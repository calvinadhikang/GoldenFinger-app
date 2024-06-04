<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use App\Exports\SuratJalanExport;
use App\Exports\TandaTerimaExport;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\DetailInvoice;
use App\Models\HeaderInvoice;
use App\Models\HeaderPaket;
use App\Models\Karyawan;
use App\Models\OperationalCost;
use Barryvdh\DomPDF\Facade\Pdf;
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
    public function invoiceView(Request $request){
        $type = $request->query('type', 'all');
        if ($type == 'all') {
            $data = HeaderInvoice::latest()->whereIn('status', [1, 2])->get();
        }else if($type == 'deleted') {
            $data = HeaderInvoice::onlyTrashed()->get();
        }else if($type == 'unconfirmed'){
            $data = HeaderInvoice::latest()->where('status', 0)->get();
        }else if($type == 'canceled'){
            $data = HeaderInvoice::latest()->where('status', -1)->get();
        }

        $countNotConfirm = HeaderInvoice::where('status', 0)->count();

        return view('master.invoice.view', [
            'type' => $type,
            'data' => $data,
            'countNotConfirm' => $countNotConfirm
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
            'customers' => Customer::latest()->get()
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
        $paket = HeaderPaket::all();
        $invoice = Session::get('invoice_cart');

        //Hitung hutang Customer
        $hutangCustomer = HeaderInvoice::where('customer_id', $invoice->customer->id)->where('paid_at', null)->get();
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
            'hutang' => $totalHutang,
            'paket' => $paket
        ]);
    }

    public function invoiceBarangAction(Request $request){
        $barangs = json_decode($request->input('barang') ?? "[]");
        $pakets = json_decode($request->input('paket') ?? "[]");

        $ppn_include = $request->input('ppn-include');
        $invoice = Session::get('invoice_cart');

        $total = 0;
        $cleanTotal = 0; //total harga bersih, untuk perhitungan harga non ppn
        $list_barang = []; //simpan data barang lengkap
        $total_list_barang = 0;
        $list_paket = []; //simpan data paket lengkap
        $total_list_paket = 0;

        foreach ($barangs as $key => $barang) {
            $obj = Barang::find($barang->part);
            $obj->qty = $barang->qty;
            $price = Util::parseNumericValue($barang->harga);
            $obj->clean_price = $price;

            if ($ppn_include != null) {
                //kalau harga termasuk PPN
                $ppnItem = $price - ($price / 100 * $invoice->PPN);
                $obj->harga = $ppnItem;
                $cleanTotal += $price * $barang->qty;
            }else{
                $obj->harga = $price;
            }

            $subtotal = $obj->harga * $barang->qty;
            $obj->subtotal = $subtotal;

            $list_barang[] = $obj;
            $total_list_barang += $subtotal;
            $total += $subtotal;
        }

        foreach ($pakets as $key => $paket) {
            $obj = HeaderPaket::find($paket->part);
            $obj->qty = $paket->qty;
            $price = Util::parseNumericValue($paket->harga);
            $obj->clean_price = $price;

            if ($ppn_include != null) {
                //kalau harga termasuk PPN
                $ppnItem = $price - ($price / 100 * $invoice->PPN);
                $obj->harga = $ppnItem;
                $cleanTotal += $price * $paket->qty;
            }else{
                $obj->harga = $price;
            }

            $subtotal = $obj->harga * $paket->qty;
            $obj->subtotal = $subtotal;

            $list_paket[] = $obj;
            $total_list_paket += $subtotal;
            $total += $subtotal;
        }

        if (count($barangs) <= 0 && count($pakets) <= 0) {
            return redirect()->back()->withErrors([
                'msg' => 'Minimal membeli 1 barang / paket !'
            ]);
        }

        $invoice->list_barang = $list_barang;
        $invoice->total_list_barang = $total_list_barang;
        $invoice->list_paket = $list_paket;
        $invoice->total_list_paket = $total_list_paket;
        $invoice->total = $total;

        // BUG: Perhitungan Incluce PPN salah

        if ($ppn_include != null){
            //kalau harga termasuk ppn
            $invoice->PPN_value = ($cleanTotal / 100) * $invoice->PPN;
            $invoice->PPN_included = true;
        }else{
            $invoice->PPN_value = ($total / 100) * $invoice->PPN;
            $invoice->PPN_included = false;
        }
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
        $new_ppn = Util::parseNumericValue($request->input('ppn') ?? 0);

        $invoice->PPN = $new_ppn;
        if ($invoice->PPN_included) {
            $cleanTotal = 0;
            foreach ($invoice->list_barang as $key => $value) {
                $cleanTotal += $value->clean_price;
            }
            foreach ($invoice->list_paket as $key => $value) {
                $cleanTotal += $value->clean_price;
            }

            $invoice->PPN_value = ($cleanTotal / 100) * $invoice->PPN;
        }else{
            $invoice->PPN_value = ($invoice->total / 100) * $invoice->PPN;
        }

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

        //cek apakah transaksi lama
        $timePembayaran = $request->input('timeValuePembayaran');
        $timeCreation = $request->input('timePembuatan') ?? Carbon::now();

        if ($timePembayaran == null) {
            if (Carbon::parse($jatuhTempo)->isPast()) {
                toast('Tanggal Jatuh Tempo Minimal Besok', 'error');
                return back()->withErrors([
                    'msg' => 'Tanggal Jatuh Tempo Minimal Besok !'
                ]);
            }
        }

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
                'contact_person' => $komisiPenerima,
                'komisi' => $komisiJumlah,
                'ppn' => $invoice->PPN,
                'ppn_value' => $invoice->PPN_value,
                'grand_total' => $invoice->grandTotal,
                'po' => $request->input('po'),
                'jatuh_tempo' => $jatuhTempo,
                'created_at' => $timeCreation,
                'paid_at' => $timePembayaran,
                'paid_by' => $timePembayaran != null ? Session::get('user')->id : null,
                'confirmed_at' => $timeCreation,
                'confirmed_by' => $karyawan->id,
                'status'=> 1,
            ]);

            foreach ($invoice->list_barang as $key => $value) {
                DB::table('dinvoice')->insert([
                    'hinvoice_id' => $lastId,
                    'part' => $value->part,
                    'nama' => $value->nama,
                    'harga' => $value->harga,
                    'qty' => $value->qty,
                    'subtotal' => $value->subtotal,
                    'type' => 'barang',
                    'created_at' => $currentDateTime
                ]);
            }

            foreach ($invoice->list_paket as $key => $value) {
                DB::table('dinvoice')->insert([
                    'hinvoice_id' => $lastId,
                    'part' => $value->id,
                    'nama' => $value->nama,
                    'harga' => $value->harga,
                    'qty' => $value->qty,
                    'subtotal' => $value->subtotal,
                    'type' => 'paket',
                    'created_at' => $currentDateTime
                ]);
            }

            Session::remove('invoice_cart');
            toast("Transaksi Customer: ".$invoice->customer->nama.", Berhasil dibuat", 'success');
            DB::commit();
            return redirect('/invoice');
        } catch (\Exception $ex) {
            DB::rollBack();
            return back()->withErrors([
                'msg' => $ex->getMessage()
            ]);
        }

    }

    public function invoiceDetailView($id){
        $invoice = HeaderInvoice::find($id) ?? HeaderInvoice::withTrashed()->where('id', $id)->first();
        if ($invoice == null) {
            toast("Invoice $id Tidak Ditemukan !", "error");
            return redirect('/invoice');
        }

        $invoiceText = "Menunggu Konfirmasi";
        if ($invoice->status == 1) {
            $invoiceText = "Menunggu Pembayaran";
        }else if ($invoice->status == 2) {
            $invoiceText = "Terproses";
        }else if ($invoice->status == -1) {
            $invoiceText = "Dibatalkan";
        }

        $paid_by = "";
        if ($invoice->snap_token) {
            $paid_by = Customer::find($invoice->paid_by);
        }else {
            $paid_by = Karyawan::find($invoice->paid_by);
        }

        $hariSisa = Util::getDiffDays($invoice->jatuh_tempo);
        $isOverdue = Carbon::parse($invoice->jatuh_tempo)->isBefore(now());
        $daysLeft = $isOverdue ? "Lewat $hariSisa hari dari tanggal jatuh tempo" : "Kurang $hariSisa hari hingga tanggal jatuh tempo";
        return view('master.invoice.detail', [
            'invoice' => $invoice,
            'daysLeft' => $daysLeft,
            'isOverdue' => $isOverdue,
            'paid_by' => $paid_by,
            'confirmed_by' => Karyawan::find($invoice->confirmed_by),
            'statusText' => $invoiceText
        ]);
    }

    public function invoiceFinish(Request $request){
        $invoice = HeaderInvoice::find($request->input('id'));
        $payment_method = $request->input('payment_method');
        $payment_code = $request->input('payment_code');
        $password = $request->input('password');
        $user = Session::get('user');

        //check password
        if (!Hash::check($password, $user->password)) {
            toast('Gagal Melunasi Invoice, Password Salah', 'error');
            return back();
        }

        if ($invoice->paid_at == null) {
            foreach ($invoice->details as $key => $detail) {
                $part = $detail->part;

                DB::beginTransaction();
                try {
                    if ($detail->type == 'barang') {
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
                    }else{
                        $paket = HeaderPaket::withTrashed()->where('id', $part)->first();
                        foreach ($paket->details as $key => $value) {
                            DB::table('barang')->where('part', $value->part)->decrement('stok', $value->qty);

                            DB::table('stock_mutation')->insert([
                                'barang_id' => $value->part,
                                'qty' => $value->qty,
                                'qty-used' => 0,
                                'harga' => $paket->harga,
                                'status' => 'keluar',
                                'trans_id' => $invoice->id,
                                'trans_kode' => $invoice->kode,
                                'type' => 'paket',
                                'created_at' => Carbon::now()
                            ]);
                        }
                    }

                    if ($invoice->komisi > 0) {
                        DB::table('operational_cost')->insert([
                            'total' => $invoice->komisi,
                            'deskripsi' => "Komisi kepada $invoice->contact_person pada Invoice $invoice->kode",
                            'karyawan_id' => $invoice->confirmed_by,
                            'created_at' => Carbon::now()
                        ]);
                    }

                    DB::commit();

                    toast('Berhasil Melunasi Transaksi', 'success');
                    $invoice->paid_at = Carbon::now();
                    $invoice->paid_by = $user->id;
                    $invoice->paid_method = $payment_method;
                    $invoice->paid_code = $payment_code;
                    $invoice->status = 2;
                    $invoice->save();
                    return back();
                } catch (Exception $ex) {
                    dd('error');
                    dd($ex->getMessage());
                    DB::rollBack();
                }
            }
        }
    }

    public function invoiceCancel(Request $request){
        $invoice = HeaderInvoice::find($request->input('id'));
        $cancel_reason = $request->input('cancel_reason');
        $password = $request->input('password');
        $user = Session::get('user');

        //check password
        if (!Hash::check($password, $user->password)) {
            toast('Gagal Melunasi Invoice, Password Salah', 'error');
            return back();
        }

        try {
            $invoice->status = -1;
            $invoice->cancel_reason = $cancel_reason;
            $invoice->cancel_by = $user->id;
            $invoice->save();

            toast('Berhasil Batalkan Pesanan', 'success');
        } catch (Exception $ex) {
            toast($ex->getMessage(), 'error');
        }
        return back();
    }

    static function getPaidInvoiceThisMonthData(){
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $data = HeaderInvoice::whereMonth('created_at', '=', $currentMonth)->whereYear('created_at', '=', $currentYear)->where('paid_by', '!=', null)->get();
        $total = 0;
        foreach ($data as $invoice) {
            $total += $invoice->grand_total;
        }

        $obj = new stdClass();
        $obj->total = $total;
        $obj->data = $data;
        return $obj;
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

    public function invoiceDelete($id, Request $request){
        $user = Session::get('user');
        $password = $request->input('password');

        //check password
        if (!Hash::check($password, $user->password)) {
            toast('Gagal Menghapus Invoice, Password Salah', 'error');
            return back();
        }

        $invoice = HeaderInvoice::find($id);
        $invoice->delete();
        $invoice->deleted_by = $user->id;
        $invoice->save();
        toast('Berhasil Menghapus Invoice', 'success');
        return back();
    }

    public function invoiceRestore($id, Request $request){
        $user = Session::get('user');
        $password = $request->input('password');

        //check password
        if (!Hash::check($password, $user->password)) {
            toast('Gagal Mengaktifkan Invoice, Password Salah', 'error');
            return back();
        }

        $invoice = HeaderInvoice::withTrashed()->where('id', $id)->first();
        $invoice->confirmed_at = Carbon::now();
        $invoice->confirmed_by = $user->id;
        $invoice->status = 1;
        $invoice->restore();
        $invoice->deleted_by = null;
        $invoice->save();

        toast('Berhasil Mengaktifkan Invoice', 'success');
        return back();
    }

    public function invoiceConfirm($id, Request $request){
        $user = Session::get('user');
        $password = $request->input('password');

        //check password
        if (!Hash::check($password, $user->password)) {
            toast('Gagal Mengaktifkan Invoice, Password Salah', 'error');
            return back();
        }

        $invoice = HeaderInvoice::withTrashed()->where('id', $id)->first();
        $invoice->confirmed_at = Carbon::now();
        $invoice->confirmed_by = $user->id;
        $invoice->status = 1;
        $invoice->save();

        toast('Berhasil Konfrimasi Invoice', 'success');
        return back();
    }

    // Document Creation
    public function createInvoicePdf($id){
        $data = HeaderInvoice::find($id);

        $pdf = Pdf::loadView('template.pdf.invoice', [
            'data' => $data
        ]);
        return $pdf->download('invoice_'.$data->kode.'.pdf');
    }

    // Api Functions
    public function getTotalPartSoldThisYear(){
        $currentYear = Carbon::now()->year;

        $sumOfQty = DetailInvoice::whereYear('created_at', $currentYear)
            ->select('part', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('part')
            ->get();

        $labels = [];
        $qty = [];
        foreach ($sumOfQty as $key => $value) {
            //kalau misalnya sebuah paket, maka jangan hitung sebagai penjualan barang
            $isPaket = HeaderPaket::withTrashed()->where('id', '=' ,$value->part)->get();
            if (count($isPaket) <= 0) {
                $labels[] = $value->part;
                $qty[] = $value->total_qty;
            }
        }

        return response()->json([
            'labels' => $labels,
            'qty' => $qty,
            'data' => $sumOfQty
        ], 200);
    }

    public function getPaidInvoiceThisMonth(){
        $data = $this->getPaidInvoiceThisMonthData();

        return response()->json([
            'total' => $data->total
        ], 200);
    }

    public function getOverdueInvoices(){
        $total_count = 0;
        $now = Carbon::now();
        $data = HeaderInvoice::whereNull('paid_at')->where('jatuh_tempo', '<=', $now)->get();
        foreach ($data as $key => $value) {
            $total_count += $value->grand_total;
        }

        return response()->json([
            'total' => count($data),
            'total_count' => $total_count
        ]);
    }
}
