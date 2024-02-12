<?php
require 'response.php';

class requestMethods{
    function get(){
            // Retrieve parameters from the GET request
            $from = isset($_GET['from']) ? $_GET['from'] : null;
            $to = isset($_GET['to']) ? $_GET['to'] : null;
            $amnt = isset($_GET['amnt']) ? $_GET['amnt'] : null;
            $format = isset($_GET['format']) ? $_GET['format'] : null;

            if(!empty($from)&&!empty($to) &&!empty($amnt)){
                $data =  new Currency();
                $allrates = $data->getRecordsFromFile();
                // print_r($allrates);
                $filter = new Filter($allrates, $from, $to);
                $filters =  $filter->filterByCountry();

                $fromData = ['code'=>$from, 'curr'=>$from, 'loc'=>'USA','amnt'=>$amnt];
                $newAmount = number_format($amnt * $filters['rate'],2);

                $toData = ['code'=>$to, 'curr'=>$to, 'loc'=>'Kenya','amnt'=>$newAmount];

                if($format==='json'){
                    echo 'json response';
                }
                else if ($format !='json' && $format !='xml' && $format!=null) {
                    $errorCode =1400;
                    $errorMessage = "Format must be xml or json";
                    $errorResponse = new Response();
                    $xmlErrorResponse=$errorResponse->xmlerrorResponse($errorCode, $errorMessage);
                    echo $xmlErrorResponse;
                }
                else {
                    $responseData = [
                        'at'=>$filters['at'], 
                        'rate'=>$filters['rate'],
                        'from'=>$fromData,
                        'to'=>$toData
                    ];
                    $xml = new SimpleXMLElement('<conv xmlns="http://example.com/namespace" />');
                    $response = new Response();
                    echo $response->jsonToXml($responseData, '',$xml);       
                }
            }
            else{
                $errorCode =1000;
                $errorMessage = "Required parameter is missing";
                $errorResponse = new Response();
                $xmlErrorResponse=$errorResponse->xmlerrorResponse($errorCode, $errorMessage);
                echo $xmlErrorResponse;
            }
    }

    function put(){
        $run = new Response();

        $symbols = isset($_PUT['symbol']) ? $_PUT['symbol'] : 'USD';
        $access_key = 'bdde04235f768d651583501989dc578e';
        $ch = curl_init('http://data.fixer.io/api/latest?access_key='.$access_key.'&base=EUR&symbols='.$symbols);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Store the data:
        $json = curl_exec($ch);
        // Check for cURL errors
        if ($json === false) {
            $errorCode =2500;
            $errorMessage = "Error in service";
            $xmlErrorResponse=$ $run->xmlerrorResponse($errorCode, $errorMessage);
            echo $xmlErrorResponse;
            return;
        }
        curl_close($ch);
    
        // Decode JSON response:
        $exchangeRates = json_decode($json, true);
        
        $xml = new SimpleXMLElement('<action xmlns="http://example.com/namespace" type="PUT" />');
        // Convert JSON to XML
      
        $xmlString = $run->jsonToXml($exchangeRates,'PUT',$xml);
        
        // Echo the XML response
        header('Content-Type: application/xml');
        echo $xmlString;    
    }
    function post(){
        $symbols = isset($_POST['symbol']) ? $_POST['symbol'] : 'XCD';
        $data =  new Currency();
        $allrates = $data->getRecordsFromFile();
        
        // print_r($allrates);
        $filter = new Filter($allrates, $symbols, null);
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

        $xml = new SimpleXMLElement('<action xmlns="http://example.com/namespace" type="POST" />');
        
        $run = new Response();
        $xmlString = $run->jsonToXml($fromData,'POST',$xml);
        
        header('Content-Type: application/xml');
        echo $xmlString;
    }
    function delete(){
        $run = new Response();
        $symbols = isset($_DELETE['symbol']) ? $_DELETE['symbol'] : 'XCD';
        $data =  new Currency();
        $allrates = $data->getRecordsFromFile();
        
        // print_r($allrates);
        $filter = new Filter($allrates, $symbols, null);
        $filters =  $filter->filterByCountry();

        $fromData = ['at'=> $filters['at'],'code'=>$symbols];
        
        $xml = new SimpleXMLElement('<action xmlns="http://example.com/namespace" type="DELETE" />');

        $xmlString = $run->jsonToXml($fromData,'DELETE',$xml);

        echo $xmlString;
    }  
}
?>