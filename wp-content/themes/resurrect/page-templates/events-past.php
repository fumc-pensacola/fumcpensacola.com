<?php
/**
 * Template Name: Events - Past
 *
 * This shows a page with custom loop after the content.
 *
 * content.php outputs the page content.
 * content-event.php outputs content for each post in the loop.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Query events that ended before today
function resurrect_events_past_loop_after_content() {

	return new WP_Query( array(
		'post_type'			=> 'ctc_event',
		'paged'				=> ctfw_page_num(), // returns/corrects $paged so pagination works on static front page
		'meta_query' => array(
			array(
				'key' => '_ctc_event_end_date', // the latest date that the event goes to (could be start date)
				'value' => date_i18n( 'Y-m-d' ), // today's date, localized
				'compare' => '<', // all events with start AND end date BEFORE today
				'type' => 'DATE'
			),
		),
		'meta_key' 			=> '_ctc_event_end_date', // want finish date first
		'orderby'			=> 'meta_value',
		'order'				=> 'DESC' // sort from most recently past to oldest
	) );

}

// Make query available via filter
add_filter( 'resurrect_loop_after_content_query', 'resurrect_events_past_loop_after_content' );

// Load main template to show the page
locate_template( 'index.php', true );