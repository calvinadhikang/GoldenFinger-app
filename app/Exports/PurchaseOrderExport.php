<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PurchaseOrderExport implements FromView, WithStyles
{
    protected $invoice;
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    public function view(): View
    {
        return view();
    }

    public function styles(Worksheet $sheet)
    {
        //set Table Size
        $sheet->getColumnDimension("A")->setWidth(3);
        $sheet->getColumnDimension("B")->setWidth(12);
        $sheet->getColumnDimension("C")->setWidth(10);
        $sheet->getColumnDimension("D")->setWidth(3);
        $sheet->getColumnDimension("E")->setWidth(6);
        $sheet->getColumnDimension("F")->setWidth(6);
        $sheet->getColumnDimension("G")->setWidth(8);
        $sheet->getColumnDimension("H")->setWidth(11);
        $sheet->getColumnDimension("I")->setWidth(9);
        $sheet->getColumnDimension("J")->setWidth(20);

        // Header Text
        $sheet->getStyle('A1:J1')->getFont()->setSize(14)->setBold(true);
        $sheet->getStyle('A2:J2')->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A3:J3')->getFont()->setSize(9)->setBold(true);
    }
}
