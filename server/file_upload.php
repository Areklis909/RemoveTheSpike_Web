<?php

include('include/FileValidator.php');
include('include/FileMover.php');
include('include/FileProcessor.php');
include('include/FileSender.php');

define('upload_path', '../uploads/');
define('destination_path', '../processed/');
define('slash', '/');

$full_upload_path = realpath(upload_path) . slash;
$full_destination_path = realpath(destination_path) . slash;

header('Content-Type: text/plain; charset=utf-8');

try {
    $validator = new FileValidator();
    $mover = new FileMover();
    
    $validator->parse_errors($_FILES['upfile']['error']);
    $validator->check_file_size($_FILES['upfile']['size']);
    $validator->is_extension_valid($full_upload_path . $_FILES['upfile']['name']);

    $mover->file_move($full_upload_path, $_FILES['upfile']['tmp_name'], $validator->get_extension());
    
    $file_processor = new FileProcessor($mover->get_target_file_name_full_path(), $full_destination_path);
    $file_processor->remove_the_spike();
    $file_processor->wait_for_process_to_end($file_processor->read_pid());
    
    $sender = new FileSender();
    $sender->file_send($file_processor->get_output_file_full_path());
} catch (RuntimeException $e) {

    echo $e->getMessage();

}
?>