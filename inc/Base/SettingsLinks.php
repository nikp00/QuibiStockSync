<?php

/**
 * @package QuibiStockSync
 */

namespace Inc\Base;
use \Inc\Base\BaseController;


 class SettingsLinks extends BaseController
 {
     public function register(){
         $plugin = plugin_basename( __FILE__ );
        add_filter( "plugin_action_links_$this->plugin", array($this, 'settings_link'));
     }

    public function settings_link($links){
        $settings_link = '<a href="admin.php?page=quibi_stock_sync">Settings</a>';
        array_push($links, $settings_link);
        return $links;
    }
 }