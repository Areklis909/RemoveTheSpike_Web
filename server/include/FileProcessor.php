<?php

class FileProcessor {
    const max_check_repetitions = 100;
    const pid_path = '../pids/';
    const pid_ending = '.pid';
    const log_path = '../logs/';
    const log_ending = '.log';
    const chart_path = '../chart';
    const chart_ending = '_chart';
    const before_suffix = '_before';
    const after_suffix = '_after';
    const binary_path = 'bin/removeTheSpike';
    const configuration_path = 'bin/Configuration.cfg';
    const chart_generator_path = '../scripts/chart.py';
    const python_call = 'python';
    const rm_command = 'rm ';
    const slash = '/';
    const process_all_samples = -1;

    private $file_full_path;
    private $file_name;
    private $output_full_path;
    private $log_file;
    private $pid_file;
    private $chart_pid_before;
    private $chart_pid_after;
    private $chart_before_file_name;
    private $chart_after_file_name;
    private $configuration_file_path;


    function __construct($file_to_process_full_path, $processed_file_destination) {
        $this->output_full_path = $processed_file_destination;
        $this->file_full_path = $file_to_process_full_path;
        $this->file_name = basename($this->file_full_path);
        $this->log_file = realpath(self::log_path) . self::slash . $this->file_name . self::log_ending;
        $this->pid_file = realpath(self::pid_path) . self::slash . $this->file_name . self::pid_ending;
        $this->chart_pid_before = realpath(self::pid_path) . self::slash . $this->file_name . self::before_suffix . self::pid_ending;
        $this->chart_pid_after = realpath(self::pid_path) . self::slash . $this->file_name . self::after_suffix . self::pid_ending;
        $this->configuration_file_path = realpath(self::configuration_path);
        error_log('Arek: config path: ' . $this->configuration_file_path);

        $part = strtok($this->file_name, '.');
        $file_name_no_format = $part;
        $this->chart_before_file_name = realpath(self::chart_path) . self::slash . $file_name_no_format . self::before_suffix;
        $this->chart_after_file_name = realpath(self::chart_path) . self::slash . $file_name_no_format . self::after_suffix;
    }

    function __destruct() {
        $this->clean_up();
    }

    function remove_the_spike() {
        $command = sprintf('%s --signalLength %s --filename %s --outputFile %s --config %s > %s & echo $! > %s',
        self::binary_path, self::process_all_samples, $this->file_full_path, $this->output_full_path . $this->file_name,
            $this->configuration_file_path, $this->log_file, $this->pid_file);
        exec($command);
    }

    function read_remove_the_spike_pid() {
        return $this->read_pid_generic($this->pid_file);
    }

    function generate_chart_generic($suffix, $chart_pid_file, $file_to_draw, $output_chart) {
        $command = sprintf('%s %s %s %s %s & echo $! > %s', self::python_call, self::chart_generator_path, $file_to_draw, $suffix, $output_chart, $chart_pid_file);
        exec($command);
    }

    function generate_chart_before() {
        $this->generate_chart_generic(self::before_suffix, $this->chart_pid_before, $this->file_full_path, $this->chart_before_file_name);
    }


    function generate_chart_after() {
        $this->generate_chart_generic(self::after_suffix, $this->chart_pid_after, $this->output_full_path . $this->file_name, $this->chart_after_file_name);
    }

    function read_pid_chart_before() {
        return $this->read_pid_generic($this->chart_pid_before);
    }

    function read_pid_chart_after() {
        return $this->read_pid_generic($this->chart_pid_after);
    }

    function read_pid_generic($pid_file_name) {
        $pidfile_fd = fopen($pid_file_name, 'r');
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
            echo 'Excpetion occured';
        }
    }

    function wait_for_chart_before() {
        $this->wait_for_process_to_end($this->read_pid_chart_before());
    }

    function wait_for_chart_after() {
        $this->wait_for_process_to_end($this->read_pid_chart_after());
    }

    function clean_up() {
        $remove_processed_file = self::rm_command . $this->get_output_file_full_path();
        exec($remove_processed_file);
        
        $remove_pidfile = self::rm_command . $this->pid_file;
        exec($remove_pidfile);

        $remove_chart_pidfiles = self::rm_command . $this->chart_pid_after . ' ' . $this->chart_pid_before;
        exec($remove_chart_pidfiles);
    }

    function get_output_file_full_path() {
        return $this->output_full_path . $this->file_name;
    }
}
