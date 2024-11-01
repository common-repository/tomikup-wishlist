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

    function tmk_shortcode( $atts ) {
		$button = str_replace( array( '\"', "\'" ), array( '"', "'" ), get_option( 'tmk-button-design', false ) );

		if( tmk_is_woo() ) {
			if( is_singular( 'product' ) ) {
				$button = str_replace( '"tomikup-button"', '"tomikup-button" style="margin-top:15px;margin-bottom:15px;" ', $button );
			}
		}

		return $button;
	} add_shortcode( 'tomikup', 'tmk_shortcode' );