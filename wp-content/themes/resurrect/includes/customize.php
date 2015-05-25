<?php
/**
 * Theme Customizer
 *
 * Add options to the Theme Customizer.
 *
 * Thank you Otto: http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
 *
 * @package    Resurrect
 * @subpackage Functions
 * @copyright  Copyright (c) 2013 - 2014, churchthemes.com
 * @link       http://churchthemes.com/themes/resurrect
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      1.0
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*********************************************
 * CHOICES
 *********************************************/

/**
 * Offset Select Choices
 *
 * @since 1.2.1
 * @return array Choices for user selection and sanitization
 */
function resurrect_customize_offset_choices() {

	$choices = array();

	$choices[0] = __( "Don't move", 'resurrect' );

	for ( $i = 1; $i <= 50; $i++ ) {
		$choices[$i] = sprintf( __( '%d pixels right', 'resurrect' ), $i );
		$choices['-' . $i] = sprintf( __( '%d pixels left', 'resurrect' ), $i );
	}

	return apply_filters( 'resurrect_customize_offset_choices', $choices );

}

/**
 * Header Text Color Choices
 *
 * @since 1.2.1
 * @return array Choices for user selection and sanitization
 */
function resurrect_customize_header_text_color_choices() {

	$choices = array(
		'dark'	=> _x( 'Dark', 'customizer header text', 'resurrect' ),
		'light'	=> _x( 'Light', 'customizer header text', 'resurrect' ),
	);

	return apply_filters( 'resurrect_customize_header_text_color_choices', $choices );

}

/**
 * Logo Type Choices
 *
 * @since 1.2.1
 * @return array Choices for user selection and sanitization
 */
function resurrect_customize_logo_type_choices() {

	$choices = 	array(
		'image'	=> _x( 'Image', 'customizer', 'resurrect' ),
		'text'	=> _x( 'Text', 'customizer', 'resurrect' ),
	);

	return apply_filters( 'resurrect_customize_logo_type_choices', $choices );

}

/**
 * Logo Text Size Choices
 *
 * @since 1.2.1
 * @return array Choices for user selection and sanitization
 */
function resurrect_customize_logo_text_size_choices() {

	$choices = 	array(
		'extra-small'	=> _x( 'Extra Small', 'customizer', 'resurrect' ),
		'small'			=> _x( 'Small', 'customizer', 'resurrect' ),
		'medium'		=> _x( 'Medium', 'customizer', 'resurrect' ),
		'large'			=> _x( 'Large', 'customizer', 'resurrect' ),
		'extra-large'	=> _x( 'Extra Large', 'customizer', 'resurrect' ),
	);

	return apply_filters( 'resurrect_customize_logo_text_size_choices', $choices );

}

/**
 * Header Right Choices
 *
 * @since 1.2.1
 * @return array Choices for user selection and sanitization
 */
function resurrect_customize_header_right_choices() {

	$choices = 	array(
		'tagline'	=> _x( 'Tagline', 'customizer', 'resurrect' ),
		'sermons'	=> _x( 'Latest Sermons', 'customizer', 'resurrect' ),
		'events'	=> _x( 'Upcoming Events', 'customizer', 'resurrect' ),
		'posts'		=> _x( 'Latest Posts', 'customizer', 'resurrect' ),
		'content'	=> _x( 'Custom Content', 'customizer', 'resurrect' ),
		'none'		=> _x( 'Nothing', 'customizer', 'resurrect' )
	);

	return apply_filters( 'resurrect_customize_header_right_choices', $choices );

}

/**
 * Header Right Items Limit Choices
 *
 * @since 1.2.1
 * @return array Choices for user selection and sanitization
 */
function resurrect_customize_header_right_items_limit_choices() {

	$choices = array(
		'1'	=> _x( 'One', 'customizer header items', 'resurrect' ),
		'2'	=> _x( 'Two', 'customizer header items', 'resurrect' ),
	);

	return apply_filters( 'resurrect_customize_header_right_items_limit_choices', $choices );

}

/*********************************************
 * SETTINGS
 *********************************************/

/**
 * Sections, settings and controls
 *
 * @since 1.0
 * @param object $wp_customize WordPress theme customizer object
 */
function resurrect_customize_register( $wp_customize ) {

	// Master Option
	// All options will be saved as an array under this single option ID
	$option_id = ctfw_customize_option_id();
	$setting_type = 'option';

	// Default values
	$defaults = ctfw_customize_defaults();

	// Control priority increment
	$control_increment = 20;

	// Remove default "Site Title & Tagline" section
	$wp_customize->remove_section( 'title_tagline' );

	/****************** COLORS *******************/

	$section = 'colors'; // default section
	$control_priority = 0;

		// Color Scheme
		$setting = $option_id . '[color]';
		$wp_customize->add_setting( $setting, array(
			'default'				=> $defaults['color']['value'],
			'type'					=> $setting_type,
			'sanitize_callback'		=> 'resurrect_customize_sanitize_color',
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> __( 'Color Scheme', 'resurrect' ),
				'section'	=> $section, // core WordPress section
				'type'		=> 'radio',
				'choices'	=> ctfw_colors(), // options based on what is in the colors directory
				'priority'	=> $control_priority += $control_increment,
			) );

		// Header Text
		$setting = $option_id . '[header_text_color]';
		$wp_customize->add_setting( $setting, array(
			'default'				=> $defaults['header_text_color']['value'],
			'type'					=> $setting_type,
			'sanitize_callback'		=> 'resurrect_customize_sanitize_header_text_color',
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> __( 'Header Text', 'resurrect' ),
				'section'	=> $section, // core WordPress section
				'type'		=> 'radio',
				'choices'	=> resurrect_customize_header_text_color_choices(),
				'priority'	=> $control_priority += $control_increment,
			) );

		// Background Color
		$wp_customize->get_control( 'background_color' )->priority = $control_priority += $control_increment; // move it down

	/************** BACKGROUND IMAGE *************/

	// Background Image
	$section = 'background_image'; // default section
	$control_priority = 0;

		// Background Image (core extended)
		$setting = 'background_image';

			// Control using extended class
			$wp_customize->remove_control( $setting ); // remove core control
			$wp_customize->add_control( new CTFW_Customize_Background_Image_Control( $wp_customize, $setting, array(
				'section'	=> $section,
				'priority'	=> $control_priority += $control_increment,
				'presets'	=> ctfw_background_image_presets()
			) ) );

		// Fullscreen
		$setting = $option_id . '[background_image_fullscreen]';
		$wp_customize->add_setting( $setting, array(
			'default'			=> $defaults['background_image_fullscreen']['value'],
			'type'				=> $setting_type,
			'transport'			=> 'postMessage',
			'sanitize_callback'	=> 'ctfw_customize_sanitize_checkbox'
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> __( 'Fullscreen Image', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'checkbox',
				'priority'	=> $control_priority += $control_increment,
			) );

		// Background Repeat (core)
		$setting = 'background_repeat';
		$wp_customize->get_control( $setting )->priority = $control_priority += $control_increment;

		// Background Position (core)
		$setting = 'background_position_x';
		$wp_customize->get_control( $setting )->priority = $control_priority += $control_increment;

		// Background Attachment (core)
		$setting = 'background_attachment';
		$wp_customize->get_control( $setting )->priority = $control_priority += $control_increment;

	/******************* FONTS *******************/

	$section = 'resurrect_fonts';
	$wp_customize->add_section( $section, array(
		'title'		=> _x( 'Google Fonts', 'customizer', 'resurrect' ),
		'priority'	=> 80, // core sectionare are 20 apart
	) );
	$control_priority = 0;

		// Logo Font
		$setting = $option_id . '[logo_font]';
		$wp_customize->add_setting( $setting, array(
			'default'			=> $defaults['logo_font']['value'],
			'type'				=> $setting_type,
			'transport'			=> 'postMessage',
			'sanitize_callback'	=> 'resurrect_customize_sanitize_logo_font'
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> __( 'Logo Font', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'select',
				'choices'	=> ctfw_google_font_options_array( array(
									'target' 	=> 'logo_font',
									'show_type'	=> true
							) ),
				'priority'	=> $control_priority += $control_increment,
			) );

		// Heading Font
		$setting = $option_id . '[heading_font]';
		$wp_customize->add_setting( $setting, array(
			'default'	=> $defaults['heading_font']['value'],
			'type'		=> $setting_type,
			'transport'	=> 'postMessage',
			'sanitize_callback'	=> 'resurrect_customize_sanitize_heading_font'
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> __( 'Heading Font', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'select',
				'choices'	=> ctfw_google_font_options_array( array(
									'target' 	=> 'heading_font',
									'show_type'	=> true
							) ),
				'priority'	=> $control_priority += $control_increment,
			) );

		// Menu Font
		$setting = $option_id . '[menu_font]';
		$wp_customize->add_setting( $setting, array(
			'default'	=> $defaults['menu_font']['value'],
			'type'		=> $setting_type,
			'transport'	=> 'postMessage',
			'sanitize_callback'	=> 'resurrect_customize_sanitize_menu_font'
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> __( 'Menu Font', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'select',
				'choices'	=> ctfw_google_font_options_array( array(
									'target' 	=> 'menu_font',
									'show_type'	=> true
							) ),
				'priority'	=> $control_priority += $control_increment,
			) );

		// Body Font
		$setting = $option_id . '[body_font]';
		$wp_customize->add_setting( $setting, array(
			'default'	=> $defaults['body_font']['value'],
			'type'		=> $setting_type,
			'transport'	=> 'postMessage',
			'sanitize_callback'	=> 'resurrect_customize_sanitize_body_font'
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> __( 'Body Font', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'select',
				'choices'	=> ctfw_google_font_options_array( array(
									'target' 	=> 'body_font',
									'show_type'	=> true
							) ),
				'priority'	=> $control_priority += $control_increment,
			) );

		// Character Sets
		$setting = $option_id . '[font_subsets]';
		$wp_customize->add_setting( $setting, array(
			'default'				=> $defaults['font_subsets']['value'],
			'type'					=> $setting_type,
			'sanitize_callback'		=> 'resurrect_customize_sanitize_font_subsets',
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> __( 'Character Sets', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'text',
				'priority'	=> $control_priority += $control_increment,
			) );

	/*************** HEADER & LOGO ***************/

	$section = 'resurrect_header';
	$wp_customize->add_section( $section, array(
		'title'		=> _x( 'Header & Logo', 'customizer', 'resurrect' ),
		'priority'	=> 85, // core sectionare are 20 apart
	) );
	$control_priority = 0;

		// Logo Type
		$setting = $option_id . '[logo_type]';
		$wp_customize->add_setting( $setting, array(
			'default'			=> $defaults['logo_type']['value'],
			'type'				=> $setting_type,
			'sanitize_callback'	=> 'resurrect_customize_sanitize_logo_type',
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> _x( 'Logo Type', 'customizer', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'radio',
				'choices'	=> resurrect_customize_logo_type_choices(),
				'priority'	=> $control_priority += $control_increment,
			) );

		// Logo Image
		$setting = $option_id . '[logo_image]';
		$wp_customize->add_setting( $setting, array(
			'default'			=> $defaults['logo_image']['value'],
			'type'				=> $setting_type,
			'sanitize_callback'	=> 'esc_url_raw'
		) );

			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $setting, array(
				'label'		=> _x( 'Logo Image', 'customizer', 'resurrect' ),
				'section'	=> $section,
				'priority'	=> $control_priority += $control_increment,
			) ) );

		// Logo Image - HiDPI / Retina
		$setting = $option_id . '[logo_hidpi]';
		$wp_customize->add_setting( $setting, array(
			'default'			=> $defaults['logo_hidpi']['value'],
			'type'				=> $setting_type,
			'sanitize_callback'	=> 'esc_url_raw'
		) );

			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $setting, array(
				'label'		=> _x( 'HiDPI Logo (Optional)', 'customizer', 'resurrect' ),
				'section'	=> $section,
				'priority'	=> $control_priority += $control_increment,
			) ) );

		// Move Logo Image
		// Handy for when logo has shadow sticking out to the left
		// (No spacing option for between logo and tagline since that can be done with logo whitespace)
		$setting = $option_id . '[logo_offset_x]';
		$wp_customize->add_setting( $setting, array(
			'default'				=> $defaults['logo_offset_x']['value'],
			'type'					=> $setting_type,
			'transport'				=> 'postMessage',
			'sanitize_callback'		=> 'resurrect_customize_sanitize_logo_offset_x'
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> __( 'Move Logo', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'select',
				'choices'	=> resurrect_customize_offset_choices(),
				'priority'	=> $control_priority += $control_increment,
			) );

		// Logo Text
		$setting = $option_id . '[logo_text]';
		$wp_customize->add_setting( $setting, array(
			'default'			=> $defaults['logo_text']['value'],
			'type'				=> $setting_type,
			'sanitize_callback'	=> 'resurrect_customize_sanitize_logo_text',
		) );

			$wp_customize->add_control( new CTFW_Customize_Textarea_Control( $wp_customize, $setting, array(
				'label'		=> __( 'Logo Text', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'textarea',
				'priority'	=> $control_priority += $control_increment
			) ) );

		// Logo Text Size
		$setting = $option_id . '[logo_text_size]';
		$wp_customize->add_setting( $setting, array(
			'default'			=> $defaults['logo_text_size']['value'],
			'type'				=> $setting_type,
			'sanitize_callback'	=> 'resurrect_customize_sanitize_logo_text_size'
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> _x( 'Logo Text Size', 'customizer', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'radio',
				'choices'	=> resurrect_customize_logo_text_size_choices(),
				'priority'	=> $control_priority += $control_increment,
			) );

		// Tagline
		// Move it from default "Site Title & Tagline" section which is removed above
		$setting = 'blogdescription'; // don't need to do add_setting because didn't remove it above
		$wp_customize->get_control( $setting )->section = $section;
		$wp_customize->get_setting( $setting )->transport = 'postMessage'; // enable JS updating
		$wp_customize->get_control( $setting )->priority = $control_priority += $control_increment;

		// Show tagline under logo
		$setting = $option_id . '[tagline_under_logo]';
		$wp_customize->add_setting( $setting, array(
			'default'			=> $defaults['tagline_under_logo']['value'],
			'type'				=> $setting_type,
			'sanitize_callback'	=> 'ctfw_customize_sanitize_checkbox'
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> __( 'Show tagline under logo', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'checkbox',
				'priority'	=> $control_priority += $control_increment,
			) );

		// Move Tagline
		// Handy for making tagline line up with text below logo image
		$setting = $option_id . '[tagline_offset_x]';
		$wp_customize->add_setting( $setting, array(
			'default'			=> $defaults['tagline_offset_x']['value'],
			'type'				=> $setting_type,
			'transport'			=> 'postMessage',
			'sanitize_callback'	=> 'resurrect_customize_sanitize_tagline_offset_x'
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> __( 'Move Tagline', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'select',
				'choices'	=> resurrect_customize_offset_choices(),
				'priority'	=> $control_priority += $control_increment,
			) );

		// Show on Right
		$setting = $option_id . '[header_right]';
		$wp_customize->add_setting( $setting, array(
			'default'			=> $defaults['header_right']['value'],
			'type'				=> $setting_type,
			'sanitize_callback'	=> 'resurrect_customize_sanitize_header_right'
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> _x( 'Show on Right', 'customizer', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'radio',
				'choices'	=> resurrect_customize_header_right_choices(),
				'priority'	=> $control_priority += $control_increment,
			) );

		// Header Items Limit
		$setting = $option_id . '[header_right_items_limit]';
		$wp_customize->add_setting( $setting, array(
			'default'			=> $defaults['header_right_items_limit']['value'],
			'type'				=> $setting_type,
			'sanitize_callback'	=> 'resurrect_customize_sanitize_header_right_items_limit'
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> _x( 'Items on Right', 'customizer', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'radio',
				'choices'	=> resurrect_customize_header_right_items_limit_choices(),
				'priority'	=> $control_priority += $control_increment,
			) );

		// Custom Content
		$setting = $option_id . '[header_right_content]';
		$wp_customize->add_setting( $setting, array(
			'default'			=> $defaults['header_right_content']['value'],
			'type'				=> $setting_type,
			'sanitize_callback'	=> 'resurrect_customize_sanitize_header_right_content'
		) );

			$wp_customize->add_control( new CTFW_Customize_Textarea_Control( $wp_customize, $setting, array(
				'label'		=> __( 'Custom Content', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'textarea',
				'priority'	=> $control_priority += $control_increment,
			) ) );

	/**************** FOOTER TEXT ****************/

	$section = 'resurrect_footer';
	$wp_customize->add_section( $section, array(
		'title'			=> _x( 'Footer Text', 'customizer', 'resurrect' ),
		'priority'		=> 90, // core section are are 20 apart
	) );
	$control_priority = 0;

		// Address
		$setting = $option_id . '[footer_address]';
		$wp_customize->add_setting( $setting, array(
			'default'				=> $defaults['footer_address']['value'],
			'type'					=> $setting_type,
			'sanitize_callback'		=> 'resurrect_customize_sanitize_footer_address'
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> __( 'Address', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'text',
				'priority'	=> $control_priority += $control_increment,
			) );

		// Phone
		$setting = $option_id . '[footer_phone]';
		$wp_customize->add_setting( $setting, array(
			'default'				=> $defaults['footer_phone']['value'],
			'type'					=> $setting_type,
			'sanitize_callback'		=> 'resurrect_customize_sanitize_footer_phone',
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> __( 'Phone', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'text',
				'priority'	=> $control_priority += $control_increment,
			) );

		// Notice
		$setting = $option_id . '[footer_notice]';
		$wp_customize->add_setting( $setting, array(
			'default'	=> $defaults['footer_notice']['value'],
			'type'		=> $setting_type,
			'sanitize_callback'		=> 'resurrect_customize_sanitize_footer_notice',
		) );

			$wp_customize->add_control( new CTFW_Customize_Textarea_Control( $wp_customize, $setting, array(
				'label'		=> _x( 'Notice', 'customizer', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'textarea',
				'priority'	=> $control_priority += $control_increment,
			) ) );

	/************ SOCIAL MEDIA ICONS *************/

	$section = 'resurrect_icons';
	$wp_customize->add_section( $section, array(
		'title'			=> _x( 'Social Media Icons', 'customizer', 'resurrect' ),
		'priority'		=> 100, // core section are are 20 apart
	) );
	$control_priority = 0;

		// Header URLs
		$setting = $option_id . '[header_icon_urls]';
		$wp_customize->add_setting( $setting, array(
			'default'			=> $defaults['header_icon_urls']['value'],
			'type'				=> $setting_type,
			'sanitize_callback'	=> 'resurrect_customize_sanitize_social_icons',
		) );

			$wp_customize->add_control( new CTFW_Customize_Textarea_Control( $wp_customize, $setting, array(
				'label'		=> __( 'Header URLs', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'textarea',
				'priority'	=> $control_priority += $control_increment,
			) ) );

			add_action( 'ctfw_customize_textarea_control_before-' . $setting, 'resurrect_customize_icons_description' );

			function resurrect_customize_icons_description() {

				?>
				<p id="resurrect-customize-icons-description" class="description">
					<?php printf( __( 'Enter one URL per line for %s. Use <code>[ctcom_rss_url]</code> for RSS.', 'resurrect' ), resurrect_social_icon_sites( 'or' ) ); ?>
				<p>
				<?php

			}

		// Footer URLs
		$setting = $option_id . '[footer_icon_urls]';
		$wp_customize->add_setting( $setting, array(
			'default'			=> $defaults['footer_icon_urls']['value'],
			'type'				=> $setting_type,
			'sanitize_callback'	=> 'resurrect_customize_sanitize_social_icons',
		) );

			$wp_customize->add_control( new CTFW_Customize_Textarea_Control( $wp_customize, $setting, array(
				'label'		=> __( 'Footer URLs', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'textarea',
				'priority'	=> $control_priority += $control_increment,
			) ) );

	/************* NAVIGATION (CORE) *************/

	$section = 'nav'; // default section
	$control_priority = 0;

		// Breadcrumb Path
		$setting = $option_id . '[show_breadcrumbs]';
		$wp_customize->add_setting( $setting, array(
			'default'			=> $defaults['show_breadcrumbs']['value'],
			'type'				=> $setting_type,
			'sanitize_callback'	=> 'ctfw_customize_sanitize_checkbox',
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> __( 'Show breadcrumb path on subpages', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'checkbox',
				'priority'	=> $control_priority += $control_increment,
			) );

	/************* STATIC FRONT PAGE *************/

	// Static Front Page (core)
	$section = 'static_front_page';
	$wp_customize->get_section( $section )->priority = 110; // section order

	/************** HOMEPAGE SLIDER **************/

	$section = 'resurrect_slider';
	$wp_customize->add_section( $section, array(
		'title'				=> _x( 'Homepage Slider', 'customizer', 'resurrect' ),
		'priority'			=> 120, // core section are are 20 apart,
		'sanitize_callback'	=> 'ctfw_customize_sanitize_checkbox',
	) );
	$control_priority = 0;

		// Automatic
		$setting = $option_id . '[slider_slideshow]';
		$wp_customize->add_setting( $setting, array(
			'default'			=> $defaults['slider_slideshow']['value'],
			'type'				=> $setting_type,
			'sanitize_callback'	=> 'ctfw_customize_sanitize_checkbox',
		) );

			$wp_customize->add_control( $setting, array(
				'label'		=> __( 'Automatically transition to next slide', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'checkbox',
				'priority'	=> $control_priority += $control_increment,
			) );

		// Speed
		$setting = $option_id . '[slider_speed]';
		$wp_customize->add_setting( $setting, array(
			'default'	=> $defaults['slider_speed']['value'],
			'type'		=> $setting_type,
			'sanitize_callback'		=> 'resurrect_customize_sanitize_slider_speed',
		) );

			$wp_customize->add_control( new CTFW_Customize_Number_Control( $wp_customize, $setting, array(
				'label'		=> __( 'Seconds Between Transitions', 'resurrect' ),
				'section'	=> $section,
				'type'		=> 'number',
				'priority'	=> $control_priority += $control_increment,
			) ) );

	/****************** WIDGETS ******************/

	// Widgets (core) - move to bottom
	if ( method_exists( $wp_customize, 'get_panel' ) ) { // prevent nonexistent metnhor error in pre WordPress 4.0
		$panel = (object) $wp_customize->get_panel( 'widgets' ); // prevent "Creating default object from empty value" warning in PHP 5.4
		$panel->priority = 999; // panel/section order
	}

}

add_action( 'customize_register', 'resurrect_customize_register' );

/*********************************************
 * SANITIZATION
 *********************************************/

/****************** COLORS *******************/

/**
 * Sanitize Color Scheme
 *
 * @since 1.2.1
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return string Sanitized value
 */
function resurrect_customize_sanitize_color( $input, $object ) {

	// Check input against options; use default if empty value not permitted
	$output = ctfw_customize_sanitize_single_choice( 'color', $input, ctfw_colors() ); // ctfw_customize_sanitize_single_choice is for radio or single select

	// Return sanitized, filterable
	return apply_filters( 'resurrect_customize_sanitize_color', $output, $input, $object );

}

/**
 * Sanitize Header Text Color
 *
 * @since 1.2.1
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return string Sanitized value
 */
function resurrect_customize_sanitize_header_text_color( $input, $object ) {

	// Check input against options; use default if empty value not permitted
	$output = ctfw_customize_sanitize_single_choice( 'header_text_color', $input, resurrect_customize_header_text_color_choices() ); // ctfw_customize_sanitize_single_choice is for radio or single select

	// Return sanitized, filterable
	return apply_filters( 'resurrect_customize_sanitize_header_text_color', $output, $input, $object );

}

/**
 * Background Color -- setting handled by core
 */

/************* BACKGROUND IMAGE **************/

/**
 * Background Image -- setting handled by core
 */

/**
 * Fullscreen Image -- done directly with ctfw_customize_sanitize_checkbox()
 */

/**
 * Background Repeat / Position / Attachment -- settings handled by core
 */

/*************** GOOGLE FONTS ****************/

/**
 * Sanitize Logo Font
 *
 * @since 1.2.1
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return string Sanitized value
 */
function resurrect_customize_sanitize_logo_font( $input, $object ) {

	// Check input against choices; use default if empty value not permitted
	$output = ctfw_customize_sanitize_google_font( 'logo_font', $input );

	// Return sanitized, filterable
	return apply_filters( 'resurrect_customize_sanitize_logo_font', $output, $input, $object );

}

/**
 * Sanitize Menu Font
 *
 * @since 1.2.1
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return string Sanitized value
 */
function resurrect_customize_sanitize_menu_font( $input, $object ) {

	// Check input against choices; use default if empty value not permitted
	$output = ctfw_customize_sanitize_google_font( 'menu_font', $input );

	// Return sanitized, filterable
	return apply_filters( 'resurrect_customize_sanitize_menu_font', $output, $input, $object );

}

/**
 * Sanitize Heading Font
 *
 * @since 1.2.1
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return string Sanitized value
 */
function resurrect_customize_sanitize_heading_font( $input, $object ) {

	// Check input against choices; use default if empty value not permitted
	$output = ctfw_customize_sanitize_google_font( 'heading_font', $input );

	// Return sanitized, filterable
	return apply_filters( 'resurrect_customize_sanitize_heading_font', $output, $input, $object );

}

/**
 * Sanitize Body Font
 *
 * @since 1.2.1
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return string Sanitized value
 */
function resurrect_customize_sanitize_body_font( $input, $object ) {

	// Check input against choices; use default if empty value not permitted
	$output = ctfw_customize_sanitize_google_font( 'body_font', $input );

	// Return sanitized, filterable
	return apply_filters( 'resurrect_customize_sanitize_body_font', $output, $input, $object );

}

/**
 * Sanitize Google Font Character Sets
 *
 * @since 1.2.1
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return string Sanitized value
 */
function resurrect_customize_sanitize_font_subsets( $input, $object ) {

	// Remove whitespace, HTML, etc.
	$output = sanitize_text_field( $input );

	// Return sanitized filterable
	return apply_filters( 'resurrect_customize_sanitize_font_subsets', $output, $input, $object );

}

/*************** HEADER & LOGO ****************/

/**
 * Sanitize Logo Type
 *
 * @since 1.2.1
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return string Sanitized value
 */
function resurrect_customize_sanitize_logo_type( $input, $object ) {

	// Check input against choices; use default if empty value not permitted
	$output = ctfw_customize_sanitize_single_choice( 'logo_type', $input, resurrect_customize_logo_type_choices() ); // ctfw_customize_sanitize_single_choice is for radio or single select

	// Return sanitized, filterable
	return apply_filters( 'resurrect_customize_sanitize_logo_type', $output, $input, $object );

}

/**
 * Logo Image and HiDPI Logo -- done directly with esc_url_raw()
 */

/**
 * Sanitize Move Logo
 *
 * @since 1.2.1
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return string Sanitized value
 */
function resurrect_customize_sanitize_logo_offset_x( $input, $object ) {

	// Check input against choices; use default if empty value not permitted
	$output = ctfw_customize_sanitize_single_choice( 'logo_offset_x', $input, resurrect_customize_offset_choices() ); // ctfw_customize_sanitize_single_choice is for radio or single select

	// Return sanitized, filterable
	return apply_filters( 'resurrect_customize_sanitize_logo_offset_x', $output, $input, $object );

}

/**
 * Sanitize Logo Text
 *
 * @since 1.2.1
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return string Sanitized value
 */
function resurrect_customize_sanitize_logo_text( $input, $object ) {

	// Allow only <span> tag
	$output = wp_kses( $input, array(
		'span' => array()
	) );

	// Balance tags
	$output = force_balance_tags( $output );

	// Return sanitized filterable
	return apply_filters( 'resurrect_customize_sanitize_logo_text', $output, $input, $object );

}

/**
 * Sanitize Logo Text Size
 *
 * @since 1.2.1
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return string Sanitized value
 */
function resurrect_customize_sanitize_logo_text_size( $input, $object ) {

	// Check input against choices; use default if empty value not permitted
	$output = ctfw_customize_sanitize_single_choice( 'logo_text_size', $input, resurrect_customize_logo_text_size_choices() ); // ctfw_customize_sanitize_single_choice is for radio or single select

	// Return sanitized, filterable
	return apply_filters( 'resurrect_customize_sanitize_logo_text_size', $output, $input, $object );

}

/**
 * Show tagline under logo -- done directly with ctfw_customize_sanitize_checkbox()
 */

/**
 * Sanitize Move Tagline
 *
 * @since 1.2.1
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return string Sanitized value
 */
function resurrect_customize_sanitize_tagline_offset_x( $input, $object ) {

	// Check input against choices; use default if empty value not permitted
	$output = ctfw_customize_sanitize_single_choice( 'tagline_offset_x', $input, resurrect_customize_offset_choices() ); // ctfw_customize_sanitize_single_choice is for radio or single select

	// Return sanitized, filterable
	return apply_filters( 'resurrect_customize_sanitize_tagline_offset_x', $output, $input, $object );

}

/**
 * Sanitize Show on Right
 *
 * @since 1.2.1
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return string Sanitized value
 */
function resurrect_customize_sanitize_header_right( $input, $object ) {

	// Check input against choices; use default if empty value not permitted
	$output = ctfw_customize_sanitize_single_choice( 'header_right', $input, resurrect_customize_header_right_choices() ); // ctfw_customize_sanitize_single_choice is for radio or single select

	// Return sanitized, filterable
	return apply_filters( 'resurrect_customize_sanitize_header_right', $output, $input, $object );

}

/**
 * Sanitize Header Right Items Limit
 *
 * @since 1.0
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return string Sanitized value
 */
function resurrect_customize_sanitize_header_right_items_limit( $input, $object ) {

	// Check input against choices; use default if empty value not permitted
	$output = ctfw_customize_sanitize_single_choice( 'header_right_items_limit', $input, resurrect_customize_header_right_items_limit_choices() ); // ctfw_customize_sanitize_single_choice is for radio or single select

	// Return sanitized, filterable
	return apply_filters( 'resurrect_customize_sanitize_header_right_items_limit', $output, $input, $object );

}

/**
 * Sanitize Header Right Custom Content
 *
 * @since 1.0
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return string Content with "safe" HTML
 */
function resurrect_customize_sanitize_header_right_content( $input, $object ) {

	// Allow HTML (same as posts), no scripts (better to child theme it)
	$output = stripslashes( wp_filter_post_kses( addslashes( $input ) ) );

	// Balance tags
	$output = force_balance_tags( $output );

	// Return sanitized filterable
	return apply_filters( 'resurrect_customize_sanitize_header_right_content', $output, $input, $object );

}

/**************** FOOTER TEXT ****************/

/**
 * Sanitize Footer Address
 *
 * @since 1.0
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return string Address with "safe" HTML
 */
function resurrect_customize_sanitize_footer_address( $input, $object ) {

	// Allow basic HTML (same as comments), no scripts
	$output = stripslashes( wp_filter_kses(  addslashes( $input ) ) );

	// Balance tags
	$output = force_balance_tags( $output );

	// Return sanitized filterable
	return apply_filters( 'resurrect_customize_sanitize_footer_address', $output, $input, $object );

}

/**
 * Sanitize Footer Phone
 *
 * @since 1.0
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return string Phone with "safe" HTML
 */
function resurrect_customize_sanitize_footer_phone( $input, $object ) {

	// Allow basic HTML (same as comments), no scripts
	$output = stripslashes( wp_filter_kses(  addslashes( $input ) ) );

	// Balance tags
	$output = force_balance_tags( $output );

	// Return sanitized filterable
	return apply_filters( 'resurrect_customize_sanitize_footer_phone', $output, $input, $object );

}

/**
 * Sanitize Footer Notice
 */
function resurrect_customize_sanitize_footer_notice( $input, $object ) {

	// Allow HTML (same as posts), no scripts
	$output = stripslashes( wp_filter_post_kses( addslashes( $input ) ) );

	// Balance tags
	$output = force_balance_tags( $output );

	// Return sanitized filterable
	return apply_filters( 'resurrect_customize_sanitize_footer_notice', $output, $input, $object );

}

/************* SOCIAL MEDIA ICONS ************/

/**
 * Sanitize Social Icons
 *
 * Used on header and footer URL lists for icons.
 *
 * @since 1.2.1
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return string Sanitized list of URLs
 */
function resurrect_customize_sanitize_social_icons( $input, $object ) {

	// Remove empty lines and sanitize URLs
	$output = ctfw_sanitize_url_list( $input, array(
		'[ctcom_rss_url]' // allow this string instead of URL
	) );

	// Return sanitized filterable
	return apply_filters( 'resurrect_customize_sanitize_social_icons', $output, $input, $object );

}

/**************** NAVIGATION *****************/

/**
 * Show breadcrumb... -- done directly with ctfw_customize_sanitize_checkbox()
 */

/************** HOMEPAGE SLIDER **************/

/**
 * Automatically transition... -- done directly with ctfw_customize_sanitize_checkbox()
 */

/**
 * Sanitize Slider Speed
 *
 * @since 1.0
 * @param string $input Unsanitized value submitted by user
 * @param object $object
 * @return int Non-negative number greater than 1
 */
function resurrect_customize_sanitize_slider_speed( $input, $object ) {

	// Force non-negative numeric value
	$output = absint( $input );

	// If 0 set it to 1
	if ( 0 == $output ) {
		$output = 1;
	}

	// Return sanitized filterable
	return apply_filters( 'resurrect_customize_sanitize_slider_speed', $output, $input, $object );

}

/*********************************************
 * SCRIPTS & STYLES
 *********************************************/

/**
 * Enqueue JavaScript for customizer controls
 *
 * @since 1.0
 */
function resurrect_customize_enqueue_scripts() {

	// doTimeout used by admin-customize.js
	wp_enqueue_script( 'jquery-ba-dotimeout', ctfw_theme_url( CTFW_THEME_JS_DIR . '/jquery.ba-dotimeout.min.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update

	// Script that handles dynamic display of controls
	wp_enqueue_script( 'resurrect-admin-customize', ctfw_theme_url( CTFW_THEME_JS_DIR . '/admin-customize.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update

	// Make data available to script
	wp_localize_script( 'resurrect-admin-customize', 'resurrect_customize', array(
		'option_id' 				=> ctfw_customize_option_id(),
		'background_colorable_text'	=> __( 'Colorable Image', 'resurrect' )
	));

}

add_action( 'customize_controls_print_scripts', 'resurrect_customize_enqueue_scripts' );

/**
 * Enqueue styles for customizer controls
 *
 * @since 1.0
 */
function resurrect_customize_enqueue_styles() {

	// Main styles for Customizer
	wp_enqueue_style( 'resurrect-admin-customize', ctfw_theme_url( CTFW_THEME_CSS_DIR . '/admin-customize.css' ), false, CTFW_THEME_VERSION ); // bust cache on update

}

add_action( 'customize_controls_print_styles', 'resurrect_customize_enqueue_styles' );

/**
 * Enqueue JavaScript for customizer live preview
 *
 * @since 1.0
 */
function resurrect_customize_preview_enqueue_scripts() {

	// Google Web Font Loader
	wp_enqueue_script( 'google-webfont-loader', ctfw_current_protocol() . '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js', false, null ); // null - don't mess with Google Fonts URL by adding version

	// Enqueue preview script
	wp_enqueue_script( 'resurrect-admin-customize-preview', ctfw_theme_url( CTFW_THEME_JS_DIR . '/admin-customize-preview.js' ), false, CTFW_THEME_VERSION ); // bust cache on theme update

	// Make data available to script
	wp_localize_script( 'resurrect-admin-customize-preview', 'resurrect_customize_preview', array(
		'option_id' 				=> ctfw_customize_option_id(),
		'fonts' 					=> ctfw_google_fonts(),
		'logo_font_selectors'		=> resurrect_style_selectors( 'logo_font' ),
		'menu_font_selectors'		=> resurrect_style_selectors( 'menu_font' ),
		'heading_font_selectors'	=> resurrect_style_selectors( 'heading_font' ),
		'body_font_selectors'		=> resurrect_style_selectors( 'body_font' )
	));

}

add_action( 'customize_preview_init', 'resurrect_customize_preview_enqueue_scripts' );
