<?php
// 削除したいファイルのパス
$tmpDir = __DIR__ . '/../tmp';
$files = scandir($tmpDir);
$FILE_LIMIT_SEC = 20;

foreach($files as $file) {

    if ($file === '.' || $file === '..') {
        continue;
    }

    $filepath = $tmpDir . '/' . $file;
    if (file_exists($filepath)) {

        $filetime = filemtime($filepath);
        if ((time() - $filetime) >= $FILE_LIMIT_SEC) {
            unlink($filepath);
        }
    }

}
