<?php

class FileMover {

    const underscore = '_';
    const dot = '.';

    function file_move($where, $tmp_name, $extension) {
        $timestamp = time();
        $target_filename = $where . sha1_file($tmp_name) . self::underscore . $timestamp . self::dot . $extension;
        if (!move_uploaded_file($tmp_name, $target_filename)) {
            throw new RuntimeException('Failed to move uploaded file.');
        }
    }

}

?>