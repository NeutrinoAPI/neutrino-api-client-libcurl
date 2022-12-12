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
    echo "city: ", (isset($data['city'])) ? var_export($data['city'], true) : "NULL", "\n";
    
    // ISO 2-letter continent code
    echo "continent-code: ", (isset($data['continent-code'])) ? var_export($data['continent-code'], true) : "NULL", "\n";
    
    // Full country name
    echo "country: ", (isset($data['country'])) ? var_export($data['country'], true) : "NULL", "\n";
    
    // ISO 2-letter country code
    echo "country-code: ", (isset($data['country-code'])) ? var_export($data['country-code'], true) : "NULL", "\n";
    
    // ISO 3-letter country code
    echo "country-code3: ", (isset($data['country-code3'])) ? var_export($data['country-code3'], true) : "NULL", "\n";
    
    // ISO 4217 currency code associated with the country
    echo "currency-code: ", (isset($data['currency-code'])) ? var_export($data['currency-code'], true) : "NULL", "\n";
    
    // The IPs host domain (only set if reverse-lookup has been used)
    echo "host-domain: ", (isset($data['host-domain'])) ? var_export($data['host-domain'], true) : "NULL", "\n";
    
    // The IPs full hostname (only set if reverse-lookup has been used)
    echo "hostname: ", (isset($data['hostname'])) ? var_export($data['hostname'], true) : "NULL", "\n";
    
    // The IP address
    echo "ip: ", (isset($data['ip'])) ? var_export($data['ip'], true) : "NULL", "\n";
    
    // True if this is a bogon IP address such as a private network, local network or reserved address
    echo "is-bogon: ", (isset($data['is-bogon'])) ? var_export($data['is-bogon'], true) : "NULL", "\n";
    
    // True if this is a IPv4 mapped IPv6 address
    echo "is-v4-mapped: ", (isset($data['is-v4-mapped'])) ? var_export($data['is-v4-mapped'], true) : "NULL", "\n";
    
    // True if this is a IPv6 address. False if IPv4
    echo "is-v6: ", (isset($data['is-v6'])) ? var_export($data['is-v6'], true) : "NULL", "\n";
    
    // Location latitude
    echo "latitude: ", (isset($data['latitude'])) ? var_export($data['latitude'], true) : "NULL", "\n";
    
    // Location longitude
    echo "longitude: ", (isset($data['longitude'])) ? var_export($data['longitude'], true) : "NULL", "\n";
    
    // Name of the region (if detectable)
    echo "region: ", (isset($data['region'])) ? var_export($data['region'], true) : "NULL", "\n";
    
    // ISO 3166-2 region code (if detectable)
    echo "region-code: ", (isset($data['region-code'])) ? var_export($data['region-code'], true) : "NULL", "\n";
    
    // Map containing timezone details for the location
    echo "timezone: ", (isset($data['timezone'])) ? var_export($data['timezone'], true) : "NULL", "\n";
    
    // True if this is a valid IPv4 or IPv6 address
    echo "valid: ", (isset($data['valid'])) ? var_export($data['valid'], true) : "NULL", "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}