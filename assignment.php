<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require 'fetch-currency.php';
require 'requestMethods.php';
require 'response.php';

$run = new Assignment();
$run->delete();
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $run->put();
}else if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $run->post();
}else if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
    $run->delete();
}else{
    $run->index();
}

?>
