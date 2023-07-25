<?php
require __DIR__ . '/../client/APIErrorCode.php';
require __DIR__ . '/../client/APIResponse.php';
require __DIR__ . '/../client/NeutrinoAPIClient.php';

$neutrinoAPIClient = new NeutrinoAPI\NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

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
    echo "country: ", var_export($data['country'], true), "\n";
    
    // The phone number country as an ISO 2-letter country code
    echo "country-code: ", var_export($data['country-code'], true), "\n";
    
    // The phone number country as an ISO 3-letter country code
    echo "country-code3: ", var_export($data['country-code3'], true), "\n";
    
    // ISO 4217 currency code associated with the country
    echo "currency-code: ", var_export($data['currency-code'], true), "\n";
    
    // The international calling code
    echo "international-calling-code: ", var_export($data['international-calling-code'], true), "\n";
    
    // The number represented in full international format (E.164)
    echo "international-number: ", var_export($data['international-number'], true), "\n";
    
    // True if this is a mobile number. If the number type is unknown this value will be false
    echo "is-mobile: ", var_export($data['is-mobile'], true), "\n";
    
    // The number represented in local dialing format
    echo "local-number: ", var_export($data['local-number'], true), "\n";
    
    // The phone number location. Could be the city, region or country depending on the type of number
    echo "location: ", var_export($data['location'], true), "\n";
    
    // The network/carrier who owns the prefix (this only works for some countries, use HLR lookup for
    // global network detection)
    echo "prefix-network: ", var_export($data['prefix-network'], true), "\n";
    
    // The number type based on the number prefix. Possible values are:
    // • mobile
    // • fixed-line
    // • premium-rate
    // • toll-free
    // • voip
    // • unknown (use HLR lookup)
    echo "type: ", var_export($data['type'], true), "\n";
    
    // Is this a valid phone number
    echo "valid: ", var_export($data['valid'], true), "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}
