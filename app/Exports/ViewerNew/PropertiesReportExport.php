<?php

namespace App\Exports\ViewerNew;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PropertiesReportExport extends StringValueBinder implements FromArray, ShouldAutoSize, WithCustomValueBinder, WithEvents, WithTitle
{
    private const HEADER_ROW = 5;

    /**
     * @param  array<int, array{key: string, header: string}>  $columns
     * @param  array<int, array<int, string>>  $rows
     */
    public function __construct(
        private readonly array $columns,
        private readonly array $rows,
        private readonly Carbon $generatedAt,
    ) {}

    public function array(): array
    {
        $columnCount = count($this->columns);
        $metadataWidth = max(1, $columnCount);
        $blankMetadataCells = array_fill(1, max(0, $metadataWidth - 1), '');

        return [
            array_merge(['تقرير العقارات'], $blankMetadataCells),
            array_merge(['تاريخ الإنشاء: '.$this->generatedAt->format('Y-m-d H:i')], $blankMetadataCells),
            array_merge(['عدد الصفوف: '.count($this->rows)], $blankMetadataCells),
            array_fill(0, $metadataWidth, ''),
            array_map(fn (array $column): string => $column['header'], $this->columns),
            ...$this->rows,
        ];
    }

    public function title(): string
    {
        return 'تقرير العقارات';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event): void {
                $sheet = $event->sheet->getDelegate();
                $columnCount = max(1, count($this->columns));
                $rowCount = count($this->rows);
                $lastColumn = Coordinate::stringFromColumnIndex($columnCount);
                $lastRow = self::HEADER_ROW + $rowCount;
                $fullRange = "A1:{$lastColumn}{$lastRow}";
                $headerRange = "A".self::HEADER_ROW.":{$lastColumn}".self::HEADER_ROW;
                $dataRange = "A".self::HEADER_ROW.":{$lastColumn}{$lastRow}";
                $bodyRange = $rowCount > 0 ? 'A'.(self::HEADER_ROW + 1).":{$lastColumn}{$lastRow}" : null;

                $sheet->setRightToLeft(true);
                $sheet->freezePane('A'.(self::HEADER_ROW + 1));
                $sheet->setAutoFilter($dataRange);
                $sheet->getDefaultRowDimension()->setRowHeight(24);

                $sheet->mergeCells("A1:{$lastColumn}1");
                $sheet->mergeCells("A2:{$lastColumn}2");
                $sheet->mergeCells("A3:{$lastColumn}3");

                $sheet->getStyle($fullRange)->getFont()->setName('Arial');
                $sheet->getStyle($fullRange)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $sheet->getStyle($fullRange)->getAlignment()
                    ->setReadingOrder(Alignment::READORDER_RTL)
                    ->setVertical(Alignment::VERTICAL_CENTER)
                    ->setWrapText(true);

                $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1F2937']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F8E7B0']],
                ]);

                $sheet->getStyle("A2:{$lastColumn}3")->applyFromArray([
                    'font' => ['size' => 11, 'color' => ['rgb' => '4B5563']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFBEB']],
                ]);

                $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '7C5A12']],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'D6B85A']],
                    ],
                ]);
                $sheet->getRowDimension(self::HEADER_ROW)->setRowHeight(30);

                if ($bodyRange !== null) {
                    $sheet->getStyle($bodyRange)->applyFromArray([
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_RIGHT,
                            'vertical' => Alignment::VERTICAL_CENTER,
                            'wrapText' => true,
                        ],
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']],
                        ],
                    ]);

                    for ($row = self::HEADER_ROW + 1; $row <= $lastRow; $row++) {
                        if (($row - self::HEADER_ROW) % 2 === 0) {
                            $sheet->getStyle("A{$row}:{$lastColumn}{$row}")->getFill()
                                ->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()->setRGB('FFF8E1');
                        }
                    }
                }
            },
        ];
    }
}
