<?php
/**
 * Plugin Name: Opal Estate Custom Fields
 * Plugin URI: http://www.wpopal.com/opal-estate
 * Description: This plugin allows you control and manage fields to disable as meta information and using for searchable..
 * Version: 1.0.4
 * Author: WPOPAL
 * Author URI: http://www.wpopal.com
 * Requires at least: 4.9
 * Tested up to: 5.2.3
 *
 * Text Domain: opal-estate-custom-fields
 * Domain Path: languages/
 *
 * @package  opalestate-custom-fields
 * @category Plugins
 * @author   WPOPAL
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Opal Packages only works with WordPress 4.9 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.9', '<' ) ) {
	/**
	 * Prints an update nag after an unsuccessful attempt to active
	 * Opal Packages on WordPress versions prior to 4.6.
	 *
	 * @global string $wp_version WordPress version.
	 */
	function opalestate_custom_fields_wordpress_upgrade_notice() {
		$message = sprintf( esc_html__( 'Opal Estate Custom Fields requires at least WordPress version 4.9, you are running version %s. Please upgrade and try again!', 'opal-estate-custom-fields' ),
			$GLOBALS['wp_version'] );
		printf( '<div class="error"><p>%s</p></div>', $message ); // WPCS: XSS OK.

		deactivate_plugins( [ 'opalestate_custom_fields/opalestate_custom_fields.php' ] );
	}

	add_action( 'admin_notices', 'opalestate_custom_fields_wordpress_upgrade_notice' );

	return;
}

/**
 * And only works with PHP 5.6 or later.
 */
if ( version_compare( phpversion(), '5.6', '<' ) ) {
	/**
	 * Adds a message for outdate PHP version.
	 */
	function opalestate_custom_fields_php_upgrade_notice() {
		$message = sprintf( esc_html__( 'Opal Estate Custom Fields requires at least PHP version 5.6 to work, you are running version %s. Please contact to your administrator to upgrade PHP version!',
			'opal-estate-custom-fields'
		),
			phpversion() );
		printf( '<div class="error"><p>%s</p></div>', $message ); // WPCS: XSS OK.

		deactivate_plugins( [ 'opalestate_custom_fields/opalestate_custom_fields.php' ] );
	}

	add_action( 'admin_notices', 'opalestate_custom_fields_php_upgrade_notice' );

	return;
}

if ( defined( 'OPALESTATE_CUSTOM_FIELDS_VERSION' ) ) {
	return;
}

define( 'OPALESTATE_CUSTOM_FIELDS_VERSION', '1.0.4' );
define( 'OPALESTATE_CUSTOM_FIELDS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'OPALESTATE_CUSTOM_FIELDS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Admin notice: Require OpalEstate.
 */
function opalestate_custom_fields_admin_notice() {
	if ( ! class_exists( 'OpalEstate' ) ) {
		echo '<div class="error">';
		echo '<p>' . __( 'Please note that the <strong>Opal Estate Custom Fields</strong> plugin is meant to be used only with the <strong>Opal Estate Pro</strong> plugin.</p>', 'opal-estate-custom-fields' );
		echo '</div>';
	}
}

/**
 * Is activatable?
 *
 * @return bool
 */
function is_opalestate_custom_fields_activatable() {
	return class_exists( 'OpalEstate' );
}

add_action( 'plugins_loaded', function () {
	if ( is_opalestate_custom_fields_activatable() ) {
		// Include the loader.
		require_once dirname( __FILE__ ) . '/loader.php';

		$GLOBALS['opalestate_custom_fields'] = Opalestate_Custom_Fields::get_instance();
	}
	add_action( 'admin_notices', 'opalestate_custom_fields_admin_notice', 4 );
} );


