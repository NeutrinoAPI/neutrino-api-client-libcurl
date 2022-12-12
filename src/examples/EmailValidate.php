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

    // An email address
    "email" => "tech@neutrinoapi.com",

    // Automatically attempt to fix typos in the address
    "fix-typos" => "false"
);

$apiResponse = $neutrinoAPIClient->emailValidate($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // The email domain
    echo "domain: ", (isset($data['domain'])) ? var_export($data['domain'], true) : "NULL", "\n";
    
    // True if this address has a domain error (e.g. no valid mail server records)
    echo "domain-error: ", (isset($data['domain-error'])) ? var_export($data['domain-error'], true) : "NULL", "\n";
    
    // The email address. If you have used the fix-typos option then this will be the fixed address
    echo "email: ", (isset($data['email'])) ? var_export($data['email'], true) : "NULL", "\n";
    
    // True if this address is a disposable, temporary or darknet related email address
    echo "is-disposable: ", (isset($data['is-disposable'])) ? var_export($data['is-disposable'], true) : "NULL", "\n";
    
    // True if this address is a free-mail address
    echo "is-freemail: ", (isset($data['is-freemail'])) ? var_export($data['is-freemail'], true) : "NULL", "\n";
    
    // True if this address belongs to a person. False if this is a role based address, e.g. admin@,
    // help@, office@, etc.
    echo "is-personal: ", (isset($data['is-personal'])) ? var_export($data['is-personal'], true) : "NULL", "\n";
    
    // The email service provider domain
    echo "provider: ", (isset($data['provider'])) ? var_export($data['provider'], true) : "NULL", "\n";
    
    // True if this address has a syntax error
    echo "syntax-error: ", (isset($data['syntax-error'])) ? var_export($data['syntax-error'], true) : "NULL", "\n";
    
    // True if typos have been fixed
    echo "typos-fixed: ", (isset($data['typos-fixed'])) ? var_export($data['typos-fixed'], true) : "NULL", "\n";
    
    // Is this a valid email
    echo "valid: ", (isset($data['valid'])) ? var_export($data['valid'], true) : "NULL", "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}