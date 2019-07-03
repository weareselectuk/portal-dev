var toolbarOptions = [
    [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
    ['bold', 'italic', 'underline'],        // toggled buttons
    ['blockquote', 'code-block'],              // custom button values
    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
    [{ 'font': [] }],
    [{ 'align': [] }],
    ['link'],
    ['clean']                                         // remove formatting button
    ];
jQuery(function () {
    jQuery(".wsdesk-overlay-success").hide();
    jQuery(".textarea").each(function(){
        if(!jQuery(this).hasClass('except_rich'))
        {
            
            var quill = new Quill('#'+jQuery(this).prop('id'), {
                theme: 'snow',
                modules: { toolbar: toolbarOptions}
            });
        }
    });
    if(jQuery(".direct_load_tid").length!==0)
    {
        //var id = jQuery(".direct_load_tid").prop("id");
        var id = jQuery(".direct_load_tid").prop("id").split("tab_content_").pop();
        trigger_load_single_ticket(id);
    }
    // attach table filter plugin to inputs
    jQuery('[data-action="filter"]').filterTable();

    jQuery('#tickets_page_view').on('click', '.tickets_panel span.filter', function (e) {
        var $this = jQuery(this),
                $panel = $this.parents('.panel');

        $panel.find('.tickets_panel > .panel-body').slideToggle();
        if ($this.css('display') !== 'none') {
            $panel.find('.tickets_panel > .panel-body input').focus();
        }
    });
    jQuery('[data-toggle="wsdesk_tooltip"]').wstooltip({trigger : 'hover'});
    collapse_tab();
    jQuery("#default_assignee_ticket").select2({
        width: '100%',
        minimumResultsForSearch: -1
    });
    jQuery('#assignee_ticket_edit').select2({
        dropdownParent: jQuery('#edit_tickets_modal'),
        width: '98%',
        allowClear: true,
        placeholder: js_obj.Select_Assignee,
        formatNoMatches: function () {
            return "0";
        },
        language: {
            noResults: function (params) {
                return "0";
            }
        }
    });
    jQuery('#tags_ticket_edit').select2({
        dropdownParent: jQuery('#edit_tickets_modal'),
        width: '98%',
        allowClear: true,
        placeholder: js_obj.Select_Label,
        formatNoMatches: function () {
            return "0";
        },
        language: {
            noResults: function (params) {
                return "0";
            }
        }
    });
});
function trigger_load_single_ticket(ticket_id)
{
    assignee_select2_init("#assignee_ticket_" + ticket_id);
    tag_select2("#tags_ticket_" + ticket_id);
    if(jQuery(".cc_select_" + ticket_id).length != 0)
    {
        cc_select2("#cc_ticket_" + ticket_id);
    }
    if(jQuery(".bcc_select_" + ticket_id).length != 0)
    {
        bcc_select2("#bcc_ticket_" + ticket_id);
    }
    jQuery('.ticket_input_date_'+ticket_id).datepicker({
        beforeShow: function(input, inst) {
            var pick = jQuery('#ui-datepicker-div');
            if(!jQuery(pick).parent().hasClass('wsdesk_date'))
            {
                jQuery('#ui-datepicker-div').wrap('<div class="wsdesk_date"></div>');
            }
        }
    });
    new Quill('#reply_textarea_'+ticket_id, {theme: 'snow', modules: {toolbar: toolbarOptions}});
    if(typeof Cookies.get("reply_textarea_" + ticket_id) != 'undefined')
    {
        jQuery("#reply_textarea_" + ticket_id+' > .ql-editor').html(Cookies.get("reply_textarea_" + ticket_id));
    }
    jQuery('#reply_textarea_'+ticket_id+' > .ql-editor').on('blur', function() {
        if(typeof jQuery("#reply_textarea_" + ticket_id+' > .ql-editor') != 'undefined'  && jQuery("#reply_textarea_" + ticket_id+' > .ql-editor').html()!='<br>')
        {
            addToCookie("reply_textarea_" + ticket_id,jQuery("#reply_textarea_" + ticket_id+' > .ql-editor').html());            
        }
    });
}
function height_adjust(e) {
    jQuery(e).css({'height': 'auto', 'overflow-y': 'hidden'}).height(e.scrollHeight);
}
function assignee_select2_init(id)
{
    jQuery(id).select2({
        width: '100%',
        allowClear: true,
        placeholder: "Select Assignee",
        formatNoMatches: function () {
            return "No Assignee";
        },
        language: {
            noResults: function (params) {
                return "No Assignee";
            }
        }
    });
}
jQuery(function () {
    
    //Template Section
    jQuery(".tab-content").on('click',"#create_new_template",function(e) {
        e.preventDefault();
        var title = jQuery("#new_template_title").val();
        if(title === "")
        {
            jQuery("#new_template_title").css("border", "1px solid red");
            return;
        }
        var btn=jQuery(this);
        btn.prop("disabled","disabled");
        var textAreaTxt = jQuery('#new_template_content > .ql-editor').html();
        jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'eh_crm_ticket_new_template',
                    title: title,
                    content : textAreaTxt
                },
                success: function (data) {
                    jQuery(".alert-success").css("display", "block");
                    jQuery(".alert-success").css("opacity", "1");
                    jQuery("#success_alert_text").html("<strong>"+js_obj.WSDesk_Templates_Notification+"</strong><br>"+js_obj.WSDesk_Templates_Added+"!");
                    window.setTimeout(function () {
                        jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                            jQuery(this).css("display", "none");
                        });
                    }, 4000);
                    jQuery('#new_template_model').modal('hide');
                    jQuery("#template_multiple_actions li:nth-child(2").after(data);
                    jQuery('#new_template_content > .ql-editor').html("");
                    jQuery("#new_template_title").val("");
                    jQuery(".mulitple_ticket_template_button").trigger('click');
                    btn.removeProp("disabled");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    btn.removeProp("disabled");
                }
            });
    });
    jQuery( document ).on("change", ".all_ticket_ids", function(){
        jQuery(".merge_ticket_verify").removeProp("disabled");
        jQuery(".merge_ticket_confirm").prop("disabled", true);
    });
    jQuery(document).on("click", ".merge_ticket_confirm", function(){
        var parent_id = document.getElementById('hidden_ticket_id').value;
        var ticket_ids = jQuery("#merge_hidden_ticket_ids_"+parent_id).val();
        jQuery(".merge_ticket_confirm").prop("disabled", true);
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data:{
                action: 'eh_crm_confirm_merge_tickets',
                ticket_ids: ticket_ids,
                parent_id: parent_id,
                pagination_id: jQuery("#pagination_ids_traverse").val()
            },
            success: function(data){
                
                jQuery("#ticket_merge_modal_"+parent_id).modal('hide');
                jQuery('body').removeClass('modal-open');
                jQuery('.modal-backdrop').remove();
                parse = jQuery.parseJSON(data);
                var tab_head = parse.tab_head;
                var tab_content = parse.tab_content;
                refresh_left_bar();
                refresh_right_bar();
                jQuery("#tab_" + parent_id).html(tab_head);
                jQuery("#tab_content_" + parent_id).html(tab_content);
                jQuery(".alert-success").css("display", "block");
                jQuery(".alert-success").css("opacity", "1");
                jQuery("#success_alert_text").html("<strong>"+js_obj.WSDesk_Tickets_Notification+"</strong><br>Ticket " + ticket_ids + " "+js_obj.Merged_Successfully+"!");
                window.setTimeout(function () {
                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                        jQuery(this).css("display", "none");
                    });
                }, 4000);
                trigger_load_single_ticket(parent_id);
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown);
            }
        });
    });
    jQuery( document ).on("click", ".merge_ticket_verify", function(){
        var parent_id = document.getElementById('hidden_ticket_id').value;
        var ticket_ids = JSON.stringify(jQuery("#all_ticket_ids_"+parent_id).val());
        jQuery(".merge_ticket_verify").prop("disabled",true);
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data:{
                action: 'eh_crm_verify_merge_tickets',
                ticket_ids: ticket_ids,
                parent_id: parent_id
            },
            success: function(data)
            {
                jQuery("#merge_hidden_ticket_ids_"+parent_id).val(ticket_ids);
                jQuery(".merge_ticket_confirm").removeProp("disabled");
                jQuery(".verify").html(data);   
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }

        });
    });
    jQuery("#edit_tickets_modal").on('click','#bulk_edit_submit',function(e){
        jQuery("#bulk_edit_submit").prop("disabled", true);
        var tickets = (jQuery("#ticket_ids").val())?jQuery("#ticket_ids").val():'';
        var assignee = (jQuery("#assignee_ticket_edit").val())?jQuery("#assignee_ticket_edit").val():'';
        var labels = (jQuery("#label_ticket_edit").val())?jQuery("#label_ticket_edit").val():'';
        var tags = (jQuery("#tags_ticket_edit").val())?jQuery("#tags_ticket_edit").val():'';
        var subject = (jQuery("#title_ticket_edit").val())?jQuery("#title_ticket_edit").val():'';
        var reply = jQuery("#reply_textarea_edit > .ql-editor").html();
        var file = jQuery("#files_edit");        
        var fd = new FormData();

        if(reply!="" && reply!="<br>")
        {
            jQuery.each(jQuery(file), function (i, obj) {
                jQuery.each(obj.files, function (j, file) {
                    fd.append('file[' + j + ']', file);
                });
            });
        }
        else
        {
            if(file[0].files.length!==0)
            {
                alert("Text in the body of the reply is mandatory to submit attachemnts.");
                jQuery('#bulk_edit_submit').removeAttr("disabled");
                return ;
            }
        }
        fd.append("tickets",tickets);
        fd.append("assignee",assignee);
        fd.append("labels",labels);
        fd.append("tags",tags);
        fd.append("subject",subject);
        fd.append("reply",reply);
        fd.append("action", "eh_crm_bulk_edit");
        jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: fd,
                processData: false,
                contentType: false,
                success: function (data) {
                    jQuery('#edit_tickets_modal').modal('toggle');
                    jQuery('#bulk_edit_submit').removeAttr("disabled");
                    refresh_left_bar();
                    refresh_right_bar();
                    jQuery(".alert-success").css("display", "block");
                    jQuery(".alert-success").css("opacity", "1");
                    jQuery("#success_alert_text").html("<strong>"+js_obj.WSDesk_Tickets_Notification+"</strong><br>Ticket #" + tickets + " "+js_obj.Edited_Successfully+"!");
                    window.setTimeout(function () {
                        jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                            jQuery(this).css("display", "none");
                        });
                    }, 4000);
                }
            });
    });
    var timeoutID = null;
    function findSuggestion(str, ticket_id) {
        if(str != "")
        {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'eh_crm_search_post',
                    q:str
                },
                success: function (data)
                {
                    var parse = JSON.parse(data);
                    var html='No Suggestions';
                    if(parse.total_count !=0)
                    {
                        var count = (parse.total_count <= 10)?parse.total_count:10;
                        html='';
                        parse=parse.items;
                        for(var i=0;i<count;i++)
                        {
                            html=html+'<li class="clickable suggest_li" id="'+ticket_id+'"><span style="color:black;" id="sug_title">'+parse[i]['title']+'</span><br><span style="color:blue;" id="sug_url">'+parse[i]['guid']+'</span></li>';
                            if(i<count-1)
                                html=html+"<hr>";
                        }
                    }
                    
                    jQuery(".suggest_ul").html(html);
                }
            });
        }
        else
        {
            jQuery(".auto_suggestion_posts").hide('fast');
            jQuery(".auto_suggestion_posts").html("");
        }
    }
    jQuery('.tab-content').on('keyup',".reply_textarea > .ql-editor",function(e) {
        if(jQuery("#suggestion").length !=0)
        {
            clearTimeout(timeoutID);
            var id = jQuery(this).parent().parent().find('.reply_textarea').prop('id').split('_');
            timeoutID = setTimeout(findSuggestion.bind(undefined, jQuery("#reply_textarea_" + id[2]+' > .ql-editor').html(), id[2]), 300);
        }
    });
    jQuery('.tab-content').on('keyup',".ticket_title_editable",function(e) {
        if(jQuery("#suggestion").length !=0)
        {
            clearTimeout(timeoutID);
            var id = jQuery(this).prop('id').split("_");
            timeoutID = setTimeout(findSuggestion.bind(undefined, e.target.value, id[2]), 300);
        }
    });
    jQuery(".tab-content").on('click',".ticket_template_edit_type",function(e) {
        e.preventDefault();
        var slug = jQuery(this).prop("id");
        jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'eh_crm_ticket_edit_template_content',
                    slug: slug
                },
                success: function (data) {
                    jQuery('#update_template_model_display').html(data);
                    new Quill('#edit_template_content', {
                        theme: 'snow',
                        modules: {toolbar: toolbarOptions}
                    });
                    jQuery('#edit_template_model').modal('show');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
    });
    jQuery(".tab-content").on('click',".edit_template",function(e) {
        e.preventDefault();
        var slug = jQuery(this).prop('id');
        var title = jQuery("#edit_template_title").val();
        if(title === "")
        {
            jQuery("#edit_template_title").css("border", "1px solid red");
            return;
        }
        var btn=jQuery(this);
        btn.prop("disabled","disabled");
        var textAreaTxt = jQuery('#edit_template_content > .ql-editor').html();
        jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'eh_crm_ticket_update_template',
                    slug : slug,
                    title: title,
                    content : textAreaTxt
                },
                success: function (data) {
                    jQuery(".alert-success").css("display", "block");
                    jQuery(".alert-success").css("opacity", "1");
                    jQuery("#success_alert_text").html("<strong>"+js_obj.WSDesk_Templates_Notification+"</strong><br>"+js_obj.WSDesk_Templates_Updated+"!");
                    window.setTimeout(function () {
                        jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                            jQuery(this).css("display", "none");
                        });
                    }, 4000);
                    jQuery('#edit_template_model').modal('hide');
                    jQuery('#edit_template_model').on('hidden.bs.modal', function (e) {
                        jQuery('#update_template_model_display').empty();
                        jQuery("."+slug+"_head").html(title);
                        jQuery(".mulitple_ticket_template_button").trigger('click');
                    });
                    btn.removeProp("disabled");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    btn.removeProp("disabled");
                }
            });
    });
    
    var timeoutID = null;
    function findTemplate(str) {
        jQuery('.A0 span').removeClass("glyphicon-search");
        jQuery('.A0 span').addClass('glyphicon-refresh');
        jQuery('.A0 span').addClass('spin_search');
        if(str !== "")
        {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'eh_crm_ticket_template_search',
                    text:str
                },
                success: function (data)
                {
                    jQuery(".search_template").remove();
                    jQuery(".available_template").hide();
                    jQuery("#template_multiple_actions li:nth-child(2").after(data);
                    jQuery('.A0 span').addClass("glyphicon-search");
                    jQuery('.A0 span').removeClass('glyphicon-refresh');
                    jQuery('.A0 span').removeClass('spin_search');
                }
            });
        }
        else
        {
            jQuery(".search_template").remove();
            jQuery(".available_template").show();
            jQuery('.A0 span').addClass("glyphicon-search");
            jQuery('.A0 span').removeClass('glyphicon-refresh');
            jQuery('.A0 span').removeClass('spin_search');
        }
    }
    
    jQuery('.tab-content').on('keyup',"#search_template",function(e) {
        clearTimeout(timeoutID);
        timeoutID = setTimeout(findTemplate.bind(undefined, e.target.value), 300);
    });
    
    function findTemplateSingle(str,id) {
        jQuery('.A0_'+id+' span').removeClass("glyphicon-search");
        jQuery('.A0_'+id+' span').addClass('glyphicon-refresh');
        jQuery('.A0_'+id+' span').addClass('spin_search');
        if(str !== "")
        {
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'eh_crm_ticket_template_search_single',
                    text:str,
                    id:id
                },
                success: function (data)
                {
                    jQuery(".search_template_"+id).remove();
                    jQuery(".available_template_"+id).hide();
                    jQuery("#template_multiple_actions_single_"+id+" li:nth-child(2").after(data);
                    jQuery('.A0_'+id+' span').addClass("glyphicon-search");
                    jQuery('.A0_'+id+' span').removeClass('glyphicon-refresh');
                    jQuery('.A0_'+id+' span').removeClass('spin_search');
                }
            });
        }
        else
        {
            jQuery(".search_template_"+id).remove();
            jQuery(".available_template_"+id).show();
            jQuery('.A0_'+id+' span').addClass("glyphicon-search");
            jQuery('.A0_'+id+' span').removeClass('glyphicon-refresh');
            jQuery('.A0_'+id+' span').removeClass('spin_search');
        }
    }
    
    jQuery('.tab-content').on('keyup',".search_template_single",function(e) {
        clearTimeout(timeoutID);
        var str = jQuery(this).val();
        var id = jQuery(this).prop("id");
        timeoutID = setTimeout(findTemplateSingle(str,id), 300);
    });
    
    jQuery(".tab-content").on('click',".delete_template",function(e) {
        e.preventDefault();
        var slug = jQuery(this).prop('id');
        BootstrapDialog.show({
            title: js_obj.WSDesk_Alert,
            message: js_obj.WSDesk_Templates_Delete,
            cssClass: 'wsdesk_wrapper',
            buttons: [{
                    label: js_obj.Yes_Delete,
                    // no title as it is optional
                    cssClass: 'btn-primary',
                    action: function (dialogItself) {
                        jQuery.ajax({
                            type: 'post',
                            url: ajaxurl,
                            data: {
                                action: 'eh_crm_ticket_template_delete',
                                slug: slug
                            },
                            success: function (data) {
                                jQuery(".alert-success").css("display", "block");
                                jQuery(".alert-success").css("opacity", "1");
                                jQuery("#success_alert_text").html("<strong>"+js_obj.WSDesk_Templates_Notification+"</strong><br>"+js_obj.WSDesk_Templates_Deleted+"!");
                                window.setTimeout(function () {
                                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                        jQuery(this).css("display", "none");
                                    });
                                }, 4000);
                                jQuery('#edit_template_model').modal('hide');
                                jQuery('#edit_template_model').on('hidden.bs.modal', function (e) {
                                    jQuery('#update_template_model_display').empty();
                                    jQuery("."+slug+"_li").remove();
                                    jQuery(".mulitple_ticket_template_button").trigger('click');
                                });
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                            }
                        });
                        dialogItself.close();
                    }
                }, {
                    label: 'Close',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
        });
    });
    
    jQuery(".tab-content").on("click", ".multiple_template_action", function (e) {
        e.preventDefault();
        var ticket_id = jQuery(this).parent('li').prop("id");
        var text = jQuery("#reply_textarea_" + ticket_id + " > .ql-editor").html();
        var based = jQuery(this).attr("based");
        var template = jQuery(this).prop("id");
        if(based === 'bulk')
        {
            var ticket = getValue_checkbox("ticket_select");
            if(ticket !== '')
            {
                jQuery(".table_loader").css("display", "inline");
                jQuery.ajax({
                    type: 'post',
                    url: ajaxurl,
                    data: {
                        action: 'eh_crm_ticket_preview_template',
                        slug:template,
                        ticket:JSON.stringify(ticket),
                        type: 'bulk'
                    },
                    success: function (data) {
                        jQuery(".table_loader").css("display", "none");
                        jQuery('#preview_template_model_display').html(data);
                        jQuery('#preview_template_model').modal('show');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
            else
            {
                BootstrapDialog.alert('Select tickets to make send template!');
            }
        }
        else
        {
            var ticket = [];
            var id = jQuery(this).parent('li').prop('id');
            ticket.push(id);
            jQuery(".table_loader").css("display", "inline");
            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'eh_crm_ticket_preview_template',
                    slug:template,
                    ticket:JSON.stringify(ticket),
                    type: 'single'
                },
                success: function (data) {
                    
                    jQuery(".table_loader").css("display", "none");
                    jQuery("#reply_textarea_" + id + " > .ql-editor").html(data + jQuery("#reply_textarea_" + id + " > .ql-editor").html());
                    jQuery(".wsdesk-overlay-success").show();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
    });
    
    jQuery(".tab-content").on("click", ".ticket_template_confirm_action", function (e) {
        e.preventDefault();
        var based = jQuery(this).attr("based");
        var label = jQuery(this).prop("id");
        var template = jQuery("#template_id_for_confirm").val();
        if(based === 'bulk')
        {
            var ticket = getValue_checkbox("ticket_select");
            var openTic = [];
            jQuery(".ticket_tab_open").each(function(){
                var id = jQuery(this).prop("id");
                id = id.replace('tab_', '');
                openTic.push(id);
            });
            if(ticket !== '')
            {
                jQuery(".table_loader").css("display", "inline");
                jQuery.ajax({
                    type: 'post',
                    url: ajaxurl,
                    data: {
                        action      : 'eh_crm_ticket_multiple_template_send',
                        label       : label,
                        template    : template,
                        ticket      : JSON.stringify(ticket),
                        opened      : JSON.stringify(openTic)
                    },
                    success: function (data) {
                        var response = jQuery.parseJSON(data);
                        jQuery(".table_loader").css("display", "none");
                        jQuery('#preview_template_model').modal('hide');
                        jQuery('#preview_template_model').on('hidden.bs.modal', function (e) {
                            jQuery.each( response, function( key, parse ) {
                                var ticket_id = key;
                                if (jQuery("#tab_" + ticket_id).length != 0 && jQuery("#tab_content_" + ticket_id).length != 0)
                                {
                                    var tab_head = parse.tab_head;
                                    var tab_content = parse.tab_content;
                                    jQuery("#tab_" + ticket_id).html(tab_head);
                                    jQuery("#tab_content_" + ticket_id).html(tab_content);
                                    trigger_load_single_ticket(ticket_id);
                                }     
                            });
                            refresh_left_bar();
                            refresh_right_bar();
                            jQuery(".alert-success").css("display", "block");
                            jQuery(".alert-success").css("opacity", "1");
                            jQuery("#success_alert_text").html("<strong>"+js_obj.WSDesk_Tickets_Notification+"</strong><br>Ticket "+js_obj.Replied_Successfully+"!");
                            window.setTimeout(function () {
                                jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                    jQuery(this).css("display", "none");
                                });
                            }, 4000);
                            jQuery('#preview_template_model_display').empty();
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
            else
            {
                BootstrapDialog.alert('Select tickets to send template!');
            }
        }
    });
    
    jQuery(".tab-content").on('click',"#suggestion-tab",function(e) {
        e.preventDefault();
        var id=jQuery(this).prop("class");
        jQuery(".suggest-form-"+id).toggle("slide");
    });
    jQuery(".tab-content").on('click',".suggest_li",function() {
        var id=jQuery(this).prop("id");
        var title = jQuery(this).children("#sug_title").html();
        var link = jQuery(this).children("#sug_url").html();
        var textAreaTxt = jQuery('#reply_textarea_' + id+' > .ql-editor').html();
        var txtToAdd = title + "<br>" + link + "<br>";
        jQuery("#reply_textarea_" + id+" > .ql-editor").html(textAreaTxt + txtToAdd);
    });
    jQuery(".tab-content").on('click',".quote_button",function() {
        var id=jQuery(this).prop("id");
        var textAreaTxt = jQuery('#reply_textarea_' + id + " > .ql-editor").html();
        var txtToAdd = jQuery("#"+id+"_quote_text_ticket_content").html();
        var type = jQuery("#"+id+"_quote_text_ticket_content").prop("class");
        var html = '--- '+ type.replace('_', ' ') + ' --- <br>';
        jQuery('#reply_textarea_' + id + " > .ql-editor").html(textAreaTxt + html + txtToAdd);
    });
    jQuery('#search_ticket_input').keypress(function(e){
        if(e.which == 13){
            var search = jQuery('#search_ticket_input').val();
            jQuery("#search_ticket_input").blur(); 
            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'eh_crm_ticket_search',
                    search: search
                },
                success: function (data) {
                    var parse = jQuery.parseJSON(data);
                    if(parse.data === "ticket")
                    {
                        var ticket_id = search;
                        if (jQuery(".elaborate > li#tab_" + ticket_id).length == 0)
                        {
                            var tab_head = '<li role="presentation" class="visible_tab ticket_tab_open" id="tab_' + ticket_id + '" style="min-width:200px;">' + parse.tab_head + '</li>';
                            var tab_content = '<div class="tab-pane" id="tab_content_' + ticket_id + '">' + parse.tab_content + '</div>';
                            jQuery('.elaborate > li').last().before(tab_head);
                            jQuery('.tab-content').append(tab_content);
                            trigger_load_single_ticket(ticket_id);
                            jQuery("reply_textarea_" + ticket_id + ' > .ql-editor').html(jQuery('direct_reply_textarea_' + ticket_id + ' > .ql-editor').html());
                            jQuery('.visible_tab a#tab_content_a_' + ticket_id).click();
                            collapse_tab();
                        }
                        else
                        {
                            jQuery(".elaborate > li#tab_" + ticket_id).children('a').click();
                        }
                    }
                    else
                    {
                        var search_key = search.replace(' ', '_');
                        while(search_key.indexOf(" ")!=-1)
                        {
                            search_key = search_key.replace(' ', '_');
                        }
                        while(search_key.indexOf("@")!=-1)
                        {
                            search_key = search_key.replace('@', '_1attherate1_');
                        }
                        while(search_key.indexOf(".")!=-1)
                        {
                            search_key = search_key.replace('.', '_1dot1_');
                        }
                        while(search_key.indexOf(";")!=-1)
                        {
                            search_key = search_key.replace(';','_1semicolon1_');
                        }
                        while(search_key.indexOf("?")!=-1)
                        {
                            search_key = search_key.replace('?','_1questionmark1_');
                        }
                        if (jQuery(".elaborate > li#tab_" + search_key).length == 0)
                        {
                            var tab_head = '<li role="presentation" class="visible_tab" id="tab_' + search_key + '" style="min-width:200px;">' + parse.tab_head + '</li>';
                            var tab_content = '<div class="tab-pane" id="tab_content_' + search_key + '">' + parse.tab_content + '</div>';
                            jQuery('.elaborate > li').last().before(tab_head);
                            jQuery('.tab-content').append(tab_content);
                            jQuery('.visible_tab a#tab_content_a_'+search_key).click();
                            collapse_tab();
                        }
                        else
                        {
                            jQuery(".elaborate > li#tab_" + search_key).children('a').click();
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
            jQuery("#search_ticket_input").val('');
        }
    });
    jQuery(".nav-tabs").on("click", ".close_tab", function () {
        var anchor = jQuery(this).parent();
        var li = anchor.parent();
        var count = jQuery(".elaborate li").length;
        if(count <= 3)
        {
            jQuery(".elaborate > li").first().children('a').click();
        }
        else
        {
            if(li.hasClass('active'))
            {
                if(li.next().hasClass('visible_tab'))
                {
                    li.next().children('a').click();
                }
                else
                {
                    li.prev().children('a').click();
                }
            }
        }
        refresh_left_bar();
        refresh_right_bar();
        jQuery(anchor.attr('href')).remove();
        jQuery(anchor).parent().remove();
        collapse_tab();
    });
    jQuery(".tab-content").on("click", ".sort-icon", function(e){
        e.preventDefault();
        var order_by = '&order_by=';
        switch(jQuery(this).attr('id'))
        {
            case 'id':
                order_by += 'ticket_id';
                break;
            case 'subject':
                order_by += 'ticket_title';
                break;
        }
        if(jQuery(this).hasClass('dashicons-sort') || jQuery(this).hasClass('dashicons-arrow-up'))
        {
            jQuery(this).removeClass('dashicons-sort');
            jQuery(this).removeClass('dashicons-arrow-up');
            jQuery(this).addClass('dashicons-arrow-down');
            window.history.pushState('Order By', 'order_by', wsdesk_data.ticket_admin_url+"&order=DESC"+order_by);
            refresh_right_bar()
        }
        else if(jQuery(this).hasClass('dashicons-arrow-down'))
        {
            jQuery(this).removeClass('dashicons-arrow-down');
            jQuery(this).addClass('dashicons-arrow-up');
            window.history.pushState('Order By', 'order_by', wsdesk_data.ticket_admin_url+"&order=ASC"+order_by);
            refresh_right_bar();
        }
    });
    jQuery(".tab-content").on("click", ".content_more", function(e){
        e.preventDefault();
        var id = jQuery(this).attr('id');
        jQuery("#hide_content_"+id).show();
        jQuery(this).hide();
        jQuery("a#"+id+".content_less").show();
    });
    jQuery(".tab-content").on("click", ".content_less", function(e){
        e.preventDefault();
        var id = jQuery(this).attr('id');
        jQuery("#hide_content_"+id).hide();
        jQuery(this).hide();
        jQuery("a#"+id+".content_more").show();
    });
    function refresh_left_bar()
    {
        jQuery(".ticket-delete-btn").hide();
        jQuery(".ticket-edit-btn").hide();
        jQuery(".ticket_select_all").removeProp("checked");
        jQuery(".labels_loader").css("display", "inline");
        jQuery(".agents_loader").css("display", "inline");
        jQuery(".tags_loader").css("display", "inline");
        jQuery(".users_loader").css("display", "inline");
        var active = jQuery("#left_bar_all_tickets").find(".active").children('a').attr('id');
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_refresh_left_bar',
                active: active
            },
            success: function (data) {
                jQuery(".labels_loader").css("display", "none");
                jQuery(".agents_loader").css("display", "none");
                jQuery(".tags_loader").css("display", "none");
                jQuery(".users_loader").css("display", "none");
                jQuery("#left_bar_all_tickets").html(data);
                window.history.pushState('Tickets', 'Title', wsdesk_data.ticket_admin_url+'&view='+active);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
    
    function refresh_ticket_count()
    {
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_refresh_tickets_count'
            },
            success: function (data) {
                var parse = jQuery.parseJSON(data);
                jQuery("#wsdesk_tickets_count").html(parse.data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
    
    function refresh_right_bar(ul, pagination, current)
    {
        ul = ul||'';
        pagination = pagination||'';
        current = current||0;
        jQuery('[data-toggle="wsdesk_tooltip"]').wstooltip('destroy');
        jQuery(".table_loader").css("display", "inline");
        var active = jQuery("#left_bar_all_tickets").find(".active").children('a').attr('id');
        jQuery("." + ul + "_loader").css("display", "inline");
        var current_page = (current==0)?jQuery("#current_page_no").val():0;
        var cur= (current==0)?jQuery("#current_page_n").val():0;
        if($_GET('order'))
        {
            var order = $_GET('order');
        }
        else
        {
            var order = 'DESC';
        }
        if($_GET('order_by'))
        {
            var order_by = $_GET('order_by');
        }
        else
        {
            var order_by = 'ticket_updated';
        }
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_refresh_right_bar',
                active: active,
                current_page:current_page,
                cur:cur,
                pagination_type:pagination,
                order: order,
                order_by: order_by
            },
            success: function (data) {
                refresh_ticket_count();
                jQuery(".table_loader").css("display", "none");
                jQuery("." + ul + "_loader").css("display", "none");
                jQuery("#right_bar_all_tickets").html(data);
                jQuery('[data-action="filter"]').filterTable();
                jQuery(".direct_reply_textarea").each(function(){
                    var id = jQuery(this).prop("id");
                    new Quill('#' + id, {
                        theme: 'snow',
                        modules:{toolbar: toolbarOptions}
                    });
                });
                jQuery('[data-toggle="wsdesk_tooltip"]').wstooltip({trigger : 'hover'});
                
                //jQuery(".tickets_panel span.filter").parents('.panel').find('.tickets_panel > .panel-body').slideToggle();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
    jQuery(".tab-content").on("click", "#left_bar_all_tickets a", function (e)
    {
        e.preventDefault();
        var li = jQuery(this).parent();
        var ul = jQuery(li).parent().prop("id");
        jQuery("#left_bar_all_tickets").find(".active").removeClass("active");
        jQuery(li).addClass("active");
        refresh_left_bar();
        refresh_right_bar(ul,"",1);
    });
    jQuery("#refresh_tickets").on("click", function (e)
    {
        e.preventDefault();
        refresh_right_bar();
        jQuery(".ticket_select_all").removeProp("checked");
        jQuery(".ticket-delete-btn").hide();
        jQuery(".ticket-edit-btn").hide();
    });
    jQuery(".tab-content").on("keyup", ".pagination_tic",function (e)
    {   
        if(e.which==13){
            e.preventDefault();
            jQuery(".ticket-delete-btn").hide();
            jQuery(".ticket-edit-btn").hide();
            jQuery(".ticket_select_all").removeProp("checked");
            var id = jQuery(this).prop("id");
            refresh_right_bar("",id);
        }
    });
   
    
    jQuery(".tab-content").on("click", ".pagination_tickets", function (e)
    {
        e.preventDefault();
        jQuery(".ticket-delete-btn").hide();
        jQuery(".ticket-edit-btn").hide();
        jQuery(".ticket_select_all").removeProp("checked");
        var id = jQuery(this).prop("id");
        refresh_right_bar("",id);
    });

    var stop = false;
    jQuery('.tab-content').on('click', '#dev-table tr', function (e) {
        if (!jQuery(e.target).closest('.except_view').length) {
            var ticket_id = jQuery(this).prop("id");
            if (jQuery("ul > li#tab_" + ticket_id).length == 0)
            {
                jQuery(".table_loader").css("display", "inline");
                if (stop)
                    return false;
                stop = true;
                jQuery.ajax({
                    type: 'post',
                    url: ajaxurl,
                    data: {
                        action: 'eh_crm_ticket_single_view',
                        ticket_id: ticket_id,
                        pagination_id : jQuery("#pagination_ids_traverse").val()
                    },
                    success: function (data) {
                        jQuery(".table_loader").css("display", "none");
                        var parse = jQuery.parseJSON(data);
                        var tab_head = '<li role="presentation" class="visible_tab ticket_tab_open" id="tab_' + ticket_id + '" style="min-width:200px;">' + parse.tab_head + '</li>';
                        var tab_content = '<div class="tab-pane new-style-tab-pane" id="tab_content_' + ticket_id + '">' + parse.tab_content + '</div>';
                        jQuery('.elaborate > li').last().before(tab_head);
                        jQuery('.tab-content').append(tab_content);
                        trigger_load_single_ticket(ticket_id);
                        jQuery('.visible_tab a#tab_content_a_'+ticket_id).click();
                        setURLFunc(ticket_id);
                        collapse_tab();
                        stop = false;
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            } else
            {
                if(jQuery("ul.collapse_ul > li#tab_" + ticket_id).length!=0)
                {
                    jQuery('.elaborate > li').last().before(jQuery("ul.collapse_ul > li#tab_" + ticket_id));
                    collapse_tab();
                }
                jQuery(".elaborate > li#tab_" + ticket_id).children('a').click();
            }
        }

    });
    
    jQuery('.tab-content').on('click', '.single_pagination_tickets', function (e) {
        var ticket_id = jQuery(this).prop("id");
        var par_id = jQuery(this).parent().prop("id");
        if (jQuery("ul > li#tab_" + ticket_id).length == 0)
        {
            jQuery(".ticket_loader_" + par_id).css("display", "inline");
            if (stop)
                return false;
            stop = true;
            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'eh_crm_ticket_single_view',
                    ticket_id: ticket_id,
                    pagination_id : jQuery("#pagination_ids_traverse").val()
                },
                success: function (data) {
                    jQuery(".ticket_loader_" + par_id).css("display", "none");
                    var parse = jQuery.parseJSON(data);
                    jQuery('#tab_'+par_id).html(parse.tab_head);
                    jQuery('#tab_'+par_id).prop("id","tab_"+ticket_id);
                    jQuery('#tab_content_'+par_id).html(parse.tab_content);
                    jQuery('#tab_content_'+par_id).prop("id","tab_content_"+ticket_id);
                    trigger_load_single_ticket(ticket_id);
                    jQuery('.visible_tab a#tab_content_a_'+ticket_id).click();
                    setURLFunc(ticket_id);
                    collapse_tab();
                    stop = false;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        } else
        {
            if(jQuery("ul.collapse_ul > li#tab_" + ticket_id).length!=0)
            {
                jQuery('.elaborate > li').last().before(jQuery("ul.collapse_ul > li#tab_" + ticket_id));
                collapse_tab();
            }
            jQuery(".elaborate > li#tab_" + ticket_id).children('a').click();
        }

    });
    jQuery('.tab-content').on('click', '#search-table tr', function (e) {
        if (!jQuery(e.target).closest('.except_view').length) {
            var ticket_id = jQuery(this).prop("id");
            if (jQuery("ul > li#tab_" + ticket_id).length == 0)
            {
                jQuery(".search_table_loader").css("display", "inline");
                if (stop)
                    return false;
                stop = true;
                jQuery.ajax({
                    type: 'post',
                    url: ajaxurl,
                    data: {
                        action: 'eh_crm_ticket_single_view',
                        ticket_id: ticket_id
                    },
                    success: function (data) {
                        jQuery(".search_table_loader").css("display", "none");
                        var parse = jQuery.parseJSON(data);
                        var tab_head = '<li role="presentation" class="visible_tab ticket_tab_open" id="tab_' + ticket_id + '" style="min-width:200px;">' + parse.tab_head + '</li>';
                        var tab_content = '<div class="tab-pane" id="tab_content_' + ticket_id + '">' + parse.tab_content + '</div>';
                        jQuery('.elaborate > li').last().before(tab_head);
                        jQuery('.tab-content').append(tab_content);
                        trigger_load_single_ticket(ticket_id);
                        jQuery('.visible_tab a#tab_content_a_'+ticket_id).click();
                        setURLFunc(ticket_id);
                        collapse_tab();
                        stop = false;
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            } else
            {
                if(jQuery("ul.collapse_ul > li#tab_" + ticket_id).length!=0)
                {
                    jQuery('.elaborate > li').last().before(jQuery("ul.collapse_ul > li#tab_" + ticket_id));
                    collapse_tab();
                }
                jQuery(".elaborate > li#tab_" + ticket_id).children('a').click();
            }
        }

    });
    jQuery(".tab-content").on("change", "#dev-table-action-bar .ticket_select_all", function (e)
    {
        if (this.checked)
        {
            jQuery(".ticket-delete-btn").show();
            jQuery(".ticket-edit-btn").show();
            jQuery('.ticket_select').each(function () {
                this.checked = true;
            });
        } else
        {
            jQuery(".ticket-delete-btn").hide();
            jQuery(".ticket-edit-btn").hide();
            jQuery('.ticket_select').each(function () {
                this.checked = false;
            });
        }
        e.preventDefault();

    });
    jQuery(".tab-content").on("change", "#dev-table .ticket_select", function (e)
    {
        e.preventDefault();
        jQuery(".ticket_select_all").removeProp("checked");
        var all_uncheked = true;
        jQuery('.ticket_select').each(function () {
                if(this.checked){
                    all_uncheked = false;
                }
            });
            
        if (!all_uncheked)
        {
            jQuery(".ticket-delete-btn").show();
            jQuery(".ticket-edit-btn").show();
        } else
        {
            jQuery(".ticket-delete-btn").hide();
            jQuery(".ticket-edit-btn").hide();
        }
    });
    jQuery('.add-ticket').click(function (e) {
        e.preventDefault();
        if (jQuery("ul > li#tab_new").length == 0)
        {
            jQuery(".table_loader").css("display", "inline");
            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                data: {
                    action: 'eh_crm_ticket_add_new'
                },
                success: function (data) {
                    jQuery(".table_loader").css("display", "none");
                    var parse = jQuery.parseJSON(data);
                    var tab_head = '<li role="presentation" class="visible_tab" id="tab_new" style="min-width:200px;">' + parse.tab_head + '</li>';
                    var tab_content = '<div class="tab-pane" id="tab_content_new">' + parse.tab_content + '</div>';
                    jQuery('.elaborate > li').last().before(tab_head);
                    jQuery('.tab-content').append(tab_content);
                    trigger_load_single_ticket('new');
                    jQuery('.visible_tab a#tab_content_a_new').click();
                    setURLFunc('tickets');
                    collapse_tab();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
        else
        {
                if(jQuery("ul.collapse_ul > li#tab_new").length!=0)
                {
                    jQuery('.elaborate > li').last().before(jQuery("ul.collapse_ul > li#tab_new"));
                    collapse_tab();
                }
                jQuery(".elaborate > li#tab_new").children('a').click();
        }
    });
    jQuery("#tickets_page_view").on("click", ".quick_view_ticket", function (e) {
        e.preventDefault();
        var target = jQuery(this).attr("data-target");
        if (jQuery(target).hasClass("in"))
        {
            jQuery(target).parent().css("display", "none");
            jQuery(this).children('.glyphicon').addClass("glyphicon-eye-open").removeClass("glyphicon-eye-close");
        } else
        {
            jQuery(target).parent().css("display", "table-cell");
            jQuery(this).children('.glyphicon').addClass("glyphicon-eye-close").removeClass("glyphicon-eye-open");
        }
    });
    jQuery(".tab-content").on("click", ".single_ticket_action", function (e) {
        e.preventDefault();
        var label = jQuery(this).prop("id");
        var ticket_id = jQuery(this).parent().prop("id");
        jQuery(".table_loader").css("display", "inline");
        jQuery(".single_ticket_action_button_" + ticket_id).prop("disabled", true);
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_single_ticket_action',
                ticket_id: ticket_id,
                label: label,
                pagination_id : jQuery("#pagination_ids_traverse").val()
            },
            success: function (data) {
                jQuery(".table_loader").css("display", "none");
                if (jQuery("#tab_" + ticket_id).length != 0 && jQuery("#tab_content_" + ticket_id).length != 0)
                {
                    jQuery("#tab_content_" + ticket_id).html(data);
                    trigger_load_single_ticket(ticket_id);
                }
                refresh_left_bar();
                refresh_right_bar();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

    });
    jQuery(".tab-content").on("click", ".single_ticket_assignee", function (e) {
        e.preventDefault();
        var assignee = jQuery(this).prop("id");
        var ticket_id = jQuery(this).parent().prop("id");
        jQuery(".table_loader").css("display", "inline");
        jQuery(".single_ticket_assignee_button_" + ticket_id).prop("disabled", true);
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_single_ticket_assignee',
                ticket_id: ticket_id,
                assignee: assignee,
                pagination_id : jQuery("#pagination_ids_traverse").val()
            },
            success: function (data) {
                jQuery(".table_loader").css("display", "none");
                if (jQuery("#tab_" + ticket_id).length != 0 && jQuery("#tab_content_" + ticket_id).length != 0)
                {
                    jQuery("#tab_content_" + ticket_id).html(data);
                    trigger_load_single_ticket(ticket_id);
                }
                refresh_left_bar();
                refresh_right_bar();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

    });
    jQuery(".tab-content").on('click','.ticket_action_merge',function(e){
        var ticket_id = jQuery(this).prop("id");
        jQuery(".merge_ticket_verify").prop("disabled", true);
        jQuery(".merge_ticket_confirm").prop("disabled", true);
        jQuery("#all_ticket_ids_"+ticket_id).select2({
            dropdownParent: jQuery('.modal'),
            width: '98%',
            allowClear: true,
            placeholder: "Ticket IDs to be merged.",
            formatNoMatches: function () {
                return "0";
            },
            language: {
                noResults: function (params) {
                    return "0";
                }
            }
        });
        jQuery("#ticket_merge_modal_"+ticket_id).modal("show");
    });
    jQuery(".tab-content").on("click", ".ticket_action_delete", function (e) {
        e.preventDefault();
        var ticket_id = jQuery(this).prop("id");
        BootstrapDialog.show({
            title: js_obj.WSDesk_Alert,
            message: js_obj.Do_You_want_to_Delete_Ticket,
            cssClass: 'wsdesk_wrapper',
            buttons: [{
                    label: js_obj.Yes_Delete,
                    // no title as it is optional
                    cssClass: 'btn-primary',
                    action: function (dialogItself) {
                        jQuery(".ticket_loader_" + ticket_id).css("display", "inline");
                        jQuery.ajax({
                            type: 'post',
                            url: ajaxurl,
                            data: {
                                action: 'eh_crm_ticket_single_delete',
                                ticket_id: ticket_id
                            },
                            success: function (data) {
                                jQuery("#tab_" + ticket_id + ">a>.close_tab").trigger("click");
                                jQuery(".ticket_loader_" + ticket_id).css("display", "none");
                                jQuery(".alert-success").css("display", "block");
                                jQuery(".alert-success").css("opacity", "1");
                                jQuery("#success_alert_text").html("<strong>"+js_obj.WSDesk_Tickets_Notification+"</strong><br>Ticket #" + ticket_id + " Deleted Successfully!");
                                window.setTimeout(function () {
                                    jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                        jQuery(this).css("display", "none");
                                    });
                                }, 4000);
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                            }
                        });
                        dialogItself.close();
                    }
                }, {
                    label: 'Close',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
        });
    });
    jQuery(".tab-content").on("click", ".multiple_ticket_action", function (e) {
        e.preventDefault();
        var label = jQuery(this).prop("id");
        var ticket = getValue_checkbox("ticket_select");
        if(ticket != '')
        {
            if(label === "delete_tickets")
            {
                BootstrapDialog.show({
                    title: js_obj.WSDesk_Alert,
                    message: js_obj.Do_You_want_to_Delete_Ticket,
                    cssClass: 'wsdesk_wrapper',
                    buttons: [{
                            label: js_obj.Yes_Delete,
                            // no title as it is optional
                            cssClass: 'btn-primary',
                            action: function (dialogItself) {
                                jQuery(".table_loader").css("display", "inline");
                                jQuery.ajax({
                                    type: 'post',
                                    url: ajaxurl,
                                    data: {
                                        action: 'eh_crm_ticket_multiple_delete',
                                        tickets_id: JSON.stringify(ticket)
                                    },
                                    success: function (data) {
                                        jQuery(".ticket-delete-btn").hide();
                                        jQuery(".ticket-edit-btn").hide();
                                        for(i=0;i<ticket.length;i++)
                                        {
                                            if (jQuery("#tab_" + ticket[i]).length != 0 && jQuery("#tab_content_" + ticket[i]).length != 0)
                                            {
                                                jQuery("#tab_" + ticket[i] + ">a>.close_tab").trigger("click");
                                            }                                            
                                        }
                                        jQuery(".table_loader").css("display", "none");
                                        jQuery(".alert-success").css("display", "block");
                                        jQuery(".alert-success").css("opacity", "1");
                                        jQuery("#success_alert_text").html("<strong>"+js_obj.WSDesk_Tickets_Notification+"</strong><br>"+js_obj.Tickets_Deleted_Successfully+"!");
                                        window.setTimeout(function () {
                                            jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                                jQuery(this).css("display", "none");
                                            });
                                        }, 4000);
                                        refresh_left_bar();
                                        refresh_right_bar();
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) {
                                        console.log(textStatus, errorThrown);
                                    }
                                });
                                dialogItself.close();
                            }
                        }, {
                            label: 'Close',
                            action: function (dialogItself) {
                                dialogItself.close();
                            }
                        }]
                });
            }
            else if(label === 'edit_tickets')
            {
                jQuery("#edit_tickets_modal").modal("toggle");
                jQuery("#ticket_ids").val(ticket);
                jQuery(".number_of_tickets").html(ticket.length);
            }
            else
            {
                BootstrapDialog.show({
                    title: js_obj.WSDesk_Alert,
                    message: js_obj.Do_You_want_to_Update_Tickets_Label,
                    cssClass: 'wsdesk_wrapper',
                    buttons: [{
                            label: js_obj.Yes_Update,
                            // no title as it is optional
                            cssClass: 'btn-primary',
                            action: function (dialogItself) {
                                jQuery(".table_loader").css("display", "inline");
                                jQuery.ajax({
                                    type: 'post',
                                    url: ajaxurl,
                                    data: {
                                        action: 'eh_crm_ticket_multiple_ticket_action',
                                        tickets_id: JSON.stringify(ticket),
                                        label:label
                                    },
                                    success: function (data) {
                                        jQuery(".ticket-delete-btn").hide();
                                        jQuery(".ticket-edit-btn").hide();
                                        jQuery(".table_loader").css("display", "none");
                                        jQuery(".alert-success").css("display", "block");
                                        jQuery(".alert-success").css("opacity", "1");
                                        jQuery("#success_alert_text").html("<strong>"+js_obj.WSDesk_Tickets_Notification+"</strong><br>"+js_obj.Tickets_Updated_Successfully+"!");
                                        window.setTimeout(function () {
                                            jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                                jQuery(this).css("display", "none");
                                            });
                                        }, 4000);
                                        refresh_left_bar();
                                        refresh_right_bar();
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) {
                                        console.log(textStatus, errorThrown);
                                    }
                                });
                                dialogItself.close();
                            }
                        }, {
                            label: 'Close',
                            action: function (dialogItself) {
                                dialogItself.close();
                            }
                        }]
                });
            }
        }
        else
        {
            BootstrapDialog.alert('Select tickets to make actions!');
        }
    });
    jQuery(".tab-content").on("click", ".ticket_submit_new", function (e) {
        var ticket_id = jQuery(this).parent('li').prop("id");
        var text = jQuery("#reply_textarea_" + ticket_id + " > .ql-editor").html();
        var email = jQuery('#ticket_email_'+ticket_id).val();
        var title = jQuery('#ticket_title_'+ticket_id).val();
        if (text !== "<br>" && text !=="" && email != "" && title != "")
        {
            
            jQuery("#reply_textarea_" + ticket_id).css("border", "1px solid #F2F2F2");
            var submit = jQuery(this).prop("id");
            var fd = new FormData();
            var file = jQuery("#files_" + ticket_id);
            jQuery.each(jQuery(file), function (i, obj) {
                jQuery.each(obj.files, function (j, file) {
                    fd.append('file[' + j + ']', file);
                });
            });
            
            var assignee = jQuery("#assignee_ticket_" + ticket_id).val();
            var tags = jQuery("#tags_ticket_" + ticket_id).val();
            var input_field = {};
            if (jQuery(".ticket_input_text_" + ticket_id).length != 0)
            {
                var text_validate = true;
                jQuery(".ticket_input_text_" + ticket_id).each(function () {
                    var key = jQuery(this).prop("id");
                    if(jQuery(this).hasClass('text_required') && jQuery(this).val() === "")
                    {
                        jQuery(this).css('border','1px solid red');
                        text_validate = false;
                    }
                    else
                    {
                        var value = jQuery(this).val();
                        jQuery(this).css('border','1px solid #ccc');
                        input_field[key] = value;
                        if(text_validate)
                        {
                            text_validate = true;
                        }
                    }
                });
                if(!text_validate)
                {
                    return false;
                }
            }
            if(jQuery(".ticket_input_ip_"+ticket_id).length !=0)
            {
                jQuery(".ticket_input_ip_" + ticket_id).each(function () {
                    var key = jQuery(this).prop("id");
                    var value = jQuery(this).val();
                    input_field[key] = value;
                });
            }
            if (jQuery(".ticket_input_date_" + ticket_id).length != 0)
            {
                var text_validate = true;
                jQuery(".ticket_input_date_" + ticket_id).each(function () {
                    var key = jQuery(this).prop("id");
                    if(jQuery(this).hasClass('text_required') && jQuery(this).val() === "")
                    {
                        jQuery(this).css('border','1px solid red');
                        text_validate = false;
                    }
                    else
                    {
                        var value = jQuery(this).val();
                        jQuery(this).css('border','1px solid #ccc');
                        input_field[key] = value;
                        if(text_validate)
                        {
                            text_validate = true;
                        }
                    }
                });
                if(!text_validate)
                {
                    return false;
                }
            }
            if (jQuery(".ticket_input_email_" + ticket_id).length != 0)
            {
                var text_validate = true;
                jQuery(".ticket_input_email_" + ticket_id).each(function () {
                    var key = jQuery(this).prop("id");
                    if(jQuery(this).hasClass('text_required') && jQuery(this).val() === "")
                    {
                        jQuery(this).css('border','1px solid red');
                        text_validate = false;
                    }
                    else
                    {
                        var value = jQuery(this).val();
                        jQuery(this).css('border','1px solid #ccc');
                        input_field[key] = value;
                        if(text_validate)
                        {
                            text_validate = true;
                        }
                    }
                });
                if(!text_validate)
                {
                    return false;
                }
            }
            if (jQuery(".ticket_input_number_" + ticket_id).length != 0)
            {
                var text_validate = true;
                jQuery(".ticket_input_number_" + ticket_id).each(function () {
                    var key = jQuery(this).prop("id");
                    if(jQuery(this).hasClass('text_required') && jQuery(this).val() === "")
                    {
                        jQuery(this).css('border','1px solid red');
                        text_validate = false;
                    }
                    else
                    {
                        var value = jQuery(this).val();
                        jQuery(this).css('border','1px solid #ccc');
                        input_field[key] = value;
                        if(text_validate)
                        {
                            text_validate = true;
                        }
                    }
                });
                if(!text_validate)
                {
                    return false;
                }
            }
            if (jQuery(".ticket_input_pwd_" + ticket_id).length != 0)
            {
                var text_validate = true;
                jQuery(".ticket_input_pwd_" + ticket_id).each(function () {
                    var key = jQuery(this).prop("id");
                    if(jQuery(this).hasClass('text_required') && jQuery(this).val() === "")
                    {
                        jQuery(this).css('border','1px solid red');
                        text_validate = false;
                    }
                    else
                    {
                        var value = jQuery(this).val();
                        jQuery(this).css('border','1px solid #ccc');
                        input_field[key] = value;
                        if(text_validate)
                        {
                            text_validate = true;
                        }
                    }
                });
                if(!text_validate)
                {
                    return false;
                }
            }
            if (jQuery(".ticket_input_select_" + ticket_id).length != 0)
            {
                var text_validate = true;
                jQuery(".ticket_input_select_" + ticket_id).each(function () {
                    var key = jQuery(this).prop("id");
                    if(jQuery(this).hasClass('text_required') && jQuery(this).val() === "")
                    {
                        jQuery(this).css('border','1px solid red');
                        text_validate = false;
                    }
                    else
                    {
                        var value = jQuery(this).val();
                        jQuery(this).css('border','1px solid #ccc');
                        input_field[key] = value;
                        if(text_validate)
                        {
                            text_validate = true;
                        }
                    }
                });
                if(!text_validate)
                {
                    return false;
                }
            }
            if (jQuery(".ticket_input_radio_" + ticket_id).length != 0)
            {
                var radio_validate = true;
                jQuery(".ticket_input_radio_" + ticket_id).each(function () {
                    var key = jQuery(this).prop("id");
                    var value = ((jQuery("input[name='" + key + "']:checked").val() != undefined) ? jQuery("input[name='" + key + "']:checked").val() : "");
                    if(jQuery(this).hasClass('radio_required') && value == "")
                    {
                        jQuery(this).css('border','1px solid red');
                        radio_validate = false;
                    }
                    else
                    {
                        jQuery(this).css('border','1px solid #ccc');
                        if(radio_validate)
                        {
                            radio_validate = true;
                        }
                        input_field[key] = value;
                    }
                });
                if(!radio_validate)
                {
                    return false;
                }
            }
            if (jQuery(".ticket_input_checkbox_" + ticket_id).length != 0)
            {
                var check_validate = true;
                jQuery(".ticket_input_checkbox_" + ticket_id).each(function () {
                    var key = jQuery(this).prop("id");
                    var value = getValue_checkbox(key);
                    if(jQuery(this).hasClass('check_required') && value === "")
                    {
                        jQuery(this).css('border','1px solid red');
                        check_validate = false;
                    }
                    else
                    {
                        jQuery(this).css('border','1px solid #ccc');
                        if(check_validate)
                        {
                            check_validate = true;
                        }
                        input_field[key] = value;
                    }
                });
                if(!check_validate)
                {
                    return false;
                }
            }
            if (jQuery(".ticket_input_textarea_" + ticket_id).length != 0)
            {
                var text_validate = true;
                jQuery(".ticket_input_textarea_" + ticket_id).each(function () {
                    var key = jQuery(this).prop("id");
                    if(jQuery(this).hasClass('text_required') && jQuery(this).val() === "")
                    {
                        jQuery(this).css('border','1px solid red');
                        text_validate = false;
                    }
                    else
                    {
                        var value = jQuery(this).val();
                        jQuery(this).css('border','1px solid #ccc');
                        input_field[key] = value;
                        if(text_validate)
                        {
                            text_validate = true;
                        }
                    }
                });
                if(!text_validate)
                {
                    return false;
                }
            }
            jQuery("#reply_textarea_" + ticket_id).css("border", "1px solid #F2F2F2");
            jQuery("#ticket_email_" + ticket_id).css("border", "1px solid #F2F2F2");
            jQuery("#ticket_title_" + ticket_id).css("border", "1px solid #F2F2F2");
            var submit = jQuery(this).prop("id");
            var fd = new FormData();
            var file = jQuery("#files_" + ticket_id);
            jQuery.each(jQuery(file), function (i, obj) {
                jQuery.each(obj.files, function (j, file) {
                    fd.append('file[' + j + ']', file);
                });
            });
            fd.append("title", title);
            fd.append("email", email);
            fd.append("desc", text);
            fd.append("submit", submit);
            fd.append("assignee",(assignee != null) ? assignee.join(",") : '');
            fd.append("tags",(tags != null) ? tags.join(",") : '');
            fd.append("input",JSON.stringify(input_field));
            fd.append('action', 'eh_crm_ticket_new_submit');
            jQuery(".ticket_loader_" + ticket_id).css("display", "inline");
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: fd,
                processData: false,
                contentType: false,
                success: function (data) {
                    jQuery(".ticket_loader_" + ticket_id).css("display", "none");
                    Cookies.remove('reply_textarea_'+ticket_id);
                    jQuery("#tab_"+ticket_id+">a>.close_tab").trigger("click");
                    jQuery(".alert-success").css("display", "block");
                    jQuery(".alert-success").css("opacity", "1");
                    jQuery("#success_alert_text").html("<strong>"+js_obj.WSDesk_Tickets_Notification+"</strong><br>"+js_obj.New_Ticket_Created_Successfully+"!");
                    window.setTimeout(function () {
                        jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                            jQuery(this).css("display", "none");
                        });
                    }, 4000);
                    var parse = jQuery.parseJSON(data);
                    ticket_id = parse.id;
                    var tab_head = '<li role="presentation" class="visible_tab" id="tab_' + ticket_id + '" style="min-width:200px;">' + parse.tab_head + '</li>';
                    var tab_content = '<div class="tab-pane" id="tab_content_' + ticket_id + '">' + parse.tab_content + '</div>';
                    jQuery('.elaborate > li').last().before(tab_head);
                    jQuery('.tab-content').append(tab_content);
                    trigger_load_single_ticket(ticket_id);
                    jQuery('.visible_tab a#tab_content_a_' + ticket_id).click();
                    collapse_tab();
                }
            });
        } else
        {
            jQuery(".alert-warning").css("display", "block");
            jQuery(".alert-warning").css("opacity", "1");
            jQuery("#warning_alert_text").html("<strong>"+js_obj.WSDesk_Tickets_Notification+"</strong><br>Ticket #" + ticket_id + " "+js_obj.missing_some_data+"!");
            window.setTimeout(function () {
                jQuery(".alert-warning").fadeTo(500, 0).slideUp(500, function () {
                    jQuery(this).css("display", "none");
                });
            }, 4000);
        }
    });
    jQuery(".tab-content").on("click", ".ticket_reply_action", function (e) {
        e.preventDefault();
        var ticket_id = jQuery(this).parent('li').prop("id");
        var submit = jQuery(this).prop("id");
        var text = jQuery("#reply_textarea_" + ticket_id + " > .ql-editor").html();
        if (text !== "<br>" && text !=="" && text != "<p><br></p>")
        {
            jQuery(".ticket_action_save_props").trigger("click");
            jQuery("#reply_textarea_" + ticket_id).css("border", "1px solid #F2F2F2");
            var fd = new FormData();
            var file = jQuery("#files_" + ticket_id);
            jQuery.each(jQuery(file), function (i, obj) {
                jQuery.each(obj.files, function (j, file) {
                    fd.append('file[' + j + ']', file);
                });
            });
            if (jQuery("#ticket_title_" + ticket_id).length)
            {
                var title = jQuery("#ticket_title_" + ticket_id).val();
                fd.append("ticket_title", title);
            }
            if (jQuery("#ticket_author_edit_"+ticket_id).length)
            {       
                var email = jQuery("#ticket_author_edit_"+ticket_id).val();     
                fd.append("wsd_ticket_email", email);
            }
            fd.append("ticket_reply", text);
            fd.append("ticket_id", ticket_id);
            fd.append("submit", submit);
            fd.append('action', 'eh_crm_ticket_reply_agent');
            fd.append('pagination_id', jQuery("#pagination_ids_traverse").val());
            jQuery(".ticket_loader_" + ticket_id).css("display", "inline");
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: fd,
                processData: false,
                contentType: false,
                success: function (data) {
                    jQuery(".ticket_loader_" + ticket_id).css("display", "none");
                    Cookies.remove('reply_textarea_'+ticket_id);
                    var parse = jQuery.parseJSON(data);
                    if(parse.status=='error')
                    {
                        jQuery(".alert-warning").css("display", "block");
                        jQuery(".alert-warning").css("opacity", "1");
                        jQuery("#warning_alert_text").html("<strong>"+js_obj.WSDesk_Tickets_Notification+"</strong><br>Ticket #" + ticket_id + " "+parse.message);
                        window.setTimeout(function () {
                            jQuery(".alert-warning").fadeTo(500, 0).slideUp(500, function () {
                                jQuery(this).css("display", "none");
                            });
                        }, 4000);
                    }
                    else
                    {
                        var tab_head = parse.tab_head;
                        var tab_content = parse.tab_content;
                        jQuery("#tab_" + ticket_id).html(tab_head);
                        jQuery("#tab_content_" + ticket_id).html(tab_content);
                        trigger_load_single_ticket(ticket_id);
                        var mail = parse.response;
                        var alert_msg = '';
                        if(typeof(mail.status) !== "undefined" && mail.status !== null) {
                            if(mail.status)
                            {
                                if(typeof(mail.message) !== "undefined" && mail.message !== null) {
                                    alert_msg = '<br/>'+mail.message;
                                }
                                else
                                {
                                    alert_msg = '<br/>'+"Email sent successfully";
                                }
                            }
                            else
                            {
                                alert_msg = '<br/>'+"Email not sent";
                            }
                        }
                        jQuery(".alert-success").css("display", "block");
                        jQuery(".alert-success").css("opacity", "1");
                        jQuery("#success_alert_text").html("<strong>"+js_obj.WSDesk_Tickets_Notification+"</strong><br>Ticket #" + ticket_id + " "+js_obj.Replied_Successfully+"!"+alert_msg);
                        window.setTimeout(function () {
                            jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                jQuery(this).css("display", "none");
                            });
                        }, 4000);
                    }
                }
            });
        } else
        {
            BootstrapDialog.show({
                title: js_obj.WSDesk_Alert,
                message: js_obj.Do_You_want_to_Submit_Ticket_Without_Reply,
                cssClass: 'wsdesk_wrapper',
                buttons: [{
                        label: js_obj.Yes_Submit,
                        // no title as it is optional
                        cssClass: 'btn-primary',
                        action: function (dialogItself) {
                            jQuery(".ticket_loader_" + ticket_id).css("display", "inline");
                            jQuery.ajax({
                                type: 'post',
                                url: ajaxurl,
                                data: {
                                    action: 'eh_crm_ticket_change_label',
                                    ticket_id: ticket_id,
                                    label: submit,
                                    pagination: jQuery("#pagination_ids_traverse").val()
                                },
                                success: function (data) {
                                    jQuery(".ticket_loader_" + ticket_id).css("display", "none");
                                    var parse = jQuery.parseJSON(data);
                                    var tab_head = parse.tab_head;
                                    var tab_content = parse.tab_content;
                                    jQuery("#tab_" + ticket_id).html(tab_head);
                                    jQuery("#tab_content_" + ticket_id).html(tab_content);
                                    trigger_load_single_ticket(ticket_id);
                                    jQuery(".table_loader").css("display", "none");
                                    jQuery(".alert-success").css("display", "block");
                                    jQuery(".alert-success").css("opacity", "1");
                                    jQuery("#success_alert_text").html("<strong>"+js_obj.WSDesk_Tickets_Notification+"</strong><br>"+js_obj.Ticket_Label_Changed+"!");
                                    window.setTimeout(function () {
                                        jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                            jQuery(this).css("display", "none");
                                        });
                                    }, 4000);
                                    jQuery(".ticket_reply_action_button_"+ticket_id).removeProp('disabled');
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(textStatus, errorThrown);
                                }
                            });
                            dialogItself.close();
                        }
                    }, {
                        label: 'Close',
                        action: function (dialogItself) {
                            dialogItself.close();
                        }
                    }]
            });
        }   
    });
    jQuery(".tab-content").on("click", ".direct_ticket_reply_action", function (e) {
        e.preventDefault();
        var ticket_id = jQuery(this).parent('li').prop("id");
        var text = jQuery("#direct_reply_textarea_" + ticket_id + " > .ql-editor").html();
        if (text !== "<br>" && text !=="")
        {
            jQuery("#direct_reply_textarea_" + ticket_id).css("border", "1px solid #F2F2F2");
            var submit = jQuery(this).prop("id");
            var fd = new FormData();
            var file = jQuery("#direct_files_" + ticket_id);
            jQuery.each(jQuery(file), function (i, obj) {
                jQuery.each(obj.files, function (j, file) {
                    fd.append('file[' + j + ']', file);
                });
            });
            if (jQuery("#direct_ticket_title_" + ticket_id).length)
            {
                var title = jQuery("#direct_ticket_title_" + ticket_id).val();
                fd.append("ticket_title", title);
            }
            fd.append("ticket_reply", text);
            fd.append("ticket_id", ticket_id);
            fd.append("submit", submit);
            fd.append('action', 'eh_crm_ticket_reply_agent');
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: fd,
                processData: false,
                contentType: false,
                success: function (data) {
                    if (jQuery("#tab_" + ticket_id).length != 0 && jQuery("#tab_content_" + ticket_id).length != 0)
                    {
                        var parse = jQuery.parseJSON(data);
                        var tab_head = parse.tab_head;
                        var tab_content = parse.tab_content;
                        jQuery("#tab_" + ticket_id).html(tab_head);
                        jQuery("#tab_content_" + ticket_id).html(tab_content);
                        trigger_load_single_ticket(ticket_id);
                    }
                    jQuery('#reply_' + ticket_id).modal('toggle');
                    refresh_left_bar();
                    refresh_right_bar();
                    var mail = parse.response;
                    var alert_msg = '';
                    if(typeof(mail.status) !== "undefined" && mail.status !== null) {
                        if(mail.status)
                        {
                            if(typeof(mail.message) !== "undefined" && mail.message !== null) {
                                alert_msg = '<br/>'+mail.message;
                            }
                            else
                            {
                                alert_msg = '<br/>'+"Email sent successfully";
                            }
                        }
                        else
                        {
                            alert_msg = '<br/>'+"Email not sent";
                        }
                    }
                    jQuery(".alert-success").css("display", "block");
                    jQuery(".alert-success").css("opacity", "1");
                    jQuery("#success_alert_text").html("<strong>"+js_obj.WSDesk_Tickets_Notification+"</strong><br>Ticket #" + ticket_id + " "+js_obj.Replied_Successfully+"!"+alert_msg);
                    window.setTimeout(function () {
                        jQuery(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                            jQuery(this).css("display", "none");
                        });
                    }, 4000);
                }
            });
        } else
        {
            jQuery(".alert-warning").css("display", "block");
            jQuery(".alert-warning").css("opacity", "1");
            jQuery("#warning_alert_text").html("<strong>"+js_obj.WSDesk_Tickets_Notification+"</strong><br>Ticket #" + ticket_id + " "+js_obj.needs_reply_content+"!");
            window.setTimeout(function () {
                jQuery(".alert-warning").fadeTo(500, 0).slideUp(500, function () {
                    jQuery(this).css("display", "none");
                });
            }, 4000);
        }
    });
    jQuery(".tab-content").on("click", ".ticket_action_save_props", function (e) {
        e.preventDefault();
        var ticket_id = jQuery(this).prop("id");
        var assignee = jQuery("#assignee_ticket_" + ticket_id).val();
        var tags = jQuery("#tags_ticket_" + ticket_id).val();
        var cc = [];
        var bcc = [];
        if(jQuery(".cc_" + ticket_id).length != 0)
        {
            cc = jQuery("#cc_ticket_" + ticket_id).val();
            if(cc === null)
            {
                cc =[];
            }
        }
        if(jQuery(".bcc_select_" + ticket_id).length != 0)
        {
            bcc = jQuery("#bcc_ticket_" + ticket_id).val();
            if(bcc === null)
            {
                bcc =[];
            }
        }
        var input_field = {};
        if (jQuery(".ticket_input_text_" + ticket_id).length != 0)
        {
            var text_validate = true;
            jQuery(".ticket_input_text_" + ticket_id).each(function () {
                var key = jQuery(this).prop("id");
                if(jQuery(this).hasClass('text_required') && jQuery(this).val() === "")
                {
                    jQuery(this).css('border','1px solid red');
                    text_validate = false;
                }
                else
                {
                    var value = jQuery(this).val();
                    jQuery(this).css('border','1px solid #ccc');
                    input_field[key] = value;
                    if(text_validate)
                    {
                        text_validate = true;
                    }
                }
            });
            if(!text_validate)
            {
                return false;
            }
        }
        if (jQuery(".ticket_input_date_" + ticket_id).length != 0)
        {
            var text_validate = true;
            jQuery(".ticket_input_date_" + ticket_id).each(function () {
                var key = jQuery(this).prop("id");
                if(jQuery(this).hasClass('text_required') && jQuery(this).val() === "")
                {
                    jQuery(this).css('border','1px solid red');
                    text_validate = false;
                }
                else
                {
                    var value = jQuery(this).val();
                    jQuery(this).css('border','1px solid #ccc');
                    key = key.replace('_t_'+ticket_id,'');
                    input_field[key] = value;
                    if(text_validate)
                    {
                        text_validate = true;
                    }
                }
            });
            if(!text_validate)
            {
                return false;
            }
        }
        if (jQuery(".ticket_input_email_" + ticket_id).length != 0)
        {
            var text_validate = true;
            jQuery(".ticket_input_email_" + ticket_id).each(function () {
                var key = jQuery(this).prop("id");
                if(jQuery(this).hasClass('text_required') && jQuery(this).val() === "")
                {
                    jQuery(this).css('border','1px solid red');
                    text_validate = false;
                }
                else
                {
                    var value = jQuery(this).val();
                    jQuery(this).css('border','1px solid #ccc');
                    input_field[key] = value;
                    if(text_validate)
                    {
                        text_validate = true;
                    }
                }
            });
            if(!text_validate)
            {
                return false;
            }
        }
        if (jQuery(".ticket_input_number_" + ticket_id).length != 0)
        {
            var text_validate = true;
            jQuery(".ticket_input_number_" + ticket_id).each(function () {
                var key = jQuery(this).prop("id");
                if(jQuery(this).hasClass('text_required') && jQuery(this).val() === "")
                {
                    jQuery(this).css('border','1px solid red');
                    text_validate = false;
                }
                else
                {
                    var value = jQuery(this).val();
                    jQuery(this).css('border','1px solid #ccc');
                    input_field[key] = value;
                    if(text_validate)
                    {
                        text_validate = true;
                    }
                }
            });
            if(!text_validate)
            {
                return false;
            }
        }
        if (jQuery(".ticket_input_pwd_" + ticket_id).length != 0)
        {
            var text_validate = true;
            jQuery(".ticket_input_pwd_" + ticket_id).each(function () {
                var key = jQuery(this).prop("id");
                if(jQuery(this).hasClass('text_required') && jQuery(this).val() === "")
                {
                    jQuery(this).css('border','1px solid red');
                    text_validate = false;
                }
                else
                {
                    var value = jQuery(this).val();
                    jQuery(this).css('border','1px solid #ccc');
                    input_field[key] = value;
                    if(text_validate)
                    {
                        text_validate = true;
                    }
                }
            });
            if(!text_validate)
            {
                return false;
            }
        }
        if (jQuery(".ticket_input_select_" + ticket_id).length != 0)
        {
            var text_validate = true;
            jQuery(".ticket_input_select_" + ticket_id).each(function () {
                var key = jQuery(this).prop("id");
                if(jQuery(this).hasClass('text_required') && jQuery(this).val() === "")
                {
                    jQuery(this).css('border','1px solid red');
                    text_validate = false;
                }
                else
                {
                    var value = jQuery(this).val();
                    jQuery(this).css('border','1px solid #ccc');
                    input_field[key] = value;
                    if(text_validate)
                    {
                        text_validate = true;
                    }
                }
            });
            if(!text_validate)
            {
                return false;
            }
        }
        if (jQuery(".ticket_input_radio_" + ticket_id).length != 0)
        {
            var radio_validate = true;
            jQuery(".ticket_input_radio_" + ticket_id).each(function () {
                var key = jQuery(this).prop("id");
                var value = ((jQuery("input[name='" + key + "']:checked").val() != undefined) ? jQuery("input[name='" + key + "']:checked").val() : "");
                if(jQuery(this).hasClass('radio_required') && value == "")
                {
                    jQuery(this).css('border','1px solid red');
                    radio_validate = false;
                }
                else
                {
                    jQuery(this).css('border','1px solid #ccc');
                    if(radio_validate)
                    {
                        radio_validate = true;
                    }
                    input_field[key] = value;
                }
            });
            if(!radio_validate)
            {
                return false;
            }
        }
        if (jQuery(".ticket_input_checkbox_" + ticket_id).length != 0)
        {
            var check_validate = true;
            jQuery(".ticket_input_checkbox_" + ticket_id).each(function () {
                var key = jQuery(this).prop("id");
                var value = getValue_checkbox(key);
                if(jQuery(this).hasClass('check_required') && value === "")
                {
                    jQuery(this).css('border','1px solid red');
                    check_validate = false;
                }
                else
                {
                    jQuery(this).css('border','1px solid #ccc');
                    if(check_validate)
                    {
                        check_validate = true;
                    }
                    input_field[key] = value;
                }
            });
            if(!check_validate)
            {
                return false;
            }
        }
        if (jQuery(".ticket_input_textarea_" + ticket_id).length != 0)
        {
            var text_validate = true;
            jQuery(".ticket_input_textarea_" + ticket_id).each(function () {
                var key = jQuery(this).prop("id");
                if(jQuery(this).hasClass('text_required') && jQuery(this).val() === "")
                {
                    jQuery(this).css('border','1px solid red');
                    text_validate = false;
                }
                else
                {
                    var value = jQuery(this).val();
                    jQuery(this).css('border','1px solid #ccc');
                    input_field[key] = value;
                    if(text_validate)
                    {
                        text_validate = true;
                    }
                }
            });
            if(!text_validate)
            {
                return false;
            }
        }
        var button = jQuery(this);
        jQuery(".ticket_loader_" + ticket_id).css("display", "inline");
        jQuery(button).prop("disabled", true);
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_single_save_props',
                ticket_id: ticket_id,
                assignee: (assignee !== null) ? assignee.join(",") : '',
                tags: (tags !== null) ? tags.join(",") : '',
                cc: (cc.length !== 0) ? cc : '',
                bcc: (bcc.length !== 0) ? bcc.join(",") : '',
                input: JSON.stringify(input_field)
            },
            success: function (data) {
                jQuery(".ticket_loader_" + ticket_id).css("display", "none");
                jQuery(button).removeProp("disabled");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    jQuery(".tab-content").on("click", ".ticket_author_edit_link", function(e){
        e.preventDefault();
        var ticket_id = e.target.id;
        jQuery("#ticket_author_"+ticket_id).hide();
        jQuery("#ticket_author_edit_"+ticket_id).show();
        jQuery("#ticket_author_edit_"+ticket_id).focus();
        jQuery("#ticket_author_edit_link_span_"+ticket_id).hide();
    });
    jQuery(".tab-content").on("focusout", ".ticket_author_editable", function(e){
        e.preventDefault();
        var id_arr = e.target.id.split("_");
        var ticket_id = id_arr[id_arr.length-1];
        jQuery("#ticket_author_"+ticket_id).show();
        jQuery("#ticket_author_edit_"+ticket_id).hide();
        jQuery("#ticket_author_edit_link_span_"+ticket_id).show();
    });
    function getValue_checkbox(id) {
        var chkArray = [];
        jQuery("#" + id + ":checked").each(function () {
            chkArray.push(jQuery(this).val());
        });
        if (chkArray.length > 0) {
            return chkArray;
        } else {
            return ('');
        }
    }
    jQuery("#tickets_page_view").on("click", ".collapse_ul > li > a", function (e) {
        e.preventDefault();
        jQuery('.elaborate > li.visible_tab').first().appendTo('ul.collapse_ul');
        jQuery('.elaborate > li').last().before(jQuery(this).parent());
        jQuery(this).click();
    });
    function previewFiles(files, id) {

        function readAndPreview(file) {
            // Make sure `file.name` matches our extensions criteria
            if (/\.(jpe?g|png|gif|3gp|avi|wmv|mpg|mov|flv)$/i.test(file.name)) {
                var reader = new FileReader();
                reader.addEventListener("load", function () {
                    var img_html = '<a href="' + this.result + '" target="_blank"><img class="img-upload clickable" style="width:150px" title="' + file.name + '" src=' + this.result + '></a>';
                    jQuery(".upload_preview_" + id).append(img_html);
                    jQuery(".upload_preview_edit").append(img_html);
                }, false);

                reader.readAsDataURL(file);
            } else
            {
                if (/\.(doc?x|pdf|xml|csv|xls|xlsx|txt|zip|mp3|mp4|syx|rtf)$/i.test(file.name)) {
                    var ext = (file.name).substr((file.name).lastIndexOf('.') + 1);
                    var reader = new FileReader();

                    reader.addEventListener("load", function () {
                        var img_html = '<a href="' + this.result + '" target="_blank" title="' + file.name + '" class="img-upload"><div class="' + ext + '"></div></a>';
                        jQuery(".upload_preview_" + id).append(img_html);
                        jQuery(".upload_preview_edit").append(img_html);
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
(function () {
    'use strict';
    var $ = jQuery;
    $.fn.extend({
        filterTable: function () {
            return this.each(function () {
                $(this).on('keyup', function (e) {
                    $('.filterTable_no_results').remove();
                    var $this = $(this),
                            search = $this.val().toLowerCase(),
                            target = $this.attr('data-filters'),
                            $target = $(target),
                            $rows = $target.find('tbody tr');

                    if (search == '') {
                        $rows.show();
                    } else {
                        $rows.each(function () {
                            var $this = $(this);
                            $this.text().toLowerCase().indexOf(search) === -1 ? $this.hide() : $this.show();
                        });
                        if ($target.find('tbody tr:visible').size() === 0) {
                            var col_count = $target.find('tr').first().find('td').size();
                            var no_results = $('<tr class="filterTable_no_results"><td colspan="12">'+js_obj.No_results_found+'</td></tr>')
                            $target.find('tbody').append(no_results);
                        }
                    }
                });
            });
        }
    });
    $('[data-action="filter"]').filterTable();
})(jQuery);

function tag_select2(id)
{
    jQuery(id).select2({
        width: '100%',
        allowClear: true,
        placeholder: js_obj.Select_Tag,
        formatNoMatches: function () {
            return js_obj.No_Tags_Tagged;
        },
        language: {
            noResults: function (params) {
                return js_obj.No_Tags_Tagged;
            }
        }
    });
}
function cc_select2(id)
{
    jQuery(id).select2({
        width: '100%',
        allowClear: true,
        placeholder: js_obj.Select_Cc,
        formatNoMatches: function () {
            return js_obj.No_Cc_found;
        },
        language: {
            noResults: function (params) {
                return js_obj.No_Cc_found;
            }
        }
    });
}
function bcc_select2(id)
{
    jQuery(id).select2({
        width: '100%',
        allowClear: true,
        placeholder: js_obj.Select_Bcc,
        formatNoMatches: function () {
            return js_obj.No_Bcc_found;
        },
        language: {
            noResults: function (params) {
                return js_obj.No_Bcc_found;
            }
        }
    });
}
function collapse_tab()
{
    var TAB = {

        wrapper: '.nav-tabs',

        init: function () {
            var _this = this;
            _this.reFlow();

            jQuery(window).on('resize', function () {
                _this.reFlow();
            });
        },

        reFlow: function () {
            var tab_wrapper = jQuery(this.wrapper);

            var wrapper_width = tab_wrapper.width(),
                    dropdown_width = tab_wrapper.find("li.dropdown").width(),
                    width_sum = 0;

            tab_wrapper.find('>li.visible_tab:not(li.dropdown)').each(function () {
                width_sum += jQuery(this).outerWidth(true);
            });

            var hidden_lists = tab_wrapper.find('>li.visible_tab');
            if (hidden_lists.length > 0 && width_sum + dropdown_width + 100 > wrapper_width)
            {
                jQuery("li.dropdown").show();
                jQuery('.elaborate > li.visible_tab').first().appendTo('ul.collapse_ul');
            } else
            {
                if (width_sum + dropdown_width + 100 < wrapper_width)
                {
                    jQuery('.elaborate > li').last().before(jQuery('ul.collapse_ul > li.visible_tab').first());
                }
                if (jQuery(".collapse_ul > li").length === 0)
                {
                    jQuery("li.dropdown").hide();
                }
            }
        }
    };
    if (jQuery('.nav-tabs').length) {
        TAB.init();
    }
}

function setURLFunc(tid){
    if(tid==="tickets"){
        window.history.pushState('Tickets', 'Title', wsdesk_data.ticket_admin_url);
    }else{
        window.history.pushState('Tickets', 'Title', wsdesk_data.ticket_admin_url+'&tid='+tid)};
}

function addToCookie(element,value)
{
    Cookies.set(element, value);
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
function deepview(){
    if($_GET('view') || $_GET('order') )
    {
        if($_GET('order'))
        {
            order = $_GET('order');
        }
        else
        {
            order = "DESC";
        }
        if($_GET('view'))
        {
            active = $_GET('view');
        }
        else
        {
            active = "all";
        }
        if($_GET('order_by'))
        {
            order_by = $_GET('order_by');
        }
        else
        {
            order_by = 'ticket_updated';
        }
        jQuery(".table_loader").css("display", "inline");
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_refresh_left_bar',
                active: active
            },
            success: function (data) {
                jQuery("#left_bar_all_tickets").html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'eh_crm_ticket_refresh_right_bar',
                active: active,
                order: order,
                order_by: order_by
            },
            success: function (data) {
                jQuery("#right_bar_all_tickets").html(data);

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
}
function collapse(id)
{
    jQuery('#'+id).animate({
        height: 'hide'
    });
    jQuery('#'+id+'_collapse').hide();
    jQuery('#'+id+'_drop').show();
    if(typeof Cookies.get('collapsed_views') !=='undefined')
    {
        var collapsed_views = JSON.parse(Cookies.get('collapsed_views'));
        collapsed_views.push(id);
    }
    else
    {
        var collapsed_views = new Array(id);
    }
    Cookies.remove('collapsed_views');
    addToCookie('collapsed_views',JSON.stringify(collapsed_views));
}
function drop(id)
{
    jQuery('#'+id).animate({
        height: 'show'
    });
    jQuery('#'+id+'_collapse').show();
    jQuery('#'+id+'_drop').hide();
    if(typeof Cookies.get('collapsed_views') !=='undefined')
    {
        var collapsed_views = JSON.parse(Cookies.get('collapsed_views'));
        while(collapsed_views.indexOf(id)!=-1)
        {
            collapsed_views.splice(collapsed_views.indexOf(id),1);
        }
        Cookies.remove('collapsed_views');
        addToCookie('collapsed_views',JSON.stringify(collapsed_views));
    }
}
function search_by_email(search, ticket_id)
{
    jQuery(".ticket_loader_" + ticket_id).css("display", "inline");
    var id = ticket_id;
    jQuery.ajax({
        type: 'post',
        url: ajaxurl,
        data: {
            action: 'eh_crm_ticket_search',
            search: search
        },
        success: function (data) {
            var parse = jQuery.parseJSON(data);
            jQuery(".ticket_loader_" + id).css('display', 'none');
            if(parse.data === "ticket")
            {
                var ticket_id = search;
                if (jQuery(".elaborate > li#tab_" + ticket_id).length == 0)
                {
                    var tab_head = '<li role="presentation" class="visible_tab ticket_tab_open" id="tab_' + ticket_id + '" style="min-width:200px;">' + parse.tab_head + '</li>';
                    var tab_content = '<div class="tab-pane" id="tab_content_' + ticket_id + '">' + parse.tab_content + '</div>';
                    jQuery('.elaborate > li').last().before(tab_head);
                    jQuery('.tab-content').append(tab_content);
                    trigger_load_single_ticket(ticket_id);
                    jQuery("reply_textarea_" + ticket_id + ' > .ql-editor').html(jQuery('direct_reply_textarea_' + ticket_id + ' > .ql-editor').html());
                    jQuery('.visible_tab a#tab_content_a_' + ticket_id).click();
                    collapse_tab();
                }
                else
                {
                    jQuery(".elaborate > li#tab_" + ticket_id).children('a').click();
                }
            }
            else
            {
                var search_key = search.replace(' ', '_');
                while(search_key.indexOf(" ")!=-1)
                {
                    search_key = search_key.replace(' ', '_');
                }
                while(search_key.indexOf("@")!=-1)
                {
                    search_key = search_key.replace('@', '_1attherate1_');
                }
                while(search_key.indexOf(".")!=-1)
                {
                    search_key = search_key.replace('.', '_1dot1_');
                }
                while(search_key.indexOf(";")!=-1)
                {
                    search_key = search_key.replace(';','_1semicolon1_');
                }
                while(search_key.indexOf("?")!=-1)
                {
                    search_key = search_key.replace('?','_1questionmark1_');
                }
                if (jQuery(".elaborate > li#tab_" + search_key).length == 0)
                {
                    var tab_head = '<li role="presentation" class="visible_tab" id="tab_' + search_key + '" style="min-width:200px;">' + parse.tab_head + '</li>';
                    var tab_content = '<div class="tab-pane" id="tab_content_' + search_key + '">' + parse.tab_content + '</div>';
                    jQuery('.elaborate > li').last().before(tab_head);
                    jQuery('.tab-content').append(tab_content);
                    jQuery('.visible_tab a#tab_content_a_'+search_key).click();
                    collapse_tab();
                }
                else
                {
                    jQuery(".elaborate > li#tab_" + search_key).children('a').click();
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });

}