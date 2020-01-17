<?php

define('cmd', '/home/alis/build/src/removeTheSpike');
define('log_path', '../logs/');
define('upload_path', '../uploads/');
define('pid_path', '../pids/');
define('max_repetitions', 100);

$file_to_send = '../processed/nagranie1_output.wav';
$file_to_process = $_SERVER['argv'][1];
$file_to_process_path = upload_path . $file_to_process;
$logfile = log_path . $file_to_process . '.log';
$pidfile = pid_path . $file_to_process . '.pid';

$command_log = fopen('log.txt', 'w') or die('File Open Error');

$command = sprintf('%s > %s & echo $! >> %s &', cmd, $logfile, $pidfile);
fwrite($command_log, $command . '\A');
exec($command);

$pidfile_fd = fopen($pidfile, 'r');
$pid = fread($pidfile_fd, filesize($pidfile));
fclose($pidfile);

try {
    $repetition = 0;
    do {
        $result = shell_exec(sprintf('ps %d', $pid));
        $condition = count(preg_split('/\n/', $result)) > 2;
        $repetition = $repetition + 1;
        sleep(2);
    } while($condition == true && $repetition < max_repetitions);
} catch(Exception $e) {
    echo 'Expetion occured';
}

$remove_processed_file = 'rm ' . $file_to_process_path;
fwrite($remove_processed_file, $command . '\n');
exec($remove_processed_file);

$remove_pidfile = 'rm ' . $pidfile;
fwrite($remove_pidfile, $command . '\n');
exec($remove_pidfile);

fclose($command_log);

if (file_exists($file_to_send)) {
    header("Cache-Control: private");
    header("Content-type: audio/mpeg3");
    header("Content-Transfer-Encoding: binary");
    header("Content-disposition: attachment; filename=\"".basename($file_to_send)."\"");
    header('Content-Length: ' . filesize($file_to_send));
    readfile($file_to_send);
}


?>