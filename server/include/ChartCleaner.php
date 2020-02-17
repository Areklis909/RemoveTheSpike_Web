<?php

class ChartCleaner {

    private $chart_to_remove;

    const chart_path = '../chart/';
    const slash = '/';
    const rm_command = 'rm ';


    function __construct($chart_name) {
        $this->chart_to_remove = realpath(self::chart_path) . self::slash . $chart_name;
        error_log($this->chart_to_remove);
    }

    function __destruct() {
        $command = self::rm_command . $this->chart_to_remove;
        error_log($command);
        exec($command);
    }
}

?>