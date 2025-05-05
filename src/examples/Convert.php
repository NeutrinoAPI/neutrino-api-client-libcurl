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
    "to-type" => "EUR",

    // Convert using the rate on a historical date, accepted date formats are: YYYY-MM-DD, YYYY-MM,
    // YYYY. Historical rates are stored with daily granularity so the date format YYYY-MM-DD is
    // preferred for the highest precision. If an invalid date or a date too far into the past is
    // supplied then the API will respond with 'valid' as false and an empty 'historical-date'
    "historical-date" => ""
);

$apiResponse = $neutrinoAPIClient->convert($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // The full name of the type being converted from
    echo "from-name: ", var_export($data['from-name'], true), "\n";
    
    // The standard UTF-8 symbol used to represent the type being converted from
    echo "from-symbol: ", var_export($data['from-symbol'], true), "\n";
    
    // The type of the value being converted from
    echo "from-type: ", var_export($data['from-type'], true), "\n";
    
    // The value being converted from
    echo "from-value: ", var_export($data['from-value'], true), "\n";
    
    // If a historical conversion was made using the 'historical-date' request option this will contain
    // the exact date used for the conversion in ISO format: YYYY-MM-DD
    echo "historical-date: ", var_export($data['historical-date'], true), "\n";
    
    // The result of the conversion in string format
    echo "result: ", var_export($data['result'], true), "\n";
    
    // The result of the conversion as a floating-point number
    echo "result-float: ", var_export($data['result-float'], true), "\n";
    
    // The full name of the type being converted to
    echo "to-name: ", var_export($data['to-name'], true), "\n";
    
    // The standard UTF-8 symbol used to represent the type being converted to
    echo "to-symbol: ", var_export($data['to-symbol'], true), "\n";
    
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
