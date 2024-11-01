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

	function tmk_remove_options() {
		// delete_option( 'tmk-data');
		// delete_option( 'tmk-status' );
		// delete_option( 'tmk-default-script' );
		// delete_option( 'tmk-button-design' );
	} register_deactivation_hook( __FILE__ , 'tmk_remove_options' );