<?php
use NeutrinoAPI\NeutrinoAPIClient;

spl_autoload_register(function ($className) {
    if (strpos($className, "NeutrinoAPI\\") === 0) {
        $classFile = explode('\\', $className)[1].'.php';
        include realpath(__DIR__ . "/../client/$classFile");
    }
});

$tmpFile = tempnam(sys_get_temp_dir(), "bin-list-download-") . ".png";

$neutrinoAPIClient = new NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

$params = array(

    // Include ISO 3-letter country codes and ISO 3-letter currency codes in the data. These will be
    // added to columns 10 and 11 respectively
    "include-iso3" => "false",

    // Include 8-digit and higher BIN codes. Use this option if you want to download BINs with more than
    // 6-digits
    "include-8digit" => "false"
);

$apiResponse = $neutrinoAPIClient->binListDownload($params, $tmpFile);
if ($apiResponse->isOK()) {
    $outputFile = $apiResponse->getFile();
    printf("API Response OK, output saved to: %s\n", $outputFile);
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}
