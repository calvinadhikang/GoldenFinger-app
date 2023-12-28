<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuratJalanExport implements FromView, WithStyles
{
    protected $invoice;
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    public function styles(Worksheet $sheet)
    {
        //set Table Size
        $sheet->getColumnDimension("A")->setWidth(9);
        $sheet->getColumnDimension("B")->setWidth(27);
        $sheet->getColumnDimension("C")->setWidth(9);
        $sheet->getColumnDimension("D")->setWidth(6);
        $sheet->getColumnDimension("E")->setWidth(6);
        $sheet->getColumnDimension("F")->setWidth(9);
        $sheet->getColumnDimension("G")->setWidth(21);

        // Header Text
        $sheet->getStyle('A1:F1')->getFont()->setSize(14)->setBold(true);
        $sheet->getStyle('A2:F2')->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A3:F3')->getFont()->setSize(9)->setBold(true);

        // Surat Jalan Text
        $sheet->getStyle('F4')->getFont()->setSize(14)->setBold(true);

        // Header Surat Text
        $sheet->getStyle('A5:G9')->getFont()->setBold(true);
    }

    public function view(): View
    {
        $date = Carbon::now();
        return view('template.export.dokumen.surat_jalan', [
            'invoice' => $this->invoice,
            'date' => $date
        ]);
    }
}
