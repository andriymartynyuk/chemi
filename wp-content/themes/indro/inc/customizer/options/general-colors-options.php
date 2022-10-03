<?php
/**
 * Header Builder Options
 *
 * @package indro
 */

namespace indro;

use indro\Theme_Customizer;
use function indro\indro;

Theme_Customizer::add_settings(
	array(
		'info_background' => array(
			'control_type' => 'indro_title_control',
			'section'      => 'colors',
			'label'        => esc_html__( 'Backgrounds', 'indro' ),
			'settings'     => false,
		),
		'site_background' => array(
			'control_type' => 'indro_background_control',
			'section'      => 'colors',
			'label'        => esc_html__( 'Site Background', 'indro' ),
			'default'      => indro()->default( 'site_background' ),
			'live_method'     => array(
				array(
					'type'     => 'css_background',
					'selector' => 'body',
					'property' => 'background',
					'pattern'  => '$',
					'key'      => 'base',
				),
			),
			'input_attrs'  => array(
				'tooltip'  => __( 'Site Background', 'indro' ),
			),
		),
		'content_background' => array(
			'control_type' => 'indro_background_control',
			'section'      => 'colors',
			'label'        => esc_html__( 'Content Background', 'indro' ),
			'default'      => indro()->default( 'content_background' ),
			'live_method'     => array(
				array(
					'type'     => 'css_background',
					'selector' => '.content-bg, body.content-style-unboxed .site',
					'property' => 'background',
					'pattern'  => '$',
					'key'      => 'base',
				),
			),
			'input_attrs'  => array(
				'tooltip'  => __( 'Content Background', 'indro' ),
			),
		),
		'above_title_background' => array(
			'control_type' => 'indro_background_control',
			'section'      => 'colors',
			'label'        => esc_html__( 'Title Above Content Background', 'indro' ),
			'default'      => indro()->default( 'above_title_background' ),
			'live_method'     => array(
				array(
					'type'     => 'css_background',
					'selector' => '.site .entry-hero-container-inner',
					'property' => 'background',
					'pattern'  => '$',
					'key'      => 'base',
				),
			),
			'input_attrs'  => array(
				'tooltip'  => __( 'Title Above Content Background', 'indro' ),
			),
		),
		'above_title_overlay_color' => array(
			'control_type' => 'indro_color_control',
			'section'      => 'colors',
			'label'        => esc_html__( 'Title Above Content Overlay Color', 'indro' ),
			'default'      => indro()->default( 'above_title_overlay_color' ),
			'live_method'     => array(
				array(
					'type'     => 'css',
					'selector' => '.entry-hero-container-inner .hero-section-overlay',
					'property' => 'background',
					'pattern'  => '$',
					'key'      => 'color',
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
		'info_links' => array(
			'control_type' => 'indro_title_control',
			'section'      => 'colors',
			'label'        => esc_html__( 'Content Links', 'indro' ),
			'settings'     => false,
		),
		'link_color' => array(
			'control_type' => 'indro_color_link_control',
			'section'      => 'colors',
			'transport'    => 'refresh',
			'label'        => esc_html__( 'Links Color', 'indro' ),
			'default'      => indro()->default( 'link_color' ),
			'live_method'     => array(
				array(
					'type'     => 'css_link',
					'selector' => 'a',
					'property' => 'color',
					'pattern'  => 'link-style-$',
					'key'      => 'base',
				),
			),
		),
	)
);

