<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function customerView()
    {
        $customer = Customer::all();
        return view('master.customer.view', [
            'data' => $customer
        ]);
    }

    public function customerAddView()
    {
        return view('master.customer.add');
    }

    public function customerAddAction(Request $request)
    {
        $customer = Customer::create([
            'part' => $request->input('part'),
            'nama' => $request->input('nama'),
            'harga' => $request->input('harga'),
            'stok' => 0,
        ]);

        toast('Berhasil Menambah Customer', 'success');
        return redirect('/customer');
    }

    public function customerDetailView($id)
    {
        $customer = Customer::find($id);
        return view('master.customer.detail', [
            'customer' => $customer
        ]);
    }

    public function customerDetailAction(Request $request, $id){
        $customer = Customer::find($id);

        if ($customer == null) {
            toast("Customer Tidak Ditemukan", "error");
            return redirect('customer');
        }

        $customer->part = $request->input('part');
        $customer->nama = $request->input('nama');
        $customer->harga = $request->input('harga');
        $customer->save();

        toast("Berhasil Update Customer", "success");
        return redirect()->back();
    }
}
