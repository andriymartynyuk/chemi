<?php
/**
 * The `indro()` function.
 *
 * @package indro
 */

namespace indro;

use indro\Template_Tags;
use indro\Theme;
use function get_template_directory;

/**
 * Provides access to all available template tags of the theme.
 *
 * When called for the first time, the function will initialize the theme.
 *
 * @return Template_Tags Template tags instance exposing template tag methods.
 */
function indro() : Template_Tags {
	static $theme = null;

	if ( null === $theme ) {
		$theme = Theme::instance();
	}

	return $theme->template_tags();
}

// Load the CSS class.
 require get_template_directory() . '/inc/class-taf-css.php';

// Load the Customizer class.
require get_template_directory() . '/inc/customizer/class-theme-customizer.php';


