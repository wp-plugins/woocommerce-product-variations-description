<?php
/**
 * Feature Name: Custom Post Type
 * Descriptions: Registers the custom post type and its dependencies
 * Version:      1.0
 * Author:       Inpsyde GmbH for MarketPress
 * Author URI:   http://inpsyde.com
 * Licence:      GPLv3
 */

/**
 * Registers the custom post type
 * 
 * @wp-hook	init
 * @return	void
 */
function wcpd_register_post_type() {

	register_post_type( 'documentations', array(
		'labels'       => array(
			'name'               => __( 'Documentations', 'wcpd' ),
			'singular_name'      => __( 'Documentation', 'wcpd' ),
			'add_new'            => __( 'Add New Documentation', 'wcpd' ),
			'add_new_item'       => __( 'Add New Documentation', 'wcpd' ),
			'edit_item'          => __( 'Edit Documentation', 'wcpd' ),
			'new_item'           => __( 'New Documentation', 'wcpd' ),
			'view_item'          => __( 'View Documentation', 'wcpd' ),
			'search_items'       => __( 'Search Documentations', 'wcpd' ),
			'not_found'          => __( 'No Documentations found', 'wcpd' ),
			'not_found_in_trash' => __( 'No Documentations found in Trash', 'wcpd' ),
		),
		'hierarchical' => TRUE,
		'public'       => TRUE,
		'has_archive'  => TRUE,
		'show_in_menu' => 'edit.php?post_type=product',
		'supports'     => array(
			'title',
			'editor',
			'revisions',
			'page-attributes'
		)
	) );
}
