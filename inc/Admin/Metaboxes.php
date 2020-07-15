<?php
namespace Opalestate_Custom_Fields\Admin;

class Metaboxes {
	/**
	 * Settings.
	 *
	 * @var array
	 */
	public $settings = [];

	/**
	 * Metaboxes constructor.
	 */
	public function __construct() {
		$this->settings = get_option( 'opal_estate_custom_fields', [] );

		add_filter( 'opalestate_postype_property_metaboxes_fields_info', [ $this, 'register_property_metabox' ] );
		add_filter( 'opalestate_metaboxes_public_info_fields', [ $this, 'register_public_property_metabox' ] );
		add_filter( 'opalestate_property_meta_icon', [ $this, 'opalestate_property_meta_icon' ], 10, 2 );
	}

	/**
	 * Get settings.
	 *
	 * @return array
	 */
	public function get_settings() {
		return $this->settings;
	}

	/**
	 * Register public property metabox.
	 *
	 * @param array $fields Fields.
	 * @return array
	 */
	public function register_property_metabox( $fields ) {
		$settings = $this->get_settings();
		if ( ! $settings ) {
			return $fields;
		}

		foreach ( $settings as $setting ) {
			$field = $this->parse_setting_fields( $setting );
			if ( $field ) {
				$fields[] = $field;
			}
		}

		return $fields;
	}

	/**
	 * Register property metabox.
	 *
	 * @param array $fields Fields.
	 * @return array
	 */
	public function register_public_property_metabox( $fields ) {
		$settings = $this->get_settings();
		if ( ! $settings ) {
			return $fields;
		}

		$prefix = OPALESTATE_PROPERTY_PREFIX;
		foreach ( $fields as $key => $field ) {
			if ( "{$prefix}amountrooms" == $field['id'] ) {
				unset( $field['after_row'] );
				unset( $fields[ $key ] );
				$fields[] = $field;
			}
		}

		foreach ( $settings as $setting ) {
			$field = $this->parse_setting_fields( $setting );
			if ( $field ) {
				$fields[] = $field;
			}
		}

		return $fields;
	}

	/**
	 * Parse setting fields.
	 *
	 * @param array $setting Settings.
	 * @return array
	 */
	protected function parse_setting_fields( $setting ) {
		$field = [];
		if ( ! isset( $setting['type'] ) ) {
			return $field;
		}

		$setting = opalestate_custom_fields_parse_setting_field( $setting );
		$prefix  = OPALESTATE_PROPERTY_PREFIX;

		switch ( $setting['type'] ) {
			case 'text':
			case 'textarea':
			case 'date':
			case 'checkbox':

				$field = [
					'type'        => opalestate_custom_fields_get_cmb2_field_type( $setting['type'] ),
					'id'          => $prefix . $setting['id'],
					'name'        => $setting['name'],
					'description' => $setting['description'],
					'default'     => $setting['default'],
				];

				if ( 'checkbox' === $setting['type'] ) {
					$field['default'] = 'off' !== $setting['default'] ? $setting['default'] : '';
				} else {
					$field['default'] = $setting['default'];
				}

				$attributes = [];

				if ( $setting['number'] ) {
					$attributes['type'] = 'number';
				}

				if ( $setting['required'] ) {
					$attributes['required'] = 'required';
				}

				if ( $attributes ) {
					$field['attributes'] = $attributes;
				}

				break;

			case 'select':
				$field = [
					'type'        => opalestate_custom_fields_get_cmb2_field_type( $setting['type'] ),
					'id'          => $prefix . $setting['id'],
					'name'        => $setting['name'],
					'description' => $setting['description'],
					'required'    => $setting['required'],
					'default'     => $setting['default'],
					'options'     => $setting['options'],
				];

				break;
		}

		return $field;
	}

	public function opalestate_property_meta_icon( $icon, $key ) {
		$settings = $this->get_settings();

		$icons = [];
		foreach ( $settings as $setting ) {
			$icons[ $setting['id'] ] = $setting['icon'];
		}

		if ( array_key_exists( $key, $icons ) ) {
			$icon = $icons[ $key ];
		}

		return $icon;
	}
}
