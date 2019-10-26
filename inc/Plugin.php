<?php
namespace Opalestate_Custom_Fields;

use Opalestate_Custom_Fields\Admin\Admin;
use Opalestate_Custom_Fields\Admin\Metaboxes;

/**
 * Set up and initialize
 */
class Plugin {
	/**
	 *  The instance.
	 *
	 * @var void
	 */
	private static $instance;

	/**
	 * Returns the instance.
	 */
	public static function get_instance() {

		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Actions setup
	 */
	public function __construct() {
		$this->register_admin();
		$this->register_core();

		add_action( 'plugins_loaded', [ $this, 'i18n' ], 3 );
	}

	/**
	 * Register admin.
	 */
	public function register_admin() {
		new Admin();
		new Metaboxes();
	}

	/**
	 * Register core.
	 */
	public function register_core() {
		new Handler();
	}

	/**
	 * Translations.
	 */
	public function i18n() {
		load_plugin_textdomain( 'opal-estate-custom-fields', false, 'opal-estate-custom-fields/languages' );
	}
}
