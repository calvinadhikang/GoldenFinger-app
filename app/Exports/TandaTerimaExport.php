<?php

namespace App\Exports;

use App\Models\HeaderInvoice;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TandaTerimaExport implements FromView, ShouldAutoSize, WithStyles
{

    protected $invoice;
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
        $sheet->getStyle('4')->getFont()->setBold(true);
        $sheet->getStyle('4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('12')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('6')->getFont()->setBold(true);
        $sheet->getStyle('A6:E6')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A7:E7')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A8:E8')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);


        //supaya cell A, bagian table Nomor tidak terlalu lebar
        $sheet->getColumnDimension('A')->setWidth(5);

        $TopSideBorderStyle = [
            'borders' => [
                'top' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ]
        ];
        $BottomSideBorderStyle = [
            'borders' => [
                'bottom' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ]
        ];
        $SideBorderStyle = [
            'borders' => [
                'right' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ]
        ];
        $sheet->mergeCells('A10:C10');
        $sheet->mergeCells('A11:C11');
        $sheet->mergeCells('A12:C12');
        $sheet->getStyle('A10:C10')->applyFromArray($TopSideBorderStyle);
        $sheet->getStyle('A11:C11')->applyFromArray($SideBorderStyle);
        $sheet->getStyle('A12:C12')->applyFromArray($BottomSideBorderStyle);

        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
        ];
    }

    public function view(): View
    {
        $date = Carbon::now();
        return view('template.export.dokumen.tanda_terima', [
            'invoice' => $this->invoice,
            'date' => $date
        ]);
    }
}
