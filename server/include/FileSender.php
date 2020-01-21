<?php


class FileSender {
    
    function file_send($file_full_path) {
        if (file_exists($file_full_path)) {
            header("Cache-Control: private");
            header("Content-type: audio/mpeg3");
            header("Content-Transfer-Encoding: binary");
            header("Content-disposition: attachment; filename=\"" . basename($file_full_path)."\"");
            header('Content-Length: ' . filesize($file_full_path));
            readfile($file_full_path);
        } else {
            throw new RuntimeException('Requested file does not exist!');
        }
    }
}

?>