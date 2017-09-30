

### 中文乱码

```
if you want make UTF-8 file for excel, use this:

$fp = fopen($filename, 'w');
//add BOM to fix UTF-8 in Excel
fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
```
