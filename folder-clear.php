<?php
$dir = "temp/"; // directory name



foreach (scandir($dir) as $item) {
    if ($item == '.' || $item == '..')
        continue;

        unlink($dir.DIRECTORY_SEPARATOR.$item);
        echo "All files deleted";
    }   
//rmdir($dir);

?>