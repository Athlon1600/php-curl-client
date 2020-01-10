<?php

namespace Curl;

class BrowserClient extends Client
{
    protected $headers = array(
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Encoding' => 'identity',
        'Accept-Language' => 'en-US,en;q=0.5',
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0'
    );

    protected $options = array(
        CURLOPT_ENCODING => '', // apparently curl will decode gzip automatically when this is empty
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 15
    );

    protected $cookie_file;

    public function __construct()
    {
        parent::__construct();

        $cookie_file = join(DIRECTORY_SEPARATOR, [sys_get_temp_dir(), "BrowserClient"]);
        $this->setCookieFile($cookie_file);
    }

    public function setCookieFile($cookie_file)
    {
        $this->cookie_file = $cookie_file;

        // read & write cookies
        $this->options[CURLOPT_COOKIEJAR] = $cookie_file;
        $this->options[CURLOPT_COOKIEFILE] = $cookie_file;
    }

    public function getCookieFile()
    {
        return $this->cookie_file;
    }

    public function clearCookies()
    {
        unlink($this->getCookieFile());
    }
}
