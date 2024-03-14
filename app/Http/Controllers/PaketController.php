<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\HeaderPaket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaketController extends Controller
{
    public function paketView(Request $request){
        $type = $request->query('type', 'all');
        if ($type == 'deleted') {
            $data = HeaderPaket::onlyTrashed()->latest()->get();
        }else {
            $data = HeaderPaket::latest()->get();
        }
        return view('master.paket.view', [
            'data' => $data,
            'type' => $type
        ]);
    }

    public function paketAddView(){
        $data = Barang::latest()->get();
        return view('master.paket.add', [
            'barang' => $data
        ]);
    }

    public function paketAddAction(Request $request){
        $harga = Util::parseNumericValue($request->input('harga'));
        $nama = $request->input('nama');
        $data = $request->input('data') ?? '';
        $data = json_decode($data);
        if(count($data) <= 0){
            return back()->withErrors([
                'msg' => 'Minimal pilih 1 data'
            ]);
        }

        try {
            DB::beginTransaction();

            $header_id = DB::table('hpaket')->insertGetId([
                'nama' => $nama,
                'harga' => $harga,
                'created_at' => Carbon::now()
            ]);

            foreach ($data as $key => $value) {
                DB::table('dpaket')->insert([
                    'hpaket_id' => $header_id,
                    'part' => $value->part,
                    'qty' => $value->qty
                ]);
            }

            DB::commit();
            toast("Berhasil buat paket $nama", 'success');
            return redirect('/paket');
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return back()->withErrors([
                'msg' => "Error : $msg"
            ]);
        }
    }

    public function paketDetailView($id){
        $paket = HeaderPaket::withTrashed()->where('id', $id)->first() ?? null;
        if (!$paket) {
            return back()->withErrors([
                'msg' => 'Data tidak ditemukan !'
            ]);
        }

        $detailBarang = [];
        foreach ($paket->details as $key => $value) {
            $target = Barang::withTrashed()->where('part', $value->part)->first();
            $target->qty = $value->qty;
            $detailBarang[] = $target;
        }

        return view('master.paket.detail', [
            'paket' => $paket,
            'detail' => $detailBarang
        ]);
    }

    public function paketDetailStatusToggle($id) {
        $paket = HeaderPaket::withTrashed()->where('id', '=', $id)->first();
        if ($paket->deleted_at != null) {
            $paket->restore();
            $paket->deleted_at = null;
            $paket->save();
        }else{
            $paket->delete();
        }

        return back()->with([
            'msg' => "Berhasil Ubah Status"
        ]);
    }
}
