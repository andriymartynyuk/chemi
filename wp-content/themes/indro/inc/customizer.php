<?php
/**
 * indro Theme Customizer
 *
 * @package indro
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function indro_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'indro_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'indro_customize_partial_blogdescription',
			)
		);
	}

	//==================== All Controls ===========================
	if (file_exists(get_template_directory() . '/inc/class/customizer-controls/switch-control.php')) {
		require_once get_template_directory() . '/inc/class/customizer-controls/switch-control.php';
	}
	
	if (file_exists(get_template_directory() . '/inc/class/customizer-controls/range-custom-control.php')) {
		require_once get_template_directory() . '/inc/class/customizer-controls/range-custom-control.php';
	}
	
	if (file_exists(get_template_directory() . '/inc/class/customizer-controls/radio-image-control.php')) {
		require_once get_template_directory() . '/inc/class/customizer-controls/radio-image-control.php';
	}
	
	// if (file_exists(get_template_directory() . '/inc/class/customizer-controls/class-control-color-palette.php')) {
	// 	require_once get_template_directory() . '/inc/class/customizer-controls/class-control-color-palette.php';
	// }
	//==================== All Sanitization ===========================

		/**
		 * Slider sanitization
		 *
		 * @param  string	Slider value to be sanitized
		 * @return string	Sanitized input
		 */
		if ( ! function_exists( 'indro_range_sanitization' ) ) {
			function indro_range_sanitization( $input, $setting ) {
				$attrs = $setting->manager->get_control( $setting->id )->input_attrs;

				$min = ( isset( $attrs['min'] ) ? $attrs['min'] : $input );
				$max = ( isset( $attrs['max'] ) ? $attrs['max'] : $input );
				$step = ( isset( $attrs['step'] ) ? $attrs['step'] : 1 );

				$number = floor( $input / $attrs['step'] ) * $attrs['step'];

				return indro_in_range( $number, $min, $max );
			}
		}

		// sanitization and validation for Header & Footer
		function indro_theme_sanitize_select( $input, $setting ) {

			// Ensure input is a slug.
			$input = sanitize_key( $input );
	
			// Get list of choices from the control associated with the setting.
			$choices = $setting->manager->get_control( $setting->id )->choices;
	
			// If the input is a valid key, return it; otherwise, return the default.
			return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
			}

			if ( ! function_exists( 'indro_sanitize_checkbox' ) ) :

				/**
				 * Sanitize checkbox.
				 *
				 * @since 1.0.0
				 *
				 * @param bool $checked Whether the checkbox is checked.
				 * @return bool Whether the checkbox is checked.
				 */
				function indro_sanitize_checkbox( $checked ) {
			
					return ( ( isset( $checked ) && true === $checked ) ? true : false );
			
				}
			
			endif;

			if ( ! function_exists( 'indro_sanitize_image' ) ) :

				/**
				 * Sanitize image.
				 *
				 * @since 1.0.0
				 *
				 * @see wp_check_filetype() https://developer.wordpress.org/reference/functions/wp_check_filetype/
				 *
				 * @param string               $image Image filename.
				 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
				 * @return string The image filename if the extension is allowed; otherwise, the setting default.
				 */
				function indro_sanitize_image( $image, $setting ) {
			
					/**
					 * Array of valid image file types.
					 *
					 * The array includes image mime types that are included in wp_get_mime_types().
					 */
					$img_type = array(
						'jpg|jpeg|jpe' => 'image/jpeg',
						'gif'          => 'image/gif',
						'png'          => 'image/png',
						'bmp'          => 'image/bmp',
						'tif|tiff'     => 'image/tiff',
						'ico'          => 'image/x-icon',
					);
			
					// Return an array with file extension and mime_type.
					$file = wp_check_filetype( $image, $img_type );
			
					// If $image has a valid mime_type, return it; otherwise, return the default.
					return ( $file['ext'] ? $image : $setting->default );
			
				}
			
			endif;

	// sanitization and validation for Header & Footer
	function indro_sanitize_radio_btn( $input, $setting ) {

		// Ensure input is a slug.
		$input = sanitize_key( $input );

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}

	/**
	 * Switch sanitization
	 *
	 * @param  string		Switch value
	 * @return integer	Sanitized value
	 */
	if ( ! function_exists( 'indro_switch_sanitization' ) ) {
		function indro_switch_sanitization( $input ) {
			if ( true === $input ) {
				return 1;
			} else {
				return 0;
			}
		}
	}

	/**
	 * Sanitize URL.
	**/
	if ( ! function_exists( 'sanitize_url' ) ) {
		function sanitize_url( $url ) {
			return esc_url_raw( $url );
		}
	}


}
add_action( 'customize_register', 'indro_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function indro_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function indro_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function indro_customize_preview_js() {
	wp_enqueue_script( 'indro-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'indro_customize_preview_js' );
