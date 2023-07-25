<?php
require __DIR__ . '/../client/APIErrorCode.php';
require __DIR__ . '/../client/APIResponse.php';
require __DIR__ . '/../client/NeutrinoAPIClient.php';

$neutrinoAPIClient = new NeutrinoAPI\NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

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
    echo "country: ", var_export($data['country'], true), "\n";
    
    // The number location as an ISO 2-letter country code
    echo "country-code: ", var_export($data['country-code'], true), "\n";
    
    // The number location as an ISO 3-letter country code
    echo "country-code3: ", var_export($data['country-code3'], true), "\n";
    
    // ISO 4217 currency code associated with the country
    echo "currency-code: ", var_export($data['currency-code'], true), "\n";
    
    // The currently used network/carrier name
    echo "current-network: ", var_export($data['current-network'], true), "\n";
    
    // The HLR lookup status, possible values are:
    // • ok - the HLR lookup was successful and the device is connected
    // • absent - the number was once registered but the device has been switched off or out of
    //   network range for some time
    // • unknown - the number is not known by the mobile network
    // • invalid - the number is not a valid mobile MSISDN number
    // • fixed-line - the number is a registered fixed-line not mobile
    // • voip - the number has been detected as a VOIP line
    // • failed - the HLR lookup has failed, we could not determine the real status of this number
    echo "hlr-status: ", var_export($data['hlr-status'], true), "\n";
    
    // Was the HLR lookup successful. If true then this is a working and registered cell-phone or mobile
    // device (SMS and phone calls will be delivered)
    echo "hlr-valid: ", var_export($data['hlr-valid'], true), "\n";
    
    // The mobile IMSI number (International Mobile Subscriber Identity)
    echo "imsi: ", var_export($data['imsi'], true), "\n";
    
    // The international calling code
    echo "international-calling-code: ", var_export($data['international-calling-code'], true), "\n";
    
    // The number represented in full international format
    echo "international-number: ", var_export($data['international-number'], true), "\n";
    
    // True if this is a mobile number (only true with 100% certainty, if the number type is unknown
    // this value will be false)
    echo "is-mobile: ", var_export($data['is-mobile'], true), "\n";
    
    // Has this number been ported to another network
    echo "is-ported: ", var_export($data['is-ported'], true), "\n";
    
    // Is this number currently roaming from its origin country
    echo "is-roaming: ", var_export($data['is-roaming'], true), "\n";
    
    // The number represented in local dialing format
    echo "local-number: ", var_export($data['local-number'], true), "\n";
    
    // The number location. Could be a city, region or country depending on the type of number
    echo "location: ", var_export($data['location'], true), "\n";
    
    // The mobile MCC number (Mobile Country Code)
    echo "mcc: ", var_export($data['mcc'], true), "\n";
    
    // The mobile MNC number (Mobile Network Code)
    echo "mnc: ", var_export($data['mnc'], true), "\n";
    
    // The mobile MSC number (Mobile Switching Center)
    echo "msc: ", var_export($data['msc'], true), "\n";
    
    // The mobile MSIN number (Mobile Subscription Identification Number)
    echo "msin: ", var_export($data['msin'], true), "\n";
    
    // The number type, possible values are:
    // • mobile
    // • fixed-line
    // • premium-rate
    // • toll-free
    // • voip
    // • unknown
    echo "number-type: ", var_export($data['number-type'], true), "\n";
    
    // True if this a valid phone number
    echo "number-valid: ", var_export($data['number-valid'], true), "\n";
    
    // The origin network/carrier name
    echo "origin-network: ", var_export($data['origin-network'], true), "\n";
    
    // The ported to network/carrier name (only set if the number has been ported)
    echo "ported-network: ", var_export($data['ported-network'], true), "\n";
    
    // If the number is currently roaming, the ISO 2-letter country code of the roaming in country
    echo "roaming-country-code: ", var_export($data['roaming-country-code'], true), "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}
