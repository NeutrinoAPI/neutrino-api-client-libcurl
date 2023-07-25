<?php
require __DIR__ . '/../client/APIErrorCode.php';
require __DIR__ . '/../client/APIResponse.php';
require __DIR__ . '/../client/NeutrinoAPIClient.php';

$neutrinoAPIClient = new NeutrinoAPI\NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

$params = array(

    // An IP address, domain name, FQDN or URL. If you supply a domain/URL it will be checked against
    // the URI DNSBL lists
    "host" => "neutrinoapi.com",

    // Only check lists with this rating or better
    "list-rating" => "3",

    // Only check these DNSBL zones/hosts. Multiple zones can be supplied as comma-separated values
    "zones" => ""
);

$apiResponse = $neutrinoAPIClient->hostReputation($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // The IP address or host name
    echo "host: ", var_export($data['host'], true), "\n";
    
    // Is this host blacklisted
    echo "is-listed: ", var_export($data['is-listed'], true), "\n";
    
    // The number of DNSBLs the host is listed on
    echo "list-count: ", var_export($data['list-count'], true), "\n";
    
    // Array of objects for each DNSBL checked
    $lists = $data['lists'];
    echo "lists:\n";
    foreach ($lists as $listsItem) {

        // True if the host is currently black-listed
        echo "    is-listed: ", var_export($listsItem['is-listed'], true), "\n";

        // The hostname of the DNSBL
        echo "    list-host: ", var_export($listsItem['list-host'], true), "\n";

        // The name of the DNSBL
        echo "    list-name: ", var_export($listsItem['list-name'], true), "\n";

        // The list rating [1-3] with 1 being the best rating and 3 the lowest rating
        echo "    list-rating: ", var_export($listsItem['list-rating'], true), "\n";

        // The DNSBL server response time in milliseconds
        echo "    response-time: ", var_export($listsItem['response-time'], true), "\n";

        // The specific return code for this listing (only set if listed)
        echo "    return-code: ", var_export($listsItem['return-code'], true), "\n";

        // The TXT record returned for this listing (only set if listed)
        echo "    txt-record: ", var_export($listsItem['txt-record'], true), "\n";
        echo "\n";
    }
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}
