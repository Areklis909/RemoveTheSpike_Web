<?php

class FileMover {

    const underscore = '_';
    const dot = '.';
    const rm_command = 'rm ';

    private $target_file_name_full_path;
    private $target_file_name;

    function file_move($where, $tmp_name, $extension) {
        $timestamp = time();
        $this->target_file_name = sha1_file($tmp_name) . self::underscore . $timestamp . self::dot . $extension;
        $this->target_file_name_full_path = $where . $this->target_file_name;
        if (!move_uploaded_file($tmp_name, $this->target_file_name_full_path)) {
            throw new RuntimeException('Failed to move uploaded file.');
        }
    }

    function clean_up() {
        $rm_uploaded_file = self::rm_command . $this->target_file_name_full_path;
        exec($rm_uploaded_file);
    }

    function get_target_file_name() {
        return $this->target_file_name;
    }
    
    function get_target_file_name_full_path() {
        return $this->target_file_name_full_path;
    }

}

?>