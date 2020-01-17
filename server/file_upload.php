<?php

include('include/FileValidator.php');
include('include/FileMover.php');
include('include/Logger.php');

define('upload_path', '../uploads/');

header('Content-Type: text/plain; charset=utf-8');

try {
    
    $GLOBALS['logger'] = new Logger();
    $fv = new FileValidator();
    $mover = new FileMover();

    $fv->parse_errors($_FILES['upfile']['error']);
    $fv->check_file_size($_FILES['upfile']['size']);
    $fv->is_extension_valid(upload_path . $_FILES['upfile']['name']);

    $mover->file_move(upload_path, $_FILES['upfile']['tmp_name'], $fv->get_extension());

    // include('process_task.php');

} catch (RuntimeException $e) {

    echo $e->getMessage();

}
?>