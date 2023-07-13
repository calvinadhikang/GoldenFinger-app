<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use stdClass;
use Symfony\Component\VarDumper\VarDumper;

class VendorController extends Controller
{
    //
    public function vendorView()
    {
        $vendor = Vendor::all();
        return view('master.vendor.view', [
            'data' => $vendor
        ]);
    }

    public function vendorAddView()
    {
        return view('master.vendor.add');
    }

    public function vendorAddAction(Request $request)
    {
        $vendor = Vendor::create([
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'telp' => $request->input('telp'),
            'alamat' => $request->input('alamat'),
        ]);

        toast('Berhasil Menambah Vendor', 'success');
        return redirect('/vendors');
    }

    public function vendorDetailView($id)
    {
        $vendor = Vendor::find($id);
        $dataBarang = [];
        return view('master.vendor.detail', [
            'vendor' => $vendor,
            'data' => $dataBarang
        ]);
    }

    public function vendorDetailAction(Request $request, $id){
        $vendor = Vendor::find($id);

        if ($vendor == null) {
            toast("Vendor Tidak Ditemukan", "error");
            return redirect('vendors');
        }

        $vendor->nama = $request->input('nama');
        $vendor->email = $request->input('email');
        $vendor->telp = $request->input('telp');
        $vendor->alamat = $request->input('alamat');
        $vendor->save();

        toast("Berhasil Update Vendor", "success");
        return redirect()->back();
    }

    public function VendorAddBarangView() {
        $barang = Barang::all();

        return view('master.vendor.viewBarang', [
            'barang' => $barang
        ]);
    }

    public function VendorAddBarangAction(Request $request) {
        $arrIdBarang = $request->barang;

        $arrTemp = [];
        foreach ($arrIdBarang as $key => $value) {
            $barang = Barang::find($value);

            $obj = new stdClass();
            $obj->id = $barang->id;
            $obj->part = $barang->part;
            $obj->nama = $barang->nama;
            $obj->harga = 0;

            $arrTemp[] = $obj;
        }

        Session::put('vendor_barang_cart', $arrTemp);
        return redirect('/vendors/add/harga');
    }

    public function vendorAddBarangHargaView() {
        $barang = Session::get('vendor_barang_cart');

        return view('master.vendor.hargaBarang', [
            'barang' => $barang
        ]);
    }
}
