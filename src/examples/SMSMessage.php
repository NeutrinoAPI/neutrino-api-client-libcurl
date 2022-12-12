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

    // The phone number to send a message to
    "number" => "+12106100045",

    // ISO 2-letter country code, assume numbers are based in this country. If not set numbers are
    // assumed to be in international format (with or without the leading + sign)
    "country-code" => "",

    // Limit the total number of SMS allowed to the supplied phone number, if the limit is reached
    // within the TTL then error code 14 will be returned
    "limit" => "10",

    // The SMS message to send. Messages are truncated to a maximum of 150 characters for ASCII content
    // OR 70 characters for UTF content
    "message" => "Hello, this is a test message!",

    // Set the TTL in number of days that the 'limit' option will remember a phone number (the default
    // is 1 day and the maximum is 365 days)
    "limit-ttl" => "1"
);

$apiResponse = $neutrinoAPIClient->smsMessage($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // True if this a valid phone number
    echo "number-valid: ", (isset($data['number-valid'])) ? var_export($data['number-valid'], true) : "NULL", "\n";
    
    // True if the SMS has been sent
    echo "sent: ", (isset($data['sent'])) ? var_export($data['sent'], true) : "NULL", "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}