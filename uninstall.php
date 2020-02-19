<?php
/**
 * @package QuibiStockSync
 */

 if(!defined('WP_UNINSTALL_PLUGIN')){
     die;
 }

global $wpdb;
$table = $wpdb->prefix.'options';
$wpdb -> query("DELETE FROM $table WHERE option_name = 'qss_username' or option_name = 'qss_password' or option_name = 'qss_sync_interval'");