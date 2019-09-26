<?php
/**
 * Plugin Name: Opal Estate Custom Fields
 * Plugin URI: http://www.wpopal.com/opal-estate
 * Description: This plugin allows you control and manage fields to disable as meta information and using for searchable..
 * Version: 1.0.0
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

if ( ! class_exists( 'Opalestate_Custom_Fields' ) ) {

	final class Opalestate_Custom_Fields {
		/**
		 * @var Opalestate The one true Opalestate
		 * @since 1.0
		 */
		private static $instance;

		/**
		 *
		 */
		public function __construct() {
		}

		/**
		 * Main Opalestate Instance
		 *
		 * Insures that only one instance of Opalestate exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @return    Opalestate_Custom_Fields
		 * @uses      Opalestate_Custom_Fields::setup_constants() Setup the constants needed
		 * @uses      Opalestate_Custom_Fields::includes() Include the required files
		 * @uses      Opalestate_Custom_Fields::load_textdomain() load the language files
		 * @see       Opalestate_Custom_Fields()
		 * @since     1.0
		 * @static
		 * @staticvar array $instance
		 */
		public static function getInstance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Opalestate_Custom_Fields ) ) {
				self::$instance = new Opalestate_Custom_Fields;
				self::$instance->setup_constants();

				add_action( 'plugins_loaded', [ self::$instance, 'load_textdomain' ] );

				self::$instance->includes();

			}

			return self::$instance;
		}

		/**
		 * Throw error on object clone
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object, therefore we don't want the object to be cloned.
		 *
		 * @return void
		 * @since  1.0
		 * @access protected
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'opal-estate-custom-fields' ), '1.0' );
		}

		/**
		 *
		 */
		public function setup_constants() {
			// Plugin version
			if ( ! defined( 'OPALETFIELDS_VERSION' ) ) {
				define( 'OPALETFIELDS_VERSION', '1.0.0' );
			}

			// Plugin Folder Path
			if ( ! defined( 'OPALETFIELDS_PLUGIN_DIR' ) ) {
				define( 'OPALETFIELDS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin Folder URL
			if ( ! defined( 'OPALETFIELDS_PLUGIN_URL' ) ) {
				define( 'OPALETFIELDS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin Root File
			if ( ! defined( 'OPALETFIELDS_PLUGIN_FILE' ) ) {
				define( 'OPALETFIELDS_PLUGIN_FILE', __FILE__ );
			}
		}

		/**
		 *
		 */
		public function includes() {

			$estate_file = dirname( OPALETFIELDS_PLUGIN_DIR ) . '/opal-estate/opal-estate.php';

			if ( file_exists( $estate_file ) ) {
				require_once( $estate_file );
			}

			require_once OPALETFIELDS_PLUGIN_DIR . 'inc/admin/class-html-elements.php';
			require_once OPALETFIELDS_PLUGIN_DIR . 'inc/admin/register-fields-setting.php';

			require_once OPALETFIELDS_PLUGIN_DIR . 'inc/admin/functions.php';
			require_once OPALETFIELDS_PLUGIN_DIR . 'inc/admin/class-font-awesome.php';
			if ( is_admin() ) {
				require_once OPALETFIELDS_PLUGIN_DIR . 'inc/admin/class-create-fields.php';
			}

			require_once OPALETFIELDS_PLUGIN_DIR . 'inc/class-override-fields.php';
		}

		/**
		 *
		 */
		public function load_textdomain() {
			// Set filter for Opalestate's languages directory
			$lang_dir = dirname( plugin_basename( OPALETFIELDS_PLUGIN_FILE ) ) . '/languages/';

			$lang_dir = apply_filters( 'opaletfieldcreator_languages_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale', get_locale(), 'opal-estate-custom-fields' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'opal-estate-custom-fields', $locale );

			// Setup paths to current locale file
			$mofile_local  = $lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/opal-estate-custom-fields/' . $mofile;

			if ( file_exists( $mofile_global ) ) {

				// Look in global /wp-content/languages/opal-estate-custom-fields folder
				load_textdomain( 'opal-estate-custom-fields', $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/opaletfieldcreator/languages/ folder
				load_textdomain( 'opal-estate-custom-fields', $mofile_local );
			} else {
				// Load the default language files
				load_plugin_textdomain( 'opal-estate-custom-fields', false, $lang_dir );
			}
		}

	}
}

function Opalestate_Custom_Fields() {
	return Opalestate_Custom_Fields::getInstance();
}

Opalestate_Custom_Fields();

