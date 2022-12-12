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

    // The BIN or IIN number. This is the first 6, 8 or 10 digits of a card number, use 8 (or more)
    // digits for the highest level of accuracy
    "bin-number" => "47192100",

    // Pass in the customers IP address and we will return some extra information about them
    "customer-ip" => ""
);

$apiResponse = $neutrinoAPIClient->binLookup($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // The BIN or IIN number
    echo "bin-number: ", (isset($data['bin-number'])) ? var_export($data['bin-number'], true) : "NULL", "\n";
    
    // The card brand (e.g. Visa or Mastercard)
    echo "card-brand: ", (isset($data['card-brand'])) ? var_export($data['card-brand'], true) : "NULL", "\n";
    
    // The card category. There are many different card categories the most common card categories are:
    // CLASSIC, BUSINESS, CORPORATE, PLATINUM, PREPAID
    echo "card-category: ", (isset($data['card-category'])) ? var_export($data['card-category'], true) : "NULL", "\n";
    
    // The card type, will always be one of: DEBIT, CREDIT, CHARGE CARD
    echo "card-type: ", (isset($data['card-type'])) ? var_export($data['card-type'], true) : "NULL", "\n";
    
    // The full country name of the issuer
    echo "country: ", (isset($data['country'])) ? var_export($data['country'], true) : "NULL", "\n";
    
    // The ISO 2-letter country code of the issuer
    echo "country-code: ", (isset($data['country-code'])) ? var_export($data['country-code'], true) : "NULL", "\n";
    
    // The ISO 3-letter country code of the issuer
    echo "country-code3: ", (isset($data['country-code3'])) ? var_export($data['country-code3'], true) : "NULL", "\n";
    
    // ISO 4217 currency code associated with the country of the issuer
    echo "currency-code: ", (isset($data['currency-code'])) ? var_export($data['currency-code'], true) : "NULL", "\n";
    
    // True if the customers IP is listed on one of our blocklists, see the IP Blocklist API
    echo "ip-blocklisted: ", (isset($data['ip-blocklisted'])) ? var_export($data['ip-blocklisted'], true) : "NULL", "\n";
    
    // An array of strings indicating which blocklists this IP is listed on
    echo "ip-blocklists: ", (isset($data['ip-blocklists'])) ? var_export($data['ip-blocklists'], true) : "NULL", "\n";
    
    // The city of the customers IP (if detectable)
    echo "ip-city: ", (isset($data['ip-city'])) ? var_export($data['ip-city'], true) : "NULL", "\n";
    
    // The country of the customers IP
    echo "ip-country: ", (isset($data['ip-country'])) ? var_export($data['ip-country'], true) : "NULL", "\n";
    
    // The ISO 2-letter country code of the customers IP
    echo "ip-country-code: ", (isset($data['ip-country-code'])) ? var_export($data['ip-country-code'], true) : "NULL", "\n";
    
    // The ISO 3-letter country code of the customers IP
    echo "ip-country-code3: ", (isset($data['ip-country-code3'])) ? var_export($data['ip-country-code3'], true) : "NULL", "\n";
    
    // True if the customers IP country matches the BIN country
    echo "ip-matches-bin: ", (isset($data['ip-matches-bin'])) ? var_export($data['ip-matches-bin'], true) : "NULL", "\n";
    
    // The region of the customers IP (if detectable)
    echo "ip-region: ", (isset($data['ip-region'])) ? var_export($data['ip-region'], true) : "NULL", "\n";
    
    // Is this a commercial/business use card
    echo "is-commercial: ", (isset($data['is-commercial'])) ? var_export($data['is-commercial'], true) : "NULL", "\n";
    
    // Is this a prepaid or prepaid reloadable card
    echo "is-prepaid: ", (isset($data['is-prepaid'])) ? var_export($data['is-prepaid'], true) : "NULL", "\n";
    
    // The card issuer
    echo "issuer: ", (isset($data['issuer'])) ? var_export($data['issuer'], true) : "NULL", "\n";
    
    // The card issuers phone number
    echo "issuer-phone: ", (isset($data['issuer-phone'])) ? var_export($data['issuer-phone'], true) : "NULL", "\n";
    
    // The card issuers website
    echo "issuer-website: ", (isset($data['issuer-website'])) ? var_export($data['issuer-website'], true) : "NULL", "\n";
    
    // Is this a valid BIN or IIN number
    echo "valid: ", (isset($data['valid'])) ? var_export($data['valid'], true) : "NULL", "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}