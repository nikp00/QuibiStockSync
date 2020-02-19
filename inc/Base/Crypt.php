<?php

/**
 * @package QuibiStockSync
 */

namespace Inc\Base;

 class Crypt
{   
    public static function encrypt(string $string, string $key, string $iv){
        return base64_encode(openssl_encrypt($string, "aes-256-cbc", base64_decode($key), 0, $iv));
    }

    public static function decrypt(string $string, string $key, string $iv){
        $string = base64_decode($string);
        return openssl_decrypt($string, "aes-256-cbc", base64_decode($key), 0, $iv);
    }
}