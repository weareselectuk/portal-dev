jQuery(document).ready(function (jQuery) {
    jQuery(".satisfaction-div").on("click","#submit_satisfaction",function(e){
        var btn = jQuery(this);
        btn.prop("disabled","disabled");
        jQuery.ajax({
            type: "POST",
            url: satisfaction_object.ajax_url,
            data: 
            {
                action: 'eh_crm_survey_ticket_form',
                id: jQuery("#satisfaction_id").val(),
                author: jQuery("#satisfaction_author").val(),
                rating: jQuery("input[name='satisfaction-thumb']:checked").val(),
                comment: jQuery("#satisfaction_comment").val()
            },
            success: function (data)
            {
                btn.removeProp("disabled");
                jQuery('.satisfaction-div').html(data);
            }
        });
        e.preventDefault();
    });
});