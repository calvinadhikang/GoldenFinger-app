<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    //
    public function kategoriView(){
        $data = Kategori::all();

        return view('master.kategori.view', [
            'data' => $data
        ]);
    }

    public function kategoriAddView(){
        return view('master.kategori.add');
    }

    public function kategoriDetailView($id){
        $kategori = Kategori::find($id);

        return view('master.kategori.detail', [
            'kategori' => $kategori
        ]);
    }
    public function kategoriAddAction(Request $request){
        $kategori = Kategori::create([
            'nama' => $request->input('nama')
        ]);

        toast('Berhasil tambah kategori ' . $kategori->nama , 'success');
        return redirect('/kategori');
    }

    public function kategoriDetailAction(Request $request){
        $nama = $request->input('nama');
        $id = $request->input('id');

        $kategori = Kategori::find($id);
        $kategori->nama = $nama;
        $kategori->save();

        toast('Berhasil edit kategori', 'success');
        return back();
    }
}
