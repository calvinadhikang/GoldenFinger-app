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
            'alamat' => $request->input('alamat'),
            'nama' => $request->input('nama'),
            'telp' => $request->input('telp'),
            'email' => $request->input('email'),
        ]);

        toast('Berhasil Menambah Customer', 'success');
        return redirect('/customer');
    }

    public function customerDetailView($id)
    {
        $customer = Customer::find($id);
        $grandTotal = 0;
        foreach ($customer->invoice as $key => $value) {
            $grandTotal += $value->total;
        }
        return view('master.customer.detail', [
            'customer' => $customer,
            'grandTotal' => $grandTotal
        ]);
    }

    public function customerDetailAction(Request $request, $id){
        $customer = Customer::find($id);

        if ($customer == null) {
            toast("Customer Tidak Ditemukan", "error");
            return redirect('customer');
        }

        $customer->alamat = $request->input('alamat');
        $customer->nama = $request->input('nama');
        $customer->telp = $request->input('telp');
        $customer->limit = Util::parseNumericValue($request->input('limit'));
        $customer->save();

        toast("Berhasil Update Customer", "success");
        return redirect()->back();
    }

    public function getCustomer(Request $request){
        $key = $request->input('key');
        if ($key == "") {
            $data = Customer::all();
        }else{
            $data = Customer::where('nama', 'like', "%$key%")->get();
        }

        return response()->json([
            'error' => false,
            'message' => 'Berhasil fetch data Customer',
            'data' => $data
        ]);
    }
}
