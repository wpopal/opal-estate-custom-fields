<?php
namespace Opalestate_Custom_Fields;

class Handler {
	/**
	 * Handler constructor.
	 */
	public function __construct() {
		add_filter( 'opalestate_search_select_type_options', [ $this, 'change_value_options' ], 10, 3 );
	}

	/**
	 * Returns value options.
	 *
	 * @param $option_values
	 * @param $setting_search_type_options
	 * @param $field
	 *
	 * @return array
	 */
	public function change_value_options( $option_values, $setting_search_type_options, $field ) {
		$custom_fields_option = get_option( 'opal_estate_custom_fields', [] );
		if ( $custom_fields_option ) {
			$key = array_search( $field, array_column( $custom_fields_option, 'id' ) );

			if ( false !== $key ) {
				if ( isset( $custom_fields_option[ $key ]['options'] ) && $custom_fields_option[ $key ]['options'] ) {
					$option_values = $custom_fields_option[ $key ]['options'];
				}
			}
		}

		return $option_values;
	}
}
