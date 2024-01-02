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

class InvoiceExport implements FromView, WithStyles
{
    protected $invoice;
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    public function styles(Worksheet $sheet)
    {
        // Set narrow margins
        $sheet->getPageSetup()->setFitToWidth(1); // Set Fit-to-Width to 1 page
        $sheet->getPageMargins()->setTop(0.25); // Set top margin to 0.25 inches
        $sheet->getPageMargins()->setRight(0.25); // Set right margin to 0.25 inches
        $sheet->getPageMargins()->setBottom(0.25); // Set bottom margin to 0.25 inches
        $sheet->getPageMargins()->setLeft(0.25); // Set left margin to 0.25 inches

        // SET WIDTH
        $sheet->getColumnDimension('A')->setWidth(2.71);
        $sheet->getColumnDimension('B')->setWidth(4);
        $sheet->getColumnDimension('C')->setWidth(9);
        $sheet->getColumnDimension('D')->setWidth(34.57);
        $sheet->getColumnDimension('E')->setWidth(8.86);
        $sheet->getColumnDimension('F')->setWidth(8.86);
        $sheet->getColumnDimension('G')->setWidth(14.71);
        $sheet->getColumnDimension('H')->setWidth(16.14);
        $sheet->getColumnDimension('I')->setWidth(0.92);

        // Header Text
        $sheet->getStyle('A1:F1')->getFont()->setSize(14)->setBold(true);
        $sheet->getStyle('A2:F2')->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A3:F3')->getFont()->setSize(9)->setBold(true);


        // Invoice Text
        $invoiceTextCell = "D4";
        $sheet->getStyle($invoiceTextCell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($invoiceTextCell)->getFont()->setSize(11)->setBold(true);

        // Detail Table
        $detailsCount = count($this->invoice->details);
        $tableEndRange = 8 + $detailsCount;
        $cellRange = "B8:H$tableEndRange";
        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $numberCell = "G9:H$tableEndRange";
        $sheet->getStyle($numberCell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $qtyCell = "E8:F$tableEndRange";
        $sheet->getStyle($qtyCell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $noCell = "B8:B$tableEndRange";
        $sheet->getStyle($noCell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Table Footer
        $footerStart = $tableEndRange + 1;
        $footerEnd = $tableEndRange + 3;
        // Footer Number
        for ($i= $footerStart; $i <= $footerEnd ; $i++) {
            //number range
            $numberRange = "G$i:H$i";
            $sheet->getStyle($numberRange)->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle($numberRange)->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle($numberRange)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle($numberRange)->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle("H$i")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            //text range
            $textRange = "B$i:F$i";
            $sheet->getStyle($textRange)->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle($textRange)->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle($textRange)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle($textRange)->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle($textRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Center Hormat Kami
        $hormatKamiRow = $footerEnd + 1;
        $hormatKamiRange = "H$hormatKamiRow";
        $sheet->getStyle($hormatKamiRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Center Nadia
        $nadiaRow = $hormatKamiRow + 4;
        $nadiaRange = "H$nadiaRow";
        $sheet->getStyle($nadiaRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($nadiaRange)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

        // Penerima Border
        $penerimaRange = "F$nadiaRow";
        $sheet->getStyle($penerimaRange)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

        //Perhatian
        $perhatianStart = $footerEnd + 1;
        $perhatianRange = "B$perhatianStart";
        $sheet->getStyle($perhatianRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle($perhatianRange)->getFont()->setSize(8)->setBold(true);
        $sheet->getRowDimension($footerEnd + 1)->setRowHeight(20);

        // Merge Rekening
        $rekeningStart = $perhatianStart + 1;
        $rekeningEnd = $rekeningStart + 3;
        $rekeningRange = "B$rekeningStart:D$rekeningEnd";
        $sheet->getStyle($rekeningRange)->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($rekeningRange)->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($rekeningRange)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($rekeningRange)->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
    }

    public function view(): View
    {
        return view('template.export.dokumen.invoice', [
            'invoice' => $this->invoice,
        ]);
    }
}
