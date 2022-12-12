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

    // The phone number to call. Must be in valid international format
    "number" => "+12106100045",

    // Limit the total number of calls allowed to the supplied phone number, if the limit is reached
    // within the TTL then error code 14 will be returned
    "limit" => "3",

    // A URL to a valid audio file. Accepted audio formats are:
    // • MP3
    // • WAV
    // • OGG You can use the following MP3 URL for testing:
    //   https://www.neutrinoapi.com/test-files/test1.mp3
    "audio-url" => "https://www.neutrinoapi.com/test-files/test1.mp3",

    // Set the TTL in number of days that the 'limit' option will remember a phone number (the default
    // is 1 day and the maximum is 365 days)
    "limit-ttl" => "1"
);

$apiResponse = $neutrinoAPIClient->phonePlayback($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // True if the call is being made now
    echo "calling: ", (isset($data['calling'])) ? var_export($data['calling'], true) : "NULL", "\n";
    
    // True if this a valid phone number
    echo "number-valid: ", (isset($data['number-valid'])) ? var_export($data['number-valid'], true) : "NULL", "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}