<?php
/**
 * Feature Name: Documentations Meta Box
 * Descriptions: Adds the metabox and its needed functions to the documentations overview
 * Version:      1.0
 * Author:       Inpsyde GmbH for MarketPress
 * Author URI:   http://inpsyde.com
 * Licence:      GPLv3
 */

/**
 * Adds the metabox to the documentations write panel
 * 
 * @wp-hook	add_meta_boxes
 * @return	void
 */
function wcpd_add_meta_boxes() {

	add_meta_box( 'link-to-product', __( 'Link to product', 'wcpd' ), 'wcpd_metabox_content', 'documentations', 'side', 'low' );
}

/**
 * Shows the content of the metabox
 * called at wcpd_add_meta_boxes
 * 
 * @return	void
 */
function wcpd_metabox_content() {

	?>
	<input type="hidden" id="linked_product_id" name="linked_product_id" value="<?php echo get_post_meta( get_the_ID(), 'linked_product_id', TRUE ); ?>" class="select2 select2-input-select search-products">
	<?php
}
