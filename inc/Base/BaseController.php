<?php

/**
 * @package QuibiStockSync
 */

namespace Inc\Base;

 class BaseController
{   
    public $plugin_path;
    public $plugin_url;
    public $plugin;
    public $key;
    public $iv;

    public function __construct(){
        $this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
        $this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
        $this->plugin = plugin_basename(dirname(__FILE__, 3)) . '/quibi-stock-sync.php';
        $this->key = "G5bZHlzle+xTerZAe6axzb88NzIdpxi/MhOTBunNcIg="; #base64_encode(openssl_random_pseudo_bytes(32));
        $this->iv = 'E5nZBtdjpv11%Iz#'; #openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    }
}