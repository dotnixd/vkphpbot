<?php

require_once "./library/hash.php";

function download(string $url, string $ext) : string {
    $filename = generateHash(40) . ".$ext";

    $ch = curl_init ($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    $raw = curl_exec($ch);
    curl_close ($ch);

    if(file_exists($filename)){
        unlink($filename);
    }

    $fp = fopen($filename, 'x');
    fwrite($fp, $raw);
    fclose($fp);

    return $filename;
}

?>