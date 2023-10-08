<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\HeaderInvoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use stdClass;


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

    function parseNumericValue($value){
        $rawValue = str_replace(',', '', $value);
        $numeric = (float)$rawValue;
        return $numeric;
    }

    public function invoiceAddAction(Request $request){
        $qty = $request->input('qty');
        $harga = $request->input('harga');
        $id = $request->input('id');

        $grandTotal = 0;
        $list = [];
        for ($i=0; $i < count($qty); $i++) {
            if ($qty[$i] > 0) {
                $obj = Barang::find($id[$i]);
                $obj->qty = $qty[$i];
                $obj->harga = $this->parseNumericValue($harga[$i]);

                $subtotal = $obj->harga * $qty[$i];
                $obj->subtotal = $subtotal;

                $list[] = $obj;
                $grandTotal += $subtotal;
            }
        }


        $oldInvoice = Session::get('invoice_cart');
        // Object Creation for Invoice
        $invoice = new stdClass();
        if ($oldInvoice != null) {
            $invoice->customer = $oldInvoice->customer;
        }else{
            $invoice->customer = null;
        }
        $invoice->grandTotal = $grandTotal;
        $invoice->list = $list;

        Session::put('invoice_cart', $invoice);
        return redirect('/invoice/customer');
    }

    public function invoiceCustomerView(){
        $invoice = Session::get('invoice_cart');
        return view('master.invoice.customer', [
            'barang' => $invoice->list,
            'customer' => $invoice->customer,
            'grandTotal' => $invoice->grandTotal,
        ]);
    }

    public function invoiceCustomerAction(Request $request){
        $customer = Customer::find($request->input('customer'));
        $invoice = Session::get('invoice_cart');

        $invoice->customer = $customer;

        toast('Berhasil memilih customer', 'success');
        return redirect()->back();
        // return redirect('/invoice/confirmation');
    }

    public function invoiceCustomerUnsetAction(Request $request){
        $invoice = Session::get('invoice_cart');
        $invoice->customer = null;
        Session::put('invoice_cart', $invoice);

        toast('Berhasil melepas customer', 'success');
        return redirect()->back();
    }

    public function invoiceConfirmationView(){
        $invoice = Session::get('invoice_cart');

        return view('master.invoice.confirmation', [
            'invoice' => $invoice
        ]);
    }

    public function invoiceConfirmationAction(Request $request){
        $komisiJumlah = 0;
        $komisiPenerima = "-";
        $karyawan = Session::get('user');
        $jatuhTempo = $request->input('jatuhTempo');
        $invoice = Session::get('invoice_cart');

        $komisiStatus = $request->input('komisi');
        if ($komisiStatus) {
            $komisiJumlah = $request->input('komisiJumlah');
            $komisiPenerima = $request->input('komisiPenerima');
        }

        DB::beginTransaction();
        try {

            $currentDateTime = Carbon::now()->toDateTimeString();
            //insert header
            $lastId = DB::table('hinvoice')->insertGetId([
                'customer_id' => $invoice->customer->id,
                'karyawan_id' => $karyawan->id,
                'total' => $invoice->grandTotal,
                'status' => 0,
                'contact_person' => $komisiPenerima,
                'komisi' => $komisiJumlah,
                'ppn' => 10,
                'grand_total' => $invoice->grandTotal += $invoice->grandTotal * 0.10,
                'jatuh_tempo' => $jatuhTempo,
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

            Session::remove('invoice_cart');
            toast("Transaksi Customer: ".$invoice->customer->nama.", Berhasil dibuat", 'success');
            DB::commit();
        } catch (\Exception $ex) {
            toast($ex->getMessage(), 'error');
            DB::rollBack();
        }

        return redirect('/invoice');
    }

    public function invoiceDetailView($id){
        $invoice = HeaderInvoice::find($id);

        // Get the current date and time
        $currentDate = Carbon::now();
        // Calculate the difference in days
        $daysLeft = $currentDate->diffInDays($invoice->jatuh_tempo);

        return view('master.invoice.detail', [
            'invoice' => $invoice,
            'daysLeft' => $daysLeft
        ]);
    }

    public function createDocument(Request $request){
        if ($request->input('type') == 'invoice') {
            $pdf = Pdf::loadView('template.dokumen.tanda_terima');

            return $pdf->download('document.pdf');
        }
        return redirect()->back();
    }

    public function invoiceFinish(Request $request){
        $invoice = HeaderInvoice::find($request->input('id'));
        if ($invoice->status == 0) {
            toast('Berhasil Melunasi Transaksi', 'success');
            $invoice->status = 1;
            $invoice->save();
            return redirect()->back();
        }
    }

    public function customerAddAction(Request $request){
        $customer = Customer::create([
            'alamat' => $request->input('alamat'),
            'nama' => $request->input('nama'),
            'telp' => $request->input('telp'),
            'email' => $request->input('email'),
        ]);

        $invoice = Session::get('invoice_cart');
        $invoice->customer = $customer;
        Session::put('invoice_cart', $invoice);

        toast('Berhasil Menambah Customer', 'success');
        return redirect()->back();
    }
}
