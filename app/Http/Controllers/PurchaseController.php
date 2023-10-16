<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangVendor;
use App\Models\HeaderPurchase;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use stdClass;

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
        $PO->PPN = 0;
        $PO->list = $list;

        Session::put('po_cart', $PO);
        return redirect('/po/vendor');
    }

    public function purchaseVendorView(){
        $oldPO = Session::get('po_cart');
        if ($oldPO == null) {
            return redirect('/po/barang');
        }

        $itemIds = [];

        foreach ($oldPO->list as $key => $value) {
            $itemIds[] = $value->part;
        }

        // cari vendor yang mampu memasok barang
        $vendors = Vendor::whereHas('barang', function ($query) use ($itemIds) {
            $query->whereIn('barang.part', $itemIds);
        })->with(['barang' => function ($query) {
            $query->select(['barang.part', 'barang.nama', 'vendor_id', 'barang_vendor.harga']);
        }])->get();

        // Tentukan harga tiap vendor
        foreach ($vendors as $key => $vendor) {
            $total = 0;

            // 1. Iterasi dari semua barang yang akan dibeli admin...
            // 2. Selanjutnya badingkan dengan part number tiap barang yang akan dibeli dengan barang yang di supply oleh Vendor
            // 3. Hitung jumlah barang yang akan dibeli + harga dari Vendor
            //    lalu tambahkan hasilnya hingga semua barang yang akan dibeli habis(iterasi habis)
            // 4. Hasil total penambahan adalah total harga penawaran vendor
            foreach ($oldPO->list as $key => $itemsToBuy) {
                foreach ($vendor->barang as $key => $vendorItem) {
                    if ($itemsToBuy->part == $vendorItem->part) {
                        $totalPerItem = $vendorItem->harga * $itemsToBuy->qty;
                        $total += $totalPerItem;
                    }
                }
            }

            $vendor->total = $total;
        }

        return view('master.po.vendor', [
            'vendor' => $vendors
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
        $oldPO->grandTotal = ($oldPO->total / 100 * $oldPO->PPN) + $oldPO->total;
        Session::put('po_cart', $oldPO);
        return redirect()->back();
    }

    public function purchaseConfirmationAction(Request $request){
        $po = Session::get('po_cart');
        $user = Session::get('user');
        $jatuhTempo = $request->input('jatuhTempo');

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

    public function confirmationPesananView($id){

    }
    public function confirmationPesananAction(Request $request){

    }

    public function confirmationPembayaran(Request $request){
        $id = $request->input('id');
        $po = HeaderPurchase::find($id);
        $po->status_pembayaran = 1;
        $po->save();

        toast('Transaksi telah berhasil dilunasi !', 'success');
        return redirect()->back();
    }
}
