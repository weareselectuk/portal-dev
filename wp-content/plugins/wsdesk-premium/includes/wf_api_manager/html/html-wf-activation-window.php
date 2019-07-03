<style>
    .marketing_logos{
        width: 300px;
        height: 300px;
        border-radius: 10px;
    }
    .marketing_redirect_links{
        padding: 0px 2px !important;
        background-color: #fcb800;
        height: 52px;
        font-weight: 600 !important;
        font-size: 18px !important;
        min-width: 210px;
    }
</style>
<center>
    <div class="panel panel-default activation_panel" style="margin: 20px;">
        <div class="panel-heading">
            <h3 class="panel-title">Licence Activation</h3>
        </div>
        <div class="panel-body" id="activation_panel_body" style="text-align: center">
            <div id="aw-activation" class="content-row col-md-12 <?php echo $show_activation ?>">
                <center>
                    <div class="crm-form-element">
                        <div class="col-md-8 col-md-offset-2">
                            <span class="help-block">Enter your API Licence Key?</span>
                            <input type="text" class="form-control crm-form-element-input" placeholder="Licence Key" value="" id="wsdesk_txt_licence_key">
                        </div>
                    </div>
                    <div class="crm-form-element">
                        <div class="col-md-8 col-md-offset-2">
                            <span class="help-block">Enter your API Licence Email?</span>
                            <input type="text" id="wsdesk_txt_email" class="form-control crm-form-element-input" placeholder="Licence Email" value="">
                        </div>
                    </div>
                    <div class="crm-form-element">
                        <div class="col-md-8 col-md-offset-2">
                            <span class="help-block" style="text-align: center">Check <a href="https://elextensions.com/my-account/my-api-keys/" target="_blank">My Account</a> for API Keys and API Downloads.</span>
                            <button type="button" id="wsdesk_btn_licence_activate" data-loading-text="Activating WSDesk..." class="btn btn-primary btn-lg">Activate WSDesk</button>
                        </div>
                    </div>
                </center>
            </div>
            <div id="aw-deactivation" class="content-row <?php echo $show_deactivation ?>">
                <input type="hidden" id="hid_licence_key" value="<?php echo $licence_key ?>">
                <input type="hidden" id="hid_email" value="<?php echo $mail ?>">
                <div class="aw-deactivation-info">
                    Licence: <span id="info-licence-key"><?php echo $licence_key ?></span> &nbsp;|&nbsp;
                    Mail: <span id="info-licence-mail"><?php echo $mail ?></span> &nbsp;|&nbsp;
                    Status: <span id="info-status"><?php echo $status ?></span>
                    <br>
                    <br>
                    <button type="button" id="btn_licence_deactivate" data-loading-text="Deactivating WSDesk..." class="btn btn-danger btn-lg">Deactivate WSDesk</button>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default" style="margin: 20px;">
        <div class="panel-heading">
            <h3 class="panel-title"><?php _e('WSDesk Addons'); ?></h3>
        </div> 
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <img src="<?php echo EH_CRM_MAIN_IMG.'agent_signature_addon.png'?>" class="marketing_logos">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5><a href="https://elextensions.com/plugin/wsdesk-agent-signature-add-on/" data-wpel-link="internal" target="_blank">WSDesk Agent Signature Add-On</a></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <img src="<?php echo EH_CRM_MAIN_IMG.'sms_notification_addon.png'?>" class="marketing_logos">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5><a href="https://elextensions.com/plugin/wsdesk-sms-notification-add-on/" data-wpel-link="internal" target="_blank">WSDesk SMS Notification Add-On</a></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="https://elextensions.com/product-category/add-ons/" target="_blank">
                        <button type="submit" class="btn marketing_redirect_links" target="_blank">Show All ELEX Addons</button>
                    </form>
                </div>
            </div>
        </div>   
    </div>
    <div class="panel panel-default" style="margin: 20px;">
        <div class="panel-heading">
            <h3 class="panel-title"><?php _e('ELEX Plugins You May Be Interested In'); ?></h3>
        </div> 
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <img src="<?php echo EH_CRM_MAIN_IMG.'wschat.png'?>" class="marketing_logos">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5><a href="https://elextensions.com/plugin/wschat-wordpress-live-chat-plugin/" data-wpel-link="internal" target="_blank">WSChat – WordPress Live Chat Plugin</a> </h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <img src="<?php echo EH_CRM_MAIN_IMG.'dynamic_pricing.png'?>" class="marketing_logos">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5><a href="https://elextensions.com/plugin/dynamic-pricing-and-discounts-plugin-for-woocommerce/" data-wpel-link="internal" target="_blank">ELEX Dynamic Pricing and Discounts Plugin for WooCommerce</a></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <img src="<?php echo EH_CRM_MAIN_IMG.'catalog_mode.png'?>" class="marketing_logos">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5><a href="https://elextensions.com/plugin/woocommerce-catalog-mode-wholesale-role-based-pricing/" data-wpel-link="internal" target="_blank">ELEX WooCommerce Catalog Mode, Wholesale &amp; Role Based Pricing</a></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <img src="<?php echo EH_CRM_MAIN_IMG.'gpf.png'?>" class="marketing_logos">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5><a href="https://elextensions.com/plugin/woocommerce-google-product-feed-plugin/" data-wpel-link="internal" target="_blank">ELEX WooCommerce Google Product Feed Plugin</a></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <img src="<?php echo EH_CRM_MAIN_IMG.'bulk_edit.png'?>" class="marketing_logos">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5><a href="https://elextensions.com/plugin/bulk-edit-products-prices-attributes-for-woocommerce/" data-wpel-link="internal" target="_blank">ELEX Bulk Edit Products, Prices &amp; Attributes for WooCommerce</a></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="https://elextensions.com/product-category/plugins/" target="_blank">
                        <button href="https://elextensions.com/product-category/plugins/" class="btn marketing_redirect_links" target="_blank">Show All ELEX Plugins</a>
                </div>
            </div>
        </div>   
    </div>
</center>
<script>
    jQuery(document).on("click", "#wsdesk_btn_licence_activate", function () {
        var me = jQuery(this);
        var licence_key = jQuery('#wsdesk_txt_licence_key').val();
        var email = jQuery('#wsdesk_txt_email').val();
        var action = "wf_activate_license_keys_" + "<?php echo $plugin_name; ?>";
        var submit_data = {
            action: action,
            licence_key: licence_key,
            email: email
        };
        jQuery('#wsdesk_txt_licence_key').css("border","1px solid #ddd");
        jQuery('#wsdesk_txt_licence_key').css("border","1px solid #ddd");
        if (licence_key !== "" && email !=="") {
            var btn = jQuery(this);
            btn.prop("disabled","disabled");
            var ajax_url = 'admin-ajax.php?page=wsdesk_settings';
            jQuery.get(ajax_url, submit_data, function (data) {
                var formatted_data = jQuery.parseJSON(data);
                btn.removeProp("disabled");
                var html_msg = '';
                if (typeof formatted_data.error !== "undefined") {
                   var remove_style = 'updated';
                   var add_style = 'error';

                   var additional_info = '';
                    if (typeof formatted_data['additional info'] !== "undefined") {
                        additional_info = formatted_data['additional info'];
                    }

                    html_msg = "<p><strong>" + formatted_data.error + ": " + additional_info + " </strong></p>";
                } else if (formatted_data.activated) {
                   var html_msg = "<p> WSDesk Successfully Activated </p>";
                   var add_style = 'updated';
                   var remove_style = 'error';

                    jQuery("#info-status").html('active');
                    jQuery("#info-licence-key").html(licence_key);
                    jQuery("#info-licence-mail").html(email);

                    jQuery('#hid_licence_key').val(licence_key);
                    jQuery('#hid_email').val(email);

                    jQuery("#aw-activation").addClass("hidden");
                    jQuery("#aw-deactivation").removeClass("hidden");
                    jQuery(".activation_wsdesk").removeClass("not_activated").addClass("get_activated");
                    jQuery("#aw_wsdesk_status").html("( Activated )");
                } else {
                   var remove_style = 'updated';
                   var add_style = 'error';
                   var html_msg = "<p><strong>" + formatted_data + " </strong></p>";
                }
                jQuery("#result").html(html_msg)
                        .show()
                        .removeClass(remove_style)
                        .addClass(add_style);
            });
        }
        else
        {
            if(jQuery('#wsdesk_txt_licence_key').val() === "")
            {
                jQuery('#wsdesk_txt_licence_key').css("border","1px solid red");
            }
            if(jQuery('#wsdesk_txt_email').val() === "")
            {
                jQuery('#wsdesk_txt_email').css("border","1px solid red");
            }
        }

    });
    jQuery(document).on("click", "#btn_licence_deactivate", function () {
        me = jQuery(this);
        var btn = jQuery(this);
        btn.prop("disabled","disabled");
        licence_key = jQuery('#hid_licence_key').val();
        email = jQuery('#hid_email').val();
        action = "wf_deactivate_license_keys_" + "<?php echo $plugin_name; ?>";
        var submit_data = {
            action: action,
            licence_key: licence_key,
            email: email
        };

        if (licence_key.length > 0) {
            ajax_url = 'admin-ajax.php?page=wsdesk_settings';
            jQuery.get(ajax_url, submit_data, function (data) {
                btn.removeProp("disabled");
                var formatted_data = jQuery.parseJSON(data);
                var html_msg = '';
                if (typeof formatted_data.error !== "undefined") {
                    remove_style = 'updated';
                    add_style = 'error';

                    additional_info = '';
                    if (typeof formatted_data['additional info'] !== "undefined") {
                        additional_info = formatted_data['additional info'];
                    }

                    html_msg = "<p><strong>" + formatted_data.error + ": " + additional_info + " </strong></p>";
                } else if (formatted_data.deactivated) {
                    add_style = 'updated';
                    remove_style = 'error';
                    html_msg = "<p><strong> The WSDesk licence has been deactivated successfully</strong></p>";
                    jQuery("#aw-activation").removeClass("hidden");
                    jQuery("#aw-deactivation").addClass("hidden");
                    jQuery(".activation_wsdesk").removeClass("get_activated").addClass("not_activated");
                    jQuery("#aw_wsdesk_status").html("( Not Activated )");
                    jQuery("alert_for_activation").remove();
                } else {
                    remove_style = 'updated';
                    add_style = 'error';
                    html_msg = "<p><strong> " + formatted_data + "</strong></p>";
                }
                jQuery("#result").html(html_msg)
                        .show()
                        .removeClass(remove_style)
                        .addClass(add_style);
            });
        }

    });
</script>