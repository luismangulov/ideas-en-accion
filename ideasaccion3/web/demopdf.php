<?php
 
function pdfVersion($filename)
{ 
    $fp = @fopen($filename, 'rb');
 
    if (!$fp) {
        return 0;
    }
 
    /* Reset file pointer to the start */
    fseek($fp, 0);
 
    /* Read 20 bytes from the start of the PDF */
    preg_match('/\d\.\d/',fread($fp,20),$match);
 
    fclose($fp);
 
    if (isset($match[0])) {
        return $match[0];
    } else {
        return 0;
    }
} 
 
$version = pdfVersion("D:\CINGARUCA\811.pdf");

 echo $version;