<?php
/**
 * The Switch customize control extends the WP_Customize_Control class.
 *
 * @package customizer-controls
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}


/**
 * Class indro_Control_Switch
 *
 * @access public
 */
class indro_Control_Title extends WP_Customize_Control {
	/**
	 * Control type
	 *
	 * @var string
	 */
	public $type = 'indro_title_control';

	/**
	 * Send to JS.
	 */
	public function to_json() {
		parent::to_json();
	}
	/**
	 * Empty Render Function to prevent errors.
	 */
	public function render_content() {
	}
}
$wp_customize->register_control_type( 'indro_Control_Title' );
