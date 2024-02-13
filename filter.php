<?php
require_once('classes.php');
class Filter{
    public $rates;
    public $from;
    public $to;
    
    function __construct($currencydata, $from, $to){
        $this->from = $from;
        $this->to = $to;
        $this->rates= $currencydata;
    }
     function filter_rates(){
        // Filter values
        $filterValues = ["AUD","BRL","CAD","CHF","CNY","DKK","EUR","GBP","HKD","HUF","INR","JPY","MXN","MYR","NOK","NZD","PHP","RUB","SEK","SGD","THB","TRY","USD","ZAR"];

        function filter_by_currency(){
            $filteredRates = array_intersect_key($this->rates['rates'], array_flip($filterValues));
            $jsonData = json_encode($filteredRates, JSON_PRETTY_PRINT);
            // Write the JSON data to a .json file
            $file = 'filtered_rates.json';
            file_put_contents($file, $jsonData);
        }
    }

    function filterByCountry(){
        $run = new Response();

        $to =  empty($this->to) ? 1: $this->to; 
        $filterValues =[$this->from, $to];
        $filteredRates = array_intersect_key($this->rates['rates'], array_flip($filterValues));
        $jsonData = json_encode($filteredRates, JSON_PRETTY_PRINT);
        $countryCurr = json_decode($jsonData, true);
        // if(empty($countryCurr[$this->from])){
        //     $error = ['error'=>['code'=>2200, 'message'=>'Currency code not found for update']];
        //     $xml = new SimpleXMLElement('<action xmlns="http://example.com/namespace" type="tttt" />');
        //     $xmlString = $run->jsonToXml($error,'DELETE',$xml);
        //     echo $xmlString; 
        // } 

        $toVal = empty($this->$to) ? 1: $countryCurr[$this->to];  
        $rate = $countryCurr[$this->to]/$countryCurr[$this->from];
        $timestamp = $this->rates['timestamp'];
        $formattedDate = date('Y-m-d H:i', $timestamp);
        $response =['at'=>$formattedDate,'rate'=>$rate];
        return $response;
    }
}
?>