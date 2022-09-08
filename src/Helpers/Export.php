<?php
/**
 * Created by PhpStorm.
 * User: MapleSnow
 * Date: 2019/10/17
 * Time: 5:56 PM
 */

namespace MapleSnow\LaravelCore\Helpers;

use Exception;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Sheet;

/**
 * 文件导出类（基于laravel-excel）
 * Class Export
 * @package App\Exports
 */
abstract class Export implements FromQuery, ShouldAutoSize, WithMapping, WithHeadings, WithEvents {
    /**
     * @var array
     */
    const LETTER = [
        'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q',
        'R','S','T','U','V','W','X','Y','Z'
    ];

    public function __construct() {
        $this->globalStyle();
        $this->headerStyle();
    }

    abstract public function query();

    abstract public function map($row): array;

    abstract public function headings(): array;

    /**
     * @return array
     */
    public function registerEvents(): array {
        return [
            AfterSheet::class => $this->afterSheet()
        ];
    }

    /**
     * @return \Closure
     */
    protected function afterSheet() {
        return function(AfterSheet $event) {

            $row = $this->query()->count() + 1;     //总行数
            $columnNum = count($this->headings());    //总列数
            if(0 == $columnNum){
                throw new Exception("Set headers first");
            }
            $start = $this::LETTER[0];
            $end = $this->getColumnIndex($columnNum);

            $globalRange = "{$start}1:{$end}{$row}";
            $event->sheet->globalStyle($globalRange);

            $headerRange = "{$start}1:{$end}1";
            $event->sheet->headerStyle($headerRange);
        };
    }

    /**
     * 获取列的索引号
     * @param int $columnNum 总列数
     * @return mixed|string
     */
    private function getColumnIndex($columnNum) {
        $index = $columnNum -1;
        if($index < 26){
            return $this::LETTER[$index];
        }else{
            $prefix = intval($index / 26) - 1;
            $offset = $index % 26;
            return $this::LETTER[$prefix] . $this::LETTER[$offset];
        }
    }

    /**
     * 定义全局样式
     */
    private function globalStyle() {
        Sheet::macro('globalStyle', function (Sheet $sheet, string $cellRange, array $style = null) {
            $delegate = $sheet->getDelegate();
            // 设置行高
            //$delegate->getDefaultRowDimension()->setRowHeight(22);

            // 设置样式
            is_null($style) && $style = [
                'font' => [
                    'name' => 'Calibri',
                    'size' => 14,
                    'bold' => false
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '808080'
                        ]
                    ]
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,     // 单位格内显示所有文字
                ]
            ];
            $delegate->getStyle($cellRange)->applyFromArray($style);
        });
    }

    /**
     * 定义头部样式
     */
    private function headerStyle() {
        Sheet::macro('headerStyle', function (Sheet $sheet, string $cellRange, array $style = null) {
            // 设置样式
            is_null($style) && $style = [
                'font' => [
                    'size' => 16
                ],
                'fill' => [
                    'fillType' => Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 0,
                    'startColor' => [
                        'rgb' => 'AAAAFF' //初始颜色
                    ],
                    //结束颜色，如果需要单一背景色，请和初始颜色保持一致
                    'endColor' => [
                        'argb' => 'AAAAFF'
                    ]
                ]
            ];
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });
    }
}