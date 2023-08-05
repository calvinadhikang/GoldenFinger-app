<?php

namespace App\Http\Controllers;

use App\Models\OperationalCost;
use Illuminate\Http\Request;

class OperationalCostController extends Controller
{
    public function costView(){
        $data = OperationalCost::all();
        return view('master.cost.view', [
            'data' => $data
        ]);
    }

    public function costAddView(){
        return view('master.cost.add');
    }

    public function costAddAction(Request $request){
        $deskripsi = $request->input('deskripsi');
        $total = $request->input('total');

        toast('Berhasil Menambah Operational Cost', 'success');
        $cost = OperationalCost::create([
            'deskripsi' => $deskripsi,
            'total' => $total
        ]);

        return redirect('/cost');
    }
}
