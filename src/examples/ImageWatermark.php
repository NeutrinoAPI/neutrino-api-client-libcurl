<?php
use NeutrinoAPI\NeutrinoAPIClient;

spl_autoload_register(function ($className) {
    if (strpos($className, "NeutrinoAPI\\") === 0) {
        $classFile = explode('\\', $className)[1].'.php';
        include realpath(__DIR__ . "/../client/$classFile");
    }
});

$tmpFile = tempnam(sys_get_temp_dir(), "image-watermark-") . ".png";

$neutrinoAPIClient = new NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

$params = array(

    // The output image format, can be either png or jpg
    "format" => "png",

    // If set resize the resulting image to this width (in px) while preserving aspect ratio
    "width" => "",

    // The URL or Base64 encoded Data URL for the source image (you can also upload an image file
    // directly in which case this field is ignored)
    "image-url" => "https://www.neutrinoapi.com/img/LOGO.png",

    // The position of the watermark image, possible values are: center, top-left, top-center,
    // top-right, bottom-left, bottom-center, bottom-right
    "position" => "center",

    // The URL or Base64 encoded Data URL for the watermark image (you can also upload an image file
    // directly in which case this field is ignored)
    "watermark-url" => "https://www.neutrinoapi.com/img/icons/security.png",

    // The opacity of the watermark (0 to 100)
    "opacity" => "50",

    // If set resize the resulting image to this height (in px) while preserving aspect ratio
    "height" => ""
);

$apiResponse = $neutrinoAPIClient->imageWatermark($params, $tmpFile);
if ($apiResponse->isOK()) {
    $outputFile = $apiResponse->getFile();
    printf("API Response OK, output saved to: %s\n", $outputFile);
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}
