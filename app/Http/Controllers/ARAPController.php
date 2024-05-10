<?php

namespace App\Http\Controllers;

use App\Models\HeaderInvoice;
use App\Models\HeaderPurchase;
use Illuminate\Http\Request;

class ARAPController extends Controller
{
    public function view(){
        $hutang = 0;
        $hutang_data = HeaderPurchase::where('paid_at', null)->get();
        foreach($hutang_data as $data){
            $hutang += $data->grand_total;
        }

        $piutang = 0;
        $piutang_data = HeaderInvoice::where('paid_at', null)->where('status', '=', 2)->get();
        foreach($piutang_data as $data){
            $piutang += $data->grand_total;
        }

        $dueInvoices = HeaderInvoice::whereNull('paid_at')->where('status', '=', 2)
            ->where('jatuh_tempo', '<', now())
            ->count();

        return view('master.arap.view', [
            'hutang' => $hutang,
            'piutang' => $piutang,
            'invoice_jatuh_tempo' => $dueInvoices,
        ]);
    }
}
