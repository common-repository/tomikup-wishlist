<?php
/**
 * Plugin Name:       Seznam přání a hlídací pes Tomikup
 * Plugin URI:        https://tomikup.cz/
 * Description:       Seznam přání a hlídací pes
 * Version:           1.0.1
 * Author:            Pavel Mareš
 * Author URI:        https://mares-pavel.cz/
 * Text Domain:       tomikup-wishlist
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

	// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) die;

	define( 'TMKDIR', plugin_dir_path( __FILE__ ) );
	define( 'TMKURL', plugin_dir_url( __FILE__ ) );

	// setup variables
	include( TMKDIR . 'setup.php');

	// shortcode
	include( TMKDIR . 'shortcode.php');

	// basic general functions
	include( TMKDIR . 'functions.php');

	// uninstall hook
	include( TMKDIR . 'uninstall.php');

	// WooCommerce functuons
	include( TMKDIR . 'woocommerce/woocommerce.php');

	// WooCommerce functuons
	include( TMKDIR . 'hooks.php');

	// include admin page
	if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
		include( TMKDIR . 'admin/tmk-admin.php' );
	}