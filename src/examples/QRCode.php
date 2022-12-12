<?php
use NeutrinoAPI\NeutrinoAPIClient;

spl_autoload_register(function ($className) {
    if (strpos($className, "NeutrinoAPI\\") === 0) {
        $classFile = explode('\\', $className)[1].'.php';
        include realpath(__DIR__ . "/../client/$classFile");
    }
});

$tmpFile = tempnam(sys_get_temp_dir(), "qr-code-") . ".png";

$neutrinoAPIClient = new NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

$params = array(

    // The width of the QR code (in px)
    "width" => "256",

    // The QR code foreground color
    "fg-color" => "#000000",

    // The QR code background color
    "bg-color" => "#ffffff",

    // The content to encode into the QR code (e.g. a URL or a phone number)
    "content" => "https://www.neutrinoapi.com/signup/",

    // The height of the QR code (in px)
    "height" => "256"
);

$apiResponse = $neutrinoAPIClient->qrCode($params, $tmpFile);
if ($apiResponse->isOK()) {
    $outputFile = $apiResponse->getFile();
    printf("API Response OK, output saved to: %s\n", $outputFile);
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}
