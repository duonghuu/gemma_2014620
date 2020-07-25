<?php

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = new Spreadsheet();
// Set document properties
$spreadsheet->getProperties()->setCreator('Maarten Balliauw')
    ->setLastModifiedBy('Maarten Balliauw')
    ->setTitle('Office 2007 XLSX')
    ->setSubject('Office 2007 XLSX')
    ->setDescription('Office 2007 XLSX, generated using PHP classes.')
    ->setKeywords('office 2007 openxml php')
    ->setCategory('Output file');
$sheet = $spreadsheet->getActiveSheet();
//set styles
$stylemainArray = [
    'font' => [
        'bold' => true,
        'size' => 20,
        'color' => ['argb' => 'FFFFFFFF'],
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FF0000FF',
        ],
    ],

];
$styleheaderArray = [
    'font' => [
        'bold' => true,
        'size' => 14,
        'color' => ['argb' => 'FFFFFFFF'],
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => '996600',
        ],
    ],
    'borders' => [
        'outline' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '00000000'],
        ],
    ],
];
$sheet->getStyle('A1:N1')->applyFromArray($stylemainArray);
$sheet->getStyle('A2:N2')->applyFromArray($styleheaderArray);
foreach(range('A','N') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}
//set data

$sheet->mergeCells('A1:N1')->setCellValue('A1', 'QUẢN LÝ HOẠT ĐỘNG VÀ BÁO CÁO CÔNG TY GEMMA TRAVEL');
$sheet->setCellValue('A2', 'STT');
$sheet->setCellValue('B2', 'HỌ VÀ TÊN');
$sheet->setCellValue('C2', 'EMAIL');
$sheet->setCellValue('D2', 'SỐ ĐIỆN THOẠI');
$sheet->setCellValue('E2', 'ĐỊA CHỈ');
$sheet->setCellValue('F2', 'MEMBER');
$sheet->setCellValue('G2', 'HẠN SỬ DỤNG THẺ');
$sheet->setCellValue('H2', 'GIÁ TRỊ THẺ');
$sheet->setCellValue('I2', 'NHÂN VIÊN KINH DOANH');
$sheet->setCellValue('J2', 'HÌNH THỨC THANH TOÁN');
$sheet->setCellValue('K2', 'NGÀY THANH TOÁN');
$sheet->setCellValue('L2', 'NGƯỜI THU PHÍ');
$sheet->setCellValue('M2', 'TÌNH TRẠNG');
$sheet->setCellValue('N2', 'GHI CHÚ');


//set output
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="quanlykhachhang.xlsx"');
header('Cache-Control: max-age=0');
$writer->save("php://output");
exit;