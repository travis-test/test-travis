<?php
/**
 * crystal Theme Customizer.
 *
 * @package crystal
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function crystal_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'crystal_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function crystal_customize_preview_js() {
	wp_enqueue_script( 'crystal_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'crystal_customize_preview_js' );


/**
 * Adds custom customizer elements
 *
 */
add_action( 'customize_register', 'crystal_add_customizer' );

if( ! function_exists( 'crystal_add_customizer' ) ) {

	function crystal_add_customizer( $wp_customize ) {
		/* Page Layout section
		----------------------------------------------------*/
		$wp_customize->add_section( 'crystal_page_layout' , array(
			'title'      => esc_html__('Page Layout','crystal'),
			'priority'   => 100,
		) );

		/* Header Grid type */
		$wp_customize->add_setting( 'crystal_header_grid_type', array(
				'default'           => 'boxed',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'crystal_sanitize_select'
		) );
		$wp_customize->add_control( 'crystal_header_grid_type', array(
				'label'    => esc_html__( 'Header Grid Type', 'crystal' ),
				'section'  => 'crystal_page_layout',
				'settings' => 'crystal_header_grid_type',
				'type'     => 'select',
				'priority' => 10,
				'choices'  => array(
						'boxed' => esc_html__( 'Boxed', 'crystal' ),
						'wide'  => esc_html__( 'Wide', 'crystal' )
				)
		) );

		/* Content Grid type */
		$wp_customize->add_setting( 'crystal_content_grid_type', array(
				'default'           => 'boxed',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'crystal_sanitize_select'
		) );
		$wp_customize->add_control( 'crystal_content_grid_type', array(
				'label'    => esc_html__( 'Content Grid Type', 'crystal' ),
				'section'  => 'crystal_page_layout',
				'settings' => 'crystal_content_grid_type',
				'type'     => 'select',
				'priority' => 20,
				'choices'  => array(
						'boxed' => esc_html__( 'Boxed', 'crystal' ),
						'wide'  => esc_html__( 'Wide', 'crystal' )
				)
		) );

		/* Footer Grid type */
		$wp_customize->add_setting( 'crystal_footer_grid_type', array(
				'default'           => 'boxed',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'crystal_sanitize_select'
		) );
		$wp_customize->add_control( 'crystal_footer_grid_type', array(
				'label'    => esc_html__( 'Footer Grid Type', 'crystal' ),
				'section'  => 'crystal_page_layout',
				'settings' => 'crystal_footer_grid_type',
				'type'     => 'select',
				'priority' => 30,
				'choices'  => array(
						'boxed' => esc_html__( 'Boxed', 'crystal' ),
						'wide'  => esc_html__( 'Wide', 'crystal' )
				)
		) );

		/* Sidebar position */
		$wp_customize->add_setting( 'crystal_sidebar_position', array(
			'default'           => 'right',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'crystal_sanitize_select'
		) );
		$wp_customize->add_control( 'crystal_sidebar_position', array(
			'label'    => esc_html__( 'Sidebar position', 'crystal' ),
			'section'  => 'crystal_page_layout',
			'settings' => 'crystal_sidebar_position',
			'type'     => 'select',
			'priority' => 40,
			'choices'  => array(
				'right' => esc_html__( 'Right', 'crystal' ),
				'left'  => esc_html__( 'Left', 'crystal' )
			)
		) );
	}
}

/**
 * Sanitize callback select input
 *
 * @copyright Copyright (c) 2015, WordPress Theme Review Team
 */
function crystal_sanitize_select( $input, $setting ) {

	// Ensure input is a slug.
	$input = sanitize_key( $input );

	$control = str_replace( '[', '_', trim( $setting->id, ']' ) );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $control )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}