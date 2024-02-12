<?php
class Response{
    function xmlResponse($mainbody, $fromData, $toData){
        // Set the content type to XML
        header('Content-Type: application/xml');
        // Create an XML document
        $xmlDoc = new DOMDocument('1.0', 'utf-8');

        // Create the root element
        $root = $xmlDoc->createElement('conv');
        $xmlDoc->appendChild($root);

        // Add some sample data
        $at = $xmlDoc->createElement('at', $mainbody['at']);
        $rate = $xmlDoc->createElement('rate', $mainbody['rate']);
        $from = $xmlDoc->createElement('from');
        $to = $xmlDoc->createElement('to');
        $root->appendChild($at);
        $root->appendChild($rate);
        $root->appendChild($from);
        $root->appendChild($to);

        $fromElement = $xmlDoc->createElement('code', $fromData['code']);
        $fromElement1 = $xmlDoc->createElement('curr', $fromData['curr']);
        $fromElement2 = $xmlDoc->createElement('loc', $fromData['loc']);
        $fromElement3 = $xmlDoc->createElement('amnt', $fromData['amnt']);
        $from->appendChild($fromElement);
        $from->appendChild($fromElement1);
        $from->appendChild($fromElement2);
        $from->appendChild($fromElement3);

        $toElement = $xmlDoc->createElement('code',$toData['code']);
        $toElement1 = $xmlDoc->createElement('curr', $toData['curr']);
        $toElement2 = $xmlDoc->createElement('loc', $toData['loc']);
        $toElement3 = $xmlDoc->createElement('amnt', $toData['amnt']);
        $to->appendChild($toElement);
        $to->appendChild($toElement1);
        $to->appendChild($toElement2);
        $to->appendChild($toElement3);

        // Output the XML
        $xmlString = $xmlDoc->saveXML();
 
        return $xmlString;
    }
    function xmlerrorResponse($errorCode, $errorMessage){
         // Set the content type to XML
         header('Content-Type: application/xml');
        // Create an XML document
        $xmlDoc = new DOMDocument('1.0', 'utf-8');
        // Create the root element
        $root = $xmlDoc->createElement('conv');
        $xmlDoc->appendChild($root);
        // Create the error element
        $errorElement = $xmlDoc->createElement('error');
        $root->appendChild($errorElement);
        // Add code and message elements under the error element
        $codeElement = $xmlDoc->createElement('code', $errorCode);
        $errorElement->appendChild($codeElement);
        $msgElement = $xmlDoc->createElement('msg', $errorMessage);
        $errorElement->appendChild($msgElement);
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

    function jsonToXml($jsonString, $action) {
        $jsonArray = json_decode($jsonString, true);
    
        $xml = new SimpleXMLElement('<action xmlns="http://example.com/namespace" type="PUT"/>');
        array_walk_recursive($jsonArray, function ($value, $key) use ($xml) {
            $xml->addChild($key, $value);
        });
    
        return $xml->asXML();
    }
}
?>