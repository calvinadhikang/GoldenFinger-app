<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use App\Exports\SuratJalanExport;
use App\Exports\TandaTerimaExport;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\DetailInvoice;
use App\Models\HeaderInvoice;
use App\Models\OperationalCost;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
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

    public function customerAddAction(Request $request){
        $validate = $request->validate([
            'alamat' => 'required',
            'nama' => 'required',
            'telp' => 'required',
            'email' => 'required',
            'kota' => 'required',
            'NPWP' => 'required',
        ]);

        $customer = Customer::create([
            'alamat' => $request->input('alamat'),
            'nama' => $request->input('nama'),
            'telp' => $request->input('telp'),
            'email' => $request->input('email'),
            'kota' => $request->input('kota'),
            'NPWP' => $request->input('NPWP'),
        ]);

        $invoice = Session::get('invoice_cart');
        $invoice->customer = $customer;
        Session::put('invoice_cart', $invoice);

        toast('Berhasil Menambah Customer', 'success');
        return redirect()->back();
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

        //Hitung hutang Customer
        $hutangCustomer = HeaderInvoice::where('customer_id', $invoice->customer->id)->where('status', 0)->get();
        $totalHutang = 0;
        foreach ($hutangCustomer as $key => $hutang) {
            $totalHutang += $hutang->grand_total;
        }

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
            'barang' => $barang,
            'hutang' => $totalHutang
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

        if (count($list) <= 0) {
            toast('Minimal membeli 1 Barang', 'error');
            return redirect()->back();
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
            $suratJalan = Util::generateSuratJalanCodeFromInvoiceCode($kode);

            $currentDateTime = Carbon::now();
            //insert header
            $lastId = DB::table('hinvoice')->insertGetId([
                'customer_id' => $invoice->customer->id,
                'karyawan_id' => $karyawan->id,
                'kode' => $kode,
                'surat_jalan' => $suratJalan,
                'total' => $invoice->total,
                'status' => 0,
                'contact_person' => $komisiPenerima,
                'komisi' => $komisiJumlah,
                'ppn' => $invoice->PPN,
                'ppn_value' => $invoice->PPN_value,
                'grand_total' => $invoice->grandTotal,
                'po' => $request->input('po'),
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
                    'created_at' => $currentDateTime
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
        if ($invoice == null) {
            toast("Invoice $id Tidak Ditemukan !", "error");
            return redirect('/invoice');
        }

        return view('master.invoice.detail', [
            'invoice' => $invoice,
            'daysLeft' => Util::getDiffDays($invoice->jatuh_tempo)
        ]);
    }

    public function invoiceFinish(Request $request){
        $invoice = HeaderInvoice::find($request->input('id'));
        $password = $request->input('password');
        $user = Session::get('user');

        //check password
        if (!Hash::check($password, $user->password)) {
            toast('Gagal Melunasi Invoice, Password Salah', 'error');
            return back();
        }

        if ($invoice->status == 0) {
            foreach ($invoice->details as $key => $detail) {
                $part = $detail->part;

                DB::beginTransaction();
                try {
                    //Menambahkan Stok ke table Barang
                    DB::table('barang')->where('part', $part)->decrement('stok', $detail->qty);

                    //Buat Row Baru di table Stock Mutation
                    DB::table('stock_mutation')->insert([
                        'barang_id' => $part,
                        'qty' => $detail->qty,
                        'qty-used' => 0,
                        'harga' => $detail->harga,
                        'status' => 'keluar',
                        'trans_id' => $invoice->id,
                        'trans_kode' => $invoice->kode,
                        'created_at' => Carbon::now()
                    ]);

                    if ($invoice->komisi > 0) {
                        DB::table('operational_cost')->insert([
                            'total' => $invoice->komisi,
                            'deskripsi' => "Komisi kepada $invoice->contact_person pada Invoice $invoice->kode",
                            'created_at' => Carbon::now()
                        ]);
                    }

                    DB::commit();
                } catch (Exception $ex) {
                    dd($ex);
                    DB::rollBack();
                }
            }

            toast('Berhasil Melunasi Transaksi', 'success');
            $invoice->status = 1;
            $invoice->paid_at = Carbon::now();
            $invoice->pelunas_id = $user->id;
            $invoice->save();
            return redirect()->back();
        }
    }

    static function getPaidInvoiceThisMonthData(){
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $data = HeaderInvoice::whereMonth('created_at', '=', $currentMonth)->whereYear('created_at', '=', $currentYear)->where('status', 1)->get();
        $total = 0;
        foreach ($data as $invoice) {
            $total += $invoice->grand_total;
        }

        $obj = new stdClass();
        $obj->total = $total;
        $obj->data = $data;
        return $obj;
    }

    public function getPaidInvoiceThisMonth(){

        $data = $this->getPaidInvoiceThisMonthData();

        return response()->json([
            'total' => $data->total
        ], 200);
    }

    public function getTotalPartSoldThisYear(){
        $currentYear = Carbon::now()->year;

        $sumOfQty = DetailInvoice::whereYear('created_at', $currentYear)
            ->select('part', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('part')
            ->get();

        $labels = [];
        $qty = [];
        foreach ($sumOfQty as $key => $value) {
            $labels[] = $value->part;
            $qty[] = $value->total_qty;
        }

        return response()->json([
            'labels' => $labels,
            'qty' => $qty,
            'data' => $sumOfQty
        ], 200);
    }

    public function invoiceCreateTandaTerima($id){
        $invoice = HeaderInvoice::find($id);
        return Excel::download(new TandaTerimaExport($invoice), "tanda_terima.xlsx");
    }

    public function invoiceCreateSuratJalan($id){
        $invoice = HeaderInvoice::find($id);
        return Excel::download(new SuratJalanExport($invoice), "surat_jalan.xlsx");
    }

    public function invoiceCreateInvoice($id){
        $invoice = HeaderInvoice::find($id);
        return Excel::download(new InvoiceExport($invoice), 'invoice.xlsx');
    }
}
