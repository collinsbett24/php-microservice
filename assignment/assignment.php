<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once('classes.php');

    $run = new requestMethods();
    
    if(($_SERVER['REQUEST_METHOD'] === 'GET')){
        $run->get();
    }else if (($_SERVER['REQUEST_METHOD'] === 'PUT')) {
        $run->put();
    }else if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $run->post();
    }else if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
        $run->delete();
    }else{
        $errorCode =1500;
        $errorMessage = "Error in service";
        $run = new Response();
        $error = ['error'=>[
            'code'=>$errorCode,
            'msg'=>$errorMessage
        ]];
        $xml = new SimpleXMLElement('<conv  type="tttt" />');
        // Convert JSON to XML   
        $xmlString = $run->jsonToXml($error,'GET',$xml);     
        // Echo the XML response
        header('Content-Type: application/xml');
        echo $xmlString;  
        return;
              
    }
    
?>
