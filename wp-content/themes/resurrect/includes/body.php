<?php
/**
 * <body> Functions
 *
 * @package    Resurrect
 * @subpackage Functions
 * @copyright  Copyright (c) 2013, churchthemes.com
 * @link       http://churchthemes.com/themes/resurrect
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      1.0
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*******************************************
 * BODY CLASSES
 *******************************************/

/**
 * Add helper classes to <body>
 *
 * @since 1.0
 * @param array $classes Classes currently being added to body tag
 * @return array Modified classes
 */
function resurrect_add_body_classes( $classes ) {

	// Fonts
	$fonts_areas = array( 'logo_font', 'heading_font', 'menu_font', 'body_font' );
	foreach ( $fonts_areas as $font_area ) {

		$font_name = ctfw_customization( $font_area );
		$font_name = sanitize_title( $font_name );

		$font_area = str_replace( '_', '-', $font_area );

		$classes[] = 'resurrect-' . $font_area . '-' . $font_name;

	}

	// No logo
	if ( ! ctfw_customization( 'logo_image' ) ) {
		$classes[] = 'resurrect-no-logo';
	}

	// Fullscreen background image
	if ( ctfw_customization( 'background_image_fullscreen' ) ) {
		$classes[] = 'resurrect-background-image-fullscreen';
	}

	// Background image name
	// Handy for setting specific background color to match
	$background_image = get_background_image();
	if ( $background_image ) {
		$background_image_info = pathinfo( basename( $background_image ) );
		$classes[] = 'resurrect-background-image-file-' . sanitize_title( $background_image_info['filename'] ); // extension removed
	}

	// "View Full Site" cookie set is set in main.js -- client-side to avoid issues w/caching plugins

	return $classes;

}

add_filter( 'body_class', 'resurrect_add_body_classes' );
