<?php
/**
 * Header Main Row Options
 *
 * @package indro
 */

namespace indro;

use indro\Theme_Customizer;
use function indro\indro;

ob_start(); ?>
<div class="indro-compontent-tabs nav-tab-wrapper wp-clearfix">
	<a href="#" class="nav-tab indro-general-tab indro-compontent-tabs-button nav-tab-active" data-tab="general">
		<span><?php esc_html_e( 'General', 'indro' ); ?></span>
	</a>
	<a href="#" class="nav-tab indro-design-tab indro-compontent-tabs-button" data-tab="design">
		<span><?php esc_html_e( 'Design', 'indro' ); ?></span>
	</a>
</div>
<?php
$compontent_tabs = ob_get_clean();
$settings = array(
	'page_layout_tabs' => array(
		'control_type' => 'indro_blank_control',
		'section'      => 'page_layout',
		'settings'     => false,
		'priority'     => 1,
		'description'  => $compontent_tabs,
	),
	'info_page_title' => array(
		'control_type' => 'indro_title_control',
		'section'      => 'page_layout',
		'priority'     => 2,
		'label'        => esc_html__( 'Page Title', 'indro' ),
		'settings'     => false,
	),
	'page_title' => array(
		'control_type' => 'indro_switch_control',
		'sanitize'     => 'indro_sanitize_toggle',
		'section'      => 'page_layout',
		'priority'     => 3,
		'default'      => indro()->default( 'page_title' ),
		'label'        => esc_html__( 'Show Page Title?', 'indro' ),
		'transport'    => 'refresh',
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
	),
	'page_title_layout' => array(
		'control_type' => 'indro_radio_icon_control',
		'section'      => 'page_layout',
		'label'        => esc_html__( 'Page Title Layout', 'indro' ),
		'transport'    => 'refresh',
		'priority'     => 4,
		'default'      => indro()->default( 'page_title_layout' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
			array(
				'setting'    => 'page_title',
				'operator'   => '=',
				'value'      => true,
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'normal' => array(
					'name' => __( 'In Content', 'indro' ),
					'icon'    => 'incontent',
				),
				'above' => array(
					'name' => __( 'Above Content', 'indro' ),
					'icon'    => 'abovecontent',
				),
			),
			'responsive' => false,
			'class'      => 'indro-two-col',
		),
	),
	'page_title_inner_layout' => array(
		'control_type' => 'indro_radio_icon_control',
		'section'      => 'page_layout',
		'priority'     => 4,
		'default'      => indro()->default( 'page_title_inner_layout' ),
		'label'        => esc_html__( 'Title Container Width', 'indro' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
			array(
				'setting'    => 'page_title',
				'operator'   => '=',
				'value'      => true,
			),
			array(
				'setting'    => 'page_title_layout',
				'operator'   => '=',
				'value'      => 'above',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'class',
				'selector' => '.page-hero-section',
				'pattern'  => 'entry-hero-layout-$',
				'key'      => '',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'standard' => array(
					'tooltip' => __( 'Background Fullwidth, Content Contained', 'indro' ),
					'name'    => __( 'Standard', 'indro' ),
					'icon'    => '',
				),
				'fullwidth' => array(
					'tooltip' => __( 'Background & Content Fullwidth', 'indro' ),
					'name'    => __( 'Fullwidth', 'indro' ),
					'icon'    => '',
				),
				'contained' => array(
					'tooltip' => __( 'Background & Content Contained', 'indro' ),
					'name'    => __( 'Contained', 'indro' ),
					'icon'    => '',
				),
			),
			'responsive' => false,
		),
	),
	'page_title_align' => array(
		'control_type' => 'indro_radio_icon_control',
		'section'      => 'page_layout',
		'label'        => esc_html__( 'Page Title Align', 'indro' ),
		'priority'     => 4,
		'default'      => indro()->default( 'page_title_align' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
			array(
				'setting'    => 'page_title',
				'operator'   => '=',
				'value'      => true,
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'class',
				'selector' => '.page-title',
				'pattern'  => array(
					'desktop' => 'title-align-$',
					'tablet'  => 'title-tablet-align-$',
					'mobile'  => 'title-mobile-align-$',
				),
				'key'      => '',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'left' => array(
					'tooltip'  => __( 'Left Align Title', 'indro' ),
					'dashicon' => 'editor-alignleft',
				),
				'center' => array(
					'tooltip'  => __( 'Center Align Title', 'indro' ),
					'dashicon' => 'editor-aligncenter',
				),
				'right' => array(
					'tooltip'  => __( 'Right Align Title', 'indro' ),
					'dashicon' => 'editor-alignright',
				),
			),
			'responsive' => true,
		),
	),
	'page_title_height' => array(
		'control_type' => 'indro_range_control',
		'section'      => 'page_layout',
		'priority'     => 5,
		'label'        => esc_html__( 'Title Container Min Height', 'indro' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
			array(
				'setting'    => 'page_title',
				'operator'   => '=',
				'value'      => true,
			),
			array(
				'setting'    => 'page_title_layout',
				'operator'   => '=',
				'value'      => 'above',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '#inner-wrap .page-hero-section .entry-header',
				'property' => 'min-height',
				'pattern'  => '$',
				'key'      => 'size',
			),
		),
		'default'      => indro()->default( 'page_title_height' ),
		'input_attrs'  => array(
			'min'     => array(
				'px'  => 10,
				'em'  => 1,
				'rem' => 1,
				'vh'  => 2,
			),
			'max'     => array(
				'px'  => 800,
				'em'  => 12,
				'rem' => 12,
				'vh'  => 100,
			),
			'step'    => array(
				'px'  => 1,
				'em'  => 0.01,
				'rem' => 0.01,
				'vh'  => 1,
			),
			'units'   => array( 'px', 'em', 'rem', 'vh' ),
		),
	),
	'page_title_elements' => array(
		'control_type' => 'indro_sorter_control',
		'section'      => 'page_layout',
		'priority'     => 6,
		'default'      => indro()->default( 'page_title_elements' ),
		'label'        => esc_html__( 'Title Elements', 'indro' ),
		'transport'    => 'refresh',
		'settings'     => array(
			'elements'   => 'page_title_elements',
			'title'      => 'page_title_element_title',
			'breadcrumb' => 'page_title_element_breadcrumb',
			'meta'       => 'page_title_element_meta',
		),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
			array(
				'setting'    => 'page_title',
				'operator'   => '=',
				'value'      => true,
			),
		),
		'input_attrs'  => array(
			'defaults' => array(
				'title'      => indro()->default( 'page_title_element_title' ),
				'meta'       => indro()->default( 'page_title_element_meta' ),
				'breadcrumb' => indro()->default( 'page_title_element_breadcrumb' ),
			),
			'group' => 'page_title_element',
		),
		// 'partial'      => array(
		// 	'selector'            => '.page-title',
		// 	'container_inclusive' => false,
		// 	'render_callback'     => 'indro\indro_entry_header',
		// ),
	),
	'page_title_font' => array(
		'control_type' => 'indro_typography_control',
		'section'      => 'page_layout',
		'label'        => esc_html__( 'Page Title Font', 'indro' ),
		'default'      => indro()->default( 'page_title_font' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => '.page-title h1',
				'property' => 'font',
				'key'      => 'typography',
			),
		),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
			array(
				'setting'    => 'page_title',
				'operator'   => '=',
				'value'      => true,
			),
		),
		'input_attrs'  => array(
			'id'             => 'page_title_font',
			'headingInherit' => true,
		),
	),
	'page_title_breadcrumb_color' => array(
		'control_type' => 'indro_color_control',
		'section'      => 'page_layout',
		'label'        => esc_html__( 'Breadcrumb Colors', 'indro' ),
		'default'      => indro()->default( 'page_title_breadcrumb_color' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.page-title .indro-breadcrumbs',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.page-title .indro-breadcrumbs a:hover',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Color', 'indro' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Link Hover Color', 'indro' ),
					'palette' => true,
				),
			),
		),
	),
	'page_title_breadcrumb_font' => array(
		'control_type' => 'indro_typography_control',
		'section'      => 'page_layout',
		'label'        => esc_html__( 'Breadcrumb Font', 'indro' ),
		'default'      => indro()->default( 'page_title_breadcrumb_font' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => '.page-title .indro-breadcrumbs',
				'property' => 'font',
				'key'      => 'typography',
			),
		),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'input_attrs'  => array(
			'id'      => 'page_title_breadcrumb_font',
			'options' => 'no-color',
		),
	),
	'page_title_meta_color' => array(
		'control_type' => 'indro_color_control',
		'section'      => 'page_layout',
		'label'        => esc_html__( 'Meta Colors', 'indro' ),
		'default'      => indro()->default( 'page_title_meta_color' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.page-title .entry-meta',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.page-title .entry-meta a:hover',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Color', 'indro' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Link Hover Color', 'indro' ),
					'palette' => true,
				),
			),
		),
	),
	'page_title_meta_font' => array(
		'control_type' => 'indro_typography_control',
		'section'      => 'page_layout',
		'label'        => esc_html__( 'Meta Font', 'indro' ),
		'default'      => indro()->default( 'page_title_meta_font' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => '.page-title .entry-meta',
				'property' => 'font',
				'key'      => 'typography',
			),
		),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'input_attrs'  => array(
			'id'      => 'page_title_breadcrumb_font',
			'options' => 'no-color',
		),
	),
	'page_title_background' => array(
		'control_type' => 'indro_background_control',
		'section'      => 'page_layout',
		'label'        => esc_html__( 'Page Title Background', 'indro' ),
		'default'      => indro()->default( 'page_title_background' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
			array(
				'setting'    => 'page_title',
				'operator'   => '=',
				'value'      => true,
			),
			array(
				'setting'    => 'page_title_layout',
				'operator'   => '=',
				'value'      => 'above',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css_background',
				'selector' => '#inner-wrap .page-hero-section .entry-hero-container-inner',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'base',
			),
		),
		'input_attrs'  => array(
			'tooltip'  => __( 'Page Title Background', 'indro' ),
		),
	),
	'page_title_featured_image' => array(
		'control_type' => 'indro_switch_control',
		'sanitize'     => 'indro_sanitize_toggle',
		'section'      => 'page_layout',
		'default'      => indro()->default( 'page_title_featured_image' ),
		'label'        => esc_html__( 'Use Featured Image for Background?', 'indro' ),
		'transport'    => 'refresh',
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
			array(
				'setting'    => 'page_title',
				'operator'   => '=',
				'value'      => true,
			),
			array(
				'setting'    => 'page_title_layout',
				'operator'   => '=',
				'value'      => 'above',
			),
		),
	),
	'page_title_overlay_color' => array(
		'control_type' => 'indro_color_control',
		'section'      => 'page_layout',
		'label'        => esc_html__( 'Background Overlay Color', 'indro' ),
		'default'      => indro()->default( 'page_title_overlay_color' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.page-hero-section .hero-section-overlay',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'color',
			),
		),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
			array(
				'setting'    => 'page_title',
				'operator'   => '=',
				'value'      => true,
			),
			array(
				'setting'    => 'page_title_layout',
				'operator'   => '=',
				'value'      => 'above',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Overlay Color', 'indro' ),
					'palette' => true,
				),
			),
			'allowGradient' => true,
		),
	),
	'page_title_border' => array(
		'control_type' => 'indro_borders_control',
		'section'      => 'page_layout',
		'label'        => esc_html__( 'Border', 'indro' ),
		'default'      => indro()->default( 'page_title_border' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
			array(
				'setting'    => 'page_title',
				'operator'   => '=',
				'value'      => true,
			),
			array(
				'setting'    => 'page_title_layout',
				'operator'   => '=',
				'value'      => 'above',
			),
		),
		'settings'     => array(
			'border_top'    => 'page_title_top_border',
			'border_bottom' => 'page_title_bottom_border',
		),
		'live_method'     => array(
			'page_title_top_border' => array(
				array(
					'type'     => 'css_border',
					'selector' => '.page-hero-section .entry-hero-container-inner',
					'pattern'  => '$',
					'property' => 'border-top',
					'key'      => 'border',
				),
			),
			'page_title_bottom_border' => array( 
				array(
					'type'     => 'css_border',
					'selector' => '.page-hero-section .entry-hero-container-inner',
					'property' => 'border-bottom',
					'pattern'  => '$',
					'key'      => 'border',
				),
			),
		),
	),
	'info_page_layout' => array(
		'control_type' => 'indro_title_control',
		'section'      => 'page_layout',
		'priority'     => 10,
		'label'        => esc_html__( 'Default Page Layout', 'indro' ),
		'settings'     => false,
	),
	'page_layout' => array(
		'control_type' => 'indro_radio_icon_control',
		'section'      => 'page_layout',
		'label'        => esc_html__( 'Default Page Layout', 'indro' ),
		'transport'    => 'refresh',
		'priority'     => 10,
		'default'      => indro()->default( 'page_layout' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'normal' => array(
					'name' => __( 'Normal', 'indro' ),
					'icon' => 'normal',
				),
				'narrow' => array(
					'name' => __( 'Narrow', 'indro' ),
					'icon' => 'narrow',
				),
				'fullwidth' => array(
					'name' => __( 'Fullwidth', 'indro' ),
					'icon' => 'fullwidth',
				),
				'left' => array(
					'name' => __( 'Left Sidebar', 'indro' ),
					'icon' => 'leftsidebar',
				),
				'right' => array(
					'name' => __( 'Right Sidebar', 'indro' ),
					'icon' => 'rightsidebar',
				),
			),
			'responsive' => false,
			'class'      => 'indro-three-col',
		),
	),
	'page_sidebar_id' => array(
		'control_type' => 'indro_select_control',
		'section'      => 'page_layout',
		'label'        => esc_html__( 'Page Default Sidebar', 'indro' ),
		'transport'    => 'refresh',
		'priority'     => 10,
		'default'      => indro()->default( 'page_sidebar_id' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
		'input_attrs'  => array(
			'options' => indro()->sidebar_options(),
		),
	),
	'page_content_style' => array(
		'control_type' => 'indro_radio_icon_control',
		'section'      => 'page_layout',
		'label'        => esc_html__( 'Content Style', 'indro' ),
		'priority'     => 10,
		'default'      => indro()->default( 'page_content_style' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'class',
				'selector' => 'body.page',
				'pattern'  => 'content-style-$',
				'key'      => '',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'boxed' => array(
					'name' => __( 'Boxed', 'indro' ),
					'icon' => 'boxed',
				),
				'unboxed' => array(
					'name' => __( 'Unboxed', 'indro' ),
					'icon' => 'narrow',
				),
			),
			'responsive' => false,
			'class'      => 'indro-two-col',
		),
	),
	'page_vertical_padding' => array(
		'control_type' => 'indro_radio_icon_control',
		'section'      => 'page_layout',
		'label'        => esc_html__( 'Content Vertical Padding', 'indro' ),
		'priority'     => 10,
		'default'      => indro()->default( 'page_vertical_padding' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'class',
				'selector' => 'body.page',
				'pattern'  => 'content-vertical-padding-$',
				'key'      => '',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'show' => array(
					'name' => __( 'Enable', 'indro' ),
				),
				'hide' => array(
					'name' => __( 'Disable', 'indro' ),
				),
			),
			'responsive' => false,
		),
	),
	'page_feature' => array(
		'control_type' => 'indro_switch_control',
		'sanitize'     => 'indro_sanitize_toggle',
		'section'      => 'page_layout',
		'priority'     => 20,
		'default'      => indro()->default( 'page_feature' ),
		'label'        => esc_html__( 'Show Featured Image?', 'indro' ),
		'transport'    => 'refresh',
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
	),
	'page_feature_position' => array(
		'control_type' => 'indro_radio_icon_control',
		'section'      => 'page_layout',
		'label'        => esc_html__( 'Featured Image Position', 'indro' ),
		'priority'     => 20,
		'transport'    => 'refresh',
		'default'      => indro()->default( 'page_feature_position' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
			array(
				'setting'    => 'page_feature',
				'operator'   => '=',
				'value'      => true,
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'above' => array(
					'name' => __( 'Above', 'indro' ),
				),
				'behind' => array(
					'name' => __( 'Behind', 'indro' ),
				),
				'below' => array(
					'name' => __( 'Below', 'indro' ),
				),
			),
			'responsive' => false,
		),
	),
	'page_feature_ratio' => array(
		'control_type' => 'indro_radio_icon_control',
		'section'      => 'page_layout',
		'label'        => esc_html__( 'Featured Image Ratio', 'indro' ),
		'priority'     => 20,
		'default'      => indro()->default( 'page_feature_ratio' ),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
			array(
				'setting'    => 'page_feature',
				'operator'   => '=',
				'value'      => true,
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'class',
				'selector' => 'body.page .article-post-thumbnail',
				'pattern'  => 'indro-thumbnail-ratio-$',
				'key'      => '',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'inherit' => array(
					'name' => __( 'Inherit', 'indro' ),
				),
				'1-1' => array(
					'name' => __( '1:1', 'indro' ),
				),
				'3-4' => array(
					'name' => __( '4:3', 'indro' ),
				),
				'2-3' => array(
					'name' => __( '3:2', 'indro' ),
				),
				'9-16' => array(
					'name' => __( '16:9', 'indro' ),
				),
				'1-2' => array(
					'name' => __( '2:1', 'indro' ),
				),
			),
			'responsive' => false,
			'class' => 'indro-three-col-short',
		),
	),
	'page_comments' => array(
		'control_type' => 'indro_switch_control',
		'sanitize'     => 'indro_sanitize_toggle',
		'section'      => 'page_layout',
		'priority'     => 20,
		'default'      => indro()->default( 'page_comments' ),
		'label'        => esc_html__( 'Show Comments?', 'indro' ),
		'transport'    => 'refresh',
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'general',
			),
		),
	),
	'page_background' => array(
		'control_type' => 'indro_background_control',
		'section'      => 'page_layout',
		'label'        => esc_html__( 'Site Background', 'indro' ),
		'default'      => indro()->default( 'page_background' ),
		'live_method'     => array(
			array(
				'type'     => 'css_background',
				'selector' => 'body.page',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'base',
			),
		),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'input_attrs'  => array(
			'tooltip' => __( 'Page Background', 'indro' ),
		),
	),
	'page_content_background' => array(
		'control_type' => 'indro_background_control',
		'section'      => 'page_layout',
		'label'        => esc_html__( 'Content Background', 'indro' ),
		'default'      => indro()->default( 'page_content_background' ),
		'live_method'  => array(
			array(
				'type'     => 'css_background',
				'selector' => 'body.page .content-bg, body.page.content-style-unboxed .site',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'base',
			),
		),
		'context'      => array(
			array(
				'setting' => '__current_tab',
				'value'   => 'design',
			),
		),
		'input_attrs'  => array(
			'tooltip' => __( 'Page Content Background', 'indro' ),
		),
	),
);

Theme_Customizer::add_settings( $settings );

