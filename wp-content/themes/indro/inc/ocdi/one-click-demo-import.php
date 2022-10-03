<?php


function ocdi_import_files()
{
  return array(
    array(
      'import_file_name' => 'indro Import',
      'import_file_url' => 'http://indro.iamabdus.com/v1.0/ocdi/indro-theme.xml',
      'import_widget_file_url' => 'http://indro.iamabdus.com/v1.0/ocdi/indro-widgets.wie',
      'import_customizer_file_url' => 'http://indro.iamabdus.com/v1.0/ocdi/indro-export.dat',
      'import_preview_image_url'   => 'http://indro.iamabdus.com/v1.0/ocdi/preview.png',
      'preview_url' => 'http://indro.iamabdus.com/v1.0/',
      'import_notice'              => __( 'After you import this demo, you will have to setup Customizer.', 'indro' ),
		),
  );
}
add_filter('ocdi/import_files', 'ocdi_import_files');


function ocdi_after_import_setup() {
  // Assign menus to their locations.
  $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
  $footer_menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );

  set_theme_mod( 'nav_menu_locations', [
          'main-1' => $main_menu->term_id,
          'menu-2' => $footer_menu->term_id,
      ]
  );

  // Assign front page and posts page (blog page).
  $front_page_id = get_page_by_title( 'Home' );
  $blog_page_id  = get_page_by_title( 'Blog Grid Without Sidebar' );

  update_option( 'show_on_front', 'page' );
  update_option( 'page_on_front', $front_page_id->ID );
  update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'ocdi/after_import', 'ocdi_after_import_setup' );


/**
 * After import run elementor stuff.
 */
function indro_elementor_after_import( $selected_palette ) {
  // If elementor make sure we set things up and clear cache.
    if ( class_exists( 'Elementor\Plugin' ) ) {
      if ( class_exists( 'indro\Theme' ) ) {
        $component = \indro\Theme::instance()->components['elementor'];
        if ( $component ) {
          $component->elementor_add_theme_colors();
        }
      }
      
      \Elementor\Plugin::instance()->files_manager->clear_cache();
    }
  }
  add_action( 'ocdi/after_import', 'indro_elementor_after_import' ); 
