<?php

class DS_Checkout {

    public function __construct() {
    if ( ! class_exists( 'WooCommerce' ) ) return;

    
    add_filter( 'woocommerce_checkout_fields', [ $this, 'override_checkout_city_fields' ], 9999 );

    add_filter( 'woocommerce_package_rates', [ $this, 'calculate_custom_shipping' ], 10, 2 );
    add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_checkout_assets' ] );
    add_filter( 'woocommerce_checkout_fields', [ $this, 'usp_rename_city_label' ], 999 );
}


public function usp_rename_city_label( $fields ) {
    
    if ( isset( $fields['billing']['billing_city'] ) ) {
        $fields['billing']['billing_city']['label'] = 'Περιοχή';
        $fields['billing']['billing_city']['placeholder'] = 'Επιλέξτε την περιοχή σας...';
    }

    
    if ( isset( $fields['shipping']['shipping_city'] ) ) {
        $fields['shipping']['shipping_city']['label'] = 'Περιοχή';
        $fields['shipping']['shipping_city']['placeholder'] = 'Επιλέξτε την περιοχή σας...';
    }

    return $fields;
}


public function override_checkout_city_fields( $fields ) {
    $areas = DS_Settings::get_areas();
    $options = [ '' => 'Επιλέξτε Περιοχή...' ];
    
    if ( ! empty( $areas ) ) {
        foreach ( $areas as $row ) {
            $options[$row['name']] = $row['name'];
        }
    }

    
    foreach ( ['billing', 'shipping'] as $type ) {
        if ( isset( $fields[$type][$type . '_city'] ) ) {
            $fields[$type][$type . '_city']['type'] = 'select';
            $fields[$type][$type . '_city']['options'] = $options;
            $fields[$type][$type . '_city']['class'] = array('form-row-wide', 'update_totals_on_change');
            $fields[$type][$type . '_city']['input_class'] = array('wc-enhanced-select');
        }
    }

    return $fields;
}

    /**
     * Υπολογισμός Κόστους
     */
    public function calculate_custom_shipping( $rates, $package ) {
    if ( ! function_exists( 'WC' ) ) return $rates;

    // Παίρνουμε την πόλη που επέλεξε ο πελάτης από το dropdown
    $chosen_city = WC()->customer->get_shipping_city();
    if ( empty( $chosen_city ) ) {
        $chosen_city = WC()->customer->get_billing_city();
    }

    $areas = DS_Settings::get_areas();
    $config = DS_Settings::get_config();

    // Default τιμή αν δεν βρεθεί η περιοχή
    $final_cost = isset( $config['default_price'] ) ? (float) $config['default_price'] : 5.00;

    if ( ! empty( $areas ) && ! empty( $chosen_city ) ) {
        foreach ( $areas as $row ) {

            $area_name = trim((string)$row['name']);
            $user_city = trim((string)$chosen_city);

            if ( $area_name === $user_city ) {
                $final_cost = (float) $row['price'];
                break;
            }
        }
    }

    // Εφαρμογή της τιμής στις μεθόδους αποστολής
    foreach ( $rates as $rate_key => $rate ) {
        if ( 'flat_rate' === $rate->method_id ) {
            $rates[$rate_key]->cost = $final_cost;
        }
    }

    return $rates;
}

    public function enqueue_checkout_assets() {
    if ( function_exists( 'is_checkout' ) && is_checkout() ) {
        
        
        wp_enqueue_script( 'select2' );
        wp_enqueue_style( 'select2' );

        wp_enqueue_style( 'usp-checkout-css', USP_URL . 'assets/css/checkout-style.css', [], '1.1' );

        wp_enqueue_script( 
            'usp-checkout-js', 
            USP_URL . 'assets/js/checkout-script.js', 
            array('jquery', 'select2'), 
            '1.1', 
            true 
        );

        wp_add_inline_script( 'usp-checkout-js', "
            jQuery(document).ready(function($) {
                $('select#shipping_city').select2();
            });
        ");
    }
}
}