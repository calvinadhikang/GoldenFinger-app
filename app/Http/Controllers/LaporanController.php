<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailInvoice;
use App\Models\DFIFO;
use App\Models\HeaderInvoice;
use App\Models\HeaderPurchase;
use App\Models\OperationalCost;
use App\Models\SharesModel;
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

    public function costView(Request $request){
        $mulai = $request->input('mulai', null);
        $akhir = $request->input('akhir', null);

        $data = OperationalCost::latest()->whereBetween('created_at', [$mulai, $akhir])->get();

        return view('laporan.operational_cost', [
            'mulai' => $mulai,
            'akhir' => $akhir,
            'data' => $data
        ]);
    }

    public function costPdfDownload(Request $request){
        $mulai = $request->input('mulai', null);
        $akhir = $request->input('akhir', null);

        $data = OperationalCost::latest()->whereBetween('created_at', [$mulai, $akhir])->get();

        $pdf = Pdf::loadView('template.pdf.laporan.cost.laporan_cost', [
            'data' => $data,
            'mulai' => $mulai,
            'akhir' => $akhir,
        ]);
        return $pdf->download('laporan_cost.pdf');
    }

    public function pendapatanView(Request $request){
        $mulai = $request->input('mulai', null);
        $akhir = $request->input('akhir', null);

        $data = HeaderInvoice::latest()->whereNotNull('paid_at')->whereBetween('created_at', [$mulai, $akhir])->get();

        return view('laporan.pendapatan', [
            'mulai' => $mulai,
            'akhir' => $akhir,
            'data' => $data
        ]);
    }

    public function pendapatanPdfDownload(Request $request){
        $mulai = $request->input('mulai', null);
        $akhir = $request->input('akhir', null);

        $data = HeaderInvoice::latest()->whereNotNull('paid_at')->whereBetween('created_at', [$mulai, $akhir])->get();

        $pdf = Pdf::loadView('template.pdf.laporan.pendapatan.laporan_pendapatan', [
            'data' => $data,
            'mulai' => $mulai,
            'akhir' => $akhir,
        ]);
        return $pdf->download('laporan_pendapatan.pdf');
    }

    public function piutangView(Request $request){
        $mulai = $request->input('mulai', null);
        $akhir = $request->input('akhir', null);

        $data = HeaderInvoice::latest()->whereNull('paid_at')->whereBetween('created_at', [$mulai, $akhir])->get();

        return view('laporan.piutang', [
            'mulai' => $mulai,
            'akhir' => $akhir,
            'data' => $data
        ]);
    }

    public function piutangPdfDownload(Request $request){
        $mulai = $request->input('mulai', null);
        $akhir = $request->input('akhir', null);

        $data = HeaderInvoice::latest()->whereNull('paid_at')->whereBetween('created_at', [$mulai, $akhir])->get();

        $pdf = Pdf::loadView('template.pdf.laporan.piutang.laporan_piutang', [
            'data' => $data,
            'mulai' => $mulai,
            'akhir' => $akhir,
        ]);
        return $pdf->download('laporan_piutang.pdf');
    }

    public function hutangView(Request $request){
        $mulai = $request->input('mulai', null);
        $akhir = $request->input('akhir', null);

        $data = HeaderPurchase::latest()->whereNull('paid_at')->whereBetween('created_at', [$mulai, $akhir])->get();

        return view('laporan.hutang', [
            'mulai' => $mulai,
            'akhir' => $akhir,
            'data' => $data
        ]);
    }

    public function hutangPdfDownload(Request $request){
        $mulai = $request->input('mulai', null);
        $akhir = $request->input('akhir', null);

        $data = HeaderPurchase::latest()->whereNull('paid_at')->whereBetween('created_at', [$mulai, $akhir])->get();

        $pdf = Pdf::loadView('template.pdf.laporan.hutang.laporan_hutang', [
            'data' => $data,
            'mulai' => $mulai,
            'akhir' => $akhir,
        ]);
        return $pdf->download('laporan_hutang.pdf');
    }

    public function pembelianView(Request $request){
        $mulai = $request->input('mulai', null);
        $akhir = $request->input('akhir', null);

        $data = HeaderPurchase::latest()->whereBetween('created_at', [$mulai, $akhir])->get();

        return view('laporan.pembelian', [
            'mulai' => $mulai,
            'akhir' => $akhir,
            'data' => $data
        ]);
    }

    public function pembelianPdfDownload(Request $request){
        $mulai = $request->input('mulai', null);
        $akhir = $request->input('akhir', null);

        $data = HeaderPurchase::latest()->whereBetween('created_at', [$mulai, $akhir])->get();

        $pdf = Pdf::loadView('template.pdf.laporan.pembelian.laporan_pembelian', [
            'data' => $data,
            'mulai' => $mulai,
            'akhir' => $akhir,
        ]);
        return $pdf->download('laporan_pembelian.pdf');
    }

    public function dividenView(Request $request){
        $mulai = $request->input('mulai', null);
        $akhir = $request->input('akhir', null);

        $data = SharesModel::all();
        $pendapatan = HeaderInvoice::whereBetween('created_at', [$mulai, $akhir])->whereNotNull('paid_at')->get();
        $pengeluaran = HeaderPurchase::whereBetween('created_at', [$mulai, $akhir])->whereNotNull('paid_at')->get();
        $cost = OperationalCost::whereBetween('created_at', [$mulai, $akhir])->get();

        $totalPendapatan = 0;
        $totalPengeluaran = 0;
        $totalCost = 0;
        foreach ($pendapatan as $key => $value) {
            $totalPendapatan += $value->grand_total;
        }
        foreach ($pengeluaran as $key => $value) {
            $totalPengeluaran += $value->grand_total;
        }
        foreach ($cost as $key => $value) {
            $totalCost += $value->total;
        }
        $pendapatanBersih = $totalPendapatan - $totalPengeluaran - $totalCost;

        return view('laporan.dividen', [
            'mulai' => $mulai,
            'akhir' => $akhir,
            'data' => $data,
            'pendapatan' => $totalPendapatan,
            'pengeluaran' => $totalPengeluaran,
            'cost' => $totalCost,
            'bersih' => $pendapatanBersih
        ]);
    }

    public function dividenPdfDownload(Request $request){
        $mulai = $request->input('mulai', null);
        $akhir = $request->input('akhir', null);

        $data = SharesModel::latest()->whereBetween('created_at', [$mulai, $akhir])->get();
        $pendapatan = HeaderInvoice::whereBetween('created_at', [$mulai, $akhir])->whereNotNull('paid_at')->get();
        $pengeluaran = HeaderPurchase::whereBetween('created_at', [$mulai, $akhir])->whereNotNull('paid_at')->get();
        $cost = OperationalCost::whereBetween('created_at', [$mulai, $akhir])->get();

        $totalPendapatan = 0;
        $totalPengeluaran = 0;
        $totalCost = 0;
        foreach ($pendapatan as $key => $value) {
            $totalPendapatan += $value->grand_total;
        }
        foreach ($pengeluaran as $key => $value) {
            $totalPengeluaran += $value->grand_total;
        }
        foreach ($cost as $key => $value) {
            $totalCost += $value->total;
        }
        $pendapatanBersih = $totalPendapatan - $totalPengeluaran - $totalCost;


        $pdf = Pdf::loadView('template.pdf.laporan.dividen.laporan_dividen', [
            'data' => $data,
            'mulai' => $mulai,
            'akhir' => $akhir,
            'pendapatan' => $totalPendapatan,
            'pengeluaran' => $totalPengeluaran,
            'cost' => $totalCost,
            'bersih' => $pendapatanBersih
        ]);
        return $pdf->download('laporan_dividen.pdf');
    }

    public function penjualanView(Request $request){
        $mulai = $request->input('mulai', null);
        $akhir = $request->input('akhir', null);

        $barang = Barang::latest()->get();
        foreach ($barang as $key => $value) {
            $details = DetailInvoice::where('part', $value->part)->whereBetween('created_at', [$mulai, $akhir])->get();

            $value->qty_terjual = 0;
            $value->pendapatan_total = 0;
            $value->list_penjualan = $details;

            foreach ($details as $key => $detail) {
                $value->qty_terjual += $detail->qty;
                $value->pendapatan_total += $detail->subtotal;
            }
        }

        return view('laporan.penjualan', [
            'data' => $barang,
            'mulai' => $mulai,
            'akhir' => $akhir
        ]);
    }

    public function penjualanPdfDownload(Request $request){
        $mulai = $request->input('mulai', null);
        $akhir = $request->input('akhir', null);

        $barang = Barang::latest()->get();
        foreach ($barang as $key => $value) {
            $details = DetailInvoice::where('part', $value->part)->whereBetween('created_at', [$mulai, $akhir])->get();

            $value->qty_terjual = 0;
            $value->pendapatan_total = 0;
            $value->list_penjualan = $details;

            foreach ($details as $key => $detail) {
                $value->qty_terjual += $detail->qty;
                $value->pendapatan_total += $detail->subtotal;
            }
        }

        $pdf = Pdf::loadView('template.pdf.laporan.penjualan.laporan_penjualan', [
            'data' => $barang,
            'mulai' => $mulai,
            'akhir' => $akhir
        ]);
        return $pdf->download('laporan_penjualan.pdf');
    }

    public function labaBersihView(Request $request){
        $mulai = $request->input('mulai', null);
        $akhir = $request->input('akhir', null);

        $data = DFIFO::whereBetween('created_at', [$mulai, $akhir])->get();

        $totalBersih = 0;
        foreach ($data as $key => $value) {
            $totalBersih += $value->profit_total;
            $value->invoice = HeaderInvoice::find($value->hinvoice_id);
        }

        return view('laporan.laba_bersih', [
            'mulai' => $mulai,
            'akhir' => $akhir,
            'data' => $data,
            'total' => $totalBersih
        ]);
    }

    public function labaBersihPdfDownload(Request $request){
        $mulai = $request->input('mulai', null);
        $akhir = $request->input('akhir', null);

        $data = DFIFO::whereBetween('created_at', [$mulai, $akhir])->get();

        $totalBersih = 0;
        foreach ($data as $key => $value) {
            $totalBersih += $value->profit_total;
            $value->invoice = HeaderInvoice::find($value->hinvoice_id);
        }

        $pdf = Pdf::loadView('template.pdf.laporan.lababersih.laporan_laba_bersih', [
            'data' => $data,
            'mulai' => $mulai,
            'akhir' => $akhir,
            'total' => $totalBersih
        ]);
        return $pdf->download('laporan_laba_bersih.pdf');
    }

    public function labaRugiView(Request $request){
        $mulai = $request->input('mulai', null);
        $akhir = $request->input('akhir', null);

        $totalOpsCost = 0;
        $opsCostData = OperationalCost::whereBetween('created_at', [$mulai, $akhir])->get();
        foreach ($opsCostData as $key => $value) {
            $totalOpsCost += $value->total;
        }

        $totalPendapatanKotor = 0;
        $totalPembelian = 0;
        $totalPendapatanBersih = 0;
        $data = DFIFO::whereBetween('created_at', [$mulai, $akhir])->get();
        foreach ($data as $key => $value) {
            $totalPendapatanKotor += $value->harga_jual * $value->qty;
            $totalPendapatanBersih += $value->profit_total;
            $totalPembelian += $value->harga_beli * $value->qty;
        }

        $totalLabaRugi = $totalPendapatanBersih - $totalOpsCost;

        return view('laporan.laba_rugi', [
            'mulai' => $mulai,
            'akhir' => $akhir,
            'data' => $data,
            'totalPendapatanKotor' => $totalPendapatanKotor,
            'totalPendapatanBersih' => $totalPendapatanBersih,
            'totalOperationalCost' => $totalOpsCost,
            'totalPembelian' => $totalPembelian,
            'totalLabaRugi' => $totalLabaRugi
        ]);
    }

    public function labaRugiPdfDownload(Request $request){
        $mulai = $request->input('mulai', null);
        $akhir = $request->input('akhir', null);

        $totalOpsCost = 0;
        $opsCostData = OperationalCost::whereBetween('created_at', [$mulai, $akhir])->get();
        foreach ($opsCostData as $key => $value) {
            $totalOpsCost += $value->total;
        }

        $totalPendapatanKotor = 0;
        $totalPembelian = 0;
        $totalPendapatanBersih = 0;
        $data = DFIFO::whereBetween('created_at', [$mulai, $akhir])->get();
        foreach ($data as $key => $value) {
            $totalPendapatanKotor += $value->harga_jual * $value->qty;
            $totalPendapatanBersih += $value->profit_total;
            $totalPembelian += $value->harga_beli * $value->qty;
        }

        $totalLabaRugi = $totalPendapatanBersih - $totalOpsCost;

        $pdf = Pdf::loadView('template.pdf.laporan.labarugi.laporan_laba_rugi', [
            'mulai' => $mulai,
            'akhir' => $akhir,
            'data' => $data,
            'totalPendapatanKotor' => $totalPendapatanKotor,
            'totalPendapatanBersih' => $totalPendapatanBersih,
            'totalOperationalCost' => $totalOpsCost,
            'totalPembelian' => $totalPembelian,
            'totalLabaRugi' => $totalLabaRugi
        ]);
        return $pdf->download('laporan_laba_rugi.pdf');
    }
}
