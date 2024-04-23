<?php

namespace App\Http\Controllers;

use App\Models\OperationalCost;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;

class OperationalCostController extends Controller
{
    public function costView(Request $request){
        $inputMonth = $request->query('month');

        if ($inputMonth) {
            $startDate = Carbon::parse($inputMonth)->startOfMonth();
            $endDate = Carbon::parse($inputMonth)->endOfMonth();

            $data = OperationalCost::whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc')->get();
        }else{
            $data = OperationalCost::orderBy('created_at', 'desc')->get();
        }

        return view('master.cost.view', [
            'data' => $data,
            'filter' => $inputMonth,
            'filterReadable' => $inputMonth ? Carbon::parse($inputMonth)->format('F Y') : 'Keseluruhan'
        ]);
    }

    public function costAddView(){
        $default = Carbon::now()->toDateString();
        return view('master.cost.add', [
            'default' => $default
        ]);
    }

    public function costAddAction(Request $request){
        $deskripsi = $request->input('deskripsi');
        $tanggal = $request->input('tanggal');
        $total = intval(str_replace(',', '', $request->input('total')));

        toast('Berhasil Menambah Operational Cost', 'success');

        $cost = new OperationalCost();
        $cost->deskripsi = $deskripsi;
        $cost->total = $total;
        $cost->created_at = $tanggal;
        $cost->save();

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

    static function getOperationalCostThisMonthData(){
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $data = OperationalCost::whereMonth('created_at', '=', $currentMonth)->whereYear('created_at', '=', $currentYear)->get();
        $totalOc = 0;
        foreach ($data as $oc) {
            $totalOc += $oc->total;
        }

        $obj = new stdClass();
        $obj->total = $totalOc;
        $obj->data = $data;
        return $obj;
    }
}
