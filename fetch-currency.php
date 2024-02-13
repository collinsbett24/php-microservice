<?php
require_once('classes.php');
class Currency{
    public $endpoint;
    public $access_key;
    function __construct(){
        $this->endpoint ='latest';
        $this->access_key = 'bdde04235f768d651583501989dc578e';
    }

    function fetch_currency(){
        // Initialize CURL:
        $ch = curl_init('http://data.fixer.io/api/'.$endpoint.'?access_key='.$access_key.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);
        
        // Decode JSON response:
        $exchangeRates = json_decode($json, true);

        $filter = new Filter($exchangeRates);
        $filter->filter_rates();
    }

    function save_to_file($data) : String {
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        // Write the JSON data to a .json file
        $file = 'filtered_data.json';
        $save = file_put_contents($file, $jsonData);

        if($save){
            return "File updated successfully";
        }
        else{
            return "Failed to save";
        }        
    }

    function getRecordsFromFile(){
        $jsonFilePath = 'filtered_data.json';
        // Get JSON data from the file
        $jsonData = file_get_contents($jsonFilePath);
        
        // Decode JSON data into a PHP array
        $data = json_decode($jsonData, true);
        // Access the desired data
        return $data;
    }
    function fetch_per_currency($symbols){
        $run = new Response();
        $ch = curl_init('http://data.fixer.io/api/latest?access_key='.$this->access_key.'&base=EUR&symbols='.$symbols);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Store the data:
        $json = curl_exec($ch);
        // Check for cURL errors
        if ($json === false) {
            $errorCode=2500;
            $errorMessage = "Error in service";
            $xmlErrorResponse=$run->xmlerrorResponse($errorCode, $errorMessage);
            echo $xmlErrorResponse;
            return;
        }
        curl_close($ch);
        // Decode JSON response:
        $exchangeRate = json_decode($json, true);
        return $exchangeRate;
    }
}