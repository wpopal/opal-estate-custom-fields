<?php

function opalestate_custom_fields_get_cmb2_field_type( $field_type ) {
	switch ( $field_type ) {
		case 'text':
		case 'textarea':
		case 'checkbox':
		case 'select':
			$type = $field_type;
			break;
		case 'date':
			$type = 'datepicker';
			break;
		default:
			$type = 'text';
	}

	return $type;
}

function opalestate_custom_fields_parse_setting_field( $setting ) {
	$defaults = apply_filters( 'opalestate_custom_fields_parse_setting_fields', [
		'type'                => '',
		'id'                  => '',
		'name'                => '',
		'options'             => [],
		'description'         => '',
		'default'             => '',
		'default_value_index' => '',
		'multiple'            => '',
		'number'              => '',
		'required'            => '',
	] );

	$setting = wp_parse_args( $setting, $defaults );

	return $setting;
}
