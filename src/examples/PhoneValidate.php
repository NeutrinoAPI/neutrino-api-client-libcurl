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

    // A phone number. This can be in international format (E.164) or local format. If passing local
    // format you must also set either the 'country-code' OR 'ip' options as well
    "number" => "+6495552000",

    // ISO 2-letter country code, assume numbers are based in this country. If not set numbers are
    // assumed to be in international format (with or without the leading + sign)
    "country-code" => "",

    // Pass in a users IP address and we will assume numbers are based in the country of the IP address
    "ip" => ""
);

$apiResponse = $neutrinoAPIClient->phoneValidate($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // The phone number country
    echo "country: ", (isset($data['country'])) ? var_export($data['country'], true) : "NULL", "\n";
    
    // The phone number country as an ISO 2-letter country code
    echo "country-code: ", (isset($data['country-code'])) ? var_export($data['country-code'], true) : "NULL", "\n";
    
    // The phone number country as an ISO 3-letter country code
    echo "country-code3: ", (isset($data['country-code3'])) ? var_export($data['country-code3'], true) : "NULL", "\n";
    
    // ISO 4217 currency code associated with the country
    echo "currency-code: ", (isset($data['currency-code'])) ? var_export($data['currency-code'], true) : "NULL", "\n";
    
    // The international calling code
    echo "international-calling-code: ", (isset($data['international-calling-code'])) ? var_export($data['international-calling-code'], true) : "NULL", "\n";
    
    // The number represented in full international format (E.164)
    echo "international-number: ", (isset($data['international-number'])) ? var_export($data['international-number'], true) : "NULL", "\n";
    
    // True if this is a mobile number. If the number type is unknown this value will be false
    echo "is-mobile: ", (isset($data['is-mobile'])) ? var_export($data['is-mobile'], true) : "NULL", "\n";
    
    // The number represented in local dialing format
    echo "local-number: ", (isset($data['local-number'])) ? var_export($data['local-number'], true) : "NULL", "\n";
    
    // The phone number location. Could be the city, region or country depending on the type of number
    echo "location: ", (isset($data['location'])) ? var_export($data['location'], true) : "NULL", "\n";
    
    // The network/carrier who owns the prefix (this only works for some countries, use HLR lookup for
    // global network detection)
    echo "prefix-network: ", (isset($data['prefix-network'])) ? var_export($data['prefix-network'], true) : "NULL", "\n";
    
    // The number type based on the number prefix. Possible values are:
    // • mobile
    // • fixed-line
    // • premium-rate
    // • toll-free
    // • voip
    // • unknown (use HLR lookup)
    echo "type: ", (isset($data['type'])) ? var_export($data['type'], true) : "NULL", "\n";
    
    // Is this a valid phone number
    echo "valid: ", (isset($data['valid'])) ? var_export($data['valid'], true) : "NULL", "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}