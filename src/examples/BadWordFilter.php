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

    // The character to use to censor out the bad words found
    "censor-character" => "",

    // Which catalog of bad words to use, we currently maintain two bad word catalogs:
    // • strict - the largest database of bad words which includes profanity, obscenity, sexual, rude,
    //   cuss, dirty, swear and objectionable words and phrases. This catalog is suitable for
    //   environments of all ages including educational or children's content
    // • obscene - like the strict catalog but does not include any mild profanities, idiomatic
    //   phrases or words which are considered formal terminology. This catalog is suitable for adult
    //   environments where certain types of bad words are considered OK
    "catalog" => "strict",

    // The content to scan. This can be either a URL to load from, a file upload or an HTML content
    // string
    "content" => "https://en.wikipedia.org/wiki/Profanity"
);

$apiResponse = $neutrinoAPIClient->badWordFilter($params);
if ($apiResponse->isOK()) {
    $data = $apiResponse->getData();
    echo "API Response OK: \n";
    
    // An array of the bad words found
    echo "bad-words-list: ", (isset($data['bad-words-list'])) ? var_export($data['bad-words-list'], true) : "NULL", "\n";
    
    // Total number of bad words detected
    echo "bad-words-total: ", (isset($data['bad-words-total'])) ? var_export($data['bad-words-total'], true) : "NULL", "\n";
    
    // The censored content (only set if censor-character has been set)
    echo "censored-content: ", (isset($data['censored-content'])) ? var_export($data['censored-content'], true) : "NULL", "\n";
    
    // Does the text contain bad words
    echo "is-bad: ", (isset($data['is-bad'])) ? var_export($data['is-bad'], true) : "NULL", "\n";
} else {
    error_log(sprintf("API Error: %s, Error Code: %d, HTTP Status Code: %d", $apiResponse->getErrorMessage(), $apiResponse->getErrorCode(), $apiResponse->getStatusCode()));
    if (strlen($apiResponse->getErrorCause()) > 0) {
        error_log(sprintf("Error Caused By: %s", $apiResponse->getErrorCause()));
    }
}