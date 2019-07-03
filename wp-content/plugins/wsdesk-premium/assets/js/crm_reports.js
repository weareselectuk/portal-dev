jQuery(function () {
    jQuery("#user").select2({
        width: '30%',
        minimumResultsForSearch: -1
    });
    jQuery('#duration').select2({
        width: '30%',
        minimumResultsForSearch: -1
    })
    jQuery("#show_product").select2({
        width: '30%',
        minimumResultsForSearch: -1,
        maximumSelectionLength: 7,
        allowClear: true,
        placeholder: js_obj.Select_Products_for_Reports,
        formatNoMatches: function () {
            return js_obj.No_Products_Found;
        }
    });
    jQuery("#show_category").select2({
        width: '30%',
        minimumResultsForSearch: -1,
        maximumInputLength:1,
        maximumSelectionLength: 7,
        allowClear: true,
        placeholder: js_obj.Select_Category_for_Reports,
        formatNoMatches: function () {
            return js_obj.No_Category_Found;
        }
    });
    jQuery("#woo_reports_page_view").on("click","#woo_product_report_custom",function(e){
        e.preventDefault();
        jQuery("#woo_product_loader").css("display", "block");
        var show = jQuery("#show_product").val();
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_woo_report_products',
                data : (show !== null) ? show.join(",") : ''
            },
            success: function (data) {
                jQuery("#woo_product_loader").css("display", "none");
                if(show === null)
                {
                    jQuery("#change_product_name").html("Top Products");
                }
                else
                {
                    var content = "";
                    jQuery.each(show, function( index, value ) {
                        if(content === "")
                        {
                            content = jQuery("#show_product option[value='"+value+"']").html();
                        }
                        else
                        {
                            content += ", "+ jQuery("#show_product option[value='"+value+"']").html();
                        }
                    });
                    jQuery("#change_product_name").html(content);
                }
                woo_product_bar_chart.setData(JSON.parse(data));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    jQuery("#woo_reports_page_view").on("click","#woo_category_report_custom",function(e){
        e.preventDefault();
        jQuery("#woo_category_loader").css("display", "block");
        var show = jQuery("#show_category").val();
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_woo_report_category',
                data : (show !== null) ? show.join(",") : ''
            },
            success: function (data) {
                jQuery("#woo_category_loader").css("display", "none");
                if(show === null)
                {
                    jQuery("#change_category_name").html("Top Categories");
                }
                else
                {
                    var content = "";
                    jQuery.each(show, function( index, value ) {
                        if(content === "")
                        {
                            content = jQuery("#show_category option[value='"+value+"']").html();
                        }
                        else
                        {
                            content += ", "+ jQuery("#show_category option[value='"+value+"']").html();
                        }
                    });
                    jQuery("#change_category_name").html(content);
                }
                woo_category_bar_chart.setData(JSON.parse(data));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    jQuery("#duration").change(function(){
        var duration_val = jQuery("#duration").val();
        var now_date = new Date(Date.now());

        switch (duration_val){
            case "last_7":                
                jQuery(".from_date").hide();
                var week_back = new Date(Date.now()-(1000*7*86400));
                var year = week_back.getFullYear();
                var month = (week_back.getMonth()+1);
                month = (month.toString().length==1)?"0"+month:month;
                var date = week_back.getDate();
                date = (date.toString().length==1)?"0"+date:date;
                jQuery("#from_date").val(year+"-"+month+"-"+date);

                jQuery(".to_date").hide();
                year = now_date.getFullYear();
                month = (now_date.getMonth()+1);
                month = (month.toString().length==1)?"0"+month:month;
                date = now_date.getDate();
                date = (date.toString().length==1)?"0"+date:date;
                jQuery("#to_date").val(year+"-"+month+"-"+date);
                break;
            case "last_30":
                jQuery(".from_date").hide();
                var month_back = new Date(Date.now()-(1000*30*86400));
                var year = month_back.getFullYear();
                var month = (month_back.getMonth()+1);
                month = (month.toString().length==1)?"0"+month:month;
                var date = month_back.getDate();
                date = (date.toString().length==1)?"0"+date:date;
                jQuery("#from_date").val(year+"-"+month+"-"+date);

                jQuery(".to_date").hide();
                year = now_date.getFullYear();
                month = (now_date.getMonth()+1);
                month = (month.toString().length==1)?"0"+month:month;
                date = now_date.getDate();
                date = (date.toString().length==1)?"0"+date:date;
                jQuery("#to_date").val(year+"-"+month+"-"+date);
                break;
            case "custom":
                jQuery(".from_date").show();
                jQuery(".to_date").show();
                break;
        }
    });
});