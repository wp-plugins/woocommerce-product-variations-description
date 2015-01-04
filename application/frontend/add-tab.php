<?php
/**
 * Feature Name: Add Tab
 * Descriptions: These functions are adding the new tab for the documentation
 * Version:      1.0
 * Author:       Inpsyde GmbH for MarketPress
 * Author URI:   http://inpsyde.com
 * Licence:      GPLv3
 */

/**
 * Adds the tab to the product write panel
 * 
 * @wp-hook	woocommerce_product_tabs
 * @return	void
 */
function wcpd_frontend_add_tab( $tabs ) {
	global $product;

	// only add documentation if we got one
	$documentation_id = wcpd_get_linked_product_id( $product->id );
	if ( $documentation_id == '' )
		return $tabs;

	$tabs[ 'documentation' ] = array(
		'title' 	=> __( 'Documentation', 'wcpcl' ),
		'priority' 	=> 50,
		'link'      => get_permalink( $documentation_id )
	);
	
	return $tabs;
}
