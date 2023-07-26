<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\HeaderInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PHPUnit\Framework\Constraint\IsEmpty;
use stdClass;
use Symfony\Component\VarDumper\VarDumper;

class InvoiceController extends Controller
{
    public function invoiceView(){
        $data = HeaderInvoice::all();
        return view('master.invoice.view', [
            'data' => $data
        ]);
    }

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
        $invoice->customer = null;
        $invoice->grandTotal = $grandTotal;
        $invoice->list = $list;

        Session::put('invoice_cart', $invoice);
        return redirect('/invoice/customer');
    }

    public function invoiceCustomerView(){
        $invoice = Session::get('invoice_cart');
        return view('master.invoice.customer', [
            'barang' => $invoice->list,
            'grandTotal' => $invoice->grandTotal,
        ]);
    }

    public function invoiceCustomerAction(Request $request){
        $customer = Customer::find($request->input('customer'));
        $invoice = Session::get('invoice_cart');

        $invoice->customer = $customer;

        Session::put('invoice_cart', $invoice);
        return redirect('/invoice/confirmation');
    }

    public function invoiceConfirmationView(){
        $invoice = Session::get('invoice_cart');

        return view('master.invoice.confirmation', [
            'invoice' => $invoice
        ]);
    }

    public function invoiceConfirmationAction(Request $request){
        $invoice = Session::get('invoice_cart');

        DB::beginTransaction();
        try {

            $currentDateTime = Carbon::now()->toDateTimeString();
            //insert header
            $lastId = DB::table('hinvoice')->insertGetId([
                'customer_id' => $invoice->customer->id,
                'total' => $invoice->grandTotal,
                'status' => 0,
                'created_at' => $currentDateTime
            ]);

            foreach ($invoice->list as $key => $value) {
                DB::table('dinvoice')->insert([
                    'hinvoice_id' => $lastId,
                    'part' => $value->part,
                    'nama' => $value->nama,
                    'harga' => $value->harga,
                    'qty' => $value->qty,
                    'subtotal' => $value->subtotal,
                ]);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
        }

        Session::remove('invoice_cart');
        toast("Transaksi Customer: ".$invoice->customer->nama.", Berhasil dibuat", 'success');
        return redirect('/invoice');
    }

    public function invoiceDetailView($id){
        $invoice = HeaderInvoice::find($id);

        return view('master.invoice.detail', [
            'invoice' => $invoice
        ]);
    }
}
