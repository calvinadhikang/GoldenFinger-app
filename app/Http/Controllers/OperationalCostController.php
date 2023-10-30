<?php

namespace App\Http\Controllers;

use App\Models\HeaderPurchase;
use App\Models\OperationalCost;
use Carbon\Carbon;
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
        $total = intval(str_replace(',', '', $request->input('total')));

        toast('Berhasil Menambah Operational Cost', 'success');
        $cost = OperationalCost::create([
            'deskripsi' => $deskripsi,
            'total' => $total
        ]);

        return redirect('/cost');
    }

    public function getMonthlyCost(){
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $data = OperationalCost::whereMonth('created_at', '=', $currentMonth)->whereYear('created_at', '=', $currentYear)->get();
        $total = 0;
        foreach ($data as $key => $value) {
            $total += $value->total;
        }

        return response()->json([
            'data' => $data,
            'total' => $total
        ], 200);
    }

    public function costRemoveAction(Request $request){
        $cost = OperationalCost::find($request->input('id'));
        $cost->delete();

        toast("Berhasil hapus pengeluaran $cost->deskripsi", 'success');
        return redirect()->back();
    }
}
