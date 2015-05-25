<?php
/**
 * WordPress Feature Support
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

/**
 * Add theme support for WordPress features
 *
 * @since 1.0
 */
function resurrect_add_theme_support_wp() {

	// Featured images
	add_theme_support( 'post-thumbnails' );

	// RSS feeds in <head>
	add_theme_support( 'automatic-feed-links' );

	// Custom background with defaults
	add_theme_support( 'custom-background', array(
		'default-color' => '888888', // default color for Customizer (somewhere between light and dark)
		'default-image' => ctfw_background_image_first_preset_url() // first image defined
	) );

	// Output HTML5 markup
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

}

add_action( 'after_setup_theme', 'resurrect_add_theme_support_wp' );
