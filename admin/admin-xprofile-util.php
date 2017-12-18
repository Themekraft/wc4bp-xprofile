<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Retrieve product names for a list of product IDs
 */
function wc4bp_xprofile_fetch_product_names( $product_ids ) {
	$product_data = array();

	foreach ( $product_ids as $product_id ) {
		$product = wc_get_product( $product_id );
		if ( is_object( $product ) ) {
			$product_data[ $product_id ] = wp_kses_post( html_entity_decode(
				$product->get_formatted_name(), ENT_QUOTES, get_bloginfo( 'charset' ) ) );
		}
	}

	return $product_data;
}

/**
 * Retrieve category names for a list of category IDs
 */
function wc4bp_xprofile_fetch_category_names( $category_ids ) {
	$category_data = array();

	foreach ( $category_ids as $category_id ) {
		$term = get_term( $category_id );
		if ( is_object( $term ) && $term->taxonomy == 'product_cat' ) {
			$category_data[ $category_id ] = wp_kses_post( html_entity_decode(
				$term->name, ENT_QUOTES, get_bloginfo( 'charset' ) ) );
		}
	}

	return $category_data;
}

/**
 * Check whether a particular XProfile group exists
 */
function wc4bp_xprofile_group_exists( $group_id ) {
	$group = BP_XProfile_Group::get( array( 'profile_group_id' => $group_id ) );

	// empty() called on variable for compatibility with PHP 5.2.x
	return ! empty( $group );
}

/**
 * Create or re-use a nonce with the given name
 */
function wc4bp_xprofile_get_nonce( $name ) {
	static $nonces = array();

	if ( isset( $nonces[ $name ] ) ) {
		return $nonces[ $name ];
	}

	return $nonces[ $name ] = wp_create_nonce( $name );
}
