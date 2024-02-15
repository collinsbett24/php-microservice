<?php
// Import the required class files
require_once('classes.php');

// Define a class named requestMethods
class requestMethods{
    // Define a method named get()
    function get(){
        // Retrieve parameters from the GET request
        $from = isset($_GET['from']) ? $_GET['from'] : null;
        $to = isset($_GET['to']) ? $_GET['to'] : null;
        $amnt = isset($_GET['amnt']) ? $_GET['amnt'] : null;
        $format = isset($_GET['format']) ? $_GET['format'] : null;
        // Check if required parameters are not empty
        if(!empty($from) && !empty($to) && !empty($amnt)){
            // Create instances of Currency and Response classes
            $data = new Currency();
            $run = new Response();             
            // Check if the amount is a float
            if(is_float($amnt)){
                $errorCode = 1300;
                $errorMessage = "Currency amount must be a decimal number";
                $error = ['error' => [
                    'code' => $errorCode,
                    'msg' => $errorMessage
                ]];
                $xml = new SimpleXMLElement('<conv type="tttt" />');
                // Convert JSON to XML   
                $xmlString = $run->jsonToXml($error, 'GET', $xml);     
                // Echo the XML response
                header('Content-Type: application/xml');
                echo $xmlString;
                return;
            }
                
            // Retrieve currency rates from the file
            $allrates = $data->getRecordsFromFile();

            // Create a Filter instance to filter currencies
            $filter = new Filter($allrates, $from, $to);
            $filters = $filter->filterByCountry();

            // Prepare data for 'from' currency
            $fromData = ['code' => $from, 'curr' => $from, 'loc' => $from, 'amnt' => $amnt];
            // Calculate the new amount in the 'to' currency
            $newAmount = number_format($amnt * $filters['rate'], 2);
            // Prepare data for 'to' currency
            $toData = ['code' => $to, 'curr' => $to, 'loc' => $to, 'amnt' => $newAmount];
            
            // Prepare the final response data
            $responseData = [
                'at' => $filters['at'], 
                'rate' => number_format($filters['rate'], 2),
                'from' => $fromData,
                'to' => $toData
            ];
           

            // Check the requested format and generate the response accordingly
            switch ($format) {
                case (($format != 'json') && ($format != 'xml')):
                    $errorCode = 1400;
                    $errorMessage = "Format must be xml or json";
                
                    $error = ['error' => [
                        'code' => $errorCode,
                        'msg' => $errorMessage
                    ]];
                   
                    $xml = new SimpleXMLElement('<conv type="tttt" />');
                    // Convert JSON to XML   
                    $xmlString = $run->jsonToXml($error, 'GET', $xml);     
                    // Echo the XML response
                    header('Content-Type: application/xml');
                    echo $xmlString;
                    break;
                case 'json':
                    echo $run->jsonResponse($responseData);
                    break;
                default:
                    $xml = new SimpleXMLElement('<conv />');
                    $response = new Response();
                    echo $response->jsonToXml($responseData, '', $xml); 
                    break;
            }
        } else {
            // Handle missing required parameters
            $errorCode = 1000;
            $errorMessage = "Required parameter is missing";
            $run = new Response();

            $error = ['error' => [
                'code' => $errorCode,
                'msg' => $errorMessage
            ]];

            if($format === 'json'){
                echo $run->jsonResponse($error);
                return;
            }
            $xml = new SimpleXMLElement('<conv type="tttt" />');
            // Convert JSON to XML   
            $xmlString = $run->jsonToXml($error, 'GET', $xml);     
            // Echo the XML response
            header('Content-Type: application/xml');
            echo $xmlString;    
        }
    }

    function put(){
        $run = new Response();
        $symbols = isset($_PUT['cur']) ? $_PUT['cur'] : 'USD';
        $fetchFromAPI = new Currency();
        $newRate = $fetchFromAPI->fetch_per_currency($symbols);
        if($newRate['success']==true){
            $data =  new Currency();
            $allrates = $data->getRecordsFromFile();
            $filter = new Filter($allrates, $symbols, 'EUR');
            $oldrates =  $filter->filterByCountry();
            $timestamp = date('Y-m-d H:i', $newRate['timestamp']);
            $currentRate = number_format(1/$newRate['rates'][$symbols],5);
            $oldRateValue = number_format($oldrates['rate'],5);
            $response = [
                'at'=>$timestamp,
                'rate'=>$currentRate,
                'old_rate'=>$oldRateValue,
                'curr'=>[
                    'code'=>$symbols,
                    'name'=>$symbols,
                    'loc'=>$symbols
                    ]        
                ];
                echo $currentRate;
            $xml = new SimpleXMLElement('<action type="put"/>');
            // Convert JSON to XML   
            $xmlString = $run->jsonToXml($response,'PUT',$xml);     
            // Echo the XML response
            header('Content-Type: application/xml');
            echo $xmlString;
        }else{
            $error = ['error'=>['code'=>1500, 'message'=>$newRate['error']]];
            $xml = new SimpleXMLElement('<action type="tttt" />');
            $xmlString = $run->jsonToXml($error,'DELETE',$xml);
            echo $xmlString;
        }    
    }
    function post(){
        $symbols = isset($_GET['cur']) ? $_GET['cur'] : 'XCD';
        $data =  new Currency();
        $allrates = $data->getRecordsFromFile();
        $filter = new Filter($allrates, $symbols, 'EUR');
        $filters =  $filter->filterByCountry();
        $fromData = [
            'at' => $filters['at'],
            'rate' => $filters['rate'],
            'curr' => [
                'code' => $symbols,
                'name' => $symbols,
                'loc' => $symbols,
            ],
        ];
        $xml = new SimpleXMLElement('<action type="post" />');
        $run = new Response();
        $xmlString = $run->jsonToXml($fromData,'POST',$xml);
        header('Content-Type: application/xml');
        echo $xmlString;
    }
    function delete(){
        $run = new Response();
        $symbols = isset($_GET['cur']) ? $_GET['cur'] : null;
        if($symbols!==null && !empty($symbols)){
            $data =  new Currency();
            $allrates = $data->getRecordsFromFile();
            
            // print_r($allrates);
            $filter = new Filter($allrates, $symbols, 'EUR');
            $filters =  $filter->filterByCountry();

            $fromData = ['at'=> $filters['at'],'code'=>$symbols];
            
            $xml = new SimpleXMLElement('<action type="del" />');

            $xmlString = $run->jsonToXml($fromData,'DELETE',$xml);

            echo $xmlString;
        }else{
            $error = ['error'=>['code'=>1000, 'message'=>'Required parameter is missing']];
            $xml = new SimpleXMLElement('<action type="tttt" />');
            $xmlString = $run->jsonToXml($error,'DELETE',$xml);
            echo $xmlString;
        }
    }  
}
?>