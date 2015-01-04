<?php
/**
 * Feature Name: Save Meta Box
 * Descriptions: Saves the data of the input from the metabox
 * Version:      1.0
 * Author:       Inpsyde GmbH for MarketPress
 * Author URI:   http://inpsyde.com
 * Licence:      GPLv3
 */

/**
 * Saves the metabox content
 * 
 * @return	void
 */
function wcpd_save_meta_box() {

	// validate input
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;
	if ( 0 >= count( $_POST ) )
		return;
	if ( ! isset( $_POST[ 'post_type' ] ) || 'documentations' != $_POST[ 'post_type' ] )
		return;
	if ( ! current_user_can( 'edit_post', $_POST[ 'ID' ] ) )
		return;

	// Save the product id
	if ( isset( $_POST[ 'linked_product_id' ] ) && '' != trim( $_POST[ 'linked_product_id' ] ) )
		update_post_meta( $_POST[ 'ID' ], 'linked_product_id', $_POST[ 'linked_product_id' ] );
	else
		delete_post_meta( $_POST[ 'ID' ], 'linked_product_id' );
}
