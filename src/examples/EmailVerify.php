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

$apiResponse = $neutrinoAPIClient->emailVerify($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // The email domain
    echo "domain: ", (isset($data['domain'])) ? var_export($data['domain'], true) : "NULL", "\n";
    
    // True if this address has a domain error (e.g. no valid mail server records)
    echo "domain-error: ", (isset($data['domain-error'])) ? var_export($data['domain-error'], true) : "NULL", "\n";
    
    // The email address. If you have used the fix-typos option then this will be the fixed address
    echo "email: ", (isset($data['email'])) ? var_export($data['email'], true) : "NULL", "\n";
    
    // True if this email domain has a catch-all policy (it will accept mail for any username)
    echo "is-catch-all: ", (isset($data['is-catch-all'])) ? var_export($data['is-catch-all'], true) : "NULL", "\n";
    
    // True if the mail server responded with a temporary failure (either a 4xx response code or
    // unresponsive server). You can retry this address later, we recommend waiting at least 15 minutes
    // before retrying
    echo "is-deferred: ", (isset($data['is-deferred'])) ? var_export($data['is-deferred'], true) : "NULL", "\n";
    
    // True if this address is a disposable, temporary or darknet related email address
    echo "is-disposable: ", (isset($data['is-disposable'])) ? var_export($data['is-disposable'], true) : "NULL", "\n";
    
    // True if this address is a free-mail address
    echo "is-freemail: ", (isset($data['is-freemail'])) ? var_export($data['is-freemail'], true) : "NULL", "\n";
    
    // True if this address is for a person. False if this is a role based address, e.g. admin@, help@,
    // office@, etc.
    echo "is-personal: ", (isset($data['is-personal'])) ? var_export($data['is-personal'], true) : "NULL", "\n";
    
    // The email service provider domain
    echo "provider: ", (isset($data['provider'])) ? var_export($data['provider'], true) : "NULL", "\n";
    
    // The raw SMTP response message received during verification
    echo "smtp-response: ", (isset($data['smtp-response'])) ? var_export($data['smtp-response'], true) : "NULL", "\n";
    
    // The SMTP verification status for the address:
    // • ok - SMTP verification was successful, this is a real address that can receive mail
    // • invalid - this is not a valid email address (has either a domain or syntax error)
    // • absent - this address is not registered with the email service provider
    // • unresponsive - the mail server(s) for this address timed-out or refused to open an SMTP
    //   connection
    // • unknown - sorry, we could not reliably determine the real status of this address (this
    //   address may or may not exist)
    echo "smtp-status: ", (isset($data['smtp-status'])) ? var_export($data['smtp-status'], true) : "NULL", "\n";
    
    // True if this address has a syntax error
    echo "syntax-error: ", (isset($data['syntax-error'])) ? var_export($data['syntax-error'], true) : "NULL", "\n";
    
    // True if typos have been fixed
    echo "typos-fixed: ", (isset($data['typos-fixed'])) ? var_export($data['typos-fixed'], true) : "NULL", "\n";
    
    // Is this a valid email address (syntax and domain is valid)
    echo "valid: ", (isset($data['valid'])) ? var_export($data['valid'], true) : "NULL", "\n";
    
    // True if this address has passed SMTP verification. Check the smtp-status and smtp-response fields
    // for specific verification details
    echo "verified: ", (isset($data['verified'])) ? var_export($data['verified'], true) : "NULL", "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}