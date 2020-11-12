<?php
header("Content-Encoding: none\r\n");
header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zipname);
header('Content-Length: ' . $size);

set_time_limit(0); // never timeout this script
$file = @fopen($zipname,"rb");
while(!feof($file))
{
    print(@fread($file, 1024*8));
    ob_flush();
    flush();
}
fclose($file);
ob_flush();
flush();
?>