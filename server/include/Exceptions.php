<?php

class WrongFormatException extends Exception {
    function __construct() {
        $this->code = 415;
    }
}

class FileSizeIncorrectException extends Exception {
    function __construct() {
        $this->code = 400;
    }
}

class InternalErrorException extends Exception {
    function __construct() {
        $this->code = 500;
    }
}

?>