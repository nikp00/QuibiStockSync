<?php

/**
 * @package QuibiStockSync
 * 
 */
/*
Plugin Name: Quibi stock sync
Plugin URI: https://github.com/nikp00/QuibiStockSync
Description: Stock sync from Quibi
Version: 1.0.0
Author: Nik Prinčič
Author URI: https://github.com/nikp00
License: GNU GPLv3 or later
Text Domain: Quibi stock sync
*/

defined('ABSPATH') or die('Hi there!  I\'m just a plugin, not much I can do when called directly.');
if (file_exists(dirname(__FILE__).'/vendor/autoload.php')){
    require_once dirname(__FILE__).'/vendor/autoload.php';
}

use Inc\Base\Activate;
use Inc\Base\Deactivate;
use Inc\Base\ErrorHandler;


function activate_quibi_stock_sync(){
    Activate::activate(); 
}

function deactivate_quibi_stock_sync(){
    Deactivate::deactivate();
}

register_activation_hook( __FILE__, 'activate_quibi_stock_sync');
register_deactivation_hook( __FILE__, 'deactivate_quibi_stock_sync');


if (class_exists('Inc\\Init')){
    Inc\Init::register_services();
}


