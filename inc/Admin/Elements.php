<?php
namespace Opalestate_Custom_Fields\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Elements {
	/**
	 * @var
	 */
	public $icon_data;

	/**
	 * Elements constructor.
	 */
	public function __construct() {
		// $icons           = new Fontawesome();
		// $this->icon_data = $icons->get_icons();
		$this->icon_data = [];
	}

	/**
	 * Build text field.
	 *
	 * @param array $args
	 */
	public function text( $args = [] ) {
		$default = [
			'name'        => '',
			'id'          => '',
			'description' => '',
			'default'     => '',
			'placeholder' => '',
			'required'    => '',
			'icon'        => '',
		];

		$args = array_merge( $default, $args );

		extract( $args );

		?>
        <li class="panel-group">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="toggle-panel"><i class="dashicons dashicons-edit"></i><?php esc_html_e( 'Text', 'opaljob' ); ?>: <span><?php echo esc_html( $name ); ?></span></a>
                        <a href="#" class="remove-custom-field-item"><i class="dashicons dashicons-no"></i></a>
                    </h4>
                </div>
                <div class="panel-body" style="display: none">
					<?php $this->render_metakey( $id ); ?>

					<?php $this->render_title( $name ); ?>

					<?php $this->render_placeholder( $placeholder ); ?>

					<?php $this->render_description( $description ); ?>

					<?php $this->render_default( $default ); ?>

					<?php $this->render_required( $required ); ?>

					<?php $this->render_icon( $icon ); ?>
                </div>
            </div>
            <input type="hidden" name="type[]" value="text"/>
        </li>
		<?php
	}

	/**
	 * Build textarea.
	 *
	 * @param array $args
	 */
	public function textarea( $args = [] ) {
		$default = [
			'name'        => '',
			'id'          => '',
			'description' => '',
			'default'     => '',
			'required'    => '',
			'icon'        => '',
		];

		$args = array_merge( $default, $args );

		extract( $args );

		?>
        <li class="panel-group">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="toggle-panel"><i class="dashicons dashicons-editor-alignleft"></i><?php esc_html_e( 'Textarea', 'opaljob' ); ?>: <span><?php echo esc_html( $name ); ?></span></a>
                        <a href="#" class="remove-custom-field-item"><i class="dashicons dashicons-no"></i></a>
                    </h4>
                </div>
                <div class="panel-body" style="display: none">
					<?php $this->render_metakey( $id ); ?>

					<?php $this->render_title( $name ); ?>

					<?php $this->render_description( $description ); ?>

					<?php $this->render_default( $default ); ?>

					<?php $this->render_required( $required ); ?>

					<?php $this->render_icon( $icon ); ?>
                </div>
            </div>
            <input type="hidden" name="type[]" value="textarea"/>
        </li>
		<?php
	}

	/**
	 * Build text date.
	 *
	 * @param array $args
	 */
	public function date( $args = [] ) {
		$default = [
			'name'        => '',
			'id'          => '',
			'description' => '',
			'default'     => '',
			'placeholder' => '',
			'required'    => '',
			'icon'        => '',
		];

		$args = array_merge( $default, $args );

		extract( $args );

		?>
        <li class="panel-group">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="toggle-panel"><i class="dashicons dashicons-calendar-alt"></i><?php esc_html_e( 'Date', 'opaljob' ); ?>: <span><?php echo esc_html( $name ); ?></span></a>
                        <a href="#" class="remove-custom-field-item"><i class="dashicons dashicons-no"></i></a>
                    </h4>

                </div>
                <div class="panel-body" style="display: none">
					<?php $this->render_metakey( $id ); ?>

					<?php $this->render_title( $name ); ?>

					<?php $this->render_placeholder( $placeholder ); ?>

					<?php $this->render_description( $description ); ?>

					<?php $this->render_default( $default ); ?>

					<?php $this->render_required( $required ); ?>

					<?php $this->render_icon( $icon ); ?>
                </div>
            </div>
            <input type="hidden" name="type[]" value="date"/>
        </li>
		<?php
	}

	/**
	 * Build select.
	 *
	 * @param array $args
	 */
	public function select( $args = [] ) {
		$default = [
			'name'        => '',
			'id'          => '',
			'description' => '',
			'default'     => '',
			'i'           => 0,
			'options'     => [],
			'multiple'    => 0,
			'required'    => '',
			'icon'        => '',
		];

		$args = array_merge( $default, $args );

		extract( $args );

		?>
        <li class="panel-group select-container">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="toggle-panel"><i class="dashicons dashicons-menu"></i><?php esc_html_e( 'Select', 'opaljob' ); ?>: <span><?php echo esc_html( $name ); ?></span></a>
                        <a href="#" class="remove-custom-field-item"><i class="dashicons dashicons-no"></i></a>
                    </h4>
                </div>
                <div class="panel-body" style="display: none">
					<?php $this->render_metakey( $id ); ?>

					<?php $this->render_title( $name ); ?>

                    <div class="form-group-field">
                        <label class="control-label label-field"><?php esc_html_e( 'Options', 'opaljob' ); ?></label>
                        <div class="content-field options-container">

							<?php
							$index = 0;
							foreach ( $options as $option_item_key => $option_item ) {
								$checked = false;
								if ( $option_item_key == $default ) {
									$checked = true;
								}

								?>
                                <div class="row option-row">
                                    <div class="label-wrap">
                                        <label>
                                            <strong><?php esc_html_e( 'Label', 'opaljob' ); ?></strong>
                                            <input type="text" name="select_options_label[<?php echo esc_attr( $i ); ?>][]" class="options-label form-control"
                                                   value="<?php echo esc_attr( $option_item ); ?>"/>
                                        </label>
                                    </div>
                                    <div class="value-wrap">
                                        <label>
                                            <strong><?php esc_html_e( 'Value', 'opaljob' ); ?></strong>
                                            <input type="text" name="select_options_value[<?php echo esc_attr( $i ); ?>][]" class="options-value form-control"
                                                   value="<?php echo esc_attr( $option_item_key ); ?>"/>
                                        </label>

                                    </div>
                                    <div class="default-wrap">
                                        <label>
                                            <strong><?php esc_html_e( 'Default', 'opaljob' ); ?></strong>
                                            <input type="radio" name="select_options_default[<?php echo esc_attr( $i ); ?>]" class="options-default" <?php echo esc_attr(
												$checked ) ? 'checked' : ''; ?> value="<?php echo esc_attr( $index ); ?>">
                                        </label>

                                    </div>
                                    <div class="remove-wrap">
                                        <a href="#" class="form-builder-remove-option"><i class="dashicons dashicons-no"></i></a>
                                    </div>
                                </div>
								<?php
								$index++;
							}
							?>

                            <a href="#" class="btn button button-secondary add-new-options"><?php esc_html_e( 'Add new option', 'opaljob' ); ?></a>
                        </div>
                    </div>

					<?php $this->render_description( $description ); ?>

                    <div class="form-group-field">
                        <label class="control-label label-field"><?php esc_html_e( 'Multiple', 'opaljob' ); ?></label>
                        <div class="content-field">
                            <input type="checkbox" name="multiple[<?php echo esc_attr( $i ); ?>]" class="form-control multiple" value="1" <?php echo esc_attr( $multiple ) ? "checked" : "" ?> />
                        </div>
                    </div>

					<?php $this->render_required( $required ); ?>

					<?php $this->render_icon( $icon ); ?>
                </div>
            </div>
            <input type="hidden" name="type[]" value="select"/>
            <input type="hidden" name="select_id[]" class="select-index" value="<?php echo esc_attr( $i ); ?>"/>
        </li>
		<?php
	}

	/**
	 * Build select option.
	 *
	 * @param array $args
	 */
	public function select_option( $args = [] ) {
		$default = [
			'index'           => 0,
			'checked_default' => '',
			'option_index'    => 0,
		];

		$args = array_merge( $default, $args );

		extract( $args );

		?>
        <div class="row option-row">
            <div class="label-wrap">
                <label>
                    <strong><?php esc_html_e( 'Label', 'opaljob' ); ?></strong>
                    <input type="text" name="select_options_label[<?php echo esc_attr( $index ); ?>][]" class="options-label form-control" value=""/>
                </label>
            </div>

            <div class="value-wrap">
                <label>
                    <strong><?php esc_html_e( 'Value', 'opaljob' ); ?></strong>
                    <input type="text" name="select_options_value[<?php echo esc_attr( $index ); ?>][]" class="options-value form-control" value=""/>
                </label>
            </div>
            <div class="default-wrap">
                <label>
                    <strong><?php esc_html_e( 'Default', 'opaljob' ); ?></strong>
                    <input type="radio" name="select_options_default[<?php echo esc_attr( $index ); ?>]" class="options-default" <?php echo esc_attr( $checked_default ); ?>
                           value="<?php echo esc_attr( $option_index ); ?>">
                </label>
            </div>
            <div class="remove-wrap">
                <a href="#" class="form-builder-remove-option"><i class="dashicons dashicons-no"></i></a>
            </div>
        </div>
		<?php
	}

	/**
	 * Build checkbox.
	 *
	 * @param array $args
	 */
	public function checkbox( $args = [] ) {
		$default = [
			'name'        => '',
			'id'          => '',
			'description' => '',
			'default'     => '',
			'required'    => '',
			'icon'        => '',
		];

		$args = array_merge( $default, $args );

		extract( $args );

		?>
        <li class="panel-group">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="toggle-panel"><i class="dashicons dashicons-yes-alt"></i><?php esc_html_e( 'Checkbox', 'opaljob' ); ?>: <span><?php echo esc_html( $name ); ?></span></a>
                        <a href="#" class="remove-custom-field-item"><i class="dashicons dashicons-no"></i></a>
                    </h4>
                </div>
                <div class="panel-body" style="display: none">
					<?php $this->render_metakey( $id ); ?>

					<?php $this->render_title( $name ); ?>

					<?php $this->render_description( $description ); ?>

                    <div class="form-group-field">
                        <label class="control-label label-field"><?php esc_html_e( 'Default', 'opaljob' ); ?></label>
                        <div class="content-field">
                            <select name="default[]" class="form-control etf-in">
                                <option value="off" <?php selected( $default, 'off' ); ?>><?php esc_html_e( 'Off', 'opaljob' ); ?></option>
                                <option value="on" <?php selected( $default, 'on' ); ?>><?php esc_html_e( 'On', 'opaljob' ); ?></option>
                            </select>
                        </div>
                    </div>

					<?php $this->render_required( $required ); ?>

					<?php $this->render_icon( $icon ); ?>
                </div>
            </div>
            <input type="hidden" name="type[]" value="checkbox"/>
        </li>
		<?php
	}

	/**
	 * Render meta key.
	 *
	 * @param $value
	 */
	protected function render_metakey( $value ) {
		?>
        <div class="form-group-field">
            <label class="control-label label-field"><?php esc_html_e( 'Meta key', 'opaljob' ); ?><span class="required"> *</span></label>
            <div class="content-field">
                <input type="text" name="id[]" class="form-control input-meta-key etf-in" placeholder="<?php esc_html_e( 'Please Enter Meta Key', 'opaljob' ); ?>" value="<?php echo esc_attr( $value
				); ?>" required="required">
                <p class="content-field__description">
					<?php esc_html_e( 'Please enter word not contain blank, special characters. This field is used for search able, it should be lowercase or _ for example: your_key_here.' ); ?>
                </p>
            </div>
        </div>
		<?php
	}

	/**
	 * Render title.
	 *
	 * @param $value
	 */
	protected function render_title( $value ) {
		?>
        <div class="form-group-field">
            <label class="control-label label-field"><?php esc_html_e( 'Title', 'opaljob' ); ?><span class="required"> *</span></label>
            <div class="content-field">
                <input type="text" name="name[]" class="form-control input-title etf-in" placeholder="<?php esc_attr_e( 'Please enter title.', 'opaljob' ); ?>" value="<?php echo esc_attr( $value
				); ?>" required="required">
            </div>
        </div>
		<?php
	}

	/**
	 * Render placeholder.
	 *
	 * @param $value
	 */
	protected function render_placeholder( $value ) {
		?>
        <div class="form-group-field">
            <label class="control-label label-field"><?php esc_html_e( 'Placeholder', 'opaljob' ); ?></label>
            <div class="content-field">
                <input type="text" name="placeholder[]" class="form-control input-placeholder etf-in" placeholder="<?php esc_attr_e( 'Please enter placeholder.', 'opaljob' ); ?>" value="<?php echo
				esc_attr( $value ); ?>">
            </div>
        </div>
		<?php
	}

	/**
	 * Render description.
	 *
	 * @param $value
	 */
	protected function render_description( $value ) {
		?>
        <div class="form-group-field">
            <label class="control-label label-field"><?php esc_html_e( 'Description', 'opaljob' ); ?></label>
            <div class="content-field">
                <textarea name="description[]" class="input-description etf-textarea" placeholder="<?php esc_attr_e( 'Please enter description', 'opaljob' ); ?>"><?php echo esc_html( $value );
	                ?></textarea>
            </div>
        </div>
		<?php
	}

	/**
	 * Render default.
	 *
	 * @param $value
	 */
	protected function render_default( $value ) {
		?>
        <div class="form-group-field">
            <label class="control-label label-field"><?php esc_html_e( 'Default', 'opaljob' ); ?></label>
            <div class="content-field">
                <input type="text" name="default[]" class="form-control input-default etf-in" placeholder="<?php esc_attr_e( 'Please enter default', 'opaljob' ); ?>" value="<?php echo esc_attr(
					$value );
				?>">
            </div>
        </div>
		<?php
	}

	/**
	 * Render required.
	 *
	 * @param $value
	 */
	protected function render_required( $value ) {
		?>
        <div class="form-group-field">
            <label class="control-label label-field"><?php esc_html_e( 'Required', 'opaljob' ); ?></label>
            <div class="content-field">
                <select name="required[]" class="form-control etf-in">
                    <option value="" <?php selected( $value, '' ); ?>><?php esc_html_e( 'No', 'opaljob' ); ?></option>
                    <option value="yes" <?php selected( $value, 'yes' ); ?>><?php esc_html_e( 'Yes', 'opaljob' ); ?></option>
                </select>
            </div>
        </div>
		<?php
	}

	/**
	 * Render required.
	 *
	 * @param $value
	 */
	protected function render_icon( $value ) {
		wp_enqueue_script( 'fonticonpicker' );
		?>
        <div class="form-group-field">
            <label class="control-label label-field"><?php esc_html_e( 'Icon', 'opaljob' ); ?></label>
            <div class="content-field">
                <select name="icon[]" class="opaljob-iconpicker form-control etf-in">
					<?php
					foreach ( $this->icon_data as $icon_item ) {
						$full_icon_class = $icon_item['prefix'] . ' ' . $icon_item['class'];
						echo '<option value="' . $full_icon_class . '" ' . selected( $full_icon_class, $value, false ) . '>' . esc_html( $icon_item['class'] ) . '</option>';
					}
					?>
                </select>
            </div>
        </div>
		<?php
	}
}
