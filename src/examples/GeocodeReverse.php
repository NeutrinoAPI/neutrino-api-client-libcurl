<?php
require __DIR__ . '/../client/APIErrorCode.php';
require __DIR__ . '/../client/APIResponse.php';
require __DIR__ . '/../client/NeutrinoAPIClient.php';

$neutrinoAPIClient = new NeutrinoAPI\NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

$params = array(

    // The location latitude in decimal degrees format
    "latitude" => "-41.2775847",

    // The location longitude in decimal degrees format
    "longitude" => "174.7775229",

    // The language to display results in, available languages are:
    // • de, en, es, fr, it, pt, ru
    "language-code" => "en",

    // The zoom level to respond with:
    // • address - the most precise address available
    // • street - the street level
    // • city - the city level
    // • state - the state level
    // • country - the country level
    "zoom" => "address"
);

$apiResponse = $neutrinoAPIClient->geocodeReverse($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // The complete address using comma-separated values
    echo "address: ", var_export($data['address'], true), "\n";
    
    // The components which make up the address such as road, city, state, etc
    echo "address-components: ", var_export($data['address-components'], true), "\n";
    
    // The city of the location
    echo "city: ", var_export($data['city'], true), "\n";
    
    // The country of the location
    echo "country: ", var_export($data['country'], true), "\n";
    
    // The ISO 2-letter country code of the location
    echo "country-code: ", var_export($data['country-code'], true), "\n";
    
    // The ISO 3-letter country code of the location
    echo "country-code3: ", var_export($data['country-code3'], true), "\n";
    
    // ISO 4217 currency code associated with the country
    echo "currency-code: ", var_export($data['currency-code'], true), "\n";
    
    // True if these coordinates map to a real location
    echo "found: ", var_export($data['found'], true), "\n";
    
    // The ISO 2-letter language code for the official language spoken in the country
    echo "language-code: ", var_export($data['language-code'], true), "\n";
    
    // The location latitude
    echo "latitude: ", var_export($data['latitude'], true), "\n";
    
    // Array of strings containing any location tags associated with the address. Tags are additional
    // pieces of metadata about a specific location, there are thousands of different tags. Some
    // examples of tags: shop, office, cafe, bank, pub
    echo "location-tags: ", var_export($data['location-tags'], true), "\n";
    
    // The detected location type ordered roughly from most to least precise, possible values are:
    // • address - indicates a precise street address
    // • street - accurate to the street level but may not point to the exact location of the
    //   house/building number
    // • city - accurate to the city level, this includes villages, towns, suburbs, etc
    // • postal-code - indicates a postal code area (no house or street information present)
    // • railway - location is part of a rail network such as a station or railway track
    // • natural - indicates a natural feature, for example a mountain peak or a waterway
    // • island - location is an island or archipelago
    // • administrative - indicates an administrative boundary such as a country, state or province
    echo "location-type: ", var_export($data['location-type'], true), "\n";
    
    // The location longitude
    echo "longitude: ", var_export($data['longitude'], true), "\n";
    
    // The formatted address using local standards suitable for printing on an envelope
    echo "postal-address: ", var_export($data['postal-address'], true), "\n";
    
    // The postal code for the location
    echo "postal-code: ", var_export($data['postal-code'], true), "\n";
    
    // The ISO 3166-2 region code for the location
    echo "region-code: ", var_export($data['region-code'], true), "\n";
    
    // The state of the location
    echo "state: ", var_export($data['state'], true), "\n";
    
    // Structure of timezone
    echo "timezone: ", var_export($data['timezone'], true), "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}
