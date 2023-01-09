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
    echo "browser-engine: ", var_export($data['browser-engine'], true), "\n";
    
    // If the client is a web browser which year was this browser version released
    echo "browser-release: ", var_export($data['browser-release'], true), "\n";
    
    // The device brand / manufacturer
    echo "device-brand: ", var_export($data['device-brand'], true), "\n";
    
    // The device display height in CSS 'px'
    echo "device-height-px: ", var_export($data['device-height-px'], true), "\n";
    
    // The device model
    echo "device-model: ", var_export($data['device-model'], true), "\n";
    
    // The device model code
    echo "device-model-code: ", var_export($data['device-model-code'], true), "\n";
    
    // The device display pixel ratio (the ratio of the resolution in physical pixels to the resolution
    // in CSS pixels)
    echo "device-pixel-ratio: ", var_export($data['device-pixel-ratio'], true), "\n";
    
    // The device display PPI (pixels per inch)
    echo "device-ppi: ", var_export($data['device-ppi'], true), "\n";
    
    // The average device price on release in USD
    echo "device-price: ", var_export($data['device-price'], true), "\n";
    
    // The year when this device model was released
    echo "device-release: ", var_export($data['device-release'], true), "\n";
    
    // The device display resolution in physical pixels (e.g. 720x1280)
    echo "device-resolution: ", var_export($data['device-resolution'], true), "\n";
    
    // The device display width in CSS 'px'
    echo "device-width-px: ", var_export($data['device-width-px'], true), "\n";
    
    // Is this a mobile device (e.g. a phone or tablet)
    echo "is-mobile: ", var_export($data['is-mobile'], true), "\n";
    
    // Is this a WebView / embedded software client
    echo "is-webview: ", var_export($data['is-webview'], true), "\n";
    
    // The client software name
    echo "name: ", var_export($data['name'], true), "\n";
    
    // The full operating system name
    echo "os: ", var_export($data['os'], true), "\n";
    
    // The operating system family. The major OS families are: Android, Windows, macOS, iOS, Linux
    echo "os-family: ", var_export($data['os-family'], true), "\n";
    
    // The operating system full version
    echo "os-version: ", var_export($data['os-version'], true), "\n";
    
    // The operating system major version
    echo "os-version-major: ", var_export($data['os-version-major'], true), "\n";
    
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
    echo "type: ", var_export($data['type'], true), "\n";
    
    // The user agent string
    echo "ua: ", var_export($data['ua'], true), "\n";
    
    // The client software full version
    echo "version: ", var_export($data['version'], true), "\n";
    
    // The client software major version
    echo "version-major: ", var_export($data['version-major'], true), "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}