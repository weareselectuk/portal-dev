<?php
if (!defined('ABSPATH')) {
    exit;
}

ob_start();
if(isset($display) && ($display === 'form' || $display==="form_only"))
{
    echo '<div class="eh_crm_support_main wsdesk_wrapper">';
}
$raiser_default = eh_crm_get_settingsmeta(0, 'ticket_raiser');
$login_redirect_url = eh_crm_get_settingsmeta(0, 'login_redirect_url');
$logout_redirect_url = eh_crm_get_settingsmeta(0, 'logout_redirect_url');
$register_redirect_url = eh_crm_get_settingsmeta(0, 'register_redirect_url');
if($raiser_default == "registered")
{
    if(!is_user_logged_in())
    {
        $url= wp_registration_url()."&redirect_to=".urlencode($register_redirect_url);
        echo '<div class="form-elements log-in"><span>'.__('You must Login to Raise Ticket', 'wsdesk').'</span><br><a class="btn btn-primary" href="'. wp_login_url($login_redirect_url).'">'.__('Login', 'wsdesk').'</a></div>';
        echo '<div class="form-elements sign-up"><span>'.__('Need an Account?', 'wsdesk').'</span><br><a class="btn btn-primary" href="'.$url.'">'.__('Register', 'wsdesk').'</a></div>';
        return ob_get_clean();
    }
}
else if($raiser_default=="guest")
{
    if(is_user_logged_in())
    {
        echo '<div class="form-elements"><span>'.__('You must Logout to Raise Ticket', 'wsdesk').'</span><br><a class="btn btn-primary" href="'. wp_logout_url($logout_redirect_url).'">'.__('Logout', 'wsdesk').'</a></div>';
        return ob_get_clean();
    }
}
$args = array("type" => "field");
$fields = array("slug", "title", "settings_id");
$avail_fields = eh_crm_get_settings($args, $fields);
$selected_fields = eh_crm_get_settingsmeta(0, 'selected_fields');

if(empty($selected_fields))
{
    $selected_fields = array('request_email','request_title','request_description');
}
if(isset($cus_fields) && !empty($cus_fields) && is_array($cus_fields))
{
    $select_val = array();
    foreach ($cus_fields as $value) {
        if(in_array($value, $selected_fields))
        {
            array_push($select_val, $value);
        }
    }
    $selected_fields = $select_val;
}
if(!in_array('request_description', $selected_fields))
{
    array_unshift($selected_fields, "request_description");
}
if(!in_array('request_title', $selected_fields))
{
    array_unshift($selected_fields, "request_title");
}
if(!in_array('request_email', $selected_fields))
{
    array_unshift($selected_fields, "request_email");
}
$input_width = eh_crm_get_settingsmeta(0, 'input_width');
$title= eh_crm_get_settingsmeta(0, 'new_ticket_form_title');

$title = eh_crm_wpml_translations($title, "title", "title");

$submit= eh_crm_get_settingsmeta(0, 'submit_ticket_button');

if(!$submit)
{
    $submit = __('Submit Request', 'wsdesk');
}

$submit = eh_crm_wpml_translations($submit, "submit", "submit");

$reset= eh_crm_get_settingsmeta(0, 'reset_ticket_button');

if(!$reset)
{
    $reset = __('Reset Request', 'wsdesk');
}

$reset = eh_crm_wpml_translations($reset, "reset", "reset");

$existing= eh_crm_get_settingsmeta(0, 'existing_ticket_button');
if(!$existing)
{
    $existing = __('Check your Existing Request', 'wsdesk');
}

$existing = eh_crm_wpml_translations($existing, "existing", "existing");
if(isset($display) && ($display === 'form'))
{
    echo '
            <div class="support_option_choose">
                <a href="'.eh_get_url_by_shortcode('[wsdesk_support display="check_request"').'"  target="_blank" data-loading-text="'.__('Loading your Request...', 'wsdesk').'" class="btn btn-primary eh_crm_check_request" role="button">
                    '.$existing.'
                </a>
        </div>';
}
echo '<div class="main_new_suppot_request_form">';
$css = '<style>
                .support_form
                {
                    width: ' . $input_width . '% !important;
                }
                </style>';
echo $css . '<form class="support_form" id="eh_crm_ticket_form">';
echo ($title!=='')?'<h3>'.$title.'</h3>':'';
$role='';
if(is_user_logged_in())
{
    if(isset(wp_get_current_user()->roles))
    {
        $wp_roles = array("administrator", "WSDesk_Agents", "WSDesk_Supervisor");
        foreach ($wp_roles as $wp_role) {
           
           $role_index = array_search($wp_role, wp_get_current_user()->roles);
           if($role_index)
           {
               $role = wp_get_current_user()->roles[$role_index];
               break;
           }
       }
    }
}
for ($i = 0; $i < count($selected_fields); $i++) {
    for ($j = 0; $j < count($avail_fields); $j++) {
        $current_meta = eh_crm_get_settingsmeta($avail_fields[$j]['settings_id']);
        if ($avail_fields[$j]['slug'] === $selected_fields[$i] && (!isset($current_meta['field_visible']) || $current_meta['field_visible'] === 'yes' || $current_meta['field_type']=='ip' || in_array($avail_fields[$j]['slug'],array('request_email','request_title','request_description'))))
        {
            echo '<div class="form-elements">';
            if($role=="WSDesk_Agents")
                 $required = (isset($current_meta['field_require_agent'])?$current_meta['field_require_agent']:'');
            else if($role=="WSDesk_Supervisor" || $role== "administrator")
                $required = "no";
            else
                $required = (isset($current_meta['field_require'])?$current_meta['field_require']:'');
           
            $required = ($required === "yes" || in_array($avail_fields[$j]['slug'],array('request_email','request_title','request_description')))?'required':'';
            if($current_meta['field_type']=='ip')
            {
                echo '<input type="hidden" value="'.$_SERVER['REMOTE_ADDR'].'" name="' . $selected_fields[$i] . '" id="' . $selected_fields[$i] . '" class="input_element form-control">';
            }
            else
            {
                $field_title = eh_crm_wpml_translations($avail_fields[$j]['title'], $avail_fields[$j]['settings_id']."_field_title", $avail_fields[$j]['settings_id']."_field_title");
                echo '<span>' . $field_title . ' </span>';
            }
            echo ($required === 'required') ? '<span class="input_required">*</span>' : ''.'<br>';
            $default_values = (isset($current_meta['field_default'])?$current_meta['field_default']:'');

            switch ($current_meta['field_type']) {
                case 'text':
                    $default_values = eh_crm_wpml_translations($default_values, $avail_fields[$j]['settings_id']."_field_default", $avail_fields[$j]['settings_id']."_field_default");

                    $field_placeholder = eh_crm_wpml_translations($current_meta['field_placeholder'], $avail_fields[$j]['settings_id']."_field_placeholder", $avail_fields[$j]['settings_id']."_field_placeholder");
                    echo '<input type="text" autocomplete="off" name="' . $selected_fields[$i] . '" id="' . $selected_fields[$i] . '" value="' . $default_values . '" class="input_element form-control" placeholder="' . $field_placeholder . '" ' . $required . '>';
                    break;
                case 'email':
                    $email = "";
                    if(is_user_logged_in() && $avail_fields[$j]['slug'] == "request_email")
                    {
                        $id = get_current_user_id();
                        $user = new WP_User($id);
                        $default_values = $user->user_email;
                    }
                    $field_placeholder = eh_crm_wpml_translations($current_meta['field_placeholder'], $avail_fields[$j]['settings_id']."_field_placeholder", $avail_fields[$j]['settings_id']."_field_placeholder");
                    echo '<input type="email" name="' . $selected_fields[$i] . '" id="' . $selected_fields[$i] . '" value="' . $default_values . '" class="input_element form-control" placeholder="' . $field_placeholder . '"' . $required . '>';
                    break;
                case 'phone':
                    echo '<br><span><strong>+</strong><input type="number" name="' . $selected_fields[$i] . '" id="' . $selected_fields[$i] . '" value="' . $default_values . '" class="input_element form-control" placeholder="' . $current_meta['field_placeholder'] . '"' . $required . ' style="display:  inline; width: 99% !important"></span>';
                    break;
                case 'number':
                    echo '<input type="number" name="' . $selected_fields[$i] . '" id="' . $selected_fields[$i] . '" value="' . $default_values . '" class="input_element form-control" placeholder="' . $current_meta['field_placeholder'] . '"' . $required . '>';
                    break;
                case 'password':
                    echo '<input type="password" name="' . $selected_fields[$i] . '" id="' . $selected_fields[$i] . '" value="' . $default_values . '" class="input_element form-control" placeholder="' . $current_meta['field_placeholder'] . '"' . $required . '>';
                    break;
                case 'select':
                $field_values = $current_meta['field_values'];
                $customer_temp_altered = array();
                $return = array();
                if($selected_fields[$i]=='woo_order_id')
                {
                    $id = get_current_user_id();
                    if($id != 0)
                    {
                        $customer_orders = wc_get_orders(array('customer_id'=>$id));
                        if(count($customer_orders)>0)
                        {
                            foreach ($customer_orders as $key =>$customer_order) 
                            {
                                array_push($customer_temp_altered, trim(str_replace(' ', '', $customer_order->get_order_number())));
                            }
                            for($g=0;$g<count($customer_temp_altered);$g++)
                            {
                                $return[$g] = $customer_temp_altered[$g];
                            }
                            echo '<select class="input_element form-control" name="' . $selected_fields[$i] . '" id="' . $selected_fields[$i] . '" ' . $required . '>';
                            echo '<option value="">'.(isset($current_meta['field_placeholder'])?$current_meta['field_placeholder']:'-').'</option>';
                            foreach ($return as $key => $val)
                            {
                                $select_default = '';
                                if ($default_values === $val)
                                {
                                    $select_default = 'selected';
                                }
                                $field_values_tranlsated = eh_crm_wpml_translations($val, $avail_fields[$j]['settings_id']."_".$key."_field_values", $avail_fields[$j]['settings_id']."_".$key."_field_values");
                                echo '<option value="' . $val . '" ' . $select_default . '>' .$field_values_tranlsated . '</option>';
                            }
                            echo '</select>';
                            break;
                        }
                    }
                }
                else
                {
                    $field_values = $current_meta['field_values'];
                    $field_keys = array_keys($field_values);
                    echo '<select class="input_element form-control" name="' . $selected_fields[$i] . '" id="' . $selected_fields[$i] . '" ' . $required . '>';
                    echo '<option value="">'.(isset($current_meta['field_placeholder'])?$current_meta['field_placeholder']:'-').'</option>';
                    $field_order = isset($current_meta['field_order'])?$current_meta['field_order']:array_keys($field_values);
                    foreach ($field_order as $value) {
                        $key = $value;
                        $select_default = '';
                        if ($default_values === $key) {
                            $select_default = 'selected';
                        }
                        $field_values_tranlsated = eh_crm_wpml_translations($field_values[$key], $avail_fields[$j]['settings_id']."_".$key."_field_values", $avail_fields[$j]['settings_id']."_".$key."_field_values");
                        echo '<option value="' . $key . '" ' . $select_default . '>' .$field_values_tranlsated . '</option>';
                    }
                    echo '</select>';
                    break;
                }
                case 'radio':
                    $field_values = $current_meta['field_values'];
                    echo '<span style="vertical-align: middle;display: block;">';
                    foreach ($field_values as $key => $value) {
                        $radio_default = '';
                        if ($default_values === $key) {
                            $radio_default = 'checked';
                        }
                        $field_values_tranlsated = eh_crm_wpml_translations($value, $avail_fields[$j]['settings_id']."_".$key."_field_values", $avail_fields[$j]['settings_id']."_".$key."_field_values");
                        echo '<input type="radio" class="form-control" name="' . $selected_fields[$i] . '" id="' . $selected_fields[$i] . '" style="margin-top: 0;" value="' . $key . '" ' . $radio_default . ' ' . $required . '>' . $field_values_tranlsated . '<br>';
                    }
                    echo "</span>";
                    break;
                case 'checkbox':
                    $field_values = $current_meta['field_values'];
                    echo '<span style="vertical-align: middle;display: block;">';
                    foreach ($field_values as $key => $value) {
                        $check_default = '';
                        if ($default_values === $key) {
                            $check_default = 'checked';
                        }
                        $field_values_tranlsated = eh_crm_wpml_translations($value, $avail_fields[$j]['settings_id']."_".$key."_field_values", $avail_fields[$j]['settings_id']."_".$key."_field_values");
                        echo '<input type="checkbox"  class="form-control" name="' . $selected_fields[$i] . '[]" id="' . $selected_fields[$i] . '[]" style="margin-top: 0;" value="' . $key . '" ' . $check_default . ' ' . $required . '> ' . $field_values_tranlsated . '<br>';
                    }
                    echo "</span>";
                    break;
                case 'textarea':
                    $default_values = eh_crm_wpml_translations($default_values, $avail_fields[$j]['settings_id']."_field_default", $avail_fields[$j]['settings_id']."_field_default");
                    echo '<textarea name="' . $selected_fields[$i] . '" id="' . $selected_fields[$i] . '" class="input_element form-control" ' . $required . '>' . $default_values . '</textarea>';
                    break;
                case 'date';
                    echo '<input type="text" autocomplete="off" name="' . $selected_fields[$i] . '" id="' . $selected_fields[$i] . '" class="input_element form-control trigger_date_jq" placeholder="' . $current_meta['field_placeholder'] . '" ' . $required . '>';
                    break;
                case 'file':
                    $file_type = ($current_meta['file_type'] == "multiple")?"multiple":"";
                    echo '<input type="file" name="'.$selected_fields[$i].'" id="'.$selected_fields[$i].'" ' . $file_type . ' class="input_element form-control ticket_attachment" ' . $required . ' style="height: auto;">';
                    break;
                case 'google_captcha':
                    echo '<div class="g-recaptcha" data-sitekey="'.$current_meta['field_site_key'].'"></div><div class="captcha-error"></div>';
                    break;
            }
            $field_description = eh_crm_wpml_translations($current_meta['field_description'], $avail_fields[$j]['settings_id']."_field_description", $avail_fields[$j]['settings_id']."_field_description");
            echo '<small>' . $field_description . '</small>';
            if(eh_crm_get_settingsmeta(0, "auto_suggestion") == "enable" && $selected_fields[$i] == "request_title")
            {
                echo '<div class="auto_suggestion_posts"></div>';
            }
            echo '</div><br>';
        }
    }
}
echo '<button  type="submit" id="crm_form_submit" class="btn btn-primary" data-loading-text="'.__('Submitting...', 'wsdesk').'">'.$submit.'</button>';
echo '<button  type="reset" class="btn btn-primary wsdesk_crm_reset_button_show_hide" style="margin-left:5px;">'.$reset.'</button></form>';
echo '</div>';
if(!defined('WSDESK_POWERED_SUPPORT'))
{
    echo '<div class="powered_wsdesk"><span>'. __('Powered by', 'wsdesk'). '</span> <a href="https://elextensions.com/plugin/wsdesk-wordpress-support-desk-plugin/" target="_blank" rel="nofollow">WSDesk</a></div>';
}
return ob_get_clean();
