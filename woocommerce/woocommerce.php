<?php
/**
 * @package   Tomikup Wishlist
 * @author    Pavel Mareš
 * @license   GPL-2.0+
 * @link      https://tomikup.cz/
 * @copyright 2020 Tomikup.cz
 */

    // If this file is called directly, abort.
    if ( ! defined( 'WPINC' ) ) die;
    
    add_action( 'woocommerce_before_add_to_cart_form', 	'tmk_woocommerce_place_button', 10, 0 ); 	
	add_action( 'woocommerce_before_add_to_cart_button','tmk_woocommerce_place_button', 10, 0 ); 
	add_action( 'woocommerce_after_add_to_cart_button', 'tmk_woocommerce_place_button', 10, 0 ); 
	add_action( 'woocommerce_after_add_to_cart_form', 	'tmk_woocommerce_place_button', 10, 0 ); 

    function tmk_woocommerce_place_button() { 
		$woo_place = get_option( 'tmk-woocommerce-position', false );
		if( tmk_status() == 'tmk-status-woo' && $woo_place == current_filter() ) {
			echo tmk_woocommerce_place_button_html();
		}
    };

	function tmk_woocommerce_place_button_html() {
		$data = get_option( 'tmk-data', false );
		if( $data ) {
			$data = maybe_unserialize( $data );

			if( ! $data['fixed'] ) {
				return do_shortcode( '[tomikup]' );
			}
		}

		return '';
	}