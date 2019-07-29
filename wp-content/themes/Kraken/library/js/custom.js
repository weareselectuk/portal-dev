jQuery(document).ready(function($) {
	setTimeout(function() {
  
	  if ($('.js-select-client').length) {
		$('.js-select-user, .js-select-site').prop('disabled', false);
		selectByClient();
	  } else {
		$('.js-select-user').prop('disabled', false);
		selectBySite();
	  }
  
	}, 1000);
  
	function selectByClient() {
	  $('body').on('change', '.js-select-client', function() {
		var value = $(this).val();
		$('.js-select-user, .js-select-site').prop('disabled', false);
  
		if (value && value != '') {
		  $.ajax({
			  url: nfFrontEnd.adminAjax,
			  type: 'POST',
			  data: {
				action: 'getUsersAndSites',
				client_id: value
			  },
			})
			.done(function(result) {
  
			  $('.js-select-user').html(result.data.users);
			  $('.js-select-user').prop('disabled', false);
  
			  $('.js-select-site').html(result.data.sites);
			  $('.js-select-site').prop('disabled', false);
			});
		}
  
	  });
	}
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
	jQuery(document).ready(function($) {
	  $("[data-toggle=popover]").popover();
	});
  
	function selectBySite() {
	  $('body').on('change', '.js-select-site', function() {
		var value = $(this).val();
		$('.js-select-user').prop('disabled', false);
		if (value && value != '') {
		  $.ajax({
			  url: nfFrontEnd.adminAjax,
			  type: 'POST',
			  data: {
				action: 'getUsersBySite',
				siteId: value
			  },
			})
			.done(function(result) {
			  $('.js-select-user').html(result.data.users);
			  $('.js-select-user').prop('disabled', false);
			});
		}
	  });
	}
  
	$('.text-field').on('save', function(e, params) {
	  var post_id = $(this).data('pk');
	  var meta_key = $(this).attr('name');
  
	  var data = {
		action: 'updatePostMeta',
		post_id: post_id,
		meta_key: meta_key,
		meta_value: params.newValue
	  };
  
	  if (post_id == '') {
		post_id = global_post_id;
	  }
  
	  $.ajax({
		url: myajax.url,
		type: 'POST',
		data: data,
	  });
	});
	$('.text-field.delete').on('save', function(e, params) {
	  var post_id = $(this).data('pk');
	  var meta_key = $(this).attr('name');
  
	  var data = {
		action: 'updatePostMeta',
		post_id: post_id,
		meta_key: meta_key,
		meta_value: params.newValue
	  };
  
	  if (post_id == '') {
		post_id = global_post_id;
	  }
  
	  $.ajax({
		url: myajax.url,
		type: 'POST',
		data: data,
	  });
	  $(this).parents("tr").remove();
	});
	$(".tab-content").on("click", ".single_ticket_assignee", function (e) {
        e.preventDefault();
        var assignee = jQuery(this).prop("id");
        var ticket_id = jQuery(this).parent().prop("id");
        jQuery(".table_loader").css("display", "inline");
        jQuery(".single_ticket_assignee_button_" + ticket_id).prop("disabled", true);
        jQuery.ajax({
            type: 'post',
            url: myajax.url,
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
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

	});
	$(".tab-content").on("click", ".single_ticket_priority", function (e) {
        e.preventDefault();
        var priority = jQuery(this).prop("id");
        var ticket_id = jQuery(this).parent().prop("id");
        jQuery(".table_loader").css("display", "inline");
        jQuery(".single_ticket_priority_button_" + ticket_id).prop("disabled", true);
        jQuery.ajax({
            type: 'post',
            url: myajax.url,
            data: {
                action: 'eh_crm_ticket_single_ticket_priority',
                ticket_id: ticket_id,
                priority: priority,
                pagination_id : jQuery("#pagination_ids_traverse").val()
			},
            success: function (data) {
                jQuery(".table_loader").css("display", "none");
                if (jQuery("#tab_" + ticket_id).length != 0 && jQuery("#tab_content_" + ticket_id).length != 0)
                {
                    jQuery("#tab_content_" + ticket_id).html(data);
                    trigger_load_single_ticket(ticket_id);
                }                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

	});
	$(".tab-content").on("click", ".single_ticket_site", function (e) {
        e.preventDefault();
        var site = jQuery(this).prop("id");
        var ticket_id = jQuery(this).parent().prop("id");
        jQuery(".table_loader").css("display", "inline");
        jQuery(".single_ticket_site_button_" + ticket_id).prop("disabled", true);
        jQuery.ajax({
            type: 'post',
            url: myajax.url,
            data: {
                action: 'eh_crm_ticket_single_ticket_site',
                ticket_id: ticket_id,
                site: site,
                pagination_id : jQuery("#pagination_ids_traverse").val()
			},
            success: function (data) {
                jQuery(".table_loader").css("display", "none");
                if (jQuery("#tab_" + ticket_id).length != 0 && jQuery("#tab_content_" + ticket_id).length != 0)
                {
                    jQuery("#tab_content_" + ticket_id).html(data);
                    trigger_load_single_ticket(ticket_id);
                }                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

	});
	$(".tab-content").on("click", ".single_ticket_asset", function (e) {
        e.preventDefault();
        var asset = jQuery(this).prop("id");
        var ticket_id = jQuery(this).parent().prop("id");
        jQuery(".table_loader").css("display", "inline");
        jQuery(".single_ticket_asset_button_" + ticket_id).prop("disabled", true);
        jQuery.ajax({
            type: 'post',
            url: myajax.url,
            data: {
                action: 'eh_crm_ticket_single_ticket_asset',
                ticket_id: ticket_id,
                asset: asset,
                pagination_id : jQuery("#pagination_ids_traverse").val()
			},
            success: function (data) {
                jQuery(".table_loader").css("display", "none");
                if (jQuery("#tab_" + ticket_id).length != 0 && jQuery("#tab_content_" + ticket_id).length != 0)
                {
                    jQuery("#tab_content_" + ticket_id).html(data);
                    trigger_load_single_ticket(ticket_id);
                }                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

	});
	$(".tab-content").on("click", ".single_ticket_user", function (e) {
        e.preventDefault();
        var user = jQuery(this).prop("id");
        var ticket_id = jQuery(this).parent().prop("id");
        jQuery(".table_loader").css("display", "inline");
        jQuery(".single_ticket_user_button_" + ticket_id).prop("disabled", true);
        jQuery.ajax({
            type: 'post',
            url: myajax.url,
            data: {
                action: 'eh_crm_ticket_single_ticket_user',
                ticket_id: ticket_id,
                user: user,
                pagination_id : jQuery("#pagination_ids_traverse").val()
			},
            success: function (data) {
                jQuery(".table_loader").css("display", "none");
                if (jQuery("#tab_" + ticket_id).length != 0 && jQuery("#tab_content_" + ticket_id).length != 0)
                {
                    jQuery("#tab_content_" + ticket_id).html(data);
                    trigger_load_single_ticket(ticket_id);
                }                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

	});
	$(".tab-content").on("click", ".single_ticket_client", function (e) {
        e.preventDefault();
        var client = jQuery(this).prop("id");
        var ticket_id = jQuery(this).parent().prop("id");
        jQuery(".table_loader").css("display", "inline");
        jQuery(".single_ticket_client_button_" + ticket_id).prop("disabled", true);
        jQuery.ajax({
            type: 'post',
            url: myajax.url,
            data: {
                action: 'eh_crm_ticket_single_ticket_client',
                ticket_id: ticket_id,
                client: client,
                pagination_id : jQuery("#pagination_ids_traverse").val()
			},
            success: function (data) {
                jQuery(".table_loader").css("display", "none");
                if (jQuery("#tab_" + ticket_id).length != 0 && jQuery("#tab_content_" + ticket_id).length != 0)
                {
                    jQuery("#tab_content_" + ticket_id).html(data);
                    trigger_load_single_ticket(ticket_id);
                }                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

	});
	$(".tab-content").on("click", ".single_ticket_tags", function (e) {
        e.preventDefault();
        var priority = jQuery(this).prop("id");
        var ticket_id = jQuery(this).parent().prop("id");
        jQuery(".table_loader").css("display", "inline");
        jQuery(".single_ticket_priority_button_" + ticket_id).prop("disabled", true);
        jQuery.ajax({
            type: 'post',
            url: myajax.url,
            data: {
                action: 'eh_crm_ticket_single_ticket_tags',
                ticket_id: ticket_id,
                priority: priority,
                pagination_id : jQuery("#pagination_ids_traverse").val()
			},
            success: function (data) {
                jQuery(".table_loader").css("display", "none");
                if (jQuery("#tab_" + ticket_id).length != 0 && jQuery("#tab_content_" + ticket_id).length != 0)
                {
                    jQuery("#tab_content_" + ticket_id).html(data);
                    trigger_load_single_ticket(ticket_id);
                }                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

	});
	$(".tab-content").on("click", ".single_ticket_action", function (e) {
        e.preventDefault();
        var label = jQuery(this).prop("id");
        var ticket_id = jQuery(this).parent().prop("id");
        jQuery(".table_loader").css("display", "inline");
        jQuery(".single_ticket_action_button_" + ticket_id).prop("disabled", true);
        jQuery.ajax({
            type: 'post',
            url: myajax.url,
            data: {
                action: 'eh_crm_ticket_single_ticket_action',
                ticket_id: ticket_id,
                label: label,
                //pagination_id : jQuery("#pagination_ids_traverse").val()
			},/*
            success: function (data) {
                jQuery(".table_loader").css("display", "none");
                if (jQuery("#tab_" + ticket_id).length != 0 && jQuery("#tab_content_" + ticket_id).length != 0)
                {
                    jQuery("#tab_content_" + ticket_id).html(data);
                    trigger_load_single_ticket(ticket_id);
                }
                refresh_left_bar();
                refresh_right_bar();
            },*/
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

    });
	$('.conversation-fieldx').on('save', function(e, params) {
	  var ticket_id = $(this).data('pk');
	  var meta_key = $(this).attr('name');
  
	  var data = {
		action: 'updatePostMeta',
		ticket_id: ticket_id,
		meta_key: meta_key,
		meta_value: params.newValue
	  };
  
	  if (post_id == '') {
		post_id = global_post_id;
	  }
  
	  $.ajax({
		url: myajax.url,
		type: 'POST',
		data: data,
	  });
	});
	$('#helpdesk-fieldx').on('save', function eh_crm_ticket_single_save_props() {
	  var ticket_id = $(this).data('pk');
	  var meta_key = $(this).attr('name');
	  //var ticket_id = sanitize_text_field($_POST['ticket_id']);
	  var assignee = $(this).data('assignee');//['assignee']?explode(",", sanitize_text_field($_POST['assignee'])):array();
	  var tags = $(this).data('tags');//((sanitize_text_field($_POST['tags']) !== '')?explode(",", sanitize_text_field($_POST['tags'])):array());
	  var cc = $(this).data('cc');//((sanitize_text_field($_POST['cc']) !== '')?explode(",", sanitize_text_field($_POST['cc'])):array());
	  var bcc = $(this).data('bcc');//((sanitize_text_field($_POST['bcc']) !== '')?explode(",", sanitize_text_field($_POST['bcc'])):array());
	  var input = $(this).data('input');//json_decode(stripslashes(sanitize_text_field($_POST['input'])), true);
	  //eh_crm_update_ticketmeta($ticket_id, "ticket_assignee", $assignee);
	  //eh_crm_update_ticketmeta($ticket_id, "ticket_tags", $tags);
	  //eh_crm_update_ticketmeta($ticket_id, "ticket_cc", $cc,false);
	  //eh_crm_update_ticketmeta($ticket_id, "ticket_bcc", $bcc,false);
	  var data = {
		action: 'eh_crm_ticket_single_save_props',
		ticket_id: ticket_id,
		meta_key: meta_key,
		tags:tags,
		cc:cc,
		bcc:bcc,
		input:input,
		//meta_value: params.newValue
	  };
  
	  $.ajax({
		url: myajax.url,
		type: 'POST',
		data: data,
	  });
	});
  });
  jQuery(document).ready(function($) {
  
	$('.star').on('click', function() {
	  $(this).toggleClass('star-checked');
	});
  
	$('.ckbox label').on('click', function() {
	  $(this).parents('tr').toggleClass('selected');
	});
	/*
			$('.btn-filter').on('click', function () {
				$(this).toggleClass('active').siblings().removeClass('active');
				
		
					var $target = $(this).data('target');
					if ($target != 'all') {
						$('.table tr').css('display', 'none');
						$('.table tr[data-status="' + $target + '"]').fadeIn('slow');
					} else {
						$('.table tr').css('display', 'none').fadeIn('slow');
					}
				});*/
  
	$('.btn-filter.sites').on('click', function() {
	  $(this).toggleClass('active').siblings().removeClass('active');
	  var $target = $(this).data('target');
	  if ($target != 'all') {
		$('.table tr.filterable.sites').css('display', 'none');
		$('.table tr.filterable.sites[data-status="' + $target + '"]').fadeIn('slow');
	  } else {
		$('.table tr.filterable.sites').css('display', 'none').fadeIn('slow');
	  }
	});
	$('.btn-filter.users').on('click', function() {
	  $(this).toggleClass('active').siblings().removeClass('active');
  
  
	  var $target = $(this).data('target');
	  if ($target != 'all') {
		$('.table tr.filterable.users').css('display', 'none');
		$('.table tr.filterable.users[data-status="' + $target + '"]').fadeIn('slow');
		$('.table tr.filterable.users[data-employment="' + $target + '"]').fadeIn('slow');
	  } else {
		$('.table tr.filterable.users').css('display', 'none').fadeIn('slow');
	  }
	});
  
	$('.btn-filter.assets').on('click', function() {
	  $(this).toggleClass('active').siblings().removeClass('active');
	  var $target = $(this).data('target');
	  if ($target != 'all') {
		$('.table tr.filterable.assets').css('display', 'none');
		$('.table tr.filterable.assets[data-status="' + $target + '"]').fadeIn('slow');
		$('.table tr.filterable.assets[data-guru-license="' + $target + '"]').fadeIn('slow');
		$('.table tr.filterable.assets[data-device-class="' + $target + '"]').fadeIn('slow');
	  } else {
		$('.table tr.filterable.assets').css('display', 'none').fadeIn('slow');
	  }
	});
	$('.btn-filter.internal').on('click', function() {
	  $(this).toggleClass('active').siblings().removeClass('active');
  
  
	  var $target = $(this).data('target');
	  if ($target != 'all') {
		$('.table tr.filterable.internal').css('display', 'none');
		$('.table tr.filterable.internal[data-status="' + $target + '"]').fadeIn('slow');
	  } else {
		$('.table tr.filterable.internal').css('display', 'none').fadeIn('slow');
	  }
	});
	$('.btn-filter.external').on('click', function() {
	  $(this).toggleClass('active').siblings().removeClass('active');
  
  
	  var $target = $(this).data('target');
	  if ($target != 'all') {
		$('.table tr.filterable.external').css('display', 'none');
		$('.table tr.filterable.external[data-status="' + $target + '"]').fadeIn('slow');
	  } else {
		$('.table tr.filterable.external').css('display', 'none').fadeIn('slow');
	  }
	});
	$('.btn-filter.hosting').on('click', function() {
	  $(this).toggleClass('active').siblings().removeClass('active');
  
  
	  var $target = $(this).data('target');
	  if ($target != 'all') {
		$('.table tr.filterable.hosting').css('display', 'none');
		$('.table tr.filterable.hosting[data-status="' + $target + '"]').fadeIn('slow');
	  } else {
		$('.table tr.filterable.hosting').css('display', 'none').fadeIn('slow');
	  }
	});
  
	$('.btn-filter.domain').on('click', function() {
	  $(this).toggleClass('active').siblings().removeClass('active');
  
	  var $target = $(this).data('target');
	  if ($target != 'all') {
		$('.table tr.filterable.domain').css('display', 'none');
		$('.table tr.filterable.domain[data-status="' + $target + '"]').fadeIn('slow');
	  } else {
		$('.table tr.filterable.domain').css('display', 'none').fadeIn('slow');
	  }
	});
	$('.btn-filter.crush').on('click', function() {
	  $(this).toggleClass('active').siblings().removeClass('active');
  
  
	  var $target = $(this).data('target');
	  if ($target != 'all') {
		$('.table tr.filterable.crush').css('display', 'none');
		$('.table tr.filterable.crush[data-status="' + $target + '"]').fadeIn('slow');
		$('.table tr.filterable.crush[data-package="' + $target + '"]').fadeIn('slow');
	  } else {
		$('.table tr.filterable.crush').css('display', 'none').fadeIn('slow');
	  }
	});
	$('.btn-filter.ssl').on('click', function() {
	  $(this).toggleClass('active').siblings().removeClass('active');
  
  
	  var $target = $(this).data('target');
	  if ($target != 'all') {
		$('.table tr.filterable.ssl').css('display', 'none');
		$('.table tr.filterable.ssl[data-status="' + $target + '"]').fadeIn('slow');
	  } else {
		$('.table tr.filterable.ssl').css('display', 'none').fadeIn('slow');
	  }
	});
	$('.btn-filter.email').on('click', function() {
	  $(this).toggleClass('active').siblings().removeClass('active');
  
  
	  var $target = $(this).data('target');
	  if ($target != 'all') {
		$('.table tr.filterable.email').css('display', 'none');
		$('.table tr.filterable.email[data-status="' + $target + '"]').fadeIn('slow');
		$('.table tr.filterable.email[data-provider-type="' + $target + '"]').fadeIn('slow');
		$('.table tr.filterable.email[data-office-365="' + $target + '"]').fadeIn('slow');
		$('.table tr.filterable.email[data-gsuite="' + $target + '"]').fadeIn('slow');
		$('.table tr.filterable.email[data-mailbox-type="' + $target + '"]').fadeIn('slow');
  
	  } else {
		$('.table tr.filterable.email').css('display', 'none').fadeIn('slow');
	  }
	});
	$('.btn-filter.helpdesk').on('click', function() {
	  $(this).toggleClass('active').siblings().removeClass('active');
  
  
	  var $target = $(this).data('target');
	  if ($target != 'all') {
		$('div.filterable.helpdesk').css('display', 'none');
		$('div.filterable.helpdesk[data-client-total="' + $target + '"]').fadeIn('slow');
		$('div.filterable.helpdesk[data-engineer-status="' + $target + '"]').fadeIn('slow');
		$('div.filterable.helpdesk[data-tag="' + $target + '"]').fadeIn('slow');
		$('div.filterable.helpdesk[data-priority="' + $target + '"]').fadeIn('slow');
	  } else {
		$('div.filterable.helpdesk').css('display', 'none').fadeIn('slow');
	  }
	});
  
  });
  jQuery(document).ready(function($) {
	$('#interest_tabs').on('click', 'a[data-toggle="tab"]', function(e) {
	  e.preventDefault();
  
	  var $link = $(this);
  
	  if (!$link.parent().hasClass('active')) {
  
		//remove active class from other tab-panes
		$('.tab-content:not(.' + $link.attr('href').replace('#', '') + ') .tab-pane').removeClass('active');
  
		// click first submenu tab for active section
		$('a[href="' + $link.attr('href') + '_all"][data-toggle="tab"]').click();
  
		// activate tab-pane for active section
		$('.tab-content.' + $link.attr('href').replace('#', '') + ' .tab-pane:first').addClass('active');
	  }
	  $("ul.nav-tabs a").click(function(e) {
		e.preventDefault();
		$(this).tab('show');
	  });
	});
  });
  // toggle password visibility
  jQuery(document).ready(function($) {
	$('[id^=password] + .glyphicon').on('click', function() {
	  $(this).toggleClass('glyphicon-eye-close').toggleClass('glyphicon-eye-open'); // toggle our classes for the eye icon
	  $(this).prev().toggleClass('password');
	});
  });
  jQuery(document).ready(function($) {
	$('[id^=password] + .glyphicon + .btn').on('click', function() {
		$(this).prev().toggleClass('glyphicon-eye-close').toggleClass('glyphicon-eye-open'); // toggle our classes for the eye icon
		$(this).prev().prev().toggleClass('password');
	 
	new ClipboardJS('.btn.fas.fa-paste', {
	  container: document.getElementById('password')
	});
  });
});
  jQuery(document).ready(function($) {
	if (location.hash) {
	  $('a[href=\'' + location.hash + '\']').tab('show');
	}
	var activeTab = localStorage.getItem('activeTab');
	if (activeTab) {
	  $('a[href="' + activeTab + '"]').tab('show');
	}
  
	$('body').on('click', 'a[data-toggle=\'tab\']', function(e) {
	  e.preventDefault()
	  var tab_name = this.getAttribute('href')
	  if (history.pushState) {
		history.pushState(null, null, tab_name)
	  } else {
		location.hash = tab_name
	  }
	  localStorage.setItem('activeTab', tab_name)
  
	  $(this).tab('show');
	  return false;
	});
	$(window).on('popstate', function() {
	  var anchor = location.hash ||
		$('a[data-toggle=\'tab\']').first().attr('href');
	  $('a[href=\'' + anchor + '\']').tab('show');
	});
});