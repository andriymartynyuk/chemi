<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package indro
 */

?>

<footer id="colophon" class="site-footer">
	<?php

	if(get_theme_mod( 'footer') == null){
		// "No settings in customizer";
		$templates = Elementor\Plugin::$instance->templates_manager->get_source( 'local' )->get_items();

		$has_default_footer = false;
		$default_footer_id = null;
		foreach ( $templates as $template ) {
			$options[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
			if($template['title'] == "footer"){
				$has_default_footer = true;
				$default_footer_id = $template['template_id'] ;
			}
		}

		if ( $has_default_footer == true ) {

			echo Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $default_footer_id );

		}else{
			?>
			<div class="waring-message">
				<div class="container">
					<div class="row">
						<?php
						echo '<div class="before-import-warning-footer"><p>No templates found for footer! Create a template from ' . ' <a class="before-import-library-footer" href="wp-admin/edit.php?post_type=elementor_library&tabs_group=library" target="_blank">Elementor library</a>. Then select from Customizer Footer sections</p></div>';
						?>
					</div>
				</div>
			</div>
			<?php
		}

	}else{

		// echo "Setting Found in customizer";
		echo Elementor\Plugin::$instance->frontend->get_builder_content_for_display( get_theme_mod( 'footer') );

	}	
		
?>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
