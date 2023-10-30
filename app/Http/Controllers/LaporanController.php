<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    //
    public function stokView(){
        return view('laporan.stok');
    }
}
