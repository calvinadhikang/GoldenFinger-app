<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\SharesModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\VarDumper\VarDumper;

class KaryawanController extends Controller
{
    //
    public function karyawanView(){
        $data = Karyawan::all();

        return view('master.karyawan.view',[
            'data' => $data
        ]);
    }

    public function karyawanAddView(){
        return view('master.karyawan.add');
    }

    public function karyawanAddAction(Request $request){
        $data = Karyawan::where('username', $request->input('username'))->get();
        if (count($data) > 0) {
            toast('Username sudah digunakan', 'error');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $lastId = DB::table('karyawan')->insertGetId([
                'nama' => $request->input('nama'),
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password')),
                'telp' => $request->input('telp'),
                'role' => $request->input('role'),
                'status' => 1,
                'created_at' => Carbon::now()
            ]);

            if ($request->input('role') == 'Stakeholder') {
                DB::table('shares')->insert([
                    'karyawan_id' => $lastId,
                    'shares' => 0,
                    'created_at' => Carbon::now()
                ]);
            }

            DB::commit();
            toast("Berhasil Menambah Karyawan", "success");
        } catch (\Exception $ex) {
            dd($ex->getMessage());
            DB::rollBack();
        }

        return redirect('/karyawan');
    }

    public function karyawanDetailView($id){
        $karyawan = Karyawan::find($id);

        if ($karyawan == null) {
            toast("Karyawan Tidak Ditemukan", "error");
            return redirect('karyawan');
        }

        return view('master.karyawan.detail', [
            'karyawan' => $karyawan
        ]);
    }

    public function karyawanDetailAction(Request $request, $id){
        $karyawan = Karyawan::find($id);

        if ($karyawan == null) {
            toast("Karyawan Tidak Ditemukan", "error");
            return redirect('karyawan');
        }

        $status = $request->input('status') == "on" ? "Aktif" : "Non-Aktif";

        $karyawan->nama = $request->input('nama');
        $karyawan->username = $request->input('username');
        $karyawan->telp = $request->input('telp');
        $karyawan->role = $request->input('role');
        $karyawan->status = $status;
        $karyawan->save();

        toast("Berhasil Update Karyawan", "success");
        return redirect()->back();
    }
}
