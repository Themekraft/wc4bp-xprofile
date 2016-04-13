<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wc4bp_xprofile_conditional_visibility_enabled( $object_id, $object_type ) {
	$enabled = bp_xprofile_get_meta( $object_id, $object_type, 'bf_xprofile_conditional_visibility_enabled' );

	return $enabled == '1';
}

function wc4bp_xprofile_conditional_visibility_products( $object_id, $object_type, $default = false ) {
	$product_ids = bp_xprofile_get_meta( $object_id, $object_type, 'bf_xprofile_conditional_visibility_products' );
	if ( empty( $product_ids ) ) {
		return $default;
	}

	return explode( ',', $product_ids );
}

function wc4bp_xprofile_conditional_visibility_categories( $object_id, $object_type, $default = false ) {
	$category_ids = bp_xprofile_get_meta( $object_id, $object_type, 'bf_xprofile_conditional_visibility_categories' );
	if ( empty( $category_ids ) ) {
		return $default;
	}

	return explode( ',', $category_ids );
}
