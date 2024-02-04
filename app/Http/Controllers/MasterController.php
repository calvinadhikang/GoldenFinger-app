<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\HeaderInvoice;
use App\Models\HeaderPurchase;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    //
    public function dashboardView(){
        return view('dashboard.dashboard');
    }

    public function barangMinimumView(){
        $data = Barang::where('stok', '<=', 'batas')->orderBy('created_at', 'desc')->get();
        return view('dashboard.details.minimum_barang', [
            'data' => $data
        ]);
    }

    public function poUnpaidView(){
        $data = HeaderPurchase::where('status_pembayaran', 0)->get();
        $total = 0;
        foreach ($data as $key => $value) {
            $total += $value->grand_total;
        }
        return view('dashboard.details.po_unpaid', [
            'data' => $data,
            'total' => $total
        ]);
    }

    public function invoicePaidView(){
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $data = HeaderInvoice::whereMonth('created_at', '=', $currentMonth)->whereYear('created_at', '=', $currentYear)->where('status', 1)->get();
        $total = 0;
        foreach ($data as $invoice) {
            $total += $invoice->grand_total;
        }
        return view('dashboard.details.invoice_paid', [
            'data' => $data,
            'total' => $total
        ]);
    }
}
