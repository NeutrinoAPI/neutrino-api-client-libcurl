<?php
require __DIR__ . '/../client/APIErrorCode.php';
require __DIR__ . '/../client/APIResponse.php';
require __DIR__ . '/../client/NeutrinoAPIClient.php';

$neutrinoAPIClient = new NeutrinoAPI\NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

$params = array(

    // A domain name, hostname, FQDN, URL, HTML link or email address to lookup
    "host" => "neutrinoapi.com",

    // For domains that we have never seen before then perform various live checks and realtime
    // reconnaissance. NOTE: this option may add additional non-deterministic delay to the request, if
    // you require consistently fast API response times or just want to check our domain blocklists then
    // you can disable this option
    "live" => "true"
);

$apiResponse = $neutrinoAPIClient->domainLookup($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // The number of days since the domain was registered. A domain age of under 90 days is generally
    // considered to be potentially risky. A value of 0 indicates no registration date was found for
    // this domain
    echo "age: ", var_export($data['age'], true), "\n";
    
    // An array of strings indicating which blocklist categories this domain is listed on. Current
    // possible values are:
    // • phishing - Domain has recently been hosting phishing links or involved in the sending of
    //   phishing messages
    // • malware - Domain has recently been hosting malware or involved in the distribution of malware
    // • spam - Domain has recently been sending spam either directly or indirectly
    // • anonymizer - Domain is involved in anonymizer activity such as disposable email, hosting
    //   proxies or tor services
    // • nefarious - Domain is involved in nefarious or malicious activity such as hacking, fraud or
    //   other abusive behavior
    echo "blocklists: ", var_export($data['blocklists'], true), "\n";
    
    // The primary domain of the DNS provider for this domain
    echo "dns-provider: ", var_export($data['dns-provider'], true), "\n";
    
    // The primary domain name excluding any subdomains. This is also referred to as the second-level
    // domain (SLD)
    echo "domain: ", var_export($data['domain'], true), "\n";
    
    // The fully qualified domain name (FQDN)
    echo "fqdn: ", var_export($data['fqdn'], true), "\n";
    
    // This domain is hosting adult content such as porn, webcams, escorts, etc
    echo "is-adult: ", var_export($data['is-adult'], true), "\n";
    
    // Is this domain under a government or military TLD
    echo "is-gov: ", var_export($data['is-gov'], true), "\n";
    
    // Consider this domain malicious as it is currently listed on at least 1 blocklist
    echo "is-malicious: ", var_export($data['is-malicious'], true), "\n";
    
    // Is this domain under an OpenNIC TLD
    echo "is-opennic: ", var_export($data['is-opennic'], true), "\n";
    
    // True if this domain is unseen and is currently being processed in the background. This field only
    // matters when the 'live' lookup setting has been explicitly disabled and indicates that not all
    // domain data my be present yet
    echo "is-pending: ", var_export($data['is-pending'], true), "\n";
    
    // Is the FQDN a subdomain of the primary domain
    echo "is-subdomain: ", var_export($data['is-subdomain'], true), "\n";
    
    // The primary domain of the email provider for this domain. An empty value indicates the domain has
    // no valid MX records
    echo "mail-provider: ", var_export($data['mail-provider'], true), "\n";
    
    // The domains estimated global traffic rank with the highest rank being 1. A value of 0 indicates
    // the domain is currently ranked outside of the top 1M of domains
    echo "rank: ", var_export($data['rank'], true), "\n";
    
    // The ISO date this domain was registered or first seen on the internet. An empty value indicates
    // we could not reliably determine the date
    echo "registered-date: ", var_export($data['registered-date'], true), "\n";
    
    // The IANA registrar ID (0 if no registrar ID was found)
    echo "registrar-id: ", var_export($data['registrar-id'], true), "\n";
    
    // The name of the domain registrar owning this domain
    echo "registrar-name: ", var_export($data['registrar-name'], true), "\n";
    
    // An array of objects containing details on which specific blocklist sensors have detected this
    // domain
    $sensors = $data['sensors'];
    echo "sensors:\n";
    foreach ($sensors as $sensorsItem) {

        // The primary blocklist category this sensor belongs to
        echo "    blocklist: ", var_export($sensorsItem['blocklist'], true), "\n";

        // Contains details about the sensor source and what type of malicious activity was detected
        echo "    description: ", var_export($sensorsItem['description'], true), "\n";

        // The sensor ID. This is a permanent and unique ID for each sensor
        echo "    id: ", var_export($sensorsItem['id'], true), "\n";
        echo "\n";
    }
    
    // The top-level domain (TLD)
    echo "tld: ", var_export($data['tld'], true), "\n";
    
    // For a country code top-level domain (ccTLD) this will contain the associated ISO 2-letter country
    // code
    echo "tld-cc: ", var_export($data['tld-cc'], true), "\n";
    
    // True if a valid domain was found. For a domain to be considered valid it must be registered and
    // have valid DNS NS records
    echo "valid: ", var_export($data['valid'], true), "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}
