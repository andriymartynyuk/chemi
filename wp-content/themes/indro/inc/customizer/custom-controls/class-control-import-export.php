<?php
/**
 * The Radio Icon customize control extends the WP_Customize_Control class.
 *
 * @package customizer-controls
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}


/**
 * Class indro_Control_Import_Export
 *
 * @access public
 */
class indro_Control_Import_Export extends WP_Customize_Control {
	/**
	 * Control type
	 *
	 * @var string
	 */
	public $type = 'indro_import_export_control';
	/**
	 * Empty Render Function to prevent errors.
	 */
	public function render_content() {
		?>
			<span class="customize-control-title">
				<?php esc_html_e( 'Export', 'indro' ); ?>
			</span>
			<span class="description customize-control-description">
				<?php esc_html_e( 'Click the button below to export the customization settings for this theme.', 'indro' ); ?>
			</span>
			<input type="button" class="button indro-theme-export indro-theme-button" name="indro-theme-export-button" value="<?php esc_attr_e( 'Export', 'indro' ); ?>" />

			<hr class="kt-theme-hr" />

			<span class="customize-control-title">
				<?php esc_html_e( 'Import', 'indro' ); ?>
			</span>
			<span class="description customize-control-description">
				<?php esc_html_e( 'Upload a file to import customization settings for this theme.', 'indro' ); ?>
			</span>
			<div class="indro-theme-import-controls">
				<input type="file" name="indro-theme-import-file" class="indro-theme-import-file" />
				<?php wp_nonce_field( 'indro-theme-importing', 'indro-theme-import' ); ?>
			</div>
			<div class="indro-theme-uploading"><?php esc_html_e( 'Uploading...', 'indro' ); ?></div>
			<input type="button" class="button indro-theme-import indro-theme-button" name="indro-theme-import-button" value="<?php esc_attr_e( 'Import', 'indro' ); ?>" />

			<hr class="kt-theme-hr" />
			<span class="customize-control-title">
				<?php esc_html_e( 'Reset', 'indro' ); ?>
			</span>
			<span class="description customize-control-description">
				<?php esc_html_e( 'Click the button to reset all theme settings.', 'indro' ); ?>
			</span>
			<input type="button" class="components-button is-destructive indro-theme-reset indro-theme-button" name="indro-theme-reset-button" value="<?php esc_attr_e( 'Reset', 'indro' ); ?>" />
			<?php
	}
}