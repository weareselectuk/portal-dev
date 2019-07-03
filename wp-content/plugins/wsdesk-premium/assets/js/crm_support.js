jQuery(document).ready(function (jQuery) {
    load_datepicker_wsdesk();
    jQuery(".eh_crm_support_main").on('click', "#left_page", function(e){
        var current_page = jQuery(".wsdesk_current_page").attr('id');
        jQuery(".wsdesk_current_page").html(+current_page - 1);
        jQuery(".wsdesk_current_page").attr('id', +current_page - 1);
        jQuery(".table_loader").css("display", "inline");
        eh_crm_check_ticket_request(this);
    });
    jQuery(".eh_crm_support_main").on('click', "#right_page", function(e){
        var current_page = jQuery(".wsdesk_current_page").attr('id');
        jQuery(".wsdesk_current_page").html(+current_page + 1);
        jQuery(".wsdesk_current_page").attr('id', +current_page + 1);
        jQuery(".table_loader").css("display", "inline");
        eh_crm_check_ticket_request(this);
    });
    jQuery(".eh_crm_support_main").on('click', '.filter_label', function(e){
        jQuery(".wsdesk_current_page").attr('id', 1);
        jQuery(".wsdesk_current_page").html(1);
        jQuery('#filter_label_input').val(jQuery(this).attr('id'));
        jQuery(".table_loader").css("display", "inline");
        eh_crm_check_ticket_request(this);
    });
    jQuery(".eh_crm_support_main").on('keyup', '#search_tickets', function(e){
        if(e.keyCode == 13)
        {
            jQuery(".wsdesk_current_page").html(1);
            jQuery(".wsdesk_current_page").attr('id', 1);
            jQuery(".table_loader").css("display", "inline");
            eh_crm_check_ticket_request(this);
        }
    });
    jQuery(".eh_crm_support_main").on('click', "#search_ticket_icon", function(e){
        jQuery(".wsdesk_current_page").html(1);
        jQuery(".wsdesk_current_page").attr('id', 1);
        jQuery(".table_loader").css("display", "inline");
        eh_crm_check_ticket_request(this);
    });
    jQuery(document).on('click',".ticket_select_all_check", function (e)
    {
        if (this.checked)
        {
            jQuery('#submit_check_all').show();
            jQuery(".ticket_select_check").prop("checked", true);
            jQuery(".ticket_select_all_check").prop("checked", true);
        } else
        {
            jQuery('#submit_check_all').hide();
            jQuery('.ticket_select_check').removeProp("checked",true);
        }
    });
    jQuery(document).on("change", ".ticket_select_check", function (e)
    {
        jQuery('#submit_check_all').show();
        jQuery(".ticket_select_all_check").removeProp("checked",true);
        var all_uncheked = true;
        jQuery('.ticket_select_check').each(function () {
                if(this.checked){
                    all_uncheked = false;
                }
            });
            
        if (!all_uncheked)
        {
            jQuery('#submit_check_all').show();
        } 
        else
        {
            jQuery('#submit_check_all').hide();
        }
    });
    jQuery(document).on("click", "#submit_check_all" , function(e)
    {
        var slug = jQuery("#custom_fields").val();
        var value = [];
        i = 0;
        jQuery('.ticket_select_check').each(function () 
        {   
            if(this.checked)
            {
                value[i] = jQuery(this).val();
                i++;  
            }
        }); 
        var id = JSON.stringify(value);
        jQuery(".table_loader").css("display", "inline");
        jQuery.ajax
        ({
            type: 'post',
            url: support_object.ajax_url,
            data:
            {
                action: 'eh_crm_ticket_close_check_request',
                val : id,
                slug:slug,
            },
            success:function(data)
            {
                eh_crm_check_ticket_request(this);
            }
        });
    });
    if(jQuery('.eh_crm_support_main').hasClass("load_wsdesk_request_ticket_directly"))
    {
            var current_url = window.location.href;
            var ticket_id = $_GET("customer_ticket_num");
            jQuery(".loaderDirect").css("display", "none");
            jQuery.ajax({
                type: 'post',
                url: support_object.ajax_url,
                data: {
                    action: 'eh_crm_ticket_single_view_client',
                    ticket_id: ticket_id
                },
                success: function (data) {
                    //jQuery(".table_loader").css("display", "none");
                    jQuery('.ticket_load_content').html(data);
                    jQuery('.reply_textarea').each(function () {
                        this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
                    }).on('input', function () {
                        this.style.height = 'auto';
                        this.style.height = (this.scrollHeight) + 'px';
                    });
                    jQuery('html, body').animate({
                        scrollTop: jQuery("hr").offset().top
                    }, 300);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        
    };
    
    if(jQuery('.eh_crm_support_main').hasClass("load_wsdesk_request_directly"))
    {
        var slug = jQuery("#custom_fields").val();
        jQuery.ajax({
            type: "POST",
            url: support_object.ajax_url,
            data: {
                action: 'eh_crm_check_ticket_request',
                slug:slug,
                url:window.location.pathname
            },
            success: function (data)
            {
                jQuery('.loaderDirect').css("display","none");
                var parse = JSON.parse(data);
                if(parse.status == 'success')
                {
                    jQuery('.ticket_table_wrapper').html(parse.content);
                    if(jQuery(".tickets_panel").height() < 190)
                    {
                        jQuery(".tickets_panel").height(190);
                    }
                }
                else
                {
                    window.location.href = parse.url;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
    var timeoutID = null;
    function findSuggestion(str) {
        if(str != "")
        {
            jQuery.ajax({
                type: "POST",
                url: support_object.ajax_url,
                data: {
                    action: 'eh_crm_search_post',
                    q:str
                },
                success: function (data)
                {
                    var parse = JSON.parse(data);
                    if(parse.total_count !=0)
                    {
                        var count = (parse.total_count <= 10)?parse.total_count:10;
                        var html = '<br>'+parse.message+'<span class="crm-divider"></span>';
                        html += '<ul class="search-ac">';
                        var items = parse.items;
                        for(i=0;i<count;i++)
                        {
                            html+='<li><a href="'+items[i]['guid']+'">'+items[i]['title']+'</a> ( <span>'+items[i]['type']+'</span> )<br><small>'+items[i]['content']+'</small></li><span class="crm-divider"></span>';
                        }
                        html+='</ul>';
                        jQuery(".auto_suggestion_posts").html(html).show('fast');
                    }
                }
            });
        }
        else
        {
            jQuery(".auto_suggestion_posts").hide('fast');
            jQuery(".auto_suggestion_posts").html("");
        }
    }
    jQuery('.eh_crm_support_main').on('keyup',"#request_title",function(e) {
        if(jQuery(".auto_suggestion_posts").length != 0)
        {
            clearTimeout(timeoutID);
            timeoutID = setTimeout(findSuggestion.bind(undefined, e.target.value), 500);
        }
    });
  
    jQuery('.eh_crm_support_main').on('submit','form#eh_crm_ticket_form',function (e) {
        var btn = jQuery("#crm_form_submit");
        btn.prop("disabled","disabled");
        var fd = new FormData();
        if(jQuery(".ticket_attachment").length !=0 )
        {
            var k=0;
            var file = jQuery(".ticket_attachment");
            jQuery.each(jQuery(file), function (i, obj) {
                jQuery.each(obj.files, function (j, file) {
                    fd.append('file[' + k + ']', file);
                    k++;
                });
            });
        }
        fd.append("form", jQuery(this).serialize());
        fd.append('action', 'eh_crm_new_ticket_post');
        jQuery.ajax({
            type: "POST",
            url: support_object.ajax_url,
            processData: false,
            contentType: false,
            data:fd, // serializes the form's elements.
            success: function (data)
            {
                btn.removeProp("disabled");
                if(data === "captcha_failed")
                {
                    jQuery(".captcha-error").html("Please verify that you are not a robot.");
                }
                else
                {
                    var parse_data = JSON.parse(data);

                    if(parse_data.status=='success')
                    {
                        jQuery('.main_new_suppot_request_form').html('<div><p style="color: green">'+parse_data.message+'</p></div><div class="wsdesk_wrapper"><div class="eh_crm_support_main load_wsdesk_request_directly"><div class="submited_ticket_table_wrapper"></div></div></div>');
                        jQuery(".wsdesk_new_ticket_view").hide();
                        var slug = jQuery("#custom_fields").val();
                        if(typeof slug == 'undefined')
                        {
                            slug = '';
                        }
                    }
                    else if(parse_data.status == 'redirect')
                    {
                        window.location.href = parse_data.link;
                    }
                    else
                    {
                        jQuery('.main_new_suppot_request_form').append("<div class='wsdesk_error_message' style='color: red'>"+parse_data.message+"</div>");
                    }
                }
            }
        });
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });
    jQuery('.eh_crm_support_main').on('click', 'button.eh_crm_new_request', function (e) {
        //jQuery("div .spinner").show();
        var btn = jQuery(this);
        jQuery('.tickets_panel').hide();
        btn.prop("disabled","disabled");
        // business logic...
        jQuery.ajax({
            type: "POST",
            url: support_object.ajax_url,
            data: {
                action: 'eh_crm_new_ticket_form'
            },
            success: function (data)
            {
                btn.removeProp("disabled");
                jQuery('.support_option_choose').hide();
                jQuery('.eh_crm_support_main').append(data);
                jQuery('textarea').each(function () {
                    this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
                }).on('input', function () {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });
                load_datepicker_wsdesk();

            }
        });
        e.preventDefault();
    });
    setInterval(function()
    {
        if(jQuery(".single_ticket_panel").length != 0)
        {
            eh_crm_check_section_data();
        }
    }, 60000);
    
    function eh_crm_check_section_data()
    {
        var ticket_id = jQuery(".single_ticket_panel").prop("id");
        jQuery.ajax({
            type: "POST",
            url: support_object.ajax_url,
            data: {
                action: 'eh_crm_ticket_client_section_load',
                ticket_id:ticket_id
            },
            success: function (data)
            {
                jQuery('.comment-list').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
    
    function eh_crm_check_ticket_request(comp)
    {
        var slug = jQuery("#custom_fields").val();
        if(typeof slug == 'undefined')
        {
            slug = '';
        }
        var btn = jQuery(comp);
        btn.prop("disabled","disabled");
        jQuery.ajax({
            type: "POST",
            url: support_object.ajax_url,
            data: {
                action: 'eh_crm_check_ticket_request',
                slug:slug,
                url:window.location.pathname,
                wsdesk_current_page: jQuery(".wsdesk_current_page").attr('id'),
                label: jQuery("#filter_label_input").val(),
                search_tickets: jQuery('#search_tickets').val()
            },
            success: function (data)
            {
                btn.removeProp("disabled");
                jQuery('.support_option_choose').hide();
                var parse = JSON.parse(data);
                if(parse.status == 'success')
                {
                    jQuery('.ticket_table_wrapper').html(parse.content);
                }
                else
                {
                    window.location.href = parse.url;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
    jQuery('.eh_crm_support_main').on('click', 'button.eh_crm_support_back', function (e) {
        jQuery("div .spinner").show();
        jQuery('.main_new_suppot_request_form').remove();
        jQuery('.support_option_choose').show();
        jQuery("div .spinner").hide();
    });
    jQuery(".eh_crm_support_main").on("click", ".ticket_reply_action_button", function (e) {
        e.preventDefault();
        var ticket_id = jQuery(this).prop("id");
        var text = jQuery("#reply_textarea_" + ticket_id).val();
        if (text !== "")
        {
            jQuery(".ticket_loader").css("display", "inline");
            var btn = jQuery(this);
            btn.prop("disabled","disabled");
            jQuery("#reply_textarea_" + ticket_id).css("border", "1px solid #F2F2F2");
            var fd = new FormData();
            var file = jQuery("#files_" + ticket_id);
            jQuery.each(jQuery(file), function (i, obj) {
                jQuery.each(obj.files, function (j, file) {
                    fd.append('file[' + j + ']', file);
                });
            });
            if(jQuery("#ticket_select_check_"+ticket_id).prop('checked') == true){
                fd.append("close", "close");
            }
            else
            {
                fd.append("close", "");
            }
            fd.append("ticket_reply", text);
            fd.append("ticket_id", ticket_id);
            fd.append('action', 'eh_crm_ticket_reply_raiser');
            jQuery.ajax({
                type: 'POST',
                url: support_object.ajax_url,
                data: fd,
                processData: false,
                contentType: false,
                success: function (data) {
                    jQuery(".ticket_loader").css("display", "none");
                    btn.removeProp("disabled");
                    var parse = JSON.parse(data);
                    if(parse.status=="error")
                    {
                        jQuery('.newMsgFull').append("<div class='wsdesk_error_message' style='color: red'>"+parse.message+"</div>");
                    }
                    else
                    {
                        jQuery(".ticket_load_content").html(parse.ticket);
                        jQuery('.reply_textarea').each(function () {
                            this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
                        }).on('input', function () {
                            this.style.height = 'auto';
                            this.style.height = (this.scrollHeight) + 'px';
                        });
                    }
                }
            });
        } else
        {
            jQuery("#reply_textarea_" + ticket_id).css("border", "1px solid red");
        }
    });
    jQuery(".eh_crm_support_main").on('click',"#suggestion-tab",function(e) {
        e.preventDefault();
        var id=jQuery(this).prop("class");
        jQuery(".suggest-form-"+id).toggle("slide");
    });
    jQuery(".eh_crm_support_main").on('click',".suggest_li",function() {
        var id=jQuery(this).prop("id");
        var title = jQuery(this).children("#sug_title").html();
        var link = jQuery(this).children("#sug_url").html();
        var txt = jQuery("#reply_textarea_" + id);
        var caretPos = txt[0].selectionStart;
        var textAreaTxt = txt.val();
        var txtToAdd = title + "\n" + link + "\n";
        txt.val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos) );
    });
    function previewFiles(files, id) {

        function readAndPreview(file) {
            // Make sure `file.name` matches our extensions criteria
            if (/\.(jpe?g|png|gif|mp4|mp3|3gp|avi|wmv|mpg|mov|flv|syx|rtf)$/i.test(file.name)) {
                var reader = new FileReader();
                reader.addEventListener("load", function () {
                    var img_html = '<a href="' + this.result + '" target="_blank"><img class="img-upload clickable" style="width:150px" title="' + file.name + '" src=' + this.result + '></a>';
                    jQuery(".upload_preview_" + id).append(img_html);
                }, false);

                reader.readAsDataURL(file);
            } else
            {
                if (/\.(doc?x|pdf|xml|csv|xls?x|txt|zip)$/i.test(file.name)) {
                    var ext = (file.name).substr((file.name).lastIndexOf('.') + 1);
                    var reader = new FileReader();

                    reader.addEventListener("load", function () {
                        var img_html = '<a href="' + this.result + '" target="_blank" title="' + file.name + '" class="img-upload"><div class="' + ext + '"></div></a>';
                        jQuery(".upload_preview_" + id).append(img_html);
                    }, false);

                    reader.readAsDataURL(file);
                } else
                {
                    jQuery("#" + id).val("");
                    jQuery("#" + id).trigger("change");
                }
            }
        }

        if (files) {
            [].forEach.call(files, readAndPreview);
        }
    }
    jQuery("body").on('click', ".attachment_reply", function () {
        var file_id = jQuery(this).prop("id");
        jQuery("#" + file_id).val("");
        jQuery("#" + file_id).trigger("change");
    });
    jQuery("body").on('change', ".attachment_reply", function () {
        var file_id = jQuery(this).prop("id");
        previewFiles(jQuery("#" + file_id).prop("files"), file_id);
        jQuery(".upload_preview_" + file_id).empty();
    });
});
function load_datepicker_wsdesk()
{
    jQuery('.trigger_date_jq').each(function(){
        var id=jQuery(this).prop('id');
        jQuery("#"+id).datepicker({
            beforeShow: function(input, inst) {
                var pick = jQuery('#ui-datepicker-div');
                if(!jQuery(pick).parent().hasClass('wsdesk_date'))
                {
                    jQuery('#ui-datepicker-div').wrap('<div class="wsdesk_date"></div>');
                }
            }
        });
    });
}
function $_GET(param) {
    var vars = {};
    window.location.href.replace( location.hash, '' ).replace( 
        /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
        function( m, key, value ) { // callback
            vars[key] = value !== undefined ? value : '';
        }
    );

    if ( param ) {
        return vars[param] ? vars[param] : null;    
    }
    return vars;
}