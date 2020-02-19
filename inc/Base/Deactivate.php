<?php

/**
 * @package QuibiStockSync
 */

namespace Inc\Base;
use Inc\Api\ApiManager;
 class Deactivate
 {
     public static function deactivate(){
        flush_rewrite_rules();
        ApiManager::remove_cron_job();
     }
 }
 