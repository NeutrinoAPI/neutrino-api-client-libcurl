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

    // The phone number to send the verification code to
    "number" => "+12106100045",

    // ISO 2-letter country code, assume numbers are based in this country. If not set numbers are
    // assumed to be in international format (with or without the leading + sign)
    "country-code" => "",

    // Pass in your own security code. This is useful if you have implemented TOTP or similar 2FA
    // methods. If not set then we will generate a secure random code
    "security-code" => "",

    // The language to playback the verification code in, available languages are:
    // • de - German
    // • en - English
    // • es - Spanish
    // • fr - French
    // • it - Italian
    // • pt - Portuguese
    // • ru - Russian
    "language-code" => "en",

    // The number of digits to use in the security code (between 4 and 12)
    "code-length" => "6",

    // Limit the total number of calls allowed to the supplied phone number, if the limit is reached
    // within the TTL then error code 14 will be returned
    "limit" => "3",

    // The delay in milliseconds between the playback of each security code
    "playback-delay" => "800",

    // Set the TTL in number of days that the 'limit' option will remember a phone number (the default
    // is 1 day and the maximum is 365 days)
    "limit-ttl" => "1"
);

$apiResponse = $neutrinoAPIClient->phoneVerify($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // True if the call is being made now
    echo "calling: ", (isset($data['calling'])) ? var_export($data['calling'], true) : "NULL", "\n";
    
    // True if this a valid phone number
    echo "number-valid: ", (isset($data['number-valid'])) ? var_export($data['number-valid'], true) : "NULL", "\n";
    
    // The security code generated, you can save this code to perform your own verification or you can
    // use the Verify Security Code API
    echo "security-code: ", (isset($data['security-code'])) ? var_export($data['security-code'], true) : "NULL", "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}