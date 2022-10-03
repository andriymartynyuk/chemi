<?php

    $wp_customize->add_setting( 
        'indro_language_readmore_setting', 
        array(
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'default'           => esc_html__( '...Read More', 'indro' ),
        )
    );
        
    $wp_customize->add_control( 
        'indro_language_readmore_setting', 
        array(
            'label' => esc_html__( 'Read More', 'indro' ),
            'section' => 'indro_language_section',
            'type' => 'text'
        )
    );     

    $wp_customize->add_setting( 
        'indro_language_comment_setting', 
        array(
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'default'           => esc_html__( 'comment', 'indro' ),
        )
    );
        
    $wp_customize->add_control( 
        'indro_language_comment_setting', 
        array(
            'label' => esc_html__( 'Comment', 'indro' ),
            'section' => 'indro_language_section',
            'type' => 'text'
        )
    );   
    
    $wp_customize->add_setting( 
        'indro_language_comments_setting', 
        array(
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'default'           => esc_html__( 'comments', 'indro' ),
        )
    );
        
    $wp_customize->add_control( 
        'indro_language_comments_setting', 
        array(
            'label' => esc_html__( 'Comments', 'indro' ),
            'section' => 'indro_language_section',
            'type' => 'text'
        )
    );    

