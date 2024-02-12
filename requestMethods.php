<?php
class requestMethods{
    function index(){
        // Check the request method
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Retrieve parameters from the GET request
            $from = isset($_GET['from']) ? $_GET['from'] : null;
            $to = isset($_GET['to']) ? $_GET['to'] : null;
            $amnt = isset($_GET['amnt']) ? $_GET['amnt'] : null;
            $format = isset($_GET['format']) ? $_GET['format'] : 'xml';

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
                }else{
                    $response = new Response();
                    echo$response->xmlResponse($filters, $fromData,$toData );       
                }
            }else{
                $errorCode =1000;
                $errorMessage = "Required parameter is missing";
                $errorResponse = new Response();
                $xmlErrorResponse=$errorResponse->xmlerrorResponse($errorCode, $errorMessage);
                echo $xmlErrorResponse;
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo 'This is a POST request.';
        } else {
            echo 'This is a different type of request.';
        }
    }

    function put(){
        $symbols = isset($_PUT['symbol']) ? $_PUT['symbol'] : 'USD';
        $access_key = 'bdde04235f768d651583501989dc578e';
        $ch = curl_init('http://data.fixer.io/api/latest?access_key='.$access_key.'&base=EUR&symbols='.$symbols);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Store the data:
        $json = curl_exec($ch);
        // Check for cURL errors
        if ($json === false) {
            echo json_encode(['error' => 'cURL error: ' . curl_error($ch)]);
            return;
        }
        curl_close($ch);
    
        // Decode JSON response:
        $exchangeRates = json_decode($json, true);
        
        // Convert JSON to XML
        $run = new Response();
        $xmlString = $run->jsonToXml(json_encode($exchangeRates),'PUT');
        
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

            $fromData = ['at'=> $filters['at'],'code'=>$symbols, 'curr'=>$symbols, 'loc'=>'USA', 'rate'=> $filters['rate']];
            
            $run = new Response();
            $xmlString = $run->jsonToXml(json_encode($fromData),'POST');
            header('Content-Type: application/xml');
            echo $xmlString;

    }
    function delete(){
        $symbols = isset($_DELETE['symbol']) ? $_DELETE['symbol'] : 'XCD';
        $data =  new Currency();
        $allrates = $data->getRecordsFromFile();
        
        // print_r($allrates);
        $filter = new Filter($allrates, $symbols, null);
        $filters =  $filter->filterByCountry();

        $fromData = ['at'=> $filters['at'],'code'=>$symbols];
        
        $run = new Response();
        $xmlString = $run->jsonToXml(json_encode($fromData),'POST');
        header('Content-Type: application/xml');
        echo $xmlString;
    }  
}
?>