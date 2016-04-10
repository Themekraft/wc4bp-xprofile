<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AJAX endpoint to retrieve a list of categories with names containing a given search term
 */
function wc4bp_xprofile_search_categories() {
	global $wpdb;

	ob_start();

	check_ajax_referer( 'search-categories', 'security' );

	$term = (string) wc_clean( stripslashes( $_GET['term'] ) );
	if ( empty( $term ) ) {
		die();
	}

	$like_term = '%' . $wpdb->esc_like( $term ) . '%';

	$query = $wpdb->prepare(
		"SELECT terms.term_id, terms.name FROM {$wpdb->terms} terms " .
		"JOIN {$wpdb->term_taxonomy} taxonomy ON terms.term_id = taxonomy.term_id " .
		"WHERE terms.name LIKE %s AND taxonomy.taxonomy = 'product_cat'",
		$like_term );

	if ( ! empty( $_GET['limit'] ) ) {
		$query .= " LIMIT " . intval( $_GET['limit'] );
	}

	$terms = $wpdb->get_results( $query );

	$found_categories = array();

	if ( ! empty( $terms ) ) {
		foreach ( $terms as $term ) {
			$found_categories[ $term->term_id ] = rawurldecode( $term->name );
		}
	}

	wp_send_json( $found_categories );
}

add_action( 'wp_ajax_wc4bp_xprofile_search_categories', 'wc4bp_xprofile_search_categories' );
