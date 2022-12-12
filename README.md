# NeutrinoAPI PHP cURL SDK

PHP client using the libcURL extension

The official API client and SDK built by [NeutrinoAPI](https://www.neutrinoapi.com/)

| Feature          |       |
|------------------|-------|
| Platform Version | >= 7  |
| HTTP Library     |       |
| JSON Library     |       |
| HTTP/2           | true  |
| HTTP/3           | false |
| CodeGen Version  | 4.6.8 |

## Getting started

First you will need a user ID and API key pair: [SignUp](https://www.neutrinoapi.com/signup/)

## To Initialize 
```php
use NeutrinoAPI\NeutrinoAPIClient;

$neutrinoAPI = new NeutrinoAPI('<your-user-id>', '<your-api-key>');
```

## Running Examples

```sh
$ php neutrino-api-client-libcurl/src/examples/BadWordFilter.php
```
You can find examples of all APIs in _src/examples/_

## For Support 
[Contact us](https://www.neutrinoapi.com/contact-us/)
