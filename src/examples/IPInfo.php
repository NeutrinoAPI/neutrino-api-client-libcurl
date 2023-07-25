<?php
require __DIR__ . '/../client/APIErrorCode.php';
require __DIR__ . '/../client/APIResponse.php';
require __DIR__ . '/../client/NeutrinoAPIClient.php';

$neutrinoAPIClient = new NeutrinoAPI\NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

$params = array(

    // IPv4 or IPv6 address
    "ip" => "1.1.1.1",

    // Do a reverse DNS (PTR) lookup. This option can add extra delay to the request so only use it if
    // you need it
    "reverse-lookup" => "false"
);

$apiResponse = $neutrinoAPIClient->ipInfo($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // Name of the city (if detectable)
    echo "city: ", var_export($data['city'], true), "\n";
    
    // ISO 2-letter continent code
    echo "continent-code: ", var_export($data['continent-code'], true), "\n";
    
    // Full country name
    echo "country: ", var_export($data['country'], true), "\n";
    
    // ISO 2-letter country code
    echo "country-code: ", var_export($data['country-code'], true), "\n";
    
    // ISO 3-letter country code
    echo "country-code3: ", var_export($data['country-code3'], true), "\n";
    
    // ISO 4217 currency code associated with the country
    echo "currency-code: ", var_export($data['currency-code'], true), "\n";
    
    // The IPs host domain (only set if reverse-lookup has been used)
    echo "host-domain: ", var_export($data['host-domain'], true), "\n";
    
    // The IPs full hostname (only set if reverse-lookup has been used)
    echo "hostname: ", var_export($data['hostname'], true), "\n";
    
    // The IP address
    echo "ip: ", var_export($data['ip'], true), "\n";
    
    // True if this is a bogon IP address such as a private network, local network or reserved address
    echo "is-bogon: ", var_export($data['is-bogon'], true), "\n";
    
    // True if this is a IPv4 mapped IPv6 address
    echo "is-v4-mapped: ", var_export($data['is-v4-mapped'], true), "\n";
    
    // True if this is a IPv6 address. False if IPv4
    echo "is-v6: ", var_export($data['is-v6'], true), "\n";
    
    // Location latitude
    echo "latitude: ", var_export($data['latitude'], true), "\n";
    
    // Location longitude
    echo "longitude: ", var_export($data['longitude'], true), "\n";
    
    // Name of the region (if detectable)
    echo "region: ", var_export($data['region'], true), "\n";
    
    // ISO 3166-2 region code (if detectable)
    echo "region-code: ", var_export($data['region-code'], true), "\n";
    
    // Map containing timezone details
    echo "timezone: ", var_export($data['timezone'], true), "\n";
    
    // True if this is a valid IPv4 or IPv6 address
    echo "valid: ", var_export($data['valid'], true), "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}
