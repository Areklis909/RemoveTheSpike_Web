<?php

define('cmd', '/home/alis/build/src/removeTheSpike');
define('log_path', '../logs/');
define('upload_path', '../uploads/');
define('pid_path', '../pids/');
define('max_repetitions', 100);

// $file_to_send = $_SERVER['argv'][2];
$file_to_send = '../processed/nagranie1_output.wav';
$file_to_process = $_SERVER['argv'][1];
$file_to_process_path = upload_path . $file_to_process;
$logfile = log_path . $file_to_process . '.log';
$pidfile = pid_path . $file_to_process . '.pid';


$command = sprintf('%s > %s 2>&1 & echo $! >> %s', cmd, $logfile, $pidfile);
exec($command);
echo $command;

$pidfile_fd = fopen($pidfile, 'r');
echo $pidfile_fd;
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

$remove_pidfile = 'rm ' . $pidfile;
exec($remove_pidfile);

// if (file_exists($file_to_send)) {
//     header('Content-Description: File Transfer');
//     header('Content-Type: application/octet-stream');
//     header('Content-Disposition: attachment; filename="'.basename($file_to_send).'"');
//     header('Expires: 0');
//     header('Cache-Control: must-revalidate');
//     header('Pragma: public');
//     header('Content-Length: ' . filesize($file_to_send));
//     readfile($file_to_send);
// } 



?>