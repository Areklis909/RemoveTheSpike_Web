<?php

class FileProcessor {
    const max_check_repetitions = 100;
    const pid_path = '../pids/';
    const pid_ending = '.pid';
    const log_path = '../logs/';
    const log_ending = '.log';
    const binary_path = 'bin/removeTheSpike';
    const rm_command = 'rm ';
    const slash = '/';
    const process_all_samples = -1;

    private $file_full_path;
    private $file_name;
    private $output_full_path;
    private $log_file;
    private $pid_file;

    function __construct($file_to_process_full_path, $processed_file_destination) {
        $this->output_full_path = $processed_file_destination;
        $this->file_full_path = $file_to_process_full_path;
        $this->file_name = basename($this->file_full_path);
    }

    function __destruct() {
        // $this->clean_up();
    }

    function remove_the_spike() {
        $this->log_file = realpath(self::log_path) . self::slash . $this->file_name . self::log_ending;
        $this->pid_file = realpath(self::pid_path) . self::slash . $this->file_name . self::pid_ending;
        $command = sprintf('%s --signalLength %s --filename %s --outputFile %s > %s & echo $! > %s',
        self::binary_path, self::process_all_samples, $this->file_full_path, $this->output_full_path . $this->file_name, 
        $this->log_file, $this->pid_file);
        exec($command);
    }

    function read_pid() {
        $pidfile_fd = fopen($this->pid_file, 'r');
        $pid = fread($pidfile_fd, filesize($this->pid_file));
        fclose($pidfile_fd);
        return $pid;
    }

    function wait_for_process_to_end($pid) {
        try {
            $repetition = 0;
            do {
                $result = shell_exec(sprintf('ps %d', $pid));
                $condition = count(preg_split('/\n/', $result)) > 2;
                $repetition = $repetition + 1;
                sleep(1);
            } while($condition == true && $repetition < self::max_check_repetitions);
        } catch(Exception $e) {
            echo 'Expetion occured';
        }
    }

    function clean_up() {
        $remove_processed_file = self::rm_command . $this->get_output_file_full_path();
        exec($remove_processed_file);
        
        $remove_pidfile = self::rm_command . $this->pid_file;
        exec($remove_pidfile);
    }

    function get_output_file_full_path() {
        return $this->output_full_path . $this->file_name;
    }
}


?>