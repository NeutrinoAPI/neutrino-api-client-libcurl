<?php
require __DIR__ . '/../client/APIErrorCode.php';
require __DIR__ . '/../client/APIResponse.php';
require __DIR__ . '/../client/NeutrinoAPIClient.php';

$neutrinoAPIClient = new NeutrinoAPI\NeutrinoAPIClient("<your-user-id>", "<your-api-key>");

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
    
    // The domain name of this email address
    echo "domain: ", var_export($data['domain'], true), "\n";
    
    // True if this address has any domain name or DNS related errors. Check the 'domain-status' field
    // for the detailed error reason
    echo "domain-error: ", var_export($data['domain-error'], true), "\n";
    
    // The email domain status, possible values are:
    // • ok - the domain is in working order and can receive email
    // • invalid - the domain is not a conformant hostname. May contain invalid syntax or characters
    // • no-service - the domain owner has indicated there is no mail service on the domain (also
    //   known as the 'Null MX')
    // • no-mail - the domain has no valid MX records so cannot receive email
    // • mx-invalid - MX records contain invalid or non-conformant hostname values
    // • mx-bogon - MX records point to bogon IP addresses
    // • resolv-error - MX records do not resolve to any valid IP addresses
    echo "domain-status: ", var_export($data['domain-status'], true), "\n";
    
    // The complete email address. If you enabled the 'fix-typos' option then this will be the corrected
    // address
    echo "email: ", var_export($data['email'], true), "\n";
    
    // True if this email domain has a catch-all policy. A catch-all domain will accept mail for any
    // username so therefor the 'smtp-status' will always be 'ok'
    echo "is-catch-all: ", var_export($data['is-catch-all'], true), "\n";
    
    // True if the mail server responded with a temporary failure (either a 4xx response code or
    // unresponsive server). You can retry this address later, we recommend waiting at least 15 minutes
    // before retrying
    echo "is-deferred: ", var_export($data['is-deferred'], true), "\n";
    
    // True if this address is a disposable, temporary or darknet related email address
    echo "is-disposable: ", var_export($data['is-disposable'], true), "\n";
    
    // True if this address is from a free email provider
    echo "is-freemail: ", var_export($data['is-freemail'], true), "\n";
    
    // True if this address likely belongs to a person. False if this is a role based address, e.g.
    // admin@, help@, office@, etc.
    echo "is-personal: ", var_export($data['is-personal'], true), "\n";
    
    // The first resolved IP address of the primary MX server, may be empty if there are domain errors
    // present
    echo "mx-ip: ", var_export($data['mx-ip'], true), "\n";
    
    // The domain name of the email hosting provider
    echo "provider: ", var_export($data['provider'], true), "\n";
    
    // The raw SMTP response message received during verification
    echo "smtp-response: ", var_export($data['smtp-response'], true), "\n";
    
    // The SMTP username verification status for this address:
    // • ok - verification was successful, this is a real username that can receive mail
    // • absent - this username or domain is not registered with the email service provider
    // • invalid - not a valid email address, check the 'domain-status' field for specific details
    // • unresponsive - the mail servers for this domain have repeatedly timed-out or refused multiple
    //   connection attempts
    // • unknown - sorry, we could not reliably determine the status of this username
    echo "smtp-status: ", var_export($data['smtp-status'], true), "\n";
    
    // True if this address has any syntax errors or is not in RFC compliant formatting
    echo "syntax-error: ", var_export($data['syntax-error'], true), "\n";
    
    // True if any typos have been fixed. The 'fix-typos' option must be enabled for this to work
    echo "typos-fixed: ", var_export($data['typos-fixed'], true), "\n";
    
    // Is this a valid email address. To be valid an email must have: correct syntax, a registered and
    // active domain name, correct DNS records and operational MX servers
    echo "valid: ", var_export($data['valid'], true), "\n";
    
    // True if this email address has passed SMTP username verification. Check the 'smtp-status' and
    // 'domain-status' fields for specific verification details
    echo "verified: ", var_export($data['verified'], true), "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}
