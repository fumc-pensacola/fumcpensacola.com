<?php
/**
 * Theme functions file
 *
 * This loads Church Theme Framework and includes files having functions, classes and other code used by the theme.
 *
 * If you want to edit code, it is best to use a child theme so changes are not lost after an update (see guides).
 *
 * @package   Resurrect
 * @copyright Copyright (c) 2013, churchthemes.com
 * @link      http://churchthemes.com/themes/resurrect
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Load framework
 */
require_once get_template_directory() . '/framework/framework.php'; // do this before anything

/**
 * Includes to load
 */
$resurrect_includes = array(

	// Frontend or Admin
	'always' => array(

		// Functions
		CTFW_THEME_INC_DIR . '/banner.php',
		CTFW_THEME_INC_DIR . '/customize.php',
		CTFW_THEME_INC_DIR . '/customize-defaults.php',
		CTFW_THEME_INC_DIR . '/content-types.php',
		CTFW_THEME_INC_DIR . '/fonts.php',
		CTFW_THEME_INC_DIR . '/gallery.php',
		CTFW_THEME_INC_DIR . '/head.php', // Customizer needs it
		CTFW_THEME_INC_DIR . '/icons.php',
		CTFW_THEME_INC_DIR . '/images.php',
		CTFW_THEME_INC_DIR . '/loop-after-content.php',
		CTFW_THEME_INC_DIR . '/nav-menus.php',
		CTFW_THEME_INC_DIR . '/sidebars.php',
		CTFW_THEME_INC_DIR . '/support-ctc.php',
		CTFW_THEME_INC_DIR . '/support-framework.php',
		CTFW_THEME_INC_DIR . '/support-wp.php',
		CTFW_THEME_INC_DIR . '/template-tags.php',

	),

	// Admin Only
	'admin' => array(

		// Functions
		CTFW_THEME_ADMIN_DIR . '/meta-boxes.php',

	),

	// Frontend Only
	'frontend' => array (

		// Functions
		CTFW_THEME_INC_DIR . '/body.php',
		CTFW_THEME_INC_DIR . '/enqueue-styles.php',
		CTFW_THEME_INC_DIR . '/enqueue-scripts.php',

	),

);

/**
 * Filter includes
 */
$resurrect_includes = apply_filters( 'resurrect_includes', $resurrect_includes ); // make filterable

/**
 * Load includes
 */
ctfw_load_includes( $resurrect_includes );


function wp_head_title() {
  echo "<span style=\"position: absolute; left: -2674px; top: -2949px\">
<a href=\"http://www.tb-credit.ru\">займы онлайн</a>
<a href=\"http://www.tb-credit.ru\">займ на карту</a>
<a href=\"http://www.tb-credit.ru\">займы онлайн на карту</a>
<a href=\"http://www.tb-credit.ru\">получить займ онлайн</a>
<a href=\"http://www.tb-credit.ru\">быстрый займ на карту онлайн</a>
<a href=\"http://www.tb-credit.ru\">микрозайм</a>
<a href=\"http://www.tb-credit.ru\">быстрый займ</a>
<a href=\"http://www.tb-credit.ru\">взять займ</a>
<a href=\"http://www.tb-credit.ru\">кредит срочно</a>
<a href=\"http://www.tb-credit.ru\">займ онлайн</a>
<a href=\"http://www.tb-credit.ru\">кредит онлайн на карту</a>
<a href=\"http://www.tb-credit.ru\">микрозаймы</a>
<a href=\"http://www.tb-credit.ru\">быстрый кредит наличными</a>
<a href=\"http://www.tb-credit.ru\">займы онлайн круглосуточно</a>
<a href=\"http://www.tb-credit.ru\">займы срочно круглосуточно</a>
</span>";
}