<?php

namespace App\Http\Controllers;

use App\Models\OperationalCost;
use App\Models\SharesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SharesController extends Controller
{
    //
    public function sharesView(){
        $data = SharesModel::orderBy('shares', 'desc')->get();
        $dataPenjualan = InvoiceController::getPaidInvoiceThisMonthData();

        $user = Session::get('user');
        $user->shares = SharesModel::where('karyawan_id', $user->id)->first()->shares;
        $user->shares_value = $dataPenjualan->total / 100 * $user->shares;

        $operasional = OperationalCostController::getOperationalCostThisMonthData();
        $pendapatanBersih = $dataPenjualan->total - $operasional->total;

        return view('shares.view', [
            'data' => $data,
            'dataPenjualan' => $dataPenjualan,
            'user' => $user,
            'operasional' => $operasional,
            'pendapatanBersih' => $pendapatanBersih
        ]);
    }

    public function configureSharesView(){
        $data = SharesModel::orderBy('shares', 'desc')->get();
        return view('shares.configure', [
            'data' => $data
        ]);
    }

    public function configureSharesAction(Request $request){
        $ids = $request->input('id');
        $shares = $request->input('shares');

        $total = 0;
        foreach ($shares as $key => $value) {
            $total += Util::parseNumericValue($value);
        }

        if ($total != 100) {
            toast('Jumlah total Shares harus 100', 'info');
            return back();
        }else{
            DB::beginTransaction();

            try {
                for ($i=0; $i < count($ids); $i++) {
                    DB::table('shares')->where('id', $ids[$i])->update(['shares' => $shares[$i]]);
                }

                DB::commit();

                toast('Berhasil ubah shares', 'info');
                return redirect('/shares');
            } catch (\Exception $th) {
                dd($th);
                DB::rollBack();
            }
        }
    }

    public function getSharesData(){
        $data = SharesModel::orderBy('shares', 'desc')->get();

        $arrKaryawan = [];
        $arrShares = [];
        foreach ($data as $key => $value) {
            $arrKaryawan[] = $value->details->nama;
            $arrShares[] = $value->shares;
        }

        return response()->json([
            'data' => $data,
            'karyawan' => $arrKaryawan,
            'shares' => $arrShares,
        ], 200);
    }
}
