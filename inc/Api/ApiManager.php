<?php

/**
 * @package QuibiStockSync
 */

namespace Inc\Api;

use \Inc\Base\Crypt;
use \Inc\Base\BaseController;
class ApiManager extends BaseController
{   
    function __construct(){
        parent::__construct();

        /**
         * The qss_sync_stock function is hooked to the qss_cronjob event
         */
        add_action ('qss_cronjob', array($this, 'qss_sync_stock')); 
    }


    /**
     * The qss_cronjob is registered with the selected time interval
     */
    function register_cron_job(){
        if( !wp_next_scheduled( 'qss_cronjob' ) ) {  
            $interval = get_option('qss_sync_interval');
            wp_schedule_event( time(), $interval, 'qss_cronjob' );
        }
    }
    
    public static function remove_cron_job(){
        if( wp_next_scheduled( 'qss_cronjob' ) ) {  
            $timestamp = wp_next_scheduled ('qss_cronjob');
            wp_unschedule_event ($timestamp, 'qss_cronjob');
        }
    }


    /**
     * The function checks if the credentials are valid, if
     *      -   TRUE: if the cronjob was already registered it is removed, and a new one is registere
     *      -   FALSE: the existing cronjob is removed
     */
    public function check_credentials(){
        $username = Crypt::decrypt(get_option('qss_username'), $this->key, $this->iv);
        $password = Crypt::decrypt(get_option('qss_password'), $this->key, $this->iv);
        if (!$this->api_call('/api2/sifranti', $username, $password)['error']){
            $this->remove_cron_job();
            $this->register_cron_job();
        } else{
            $this->remove_cron_job();
            echo 'Wrong credentials.';
        }
    }


    /**
     * The function first retrieves al the ids of the locations (warehouses) and the loops trough them and updates the stock quantity of the items inside
     */
    public function qss_sync_stock(){
        $username = Crypt::decrypt(get_option('qss_username'), $this->key, $this->iv);
        $password = Crypt::decrypt(get_option('qss_password'), $this->key, $this->iv);
        $locations_array = $this->api_call('/api2/skladisca', $username, $password);
        $locations_id = array();
        foreach ($locations_array['data']['Skladisca'] as $location){
            array_push($locations_id, intval($location['Skladisca']['id']));
        }

        foreach ($locations_id as $location_id){
            $items = $this->api_call("/api2/sifranti/trenutnazaloga/$location_id", $username, $password);
            foreach ($items['data']['TrenutnaZaloga'] as $item){
                $qty = intval($item['0']['zaloga']);
                $sku = $item['s']['sifra'];
                $id = wc_get_product_id_by_sku("$sku");
	            wc_update_product_stock($id, $qty, 'set');
            }
        }
    }

    function api_call($endpoint, $username, $password){
    /*
        $url = "https://dev2.quibi.net";
        $opts = array( 'http'=>array(
            'method' => "GET",
            'header' => "Content-Type: application/json\r\n" .
                      "username: {$username}\r\n" .
                      "password: {$password}\r\n"              
          )
        );
        return json_decode(file_get_contents("$url$endpoint", false, stream_context_create($opts)), true);
    */

        $url = "https://dev2.quibi.net";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "$url$endpoint");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            "username: $username",
            "password: $password"
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result, true);
    }
}