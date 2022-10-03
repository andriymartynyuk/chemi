<?php
/**
 * Customizer Separator Control settings for this theme.
 *
 * @package indro
 * @since 1.0.0
 */

if ( class_exists( 'WP_Customize_Control' ) ) :

	if ( ! class_exists( 'indro_customizer_Custom_Control' ) ) :

		class indro_customizer_Custom_Control extends WP_Customize_Control {
            
            public function __construct()
            {
                // Register our sections
                add_action('customize_register', array($this, 'indro_add_customizer_sections'));
            }

            //==================== Preloader  ===========================

            public function indro_add_customizer_sections($wp_customize) {
                    // Move customizer default settings
                $wp_customize->add_section('title_tagline', array(
                    'title'    => esc_html__('Logo', 'indro'),
                    'priority' => 20,
                   
                ));

                $wp_customize->add_section('preloader_section', array(
                    'title'    => esc_html__('Preloader', 'indro'),
                    'priority' => 40,
                  
                ));

                $wp_customize->add_section('indro_colors', array(
                    'title'    => esc_html__('Colors', 'indro'),
                    'priority' => 50,
                   
                ));
            
                $wp_customize->add_section('indro_header_section', array(
                    'title'    => esc_html__('Header Template', 'indro'),
                    'priority' => 60,
                   
                ));

                $wp_customize->add_section('indro_footer_section', array(
                    'title'    => esc_html__('Footer Template', 'indro'),
                    'priority' => 70,
                    
                ));
                
                $wp_customize->add_section('indro_layout_section', array(
                    'title'    => esc_html__('Layout', 'indro'),
                    'priority' => 80,
                    
                ));

                $wp_customize->add_section('indro_language_section', array(
                    'title'    => esc_html__('Language', 'indro'),
                    'priority' => 110,
                    
                ));

                if (file_exists(get_template_directory() . '/inc/class/customizer-settings/preloader-setting.php')) {
                    require_once get_template_directory() . '/inc/class/customizer-settings/preloader-setting.php';
                }

                if (file_exists(get_template_directory() . '/inc/class/customizer-settings/header-setting.php')) {
                    require_once get_template_directory() . '/inc/class/customizer-settings/header-setting.php';
                }

                if (file_exists(get_template_directory() . '/inc/class/customizer-settings/footer-setting.php')) {
                    require_once get_template_directory() . '/inc/class/customizer-settings/footer-setting.php';
                }

                if (file_exists(get_template_directory() . '/inc/class/customizer-settings/layout-setting.php')) {
                    require_once get_template_directory() . '/inc/class/customizer-settings/layout-setting.php';
                }

                // if (file_exists(get_template_directory() . '/inc/class/customizer-settings/color-setting.php')) {
                //     require_once get_template_directory() . '/inc/class/customizer-settings/color-setting.php';
                // }

                if (file_exists(get_template_directory() . '/inc/class/customizer-settings/language-setting.php')) {
                    require_once get_template_directory() . '/inc/class/customizer-settings/language-setting.php';
                }

                // if (file_exists(get_template_directory() . '/inc/class/customizer-settings/class-control-color-palette.php')) {
                //     require_once get_template_directory() . '/inc/class/customizer-settings/class-control-color-palette.php';
                // }

            }
        }
    endif;



/**
* Initialise our Customizer settings
*/
$indro_customizer_settings = new indro_customizer_Custom_Control();
endif;

