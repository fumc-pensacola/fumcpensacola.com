<?php
/**
 * Search form
 *
 * Provides contents of get_search_form() for the search widget
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<div class="resurrect-search-form">
	<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label class="resurrect-assistive-text"><?php _e( 'Search', 'resurrect' ); ?></label>
		<div class="resurrect-search-field">
			<input type="text" name="s" />
		</div>
		<a href="#" class="resurrect-search-button <?php resurrect_icon_class( 'search-button' ); ?>"></a>
	</form>
</div>