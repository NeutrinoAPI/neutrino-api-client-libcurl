<?php
use NeutrinoAPI\NeutrinoAPIClient;

spl_autoload_register(function ($className) {
    if (strpos($className, "NeutrinoAPI\\") === 0) {
        $classFile = explode('\\', $className)[1].'.php';
        include realpath(__DIR__ . "/../client/$classFile");
    }
});

$neutrinoAPIClient = new NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

$params = array(

    // The value to convert from (e.g. 10.95)
    "from-value" => "100",

    // The type of the value to convert from (e.g. USD)
    "from-type" => "USD",

    // The type to convert to (e.g. EUR)
    "to-type" => "EUR"
);

$apiResponse = $neutrinoAPIClient->convert($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // The type of the value being converted from
    echo "from-type: ", (isset($data['from-type'])) ? var_export($data['from-type'], true) : "NULL", "\n";
    
    // The value being converted from
    echo "from-value: ", (isset($data['from-value'])) ? var_export($data['from-value'], true) : "NULL", "\n";
    
    // The result of the conversion in string format
    echo "result: ", (isset($data['result'])) ? var_export($data['result'], true) : "NULL", "\n";
    
    // The result of the conversion as a floating-point number
    echo "result-float: ", (isset($data['result-float'])) ? var_export($data['result-float'], true) : "NULL", "\n";
    
    // The type being converted to
    echo "to-type: ", (isset($data['to-type'])) ? var_export($data['to-type'], true) : "NULL", "\n";
    
    // True if the conversion was successful and produced a valid result
    echo "valid: ", (isset($data['valid'])) ? var_export($data['valid'], true) : "NULL", "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}