<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function customerView()
    {
        $customer = Customer::latest()->get();
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
        $validate = $request->validate([
            'alamat' => 'required',
            'nama' => 'required',
            'telp' => 'required',
            'email' => 'required',
            'kota' => 'required',
            'NPWP' => 'required',
        ]);

        $customer = Customer::create([
            'alamat' => $request->input('alamat'),
            'nama' => $request->input('nama'),
            'telp' => $request->input('telp'),
            'email' => $request->input('email'),
            'kota' => $request->input('kota'),
            'NPWP' => $request->input('NPWP'),
        ]);

        toast('Berhasil Menambah Customer', 'success');
        return redirect('/customer/detail/'.$customer->id);
    }

    public function customerDetailView($id)
    {
        $customer = Customer::find($id);
        $grandTotal = 0;
        $totalHutang = 0;
        $countHutang = 0;
        foreach ($customer->invoice as $key => $value) {
            $grandTotal += $value->total;
            if ($value->status == 0) {
                $countHutang += 1;
                $totalHutang += $value->total;
            }
        }
        return view('master.customer.detail', [
            'customer' => $customer,
            'grandTotal' => $grandTotal,
            'hutang' => $totalHutang,
            'countHutang' => $countHutang
        ]);
    }

    public function customerDetailAction(Request $request, $id){
        $customer = Customer::find($id);

        if ($customer == null) {
            toast("Customer Tidak Ditemukan", "error");
            return redirect('customer');
        }

        $validate = $request->validate([
            'alamat' => 'required',
            'nama' => 'required',
            'telp' => 'required',
            'email' => 'required',
            'kota' => 'required',
            'limit' => 'required',
            'NPWP' => 'required',
        ]);

        $customer->alamat = $request->input('alamat');
        $customer->nama = $request->input('nama');
        $customer->telp = $request->input('telp');
        $customer->limit = Util::parseNumericValue($request->input('limit'));
        $customer->kota = $request->input('kota');
        $customer->NPWP = $request->input('NPWP');
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
