<?php
namespace Opalestate_Custom_Fields;

class Create_Fields {
	/**
	 * Create_Fields constructor.
	 */
	public function __construct() {

		add_action( 'admin_menu', [ $this, 'admin_menu' ], 10 );

		add_action( 'wp_ajax_creator_custom_type', [ $this, 'creator_custom_type' ] );
		add_action( 'wp_ajax_nopriv_creator_custom_type', [ $this, 'creator_custom_type' ] );

		add_action( 'wp_ajax_create_option_select', [ $this, 'create_option_select' ] );
		add_action( 'wp_ajax_nopriv_create_option_select', [ $this, 'create_option_select' ] );

		add_action( "admin_init", [ $this, 'save_data' ] );
	}


	public function admin_menu() {
		add_submenu_page( 'edit.php?post_type=opalestate_property', __( 'Fields creator', 'opal-et-field-creator' ), __( 'Fields creator', 'opal-et-field-creator' ),
			'manage_opalestate_settings', 'opal-create-fields',
			[ $this, 'admin_page_display' ] );
	}


	public function create_option_select() {

		if ( isset( $_POST['index'] ) && isset( $_POST['checked_default'] ) && isset( $_POST['option_index'] ) ) {

			$args = [
				'index'           => $_POST['index'],
				'checked_default' => $_POST['checked_default'],
				'option_index'    => $_POST['option_index'],
			];

			$OpalEtFieldCreator_Html_Elements = new OpalEtFieldCreator_Html_Elements();

			ob_start();
			$OpalEtFieldCreator_Html_Elements->select_option( $args );
			$html = ob_get_contents();
			ob_end_clean();

			$result = [ 'type' => 'success', 'html' => $html ];
		} else {
			$result = [ 'type' => 'fail', 'html' => '' ];
		}

		echo json_encode( $result );
		exit;
	}


	public function creator_custom_type() {

		$type = $_POST['type'];

		$OpalEtFieldCreator_Html_Elements = new OpalEtFieldCreator_Html_Elements();

		ob_start();

		switch ( $type ) {
			case "textarea":
				$OpalEtFieldCreator_Html_Elements->textarea();
				break;
			case "select":
				$OpalEtFieldCreator_Html_Elements->select();
				break;
			case "checkbox";
				$OpalEtFieldCreator_Html_Elements->checkbox();
				break;
			case "text_date":
				$OpalEtFieldCreator_Html_Elements->text_date();
				break;
			case "text":
			default:
				$OpalEtFieldCreator_Html_Elements->text();
				break;
		}

		$html = ob_get_contents();
		ob_end_clean();

		$result = [ 'type' => 'success', 'html' => $html ];

		echo json_encode( $result );
		exit;
	}


	public function save_data() {

		if ( isset( $_POST['nonce_field_save_etfields'] ) ) {

			if ( wp_verify_nonce( $_POST['nonce_field_save_etfields'], 'action_save_etfields' ) ) {

				$custom_fields = [];

				$custom_fields_flag = false;
				if ( isset( $_POST['type'] ) ) {
					$custom_fields_flag = true;

					$case_select = 0;
					$case_common = 0;

					foreach ( $_POST['type'] as $key => $value ) {

						switch ( $value ) {
							case 'text':
							case 'textarea':
							case 'checkbox':
							case 'text_date':
								$custom_fields[ $key ] = [
									'type'        => $value,
									'id'          => sanitize_title( $_POST['id'][ $key ] ),
									'name'        => sanitize_text_field( $_POST['name'][ $key ] ),
									'description' => sanitize_text_field( $_POST['description'][ $key ] ),
									'icon'        => sanitize_text_field( $_POST['icon'][ $key ] ),
									'icon_class'  => sanitize_text_field( $_POST['icon_class'][ $key ] ),
									'unit'        => sanitize_text_field( $_POST['unit'][ $key ] ),
								];

								if ( isset( $_POST['default'][ $case_common ] ) ) {
									$custom_fields[ $key ]['default'] = sanitize_text_field( $_POST['default'][ $case_common ] );
								} else {
									$custom_fields[ $key ]['default'] = '';
								}

								$case_common++;
								break;

							case 'select':

								if ( isset( $_POST['opal_custom_select_options_value'][ $case_select ] ) && $_POST['opal_custom_select_options_value'][ $case_select ] ) {
									$option_values = $_POST['opal_custom_select_options_value'][ $case_select ];
									if ( $option_values ) {
										foreach ( $option_values as $k => $v ) {
											$option_values[ $k ] = sanitize_text_field( $v );
										}

									}
								} else {
									$option_values = [];
								}

								if ( isset( $_POST['opal_custom_select_options_label'][ $case_select ] ) && $_POST['opal_custom_select_options_label'][ $case_select ] ) {
									$option_labels = $_POST['opal_custom_select_options_label'][ $case_select ];
									if ( $option_labels ) {
										foreach ( $option_labels as $k => $v ) {
											$option_labels[ $k ] = sanitize_text_field( $v );
										}
									}
								} else {
									$option_labels = [];
								}

								if ( isset( $_POST['opal_custom_select_options_default'][ $case_select ] ) ) {
									$def_value_index = (int) $_POST['opal_custom_select_options_default'][ $case_select ];
								} else {
									$def_value_index = 0;
								}

								$custom_fields[ $key ] = [
									'type'                => 'select',
									'id'                  => sanitize_title( $_POST['id'][ $key ] ),
									'name'                => sanitize_text_field( $_POST['name'][ $key ] ),
									'description'         => sanitize_text_field( $_POST['description'][ $key ] ),
									'icon'                => sanitize_text_field( $_POST['icon'][ $key ] ),
									'icon_class'          => sanitize_text_field( $_POST['icon_class'][ $key ] ),
									'options'             => array_combine( $option_values, $option_labels ),
									'unit'                => sanitize_text_field( $_POST['unit'][ $key ] ),
									'default'             => '',
									'default_value_index' => $def_value_index,
									'multiple'            => isset( $_POST['multiple'][ $case_select ] ) ? $_POST['multiple'][ $case_select ] : 0,
								];

								if ( ! empty( $option_values ) ) {
									if ( $custom_fields[ $key ]['multiple'] == 1 ) {
										if ( isset( $option_values[ $def_value_index ] ) && sanitize_text_field( $option_values[ $def_value_index ] ) ) {
											$custom_fields[ $key ]['default'] = sanitize_text_field( $option_values[ $def_value_index ] );
										}
									} else {
										if ( isset( $option_values[ $def_value_index ] ) && sanitize_text_field( $option_values[ $def_value_index ] ) ) {
											$custom_fields[ $key ]['default'] = sanitize_text_field( $option_values[ $def_value_index ] );
										} else {
											$custom_fields[ $key ]['default'] = sanitize_text_field( $option_values[0] );
										}
									}
								}

								if ( $custom_fields[ $key ]['options'] ) {
									foreach ( $custom_fields[ $key ]['options'] as $option_key => $option_val ) {
										if ( ! $option_val ) {
											$custom_fields[ $key ]['options'][ $option_key ] = $option_key;
										}
										if ( ! $option_key ) {
											unset( $custom_fields[ $key ]['options'][ $option_key ] );
										}
									}

								}

								$case_select++;
								break;
						}
					}
				}

				$meta_key_check_exist = [];

				if ( $custom_fields_flag ) {

					if ( $_POST["in_reset_default"] == 1 ) {
						update_option( 'opal_etfields_fields', [] );
					} else {

						if ( $custom_fields ) {
							foreach ( $custom_fields as $custom_field_key => $custom_field_item ) {
								if ( isset( $custom_field_item['id'] ) ) {
									if ( ! $custom_field_item['id'] ) {
										unset( $custom_fields[ $custom_field_key ] );
									}

									if ( ! $custom_field_item['name'] ) {
										$custom_fields[ $custom_field_key ]['name'] = $custom_field_item['id'];
									}

									if ( in_array( $custom_field_item['id'], $meta_key_check_exist ) ) {
										unset( $custom_fields[ $custom_field_key ] );
									} else {
										$meta_key_check_exist[] = $custom_field_item['id'];
									}

								} else {
									unset( $custom_fields[ $custom_field_key ] );
								}


							}
						}

						update_option( 'opal_etfields_fields', $custom_fields );
					}


				} else {
					delete_option( 'opal_etfields_fields' );
				}

			}
		}

	}


	public function admin_page_display() {

		wp_enqueue_style( "place-type", OPALETFIELDS_PLUGIN_URL . '/assets/admin/css/field-type.css' );

		wp_enqueue_style( "fonticonpicker", OPALETFIELDS_PLUGIN_URL . '/assets/fontIconPicker-2.0.0/css/jquery.fonticonpicker.min.css' );
		wp_enqueue_style( "fonticonpicker-grey-theme", OPALETFIELDS_PLUGIN_URL . '/assets/fontIconPicker-2.0.0/themes/grey-theme/jquery.fonticonpicker.grey.min.css' );
		wp_enqueue_style( "fontawesome", OPALETFIELDS_PLUGIN_URL . 'assets/font-awesome-4.6.3/css/font-awesome.css' );

		wp_enqueue_script( "creatorfields", OPALETFIELDS_PLUGIN_URL . 'assets/js/fields.js', [ 'jquery' ], "1.3", false );

		wp_enqueue_script( "fonticonpicker", OPALETFIELDS_PLUGIN_URL . 'assets/fontIconPicker-2.0.0/jquery.fonticonpicker.min.js', [ 'jquery' ], "1.3", false );

		wp_localize_script( 'creatorfields', 'myAjax', [ 'ajaxurl' => admin_url( 'admin-ajax.php' ) ] );

		$data = [];

		if ( class_exists( 'Opalestate_PostType_Property' ) ) {
			$data = Opalestate_PostType_Property::metaboxes_info_fields();
		}

		$custom_fields = get_option( 'opal_etfields_fields' );

		if ( ! $custom_fields ) {

			foreach ( $data as $key => $item ) {
				if ( isset( $item['type'] ) ) {
					if ( in_array( $item['type'], [ 'text', 'text_date', 'textarea', 'select', 'checkbox' ] ) ) {
						$item['id']   = str_replace( OPALESTATE_PROPERTY_PREFIX, "", $item['id'] );
						$data[ $key ] = $item;
					}
				}
			}
			$custom_fields = $data;
		}

		?>
        <div class="etf-wappper">
            <h1><?php _e( 'Creator fields', 'opal-et-field-creator' ) ?></h1>

            <form name="opal-etfields-form" action="" method="post">

                <div class="opl-bootstrap">
                    <div class="listing-creator-custom-fields">
                        <div class="content-fields form-horizontal">

							<?php

							$OpalEtFieldCreator_Html_Elements = new OpalEtFieldCreator_Html_Elements();

							if ( $custom_fields ) {
								$index_select = 0;
								foreach ( $custom_fields as $custom_field ) {
									switch ( $custom_field['type'] ) {
										case 'text':
											$OpalEtFieldCreator_Html_Elements->text( $custom_field );
											break;
										case 'text_date' :
											$OpalEtFieldCreator_Html_Elements->text_date( $custom_field );
											break;
										case 'textarea':
											$OpalEtFieldCreator_Html_Elements->textarea( $custom_field );
											break;
										case 'select':
											$custom_field['i'] = $index_select;
											$OpalEtFieldCreator_Html_Elements->select( $custom_field );
											$index_select++;
											break;
										case 'checkbox':
											$OpalEtFieldCreator_Html_Elements->checkbox( $custom_field );
											break;
										default:
									}
								}
							}
							?>

                        </div>

                        <div class="control-button">
                            <span style="margin-right: 20px"><?php _e( 'Create new field', 'opal-et-field-creator' ) ?> : </span>
                            <a href="#" data-type="text" class="create-et-field-btn button button-primary"><?php _e( 'Text', 'opal-et-field-creator' ) ?></a>
                            <a href="#" data-type="text_date" class="create-et-field-btn button button-primary"><?php _e( 'Text date', 'opal-et-field-creator' ) ?></a>
                            <a href="#" data-type="textarea" class="create-et-field-btn button button-primary"><?php _e( 'Textarea', 'opal-et-field-creator' ) ?></a>
                            <a href="#" data-type="select" class="create-et-field-btn button button-primary"><?php _e( 'Select', 'opal-et-field-creator' ) ?></a>
                            <a href="#" data-type="checkbox" class="create-et-field-btn button button-primary"><?php _e( 'Checkbox', 'opal-et-field-creator' ) ?></a>
                        </div>

						<?php wp_nonce_field( 'action_save_etfields', 'nonce_field_save_etfields' ); ?>

                        <div class="submit-wrap">
                            <input type="button" id="save-etfields" class="button button-primary" value="<?php _e( 'Save fields', 'opal-et-field-creator' ) ?>">
                            <input type="hidden" name="in_reset_default" id="in-reset-default" value="0">
                        </div>
                    </div>

                </div>

            </form>


        </div>
		<?php
	}


}

$OpalEtFieldCreator_Create_Fields = new OpalEtFieldCreator_Create_Fields();


