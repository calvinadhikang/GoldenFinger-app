<?php

namespace App\Http\Controllers;

use App\Models\HeaderPaket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function paketView(Request $request){
        $type = $request->query('type', 'all');
        if ($type == 'deleted') {
            $data = HeaderPaket::onlyTrashed()->latest()->get();
        }else {
            $data = HeaderPaket::latest()->get();
        }
        return view('master.paket.view', [
            'data' => $data,
            'type' => $type
        ]);
    }

    public function paketAddView(){
        return view('master.paket.add');
    }
}
