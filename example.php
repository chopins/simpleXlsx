<?php

//use Toknot\SimpleXlsx\SimpleXlsx;
//include_once '../toknot/vendor/toknot/Toknot/Share/File.php';
//include_once '../toknot/vendor/toknot/Toknot/Share/Generator.php';
//include_once '../toknot/vendor/toknot/Toknot/Share/SimpleXlsx/SimpleXlsxBak.php';


include_once '../path/src/File.php';
include_once './src/SimpleXlsx.php';
include_once './src/Xlsx/Xlsx.php';
include_once './src/Xlsx/Shared.php';
include_once './src/Xlsx/Sheet.php';


$s = new Toknot\SimpleXlsx\SimpleXlsx();
//$xlsx = $s->createXlsx('./test.xlsx');
//$sheet = $xlsx->newSheet('test');
//for ($i = 0; $i < 1000; $i++) {
//     $row = range(1, 100);
//     $sheet->addRow($row);
//}
//$xlsx->save();


$xlsx = $s->loadXlsx('./example.xlsx');
$sheetList = $xlsx->getSheetList();
$sheet = $xlsx->getSheet(1);
while($r = $sheet->readRow()) {
    print_r($r);
}