<?php

namespace Curl\Tests;

use Curl\BrowserClient;
use Curl\UserAgents;
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

    public function test_custom_cookie_storage()
    {
        @unlink('./BrowserClient');

        BrowserClient::setStorageDirectory('./');

        $browser = new BrowserClient();
        $browser->get('http://www.yahoo.com');

        $this->assertTrue(file_exists('./BrowserClient'));
    }

    public function test_user_agent()
    {
        $client = new BrowserClient();

        $randomAgent = UserAgents::getRandomGsaUserAgent();
        $client->setUserAgent($randomAgent);

        $response = $client->get("https://httpbin.org/headers");

        $this->assertStringContainsString($randomAgent, $response->body);
    }
}