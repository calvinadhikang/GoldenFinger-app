<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PHPUnit\Framework\Constraint\IsEmpty;

class InvoiceController extends Controller
{
    public function invoiceAddView(){
        $barang = Barang::all();
        return view('master.invoice.add', [
            'barang' => $barang
        ]);
    }

    public function invoiceAddAction(Request $request){
        $qty = $request->input('qty');
        $id = $request->input('id');

        $list = [];
        for ($i=0; $i < count($qty); $i++) {
            if ($qty[$i] != null) {
                $obj = Barang::find($id[$i]);
                $obj->qty = $qty[$i];
                $obj->subtotal = $obj->harga * $qty[$i];
                $list[] = $obj;
            }
        }

        Session::put('invoice_cart', $list);
        return redirect('/invoice/confirmation');
    }

    public function invoiceConfirmationView(){
        $barang = Session::get('invoice_cart');
        $grandTotal = 0;
        foreach ($barang as $key => $value) {
            $grandTotal += $value->subtotal;
        }
        return view('master.invoice.confirmation', [
            'barang' => $barang,
            'grandTotal' => $grandTotal
        ]);
    }
}
