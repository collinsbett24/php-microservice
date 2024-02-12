<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require 'fetch-currency.php';
    require 'requestMethods.php';

    $run = new requestMethods();
    
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $run->get();
    }else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $run->put();
    }else if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $run->post();
    }else if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
        $run->delete();
    }else{
        $errorCode = 1500;
        $message = "Error in service";
        $response = new Response();
        echo($response->xmlerrorResponse($errorCode, $message));       
    }
?>
