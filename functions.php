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

    /**
	 * Control if WooCommerce is active
	*/
    function tmk_is_woo() {
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return true; // Check if WooCommerce is active
		}

		return false;
	}

	/**
	 * Write custom logs to system log file
	*/
	if (!function_exists('write_log')) {
		function write_log($log) {
			if (true === WP_DEBUG) {
				if (is_array($log) || is_object($log)) {
					error_log(print_r($log, true));
				} else {
					error_log($log);
				}
			}
		}
	}

	function tmk_get_defaults() {
        global $wpdb;
        global $tmk_defaults_data;

		$return_data = [];

		$data = get_option( 'tmk-data', false );

		if( $data ) {
			$data = maybe_unserialize( $data );

			foreach ( $tmk_defaults_data as $key => $value ) {
				if( !empty( $data[ $key ] ) ) {
					if( $key == 'fixed' ) {
						$return_data[ $key ] = (bool) $data[ $key ];
					} else {
						$return_data[ $key ] = $data[ $key ];
					}
				} else {
					$return_data[ $key ] = $tmk_defaults_data[ $key ];
				}
			}
		} else { $return_data = $tmk_defaults_data; }

		return $return_data;
	}

	function tmk_save_data() {
		if( current_user_can( 'manage_options' ) ) {
			if( ( 	! isset( $_POST['tmk_nonce_field'] ) 
				|| 	! wp_verify_nonce( $_POST['tmk_nonce_field'], 'tmk_nonce_action' ) ) 
			) { /* NOPE */ } else {
				$data = tmk_control_save_data( $_POST ); // print_r( $data );
				$data_maybe_serialize = maybe_serialize( $data ); // var_dump( $data );

				if( ! isset( $data['tmk-status'] ) ) { $data['tmk-status'] = 0; }

				if( tmk_is_woo() ) {
					update_option( 'tmk-woocommerce-position', $data['tmk-woocommerce-position'], true );
				}

				update_option( 'tmk-data', $data_maybe_serialize, true );
				update_option( 'tmk-status', $data['tmk-status'], true );
				update_option( 'tmk-default-script', $data['default_script'], true );
				update_option( 'tmk-button-design', $data['button_design'], true );
			}
		}
	}

	function tmk_control_save_data( $data ) {
		global $tmk_defaults_data;

		$text_fields	= ['buttonText'];
		$boolean_fields = ['fixed', 'textUnderlineHover'];
		$numbers_fields = ['iconSize', 'fontSize', 'fontWeightSliderValue', 'borderWidth', 'borderRadius', 'paddingHorizontal', 'paddingVertical'];
		$hex_fields 	= ['textColor','textColorHover','backgroundColor','backgroundColorHover','borderColor','borderColorHove'];
		$option_fields 	= ['borderStyle','borderStyleHover','tmk-status','tmk-woocommerce-position'];
		$url_fields		= ['helpUrl'];
		$html_fields	= ['default_script','button_design'];

		foreach ( $data as $key => $value ) {
			$remove_field = true;

			if( in_array( $key, $text_fields ) ) {
				$data[ $key ] = sanitize_text_field( $data[ $key ] );
				$remove_field = false;
			}

			if( in_array( $key, $boolean_fields ) ) {
				$data[ $key ] = tmk_esc_boolean( $data[ $key ] );
				$remove_field = false;
			}

			if( in_array( $key, $numbers_fields ) ) {
				$data[ $key ] = tmk_esc_number( $data[ $key ], $tmk_defaults_data[ $key ] );
				$remove_field = false;
			}

			if( in_array( $key, $hex_fields ) ) {
				$data[ $key ] = sanitize_hex_color( $data[ $key ] );
				$remove_field = false;
			}

			if( in_array( $key, $option_fields ) ) {
				$data[ $key ] = tmk_esc_options( $key, $data[ $key ] );
				$remove_field = false;
			}

			if( in_array( $key, $url_fields ) ) {
				$data[ $key ] = esc_url_raw( $data[ $key ] );
				$remove_field = false;
			}

			if( in_array( $key, $html_fields ) ) {
				$data[ $key ] = $data[ $key ];
				$remove_field = false;
			}

			if( $remove_field ) { unset( $data[ $key ] ); }
		}

		return $data;
	}

	function tmk_esc_options( $key, $content ) {
		$options = [
			'borderStyle' => [
				'solid',
				'dotted',
				'dashed',
				'double',
				'hidden'
			],
			'borderStyleHover' => [
				'solid',
				'dotted',
				'dashed',
				'double',
				'hidden'
			],
			'tmk-status' => [
				'tmk-status-off',
				'tmk-status-woo',
				'tmk-status-fixed',
				'tmk-status-custom'
			],
			'tmk-woocommerce-position' => [
				'woocommerce_before_add_to_cart_form',
				'woocommerce_before_add_to_cart_button',
				'woocommerce_after_add_to_cart_button',
				'woocommerce_after_add_to_cart_form'
			]
		];

		if( in_array( $content, $options[ $key ] ) ) {
			return $content;
		}

		return $options[ $key ][0];
	}

	function tmk_esc_boolean( $content ) {
		if( $content === true || $content === "true" ) { return true; }

		return false;
	}

	function tmk_esc_number( $content, $default ) {
		if( is_numeric( $content ) ) { return $content; }

		return $default;
	}

	function tmk_status() {
		$tmk_status = get_option( 'tmk-status', 'tmk-status-off' );

		if( ! tmk_is_woo() && $tmk_status == 'tmk-status-woo' ) return 'tmk-status-custom';

		return $tmk_status;
	}

	function tmk_check_status( $default_status, $status_to_check, $echo = false ) {
		if( $default_status == $status_to_check ) {
			if( $echo ) {  echo 'checked'; } 
			else { return true; }
		}

		if( $echo ) {  echo ''; } 
		else { return false; }
	}