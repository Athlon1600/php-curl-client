<?php

namespace Curl;

class BrowserClient extends Client
{
    // HTTP headers that uniquely identify this browser such as User-Agent
    protected $headers = array(
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Encoding' => 'gzip, deflate',
        'Accept-Language' => 'en-US,en;q=0.5',
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:71.0) Gecko/20100101 Firefox/71.0'
    );

    protected $options = array(
        CURLOPT_ENCODING => '', // apparently curl will decode gzip automatically when this is empty
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_AUTOREFERER => 1,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 15
    );

    protected static $_storage_dir;

    /** @var string Where the cookies are stored */
    protected $cookie_file;

    public function __construct()
    {
        parent::__construct();

        $cookie_file = join(DIRECTORY_SEPARATOR, [static::getStorageDirectory(), "BrowserClient"]);
        $this->setCookieFile($cookie_file);
    }

    protected function getStorageDirectory()
    {
        return static::$_storage_dir ? static::$_storage_dir : sys_get_temp_dir();
    }

    // TODO: make this apply across all previous browser sessions too
    public static function setStorageDirectory($path)
    {
        static::$_storage_dir = $path;
    }

    /**
     * Format ip:port or null to use direct connection
     * @param $proxy_server
     * @param $proxy_type
     */
    public function setProxy($proxy_server, $proxy_type = CURLPROXY_HTTP)
    {
        $this->options[CURLOPT_PROXY] = $proxy_server;
        $this->options[CURLOPT_PROXYTYPE] = $proxy_type;
    }

    public function getProxy()
    {
        return !empty($this->options[CURLOPT_PROXY]) ? $this->options[CURLOPT_PROXY] : null;
    }

    public function getProxyType()
    {
        return !empty($this->options[CURLOPT_PROXYTYPE]) ? $this->options[CURLOPT_PROXYTYPE] : null;
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

    // Manual alternative for: curl_getinfo($ch, CURLINFO_COOKIELIST));
    public function getCookies()
    {
        $contents = @file_get_contents($this->getCookieFile());
        return $contents;
    }

    public function setCookies($cookies)
    {
        return @file_put_contents($this->getCookieFile(), $cookies) !== false;
    }

    public function clearCookies()
    {
        @unlink($this->getCookieFile());
    }
}
