<?php

namespace App\Http\Controllers;

use App\Exports\BarangExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SettingsController extends Controller
{
    //
    public function settingsView(){
        $ppn = DB::table('settings')->value('ppn');
        return view('settings.view', [
            'ppn' => $ppn
        ]);
    }

    public function downloadBarang(){
        return Excel::download(new BarangExport, 'barang.xlsx');
    }
}
