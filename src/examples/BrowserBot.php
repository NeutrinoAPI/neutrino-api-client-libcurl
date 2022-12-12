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

    // Delay in seconds to wait before capturing any page data, executing selectors or JavaScript
    "delay" => "3",

    // Ignore any TLS/SSL certificate errors and load the page anyway
    "ignore-certificate-errors" => "false",

    // Extract content from the page DOM using this selector. Commonly known as a CSS selector, you can
    // find a good reference here
    "selector" => ".header-link",

    // The URL to load
    "url" => "https://www.neutrinoapi.com/",

    // Timeout in seconds. Give up if still trying to load the page after this number of seconds
    "timeout" => "30",

    // Execute JavaScript on the website. This parameter accepts JavaScript as either a string
    // containing JavaScript or for sending multiple separate statements a JSON array or POST array can
    // also be used. If a statement returns any value it will be returned in the 'exec-results'
    // response. You can also use the following specially defined user interaction functions:
    // sleep(seconds); Just wait/sleep for the specified number of seconds. click('selector'); Click on
    // the first element matching the given selector. focus('selector'); Focus on the first element
    // matching the given selector. keys('characters'); Send the specified keyboard characters. Use
    // click() or focus() first to send keys to a specific element. enter(); Send the Enter key. tab();
    // Send the Tab key.
    "exec" => "[]",

    // Override the browsers default user-agent string with this one
    "user-agent" => ""
);

$apiResponse = $neutrinoAPIClient->browserBot($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // The complete raw, decompressed and decoded page content. Usually will be either HTML, JSON or XML
    echo "content: ", (isset($data['content'])) ? var_export($data['content'], true) : "NULL", "\n";
    
    // Array containing all the elements matching the supplied selector. Each element object will
    // contain the text content, HTML content and all current element attributes
    echo "elements: ", (isset($data['elements'])) ? var_export($data['elements'], true) : "NULL", "\n";
    
    // Contains the error message if an error has occurred ('is-error' will be true)
    echo "error-message: ", (isset($data['error-message'])) ? var_export($data['error-message'], true) : "NULL", "\n";
    
    // If you executed any JavaScript this array holds the results as objects
    echo "exec-results: ", (isset($data['exec-results'])) ? var_export($data['exec-results'], true) : "NULL", "\n";
    
    // The redirected URL if the URL responded with an HTTP redirect
    echo "http-redirect-url: ", (isset($data['http-redirect-url'])) ? var_export($data['http-redirect-url'], true) : "NULL", "\n";
    
    // The HTTP status code the URL returned
    echo "http-status-code: ", (isset($data['http-status-code'])) ? var_export($data['http-status-code'], true) : "NULL", "\n";
    
    // The HTTP status message the URL returned
    echo "http-status-message: ", (isset($data['http-status-message'])) ? var_export($data['http-status-message'], true) : "NULL", "\n";
    
    // True if an error has occurred loading the page. Check the 'error-message' field for details
    echo "is-error: ", (isset($data['is-error'])) ? var_export($data['is-error'], true) : "NULL", "\n";
    
    // True if the HTTP status is OK (200)
    echo "is-http-ok: ", (isset($data['is-http-ok'])) ? var_export($data['is-http-ok'], true) : "NULL", "\n";
    
    // True if the URL responded with an HTTP redirect
    echo "is-http-redirect: ", (isset($data['is-http-redirect'])) ? var_export($data['is-http-redirect'], true) : "NULL", "\n";
    
    // True if the page is secured using TLS/SSL
    echo "is-secure: ", (isset($data['is-secure'])) ? var_export($data['is-secure'], true) : "NULL", "\n";
    
    // True if a timeout occurred while loading the page. You can set the timeout with the request
    // parameter 'timeout'
    echo "is-timeout: ", (isset($data['is-timeout'])) ? var_export($data['is-timeout'], true) : "NULL", "\n";
    
    // The ISO 2-letter language code of the page. Extracted from either the HTML document or via HTTP
    // headers
    echo "language-code: ", (isset($data['language-code'])) ? var_export($data['language-code'], true) : "NULL", "\n";
    
    // The number of seconds taken to load the page (from initial request until DOM ready)
    echo "load-time: ", (isset($data['load-time'])) ? var_export($data['load-time'], true) : "NULL", "\n";
    
    // The document MIME type
    echo "mime-type: ", (isset($data['mime-type'])) ? var_export($data['mime-type'], true) : "NULL", "\n";
    
    // Map containing all the HTTP response headers the URL responded with
    echo "response-headers: ", (isset($data['response-headers'])) ? var_export($data['response-headers'], true) : "NULL", "\n";
    
    // Map containing details of the TLS/SSL setup
    echo "security-details: ", (isset($data['security-details'])) ? var_export($data['security-details'], true) : "NULL", "\n";
    
    // The HTTP servers IP address
    echo "server-ip: ", (isset($data['server-ip'])) ? var_export($data['server-ip'], true) : "NULL", "\n";
    
    // The document title
    echo "title: ", (isset($data['title'])) ? var_export($data['title'], true) : "NULL", "\n";
    
    // The page URL
    echo "url: ", (isset($data['url'])) ? var_export($data['url'], true) : "NULL", "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}