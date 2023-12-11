<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuratJalanExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $invoice;
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    public function styles(Worksheet $sheet)
    {
        //Header Dokumen
        $headerTextCell = 'A1:E3';
        $sheet->getStyle($headerTextCell)->getFont()->setSize(12)->setBold(true);

        // Title 'SURAT JALAN'
        $titleRange = "D4:E4";
        $sheet->getStyle($titleRange)->getFont()->setSize(15)->setBold(true);
        $sheet->getRowDimension(4)->setRowHeight(20);

        //Table Header
        $headerRange = "A11:E11";
        $sheet->getStyle($headerRange)->getFont()->setSize(13)->setBold(true);

        //set Table Size
        $sheet->getColumnDimension("A")->setAutoSize(false);
        $sheet->getColumnDimension("A")->setWidth(30);
        $sheet->getColumnDimension("D")->setAutoSize(false);
        $sheet->getColumnDimension("D")->setWidth(30);
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
