<?php

class Logger {

    const file_mode = 'w';
    const new_line = "\n";

    private $log_name;
    private $log_fd;

    function __construct($logname) {
        $this->log_name = $logname;
        $this->$log_fd = fopen($this->$log_name, self::file_mode);
    }

    function __destruct() {
        fclose($this->$log_fd);
    }

    function log($msg) {
        fwrite($this->$log_fd, msg);
        fwrite($this->$log_fd, self::new_line);
    }
}


?>