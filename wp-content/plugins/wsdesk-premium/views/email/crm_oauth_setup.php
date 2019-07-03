<?php
if (!defined('ABSPATH')) {
    exit;
}
ob_start();
$client_id = eh_crm_get_settingsmeta('0', "oauth_client_id");
$client_secret = eh_crm_get_settingsmeta('0', "oauth_client_secret");
$oauth_activation = eh_crm_get_settingsmeta('0', "oauth_activation");
?>
    <div class="crm-form-element">
        <div class="col-md-12">
            <span class="help-block"><?php _e('Google API client ID','wsdesk'); ?> <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="<?php _e("You would get this after completing the entire process of enabling gmail API and Google OAuth.", 'wsdesk'); ?>" data-container="body"></span></span>
            <input type="text" id="oauth_client_id" value="<?php echo $client_id;?>" class="form-control crm-form-element-input">
        </div>
    </div>
    <div class="crm-form-element">
        <div class="col-md-12">
            <span class="help-block"><?php _e('Google API Client Secret','wsdesk'); ?> <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="<?php _e("You would get this after completing the entire process of enabling gmail API and Google OAuth.", 'wsdesk'); ?>" data-container="body"></span></span>
            <input type="text" id="oauth_client_secret" value="<?php echo $client_secret?>" class="form-control crm-form-element-input">
        </div>
    </div>
    <?php
    if($oauth_activation == "activated")
    {
        ?>
        <div class="crm-form-element">
            <div class="col-md-12">
                <span class="help-block"><?php _e('Access Token','wsdesk'); ?> <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="This should appear as soon as you click on 'Activate'. If it doesn't, then please recheck the 'Client ID' and 'Client Secret' fields" data-container="body"></span></span>
                <input type="text" readonly value="<?php echo eh_crm_get_settingsmeta('0', "oauth_accesstoken")?>" class="form-control crm-form-element-input">
            </div>
        </div>
        <div class="crm-form-element">
            <div class="col-md-12">
                <span class="help-block"><?php _e('Refresh Token','wsdesk'); ?> <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="This should appear as soon as you click on 'Activate'. If it doesn't, then please recheck the 'Client ID' and 'Client Secret' fields" data-container="body"></span></span>
                <input type="text" readonly value="<?php echo eh_crm_get_settingsmeta('0', "oauth_refreshtoken")?>" class="form-control crm-form-element-input">
            </div>
        </div>
        <?php
    }
    ?>
    <div class="crm-form-element">
        <div class="col-md-12">
            <?php
                if($oauth_activation == "activated")
                {
                    ?>
                    <button type="button" id="deactivate_oauth" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> <?php _e('Deactivate OAuth','wsdesk'); ?></button>
                    <?php
                }
                else
                {
                    ?>
                    <button type="button" id="activate_oauth" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> <?php _e('Activate OAuth','wsdesk'); ?></button>
                    <?php
                }
            ?>
            <a href="https://wsdesk.com/setting-up-google-oauth-for-wsdesk/" target="_blank" class="btn btn-info pull-right" ><span class="glyphicon glyphicon-link"></span> <?php _e('How to setup OAuth','wsdesk'); ?></a>        
        </div>
    </div>
<?php
return ob_get_clean();