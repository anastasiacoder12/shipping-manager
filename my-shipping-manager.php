<?php
/**
 * Plugin Name: My Shipping Manager
 * Description: Διαχείριση περιοχών με δυνατότητα CSV Import & Export, για δυναμικό υπολογισμό μεταφορικών.
 * Version: 1.0
 * Author: Anastasia Kosmetou
 */


if ( ! defined( 'ABSPATH' ) ) exit;


define( 'USP_PATH', plugin_dir_path( __FILE__ ) );
define( 'USP_URL', plugin_dir_url( __FILE__ ) );


require_once USP_PATH . 'includes/class-ds-settings.php';
require_once USP_PATH . 'includes/class-ds-admin.php';
require_once USP_PATH . 'includes/class-ds-checkout.php';


add_action( 'plugins_loaded', function() {
    new DS_Settings();  
    new DS_Admin();     
    new DS_Checkout();  
});