<?php
class Response{
    //method for creating xml responses
    function jsonToXml($data,$action, $xml = null) {
        header('Content-Type: application/xml');
        if ($xml === null) {
            $xml = new SimpleXMLElement('<action />');
        }
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $response = new Response();
                // Recursively call the function for nested arrays
                $response->jsonToXml($value,$action, $xml->addChild($key));
            } else {
                $xml->addChild($key, htmlspecialchars($value));
            }
        }
        return $xml->asXML();
    }
    //method for creating json responses
    function jsonResponse($xmlString){
        // Convert to JSON
        header('Content-Type: application/json');
        $jsonData = json_encode($xmlString, JSON_PRETTY_PRINT);
        // Output JSON
        return $jsonData;
    }
    
    //method for creating error responses
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

}
?>