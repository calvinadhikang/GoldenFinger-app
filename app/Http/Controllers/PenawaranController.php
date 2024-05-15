<?php

namespace App\Http\Controllers;

use App\Models\DetailPenawaran;
use App\Models\HeaderPenawaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PenawaranController extends Controller
{
    public function penawaranView(Request $request){
        $countNotConfirm = HeaderPenawaran::where('status', 0)->count();
        $type = $request->query('type', 'confirmed');
        if($type == 'confirmed'){
            $data = HeaderPenawaran::latest()->where('status', 1)->get();
        }else if($type == 'unconfirmed'){
            $data = HeaderPenawaran::latest()->where('status', 0)->get();
        }else if($type == 'canceled'){
            $data = HeaderPenawaran::latest()->where('status', -1)->get();
        }

        foreach ($data as $key => $value) {
            if($value->status == 0){
                $value->status = 'Butuh Konfirmasi';
            }else if($value->status == -1){
                $value->status = 'Canceled';
            }else if($value->status == 1){
                $value->status = 'Terkonfirmasi';
            }
        }

        return view('master.penawaran.view', [
            'countNotConfirm' => $countNotConfirm,
            'data' => $data,
            'type' => $type,
        ]);
    }

    public function penawaranDetailView($id){
        $penawaran = HeaderPenawaran::find($id);

        if($penawaran->status == 0){
            $penawaran->status_text = 'Butuh Konfirmasi';
        }else if($penawaran->status == -1){
            $penawaran->status_text = 'Canceled';
        }else if($penawaran->status == 1){
            $penawaran->status_text = 'Terkonfirmasi';
        }

        return view('master.penawaran.detail', [
            'penawaran' => $penawaran,
        ]);
    }

    public function penawaranConfirm($id, Request $request){
        $user = Session::get('user');
        $penawaran = HeaderPenawaran::find($id);

        if (!Hash::check($request->input('password'), $user->password)) {
            toast('Password Salah', 'error');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            // Create Invoice
            $kode = Util::generateInvoiceCode();
            $suratJalan = Util::generateSuratJalanCodeFromInvoiceCode($kode);

            $currentDateTime = Carbon::now();
            //insert header
            $lastId = DB::table('hinvoice')->insertGetId([
                'customer_id' => $penawaran->customer->id,
                'karyawan_id' => $user->id,
                'penawaran_id' => $penawaran->id,
                'kode' => $kode,
                'surat_jalan' => $suratJalan,
                'total' => $penawaran->total,
                'contact_person' => "",
                'komisi' => 0,
                'ppn' => $penawaran->ppn,
                'ppn_value' => $penawaran->ppn_value,
                'grand_total' => $penawaran->grand_total,
                'po' => "-",
                'jatuh_tempo' => now()->addDays(7),
                'created_at' => now(),
                'confirmed_at' => now(),
                'confirmed_by' => $user->id,
                'status'=> 1,
            ]);

            foreach ($penawaran->details as $key => $value) {
                DB::table('dinvoice')->insert([
                    'hinvoice_id' => $lastId,
                    'part' => $value->part,
                    'nama' => $value->barang->nama,
                    'harga' => $value->harga_penawaran,
                    'qty' => $value->qty,
                    'subtotal' => $value->subtotal,
                    'type' => 'barang',
                    'created_at' => $currentDateTime
                ]);
            }

            // Update Penawaran
            DB::table('hpenawaran')->where('id', $id)->update([
                'status' => 1,
                'confirmed_at' => now(),
                'confirmed_by' => $user->id,
                'confirmed_invoice' => $lastId,
            ]);

            toast('Penawaran Berhasil Dikonfirmasi', 'success');
            DB::commit();
        } catch (\Exception $ex) {
            //throw $th;
            dd($ex->getMessage());
            DB::rollBack();
        }
        return redirect()->back();
    }

    public function penawaranCancel($id, Request $request){
        $user = Session::get('user');

        if (!Hash::check($request->input('password'), $user->password)) {
            toast('Password Salah', 'error');
            return redirect()->back();
        }

        $penawaran = HeaderPenawaran::find($id);
        $penawaran->status = -1;
        $penawaran->canceled_at = now();
        $penawaran->cancel_by = $user->id;
        $penawaran->cancel_reason = $request->input('cancel_reason');
        $penawaran->save();

        toast('Penawaran Berhasil Dibatalkan', 'success');
        return redirect()->back();
    }
}
