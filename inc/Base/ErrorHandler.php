<?php

/**
 * @package QuibiStockSync
 */

namespace Inc\Base;
use \Inc\Base\BaseController;

 class ErrorHandler extends BaseController
{   
    public static function show_error(){
        add_action( 'admin_notices', 'woocommerce_not_installed');
    }

    function woocommerce_not_installed(){
        ?>
        <div class="update-nag notice">
        <p><?php _e( 'Please Woocommerce, it is required for this plugin to work properly!', 'qss_textdomain' ); ?></p>
        </div>
        <?php
    }
}