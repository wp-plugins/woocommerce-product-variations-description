<?php
/**
 * Feature Name: Helper
 * Descriptions: Here are some functions we need for the product documentations
 * Version:      1.0
 * Author:       Inpsyde GmbH for MarketPress
 * Author URI:   http://inpsyde.com
 * Licence:      GPLv3
 */

/**
 * Gets the id of the linked product ID
 * 
 * @param	int	$product_id the ID of the current product
 * @return	int the id of the documentation
 */
function wcpd_get_linked_product_id( $product_id ) {
	global $wpdb;
	$documentation_id = $wpdb->get_var( $wpdb->prepare( 'SELECT post_id FROM ' . $wpdb->postmeta . ' WHERE `meta_key` = "linked_product_id" AND `meta_value` = %d', $product_id ) );

	return $documentation_id;
}

/**
 * getting the Script and Style suffix for Kiel-Theme
 * Adds a conditional ".min" suffix to the file name when WP_DEBUG is NOT set to TRUE.
 *
 * @return	string
 */
function wcpd_get_script_suffix() {

	$script_debug = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
	$suffix = $script_debug ? '' : '.min';

	return $suffix;
}

/**
 * Gets the specific asset directory url
 *
 * @param	string $path the relative path to the wanted subdirectory. If
 *				no path is selected, the root asset directory will be returned
 * @return	string the url of the wcpd asset directory
 */
function wcpd_get_asset_directory_url( $path = '' ) {

	// set base url
	$wcpd_assets_url = WCPD_PLUGIN_URL . 'assets/';
	if ( $path != '' )
		$wcpd_assets_url .= $path . '/';
	return $wcpd_assets_url;
}

/**
 * Gets the specific asset directory path
 *
 * @param	string $path the relative path to the wanted subdirectory. If
 *				no path is selected, the root asset directory will be returned
 * @return	string the url of the wcpd asset directory
 */
function wcpd_get_asset_directory( $path = '' ) {

	// set base url
	$wcpd_assets = WCPD_PLUGIN_PATH . 'assets/';
	if ( $path != '' )
		$wcpd_assets .= $path . '/';
	return $wcpd_assets;
}

/**
 * AJAX Helper to get the products
 * 
 * @wp-hook	wp_ajax_wcpd_get_products
 * @return	void
 */
function wcpd_get_products() {
	global $wpdb;

	// set the data
	$search_term = '%' . $_REQUEST[ 'q' ] . '%';
	$results = array();

	// search the posts
	$search_query = $wpdb->prepare( 'SELECT * FROM ' . $wpdb->posts . ' WHERE `post_type` = "product" AND `post_status` = "publish" AND ( `post_title` LIKE "%s" OR `post_name` LIKE "%s" )', $search_term, strtolower( $search_term ) );
	$search_results = $wpdb->get_results( $search_query );

	// check  if we have results
	if ( ! empty( $search_results ) )
		foreach ( $search_results as $result )
			$results[] = array(
				'product_id' => $result->ID,
				'product_title' => $result->post_title
			);

	// encode this stuff to json
	echo json_encode( $results );
	exit;
}

/**
 * AJAX Helper to get the products
 * 
 * @wp-hook	wp_ajax_wcpd_get_product
 * @return	void
 */
function wcpd_get_product() {
	global $wpdb;

	// set the data
	$product_id = $_REQUEST[ 'product_id' ];
	$product = get_post( $product_id );
	$result = array(
		'product_id' => $product->ID,
		'product_title' => $product->post_title,
	);

	// encode this stuff to json
	echo json_encode( $result );
	exit;
}
