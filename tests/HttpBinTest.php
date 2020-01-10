<?php

namespace Curl\Tests;

use Curl\Client;
use PHPUnit\Framework\TestCase;

class HttpBinTest extends TestCase
{
    public function test_get()
    {
        $client = new Client();
        $response = $client->request('GET', 'http://httpbin.org/get');
        $this->assertEquals(200, $response->status);
    }

    public function test_form_post()
    {
        $client = new Client();

        $form_data = array(
            'username' => 'test',
            'password' => 'pass'
        );

        $response = $client->request('POST', 'http://httpbin.org/post', $form_data);

        $this->assertEquals(200, $response->status);

        $json = json_decode($response->body, true);

        $this->assertEquals($form_data, $json['form']);
    }

    public function test_raw_post()
    {
        $client = new Client();

        $post_data = "I_AM_STRING";

        $response = $client->request('POST', 'http://httpbin.org/post', $post_data, [
            'Content-Type' => 'text/plain'
        ]);

        $json = json_decode($response->body, true);

        $this->assertEquals($post_data, $json['data']);
    }

    public function test_status_code()
    {
        $client = new Client();
        $response = $client->request('GET', 'http://httpbin.org/status/400');

        $this->assertEquals(400, $response->status);
    }

    public function test_redirect()
    {
        $client = new Client();

        $redirect_to = "https://azenv.net/";

        $response = $client->request('GET', 'https://httpbin.org/redirect-to', [
            'url' => $redirect_to
        ]);

        $this->assertEquals(200, $response->status);
        $this->assertEquals($redirect_to, $response->info['url']);
    }

    public function test_redirect_nofollow()
    {
        $client = new Client();

        $redirect_to = "https://azenv.net/";

        $response = $client->request('GET', 'https://httpbin.org/redirect-to', [
            'url' => $redirect_to
        ], [], [
            CURLOPT_FOLLOWLOCATION => 0
        ]);

        $this->assertEquals(302, $response->status);
    }
}