<?php
namespace Opalestate_Custom_Fields\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ajax {
	/**
	 * Ajax constructor.
	 */
	public function __construct() {
		add_action( 'wp_ajax_creator_custom_type', [ $this, 'creator_custom_type' ] );
		add_action( 'wp_ajax_nopriv_creator_custom_type', [ $this, 'creator_custom_type' ] );
		add_action( 'wp_ajax_create_option_select', [ $this, 'create_option_select' ] );
		add_action( 'wp_ajax_nopriv_create_option_select', [ $this, 'create_option_select' ] );
	}

	/**
	 * Create custom type via AJAX.
	 */
	public function creator_custom_type() {
		$type     = sanitize_text_field( $_POST['type'] );
		$elements = new Elements();
		ob_start();

		switch ( $type ) {
			case 'textarea':
				$elements->textarea();
				break;
			case 'select':
				$elements->select();
				break;
			case 'checkbox';
				$elements->checkbox();
				break;
			case 'date':
				$elements->date();
				break;
			case 'text':
			default:
				$elements->text();
				break;
		}

		$html = ob_get_contents();
		ob_end_clean();

		$result = [ 'type' => 'success', 'html' => $html ];

		echo json_encode( $result );
		exit;
	}

	/**
	 * Create option select via AJAX.
	 */
	public function create_option_select() {
		if ( isset( $_POST['index'] ) && isset( $_POST['checked_default'] ) && isset( $_POST['option_index'] ) ) {
			$args = [
				'index'           => sanitize_text_field( $_POST['index'] ),
				'checked_default' => sanitize_text_field( $_POST['checked_default'] ),
				'option_index'    => sanitize_text_field( $_POST['option_index'] ),
			];

			$elements = new Elements();

			ob_start();
			$elements->select_option( $args );
			$html = ob_get_contents();
			ob_end_clean();

			$result = [ 'type' => 'success', 'html' => $html ];
		} else {
			$result = [ 'type' => 'fail', 'html' => '' ];
		}

		echo json_encode( $result );
		exit;
	}
}
