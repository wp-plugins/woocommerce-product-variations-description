<?php
/**
 * Feature Name: Style
 * Descriptions: Registers the styles
 * Version:      1.0
 * Author:       Inpsyde GmbH for MarketPress
 * Author URI:   http://inpsyde.com
 * Licence:      GPLv3
 */

/**
 * Enqueue styles and style.
 *
 * @wp-hook	admin_enqueue_scripts
 * @return	void
 */
function wcpd_admin_enqueue_styles() {

	$styles = wcpd_get_style();
	foreach ( $styles as $handle => $style ) {
		wp_enqueue_style(
			$handle,
			$style[ 'src' ],
			$style[ 'version' ]
		);
	}
}

/**
 * Returning our Scripts
 *
 * @return  array
 */
function wcpd_get_style() {

	$suffix      = wcpd_get_script_suffix();
	$plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/' . WCPD_BASEFILE );
	$version     = $plugin_data[ 'Version' ];

	// adding the admin
	$style[ 'admin' ] = array(
		'src'       => wcpd_get_asset_directory_url( 'css' ) . 'admin' . $suffix . '.css',
		'version'   => $version,
		'in_footer' => FALSE
	);

	// adding the select2
	$style[ 'select2' ] = array(
		'src'       => wcpd_get_asset_directory_url( 'css' ) . 'select2' . $suffix . '.css',
		'version'   => $version,
		'in_footer' => FALSE
	);

	return apply_filters( 'wcpd_get_style', $style );
}
