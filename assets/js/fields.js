
jQuery(document).ready(function($){

    $('.fa-icon-picker').fontIconPicker({});

    var etfields_container = $(".listing-creator-custom-fields .content-fields");

    etfields_container.on("click", ".opallisting-remove-option", function(e){
        e.preventDefault();
        var remove_element_container = $(this).closest(".options-container");
        $(this).closest(".option-row").remove();

        remove_element_container.find("input.opallisting-options-default").each(function(index){
            $(this).val(index);
        });

    });

    etfields_container.on('click', '.panel-title', function(e){
        e.preventDefault();
        $(this).closest(".panel-group").find(".panel-body").slideToggle();
    });

    etfields_container.on("click", ".remove-custom-field-item", function(e){
        e.preventDefault();
        $(this).closest(".panel-group").remove();

        // rename select options
        $('.select-container').each(function (index, value) {
            $(this).find('input.opallisting-options-label').attr("name", "opal_custom_select_options_label["+index+"][]");
            $(this).find('input.opallisting-options-value').attr("name", "opal_custom_select_options_value["+index+"][]");
            $(this).find('input.opallisting-options-default').attr("name", "opal_custom_select_options_default["+index+"][]");
            $(this).find('input.multiple').attr("name", "multiple["+index+"]");
            $(this).find('input.opallisting-select-index').val(index);

        });
    });

    $("#reset-default").on("click", function(e){
        e.preventDefault();
        $("#in-reset-default").val(1);
        $("#save-etfields").trigger("click");
    });

    $(".create-et-field-btn").on("click", function(e){
        e.preventDefault();

        var nonce = $(this).attr("data-nonce");
        var type_field = $(this).data('type');

        $.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : {action: "creator_custom_type", type : type_field, nonce: nonce},
            success: function(response) {
                if(response.type == "success") {
                    if(type_field == 'select'){
                        var index_select = $("input.opallisting-select-index").length;
                        etfields_container.append(response.html);
                        $(".select-container:last").find("input.opallisting-select-index").val(index_select);
                        $(".select-container:last").find("input.multiple").attr("name", "multiple["+index_select+"]");
                    }else{
                        etfields_container.append(response.html);
                    }
                    $('.fa-icon-picker').fontIconPicker({});
                }
                else {
                    alert("Error please try again");
                }
            }
        });
    });


    etfields_container.on("click", ".add-new-options", function(e){
        e.preventDefault();

        var option_container = $(this).closest('.select-container').find(".options-container");

        var add_new_option = $(this);

        var index = $(this).closest('.select-container').find("input.opallisting-select-index").val();

        var option_index = $(this).closest('.select-container').find("input.opallisting-options-default").length;

        var checked_default = '';
        if(option_index == 0){
            checked_default = 'checked';
        }

        $.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : {action: "create_option_select", index : index, checked_default : checked_default, option_index: option_index},
            success: function(response) {
                if(response.type == "success") {
                    var option_html = response.html;
                    $(option_html).insertBefore(add_new_option);
                }
                else {
                    alert("Error please try again");
                }
            }
        });
    });


    $("#save-etfields").on("click", function(e){
        e.preventDefault();

        var meta_key = [];

        var submit_flag = 1;

        if(submit_flag){
            var length_input_id = $("input[name='id[]']").length;

            for(var i = 0;i< length_input_id;i++){

                var input_element = $("input[name='id[]']").eq(i);

                var val_id = input_element.val();

                if(!val_id){
                    submit_flag = 0;
                    if ( input_element.is(':hidden')){
                        input_element.closest(".panel").find(".panel-title").trigger("click");
                    }

                    $('html, body').animate({
                        scrollTop: input_element.closest(".panel-group").offset().top
                    }, 1000);

                    input_element.focus();
                    break;
                }
            }
        }

        if(submit_flag){
            var length_input_name = $("input[name='name[]']").length;

            for(var i = 0;i< length_input_name;i++){

                var input_element = $("input[name='name[]']").eq(i);

                var val_name = input_element.val();

                if(!val_name){
                    submit_flag = 0;
                    if ( input_element.is(':hidden')){
                        input_element.closest(".panel").find(".panel-title").trigger("click");
                    }

                    $('html, body').animate({
                        scrollTop: input_element.closest(".panel-group").offset().top
                    }, 1000);

                    input_element.focus();
                    break;
                }
            }
        }

        if(submit_flag){
            var length_input_id = $("input[name='id[]']").length;

            for(var i = 0;i< length_input_id;i++){

                var input_element = $("input[name='id[]']").eq(i);

                var val_id = input_element.val();

                if(meta_key.indexOf(val_id) > -1){
                    submit_flag = 0;

                    if(!input_element.css("border") == "1px solid red"){
                        input_element.css("border","1px solid red");
                    }

                    if(!input_element.closest(".panel-body").find("p.error-message").length){
                        input_element.after('<p style="color:red" class="error-message">Duplicate meta key '+input_element.val()+'</p>');
                    }else{
                        input_element.closest(".panel-body").find("p.error-message").remove();
                        input_element.after('<p style="color:red" class="error-message">Duplicate meta key '+input_element.val()+'</p>');
                    }

                    if ( input_element.is(':hidden')){
                        input_element.closest(".panel").find(".panel-title").trigger("click");
                    }

                    $('html, body').animate({
                        scrollTop: input_element.closest(".panel-group").offset().top
                    }, 1000);

                    input_element.focus();
                    break;
                }

                if(val_id){
                    meta_key.push(val_id);
                }

            }

        }

        if(submit_flag){
            $("form[name='opal-etfields-form']").submit();
        }

    });


});
