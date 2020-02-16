![](https://img.shields.io/github/last-commit/Athlon1600/php-curl-client.svg) 



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

// returns standardized Response object no matter what
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

Works with POST requests too:

```php
$client->post('http://httpbin.org/post', ['username' => 'bob', 'password' => 'test']);
```

or you can issue a completely customized request:

```php
$client->request('GET', 'https://www.whatismyip.com/', null, [
    'User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 12_0 like Mac OS X)'
], [
    CURLOPT_PROXY => '127.0.0.1:8080',
    CURLOPT_TIMEOUT => 10
]);
```

## TODO

- make PSR-7 and PSR-18 compatible

