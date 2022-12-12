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
    "ip" => "194.233.98.38"
);

$apiResponse = $neutrinoAPIClient->ipProbe($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // The age of the autonomous system (AS) in number of years since registration
    echo "as-age: ", (isset($data['as-age'])) ? var_export($data['as-age'], true) : "NULL", "\n";
    
    // The autonomous system (AS) CIDR range
    echo "as-cidr: ", (isset($data['as-cidr'])) ? var_export($data['as-cidr'], true) : "NULL", "\n";
    
    // The autonomous system (AS) ISO 2-letter country code
    echo "as-country-code: ", (isset($data['as-country-code'])) ? var_export($data['as-country-code'], true) : "NULL", "\n";
    
    // The autonomous system (AS) ISO 3-letter country code
    echo "as-country-code3: ", (isset($data['as-country-code3'])) ? var_export($data['as-country-code3'], true) : "NULL", "\n";
    
    // The autonomous system (AS) description / company name
    echo "as-description: ", (isset($data['as-description'])) ? var_export($data['as-description'], true) : "NULL", "\n";
    
    // Array of all the domains associated with the autonomous system (AS)
    echo "as-domains: ", (isset($data['as-domains'])) ? var_export($data['as-domains'], true) : "NULL", "\n";
    
    // The autonomous system (AS) number
    echo "asn: ", (isset($data['asn'])) ? var_export($data['asn'], true) : "NULL", "\n";
    
    // Full city name (if detectable)
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
    
    // The IPs host domain
    echo "host-domain: ", (isset($data['host-domain'])) ? var_export($data['host-domain'], true) : "NULL", "\n";
    
    // The IPs full hostname (PTR)
    echo "hostname: ", (isset($data['hostname'])) ? var_export($data['hostname'], true) : "NULL", "\n";
    
    // The IP address
    echo "ip: ", (isset($data['ip'])) ? var_export($data['ip'], true) : "NULL", "\n";
    
    // True if this is a bogon IP address such as a private network, local network or reserved address
    echo "is-bogon: ", (isset($data['is-bogon'])) ? var_export($data['is-bogon'], true) : "NULL", "\n";
    
    // True if this IP belongs to a hosting company. Note that this can still be true even if the
    // provider type is VPN/proxy, this occurs in the case that the IP is detected as both types
    echo "is-hosting: ", (isset($data['is-hosting'])) ? var_export($data['is-hosting'], true) : "NULL", "\n";
    
    // True if this IP belongs to an internet service provider. Note that this can still be true even if
    // the provider type is VPN/proxy, this occurs in the case that the IP is detected as both types
    echo "is-isp: ", (isset($data['is-isp'])) ? var_export($data['is-isp'], true) : "NULL", "\n";
    
    // True if this IP ia a proxy
    echo "is-proxy: ", (isset($data['is-proxy'])) ? var_export($data['is-proxy'], true) : "NULL", "\n";
    
    // True if this is a IPv4 mapped IPv6 address
    echo "is-v4-mapped: ", (isset($data['is-v4-mapped'])) ? var_export($data['is-v4-mapped'], true) : "NULL", "\n";
    
    // True if this is a IPv6 address. False if IPv4
    echo "is-v6: ", (isset($data['is-v6'])) ? var_export($data['is-v6'], true) : "NULL", "\n";
    
    // True if this IP ia a VPN
    echo "is-vpn: ", (isset($data['is-vpn'])) ? var_export($data['is-vpn'], true) : "NULL", "\n";
    
    // A description of the provider (usually extracted from the providers website)
    echo "provider-description: ", (isset($data['provider-description'])) ? var_export($data['provider-description'], true) : "NULL", "\n";
    
    // The domain name of the provider
    echo "provider-domain: ", (isset($data['provider-domain'])) ? var_export($data['provider-domain'], true) : "NULL", "\n";
    
    // The detected provider type, possible values are:
    // • isp - IP belongs to an internet service provider. This includes both mobile, home and
    //   business internet providers
    // • hosting - IP belongs to a hosting company. This includes website hosting, cloud computing
    //   platforms and colocation facilities
    // • vpn - IP belongs to a VPN provider
    // • proxy - IP belongs to a proxy service. This includes HTTP/SOCKS proxies and browser based
    //   proxies
    // • university - IP belongs to a university/college/campus
    // • government - IP belongs to a government department. This includes military facilities
    // • commercial - IP belongs to a commercial entity such as a corporate headquarters or company
    //   office
    // • unknown - could not identify the provider type
    echo "provider-type: ", (isset($data['provider-type'])) ? var_export($data['provider-type'], true) : "NULL", "\n";
    
    // The website URL for the provider
    echo "provider-website: ", (isset($data['provider-website'])) ? var_export($data['provider-website'], true) : "NULL", "\n";
    
    // Full region name (if detectable)
    echo "region: ", (isset($data['region'])) ? var_export($data['region'], true) : "NULL", "\n";
    
    // ISO 3166-2 region code (if detectable)
    echo "region-code: ", (isset($data['region-code'])) ? var_export($data['region-code'], true) : "NULL", "\n";
    
    // True if this is a valid IPv4 or IPv6 address
    echo "valid: ", (isset($data['valid'])) ? var_export($data['valid'], true) : "NULL", "\n";
    
    // The domain of the VPN provider (may be empty if the VPN domain is not detectable)
    echo "vpn-domain: ", (isset($data['vpn-domain'])) ? var_export($data['vpn-domain'], true) : "NULL", "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}