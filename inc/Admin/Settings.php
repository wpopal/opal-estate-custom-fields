<?php
namespace Opalestate_Custom_Fields\Admin;

class Settings {
	/**
	 * Opalestate_Custom_Fields_Settings constructor.
	 */
	public function __construct() {
		add_filter( 'opalestate_settings_tabs', [ $this, 'setting_tabs' ], 1, 1 );

		add_filter( 'opalestate_registered_short_meta_settings', [ $this, 'registered_short_meta_settings' ], 1, 1 );
		add_filter( 'opalestate_registered_searcharea_settings', [ $this, 'registered_searcharea_settings' ], 1, 1 );

		add_action( "wp_ajax_setting_search", [ __CLASS__, 'ajax_search_field' ] );
		add_action( "wp_ajax_nopriv_setting_search", [ __CLASS__, 'ajax_search_field' ] );

	}

	public function ajax_search_field() {

		$metas = Opalestate_PostType_Property::metaboxes_info_fields();

		$metabox_key = [];

		if ( $metas ) {
			foreach ( $metas as $meta_item ) {
				$metabox_key[] = $meta_item['id'] . '_opt';
				$metabox_key[] = $meta_item['id'] . '_opt_v';
			}
		}

		echo json_encode( [ 'data' => $metabox_key ] );
		exit;

	}

	public function registered_searcharea_settings( $settings ) {

		$new_setting_fields = [];

		$new_setting_fields[] = [
			'name' => __( 'Setting type fields search', 'opal-et-field-creator' ),
			'desc' => __( 'Setting type fields search', 'opal-et-field-creator' ) . '<hr>',
			'type' => 'opalestate_title',
			'id'   => 'opalestate_title_general_settings_type_search',
		];

		$metas       = Opalestate_PostType_Property::metaboxes_info_fields();
		$metabox_key = [];

		if ( $metas ) {
			foreach ( $metas as $meta_item ) {

				if ( $meta_item['id'] != OPALESTATE_PROPERTY_PREFIX . 'areasize' ) {
					$metabox_key[] = $meta_item['id'] . '_opt';
				}
			}
		}

		wp_enqueue_script( "setting-search-field", OPALETFIELDS_PLUGIN_URL . 'assets/js/settings.js', [ 'jquery' ], "1.3", false );

		wp_localize_script( 'setting-search-field', 'myAjax', [ 'ajaxurl' => admin_url( 'admin-ajax.php' ) ] );

		$old_fields = [];

		if ( $settings['fields'] ) {
			foreach ( $settings['fields'] as $setting_field ) {

				if ( in_array( $setting_field['id'], $metabox_key ) ) {
					$old_fields[] = $setting_field;

					$new_setting_fields[] = [
						'name'        => __( 'Search type ', 'opal-et-field-creator' ) . $setting_field['name'],
						'description' => __( 'Multiple select', 'etfields' ),
						'options'     => [
							'select' => __( 'Select', 'opal-et-field-creator' ),
							'range'  => __( 'Range', 'opal-et-field-creator' ),
							'text'   => __( 'Text', 'opal-et-field-creator' ),
						],
						'id'          => $setting_field['id'] . '_search_type',
						'type'        => 'radio_inline',
						'default'     => 'select',
					];
					$new_setting_fields[] = [
						'name'        => __( 'Options select ', 'opal-et-field-creator' ) . $setting_field['name'],
						'description' => __( 'Options value select', 'etfields' ),
						'id'          => $setting_field['id'] . '_options_value',
						'type'        => 'text',
						'default'     => '1,2,3,4,5,6,7,8,9,10',
					];
					$new_setting_fields[] = [
						'name'        => __( 'Min range ', 'opal-et-field-creator' ) . $setting_field['name'],
						'description' => __( 'Min range', 'opal-et-field-creator' ),
						'id'          => $setting_field['id'] . '_min_range',
						'type'        => 'text',
						'default'     => 1,
					];
					$new_setting_fields[] = [
						'name'        => __( 'Max range ', 'opal-et-field-creator' ) . $setting_field['name'],
						'description' => __( 'Max range', 'opal-et-field-creator' ),
						'id'          => $setting_field['id'] . '_max_range',
						'type'        => 'text',
						'default'     => 10000000,
					];


				} else {
					$old_fields[] = $setting_field;
				}
			}
		}

		$settings['fields'] = array_merge( $old_fields, $new_setting_fields );

		return $settings;
	}


	public function setting_tabs( $tabs ) {
		$tabs['short_meta'] = __( 'Short meta', 'opal-et-field-creator' );

		return $tabs;
	}

	public function registered_short_meta_settings( $settings ) {

		$fields = [];

		$metas = Opalestate_PostType_Property::metaboxes_info_fields();

		$dmeta = [ 'amountrooms', 'bathrooms', 'bedrooms', 'parking' ];
		$dmeta = apply_filters( 'opalestate_property_meta_shortinfo_fields', $dmeta );

		foreach ( $metas as $key => $meta ) {
			$fields[] = [
				'name'    => $meta['name'],
				'id'      => $meta['id'] . '_short_meta',
				'type'    => 'select',
				'options' => [
					2 => __( 'Disable', 'opal-et-field-creator' ),
					1 => __( 'Enable', 'opal-et-field-creator' ),
				],
				'default' => in_array( str_replace( OPALESTATE_PROPERTY_PREFIX, '', $meta['id'] ), $dmeta ) ? 1 : 2,
			];
		}

		$settings = [
			'id'               => 'options_page',
			'opalestate_title' => __( 'Short meta', 'opal-et-field-creator' ),
			'show_on'          => [ 'key' => 'options-page', 'value' => [ 'opalestate_settings', ], ],
			'fields'           => $fields,
		];

		return $settings;
	}

}
