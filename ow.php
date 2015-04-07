<?php
    include 'config.php';

    $daurl = APP_BASE_URL.'wyniki.php?q='.urlencode($_REQUEST['q']);

    $handle = @fopen($daurl, "r");

    if($handle){
        header('Content-type: application/txt');

        while (!feof($handle)) {
            $buffer = fgets($handle, 4096);
            echo $buffer;
        }

        fclose($handle);
    }else{
        header('HTTP/1.1 404 Not Found');
    }

?>