<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InvoiceController extends Controller
{
    public function invoiceAddView(){
        $barang = Barang::all();
        return view('master.invoice.add', [
            'barang' => $barang
        ]);
    }

    public function invoiceAddAction(Request $request){
        $selected = $request->input('barang');

        $list = [];
        foreach ($selected as $key => $value) {
            $obj = Barang::find($value);
            $obj->qty = 1;
            $obj->subtotal = $obj->harga;
            $list[] = $obj;
        }

        Session::put('invoice_cart', $list);
        return redirect('/invoice/confirmation');
    }

    public function invoiceConfirmationView(){
        $barang = Session::get('invoice_cart');
        return view('master.invoice.confirmation', [
            'barang' => $barang
        ]);
    }
}
