<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function stokView(){
        $barang = Barang::latest()->get();

        return view('laporan.stok', [
            'data' => $barang
        ]);
    }

    public function stokPdfDownload(Request $request){
        $part = $request->query('part', null);
        if ($part == null) {
            $barang = Barang::latest()->get();
        }else{
            $barang = Barang::where('part', $part)->get();
        }

        $pdf = Pdf::loadView('template.pdf.laporan.stok.laporan_stok', [
            'barangs' => $barang,
            'tanggal' => Carbon::now()
        ]);
        return $pdf->download('laporan_stok.pdf');
    }
}
