<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function kategoriDetailActionRemove(Request $request, $id){
        $barangId = $request->input('barang');
        DB::table('kategori_barang')->where('kategori_id', $id)->where('barang_id', $barangId)->delete();

        toast('Berhasil Hapus Barang Dari Kategori', 'success');
        return back();
    }

    public function kategoriDetailAddBarangView($id){
        $barang = Barang::all();
        $kategori = Kategori::find($id);
        $kategori_barang = DB::table('kategori_barang')->where('kategori_id', $id)->get();
        $unlisted = [];
        $listed = [];

        foreach ($barang as $key => $item) {
            $found = false;
            foreach ($kategori_barang as $key => $relation) {
                if ($item->kode == $relation->barang_id) {
                    $found = true;
                }
            }

            if ($found) {
                $listed[] = $item;
            }else{
                $unlisted[] = $item;
            }
        }

        return view('master.kategori.detail_add', [
            'kategori' => $kategori,
            'unlisted' => $unlisted,
            'listed' => $listed
        ]);
    }

    public function kategoriDetailAddBarangAction($id, Request $request){
        $listBarangId = $request->input('barang');
        foreach ($listBarangId as $key => $value) {
            DB::table('kategori_barang')->insert([
                'kategori_id' => $id,
                'barang_id' => $value
            ]);
        }

        toast("Berhasil tambah " . count($listBarangId) . " barang ke kategori", 'success');
        return redirect("kategori/detail/$id");
    }
}
