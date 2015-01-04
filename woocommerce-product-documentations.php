<?php
/**
 * Plugin Name: WooCommerce Product Documentations
 * Description: This plugin provides a documentations for each product through a Custom Post Type
 * Version:     1.0
 * Author:      Inpsyde GmbH for MarketPress
 * Author URI:  http://inpsyde.com
 * Licence:     GPLv3
 */

// check wp
if ( ! function_exists( 'add_action' ) )
	return;

/**
 * Inits the plugins, loads all the files
 * and registers all actions and filters
 *
 * @wp-hook	plugins_loaded
 * @return	void
 */
function wcpd_init() {

	// define needed constants
	define( 'WCPD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	define( 'WCPD_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
	define( 'WCPD_BASEFILE', plugin_basename( __FILE__ ) );

	// localization
	load_plugin_textdomain( 'wcpd', FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	// set the directory
	$application_directory = dirname( __FILE__ );

	// include the helpers
	require_once( $application_directory . '/application/helper.php' );
	add_action( 'wp_ajax_wcpd_get_product', 'wcpd_get_product' );
	add_action( 'wp_ajax_wcpd_get_products', 'wcpd_get_products' );

	// include and load the post type
	require_once( $application_directory . '/application/custom-post-type.php' );
	add_action( 'init', 'wcpd_register_post_type' );

	// frontend stuff
	if ( ! is_admin() ) {
		// adds the fied to the variations
		require_once( $application_directory . '/application/frontend/add-tab.php' );
		add_action( 'woocommerce_product_tabs', 'wcpd_frontend_add_tab' );
	}

	// we only need this plugin in the backend
	// the frontend will be displayed by the theme
	// so we return, if we are not in the admin area
	if ( ! is_admin() )
		return;

	// scripts
	require_once( $application_directory . '/application/backend/script.php' );
	add_action( 'admin_enqueue_scripts', 'wcpd_admin_enqueue_scripts' ); 

	// style
	require_once( $application_directory . '/application/backend/style.php' );
	add_action( 'admin_enqueue_scripts', 'wcpd_admin_enqueue_styles' ); 

	// adds the metabox
	require_once( $application_directory . '/application/backend/documentations-meta-box.php' );
	add_action( 'add_meta_boxes', 'wcpd_add_meta_boxes' );

	require_once( $application_directory . '/application/backend/save-meta-box.php' );
	add_action( 'save_post', 'wcpd_save_meta_box' );

} add_action( 'plugins_loaded', 'wcpd_init' );
