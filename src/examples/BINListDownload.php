<?php
require __DIR__ . '/../client/APIErrorCode.php';
require __DIR__ . '/../client/APIResponse.php';
require __DIR__ . '/../client/NeutrinoAPIClient.php';

$tmpFile = tempnam(sys_get_temp_dir(), "bin-list-download-") . ".png";

$neutrinoAPIClient = new NeutrinoAPI\NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

$params = array(

    // Include ISO 3-letter country codes and ISO 3-letter currency codes in the data. These will be
    // added to columns 10 and 11 respectively
    "include-iso3" => "false",

    // Include 8-digit and higher BIN codes. This option includes all 6-digit BINs and all 8-digit and
    // higher BINs (including some 9, 10 and 11 digit BINs where available)
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
