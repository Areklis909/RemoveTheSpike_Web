<?php

include('include/ChartCleaner.php');


try {
    error_log(var_dump($_POST));
    $cleaner = new ChartCleaner($_POST['charts_to_remove']);
} catch(Exception $e) {

}



?>