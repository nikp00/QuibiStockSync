<?php

/**
 * @package QuibiStockSync
 */

namespace Inc\Api\Callbacks;
use \Inc\Base\BaseController;
use \Inc\Base\Crypt;
use \Inc\Api\ApiManager;

 class AdminCallbacks extends BaseController
{   
    public $api_manager;

    function __construct(){
        parent::__construct();
        $this->api_manager = new ApiManager();
    }


    public function admin_dashboard(){
        return require_once("$this->plugin_path/templates/admin.php");
    }

    public function qss_options_group($input){
        return $input;
    }


    
    public function qss_username_field(){
        /**
         * When the settings are saved, the username is retrieved from the DB, encrypted and stored
         */
        if(isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true'){
            $opt = get_option('qss_username');
            $opt = Crypt::encrypt($opt, $this->key, $this->iv);
            update_option( 'qss_username', $opt);
            
        }
        
        /**
         * Gets and decrypts the username from the BD, if it doesn't exist a placeholder will be shown
         */
        $value = get_option('qss_username');
        $value = Crypt::decrypt($value, $this->key, $this->iv);
        echo '<input type="text" class="regular-text" name="qss_username" value="'.$value.'" placeholder="Username">';
    }
    
    public function qss_password_field(){
        /**
         * When the settings are saved, the password is retrieved from the DB, encrypted and stored
         */
        if(isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true'){
            $opt = get_option('qss_password');
            $opt = Crypt::encrypt($opt, $this->key, $this->iv);
            update_option( 'qss_password', $opt);

            /**
             * When the password is encrypted and stored, the check_credentials() function checks if the entered credentials are valid
             */

            $this->api_manager->check_credentials();
        }

        /**
         * Gets and decrypts the password from the BD, if it doesn't exist a placeholder will be shown
         */
        $value = esc_attr(get_option('qss_password'));
        $value = Crypt::decrypt($value, $this->key, $this->iv);
        echo '<input type="password" class="regular-text" name="qss_password" value="'.$value.'" placeholder="Password">';
    }

    public function qss_sync_list(){
        $schedules = wp_get_schedules();
        $value = esc_attr(get_option('qss_sync_interval'));

        echo '<select id="qss_sync_interval" name="qss_sync_interval">';
        foreach ($schedules as $key => $schedule){
            echo '<option value="'.$key.'"'.($value == $key ? 'selected="selected"' : '').'>'.$schedule['display'].'</option>';
        }
        echo '</select>';        
    }
}