<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangVendor;
use App\Models\HeaderPurchase;
use App\Models\StockMutation;
use App\Models\Vendor;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use stdClass;
use Symfony\Component\VarDumper\VarDumper;

class PurchaseController extends Controller
{
    public function purchaseView(){
        $data = HeaderPurchase::all();
        return view('master.po.view', [
            'data' => $data
        ]);
    }

    public function purchaseDetailView($id){
        $po = HeaderPurchase::find($id);
        return view('master.po.detail', [
            'po' => $po,
            'daysLeft' => Util::getDiffDays($po->jatuh_tempo)
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
        $qty = $request->input('qty');
        $part = $request->input('part');

        $list = [];
        for ($i=0; $i < count($qty); $i++) {
            if ($qty[$i] > 0) {
                $obj = Barang::find($part[$i]);
                $obj->qty = $qty[$i];

                $list[] = $obj;
            }
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

        if ($jatuhTempo->isPast()) {
            toast('Tanggal Jatuh Tempo minimal hari ini', 'error');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $currentDateTime = Carbon::now()->toDateTimeString();
            //insert header
            $lastId = DB::table('hpurchase')->insertGetId([
                'vendor_id' => $po->vendor->id,
                'kode' => Util::generatePurchaseCode(),
                'karyawan_id' => $user->id,
                'total' => $po->total,
                'grand_total' => $po->grandTotal,
                'ppn_value' => $po->PPN_value,
                'ppn' => $po->PPN,
                'status_pesanan' => 0,
                'status_pembayaran' => 0,
                'jatuh_tempo' => $jatuhTempo,
                'created_at' => $currentDateTime
            ]);

            foreach ($po->list as $key => $value) {
                DB::table('dpurchase')->insert([
                    'hpurchase_id' => $lastId,
                    'part' => $value->part,
                    'nama' => $value->nama,
                    'harga' => $value->harga,
                    'qty' => $value->qty,
                    'subtotal' => $value->subtotal,
                ]);
            }

            Session::remove('po_cart');
            toast('Berhasil Membuat Purchase Order', 'success');
            DB::commit();
        } catch (\Exception $ex) {
            toast($ex->getMessage(), 'error');
            DB::rollBack();
        }

        return redirect('/po');
    }

    public function finishPembayaran(Request $request){
        $id = $request->input('id');
        $po = HeaderPurchase::find($id);
        $po->status_pembayaran = 1;
        $po->save();

        toast('Transaksi telah berhasil dilunasi !', 'success');
        return redirect()->back();
    }

    public function finishPesanan(Request $request){
        $status = $request->input('status');
        $id = $request->input('id');
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
            $po->status_pesanan = 1;
            $po->save();
            return redirect()->back();
        }
        elseif ($status == 1) {
            //Barang Lebih
        }
        elseif ($status == -1){
            //Barang Kurang

        }


    }

    public function countDue(Request $request){
        // $dayBeforeDue = $request->query('day');
        // $oneDayBeforeToday = Carbon::now()->subDays(7);
        // $data = HeaderPurchase::whereDate('jatuh_tempo', '<=', $oneDayBeforeToday->toDateString())->get();
        $data = HeaderPurchase::where('status_pembayaran', 0)->get();
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
}
