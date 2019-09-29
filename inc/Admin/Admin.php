<?php
namespace Opalestate_Custom_Fields\Admin;

class Admin {
	/**
	 * Admin constructor.
	 */
	public function __construct() {
		$this->register_admin_actions();
		$this->register_frontend_actions();
	}

	/**
	 * Register admin actions.
	 *
	 * @since 1.0
	 *
	 */
	public function register_admin_actions() {
		new Ajax();
		add_action( 'admin_init', [ $this, 'save_options' ] );
	}

	/**
	 * Register frontend actions.
	 *
	 * @since 1.0
	 *
	 */
	public function register_frontend_actions() {
		if ( is_admin() ) {
			add_action( 'admin_menu', [ $this, 'admin_menu' ], 8 );
		}
	}

	/**
	 * Register admin sub-menu page.
	 *
	 * @since 1.0
	 *
	 */
	public function admin_menu() {
		add_submenu_page( 'edit.php?post_type=opalestate_property', esc_html__( 'Custom Fields', 'opal-estate-custom-fields' ), esc_html__( 'Custom Fields', 'opal-estate-custom-fields' ),
			'manage_opalestate_settings', 'opal-estate-custom-fields',
			[ $this, 'render_page' ] );
	}

	/**
	 * Save options.
	 *
	 * Handler options and save them.
	 *
	 * @since 1.0
	 *
	 */
	public function save_options() {
		$form = new Create_Fields( 'opal_estate_custom_fields' );
		$form->save();
	}

	/**
	 * Render page.
	 *
	 * Display page with tabs.
	 *
	 * @since 1.0
	 *
	 */
	public function render_page() {
		echo '<div class="opaljob-settings-page">';
		echo '<p class="opaljob-settings-page-desc">' . esc_html__( 'Property builder using for show', 'opaljob' ) . '</p>';

		$form = new Create_Fields( 'opal_estate_custom_fields' );
		$form->render();

		echo '</div>';
	}
}
