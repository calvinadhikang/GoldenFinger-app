<?php

namespace App\Http\Controllers;

use App\Models\SharesModel;
use Illuminate\Http\Request;

class SharesController extends Controller
{
    //
    public function sharesView(){
        $data = SharesModel::orderBy('shares', 'desc')->get();
        return view('shares.view', [
            'data' => $data
        ]);
    }

    public function configureSharesView(){
        return view('shares.configure', [

        ]);
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
