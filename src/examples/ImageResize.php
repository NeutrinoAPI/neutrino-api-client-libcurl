<?php
use NeutrinoAPI\NeutrinoAPIClient;

spl_autoload_register(function ($className) {
    if (strpos($className, "NeutrinoAPI\\") === 0) {
        $classFile = explode('\\', $className)[1].'.php';
        include realpath(__DIR__ . "/../client/$classFile");
    }
});

$tmpFile = tempnam(sys_get_temp_dir(), "image-resize-") . ".png";

$neutrinoAPIClient = new NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

$params = array(

    // The width to resize to (in px) while preserving aspect ratio
    "width" => "32",

    // The output image format, can be either png or jpg
    "format" => "png",

    // The URL or Base64 encoded Data URL for the source image (you can also upload an image file
    // directly in which case this field is ignored)
    "image-url" => "https://www.neutrinoapi.com/img/LOGO.png",

    // The height to resize to (in px) while preserving aspect ratio. If you don't set this field then
    // the height will be automatic based on the requested width and images aspect ratio
    "height" => "32"
);

$apiResponse = $neutrinoAPIClient->imageResize($params, $tmpFile);
if ($apiResponse->isOK()) {
    $outputFile = $apiResponse->getFile();
    printf("API Response OK, output saved to: %s\n", $outputFile);
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}
