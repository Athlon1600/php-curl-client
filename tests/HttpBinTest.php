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

        $redirect_to = "https://www.google.com/";

        $response = $client->get('https://google.com');

        $this->assertEquals(200, $response->status);
        $this->assertEquals($redirect_to, $response->info['url']);
    }

    public function test_redirect_nofollow()
    {
        $client = new Client();

        $redirect_to = "https://azenv.net/";

        $response = $client->request('GET', 'https://google.com', [], [], [
            CURLOPT_FOLLOWLOCATION => 0
        ]);

        $this->assertEquals(301, $response->status);
    }

    // https://github.com/Kong/insomnia/issues/227
    public function redirect_switch_to_get()
    {
        $client = new Client();

        $response = $client->post('https://httpbin.org/redirect-to?url=https://www.google.com/&status_code=301');

        // if CURLOPT_CUSTOMREQUEST was set, then redirect would follow from POST -> POST, rather than POST -> GET
        // POST to google index gives 405
        //  <p>The request method <code>POST</code> is inappropriate for the URL <code>/</code>.  <ins>That’s all we know.</ins>
        $this->assertEquals(200, $response->status);
    }
}