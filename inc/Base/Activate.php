<?php

/**
 * @package QuibiStockSync
 */

namespace Inc\Base;

use Inc\Api\ApiManager;

 class Activate
 {
     public static function activate(){
        flush_rewrite_rules();
        $api_manager = new ApiManager();
        if (get_option('qss_username', NULL) != NULL &&
            get_option( 'qss_password', NULL ) != NULL &&
            get_option('qss_sync_interval', NULL) != NULL){
            
                $api_manager->check_credentials();
        }
     }
 }
 