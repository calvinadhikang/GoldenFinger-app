<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    //
    public function barangView(Request $request)
    {
        $type = $request->query('type', 'all');
        if($type == "all"){
            $barang = Barang::latest()->get();
        }else{
            $barang = Barang::onlyTrashed()->get();
        }

        return view('master.barang.view', [
            'data' => $barang,
            'type' => $type
        ]);
    }

    public function barangAddView()
    {
        return view('master.barang.add');
    }

    public function barangAddAction(Request $request)
    {
        $duplicate = Barang::find($request->input('part'));
        if ($duplicate) {
            toast('Part Number sudah terisi, gunakan part number lainnya', 'error');
            return redirect()->back();
        }

        $barang = Barang::create([
            'part' => $request->input('part'),
            'nama' => $request->input('nama'),
            'harga' => Util::parseNumericValue($request->input('harga')),
            'batas' => $request->input('batas'),
            'stok' => 0,
        ]);

        toast('Berhasil Menambah Barang', 'success');
        return redirect('/barang');
    }

    public function barangDetailView($id)
    {
        $barang = Barang::find($id) ?? Barang::withTrashed()->where('part', $id)->first();
        if ($barang == null) {
            toast("Barang $id Tidak Ditemukan", 'error');
            return redirect('/barang');
        }
        return view('master.barang.detail', [
            'barang' => $barang
        ]);
    }

    public function barangDetailAction(Request $request, $id){
        $barang = Barang::find($id);

        if ($barang == null) {
            toast("Barang Tidak Ditemukan", "error");
            return redirect('barang');
        }

        $barang->part = $request->input('part');
        $barang->nama = $request->input('nama');
        $barang->harga = Util::parseNumericValue($request->input('harga'));
        $barang->image = $request->input('image');
        $barang->public = $request->input('public');
        $barang->save();

        toast("Berhasil Update Barang", "success");
        return redirect('/barang/detail/'.$barang->part);
    }

    public function getMinimum(){
        $data = Barang::where('stok', '<=', 'batas')->get();

        return response()->json([
            'data' => $data,
            'count' => count($data)
        ]);
    }

    public function barangDetailStatusToggle($id){
        $barang = Barang::withTrashed()->where('part', $id)->first();
        if ($barang->deleted_at) {
            $barang->restore();
        }else {
            $barang->delete();
        }

        toast('Berhasil Ubah Status Barang', 'success');
        return back();
    }

    public function getAllBarang(){
        $data = Barang::all();
        foreach ($data as $key => $value) {
            $value->qty = 0;
        }

        return $data;
    }
}
