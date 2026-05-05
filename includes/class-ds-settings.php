<?php

class DS_Settings {

    public function __construct() {
        add_action( 'admin_init', [ $this, 'register_settings' ] );
    }

    public function register_settings() {
        
        
        register_setting( 'usp_group', 'usp_shipping_data' );

        
        register_setting( 'usp_group', 'usp_general_config' );
    }

    
    public static function get_areas() {
        return get_option( 'usp_shipping_data', [] );
    }

    public static function get_config() {
        return get_option( 'usp_general_config', [] );
    }
}