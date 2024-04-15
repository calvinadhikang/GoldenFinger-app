<?php

namespace App\Http\Controllers;

use App\Models\VulkanisirMachine;
use Illuminate\Http\Request;

class VulkanisirMachineController extends Controller
{
    public function machineView(Request $request){
        $type = $request->query('type', 'all');
        if($type == "all"){
            $machines = VulkanisirMachine::latest()->get();
        }else{
            $machines = VulkanisirMachine::onlyTrashed()->get();
        }

        return view('master.machine.view', [
            'data' => $machines,
            'type' => $type
        ]);
    }

    public function machineAddView(){
        return view('master.machine.add');
    }

    public function machineAddAction(Request $request){
        $nama = $request->input('nama');
        $oldMachine = VulkanisirMachine::where('nama', $nama)->get();
        if (count($oldMachine) > 0) {
            return back()->withErrors([
                'msg' => 'Nama sudah digunakan!'
            ]);
        }

        $newMachine = VulkanisirMachine::create([
            'nama' => $nama
        ]);

        toast('Berhasil tambah mesin baru!', 'success');
        return redirect('/machine');
    }

    public function machineDetailView($id){
        $machine = VulkanisirMachine::withTrashed()->where('id', $id)->first();
        if ($machine == null) {
            return redirect('/machine')->withErrors([
                'msg' => 'Mesin tidak ditemukan!'
            ]);
        }

        return view('master.machine.detail', [
            'machine' => $machine
        ]);
    }

    public function machineDetailAction($id, Request $request){
        $machine = VulkanisirMachine::withTrashed()->where('id', $id)->first();
        $nama = $request->input('nama');

        if ($machine == null) {
            return redirect('/machine')->withErrors([
                'msg' => 'Mesin tidak ditemukan!'
            ]);
        }

        $machine->nama = $nama;
        $machine->save();

        toast('Berhasil update data mesin!', 'success');
        return back();
    }
}
