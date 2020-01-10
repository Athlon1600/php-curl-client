<?php

namespace Curl\Tests;

use Curl\BrowserClient;
use PHPUnit\Framework\TestCase;

class BrowserTest extends TestCase
{
    public function test_cookies()
    {
        $browser = new BrowserClient();
        $browser->clearCookies();

        $cookies = array(
            'cookie_one' => '111',
            'cookie_two' => 222
        );

        $browser->get('https://httpbin.org/cookies/set', $cookies);

        $response = $browser->get('https://httpbin.org/cookies');
        $json = json_decode($response->body, true);

        $this->assertEquals($cookies, $json['cookies']);
    }
}