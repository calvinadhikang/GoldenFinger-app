<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\HeaderInvoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Error;
use Exception;
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

    public function invoiceCustomerView(){
        $invoice = Session::get('invoice_cart');

        if ($invoice == null) {
            $invoice = new stdClass();
            $invoice->customer = null;
            $invoice->list = [];
            $invoice->PPN = DB::table('settings')->select('ppn')->first()->ppn;
            $invoice->PPN_value = null;
            $invoice->total = null;
            $invoice->grandTotal = null;

            Session::put('invoice_cart', $invoice);
        }

        return view('master.invoice.customer', [
            'customer' => $invoice->customer,
            'customers' => Customer::all()
        ]);
    }

    public function invoiceCustomerAction(Request $request){
        $customer = Customer::find($request->input('id'));
        $invoice = Session::get('invoice_cart');

        $invoice->customer = $customer;

        toast('Berhasil memilih customer', 'success');
        return redirect()->back();
    }

    public function invoiceCustomerUnsetAction(Request $request){
        $invoice = Session::get('invoice_cart');
        $invoice->customer = null;
        Session::put('invoice_cart', $invoice);

        toast('Berhasil melepas customer', 'success');
        return redirect()->back();
    }

    public function invoiceBarangView(){
        $barang = Barang::all();
        $invoice = Session::get('invoice_cart');

        foreach ($barang as $keyBarang => $valueBarang) {
            $found = -1;
            if ($invoice != null) {
                foreach ($invoice->list as $key => $value) {
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

        return view('master.invoice.barang', [
            'barang' => $barang
        ]);
    }

    public function invoiceBarangAction(Request $request){
        $qty = $request->input('qty');
        $harga = $request->input('harga');
        $part = $request->input('part');

        $total = 0;
        $list = [];
        for ($i=0; $i < count($qty); $i++) {
            if ($qty[$i] > 0) {
                $obj = Barang::find($part[$i]);
                $obj->qty = $qty[$i];
                $obj->harga = Util::parseNumericValue($harga[$i]);

                $subtotal = $obj->harga * $qty[$i];
                $obj->subtotal = $subtotal;

                $list[] = $obj;
                $total += $subtotal;
            }
        }

        $invoice = Session::get('invoice_cart');
        $invoice->list = $list;
        $invoice->total = $total;
        $invoice->PPN_value = ($total / 100) * $invoice->PPN;
        $invoice->grandTotal = $total + $invoice->PPN_value;

        Session::put('invoice_cart', $invoice);
        return redirect('/invoice/confirmation');
    }

    public function invoiceConfirmationView(){
        $invoice = Session::get('invoice_cart');

        return view('master.invoice.confirmation', [
            'invoice' => $invoice
        ]);
    }

    public function invoiceConfirmationPPN(Request $request){
        $invoice = Session::get('invoice_cart');
        $new_ppn = $request->input('ppn');

        $invoice->PPN = $new_ppn;
        $invoice->PPN_value = ($invoice->total / 100) * $invoice->PPN;
        $invoice->grandTotal = $invoice->total + $invoice->PPN_value;
        Session::put('invoice_cart', $invoice);

        toast('Berhasil merubah PPN', 'success');
        return redirect()->back();
    }

    public function invoiceConfirmationAction(Request $request){
        $komisiJumlah = 0;
        $komisiPenerima = "-";
        $karyawan = Session::get('user');
        $jatuhTempo = $request->input('jatuhTempo');
        $invoice = Session::get('invoice_cart');

        $komisiStatus = $request->input('komisi');
        if ($komisiStatus) {
            $komisiJumlah = Util::parseNumericValue($request->input('komisiJumlah'));
            $komisiPenerima = $request->input('komisiPenerima');
        }

        DB::beginTransaction();
        try {
            $kode = Util::generateInvoiceCode();
            $currentDateTime = Carbon::now()->toDateTimeString();
            //insert header
            $lastId = DB::table('hinvoice')->insertGetId([
                'customer_id' => $invoice->customer->id,
                'karyawan_id' => $karyawan->id,
                'kode' => $kode,
                'total' => $invoice->total,
                'status' => 0,
                'contact_person' => $komisiPenerima,
                'komisi' => $komisiJumlah,
                'ppn' => $invoice->PPN,
                'ppn_value' => $invoice->PPN_value,
                'grand_total' => $invoice->grandTotal,
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

        return view('master.invoice.detail', [
            'invoice' => $invoice,
            'daysLeft' => Util::getDiffDays($invoice->jatuh_tempo)
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
