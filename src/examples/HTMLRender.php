<?php
use NeutrinoAPI\NeutrinoAPIClient;

spl_autoload_register(function ($className) {
    if (strpos($className, "NeutrinoAPI\\") === 0) {
        $classFile = explode('\\', $className)[1].'.php';
        include realpath(__DIR__ . "/../client/$classFile");
    }
});

$tmpFile = tempnam(sys_get_temp_dir(), "html-render-") . ".pdf";

$neutrinoAPIClient = new NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

$params = array(

    // The document margin (in mm)
    "margin" => "0",

    // Inject custom CSS into the HTML. e.g. 'body { background-color: red;}'
    "css" => "",

    // If rendering to an image format (PNG or JPG) use this image width (in pixels)
    "image-width" => "1024",

    // The footer HTML to insert into each page. The following dynamic tags are supported: {date},
    // {title}, {url}, {pageNumber}, {totalPages}
    "footer" => "",

    // Which format to output, available options are: PDF, PNG, JPG
    "format" => "PDF",

    // Set the zoom factor when rendering the page (2.0 for double size, 0.5 for half size)
    "zoom" => "1",

    // The document title
    "title" => "",

    // The HTML content. This can be either a URL to load from, a file upload or an HTML content string
    "content" => "<h1>TEST DOCUMENT</h1><p>Hello, this is a test page...</p>",

    // Set the PDF page width explicitly (in mm)
    "page-width" => "",

    // Timeout in seconds. Give up if still trying to load the HTML content after this number of seconds
    "timeout" => "300",

    // The document right margin (in mm)
    "margin-right" => "0",

    // Render the final document in grayscale
    "grayscale" => "false",

    // The document left margin (in mm)
    "margin-left" => "0",

    // Set the document page size, can be one of: A0 - A9, B0 - B10, Comm10E, DLE or Letter
    "page-size" => "A4",

    // Number of seconds to wait before rendering the page (can be useful for pages with animations etc)
    "delay" => "0",

    // Ignore any TLS/SSL certificate errors
    "ignore-certificate-errors" => "false",

    // Set the PDF page height explicitly (in mm)
    "page-height" => "",

    // If rendering to an image format (PNG or JPG) use this image height (in pixels). The default is
    // automatic which dynamically sets the image height based on the content
    "image-height" => "",

    // The header HTML to insert into each page. The following dynamic tags are supported: {date},
    // {title}, {url}, {pageNumber}, {totalPages}
    "header" => "<div style='width: 100%; font-size: 8pt;'>{pageNumber} of {totalPages} - {date}</div>",

    // The document top margin (in mm)
    "margin-top" => "0",

    // The document bottom margin (in mm)
    "margin-bottom" => "0",

    // Set the document to landscape orientation
    "landscape" => "false"
);

$apiResponse = $neutrinoAPIClient->htmlRender($params, $tmpFile);
if ($apiResponse->isOK()) {
    $outputFile = $apiResponse->getFile();
    printf("API Response OK, output saved to: %s\n", $outputFile);
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}
