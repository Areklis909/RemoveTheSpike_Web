<?php
$file_full_path = '../img/header_background.png';
if (file_exists($file_full_path)) {
    header("Cache-Control: private");
    header("Content-type: image/png");
    header("Content-Transfer-Encoding: binary");
    header("Content-disposition: attachment; filename=\"" . basename($file_full_path)."\"");
    header('Content-Length: ' . filesize($file_full_path));
    readfile($file_full_path);
} else {
    throw new RuntimeException('Requested file does not exist!');
}

?>