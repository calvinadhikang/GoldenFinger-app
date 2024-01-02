<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PurchaseOrderExport implements FromView, WithStyles
{
    protected $po;
    public function __construct($po)
    {
        $this->po = $po;
    }

    public function view(): View
    {
        return view('template.export.dokumen.purchase_order', [
            'po' => $this->po
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Set narrow margins
        $sheet->getPageSetup()->setFitToWidth(1); // Set Fit-to-Width to 1 page
        $sheet->getPageMargins()->setTop(0.25); // Set top margin to 0.25 inches
        $sheet->getPageMargins()->setRight(0.25); // Set right margin to 0.25 inches
        $sheet->getPageMargins()->setBottom(0.25); // Set bottom margin to 0.25 inches
        $sheet->getPageMargins()->setLeft(0.25); // Set left margin to 0.25 inches

        //set Table Size
        $sheet->getColumnDimension("A")->setWidth(5);
        $sheet->getColumnDimension("B")->setWidth(12);
        $sheet->getColumnDimension("C")->setWidth(10);
        $sheet->getColumnDimension("D")->setWidth(3);
        $sheet->getColumnDimension("E")->setWidth(6);
        $sheet->getColumnDimension("F")->setWidth(6);
        $sheet->getColumnDimension("G")->setWidth(18);
        $sheet->getColumnDimension("H")->setWidth(18);
        $sheet->getColumnDimension("I")->setWidth(9);
        $sheet->getColumnDimension("J")->setWidth(20);

        // Header Text
        $sheet->getStyle('A1:J1')->getFont()->setSize(14)->setBold(true);
        $sheet->getStyle('A2:J2')->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A3:J3')->getFont()->setSize(9)->setBold(true);

        $tableItemCount = count($this->po->details);
        $tableHeaderStart = 16;
        $tableHeaderEnd = $tableHeaderStart + 1;
        $tableItemStart = $tableHeaderEnd + 1;
        $tableItemEnd = $tableItemStart + $tableItemCount - 1;

        $sheet->getStyle("A$tableHeaderStart:J$tableHeaderEnd")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        //Table Item Aligment
        $sheet->getStyle("A$tableItemStart:A$tableItemEnd")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("E$tableItemStart:F$tableItemEnd")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("G$tableItemStart:J$tableItemEnd")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        //Table Footer Aligment
        $tableFooterStart = $tableItemEnd + 1;
        $tableFooterStart1 = $tableFooterStart + 1;
        $tableFooterStart2 = $tableFooterStart1 + 1;
        $sheet->getStyle("A$tableFooterStart:H$tableFooterStart")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("I$tableFooterStart:J$tableFooterStart")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle("A$tableFooterStart1:H$tableFooterStart1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("I$tableFooterStart1:J$tableFooterStart1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle("A$tableFooterStart2:H$tableFooterStart2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("I$tableFooterStart2:J$tableFooterStart2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    }
}
