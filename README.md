# simpleXlsx
a simple xlsx file opreate lib

# Usage
Open Xlsx file

```php
    $s = new SimpleXlsx();
     $xlsx = $s->createXlsx('/your_file_save_path/test.xlsx');
    $sheet = $xlsx->newSheet('test');
     for ($i = 0; $i < 1000; $i++) {
          $row = range(1, 100);
          $sheet->addRow($row);
     }
     $xlsx->save();

     $xlsx = $s->loadXlsx('your_file_save_path/test.xlsx');
     $sheetList = $xlsx->getSheetList();
     $sheet = $xlsx->getSheet(1);
     while($r = $sheet->readRow()) {

     }
```
