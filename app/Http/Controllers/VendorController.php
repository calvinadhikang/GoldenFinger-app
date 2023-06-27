<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

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
        return view('master.vendor.detail', [
            'vendor' => $vendor
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
}
