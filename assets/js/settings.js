/**
 * Created by DELL on 8/30/2016.
 */



jQuery(document).ready(function($){


    $.ajax({
        type : "post",
        dataType : "json",
        url : myAjax.ajaxurl,
        data : {action: "setting_search"},
        success: function(response) {

            var arr_setting_fields = response.data;

            for(var i=0;i < arr_setting_fields.length;i++){
                $('#'+arr_setting_fields[i]).addClass('search-control');
                $('input[name="'+arr_setting_fields[i]+'_search_type"]').addClass('search-type-ctrl');
            }

            $('.search-type-ctrl').each(function(index, value){

                if($(this).prop("checked")){
                    var val = $(this).val();

                    var name = $(this).attr("name");

                    if( (val === 'select') || (val === 'text') ){
                        var res = name.replace(/_search_type/g, "");

                        var res = res.replace(/_/g, "-");

                        $(".cmb2-id-"+res+"-options-value").show();
                        $(".cmb2-id-"+res+"-min-range").hide();
                        $(".cmb2-id-"+res+"-max-range").hide();
                    }

                    if(val === 'range'){

                        var name = $(this).attr("name");
                        var res = name.replace(/_search_type/g, "");

                        var res = res.replace(/_/g, "-");
                        
                        $(".cmb2-id-"+res+"-options-value").hide();
                        $(".cmb2-id-"+res+"-min-range").show();
                        $(".cmb2-id-"+res+"-max-range").show();
                    }
                }


            });

            $('.search-type-ctrl').on("change", function(){
                var val = $(this).val();

                var name = $(this).attr("name");
                var res = name.replace(/_search_type/g, "");

                var res = res.replace(/_/g, "-");

                if(val == 'range'){
                    $(".cmb2-id-"+res+"-options-value").hide();
                    $(".cmb2-id-"+res+"-min-range").show();
                    $(".cmb2-id-"+res+"-max-range").show();
                }else{
                    $(".cmb2-id-"+res+"-options-value").show();
                    $(".cmb2-id-"+res+"-min-range").hide();
                    $(".cmb2-id-"+res+"-max-range").hide();
                }
            });

        }
    });

});
