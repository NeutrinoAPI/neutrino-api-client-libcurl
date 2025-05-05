# NeutrinoAPI PHP cURL SDK

Neutrino API PHP client using the libcURL extension

The official API client and SDK built by [NeutrinoAPI](https://www.neutrinoapi.com/)

| Feature          |        |
|------------------|--------|
| Platform Version | >= 7   |
| HTTP Library     | Native |
| JSON Library     | Native |
| HTTP/2           | Yes    |
| HTTP/3           | No     |
| CodeGen Version  | 4.7.1  |

## Getting started

First you will need a user ID and API key pair: [SignUp](https://www.neutrinoapi.com/signup/)

## To Initialize 
```php
$neutrinoAPI = new NeutrinoAPI\NeutrinoAPIClient('<your-user-id>', '<your-api-key>');
```

## Running Examples
```sh
$ php src/examples/IPInfo.php
```
You can find examples of all APIs in _src/examples/_

Set the __'your-user-id'__ and __'your-api-key'__ values in the example to retrieve real API responses

## Install using Composer
```sh
$ composer require neutrino_api/neutrino_api_client
```

## For Support 
[Contact us](https://www.neutrinoapi.com/contact-us/)
