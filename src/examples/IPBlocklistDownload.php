<?php
use NeutrinoAPI\NeutrinoAPIClient;

spl_autoload_register(function ($className) {
    if (strpos($className, "NeutrinoAPI\\") === 0) {
        $classFile = explode('\\', $className)[1].'.php';
        include realpath(__DIR__ . "/../client/$classFile");
    }
});

$tmpFile = tempnam(sys_get_temp_dir(), "ip-blocklist-download-") . ".csv";

$neutrinoAPIClient = new NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

$params = array(

    // The data format. Can be either CSV or TXT
    "format" => "csv",

    // Include public VPN provider IP addresses, this option is only available for Tier 3 or higher
    // accounts. WARNING: This option will add at least an additional 8 million IP addresses to the
    // download if not using CIDR notation
    "include-vpn" => "false",

    // Output IPs using CIDR notation. This option should be preferred but is off by default for
    // backwards compatibility
    "cidr" => "false",

    // Output the IPv6 version of the blocklist, the default is to output IPv4 only. Note that this
    // option enables CIDR notation too as this is the only notation currently supported for IPv6
    "ip6" => "false"
);

$apiResponse = $neutrinoAPIClient->ipBlocklistDownload($params, $tmpFile);
if ($apiResponse->isOK()) {
    $outputFile = $apiResponse->getFile();
    printf("API Response OK, output saved to: %s\n", $outputFile);
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}
