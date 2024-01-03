<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
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
        $sheet->getColumnDimension("G")->setWidth(11);
        $sheet->getColumnDimension("H")->setWidth(11);
        $sheet->getColumnDimension("I")->setWidth(9);
        $sheet->getColumnDimension("J")->setWidth(25);

        // Header Text
        $sheet->getStyle('A1:J1')->getFont()->setSize(14)->setBold(true);
        $sheet->getStyle('A2:J2')->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A3:J3')->getFont()->setSize(9)->setBold(true);

        // Title Text
        $sheet->mergeCells('A5:J5');
        $sheet->getStyle('A5:J5')->getFont()->setSize(16);
        $sheet->getStyle('A5:J5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('A6:J6');
        $sheet->getStyle('A6:J6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $tableItemCount = count($this->po->details);
        $tableHeaderStart = 16;
        $tableHeaderEnd = $tableHeaderStart + 1;
        $tableItemStart = $tableHeaderEnd + 1;
        $tableItemEnd = $tableItemStart + $tableItemCount - 1;

        $sheet->getStyle("A$tableHeaderStart:J$tableHeaderEnd")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A$tableHeaderStart:J$tableHeaderEnd")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        //Table Item Aligment
        $sheet->getStyle("A$tableItemStart:A$tableItemEnd")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("E$tableItemStart:F$tableItemEnd")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("G$tableItemStart:J$tableItemEnd")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("A$tableItemStart:J$tableItemEnd")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

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

        $sheet->getStyle("I$tableFooterStart:I$tableFooterStart2")->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("I$tableFooterStart:J$tableFooterStart")->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("J$tableFooterStart:J$tableFooterStart2")->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("I$tableFooterStart2:J$tableFooterStart2")->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("I$tableFooterStart:J$tableFooterStart")->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("I$tableFooterStart1:J$tableFooterStart1")->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

        //Instrcution
        $instructionStart = $tableItemEnd + 4;
        $instructionStart1 = $instructionStart + 1;
        $instructionEnd = $instructionStart + 3;
        $sheet->getStyle("A$instructionStart:J$instructionStart")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A$instructionStart1:A$instructionEnd")->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("A$instructionStart1:J$instructionStart1")->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("J$instructionStart1:J$instructionEnd")->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("A$instructionEnd:J$instructionEnd")->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);


        //Approval
        $approvalStart = $tableItemEnd + 9;
        $approvalEnd = $approvalStart + 3;
        $sheet->getStyle("A$approvalStart:J$approvalEnd")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A$approvalStart:J$approvalEnd")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Set Background Color
        $orangeColor = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFA500']
            ]
        ];
        $sheet->getStyle("A8:G8")->applyFromArray($orangeColor);
        $sheet->getStyle("I8:J8")->applyFromArray($orangeColor);
        $sheet->getStyle("A16:J17")->applyFromArray($orangeColor);
        $sheet->getStyle("A$instructionStart:J$instructionStart")->applyFromArray($orangeColor);
        $sheet->getStyle("A$approvalStart:J$approvalStart")->applyFromArray($orangeColor);
    }
}
