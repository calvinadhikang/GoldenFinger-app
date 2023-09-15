<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
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
        $karyawan = Karyawan::create([
            'nama' => $request->input('nama'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'telp' => $request->input('telp'),
            'role' => $request->input('role'),
            'status' => 1,
        ]);

        toast("Berhasil Menambah Karyawan", "success");
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

        $status = $request->input('status') == "on" ? 1 : 0;

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
