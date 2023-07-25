<?php
require __DIR__ . '/../client/APIErrorCode.php';
require __DIR__ . '/../client/APIResponse.php';
require __DIR__ . '/../client/NeutrinoAPIClient.php';

$neutrinoAPIClient = new NeutrinoAPI\NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

$params = array(

    // The URL to probe
    "url" => "https://www.neutrinoapi.com/",

    // If this URL responds with html, text, json or xml then return the response. This option is useful
    // if you want to perform further processing on the URL content (e.g. with the HTML Extract or HTML
    // Clean APIs)
    "fetch-content" => "false",

    // Ignore any TLS/SSL certificate errors and load the URL anyway
    "ignore-certificate-errors" => "false",

    // Timeout in seconds. Give up if still trying to load the URL after this number of seconds
    "timeout" => "60",

    // If the request fails for any reason try again this many times
    "retry" => "0"
);

$apiResponse = $neutrinoAPIClient->urlInfo($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // The actual content this URL responded with. Only set if the 'fetch-content' option was used
    echo "content: ", var_export($data['content'], true), "\n";
    
    // The encoding format the URL uses
    echo "content-encoding: ", var_export($data['content-encoding'], true), "\n";
    
    // The size of the URL content in bytes
    echo "content-size: ", var_export($data['content-size'], true), "\n";
    
    // The content-type this URL serves
    echo "content-type: ", var_export($data['content-type'], true), "\n";
    
    // True if this URL responded with an HTTP OK (200) status
    echo "http-ok: ", var_export($data['http-ok'], true), "\n";
    
    // True if this URL responded with an HTTP redirect
    echo "http-redirect: ", var_export($data['http-redirect'], true), "\n";
    
    // The HTTP status code this URL responded with. An HTTP status of 0 indicates a network level issue
    echo "http-status: ", var_export($data['http-status'], true), "\n";
    
    // The HTTP status message assoicated with the status code
    echo "http-status-message: ", var_export($data['http-status-message'], true), "\n";
    
    // True if an error occurred while loading the URL. This includes network errors, TLS errors and
    // timeouts
    echo "is-error: ", var_export($data['is-error'], true), "\n";
    
    // True if a timeout occurred while loading the URL. You can set the timeout with the request
    // parameter 'timeout'
    echo "is-timeout: ", var_export($data['is-timeout'], true), "\n";
    
    // The ISO 2-letter language code of the page. Extracted from either the HTML document or via HTTP
    // headers
    echo "language-code: ", var_export($data['language-code'], true), "\n";
    
    // The time taken to load the URL content in seconds
    echo "load-time: ", var_export($data['load-time'], true), "\n";
    
    // A key-value map of the URL query paramaters
    echo "query: ", var_export($data['query'], true), "\n";
    
    // Is this URL actually serving real content
    echo "real: ", var_export($data['real'], true), "\n";
    
    // The servers IP geo-location: full city name (if detectable)
    echo "server-city: ", var_export($data['server-city'], true), "\n";
    
    // The servers IP geo-location: full country name
    echo "server-country: ", var_export($data['server-country'], true), "\n";
    
    // The servers IP geo-location: ISO 2-letter country code
    echo "server-country-code: ", var_export($data['server-country-code'], true), "\n";
    
    // The servers hostname (PTR record)
    echo "server-hostname: ", var_export($data['server-hostname'], true), "\n";
    
    // The IP address of the server hosting this URL
    echo "server-ip: ", var_export($data['server-ip'], true), "\n";
    
    // The name of the server software hosting this URL
    echo "server-name: ", var_export($data['server-name'], true), "\n";
    
    // The servers IP geo-location: full region name (if detectable)
    echo "server-region: ", var_export($data['server-region'], true), "\n";
    
    // The document title
    echo "title: ", var_export($data['title'], true), "\n";
    
    // The fully qualified URL. This may be different to the URL requested if http-redirect is true
    echo "url: ", var_export($data['url'], true), "\n";
    
    // The URL path
    echo "url-path: ", var_export($data['url-path'], true), "\n";
    
    // The URL port
    echo "url-port: ", var_export($data['url-port'], true), "\n";
    
    // The URL protocol, usually http or https
    echo "url-protocol: ", var_export($data['url-protocol'], true), "\n";
    
    // Is this a valid well-formed URL
    echo "valid: ", var_export($data['valid'], true), "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}
