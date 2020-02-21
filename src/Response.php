<?php

namespace Curl;

// https://github.com/php-fig/http-message/blob/master/src/ResponseInterface.php#L11
class Response
{
    public $status;
    public $body;

    // usually empty
    public $error;

    /** @var CurlInfo */
    public $info;
}