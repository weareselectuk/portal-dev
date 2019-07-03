<?php
$woo_order_tickets = eh_crm_get_settingsmeta('0', "woo_order_tickets");
$woo_order_price = eh_crm_get_settingsmeta('0', "woo_order_price");
$access = eh_crm_get_settingsmeta('0', "woo_order_access");
if(!$access)
{
    $access = array();
}
ob_start();
?>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="woo_order_tickets" style="padding-right:1em !important;"><?php _e('Show Order Details','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Want to display order details in customer ticket?','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
            <input type="radio" <?php echo ($woo_order_tickets === "enable")?"checked":""; ?> style="margin-top: 0;" id="woo_order_tickets" class="form-control" name="woo_order_tickets" value="enable"> <?php _e('Enable','wsdesk'); ?><br>
            <input type="radio" <?php echo ($woo_order_tickets === "disable")?"checked":""; ?> style="margin-top: 0;" id="woo_order_tickets" class="form-control" name="woo_order_tickets" value="disable"> <?php _e('Disable','wsdesk'); ?><br>
        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="woo_order_price" style="padding-right:1em !important;"><?php _e('Show Order Price','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Want to display order price along with Order details?','wsdesk'); ?></span>
        <span style="vertical-align: middle;">
            <input type="radio" <?php echo ($woo_order_price === "enable")?"checked":"";  ?> style="margin-top: 0;" id="woo_order_price" class="form-control" name="woo_order_price" value="enable"> <?php _e('Enable','wsdesk'); ?><br>
            <input type="radio" <?php echo ($woo_order_price === "disable")?"checked":""; ?> style="margin-top: 0;" id="woo_order_price" class="form-control" name="woo_order_price" value="disable"> <?php _e('Disable','wsdesk'); ?><br>
        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="woo_order_access" style="padding-right:1em !important;"><?php _e('Display Order Details','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Display order details only to?','wsdesk'); ?> </span>
        <span style="vertical-align: middle;">
            <input type="checkbox" style="margin-top: 0;"  id="woo_order_access" class="form-control" name="woo_order_access" value="administrator" <?php echo ((in_array('administrator', $access))?"checked":""); ?> > Administrator<br>
            <input type="checkbox" style="margin-top: 0;" id="woo_order_access" class="form-control" name="woo_order_access" value="WSDesk_Agents" <?php echo ((in_array('WSDesk_Agents', $access))?"checked":""); ?>> WSDesk Agents<br>
            <input type="checkbox" style="margin-top: 0;" id="woo_order_access" class="form-control" name="woo_order_access" value="WSDesk_Supervisor" <?php echo ((in_array('WSDesk_Supervisor', $access))?"checked":""); ?>> WSDesk Supervisors<br>
        </span>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-3">
        <label for="vendor_roles" style="padding-right:1em !important;"><?php _e('Multi-Vendor Roles','wsdesk'); ?></label>
    </div>
    <div class="col-md-9">
        <span class="help-block"><?php _e('Choose the vendor roles if you have installed any WC Vendor Plugin','wsdesk'); ?></span>
        <select multiple id="vendor_roles" style="width: 100% !important;display: inline !important" class="form-control" aria-describedby="helpBlock">
            <?php 
                $vendor = eh_crm_get_settingsmeta('0', "woo_vendor_roles")?eh_crm_get_settingsmeta('0', "woo_vendor_roles"):array();
                global $wp_roles;
                $user_roles = $wp_roles->role_names;
                if ($user_roles) 
                {
                    foreach ( $user_roles as $slug=>$name) {
                        echo '<option value="' . $slug .'" '.(in_array($slug,$vendor)?"selected":"").'>' .$name. '</option>';
                    }
                }
            ?>
        </select>
    </div>
</div>
<span class="crm-divider"></span>
<div class="crm-form-element">
    <div class="col-md-12">
        <button type="button" id="save_woocommerce" class="btn btn-primary btn-sm"> <span class="glyphicon glyphicon-ok"></span> <?php _e('Save Changes','wsdesk'); ?></button>
    </div>
</div>
<?php
return ob_get_clean();