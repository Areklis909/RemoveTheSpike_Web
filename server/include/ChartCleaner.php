<?php

class ChartCleaner {

    private $chart_to_remove;

    const chart_path = '../charts/';
    const slash = '/';
    const rm_command = 'rm ';


    function __construct($chart_name) {
        $this->chart_to_remove = realpath(self::chart_path) . self::slash . $chart_name;
    }

    function __destruct() {
        $command = self::rm_command . $this->chart_to_remove;
        exec($command);
    }
}

?>
