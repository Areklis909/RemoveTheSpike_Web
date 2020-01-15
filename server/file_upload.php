<?php


define(max_upload_size, 10000 * 1024);
define(upload_path, '../uploads/');
$extension_array = array(
    '.mp3',
    '.wav'
);
header('Content-Type: text/plain; charset=utf-8');

try {
   
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (!isset($_FILES['upfile']['error']) || is_array($_FILES['upfile']['error'])) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check $_FILES['upfile']['error'] value.
    switch ($_FILES['upfile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
            throw new RuntimeException('INI size problem: ' . $_FILES['upfile']['size'] . ' bytes');
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit: ' . $_FILES['upfile']['size'] . ' bytes');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // You should also check filesize here.
    if ($_FILES['upfile']['size'] > max_upload_size) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    $ext = pathinfo(upload_path . $_FILES['upfile']['name'], PATHINFO_EXTENSION);
    $valid_extension = false;
    foreach($extension_array as $extension) {
        $valid_extension = array_search($extension, $extension_array);
        if($valid_extension == true) {
            break;
        }
    }

    if($valid_extension == false) {
        throw new RuntimeException('File type is not supported!');
    }

    // You should name it uniquely.
    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    $timestamp = time();
    $target_filename = upload_path . sha1_file($_FILES['upfile']['tmp_name']) . '_' . $timestamp . '.' . $ext;
    if (!move_uploaded_file($_FILES['upfile']['tmp_name'], $target_filename)) {
            throw new RuntimeException('Failed to move uploaded file.');
    }

    echo 'File is uploaded successfully.';

} catch (RuntimeException $e) {

    echo $e->getMessage();

}
?>