<?php

/**
 * @package QuibiStockSync
 */

namespace Inc\Pages;
use \Inc\Api\SettingsApi;
use \Inc\Base\BaseController;
use \Inc\Api\Callbacks\AdminCallbacks;

 class Admin extends BaseController
 {
   public $callbacks;
   public $settings;
   public $pages = array();

   public function register(){
      $this->settings = new SettingsApi();

      $this->callbacks = new AdminCallbacks();

      $this->set_pages();
      
      $this->set_settings();

      $this->set_sections();
      
      $this->set_fields();

      $this->settings->add_pages($this->pages)->register();
   }

   public function set_pages(){
      $this->pages = [
         [
         'page_title' => 'Quibi Stock Sync',
         'menu_title' => 'Quibi Stock Sync',
         'capability' => 'manage_options',
         'menu_slug' => 'quibi_stock_sync',
         'callback' => array($this->callbacks, 'admin_dashboard'), 
         'icon_url' => 'dashicons-update',
         'position' => 110 
         ]
      ];
   }


   public function set_settings(){
      $args = array(
         array(
            'option_group' => 'api_credentials_group',
            'option_name' => 'qss_username'
            ),
         array(
            'option_group' => 'api_credentials_group',
            'option_name' => 'qss_password'
         ),
         array(
            'option_group' => 'api_credentials_group',
            'option_name' => 'qss_sync_interval'
         )
      );

      $this->settings->set_settings($args);
   }

   public function set_sections(){
      $args = array(
         array(
            'id' => 'quibi_stock_sync',
            'title' => 'Settings',
            'callback' => array(),
            'page' => 'quibi_stock_sync'
         )
      );

      $this->settings->set_sections($args);
   }

   public function set_fields(){
      $args = array(
         array(
            'id' => 'qss_username',
            'title' => 'Username',
            'callback' => array( $this->callbacks, 'qss_username_field'),
            'page' => 'quibi_stock_sync',
            'section' => 'quibi_stock_sync',
            'args' => array(
               'label_for' => 'qss_username'
            )
            ),
            array(
               'id' => 'qss_password',
               'title' => 'Password',
               'callback' => array( $this->callbacks, 'qss_password_field'),
               'page' => 'quibi_stock_sync',
               'section' => 'quibi_stock_sync',
               'args' => array(
                  'label_for' => 'qss_password'
               )
            ),
            array(
               'id' => 'qss_sync_interval',
               'title' => 'Sync interval',
               'callback' => array( $this->callbacks, 'qss_sync_list'),
               'page' => 'quibi_stock_sync',
               'section' => 'quibi_stock_sync',
               'args' => array(
                  'label_for' => 'qss_sync_interval'
               )
            )
      );

      $this->settings->set_fields($args);
   }
}