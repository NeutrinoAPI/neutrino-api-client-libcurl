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

    // The user-agent string to lookup. For client hints use the 'UA' header or the JSON data directly
    // from 'navigator.userAgentData.brands' or 'navigator.userAgentData.getHighEntropyValues()'
    "ua" => "Mozilla/5.0 (Linux; Android 11; SM-G9980U1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.101 Mobile Safari/537.36",

    // For client hints this corresponds to the 'UA-Full-Version' header or 'uaFullVersion' from
    // NavigatorUAData
    "ua-version" => "",

    // For client hints this corresponds to the 'UA-Platform' header or 'platform' from NavigatorUAData
    "ua-platform" => "",

    // For client hints this corresponds to the 'UA-Platform-Version' header or 'platformVersion' from
    // NavigatorUAData
    "ua-platform-version" => "",

    // For client hints this corresponds to the 'UA-Mobile' header or 'mobile' from NavigatorUAData
    "ua-mobile" => "",

    // For client hints this corresponds to the 'UA-Model' header or 'model' from NavigatorUAData. You
    // can also use this parameter to lookup a device directly by its model name, model code or hardware
    // code, on android you can get the model name from:
    // https://developer.android.com/reference/android/os/Build.html#MODEL
    "device-model" => "",

    // This parameter is only used in combination with 'device-model' when doing direct device lookups
    // without any user-agent data. Set this to the brand or manufacturer name, this is required for
    // accurate device detection with ambiguous model names. On android you can get the device brand
    // from: https://developer.android.com/reference/android/os/Build#MANUFACTURER
    "device-brand" => ""
);

$apiResponse = $neutrinoAPIClient->uaLookup($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // If the client is a web browser which underlying browser engine does it use
    echo "browser-engine: ", (isset($data['browser-engine'])) ? var_export($data['browser-engine'], true) : "NULL", "\n";
    
    // If the client is a web browser which year was this browser version released
    echo "browser-release: ", (isset($data['browser-release'])) ? var_export($data['browser-release'], true) : "NULL", "\n";
    
    // The device brand / manufacturer
    echo "device-brand: ", (isset($data['device-brand'])) ? var_export($data['device-brand'], true) : "NULL", "\n";
    
    // The device display height in CSS 'px'
    echo "device-height-px: ", (isset($data['device-height-px'])) ? var_export($data['device-height-px'], true) : "NULL", "\n";
    
    // The device model
    echo "device-model: ", (isset($data['device-model'])) ? var_export($data['device-model'], true) : "NULL", "\n";
    
    // The device model code
    echo "device-model-code: ", (isset($data['device-model-code'])) ? var_export($data['device-model-code'], true) : "NULL", "\n";
    
    // The device display pixel ratio (the ratio of the resolution in physical pixels to the resolution
    // in CSS pixels)
    echo "device-pixel-ratio: ", (isset($data['device-pixel-ratio'])) ? var_export($data['device-pixel-ratio'], true) : "NULL", "\n";
    
    // The device display PPI (pixels per inch)
    echo "device-ppi: ", (isset($data['device-ppi'])) ? var_export($data['device-ppi'], true) : "NULL", "\n";
    
    // The average device price on release in USD
    echo "device-price: ", (isset($data['device-price'])) ? var_export($data['device-price'], true) : "NULL", "\n";
    
    // The year when this device model was released
    echo "device-release: ", (isset($data['device-release'])) ? var_export($data['device-release'], true) : "NULL", "\n";
    
    // The device display resolution in physical pixels (e.g. 720x1280)
    echo "device-resolution: ", (isset($data['device-resolution'])) ? var_export($data['device-resolution'], true) : "NULL", "\n";
    
    // The device display width in CSS 'px'
    echo "device-width-px: ", (isset($data['device-width-px'])) ? var_export($data['device-width-px'], true) : "NULL", "\n";
    
    // Is this a mobile device (e.g. a phone or tablet)
    echo "is-mobile: ", (isset($data['is-mobile'])) ? var_export($data['is-mobile'], true) : "NULL", "\n";
    
    // Is this a WebView / embedded software client
    echo "is-webview: ", (isset($data['is-webview'])) ? var_export($data['is-webview'], true) : "NULL", "\n";
    
    // The client software name
    echo "name: ", (isset($data['name'])) ? var_export($data['name'], true) : "NULL", "\n";
    
    // The full operating system name
    echo "os: ", (isset($data['os'])) ? var_export($data['os'], true) : "NULL", "\n";
    
    // The operating system family. The major OS families are: Android, Windows, macOS, iOS, Linux
    echo "os-family: ", (isset($data['os-family'])) ? var_export($data['os-family'], true) : "NULL", "\n";
    
    // The operating system full version
    echo "os-version: ", (isset($data['os-version'])) ? var_export($data['os-version'], true) : "NULL", "\n";
    
    // The operating system major version
    echo "os-version-major: ", (isset($data['os-version-major'])) ? var_export($data['os-version-major'], true) : "NULL", "\n";
    
    // The user agent type, possible values are:
    // • desktop
    // • phone
    // • tablet
    // • wearable
    // • tv
    // • console
    // • email
    // • library
    // • robot
    // • unknown
    echo "type: ", (isset($data['type'])) ? var_export($data['type'], true) : "NULL", "\n";
    
    // The user agent string
    echo "ua: ", (isset($data['ua'])) ? var_export($data['ua'], true) : "NULL", "\n";
    
    // The client software full version
    echo "version: ", (isset($data['version'])) ? var_export($data['version'], true) : "NULL", "\n";
    
    // The client software major version
    echo "version-major: ", (isset($data['version-major'])) ? var_export($data['version-major'], true) : "NULL", "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}