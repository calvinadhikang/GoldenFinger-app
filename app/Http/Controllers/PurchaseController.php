<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use stdClass;

class PurchaseController extends Controller
{
    //
    public function purchaseView(){
        return view('master.po.view');
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
        Session::put('po_cart', $oldPO);
        return redirect()->back();
    }

    public function purchaseConfirmationAction(Request $request){
        toast('Berhasil Membuat Purchase Order', 'success');
        return redirect('/po');
    }
}
