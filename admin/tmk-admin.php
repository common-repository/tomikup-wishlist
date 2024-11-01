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

	function tmk_admin_page_styles_scripts(){
		wp_enqueue_style( 'tmk-style-font', TMKURL . 'admin/assets/css/font.css', false, '1.0.0' );
		
		if( empty( $_GET['page'] ) || $_GET['page'] != 'tomikup' ) return;

		wp_enqueue_style( 'tmk-style-button', TMKURL . 'admin/assets/css/button-styles.css', false, '1.0.0' );
		wp_enqueue_style( 'tmk-style-admin', TMKURL . 'admin/assets/css/admin.css', false, '1.0.0' );
		
		wp_enqueue_script( 'tmk-script-vue', TMKURL . 'admin/assets/js/vue@2.6.11.js', array(), '2.6.11', true );
		wp_enqueue_script( 'tmk-script-vue-color', TMKURL . 'admin/assets/js/vue-color.min.js', array(), '1.0.0', true );
		wp_enqueue_script( 'tmk-script-tomikup-wishlist', TMKURL . 'admin/assets/js/wishlist.js', array(), '1.0.0', true );
		
		wp_enqueue_script( 'tmk-script-button-generator', TMKURL . 'admin/assets/js/buttonGenerator.v3.js', array( 'tmk-script-vue', 'tmk-script-vue-color', 'tmk-script-tomikup-wishlist' ), '1.0.0', true );
		wp_enqueue_script( 'tmk-script-admin', TMKURL . 'admin/assets/js/admin.js', array(), '1.0.0', true );

		// save data before loading them
		tmk_save_data();

		// Localize the script with new data
		$tmk_data = tmk_get_defaults();
		wp_add_inline_script('tmk-script-tomikup-wishlist','var tmkData ='. json_encode( $tmk_data ) );
	} add_action('admin_enqueue_scripts', 'tmk_admin_page_styles_scripts');

	function tmk_admin_page_register() {
		add_menu_page(
			__( 'Tomikup Nastavení', 'tomikup-wishlist' ),	// page title
			__( 'Tomikup', 'tomikup-wishlist' ),     		// menu title
			'manage_options',   							// capability
			'tomikup',     									// menu slug
			'tmk_admin_page_content', 						// callback function
			'dashicons-tomikup', 							// dashicon
			70												// menu position
		);
	} add_action( 'admin_menu', 'tmk_admin_page_register' );

	function tmk_admin_page_content() {
		ob_start();

		require_once( TMKDIR . 'admin/tmk-admin-page.php' );

		$output = ob_get_contents();
		ob_end_clean();
		
		echo $output;
	}