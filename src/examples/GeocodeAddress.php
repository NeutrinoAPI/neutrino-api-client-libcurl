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

    // The full address, partial address or name of a place to try and locate. Comma separated address
    // components are preferred.
    "address" => "1 Molesworth Street, Thorndon, Wellington 6011",

    // The house/building number to locate
    "house-number" => "",

    // The street/road name to locate
    "street" => "",

    // The city/town name to locate
    "city" => "",

    // The county/region name to locate
    "county" => "",

    // The state name to locate
    "state" => "",

    // The postal code to locate
    "postal-code" => "",

    // Limit result to this country (the default is no country bias)
    "country-code" => "",

    // The language to display results in, available languages are:
    // • de, en, es, fr, it, pt, ru, zh
    "language-code" => "en",

    // If no matches are found for the given address, start performing a recursive fuzzy search until a
    // geolocation is found. This option is recommended for processing user input or implementing
    // auto-complete. We use a combination of approximate string matching and data cleansing to find
    // possible location matches
    "fuzzy-search" => "false"
);

$apiResponse = $neutrinoAPIClient->geocodeAddress($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // The number of possible matching locations found
    echo "found: ", (isset($data['found'])) ? var_export($data['found'], true) : "NULL", "\n";
    
    // Array of matching location objects
    $locations = $data['locations'];
    echo "locations:\n";
    foreach ($locations as $locationsItem) {

        // The fully formatted address
        echo "    address: ", (isset($locationsItem['address'])) ? var_export($locationsItem['address'], true) : "NULL", "\n";

        // The components which make up the address such as road, city, state, etc
        echo "    address-components: ", (isset($locationsItem['address-components'])) ? var_export($locationsItem['address-components'], true) : "NULL", "\n";

        // The city of the location
        echo "    city: ", (isset($locationsItem['city'])) ? var_export($locationsItem['city'], true) : "NULL", "\n";

        // The country of the location
        echo "    country: ", (isset($locationsItem['country'])) ? var_export($locationsItem['country'], true) : "NULL", "\n";

        // The ISO 2-letter country code of the location
        echo "    country-code: ", (isset($locationsItem['country-code'])) ? var_export($locationsItem['country-code'], true) : "NULL", "\n";

        // The ISO 3-letter country code of the location
        echo "    country-code3: ", (isset($locationsItem['country-code3'])) ? var_export($locationsItem['country-code3'], true) : "NULL", "\n";

        // ISO 4217 currency code associated with the country
        echo "    currency-code: ", (isset($locationsItem['currency-code'])) ? var_export($locationsItem['currency-code'], true) : "NULL", "\n";

        // The location latitude
        echo "    latitude: ", (isset($locationsItem['latitude'])) ? var_export($locationsItem['latitude'], true) : "NULL", "\n";

        // Array of strings containing any location tags associated with the address. Tags are additional
        // pieces of metadata about a specific location, there are thousands of different tags. Some
        // examples of tags: shop, office, cafe, bank, pub
        echo "    location-tags: ", (isset($locationsItem['location-tags'])) ? var_export($locationsItem['location-tags'], true) : "NULL", "\n";

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
        echo "    location-type: ", (isset($locationsItem['location-type'])) ? var_export($locationsItem['location-type'], true) : "NULL", "\n";

        // The location longitude
        echo "    longitude: ", (isset($locationsItem['longitude'])) ? var_export($locationsItem['longitude'], true) : "NULL", "\n";

        // The postal code for the location
        echo "    postal-code: ", (isset($locationsItem['postal-code'])) ? var_export($locationsItem['postal-code'], true) : "NULL", "\n";

        // The state of the location
        echo "    state: ", (isset($locationsItem['state'])) ? var_export($locationsItem['state'], true) : "NULL", "\n";

        // Map containing timezone details for the location
        echo "    timezone: ", (isset($locationsItem['timezone'])) ? var_export($locationsItem['timezone'], true) : "NULL", "\n";
        echo "\n";
    }
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}