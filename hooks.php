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
    
    function tmk_footer_code() {
		$tmk_status = get_option( 'tmk-status', false );

		$allow_status = array( 'tmk-status-fixed', 'tmk-status-custom', 'tmk-status-woo' );
		if( in_array( $tmk_status, $allow_status ) ) {
			global $wpdb;
			
			$data = get_option( 'tmk-data', false );
			$script = str_replace( array( '\"', "\'" ), array( '"', "'" ), get_option( 'tmk-default-script', false ) );

			if( $data && $script ) {
				$data = maybe_unserialize( $data ); // print_r( $data );

				if( $data['fixed'] ) { echo do_shortcode( '[tomikup]' ); }
				echo $script;
			}
		}
	} add_action( 'wp_footer', 'tmk_footer_code' );