<?php
require __DIR__ . '/../client/APIErrorCode.php';
require __DIR__ . '/../client/APIResponse.php';
require __DIR__ . '/../client/NeutrinoAPIClient.php';

$neutrinoAPIClient = new NeutrinoAPI\NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

$params = array(

    // Delay in seconds to wait before capturing any page data, executing selectors or JavaScript
    "delay" => "3",

    // Ignore any TLS/SSL certificate errors and load the page anyway
    "ignore-certificate-errors" => "false",

    // Extract content from the page DOM using this selector. Commonly known as a CSS selector, you can
    // find a good reference here
    "selector" => ".button",

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
    "exec" => "[click('#button-id'), sleep(1), click('.class'), keys('1234'), enter()]",

    // Override the browsers default user-agent string with this one
    "user-agent" => ""
);

$apiResponse = $neutrinoAPIClient->browserBot($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // The complete raw, decompressed and decoded page content. Usually will be either HTML, JSON or XML
    echo "content: ", var_export($data['content'], true), "\n";
    
    // The size of the returned content in bytes
    echo "content-size: ", var_export($data['content-size'], true), "\n";
    
    // Array containing all the elements matching the supplied selector
    $elements = $data['elements'];
    echo "elements:\n";
    foreach ($elements as $elementsItem) {

        // The 'class' attribute of the element
        echo "    class: ", var_export($elementsItem['class'], true), "\n";

        // The 'href' attribute of the element
        echo "    href: ", var_export($elementsItem['href'], true), "\n";

        // The raw HTML of the element
        echo "    html: ", var_export($elementsItem['html'], true), "\n";

        // The 'id' attribute of the element
        echo "    id: ", var_export($elementsItem['id'], true), "\n";

        // The plain-text content of the element with normalized whitespace
        echo "    text: ", var_export($elementsItem['text'], true), "\n";
        echo "\n";
    }
    
    // Contains the error message if an error has occurred ('is-error' will be true)
    echo "error-message: ", var_export($data['error-message'], true), "\n";
    
    // If you executed any JavaScript this array holds the results as objects
    $execResults = $data['exec-results'];
    echo "exec-results:\n";
    foreach ($execResults as $execResultsItem) {

        // The result of the executed JavaScript statement. Will be empty if the statement returned nothing
        echo "    result: ", var_export($execResultsItem['result'], true), "\n";

        // The JavaScript statement that was executed
        echo "    statement: ", var_export($execResultsItem['statement'], true), "\n";
        echo "\n";
    }
    
    // The redirected URL if the URL responded with an HTTP redirect
    echo "http-redirect-url: ", var_export($data['http-redirect-url'], true), "\n";
    
    // The HTTP status code the URL returned
    echo "http-status-code: ", var_export($data['http-status-code'], true), "\n";
    
    // The HTTP status message the URL returned
    echo "http-status-message: ", var_export($data['http-status-message'], true), "\n";
    
    // True if an error has occurred loading the page. Check the 'error-message' field for details
    echo "is-error: ", var_export($data['is-error'], true), "\n";
    
    // True if the HTTP status is OK (200)
    echo "is-http-ok: ", var_export($data['is-http-ok'], true), "\n";
    
    // True if the URL responded with an HTTP redirect
    echo "is-http-redirect: ", var_export($data['is-http-redirect'], true), "\n";
    
    // True if the page is secured using TLS/SSL
    echo "is-secure: ", var_export($data['is-secure'], true), "\n";
    
    // True if a timeout occurred while loading the page. You can set the timeout with the request
    // parameter 'timeout'
    echo "is-timeout: ", var_export($data['is-timeout'], true), "\n";
    
    // The ISO 2-letter language code of the page. Extracted from either the HTML document or via HTTP
    // headers
    echo "language-code: ", var_export($data['language-code'], true), "\n";
    
    // The number of seconds taken to load the page (from initial request until DOM ready)
    echo "load-time: ", var_export($data['load-time'], true), "\n";
    
    // The document MIME type
    echo "mime-type: ", var_export($data['mime-type'], true), "\n";
    
    // Map containing all the HTTP response headers the URL responded with
    echo "response-headers: ", var_export($data['response-headers'], true), "\n";
    
    // Map containing details of the TLS/SSL setup
    echo "security-details: ", var_export($data['security-details'], true), "\n";
    
    // The HTTP servers hostname (PTR/RDNS record)
    echo "server-hostname: ", var_export($data['server-hostname'], true), "\n";
    
    // The HTTP servers IP address
    echo "server-ip: ", var_export($data['server-ip'], true), "\n";
    
    // The document title
    echo "title: ", var_export($data['title'], true), "\n";
    
    // The requested URL. This may not be the same as the final destination URL, if the URL redirects
    // then it will be set in 'http-redirect-url' and 'is-http-redirect' will also be true
    echo "url: ", var_export($data['url'], true), "\n";
    
    // Structure of url-components
    echo "url-components: ", var_export($data['url-components'], true), "\n";
    
    // True if the URL supplied is valid
    echo "url-valid: ", var_export($data['url-valid'], true), "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}
