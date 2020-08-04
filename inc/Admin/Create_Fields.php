<?php
namespace Opalestate_Custom_Fields\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Create_Fields {
	/**
	 * @var
	 */
	public $option_key;

	/**
	 * Create_Fields constructor.
	 */
	public function __construct( $option_key ) {
		$this->option_key = $option_key;
	}

	public function save() {
		if ( isset( $_POST['nonce_field_save_custom_fields'] ) ) {

			if ( wp_verify_nonce( $_POST['nonce_field_save_custom_fields'], 'action_save_custom_fields' ) ) {
				$custom_fields      = [];
				$custom_fields_flag = false;
				if ( isset( $_POST['type'] ) ) {
					$custom_fields_flag = true;
					$case_select        = 0;
					$case_common        = 0;

					foreach ( $_POST['type'] as $key => $value ) {

						switch ( $value ) {
							case 'text':
							case 'textarea':
							case 'checkbox':
							case 'date':
								$custom_fields[ $key ] = [
									'type'        => $value,
									'id'          => sanitize_title( $_POST['id'][ $key ] ),
									'name'        => sanitize_text_field( $_POST['name'][ $key ] ),
									'description' => sanitize_text_field( $_POST['description'][ $key ] ),
									'required'    => isset( $_POST['required'][ $key ] ) ? sanitize_text_field( $_POST['required'][ $key ] ) : '',
									'icon'        => isset( $_POST['icon'][ $key ] ) ? sanitize_text_field( $_POST['icon'][ $key ] ) : '',
								];

								if ( isset( $_POST['default'][ $case_common ] ) ) {
									$custom_fields[ $key ]['default'] = sanitize_text_field( $_POST['default'][ $case_common ] );
								} else {
									$custom_fields[ $key ]['default'] = '';
								}

                                if ( isset( $_POST['number'][ $case_common ] ) ) {
                                    $custom_fields[ $key ]['number'] = sanitize_text_field( $_POST['number'][ $case_common ] );
                                } else {
                                    $custom_fields[ $key ]['number'] = '';
                                }

								$case_common++;
								break;

							case 'select':
								if ( isset( $_POST['select_options_value'][ $case_select ] ) && $_POST['select_options_value'][ $case_select ] ) {
									$option_values = $_POST['select_options_value'][ $case_select ];
									if ( $option_values ) {
										foreach ( $option_values as $k => $v ) {
											$option_values[ $k ] = sanitize_text_field( $v );
										}
									}
								} else {
									$option_values = [];
								}

								if ( isset( $_POST['select_options_label'][ $case_select ] ) && $_POST['select_options_label'][ $case_select ] ) {
									$option_labels = $_POST['select_options_label'][ $case_select ];
									if ( $option_labels ) {
										foreach ( $option_labels as $k => $v ) {
											$option_labels[ $k ] = sanitize_text_field( $v );
										}
									}
								} else {
									$option_labels = [];
								}

								if ( isset( $_POST['select_options_default'][ $case_select ] ) ) {
									$def_value_index = absint( $_POST['select_options_default'][ $case_select ] );
								} else {
									$def_value_index = 0;
								}

								$custom_fields[ $key ] = [
									'type'                => 'select',
									'id'                  => sanitize_title( $_POST['id'][ $key ] ),
									'name'                => sanitize_text_field( $_POST['name'][ $key ] ),
									'description'         => sanitize_text_field( $_POST['description'][ $key ] ),
									'options'             => array_combine( $option_values, $option_labels ),
									'default'             => '',
									'default_value_index' => $def_value_index,
									'multiple'            => isset( $_POST['multiple'][ $case_select ] ) ? $_POST['multiple'][ $case_select ] : 0,
									'required'            => isset( $_POST['required'][ $key ] ) ? sanitize_text_field( $_POST['required'][ $key ] ) : '',
									'icon'                => isset( $_POST['icon'][ $key ] ) ? sanitize_text_field( $_POST['icon'][ $key ] ) : '',
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
					if ( $_POST['in_reset_default'] == 1 ) {
						update_option( $this->option_key, [] );
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
						update_option( $this->option_key, $custom_fields );
					}
				} else {
					delete_option( $this->option_key );
				}
			}
		}
	}

	/**
	 * Render form builder.
	 */
	public function render() {
		wp_enqueue_script( 'fonticonpicker', OPALESTATE_CUSTOM_FIELDS_PLUGIN_URL . 'assets/js/jquery.fonticonpicker.min.js', [], '2.0.0' );
		wp_enqueue_style( 'opalestate-custom-fields', OPALESTATE_CUSTOM_FIELDS_PLUGIN_URL . 'assets/css/form-builder.css', [], '1.0' );
		wp_enqueue_script( 'opalestate-custom-fields', OPALESTATE_CUSTOM_FIELDS_PLUGIN_URL . 'assets/js/form-builder.js', [ 'jquery', 'jquery-ui-sortable' ], '1.0', false );
		wp_enqueue_style( 'hint', OPALESTATE_CUSTOM_FIELDS_PLUGIN_URL . 'assets/css/hint.min.css', null, '1.3', false );
		wp_register_style( 'fontawesome', OPALESTATE_PLUGIN_URL . 'assets/3rd/fontawesome/css/all.min.css', null, '5.11.2', false );

		// Iconpicker.
		wp_register_style( 'fonticonpicker', OPALESTATE_CUSTOM_FIELDS_PLUGIN_URL . 'assets/css/jquery.fonticonpicker.min.css', [], '2.0.0' );
		wp_register_style( 'fonticonpicker-grey-theme', OPALESTATE_CUSTOM_FIELDS_PLUGIN_URL . 'assets/themes/grey-theme/jquery.fonticonpicker.grey.min.css', [ 'fontawesome' ], '2.0.0' );

		wp_enqueue_style( 'fonticonpicker' );
		wp_enqueue_style( 'fonticonpicker-grey-theme' );
		wp_localize_script( 'opalestate-custom-fields', 'opalestateCTF', [
			'text' => [
				'confirm_reset_text' => esc_html__( 'Are you sure reset fields?', 'opal-estate-custom-fields' ),
				'duplicate_meta_key' => esc_html__( 'Duplicate meta key', 'opal-estate-custom-fields' ),
				'try_again'          => esc_html__( 'Please try again!', 'opal-estate-custom-fields' ),
			],
		] );

		$data = [];

		$custom_fields = get_option( $this->option_key );

		if ( ! $custom_fields ) {

			foreach ( $data as $key => $item ) {
				if ( isset( $item['type'] ) ) {
					if ( in_array( $item['type'], [ 'text', 'date', 'textarea', 'select', 'checkbox' ] ) ) {
						$data[ $key ] = $item;
					}
				}
			}
			$custom_fields = $data;
		}

		?>
        <form name="opal-etfields-form" action="" method="post">
            <div class="opl-bootstrap">
                <div class="listing-creator-custom-fields">

                    <div class="control-button">
                        <span style="margin-right: 20px"><?php esc_html_e( 'Add new field', 'opal-estate-custom-fields' ) ?>: </span>
						<?php $field_supports = $this->get_field_supports(); ?>
						<?php foreach ( $field_supports as $field ) : ?>
                            <a href="#" data-type="<?php echo esc_attr( $field['type'] ); ?>" class="create-et-field-btn hint--top" aria-label="<?php echo esc_attr( $field['title'] ); ?>"
                               title="<?php echo esc_attr( $field['title'] ); ?>">
								<?php if ( $field['icon'] ) : ?>
                                    <i class="<?php echo esc_attr( $field['icon'] ); ?>"></i>
								<?php else : ?>
									<?php echo esc_html( $field['title'] ); ?>
								<?php endif; ?>
                            </a>
						<?php endforeach; ?>
                    </div>

                    <ul class="content-fields form-horizontal">
						<?php
						$elements = new Elements();

						if ( $custom_fields ) {
							$index_select = 0;
							foreach ( $custom_fields as $custom_field ) {
								switch ( $custom_field['type'] ) {
									case 'text':
										$elements->text( $custom_field );
										break;
									case 'textarea':
										$elements->textarea( $custom_field );
										break;
									case 'select':
										$custom_field['i'] = $index_select;
										$elements->select( $custom_field );
										$index_select++;
										break;
									case 'checkbox':
										$elements->checkbox( $custom_field );
										break;
									case 'date' :
										$elements->date( $custom_field );
										break;
								}

								do_action( 'opalestate_custom_fields_render_field', $custom_field, $elements );
							}
						}
						?>

                    </ul>

					<?php wp_nonce_field( 'action_save_custom_fields', 'nonce_field_save_custom_fields' ); ?>

                    <div class="submit-wrap">
                        <input type="hidden" name="option_key" id="option_key" value="<?php echo esc_attr( $this->option_key ); ?>">
                        <button class="save-button btn btn-submit button button-primary" id="save-etfields" name="save_page_options" value="savedata" type="submit">
							<?php esc_html_e( 'Save', 'opal-estate-custom-fields' ); ?>
                        </button>

                        <button class="reset-button btn btn-submit button button-secondary" id="reset-etfields" name="reset_page_options" value="savedata" type="button">
							<?php esc_html_e( 'Reset', 'opal-estate-custom-fields' ); ?>
                        </button>
                        <input type="hidden" name="in_reset_default" id="in-reset-default" value="0">
                    </div>
                </div>
            </div>
        </form>
		<?php
	}

	/**
	 * Gets field supports.
	 */
	public function get_field_supports() {
		return apply_filters( 'opalestate_custom_fields_field_supports', [
			[
				'type'  => 'text',
				'title' => esc_html__( 'Text', 'opal-estate-custom-fields' ),
				'icon'  => 'dashicons dashicons-edit',
			],
			[
				'type'  => 'textarea',
				'title' => esc_html__( 'Text area', 'opal-estate-custom-fields' ),
				'icon'  => 'dashicons dashicons-editor-alignleft',
			],
			[
				'type'  => 'select',
				'title' => esc_html__( 'Select', 'opal-estate-custom-fields' ),
				'icon'  => 'dashicons dashicons-menu',
			],
			[
				'type'  => 'checkbox',
				'title' => esc_html__( 'Checkbox', 'opal-estate-custom-fields' ),
				'icon'  => 'dashicons dashicons-yes-alt',
			],
			[
				'type'  => 'date',
				'title' => esc_html__( 'Date', 'opal-estate-custom-fields' ),
				'icon'  => 'dashicons dashicons-calendar-alt',
			],
		] );
	}
}
