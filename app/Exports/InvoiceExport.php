<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvoiceExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $invoice;
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    public function styles(Worksheet $sheet)
    {
        // Header Text
        $headerTextCell = 'A1:F3';
        $sheet->getStyle($headerTextCell)->getFont()->setSize(12)->setBold(true);

        // Calculate the width for A4 page size (adjust as needed)
        $a4Width = PageSetup::PAPERSIZE_A4;
        $defaultColumnWidth = 8.43; // Adjust this based on your default column width
        $numColumns = 6; // Adjust this based on the number of columns in the merged range
        $width = ($a4Width - $defaultColumnWidth * $numColumns) / $numColumns;

        // Set the width for the merged cell range
        $sheet->getColumnDimension('A')->setWidth($width);
        $sheet->getColumnDimension('B')->setWidth($width);
        $sheet->getColumnDimension('C')->setWidth($width);
        $sheet->getColumnDimension('D')->setWidth($width);
        $sheet->getColumnDimension('E')->setWidth($width);
        $sheet->getColumnDimension('F')->setWidth($width);

        // Invoice Text
        $invoiceTextCell = 'A4:F4';
        $sheet->mergeCells($invoiceTextCell);
        $sheet->getStyle($invoiceTextCell)->getAlignment()->setIndent(2)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($invoiceTextCell)->getFont()->setSize(14)->setBold(true);

        // Make Table
        $detailsCount = count($this->invoice->details);
        $tableEndRange = 8 + 3 + $detailsCount;
        $cellRange = "A8:F$tableEndRange";
        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getColumnDimension('B')->setWidth(35);
        $sheet->getColumnDimension('B')->setAutoSize(false);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('C')->setAutoSize(false);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('D')->setAutoSize(false);
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('A')->setAutoSize(false);

        // Table Footer
        $footerStart = $tableEndRange - 2;
        $footerEnd = $tableEndRange;
        $footerRange = "E$footerStart:F$footerEnd";
        $footerRangeText = "A$footerStart:D$footerEnd";
        // Clear existing borders
        $sheet->getStyle($footerRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_NONE);
        // Apply an outside border
        $sheet->getStyle($footerRange)->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($footerRange)->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($footerRange)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($footerRange)->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
        // Center Table Footer
        $sheet->getStyle($footerRangeText)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        //Perhatian
        $perhatianStart = $tableEndRange + 1;
        $perhatianRange = "A$perhatianStart";
        $sheet->getStyle($perhatianRange)->getAlignment()->setIndent(2)->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle($perhatianRange)->getFont()->setSize(10)->setBold(true);

        // Merge Rekening
        $rekeningStart = $tableEndRange + 3;
        $rekeningRange = "A$rekeningStart:B$rekeningStart";
        $sheet->mergeCells($rekeningRange);
        $sheet->getStyle($rekeningRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Border Rekening Group
        $rekeningGroupStart = $perhatianStart + 1;
        $rekeningGroupEnd = $rekeningGroupStart + 2;
        $rekeningGroupRange = "A$rekeningGroupStart:B$rekeningGroupEnd";
        $sheet->getStyle($rekeningGroupRange)->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($rekeningGroupRange)->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($rekeningGroupRange)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($rekeningGroupRange)->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);

    }

    public function view(): View
    {
        return view('template.export.dokumen.invoice', [
            'invoice' => $this->invoice,
        ]);
    }
}
