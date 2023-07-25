<?php
require __DIR__ . '/../client/APIErrorCode.php';
require __DIR__ . '/../client/APIResponse.php';
require __DIR__ . '/../client/NeutrinoAPIClient.php';

$neutrinoAPIClient = new NeutrinoAPI\NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

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
    echo "from-type: ", var_export($data['from-type'], true), "\n";
    
    // The value being converted from
    echo "from-value: ", var_export($data['from-value'], true), "\n";
    
    // The result of the conversion in string format
    echo "result: ", var_export($data['result'], true), "\n";
    
    // The result of the conversion as a floating-point number
    echo "result-float: ", var_export($data['result-float'], true), "\n";
    
    // The type being converted to
    echo "to-type: ", var_export($data['to-type'], true), "\n";
    
    // True if the conversion was successful and produced a valid result
    echo "valid: ", var_export($data['valid'], true), "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}
