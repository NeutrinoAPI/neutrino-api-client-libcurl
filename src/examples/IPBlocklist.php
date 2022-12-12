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

    // An IPv4 or IPv6 address. Accepts standard IP notation (with or without port number), CIDR
    // notation and IPv6 compressed notation. If multiple IPs are passed using comma-separated values
    // the first non-bogon address on the list will be checked
    "ip" => "104.244.72.115",

    // Include public VPN provider IP addresses. NOTE: For more advanced VPN detection including the
    // ability to identify private and stealth VPNs use the IP Probe API
    "vpn-lookup" => "false"
);

$apiResponse = $neutrinoAPIClient->ipBlocklist($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // An array of strings indicating which blocklist categories this IP is listed on
    echo "blocklists: ", (isset($data['blocklists'])) ? var_export($data['blocklists'], true) : "NULL", "\n";
    
    // The CIDR address for this listing (only set if the IP is listed)
    echo "cidr: ", (isset($data['cidr'])) ? var_export($data['cidr'], true) : "NULL", "\n";
    
    // The IP address
    echo "ip: ", (isset($data['ip'])) ? var_export($data['ip'], true) : "NULL", "\n";
    
    // IP is hosting a malicious bot or is part of a botnet. This is a broad category which includes
    // brute-force crackers
    echo "is-bot: ", (isset($data['is-bot'])) ? var_export($data['is-bot'], true) : "NULL", "\n";
    
    // IP has been flagged as a significant attack source by DShield (dshield.org)
    echo "is-dshield: ", (isset($data['is-dshield'])) ? var_export($data['is-dshield'], true) : "NULL", "\n";
    
    // IP is hosting an exploit finding bot or is running exploit scanning software
    echo "is-exploit-bot: ", (isset($data['is-exploit-bot'])) ? var_export($data['is-exploit-bot'], true) : "NULL", "\n";
    
    // IP is part of a hijacked netblock or a netblock controlled by a criminal organization
    echo "is-hijacked: ", (isset($data['is-hijacked'])) ? var_export($data['is-hijacked'], true) : "NULL", "\n";
    
    // Is this IP on a blocklist
    echo "is-listed: ", (isset($data['is-listed'])) ? var_export($data['is-listed'], true) : "NULL", "\n";
    
    // IP is involved in distributing or is running malware
    echo "is-malware: ", (isset($data['is-malware'])) ? var_export($data['is-malware'], true) : "NULL", "\n";
    
    // IP has been detected as an anonymous web proxy or anonymous HTTP proxy
    echo "is-proxy: ", (isset($data['is-proxy'])) ? var_export($data['is-proxy'], true) : "NULL", "\n";
    
    // IP address is hosting a spam bot, comment spamming or any other spamming type software
    echo "is-spam-bot: ", (isset($data['is-spam-bot'])) ? var_export($data['is-spam-bot'], true) : "NULL", "\n";
    
    // IP is running a hostile web spider / web crawler
    echo "is-spider: ", (isset($data['is-spider'])) ? var_export($data['is-spider'], true) : "NULL", "\n";
    
    // IP is involved in distributing or is running spyware
    echo "is-spyware: ", (isset($data['is-spyware'])) ? var_export($data['is-spyware'], true) : "NULL", "\n";
    
    // IP is a Tor node or running a Tor related service
    echo "is-tor: ", (isset($data['is-tor'])) ? var_export($data['is-tor'], true) : "NULL", "\n";
    
    // IP belongs to a public VPN provider (only set if the 'vpn-lookup' option is enabled)
    echo "is-vpn: ", (isset($data['is-vpn'])) ? var_export($data['is-vpn'], true) : "NULL", "\n";
    
    // The unix time when this IP was last seen on any blocklist. IPs are automatically removed after 7
    // days therefor this value will never be older than 7 days
    echo "last-seen: ", (isset($data['last-seen'])) ? var_export($data['last-seen'], true) : "NULL", "\n";
    
    // The number of blocklists the IP is listed on
    echo "list-count: ", (isset($data['list-count'])) ? var_export($data['list-count'], true) : "NULL", "\n";
    
    // An array of objects containing details on which specific sensors detected the IP
    $sensors = $data['sensors'];
    echo "sensors:\n";
    foreach ($sensors as $sensorsItem) {

        // The primary blocklist category this sensor belongs to
        echo "    blocklist: ", (isset($sensorsItem['blocklist'])) ? var_export($sensorsItem['blocklist'], true) : "NULL", "\n";

        // Contains details about the sensor source and what type of malicious activity was detected
        echo "    description: ", (isset($sensorsItem['description'])) ? var_export($sensorsItem['description'], true) : "NULL", "\n";

        // The sensor ID. This is a permanent and unique ID for each sensor
        echo "    id: ", (isset($sensorsItem['id'])) ? var_export($sensorsItem['id'], true) : "NULL", "\n";
        echo "\n";
    }
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}