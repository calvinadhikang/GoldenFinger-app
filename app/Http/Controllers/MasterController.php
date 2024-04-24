<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\HeaderInvoice;
use App\Models\HeaderPurchase;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function dashboardView(){
        return view('dashboard.dashboard');
    }

    // Dibawah ini adalah function untuk menampilkan view ketika dashboard ditekan!
    public function barangMinimumView(){
        $barangs = Barang::orderBy('created_at', 'desc')->get();
        $data = [];
        foreach ($barangs as $key => $value) {
            if ($value->stok <= $value->batas) {
                $data[] = $value;
            }
        }
        return view('dashboard.details.minimum_barang', [
            'data' => $data
        ]);
    }

    // Dibawah ini adalah function untuk menampilkan view ketika dashboard ditekan!
    public function poUnpaidView(){
        $data = HeaderPurchase::whereNull('paid_at')->get();
        $total = 0;
        foreach ($data as $key => $value) {
            $total += $value->grand_total;
        }
        return view('dashboard.details.po_unpaid', [
            'data' => $data,
            'total' => $total
        ]);
    }

    // Dibawah ini adalah function untuk menampilkan view ketika dashboard ditekan!
    public function invoicePaidView(){
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $data = HeaderInvoice::whereMonth('created_at', '=', $currentMonth)->whereYear('created_at', '=', $currentYear)->whereNotNull('paid_at')->get();
        $total = 0;
        foreach ($data as $invoice) {
            $total += $invoice->grand_total;
        }
        return view('dashboard.details.invoice_paid', [
            'data' => $data,
            'total' => $total
        ]);
    }

    public function invoiceOverdueView(){
        $total_count = 0;
        $now = Carbon::now();
        $data = HeaderInvoice::whereNull('paid_at')->where('jatuh_tempo', '<=', $now)->get();
        foreach ($data as $key => $value) {
            $total_count += $value->grand_total;
        }

        return view('dashboard.details.invoice_overdue', [
            'data' => $data,
            'total' => $total_count
        ]);
    }
}
