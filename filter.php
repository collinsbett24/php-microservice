<?php
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
        $to =  empty($this->to) ? 1: $this->to; 
        $filterValues =[$this->from, $to];
        $filteredRates = array_intersect_key($this->rates['rates'], array_flip($filterValues));
        $jsonData = json_encode($filteredRates, JSON_PRETTY_PRINT);
        $countryCurr = json_decode($jsonData, true); 
        $toVal = empty($this->$to) ? 1: $countryCurr[$this->to];  
        $rate = number_format($countryCurr[$this->to]/$countryCurr[$this->from], 2);

        $timestamp = $this->rates['timestamp'];
        
        $formattedDate = date('Y-m-d H:i', $timestamp);
        
        $response =['at'=>$formattedDate,'rate'=>$rate];
        
        return $response;
    }
}
?>