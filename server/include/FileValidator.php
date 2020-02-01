<?php

class FileValidator {
    
    const extension_array = array(
        'mp3',
        'wav'
    );

    const no_file_sent_str = 'No file sent.';
    const ini_size_problem_str = 'INI size problem. ';
    const exceeded_filesize_str = 'Exceeded filesize limit: ';
    const unknown_error_str = 'Unknown errors.';

    const max_file_size = 10240000;

    private $ext;

    function __construct() {}
    function __destruct() {}

    function get_extension() {
        return $this->ext;
    }

    function is_extension_valid($filename) {
        $this->ext = pathinfo($filename, PATHINFO_EXTENSION);
        $valid_extension = false;
        foreach(self::extension_array as $extension) {
            $valid_extension = array_search($this->ext, self::extension_array);
            if($valid_extension == true) {
                break;
            }
        }

        if($valid_extension == false) {
            throw new RuntimeException('Invalid extension.');
        }
    }

    function parse_errors($errors) {
        if (!isset($errors) || is_array($errors)) {
            throw new RuntimeException('Invalid parameters.');
        }
    
        // Check $_FILES['upfile']['error'] value.
        switch ($errors) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException(self::no_file_sent_str);
            case UPLOAD_ERR_INI_SIZE:
                throw new RuntimeException(self::ini_size_problem_str);
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException(self::exceeded_filesize_str);
            default:
                throw new RuntimeException(self::unknown_error_str);
        }   
    }

    function check_file_size($file_size) {
        if($file_size > self::max_file_size) {
            throw new RuntimeException('Exceeded filesize limit.');
        }
    }

}



?>