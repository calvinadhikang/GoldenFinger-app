<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangVendor;
use App\Models\ContactPerson;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use stdClass;

class VendorController extends Controller
{
    //
    public function vendorView()
    {
        $vendor = Vendor::latest()->get();
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
            'kota' => $request->input('kota'),
            'npwp' => $request->input('npwp'),
        ]);

        toast('Berhasil Menambah Vendor '. $vendor->nama, 'success');
        return redirect('/vendors');
    }

    public function vendorDetailView($id)
    {
        $vendor = Vendor::find($id);

        $dataBarang = $vendor->barang;
        foreach ($dataBarang as $key => $value) {
            $barangVendor = BarangVendor::where('vendor_id', '=', $vendor->id)->where('barang_id', '=', $value->part)->get();
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
        $vendorItem = BarangVendor::where('vendor_id', $id)->get();
        foreach ($barang as $key => $item) {
            foreach ($vendorItem as $key => $value) {
                if ($item->part == $value->barang_id) {
                    $item->checked = true;
                }
            }
        }
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
        $idVendor = Session::get('vendor_barang_id');
        foreach ($arrBarang as $key => $value) {
            $barang = Barang::find($value);

            $barangVendor = BarangVendor::where('vendor_id', $idVendor)->where('barang_id', $value)->first();

            $obj = new stdClass();
            $obj->part = $barang->part;
            $obj->nama = $barang->nama;
            $obj->harga = $barangVendor ? number_format($barangVendor->harga) : 0;

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
            DB::table('barang_vendor')->where('vendor_id', $idVendor)->delete();

            for ($i=0; $i < count($arrBarang); $i++) {
                $arrBarang[$i]->harga = Util::parseNumericValue($arrHarga[$i]);

                //insert to table
                DB::table('barang_vendor')->insert([
                    'vendor_id' => $idVendor,
                    'barang_id' => $arrBarang[$i]->part,
                    'harga' => $arrBarang[$i]->harga,
                    'created_at' => Carbon::now()
                ]);
            }

            DB::commit();
            toast('Berhasil Insert Barang ke Vendor', 'success');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
        }

        return redirect("/vendors/detail/$idVendor");
    }

    public function vendorAddContactView($id){
        return view('master.vendor.addContactPerson');
    }

    public function vendorAddContactAction(Request $request, $id){

        $cp = ContactPerson::create([
            'vendor_id' => $id,
            'nama' => $request->input('nama'),
            'telp' => $request->input('telp'),
        ]);

        toast('Berhasil Menambah Contact', 'success');
        return redirect("/vendors/detail/$id");
    }

    public function vendorRemoveContactAction($id){

    }
}
