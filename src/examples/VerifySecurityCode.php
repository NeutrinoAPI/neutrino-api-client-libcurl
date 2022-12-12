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

    // The security code to verify
    "security-code" => "123456",

    // If set then enable additional brute-force protection by limiting the number of attempts by the
    // supplied value. This can be set to any unique identifier you would like to limit by, for example
    // a hash of the users email, phone number or IP address. Requests to this API will be ignored after
    // approximately 10 failed verification attempts
    "limit-by" => ""
);

$apiResponse = $neutrinoAPIClient->verifySecurityCode($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // True if the code is valid
    echo "verified: ", (isset($data['verified'])) ? var_export($data['verified'], true) : "NULL", "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}