<?php
if (!defined('ABSPATH')) {
    exit;
}
ob_start();
$server_url = eh_crm_get_settingsmeta('0', "imap_server_url");
$server_port = eh_crm_get_settingsmeta('0', "imap_server_port");
$server_email = eh_crm_get_settingsmeta('0', "imap_server_email");
$server_email_pwd = eh_crm_get_settingsmeta('0', "imap_server_email_pwd");
$imap_activation = eh_crm_get_settingsmeta('0', "imap_activation");
$delete_email = eh_crm_get_settingsmeta('0', "delete_email");
if(!in_array("imap", get_loaded_extensions()))
{
?>
    <div style="text-align: center;">
        <h1><span class="glyphicon glyphicon-screenshot" style="font-size: 2em;color: lightgrey;"></span></h1><br>
        <p>
        IMAP is not enabled on your server. Please contact your service provider.
        <br>
        <span class="crm-divider"></span>
        <b>Have a Google account?</b> Use WSDesk Google OAuth setup.
        <br>
        [ WSDesk -> E-Mail -> Google OAuth Setup ]
        <br>    
        </p>
    </div>

    <?php
}
else
{
?>
    <div class="crm-form-element">
        <div class="col-md-12">
            <span class="help-block"><?php _e('IMAP Server SSL URL','wsdesk'); ?> <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="<?php _e("Copy Paste the IMAP URL provided by your respective hosting service provider. ( viz. imap.gmail.com ).", 'wsdesk'); ?>" data-container="body"></span></span>
            <input type="text" id="server_url" placeholder="imap.gmail.com" value="<?php echo $server_url;?>" class="form-control crm-form-element-input">
        </div>
    </div>
    <div class="crm-form-element">
        <div class="col-md-12">
            <span class="help-block"><?php _e('IMAP Server SSL Port','wsdesk'); ?> <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="<?php _e(" Provide port number of your hosting service provider (993 for Gmail).", 'wsdesk'); ?>" data-container="body"></span></span>
            <input type="text" id="server_port" placeholder="993" value="<?php echo $server_port?>" class="form-control crm-form-element-input">
        </div>
    </div>
    <div class="crm-form-element">
        <div class="col-md-12">
            <span class="help-block"><?php _e('Email-ID','wsdesk'); ?> <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="<?php _e("Enter email address from where emails are to be extracted.", 'wsdesk'); ?>" data-container="body"></span></span>
            <input type="text" id="server_email" autocomplete="off" placeholder="example@gmail.com" value="<?php echo $server_email;?>" class="form-control crm-form-element-input">
        </div>
    </div>
    <div class="crm-form-element">
        <div class="col-md-12">
            <span class="help-block"><?php _e('Password','wsdesk'); ?> <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="<?php _e("Enter password for your email address.", 'wsdesk'); ?>" data-container="body"></span></span>
            <input type="password" id="server_email_pwd" autocomplete="off" placeholder="Password" value="<?php echo $server_email_pwd?>" class="form-control crm-form-element-input">
        </div>
    </div>
    <div class="crm-form-element">
        <div class="col-md-12">
            <span class="help-block"><?php _e('Delete imported e-mail from the server','wsdesk'); ?> <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="<?php _e("Enabling this will delete the e-mail after importing it as ticket.", 'wsdesk'); ?>" data-container="body"></span></span>
            <input type="checkbox" id="delete_email" autocomplete="off" value="yes" <?php echo ($delete_email == "yes")?"checked": ""; ?> class="form-control"><label style="font-weight: normal;">Enable</label>
        </div>
    </div>
    <div class="crm-form-element">
        <div class="col-md-12">
            <?php
                if($imap_activation == "activated")
                {
                    ?>
                    <button type="button" id="deactivate_imap" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> <?php _e('Deactivate IMAP','wsdesk'); ?></button>
                    <?php
                }
                else
                {
                    ?>
                    <button type="button" id="activate_imap" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> <?php _e('Activate IMAP','wsdesk'); ?></button>
                    <?php
                }
            ?>
            <a href="https://wsdesk.com/configure-imap-in-wsdesk/" target="_blank" class="btn btn-info pull-right" ><span class="glyphicon glyphicon-link"></span> <?php _e('How to setup IMAP','wsdesk'); ?></a>        
        </div>
    </div>
<?php
}
return ob_get_clean();