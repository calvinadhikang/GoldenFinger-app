<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Karyawan;
use App\Models\VulkanisirMachine;
use App\Models\VulkanisirService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use stdClass;

class VulkanisirServiceController extends Controller
{
    public function serviceView(Request $request) {
        $type = $request->query('type', 'all');
        if($type == "all"){
            $services = VulkanisirService::latest()->whereNull('canceled_by')->WhereNull('taken_by')->get();
        }else{
            $services = VulkanisirService::latest()->whereNotNull('canceled_by')->orWhereNotNull('taken_by')->get();
        }

        foreach ($services as $key => $value) {
            $nowTime = Carbon::now();
            $serviceFinishTime = Carbon::createFromFormat('Y-m-d H:i:s', $value->will_finish_at);
            $status = $nowTime->gt($serviceFinishTime) ? 'Pickup' : 'On Progress';
            if ($value->cancel_reason != null) {
                $status = "Canceled";
            }
            if ($value->taken_by != null) {
                $status = "Finished";
            }

            $value->status = $status;
            $value->finish_text = $serviceFinishTime;
        }

        return view('master.vservice.view', [
            'data' => $services,
            'type' => $type
        ]);
    }

    public function serviceCustomerView(){
        $service = Session::get('service_cart');
        $customers = Customer::latest()->get();

        if ($service == null) {
            $service = new stdClass();
            $service->customer = null;
            $service->nama = null;
            $service->PPN = DB::table('settings')->select('ppn')->first()->ppn;
            $service->PPN_value = null;
            $service->total = null;
            $service->grandTotal = null;
            $service->machine = null;
            $service->will_finish_at = null;

            Session::put('service_cart', $service);
        }

        return view('master.vservice.customer', [
            'customers' => $customers,
            'customer' => $service->customer
        ]);
    }

    public function serviceCustomerAdd(Request $request){
        $customer = Customer::create([
            'alamat' => $request->input('alamat'),
            'nama' => $request->input('nama'),
            'telp' => $request->input('telp'),
            'email' => $request->input('email'),
            'kota' => $request->input('kota'),
            'NPWP' => $request->input('NPWP'),
        ]);

        $service = Session::get('service_cart');
        $service->customer = $customer;
        Session::put('service_cart', $service);

        toast('Berhasil Menambah Customer', 'success');
        return redirect()->back();
    }

    public function serviceCustomerAction(Request $request){
        $customer = Customer::find($request->input('id'));
        $service = Session::get('service_cart');

        $service->customer = $customer;

        toast('Berhasil memilih customer', 'success');
        return redirect()->back();
    }

    public function serviceCustomerUnsetAction(Request $request){
        $service = Session::get('service_cart');
        $service->customer = null;
        Session::put('service_cart', $service);

        toast('Berhasil melepas customer', 'success');
        return redirect()->back();
    }

    public function serviceKeteranganView(){
        $machines = VulkanisirMachine::where('service_id', null)->get();
        return view('master.vservice.keterangan', [
            'machines' => $machines
        ]);
    }

    public function serviceKeteranganAction(Request $request){
        $service = Session::get('service_cart');

        $harga = Util::parseNumericValue($request->input('harga'));
        $nama = $request->input('nama');
        $tanggal = $request->input('tanggal');
        $machine = $request->input('machine');

        $service->nama = $nama;
        $service->PPN_value = $harga / 100 * $service->PPN;
        $service->total = $harga;
        $service->grandTotal = $harga + $service->PPN_value;
        $service->machine = $machine;
        $service->will_finish_at = $tanggal;
        Session::put('service_cart', $service);

        return redirect('/vservice/confirmation');
    }

    public function serviceConfirmationView(){
        $teknisi = Karyawan::latest()->get();
        $service = Session::get('service_cart');
        $machine = VulkanisirMachine::find($service->machine);

        return view('master.vservice.confirmation', [
            'service' => $service,
            'machine' => $machine,
            'teknisi' => $teknisi
        ]);
    }

    public function serviceConfirmationAction(Request $request){
        $teknisi_id = $request->input('teknisi');
        $service = Session::get('service_cart');

        $newService = VulkanisirService::create([
            'machine_id' => $service->machine,
            'customer_id' => $service->customer->id,
            'harga' => $service->grandTotal,
            'nama' => $service->nama,
            'will_finish_at' => $service->will_finish_at,
            'handled_by'=> $teknisi_id
        ]);
        $machine = VulkanisirMachine::find($service->machine);
        $machine->service_id = $newService->id;
        $machine->save();

        toast('Berhasil membuat service vulkanisir', 'success');
        return redirect('/vservice');
    }

    public function serviceDetailView($id){
        $service = VulkanisirService::find($id);

        $nowTime = Carbon::now();
        $serviceFinishTime = Carbon::createFromFormat('Y-m-d H:i:s', $service->will_finish_at);
        $status = $nowTime->gt($serviceFinishTime) ? 'Pickup' : 'On Progress';
        if ($service->cancel_reason != null) {
            $status = "Canceled";
        }
        if ($service->taken_by != null) {
            $status = "Finished";
        }

        return view('master.vservice.detail', [
            'service' => $service,
            'service_status' => $status
        ]);
    }

    public function serviceFinishTaken(Request $request){
        $service_id = $request->input('service_id');
        $taken_by = $request->input('taken_by');

        $service = VulkanisirService::find($service_id);
        $service->taken_by = $taken_by;
        $service->taken_at = Carbon::now();
        $service->save();

        // Kosongkan Mesin.. melalui relation model VulkanisirService
        $service->machine->service_id = null;
        $service->machine->save();

        toast('Berhasil menyelesaikan pesanan service vulkanisir', 'success');
        return back();
    }

    public function serviceCancel(Request $request){
        $user = Session::get('user');
        $service_id = $request->input('service_id');
        $password = $request->input('password');
        $cancel_reason = $request->input('cancel_reason');

        if (!Hash::check($password, $user->password)) {
            return back()->withErrors([
                'msg' => 'Gagal batalkan pesanan, password user salah!'
            ]);
        }

        $service = VulkanisirService::find($service_id);
        $service->canceled_by = $user->id;
        $service->cancel_reason = $cancel_reason;
        $service->save();

        // Kosongkan Mesin.. melalui relation model VulkanisirService
        $service->machine->service_id = null;
        $service->machine->save();

        toast('Berhasil membatalkan service vulkanisir', 'success');
        return back();
    }
}
