<?php

// Check the request method
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve parameters from the GET request
    $from = isset($_GET['from']) ? $_GET['from'] : null;
    $to = isset($_GET['to']) ? $_GET['to'] : null;
    $amnt = isset($_GET['amnt']) ? $_GET['amnt'] : null;
    $format = isset($_GET['format']) ? $_GET['format'] : 'xml';
    echo("data");
    $jsonFilePath = 'filtered_data.json';
    
    // Get JSON data from the file
    $jsonData = file_get_contents($jsonFilePath);
    
    // Decode JSON data into a PHP array
    $data = json_decode($jsonData, true);
    // Access the desired data
    $convData = $data['rates'];
    // Display the data
    print_r($convData);

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo 'This is a POST request.';
} else {
    echo 'This is a different type of request.';
}

class Response{
    function xmlResponse(){
        // Set the content type to XML
        header('Content-Type: application/xml');
        // Create an XML document
        $xmlDoc = new DOMDocument('1.0', 'utf-8');

        // Create the root element
        $root = $xmlDoc->createElement('conv');
        $xmlDoc->appendChild($root);

        // Add some sample data
        $dataElement = $xmlDoc->createElement('data', 'Hello, this is XML response!');
        $at = $xmlDoc->createElement('at', 'Hello, this is XML response!');
        $rate = $xmlDoc->createElement('rate', 'Hello, this is XML response!');
        $from = $xmlDoc->createElement('from');
        $to = $xmlDoc->createElement('to');
        $root->appendChild($dataElement);
        $root->appendChild($at);
        $root->appendChild($rate);
        $root->appendChild($from);
        $root->appendChild($to);

        $fromElement = $xmlDoc->createElement('code','GBP');
        $fromElement1 = $xmlDoc->createElement('curr','GBP');
        $fromElement2 = $xmlDoc->createElement('loc','GBP');
        $fromElement3 = $xmlDoc->createElement('amnt',10.35);
        $from->appendChild($fromElement);
        $from->appendChild($fromElement1);
        $from->appendChild($fromElement2);
        $from->appendChild($fromElement3);

        $toElement = $xmlDoc->createElement('code','GBP');
        $toElement1 = $xmlDoc->createElement('curr','GBP');
        $toElement2 = $xmlDoc->createElement('loc','GBP');
        $toElement3 = $xmlDoc->createElement('amnt',10.35);
        $to->appendChild($toElement);
        $to->appendChild($toElement1);
        $to->appendChild($toElement2);
        $to->appendChild($toElement3);

        // Output the XML
        $xmlString = $xmlDoc->saveXML();
        return $xmlString;
    }

    function jsonResponse($xmlString){
        $xmlObject = simplexml_load_string($xmlString);
        $jsonString = json_encode($xmlObject, JSON_PRETTY_PRINT);
        // Output the JSON
        return $jsonString;
    }

}

?>
