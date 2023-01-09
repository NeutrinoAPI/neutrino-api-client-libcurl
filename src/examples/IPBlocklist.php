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
    echo "blocklists: ", var_export($data['blocklists'], true), "\n";
    
    // The CIDR address for this listing (only set if the IP is listed)
    echo "cidr: ", var_export($data['cidr'], true), "\n";
    
    // The IP address
    echo "ip: ", var_export($data['ip'], true), "\n";
    
    // IP is hosting a malicious bot or is part of a botnet. This is a broad category which includes
    // brute-force crackers
    echo "is-bot: ", var_export($data['is-bot'], true), "\n";
    
    // IP has been flagged as a significant attack source by DShield (dshield.org)
    echo "is-dshield: ", var_export($data['is-dshield'], true), "\n";
    
    // IP is hosting an exploit finding bot or is running exploit scanning software
    echo "is-exploit-bot: ", var_export($data['is-exploit-bot'], true), "\n";
    
    // IP is part of a hijacked netblock or a netblock controlled by a criminal organization
    echo "is-hijacked: ", var_export($data['is-hijacked'], true), "\n";
    
    // Is this IP on a blocklist
    echo "is-listed: ", var_export($data['is-listed'], true), "\n";
    
    // IP is involved in distributing or is running malware
    echo "is-malware: ", var_export($data['is-malware'], true), "\n";
    
    // IP has been detected as an anonymous web proxy or anonymous HTTP proxy
    echo "is-proxy: ", var_export($data['is-proxy'], true), "\n";
    
    // IP address is hosting a spam bot, comment spamming or any other spamming type software
    echo "is-spam-bot: ", var_export($data['is-spam-bot'], true), "\n";
    
    // IP is running a hostile web spider / web crawler
    echo "is-spider: ", var_export($data['is-spider'], true), "\n";
    
    // IP is involved in distributing or is running spyware
    echo "is-spyware: ", var_export($data['is-spyware'], true), "\n";
    
    // IP is a Tor node or running a Tor related service
    echo "is-tor: ", var_export($data['is-tor'], true), "\n";
    
    // IP belongs to a public VPN provider (only set if the 'vpn-lookup' option is enabled)
    echo "is-vpn: ", var_export($data['is-vpn'], true), "\n";
    
    // The unix time when this IP was last seen on any blocklist. IPs are automatically removed after 7
    // days therefor this value will never be older than 7 days
    echo "last-seen: ", var_export($data['last-seen'], true), "\n";
    
    // The number of blocklists the IP is listed on
    echo "list-count: ", var_export($data['list-count'], true), "\n";
    
    // An array of objects containing details on which specific sensors detected the IP
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
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}