<?php

namespace App\Http\Controllers;

use App\Models\HeaderInvoice;
use App\Models\HeaderPurchase;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ARAPController extends Controller
{
    public function view(Request $request){
        $besok = Carbon::now()->addDay();
        $seminggu = Carbon::now()->addDays(7);

        $total_hutang = 0;
        $data_hutang = HeaderPurchase::where('paid_at', null)->orderBy('jatuh_tempo')->get();
        foreach($data_hutang as $data){
            $total_hutang += $data->grand_total;
        }

        $total_piutang = 0;
        $data_piutang = HeaderInvoice::where('paid_at', null)->whereNotNull('confirmed_by')->orderBy('jatuh_tempo')->get();
        foreach($data_piutang as $data){
            $total_piutang += $data->grand_total;
        }

        $hutang_jatuh_tempo = HeaderPurchase::whereNull('paid_at')
            ->where('jatuh_tempo', '<=', now()->addDay())->orderBy('jatuh_tempo')
            ->get();
        $hutang_jatuh_tempo_seminggu = HeaderPurchase::whereNull('paid_at')
            ->whereBetween('jatuh_tempo', [$besok, $seminggu])->orderBy('jatuh_tempo')
            ->get();

        $piutang_jatuh_tempo = HeaderInvoice::whereNull('paid_at')->whereNotNull('confirmed_by')
            ->where('jatuh_tempo', '<=', now()->addDay())->orderBy('jatuh_tempo')
            ->get();
        $piutang_jatuh_tempo_seminggu = HeaderInvoice::whereNull('paid_at')->whereNotNull('confirmed_by')
            ->whereBetween('jatuh_tempo', [$besok, $seminggu])->orderBy('jatuh_tempo')
            ->get();

        // Piutang Query Mode, 0 = Semua, 1 = Lewat Jatuh Tempo, 2 = Jatuh Tempo Seminggu
        $piutang_mode = $request->query('piutang_mode') ?? 0;
        $show_piutang = [];
        $show_piutang_total = 0;
        if ($piutang_mode == 0) {
            $show_piutang = $data_piutang;
        }else if ($piutang_mode == 1) {
            $show_piutang = $piutang_jatuh_tempo;
        }else if ($piutang_mode == 2) {
            $show_piutang = $piutang_jatuh_tempo_seminggu;
        }

        foreach($show_piutang as $data){
            $show_piutang_total += $data->grand_total;
            $selisihHari = Carbon::parse($data->jatuh_tempo)->diffInDays(now());
            $isJatuhTempo = Carbon::parse($data->jatuh_tempo)->isBefore(now());
            $data->sisa_hari = $isJatuhTempo ? "-".$selisihHari : $selisihHari;
        }

        // Hutang Query Mode, 0 = Semua, 1 = Lewat Jatuh Tempo, 2 = Jatuh Tempo Seminggu
        $hutang_mode = $request->query('hutang_mode') ?? 0;
        $show_hutang = [];
        $show_hutang_total = 0;
        if ($hutang_mode == 0) {
            $show_hutang = $data_hutang;
        }else if ($hutang_mode == 1) {
            $show_hutang = $hutang_jatuh_tempo;
        }else if ($hutang_mode == 2) {
            $show_hutang = $hutang_jatuh_tempo_seminggu;
        }

        foreach ($show_hutang as $data) {
            $show_hutang_total += $data->grand_total;
            $selisihHari = Carbon::parse($data->jatuh_tempo)->diffInDays(now());
            $isJatuhTempo = Carbon::parse($data->jatuh_tempo)->isBefore(now());
            $data->sisa_hari = $isJatuhTempo ? "-".$selisihHari : $selisihHari;
        }

        return view('master.arap.view', [
            'total_hutang' => $total_hutang,
            'total_piutang' => $total_piutang,
            'data_hutang' => $data_hutang,
            'data_piutang' => $data_piutang,
            'hutang_jatuh_tempo' => $hutang_jatuh_tempo,
            'hutang_jatuh_tempo_seminggu' => $hutang_jatuh_tempo_seminggu,
            'piutang_jatuh_tempo' => $piutang_jatuh_tempo,
            'piutang_jatuh_tempo_seminggu' => $piutang_jatuh_tempo_seminggu,
            'piutang_mode' => $piutang_mode,
            'hutang_mode' => $hutang_mode,
            'show_piutang' => $show_piutang,
            'show_piutang_total' => $show_piutang_total,
            'show_hutang' => $show_hutang,
            'show_hutang_total' => $show_hutang_total,
        ]);
    }
}
