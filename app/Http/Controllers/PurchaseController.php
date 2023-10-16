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
                    if ($valueBarang->id == $value->id) {
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
        $id = $request->input('id');

        $list = [];
        for ($i=0; $i < count($qty); $i++) {
            if ($qty[$i] > 0) {
                $obj = Barang::find($id[$i]);
                $obj->qty = $qty[$i];

                $list[] = $obj;
            }
        }

        $oldPO = Session::get('po_cart');
        // Object Creation for Invoice
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
            $itemIds[] = $value->id;
        }

        $vendors = Vendor::whereHas('barang', function ($query) use ($itemIds) {
            $query->whereIn('barang.id', $itemIds);
        })->with(['barang' => function ($query) {
            $query->select(['barang.id', 'barang.nama', 'vendor_id', 'barang_vendor.harga']);
        }])->get();

        foreach ($vendors as $key => $value) {
            $total = 0;
            foreach ($value->barang as $key => $vendorItem) {
                foreach ($oldPO->list as $key => $itemsToBuy) {
                    if ($vendorItem->id == $itemsToBuy->id) {
                        $total += $vendorItem->harga * $itemsToBuy->qty;
                    }
                }
            }
            $value->total = $total;
        }

        return view('master.po.vendor', [
            'vendor' => $vendors
        ]);
    }

    public function purchaseVendorAdd(Request $request){
        $oldPO = Session::get('po_cart');

        $vendor = $request->input('vendor');
        $total = $request->input('total');

        $oldPO->total = $total;
        $oldPO->vendor = Vendor::find($vendor);

        //set po->list subtotal
        foreach ($oldPO->list as $key => $value) {
            $value->harga = BarangVendor::find($value->id)->harga;
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
