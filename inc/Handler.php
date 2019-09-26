<?php
namespace Opalestate_Custom_Fields;

class Handler {

	public $meta = [];

	public $fields_override = [];

	public $new_setting_fields = [];

	public function __construct() {

		$meta_key_search_areasize = OPALESTATE_PROPERTY_PREFIX . 'areasize_opt';

		$this->fields_override = get_option( 'opal_etfields_fields' );

		if ( $this->fields_override ) {
			add_filter( 'opalestate_option_' . $meta_key_search_areasize, [ $this, 'opalestate_option_areasize' ], 1, 3 );

			add_filter( 'opalestate_property_render_search_label', [ $this, 'property_render_search_label' ], 1, 2 );
			add_filter( 'opalestate_get_search_results_query_args', [ $this, 'add_results_query_args' ], 1, 1 );

			add_filter( 'opalestate_property_render_search_field_template', [ $this, 'display_search_field' ], 1, 2 );

			add_filter( 'opalestate_loop_meta_info', [ $this, 'display_meta_field' ], 1 );
			add_filter( 'opalestate_single_meta_info', [ $this, 'display_meta_field' ], 1 );
			add_filter( 'opalestate_postype_property_metaboxes_fields_info', [ $this, 'display_admin_setting_fields' ], 1, 99 );
			add_filter( 'opalestate_property_field_value', [ $this, 'callback_property_field_value' ], 1, 3 );
			$this->set_meta_short_fields();
		}
	}

	public function opalestate_option_areasize( $value, $key, $default ) {
		$check_area_field_exist = false;

		if ( ! empty( $this->fields_override ) ) {
			foreach ( $this->fields_override as $field ) {

				if ( isset( $field['id'] ) ) {
					$field_id = $field['id'];
					if ( $field_id == 'areasize' ) {
						$check_area_field_exist = true;

						return $value;
					}
				}
			}

			if ( ! $check_area_field_exist ) {
				return 0;
			}
		}

		return $value;
	}

	public function property_render_search_label( $search_label, $key ) {
		if ( $key ) {
			$setting_field_name        = 'opalestate_ppt_' . $key . '_opt';
			$setting_search_type       = 'opalestate_ppt_' . $key . '_opt_search_type';
			$setting_search_query      = 'opalestate_ppt_' . $key . '_opt_search_query';
			$setting_search_query_type = opalestate_options( $setting_search_query, 'min' );

			if ( opalestate_options( $setting_field_name, 0 ) == 1 ) {
				$display_type_search = opalestate_options( $setting_search_type, 'select' );

				if ( $display_type_search == 'select' ) {

					if ( $setting_search_query_type == 'min' ) {

						$search_label = __( 'Min', 'opal-et-field-creator' ) . ' ' . $search_label;

					} elseif ( $setting_search_query_type == 'max' ) {

						$search_label = __( 'Max', 'opal-et-field-creator' ) . ' ' . $search_label;

					} else {
						// do nothing
					}

				} else {
					// range
				}

			}
		}

		return $search_label;
	}


	public function add_results_query_args( $args ) {

		$check_area_field_exist   = false;
		$meta_key_search_areasize = OPALESTATE_PROPERTY_PREFIX . 'areasize';

		if ( ! empty( $this->fields_override ) ) {
			foreach ( $this->fields_override as $field ) {

				if ( isset( $field['id'] ) ) {
					$field_id                    = $field['id'];
					$setting_field_name          = 'opalestate_ppt_' . $field_id . '_opt';
					$setting_search_type         = 'opalestate_ppt_' . $field_id . '_opt_search_type';
					$setting_search_type_options = $setting_field_name . '_options_value';

					if ( $field_id == 'areasize' ) {
						$check_area_field_exist = true;
						continue;
					}

					if ( opalestate_options( $setting_field_name, 0 ) == 1 ) {
						$display_type_search = opalestate_options( $setting_search_type, 'select' );

						$qvalue = isset( $_GET['info'][ $field_id ] ) ? $_GET['info'][ $field_id ] : "";

						if ( $display_type_search == 'select' ) {

						} elseif ( $display_type_search == 'range' ) {

							$min_name = 'min_' . $field_id;
							$max_name = 'max_' . $field_id;

							if ( isset( $_GET[ $min_name ] ) && isset( $_GET[ $max_name ] ) ) {

								if ( $_GET[ $min_name ] != '' && $_GET[ $max_name ] != '' && is_numeric( $_GET[ $min_name ] ) && is_numeric( $_GET[ $max_name ] ) ) {
									array_push( $args['meta_query'], [
										'key'     => OPALESTATE_PROPERTY_PREFIX . $field_id,
										'value'   => [ $_GET[ $min_name ], $_GET[ $max_name ] ],
										'compare' => 'BETWEEN',
										'type'    => 'NUMERIC',
									] );
								} elseif ( $_GET[ $min_name ] != '' && is_numeric( $_GET[ $min_name ] ) ) {
									array_push( $args['meta_query'], [
										'key'     => OPALESTATE_PROPERTY_PREFIX . $field_id,
										'value'   => $_GET[ $min_name ],
										'compare' => '>=',
										'type'    => 'NUMERIC',
									] );
								} elseif ( $_GET[ $max_name ] != '' && is_numeric( $_GET[ $max_name ] ) ) {
									array_push( $args['meta_query'], [
										'key'     => OPALESTATE_PROPERTY_PREFIX . $field_id,
										'value'   => $_GET[ $max_name ],
										'compare' => '<=',
										'type'    => 'NUMERIC',
									] );
								}

							}


						} else {
							// do nothing

						}

					}

				}

			}

			if ( ! $check_area_field_exist ) {
				if ( isset( $args['meta_query'] ) ) {
					foreach ( $args['meta_query'] as $key => $item ) {
						if ( isset( $item['key'] ) && ( $item['key'] == $meta_key_search_areasize ) ) {
							unset( $args['meta_query'][ $key ] );
						}

					}
				}
			}
		}

		return $args;
	}

	public function callback_property_field_value( $value, $post_id, $field ) {

		if ( $field['type'] == 'multicheck' || $field['type'] == 'select' ) {

			$opt_values = (array) get_post_meta( $post_id, $field['id'] );
			if ( ! empty( $opt_values ) && isset( $field['options'] ) ) {
				$tmp = [];
				foreach ( $opt_values as $key => $val ) {
					if ( isset( $field['options'][ $val ] ) ) {
						$tmp[ $val ] = $field['options'][ $val ];
					}
				}
				$opt_values = $tmp;
			}
			$value = implode( ", ", $opt_values );
		} else {
			$value = get_post_meta( $post_id, $field['id'], true );
		}

		return $value;
	}

	public function set_meta_short_fields() {


		$new_setting_fields = [];

		foreach ( $this->fields_override as $override_item ) {
			$new_setting_fields[ $override_item['id'] ] = $override_item;
		}

		$this->new_setting_fields = $new_setting_fields;

		$fields = Opalestate_PostType_Property::metaboxes_info_fields();

		$metabox_info = [];

		foreach ( $fields as $field ) {
			$field_setting_name = $field['id'] . '_short_meta';
			$meta_setting       = opalestate_options( $field_setting_name, 0 );

			if ( $meta_setting == 1 ) {
				$id   = str_replace( OPALESTATE_PROPERTY_PREFIX, "", $field['id'] );
				$icon = '';
				if ( $new_setting_fields[ $id ] ) {
					$icon = isset( $new_setting_fields[ $id ]['icon'] ) ? $new_setting_fields[ $id ]['icon'] : '';
					$icon = isset( $new_setting_fields[ $id ]['icon_class'] ) ? $icon . ' ' . $new_setting_fields[ $id ]['icon_class'] : $icon;
				}

				$unit = isset( $new_setting_fields[ $id ]['unit'] ) ? $new_setting_fields[ $id ]['unit'] : '';

				$metabox_info[ $id ]            = [ 'label' => $field['name'], 'value' => '', 'icon' => $icon, 'id' => $field['id'], 'unit' => $unit ];
				$metabox_info[ $id ]['type']    = $field['type'];
				$metabox_info[ $id ]['options'] = isset( $field['options'] ) ? $field['options'] : [];
			}
		}

		$this->meta = $metabox_info;

	}

	/**
	 *
	 */
	public function display_meta_field() {

		ob_start();
		$this->display_meta_field_html();
		$template = ob_get_contents();
		ob_end_clean();

		return $template;

	}


	public function display_meta_field_html() {
		global $post;

		?>

		<?php if ( $this->meta ): ?>
            <div class="property-meta">
                <ul class="property-meta-list list-inline">
					<?php if ( $this->meta ) : ?>
						<?php foreach ( $this->meta as $key => $field ) :
							$value = get_post_meta( $post->ID, $field['id'], true );
							$field['value'] = apply_filters( "opalestate_property_field_value", $value, $post->ID, $field );
							?>
                            <li class="property-label-<?php echo $key; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $field['label']; ?>">
                                <span class="<?php echo $field['icon'] ?>"></span>
                                <span class="label-property"><?php echo __( $field['label'], 'opal-et-field-creator' ); ?></span>
                                <span class="label-content"><?php echo apply_filters( 'opalestate' . $key . '_unit_format', trim( $field['value'] ) ); ?><?php echo trim( $field['unit'] ) ?></span>
                            </li>
						<?php endforeach; ?>
					<?php endif; ?>
                </ul>
            </div>
		<?php endif; ?>

		<?php

	}


	public function display_search_field( $field, $label ) {

		$setting_field_name          = 'opalestate_ppt_' . $field . '_opt';
		$setting_search_type         = 'opalestate_ppt_' . $field . '_opt_search_type';
		$setting_search_type_options = $setting_field_name . '_options_value';
		$setting_search_min_range    = $setting_field_name . '_min_range';
		$setting_search_max_range    = $setting_field_name . '_max_range';

		if ( opalestate_options( $setting_field_name, 0 ) == 1 ) {
			$display_type_search = opalestate_options( $setting_search_type, 'select' );

			$qvalue = isset( $_GET['info'][ $field ] ) ? $_GET['info'][ $field ] : "";

			if ( $display_type_search == 'select' ) {

				$option_values = (array) explode( ',', opalestate_options( $setting_search_type_options, '1,2,3,4,5,6,7,8,9,10' ) );

				$template = '<select class="form-control" name="info[%s]"><option value="">%s</option>';
				foreach ( $option_values as $value ) {
					$selected = $value == $qvalue ? 'selected="selected"' : '';
					$template .= '<option ' . $selected . ' value="' . $value . '">' . $value . '</option>';
				}
				$template .= '</select>';

				$template = sprintf( $template, $field, $label );

				return $template;

			} elseif ( $display_type_search == 'text' ) {

				// $option_values = (array) explode( ',', opalestate_options($setting_search_type_options, '1,2,3,4,5,6,7,8,9,10') );
				$option_values = opalestate_options( $setting_search_type_options, '' );
				$qvalue        = isset( $_GET['info'][ $field ] ) ? $_GET['info'][ $field ] : $option_values;

				// $template = '<select class="form-control" name="info[%s]"><option value="">%s</option>';
				// foreach ( $option_values as $value ) {
				//     $selected = $value == $qvalue ? 'selected="selected"':'';
				//     $template .= '<option '.$selected.' value="'.$value.'">'.$value.'</option>';
				// }
				// $template .= '</select>';

				$template = '<input class="form-control" type="text" name="info[%s]" value="%s"/>';

				$template = sprintf( $template, $field, $qvalue );

				return $template;

			} elseif ( $display_type_search == 'range' ) {

				$min_name = 'min_' . $field;
				$max_name = 'max_' . $field;

				$search_min = (int) isset( $_GET[ $min_name ] ) ? $_GET[ $min_name ] : opalestate_options( $setting_search_min_range, 0 );
				$search_max = (int) isset( $_GET[ $max_name ] ) ? $_GET[ $max_name ] : opalestate_options( $setting_search_max_range, 1000 );

				$data = [
					'id'         => $field,
					'unit'       => '',
					'ranger_min' => opalestate_options( $setting_search_min_range, 0 ),
					'ranger_max' => opalestate_options( $setting_search_max_range, 1000 ),
					'input_min'  => $search_min,
					'input_max'  => $search_max,
				];

				ob_start();

				opalesate_property_slide_ranger_template( __( $field . " : ", 'opal-et-field-creator' ), $data );
				$template = ob_get_contents();

				ob_end_clean();

				return $template;
			} else {
				return '';
			}
		}

		return '';
	}


	public function display_admin_setting_fields( $fields ) {
		if ( $this->fields_override ) {

			$new_fields = [];

			foreach ( $this->fields_override as $override_item ) {
				if ( $override_item['id'] ) {

					$new_field_item       = $override_item;
					$new_field_item['id'] = OPALESTATE_PROPERTY_PREFIX . $new_field_item['id'];

					if ( isset( $new_field_item['name'] ) ) {
						$name                   = $new_field_item['name'];
						$new_field_item['name'] = __( $name, "opal-et-field-creator" );
					}

					// multiple check
					if ( ( $new_field_item['type'] == 'select' ) && isset( $new_field_item['multiple'] ) && ( $new_field_item['multiple'] == 1 ) ) {
						$new_field_item['type'] = 'multicheck';
					}
					$new_fields[] = $new_field_item;
				}
			}

			return $new_fields;
		}

		return $fields;
	}

}

$Opalestate_Override_Fields = new Opalestate_Override_Fields();


