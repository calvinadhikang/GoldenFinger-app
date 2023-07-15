<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangVendor;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $dataBarang = $vendor->barang;
        foreach ($dataBarang as $key => $value) {
            $barangVendor = BarangVendor::where('vendor_id', '=', $vendor->id)->where('barang_id', '=', $value->id)->get();
            $value->hargaBeli = $barangVendor[0]->harga;
        }

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

    public function VendorAddBarangView($id) {
        $barang = Barang::all();
        Session::put('vendor_barang_id', $id);

        return view('master.vendor.viewBarang', [
            'barang' => $barang
        ]);
    }

    public function VendorAddBarangAction(Request $request) {
        $arrBarang = $request->barang;
        if ($arrBarang == null) {
            toast("Minimal Pilih 1 Barang", 'warning');
            return redirect()->back();
        }

        $arrTemp = [];
        foreach ($arrBarang as $key => $value) {
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

    public function VendorAddBarangHargaAction(Request $request) {
        $idVendor = Session::get('vendor_barang_id');
        $arrBarang = Session::get('vendor_barang_cart');
        $arrHarga = $request->harga;

        DB::beginTransaction();

        try {
            for ($i=0; $i < count($arrBarang); $i++) {
                $arrBarang[$i]->harga = $arrHarga[$i];

                //insert to table
                DB::table('barang_vendor')->insert([
                    'vendor_id' => $idVendor,
                    'barang_id' => $arrBarang[$i]->id,
                    'harga' => $arrBarang[$i]->harga
                ]);
            }

            DB::commit();
            toast('Berhasil Insert Barang ke Vendor', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect("/vendors/detail/$idVendor");
    }
}
