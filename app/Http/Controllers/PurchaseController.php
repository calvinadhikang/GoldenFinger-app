<?php

namespace App\Http\Controllers;

use App\Exports\PurchaseOrderExport;
use App\Models\Barang;
use App\Models\BarangVendor;
use App\Models\DetailPurchase;
use App\Models\HeaderPurchase;
use App\Models\Karyawan;
use App\Models\PurchasePayment;
use App\Models\StockMutation;
use App\Models\Vendor;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;
use Symfony\Component\VarDumper\VarDumper;

class PurchaseController extends Controller
{
    public function purchaseView(Request $request){
        $type = $request->query('type', 'all');
        if ($type == "deleted") {
            $data = HeaderPurchase::onlyTrashed()->get();
        }else{
            $data = HeaderPurchase::latest()->get();
        }

        return view('master.po.view', [
            'data' => $data,
            'type' => $type
        ]);
    }

    public function purchaseDetailView($id){
        $po = HeaderPurchase::find($id) ?? HeaderPurchase::withTrashed()->where('id', $id)->first();

        if ($po == null) {
            toast("PO $id Tidak Ditemukan !", "error");
            return redirect('/invoice');
        }

        $paid_name = "";
        if ($po->paid_by != null){
            $karyawan = Karyawan::where('id', $po->paid_by)->first();
            $paid_name = $karyawan->nama;
        }

        $recieved_name = "";
        if ($po->recieved_by != null){
            $karyawan = Karyawan::where('id', $po->recieved_by)->first();
            $recieved_name = $karyawan->nama;
        }

        $data_pembayaran = PurchasePayment::where('purchase_id', $id)->get();
        $total_pembayaran = 0;
        foreach ($data_pembayaran as $key => $value) {
            $total_pembayaran += $value->total;
        }

        return view('master.po.detail', [
            'po' => $po,
            'daysLeft' => Util::getDiffDays($po->jatuh_tempo),
            'paid_name' => $paid_name,
            'recieved_name' => $recieved_name,
            'data_pembayaran' => $data_pembayaran,
            'total_pembayaran' => $total_pembayaran
        ]);
    }

    public function purchaseBarangView(){
        $barang = Barang::all();
        $oldPO = Session::get('po_cart');

        foreach ($barang as $keyBarang => $valueBarang) {
            $found = -1;
            if ($oldPO != null) {
                foreach ($oldPO->list as $key => $value) {
                    if ($valueBarang->part == $value->part) {
                        $found = $key;
                        $valueBarang->qty = $value->qty;
                    }
                }
            }

            if ($found == -1) {
                $valueBarang->qty = 0;
            }
        }

        return view('master.po.barang', [
            'barang' => $barang
        ]);
    }

    public function purchaseBarangAdd(Request $request){
        $barangs = json_decode($request->input('barang'));

        $list = [];
        for ($i=0; $i < count($barangs); $i++) {
            $targetPart = $barangs[$i]->part;
            $targetQty = $barangs[$i]->qty;

            if ($targetQty > 0) {
                $obj = Barang::find($targetPart);
                $obj->qty = $targetQty;

                $list[] = $obj;
            }
        }

        if(count($list) <= 0){
            return back()->withErrors([
                'msg' => 'Minimal Beli 1 Barang'
            ]);
        }

        $oldPO = Session::get('po_cart');
        // Object Creation for Purchase
        $PO = new stdClass();
        if ($oldPO != null) {
            $PO->vendor = $oldPO->vendor;
            $PO->grandTotal = $oldPO->grandTotal;
        }else{
            $PO->vendor = null;
            $PO->grandTotal = null;
        }
        $PO->PPN = DB::table('settings')->select('ppn')->first()->ppn;
        $PO->PPN_value = 0;
        $PO->list = $list;

        Session::put('po_cart', $PO);
        return redirect('/po/vendor');
    }

    public function purchaseVendorView(){
        $oldPO = Session::get('po_cart');
        if ($oldPO == null) {
            return redirect('/po/barang');
        }

        $availableVendors = [];
        // cari vendor yang mampu memasok barang
        $vendors = Vendor::all();
        foreach ($vendors as $key => $vendor) {
            $valid = true;
            foreach ($oldPO->list as $barang) {
                $available = BarangVendor::where('vendor_id', $vendor->id)->where('barang_id', $barang->part)->count();
                if ($available == 0) {
                    $valid = false;
                }
            }

            if ($valid) {
                //tambahkan Vendor ke daftar Vendor
                $availableVendors[] = $vendor;
            }
        }

        // Tentukan harga tiap vendor
        foreach ($availableVendors as $key => $vendor) {
            $barangVendor = BarangVendor::where('vendor_id', $vendor->id)->get();
            $total = 0;

            // 1. Iterasi dari semua barang yang akan dibeli admin...
            // 2. Selanjutnya badingkan dengan part number tiap barang yang akan dibeli dengan barang yang di supply oleh Vendor
            // 3. Hitung jumlah barang yang akan dibeli + harga dari Vendor
            //    lalu tambahkan hasilnya hingga semua barang yang akan dibeli habis(iterasi habis)
            // 4. Hasil total penambahan adalah total harga penawaran vendor
            foreach ($oldPO->list as $key => $barang) {
                foreach ($barangVendor as $key => $barang_vendor) {
                    if ($barang_vendor->barang_id == $barang->part) {
                        $total += $barang->qty * $barang_vendor->harga;
                    }
                }
            }

            $vendor->total = $total;
        }

        return view('master.po.vendor', [
            'vendor' => $availableVendors
        ]);
    }

    public function purchaseVendorAdd(Request $request){
        $oldPO = Session::get('po_cart');

        $vendorId = $request->input('vendor');
        $total = $request->input('total');

        $oldPO->total = $total;
        $oldPO->vendor = Vendor::find($vendorId);

        //set po->list subtotal
        foreach ($oldPO->list as $key => $value) {
            $objBarang = BarangVendor::where('vendor_id', '=', $vendorId)->where('barang_id', '=', $value->part)->get();
            $value->harga = $objBarang[0]->harga;
            $value->subtotal = $value->harga * $value->qty;
        }

        //set PPN from Setting
        $oldPO->PPN_value = ($oldPO->total / 100 * $oldPO->PPN);
        $oldPO->grandTotal = $oldPO->PPN_value + $oldPO->total;

        Session::put('po_cart', $oldPO);
        return redirect('/po/confirmation');
    }

    public function purchaseConfirmationView(){
        $po = Session::get('po_cart');
        return view('master.po.confirmation', [
            'po' => $po
        ]);
    }

    public function purchaseConfirmationPPN(Request $request){
        $ppn = $request->input('ppn');

        $oldPO = Session::get('po_cart');
        $oldPO->PPN = $ppn;
        $oldPO->PPN_value = ($oldPO->total / 100 * $oldPO->PPN);
        $oldPO->grandTotal = $oldPO->PPN_value + $oldPO->total;
        Session::put('po_cart', $oldPO);
        return redirect()->back();
    }

    public function purchaseConfirmationAction(Request $request){
        $po = Session::get('po_cart');
        $user = Session::get('user');
        $jatuhTempo = Carbon::parse($request->input('jatuhTempo'));

        //cek apakah transaksi lama
        $isOldTransaction = $request->input('time');
        $oldMethodTransaksi = $request->input('oldMethodTransaksi') ?? null;
        $oldNomorTransaksi = $request->input('oldNomorTransaksi') ?? null;
        $timePembayaran = $request->input('timeValuePembayaran') ?? null;
        $timeCreation = $request->input('timePembuatan') ?? Carbon::now();
        $timePenerimaan = $request->input('timeValuePenerimaan') ?? null;

        if ($timePembayaran == null && $timePenerimaan == null) {
            if ($jatuhTempo->isPast()) {
                toast('Tanggal Jatuh Tempo minimal hari ini', 'error');
                return redirect()->back();
            }
        }

        DB::beginTransaction();
        try {
            if ($isOldTransaction) {
                $kode = $request->input('oldKode');
            } else {
                $kode = Util::generatePurchaseCode();
            }

            //insert header
            $lastId = DB::table('hpurchase')->insertGetId([
                'vendor_id' => $po->vendor->id,
                'kode' => $kode,
                'karyawan_id' => $user->id,
                'total' => $po->total,
                'grand_total' => $po->grandTotal,
                'ppn_value' => $po->PPN_value,
                'ppn' => $po->PPN,
                'jatuh_tempo' => $jatuhTempo,
                'created_at' => $timeCreation,
                'paid_at' => $timePembayaran,
                'recieved_at' => $timePenerimaan,
                'recieved_by' => $timePenerimaan != null ? Session::get('user')->id : null,
            ]);

            foreach ($po->list as $key => $value) {
                $dpurchaseId = DB::table('dpurchase')->insertGetId([
                    'hpurchase_id' => $lastId,
                    'part' => $value->part,
                    'nama' => $value->nama,
                    'harga' => $value->harga,
                    'qty' => $value->qty,
                    'subtotal' => $value->subtotal,
                ]);

                if ($isOldTransaction) {
                    //Menambahkan Stok ke table Barang
                    DB::table('barang')->where('part', $value->part)->increment('stok', $value->qty);

                    //Buat Row Baru di table Stock Mutation
                    DB::table('stock_mutation')->insert([
                        'barang_id' => $value->part,
                        'qty' => $value->qty,
                        'qty-used' => 0,
                        'harga' => $value->harga,
                        'status' => 'masuk',
                        'trans_id' => $lastId,
                        'trans_kode' => $kode,
                        'created_at' => Carbon::now()
                    ]);
                }

                // Keperluan Fifo
                DB::table('hfifo')->insert([
                    'hpurchase_id' => $lastId,
                    'dpurchase_id' => $dpurchaseId,
                    'part' => $value->part,
                    'harga_beli' => $value->harga,
                    'qty_max' => $value->qty,
                    'qty_used' => 0,
                    'created_at' => Carbon::now()
                ]);
            }

            Session::remove('po_cart');
            toast('Berhasil Membuat Purchase Order', 'success');
            DB::commit();
            return redirect('/po');
        } catch (\Exception $ex) {
            toast($ex->getMessage(), 'error');
            DB::rollBack();
            return back();
        }

    }

    public function addPembayaran(Request $request){
        $id = $request->input('id');
        $po = HeaderPurchase::find($id);
        $user = Session::get('user');
        $password = $request->input('password');
        $paid_code = $request->input('paid_code');
        $paid_method = $request->input('paid_method');
        $paid_amount = Util::parseNumericValue($request->input('paid_amount'));

        if (!Hash::check($password, $user->password)) {
            toast('Password Salah !', 'error');
            return back();
        }

        // Cek Kelebihan Bayar
        if ($po->grand_total < $po->paid_total + $paid_amount) {
            toast('Pembayaran melebihi total tagihan !', 'error');
            return back();
        }

        PurchasePayment::create([
            'purchase_id' => $id,
            'karyawan_id' => $user->id,
            'method' => $paid_method,
            'code' => $paid_code,
            'total' => $paid_amount,
        ]);

        $po->paid_total += $paid_amount;
        if ($po->paid_total >= $po->grand_total) {
            $po->paid_at = Carbon::now();
        }
        $po->save();

        toast('Pembayaran berhasil di daftarkan !', 'success');
        return redirect()->back();
    }

    public function finishPesanan(Request $request){
        // Status digunakan untuk menentukan tipe barang PO yang datang..
        // Apakah barang sesuai 0, lebih 1, atau kurang -1
        $status = $request->input('status');
        $id = $request->input('id');

        $user = Session::get('user');
        $password = $request->input('password');
        if (!Hash::check($password, $user->password)) {
            toast('Password Salah !', 'error');
            return back();
        }

        $po = HeaderPurchase::find($id);
        if ($status == 0) {
            //tambahkan semua detail transaksi ke table stock_mutation
            //jangan lupa tambah jumlah stok barang
            foreach ($po->details as $key => $detail) {
                $part = $detail->part;

                DB::beginTransaction();
                try {
                    //Menambahkan Stok ke table Barang
                    DB::table('barang')->where('part', $part)->increment('stok', $detail->qty);

                    //Buat Row Baru di table Stock Mutation
                    DB::table('stock_mutation')->insert([
                        'barang_id' => $part,
                        'qty' => $detail->qty,
                        'qty-used' => 0,
                        'harga' => $detail->harga,
                        'status' => 'masuk',
                        'trans_id' => $po->id,
                        'trans_kode' => $po->kode,
                        'created_at' => Carbon::now()
                    ]);

                    DB::commit();
                } catch (Exception $ex) {
                    dd($ex);
                    DB::rollBack();
                }
            }

            toast('Berhasil Melunasi Pesanan, Stok Telah Ditambah', 'success');

            //Update Status Pesanan PO
            $po->recieved_at = Carbon::now();
            $po->recieved_by = Session::get('user')->id;
            $po->recieved_by = $user->id;
            $po->save();
            return redirect()->back();
        }
        elseif ($status == 1) {
            //Barang Lebih
        }
        elseif ($status == -1){
            //Barang Kurang
            return redirect("/po/handling/kurang/$id");
        }
    }

    public function purchaseDelete($id, Request $request){
        $user = Session::get('user');
        $reason = $request->input('reason');
        $password = $request->input('password');

        //check password
        if (!Hash::check($password, $user->password)) {
            toast('Gagal Menghapus Purchase Order, Password Salah', 'error');
            return back();
        }

        $po = HeaderPurchase::find($id);
        $po->delete();
        $po->deleted_by = $user->id;
        $po->deleted_reason = $reason;
        $po->deleted_at = Carbon::now();
        $po->save();
        toast('Berhasil Menghapus Purchase Order', 'success');
        return back();
    }

    public function purchaseRestore($id, Request $request){
        $user = Session::get('user');
        $password = $request->input('password');

        //check password
        if (!Hash::check($password, $user->password)) {
            toast('Gagal Mengaktifkan Purchase Order, Password Salah', 'error');
            return back();
        }

        $po = HeaderPurchase::withTrashed()->where('id', $id)->first();
        $po->restore();
        $po->deleted_by = null;
        $po->deleted_reason = null;
        $po->deleted_at = null;
        $po->save();
        toast('Berhasil Mengaktifkan Purchase Order', 'success');
        return back();
    }

    public function countDue(Request $request){
        // $dayBeforeDue = $request->query('day');
        // $oneDayBeforeToday = Carbon::now()->subDays(7);
        // $data = HeaderPurchase::whereDate('jatuh_tempo', '<=', $oneDayBeforeToday->toDateString())->get();
        $data = HeaderPurchase::whereNull('paid_at')->get();
        $count = $data->count();

        $total = 0;
        foreach ($data as $key => $value) {
            $total += $value->grand_total;
        }

        return response()->json([
            'count' => $count,
            'data' => $data,
            'total' => $total
        ]);
    }

    public function handlingPesananKurang($id, Request $request){
        $po = HeaderPurchase::find($id);
        return view('master.po.handling.barang_kurang', [
            'po' => $po
        ]);
    }

    public function handlingPesananKurangAction($id, Request $request){
        $po = HeaderPurchase::find($id);
        $detailId = $request->input('id');
        $detailQty = $request->input('qty');

        DB::beginTransaction();
        try {
            //ganti Detail PO
            foreach ($detailId as $idx => $detail_id) {
                $oldDetailData = DetailPurchase::find($detail_id);

                //kalau ada perubahan... baru update di DB
                if ($oldDetailData->qty != $detailQty[$idx]) {
                    DB::table('dpurchase')->where('id', $detail_id)->update([
                        'qty' => $detailQty[$idx],
                        'subtotal' => $oldDetailData->harga * $detailQty[$idx]
                    ]);
                }
            }

            //update Header data
            $updatedDetails = $po->details;
            $total = 0;
            foreach ($updatedDetails as $key => $details) {
                $total += $details->subtotal;
            }
            $ppn_value = $total / 100 * $po->ppn;
            $grandTotal = $total + $ppn_value;

            DB::table('hpurchase')->where('id', $id)->update([
                'total' => $total,
                'ppn_value' => $ppn_value,
                'grand_total' => $grandTotal
            ]);

            DB::commit();
            toast('Berhasil update PO', 'success');
            return redirect("/po/detail/$id");
        } catch (Exception $e) {
            DB::rollBack();
            toast('Gagal update PO', 'error');
            return back();
        }
    }

    public function getThisMonth(){
        $data = $this->getThisMonthData();
        return response()->json([
            'error' => false,
            'data' => $data
        ]);
    }

    static function getThisMonthData(){
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $data = HeaderPurchase::whereMonth('created_at', '=', $currentMonth)->whereYear('created_at', '=', $currentYear)->get();
        $total = 0;
        foreach ($data as $po) {
            $total += $po->grand_total;
        }

        $obj = new stdClass();
        $obj->total = $total;
        $obj->data = $data;
        return $obj;
    }

    public function poCreatePurchaseOrder($id){
        $po = HeaderPurchase::find($id);
        return Excel::download(new PurchaseOrderExport($po), 'purchase_order.xlsx');
    }
}
