<?php
require __DIR__ . '/../client/APIErrorCode.php';
require __DIR__ . '/../client/APIResponse.php';
require __DIR__ . '/../client/NeutrinoAPIClient.php';

$tmpFile = tempnam(sys_get_temp_dir(), "image-resize-") . ".png";

$neutrinoAPIClient = new NeutrinoAPI\NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

$params = array(

    // The resize mode to use, we support 3 main resizing modes:
    // • scale Resize to within the width and height specified while preserving aspect ratio. In this
    //   mode the width or height will be automatically adjusted to fit the aspect ratio
    // • pad Resize to exactly the width and height specified while preserving aspect ratio and pad
    //   any space left over. Any padded space will be filled in with the 'bg-color' value
    // • crop Resize to exactly the width and height specified while preserving aspect ratio and crop
    //   any space which fall outside the area. The cropping window is centered on the original image
    "resize-mode" => "scale",

    // The width to resize to (in px)
    "width" => "32",

    // The output image format, can be either png or jpg
    "format" => "png",

    // The URL or Base64 encoded Data URL for the source image. You can also upload an image file
    // directly using multipart/form-data
    "image-url" => "https://www.neutrinoapi.com/img/LOGO.png",

    // The image background color in hexadecimal notation (e.g. #0000ff). For PNG output the special
    // value of 'transparent' can also be used. For JPG output the default is black (#000000)
    "bg-color" => "transparent",

    // The height to resize to (in px). If you don't set this field then the height will be automatic
    // based on the requested width and image aspect ratio
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
