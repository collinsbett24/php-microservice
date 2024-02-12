<?php

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
}
class Filter{
    public $rates;
    
    function __construct($rates){
        $this->rates= $rates;
    }

    function filter_rates(){
        // Filter values
        $filterValues = ["AUD","BRL","CAD","CHF","CNY","DKK","EUR","GBP","HKD","HUF","INR","JPY","MXN","MYR","NOK","NZD","PHP","RUB","SEK","SGD","THB","TRY","USD","ZAR"];

        function filter_by_currency(){
            $filteredRates = array_intersect_key($this->rates, array_flip($filterValues));
            $jsonData = json_encode($filteredRates, JSON_PRETTY_PRINT);
            // Write the JSON data to a .json file
            $file = 'filtered_rates.json';
            file_put_contents($file, $jsonData);
        }
    }
}

$test = new Currency();
echo($test->fetch_currency());