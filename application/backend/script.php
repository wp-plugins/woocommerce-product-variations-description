<?php
/**
 * Feature Name: Scripts
 * Descriptions: Registers the scripts
 * Version:      1.0
 * Author:       Inpsyde GmbH for MarketPress
 * Author URI:   http://inpsyde.com
 * Licence:      GPLv3
 */

/**
 * Enqueue scripts.
 *
 * @wp-hook	admin_enqueue_scripts
 * @return	void
 */
function wcpd_admin_enqueue_scripts() {

	$scripts = wcpd_get_scripts();
	foreach ( $scripts as $handle => $script ) {
		wp_enqueue_script(
			$handle,
			$script[ 'src' ],
			$script[ 'deps' ],
			$script[ 'version' ],
			$script[ 'in_footer' ]
		);

		// checking for localize script args
		if ( array_key_exists( 'localize', $script ) && !empty( $script[ 'localize' ] ) )
			foreach( $script[ 'localize' ] as $name => $args )
				wp_localize_script(
					$handle,
					$name,
					$args
				);
	}
}

/**
 * Returning our Scripts
 *
 * @return  array
 */
function wcpd_get_scripts() {

	$suffix      = wcpd_get_script_suffix();
	$plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/' . WCPD_BASEFILE );
	$version     = $plugin_data[ 'Version' ];

	// adding the main-js
	$scripts[ 'admin-js' ] = array(
		'src'       => wcpd_get_asset_directory_url( 'js' ) . 'admin' . $suffix . '.js',
		'deps'      => array( 'jquery' ),
		'version'   => $version,
		'in_footer' => TRUE,
		'localize'  => array(
			'wpcd_admin_args' => array(
				'lang_search_for_product' => __( 'Search for a product here', 'wpcd' )
			),
		)
	);

	// adding the select2
	$scripts[ 'select2' ] = array(
		'src'       => wcpd_get_asset_directory_url( 'js' ) . 'select2' . $suffix . '.js',
		'deps'      => array( 'jquery' ),
		'version'   => $version,
		'in_footer' => TRUE
	);

	// select2 locale
	$locale = substr( get_locale(), 0, 2 );
	$select2_locale_file = 'select2_locale_' . $locale . '.js';
	$select2_locale_file_path = wcpd_get_asset_directory( 'js/select2-localization' ) . $select2_locale_file;
	if ( file_exists( $select2_locale_file_path ) && is_file( $select2_locale_file_path ) )
		$select2_locale_file_uri = wcpd_get_asset_directory_url( 'js/select2-localization' ) . $select2_locale_file;
	else
		$select2_locale_file_uri = wcpd_get_asset_directory_url( 'js/select2-localization' ) . 'select2_locale_en.js';
	$scripts[ 'select2-l18n' ] = array(
		'src'       => $select2_locale_file_uri,
		'deps'      => array( 'jquery' ),
		'version'   => $version,
		'in_footer' => TRUE
	);

	return apply_filters( 'wcpd_get_scripts', $scripts );
}
