<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
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
        // Set narrow margins
        $sheet->getPageSetup()->setFitToWidth(1); // Set Fit-to-Width to 1 page
        $sheet->getPageMargins()->setTop(0.25); // Set top margin to 0.25 inches
        $sheet->getPageMargins()->setRight(0.25); // Set right margin to 0.25 inches
        $sheet->getPageMargins()->setBottom(0.25); // Set bottom margin to 0.25 inches
        $sheet->getPageMargins()->setLeft(0.25); // Set left margin to 0.25 inches

        //set Table Size
        $sheet->getColumnDimension("A")->setWidth(9);
        $sheet->getColumnDimension("B")->setWidth(27);
        $sheet->getColumnDimension("C")->setWidth(9);
        $sheet->getColumnDimension("D")->setWidth(6);
        $sheet->getColumnDimension("E")->setWidth(6);
        $sheet->getColumnDimension("F")->setWidth(9);
        $sheet->getColumnDimension("G")->setWidth(26);

        // Header Text
        $sheet->getStyle('A1:F1')->getFont()->setSize(14)->setBold(true);
        $sheet->getStyle('A2:F2')->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A3:F3')->getFont()->setSize(9)->setBold(true);

        // Surat Jalan Text
        $sheet->getStyle('F4')->getFont()->setSize(14)->setBold(true);
        $sheet->getStyle('A4:G4')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_DOUBLE);

        // Header Surat Text
        $sheet->getStyle('A5:G9')->getFont()->setBold(true);

        //table item count
        $tableItemCount = count($this->invoice->details);
        // Header Table Border
        $tableHeaderStart = 11;
        $tableItemStart = $tableHeaderStart + 1;
        $tableItemEnd = $tableHeaderStart + $tableItemCount;
        $sheet->getStyle("A$tableHeaderStart:G$tableHeaderStart")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        // Table Detail
        $sheet->getStyle("D$tableHeaderStart:E$tableItemEnd")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A$tableHeaderStart:G$tableItemEnd")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        // Table Keterangan Merge
        $sheet->mergeCells("F$tableItemStart:G$tableItemEnd");

        // Table Footer
        $footerLenght = 5;
        $footerStart = $tableItemEnd + 1;
        $footerEnd = $footerStart + $footerLenght - 1;
        $sheet->getStyle("A$footerStart:G$footerEnd")->getAlignment()->setWrapText(true);
        // set Footer Height Dimension

        //left footer
        $sheet->getStyle("A$footerStart:C$footerEnd")->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("A$footerStart:C$footerEnd")->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("D$footerStart:G$footerEnd")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
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
