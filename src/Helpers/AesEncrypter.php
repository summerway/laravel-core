<?php
/**
 * Created by PhpStorm.
 * User: MapleSnow
 * Date: 2019/8/19
 * Time: 3:03 PM
 */

namespace MapleSnow\LaravelCore\Helpers;

use RuntimeException;
use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;


class AesEncrypter implements EncrypterContract
{
    const AES_IV  = "RGd5WkRoak4yVTE="; //16位

    /**
     * The encryption key.
     *
     * @var string
     */
    protected $key;

    /**
     * The algorithm used for encryption.
     *
     * @var string
     */
    protected $cipher;

    /**
     * Create a new encrypter instance.
     *
     * @param  string  $key
     * @param  string  $cipher
     * @return void
     *
     * @throws \RuntimeException
     */
    public function __construct($key, $cipher = 'AES-128-CBC')
    {
        $key = (string) $key;

        if ($this->supported($key, $cipher)) {
            $this->key = $key;
            $this->cipher = $cipher;
        } else {
            throw new RuntimeException('The only supported ciphers are AES-128-CBC and AES-256-CBC with the correct key lengths.');
        }
    }

    /**
     * Determine if the given key and cipher combination is valid.
     *
     * @param  string  $key
     * @param  string  $cipher
     * @return bool
     */
    public function supported($key, $cipher)
    {
        $length = mb_strlen($key, '8bit');

        return ($cipher === 'AES-128-CBC' && $length === 16) ||
            ($cipher === 'AES-256-CBC' && $length === 32);
    }


    public  function encrypt($value, $serialize = false)
    {
        $encrypted_data = openssl_encrypt($serialize ? serialize($value) : $value, $this->cipher, $this->key, OPENSSL_RAW_DATA, $this::AES_IV);

        return base64_encode($encrypted_data);
    }

    public  function decrypt($payload, $unserialize = false)
    {
        $decrypted = openssl_decrypt(base64_decode($payload), $this->cipher, $this->key, OPENSSL_RAW_DATA, $this::AES_IV);

        return $unserialize ? unserialize($decrypted) : $decrypted;
    }
}