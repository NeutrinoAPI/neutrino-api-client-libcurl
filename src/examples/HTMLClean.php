<?php
use NeutrinoAPI\NeutrinoAPIClient;

spl_autoload_register(function ($className) {
    if (strpos($className, "NeutrinoAPI\\") === 0) {
        $classFile = explode('\\', $className)[1].'.php';
        include realpath(__DIR__ . "/../client/$classFile");
    }
});

$tmpFile = tempnam(sys_get_temp_dir(), "html-clean-") . ".txt";

$neutrinoAPIClient = new NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

$params = array(

    // The level of sanitization, possible values are: plain-text: reduce the content to plain text only
    // (no HTML tags at all) simple-text: allow only very basic text formatting tags like b, em, i,
    // strong, u basic-html: allow advanced text formatting and hyper links basic-html-with-images: same
    // as basic html but also allows image tags advanced-html: same as basic html with images but also
    // allows many more common HTML tags like table, ul, dl, pre
    "output-type" => "plain-text",

    // The HTML content. This can be either a URL to load from, a file upload or an HTML content string
    "content" => "<div>Some HTML to clean...</div><script>alert()</script>"
);

$apiResponse = $neutrinoAPIClient->htmlClean($params, $tmpFile);
if ($apiResponse->isOK()) {
    $outputFile = $apiResponse->getFile();
    printf("API Response OK, output saved to: %s\n", $outputFile);
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}
