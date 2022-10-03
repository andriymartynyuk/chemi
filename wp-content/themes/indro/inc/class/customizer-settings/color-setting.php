<?php 
/**
 * indro Theme Customizer Color
 *
 * @package indro
 */


  // Elementor Style Overwrite
  $wp_customize->add_setting( 'elementor_style_overwrite',
  array(
      'default' => '0',
      'transport' => 'refresh',
      'sanitize_callback' => 'indro_switch_sanitization'
  )
 );
 $wp_customize->add_control( new indro_Toggle_Switch_Custom_control( $wp_customize, 'elementor_style_overwrite',
  array(
      'label' => esc_html__( 'Elementor Style Overwrite', 'indro' ),
      'section' => 'colors'
  )
 ) );

 
// Primary Color
$wp_customize->add_setting(
    'indro_primary_color',
    array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color' ,
        'default'           => '#1545CB'
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'indro_primary_color',
        array(
            'label'   => __( 'Primary Color', 'indro' ),
            'section' => 'colors'
        )
    )
);

// Secondary Color
$wp_customize->add_setting(
    'indro_secondary_color',
    array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color' ,
        'default'           => '#FE79A2'
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'indro_secondary_color',
        array(
            'label'   => __( 'Secondary Color', 'indro' ),
            'section' => 'colors'
        )
    )
);


//  Gradient Color

   // First Gradient Color
$wp_customize->add_setting(
    'indro_gradient_first_color',
    array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color' ,
        'default'           => '#A253D8'
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'indro_gradient_first_color',
        array(
            'label'   => __( 'Gradient First Color', 'indro' ),
            'section' => 'colors'
        )
    )
);


$wp_customize->add_setting( 'indro_first_color_location', array(
    'default'    => '0',
    'capability' => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
    'transport'  => 'refresh'
) );

$wp_customize->add_control(
    new indro_Range_Custom_Control(
        $wp_customize,
        'indro_first_color_location',
        array(
            'label'       => __( '1st Location', 'indro' ),
            'section'     => 'colors',
            'settings'    => 'indro_first_color_location',
            'description' => __( 'Measurement is in %.', 'indro' ),
            'input_attrs' => array(
                'min'  => 0,
                'max'  => 100,
                'step' => 10
            )
        )
    )
);

   // Secondary Gradient Color
   $wp_customize->add_setting(
    'indro_gradient_second_color',
    array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color' ,
        'default'           => '#1545CB'
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'indro_gradient_second_color',
        array(
            'label'   => __( 'Gradient Second Color', 'indro' ),
            'section' => 'colors'
        )
    )
);

$wp_customize->add_setting( 'indro_second_color_location', array(
    'default'    => '100',
    'capability' => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
    'transport'  => 'refresh'
) );

$wp_customize->add_control(
    new indro_Range_Custom_Control(
        $wp_customize,
        'indro_second_color_location',
        array(
            'label'       => __( '2nd Location', 'indro' ),
            'section'     => 'colors',
            'settings'    => 'indro_second_color_location',
            'description' => __( 'Measurement is in %.', 'indro' ),
            'input_attrs' => array(
                'min'  => 0,
                'max'  => 100,
                'step' => 10
            )
        )
    )
);

// Angle Gradient Color
$wp_customize->add_setting( 'indro_angle_color', array(
    'default'    => '180',
    'capability' => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
    'transport'  => 'refresh'
) );

$wp_customize->add_control(
    new indro_Range_Custom_Control(
        $wp_customize,
        'indro_angle_color',
        array(
            'label'       => __( 'Angle', 'indro' ),
            'section'     => 'colors',
            'settings'    => 'indro_angle_color',
            'description' => __( 'Measurement is in Deg.', 'indro' ),
            'input_attrs' => array(
                'min'  => 0,
                'max'  => 360,
                'step' => 10
            )
        )
    )
);

$wp_customize->add_setting( 'indro_g_opacity_color', array(
    'default'    => '1',
    'capability' => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
    'transport'  => 'refresh'
) );

$wp_customize->add_control(
    new indro_Range_Custom_Control(
        $wp_customize,
        'indro_g_opacity_color',
        array(
            'label'       => __( 'Opacity', 'indro' ),
            'section'     => 'colors',
            'settings'    => 'indro_g_opacity_color',
            'input_attrs' => array(
                'min'  => 0.0,
                'max'  => 1,
                'step' => .1
            )
        )
    )
);
