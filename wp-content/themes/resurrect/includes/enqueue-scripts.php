<?php
/**
 * Enqueue JavaScript
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
 * Enqueue JavaScript
 *
 * @since 1.0
 */
function resurrect_enqueue_scripts() {

	// jQuery (included with WordPress)
	wp_enqueue_script( 'jquery' );

	// Internet Explorer 8 fallbacks
	if ( preg_match( '/MSIE 8/i', $_SERVER['HTTP_USER_AGENT'] ) ) {

		// Selectivizr
		// Add some of the missing CSS3 selectors for IE8
		wp_enqueue_script( 'selectivizr', ctfw_theme_url( CTFW_THEME_JS_DIR . '/selectivizr-min.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update

	}

	// Modernizr (custom production version)
	wp_enqueue_script( 'modernizr-custom', ctfw_theme_url( CTFW_THEME_JS_DIR . '/modernizr.custom.js' ), false, CTFW_THEME_VERSION ); // bust cache on theme update

	// Backstretch
	wp_enqueue_script( 'jquery-backstretch', ctfw_theme_url( CTFW_THEME_JS_DIR . '/jquery.backstretch.min.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update

	// Superfish Menu
	wp_enqueue_script( 'hoverIntent' ); // packaged with WordPress
	wp_enqueue_script( 'superfish', ctfw_theme_url( CTFW_THEME_JS_DIR . '/superfish.min.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update
	wp_enqueue_script( 'supersubs', ctfw_theme_url( CTFW_THEME_JS_DIR . '/supersubs.js' ), array( 'jquery', 'superfish' ), CTFW_THEME_VERSION ); // bust cache on theme update

	// SelectNav.js (converts Superfish menu into <select> for small screens)
	wp_enqueue_script( 'selectnav', ctfw_theme_url( CTFW_THEME_JS_DIR . '/selectnav.min.js' ), false, CTFW_THEME_VERSION ); // bust cache on theme update

	// Flexslider
	if ( is_page_template( CTFW_THEME_PAGE_TPL_DIR . '/homepage.php' ) ) {
		wp_enqueue_script( 'jquery-flexslider', ctfw_theme_url( CTFW_THEME_JS_DIR . '/jquery.flexslider-min.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update
	}

	// debouncedresize
	if ( is_page_template( CTFW_THEME_PAGE_TPL_DIR . '/homepage.php' ) || is_singular( 'ctc_sermon' ) ) {
		wp_enqueue_script( 'jquery-debouncedresize', ctfw_theme_url( CTFW_THEME_JS_DIR . '/jquery.debouncedresize.min.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update
	}

	// jQuery Masonry
 	// Use theme's jQuery Masonry 2 vs WordPress's Masonry 3
 	// New version of Masonry and shiv included with WordPress do not make it backward compatible with Resurrect's implementation
 	// To Do: Update Resurrect to work with Masonry 3
	if ( is_page_template( CTFW_THEME_PAGE_TPL_DIR . '/homepage.php' ) ) {
		//wp_enqueue_script( 'jquery-masonry' );
		wp_enqueue_script( 'jquery-masonry2', ctfw_theme_url( CTFW_THEME_JS_DIR . '/jquery.masonry.min.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update
	}

	// Single Post
	if ( is_singular() ) { // single post or page

		// comment-reply.js to cause comment form to show below a comment when replying to a comment
		wp_enqueue_script( 'comment-reply' );

		// Comment Validation with jQuery Plugin
		if ( is_singular() ) { // single post
			wp_enqueue_script( 'jquery-validate', ctfw_theme_url( CTFW_THEME_JS_DIR . '/jquery.validate.min.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update
		}

		// Smooth Scroll - comment and video/audio scroll down
		wp_enqueue_script( 'jquery-smooth-scroll', ctfw_theme_url( CTFW_THEME_JS_DIR . '/jquery.smooth-scroll.min.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update

	}

	// jQuery Cookie
	// Used for "View Full Site" responsive link in footer
	// Note: Filename is changed default name triggers OUTDATED default mod_security rules: https://github.com/carhartl/jquery-cookie/issues/10
	// This explains the issue: http://docs.woothemes.com/document/jquery-cookie-fails-to-load/
	wp_enqueue_script( 'jquery-cookie', ctfw_theme_url( CTFW_THEME_JS_DIR . '/jquery_cookie.min.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update

	// Main JS
	wp_enqueue_script( 'resurrect-main', ctfw_theme_url( CTFW_THEME_JS_DIR . '/main.js' ), array( 'jquery' ), CTFW_THEME_VERSION ); // bust cache on theme update

	// Theme data for JavaScript
	wp_localize_script( 'resurrect-main', 'resurrect_main', array( // pass WP data into JS from this point on
		'site_path'							=> ctfw_site_path(),
		'home_url'							=> home_url(),
		'is_ssl'							=> is_ssl(),
		'current_protocol'					=> ctfw_current_protocol(),
		'background_image_url'				=> set_url_scheme( get_background_image() ), // the saved custom image or the default image
		'background_image_fullscreen'		=> ctfw_customization( 'background_image_fullscreen' ),
		'mobile_menu_label'					=> _x( 'Menu', 'menu dropdown', 'resurrect' ),
		'slider_slideshow'					=> ctfw_customization( 'slider_slideshow' ),
		'slider_speed'						=> absint( ctfw_customization( 'slider_speed' ) * 1000 ), // convert seconds to milliseconds
		'comment_name_required'				=> get_option('require_name_email'), // name and email required on comments? (WP Admin: Settings > Discussion)
		'comment_email_required'			=> get_option('require_name_email'),
		'comment_name_error_required'		=> __( 'Required', 'resurrect' ), // translatable string for comment form validation
		'comment_email_error_required'		=> __( 'Required', 'resurrect' ),
		'comment_email_error_invalid'		=> __( 'Invalid Email', 'resurrect' ),
		'comment_url_error_invalid'			=> __( 'Invalid URL', 'resurrect' ),
		'comment_message_error_required'	=> __( 'Comment Required', 'resurrect' )
	));

}

add_action( 'wp_enqueue_scripts', 'resurrect_enqueue_scripts' ); // front-end only
