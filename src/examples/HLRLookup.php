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

    // A phone number
    "number" => "+12106100045",

    // ISO 2-letter country code, assume numbers are based in this country. If not set numbers are
    // assumed to be in international format (with or without the leading + sign)
    "country-code" => ""
);

$apiResponse = $neutrinoAPIClient->hlrLookup($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // The phone number country
    echo "country: ", (isset($data['country'])) ? var_export($data['country'], true) : "NULL", "\n";
    
    // The number location as an ISO 2-letter country code
    echo "country-code: ", (isset($data['country-code'])) ? var_export($data['country-code'], true) : "NULL", "\n";
    
    // The number location as an ISO 3-letter country code
    echo "country-code3: ", (isset($data['country-code3'])) ? var_export($data['country-code3'], true) : "NULL", "\n";
    
    // ISO 4217 currency code associated with the country
    echo "currency-code: ", (isset($data['currency-code'])) ? var_export($data['currency-code'], true) : "NULL", "\n";
    
    // The currently used network/carrier name
    echo "current-network: ", (isset($data['current-network'])) ? var_export($data['current-network'], true) : "NULL", "\n";
    
    // The HLR lookup status, possible values are:
    // • ok - the HLR lookup was successful and the device is connected
    // • absent - the number was once registered but the device has been switched off or out of
    //   network range for some time
    // • unknown - the number is not known by the mobile network
    // • invalid - the number is not a valid mobile MSISDN number
    // • fixed-line - the number is a registered fixed-line not mobile
    // • voip - the number has been detected as a VOIP line
    // • failed - the HLR lookup has failed, we could not determine the real status of this number
    echo "hlr-status: ", (isset($data['hlr-status'])) ? var_export($data['hlr-status'], true) : "NULL", "\n";
    
    // Was the HLR lookup successful. If true then this is a working and registered cell-phone or mobile
    // device (SMS and phone calls will be delivered)
    echo "hlr-valid: ", (isset($data['hlr-valid'])) ? var_export($data['hlr-valid'], true) : "NULL", "\n";
    
    // The mobile IMSI number (International Mobile Subscriber Identity)
    echo "imsi: ", (isset($data['imsi'])) ? var_export($data['imsi'], true) : "NULL", "\n";
    
    // The international calling code
    echo "international-calling-code: ", (isset($data['international-calling-code'])) ? var_export($data['international-calling-code'], true) : "NULL", "\n";
    
    // The number represented in full international format
    echo "international-number: ", (isset($data['international-number'])) ? var_export($data['international-number'], true) : "NULL", "\n";
    
    // True if this is a mobile number (only true with 100% certainty, if the number type is unknown
    // this value will be false)
    echo "is-mobile: ", (isset($data['is-mobile'])) ? var_export($data['is-mobile'], true) : "NULL", "\n";
    
    // Has this number been ported to another network
    echo "is-ported: ", (isset($data['is-ported'])) ? var_export($data['is-ported'], true) : "NULL", "\n";
    
    // Is this number currently roaming from its origin country
    echo "is-roaming: ", (isset($data['is-roaming'])) ? var_export($data['is-roaming'], true) : "NULL", "\n";
    
    // The number represented in local dialing format
    echo "local-number: ", (isset($data['local-number'])) ? var_export($data['local-number'], true) : "NULL", "\n";
    
    // The number location. Could be a city, region or country depending on the type of number
    echo "location: ", (isset($data['location'])) ? var_export($data['location'], true) : "NULL", "\n";
    
    // The mobile MCC number (Mobile Country Code)
    echo "mcc: ", (isset($data['mcc'])) ? var_export($data['mcc'], true) : "NULL", "\n";
    
    // The mobile MNC number (Mobile Network Code)
    echo "mnc: ", (isset($data['mnc'])) ? var_export($data['mnc'], true) : "NULL", "\n";
    
    // The mobile MSC number (Mobile Switching Center)
    echo "msc: ", (isset($data['msc'])) ? var_export($data['msc'], true) : "NULL", "\n";
    
    // The mobile MSIN number (Mobile Subscription Identification Number)
    echo "msin: ", (isset($data['msin'])) ? var_export($data['msin'], true) : "NULL", "\n";
    
    // The number type, possible values are:
    // • mobile
    // • fixed-line
    // • premium-rate
    // • toll-free
    // • voip
    // • unknown
    echo "number-type: ", (isset($data['number-type'])) ? var_export($data['number-type'], true) : "NULL", "\n";
    
    // True if this a valid phone number
    echo "number-valid: ", (isset($data['number-valid'])) ? var_export($data['number-valid'], true) : "NULL", "\n";
    
    // The origin network/carrier name
    echo "origin-network: ", (isset($data['origin-network'])) ? var_export($data['origin-network'], true) : "NULL", "\n";
    
    // The ported to network/carrier name (only set if the number has been ported)
    echo "ported-network: ", (isset($data['ported-network'])) ? var_export($data['ported-network'], true) : "NULL", "\n";
    
    // If the number is currently roaming, the ISO 2-letter country code of the roaming in country
    echo "roaming-country-code: ", (isset($data['roaming-country-code'])) ? var_export($data['roaming-country-code'], true) : "NULL", "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}