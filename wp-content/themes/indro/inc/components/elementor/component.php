<?php
/**
 * indro\Elementor\Component class
 *
 * @package indro
 */

namespace indro\Elementor;

use indro\Component_Interface;
use Elementor;
use function indro\indro;
use function add_action;
use function add_theme_support;
use function have_posts;
use function the_post;
use function apply_filters;
use function get_template_part;
use function get_post_type;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Controls\Repeater as Global_Style_Repeater;
use Elementor\Repeater;
use Elementor\Plugin;


/**
 * Class for adding Elementor plugin support.
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'elementor';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		// Add support for Header and Footer Plugin.
		add_action( 'after_setup_theme', array( $this, 'init_header_footer_support' ), 30 );
		add_filter( 'body_class', array( $this, 'add_body_class' ) );
		//add_action( 'init', array( $this, 'elementor_add_theme_colors' ), 1 );
		add_action( 'elementor/editor/init', array( $this, 'elementor_add_theme_colors' ) );
		//add_action( 'elementor/element/kit/section_global_colors/before_section_start', array( $this, 'elementor_remove_theme_colors' ) );
		add_action( 'elementor/element/kit/section_global_colors/after_section_end', array( $this, 'elementor_add_theme_color_controls' ), 10, 2 );
		// Set page to best pagebuilder settings when first loading.
		add_action( 'wp', array( $this, 'elementor_page_meta_setting' ), 20 );
		add_action( 'elementor/preview/init', array( $this, 'elementor_page_meta_setting' ) );
		// Add Scripts for elementor.
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'elementor_add_scripts' ) );
		//add_action( 'wp_enqueue_scripts', array( $this, 'add_styles' ), 60 );
		add_action( 'elementor/document/before_save', array( $this, 'elementor_before_save' ), 10, 2 );
		add_action( 'elementor/document/after_save', array( $this, 'elementor_after_save' ), 10, 2 );
		add_filter( 'body_class', array( $this, 'filter_body_classes_add_editing_class' ) );
	}
	/**
	 * Adds a link style class to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array Filtered body classes.
	 */
	public function add_body_class( $classes ) {
		$classes[] = 'indro-elementor-colors';

		return $classes;
	}
	/**
	 * Adds a 'el-is-editing' class to the array of body classes for when we are in elementor editing.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array Filtered body classes.
	 */
	public function filter_body_classes_add_editing_class( array $classes ) : array {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			$classes[] = 'el-is-editing';
		}

		return $classes;
	}
	public function elementor_before_save( $object, $data ) {
		//error_log( print_r( $data, true ) );
	}
	public function elementor_after_save( $object, $data ) {
		//error_log( print_r( $data, true ) );
		if ( apply_filters( 'indro_add_global_colors_to_elementor', true ) ) {
			if ( $data && isset( $data['settings'] ) && is_array( $data['settings'] ) && isset( $data['settings']['indro_colors'] ) && is_array( $data['settings']['indro_colors'] ) ) {
				$update_palette = false;
				$palette = json_decode( indro()->get_palette(), true );
				if ( isset( $palette['active'] ) && ! empty( $palette['active'] ) ) {
					$active = $palette['active'];
				} else {
					$palette = json_decode( indro()->get_default_palette(), true );
					$active  = $palette['active'];
				}
				foreach ( $data['settings']['indro_colors'] as $key => $value ) {
					if ( 'palette1' == $value['_id'] && ! empty( $value['color'] ) ) {
						$palette[$active][0]['color'] = $value['color'];
						$update_palette = true;
					}
					if ( 'palette2' == $value['_id'] && ! empty( $value['color'] ) ) {
						$palette[$active][1]['color'] = $value['color'];
						$update_palette = true;
					}
					if ( 'palette3' == $value['_id'] && ! empty( $value['color'] ) ) {
						$palette[$active][2]['color'] = $value['color'];
						$update_palette = true;
					}
					if ( 'palette4' == $value['_id'] && ! empty( $value['color'] ) ) {
						$palette[$active][3]['color'] = $value['color'];
						$update_palette = true;
					}
					if ( 'palette5' == $value['_id'] && ! empty( $value['color'] ) ) {
						$palette[$active][4]['color'] = $value['color'];
						$update_palette = true;
					}
					if ( 'palette6' == $value['_id'] && ! empty( $value['color'] ) ) {
						$palette[$active][5]['color'] = $value['color'];
						$update_palette = true;
					}
					if ( 'palette7' == $value['_id'] && ! empty( $value['color'] ) ) {
						$palette[$active][6]['color'] = $value['color'];
						$update_palette = true;
					}
					if ( 'palette8' == $value['_id'] && ! empty( $value['color'] ) ) {
						$palette[$active][7]['color'] = $value['color'];
						$update_palette = true;
					}
					if ( 'palette9' == $value['_id'] && ! empty( $value['color'] ) ) {
						$palette[$active][8]['color'] = $value['color'];
						$update_palette = true;
					}
				}
				// if ( isset( $data['settings']['custom_colors'] ) && is_array( $data['settings']['custom_colors'] ) ) {
				// 	foreach ( $data['settings']['custom_colors'] as $key => $value ) {
				// 		if ( 'indro1' == $value['_id'] ) {
				// 			$data['settings']['custom_colors'][$key]['color'] = $palette[$active][0]['color'];
				// 		}
				// 		if ( 'indro2' == $value['_id'] ) {
				// 			$data['settings']['custom_colors'][$key]['color'] = $palette[$active][1]['color'];
				// 		}
				// 		if ( 'indro3' == $value['_id'] ) {
				// 			$data['settings']['custom_colors'][$key]['color'] = $palette[$active][2]['color'];
				// 		}
				// 		if ( 'indro4' == $value['_id'] ) {
				// 			$data['settings']['custom_colors'][$key]['color'] = $palette[$active][3]['color'];
				// 		}
				// 		if ( 'indro5' == $value['_id'] ) {
				// 			$data['settings']['custom_colors'][$key]['color'] = $palette[$active][4]['color'];
				// 		}
				// 		if ( 'indro6' == $value['_id'] ) {
				// 			$data['settings']['custom_colors'][$key]['color'] = $palette[$active][5]['color'];
				// 		}
				// 		if ( 'indro7' == $value['_id'] ) {
				// 			$data['settings']['custom_colors'][$key]['color'] = $palette[$active][6]['color'];
				// 		}
				// 		if ( 'indro8' == $value['_id'] ) {
				// 			$data['settings']['custom_colors'][$key]['color'] = $palette[$active][7]['color'];
				// 		}
				// 		if ( 'indro9' == $value['_id'] ) {
				// 			$data['settings']['custom_colors'][$key]['color'] = $palette[$active][8]['color'];
				// 		}
				// 	}
				// }
				$current = \Elementor\Plugin::$instance->kits_manager->get_current_settings();
				//error_log( print_r( $current, true ) );
				if ( $current && isset( $current['custom_colors'] ) && $update_palette ) {
					$custom_colors = $current['custom_colors'];
					$indro_add = true;
					$indro = array( 'indro1', 'indro2', 'indro3', 'indro4', 'indro5', 'indro6', 'indro7', 'indro8', 'indro9' );
					foreach ( $custom_colors as $key => $value ) {
						if ( is_array( $value ) && isset( $value['_id'] ) && in_array( $value['_id'], $indro ) ) {
							$indro_add = false;
							if ( $value['_id'] == 'indro1' ) {
								$custom_colors[ $key ]['color'] = $palette[$active][0]['color'];
							}
							if ( $value['_id'] == 'indro2' ) {
								$custom_colors[ $key ]['color'] = $palette[$active][1]['color'];
							}
							if ( $value['_id'] == 'indro3' ) {
								$custom_colors[ $key ]['color'] = $palette[$active][2]['color'];
							}
							if ( $value['_id'] == 'indro4' ) {
								$custom_colors[ $key ]['color'] = $palette[$active][3]['color'];
							}
							if ( $value['_id'] == 'indro5' ) {
								$custom_colors[ $key ]['color'] = $palette[$active][4]['color'];
							}
							if ( $value['_id'] == 'indro6' ) {
								$custom_colors[ $key ]['color'] = $palette[$active][5]['color'];
							}
							if ( $value['_id'] == 'indro7' ) {
								$custom_colors[ $key ]['color'] = $palette[$active][6]['color'];
							}
							if ( $value['_id'] == 'indro8' ) {
								$custom_colors[ $key ]['color'] = $palette[$active][7]['color'];
							}
							if ( $value['_id'] == 'indro9' ) {
								$custom_colors[ $key ]['color'] = $palette[$active][8]['color'];
							}
						}
					}
					if ( $indro_add ) {
						$custom_colors = array_merge( $theme_colors, $custom_colors );
					}
					//error_log( 'update?' );
					//error_log( print_r( $custom_colors, true ) );
					\Elementor\Plugin::$instance->kits_manager->update_kit_settings_based_on_option( 'custom_colors', $custom_colors );
					// Refresh cache.
					//\Elementor\Plugin::instance()->files_manager->clear_cache();
					//\Elementor\Plugin::$instance->documents->get( Plugin::$instance->kits_manager->get_active_id(), false );
				}
				if ( $update_palette ) {
					// error_log( 'update?' );
					// error_log( print_r( $palette, true ) );
					update_option( 'indro_global_palette', json_encode( $palette ) );
				}
			}
		}
	}
	/**
	 * Add some css styles for elementor.
	 */
	public function add_styles() {
		wp_enqueue_style( 'indro-elementor', get_theme_file_uri( '/assets/css/elementor.min.css' ), array(), VERSION);
	}
	/**
	 * Add some css styles for elementor admin.
	 */
	public function elementor_add_scripts() {
		if ( apply_filters( 'indro_add_global_colors_to_elementor', true ) ) {
			wp_enqueue_style( 'indro-elementor-admin', get_theme_file_uri( '/assets/css/elementor-admin.min.css' ), array(), VERSION);
		}
	}
	/**
	 * Add some css styles for Restrict Content Pro
	 */
	public function elementor_add_theme_colors() {
		if ( apply_filters( 'indro_add_global_colors_to_elementor', true ) ) {
			$theme_colors = array(
				array(
					'_id' => 'indro1',
					'title'  => __( 'Theme Accent', 'indro' ),
					'color' => indro()->palette_option( 'palette1' ),
				),
				array(
					'_id' => 'indro2',
					'title'  => __( 'Theme Accent - alt', 'indro' ),
					'color' => indro()->palette_option( 'palette2' ),
				),
				array(
					'_id' => 'indro3',
					'title'  => __( 'Strongest text', 'indro' ),
					'color' => indro()->palette_option( 'palette3' ),
				),
				array(
					'_id' => 'indro4',
					'title'  => __( 'Strong Text', 'indro' ),
					'color' => indro()->palette_option( 'palette4' ),
				),
				array(
					'_id' => 'indro5',
					'title'  => __( 'Medium text', 'indro' ),
					'color' => indro()->palette_option( 'palette5' ),
				),
				array(
					'_id' => 'indro6',
					'title'  => __( 'Subtle Text', 'indro' ),
					'color' => indro()->palette_option( 'palette6' ),
				),
				array(
					'_id' => 'indro7',
					'title'  => __( 'Subtle Background', 'indro' ),
					'color' => indro()->palette_option( 'palette7' ),
				),
				array(
					'_id' => 'indro8',
					'title'  => __( 'Lighter Background', 'indro' ),
					'color' => indro()->palette_option( 'palette8' ),
				),
				array(
					'_id' => 'indro9',
					'title'  => __( 'White or offwhite', 'indro' ),
					'color' => indro()->palette_option( 'palette9' ),
				),
			);
			$theme_placeholder_colors = array(
				array(
					'_id' => 'palette1',
					'title'  => __( 'Theme Accent', 'indro' ),
					'color' => indro()->palette_option( 'palette1' ),
				),
				array(
					'_id' => 'palette2',
					'title'  => __( 'Theme Accent - alt', 'indro' ),
					'color' => indro()->palette_option( 'palette2' ),
				),
				array(
					'_id' => 'palette3',
					'title'  => __( 'Strongest text', 'indro' ),
					'color' => indro()->palette_option( 'palette3' ),
				),
				array(
					'_id' => 'palette4',
					'title'  => __( 'Strong Text', 'indro' ),
					'color' => indro()->palette_option( 'palette4' ),
				),
				array(
					'_id' => 'palette5',
					'title'  => __( 'Medium text', 'indro' ),
					'color' => indro()->palette_option( 'palette5' ),
				),
				array(
					'_id' => 'palette6',
					'title'  => __( 'Subtle Text', 'indro' ),
					'color' => indro()->palette_option( 'palette6' ),
				),
				array(
					'_id' => 'palette7',
					'title'  => __( 'Subtle Background', 'indro' ),
					'color' => indro()->palette_option( 'palette7' ),
				),
				array(
					'_id' => 'palette8',
					'title'  => __( 'Lighter Background', 'indro' ),
					'color' => indro()->palette_option( 'palette8' ),
				),
				array(
					'_id' => 'palette9',
					'title'  => __( 'White or offwhite', 'indro' ),
					'color' => indro()->palette_option( 'palette9' ),
				),
			);
			// Prevent Errors.
			if ( ! method_exists( \Elementor\Plugin::$instance->kits_manager, 'get_current_settings' ) ) {
				return;
			}
			$current = \Elementor\Plugin::$instance->kits_manager->get_current_settings();
			if ( $current && isset( $current['custom_colors'] ) ) {
				$custom_colors = $current['custom_colors'];
				$indro_add_array = array(
					'indro1' => true,
					'indro2' => true,
					'indro3' => true,
					'indro4' => true,
					'indro5' => true,
					'indro6' => true,
					'indro7' => true,
					'indro8' => true,
					'indro9' => true,
				);
				$indro_add = true;
				$clear_cache = false;
				$indro = array( 'indro1', 'indro2', 'indro3', 'indro4', 'indro5', 'indro6', 'indro7', 'indro8', 'indro9' );
				foreach ( $custom_colors as $key => $value ) {
					if ( is_array( $value ) && isset( $value['_id'] ) && in_array( $value['_id'], $indro ) ) {
						$indro_add = false;
						if ( $value['_id'] == 'indro1' ) {
							if ( $custom_colors[ $key ]['color'] !== $theme_colors[0]['color'] ) {
								$clear_cache = true;
							}
							$indro_add_array['indro1'] = false;
							$custom_colors[ $key ] = $theme_colors[0];
						}
						if ( $value['_id'] == 'indro2' ) {
							if ( $custom_colors[ $key ]['color'] !== $theme_colors[1]['color'] ) {
								$clear_cache = true;
							}
							$indro_add_array['indro2'] = false;
							$custom_colors[ $key ] = $theme_colors[1];
						}
						if ( $value['_id'] == 'indro3' ) {
							if ( $custom_colors[ $key ]['color'] !== $theme_colors[2]['color'] ) {
								$clear_cache = true;
							}
							$indro_add_array['indro3'] = false;
							$custom_colors[ $key ] = $theme_colors[2];
						}
						if ( $value['_id'] == 'indro4' ) {
							if ( $custom_colors[ $key ]['color'] !== $theme_colors[3]['color'] ) {
								$clear_cache = true;
							}
							$indro_add_array['indro4'] = false;
							$custom_colors[ $key ] = $theme_colors[3];
						}
						if ( $value['_id'] == 'indro5' ) {
							if ( $custom_colors[ $key ]['color'] !== $theme_colors[4]['color'] ) {
								$clear_cache = true;
							}
							$indro_add_array['indro5'] = false;
							$custom_colors[ $key ] = $theme_colors[4];
						}
						if ( $value['_id'] == 'indro6' ) {
							if ( $custom_colors[ $key ]['color'] !== $theme_colors[5]['color'] ) {
								$clear_cache = true;
							}
							$indro_add_array['indro6'] = false;
							$custom_colors[ $key ] = $theme_colors[5];
						}
						if ( $value['_id'] == 'indro7' ) {
							if ( $custom_colors[ $key ]['color'] !== $theme_colors[6]['color'] ) {
								$clear_cache = true;
							}
							$indro_add_array['indro7'] = false;
							$custom_colors[ $key ] = $theme_colors[6];
						}
						if ( $value['_id'] == 'indro8' ) {
							if ( $custom_colors[ $key ]['color'] !== $theme_colors[7]['color'] ) {
								$clear_cache = true;
							}
							$indro_add_array['indro8'] = false;
							$custom_colors[ $key ] = $theme_colors[7];
						}
						if ( $value['_id'] == 'indro9' ) {
							if ( $custom_colors[ $key ]['color'] !== $theme_colors[8]['color'] ) {
								$clear_cache = true;
							}
							$indro_add_array['indro9'] = false;
							$custom_colors[ $key ] = $theme_colors[8];
						}
					}
				}
				if ( $indro_add ) {
					$custom_colors = array_merge( $theme_colors, $custom_colors );
				} else {
					$i       = 0;
					$new_add = array();
					foreach ( $indro_add_array as $key => $value ) {
						if ( $value ) {
							$new_add[] = $theme_colors[ $i ];
						}
						$i++;
					}
					// Somehow colors were removed so we need to add them back in.
					if ( ! empty( $new_add ) ) {
						$custom_colors = array_merge( $new_add, $custom_colors );
					}
				}
				\Elementor\Plugin::$instance->kits_manager->update_kit_settings_based_on_option( 'custom_colors', $custom_colors );
				\Elementor\Plugin::$instance->kits_manager->update_kit_settings_based_on_option( 'indro_colors', $theme_placeholder_colors );
				// Refresh cache.
				if ( $clear_cache ) {
					// If the palette was updated in the customizer then we need to clear all the css.
					\Elementor\Plugin::instance()->files_manager->clear_cache();
				}
			}
		}
	}
	/**
	 * Add in new Custom Controls for Theme Colors.
	 */
	public function elementor_add_theme_color_controls( $tab, $args ) {
		if ( apply_filters( 'indro_add_global_colors_to_elementor', true ) ) {
			$tab->start_controls_section(
				'section_theme_global_colors',
				array(
					'label' => __( 'Theme Global Colors', 'indro' ),
					'tab' => 'global-colors',
				)
			);

			$repeater = new Repeater();

			$repeater->add_control(
				'title',
				array(
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
					'required' => true,
				)
			);

			// Color Value
			$repeater->add_control(
				'color',
				array(
					'type' => Controls_Manager::COLOR,
					'label_block' => true,
					'dynamic' => [],
					'selectors' => array(
						'{{WRAPPER}}.el-is-editing' => '--global-{{_id.VALUE}}: {{VALUE}}',
					),
					'global' => array(
						'active' => false,
					),
				)
			);

			$theme_colors = array(
				array(
					'_id' => 'palette1',
					'title'  => __( 'Theme Accent', 'indro' ),
					'color' => indro()->palette_option( 'palette1' ),
				),
				array(
					'_id' => 'palette2',
					'title'  => __( 'Theme Accent - alt', 'indro' ),
					'color' => indro()->palette_option( 'palette2' ),
				),
				array(
					'_id' => 'palette3',
					'title'  => __( 'Strongest text', 'indro' ),
					'color' => indro()->palette_option( 'palette3' ),
				),
				array(
					'_id' => 'palette4',
					'title'  => __( 'Strong Text', 'indro' ),
					'color' => indro()->palette_option( 'palette4' ),
				),
				array(
					'_id' => 'palette5',
					'title'  => __( 'Medium text', 'indro' ),
					'color' => indro()->palette_option( 'palette5' ),
				),
				array(
					'_id' => 'palette6',
					'title'  => __( 'Subtle Text', 'indro' ),
					'color' => indro()->palette_option( 'palette6' ),
				),
				array(
					'_id' => 'palette7',
					'title'  => __( 'Subtle Background', 'indro' ),
					'color' => indro()->palette_option( 'palette7' ),
				),
				array(
					'_id' => 'palette8',
					'title'  => __( 'Lighter Background', 'indro' ),
					'color' => indro()->palette_option( 'palette8' ),
				),
				array(
					'_id' => 'palette9',
					'title'  => __( 'White or offwhite', 'indro' ),
					'color' => indro()->palette_option( 'palette9' ),
				),
			);

			$tab->add_control(
				'indro_colors',
				array(
					'type' => Global_Style_Repeater::CONTROL_TYPE,
					'fields' => $repeater->get_controls(),
					'default' => $theme_colors,
					'item_actions' => array(
						'add' => false,
						'remove' => false,
					),
				)
			);
			$tab->end_controls_section();
		}
	}
	/**
	 * Make sure it's not a post, then set the meta if the content is empty and we are in elementor.
	 */
	public function elementor_page_meta_setting() {
		if ( ! apply_filters( 'indro_theme_elementor_default', true ) || 'post' === get_post_type() ) {
			return;
		}
		if ( ! $this->is_elementor() ) {
			return;
		}
		global $post;
		$page_id = get_the_ID();

		$page_builder_layout = get_post_meta( $page_id, '_kad_pagebuilder_layout_flag', true );
		if ( isset( $post ) && empty( $page_builder_layout ) && ( is_admin() || is_singular() ) ) {
			if ( empty( $post->post_content ) && $this->is_built_with_elementor( $page_id ) ) {
				update_post_meta( $page_id, '_kad_pagebuilder_layout_flag', 'disabled' );
				update_post_meta( $page_id, '_kad_post_title', 'hide' );
				update_post_meta( $page_id, '_kad_post_content_style', 'unboxed' );
				update_post_meta( $page_id, '_kad_post_vertical_padding', 'hide' );
				update_post_meta( $page_id, '_kad_post_feature', 'hide' );
				$post_layout = get_post_meta( $page_id, '_kad_post_layout', true );
				if ( empty( $post_layout ) || 'default' === $post_layout ) {
					update_post_meta( $page_id, '_kad_post_layout', 'fullwidth' );
				}
				$post_title = get_post_meta( $page_id, '_kad_post_title', true );
				if ( empty( $post_title ) || 'default' === $post_title ) {
					update_post_meta( $page_id, '_kad_post_title', 'hide' );
				}
			}
		}
	}
	/**
	 * Check if page is built with elementor
	 *
	 * @return boolean true if elementor edit false if not.
	 */
	private function is_built_with_elementor( $page_id ) {
		return Elementor\Plugin::$instance->db->is_built_with_elementor( $page_id );
	}
	/**
	 * Check if in elementor editor.
	 *
	 * @return boolean true if elementor edit false if not.
	 */
	private function is_elementor() {
		if ( ( isset( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] ) || isset( $_REQUEST['elementor-preview'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return true;
		}

		return false;
	}
	/**
	 * Check for use. Then
	 * Run all the Actions / Filters.
	 */
	public function init_header_footer_support() {
		add_theme_support( 'header-footer-elementor' );
		if ( function_exists( 'hfe_header_enabled' ) ) {
			if ( hfe_header_enabled() ) {
				add_action( 'template_redirect', array( $this, 'remove_theme_header' ) );
				add_action( 'indro_header', 'hfe_render_header' );
			}
		}
		if ( function_exists( 'hfe_footer_enabled' ) ) {
			if ( hfe_footer_enabled() ) {
				add_action( 'template_redirect', array( $this, 'remove_theme_footer' ) );
				add_action( 'indro_footer', 'hfe_render_footer' );
			}
		}
	}
	/**
	 * Disable header from the theme.
	 */
	public function remove_theme_header() {
		remove_action( 'indro_header', 'indro\header_markup' );
	}
	/**
	 * Disable header from the theme.
	 */
	public function remove_theme_footer() {
		remove_action( 'indro_footer', 'indro\footer_markup' );
	}

}
