<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PHPUnit\Framework\Constraint\IsEmpty;
use stdClass;
use Symfony\Component\VarDumper\VarDumper;

class InvoiceController extends Controller
{
    public function invoiceAddView(){
        $barang = Barang::all();
        $invoice = Session::get('invoice_cart');

        foreach ($barang as $keyBarang => $valueBarang) {
            $found = -1;
            if ($invoice != null) {
                foreach ($invoice->list as $key => $value) {
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

        return view('master.invoice.add', [
            'barang' => $barang
        ]);
    }

    public function invoiceAddAction(Request $request){
        $qty = $request->input('qty');
        $id = $request->input('id');

        $grandTotal = 0;
        $list = [];
        for ($i=0; $i < count($qty); $i++) {
            if ($qty[$i] > 0) {
                $obj = Barang::find($id[$i]);
                $obj->qty = $qty[$i];

                $subtotal = $obj->harga * $qty[$i];
                $obj->subtotal = $subtotal;

                $list[] = $obj;
                $grandTotal += $subtotal;
            }
        }

        // Object Creation for Invoice
        $invoice = new stdClass();
        $invoice->nama = "";
        $invoice->alamat = "";
        $invoice->telp = "";
        $invoice->grandTotal = $grandTotal;
        $invoice->list = $list;

        Session::put('invoice_cart', $invoice);
        return redirect('/invoice/confirmation');
    }

    public function invoiceConfirmationView(){
        $invoice = Session::get('invoice_cart');
        $customer = Customer::all();
        return view('master.invoice.confirmation', [
            'barang' => $invoice->list,
            'grandTotal' => $invoice->grandTotal,
            'customer' => $customer
        ]);
    }

    public function invoiceConfirmationAction(Request $request){
        $nama = $request->input('nama');
        // $telp = $request->input('telp');
        // $alamat = $request->input('alamat');

        DB::beginTransaction();
        try {
            //insert header

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
        }

        Session::remove('invoice_cart');
        toast("Transaksi Customer: $nama, Berhasil dibuat", 'success');
        return redirect('/invoice/created');
    }
}
