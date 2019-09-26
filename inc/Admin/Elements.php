<?php
namespace Opalestate_Custom_Fields\Admin;

class Elements {

	private $icon_data;


	public function __construct() {
	    $this->icon_data = [];
	}


	public function text( $args = [] ) {
		$default = [
			'name'        => '',
			'id'          => '',
			'description' => '',
			'default'     => '',
			'icon_data'   => $this->icon_data,
			'unit'        => '',
			'icon'        => '',
			'icon_class'  => '',
		];

		$args = array_merge( $default, $args );

		extract( $args );

		?>
        <div class="panel-group">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="toggle-panel">
							<?php _e( 'TextField', 'opal-et-field-creator' ) ?> : <?php echo $name ?></a>
                        <a href="#" class="remove-custom-field-item">x</a>
                    </h4>

                </div>
                <div class="panel-body" style="display: none">
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Metakey', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="id[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Meta Key', 'opal-et-field-creator' ); ?>" value="<?php echo $id ?>">
                            <p>
                                <i><?php _e( 'Please enter word not contain blank, special characters. This field is used for search able, it should be lowercase or _ for example: your_key_here' ); ?></i>
                            </p>
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Title', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="name[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Title', 'opal-et-field-creator' ); ?>" value="<?php echo $name; ?>">
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Description', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <textarea name="description[]" class="etf-textarea" placeholder="<?php _e( 'Please Enter Description', 'opal-et-field-creator' ); ?>"><?php echo $description; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Default', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="default[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Default', 'opal-et-field-creator' ); ?>"
                                   value="<?php echo $default ?>">
                        </div>
                    </div>

                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Unit', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="unit[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Unit', 'opal-et-field-creator' ); ?>" value="<?php echo $unit ?>">
                        </div>
                    </div>

                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Icon Class', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="icon_class[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Icon Class', 'opal-et-field-creator' ); ?>"
                                   value="<?php echo $icon_class; ?>">
                        </div>
                    </div>

                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Icon', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">

                            <select class="fa-icon-picker" name="icon[]">
                                <option value=""></option>
								<?php
								foreach ( $icon_data as $icon_item ) { ?>
                                    <option <?php echo ( $icon == "fa " . $icon_item["class"] ) ? 'selected="selected"' : ""; ?>
                                            value="fa <?php echo $icon_item['class'] ?>"><?php echo $icon_item['class'] ?></option>
									<?php
								}
								?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="type[]" value="text"/>
        </div>
		<?php
	}


	public function textarea( $args = [] ) {

		$default = [
			'name'        => '',
			'id'          => '',
			'description' => '',
			'default'     => '',
			'icon_data'   => $this->icon_data,
			'unit'        => '',
			'icon'        => '',
			'icon_class'  => '',
		];

		$args = array_merge( $default, $args );

		extract( $args );

		?>
        <div class="panel-group">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="toggle-panel"><?php _e( 'TextArea', 'opal-et-field-creator' ) ?> : <?php echo $name ?></a>
                        <a href="#" class="remove-custom-field-item">x</a>
                    </h4>

                </div>
                <div class="panel-body" style="display: none">
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php echo _e( 'Metakey', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="id[]" class="form-control etf-in" placeholder="<?php echo _e( 'Please Enter Meta Key', 'opal-et-field-creator' ) ?>" value="<?php echo $id ?>">
                            <p>
                                <i><?php _e( 'Please enter word not contain blank, special characters. This field is used for search able, it should be lowercase or _ for example: your_key_here' ); ?></i>
                            </p>
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Title', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="name[]" class="form-control etf-in" placeholder="<?php echo _e( 'Please Enter Title', 'opal-et-field-creator' ) ?>" value="<?php echo $name ?>">
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Description', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <textarea name="description[]" class="etf-textarea"
                                      placeholder="<?php echo _e( 'Please Enter Description', 'opal-et-field-creator' ) ?>"><?php echo $description ?></textarea>
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Default', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="default[]" class="form-control etf-in" placeholder="<?php echo _e( 'Please Enter Default', 'opal-et-field-creator' ) ?>"
                                   value="<?php echo $default ?>">
                        </div>
                    </div>

                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Unit', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="unit[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Unit', 'opal-et-field-creator' ); ?>" value="<?php echo $unit ?>">
                        </div>
                    </div>

                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Icon Class', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="icon_class[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Icon Class', 'opal-et-field-creator' ); ?>"
                                   value="<?php echo $icon_class; ?>">
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Icon', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <select class="fa-icon-picker" name="icon[]">
                                <option value=""></option>
								<?php
								foreach ( $icon_data as $icon_item ) { ?>
                                    <option <?php echo ( $icon == "fa " . $icon_item["class"] ) ? 'selected="selected"' : ""; ?>
                                            value="fa <?php echo $icon_item['class'] ?>"><?php echo $icon_item['class'] ?></option>
									<?php
								}
								?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="type[]" value="textarea"/>
        </div>
		<?php
	}


	public function text_date( $args = [] ) {

		$default = [
			'name'        => '',
			'id'          => '',
			'description' => '',
			'default'     => '',
			'icon_data'   => $this->icon_data,
			'unit'        => '',
			'icon'        => '',
			'icon_class'  => '',
		];

		$args = array_merge( $default, $args );

		extract( $args );

		?>
        <div class="panel-group">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="toggle-panel">
							<?php _e( 'TextDate', 'opal-et-field-creator' ) ?> : <?php echo $name ?></a>
                        <a href="#" class="remove-custom-field-item">x</a>
                    </h4>

                </div>
                <div class="panel-body" style="display: none">
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Metakey', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="id[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Meta Key', 'opal-et-field-creator' ) ?>" value="<?php echo $id ?>">
                            <p>
                                <i><?php _e( 'Please enter word not contain blank, special characters. This field is used for search able, it should be lowercase or _ for example: your_key_here' ); ?></i>
                            </p>
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Title', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="name[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Title', 'opal-et-field-creator' ) ?>" value="<?php echo $name; ?>">
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Description', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <textarea name="description[]" class="etf-textarea" placeholder="<?php _e( 'Please Enter Description', 'opal-et-field-creator' ) ?>"><?php echo $description; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Default', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="default[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Default', 'opal-et-field-creator' ) ?>" value="<?php echo $default ?>">
                            <p><i><?php _e( 'Please enter format mm/dd/yyyy' ); ?></i></p>
                        </div>
                    </div>

                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Unit', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="unit[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Unit', 'opal-et-field-creator' ); ?>" value="<?php echo $unit ?>">
                        </div>
                    </div>

                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Icon Class', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="icon_class[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Icon Class', 'opal-et-field-creator' ); ?>"
                                   value="<?php echo $icon_class; ?>">
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Icon', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">

                            <select class="fa-icon-picker" name="icon[]">
                                <option value=""></option>
								<?php
								foreach ( $icon_data as $icon_item ) { ?>
                                    <option <?php echo ( $icon == "fa " . $icon_item["class"] ) ? 'selected="selected"' : ""; ?>
                                            value="fa <?php echo $icon_item['class'] ?>"><?php echo $icon_item['class'] ?></option>
									<?php
								}
								?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="type[]" value="text_date"/>
        </div>
		<?php


	}


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
                <div>
                    <strong><?php _e( 'Label', 'opal-et-field-creator' ) ?></strong>
                </div>
                <div class="option-row-val"><input type="text" name="opal_custom_select_options_label[<?php echo $index ?>][]" class="opallisting-options-label form-control" value=""/></div>
            </div>

            <div class="value-wrap">
                <div>
                    <strong><?php _e( 'Value', 'opal-et-field-creator' ) ?></strong>
                </div>
                <div class="option-row-val"><input type="text" name="opal_custom_select_options_value[<?php echo $index ?>][]" class="opallisting-options-value form-control" value=""/></div>
            </div>
            <div class="col-lg-3 col-md-3 default-wrap">
                <div>
                    <strong><?php _e( 'Default', 'opal-et-field-creator' ) ?></strong>
                </div>
                <div class="option-row-val"><input type="radio" class="opallisting-options-default" <?php echo $checked_default ?> name="opal_custom_select_options_default[<?php echo $index ?>]"
                                                   value="<?php echo $option_index ?>"></div>
            </div>
            <div class="col-lg-1 col-md-1 remove-wrap">
                <a href="#" class="opallisting-remove-option">x</a>
            </div>
        </div>
		<?php

	}


	public function select( $args = [] ) {

		$default = [
			'name'        => '',
			'id'          => '',
			'description' => '',
			'default'     => '',
			'icon_data'   => $this->icon_data,
			'unit'        => '',
			'icon'        => '',
			'icon_class'  => '',
			'i'           => 0,
			'options'     => [],
			'multiple'    => 0,
		];

		$args = array_merge( $default, $args );

		extract( $args );

		?>
        <div class="panel-group select-container">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="toggle-panel">
							<?php _e( 'Select', 'opal-et-field-creator' ) ?> : <?php echo $name ?></a>
                        <a href="#" class="remove-custom-field-item">x</a>
                    </h4>

                </div>
                <div class="panel-body" style="display: none">
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Metakey', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="id[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Meta Key', 'opal-et-field-creator' ) ?>" value="<?php echo $id ?>">
                            <p>
                                <i><?php _e( 'Please enter word not contain blank, special characters. This field is used for search able, it should be lowercase or _ for example: your_key_here' ); ?></i>
                            </p>
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Title', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="name[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Title', 'opal-et-field-creator' ) ?>" value="<?php echo $name; ?>">
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Description', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <textarea name="description[]" class="etf-textarea" placeholder="<?php _e( 'Please Enter Description', 'opal-et-field-creator' ) ?>"><?php echo $description; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Multiple', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="checkbox" name="multiple[<?php echo $i ?>]" class="form-control multiple" value="1" <?php echo $multiple ? "checked" : "" ?> />
                        </div>
                    </div>

                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Options', 'opal-et-field-creator' ) ?></label>
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
                                        <div>
                                            <strong><?php _e( 'Label', 'opal-et-field-creator' ) ?></strong>
                                        </div>
                                        <div class="option-row-val">
                                            <input type="text" name="opal_custom_select_options_label[<?php echo $i ?>][]" class="opallisting-options-label form-control"
                                                   value="<?php echo $option_item ?>"/>
                                        </div>

                                    </div>
                                    <div class="value-wrap">
                                        <div>
                                            <strong><?php _e( 'Value', 'opal-et-field-creator' ) ?></strong>
                                        </div>
                                        <div class="option-row-val">
                                            <input type="text" name="opal_custom_select_options_value[<?php echo $i ?>][]" class="opallisting-options-value form-control"
                                                   value="<?php echo $option_item_key; ?>"/>
                                        </div>

                                    </div>
                                    <div class="col-lg-3 col-md-3 default-wrap">
                                        <div>
                                            <strong><?php _e( 'Default', 'opal-et-field-creator' ) ?></strong>
                                        </div>
                                        <div class="option-row-val">
                                            <input type="radio" class="opallisting-options-default" name="opal_custom_select_options_default[<?php echo $i ?>]" <?php echo $checked ? 'checked' : ''; ?>
                                                   value="<?php echo $index ?>">
                                        </div>

                                    </div>
                                    <div class="col-lg-1 col-md-1 remove-wrap">
                                        <a href="#" class="opallisting-remove-option">x</a>
                                    </div>
                                </div>

								<?php
								$index++;
							}
							?>

                            <a href="#" class="btn btn-info add-new-options"><?php _e( 'Add New Item', 'opal-et-field-creator' ) ?></a>
                        </div>
                    </div>

                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Unit', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="unit[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Unit', 'opal-et-field-creator' ); ?>" value="<?php echo $unit ?>">
                        </div>
                    </div>

                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Icon Class', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="icon_class[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Icon Class', 'opal-et-field-creator' ); ?>"
                                   value="<?php echo $icon_class; ?>">
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Icon', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <select class="fa-icon-picker" name="icon[]">
                                <option value=""></option>
								<?php
								foreach ( $icon_data as $icon_item ) { ?>
                                    <option <?php echo ( $icon == "fa " . $icon_item["class"] ) ? 'selected="selected"' : ""; ?>
                                            value="fa <?php echo $icon_item['class'] ?>"><?php echo $icon_item['class'] ?></option>
									<?php
								}
								?>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
            <input type="hidden" name="type[]" value="select"/>
            <input type="hidden" name="select_id[]" class="opallisting-select-index" value="<?php echo $i; ?>"/>
        </div>
		<?php


	}


	public function checkbox( $args = [] ) {

		$default = [
			'name'        => '',
			'id'          => '',
			'description' => '',
			'default'     => '',
			'icon_data'   => $this->icon_data,
			'unit'        => '',
			'icon'        => '',
			'icon_class'  => '',
		];

		$args = array_merge( $default, $args );

		extract( $args );

		?>
        <div class="panel-group">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="toggle-panel"><?php _e( 'Checkbox', 'opal-et-field-creator' ) ?> : <?php echo $name ?></a>
                        <a href="#" class="remove-custom-field-item">x</a>
                    </h4>

                </div>
                <div class="panel-body" style="display: none">
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Metakey', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="id[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Meta Key', 'opal-et-field-creator' ) ?>" value="<?php echo $id ?>">
                            <p>
                                <i><?php _e( 'Please enter word not contain blank, special characters. This field is used for search able, it should be lowercase or _ for example: your_key_here' ); ?></i>
                            </p>
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Title', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="name[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Title', 'opal-et-field-creator' ) ?>" value="<?php echo $name; ?>">
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Description', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <textarea name="description[]" class="etf-textarea" placeholder="<?php _e( 'Please Enter Description', 'opal-et-field-creator' ) ?>"><?php echo $description ?></textarea>
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Check by default', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="checkbox" name="default[]" class="form-control etf-in" <?php echo $default ? "checked" : ""; ?>
                                   placeholder="<?php _e( 'Please Enter Default', 'opal-et-field-creator' ) ?>" value="1">
                        </div>
                    </div>

                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Unit', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="unit[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Unit', 'opal-et-field-creator' ); ?>" value="<?php echo $unit ?>">
                        </div>
                    </div>

                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Icon Class', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <input type="text" name="icon_class[]" class="form-control etf-in" placeholder="<?php _e( 'Please Enter Icon Class', 'opal-et-field-creator' ); ?>"
                                   value="<?php echo $icon_class; ?>">
                        </div>
                    </div>
                    <div class="form-group-field">
                        <label class="control-label label-field"><?php _e( 'Icon', 'opal-et-field-creator' ) ?></label>
                        <div class="content-field">
                            <select class="fa-icon-picker" name="icon[]">
                                <option value=""></option>
								<?php
								foreach ( $icon_data as $icon_item ) { ?>
                                    <option <?php echo ( $icon == "fa " . $icon_item["class"] ) ? 'selected="selected"' : ""; ?>
                                            value="fa <?php echo $icon_item['class'] ?>"><?php echo $icon_item['class'] ?></option>
									<?php
								}
								?>
                            </select>

                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="type[]" value="checkbox"/>
        </div>
		<?php
	}
}
