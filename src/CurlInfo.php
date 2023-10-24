<?php

namespace Curl;

/** @noinspection SpellCheckingInspection */

/**
 * @property-read string $url
 * @property-read string $content_type
 * @property-read int $http_code
 * @property-read int $header_size
 * @property-read int $request_size
 * @property-read int $filetime
 * @property-read int $ssl_verify_result
 * @property-read int $redirect_count
 *
 * @property-read double $total_time
 * @property-read double $namelookup_time
 * @property-read double $connect_time
 * @property-read double $pretransfer_time
 *
 * @property-read int $size_upload
 * @property-read int $size_download
 *
 * @property-read int $speed_download
 * @property-read int $speed_upload
 *
 * @property-read int $download_content_length
 * @property-read int $upload_content_length
 *
 * @property-read double $starttransfer_time
 * @property-read double $redirect_time
 *
 * @property-read array $certinfo
 *
 * @property-read string $primary_ip
 * @property-read int $primary_port
 *
 * @property-read string $local_ip
 * @property-read int $local_port
 *
 * @property-read string $redirect_url
 */
class CurlInfo implements \ArrayAccess
{
    protected $info;

    public function __construct($info)
    {
        $this->info = $info;
    }

    public function toArray()
    {
        return $this->info;
    }

    public function __get($prop)
    {
        return $this->offsetGet($prop);
    }

    /**
     * Whether a offset exists
     * @link https://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->info);
    }

    /**
     * Offset to retrieve
     * @link https://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->info[$offset];
    }

    /**
     * Offset to set
     * @link https://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value) : void
    {
        // READONLY
    }

    /**
     * Offset to unset
     * @link https://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset) : void
    {
        // READONLY
    }
}