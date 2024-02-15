<?php
require_once('classes.php');
class Currency{
    public $endpoint;
    public $access_key;
    //initialize parameters using a constructor
    function __construct(){
        $this->endpoint ='latest';
        $this->access_key = 'bdde04235f768d651583501989dc578e';
    }
    //method to fetch currencies
    function fetch_currency(){
        // Initialize CURL:
        $ch = curl_init('http://data.fixer.io/api/'.$this->endpoint.'?access_key='.$this->access_key.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);
        // Decode JSON response:
        $exchangeRates = json_decode($json, true);
        $exchangeRates;
        $filter = new Currency();
        $filter->save_to_file($exchangeRates);
    }
    //method to save currencies to json file
    function save_to_file($data){
        if($data['error']){
            $errorCode =1500;
            $errorMessage = "Error in service";
            $run = new Response();
            $error = ['error'=>[
                'code'=>$errorCode,
                'msg'=>$data['error']
            ]];
            $xml = new SimpleXMLElement('<conv  type="tttt" />');
            // Convert JSON to XML   
            $xmlString = $run->jsonToXml($error,'GET',$xml);     
            // Echo the XML response
            header('Content-Type: application/xml');
            echo $xmlString;
            return;
        }
        else{
            $jsonData = json_encode($data, JSON_PRETTY_PRINT);
            // Write the JSON data to a .json file
            $file = 'filtered_data.json';
            $save = file_put_contents($file, $jsonData);
            if($save){
                return true;
            }
            else{
                return $data;
            }     
        }   
    }
    //method to fetch all currencies from json file
    function getRecordsFromFile(){
        $jsonFilePath = 'filtered_data.json';
        // Get JSON data from the file
        $jsonData = file_get_contents($jsonFilePath);      
        // Decode JSON data into a PHP array
        $data = json_decode($jsonData, true);
        $timestamp = $data['timestamp'];
        $formattedDate = date('Y-m-d H:i:s', $timestamp);
        $curreny = new Currency();
        if($curreny->timeDifference($formattedDate)==true){
            $resp = $curreny->fetch_currency();
            if($resp){
                $curreny->getRecordsFromFile();
            }
        }
        // Access the desired data
        return $data;
    }
    //method to fetch currecy info per Curr
    function fetch_per_currency($symbols){
        $run = new Response();
        $ch = curl_init('http://data.fixer.io/api/latest?access_key='.$this->access_key.'&base=EUR&symbols='.$symbols);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Store the data:
        $json = curl_exec($ch);
        // Check for cURL errors
        curl_close($ch);
        // Decode JSON response:
        $exchangeRate = json_decode($json, true);
        return $exchangeRate;
    }
    //method to calculate time difference
    function timeDifference($timestamp){
        // Current date and time
        $now = new DateTime();

        $targetDateTime = new DateTime($timestamp);
        // Calculate the difference
        $timeDifference = $now->diff($targetDateTime);
        // Access individual components of the difference
        $days = $timeDifference->d;
        $hours = $timeDifference->h;
        $minutes = $timeDifference->i;
        $seconds = $timeDifference->s;
        return $hours <= 2 ? false :true;
    }
}