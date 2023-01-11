<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

/** auto empty cart through /?clear-cart **/ 
add_action( 'init', 'woocommerce_clear_cart_url' );
function woocommerce_clear_cart_url() {
	if ( isset( $_GET['clear-cart'] ) ) {
		global $woocommerce;
		$woocommerce->cart->empty_cart();
	}
}

// unset checkout fields -> virtual products 

// add_filter('woocommerce_billing_fields','wpb_custom_billing_fields');
// // remove some fields from billing form
// // ref - https://docs.woothemes.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/
// function wpb_custom_billing_fields( $fields = array() ) {

// 	unset($fields['billing_first_name']);
// 	unset($fields['billing_last_name']);
// 	unset($fields['billing_company']);
// 	unset($fields['billing_address_1']);
// 	unset($fields['billing_address_2']);
// 	unset($fields['billing_state']);
// 	unset($fields['billing_city']);
// 	unset($fields['billing_phone']);
// 	unset($fields['billing_postcode']);
// 	unset($fields['billing_country']);

// 	return $fields;
// }

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields_ek', 99 );
// Remove some fields from billing form
// Our hooked in function - $fields is passed via the filter!
// Get all the fields - https://docs.woothemes.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/
function custom_override_checkout_fields_ek( $fields ) {
     
	unset($fields['billing']['billing_first_name']);
	unset($fields['billing']['billing_last_name']);
	unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_state']);
	unset($fields['billing']['billing_address_2']);
	unset($fields['billing']['billing_city']);

     return $fields;
}


function virtual_products_less_fields( $fields ) {
     
    // set our flag to be true until we find a product that isn't virtual
    $virtual_products = true;
     
    // loop through our cart
    foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
     // Check if there are non-virtual products and if so make it false
        if ( ! $cart_item['data']->is_virtual() ) $virtual_products = false; 
    }

    // only unset fields if virtual_products is true so we have no physical products in the cart
    if( $virtual_products===true) {
		unset($fields['billing']['billing_first_name']);
		unset($fields['billing']['billing_last_name']);
        unset($fields['billing']['billing_company']);
        unset($fields['billing']['billing_address_1']);
        unset($fields['billing']['billing_address_2']);
        unset($fields['billing']['billing_city']);
        unset($fields['billing']['billing_postcode']);
        unset($fields['billing']['billing_country']);
        unset($fields['billing']['billing_state']);
        // unset($fields['billing']['billing_phone']);
        //Removes Additional Info title and Order Notes
        add_filter( 'woocommerce_enable_order_notes_field', '__return_false',9999 ); 
    }
     
    return $fields;
}

add_filter( 'woocommerce_checkout_fields' , 'virtual_products_less_fields' );

