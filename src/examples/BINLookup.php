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
    echo "bin-number: ", var_export($data['bin-number'], true), "\n";
    
    // The card brand (e.g. Visa or Mastercard)
    echo "card-brand: ", var_export($data['card-brand'], true), "\n";
    
    // The card category. There are many different card categories the most common card categories are:
    // CLASSIC, BUSINESS, CORPORATE, PLATINUM, PREPAID
    echo "card-category: ", var_export($data['card-category'], true), "\n";
    
    // The card type, will always be one of: DEBIT, CREDIT, CHARGE CARD
    echo "card-type: ", var_export($data['card-type'], true), "\n";
    
    // The full country name of the issuer
    echo "country: ", var_export($data['country'], true), "\n";
    
    // The ISO 2-letter country code of the issuer
    echo "country-code: ", var_export($data['country-code'], true), "\n";
    
    // The ISO 3-letter country code of the issuer
    echo "country-code3: ", var_export($data['country-code3'], true), "\n";
    
    // ISO 4217 currency code associated with the country of the issuer
    echo "currency-code: ", var_export($data['currency-code'], true), "\n";
    
    // True if the customers IP is listed on one of our blocklists, see the IP Blocklist API
    echo "ip-blocklisted: ", var_export($data['ip-blocklisted'], true), "\n";
    
    // An array of strings indicating which blocklists this IP is listed on
    echo "ip-blocklists: ", var_export($data['ip-blocklists'], true), "\n";
    
    // The city of the customers IP (if detectable)
    echo "ip-city: ", var_export($data['ip-city'], true), "\n";
    
    // The country of the customers IP
    echo "ip-country: ", var_export($data['ip-country'], true), "\n";
    
    // The ISO 2-letter country code of the customers IP
    echo "ip-country-code: ", var_export($data['ip-country-code'], true), "\n";
    
    // The ISO 3-letter country code of the customers IP
    echo "ip-country-code3: ", var_export($data['ip-country-code3'], true), "\n";
    
    // True if the customers IP country matches the BIN country
    echo "ip-matches-bin: ", var_export($data['ip-matches-bin'], true), "\n";
    
    // The region of the customers IP (if detectable)
    echo "ip-region: ", var_export($data['ip-region'], true), "\n";
    
    // Is this a commercial/business use card
    echo "is-commercial: ", var_export($data['is-commercial'], true), "\n";
    
    // Is this a prepaid or prepaid reloadable card
    echo "is-prepaid: ", var_export($data['is-prepaid'], true), "\n";
    
    // The card issuer
    echo "issuer: ", var_export($data['issuer'], true), "\n";
    
    // The card issuers phone number
    echo "issuer-phone: ", var_export($data['issuer-phone'], true), "\n";
    
    // The card issuers website
    echo "issuer-website: ", var_export($data['issuer-website'], true), "\n";
    
    // Is this a valid BIN or IIN number
    echo "valid: ", var_export($data['valid'], true), "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}