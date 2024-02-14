<?php
//include the required classed
require_once('classes.php');
class Filter{
    public $rates;
    public $from;
    public $to;
    //initilize parameters using a constructor
    function __construct($currencydata, $from, $to){
        $this->from = $from;
        $this->to = $to;
        $this->rates= $currencydata;
    }
    //function to filter rated from 170 to only 25
     function filter_rates(){
        //array of the required currencies
        $filterValues = ["AUD","BRL","CAD","CHF","CNY","DKK","EUR","GBP","HKD","HUF","INR","JPY","MXN","MYR","NOK","NZD","PHP","RUB","SEK","SGD","THB","TRY","USD","ZAR"];

        function filter_by_currency(){
            //filter the required curr against all the currencies passed
            $filteredRates = array_intersect_key($this->rates['rates'], array_flip($filterValues));
            $jsonData = json_encode($filteredRates, JSON_PRETTY_PRINT);
            // Write the JSON data to a .json file
            $file = 'filtered_rates.json';
            file_put_contents($file, $jsonData);
        }          
    }
    //filter for two currencies $from and $to parameters
    function filterByCountry(){
        $run = new Response();
        //check if one of the values is empty
        $to =  empty($this->to) ? 1: $this->to;
        //filter the records 
        $filterValues =[$this->from, $to];
        $filteredRates = array_intersect_key($this->rates['rates'], array_flip($filterValues));
        $jsonData = json_encode($filteredRates, JSON_PRETTY_PRINT);
        $countryCurr = json_decode($jsonData, true);
        $toVal = empty($this->$to) ? 1: $countryCurr[$this->to];  
        //calculate the rate
        $rate = $countryCurr[$this->to]/$countryCurr[$this->from];
        $timestamp = $this->rates['timestamp'];
        //format the time
        $formattedDate = date('Y-m-d H:i', $timestamp);
        $response =['at'=>$formattedDate,'rate'=>$rate];
        return $response;
    }
}
?>