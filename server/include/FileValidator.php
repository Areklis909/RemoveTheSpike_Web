<?php

include('include/Exceptions.php');

class FileValidator {
    
    const extension_array = array(
        'flac',
        'wav',
        'ogg'
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
        $valid_extension = array_search($this->ext, self::extension_array);
        if($valid_extension === false || is_null($valid_extension)) {
            throw new WrongFormatException('Invalid extension.');
        }
    }

    function parse_errors($errors) {
        if (!isset($errors) || is_array($errors)) {
            throw new InternalErrorException('Invalid parameters.');
        }
    
        // Check $_FILES['upfile']['error'] value.
        switch ($errors) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new FileSizeIncorrectException(self::no_file_sent_str);
            case UPLOAD_ERR_INI_SIZE:
                throw new FileSizeIncorrectException(self::ini_size_problem_str);
            case UPLOAD_ERR_FORM_SIZE:
                throw new FileSizeIncorrectException(self::exceeded_filesize_str);
            default:
                echo 'gunwo';
                throw new InternalErrorException(self::unknown_error_str);
        }   
    }

    function check_file_size($file_size) {
        if($file_size > self::max_file_size) {
            throw new FileSizeIncorrectException('Exceeded filesize limit.');
        }
    }

}



?>