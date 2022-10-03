<?php
/**
 * Return selected homepage sidebar name.
 *
 * @package indro
 * @since 1.0.0
 * 
 */
// namespace indro;
use function indro\indro;

if ( ! function_exists( 'indro_get_sidebar' ) ) :
	function indro_get_sidebar(){
	    $sidebar = get_theme_mod( 'indro_sidebar_position', 'sidebar_right' );
		$sidebar_is_set = isset( $sidebar ) ? $sidebar : '';
	    return $sidebar_is_set;
	}
endif;



//Convert Hex Color To RGBA
if ( ! function_exists( 'indro_hex2rgba_conversion' ) ) :
function indro_hex2rgba_conversion($color, $opacity = false)
{

  $default = 'rgb(0,0,0)';

  //Return default if no color provided
  if (empty($color))
    return $default; 

  //Sanitize $color if "#" is provided 
  if ($color[0] == '#') {
    $color = substr($color, 1);
  }

    //Check if color has 6 or 3 characters and get values
  if (strlen($color) == 6) {
    $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
  } elseif (strlen($color) == 3) {
    $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
  } else {
    return $default;
  }

        //Convert hexadec to rgb
  $rgb = array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
  if ($opacity) {
    if (abs($opacity) > 1)
      $opacity = 1.0;
    $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
  } else {
    $output = 'rgb(' . implode(",", $rgb) . ')';
  }

    //Return rgb(a) color string
  return $output;
}
endif;

//Add css from customizer input
if (!function_exists('indro_customizer_theme_setting')):
    function indro_customizer_theme_setting() { 

         //preloader
        $preloader_color = get_theme_mod('indro_preloader_background_color') == '' ? "#f8f8f8" : get_theme_mod('indro_preloader_background_color');
        $preloader_image_size = get_theme_mod('indro_slug_customizer_number') == '' ? "100" : get_theme_mod('indro_slug_customizer_number');

        //color
        //$primary_color         = get_theme_mod( 'indro_primary_color', '#1545CB' );
        //$secondary_color       = get_theme_mod( 'indro_secondary_color', '#FE79A2' );

        //Gradient Color
        $gradient_first_color               =   get_theme_mod( 'indro_gradient_first_color', '#A253D8' );
        $gradient_first_color_location      =   get_theme_mod( 'indro_first_color_location', '0' );
        $gradient_second_color              =   get_theme_mod( 'indro_gradient_second_color', '#1545CB' );
        $gradient_second_color_location     =   get_theme_mod( 'indro_second_color_location', '100' );
        $gradient_color_angle               =   get_theme_mod( 'indro_angle_color', '180' );
        $gradient_color_opacity             =   get_theme_mod( 'indro_g_opacity_color', '1' );

        $elementor_style_overwrite          =  get_theme_mod( 'elementor_style_overwrite', '0' );

        //site width
        $site_width                 = get_theme_mod( 'indro_site_width', '1140' );
        

        $custom = '';
        
        $custom .= ' 
        
        .bdt-mini-cart-wrapper .bdt-mini-cart-button-icon .bdt-cart-icon i {
            color: var(--global-palette2) !important;
        }
        @media (min-width: 1200px) {
                .container,
                .indro-container,
                .elementor-section.elementor-section-boxed:not(.menu__section) > .elementor-container {
                    max-width: '. esc_attr( $site_width) .'px !important;
                }
        }';

        $custom .= '
        .smooth-loader-wrapper .loader img{
            width:' .esc_attr ($preloader_image_size). '%;
        }
        .smooth-loader-wrapper {
            background-color: ' . esc_attr ($preloader_color) .';
        } 
        .page-header.error-404-main,
        .indro-banner-breadcrumb::before {
            background-image: linear-gradient(' . esc_attr( $gradient_color_angle ) .'deg, ' . esc_attr( 'var(--global-palette1)' ) .' '. esc_attr( $gradient_first_color_location ) .'%, '. esc_attr( 'var(--global-palette2)' ) .' '.esc_attr( $gradient_second_color_location ) .'% ) !important;
            background-image: -webkit-linear-gradient(' . esc_attr( $gradient_color_angle ) .'deg, ' . esc_attr( $gradient_first_color ) .' '. esc_attr( $gradient_first_color_location ) .'%, '. esc_attr( $gradient_second_color ) .' '.esc_attr( $gradient_second_color_location ) .'% );
        }
        ';
        
    wp_add_inline_style( 'indro-style', $custom );
}
add_action( 'wp_enqueue_scripts', 'indro_customizer_theme_setting' );
endif;

add_action('admin_head', 'indro_admin_css');

if (!function_exists('indro_admin_css')):

    function indro_admin_css() {

        echo '<style>
            #element-pack-notice-id-license-issue {
                display: none !important;
            }
      </style>';

    }
endif;