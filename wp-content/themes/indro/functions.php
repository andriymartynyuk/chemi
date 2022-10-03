<?php
/**
 * indro functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package indro
 */

define("DEV_MODE", true);

if ( "DEV_MODE"){
	define("VERSION", time() );
}else{

	define("VERSION", wp_get_theme() -> get('version'));
}

if ( ! function_exists( 'indro_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function indro_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on indro, use a find and replace
		 * to change 'indro' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'indro', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'grid-size', 350, 223, true );
		add_image_size( 'standard-size', 1200, 484, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'indro' ),
			)
		);
		
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'indro_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'indro_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function indro_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'indro_content_width', 640 );
}
add_action( 'after_setup_theme', 'indro_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function indro_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'indro' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'indro' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'indro_widgets_init' );


function indro_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'indro_excerpt_length', 999 );

/**
 * Change the excerpt more string
*/
function indro_theme_excerpt_more( $more ) {
	return ' &hellip;';
}
add_filter( 'excerpt_more', 'indro_theme_excerpt_more' );

/**
 * ADD Custom Search Form.
*/
function indro_widget_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="search-form" action="' . home_url( '/' ) . '" ><label class="screen-reader-text" for="s">' . __( 'Search for:', 'indro' ) . '</label>
    <input class="search-field" type="search" value="' . get_search_query() . '" name="s" id="s" placeholder="search"/>
    <button type="submit" class="search-submit" ><i class="fa fa-search"></i></button>
    </form>';

    return $form;
}
add_filter( 'get_search_form', 'indro_widget_search_form', 100 );


add_filter( 'widget_text', 'do_shortcode' );

/**
 * Enqueue scripts and styles.
 */
function indro_scripts() {
	wp_enqueue_style( 'indro-style', get_stylesheet_uri(), array(), VERSION );
	wp_style_add_data( 'indro-style', 'rtl', 'replace' );
	wp_enqueue_style( 'indro-google-font','https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Mukta+Malar:wght@400;500;700;800&display=swap');
	wp_enqueue_style( 'indro-font-awesome', get_template_directory_uri() . '/assets/vendor/font-awesome/css/fontawesome.min.css');
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/assets/vendor/css/bootstrap.min.css');
	wp_enqueue_style( 'indro-post-style', get_template_directory_uri() . '/assets/css/post-style.css', array(), VERSION , 'all');
	wp_enqueue_style( 'indro-default-style', get_template_directory_uri() . '/assets/css/theme-default.css', array(), VERSION , 'all');


	wp_enqueue_script( 'indro-navigation', get_template_directory_uri() . '/js/navigation.js', array(), VERSION, true );
	wp_enqueue_script( 'page-scroll', get_template_directory_uri() . '/assets/vendor/page-scroll/page-scroll.js', array(), '1.0.0',true );
	wp_enqueue_script( 'indro-default-style', get_template_directory_uri() . '/assets/js/theme-default.js', array(), VERSION, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'indro_scripts' );

/**
 * Enqueue classic editor styles.
 */
function indro_classic_editor_styles() {

	$classic_editor_styles = array(
		'/assets/editor-style/editor-style-classic.css',
	);

	add_editor_style( $classic_editor_styles );

}

add_action( 'init', 'indro_classic_editor_styles' );

/**
 * Register/Enqueue JS/CSS In Admin Panel
 */
function indro_register_admin_styles(){
	wp_enqueue_style( 'indro-customizer', get_template_directory_uri() . '/assets/css/customizer.css', '', '1.0.0' );

	//wp_enqueue_script( 'indro-custom-controls-js', get_template_directory_uri()  . '/assets/js/indro-customizer.js', array( 'jquery', 'wp-color-picker' ), '1.0', true );
}
add_action('admin_enqueue_scripts', 'indro_register_admin_styles');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

if (file_exists(get_template_directory() . '/inc/class/customizer-functions.php')) {
	require get_template_directory() . '/inc/class/customizer-functions.php';
}

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load breadcrumbs file.
 */
if (file_exists(get_template_directory() . '/inc/breadcrumb.php')) {
	require get_parent_theme_file_path( '/inc/breadcrumb.php' );
}
/**
* Helpers.
*/
if (file_exists(get_template_directory() . '/inc/helpers.php')) {
	require get_parent_theme_file_path( '/inc/helpers.php' );
}

//TMG Plugin for plugin activation
if (file_exists(get_template_directory() . '/inc/tgmpa/plugins-activator.php')) {
	require_once get_parent_theme_file_path() . '/inc/tgmpa/plugins-activator.php';
}

/**
* Import demo with one click demo import.
*/

if (file_exists(get_template_directory() . '/inc/ocdi/one-click-demo-import.php')) {
	require get_parent_theme_file_path() . '/inc/ocdi/one-click-demo-import.php';
}

// Load the `indro()` entry point function.
require get_template_directory() . '/inc/class-theme.php';

// Load the `indro()` entry point function.
require get_template_directory() . '/inc/functions.php';

// Initialize the theme.
call_user_func( 'indro\indro' );


/**
* Prevent update notification.
*/

function disable_plugin_updates( $value ) {
  if ( isset($value) && is_object($value) ) {
    if ( isset( $value->response['bdthemes-element-pack/bdthemes-element-pack.php'] ) ) {
      unset( $value->response['bdthemes-element-pack/bdthemes-element-pack.php'] );
    }
  }
  return $value;
}
add_filter( 'site_transient_update_plugins', 'disable_plugin_updates' );

/**
 * jQuery Loading Priority
**/

function load_scripts() {							
	wp_enqueue_script('jquery');
	// ... other scripts
}    
add_action('wp_enqueue_scripts', 'load_scripts', 1);
add_filter('site_transient_update_plugins', '__return_false');
