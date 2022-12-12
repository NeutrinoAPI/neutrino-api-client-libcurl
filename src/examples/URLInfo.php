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
    echo "content: ", (isset($data['content'])) ? var_export($data['content'], true) : "NULL", "\n";
    
    // The encoding format the URL uses
    echo "content-encoding: ", (isset($data['content-encoding'])) ? var_export($data['content-encoding'], true) : "NULL", "\n";
    
    // The size of the URL content in bytes
    echo "content-size: ", (isset($data['content-size'])) ? var_export($data['content-size'], true) : "NULL", "\n";
    
    // The content-type this URL serves
    echo "content-type: ", (isset($data['content-type'])) ? var_export($data['content-type'], true) : "NULL", "\n";
    
    // True if this URL responded with an HTTP OK (200) status
    echo "http-ok: ", (isset($data['http-ok'])) ? var_export($data['http-ok'], true) : "NULL", "\n";
    
    // True if this URL responded with an HTTP redirect
    echo "http-redirect: ", (isset($data['http-redirect'])) ? var_export($data['http-redirect'], true) : "NULL", "\n";
    
    // The HTTP status code this URL responded with. An HTTP status of 0 indicates a network level issue
    echo "http-status: ", (isset($data['http-status'])) ? var_export($data['http-status'], true) : "NULL", "\n";
    
    // The HTTP status message assoicated with the status code
    echo "http-status-message: ", (isset($data['http-status-message'])) ? var_export($data['http-status-message'], true) : "NULL", "\n";
    
    // True if an error occurred while loading the URL. This includes network errors, TLS errors and
    // timeouts
    echo "is-error: ", (isset($data['is-error'])) ? var_export($data['is-error'], true) : "NULL", "\n";
    
    // True if a timeout occurred while loading the URL. You can set the timeout with the request
    // parameter 'timeout'
    echo "is-timeout: ", (isset($data['is-timeout'])) ? var_export($data['is-timeout'], true) : "NULL", "\n";
    
    // The ISO 2-letter language code of the page. Extracted from either the HTML document or via HTTP
    // headers
    echo "language-code: ", (isset($data['language-code'])) ? var_export($data['language-code'], true) : "NULL", "\n";
    
    // The time taken to load the URL content in seconds
    echo "load-time: ", (isset($data['load-time'])) ? var_export($data['load-time'], true) : "NULL", "\n";
    
    // A key-value map of the URL query paramaters
    echo "query: ", (isset($data['query'])) ? var_export($data['query'], true) : "NULL", "\n";
    
    // Is this URL actually serving real content
    echo "real: ", (isset($data['real'])) ? var_export($data['real'], true) : "NULL", "\n";
    
    // The servers IP geo-location: full city name (if detectable)
    echo "server-city: ", (isset($data['server-city'])) ? var_export($data['server-city'], true) : "NULL", "\n";
    
    // The servers IP geo-location: full country name
    echo "server-country: ", (isset($data['server-country'])) ? var_export($data['server-country'], true) : "NULL", "\n";
    
    // The servers IP geo-location: ISO 2-letter country code
    echo "server-country-code: ", (isset($data['server-country-code'])) ? var_export($data['server-country-code'], true) : "NULL", "\n";
    
    // The servers hostname (PTR record)
    echo "server-hostname: ", (isset($data['server-hostname'])) ? var_export($data['server-hostname'], true) : "NULL", "\n";
    
    // The IP address of the server hosting this URL
    echo "server-ip: ", (isset($data['server-ip'])) ? var_export($data['server-ip'], true) : "NULL", "\n";
    
    // The name of the server software hosting this URL
    echo "server-name: ", (isset($data['server-name'])) ? var_export($data['server-name'], true) : "NULL", "\n";
    
    // The servers IP geo-location: full region name (if detectable)
    echo "server-region: ", (isset($data['server-region'])) ? var_export($data['server-region'], true) : "NULL", "\n";
    
    // The document title
    echo "title: ", (isset($data['title'])) ? var_export($data['title'], true) : "NULL", "\n";
    
    // The fully qualified URL. This may be different to the URL requested if http-redirect is true
    echo "url: ", (isset($data['url'])) ? var_export($data['url'], true) : "NULL", "\n";
    
    // The URL path
    echo "url-path: ", (isset($data['url-path'])) ? var_export($data['url-path'], true) : "NULL", "\n";
    
    // The URL port
    echo "url-port: ", (isset($data['url-port'])) ? var_export($data['url-port'], true) : "NULL", "\n";
    
    // The URL protocol, usually http or https
    echo "url-protocol: ", (isset($data['url-protocol'])) ? var_export($data['url-protocol'], true) : "NULL", "\n";
    
    // Is this a valid well-formed URL
    echo "valid: ", (isset($data['valid'])) ? var_export($data['valid'], true) : "NULL", "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}