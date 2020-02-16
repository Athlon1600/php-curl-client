# PHP Curl Client

A very simple curl client - less than 100 lines. Perfect for being a base class.

## Installation

```bash
composer require athlon1600/php-curl-client
```

## Examples

```php
use Curl\Client;

$client = new Client();
$response = $client->get('https://stackoverflow.com');

// 200
$status = $response->status;

// HTML content
$body = $response->body;

// curl_error() OR null
$error = $response->error;

// curl_info() array
$info = $response->info;
```

## TODO

- make PSR-7 and PSR-18 compatible

