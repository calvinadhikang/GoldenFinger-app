<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    //
    public function settingsView(){
        $ppn = DB::table('settings')->value('ppn');
        return view('settings.view', [
            'ppn' => $ppn
        ]);
    }
}
