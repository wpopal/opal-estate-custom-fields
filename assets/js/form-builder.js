jQuery( document ).ready( function ( $ ) {
    var custom_fields_container = $( '.listing-creator-custom-fields .content-fields' );

    custom_fields_container.on( 'click', '.form-builder-remove-option', function ( e ) {
        e.preventDefault();
        var remove_element_container = $( this ).closest( '.options-container' );
        $( this ).closest( '.option-row' ).remove();

        remove_element_container.find( 'input.options-default' ).each( function ( index ) {
            $( this ).val( index );
        } );
    } );

    if ( custom_fields_container.length ) {
        custom_fields_container.sortable( { cursor: 'move' } ).disableSelection();
    }

    function form_key_change() {
        custom_fields_container.find( '.input-title' ).on( 'input', function () {
            var $el = $( this );
            var $title = $el.closest( '.panel-group' ).find( '.toggle-panel span' );
            $title.html( $el.val() );
        } );
    }

    form_key_change();

    function iconpicker_init() {
        custom_fields_container.find( '.opalestate-iconpicker' ).each( function () {
            $( this ).fontIconPicker();
        } );
    }
    iconpicker_init();

    custom_fields_container.on( 'click', '.panel-title', function ( e ) {
        e.preventDefault();
        $( this ).closest( '.panel-group' ).find( '.panel-body' ).slideToggle();
    } );

    custom_fields_container.on( 'click', '.remove-custom-field-item', function ( e ) {
        e.preventDefault();
        $( this ).closest( '.panel-group' ).remove();

        // rename select options
        $( '.select-container' ).each( function ( index, value ) {
            $( this )
                .find( 'input.options-label' )
                .attr( 'name', 'select_options_label[' + index + '][]' );
            $( this )
                .find( 'input.options-value' )
                .attr( 'name', 'select_options_value[' + index + '][]' );
            $( this )
                .find( 'input.options-default' )
                .attr( 'name', 'select_options_default[' + index + '][]' );
            $( this ).find( 'input.multiple' ).attr( 'name', 'multiple[' + index + ']' );
            $( this ).find( 'input.select-index' ).val( index );

        } );
    } );

    // $( '#reset-default' ).on( 'click', function ( e ) {
    //     e.preventDefault();
    //     $( '#in-reset-default' ).val( 1 );
    //     $( '#save-etfields' ).trigger( 'click' );
    // } );

    $( '.reset-button' ).on( 'click', function ( e ) {
        e.preventDefault();
        if ( confirm( opalestateCTF.text.confirm_reset_text ) == true ) {
            custom_fields_container.find( '.panel-group' ).remove();
        }
    } );

    $( '.create-et-field-btn' ).on( 'click', function ( e ) {
        e.preventDefault();

        var nonce = $( this ).attr( 'data-nonce' );
        var type_field = $( this ).data( 'type' );

        $.ajax( {
            type: 'post',
            dataType: 'json',
            url: ajaxurl,
            data: {
                action: 'creator_custom_type',
                type: type_field,
                nonce: nonce
            },
            success: function ( response ) {
                if ( response.type == 'success' ) {
                    if ( type_field == 'select' ) {
                        var index_select = $( 'input.select-index' ).length;
                        custom_fields_container.append( response.html );
                        $( '.select-container:last' ).find( 'input.select-index' ).val( index_select );
                        $( '.select-container:last' )
                            .find( 'input.multiple' )
                            .attr( 'name', 'multiple[' + index_select + ']' );
                    } else {
                        custom_fields_container.append( response.html );
                    }
                    form_key_change();
                    iconpicker_init();
                } else {
                    alert( opalestateCTF.text.try_again );
                }
            }
        } );
    } );

    custom_fields_container.on( 'click', '.add-new-options', function ( e ) {
        e.preventDefault();

        var option_container = $( this ).closest( '.select-container' ).find( '.options-container' );

        var add_new_option = $( this );

        var index = $( this ).closest( '.select-container' ).find( 'input.select-index' ).val();

        var option_index = $( this ).closest( '.select-container' ).find( 'input.options-default' ).length;

        var checked_default = '';
        if ( option_index == 0 ) {
            checked_default = 'checked';
        }

        $.ajax( {
            type: 'post',
            dataType: 'json',
            url: ajaxurl,
            data: {
                action: 'create_option_select',
                index: index,
                checked_default: checked_default,
                option_index: option_index
            },
            success: function ( response ) {
                if ( response.type == 'success' ) {
                    var option_html = response.html;
                    $( option_html ).insertBefore( add_new_option );
                } else {
                    alert( opalestateCTF.text.try_again );
                }
            }
        } );
    } );

    $( '#save-etfields' ).on( 'click', function ( e ) {
        e.preventDefault();

        var meta_key = [];

        var submit_flag = 1;

        if ( submit_flag ) {
            var length_input_id = $( 'input[name=\'id[]\']' ).length;

            for ( var i = 0; i < length_input_id; i++ ) {

                var input_element = $( 'input[name=\'id[]\']' ).eq( i );

                var val_id = input_element.val();

                if ( !val_id ) {
                    submit_flag = 0;
                    if ( input_element.is( ':hidden' ) ) {
                        input_element.closest( '.panel' ).find( '.panel-title' ).trigger( 'click' );
                    }

                    $( 'html, body' ).animate( {
                        scrollTop: input_element.closest( '.panel-group' ).offset().top
                    }, 1000 );

                    input_element.focus();
                    break;
                }
            }
        }

        if ( submit_flag ) {
            var length_input_name = $( 'input[name=\'name[]\']' ).length;

            for ( var i = 0; i < length_input_name; i++ ) {

                var input_element = $( 'input[name=\'name[]\']' ).eq( i );

                var val_name = input_element.val();

                if ( !val_name ) {
                    submit_flag = 0;
                    if ( input_element.is( ':hidden' ) ) {
                        input_element.closest( '.panel' ).find( '.panel-title' ).trigger( 'click' );
                    }

                    $( 'html, body' ).animate( {
                        scrollTop: input_element.closest( '.panel-group' ).offset().top
                    }, 1000 );

                    input_element.focus();
                    break;
                }
            }
        }

        if ( submit_flag ) {
            var length_input_id = $( 'input[name=\'id[]\']' ).length;

            for ( var i = 0; i < length_input_id; i++ ) {

                var input_element = $( 'input[name=\'id[]\']' ).eq( i );

                var val_id = input_element.val();

                if ( meta_key.indexOf( val_id ) > -1 ) {
                    submit_flag = 0;

                    if ( !input_element.css( 'border' ) == '1px solid red' ) {
                        input_element.css( 'border', '1px solid red' );
                    }

                    if ( !input_element.closest( '.panel-body' ).find( 'p.error-message' ).length ) {
                        input_element.after(
                            '<p class="form-builder-error-message">' + opalestateCTF.text.duplicate_meta_key +
                            ' <strong>' + input_element.val() +
                            '</strong></p>' );
                    } else {
                        input_element.closest( '.panel-body' ).find( 'p.error-message' ).remove();
                        input_element.after(
                            '<p class="form-builder-error-message">' + opalestateCTF.text.duplicate_meta_key +
                            ' <strong> ' + input_element.val() +
                            '</strong></p>' );
                    }

                    if ( input_element.is( ':hidden' ) ) {
                        input_element.closest( '.panel' ).find( '.panel-title' ).trigger( 'click' );
                    }

                    $( 'html, body' ).animate( {
                        scrollTop: input_element.closest( '.panel-group' ).offset().top
                    }, 1000 );

                    input_element.focus();
                    break;
                }

                if ( val_id ) {
                    meta_key.push( val_id );
                }
            }
        }

        if ( submit_flag ) {
            $( 'form[name=\'opal-etfields-form\']' ).submit();
        }
    } );
} );
