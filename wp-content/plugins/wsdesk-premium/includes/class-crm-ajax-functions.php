<?php

    if (!defined('ABSPATH')) {
        exit;
    }

    class CRM_Ajax {

        static function eh_crm_refresh_tickets_count()
        {
            $default = eh_crm_get_settingsmeta(0, 'default_label');
            $tickets = eh_crm_get_ticketmeta_value_count("ticket_label",$default);
            die(json_encode(array("data"=>count($tickets))));
        }
        
        static function eh_crm_ticket_general() {
            $default_assignee = sanitize_text_field($_POST['default_assignee']);
            $default_label = sanitize_text_field($_POST['default_label']);
            $ticket_raiser = sanitize_text_field($_POST['ticket_raiser']);
            $auto_assign = sanitize_text_field($_POST['auto_assign']);
            $allow_agent_tickets = sanitize_text_field($_POST['allow_agent_tickets']);
            $auto_suggestion = sanitize_text_field($_POST['auto_suggestion']);
            $show_excerpt_in_auto_suggestion = sanitize_text_field($_POST['show_excerpt_in_auto_suggestion']);
            $auto_create_user = sanitize_text_field($_POST['auto_create_user']);
            $ticket_rows = sanitize_text_field($_POST['ticket_rows']);
            $custom_attachment = sanitize_text_field($_POST['custom_attachment']);
            $custom_attachment_path = sanitize_text_field($_POST['custom_attachment_path']);
            $max_file_size = sanitize_text_field($_POST['max_file_size']);
            $tickets_display = sanitize_text_field($_POST['tickets_display']);
            $ext = sanitize_text_field($_POST['ext']);
            $enable_api = sanitize_text_field($_POST['enable_api']);
            $api_key = sanitize_text_field($_POST['api_key']);
            $default_deep_link = sanitize_text_field($_POST['default_deep_link']);
            $close_tickets = sanitize_text_field($_POST['close_tickets']);
            $debug_status = sanitize_text_field($_POST['debug_status']);
            $login_redirect_url = sanitize_text_field($_POST['login_redirect_url']);
            $logout_redirect_url = sanitize_text_field($_POST['logout_redirect_url']);
            $register_redirect_url = sanitize_text_field($_POST['register_redirect_url']);
            $submit_ticket_redirect_url =  sanitize_text_field($_POST['submit_ticket_redirect_url']);
            $wsdesk_powered_by_status = sanitize_text_field($_POST['wsdesk_powered_by_status']);
            $exisiting_tickets_login_label = sanitize_text_field($_POST['exisiting_tickets_login_label']);
            $exisiting_tickets_register_label = sanitize_text_field($_POST['exisiting_tickets_register_label']);
            $linkify_urls = sanitize_text_field($_POST['linkify_urls']);
            eh_crm_update_settingsmeta('0', "default_assignee", $default_assignee);
            eh_crm_update_settingsmeta('0', "default_label", $default_label);
            eh_crm_update_settingsmeta('0', "ticket_raiser", $ticket_raiser);
            eh_crm_update_settingsmeta('0', "auto_assign", $auto_assign);
            eh_crm_update_settingsmeta('0', "auto_suggestion", $auto_suggestion);
            eh_crm_update_settingsmeta('0', "show_excerpt_in_auto_suggestion", $show_excerpt_in_auto_suggestion);
            eh_crm_update_settingsmeta('0', "auto_create_user", $auto_create_user);
            eh_crm_update_settingsmeta('0', "ticket_rows", $ticket_rows);
            eh_crm_update_settingsmeta('0', "custom_attachment_folder_enable", $custom_attachment);
            eh_crm_update_settingsmeta('0', "custom_attachment_folder_path", $custom_attachment_path);
            eh_crm_update_settingsmeta('0', "valid_file_extension",$ext);
            eh_crm_update_settingsmeta('0', "max_file_size", $max_file_size);
            eh_crm_update_settingsmeta('0', "enable_api", $enable_api);
            eh_crm_update_settingsmeta('0', "tickets_display", $tickets_display);
            eh_crm_update_settingsmeta('0', "api_key", $api_key);
            eh_crm_update_settingsmeta('0', "default_deep_link", $default_deep_link);
            eh_crm_update_settingsmeta('0', "close_tickets", $close_tickets);
            eh_crm_update_settingsmeta('0', "wsdesk_debug_status", $debug_status);
            eh_crm_update_settingsmeta('0', "login_redirect_url", $login_redirect_url);
            eh_crm_update_settingsmeta('0', "logout_redirect_url", $logout_redirect_url);
            eh_crm_update_settingsmeta('0', "register_redirect_url", $register_redirect_url);
            eh_crm_update_settingsmeta('0', "submit_ticket_redirect_url", $submit_ticket_redirect_url);
            eh_crm_update_settingsmeta('0', "wsdesk_powered_by_status", $wsdesk_powered_by_status);
            eh_crm_update_settingsmeta('0', "exisiting_tickets_login_label", $exisiting_tickets_login_label);
            eh_crm_update_settingsmeta('0', "exisiting_tickets_register_label", $exisiting_tickets_register_label);
            eh_crm_update_settingsmeta('0', "allow_agent_tickets", $allow_agent_tickets);
            eh_crm_update_settingsmeta('0', "linkify_urls", $linkify_urls);
            die(include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_general.php"));
        }

        static function eh_crm_ticket_appearance() {
            $input_width = sanitize_text_field($_POST['input_width']);
            $main_ticket_title = sanitize_text_field($_POST['main_ticket_title']);
            $new_ticket_title = sanitize_text_field($_POST['new_ticket_title']);
            $existing_ticket_title = sanitize_text_field($_POST['existing_ticket_title']);
            $submit_ticket_button = sanitize_text_field($_POST['submit_ticket_button']);
            $reset_ticket_button = sanitize_text_field($_POST['reset_ticket_button']);
            $existing_ticket_button = sanitize_text_field($_POST['existing_ticket_button']);
            eh_crm_update_settingsmeta('0', "input_width", $input_width);
            eh_crm_update_settingsmeta('0', "main_ticket_form_title", $main_ticket_title);
            eh_crm_update_settingsmeta('0', "new_ticket_form_title", $new_ticket_title);
            eh_crm_update_settingsmeta('0', "existing_ticket_title", $existing_ticket_title);
            eh_crm_update_settingsmeta('0', "submit_ticket_button", $submit_ticket_button);
            eh_crm_update_settingsmeta('0', "reset_ticket_button", $reset_ticket_button);
            eh_crm_update_settingsmeta('0', "existing_ticket_button", $existing_ticket_button);
            die(include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_appearance.php"));
        }

        static function eh_crm_woocommerce_settings(){
            $woo_order_tickets = $_POST['woo_order_tickets'];
            $woo_order_price = $_POST['woo_order_price'];
            $woo_order_access = explode(",",$_POST['woo_order_access']);
            if($_POST['woo_vendor_roles'] !== "")
            {
                $woo_vendor_roles = explode(",",$_POST['woo_vendor_roles']);
            }
            else
            {
                $woo_vendor_roles = array();
            }
            eh_crm_update_settingsmeta('0', "woo_order_tickets", $woo_order_tickets);
            eh_crm_update_settingsmeta('0', "woo_order_price", $woo_order_price);
            eh_crm_update_settingsmeta('0', "woo_order_access", $woo_order_access);
            eh_crm_update_settingsmeta('0', "woo_vendor_roles", $woo_vendor_roles);
            die(include(EH_CRM_MAIN_VIEWS . "settings/crm_woocommerce_settings.php"));
        }

        static function eh_crm_ticket_field_delete() {
            $fields_remove = sanitize_text_field($_POST['fields_remove']);
            $all_ticket_field_views = eh_crm_get_settingsmeta("0", "all_ticket_page_columns");

            $args = array("type" => "field");
            $fields = array("settings_id", "slug");
            $avail_fields = eh_crm_get_settings($args, $fields);
            $selected_fields = eh_crm_get_settingsmeta("0", "selected_fields");
            if(($key = array_search($fields_remove, $selected_fields)) !== false) {
                unset($selected_fields[$key]);
            }
            if(($key = array_search($fields_remove, $all_ticket_field_views)) !== false) {
                unset($all_ticket_field_views[$key]);
            }
            eh_crm_update_settingsmeta("0", "selected_fields", array_values($selected_fields));
            eh_crm_update_settingsmeta("0", "all_ticket_page_columns", $all_ticket_field_views);
            for ($i = 0; $i < count($avail_fields); $i++) {
                if ($avail_fields[$i]["slug"] == $fields_remove) {
                    eh_crm_delete_settings($avail_fields[$i]["settings_id"]);
                }
            }
            die(json_encode(array('fields'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_fields.php"),'views'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_views.php"),'triggers'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_wsdesk_triggers.php"), 'page'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_page.php"))));
        }
        
        static function eh_crm_ticket_field_activate_deactivate() {
            $field_id = sanitize_text_field($_POST['field_id']);
            $type = sanitize_text_field($_POST['type']);
            $selected_fields = eh_crm_get_settingsmeta("0", "selected_fields");
            switch ($type) {
                case "activate":
                    if (!in_array($field_id,$selected_fields)) {
                        array_push($selected_fields,$field_id);
                    }
                    eh_crm_update_settingsmeta("0", "selected_fields", array_values($selected_fields));
                    break;
                case "deactivate":
                    $all_ticket_field_views = eh_crm_get_settingsmeta("0", "all_ticket_page_columns");
                    if(($key = array_search($field_id, $all_ticket_field_views)) !== false) {
                        unset($all_ticket_field_views[$key]);
                    }
                    eh_crm_update_settingsmeta("0", "all_ticket_page_columns", $all_ticket_field_views);
                    if(($key = array_search($field_id, $selected_fields)) !== false) {
                        unset($selected_fields[$key]);
                    }
                    eh_crm_update_settingsmeta("0", "selected_fields", array_values($selected_fields));
                    break;
                default:
                    break;
            }
            die(json_encode(array('fields'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_fields.php"),'views'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_views.php"),'triggers'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_wsdesk_triggers.php"), 'page'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_page.php"))));
        }
        
        static function eh_crm_ticket_field() {
            $selected_fields = explode(",", sanitize_text_field($_POST['selected_fields']));
            $new_field = json_decode(stripslashes($_POST['new_field']), True);
            if(!empty($new_field))
            {
                $new_field['description'] = str_replace("</script>","",$new_field['description']);
                $new_field['description'] = str_replace("<script>","",$new_field['description']);
            }
            $edit_field = json_decode(stripslashes($_POST['edit_field']), True);
            $all_ticket_field_views = json_decode(stripslashes($_POST['all_tickets_view']), True);
            $args = array("type" => "field");
            $fields = array("settings_id", "slug");
            $temp = eh_crm_get_settings($args, $fields);
            $slug = array();
            for ($i = 0; $i < count($temp); $i++) {
                $slug[$i] = $temp[$i]['slug'];
            }
            for ($i = 0; $i < count($selected_fields); $i++) {
                if (!in_array($selected_fields[$i], $slug)) {
                    unset($selected_fields[$i]);
                }
            }
            eh_crm_update_settingsmeta("0", "selected_fields", array_values($selected_fields));
            eh_crm_update_settingsmeta("0", "all_ticket_field_views", $all_ticket_field_views);
            if (!empty($new_field)) {
                $insert = array(
                    'title' => $new_field['title'],
                    'filter' => 'no',
                    'type' => 'field',
                    'vendor' => ''
                );
                switch ($new_field['type']) {
                    case "file":
                        $meta = array
                        (
                            "field_type" => $new_field['type'],
                            "field_require" => $new_field['required'],
                            "field_visible" => $new_field['visible'],
                            "field_description" => $new_field['description'],
                            "file_type" => $new_field['file_type']
                        );
                        eh_crm_insert_settings($insert, $meta);
                        break;
                    case "text":
                    case "number":
                    case "email":
                    case "password":
                        $meta = array
                            (
                            "field_type" => $new_field['type'],
                            "field_default" => $new_field['default'],
                            "field_require" => $new_field['required'],
                            "field_visible" => $new_field['visible'],
                            "field_require_agent" => $new_field['required_agent'],
                            "field_placeholder" => $new_field['placeholder'],
                            "field_description" => $new_field['description']
                        );
                        eh_crm_insert_settings($insert, $meta);
                        break;
                    case "phone":
                        $meta = array
                            (
                            "field_type" => $new_field['type'],
                            "field_default" => $new_field['default'],
                            "field_require" => $new_field['required'],
                            "field_visible" => $new_field['visible'],
                            "field_require_agent" => $new_field['required_agent'],
                            "field_placeholder" => $new_field['placeholder'],
                            "field_description" => $new_field['description']
                        );
                        eh_crm_insert_settings($insert, $meta, "phone_number");
                        break;
                    case "date":
                        $meta = array
                            (
                            "field_type" => $new_field['type'],
                            "field_require" => $new_field['required'],
                            "field_visible" => $new_field['visible'],
                            "field_require_agent" => $new_field['required_agent'],
                            "field_placeholder" => $new_field['placeholder'],
                            "field_description" => $new_field['description']
                        );
                        eh_crm_insert_settings($insert, $meta);
                        break;
                    case "checkbox":
                    case "radio":
                    case "select":
                        $meta = array
                            (
                            "field_type" => $new_field['type'],
                            "field_require" => $new_field['required'],
                            "field_visible" => $new_field['visible'],
                            "field_require_agent" => $new_field['required_agent'],
                            "field_description" => $new_field['description']
                        );
                        if($new_field['type'] === 'select')
                        {
                            $meta["field_placeholder"] = $new_field['placeholder'];
                        }
                        $id = eh_crm_insert_settings($insert, $meta);
                        $args = array("settings_id" => $id);
                        $fields = array("slug");
                        $data = eh_crm_get_settings($args, $fields);
                        $values = $new_field['values'];
                        $gen_val = array();
                        $gen_def = "";
                        for ($i = 0; $i < count($values); $i++) {
                            $key = $data[0]['slug'] . "_V" . $i;
                            $gen_val[$key] = $values[$i];
                            if ($values[$i] == $new_field['default']) {
                                $gen_def = $key;
                            }
                        }
                        eh_crm_insert_settingsmeta($id, "field_default", $gen_def);
                        eh_crm_insert_settingsmeta($id, "field_values", $gen_val);
                        break;
                    case 'woo_product':
                    case 'woo_order_id':
                    case 'edd_products':
                    case 'woo_category':
                    case 'woo_tags':
                    case 'woo_vendors':
                        $meta = array
                        (
                            "field_type" => "select",
                            "field_require" => $new_field['required'],
                            "field_visible" => $new_field['visible'],
                            "field_require_agent" => $new_field['required_agent'],
                            "field_description" => $new_field['description'],
                            "field_placeholder" => $new_field['placeholder']
                        );
                        if ($new_field['type'] == 'woo_order_id')
                        {
                            $meta = array
                            (
                            "field_type" => "select",
                            "field_require" => $new_field['required'],
                            "field_visible" => $new_field['visible'],
                            "field_require_agent" => $new_field['required_agent'],
                            "field_description" => $new_field['description'],
                            "field_placeholder" => $new_field['placeholder']
                            );
                        }
                        $id = eh_crm_insert_settings($insert, $meta,$new_field['type']);
                        $args = array("settings_id" => $id);
                        $fields = array("slug");
                        $data = eh_crm_get_settings($args, $fields);
                        $values = $new_field['values'];
                        $gen_val = array();
                        $gen_def = "";
                        foreach ($values as $key => $value) {
                            $next_ran = 0;
                            if(strpos($key, 'new_add') !== false)
                            {
                                $key = $data[0]['slug'] . "_V" . $next_ran;
                                $gen_val[$key] = $value;
                                $next_ran++;
                            }
                            else
                            {
                                $gen_val[$key] = $value;
                            }
                            if ($value == $new_field['default']) {
                                $gen_def = $key;
                            }
                        }
                        eh_crm_insert_settingsmeta($id, "field_default", $gen_def);
                        eh_crm_insert_settingsmeta($id, "field_values", $gen_val);
                        break;
                    case 'textarea':
                        $meta = array
                            (
                            "field_type" => $new_field['type'],
                            "field_default" => $new_field['default'],
                            "field_require" => $new_field['required'],
                            "field_visible" => $new_field['visible'],
                            "field_require_agent" => $new_field['required_agent'],
                            "field_description" => $new_field['description']
                        );
                        eh_crm_insert_settings($insert, $meta);
                        break;
                    case 'ip':
                        $meta = array
                        (
                            "field_type" => $new_field['type'],
                            "field_description" => $new_field['description']
                        );
                        eh_crm_insert_settings($insert, $meta);
                        break;
                    case 'google_captcha':
                        $meta = array
                        (
                            "field_type" => $new_field['type'],
                            "field_site_key" => $new_field['site_key'],
                            "field_secret_key" => $new_field['secret_key'],
                            "field_require" => $new_field['required'],
                            "field_description" => $new_field['description']
                        );
                        eh_crm_insert_settings($insert, $meta,$new_field['type']);
                        break;
                }
            }
            if (!empty($edit_field)) {
                $edit_slug = $edit_field["slug"];
                $edit_title = $edit_field["title"];
                $edit_required = $edit_field["required"];
                $edit_visible = $edit_field['visible'];
                $edit_require_agent = $edit_field['required_agent'];
                $edit_placeholder = $edit_field["placeholder"];
                $edit_default = $edit_field["default"];
                $edit_values = $edit_field["values"];
                $edit_file_type = $edit_field["file_type"];
                $edit_description = $edit_field["description"];
                $field_data = eh_crm_get_settings(array("slug" => $edit_slug, "type" => "field"), "settings_id");
                if (!empty($field_data)) {
                    $field_id = $field_data[0]['settings_id'];
                    eh_crm_update_settings($field_id, array("title" => $edit_title, "filter" => 'no'));
                    eh_crm_update_settingsmeta($field_id, "field_description", $edit_description);
                    eh_crm_update_settingsmeta($field_id, "field_placeholder", $edit_placeholder);
                    eh_crm_update_settingsmeta($field_id, "field_default", $edit_default);
                    if ($edit_required !== "") {
                        eh_crm_update_settingsmeta($field_id, "field_require", $edit_required);
                    }
                    if ($edit_file_type !== "") {
                        eh_crm_update_settingsmeta($field_id, "file_type", $edit_file_type);
                    }
                    if ($edit_visible !== "") {
                        eh_crm_update_settingsmeta($field_id, "field_visible", $edit_visible);
                    }
                    if ($edit_require_agent !== "") {
                        eh_crm_update_settingsmeta($field_id, "field_require_agent", $edit_require_agent);
                    }
                    if ($edit_values !== "") {
                        $gen_val_old = eh_crm_get_settingsmeta($field_id, "field_values");
                        $old_keys = array_keys($gen_val_old);
                        $gen_def = "";
                        $gen_val = array();
                        $next_ran = 0;
                        foreach($old_keys as $old_key)
                        {
                            $cur_ran = str_replace($edit_slug."_V","", $old_key);
                            if($cur_ran > $next_ran) {
                                $next_ran = $cur_ran;
                            }
                        }
                        foreach ($edit_values as $key => $value) {
                            if(in_array($key, $old_keys))
                            {
                                $gen_val[$key] = $value;
                            }
                            else
                            {
                                $key = $edit_slug . "_V" . (++$next_ran);
                                $gen_val[$key] = $value;
                            }
                            if ($value == $edit_default) {
                                $gen_def = $key;
                            }
                        }
                        eh_crm_update_settingsmeta($field_id, "field_default", $gen_def);
                        eh_crm_update_settingsmeta($field_id, "field_values", $gen_val);
                        if(isset($edit_field['field_order']))
                        {
                            if(count($edit_field['field_order']) != count($gen_val))
                            {
                                $new_fields = array_diff(array_keys($gen_val), $edit_field['field_order']);
                                $edit_field['field_order'] = array_merge($edit_field['field_order'], $new_fields);
                            }
                            eh_crm_update_settingsmeta($field_id, "field_order", $edit_field['field_order']);
                        }
                    }
                }
            }
            die(json_encode(array('fields'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_fields.php"),'views'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_views.php"),'triggers'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_wsdesk_triggers.php"), 'page'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_page.php"))));
        }
        
        static function eh_crm_woo_product_fetch() {
            ini_set('max_execution_time', 300);
            $args_post = array(
                'orderby' => 'ID',
                'numberposts' => -1,
                'post_type' => array('product')
            );
            $products = get_posts($args_post);
            $return = array();
            $title = array();

            for($i=0;$i<count($products);$i++)
            {
                $return["p_".$products[$i]->ID] = $products[$i]->post_title;
                $title[] = $products[$i]->post_title;
            }
            sort($title);
            $final_return = array();
            foreach ($title as $value) {
                $key = array_search($value, $return);
                $final_return[$key] = $value;
            }

            die(json_encode($final_return));
        }

        static function eh_crm_get_edd_products() {
            ini_set('max_execution_time', 300);
            $args_post = array(
                'orderby' => 'ID',
                'numberposts' => -1,
                'post_type' => array('download')
            );
            $products = get_posts($args_post);
            $return = array();
            for($i=0;$i<count($products);$i++)
            {
                $return[$i]['id'] = "p_".$products[$i]->ID;
                $return[$i]['title'] = $products[$i]->post_title;
            }
            die(json_encode($return));
        }
        static function eh_crm_woo_category_fetch() {
            ini_set('max_execution_time', 300);
            $cat_args        = array(
                'hide_empty' => false,
                'order' => 'ASC'
            );
            $categories = get_terms('product_cat', $cat_args);
            $return = array();
            for($i=0;$i<count($categories);$i++)
            {
                $return[$i]['id'] = "c_".$categories[$i]->slug;
                $return[$i]['title'] = $categories[$i]->name;
            }
            die(json_encode($return));
        }
        
        static function eh_crm_woo_tags_fetch() {
            ini_set('max_execution_time', 300);
            $cat_args        = array(
                'hide_empty' => false,
                'order' => 'ASC'
            );
            $tags = get_terms('product_tag', $cat_args);
            $return = array();
            for($i=0;$i<count($tags);$i++)
            {
                $return[$i]['id'] = "t_".$tags[$i]->slug;
                $return[$i]['title'] = $tags[$i]->name;
            }
            die(json_encode($return));
        }
        
        static function eh_crm_woo_vendors_fetch() {
            ini_set('max_execution_time', 300);
            $vendors = eh_crm_get_settingsmeta(0,"woo_vendor_roles");
            if($vendors)
            {
                $users_data = get_users(array("role__in"=>$vendors));
                $return = array();
                for($i=0;$i<count($users_data);$i++)
                {
                    $current = $users_data[$i];
                    $return[$i]['id'] = "v_".$current->ID;
                    $return[$i]['title'] = $current->data->display_name;
                }
                if(empty($return))
                {
                    die(json_encode(array('status'=>'no_roles','data'=>__('No Vendors Found', 'wsdesk'))));
                }
                else
                {
                    die(json_encode(array('status'=>'roles','data'=>$return)));
                }
            }
            else
            {
                die(json_encode(array('status'=>'no_roles','data'=>__('No Vendors Roles defined!', 'wsdesk'))));
            }
        }
        
        static function eh_crm_ticket_field_edit() {
            $field = sanitize_text_field($_POST['field']);
            $args = array("slug" => $field, "type" => "field");
            $fields = array("settings_id", "title", "filter");
            $field_sett = eh_crm_get_settings($args, $fields);
            $field_meta = eh_crm_get_settingsmeta($field_sett[0]['settings_id']);
            $add_value = '<button class="button" id="ticket_field_edit_values_add" style="vertical-align: baseline;margin-bottom: 10px;">'.__('Add Value', 'wsdesk').'</button>';
            $output = '<span class="help-block">'.__('Edit Details for custom', 'wsdesk').' ' . ucfirst($field_meta['field_type']) . '? </span>';
            $output .= '<input type="text" id="ticket_field_edit_title" placeholder="'.__('Enter Title', 'wsdesk').'" class="form-control crm-form-element-input" value="' . $field_sett[0]['title'] . '">';
            switch ($field_meta['field_type']) {
                case '':
                    break;
                case 'file':
                    $required_end = "";
                    if ($field_meta['field_require'] == "yes") {
                        $required_end = "checked";
                    }
                    $single = "";
                    $multiple = "";
                    if ($field_meta['file_type'] == "single") {
                        $multiple = "";
                        $single = "checked";
                    } else {
                        $multiple = "checked";
                        $single = "";
                    }
                    $visible = "";
                    if (isset($field_meta['field_visible']) && $field_meta['field_visible'] == "yes") {
                        $visible = "checked";
                    }
                    $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_visible" class="form-control" name="ticket_field_edit_visible" ' . $visible . ' value="yes"> '.__('Visible for End Users', 'wsdesk').'</span>';
                    $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_require" class="form-control" name="ticket_field_edit_require" ' . $required_end . ' value="yes"> '.__('Mandatory for End users', 'wsdesk').'</span>';
                    $output .= '<br><span class="help-block">'.__('Specify whether this Field is Single or Multiple Attachment?', 'wsdesk').' </span><input type="radio" style="margin-top: 0;"  id="ticket_field_edit_file_type" checked class="form-control" name="ticket_field_edit_file_type" ' . $single .' value="single"> '.__('Single Attachment', 'wsdesk').' <br><input type="radio" style="margin-top: 0;" id="ticket_field_edit_file_type" class="form-control" name="ticket_field_edit_file_type" ' . $multiple . ' value="multiple"> '.__('Multiple Attachment', 'wsdesk').' <br>';
                    $output .= '<br><span class="help-block">'.__('Want to update description to this field?', 'wsdesk').' </span><textarea id="ticket_field_edit_description" class="form-control crm-form-element-input" style="padding: 10px !important;">' . $field_meta['field_description'] . '</textarea>';
                    break;
                case 'radio':
                    $required_end = "";
                    if ($field_meta['field_require'] == "yes") {
                        $required_end = "checked";
                    }
                    $required_agent = "";
                    if (isset($field_meta['field_require_agent']) && $field_meta['field_require_agent'] == "yes") {
                        $required_agent = "checked";
                    }
                    $visible = "";
                    if (isset($field_meta['field_visible']) && $field_meta['field_visible'] == "yes") {
                        $visible = "checked";
                    }
                    $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_visible" class="form-control" name="ticket_field_edit_visible" ' . $visible . ' value="yes"> '.__('Visible for End Users', 'wsdesk').'</span>';
                    $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_require" class="form-control" name="ticket_field_edit_require" ' . $required_end . ' value="yes"> '.__('Mandatory for End users', 'wsdesk').'</span>';
                    $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_agent_require" class="form-control" name="ticket_field_edit_agent_require" ' . $required_agent . ' value="yes"> '.__('Mandatory for Agents', 'wsdesk').'</span>';
                    $output .= '<span class="help-block">'.__('Update the Radio values!', 'wsdesk').' </span>';
                    $field_values = array_values($field_meta['field_values']);
                    $field_keys = array_keys($field_meta['field_values']);
                    for ($i = 0; $i < count($field_values); $i++) {
                        if($i==0)
                        {
                            $output .= '<span id="ticket_field_edit_values_span_'. $i .'" class="ticket_field_edit_values_span"><input type="text" id="ticket_field_edit_values[' . $i . ']" class="form-control ticket_field_edit_values crm-form-element-input" value="' . $field_values[$i] . '"><input type="hidden" class="old_ticket_field_edit_values[' . $i . ']" id="'.$field_keys[$i].'" value="'.$field_values[$i].'"></span>';
                        }
                        else
                        {
                            $output .='<span id="ticket_field_edit_values_span_'. $i .'" class="ticket_field_edit_values_span"><input type="text" id="ticket_field_edit_values[' . $i . ']" class="form-control ticket_field_edit_values crm-form-element-input" style="width:90% !important;" value="' . $field_values[$i] . '"><input type="hidden" class="old_ticket_field_edit_values[' . $i . ']" id="'.$field_keys[$i].'" value="'.$field_values[$i].'"><button class="btn btn-warning" title="'.__('Remove Values', 'wsdesk').'" id="ticket_field_edit_values_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button></span>';
                        }
                    }
                    $output .= $add_value;
                    if($field_meta['field_default']=="")
                    {
                        $def = "";
                    }
                    else
                    {
                        $def = (isset($field_meta['field_values'][$field_meta['field_default']])?$field_meta['field_values'][$field_meta['field_default']]:"");
                    }
                    $output .= '<br>'.__('Enter Default Values', 'wsdesk').'<input type="text" id="ticket_field_edit_default" class="form-control crm-form-element-input" value="' . $def . '">';
                    $output .= '<br><span class="help-block">'.__('Want to update description to this field?', 'wsdesk').' </span><textarea id="ticket_field_edit_description" class="form-control crm-form-element-input" style="padding: 10px !important;">' . $field_meta['field_description'] . '</textarea>';
                    break;
                case 'checkbox':
                    $required_end = "";
                    if ($field_meta['field_require'] == "yes") {
                        $required_end = "checked";
                    }
                    $required_agent = "";
                    if (isset($field_meta['field_require_agent']) && $field_meta['field_require_agent'] == "yes") {
                        $required_agent = "checked";
                    }
                    $visible = "";
                    if (isset($field_meta['field_visible']) && $field_meta['field_visible'] == "yes") {
                        $visible = "checked";
                    }
                    $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_visible" class="form-control" name="ticket_field_edit_visible" ' . $visible . ' value="yes"> '.__('Visible for End Users', 'wsdesk').'</span>';
                    $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_require" class="form-control" name="ticket_field_edit_require" ' . $required_end . ' value="yes"> '.__('Mandatory for End users', 'wsdesk').'</span>';
                    $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_agent_require" class="form-control" name="ticket_field_edit_agent_require" ' . $required_agent . ' value="yes"> '.__('Mandatory for Agents', 'wsdesk').'</span>';
                    $output .= '<span class="help-block">'.__('Update the Checkbox values!', 'wsdesk').' </span>';
                    $field_values = array_values($field_meta['field_values']);
                    $field_keys = array_keys($field_meta['field_values']);
                    for ($i = 0; $i < count($field_values); $i++) {
                        if($i==0)
                        {
                            $output .= '<span id="ticket_field_edit_values_span_'. $i .'" class="ticket_field_edit_values_span"><input type="text" id="ticket_field_edit_values[' . $i . ']" class="form-control ticket_field_edit_values crm-form-element-input" value="' . $field_values[$i] . '"><input type="hidden" class="old_ticket_field_edit_values[' . $i . ']" id="'.$field_keys[$i].'" value="'.$field_values[$i].'"></span>';
                        }
                        else
                        {
                            $output .='<span id="ticket_field_edit_values_span_'. $i .'" class="ticket_field_edit_values_span"><input type="text" id="ticket_field_edit_values[' . $i . ']" class="form-control ticket_field_edit_values crm-form-element-input" style="width:90% !important;" value="' . $field_values[$i] . '"><input type="hidden" class="old_ticket_field_edit_values[' . $i . ']" id="'.$field_keys[$i].'" value="'.$field_values[$i].'"><button class="btn btn-warning" title="'.__('Remove Values', 'wsdesk').'" id="ticket_field_edit_values_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button></span>';
                        }
                    }
                    $output .= $add_value;
                    if($field_meta['field_default']=="")
                    {
                        $def = "";
                    }
                    else
                    {
                        $def = (isset($field_meta['field_values'][$field_meta['field_default']])?$field_meta['field_values'][$field_meta['field_default']]:"");
                    }
                    $output .= '<br>'.__('Enter Default Values', 'wsdesk').'<input type="text" id="ticket_field_edit_default" class="form-control crm-form-element-input" value="' . $def . '">';
                    $output .= '<br><span class="help-block">'.__('Want to update description to this field?', 'wsdesk').' </span><textarea id="ticket_field_edit_description" class="form-control crm-form-element-input" style="padding: 10px !important;">' . $field_meta['field_description'] . '</textarea>';
                    break;
                case 'select':
                
                    $required_end = "";
                    if ($field_meta['field_require'] == "yes") {
                        $required_end = "checked";
                    }
                    $required_agent = "";
                    if (isset($field_meta['field_require_agent']) && $field_meta['field_require_agent'] == "yes") {
                        $required_agent = "checked";
                    }
                    $visible = "";
                    if (isset($field_meta['field_visible']) && $field_meta['field_visible'] == "yes") {
                        $visible = "checked";
                    }
                    $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_visible" class="form-control" name="ticket_field_edit_visible" ' . $visible . ' value="yes"> '.__('Visible for End Users', 'wsdesk').'</span>';
                    $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_require" class="form-control" name="ticket_field_edit_require" ' . $required_end . ' value="yes"> '.__('Mandatory for End users', 'wsdesk').'</span>';
                    $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_agent_require" class="form-control" name="ticket_field_edit_agent_require" ' . $required_agent . ' value="yes"> '.__('Mandatory for Agents', 'wsdesk').'</span>';
                    $output .= '<br>'.__('Enter Placeholder', 'wsdesk').'<input type="text" id="ticket_field_edit_placeholder" class="form-control crm-form-element-input" value="' . (isset($field_meta['field_placeholder'])?$field_meta['field_placeholder']:'') . '">';
                    if($args['slug']!='woo_order_id')
                    {    
                        $output .= '<span class="help-block">'.__('Update the Dropdown values!', 'wsdesk').' </span>';
                        $field_values = array_values($field_meta['field_values']);
                        $field_keys = array_keys($field_meta['field_values']);
                        for ($i = 0; $i < count($field_values); $i++) {
                            if($i==0)
                            {
                                if(in_array($field, array("woo_product","woo_category","woo_tags","edd_products")))
                                {
                                    $output .='<span id="ticket_field_edit_values_span_'. $i .'" class="ticket_field_edit_values_span"><input type="text" id="ticket_field_edit_values[' . $i . ']" class="form-control ticket_field_edit_values crm-form-element-input" style="width:90% !important;" value="' . $field_values[$i] . '"><input type="hidden" class="old_ticket_field_edit_values[' . $i . ']" id="'.$field_keys[$i].'" value="'.$field_values[$i].'"><button class="btn btn-warning" title="'.__('Remove Values', 'wsdesk').'" id="ticket_field_edit_values_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button></span>';
                                }
                                else
                                {
                                    $output .= '<span id="ticket_field_edit_values_span_'. $i .'" class="ticket_field_edit_values_span"><input type="text" id="ticket_field_edit_values[' . $i . ']" class="form-control ticket_field_edit_values crm-form-element-input" value="' . $field_values[$i] . '"><input type="hidden" class="old_ticket_field_edit_values[' . $i . ']" id="'.$field_keys[$i].'" value="'.$field_values[$i].'"></span>';
                                }
                            }
                            else
                            {
                                $output .='<span id="ticket_field_edit_values_span_'. $i .'" class="ticket_field_edit_values_span"><input type="text" id="ticket_field_edit_values[' . $i . ']" class="form-control ticket_field_edit_values crm-form-element-input" style="width:90% !important;" value="' . $field_values[$i] . '"><input type="hidden" class="old_ticket_field_edit_values[' . $i . ']" id="'.$field_keys[$i].'" value="'.$field_values[$i].'"><button class="btn btn-warning" title="'.__('Remove Values', 'wsdesk').'" id="ticket_field_edit_values_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button></span>';
                            }
                        }
                    }
                    if($args['slug']!='woo_order_id')
                    {
                        $output .= $add_value;
                    }
                    if($field_meta['field_default']=="")
                    {
                        $def = "";
                    }
                    else
                    {
                        $def = (isset($field_meta['field_values'][$field_meta['field_default']])?$field_meta['field_values'][$field_meta['field_default']]:"");
                    }
                    if($args['slug'] =='woo_order_id')
                    {
                        $output .= '<br>'.'<input type="hidden" id="ticket_field_edit_default" class="form-control crm-form-element-input" value="' . $def . '">';
                    }
                    else
                    {
                        $output .= '<br>'.__('Enter Default Values', 'wsdesk').'<input type="text" id="ticket_field_edit_default" class="form-control crm-form-element-input" value="' . $def . '">';
                    }
                    $output .= '<br><span class="help-block">'.__('Want to update description to this field?', 'wsdesk').' </span><textarea id="ticket_field_edit_description" class="form-control crm-form-element-input" style="padding: 10px !important;">' . $field_meta['field_description'] . '</textarea>';

                    $output .= '<br><span class="help-block">'.__('Rearrange the options for front end', 'wsdesk').' </span><select class="dropdown_options_order" id="dropdown_options_order_'.$args['slug'].'" name="dropdown_options_order[]" size="6" style="width: 300px;height:auto;min-height:150px;" >';
                    $field_order = isset($field_meta['field_order'])?$field_meta['field_order']:$field_keys;
                    
                    for ($i = 0; $i < count($field_order); $i++) {
                        $key = array_search($field_order[$i], $field_keys);
                        $selected = 'selected';
                        if($i)
                            $selected = '';
                        $output .='<option value="'.$field_keys[$key].'" '.$selected.'>'.$field_values[$key].'</option>';
                    }
                    $output .= '</select>';
                    $output .= '<br><br><div><button class="button dropdown-order-up" id="'.$args['slug'].'" >UP </button> &nbsp;&nbsp;';
                    $output .= '<button class="button dropdown-order-down" id="'.$args['slug'].'">DOWN</button></div>';
                    break;
                case 'textarea':
                    if($field != 'request_description')
                    {
                        $required_end = "";
                        if ($field_meta['field_require'] == "yes") {
                            $required_end = "checked";
                        }
                        $required_agent = "";
                        if (isset($field_meta['field_require_agent']) && $field_meta['field_require_agent'] == "yes") {
                            $required_agent = "checked";
                        }
                        $visible = "";
                        if (isset($field_meta['field_visible']) && $field_meta['field_visible'] == "yes") {
                            $visible = "checked";
                        }
                        $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_visible" class="form-control" name="ticket_field_edit_visible" ' . $visible . ' value="yes"> '.__('Visible for End Users', 'wsdesk').'</span>';
                        $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_require" class="form-control" name="ticket_field_edit_require" ' . $required_end . ' value="yes"> '.__('Mandatory for End users', 'wsdesk').'</span>';
                        $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_agent_require" class="form-control" name="ticket_field_edit_agent_require" ' . $required_agent . ' value="yes"> '.__('Mandatory for Agents', 'wsdesk').'</span>';
                    }
                    $output .= '<br>'.__('Enter Default Values', 'wsdesk').'<input type="text" id="ticket_field_edit_default" class="form-control crm-form-element-input" value="' . $field_meta['field_default'] . '">';
                    $output .= '<br><span class="help-block">'.__('Want to update description to this field?', 'wsdesk').' </span><textarea id="ticket_field_edit_description" class="form-control crm-form-element-input" style="padding: 10px !important;">' . $field_meta['field_description'] . '</textarea>';
                    break;
                case "date":
                    $required_end = "";
                    if ($field_meta['field_require'] == "yes") {
                        $required_end = "checked";
                    }
                    $required_agent = "";
                    if (isset($field_meta['field_require_agent']) && $field_meta['field_require_agent'] == "yes") {
                        $required_agent = "checked";
                    }
                    $visible = "";
                    if (isset($field_meta['field_visible']) && $field_meta['field_visible'] == "yes") {
                        $visible = "checked";
                    }
                    $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_visible" class="form-control" name="ticket_field_edit_visible" ' . $visible . ' value="yes"> '.__('Visible for End Users', 'wsdesk').'</span>';
                    $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_require" class="form-control" name="ticket_field_edit_require" ' . $required_end . ' value="yes"> '.__('Mandatory for End users', 'wsdesk').'</span>';
                    $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_agent_require" class="form-control" name="ticket_field_edit_agent_require" ' . $required_agent . ' value="yes"> '.__('Mandatory for Agents', 'wsdesk').'</span>';
                    $output .= '<br>'.__('Enter Placeholder', 'wsdesk').'<input type="text" id="ticket_field_edit_placeholder" class="form-control crm-form-element-input" value="' . $field_meta['field_placeholder'] . '">';
                    $output .= '<br><span class="help-block">'.__('Want to update description to this field?', 'wsdesk').' </span><textarea id="ticket_field_edit_description" class="form-control crm-form-element-input" style="padding: 10px !important;">' . $field_meta['field_description'] . '</textarea>';
                    break;
                case 'ip':
                    $output .= '<br><span class="help-block">'.__('Want to update description to this field?', 'wsdesk').' </span><textarea id="ticket_field_edit_description" class="form-control crm-form-element-input" style="padding: 10px !important;">' . $field_meta['field_description'] . '</textarea>';
                    break;
                default :
                    if($field != 'request_email' && $field != 'request_title')
                    {
                        $required_end = "";
                        if ($field_meta['field_require'] == "yes") {
                            $required_end = "checked";
                        }
                        $required_agent = "";
                        if (isset($field_meta['field_require_agent']) && $field_meta['field_require_agent'] == "yes") {
                            $required_agent = "checked";
                        }
                        $visible = "";
                        if (isset($field_meta['field_visible']) && $field_meta['field_visible'] == "yes") {
                            $visible = "checked";
                        }
                        $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_visible" class="form-control" name="ticket_field_edit_visible" ' . $visible . ' value="yes"> '.__('Visible for End Users', 'wsdesk').'</span>';
                        $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_require" class="form-control" name="ticket_field_edit_require" ' . $required_end . ' value="yes"> '.__('Mandatory for End users', 'wsdesk').'</span>';
                        $output .= '<span class="help-block"><input type="checkbox" style="margin-top: 0;"  id="ticket_field_edit_agent_require" class="form-control" name="ticket_field_edit_agent_require" ' . $required_agent . ' value="yes"> '.__('Mandatory for Agents', 'wsdesk').'</span>';
                    }
                    $output .= '<br>'.__('Enter Placeholder', 'wsdesk').'<input type="text" id="ticket_field_edit_placeholder" class="form-control crm-form-element-input" value="' . $field_meta['field_placeholder'] . '">';
                    $output .= '<br>'.__('Enter Default Values', 'wsdesk').'<input type="text" id="ticket_field_edit_default" class="form-control crm-form-element-input" value="' . $field_meta['field_default'] . '">';
                    $output .= '<br><span class="help-block">'.__('Want to update description to this field?', 'wsdesk').' </span><textarea id="ticket_field_edit_description" class="form-control crm-form-element-input" style="padding: 10px !important;">' . $field_meta['field_description'] . '</textarea>';
                    break;
            }
            die($output);
        }

        static function eh_crm_ticket_label_delete() {
            $label_remove = sanitize_text_field($_POST['label_remove']);
            $args = array("type" => "label");
            $fields = array("settings_id", "slug");
            $avail_labels = eh_crm_get_settings($args, $fields);
            for ($i = 0; $i < count($avail_labels); $i++) {
                if ($avail_labels[$i]["slug"] == $label_remove) {
                    eh_crm_delete_settings($avail_labels[$i]["settings_id"]);
                }
            }
            die(json_encode(array('labels'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_labels.php"),'views'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_views.php"),'triggers'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_wsdesk_triggers.php"))));
        }
        
        static function eh_crm_ticket_label() {
            $new_label = json_decode(stripslashes(sanitize_text_field($_POST['new_label'])), true);
            $edit_label = json_decode(stripslashes(sanitize_text_field($_POST['edit_label'])), true);
            if (!empty($new_label)) {
                $insert = array(
                    'title' => $new_label['title'],
                    'filter' => $new_label['filter'],
                    'type' => 'label',
                    'vendor' => ''
                );
                $meta = array
                    (
                    "label_color" => $new_label['color']
                );
                eh_crm_insert_settings($insert, $meta);
            }
            if (!empty($edit_label)) {
                $edit_slug = $edit_label['slug'];
                $edit_title = $edit_label['title'];
                $edit_filter = $edit_label['filter'];
                $edit_color = $edit_label['color'];
                $label_data = eh_crm_get_settings(array("slug" => $edit_slug, "type" => "label"), "settings_id");
                $label_id = $label_data[0]['settings_id'];
                eh_crm_update_settings($label_id, array("title" => $edit_title, "filter" => $edit_filter));
                eh_crm_update_settingsmeta($label_id, "label_color", $edit_color);
            }
            die(json_encode(array('labels'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_labels.php"),'views'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_views.php"),'triggers'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_wsdesk_triggers.php"))));
        }

        static function eh_crm_ticket_label_edit() {
            $label = sanitize_text_field($_POST['label']);
            $args = array("slug" => $label, "type" => "label");
            $fields = array("settings_id", "title", "filter");
            $label_sett = eh_crm_get_settings($args, $fields);
            $label_meta = eh_crm_get_settingsmeta($label_sett[0]['settings_id']);
            $yes = "";
            $no = "";
            if ($label_sett[0]['filter'] == "yes") {
                $yes = "checked";
                $no = "";
            } else {
                $yes = "";
                $no = "checked";
            }
            $output = '     
                        <span class="help-block">'.__('Update details for', 'wsdesk').' ' . $label_sett[0]['title'] . ' '.__('Status', 'wsdesk').' </span>
                        <input type="text" id="ticket_label_edit_title" placeholder="'.__('Enter Title', 'wsdesk').'" class="form-control crm-form-element-input" value="' . $label_sett[0]['title'] . '">
                        <span class="help-block">'.__('Change ticket status color', 'wsdesk').'</span>
                        <span style="vertical-align: middle;">
                            <input type="color" id="ticket_label_edit_color" value = "' . $label_meta['label_color'] . '"/><span> '.__('Click and pick the color', 'wsdesk').'</span>
                        </span>
                        <span class="help-block">'.__('Do you want to use this status to filter tickets?', 'wsdesk').' </span>
                        <input type="radio" style="margin-top: 0;" checked id="ticket_label_edit_filter" class="form-control" name="ticket_label_edit_filter" ' . $yes . ' value="yes"> '.__('Yes! I will use it to Filter', 'wsdesk').'<br>
                        <input type="radio" style="margin-top: 0;" id="ticket_label_edit_filter" class="form-control" name="ticket_label_edit_filter" ' . $no . ' value="no"> '.__('No! Just for Information', 'wsdesk');
            die($output);
        }

        static function eh_crm_ticket_tag_delete() {
            $tag_remove = sanitize_text_field($_POST['tag_remove']);
            $args = array("type" => "tag");
            $fields = array("settings_id", "slug");
            $avail_tags = eh_crm_get_settings($args, $fields);
            for ($i = 0; $i < count($avail_tags); $i++) {
                if ($avail_tags[$i]["slug"] == $tag_remove) {
                    eh_crm_delete_settings($avail_tags[$i]["settings_id"]);
                }
            }
            die(json_encode(array('tags'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_tags.php"),'views'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_views.php"),'triggers'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_wsdesk_triggers.php"))));
        }
        
        static function eh_crm_ticket_tag() {
            $new_tag = json_decode(stripslashes(sanitize_text_field($_POST['new_tag'])), true);
            $edit_tag = json_decode(stripslashes(sanitize_text_field($_POST['edit_tag'])), true);
            if (!empty($new_tag)) {
                $insert = array(
                    'title' => $new_tag['title'],
                    'filter' => $new_tag['filter'],
                    'type' => 'tag',
                    'vendor' => ''
                );
                $meta = array("tag_posts" => $new_tag['posts']);
                eh_crm_insert_settings($insert, $meta);
            }
            if (!empty($edit_tag)) {
                $edit_slug = $edit_tag['slug'];
                $edit_title = $edit_tag['title'];
                $edit_filter = $edit_tag['filter'];
                $edit_posts = $edit_tag['posts'];
                $tag_data = eh_crm_get_settings(array("slug" => $edit_slug, "type" => "tag"), "settings_id");
                $tag_id = $tag_data[0]['settings_id'];
                eh_crm_update_settings($tag_id, array("title" => $edit_title, "filter" => $edit_filter));
                eh_crm_update_settingsmeta($tag_id, "tag_posts", $edit_posts);
            }
            die(json_encode(array('tags'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_tags.php"),'views'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_views.php"),'triggers'=>include(EH_CRM_MAIN_VIEWS . "settings/crm_wsdesk_triggers.php"))));
        }

        static function eh_crm_ticket_tag_edit() {
            $tag = sanitize_text_field($_POST['tag']);
            $args = array("slug" => $tag, "type" => "tag");
            $fields = array("settings_id", "title", "filter");
            $tag_sett = eh_crm_get_settings($args, $fields);
            $tag_meta = eh_crm_get_settingsmeta($tag_sett[0]['settings_id']);
            $yes = "";
            $no = "";
            if ($tag_sett[0]['filter'] == "yes") {
                $yes = "checked";
                $no = "";
            } else {
                $yes = "";
                $no = "checked";
            }
            $response = array();
            if(!empty($tag_meta['tag_posts']))
            {
                $args_post = array(
                    'orderby' => 'ID',
                    'numberposts' => -1,
                    'post_type' => array('post', 'product'),
                    'post__in' => $tag_meta['tag_posts']
                );
                $posts = get_posts($args_post);
                for ($i = 0; $i < count($posts); $i++) {
                    $response[$i]['id'] = $posts[$i]->ID;
                    $response[$i]['title'] = $posts[$i]->post_title;
                }
            }
            $output = '   
                        <span class="help-block">'.__('Update Details for', 'wsdesk').' ' . $tag_sett[0]['title'] . ' '.__('Tag?', 'wsdesk').' </span>
                        <input type="text" id="ticket_tag_edit_title" placeholder="'.__('Enter Title', 'wsdesk').'" class="form-control crm-form-element-input" value="' . $tag_sett[0]['title'] . '">
                        <span class="help-block">'.__('Update the Post which should be Tagged if required?', 'wsdesk').' </span>
                        <select class="ticket_tag_edit_posts form-control crm-form-element-input" multiple="multiple">
                        ';
            if (!empty($response)) {
                for ($i = 0; $i < count($response); $i++) {
                    $output .= '<option value="' . $response[$i]['id'] . '" selected title="' . $response[$i]['title'] . '"></option>';
                }
            }
            $output .= '</select>
                        <span class="help-block">'.__('Want to use this Tag for Filter Tickets?', 'wsdesk').' </span>
                        <input type="radio" style="margin-top: 0;"  id="ticket_tag_edit_filter" class="form-control" name="ticket_tag_edit_filter" ' . $yes . ' value="yes"> '.__('Yes! I will use it for Filter', 'wsdesk').'<br>
                        <input type="radio" style="margin-top: 0;" id="ticket_tag_edit_filter" class="form-control" name="ticket_tag_edit_filter" ' . $no . ' value="no"> '.__('No! Just for Information', 'wsdesk');
            die($output);
        }

        static function eh_crm_ticket_view() {
            $selected_views = explode(",", sanitize_text_field($_POST['selected_views']));
            $new_view = json_decode(stripslashes(sanitize_text_field($_POST['new_view'])), true);
            $edit_view = json_decode(stripslashes(sanitize_text_field($_POST['edit_view'])), true);
            $temp = eh_crm_get_settings(array("type" => "view"), array("settings_id", "slug"));
            $slug = array();
            for ($i = 0; $i < count($temp); $i++) {
                $slug[$i] = $temp[$i]['slug'];
            }
            for ($i = 0; $i < count($selected_views); $i++) {
                if (!in_array($selected_views[$i], $slug)) {
                    unset($selected_views[$i]);
                }
            }
            eh_crm_update_settingsmeta("0", "selected_views", array_values($selected_views));
            if (!empty($new_view)) {
                $insert = array(
                    'title' => $new_view['title'],
                    'filter' => "yes",
                    'type' => 'view',
                    'vendor' => ''
                );
                $meta = array
                (
                    "view_format" => $new_view['format'],
                    "view_group" => $new_view['group'],
                    "view_conditions" => $new_view['conditions'],
                    "view_access" => explode(",",$new_view['access'])
                );
                eh_crm_insert_settings($insert, $meta);
            }
            if (!empty($edit_view)) {
                $edit_slug = $edit_view["slug"];
                $edit_title = $edit_view["title"];
                $edit_format = $edit_view["format"];
                $edit_group = $edit_view["group"];
                $edit_conditions = $edit_view["conditions"];
                $edit_access = explode(",",$edit_view['access']);
                $view_data = eh_crm_get_settings(array("slug" => $edit_slug, "type" => "view"), "settings_id");
                if (!empty($view_data)) {
                    $view_id = $view_data[0]['settings_id'];
                    eh_crm_update_settings($view_id, array("title" => $edit_title ));
                    eh_crm_update_settingsmeta($view_id, "view_format", $edit_format);
                    eh_crm_update_settingsmeta($view_id, "view_group", $edit_group);
                    eh_crm_update_settingsmeta($view_id, "view_conditions", $edit_conditions);
                    eh_crm_update_settingsmeta($view_id, "view_access", $edit_access);
                }
            }
            die(include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_views.php"));
        }
        
        static function eh_crm_ticket_view_activate_deactivate() {
            $view_id = sanitize_text_field($_POST['view_id']);
            $type = sanitize_text_field($_POST['type']);
            $selected_views = eh_crm_get_settingsmeta("0", "selected_views");
            if(!$selected_views)
            {
                $selected_views = array();
            }
            switch ($type) {
                case "activate":
                    if (!in_array($view_id,$selected_views)) {
                        array_push($selected_views,$view_id);
                    }
                    eh_crm_update_settingsmeta("0", "selected_views", array_values($selected_views));
                    break;
                case "deactivate":
                    if(($key = array_search($view_id, $selected_views)) !== false) {
                        unset($selected_views[$key]);
                    }
                    eh_crm_update_settingsmeta("0", "selected_views", array_values($selected_views));
                    break;
                default:
                    break;
            }
            die(include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_views.php"));
        }
        
        static function eh_crm_ticket_view_delete() {
            $view_remove = sanitize_text_field($_POST['view_remove']);
            $args = array("type" => "view");
            $fields = array("settings_id", "slug");
            $selected_views = eh_crm_get_settingsmeta("0", "selected_views");
            $avail_views = eh_crm_get_settings($args, $fields);
            if(($key = array_search($view_remove, $selected_views)) !== false) {
                unset($selected_views[$key]);
            }
            eh_crm_update_settingsmeta("0", "selected_views", array_values($selected_views));
            for ($i = 0; $i < count($avail_views); $i++) {
                if ($avail_views[$i]["slug"] == $view_remove) {
                    eh_crm_delete_settings($avail_views[$i]["settings_id"]);
                }
            }
            die(include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_views.php"));
        }
        
        static function eh_crm_ticket_view_edit() {
            $view = sanitize_text_field($_POST['view']);
            $view_sett = eh_crm_get_settings(array("slug" => $view, "type" => "view"), array("settings_id", "title"));
            $view_meta = eh_crm_get_settingsmeta($view_sett[0]['settings_id']);
            $and = "";
            $or = "";
            if ($view_meta['view_format'] == "and") {
                $and = "selected";
                $or = "";
            } else {
                $and = "";
                $or = "selected";
            }
            $script = eh_crm_get_view_data();
            $options = $script['options'];
            $view_group=$view_meta['view_group'];
            $group_by = $script['group'];
            $group_altered = str_replace('value="'.$view_group.'"', 'value="'.$view_group.'" selected', $group_by);
            $conditions = $view_meta['view_conditions'];
            $access = $view_meta['view_access'];
            $output = '
                    <span class="help-block">'.__('Update title for the view:', 'wsdesk').' '.$view_sett[0]['title'].'</span>
                    <input type="text" id="ticket_view_edit_title" placeholder="'.__('Enter Title', 'wsdesk').'" value="'.$view_sett[0]['title'].'" class="form-control crm-form-element-input">
                    <span class="help-block">'.__('Modify the Conditions Format.', 'wsdesk').'</span>
                    <select id="ticket_view_edit_format" style="width: 100% !important;display: inline !important" class="form-control ticket_view_edit_format clickable" aria-describedby="helpBlock">
                        <option value="and" '.$and.'>AND '.__('Condition', 'wsdesk').'</option>
                        <option value="or" '.$or.'>OR '.__('Condition', 'wsdesk').'</option>
                    </select>
                    <span class="help-block">'.__('Modify the View Conditions.', 'wsdesk').'</span>
                    <div id="edit_conditions_all">';
                    $co=1;
                    foreach ($conditions as $cond_key => $cond_value) {
                        $class ='';
                        $color='';
                        switch ($cond_key) {
                            case "and":
                                $class="and_grouped grouped";
                                $color='style="background-color:skyblue;"';
                                break;
                            case "or":
                                $class="or_grouped grouped";
                                $color='style="background-color:darkseagreen;"';
                                break;
                            default:
                                break;
                        }
                        foreach($cond_value as $grp_single)
                        {
                            $cond_type = $grp_single['type'];
                            $options_altered = str_replace('value="'.$cond_type.'"', 'value="'.$cond_type.'" selected', $options);
                            $cond_oper = $grp_single['operator'];
                            $cond_val  = $grp_single['value'];
                            $cond_data = $script[$cond_type];
                            $output.='
                            <div id="edit_conditions_'.$co.'" class="edit_specify_conditions '.$class.'" '.$color.'>
                                <span class="edit_condition_title_span">'.__('Condition', 'wsdesk').' '.$co.'</span>';
                                if($co !== 1)
                                {
                                    $output.='
                                        <select id="edit_conditions_'.$co.'_type" title="'.__('View condition field', 'wsdesk').'" style="width: 90% !important;display: inline !important" class="form-control edit_conditions_type clickable" aria-describedby="helpBlock">
                                            '.$options_altered.'
                                        </select>
                                        <button class="btn btn-warning" title="'.__('Remove Condition', 'wsdesk').'" id="ticket_view_edit_conditions_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button>';
                                }
                                else
                                {
                                    $output.='
                                        <select id="edit_conditions_'.$co.'_type" title="'.__('View condition field', 'wsdesk').'" style="width: 100% !important;display: inline !important" class="form-control edit_conditions_type clickable" aria-describedby="helpBlock">
                                            '.$options_altered.'
                                        </select>';
                                }
                                $output.='
                                <div id="edit_conditions_'.$co.'_append">';
                                $output.= '<select id="edit_conditions_'.$co.'_operator" style="width: 100% !important; margin:10px 0px; display: inline !important" class="form-control edit_conditions_'.$co.'_operator clickable" aria-describedby="helpBlock">';
                                foreach ($cond_data['operator'] as $op_key => $op_value) {
                                    $output.='<option value="'.$op_key.'" '.(($op_key == $cond_oper)?"selected":"").'>'.$op_value.'</option>';
                                }
                                $output.= '</select>';
                                switch($cond_data['type'])
                                {
                                    case "text":
                                        $output.= '<input type="text" id="edit_conditions_'.$co.'_value" placeholder="'.__('Enter Value', 'wsdesk').'" class="form-control crm-form-element-input" value="'.$cond_val.'">';
                                        break;
                                    case "select":
                                        $output.= '<select id="edit_conditions_'.$co.'_value" style="width: 100% !important; margin-bottom:10px; display: inline !important" class="form-control edit_conditions_'.$co.'_value clickable" aria-describedby="helpBlock">';
                                        foreach ($cond_data['values'] as $val_key => $val_value) {
                                            $output.='<option value="'.$val_key.'" '.(($val_key == $cond_val)?"selected":"").'>'.$val_value.'</option>';
                                        }
                                        $output.= '</select>';
                                        break;
                                    case "multiselect":
                                        $output.= '<select multiple id="edit_conditions_'.$co.'_value" style="width: 100% !important; margin-bottom:10px; display: inline !important" class="form-control trigger_select2 edit_conditions_'.$co.'_value" aria-describedby="helpBlock">';
                                        foreach ($cond_data['values'] as $val_key => $val_value)
                                        {
                                            foreach ($cond_val as $si_value) {
                                                $output.='<option value="'.$val_key.'" '.(($val_key == $si_value)?"selected":"").'>'.$val_value.'</option>';
                                            }
                                        }
                                        $output.= '</select>';
                                        break;
                                }
                            $output.='
                                </div>
                            </div>';
                            $co++;
                        }
                    }
                    unset($script['options']);
                    unset($script['group']);
                    $output.='
                    </div>
                    <button class="button" id="ticket_view_edit_conditions_add" title="'.__('Add New Condition', 'wsdesk').'" style="vertical-align: baseline;margin-bottom: 10px;margin-top: 10px;"><span class="glyphicon glyphicon-plus"></span> '.__('Add Condition', 'wsdesk').'</button>
                    <button class="button" id="ticket_view_edit_conditions_group_and" title="'.__('Group those with AND Condition', 'wsdesk').'" style="background-color:skyblue; vertical-align: baseline;margin-bottom: 10px;margin-top: 10px;"><span class="glyphicon glyphicon-link"></span> '.__('Group with AND', 'wsdesk').'</button>
                    <button class="button" id="ticket_view_edit_conditions_group_or" title="'.__('Group those with OR Condition', 'wsdesk').'" style="background-color:darkseagreen;vertical-align: baseline;margin-bottom: 10px;margin-top: 10px;"><span class="glyphicon glyphicon-resize-horizontal"></span> '.__('Group with OR', 'wsdesk').'</button>
                    <button class="button" id="ticket_view_edit_conditions_group_clear" title="'.__('Clear Groups', 'wsdesk').'" style="background-color:orange;vertical-align: baseline;margin-bottom: 10px;margin-top: 10px;"><span class="glyphicon glyphicon-remove"></span> '.__('Clear Groups', 'wsdesk').'</button>
                    <span class="help-block">'.__('Group the tickets by', 'wsdesk').'</span>
                    <select id="group_by_view_edit" title="'.__('View Group By', 'wsdesk').'" style="width: 100% !important;margin-bottom: 10px;display: inline !important" class="form-control group_by_view_edit clickable" aria-describedby="helpBlock">
                        '.$group_altered.'
                    </select>
                    <span class="help-block">'.__('Display this view to', 'wsdesk').' </span>
                    <input type="checkbox" style="margin-top: 0;"  id="ticket_view_display_control_edit" class="form-control" name="ticket_view_display_control_edit" value="administrator" '.((in_array('administrator', $access))?"checked":"").'> Administrator
                    <input type="checkbox" style="margin-top: 0;" id="ticket_view_display_control_edit" class="form-control" name="ticket_view_display_control_edit" value="WSDesk_Agents" '.((in_array('WSDesk_Agents', $access))?"checked":"").'> WSDesk Agents
                    <input type="checkbox" style="margin-top: 0;" id="ticket_view_display_control_edit" class="form-control" name="ticket_view_display_control_edit" value="WSDesk_Supervisor" '.((in_array('WSDesk_Supervisor', $access))?"checked":"").'> WSDesk Supervisors
                    <script type="text/javascript">
                        var edit_values = '.json_encode($script).'
                        jQuery("#ticket_views_tab").on("change",".edit_conditions_type",function(){
                            if(jQuery(this).val() !== "")
                            {
                                views_condition_maker(edit_values[jQuery(this).val()],jQuery(this).parent().prop("id"));
                            }
                            else
                            {
                                var parent_id = jQuery(this).parent().prop("id");
                                jQuery("#"+parent_id+"_append").empty();
                            }
                        });
                    </script>
                    ';
            die($output);
        }
        
        static function eh_crm_ticket_trigger_activate_deactivate() {
            $trigger_id = sanitize_text_field($_POST['trigger_id']);
            $type = sanitize_text_field($_POST['type']);
            $selected_triggers = eh_crm_get_settingsmeta("0", "selected_triggers");
            if(empty($selected_triggers))
            {
                $selected_triggers = array();
            }
            switch ($type) {
                case "activate":
                    if (!in_array($trigger_id,$selected_triggers)) {
                        array_push($selected_triggers,$trigger_id);
                    }
                    eh_crm_update_settingsmeta("0", "selected_triggers", array_values($selected_triggers));
                    break;
                case "deactivate":
                    if(($key = array_search($trigger_id, $selected_triggers)) !== false) {
                        unset($selected_triggers[$key]);
                    }
                    eh_crm_update_settingsmeta("0", "selected_triggers", array_values($selected_triggers));
                    break;
                default:
                    break;
            }
            die(include(EH_CRM_MAIN_VIEWS . "settings/crm_wsdesk_triggers.php"));
        }
        
        static function eh_crm_trigger() {
            $new_trigger = json_decode(stripslashes($_POST['new_trigger']), true);
            $edit_trigger = json_decode(stripslashes($_POST['edit_trigger']), true);
            if (!empty($new_trigger)) {
                $insert = array(
                    'title' => $new_trigger['title'],
                    'filter' => "yes",
                    'type' => 'trigger',
                    'vendor' => ''
                );
                $meta = array
                (
                    "trigger_format" => $new_trigger['format'],
                    "trigger_conditions" => $new_trigger['conditions'],
                    "trigger_actions" => $new_trigger['actions']
                );
                if(isset($new_trigger['schedule']) && $new_trigger['schedule'] !== "")
                {
                    $meta['trigger_schedule'] = $new_trigger['schedule'];
                    if(isset($new_trigger['period']))
                    {
                        $meta['trigger_period'] = $new_trigger['period'];
                    }
                    else
                    {
                        $meta['trigger_period'] = 1;
                    }
                }
                else
                {
                    $meta['trigger_schedule'] = $new_trigger['schedule'];
                }
                eh_crm_insert_settings($insert, $meta);
            }
            if (!empty($edit_trigger)) {
                $edit_slug = $edit_trigger["slug"];
                $edit_title = $edit_trigger["title"];
                $edit_format = $edit_trigger["format"];
                $edit_conditions = $edit_trigger["conditions"];
                $edit_actions = $edit_trigger["actions"];
                $trigger_data = eh_crm_get_settings(array("slug" => $edit_slug, "type" => "trigger"), "settings_id");
                if (!empty($trigger_data)) {
                    $trigger_id = $trigger_data[0]['settings_id'];
                    eh_crm_update_settings($trigger_id, array("title" => $edit_title ));
                    eh_crm_update_settingsmeta($trigger_id, "trigger_format", $edit_format);
                    eh_crm_update_settingsmeta($trigger_id, "trigger_conditions", $edit_conditions);
                    eh_crm_update_settingsmeta($trigger_id, "trigger_actions", $edit_actions);
                    if(isset($edit_trigger['schedule']) && $edit_trigger['schedule'] !=="" )
                    {
                        eh_crm_update_settingsmeta($trigger_id, "trigger_schedule", $edit_trigger['schedule']);
                        if(isset($edit_trigger['period']))
                        {
                            eh_crm_update_settingsmeta($trigger_id, "trigger_period", $edit_trigger['period']);
                        }
                        else
                        {
                            eh_crm_update_settingsmeta($trigger_id, "trigger_period", 1);
                        }
                    }
                    else
                    {
                        eh_crm_update_settingsmeta($trigger_id, "trigger_schedule", $edit_trigger['schedule']);
                        eh_crm_update_settingsmeta($trigger_id, "trigger_period", "");
                    }
                }
            }
            die(include(EH_CRM_MAIN_VIEWS . "settings/crm_wsdesk_triggers.php"));
        }
        
        static function eh_crm_ticket_trigger_delete() {
            $trigger_remove = sanitize_text_field($_POST['trigger_remove']);
            $args = array("type" => "trigger");
            $fields = array("settings_id", "slug");
            $selected_triggers = eh_crm_get_settingsmeta("0", "selected_triggers");
            if(!$selected_triggers)
            {
                $selected_triggers = array();
            }
            $avail_triggers = eh_crm_get_settings($args, $fields);
            if(($key = array_search($trigger_remove, $selected_triggers)) !== false) {
                unset($selected_triggers[$key]);
            }
            eh_crm_update_settingsmeta("0", "selected_triggers", array_values($selected_triggers));
            for ($i = 0; $i < count($avail_triggers); $i++) {
                if ($avail_triggers[$i]["slug"] == $trigger_remove) {
                    eh_crm_delete_settings($avail_triggers[$i]["settings_id"]);
                }
            }
            die(include(EH_CRM_MAIN_VIEWS . "settings/crm_wsdesk_triggers.php"));
        }
        
        static function eh_crm_trigger_edit() {
            $trigger = sanitize_text_field($_POST['trigger']);
            $trigger_sett = eh_crm_get_settings(array("slug" => $trigger, "type" => "trigger"), array("settings_id", "title"));
            $trigger_meta = eh_crm_get_settingsmeta($trigger_sett[0]['settings_id']);
            $and = "";
            $or = "";
            if ($trigger_meta['trigger_format'] == "and") {
                $and = "selected";
                $or = "";
            } else {
                $and = "";
                $or = "selected";
            }
            $script = eh_crm_get_trigger_data();
            $tascript = eh_crm_get_trigger_action_data();
            $options = $script['options'];
            $taoptions  = $tascript['options'];
            $conditions = $trigger_meta['trigger_conditions'];
            $actions = $trigger_meta['trigger_actions'];
            $schedule = "";
            if(isset($trigger_meta['trigger_schedule']))
            {
                $schedule = $trigger_meta['trigger_schedule'];
            }
            $output = '
                    <span class="help-block">'.__('Update Details for', 'wsdesk').' '.$trigger_sett[0]['title'].' '.__('trigger?', 'wsdesk').' </span>
                    <input type="text" id="trigger_edit_title" placeholder="'.__('Enter Title', 'wsdesk').'" value="'.$trigger_sett[0]['title'].'" class="form-control crm-form-element-input">
                    <span class="crm-divider"></span>
                    <span><b>'.__('Match Triggers Conditions', 'wsdesk').'</b></span>
                    <span class="crm-divider"></span>
                    <span class="help-block">'.__('Modify the Conditions Format.', 'wsdesk').'</span>
                    <select id="trigger_edit_format" style="width: 100% !important;display: inline !important" class="form-control trigger_edit_format clickable" aria-describedby="helpBlock">
                        <option value="and" '.$and.'>AND '.__('Condition', 'wsdesk').'</option>
                        <option value="or" '.$or.'>OR '.__('Condition', 'wsdesk').'</option>
                    </select>
                    <span class="help-block">'.__('Modify the trigger Conditions.', 'wsdesk').'</span>
                    <div id="edit_tconditions_all">';
                    $co=1;
                    foreach ($conditions as $cond_key => $cond_value) {
                        $class ='';
                        $color='';
                        switch ($cond_key) {
                            case "and":
                                $class="and_tgrouped tgrouped";
                                $color='style="background-color:skyblue;"';
                                break;
                            case "or":
                                $class="or_tgrouped tgrouped";
                                $color='style="background-color:darkseagreen;"';
                                break;
                            default:
                                break;
                        }
                        foreach($cond_value as $grp_single)
                        {
                            $cond_type = $grp_single['type'];
                            $options_altered = str_replace('value="'.$cond_type.'"', 'value="'.$cond_type.'" selected', $options);
                            $cond_oper = $grp_single['operator'];
                            $cond_val  = $grp_single['value'];
                            $cond_data = $script[$cond_type];
                            $output.='
                            <div id="edit_tconditions_'.$co.'" class="edit_specify_tconditions '.$class.'" '.$color.'>
                                <span class="edit_tcondition_title_span">'.__('Condition', 'wsdesk').' '.$co.'</span>';
                                if($co !== 1)
                                {
                                    $output.='
                                        <select id="edit_tconditions_'.$co.'_type" title="'.__('Condition', 'wsdesk').'" style="width: 90% !important;display: inline !important" class="form-control edit_tconditions_type clickable" aria-describedby="helpBlock">
                                            '.$options_altered.'
                                        </select>
                                        <button class="btn btn-warning" title="'.__('Remove Condition', 'wsdesk').'" id="trigger_edit_tconditions_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button>';
                                }
                                else
                                {
                                    $output.='
                                        <select id="edit_tconditions_'.$co.'_type" title="'.__('Trigger condition field', 'wsdesk').'" style="width: 100% !important;display: inline !important" class="form-control edit_tconditions_type clickable" aria-describedby="helpBlock">
                                            '.$options_altered.'
                                        </select>';
                                }
                                $output.='
                                <div id="edit_tconditions_'.$co.'_append">';
                                $output.= '<select id="edit_tconditions_'.$co.'_operator" style="width: 100% !important; margin:10px 0px; display: inline !important" class="form-control edit_tconditions_'.$co.'_operator clickable" aria-describedby="helpBlock">';
                                foreach ($cond_data['operator'] as $op_key => $op_value) {
                                    $output.='<option value="'.$op_key.'" '.(($op_key == $cond_oper)?"selected":"").'>'.$op_value.'</option>';
                                }
                                $output.= '</select>';
                                switch($cond_data['type'])
                                {
                                    case "text":
                                        $output.= '<input type="text" id="edit_tconditions_'.$co.'_value" placeholder="'.__('Enter Value', 'wsdesk').'" class="form-control crm-form-element-input" value="'.$cond_val.'">';
                                        break;
                                    case "select":
                                        $output.= '<select id="edit_tconditions_'.$co.'_value" style="width: 100% !important; margin-bottom:10px; display: inline !important" class="form-control edit_tconditions_'.$co.'_value clickable" aria-describedby="helpBlock">';
                                        foreach ($cond_data['values'] as $val_key => $val_value) {
                                            $output.='<option value="'.$val_key.'" '.(($val_key == $cond_val)?"selected":"").'>'.$val_value.'</option>';
                                        }
                                        $output.= '</select>';
                                        break;
                                    case "multiselect":
                                        $output.= '<select multiple id="edit_tconditions_'.$co.'_value" style="width: 100% !important; margin-bottom:10px; display: inline !important" class="form-control trigger_tselect2_edit edit_tconditions_'.$co.'_value" aria-describedby="helpBlock">';
                                        foreach ($cond_data['values'] as $val_key => $val_value)
                                        {
                                            $output.='<option value="'.$val_key.'" '.((in_array($val_key,$cond_val))?"selected":"").'>'.$val_value.'</option>';
                                        }
                                        $output.= '</select>';
                                        break;
                                }
                            $output.='
                                </div>
                            </div>';
                            $co++;
                        }
                    }
                    unset($script['options']);
                    $output.='
                    </div>
                    <button class="button" id="trigger_edit_tconditions_add" title="'.__('Add New Condition', 'wsdesk').'" style="vertical-align: baseline;margin-bottom: 10px;margin-top: 10px;"><span class="glyphicon glyphicon-plus"></span> '.__('Add Condition', 'wsdesk').'</button>
                    <button class="button" id="trigger_edit_tconditions_group_and" title="'.__('Group those with AND Condition', 'wsdesk').'" style="background-color:skyblue; vertical-align: baseline;margin-bottom: 10px;margin-top: 10px;"><span class="glyphicon glyphicon-link"></span> '.__('Group with AND', 'wsdesk').'</button>
                    <button class="button" id="trigger_edit_tconditions_group_or" title="'.__('Group those with OR Condition', 'wsdesk').'" style="background-color:darkseagreen;vertical-align: baseline;margin-bottom: 10px;margin-top: 10px;"><span class="glyphicon glyphicon-resize-horizontal"></span> '.__('Group with OR', 'wsdesk').'</button>
                    <button class="button" id="trigger_edit_tconditions_group_clear" title="'.__('Clear Groups', 'wsdesk').'" style="background-color:orange;vertical-align: baseline;margin-bottom: 10px;margin-top: 10px;"><span class="glyphicon glyphicon-remove"></span> '.__('Clear Groups', 'wsdesk').'</button>
                    <span class="crm-divider"></span>
                    <span><b>'.__('Perform Triggers Actions', 'wsdesk').'</b></span>
                    <span class="crm-divider"></span>
                    <span class="help-block">'.__('Specify the Trigger Actions.', 'wsdesk').'</span>
                    <div id="edit_tactions_all">';
                    $co=1;
                    foreach ($actions as $act_single) {
                        $act_type = $act_single['type'];
                        $options_altered = str_replace('value="'.$act_type.'"', 'value="'.$act_type.'" selected', $taoptions);
                        $act_val  = $act_single['value'];
                        $act_data = $tascript[$act_type];
                        $output.='
                        <div id="edit_tactions_'.$co.'" class="edit_specify_tactions">
                            <span class="edit_taction_title_span">'.__('Action', 'wsdesk').' '.$co.'</span>';
                            if($co !== 1)
                            {
                                $output.='
                                    <select id="edit_tactions_'.$co.'_type" title="'.__('Trigger Action field', 'wsdesk').'" style="width: 90% !important;display: inline !important;margin-bottom:10px; " class="form-control edit_tactions_type clickable" aria-describedby="helpBlock">
                                        '.$options_altered.'
                                    </select>
                                    <button class="btn btn-warning" title="'.__('Remove Condition', 'wsdesk').'" id="trigger_edit_tconditions_remove" style="padding: 5px 8px;margin:0px 4px; vertical-align: baseline;"><span class="glyphicon glyphicon-minus"></span></button>';
                            }
                            else
                            {
                                $output.='
                                    <select id="edit_tactions_'.$co.'_type" title="'.__('Trigger Action field', 'wsdesk').'" style="width: 100% !important;display: inline !important;margin-bottom:10px; " class="form-control edit_tactions_type clickable" aria-describedby="helpBlock">
                                        '.$options_altered.'
                                    </select>';
                            }
                            $output.='
                            <div id="edit_tactions_'.$co.'_append">';
                            switch($act_data['type'])
                            {
                                case "sms":
                                     $output.= '<select multiple id="edit_tactions_'.$co.'_value" style="width: 100% !important;display: inline !important;margin-bottom:10px;" class="form-control trigger_tselect2_edit edit_tactions_'.$co.'_value clickable" aria-describedby="helpBlock">';
                                    foreach ($act_data['values'] as $val_key => $val_value) {
                                        $output.='<option value="'.$val_key.'" '.((in_array($val_key, $act_val))?"selected":"").'>'.$val_value.'</option>';
                                    }
                                    $body_not = $act_single['body'];
                                    $output.= '</select>
                                        <span class="help-block">'.__('Specify the SMS Body.', 'wsdesk').'</span>
                                        <textarea id="edit_tactions_'.$co.'_body" class="form-control trigger_textarea_edit crm-form-element-input crm-input-textarea-body" placeholder="'.__('Enter mail body', 'wsdesk').'">'.str_replace("<br>", "&#13;&#10;", $body_not).'</textarea>';
                                    break;
                                case "notification":
                                    
                                    $output.= '<select multiple id="edit_tactions_'.$co.'_value" style="width: 100% !important;display: inline !important;margin-bottom:10px;" class="form-control trigger_tselect2_edit edit_tactions_'.$co.'_value clickable" aria-describedby="helpBlock">';
                                    foreach ($act_data['values'] as $val_key => $val_value) {
                                        $output.='<option value="'.$val_key.'" '.((in_array($val_key, $act_val))?"selected":"").'>'.$val_value.'</option>';
                                    }
                                    $subject_not = $act_single['subject'];
                                    $body_not = $act_single['body'];
                                    $output.= '</select>
                                        <span class="help-block">'.__('Modify the Mail Subject. Refer the Shortcode in Email Setup Page.', 'wsdesk').'</span>
                                        <div class="input-group"><span class="input-group-addon" id="basic-addon1">'.__('Ticket', 'wsdesk').' [id] : </span>
                                        <input type="text" id="edit_tactions_'.$co.'_subject" placeholder="'.__('Enter mail subject', 'wsdesk').'" class="form-control crm-form-element-input" aria-describedby="helpBlock" value="'.$subject_not.'">
                                            </div>
                                        <span class="help-block">'.__('Specify the Mail Body. Refer the Shortcode in Email Setup Page.', 'wsdesk').'</span>
                                        <textarea id="edit_tactions_'.$co.'_body" class="form-control trigger_textarea_edit crm-form-element-input crm-input-textarea-body" placeholder="'.__('Enter mail body', 'wsdesk').'">'.str_replace("<br>", "&#13;&#10;", $body_not).'</textarea>';
                                    break;
                                case "text":
                                    $output.= '<input type="text" id="edit_tactions_'.$co.'_value" placeholder="'.__('Enter Value', 'wsdesk').'" class="form-control crm-form-element-input" value="'.$act_val.'">';
                                    break;
                                case "select":
                                    $output.= '<select id="edit_tactions_'.$co.'_value" style="width: 100% !important; margin-bottom:10px; display: inline !important" class="form-control edit_tactions_'.$co.'_value clickable" aria-describedby="helpBlock">';
                                    foreach ($act_data['values'] as $val_key => $val_value) {
                                        $output.='<option value="'.$val_key.'" '.(($val_key == $act_val)?"selected":"").'>'.$val_value.'</option>';
                                    }
                                    $output.= '</select>';
                                    break;
                                case "multiselect":
                                    $output.= '<select multiple id="edit_tactions_'.$co.'_value" style="width: 100% !important; margin-bottom:10px; display: inline !important" class="form-control trigger_tselect2_edit edit_tactions_'.$co.'_value" aria-describedby="helpBlock">';
                                    foreach ($act_data['values'] as $val_key => $val_value)
                                    {
                                        foreach ($act_val as $si_value) {
                                            $output.='<option value="'.$val_key.'" '.(($val_key == $si_value)?"selected":"").'>'.$val_value.'</option>';
                                        }
                                    }
                                    $output.= '</select>';
                                    break;
                            }
                        $output.='
                            </div>
                        </div>';
                        $co++;
                    }
                    unset($script['options']);
                    unset($tascript['options']);
                    $output.='
                        </div>
                    </div>
                    <button class="button" id="trigger_edit_tactions_add" title="'.__('Add New Action', 'wsdesk').'" style="vertical-align: baseline;margin-bottom: 10px;margin-top: 10px;"><span class="glyphicon glyphicon-plus"></span> '.__('Add Action', 'wsdesk').'</button>
                    <span class="crm-divider"></span>
                    <span class="help-block">'.__('Modify the Triggering Period.', 'wsdesk').'</span>
                    <select id="trigger_edit_schedule" style="width: 100% !important;display: inline !important" class="form-control trigger_edit_schedule clickable" aria-describedby="helpBlock">
                        <option value="" '.(($schedule == "")?"selected":"").'>'.__('Immediate Schedule', 'wsdesk').'</option>
                        <option value="min" '.(($schedule == "min")?"selected":"").'>'.__('Minute Schedule', 'wsdesk').'</option>
                        <option value="hour" '.(($schedule == "hour")?"selected":"").'>'.__('Hour Schedule', 'wsdesk').'</option>
                        <option value="day" '.(($schedule == "day")?"selected":"").'>'.__('Day Schedule', 'wsdesk').'</option>
                        <option value="week" '.(($schedule == "week")?"selected":"").'>'.__('Week Schedule', 'wsdesk').'</option>
                        <option value="month" '.(($schedule == "month")?"selected":"").'>'.__('Month Schedule', 'wsdesk').'</option>
                        <option value="year" '.(($schedule == "year")?"selected":"").'>'.__('Year Schedule', 'wsdesk').'</option>
                    </select>
                    <span id="trigger_schedule_append_edit">';
                    if($schedule!=="")
                    {
                        $output.='<span class="help-block">'.__('Edit Period for Trigger?', 'wsdesk').' </span><input type="number" id="trigger_edit_period" placeholder="How much '.$schedule.'" class="form-control crm-form-element-input" value="'.$trigger_meta['trigger_period'].'">';
                    }
                    $output .='
                    </span>
                    <script type="text/javascript">
                        var edit_tvalues = '.json_encode($script).'
                        jQuery("#triggers_tab").on("change",".edit_tconditions_type",function(){
                            if(jQuery(this).val() !== "")
                            {
                                triggers_condition_maker(edit_tvalues[jQuery(this).val()],jQuery(this).parent().prop("id"));
                            }
                            else
                            {
                                var parent_id = jQuery(this).parent().prop("id");
                                jQuery("#"+parent_id+"_append").empty();
                            }
                        });
                        var edit_tavalues = '.json_encode($tascript).'
                        jQuery("#triggers_tab").on("change",".edit_tactions_type",function(){
                            if(jQuery(this).val() !== "")
                            {
                                triggers_action_maker(edit_tavalues[jQuery(this).val()],jQuery(this).parent().prop("id"));
                            }
                            else
                            {
                                var parent_id = jQuery(this).parent().prop("id");
                                jQuery("#"+parent_id+"_append").empty();
                            }
                        });
                    </script>
                    ';
            die($output);
        }
        
        static function eh_crm_search_post() {
            global $wpdb;
            $show_excerpt_in_auto_suggestion = eh_crm_get_settingsmeta('0', 'show_excerpt_in_auto_suggestion');
            $table = $wpdb->prefix . 'posts';
            $like = sanitize_text_field($_POST['q']);
            $search_query = "SELECT ID FROM " . $table . " WHERE ( LOWER(post_title) LIKE lower('%$like%') OR  LOWER(post_content)  LIKE lower('%$like%') ) AND post_status ='publish'";
            $terms = get_term_by('slug',$like,'post_tag');
            if($terms!="")
            {
                $term_query="SELECT object_id FROM ".$wpdb->prefix."term_relationships WHERE term_taxonomy_id =".$terms->term_id;
                $tag_result = $wpdb->get_results($term_query, ARRAY_A);//object_id for tag suggestion.
            }
            $quote_ids = array();
            $response = array();
            $results = $wpdb->get_results($search_query, ARRAY_A);//post id for content&titile suggestion.
            $index = count($results);
            $merge = array();
            if($terms!="")
            {
                if(count($tag_result)>0)
                {
                    for($i = 0; $i < count($tag_result); $i++)
                    {
                        $results[$index]['ID'] = $tag_result[$i]['object_id'];
                        $index++;
                    }
                }
            }
            for ($i = 0; $i < count($results); $i++)
            {
                $quote_ids[$i] = $results[$i]['ID'];
            }
            
            $args = array(
                'orderby' => 'ID',
                'numberposts' => -1,
                'post_type' => array('post', 'product', 'epkb_post_type_1', 'avada_faq'), //added for compatibility with knowledge base plugin https://wordpress.org/plugins/echo-knowledge-base/ and avada faq
                'post__in' => $quote_ids
            );
            $posts = array();
            if(!empty($quote_ids))
            {
                $posts = get_posts($args);
            }
            for ($i = 0; $i < count($posts); $i++) 
            {
                $response[$i]['id'] = $posts[$i]->ID;
                $response[$i]['title'] = $posts[$i]->post_title;
                $response[$i]['guid'] = get_permalink($posts[$i]->ID);
                if($show_excerpt_in_auto_suggestion != 'enable')
                {
                    $response[$i]['content'] = (strlen($posts[$i]->post_content) > 100 ? substr($posts[$i]->post_content,0,100)."..." : $posts[$i]->post_content);
                }
                else
                {
                    $response[$i]['content'] = (strlen($posts[$i]->post_excerpt) > 100 ? substr($posts[$i]->post_excerpt,0,100)."..." : $posts[$i]->post_excerpt);
                }
                switch ($posts[$i]->post_type) {
                    case 'post':
                        $response[$i]['type'] = __('Post', 'wsdesk');
                        break;
                    case 'product':
                        $response[$i]['type'] = __('Product', 'wsdesk');
                        break;
                    case 'epkb_post_type_1':
                        $response[$i]['type'] = __('Knowledge Base Post', 'wsdesk');;
                        break;
                    case 'avada_faq':
                        $response[$i]['type'] = __('Avada FAQ', 'wsdesk');
                }
            }
            $res = array("total_count" => count($posts), "items" => $response, "message"=>__('Are you looking for this?', 'wsdesk'));
            die(json_encode($res));
        }

        static function eh_crm_search_tags() {
            global $wpdb;
            $table = $wpdb->prefix . 'wsdesk_settings';
            $search_query = 'SELECT settings_id,slug,title FROM ' . $table . ' WHERE LOWER(title) LIKE %s AND type ="tag"';
            $like = '%' . sanitize_text_field($_POST['q']) . '%';
            $response = array();
            $results = $wpdb->get_results($wpdb->prepare($search_query, $like), ARRAY_A);
            for ($i = 0; $i < count($results); $i++) {
                $response[$i]['id'] = $results[$i]['slug'];
                $response[$i]['title'] = $results[$i]['title'];
                $meta = eh_crm_get_settingsmeta($results[$i]['settings_id'], "tag_posts");
                if($meta)
                {
                $post = get_post($meta[0]);
                $post_title = strlen($post->post_title) > 15 ? substr($post->post_title, 0, 15) : $post->post_title;
                }
                else 
                {
                    $meta = array();
                }
                $res_post = "";
                switch (count($meta)) {
                    case 0:
                        $res_post = __("No Posts Tagged", 'wsdesk');
                        break;
                    case 1:
                        $res_post = $post_title;
                        break;
                    default:
                        $res_post = $post_title . " + " . (count($meta) - 1) . " more item";
                        break;
                }
                $response[$i]['posts'] = $res_post;
            }
            $res = array("total_count" => count($results), "items" => $response);
            die(json_encode($res));
        }
        
        static function eh_crm_agent_add_user()
        {
            $role = sanitize_text_field($_POST['role']);
            switch ($role) {
                case "agents":
                    $role ="WSDesk_Agents";
                    break;
                case "supervisor":
                    $role = "WSDesk_Supervisor";
                    break;
            }
            $rights = explode(",", sanitize_text_field($_POST['rights']));
            $user_pass = sanitize_text_field($_POST['password']);
            $user_email = sanitize_text_field($_POST['email']);
            $email_check = email_exists($user_email);
            $tags = (($_POST['tags'] !== "") ? explode(",", sanitize_text_field($_POST['tags'])) : NULL);
            $message = "";
            $code = '';
            if($email_check)
            {
                $message = "Email already exists";
                $code = "failed";

            }
            else
            {
                $maybe_username = explode('@', $user_email);
                $maybe_username = sanitize_user($maybe_username[0]);
                $counter = 1;
                $username = $maybe_username;

                while (username_exists($username)) {
                    $username = $maybe_username . $counter;
                    $counter++;
                }
                $user_login = $username;
                $userdata = compact('user_login', 'user_email', 'user_pass','role');
                $user = wp_insert_user($userdata);
                if(!is_wp_error($user))
                {
                    $created = new WP_User($user);
                    $created->add_role($role);
                    for ($j = 0; $j < count($rights); $j++) {
                        switch ($rights[$j]) {
                            case 'reply':
                                $created->add_cap("reply_tickets", 1);
                                break;
                            case 'delete':
                                $created->add_cap("delete_tickets", 1);
                                break;
                            case 'manage':
                                $created->add_cap("manage_tickets", 1);
                                break;
                            case 'templates':
                                $created->add_cap("manage_templates", 1);
                                break;
                            case 'settings':
                                $created->add_cap("settings_page", 1);
                                break;
                            case 'agents':
                                $created->add_cap("agents_page", 1);
                                break;
                            case 'email':
                                $created->add_cap("email_page", 1);
                                break;
                            case 'import':
                                $created->add_cap("import_page", 1);
                                break;
                            case 'merge':
                                $created->add_cap("merge_tickets", 1);
                                break;
                            default:
                                break;
                        }
                    }
                    update_user_meta($user, "wsdesk_tags", $tags);
                    $message = "User created successfully";
                    $code = "success";
                }
                else
                {
                    $message = "Something went wrong!";
                    $code = "failed";
                }
            }
            $add_agents = include(EH_CRM_MAIN_VIEWS . "agents/crm_agents_add.php");
            $manage_agents = include(EH_CRM_MAIN_VIEWS . "agents/crm_agents_manage.php");
            die(json_encode(array("add" => $add_agents, "manage" => $manage_agents, "message" => $message,"code"=>$code)));
        }
        
        static function eh_crm_agent_add() {
            $users = explode(",", sanitize_text_field($_POST['users']));
            $role = sanitize_text_field($_POST['role']);
            $rights = explode(",", sanitize_text_field($_POST['rights']));
            $tags = (($_POST['tags'] !== "") ? explode(",", sanitize_text_field($_POST['tags'])) : NULL);
            for ($i = 0; $i < count($users); $i++) {
                $user_id = $users[$i];
                $user = new WP_User($user_id);
                switch ($role) {
                    case "agents":
                        $user->add_role("WSDesk_Agents");
                        break;
                    case "supervisor":
                        $user->add_role("WSDesk_Supervisor");
                        break;
                }
                for ($j = 0; $j < count($rights); $j++) {
                    switch ($rights[$j]) {
                        case 'reply':
                            $user->add_cap("reply_tickets", 1);
                            break;
                        case 'delete':
                            $user->add_cap("delete_tickets", 1);
                            break;
                        case 'manage':
                            $user->add_cap("manage_tickets", 1);
                            break;
                        case 'templates':
                            $user->add_cap("manage_templates", 1);
                                break;
                        case 'settings':
                            $user->add_cap("settings_page", 1);
                            break;
                        case 'agents':
                            $user->add_cap("agents_page", 1);
                            break;
                        case 'email':
                            $user->add_cap("email_page", 1);
                            break;
                        case 'import':
                            $user->add_cap("import_page", 1);
                            break;
                        case 'merge':
                            $user->add_cap("merge_tickets", 1);
                            break;
                        default:
                            break;
                    }
                }
                update_user_meta($user_id, "wsdesk_tags", $tags);
            }
            $add_agents = include(EH_CRM_MAIN_VIEWS . "agents/crm_agents_add.php");
            $manage_agents = include(EH_CRM_MAIN_VIEWS . "agents/crm_agents_manage.php");
            die(json_encode(array("add" => $add_agents, "manage" => $manage_agents)));
        }

        static function eh_crm_edit_agent_html() {
            $user_id = sanitize_text_field($_POST['user_id']);
            $user = new WP_User($user_id);
            $tags_temp = get_user_meta($user_id, "wsdesk_tags", true);
            $caps_temp = array_keys($user->caps);
            $reply = '';
            $delete = '';
            $manage = '';
            $merge = '';
            $settings = '';
            $agents = '';
            $manage_temp = '';
            $email = '';
            $import = '';
            $checked = '';
            $disabled = '';
            $admin_message =  '';
            if(in_array("administrator", $user->roles))
            {
                $reply = 'checked';
                $delete = 'checked';
                $manage = 'checked';
                $merge = 'checked';
                $manage_temp = 'checked';
                $settings = 'checked';
                $agents = 'checked';
                $email = 'checked';
                $import = 'checked';
                $disabled = 'disabled';
                $admin_message = "(WSDesk Rights for Administrator cannot be edited.)";
            }
            for ($j = 0; $j < count($caps_temp); $j++) {
                switch ($caps_temp[$j]) {
                    case "reply_tickets":
                        $reply = 'checked';
                        break;
                    case "delete_tickets":
                        $delete = 'checked';
                        break;
                    case "manage_tickets":
                        $manage = 'checked';
                        break;
                    case "merge_tickets":
                        $merge = 'checked';
                        break;
                    case "manage_templates":
                        $manage_temp = 'checked';
                        break;
                    case "settings_page":
                        $settings = 'checked';
                        break;
                    case "agents_page":
                        $agents = 'checked';
                        break;
                    case "email_page":
                        $email = 'checked';
                        break;
                    case "import_page":
                        $import = 'checked';
                        break;
                }
            }
            $access = '<input '.$disabled.' type="checkbox" style="margin-top: 0;" class="form-control" name="edit_agents_rights_' . $user_id . '" id="edit_agents_rights_reply" value="reply" ' . $reply . '> '.__("Reply to Tickets", 'wsdesk').'<br>

                        <input '.$disabled.' type="checkbox" style="margin-top: 0;" class="form-control" name="edit_agents_rights_' . $user_id . '" id="edit_agents_rights_delete" value="delete" ' . $delete . '> '.__("Delete Tickets", 'wsdesk').'<br>

                        <input '.$disabled.' type="checkbox" style="margin-top: 0;" class="form-control" name="edit_agents_rights_' . $user_id . '" id="edit_agents_rights_manage" value="manage" ' . $manage . '> '.__("Manage Tickets", 'wsdesk').'<br>';

            if (in_array("WSDesk_Supervisor", $user->roles) || in_array("administrator", $user->roles)) {
                $access .= '
                        <input '.$disabled.' type="checkbox" style="margin-top: 0;" class="form-control" name="edit_agents_rights_' . $user_id . '" id="edit_agents_rights_merge" value="merge"' . $merge . '> '.__("Merge Tickets", 'wsdesk').'<br>
                        <input '.$disabled.' type="checkbox" style="margin-top: 0;" class="form-control" name="edit_agents_rights_' . $user_id . '" id="edit_agents_rights_templates" value="templates" ' . $manage_temp . '> '.__("Manage Templates", 'wsdesk').'<br>
                        <input '.$disabled.' type="checkbox" style="margin-top: 0;" class="form-control" name="edit_agents_rights_' . $user_id . '" id="edit_agents_rights_settings" value="settings" ' . $settings . '> '.__("Show Settings Page", 'wsdesk').'<br>
                            <input '.$disabled.' type="checkbox" style="margin-top: 0;" class="form-control" name="edit_agents_rights_' . $user_id . '" id="edit_agents_rights_agents" value="agents" ' . $agents . '> '.__("Show Agents Page", 'wsdesk').'<br>
                            <input '.$disabled.' type="checkbox" style="margin-top: 0;" class="form-control" name="edit_agents_rights_' . $user_id . '" id="edit_agents_rights_email" value="email" ' . $email . '> '.__("Show Email Page", 'wsdesk').'<br>
                            <input '.$disabled.' type="checkbox" style="margin-top: 0;" class="form-control" name="edit_agents_rights_' . $user_id . '" id="edit_agents_rights_import" value="import" ' . $import . '> '.__("Show Import Page", 'wsdesk').'<br>';
            }
            $tags = '';
            if (!empty($tags_temp)) {
                for ($j = 0; $j < count($tags_temp); $j++) {
                    $tag = eh_crm_get_settings(array("slug" => $tags_temp[$j], "type" => "tag"), array("title"));
                    if(!empty($tag))
                    {
                        $tags .= '<option selected value="' . $tags_temp[$j] . '" title="' . $tag[0]['title'] . '">  </option>';
                    }
                }
            }
            $output = '<span class="crm-divider"></span>
                        <div class="crm-form-element">
                            <div class="col-md-3">
                                <label for="edit_agents_rights" style="padding-right:1em !important;">WSDesk Rights</label>
                            </div>
                            <div class="col-md-9">
                                <span class="help-block">'.__("Mention Access Rights that are going to assign for selected User(s)? $admin_message", 'wsdesk').'</span>
                                <span style="vertical-align: middle;" id="edit_agents_access_rights">
                                    ' . $access . '
                                </span>
                            </div>
                        </div>
                        <div class="crm-form-element">
                            <div class="col-md-3">
                                <label for="edit_agents_tags" style="padding-right:1em !important;">'.__("Edit tags", 'wsdesk').'</label>
                            </div>
                            <div class="col-md-9">
                                <span class="help-block">'.__("Wish to edit ticket tags for Users?", 'wsdesk').' <br>'.__("The tickets will be assigned automatically if Default Assignee is [ Depends on Tags ]", 'wsdesk').'</span>
                                <select class="edit_agents_tags_' . $user_id . '" multiple="multiple">
                                    ' . $tags . '
                                </select>
                            </div>
                        </div>
                        <span class="crm-divider"></span>
                        <div class="crm-form-element">
                            <button type="button" id="save_edit_agents_' . $user_id . '" class="btn btn-primary btn-sm save_edit_agents" style="margin-left:10px;">'.__("Update Agents", 'wsdesk').'</button>
                            <button type="button" id="cancel_edit_agents_' . $user_id . '" class="btn btn-default btn-sm cancel_edit_agents" style="margin-left:10px;">'.__("Cancel Update", 'wsdesk').'</button>
                        </div>';
            die($output);
        }

        static function eh_crm_edit_agent() {
            $user_id = sanitize_text_field($_POST['user_id']);
            $rights = explode(",", sanitize_text_field($_POST['rights']));
            $tags = (($_POST['tags'] !== "") ? explode(",", sanitize_text_field($_POST['tags'])) : NULL);
            $user = new WP_User($user_id);
            $user->remove_cap("reply_tickets");
            $user->remove_cap("delete_tickets");
            $user->remove_cap("manage_tickets");
            $user->remove_cap("manage_templates");
            $user->remove_cap("settings_page");
            $user->remove_cap("agents_page");
            $user->remove_cap("email_page");
            $user->remove_cap("import_page");
            $user->remove_cap("merge_tickets");
            for ($j = 0; $j < count($rights); $j++) {
                switch ($rights[$j]) {
                    case 'reply':
                        $user->add_cap("reply_tickets", 1);
                        break;
                    case 'delete':
                        $user->add_cap("delete_tickets", 1);
                        break;
                    case 'manage':
                        $user->add_cap("manage_tickets", 1);
                        break;
                    case 'templates':
                        $user->add_cap("manage_templates", 1);
                            break;
                    case 'settings':
                        $user->add_cap("settings_page", 1);
                        break;
                    case 'agents':
                        $user->add_cap("agents_page", 1);
                        break;
                    case 'email':
                        $user->add_cap("email_page", 1);
                        break;
                    case 'import':
                        $user->add_cap("import_page", 1);
                        break;
                    case 'merge':
                        $user->add_cap("merge_tickets", 1);
                        break;
                    default:
                        break;
                }
            }
            update_user_meta($user_id, "wsdesk_tags", $tags);
            $add_agents = include(EH_CRM_MAIN_VIEWS . "agents/crm_agents_add.php");
            $manage_agents = include(EH_CRM_MAIN_VIEWS . "agents/crm_agents_manage.php");
            die(json_encode(array("add" => $add_agents, "manage" => $manage_agents)));
        }

        static function eh_crm_remove_agent() {
            $user_id = sanitize_text_field($_POST['user_id']);
            $user = new WP_User($user_id);
            if (in_array("WSDesk_Supervisor", $user->roles)) {
                $user->remove_cap("reply_tickets");
                $user->remove_cap("delete_tickets");
                $user->remove_cap("manage_tickets");
                $user->remove_cap("manage_templates");
                $user->remove_cap("settings_page");
                $user->remove_cap("agents_page");
                $user->remove_cap("email_page");
                $user->remove_cap("import_page");
                $user->remove_cap("merge_tickets");
                $user->remove_role("WSDesk_Supervisor");
            }
            else if(in_array("administrator", $user->roles))
            {
                $user->remove_cap("reply_tickets");
                $user->remove_cap("delete_tickets");
                $user->remove_cap("manage_tickets");
                $user->remove_cap("manage_templates");
                $user->remove_cap("settings_page");
                $user->remove_cap("agents_page");
                $user->remove_cap("email_page");
                $user->remove_cap("import_page");
                $user->remove_cap("merge_tickets");
                $user->remove_role("administrator");
            }
            else {
                $user->remove_cap("reply_tickets");
                $user->remove_cap("delete_tickets");
                $user->remove_cap("manage_tickets");
                $user->remove_role("WSDesk_Agents");
            }
            delete_user_meta($user_id, "wsdesk_tags");
            $add_agents = include(EH_CRM_MAIN_VIEWS . "agents/crm_agents_add.php");
            $manage_agents = include(EH_CRM_MAIN_VIEWS . "agents/crm_agents_manage.php");
            die(json_encode(array("add" => $add_agents, "manage" => $manage_agents)));
        }    
        static function eh_crm_new_ticket_post() {
            $post_values = array();
            parse_str($_POST['form'], $post_values);
            if(isset($post_values['g-recaptcha-response']))
            {
                if($post_values['g-recaptcha-response']=="")
                {
                    die("captcha_failed");
                }
                require_once "recaptcha.php";
                $settings = eh_crm_get_settings(array("slug"=>"google_captcha"),"settings_id");
                $secret = eh_crm_get_settingsmeta($settings[0]['settings_id'], "field_secret_key");
                $reCaptcha = new ReCaptcha($secret);
                $response = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"],$post_values['g-recaptcha-response']);
                if ($response == null && !$response->success) {
                    die("captcha_failed");
                }
            }
            $files = isset($_FILES["file"])?$_FILES["file"]:"";
            $email = $post_values['request_email'];
            $title = stripslashes($post_values['request_title']);
            $desc = str_replace("\n", '<br/>', stripslashes($post_values['request_description']));
            $vendor = '';
            if(EH_CRM_WOO_STATUS)
            {
                if(isset($post_values['woo_vendors']))
                {
                    $vendor = str_replace("v_","",$post_values['woo_vendors']);
                }
            }
            $user = get_user_by('email', $email);
            $args = array(
                'ticket_email' => $email,
                'ticket_title' => $title,
                'ticket_content' => $desc,
                'ticket_category' => 'raiser_reply',
                'ticket_vendor' => $vendor,
                'ticket_author' => (empty($user))?0:$user->ID
            );
            if(eh_crm_get_settingsmeta(0,"auto_create_user") === 'enable')
            {
                $email_check = email_exists($email);
                if($email_check)
                {
                    $args['ticket_author'] = $email_check;
                }
                else
                {
                    
                    $maybe_username = explode('@', $email);
                    $maybe_username = sanitize_user($maybe_username[0]);
                    $counter = 1;
                    $username = $maybe_username;
                    $password = wp_generate_password(12, true);

                    while (username_exists($username)) {
                        $username = $maybe_username . $counter;
                        $counter++;
                    }

                    $user = wp_create_user($username, $password, $email);
                    if(!is_wp_error($user))
                    {
                        wp_new_user_notification($user,null,'both');
                        $args['ticket_author'] = $user;
                    }
                }
            }
            unset($post_values['request_email']);
            unset($post_values['request_title']);
            unset($post_values['request_description']);
            $meta = array();
            $req_args = array("type" => "tag");
            $fields = array("slug", "title", "settings_id");
            $avail_tags = eh_crm_get_settings($req_args, $fields);
            $tagged = array();
            if(!empty($avail_tags))
            {
                for ($i = 0, $j = 0; $i < count($avail_tags); $i++) {
                    if (preg_match('/' . strtolower($avail_tags[$i]['title']) . '/', strtolower($desc)) || preg_match('/' . strtolower($avail_tags[$i]['title']) . '/', strtolower($title))) {
                        $tagged[$j] = $avail_tags[$i]['slug'];
                        $j++;
                    }
                }
            }
            $meta['ticket_tags'] = $tagged;
            $default_assignee = eh_crm_get_settingsmeta('0', "default_assignee");
            $assignee = array();
            switch ($default_assignee) {
                case "ticket_tags":
                    $users = get_users(array("role__in" => array("WSDesk_Agents", "WSDesk_Supervisor")));
                    $user_tags = array();
                    for ($i = 0; $i < count($users); $i++) {
                        $current = $users[$i];
                        $id = $current->ID;
                        $user_tags[$id] = get_user_meta($id, "wsdesk_tags", true);
                    }
                    foreach ($user_tags as $key => $value) {
                        for($i=0;$i<count($value);$i++)
                        {
                            if(in_array($value[$i], $tagged))
                            {
                                array_push($assignee, $key);
                                break;
                            }
                        }
                    }
                    break;
                case "ticket_vendors":
                    array_push($assignee, $vendor);
                    break;
                case "no_assignee":
                    break;
                default:
                    array_push($assignee, $default_assignee);
                    break;
            }
            $meta['ticket_assignee'] = $assignee;
            $default_label = eh_crm_get_settingsmeta('0', "default_label");
            if(eh_crm_get_settings(array('slug'=>$default_label)))
            {
                $meta['ticket_label'] = $default_label;
            }
            foreach ($post_values as $key => $value) {
                $meta[$key] = $value;
            }
            if(isset($_FILES["file"]) && !empty($_FILES['file']))
            {   
                $attachment_data = CRM_Ajax::eh_crm_ticket_file_handler($files);
                $meta["ticket_attachment"] = $attachment_data['url'];
                $meta["ticket_attachment_path"] = $attachment_data['path'];
            }
            $meta['ticket_source'] = "Form";
            $gen_id = eh_crm_insert_ticket($args, $meta);
            $send = eh_crm_get_settingsmeta('0', "auto_send_creation_email");
            if($send == 'enable')
            {
                eh_crm_debug_error_log(" ------------- WSDesk Email Debug Started ------------- ");
                eh_crm_debug_error_log("New ticket auto Email for Ticket #".$gen_id);
                eh_crm_debug_error_log("Email function called for New Ticket #".$gen_id);
                $response = CRM_Ajax::eh_crm_fire_email("new_ticket", $gen_id);
                eh_crm_debug_error_log(" ------------- WSDesk Email Debug Ended ------------- ");
                
            }
            $submit_ticket_redirect_url = eh_crm_get_settingsmeta('0', "submit_ticket_redirect_url");
            if(empty($submit_ticket_redirect_url))
            {
                $my_current_lang = apply_filters( 'wpml_current_language', NULL );
                do_action( 'wpml_switch_language', $my_current_lang );
                die(json_encode(array("status"=>"success","message"=>__("Support Request Received Successfully",'wsdesk'))));
            }
            else
            {
                die(json_encode(array("status"=>"redirect","link"=>$submit_ticket_redirect_url)));
            }
        }
        
        static function eh_crm_new_ticket_form() {
            die(include(EH_CRM_MAIN_VIEWS . "shortcodes/crm_support_new.php"));
        }
        
        static function eh_crm_survey_ticket_form() {
            $id = $_POST['id'];
            $author = $_POST['author'];
            $rating = $_POST['rating'];
            $comment = str_replace("\n", '<br/>',$_POST['comment']);
            $ticket = eh_crm_get_ticket(array("ticket_id"=>$id));
            if($ticket)
            {
                if($ticket[0]['ticket_email'] == $author)
                {
                    $satis = "";
                    if($rating == "good")
                    {
                        $satis = "great";
                    }
                    else
                    {
                        $satis = "Bad";
                    }
                    eh_crm_update_ticketmeta($id, "ticket_rating", $satis);
                    if($comment !== "")
                    {
                        $child = array
                                    (
                                        'ticket_email' => $author,
                                        'ticket_title' => $ticket[0]['ticket_title'],
                                        'ticket_content' => $comment,
                                        'ticket_category' => "satisfaction_survey",
                                        'ticket_parent' => $id,
                                        'ticket_vendor' => $ticket[0]['ticket_vendor']
                                    );
                        eh_crm_insert_ticket($child);
                    }
                    die('<h1>'.__("Thank you", 'wsdesk').'</h1><h4>'.__("Satisfaction feedback submitted successfully", 'wsdesk').'</h4>');
                }
                else
                {
                    die('<h1>'.__("Oops!", 'wsdesk').'</h1><h4>'.__("Unauthorized Access!", 'wsdesk').'</h4>');
                }
            }
            else
            {
               die('<h1>'.__("Oops!", 'wsdesk').'</h1><h4>'.__("Access Denied!", 'wsdesk').'</h4>'); 
            }
        }
        
        static function eh_crm_ticket_single_view() {
            $ticket_id = sanitize_text_field($_POST['ticket_id']);
            if(isset($_POST['pagination_id']))
                $pagination = json_decode(stripslashes(sanitize_text_field($_POST['pagination_id'])), true);
            else
                $pagination = array();
            $content = CRM_Ajax::eh_crm_ticket_single_view_gen($ticket_id,$pagination);
            $tab = CRM_Ajax::eh_crm_ticket_single_view_gen_head($ticket_id);
            die(json_encode(array("tab_head"=>$tab,"tab_content"=>$content)));
        }
        
        static function eh_crm_ticket_single_view_gen_head($ticket_id) {
            $current = eh_crm_get_ticket(array("ticket_id"=>$ticket_id));
            $tab = '<a onclick="setURLFunc('.$ticket_id.')" href="#tab_content_'.$ticket_id.'" id="tab_content_a_'.$ticket_id.'" aria-controls="#'.$ticket_id.'" role="tab" data-toggle="tab" class="tab_a" style="font-size: 12px;padding: 11px 5px;margin-right:0px !important;"><button type="button" class="btn btn-default btn-circle close_tab pull-right"><span class="glyphicon glyphicon-remove"></span></button><div class="badge">#'.$ticket_id.'</div><span class="tab_head"> '. stripslashes(html_entity_decode(htmlentities($current[0]['ticket_title']))).'</span></a>';
            return $tab;
        }
        
        static function eh_crm_ticket_single_view_gen($ticket_id,$pagination=array()) {
            ob_start();
            $current = eh_crm_get_ticket(array("ticket_id"=>$ticket_id));
            $tickets_display = eh_crm_get_settingsmeta('0', "tickets_display");
            $current_meta = eh_crm_get_ticketmeta($ticket_id);
            $logged_user = wp_get_current_user();
            $logged_user_caps = array_keys($logged_user->caps);
            $avail_caps = array("reply_tickets","delete_tickets","manage_tickets","manage_templates", "merge_tickets");
            $total_count = (eh_crm_get_ticket_value_count("ticket_parent",0));
            $access = array();
            if(!in_array("administrator", $logged_user->roles))
            {
                for($i=0;$i<count($logged_user_caps);$i++)
                {
                    if(!in_array($logged_user_caps[$i], $avail_caps))
                    {
                        unset($logged_user_caps[$i]);
                    }
                }
                $access = $logged_user_caps;
            }
            else
            {
                $access = $avail_caps;
            }
            $users_data = get_users(array("role__in" => array("administrator", "WSDesk_Agents", "WSDesk_Supervisor")));
            $users = array();
            for ($i = 0; $i < count($users_data); $i++) {
                $current_user = $users_data[$i];
                $temp = array();
                $roles = $current_user->roles;
                foreach ($roles as $value) {
                    $current_role = $value;
                    $temp[$i] = ucfirst(str_replace("_", " ", $current_role));
                }
                $users[implode(' & ', $temp)][$current_user->ID] = $current_user->data->display_name;
            }
            $avail_fields = eh_crm_get_settings(array("type" => "field"), array("slug", "title", "settings_id"));
            $selected_fields = eh_crm_get_settingsmeta(0, 'selected_fields');
            if(!$selected_fields)
            {
                $selected_fields = array();
            }
            $avail_tags = eh_crm_get_settings(array("type" => "tag"),array("slug","title","settings_id"));
            $avail_labels = eh_crm_get_settings(array("type" => "label"), array("slug", "title", "settings_id"));
            $ticket_label = "";
            $ticket_label_slug ="";
            $eye_color = "";
            for($j=0;$j<count($avail_labels);$j++)
            {
                if($avail_labels[$j]['slug'] == $current_meta['ticket_label'])
                {
                    $ticket_label = $avail_labels[$j]['title'];
                    $ticket_label_slug = $avail_labels[$j]['slug'];
                }
                if($avail_labels[$j]['slug'] == $current_meta['ticket_label'])
                {
                    $eye_color = eh_crm_get_settingsmeta($avail_labels[$j]['settings_id'], "label_color");
                }
            }
            $ticket_tags_list = "";
            $response = array();
            $co = 0;
            if(!empty($avail_tags))
            {
                for($j=0;$j<count($avail_tags);$j++)
                {
                    $current_ticket_tags=(isset($current_meta['ticket_tags'])?$current_meta['ticket_tags']:array());
                    for($k=0;$k<count($current_ticket_tags);$k++)
                    {
                        if($avail_tags[$j]['slug'] == $current_ticket_tags[$k])
                        {
                            $args_post = array(
                                'orderby' => 'ID',
                                'numberposts' => -1,
                                'post_type' => array('post', 'product'),
                                'post__in' => eh_crm_get_settingsmeta($avail_tags[$j]['settings_id'], 'tag_posts')
                            );
                            $posts = get_posts($args_post);
                            $temp = get_post();
                            for ($m = 0; $m < count($posts); $m++,$co++) {
                                $response[$co]['title'] = $posts[$m]->post_title;
                                $response[$co]['guid'] = get_permalink($posts[$m]->ID);
                            }
                            $ticket_tags_list .= '<span class="label label-info">#'.$avail_tags[$j]['title'].'</span>';
                        }
                    }
                }
            }
            $index = array_search($ticket_id, $pagination);
            $next = '';
            $previous = '';
            if($index !== FALSE)
            {
                if($index+1 < count($pagination))
                {
                    $next = $pagination[$index + 1];
                }
                if($index-1 >= 0)
                {
                    $previous = $pagination[$index - 1];
                }
            }
            $my_current_lang = apply_filters( 'wpml_current_language', NULL );
            do_action( 'wpml_switch_language', $my_current_lang );
            $blog_info = eh_crm_wpml_translations(get_bloginfo("name"), 'bloginfo', 'bloginfo');
            $ticket_label = eh_crm_wpml_translations($ticket_label, 'ticket_label_title', 'ticket_label_title');
            ?>
        
        <!-- Sliding div ends here -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb col-md-8" style="margin: 0 !important;background: none !important;border:none;padding: 8px 0px !important; ">
                            <li><?php echo $blog_info ?></li>
                            <li><?php echo $ticket_label; ?></li>
                            <li class="active"><span class="label label-success" style="background-color:<?php echo $eye_color; ?> !important"><?php _e('Ticket','wsdesk'); ?> #<?php echo $ticket_id; ?></span></li>
                            <span class="spinner_loader ticket_loader_<?php echo $ticket_id; ?>">
                                <span class="bounce1"></span>
                                <span class="bounce2"></span>
                                <span class="bounce3"></span>
                            </span>
                        </ol>
                        <a class="btn btn-default pull-right" target="_blank" href="<?php echo admin_url('admin.php?page=wsdesk_print&ticket='.$ticket_id.'&master='. md5($current[0]['ticket_email'])); ?>">
                            <span class="glyphicon glyphicon-print"></span>
                        </a>
                        <?php
                            if(in_array("delete_tickets", $access))
                            {
                                echo '<button type="button" class="btn btn-default ticket_action_delete pull-right" id="'.$ticket_id.'" style="margin-right:10px;">
                                        <span class="glyphicon glyphicon-trash"></span>
                                      </button>';
                            }
                            if(in_array("manage_tickets", $access))
                            {
                                echo '<div class="filter-each ticket-edit-btn multiple_ticket_action" id="edit_tickets" style="display: none;"><div  class="ticket-edit-button" data-placement="top" data-toggle="wsdesk_tooltip" title="Edit Tickets"><span class="glyphicon glyphicon-edit"></span></div></div>';                                
                            }
                            if(in_array("merge_tickets", $access))
                            {
                                echo '<button type="button" class="btn btn-default ticket_action_merge pull-right" id="'.$ticket_id.'" style="margin-right:10px;">
                                        <span>'.__('Merge Tickets', 'wsdesk').'</span>
                                      </button>';
                            }
                        ?>
                        <div id="ticket_merge_modal_<?php echo $ticket_id?>" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title"><?php _e('Merge Tickets','wsdesk')?></h4>
                                  </div>
                                  <div class="modal-body">
                                    <input type="hidden" id="merge_hidden_ticket_ids_<?php echo $ticket_id;?>" value=''>
                                    <div class="row">
                                       <select id="all_ticket_ids_<?php echo $ticket_id?>" class="form-control crm-form-element-input all_ticket_ids" multiple="multiple">
                                        <?php
                                            foreach($total_count as $parent_ids)
                                            {
                                                if($parent_ids['ticket_id']!=$ticket_id)
                                                    echo "<option value=".$parent_ids['ticket_id'].">".$parent_ids['ticket_id']."</option>";
                                            }
                                        ?>
                                       </select>
                                    </div>
                                    <div class="row verify" style="overflow-y: auto; max-height:400px; ">
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close', 'wsdesk'); ?></button>
                                    <button type="button" class="btn btn-success merge_ticket_verify" ><?php _e('Verify', 'wsdesk'); ?></button>
                                    <button type="button" class="btn btn-primary merge_ticket_confirm" ><?php _e('Confirm', 'wsdesk'); ?></button>
                                  </div>
                                </div>
                            </div>
                        </div>


                        <div class="btn-group btn-group-sm pull-right" id="<?php echo $ticket_id;?>" style="margin-right:10px;">
                                <?php
                                        if($previous != '')
                                        {
                                            ?>
                                                <button type="button"  class="btn btn-default single_pagination_tickets" id="<?php echo $previous;?>" title="<?php _e('Previous','wsdesk');?>" data-container="body" style="margin-right:5px;">
                                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                                </button>
                                            <?php
                                        }
                                        if($next != '')
                                        {
                                            ?>
                                                <button type="button"  class="btn btn-default single_pagination_tickets" id="<?php echo $next;?>" title="<?php _e('Next','wsdesk');?>" data-container="body" style="margin-left:5px;">
                                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                                </button>
                                            <?php
                                        }
                                ?>
                            </div>
                    </div>
                </div>
                <span class="crm-divider" style="margin-bottom:2px;margin-left: -15px;width: 103.75%;"></span>
                <div class="row">
                    <div class="col-md-3" style="padding-right: 0px;padding-top: 10px;">
                        <div class="form-group">
                            <span class="help-block"><?php _e("Assignee", 'wsdesk'); ?></span>
                            <select id="assignee_ticket_<?php echo $ticket_id; ?>" class="form-control" aria-describedby="helpBlock" multiple="multiple">
                                <?php
                                    $assignee = (isset($current_meta['ticket_assignee'])?$current_meta['ticket_assignee']:array());
                                    if($assignee!=="")
                                    {
                                        foreach ($users as $key => $value) {
                                            if(in_array("manage_tickets", $access))
                                            {
                                                foreach ($value as $id => $name) {
                                                    $selected = '';
                                                    if (in_array($id, $assignee)) {
                                                        $selected = 'selected';
                                                    }
                                                    echo '<option value="' . $id . '" ' . $selected . '>'.$name.' | '.$key.'</option>';
                                                }
                                            }
                                            else
                                            {
                                                foreach ($value as $id => $name) {
                                                    if (in_array($id, $assignee)) {
                                                        echo '<option value="' . $id . '" selected>'.$name.' | '.$key.'</option>';
                                                    }
                                                }
                                            }                                        
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <?php
                            $cc = (isset($current_meta['ticket_cc'])?$current_meta['ticket_cc']:array());
                            ?>
                            <div class="form-group">
                                <span class="help-block"><?php _e("CC", 'wsdesk'); ?> <span class="glyphicon glyphicon-info-sign" style="color:lightgray;font-size:x-small;vertical-align:baseline;" data-toggle="wsdesk_tooltip" title="<?php _e("To add multiple CC, separate each address with comma without any space.", 'wsdesk'); ?>" data-container="body"></span></span>
                                <input type="text" id="cc_ticket_<?php echo $ticket_id; ?>" class="form-control cc_<?php echo $ticket_id; ?>" value= "<?php echo join(',',$cc) ?>">
                            </div>
                        <?php
                            $bcc = (isset($current_meta['ticket_bcc'])?$current_meta['ticket_bcc']:array());
                            if(!empty($bcc))
                            {
                            ?>
                                <div class="form-group">
                                    <span class="help-block"><?php _e("Bcc", 'wsdesk'); ?></span>
                                    <select id="bcc_ticket_<?php echo $ticket_id; ?>" class="form-control bcc_select_<?php echo $ticket_id; ?>" aria-describedby="helpBlock" multiple="multiple">
                                        <?php
                                            foreach ($bcc as $key => $value) {
                                                if(in_array("manage_tickets", $access))
                                                {
                                                    echo '<option value="' . $value . '" selected>'.$value.'</option>';
                                                }
                                                else
                                                {
                                                    echo '<option value="' . $value . '" selected>'.$value.'</option>';
                                                }                                        
                                            }
                                        ?>
                                    </select>
                                </div>
                            <?php
                            }
                        ?>
                        <div class="form-group">
                            <span class="help-block"><?php _e("Tags", 'wsdesk'); ?></span>
                            <select id="tags_ticket_<?php echo $ticket_id; ?>" class="form-control crm-form-element-input" multiple="multiple">
                                <?php
                                    $ticket_tags = (isset($current_meta['ticket_tags'])?$current_meta['ticket_tags']:array());
                                    if($ticket_tags!=="" && !empty($avail_tags))
                                    {
                                        for($i=0;$i<count($avail_tags);$i++)
                                        {
                                            if(in_array("manage_tickets", $access))
                                            {
                                                $selected = '';
                                                if(in_array($avail_tags[$i]['slug'], $ticket_tags))
                                                {
                                                    $selected = 'selected';
                                                }
                                                echo '<option value="' . $avail_tags[$i]['slug'] . '" ' . $selected . '>'.$avail_tags[$i]['title'].'</option>';
                                            }
                                            else
                                            {
                                                if (in_array($avail_tags[$i]['slug'], $ticket_tags)) {
                                                    echo '<option value="' . $avail_tags[$i]['slug'] . '" selected>'.$avail_tags[$i]['title'].'</option>';
                                                }
                                            }
                                            
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <hr/>
                        <?php
                        for ($i = 0; $i < count($selected_fields); $i++) {
                            for ($j = 3; $j < count($avail_fields); $j++) {
                                if ($avail_fields[$j]['slug'] == $selected_fields[$i]) {
                                    $field_ticket_value = (isset($current_meta[$avail_fields[$j]['slug']])?$current_meta[$avail_fields[$j]['slug']]:'');
                                    $current_settings_meta = eh_crm_get_settingsmeta($avail_fields[$j]['settings_id']);
                                    $required = (isset($current_settings_meta['field_require_agent'])?$current_settings_meta['field_require_agent']:'');
                                    $required = ($required === "yes")?'required':'';
                                    if($current_settings_meta['field_type'] != "file" && $current_settings_meta['field_type'] != "google_captcha")
                                    {
                                        echo '<div class="form-group">';
                                        echo '<span class="help-block">' . $avail_fields[$j]['title'];
                                        echo ($required === 'required') ? '<span class="input_required"> *</span></span>' : '</span>';
                                        if($current_settings_meta['field_type'] == 'select')
                                        {
                                            if($avail_fields[$j]['slug'] == 'woo_order_id')
                                            {
                                              $current_settings_meta['field_type'] = 'text';
                                            }
                                        }
                                        switch($current_settings_meta['field_type'])
                                        {
                                            case 'text':
                                                $readonly = "";
                                                if(!in_array("manage_tickets", $access))
                                                {
                                                    $readonly = "readonly";
                                                }
                                                $required_text = '';
                                                if($required == 'required')
                                                {
                                                    $required_text = 'text_required';
                                                }
                                                echo '<input type="text" AUTOCOMPLETE="off" class="form-control '.$required_text.' crm-form-element-input ticket_input_text_'.$ticket_id.'" id="'.$avail_fields[$j]['slug'].'" placeholder="'.$current_settings_meta['field_placeholder'].'" '.$readonly.' value="'.$field_ticket_value.'">';
                                                break;
                                            case 'ip':
                                                echo '<label style="font-weight: normal !important;">'.$field_ticket_value.'</label>';
                                                break;
                                            case 'date':
                                                $readonly = "";
                                                if(!in_array("manage_tickets", $access))
                                                {
                                                    $readonly = "readonly";
                                                }
                                                $value = '';
                                                if($field_ticket_value!='')
                                                {
                                                    $value = 'value="'.$field_ticket_value.'"'; 
                                                }
                                                $required_text = '';
                                                if($required == 'required')
                                                {
                                                    $required_text = 'text_required';
                                                }
                                                echo '<input type="text" AUTOCOMPLETE="off" class="form-control '.$required_text.' crm-form-element-input trigger_date_jq ticket_input_date_'.$ticket_id.'" id="'.$avail_fields[$j]['slug'].'_t_'.$ticket_id.'" placeholder="'.$current_settings_meta['field_placeholder'].'" '.$readonly.' '.$value.'>';
                                                break;
                                            case 'email':
                                                $readonly = "";
                                                if(!in_array("manage_tickets", $access))
                                                {
                                                    $readonly = "readonly";
                                                }
                                                $required_text = '';
                                                if($required == 'required')
                                                {
                                                    $required_text = 'text_required';
                                                }
                                                echo '<input type="email" AUTOCOMPLETE="off" class="form-control '.$required_text.' crm-form-element-input ticket_input_email_'.$ticket_id.'" id="'.$avail_fields[$j]['slug'].'" placeholder="'.$current_settings_meta['field_placeholder'].'" '.$readonly.' value="'.$field_ticket_value.'">';
                                                break;
                                            case 'phone':
                                                $readonly = "";
                                                if(!in_array("manage_tickets", $access))
                                                {
                                                    $readonly = "readonly";
                                                }
                                                $required_text = '';
                                                if($required == 'required')
                                                {
                                                    $required_text = 'text_required';
                                                }
                                                echo '<span><strong>+</strong><input type="number" AUTOCOMPLETE="off" class="form-control '.$required_text.' crm-form-element-input ticket_input_number_'.$ticket_id.'" id="'.$avail_fields[$j]['slug'].'" placeholder="'.$current_settings_meta['field_placeholder'].'" '.$readonly.' value="'.$field_ticket_value.'" style="display: inline !important; width: 97% !important;"></span>';
                                                break;
                                            case 'number':
                                                $readonly = "";
                                                if(!in_array("manage_tickets", $access))
                                                {
                                                    $readonly = "readonly";
                                                }
                                                $required_text = '';
                                                if($required == 'required')
                                                {
                                                    $required_text = 'text_required';
                                                }
                                                echo '<input type="number" AUTOCOMPLETE="off" class="form-control '.$required_text.' crm-form-element-input ticket_input_number_'.$ticket_id.'" id="'.$avail_fields[$j]['slug'].'" placeholder="'.$current_settings_meta['field_placeholder'].'" '.$readonly.' value="'.$field_ticket_value.'">';
                                                break;
                                            case 'password':
                                                $readonly = "";
                                                if(in_array("manage_tickets", $access))
                                                {
                                                    $readonly = 'onfocus="this.removeAttribute(\'readonly\');"';
                                                }
                                                $required_text = '';
                                                if($required == 'required')
                                                {
                                                    $required_text = 'text_required';
                                                }
                                                echo '<input type="password" AUTOCOMPLETE="false" readonly class="form-control '.$required_text.' crm-form-element-input ticket_input_pwd_'.$ticket_id.'" id="'.$avail_fields[$j]['slug'].'" placeholder="'.$current_settings_meta['field_placeholder'].'" '.$readonly.' value="'.$field_ticket_value.'">';
                                                break;
                                            case 'select':
                                                $field_values = $current_settings_meta['field_values'];
                                                $required_text = '';
                                                if($required == 'required')
                                                {
                                                    $required_text = 'text_required';
                                                }
                                                echo '<select class="form-control crm-form-element-input '.$required_text.' ticket_input_select_'.$ticket_id.'" id="'.$avail_fields[$j]['slug'].'">';
                                                echo '<option value="">'.(isset($current_settings_meta['field_placeholder'])?htmlentities($current_settings_meta['field_placeholder']):'-').'</option>';
                                                foreach($field_values as $key => $value)
                                                {
                                                    if(in_array("manage_tickets", $access))
                                                    {
                                                        $selected = "";
                                                        if($key == $field_ticket_value)
                                                        {
                                                            $selected = "selected";
                                                        }
                                                        echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                                    }
                                                    else
                                                    {
                                                        if($key == $field_ticket_value)
                                                        {
                                                            echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                                        }
                                                    }
                                                }
                                                echo '</select>';
                                                break;
                                            case 'radio':
                                                $required_radio = '';
                                                if($required == 'required')
                                                {
                                                    $required_radio = 'radio_required';
                                                }
                                                $field_values = $current_settings_meta['field_values'];
                                                echo '<span style="vertical-align: middle;">';
                                                foreach($field_values as $key => $value)
                                                {
                                                    if(in_array("manage_tickets", $access))
                                                    {
                                                        $checked = "";
                                                        if($key == $field_ticket_value)
                                                        {
                                                            $checked = "checked";
                                                        }
                                                        echo '<input type="radio" style="margin-top: 0;" id="'.$avail_fields[$j]['slug'].'" name="'.$avail_fields[$j]['slug'].'" class="form-control '.$required_radio.' ticket_input_radio_'.$ticket_id.'" value="'.$key.'" '.$checked.'> '.$value.'<br>';
                                                    }
                                                    else
                                                    {
                                                        if($key == $field_ticket_value)
                                                        {
                                                            echo '<input type="radio" style="margin-top: 0;" id="'.$avail_fields[$j]['slug'].'" name="'.$avail_fields[$j]['slug'].'" class="form-control '.$required_radio.' ticket_input_radio_'.$ticket_id.'" value="'.$key.'" checked readonly> '.$value.'<br>';
                                                        }
                                                    }
                                                }
                                                echo "</span>";
                                                break;
                                            case 'checkbox':
                                                $required_check = '';
                                                if($required == 'required')
                                                {
                                                    $required_check = 'check_required';
                                                }
                                                $field_values = $current_settings_meta['field_values'];
                                                $field_ticket_value = is_array($field_ticket_value)?$field_ticket_value:array();
                                                echo '<span style="vertical-align: middle;">';
                                                foreach($field_values as $key => $value)
                                                {
                                                    if(in_array("manage_tickets", $access))
                                                    {
                                                        $checked = "";
                                                        if(in_array($key,$field_ticket_value))
                                                        {
                                                            $checked = "checked";
                                                        }
                                                        echo '<input type="checkbox" style="margin-top: 0;" id="'.$avail_fields[$j]['slug'].'" class="form-control '.$required_check.' ticket_input_checkbox_'.$ticket_id.'" value="'.$key.'" '.$checked.'> '.$value.'<br>';
                                                    }
                                                    else
                                                    {
                                                        if(in_array($key,$field_ticket_value))
                                                        {
                                                            echo '<input type="checkbox" style="margin-top: 0;" id="'.$avail_fields[$j]['slug'].'" class="form-control '.$required_check.' ticket_input_checkbox_'.$ticket_id.'" value="'.$key.'" checked readonly> '.$value.'<br>';
                                                        }
                                                    }
                                                }
                                                echo "</span>";
                                                break;
                                            case 'textarea':
                                                $required_text = '';
                                                if($required == 'required')
                                                {
                                                    $required_text = 'text_required';
                                                }
                                                $readonly = "";
                                                if(!in_array("manage_tickets", $access))
                                                {
                                                    $readonly = "readonly";
                                                }
                                                echo '<textarea class="form-control '.$required_text.' except_rich ticket_input_textarea_'.$ticket_id.'" id="'.$avail_fields[$j]['slug'].'" '.$readonly.'>'.$field_ticket_value.'</textarea>';
                                                break;
                                        }
                                        echo '</div>';
                                    }
                                }
                            }
                        }
                        if(in_array("manage_tickets", $access))
                        {
                            echo '<button type="button" class="btn btn-primary col-md-offset-3 ticket_action_save_props" id="'.$ticket_id.'">
                                    <span class="glyphicon glyphicon-saved"></span> '.__("Save Properties", 'wsdesk').'
                                  </button>';
                        }
                    ?>
                    </div>
                    <div class="col-md-9 Ws-content-detail-full">
                        <div class="single_ticket_panel rightPanel">
                            <div class="rightPanelHeader">
                                <div class="leftFreeSpace">
                                    <div class="icon" style="top: 5% !important;"><img src="<?php echo EH_CRM_MAIN_IMG.'message_icon.png'?>"></div>
                                    <div class="tictxt">
                                    <p style="margin-top: 5px;font-size: 16px;">
                                            <?php
                                                if(in_array("manage_tickets", $access))
                                                {
                                                    echo '<input type="text" value="'. stripslashes(htmlentities($current[0]['ticket_title'])).'" id="ticket_title_'.$ticket_id.'" class="ticket_title_editable">';
                                                }
                                                else
                                                {
                                                    echo $current[0]['ticket_title'];
                                                }
                                            ?>                                
                                    </p>
                                    <p style="margin-top: 5px;" class="info">
                                        <i class="glyphicon glyphicon-user"></i> by
                                        <?php
                                            if($current[0]['ticket_author'] != 0)
                                            {
                                                $raiser_obj = new WP_User($current[0]['ticket_author']);
                                                echo '<a href="#" id="ticket_author_'.$ticket_id.'" class="ticket_author" onclick="search_by_email(\''.str_replace('"', "&quot;", $raiser_obj->user_email).'\', '.$ticket_id.')">'.$raiser_obj->display_name.'</a> ';
                                            }
                                            else
                                            {
                                                echo '<a href="#" id="ticket_author_'.$ticket_id.'" class="ticket_author" onclick="search_by_email(\''.str_replace('"', "&quot;", $current[0]['ticket_email']).'\', '.$ticket_id.')">'.$current[0]['ticket_email'].'</a>';
                                            }
                                            if(in_array("manage_tickets", $access))
                                            {
                                                echo '<input type="text" value="'. str_replace('"', "&quot;", $current[0]['ticket_email']).'" id="ticket_author_edit_'.$ticket_id.'" class="ticket_author_editable" style="display: none">';
                                                echo '<span id="ticket_author_edit_link_span_'.$ticket_id.'">[<a href="#" data-toggle="wsdesk_tooltip" title="'.__("This will edit the requester E-mail address.", "wsdesk").'" data-container="body" id="'.$ticket_id.'" class="ticket_author_edit_link">Edit</a>]</span>';
                                            }
                                        ?>
                                        | <i class="glyphicon glyphicon-calendar"></i> <?php echo eh_crm_get_formatted_date($current[0]['ticket_date']); ?>
                                        | <i class="glyphicon glyphicon-time"></i>
                                        <?php
                                            $solved = false;
                                            $meta = eh_crm_get_ticketmeta($ticket_id);
                                            if($meta['ticket_label'] == "label_LL02")
                                            {   
                                                $solved = true;   
                                            }
                                            //Average Total Time for Agent's Solved tickets
                                            if($solved)
                                            {   
                                                $dteDifference=array();
                                                $latest_reply_id = eh_crm_get_ticket_value_count("ticket_category","agent_note" ,true,"ticket_parent",$current[0]['ticket_id'],'ticket_id');
                                                if(!$latest_reply_id)
                                                {
                                                    $ticket_time = eh_crm_get_formatted_date($current[0]['ticket_date']);
                                                    $last_reply_time = eh_crm_get_formatted_date($current[0]['ticket_date']);
                                                }
                                                else
                                                {
                                                    $latest_ticket_reply = eh_crm_get_ticket(array("ticket_id"=>$latest_reply_id[0]["ticket_id"]));
                                                    $ticket_time = eh_crm_get_formatted_date($current[0]['ticket_date']);
                                                    $last_reply_time = eh_crm_get_formatted_date($latest_ticket_reply[0]['ticket_date']);
                                                }
                                                _e("Total time ", 'wsdesk');
                                                $dteDifference[0] = eh_crm_dateDiffe($ticket_time,$last_reply_time);
                                                echo $dteDifference[0][0]."D:".$dteDifference[0][1]."H:".$dteDifference[0][2]."M";
                                            }    
                                            //Average Total Time for Agent's Unsolved tickets
                                            if(!$solved)
                                            {
                                                $ticket_time = eh_crm_get_formatted_date($current[0]['ticket_date']);
                                                $current_time = eh_crm_get_formatted_date(date("M d, Y H:i:s",time()));
                                                _e("Total time ", 'wsdesk');
                                                $dteDifference[0] = eh_crm_dateDiffe($ticket_time,$current_time);
                                                echo $dteDifference[0][0]."D:".$dteDifference[0][1]."H:".$dteDifference[0][2]."M";
                                            }  
                                        ?> 
                                        | <i class="glyphicon glyphicon-comment"></i>
                                        <?php
                                            $raiser_voice = eh_crm_get_ticket_value_count("ticket_parent",$ticket_id,false,"ticket_category","raiser_reply");
                                            echo count($raiser_voice)." ".__("Raiser Voice", 'wsdesk');                                    
                                        ?>
                                        | <i class="glyphicon glyphicon-bullhorn"></i>
                                        <?php
                                            $agent_voice = eh_crm_get_ticket_value_count("ticket_parent",$ticket_id,false,"ticket_category","agent_reply");
                                            echo count($agent_voice)." ".__("Agent Voice", 'wsdesk');
                                        ?>
                                        | <i class="glyphicon glyphicon-star"></i> Rating : <?php echo (isset($current_meta['ticket_rating'])?ucfirst($current_meta['ticket_rating']):__("None", 'wsdesk')); ?>
                                    </p>
                                    <?php
                                        if(EH_CRM_WOO_STATUS)
                                        {
                                            $woo_orders = eh_crm_get_settingsmeta(0, "woo_order_tickets");
                                            $woo_access = eh_crm_get_settingsmeta(0, "woo_order_access");
                                            $woo_price = eh_crm_get_settingsmeta(0, "woo_order_price");
                                            $role = "";
                                            if(in_array("administrator", $logged_user->roles)) {
                                                $role = "administrator";
                                            }
                                            elseif (in_array("WSDesk_Supervisor", $logged_user->roles)) {
                                                $role = "WSDesk_Supervisor";
                                            }
                                            elseif (in_array("WSDesk_Agents", $logged_user->roles)) {
                                                $role = "WSDesk_Agents";
                                            }
                                            if($woo_orders == "enable" && in_array($role, $woo_access))
                                            {
                                                $raiser_id = $current[0]['ticket_author'];
                                                if($raiser_id == 0)
                                                {
                                                    $user = get_user_by("email",$current[0]['ticket_email'] );
                                                    if($user)
                                                    {
                                                        $raiser_id = $user->ID;
                                                    }
                                                }
                                                $customer_orders =array();
                                                if(WC()->version < '2.7.0')
                                                {
                                                    if($raiser_id != 0)
                                                    {
                                                        $customer_orders = get_posts( array(
                                                            'orderby' => 'ID',
                                                            'numberposts' => -1,
                                                            'meta_key'    => '_customer_user',
                                                            'meta_value'  => $raiser_id,
                                                            'post_type'   => wc_get_order_types(),
                                                            'post_status' => array_keys(wc_get_order_statuses()),
                                                            'fields' => 'ids'
                                                        ));
                                                    }
                                                    if(!empty($customer_orders))
                                                    {
                                                        $order_id_url = "";
                                                        $total_amount = 0;
                                                        $order_count = count($customer_orders);
                                                        $count = 0;
                                                        $cou=0;
                                                        foreach ($customer_orders as $order) {
                                                            $order_data = wc_get_order($order);
                                                            if($order_data->get_status() == "completed")
                                                            {
                                                                $total_amount += $order_data->get_total();
                                                            }
                                                            if($cou < 5)
                                                            {
                                                                $order_id_url.=' <a href="'.admin_url("post.php?post=".$order."&action=edit").'" target="_blank">'.' #'.$order.'</a>,';
                                                                $cou++;
                                                            }
                                                        }
                                                        echo '<p style="margin-top: 5px;" class="info"><i class="glyphicon glyphicon-shopping-cart"></i> '.__("Total Orders", 'wsdesk').' : '.$order_count.' | '.__("Recent Order", 'wsdesk').' : [ '.rtrim($order_id_url,", ").' ]';
                                                        if($woo_price == "enable")
                                                        {
                                                            echo ' | '.__("Total Purchase", 'wsdesk').' : '. get_woocommerce_currency_symbol().$total_amount.' '. get_woocommerce_currency();
                                                        }
                                                        echo "</p>";
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <p style="margin-top: 5px;" class="info">
                                                            <i class="glyphicon glyphicon-shopping-cart"></i> <?php _e("Total Orders", 'wsdesk'); ?> : 0 | <?php _e("Recent Order", 'wsdesk'); ?> : <?php _e("None", 'wsdesk'); ?> | <?php _e("Total Purchase", 'wsdesk'); ?> : <?php echo get_woocommerce_currency_symbol().'0 '. get_woocommerce_currency(); ?>
                                                        </p>
                                                        <?php
                                                    }
                                                }
                                                else
                                                {
                                                    if($raiser_id != 0)
                                                    {
                                                        $customer_orders = wc_get_orders(array('customer_id'=>$raiser_id));
                                                        $customer_temp_altered = array();
                                                        $customer_temp_original = array();
                                                        foreach ($customer_orders as $key =>$customer_order) {
                                                            array_push($customer_temp_altered, trim(str_replace(' ', '', $customer_order->get_order_number())));
                                                            $order_id = $customer_order->get_id();
                                                            array_push($customer_temp_original, $order_id);
                                                        }
                                                        $customer_orders = $customer_temp_altered;
                                                    }
                                                    if(!empty($customer_orders))
                                                    {
                                                        $order_id_url = "";
                                                        $total_amount = 0;
                                                        $order_count = count($customer_orders);
                                                        $count = 0;
                                                        $cou=0;
                                                        foreach ($customer_orders as $key=>$order) {
                                                            $order_data = wc_get_order($customer_temp_original[$key]);
                                                            if($order_data->get_status() == "completed")
                                                            {
                                                                $total_amount += $order_data->get_total();
                                                            }
                                                            if($cou < 5)
                                                            {
                                                                $order_id_url.=' <a href="'.admin_url("post.php?post=".$customer_temp_original[$key]."&action=edit").'" target="_blank">'.' #'.$order.'</a>,';
                                                                $cou++;
                                                            }
                                                        }
                                                        echo '<p style="margin-top: 5px;" class="info"><i class="glyphicon glyphicon-shopping-cart"></i> '.__("Total Orders", 'wsdesk').' : '.$order_count.' | '.__("Recent Order", 'wsdesk').' : [ '.rtrim($order_id_url,", ").' ]';
                                                        if($woo_price == "enable")
                                                        {
                                                            echo ' | '.__("Total Purchase", 'wsdesk').' : '. get_woocommerce_currency_symbol().$total_amount.' '. get_woocommerce_currency();
                                                        }
                                                        echo "</p>";
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <p style="margin-top: 5px;" class="info">
                                                            <i class="glyphicon glyphicon-shopping-cart"></i> <?php _e("Total Orders", 'wsdesk'); ?> : 0 | <?php _e("Recent Order", 'wsdesk'); ?> : <?php _e("None", 'wsdesk'); ?> | <?php _e("Total Purchase", 'wsdesk'); ?> : <?php echo get_woocommerce_currency_symbol().'0 '. get_woocommerce_currency(); ?>
                                                        </p>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="hidden_ticket_id" value="<?=$ticket_id?>"/>
                            <div class="newMsgFull">
                                <div class="leftFreeSpace">
                                    <div class="icon"><img src="<?php echo get_avatar_url($logged_user->user_email,array('size'=>50)); ?>" style="border-radius: 25px;"></div>
                                    <div class="content">
                                        <div class="message-box">
                                        <?php
                                        if(in_array("reply_tickets",$access))
                                        {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="widget-area no-padding blank" style="width:100%">
                                                        <div class="status-upload">
                                                            <?php if(eh_crm_get_settingsmeta(0, "auto_suggestion") == "enable"){ ?>
                                                            <div id="suggestion">
                                                                <div id="suggestion-form" style='display:none;' class="panel panel-default suggest-form-<?php echo $ticket_id;?>">
                                                                    <ul class="suggest_ul">    
                                                                        <?php
                                                                            if(!empty($response))
                                                                            {
                                                                                for($re=0;$re<count($response);$re++)
                                                                                {
                                                                                    echo '<li class="clickable suggest_li" id="'.$ticket_id.'"><span style="color:black;" id="sug_title">'.$response[$re]['title'].'</span><br><span style="color:blue;" id="sug_url">'.$response[$re]['guid'].'</span></li>';
                                                                                    if($re+1!=count($response))
                                                                                    {
                                                                                        echo "<hr>";
                                                                                    }
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                echo '<li> '.__("No Suggestions", 'wsdesk').' </li>';
                                                                            }
                                                                        ?>
                                                                    </ul>
                                                                </div>                
                                                                <div id="suggestion-tab" class="<?php echo $ticket_id;?>"><?php _e("Suggestions", 'wsdesk'); ?></div>
                                                            </div>
                                                            <?php } $signature = '';
                                                            if(EH_CRM_WSDESK_SIGNATURE_STATUS)
                                                            {
                                                                $signature = '<br><p>--</p>'.get_option('wsdesk_agent_common_signature').get_user_meta( get_current_user_id(), 'wsdesk_agent_signature', true );
                                                            }
                                                            ?>
                                                            <div style="width: 100% !important;height: 200px;" class="reply_textarea" id="reply_textarea_<?php echo $ticket_id; ?>" name="reply_textarea_<?php echo $ticket_id; ?>"><?php echo $signature;?></div> 
                                                            <div class="form-group">
                                                                <div class="input-group col-md-12">
                                                                    <span class="btn btn-primary fileinput-button">
                                                                        <i class="glyphicon glyphicon-plus"></i>
                                                                        <span><?php _e("Attachment", 'wsdesk'); ?></span>
                                                                        <input type="file" name="files" id="files_<?php echo $ticket_id; ?>" class="attachment_reply" multiple="">
                                                                    </span>
                                                                    <div class="btn-group pull-right">
                                                                        <button type="button" class="btn btn-primary dropdown-toggle ticket_reply_action_button_<?php echo $ticket_id; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <?php _e("Submit as", 'wsdesk'); ?> <span class="caret"></span>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <?php
                                                                                for($j=0;$j<count($avail_labels);$j++)
                                                                                {
                                                                                    echo '<li id="'.$ticket_id.'"><a href="#" class="ticket_reply_action" id="'.$avail_labels[$j]['slug'].'">'.__("Submit as", 'wsdesk').' '.$avail_labels[$j]['title'].'</a></li>';
                                                                                }
                                                                            ?>
                                                                            <li role="separator" class="divider"></li>
                                                                            <li id="<?php echo $ticket_id;?>"><a href="#" class="ticket_reply_action" id="note"><?php _e("Submit as Note", 'wsdesk'); ?></a></li>
                                                                            <li class="text-center"><small class="text-muted"><?php _e("Notes visible to Agents and Supervisors", 'wsdesk'); ?></small></li>
                                                                        </ul>
                                                                      </div>
                                                                    <div class="btn-group pull-right" style="padding: 0px;margin-right: 10px;height: 35px;">
                                                                        <button type="button" class="btn btn-primary dropdown-toggle mulitple_ticket_template_button" data-toggle="dropdown">
                                                                            <span class="glyphicon glyphicon-envelope" style="margin-right:5px;"></span> <?php _e('Select Template','wsdesk'); ?> <span class="caret"></span>
                                                                        </button>
                                                                        <ul class="dropdown-menu list-group dropdown-menu-left" id="template_multiple_actions_single_<?php echo $ticket_id;?>" style="min-width:250px" role="menu">
                                                                            <li>
                                                                                <div class="template_div asg">
                                                                                    <div style="visibility: visible;"></div>
                                                                                    <input type="text" class="search_template_single" id="<?php echo $ticket_id; ?>" placeholder="Search Template">
                                                                                    <div class="A0 A0_<?php echo $ticket_id;?>"><span class="glyphicon glyphicon-search"></span></div>
                                                                                </div>
                                                                            </li>
                                                                            <li role="separator" class="divider" style="margin:0px; margin-bottom:5px !important;margin-top: 5px !important;"></li>
                                                                            <?php
                                                                            $avail_templates = eh_crm_get_settings(array("type" => "template"), array("slug", "title", "settings_id"));
                                                                            if(!$avail_templates) $avail_templates = array();
                                                                            if(!empty($avail_templates))
                                                                            {
                                                                                for($i=0;$i<count($avail_templates)&&$i<6;$i++)
                                                                                {
                                                                                    echo '<li class="list-group-item available_template available_template_'.$ticket_id.' '.$avail_templates[$i]['slug'].'_li" id="'.$ticket_id.'" title="'.$avail_templates[$i]['title'].'"> <span style="display: block;" class="truncate multiple_template_action '.$avail_templates[$i]['slug'].'_head" based="single" id="'.$avail_templates[$i]['slug'].'">'.$avail_templates[$i]['title'].'</span></li>';
                                                                                }
                                                                                if($i==6)
                                                                                {
                                                                                    echo '<li role="separator" class="divider available_template available_template_'.$ticket_id.'" style="margin:0px; margin-bottom:5px !important;margin-top: 5px !important;"></li>';
                                                                                    echo '<center><a href="#wsdesk-template-wsdesk-popup-3">'.(count($avail_templates)-6)." more template".((count($avail_templates)-6)==1? ' is':"s are")." there".'</a></center>';

                                                                                }
                                                                            }
                                                                            ?>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="upload_preview_files_<?php echo $ticket_id;?>"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                $reply_id = eh_crm_get_ticket_value_count("ticket_parent",$ticket_id,false,"","","ticket_updated","DESC");
                                array_push($reply_id,array("ticket_id" => $ticket_id));
                                if(EH_CRM_WOO_VENDOR)
                                {
                                   $reply_id = eh_crm_get_ticket_value_count("ticket_parent",$ticket_id,false,"","","ticket_updated","DESC","vendor");
                                   array_push($reply_id,array("ticket_id" => $ticket_id));
                                }
                                for($s=0;$s<count($reply_id);$s++)
                                {
                                    
                                    $quote = '';
                                    $quote_text = '';
                                    if($s==0)
                                    {
                                        $quote = '<span class="button button-info pull-right quote_button" id="'.$ticket_id.'">'.__("Quote", 'wsdesk').'</span>';
                                        $quote_text = 'id="'.$ticket_id.'_quote_text_ticket_content"';
                                    }
                                    $reply_ticket = eh_crm_get_ticket(array("ticket_id"=>$reply_id[$s]['ticket_id']));
                                    $reply_ticket_meta = eh_crm_get_ticketmeta($reply_id[$s]['ticket_id']);
                                    $replier_name ='';
                                    $replier_email =$reply_ticket[0]['ticket_email'];
                                    $replier_pic ='';
                                    if($reply_ticket[0]['ticket_author']!=0)
                                    {
                                        $replier_obj = new WP_User($reply_ticket[0]['ticket_author']);
                                        $replier_name = $replier_obj->display_name;
                                        $replier_pic = get_avatar_url($reply_ticket[0]['ticket_author'],array('size'=>50));
                                    }
                                    else
                                    {
                                        $replier_name = "Guest";
                                        $replier_pic = get_avatar_url($reply_ticket[0]['ticket_email'],array('size'=>50));
                                    }
                                    $attachment = "";
                                    if(isset($reply_ticket_meta['ticket_attachment']))
                                    {
                                        $reply_att = $reply_ticket_meta['ticket_attachment'];
                                        $attachment = '<div>';
                                        for($at=0;$at<count($reply_att);$at++)
                                        {
                                            $current_att = $reply_att[$at];
                                            $att_ext = pathinfo($current_att, PATHINFO_EXTENSION);
                                            if(empty($att_ext))
                                            {
                                               $att_ext=''; 
                                            }
                                            $att_name = pathinfo($current_att, PATHINFO_FILENAME);
                                            $img_ext = array("jpg","jpeg","png","gif");
                                            if(in_array(strtolower($att_ext), $img_ext))
                                            {
                                                $attachment .= '<a href="'.$current_att.'" target="_blank"><img class="img-upload clickable" style="width:200px" title="' .$att_name. '" src="'.$current_att.'"></a></p>';
                                            }
                                            else
                                            {
                                                $check_file_ext = array('doc','docx','pdf','xml','csv','xlsx','xls','txt','zip','mp3','mp4','syx');
                                                if(in_array($att_ext,$check_file_ext))
                                                {
                                                    $attachment .= '<a href="'.$current_att.'" target="_blank" title="' .$att_name. '" class="img-upload"><div class="'.$att_ext.'"></div></a>';
                                                }
                                                else
                                                {
                                                    $attachment .= '<a href="'.$current_att.'" target="_blank" title="' .$att_name. '" class="img-upload"><div class="unknown_type"></div></a>';
                                                }
                                            }
                                        }
                                        $attachment .= '</div>';
                                    }
                                    $color='';
                                    switch ($reply_ticket[0]['ticket_category']) {
                                        case "satisfaction_survey":
                                            if($current_meta['ticket_rating'] == "great")
                                            {
                                                $color = 'background-color: #88fcb6 !important';
                                            }
                                            else
                                            {
                                                $color = 'background-color: #f7aba5 !important';
                                            }
                                            break;
                                        case 'agent_note':
                                            $color = 'background-color: aliceblue!important';
                                            break;
                                        default:
                                            break;
                                    }
                                    echo '<div class="conversation_each" style="'.$color.'">
                                            <div class="leftFreeSpace">
                                            <div class="icon"><img src="'.$replier_pic.'" style="border-radius: 25px;"></div>
                                            <h3>'.$replier_name.'</h3>
                                            <h4>'.$replier_email.' | '.eh_crm_get_formatted_date($reply_ticket[0]['ticket_date']).' </h4>
                                            '.(($reply_ticket[0]['ticket_category'] === 'satisfaction_survey')?'<b>'.__("Satisfaction Comment", 'wsdesk').'</b><br>':'').'    
                                            <p>';

                                                $input_data = ($tickets_display!="text")? html_entity_decode(stripslashes($reply_ticket[0]['ticket_content'])):stripslashes($reply_ticket[0]['ticket_content']);
                                                
                                                $input_array[0] = '/<((html)[^>]*)>(.*)\<\/(html)>/Us';
                                                $input_array[1] = '/<((head)[^>]*)>(.*)\<\/(head)>/Us';
                                                $input_array[2] = '/<((style)[^>]*)>(.*)\<\/(style)>/Us';
                                                $input_array[3] = '/<((body)[^>]*)>(.*)\<\/(body)>/Us';
                                                $input_array[4] = '/<((form)[^>]*)>(.*)\<\/(form)>/Us';
                                                $input_array[5] = '/<((input)[^>]*)>(.*)\<\/(input)>/Us';
                                                $input_array[6] = '/<((input)[^>]*)>/Us';
                                                $input_array[7] = '/<((button)[^>]*)>(.*)\<\/(button)>/Us';
                                                $input_array[8] = '/<((iframe)[^>]*)>(.*)\<\/(iframe)>/Us';
                                                $input_array[9] = '/<((script)[^>]*)>(.*)\<\/(script)>/Us';
                                                $input_array[10] = '/<((ins)[^>]*)>(.*)\<\/(ins)>/Us';
                                                $output_array[0] = '&lt;$1&gt;$3&lt;/html&gt;';
                                                $output_array[1] = '&lt;$1&gt;$3&lt;/head&gt;';
                                                $output_array[2] = '&lt;$1&gt;$3&lt;/style&gt;';
                                                $output_array[3] = '&lt;$1&gt;$3&lt;/body&gt;';
                                                $output_array[4] = '&lt;$1&gt;$3&lt;/form&gt;';
                                                $output_array[5] = '&lt;$1&gt;$3&lt;/input&gt;';
                                                $output_array[6] = '&lt;$1&gt;$3&lt;/input&gt;';
                                                $output_array[7] = '&lt;$1&gt;$3&lt;/button&gt;';
                                                $output_array[8] = '&lt;$1&gt;$3&lt;/iframe&gt;';
                                                $output_array[9] = '&lt;$1&gt;$3&lt;/script&gt;';
                                                $output_array[10] = '&lt;$1&gt;$3&lt;/ins&gt;';
                                                $input_data = preg_replace($input_array, $output_array, $input_data); 
                                                $input_data = str_replace('<script>', '&lt;script&gt;', $input_data);
                                                
                                                echo eh_crm_collapse_ticket_content($input_data);
                                                echo '</p>
                                            '.$attachment.'
                                            </div>
                                        </div>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="wsdesk-template-wsdesk-popup-3" class="wsdesk-overlay">
                <div class="wsdesk-popup">
                    <div class="wsdesk-overlay-success" style="display: none;color:green">
                        <?php _e('Template Added !','wsdesk');?>
                    </div>
                    <h4>Available Templates</h4>
                    <a class="close" href="#">&times;</a>
                    <div class="content">
                        <?php
                            if(!empty($avail_templates))
                            {
                                for($i=0;$i<count($avail_templates);$i++)
                                {
                                    echo '<li class="list-group-item available_template available_template_'.$ticket_id.' '.$avail_templates[$i]['slug'].'_li" id="'.$ticket_id.'" title="'.$avail_templates[$i]['title'].'"> <span style="display: block;" class="truncate multiple_template_action '.$avail_templates[$i]['slug'].'_head" based="single" id="'.$avail_templates[$i]['slug'].'">'.$avail_templates[$i]['title'].'</span></li>';
                                }
                            }?>
                    </div>
                </div>
            </div>
            <?php
            return ob_get_clean();
        }
        
        static function eh_crm_ticket_single_save_props() {
            $ticket_id = sanitize_text_field($_POST['ticket_id']);
            $assignee = ((sanitize_text_field($_POST['assignee']) !== '')?explode(",", sanitize_text_field($_POST['assignee'])):array());
            $tags = ((sanitize_text_field($_POST['tags']) !== '')?explode(",", sanitize_text_field($_POST['tags'])):array());
            $cc = ((sanitize_text_field($_POST['cc']) !== '')?explode(",", sanitize_text_field($_POST['cc'])):array());
            $bcc = ((sanitize_text_field($_POST['bcc']) !== '')?explode(",", sanitize_text_field($_POST['bcc'])):array());
            $input = json_decode(stripslashes(sanitize_text_field($_POST['input'])), true);
            eh_crm_update_ticketmeta($ticket_id, "ticket_assignee", $assignee);
            eh_crm_update_ticketmeta($ticket_id, "ticket_tags", $tags);
            eh_crm_update_ticketmeta($ticket_id, "ticket_cc", $cc,false);
            eh_crm_update_ticketmeta($ticket_id, "ticket_bcc", $bcc,false);
            foreach ($input as $key => $value) {
                if($key == 'woo_vendors')
                {
                    $vendor = str_replace("v_","",$value);
                    eh_crm_update_ticket($ticket_id, array("ticket_vendor"=>$vendor));
                }
                eh_crm_update_ticketmeta($ticket_id, $key, $value,false);
            }
        }
        
        static function eh_crm_ticket_single_delete() {
            $ticket_id = sanitize_text_field($_POST['ticket_id']);
            $child = eh_crm_get_ticket_value_count("ticket_parent", $ticket_id);
            for($i=0;$i<count($child);$i++)
            {
                eh_crm_trash_ticket($child[$i]['ticket_id']);
            }
            eh_crm_trash_ticket($ticket_id);
        }
        
        static function eh_crm_ticket_multiple_delete() {
            $tickets_id = json_decode(stripslashes(sanitize_text_field($_POST['tickets_id'])), true);
            for($i=0;$i<count($tickets_id);$i++)
            {
                $child = eh_crm_get_ticket_value_count("ticket_parent", $tickets_id[$i]);
                for($j=0;$j<count($child);$j++)
                {
                    eh_crm_trash_ticket($child[$j]['ticket_id']);
                }
                eh_crm_trash_ticket($tickets_id[$i]);
            }
        }
        
        static function eh_crm_settings_empty_trash()
        {
            ini_set('max_execution_time', 300);
            global $wpdb;
            $table = $wpdb->prefix . 'wsdesk_tickets';
            $query = "select ticket_id from $table WHERE ticket_trash = 1 AND ticket_parent=0";
            $tickets_id = $wpdb->get_results($query, ARRAY_A);
            if (!$tickets_id) {
                die(json_encode(array('result'=>'failed','alert'=>__('No tickets in trash','wsdesk'))));
            }
            for($i=0;$i<count($tickets_id);$i++)
            {
                $query = "select ticket_id from $table WHERE ticket_parent=".$tickets_id[$i]['ticket_id'];
                $child = $wpdb->get_results($query, ARRAY_A);
                for($j=0;$j<count($child);$j++)
                {
                    eh_crm_delete_ticket($child[$j]['ticket_id']);
                }
                eh_crm_delete_ticket($tickets_id[$i]['ticket_id']);
            }
            die(json_encode(array('result'=>'success')));
        }
        
        static function eh_crm_settings_restore_trash()
        {
            ini_set('max_execution_time', 300);
            global $wpdb;
            $table = $wpdb->prefix . 'wsdesk_tickets';
            $query = "select ticket_id from $table WHERE ticket_trash = 1 AND ticket_parent=0";
            $tickets_id = $wpdb->get_results($query, ARRAY_A);
            if (!$tickets_id) {
                die(json_encode(array('result'=>'failed','alert'=>__('No tickets in trash','wsdesk'))));
            }
            for($i=0;$i<count($tickets_id);$i++)
            {
                $query = "select ticket_id from $table WHERE ticket_parent=".$tickets_id[$i]['ticket_id'];
                $child = $wpdb->get_results($query, ARRAY_A);
                for($j=0;$j<count($child);$j++)
                {
                    eh_crm_restore_trash_ticket($child[$j]['ticket_id']);
                }
                eh_crm_restore_trash_ticket($tickets_id[$i]['ticket_id']);
            }
            die(json_encode(array('result'=>'success')));
        }
        
        static function eh_crm_export_ticket_data()
        {
            $start_date =  strtotime(sanitize_text_field($_POST['export_start_date']));
            $end_date = strtotime(sanitize_text_field($_POST['export_end_date']));
            if(!$start_date)
            {
                $start_date =0;
            }
            if(!$end_date)
            {
                $end_date = time();
            }
            $tickets_data = eh_crm_get_ticket(array("ticket_parent"=>0));
            
            $args = array("type" => "label");
            $fields = array("slug","title","settings_id");
            $avail_labels= eh_crm_get_settings($args,$fields);

            $args = array("type" => "field");
            $fields = array("slug","title","settings_id");
            $avail_fields = eh_crm_get_settings($args,$fields);

            $args = array("type" => "tag");
            $fields = array("slug","title","settings_id");
            $avail_tags = eh_crm_get_settings($args,$fields);
            
            $first_row = array(
                __("Ticket ID", "wsdesk"),
                __("Requester E-mail", "wsdesk"),
                __("Subject", "wsdesk"),
                __("Content", "wsdesk"),
                __("Status", "wsdesk"),
                __("Date","wsdesk"),
                __("Last Updated","wsdesk"),
                __("Satisfaction Rating","wsdesk"),
                __("Tags", "wsdesk"),
                __("Assignee", "wsdesk")
            );
            foreach ($avail_fields as $value) {
                if($value['slug'] != "request_email" && $value['slug'] != "request_title" && $value['slug'] != "request_description")
                {
                    array_push($first_row, $value['title']);
                }
            }
            $file = fopen('php://output', 'w');
            fputcsv($file, $first_row);
            for($i=0; $i < count($tickets_data); $i++)
            {
                $new_row = array();
                if(strtotime($tickets_data[$i]['ticket_date']) >= $start_date && strtotime($tickets_data[$i]['ticket_date']) <= ($end_date + (60*60*24)))
                {
                    $current_meta = eh_crm_get_ticketmeta($tickets_data[$i]['ticket_id']);

                    //get the label name
                    foreach ($avail_labels as $value) {
                        if($value['slug'] == $current_meta['ticket_label'])
                        {
                            $label = $value['title'];
                            break;
                        }
                    }

                    //get the satisfaction rating
                    if(isset($current_meta['ticket_rating']))
                    {
                        $satisfaction_survey = __(ucfirst($current_meta['ticket_rating']), "wsdesk");
                    }
                    else
                    {
                        $satisfaction_survey = '-';
                    }

                    //get the tag names
                    $tags = array();
                    foreach ($avail_tags as $value) {
                        if(in_array($value['slug'], $current_meta['ticket_tags']))
                        {
                            array_push($tags, $value['title']);
                        }
                    }
                    $tags = implode(', ', $tags);

                    //get assignee names
                    $assignees = array();
                    foreach ($current_meta['ticket_assignee'] as $value) {
                        $user = get_user_by('id', $value);
                        if(!empty($user))
                        {
                            array_push($assignees, $user->display_name);
                        }
                    }
                    $assignees = implode(', ', $assignees);

                    $new_row = array(
                        $tickets_data[$i]['ticket_id'],
                        $tickets_data[$i]['ticket_email'],
                        $tickets_data[$i]['ticket_title'],
                        $tickets_data[$i]['ticket_content'],
                        $label,
                        $tickets_data[$i]['ticket_date'],
                        $tickets_data[$i]['ticket_updated'],
                        $satisfaction_survey,
                        $tags,
                        $assignees
                    );
                    foreach ($avail_fields as $value) {
                        if($value['slug'] != "request_email" && $value['slug'] != "request_title" && $value['slug'] != "request_description")
                        {
                            $field_meta = eh_crm_get_settingsmeta($value['settings_id']);
                            if(isset($current_meta[$value['slug']]))
                            {
                                switch ($field_meta['field_type']) {
                                    case "text":
                                    case "number":
                                    case "email":
                                    case "password":
                                    case 'textarea':
                                    case 'date':
                                    case 'ip':
                                    case 'phone':
                                        array_push($new_row, $current_meta[$value['slug']]);
                                        break;
                                    case 'select':
                                        if($value['slug'] == 'woo_order_id')
                                        {
                                            array_push($new_row, $current_meta[$value['slug']]);
                                        }
                                        else
                                        {
                                            array_push($new_row, $field_meta['field_values'][$current_meta[$value['slug']]]);
                                        }
                                        break;
                                    case "radio":
                                    case 'woo_product':
                                    case 'woo_category':
                                    case 'woo_tags':
                                    case 'woo_vendors':
                                        array_push($new_row, $field_meta['field_values'][$current_meta[$value['slug']]]);
                                        break;
                                    case "checkbox":
                                        $checkbox_values = array();
                                        foreach($current_meta[$value['slug']] as $a)
                                        {
                                            array_push($checkbox_values, $field_meta['field_values'][$a]);
                                        }
                                        array_push($new_row, implode(', ', $checkbox_values));
                                        break;
                                }
                            }
                        }
                    }
                    fputcsv($file, $new_row);
                }
            }
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="'.time().'-report.csv"');
            print($file);
            die();
        }
        
        static function eh_crm_ticket_refresh_left_bar() {
            $active = isset($_POST['active'])?$_POST['active']:'all';
            ob_start();
            $label_args = array("type" => "label", "filter" => "yes");
            $label_fields = array("slug", "title", "settings_id");
            $avail_labels = eh_crm_get_settings($label_args, $label_fields);
            $tag_args = array("type" => "tag", "filter" => "yes");
            $tag_fields = array("slug", "title", "settings_id");
            $avail_tags = eh_crm_get_settings($tag_args, $tag_fields);
            $user_roles_default = array("WSDesk_Agents", "WSDesk_Supervisor","administrator");
            $users = get_users(array("role__in" => $user_roles_default));
            $users_data = array();
            for ($i = 0; $i < count($users); $i++) {
                $current = $users[$i];
                $id = $current->ID;
                $user = new WP_User($id);
                $users_data[$i]['id'] = $id;
                $users_data[$i]['name'] = $user->display_name;
                $users_data[$i]['caps'] = $user->caps;
                $users_data[$i]['email'] = $user->user_email;
            }
            if(!isset($_COOKIE['collapsed_views']))
            {
                $collapsed_views = array();
            }
            else
            {
                $collapsed_views = stripslashes($_COOKIE['collapsed_views']);
                $collapsed_views = str_replace('"', '', $collapsed_views);
                $collapsed_views = str_replace('[', '', $collapsed_views);
                $collapsed_views = str_replace(']', '', $collapsed_views);
                $collapsed_views = explode(",",$collapsed_views);
            }
            ?>
                <ul class="nav nav-pills nav-stacked side-bar-filter" id="all_section">
                    <li class="<?php echo (($active == "all")?"active":""); ?>"><a href="#" id="all"><span class="badge pull-right"><?php echo count(eh_crm_get_ticket_value_count("ticket_parent",0)); ?></span> <?php _e("All Tickets", 'wsdesk'); ?> </a></li>
                </ul>
                <?php 
                $cus_view = 0;
                $view_html = "";
                $avail_views = eh_crm_get_settingsmeta(0, "selected_views");
                $avail_views = ($avail_views == FALSE)?array():$avail_views;
                foreach ($avail_views as $view) {
                    switch ($view) {
                        case "labels_view":
                            $labels_collapsed = false;
                            if(in_array('labels', $collapsed_views))
                                $labels_collapsed = true;
                            ?>
                            <hr>
                            <h4>
                                <?php _e('Status','wsdesk'); ?>
                                <span class="spinner_loader labels_loader">
                                    <span class="bounce1"></span>
                                    <span class="bounce2"></span>
                                    <span class="bounce3"></span>
                                </span>
                                <span id="labels_collapse" class="glyphicon glyphicon-chevron-up" style="float:right; <?php echo ($labels_collapsed)?'display: none;':'';?>" onclick="collapse('labels');"></span>
                                <span id="labels_drop" class="glyphicon glyphicon-chevron-down" style="float:right; <?php echo ($labels_collapsed)?'': 'display: none;';?>" onclick="drop('labels');">
                            </h4>
                            <ul class="nav nav-pills nav-stacked side-bar-filter" id="labels" <?php echo ($labels_collapsed)?"style='display: none;'":"";?> >
                                <?php
                                    for ($i = 0; $i < count($avail_labels); $i++) {
                                        $label_color = eh_crm_get_settingsmeta($avail_labels[$i]['settings_id'], "label_color");
                                        $current_label_count=eh_crm_get_ticketmeta_value_count("ticket_label",$avail_labels[$i]['slug']);
                                        echo '<li class="'.(($active == $avail_labels[$i]['slug'])?"active":"").'"><a href="#" id="'.$avail_labels[$i]['slug'].'"><span class="badge pull-right" style="background-color:' . $label_color . ' !important;">'.count($current_label_count).'</span> '.$avail_labels[$i]['title'].' </a></li>';
                                    }
                                ?>
                            </ul>
                            <?php
                            break;
                        case "agents_view":
                            if(!empty($users_data))
                            {
                                $agents_collapsed = false;
                                if(in_array('agents', $collapsed_views))
                                    $agents_collapsed = true;
                                ?>
                                <hr>
                                <h4>
                                    <?php _e('Agents','wsdesk'); ?>
                                    <span class="spinner_loader agents_loader">
                                        <span class="bounce1"></span>
                                        <span class="bounce2"></span>
                                        <span class="bounce3"></span>
                                    </span>
                                    <span id="agents_collapse" class="glyphicon glyphicon-chevron-up" style="float:right; <?php echo ($agents_collapsed)?'display: none;':'';?>" onclick="collapse('agents');"></span>
                                    <span id="agents_drop" class="glyphicon glyphicon-chevron-down" style="float:right; <?php echo ($agents_collapsed)?'': 'display: none;';?>" onclick="drop('agents');">
                                </h4>
                                <ul class="nav nav-pills nav-stacked side-bar-filter" id="agents" <?php echo ($agents_collapsed)?"style='display: none;'":"";?>>
                                    <?php
                                        $user_id_agent = get_current_user_id();
                                        $user_id_agent_details = get_user_by("ID", $user_id_agent);
                                        $user_id_agent_role = $user_id_agent_details->roles;
                                        $allow_agent_tickets = eh_crm_get_settingsmeta('0', "allow_agent_tickets");
                                        if($allow_agent_tickets != 'enable'){
                                            if(in_array("WSDesk_Agents", $user_id_agent_role))
                                            {
                                                for ($i = 0; $i < count($users_data); $i++) {
                                                    if($user_id_agent == $users_data[$i]['id']){
                                                       $current_agent_count=eh_crm_get_ticketmeta_value_count("ticket_assignee",$users_data[$i]['id']);
                                                        echo '<li><a href="#" id="'.$users_data[$i]['id'].'"><span class="badge pull-right">'.count($current_agent_count).'</span> '.$users_data[$i]['name'].' </a></li>'; 
                                                    }
                                                }
                                            }else{
                                                for ($i = 0; $i < count($users_data); $i++) {
                                                    $current_agent_count=eh_crm_get_ticketmeta_value_count("ticket_assignee",$users_data[$i]['id']);
                                                    echo '<li><a href="#" id="'.$users_data[$i]['id'].'"><span class="badge pull-right">'.count($current_agent_count).'</span> '.$users_data[$i]['name'].' </a></li>'; 
                                                }
                                            }
                                        }else{
                                            for ($i = 0; $i < count($users_data); $i++) {
                                                $current_agent_count=eh_crm_get_ticketmeta_value_count("ticket_assignee",$users_data[$i]['id']);
                                                echo '<li><a href="#" id="'.$users_data[$i]['id'].'"><span class="badge pull-right">'.count($current_agent_count).'</span> '.$users_data[$i]['name'].' </a></li>'; 
                                            }
                                        }
                                        
                                        $current_agent_count=eh_crm_get_ticketmeta_value_count("ticket_assignee",array());
                                    ?>
                                    <li class="<?php echo (($active == "unassigned")?"active":"");?>"><a href="#" id="unassigned"><span class="badge pull-right"><?php echo count($current_agent_count);?></span> <?php _e("Unassigned", 'wsdesk'); ?> </a></li>
                                </ul>
                                <?php 
                            }
                            break;
                        case "tags_view";
                            if(!empty($avail_tags))
                            {
                                $tags_collapsed = false;
                                if(in_array('tags', $collapsed_views))
                                    $tags_collapsed = true;
                                ?>
                                <hr>
                                <h4>
                                    <?php _e('Tags','wsdesk'); ?>
                                    <span class="spinner_loader tags_loader">
                                        <span class="bounce1"></span>
                                        <span class="bounce2"></span>
                                        <span class="bounce3"></span>
                                    </span>
                                    <span id="tags_collapse" class="glyphicon glyphicon-chevron-up" style="float:right; <?php echo ($tags_collapsed)?'display: none;':'';?>" onclick="collapse('tags');"></span>
                                    <span id="tags_drop" class="glyphicon glyphicon-chevron-down" style="float:right; <?php echo ($tags_collapsed)?'': 'display: none;';?>" onclick="drop('tags');">
                                </h4>
                                <ul class="nav nav-pills nav-stacked side-bar-filter" id="tags" <?php echo ($tags_collapsed)?"style='display: none;'":"";?>>
                                    <?php
                                        for ($i = 0; $i < count($avail_tags); $i++) {
                                            $current_tags_count=eh_crm_get_ticketmeta_value_count("ticket_tags",$avail_tags[$i]['slug']);
                                            echo '<li class="'.(($active == $avail_tags[$i]['slug'])?"active":"").'"><a href="#" id="'.$avail_tags[$i]['slug'].'"><span class="badge pull-right">'.count($current_tags_count).'</span> '.$avail_tags[$i]['title'].' </a></li>';
                                        }
                                    ?>
                                </ul>
                                <?php 
                            }
                            break;
                        case "users_view":
                            $users_collapsed = false;
                            if(in_array('users', $collapsed_views))
                                $users_collapsed = true;
                            ?>
                            <hr>
                            <h4>
                                <?php _e('Users','wsdesk'); ?>
                                <span class="spinner_loader users_loader">
                                    <span class="bounce1"></span>
                                    <span class="bounce2"></span>
                                    <span class="bounce3"></span>
                                </span>
                                <span id="users_collapse" class="glyphicon glyphicon-chevron-up" style="float:right; <?php echo ($users_collapsed)?'display: none;':'';?>" onclick="collapse('users');"></span>
                                <span id="users_drop" class="glyphicon glyphicon-chevron-down" style="float:right; <?php echo ($users_collapsed)?'': 'display: none;';?>" onclick="drop('users');">
                            </h4>
                            <ul class="nav nav-pills nav-stacked side-bar-filter" id="users" <?php echo ($users_collapsed)?"style='display: none;'":"";?>>
                                <?php
                                    $registered_count = eh_crm_get_ticket_value_count("ticket_author",0,true,"ticket_parent",0);
                                    echo '<li class="'.(($active == "registeredU")?"active":"").'"><a href="#" id="registeredU" class="user_section"><span class="badge pull-right">'.count($registered_count).'</span> '.__("Registered Users", 'wsdesk').' </a></li>';
                                    $guest_count = eh_crm_get_ticket_value_count("ticket_author",0,false,"ticket_parent",0);
                                    echo '<li class="'.(($active == "guestU")?"active":"").'"><a href="#" id="guestU" class="user_section"><span class="badge pull-right">'.count($guest_count).'</span> '.__("Guest Users", 'wsdesk').' </a></li>';
                                ?>
                            </ul>
                            <?php
                            break;
                        default:
                            $view_set = eh_crm_get_settings(array("slug"=>$view,"type"=>"view"),array("slug","settings_id","title"));
                            $view_set_meta = eh_crm_get_settingsmeta($view_set[0]['settings_id']);
                            $log_id   = get_current_user_id();
                            $log_user = get_user_by("ID", $log_id);
                            $log_role = $log_user->roles;
                            $current_role = "";
                            if(in_array("WSDesk_Agents", $log_role))
                            {
                                $current_role = "WSDesk_Agents";
                            }
                            if(in_array("WSDesk_Supervisor", $log_role))
                            {
                                $current_role = "WSDesk_Supervisor";
                            }
                            if(in_array("administrator", $log_role))
                            {
                                $current_role = "administrator";
                            }
                            if(in_array($current_role, $view_set_meta['view_access']))
                            {
                                $views_collapsed = false;
                                if(in_array('views', $collapsed_views))
                                    $views_collapsed = true;
                                $view_count = eh_crm_get_view_tickets($view);
                                $view_html.='<ul class="nav nav-pills nav-stacked side-bar-filter" id="views"';
                                $view_html.=($views_collapsed)?' style="display: none;" ':"";
                                $view_html.='><li class="'.(($active==$view)?'active':'').'"><a href="#" id="'.$view.'"><span class="badge pull-right">'.count($view_count).'</span> '.$view_set[0]['title'].' </a></li>
                                </ul>';
                                $cus_view++;
                            }
                            break;
                    }
                }
                if($cus_view != 0)
                {
                    $views_collapsed = false;
                    if(in_array('views', $collapsed_views))
                        $views_collapsed = true;
                    ?>
                    <hr>
                    <h4>
                    Ticket Views
                        <span class="spinner_loader views_loader">
                            <span class="bounce1"></span>
                            <span class="bounce2"></span>
                            <span class="bounce3"></span>
                        </span>
                        <span id="views_collapse" class="glyphicon glyphicon-chevron-up" style="float:right; <?php echo ($views_collapsed)?'display: none;':'';?>" onclick="collapse('views');"></span>
                        <span id="views_drop" class="glyphicon glyphicon-chevron-down" style="float:right; <?php echo ($views_collapsed)?'': 'display: none;';?>" onclick="drop('views');">
                    </h4>
                    <?php
                    echo $view_html;
                }
            $content = ob_get_clean();
            die($content);
        }
        
        static function eh_crm_ticket_refresh_right_bar() {
            $search_page=(isset($_POST['cur']))?$_POST['cur']:1;
            $active = isset($_POST['active'])?$_POST['active']:'all';
            $order = isset($_POST['order'])?$_POST['order']:'DESC';
            $order_by = isset($_POST['order_by'])?$_POST['order_by']:'ticket_updated';
            $current_page_no = (isset($_POST['current_page']))?$_POST['current_page']:0;
            $current_page_n = (isset($_POST['current_pa']))?$_POST['current_pa']:"$search_page";
            $pagination = isset($_POST['pagination_type'])?$_POST['pagination_type']:'';
            $avail_labels_wf = eh_crm_get_settings(array("type" => "label"), array("slug", "title", "settings_id"));
            $avail_labels =eh_crm_get_settings(array("type" => "label", "filter" => "yes"), array("slug", "title", "settings_id"));
            $avail_tags_wf = eh_crm_get_settings(array("type" => "tag"), array("slug", "title", "settings_id"));
            $avail_tags = eh_crm_get_settings(array("type" => "tag", "filter" => "yes"), array("slug", "title", "settings_id"));
            $avail_views = eh_crm_get_settings(array("type" => "view"), array("slug", "title", "settings_id"));
            $user_roles_default = array("WSDesk_Agents", "WSDesk_Supervisor","administrator");
            $users = get_users(array("role__in" => $user_roles_default));
            $users_data = array();
            $tickets_display = eh_crm_get_settingsmeta('0', "tickets_display");
            for ($i = 0; $i < count($users); $i++) {
                $current = $users[$i];
                $id = $current->ID;
                $user = new WP_User($id);
                $users_data[$i]['id'] = $id;
                $users_data[$i]['name'] = $user->display_name;
                $users_data[$i]['caps'] = $user->caps;
                $users_data[$i]['email'] = $user->user_email;
            }
            $ticket_rows = eh_crm_get_settingsmeta(0, "ticket_rows");
             if($ticket_rows=="")
            {
                $ticket_rows=25;
            }
            $current_page=$current_page_no;
            $offset = ($current_page)* $ticket_rows; 
            if($pagination != "")
            {
                switch ($pagination) {
                    case "current_page_n":
                        if($current_page_n!="")
                        {
                            $current_page_n=$current_page_n-1;
                            $total=count(eh_crm_get_ticket_value_count("ticket_parent",0));
                            if($ticket_rows%2==0)
                            {
                                if($current_page_n<=($total/$ticket_rows)-1)
                                    {
                            
                                        $current_pa=$current_page_n*$ticket_rows;
                                        $current_page=$current_page_n;
                                        $offset=$current_pa;
                                

                                        }
                                else
                                {
                                    $last_page=($total/$ticket_rows);
                                    if(is_float($last_page))
                                    {
                                        $last_page=$last_page+1;
                                    }
                            
                                    $current_page=intval($last_page);
                                    $current_page=$current_page-1;
                                
                                    $offset=($current_page)*$ticket_rows;
                                    break;
                                    }
                            }
                            if($ticket_rows%2!=0)
                            {
                                if($current_page_n<=intval($total/$ticket_rows)-1)
                                    {
                                        $current_pa=$current_page_n*$ticket_rows;
                                        $current_page=$current_page_n;
                                        $offset=$current_pa;
                                    }
                                else
                                {
                                    $last_page=$total/$ticket_rows;
                                    $current_page=intval($last_page);
                                    $current_page=$current_page;
                                    $offset=($current_page)*$ticket_rows;
                                    break;
                                }
                            }
                        }
                        else
                        {
                           
                            $offset=$current_page*$ticket_rows;
                            $current_page=$current_page_no;
                        }
                            break;
                    case "prev":
                            $current_page = $current_page_no-1;
                            $offset = ($current_page * $ticket_rows);
                            break;
                    case "next":

                            $current_page = $current_page_no+1;
                            $offset =($current_page * $ticket_rows);
                            break;
                }
            }
            
            switch ($active) {
                case "all":
                    $table_title = __("All Tickets", 'wsdesk');
                    $total_count = count(eh_crm_get_ticket_value_count("ticket_parent",0));
                    $section_tickets_id = eh_crm_get_ticket_value_count("ticket_parent",0,false,"","",$order_by,$order,$ticket_rows,$offset);
                    $all_section_ids = eh_crm_get_ticket_value_count("ticket_parent",0,false,"","",$order_by,$order,"",0);
                    break;
                case "registeredU":
                    $table_title = __('Registered Users Tickets', 'wsdesk');
                    $total_count = count(eh_crm_get_ticket_value_count("ticket_author",0,TRUE,"ticket_parent",0));
                    $section_tickets_id = eh_crm_get_ticket_value_count("ticket_author",0,TRUE,"ticket_parent",0,$order_by,$order,$ticket_rows,$offset);
                    $all_section_ids = eh_crm_get_ticket_value_count("ticket_author",0,TRUE,"ticket_parent",0,$order_by,$order,"",0);
                    break;
                case "guestU":
                    $table_title = __('Guest Users Tickets', 'wsdesk');
                    $total_count = count(eh_crm_get_ticket_value_count("ticket_author",0,FALSE,"ticket_parent",0));
                    $section_tickets_id = eh_crm_get_ticket_value_count("ticket_author",0,false,"ticket_parent",0,$order_by,$order,$ticket_rows,$offset);
                    $all_section_ids = eh_crm_get_ticket_value_count("ticket_author",0,false,"ticket_parent",0,$order_by,$order,"",0);
                    break;
                case "unassigned":
                    $table_title = __('Unassigned Tickets', 'wsdesk');
                    $total_count = count(eh_crm_get_ticketmeta_value_count("ticket_assignee",array(),"ticket_id"));
                    $section_tickets_id = eh_crm_get_ticketmeta_value_count("ticket_assignee",array(),$order_by,$order,$ticket_rows,$offset);
                    $all_section_ids = eh_crm_get_ticketmeta_value_count("ticket_assignee",array(),$order_by,$order,0,0);
                    break;
                default:
                    if (strpos($active, 'label_') !== false) 
                    {
                        for($i=0;$i<count($avail_labels);$i++)
                        {
                            if($avail_labels[$i]['slug'] == $active)
                            {
                                $table_title = $avail_labels[$i]['title'];
                            }
                        }
                        if(empty($table_title))
                        {
                            $table_title = "(Incorrect Deep Link)";
                        }
                        $table_title = $table_title . ' Tickets';
                        $total_count = count(eh_crm_get_ticketmeta_value_count("ticket_label",$active,"ticket_id"));
                        $section_tickets_id = eh_crm_get_ticketmeta_value_count("ticket_label",$active,$order_by,$order,$ticket_rows,$offset);
                        $all_section_ids = eh_crm_get_ticketmeta_value_count("ticket_label",$active,$order_by,$order,0,0);
                    } 
                    elseif (strpos($active, 'tag_') !== false) 
                    {
                        for($i=0;$i<count($avail_tags);$i++)
                        {
                            if($avail_tags[$i]['slug'] == $active)
                            {
                                $table_title = $avail_tags[$i]['title'];
                            }
                        }
                        if(empty($table_title))
                        {
                            $table_title = "(Incorrect Deep Link)";
                        }
                        $table_title = $table_title . ' Tickets';
                        $total_count = count(eh_crm_get_ticketmeta_value_count("ticket_tags",$active,"ticket_id"));
                        $section_tickets_id = eh_crm_get_ticketmeta_value_count("ticket_tags",$active,$order_by,$order,$ticket_rows,$offset);
                        $all_section_ids = eh_crm_get_ticketmeta_value_count("ticket_tags",$active,$order_by,$order,0,0);
                    }
                    elseif (strpos($active, 'view_') !== false) 
                    {
                        for($i=0;$i<count($avail_views);$i++)
                        {
                            if($avail_views[$i]['slug'] == $active)
                            {
                                $table_title = $avail_views[$i]['title'];
                            }
                        }
                        if(empty($table_title))
                        {
                            $table_title = "(Incorrect Deep Link)";
                        }
                        $table_title = $table_title . ' Tickets';
                        $total_count = count(eh_crm_get_view_tickets($active));
                        
                        $section_tickets_id = eh_crm_get_view_tickets($active,$ticket_rows,$offset);
                        $all_section_ids = eh_crm_get_view_tickets($active);
                    }
                    else 
                    {
                        for($i=0;$i<count($users_data);$i++)
                        {
                            if($users_data[$i]['id'] == $active)
                            {
                                $table_title = $users_data[$i]['name'];
                            }
                        }
                        if(empty($table_title))
                        {
                            $table_title = "(Incorrect Deep Link)";
                        }
                        $table_title = $table_title . ' Tickets';
                        $total_count = count(eh_crm_get_ticketmeta_value_count("ticket_assignee",$active,"ticket_id"));
                        $section_tickets_id = eh_crm_get_ticketmeta_value_count("ticket_assignee",$active,$order_by,$order,$ticket_rows,$offset);
                        $all_section_ids = eh_crm_get_ticketmeta_value_count("ticket_assignee",$active,$order_by,$order,0,0);
                    }
                    break;
            }
            $avail_caps = array("reply_tickets","delete_tickets","manage_tickets");
            $access = array();
            $logged_user = wp_get_current_user();
            $logged_user_caps = array_keys($logged_user->caps);
            if(!in_array("administrator", $logged_user->roles))
            {
                for($i=0;$i<count($logged_user_caps);$i++)
                {
                    if(!in_array($logged_user_caps[$i], $avail_caps))
                    {
                        unset($logged_user_caps[$i]);
                    }
                }
                $access = $logged_user_caps;
            }
            else
            {
                $access = $avail_caps;
            }
            $pagination_ids = array();
            foreach ($all_section_ids as $tic) {
                array_push($pagination_ids,$tic['ticket_id']);
            }
            $all_ticket_field_views = eh_crm_get_settingsmeta("0", "all_ticket_page_columns");
            $custom_table_headers = array();
            $default_columns = array('id', 'requestor', 'subject', 'requested', 'assignee', 'feedback');
            if($all_ticket_field_views ===  false)
            {
                $all_ticket_field_views =  $default_columns;
                eh_crm_update_settingsmeta("0", "all_ticket_page_columns", $default_columns);
            }
            if(!empty($all_ticket_field_views))
            {
                foreach ($all_ticket_field_views as  $all_ticket_field) {
                    if(in_array($all_ticket_field, $default_columns))
                    {
                        switch($all_ticket_field)
                        {
                            case 'id':
                                if($order_by == 'ticket_id')
                                {
                                    if($order == 'ASC')
                                    {
                                         array_push($custom_table_headers, '<div class="row" style="margin-left: 0px; ">#'.'<span class="dashicons dashicons-arrow-up sort-icon" id="id" style="margin-left: 5px;"></span></div>');
                                    }
                                    else
                                    {
                                         array_push($custom_table_headers, '<div class="row" style="margin-left: 0px; ">#'.'<span class="dashicons dashicons-arrow-down sort-icon" id="id" style="margin-left: 5px;"></span></div>');
                                    }
                                }
                                else
                                {
                                    array_push($custom_table_headers, '<div class="row" style="margin-left: 0px; ">#'.'<span class="dashicons dashicons-sort sort-icon" id="id" style="margin-left: 5px;"></span></div>');
                                }
                                break;
                            case 'subject':
                                if($order_by == 'ticket_title')
                                {
                                    if($order == 'ASC')
                                    {
                                        array_push($custom_table_headers, '<div class="row">'.ucfirst($all_ticket_field).'<span class="dashicons dashicons-arrow-up sort-icon" id="subject" style="margin-left: 5px"></span></div>');
                                    }
                                    else{
                                        array_push($custom_table_headers, '<div class="row">'.ucfirst($all_ticket_field).'<span class="dashicons dashicons-arrow-down sort-icon" id="subject" style="margin-left: 5px"></span></div>');
                                    }   
                                }
                                else
                                {
                                    array_push($custom_table_headers, '<div class="row">'.ucfirst($all_ticket_field).'<span class="dashicons dashicons-sort sort-icon" id="subject" style="margin-left: 5px"></span></div>');
                                }
                                break;
                            default:
                                 array_push($custom_table_headers, ucfirst($all_ticket_field));
                        }
                    }
                    else
                    {
                        $fields = eh_crm_get_settings(array('slug' => $all_ticket_field), 'title');
                        array_push($custom_table_headers, $fields[0]['title']);
                    }
                }
                
            }
            ?>
            <input type="hidden" id="pagination_ids_traverse" value="<?php echo htmlentities(json_encode($pagination_ids))?>">
            <div class="panel panel-default tickets_panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $table_title;?>
                        <span class="spinner_loader table_loader">
                            <span class="bounce1"></span>
                            <span class="bounce2"></span>
                            <span class="bounce3"></span>
                        </span>
                    </h3>
                    <div class="pull-right">
                        <span class="clickable filter" data-toggle="wsdesk_tooltip" title="<?php _e("Quick Filter for Tickets",'wsdesk');?>"data-container="body">
                            <i class="glyphicon glyphicon-filter"></i>
                        </span>
                    </div>
                    <div class="pull-right" style="margin: -25px 0px 0px 0px;">
                        <span class="text-muted"><b><?php $page_number=$current_page;echo (($current_page>0)&&($current_page*$ticket_rows)<=$total_count)?((($current_page)*$ticket_rows)+1):"1"; ?></b>–<b><?php echo(($current_page>0)&&($current_page*$ticket_rows)<=$total_count)?($current_page*$ticket_rows)+count($section_tickets_id):("$ticket_rows");?></b> of <b><?php echo $total_count; ?></b></span>
                        <?php if($page_number>=0&&$page_number<($total_count/$ticket_rows)){
                            $page_number=$current_page+1;
                            $current_page=$current_page;
                        }
                        elseif($page_number>=($total_count/$ticket_rows))
                        {
                            $page_number=$current_page;
                            $current_page=$page_number;
                        }
                        ?>
                        <input type="number" name="cur" id="current_page_n" class="btn btn-default pagination_tic" placeholder="<?php _e("$page_number",'wsdesk')?>"min=1 title="<?php _e('Page Number', 'wsdesk');  ?> "
                        oninput="validity.valid||(value='');" style="width:65px;height:30px" />
                        <div class="btn-group btn-group-sm" style="margin:1px 0px 0px 0px;">
                            <?php
                                    //To Hide the preview and next buttons for first and lastpages of tickets
                                    if($current_page != 0)
                                    {

                                        ?>
                                            <button type="button"  class="btn btn-default pagination_tickets" id="prev" title="<?php _e('Previous', 'wsdesk'); ?> <?php echo $ticket_rows?>" data-container="body">
                                                <span class="glyphicon glyphicon-chevron-left"></span>
                                            </button>
                                        <?php
                                    }
                            ?>   
                            <?php

                                    if($current_page == 0)
                                    {

                                        ?>
                                            <button type="button"  class="btn btn-default pagination_tick" id="pre" title="<?php _e('Beginning of the Page', 'wsdesk');  ?> "style="color:#AFAFAF; " data-container="body">
                                                <span class="glyphicon glyphicon-chevron-left"></span>
                                            </button>
                                        <?php
                                    }
                            ?>                                             
                            <input type="hidden" id="current_page_no" value="<?php echo $current_page ?>">
                            <?php 
                                    if(($current_page*$ticket_rows)+count($section_tickets_id) != $total_count)
                                    {
                                        ?>
                                            <button type="button"  class="btn btn-default pagination_tickets" id="next" title="<?php _e('Next', 'wsdesk'); ?> <?php echo $ticket_rows?>" data-container="body">
                                                <span class="glyphicon glyphicon-chevron-right"></span>
                                            </button>
                                        <?php
                                    }
                            ?>
                            <?php 
                                    if(($current_page*$ticket_rows)+count($section_tickets_id) == $total_count)
                                    {
                                        ?>
                                            <button type="button"  class="btn btn-default pagination_tick" id="nex" title="<?php _e('End of the Page', 'wsdesk'); ?> " style="color:#AFAFAF; " data-container="body">
                                                <span class="glyphicon glyphicon-chevron-right"></span>
                                            </button>
                                        <?php
                                    }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev-table" placeholder="<?php _e('Filter Tickets', 'wsdesk'); ?>" />
                </div>
                <table class="table table-hover" id="dev-table">
                    <thead>
                        <tr class="except_view">
                            <th style="width: 1%;"></th>
                            <th style="width: 2%;"><?php _e('View', 'wsdesk'); ?></th>
                            <?php
                                foreach ($custom_table_headers as  $value) {
                                    echo '<th>'.$value.'</th>';
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                <?php 
                    if (strpos($active, 'view_') !== false)
                    {
                        $view = eh_crm_get_settings(array("slug"=>$active));
                        $group = eh_crm_get_settingsmeta($view[0]['settings_id'],'view_group');
                        if($group !== "")
                        {
                            $grouped_data = eh_crm_view_tickets_group($section_tickets_id,$group);
                        }
                        else
                        {
                            $grouped_data = array("no_group"=>$section_tickets_id);
                        }
                        if(empty($grouped_data))
                        {

                            echo '<tr class="except_view">
                                <td colspan="12">'.__('No Tickets', 'wsdesk').' </td></tr>';
                        }
                        else
                        {
                            foreach ($grouped_data as $key => $value) 
                            {
                                if($key!=="no_group")
                                {
                                    echo'
                                        <tr class="except_view" style="background-color: #f5f5f5;font-weight: 600;">
                                            <td colspan="12">
                                                '.$key.'
                                            </td>
                                        </tr>
                                        ';
                                }

                                $section_tickets_id = $value;
                                if(empty($section_tickets_id))
                                {
                                    echo '<tr class="except_view">
                                        <td colspan="12">'.__('No Tickets', 'wsdesk').' </td></tr>';
                                }
                                else
                                {
                                    for($i=0;$i<count($section_tickets_id);$i++)
                                    {
                                        $current = eh_crm_get_ticket(array("ticket_id"=>$section_tickets_id[$i]['ticket_id']));
                                        $current_meta = eh_crm_get_ticketmeta($section_tickets_id[$i]['ticket_id']);
                                        $action_value = '';
                                        $eye_color='';
                                        for($j=0;$j<count($avail_labels_wf);$j++)
                                        {
                                            if(in_array("manage_tickets", $access))
                                            {
                                                $action_value .= '<li id="'.$current[0]['ticket_id'].'"><a href="#" class="single_ticket_action" id="'.$avail_labels_wf[$j]['slug'].'">'.__('Mark as', 'wsdesk').' '.$avail_labels_wf[$j]['title'].'</a></li>';

                                            }
                                            if($avail_labels_wf[$j]['slug'] == $current_meta['ticket_label'])
                                            {
                                                $ticket_label_slug = $avail_labels_wf[$j]['slug'];
                                                $ticket_label = $avail_labels_wf[$j]['title'];
                                                $eye_color = eh_crm_get_settingsmeta($avail_labels_wf[$j]['settings_id'], "label_color");
                                            }
                                        }
                                        $ticket_raiser = $current[0]['ticket_email'];
                                        if($current[0]['ticket_author'] != 0)
                                        {
                                            $current_user = new WP_User($current[0]['ticket_author']);
                                            $ticket_raiser = $current_user->display_name;
                                        }
                                        $ticket_assignee_name =array();
                                        $ticket_assignee_email = array();
                                        if(isset($current_meta['ticket_assignee']))
                                        {
                                            $current_assignee = $current_meta['ticket_assignee'];
                                            for($k=0;$k<count($current_assignee);$k++)
                                            {
                                                for($l=0;$l<count($users_data);$l++)
                                                {
                                                    if($users_data[$l]['id'] == $current_assignee[$k])
                                                    {
                                                        array_push($ticket_assignee_name, $users_data[$l]['name']);
                                                        array_push($ticket_assignee_email, $users_data[$l]['email']);
                                                    }
                                                }
                                            }
                                        }
                                        $ticket_assignee_name = empty($ticket_assignee_name)?__("No Assignee", 'wsdesk'):implode(", ", $ticket_assignee_name);
                                        $latest_reply_id = eh_crm_get_ticket_value_count("ticket_category","agent_note" ,true,"ticket_parent",$current[0]['ticket_id'],'ticket_id',$order,'1');
                                        $latest_content = array();
                                        $attach = "";
                                        if(!empty($latest_reply_id))
                                        {
                                            $latest_ticket_reply = eh_crm_get_ticket(array("ticket_id"=>$latest_reply_id[0]["ticket_id"]));
                                            $latest_content['content'] = html_entity_decode(stripslashes($latest_ticket_reply[0]['ticket_content']));
                                            $latest_content['author_email'] = $latest_ticket_reply[0]['ticket_email'];
                                            $latest_content['reply_date'] = $latest_ticket_reply[0]['ticket_date'];
                                            if($latest_ticket_reply[0]['ticket_author'] != 0)
                                            {
                                                $reply_user = new WP_User($latest_ticket_reply[0]['ticket_author']);
                                                $latest_content['author_name'] = $reply_user->display_name;
                                            }
                                            else
                                            {
                                                $latest_content['author_name'] = __("Guest", 'wsdesk');
                                            }
                                            $latest_reply_meta = eh_crm_get_ticketmeta($latest_reply_id[0]["ticket_id"]);
                                            if(isset($latest_reply_meta['ticket_attachment']))
                                            {
                                                $attach = ' | <small class="glyphicon glyphicon-pushpin"></small> <small style="opacity:0.7;"> '.count($latest_reply_meta['ticket_attachment']).' '.__("Attachment", 'wsdesk').'</small>';
                                            }
                                        }
                                        else
                                        {
                                            $latest_content['content'] = html_entity_decode(stripslashes($current[0]['ticket_content']));
                                            $latest_content['author_email'] = $current[0]['ticket_email'];
                                            $latest_content['reply_date'] = $current[0]['ticket_date'];
                                            if($current[0]['ticket_author'] != 0)
                                            {
                                                $current_user = new WP_User($current[0]['ticket_author']);
                                                $latest_content['author_name'] = $current_user->display_name;
                                            }
                                            else
                                            {
                                                $latest_content['author_name'] = __("Guest", 'wsdesk');
                                            }
                                            if(isset($current_meta['ticket_attachment']))
                                            {
                                                $attach = ' | <small class="glyphicon glyphicon-pushpin"></small> <small style="opacity:0.7;"> '.count($current_meta['ticket_attachment']).' '.__("Attachment", 'wsdesk').'</small>';
                                            }
                                        }
                                        $ticket_tags = "";
                                        if(!empty($avail_tags_wf))
                                        {
                                            for($j=0;$j<count($avail_tags_wf);$j++)
                                            {
                                                $current_ticket_tags=(isset($current_meta['ticket_tags'])?$current_meta['ticket_tags']:array());
                                                for($k=0;$k<count($current_ticket_tags);$k++)
                                                {
                                                    if($avail_tags_wf[$j]['slug'] == $current_ticket_tags[$k])
                                                    {
                                                        $ticket_tags .= '<span class="label label-info">#'.$avail_tags_wf[$j]['title'].'</span>';
                                                    }
                                                }
                                            }
                                        }
                                        if(isset($current_meta['ticket_rating']))
                                        {
                                            if($current_meta['ticket_rating'] == 'great')
                                            {
                                                $ticket_rating = '<span class="glyphicon glyphicon-thumbs-up" style="color: green"></span>';
                                            }
                                            else
                                            {
                                                $ticket_rating = '<span class="glyphicon glyphicon-thumbs-down" style="color: red"></span>';
                                            }
                                        }
                                        else
                                        {
                                            $ticket_rating = '<span class="glyphicon glyphicon-time"></span>';
                                        }
                                        $raiser_voice = eh_crm_get_ticket_value_count("ticket_parent",$section_tickets_id[$i]['ticket_id'],false,"ticket_category","raiser_reply");
                                        $agent_voice = eh_crm_get_ticket_value_count("ticket_parent",$section_tickets_id[$i]['ticket_id'],false,"ticket_category","agent_reply");
                                        $input_data = ($tickets_display!="text")? html_entity_decode(stripslashes($latest_content['content'])):stripslashes($latest_content['content']);
                                        $input_array[0] = '/<((html)[^>]*)>(.*)\<\/(html)>/Us';
                                        $input_array[1] = '/<((head)[^>]*)>(.*)\<\/(head)>/Us';
                                        $input_array[2] = '/<((style)[^>]*)>(.*)\<\/(style)>/Us';
                                        $input_array[3] = '/<((body)[^>]*)>(.*)\<\/(body)>/Us';
                                        $input_array[4] = '/<((form)[^>]*)>(.*)\<\/(form)>/Us';
                                        $input_array[5] = '/<((input)[^>]*)>(.*)\<\/(input)>/Us';
                                        $input_array[6] = '/<((input)[^>]*)>/Us';
                                        $input_array[7] = '/<((button)[^>]*)>(.*)\<\/(button)>/Us';
                                        $input_array[8] = '/<((iframe)[^>]*)>(.*)\<\/(iframe)>/Us';
                                        $input_array[9] = '/<((script)[^>]*)>(.*)\<\/(script)>/Us';
                                        $input_array[10] = '/<((ins)[^>]*)>(.*)\<\/(ins)>/Us';
                                        $output_array[0] = '&lt;$1&gt;$3&lt;/html&gt;';
                                        $output_array[1] = '&lt;$1&gt;$3&lt;/head&gt;';
                                        $output_array[2] = '&lt;$1&gt;$3&lt;/style&gt;';
                                        $output_array[3] = '&lt;$1&gt;$3&lt;/body&gt;';
                                        $output_array[4] = '&lt;$1&gt;$3&lt;/form&gt;';
                                        $output_array[5] = '&lt;$1&gt;$3&lt;/input&gt;';
                                        $output_array[6] = '&lt;$1&gt;$3&lt;/input&gt;';
                                        $output_array[7] = '&lt;$1&gt;$3&lt;/button&gt;';
                                        $output_array[8] = '&lt;$1&gt;$3&lt;/iframe&gt;';
                                        $output_array[9] = '&lt;$1&gt;$3&lt;/script&gt;';
                                        $output_array[10] = '&lt;$1&gt;$3&lt;/ins&gt;';
                                        $latest_content['content'] = preg_replace($input_array, $output_array, $input_data);
                                        $latest_content['content'] = str_replace('<script>', '&lt;script&gt;', $latest_content['content']);
                                        echo '
                                        <tr class="clickable ticket_row" id="'.$current[0]['ticket_id'].'">
                                            <td class="except_view"><input type="checkbox" class="ticket_select" id="ticket_select" value="'.$current[0]['ticket_id'].'"></td>
                                            <td class="except_view"><button class="btn btn-default btn-xs accordion-toggle quick_view_ticket" style="background-color: '.$eye_color.' !important" data-toggle="collapse" data-target="#expand_'.$current[0]['ticket_id'].'" ><span class="glyphicon glyphicon-eye-open"></span></button></td>';
                                        if(!empty($all_ticket_field_views))
                                        {
                                            foreach ($all_ticket_field_views as  $all_ticket_field)
                                            {
                                                switch ($all_ticket_field) {
                                                    case 'id':
                                                        echo '<td>'.$current[0]['ticket_id'].'</td>';
                                                        break;
                                                    case 'requestor':
                                                        echo '<td>'.$ticket_raiser.'</td>';
                                                        break;
                                                    case 'subject':
                                                        echo '<td class="wrap_content" data-toggle="wsdesk_tooltip" title="'.$current[0]['ticket_title'].'" data-container="body">'.$current[0]['ticket_title'].'</td>';
                                                        break;
                                                    case 'requested':
                                                        echo '<td>'.eh_crm_get_formatted_date($current[0]['ticket_date']).'</td>';
                                                        break;
                                                    case 'assignee':
                                                        echo '<td>'.$ticket_assignee_name.'</td>';
                                                        break;
                                                    case 'feedback':
                                                        echo '<td>'.$ticket_rating.'</td>';
                                                        break;
                                                    default:
                                                        $current_settings_id = eh_crm_get_settings(array('slug' => $all_ticket_field), 'settings_id');
                                                        $current_settings_meta = eh_crm_get_settingsmeta($current_settings_id[0]['settings_id']);
                                                        if($current_settings_meta['field_type'] == 'select')
                                                        {
                                                            if($all_ticket_field == 'woo_order_id')
                                                            {
                                                               $current_settings_meta['field_type'] = 'text';
                                                            }
                                                        }
                                                        if($current_settings_meta['field_type'] != "file" && $current_settings_meta['field_type'] != "google_captcha")
                                                        {
                                                            switch ($current_settings_meta['field_type']) {
                                                                case 'select':
                                                                case 'radio':
                                                                case 'checkbox':
                                                                    $field_values = $current_settings_meta['field_values'];
                                                                    if(isset($current_meta[$all_ticket_field]))
                                                                        echo '<td>'.$field_values[$current_meta[$all_ticket_field]].'</td>';
                                                                    else
                                                                        echo '<td>-</td>';
                                                                    break;
                                                                default:
                                                                    if(isset($current_meta[$all_ticket_field]))
                                                                        echo '<td>'.$current_meta[$all_ticket_field].'</td>';
                                                                    else
                                                                        echo '<td>-</td>';
                                                                    break;
                                                            }
                                                        }
                                                        break;
                                                }
                                            }
                                        } 
                                        echo '</tr>
                                        <tr class="except_view">
                                            <td colspan="12" class="hiddenRow">
                                                <div class="accordian-body collapse" id="expand_'.$current[0]['ticket_id'].'">
                                                    <table class="table table-striped" style="margin-bottom: 0px !important">
                                                        <thead>
                                                            <tr>
                                                                <td colspan="12" style="white-space: normal;">
                                                                <div style="padding:5px 0px;">
                                                                    <small class="glyphicon glyphicon-user"></small> <small style="opacity:0.7;">'.$latest_content['author_name'].'</small>
                                                                    | <small class="glyphicon glyphicon-envelope"></small> <small style="opacity:0.7;">'.$latest_content['author_email'].'</small>
                                                                    | <small class="glyphicon glyphicon-calendar"></small> <small style="opacity:0.7;">'. eh_crm_get_formatted_date($latest_content['reply_date']).'</small>
                                                                    '.$attach.'
                                                                </div>
                                                                <hr>
                                                                <p>
                                                                    '.stripslashes($latest_content['content']).'
                                                                </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>'.__("Actions", 'wsdesk').'</th>
                                                                <th>'.__("Reply Requester", 'wsdesk').'</th>
                                                                <th>'.__("Raiser Voices", 'wsdesk').'</th>
                                                                <th>'.__("Agent Voices", 'wsdesk').'</th>
                                                                <th>'.__("Tags", 'wsdesk').'</th>
                                                                <th>'.__("Source", 'wsdesk').'</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="btn-group">
                                                                        <button type="button" class="btn btn-default dropdown-toggle single_ticket_action_button_'.$current[0]['ticket_id'].'" data-toggle="dropdown">
                                                                            '.__("Actions", 'wsdesk').' <span class="caret"></span>
                                                                        </button>
                                                                        <ul class="dropdown-menu" role="menu">
                                                                            '.(($action_value != "")?$action_value:'<li style="padding: 3px 20px;">'.__("No Actions", 'wsdesk').'</li>').'
                                                                            <li class="divider"></li>
                                                                            <li class="text-center">
                                                                                <small class="text-muted">
                                                                                    '.__("Select label to assign", 'wsdesk').'
                                                                                </small>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <a href="#reply_'.$current[0]['ticket_id'].'" data-toggle="modal"  title="'.__("Compose Reply", 'wsdesk').'">
                                                                        '.$current[0]['ticket_email'].'
                                                                    </a>
                                                                </td>
                                                                <td>'.count($raiser_voice).'</td>
                                                                    <td>'.count($agent_voice).'</td>
                                                                <td>'.(($ticket_tags!="")?$ticket_tags:__("No Tags", 'wsdesk')).'</td>
                                                                <td>'.((isset($current_meta['ticket_source']))?$current_meta['ticket_source']:"").'</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!-- Modal -->
                                                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="reply_'.$current[0]['ticket_id'].'" class="modal fade" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                    <h4 class="modal-title">'.__("Compose Reply", 'wsdesk').'</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p style="margin-top: 5px;font-size: 16px;">
                                                                    ';  
                                                                    if(in_array("manage_tickets", $access))
                                                                    {
                                                                        echo '<input type="text" value="'.stripslashes(htmlentities($current[0]['ticket_title'])).'" id="direct_ticket_title_'.$current[0]['ticket_id'].'" class="ticket_title_editable">';
                                                                    }
                                                                    else
                                                                    {
                                                                        echo $current[0]['ticket_title'];
                                                                    }
                                                                    if(in_array("reply_tickets",$access))
                                                                    {
                                                                        ?>
                                                                        </p>
                                                                        <div class="row" style="margin-bottom: 20px;">
                                                                            <div class="col-md-12">
                                                                                <div class="widget-area no-padding blank" style="width:100%">
                                                                                    <div class="status-upload">
                                                                                        <textarea rows="10" cols="30" class="form-control direct_reply_textarea" id="direct_reply_textarea_<?php echo $current[0]['ticket_id']; ?>" name="reply_textarea_<?php echo $current[0]['ticket_id']; ?>"></textarea> 
                                                                                        <div class="form-group">
                                                                                            <div class="input-group col-md-12">
                                                                                                <span class="btn btn-primary fileinput-button">
                                                                                                    <i class="glyphicon glyphicon-plus"></i>
                                                                                                    <span><?php _e("Attachment", 'wsdesk');?></span>
                                                                                                    <input type="file" name="direct_files" id="direct_files_<?php echo $current[0]['ticket_id']; ?>" class="direct_attachment_reply" multiple="">
                                                                                                </span>
                                                                                                <div class="btn-group pull-right">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle direct_ticket_reply_action_button_<?php echo $current[0]['ticket_id']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                      <?php _e("Submit as", 'wsdesk');?> <span class="caret"></span>
                                                                                                    </button>
                                                                                                    <ul class="dropdown-menu">
                                                                                                        <?php
                                                                                                            for($j=0;$j<count($avail_labels_wf);$j++)
                                                                                                            {
                                                                                                                echo '<li id="'.$current[0]['ticket_id'].'"><a href="#" class="direct_ticket_reply_action" id="'.$avail_labels_wf[$j]['slug'].'">'._e("Submit as", 'wsdesk').' '.$avail_labels_wf[$j]['title'].'</a></li>';
                                                                                                            }
                                                                                                        ?>
                                                                                                        <li role="separator" class="divider"></li>
                                                                                                        <li id="<?php echo $current[0]['ticket_id'];?>"><a href="#" class="direct_ticket_reply_action" id="note"><?php _e("Submit as Note", 'wsdesk');?></a></li>
                                                                                                        <li class="text-center"><small class="text-muted"><?php _e("Notes visible to Agents and Supervisors", 'wsdesk');?></small></li>
                                                                                                    </ul>
                                                                                                  </div>
                                                                                            </div>
                                                                                            <div class="direct_upload_preview_files_<?php echo $current[0]['ticket_id'];?>"></div>
                                                                                        </div>
                                                                                    </div><!-- Status Upload  -->
                                                                                </div><!-- Widget Area -->
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        echo "<p>".__("You don't Have permisson to Reply this ticket", 'wsdesk')."</p>";
                                                                    }
                                                                echo'
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                </div>
                                            </td>
                                        </tr>
                                        ';
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        if(empty($section_tickets_id))
                        {
                            echo '<tr class="except_view">
                                <td colspan="12">'.__("No Tickets", 'wsdesk').' </td></tr>';
                        }
                        else
                        {
                            for($i=0;$i<count($section_tickets_id);$i++)
                            {
                                $current = eh_crm_get_ticket(array("ticket_id"=>$section_tickets_id[$i]['ticket_id']));
                                $current_meta = eh_crm_get_ticketmeta($section_tickets_id[$i]['ticket_id']);
                                $action_value = '';
                                $assignee_value = '';
                                $eye_color='';
                                for($j=0;$j<count($avail_labels_wf);$j++)
                                {
                                    if(in_array("manage_tickets", $access))
                                    {
                                        $action_value .= '<li id="'.$current[0]['ticket_id'].'"><a href="#" class="single_ticket_action" id="'.$avail_labels_wf[$j]['slug'].'">'.__("Mark as", 'wsdesk').' '.$avail_labels_wf[$j]['title'].'</a></li>';

                                    }
                                    if($avail_labels_wf[$j]['slug'] == $current_meta['ticket_label'])
                                    {
                                        $ticket_label_slug = $avail_labels_wf[$j]['slug'];
                                        $ticket_label = $avail_labels_wf[$j]['title'];
                                        $eye_color = eh_crm_get_settingsmeta($avail_labels_wf[$j]['settings_id'], "label_color");
                                    }
                                }
                                for($j=0;$j<count($users);$j++)
                                {
                                    if(in_array("manage_tickets", $access))
                                    {
                                        $assignee_value.='<li id="'.$current[0]['ticket_id'].'"><a href="#" class="single_ticket_assignee" id="'.$users[$j]->ID.'">'.$users[$j]->display_name.'</a></li>';
                                    }
                                }
                                $ticket_raiser = $current[0]['ticket_email'];
                                if($current[0]['ticket_author'] != 0)
                                {
                                    $current_user = new WP_User($current[0]['ticket_author']);
                                    $ticket_raiser = $current_user->display_name;
                                }
                                $ticket_assignee_name =array();
                                $ticket_assignee_email = array();
                                if(isset($current_meta['ticket_assignee']))
                                {
                                    $current_assignee = $current_meta['ticket_assignee'];
                                    for($k=0;$k<count($current_assignee);$k++)
                                    {
                                        for($l=0;$l<count($users_data);$l++)
                                        {
                                            if($users_data[$l]['id'] == $current_assignee[$k])
                                            {
                                                array_push($ticket_assignee_name, $users_data[$l]['name']);
                                                array_push($ticket_assignee_email, $users_data[$l]['email']);
                                            }
                                        }
                                    }
                                }
                                $ticket_assignee_name = empty($ticket_assignee_name)?__("No Assignee", 'wsdesk'):implode(", ", $ticket_assignee_name);
                                $latest_reply_id = eh_crm_get_ticket_value_count("ticket_category","agent_note" ,true,"ticket_parent",$current[0]['ticket_id'],'ticket_id',$order,'1');
                                $latest_content = array();
                                $attach = "";
                                if(!empty($latest_reply_id))
                                {
                                    $latest_ticket_reply = eh_crm_get_ticket(array("ticket_id"=>$latest_reply_id[0]["ticket_id"]));
                                    $latest_content['content'] = html_entity_decode(stripslashes($latest_ticket_reply[0]['ticket_content']));
                                    $latest_content['author_email'] = $latest_ticket_reply[0]['ticket_email'];
                                    $latest_content['reply_date'] = $latest_ticket_reply[0]['ticket_date'];
                                    if($latest_ticket_reply[0]['ticket_author'] != 0)
                                    {
                                        $reply_user = new WP_User($latest_ticket_reply[0]['ticket_author']);
                                        $latest_content['author_name'] = $reply_user->display_name;
                                    }
                                    else
                                    {
                                        $latest_content['author_name'] = __("Guest", 'wsdesk');
                                    }
                                    $latest_reply_meta = eh_crm_get_ticketmeta($latest_reply_id[0]["ticket_id"]);
                                    if(isset($latest_reply_meta['ticket_attachment']))
                                    {
                                        $attach = ' | <small class="glyphicon glyphicon-pushpin"></small> <small style="opacity:0.7;"> '.count($latest_reply_meta['ticket_attachment']).' '.__("Attachment", 'wsdesk').'</small>';
                                    }
                                }
                                else
                                {
                                    $latest_content['content'] = html_entity_decode(stripslashes($current[0]['ticket_content']));
                                    $latest_content['author_email'] = $current[0]['ticket_email'];
                                    $latest_content['reply_date'] = $current[0]['ticket_date'];
                                    if($current[0]['ticket_author'] != 0)
                                    {
                                        $current_user = new WP_User($current[0]['ticket_author']);
                                        $latest_content['author_name'] = $current_user->display_name;
                                    }
                                    else
                                    {
                                        $latest_content['author_name'] = __("Guest", 'wsdesk');
                                    }
                                    if(isset($current_meta['ticket_attachment']))
                                    {
                                        $attach = ' | <small class="glyphicon glyphicon-pushpin"></small> <small style="opacity:0.7;"> '.count($current_meta['ticket_attachment']).' '.__("Attachment", 'wsdesk').'</small>';
                                    }
                                }
                                $ticket_tags = "";
                                if(!empty($avail_tags_wf))
                                {
                                    for($j=0;$j<count($avail_tags_wf);$j++)
                                    {
                                        $current_ticket_tags=(isset($current_meta['ticket_tags'])?$current_meta['ticket_tags']:array());
                                        for($k=0;$k<count($current_ticket_tags);$k++)
                                        {
                                            if($avail_tags_wf[$j]['slug'] == $current_ticket_tags[$k])
                                            {
                                                $ticket_tags .= '<span class="label label-info">#'.$avail_tags_wf[$j]['title'].'</span>';
                                            }
                                        }
                                    }
                                }

                                if(isset($current_meta['ticket_rating']))
                                {
                                    if($current_meta['ticket_rating'] == 'great')
                                    {
                                        $ticket_rating = '<span class="glyphicon glyphicon-thumbs-up" style="color: green"></span>';
                                    }
                                    else
                                    {
                                        $ticket_rating = '<span class="glyphicon glyphicon-thumbs-down" style="color: red"></span>';
                                    }
                                }
                                else
                                {
                                    $ticket_rating = '<span class="glyphicon glyphicon-time"></span>';
                                }
                                $raiser_voice = eh_crm_get_ticket_value_count("ticket_parent",$section_tickets_id[$i]['ticket_id'],false,"ticket_category","raiser_reply");
                                $agent_voice = eh_crm_get_ticket_value_count("ticket_parent",$section_tickets_id[$i]['ticket_id'],false,"ticket_category","agent_reply");
                                $input_data = ($tickets_display!="text")? html_entity_decode(stripslashes($latest_content['content'])):stripslashes($latest_content['content']);
                                $input_array[0] = '/<((html)[^>]*)>(.*)\<\/(html)>/Us';
                                $input_array[1] = '/<((head)[^>]*)>(.*)\<\/(head)>/Us';
                                $input_array[2] = '/<((style)[^>]*)>(.*)\<\/(style)>/Us';
                                $input_array[3] = '/<((body)[^>]*)>(.*)\<\/(body)>/Us';
                                $input_array[4] = '/<((form)[^>]*)>(.*)\<\/(form)>/Us';
                                $input_array[5] = '/<((input)[^>]*)>(.*)\<\/(input)>/Us';
                                $input_array[6] = '/<((input)[^>]*)>/Us';
                                $input_array[7] = '/<((button)[^>]*)>(.*)\<\/(button)>/Us';
                                $input_array[8] = '/<((iframe)[^>]*)>(.*)\<\/(iframe)>/Us';
                                $input_array[9] = '/<((script)[^>]*)>(.*)\<\/(script)>/Us';
                                $input_array[10] = '/<((ins)[^>]*)>(.*)\<\/(ins)>/Us';
                                $output_array[0] = '&lt;$1&gt;$3&lt;/html&gt;';
                                $output_array[1] = '&lt;$1&gt;$3&lt;/head&gt;';
                                $output_array[2] = '&lt;$1&gt;$3&lt;/style&gt;';
                                $output_array[3] = '&lt;$1&gt;$3&lt;/body&gt;';
                                $output_array[4] = '&lt;$1&gt;$3&lt;/form&gt;';
                                $output_array[5] = '&lt;$1&gt;$3&lt;/input&gt;';
                                $output_array[6] = '&lt;$1&gt;$3&lt;/input&gt;';
                                $output_array[7] = '&lt;$1&gt;$3&lt;/button&gt;';
                                $output_array[8] = '&lt;$1&gt;$3&lt;/iframe&gt;';
                                $output_array[9] = '&lt;$1&gt;$3&lt;/script&gt;';
                                $output_array[10] = '&lt;$1&gt;$3&lt;/ins&gt;';
                                $latest_content['content'] = preg_replace($input_array, $output_array, $input_data);
                                $latest_content['content'] = str_replace('<script>', '&lt;script&gt;', $latest_content['content']);
                                echo '
                                <tr class="clickable ticket_row" id="'.$current[0]['ticket_id'].'">
                                    <td class="except_view"><input type="checkbox" class="ticket_select" id="ticket_select" value="'.$current[0]['ticket_id'].'"></td>
                                    <td class="except_view"><button class="btn btn-default btn-xs accordion-toggle quick_view_ticket" style="background-color: '.$eye_color.' !important" data-toggle="collapse" data-target="#expand_'.$current[0]['ticket_id'].'" ><span class="glyphicon glyphicon-eye-open"></span></button></td>';
                                if(!empty($all_ticket_field_views))
                                {
                                    foreach ($all_ticket_field_views as  $all_ticket_field)
                                    {
                                        switch ($all_ticket_field) {
                                            case 'id':
                                                echo '<td>'.$current[0]['ticket_id'].'</td>';
                                                break;
                                            case 'requestor':
                                                echo '<td>'.$ticket_raiser.'</td>';
                                                break;
                                            case 'subject':
                                                echo '<td class="wrap_content" data-toggle="wsdesk_tooltip" title="'.$current[0]['ticket_title'].'" data-container="body">'.$current[0]['ticket_title'].'</td>';
                                                break;
                                            case 'requested':
                                                echo '<td>'.eh_crm_get_formatted_date($current[0]['ticket_date']).'</td>';
                                                break;
                                            case 'assignee':
                                                echo '<td>'.$ticket_assignee_name.'</td>';
                                                break;
                                            case 'feedback':
                                                echo '<td>'.$ticket_rating.'</td>';
                                                break;
                                            default:
                                                $current_settings_id = eh_crm_get_settings(array('slug' => $all_ticket_field), 'settings_id');
                                                $current_settings_meta = eh_crm_get_settingsmeta($current_settings_id[0]['settings_id']);
                                                if($current_settings_meta['field_type'] == 'select')
                                                {
                                                    if($all_ticket_field == 'woo_order_id')
                                                    {
                                                       $current_settings_meta['field_type'] = 'text';
                                                    }
                                                }
                                                if($current_settings_meta['field_type'] != "file" && $current_settings_meta['field_type'] != "google_captcha")
                                                {
                                                    switch ($current_settings_meta['field_type']) {
                                                        case 'select':
                                                        case 'radio':
                                                        case 'checkbox':
                                                            $field_values = $current_settings_meta['field_values'];
                                                            if(isset($current_meta[$all_ticket_field]))
                                                                echo '<td>'.$field_values[$current_meta[$all_ticket_field]].'</td>';
                                                            else
                                                                echo '<td>-</td>';
                                                            break;
                                                        default:
                                                            if(isset($current_meta[$all_ticket_field]))
                                                                echo '<td>'.$current_meta[$all_ticket_field].'</td>';
                                                            else
                                                                echo '<td>-</td>';
                                                            break;
                                                    }
                                                }
                                                break;
                                        }
                                    }
                                }
                                echo '</tr>
                                <tr class="except_view">
                                    <td colspan="12" class="hiddenRow">
                                        <div class="accordian-body collapse" id="expand_'.$current[0]['ticket_id'].'">
                                            <table class="table table-striped" style="margin-bottom: 0px !important">
                                                <thead>
                                                    <tr>
                                                        <td colspan="12" style="white-space: normal;">
                                                        <div style="padding:5px 0px;">
                                                            <small class="glyphicon glyphicon-user"></small> <small style="opacity:0.7;">'.$latest_content['author_name'].'</small>
                                                            | <small class="glyphicon glyphicon-envelope"></small> <small style="opacity:0.7;">'.$latest_content['author_email'].'</small>
                                                            | <small class="glyphicon glyphicon-calendar"></small> <small style="opacity:0.7;">'. eh_crm_get_formatted_date($latest_content['reply_date']).'</small>
                                                            '.$attach.'
                                                        </div>
                                                        <hr>
                                                        <p>
                                                            '.stripslashes($latest_content['content']).'
                                                        </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>'.__("Actions", 'wsdesk').'</th>
                                                        <th>'.__("Assignee", 'wsdesk').'</th>
                                                        <th>'.__("Reply Requester", 'wsdesk').'</th>
                                                        <th>'.__("Raiser Voices", 'wsdesk').'</th>
                                                        <th>'.__("Agent Voices", 'wsdesk').'</th>
                                                        <th>'.__("Tags", 'wsdesk').'</th>
                                                        <th>'.__("Source", 'wsdesk').'</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-default dropdown-toggle single_ticket_action_button_'.$current[0]['ticket_id'].'" data-toggle="dropdown">
                                                                    '.__("Actions", 'wsdesk').' <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    '.(($action_value != "")?$action_value:'<li style="padding: 3px 20px;">'.__("No Actions", 'wsdesk').'</li>').'
                                                                    <li class="divider"></li>
                                                                    <li class="text-center">
                                                                        <small class="text-muted">
                                                                            '.__("Select label to assign", 'wsdesk').'
                                                                        </small>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-default dropdown-toggle single_ticket_assignee_button_'.$current[0]['ticket_id'].'" data-toggle="dropdown">
                                                                    '.__('Assignee','wsdesk').' <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    '.(($assignee_value != "")?$assignee_value:'<li style="padding: 3px 20px;">'.__('No Assignee','wsdesk').'</li>').'
                                                                    <li class="divider"></li>
                                                                    <li class="text-center">
                                                                        <small class="text-muted">
                                                                            '.__('Select assignee to assign','wsdesk').'
                                                                        </small>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="#reply_'.$current[0]['ticket_id'].'" data-toggle="modal"  title="'.__("Compose Reply", 'wsdesk').'">
                                                                '.$current[0]['ticket_email'].'
                                                            </a>
                                                        </td>
                                                        <td>'.count($raiser_voice).'</td>
                                                        <td>'.count($agent_voice).'</td>
                                                        <td>'.(($ticket_tags!="")?$ticket_tags:__("No Tags", 'wsdesk')).'</td>
                                                        <td>'.((isset($current_meta['ticket_source']))?$current_meta['ticket_source']:"").'</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!-- Modal -->
                                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="reply_'.$current[0]['ticket_id'].'" class="modal fade" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                            <h4 class="modal-title">'.__("Compose Reply", 'wsdesk').'</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p style="margin-top: 5px;font-size: 16px;">
                                                            ';  
                                                            if(in_array("manage_tickets", $access))
                                                            {
                                                                echo '<input type="text" value="'.stripslashes(htmlentities($current[0]['ticket_title'])).'" id="direct_ticket_title_'.$current[0]['ticket_id'].'" class="ticket_title_editable">';
                                                            }
                                                            else
                                                            {
                                                                echo $current[0]['ticket_title'];
                                                            }
                                                            if(in_array("reply_tickets",$access))
                                                            {
                                                                ?>
                                                                </p>
                                                                <div class="row" style="margin-bottom: 20px;">
                                                                    <div class="col-md-12">
                                                                        <div class="widget-area no-padding blank" style="width:100%">
                                                                            <div class="status-upload">
                                                                                <textarea rows="10" cols="30" class="form-control direct_reply_textarea" id="direct_reply_textarea_<?php echo $current[0]['ticket_id']; ?>" name="reply_textarea_<?php echo $current[0]['ticket_id']; ?>"></textarea> 
                                                                                <div class="form-group">
                                                                                    <div class="input-group col-md-12">
                                                                                        <span class="btn btn-primary fileinput-button">
                                                                                            <i class="glyphicon glyphicon-plus"></i>
                                                                                            <span><?php _e("Attachment", 'wsdesk');?></span>
                                                                                            <input type="file" name="direct_files" id="direct_files_<?php echo $current[0]['ticket_id']; ?>" class="direct_attachment_reply" multiple="">
                                                                                        </span>
                                                                                        <div class="btn-group pull-right">
                                                                                            <button type="button" class="btn btn-primary dropdown-toggle direct_ticket_reply_action_button_<?php echo $current[0]['ticket_id']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                <?php _e("Submit as", 'wsdesk');?> <span class="caret"></span>
                                                                                            </button>
                                                                                            <ul class="dropdown-menu">
                                                                                                <?php
                                                                                                    for($j=0;$j<count($avail_labels_wf);$j++)
                                                                                                    {
                                                                                                        echo '<li id="'.$current[0]['ticket_id'].'"><a href="#" class="direct_ticket_reply_action" id="'.$avail_labels_wf[$j]['slug'].'">'.__("Submit as", 'wsdesk').' '.$avail_labels_wf[$j]['title'].'</a></li>';
                                                                                                    }
                                                                                                ?>
                                                                                                <li role="separator" class="divider"></li>
                                                                                                <li id="<?php echo $current[0]['ticket_id'];?>"><a href="#" class="direct_ticket_reply_action" id="note"><?php _e("Submit as Note", 'wsdesk'); ?></a></li>
                                                                                                <li class="text-center"><small class="text-muted"><?php _e("Notes visible to Agents and Supervisors", 'wsdesk'); ?></small></li>
                                                                                            </ul>
                                                                                          </div>
                                                                                    </div>
                                                                                    <div class="direct_upload_preview_files_<?php echo $current[0]['ticket_id'];?>"></div>
                                                                                </div>
                                                                            </div><!-- Status Upload  -->
                                                                        </div><!-- Widget Area -->
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                echo "<p>".__("You don't Have permisson to Reply this ticket", 'wsdesk')."</p>";
                                                            }
                                                        echo'
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        </div>
                                    </td>
                                </tr>
                                ';
                            }
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
            $content = ob_get_clean();
            die($content);
        }
        
        static function eh_crm_ticket_reply_agent() {
            $files = isset($_FILES["file"])?$_FILES["file"]:"";
            $title = (isset($_POST['ticket_title'])? stripslashes(sanitize_text_field($_POST['ticket_title'])):"");
            $pagination = json_decode(stripslashes(sanitize_text_field($_POST['pagination_id'])), true);
            $ticket_id = sanitize_text_field($_POST['ticket_id']);
            if(!empty($_POST['wsd_ticket_email']))
            {
                $email = stripslashes(sanitize_text_field($_POST['wsd_ticket_email']));
            }
            else
            {
                $email = eh_crm_get_ticket(array("ticket_id"=>$ticket_id), "ticket_email");
                $email = $email[0]['ticket_email'];
            }
            $submit = sanitize_text_field($_POST['submit']);
            $content = str_replace("\n", '<br/>',stripslashes($_POST['ticket_reply']));
            if($title!="")
            {
                eh_crm_update_ticket($ticket_id, array("ticket_title"=>$title, "ticket_email"=>$email));
            }
            $parent = eh_crm_get_ticket(array("ticket_id"=>$ticket_id));
            $user = wp_get_current_user();
            $user_roles_default = array("WSDesk_Agents", "WSDesk_Supervisor","administrator");
            $category ='';
            if (count(array_intersect($user_roles_default, $user->roles)) != 0)
            {
                if($submit == "note")
                {
                    $category = 'agent_note';
                }
                else
                {
                    $category = 'agent_reply';
                }
            }
            else
            {
                $category = 'raiser_reply';
            }
            $vendor = '';
            if(EH_CRM_WOO_VENDOR)
            {
                $vendor = EH_CRM_WOO_VENDOR;
            }
            $child = array(
                'ticket_email' => $user->user_email,
                'ticket_title' => $parent[0]['ticket_title'],
                'ticket_content' => html_entity_decode($content),
                'ticket_category' => $category,
                'ticket_parent' => $ticket_id,
                'ticket_vendor' => $vendor
                );
            $child_meta = array();
            if(isset($_FILES["file"]) && !empty($_FILES['file']))
            {
                $attachment_data = CRM_Ajax::eh_crm_ticket_file_handler($files);
                $child_meta["ticket_attachment"] = $attachment_data['url'];
                $child_meta["ticket_attachment_path"] = $attachment_data['path'];
            }
            $gen_id = eh_crm_insert_ticket($child,$child_meta);
            if (count(array_intersect($user_roles_default, $user->roles)) != 0)
            {
                if($submit != "note")
                {
                    $ticket_label = eh_crm_get_ticketmeta($ticket_id, "ticket_label");
                    if($ticket_label==$submit) //if label is same
                        eh_crm_update_ticketmeta($ticket_id, "ticket_label", $submit,false); 
                    else
                        eh_crm_update_ticketmeta($ticket_id, "ticket_label", $submit); //false removed to let "change to" cause a trigger
                }
                $auto_assign = eh_crm_get_settingsmeta('0','auto_assign');
                if($auto_assign == "enable")
                {
                    $assignee = eh_crm_get_ticketmeta($ticket_id, "ticket_assignee" );
                    if(empty($assignee))
                    {
                        eh_crm_update_ticketmeta($ticket_id, "ticket_assignee", array($user->ID));
                    }
                }
            }
            $response = array();
            $send_agent_reply_mail = eh_crm_get_settingsmeta('0', "send_agent_reply_mail");
            if($send_agent_reply_mail != 'disabled')
            {
                if($category==="agent_reply")
                {
                    eh_crm_debug_error_log(" ------------- WSDesk Email Debug Started ------------- ");
                    eh_crm_debug_error_log("Agent Replied for Ticket #".$ticket_id);
                    eh_crm_debug_error_log("Email function called for new reply #".$gen_id);
                    $response = CRM_Ajax::eh_crm_fire_email("reply_ticket",$gen_id);
                    eh_crm_debug_error_log(" ------------- WSDesk Email Debug Ended ------------- ");
                }
            }
            $content_html = CRM_Ajax::eh_crm_ticket_single_view_gen($ticket_id,$pagination);
            $tab = CRM_Ajax::eh_crm_ticket_single_view_gen_head($ticket_id);
            die(json_encode(array("tab_head"=>$tab,"tab_content"=>$content_html,'response'=>$response)));
        }
        
        static function eh_crm_ticket_file_handler($files) {
            $attachment_url = array();
            $attachment_path = array();
            $attachment = array();
            $custom_attachment = eh_crm_get_settingsmeta('0','custom_attachment_folder_enable');
            $valid_exts = eh_crm_get_settingsmeta('0', 'valid_file_extension');
            $max_file_size = eh_crm_get_settingsmeta('0', 'max_file_size');
            if (empty($max_file_size))
                $max_file_size=1;
            if(!empty($valid_exts))
                $valid_exts=explode(',', $valid_exts);
            if($custom_attachment!=='yes')
            {
                if(!function_exists('wp_handle_upload')){
                    require_once(admin_url('includes/file.php'));
                }
                $upload_overrides = array( 'test_form' => false,"test_size" => false,"test_type"=>false);
                foreach ($files['name'] as $key => $value) {
                    $file_name_key = explode('.', $files['name'][$key]);
                    $extension = (count($file_name_key) - 1);
                    $file_ext=strtolower($file_name_key[$extension]);
                    if($files['size'][$key]<=$max_file_size*1024*1024)
                    {
                        if(empty($valid_exts) || in_array($file_ext, $valid_exts))
                        {
                            if ($files['name'][$key]) {
                                $file = array(
                                    'name'      => time().'_'.$files['name'][$key],
                                    'type'      => $files['type'][$key],
                                    'tmp_name'  => $files['tmp_name'][$key],
                                    'error'     => $files['error'][$key],
                                    'size'      => $files['size'][$key]
                                );
                                $attach_id = wp_handle_upload($file, $upload_overrides);
                                $attachment_url[] = $attach_id['url'];
                                $attachment_path[] = $attach_id['file'];
                            }
                        }
                        else
                        {
                            die(json_encode(array("status"=>"error","message"=> "Invalid file extension. Allowed file extensions are: ".eh_crm_get_settingsmeta('0', 'valid_file_extension'))));
                        }
                    }
                    else
                    {
                        die(json_encode(array("status"=>"error","message"=> "Maximum file size exceeded. Max file size allowed(MB): ".$max_file_size)));
                    }
                }
            }
            else
            {
                $custom_attachment_path=eh_crm_get_settingsmeta('0', 'custom_attachment_folder_path');
                foreach ($files['name'] as $key => $value) {
                    $file_name_key = explode('.', $files['name'][$key]);
                    $extension = (count($file_name_key) - 1);
                    $file_ext=strtolower($file_name_key[$extension]);
                    if($files['size'][$key]<=$max_file_size*1024*1024)
                    {
                        $file_name_key = explode('.', $files['name'][$key]);
                        if ($files['name'][$key] && empty($valid_exts) || in_array(strtolower($file_name_key[1]), $valid_exts) )
                        {
                            $new_name=time().'_'.$files['name'][$key];
                            $folder = ABSPATH.$custom_attachment_path;
                            if (!file_exists($folder) && !is_dir($folder)) {
                                mkdir($folder);
                                move_uploaded_file($files['tmp_name'][$key], $folder."/$new_name");
                            }
                            else
                            {
                                move_uploaded_file($files['tmp_name'][$key], $folder."/$new_name");
                            }
                            $attachment_url[]=get_site_url()."/$custom_attachment_path/".$new_name;
                            $attachment_path[]=ABSPATH.$custom_attachment_path."/$new_name";
                        }
                        else
                        {
                            die(json_encode(array("status"=>"error","message"=> "Invalid file extension. Allowed file extensions are: ".eh_crm_get_settingsmeta('0', 'valid_file_extension'))));
                        }
                    }
                    else
                    {
                        die(json_encode(array("status"=>"error","message"=> "Maximum file size exceeded. Max file size allowed(MB): ".$max_file_size)));
                    }
                }
                

            }
            $attachment['url'] = $attachment_url;
            $attachment['path'] = $attachment_path;
            return $attachment;
            
        }
        
        static function eh_crm_ticket_single_ticket_action() {
            $ticket_id = sanitize_text_field($_POST['ticket_id']);
            $label = sanitize_text_field($_POST['label']);
            $pagination = json_decode(stripslashes(sanitize_text_field($_POST['pagination_id'])), true);
            eh_crm_update_ticketmeta($ticket_id, "ticket_label", $label);
            $content_html = CRM_Ajax::eh_crm_ticket_single_view_gen($ticket_id,$pagination);
            die($content_html);
        }

        static function eh_crm_ticket_single_ticket_priority() {
            $ticket_id = sanitize_text_field($_POST['ticket_id']);
            $priority = sanitize_text_field($_POST['priority']);
            $pagination = json_decode(stripslashes(sanitize_text_field($_POST['pagination_id'])), true);
            eh_crm_update_ticketmeta($ticket_id, "field_HN27", $priority);
            $content_html = CRM_Ajax::eh_crm_ticket_single_view_gen($ticket_id,$pagination);
            die($content_html);
        }
        
        static function eh_crm_ticket_single_ticket_site() {
            $ticket_id = sanitize_text_field($_POST['ticket_id']);
            $site = sanitize_text_field($_POST['site']);
            $pagination = json_decode(stripslashes(sanitize_text_field($_POST['pagination_id'])), true);
            eh_crm_update_ticketmeta($ticket_id, "field_MG53", $site);
            $content_html = CRM_Ajax::eh_crm_ticket_single_view_gen($ticket_id,$pagination);
            die($content_html);
        }

        static function eh_crm_ticket_single_ticket_asset() {
            $ticket_id = sanitize_text_field($_POST['ticket_id']);
            $asset = sanitize_text_field($_POST['asset']);
            $pagination = json_decode(stripslashes(sanitize_text_field($_POST['pagination_id'])), true);
            eh_crm_update_ticketmeta($ticket_id, "field_KQ13", $asset);
            $content_html = CRM_Ajax::eh_crm_ticket_single_view_gen($ticket_id,$pagination);
            die($content_html);
        }

        static function eh_crm_ticket_single_ticket_user() {
            $ticket_id = sanitize_text_field($_POST['ticket_id']);
            $user = sanitize_text_field($_POST['user']);
            $pagination = json_decode(stripslashes(sanitize_text_field($_POST['pagination_id'])), true);
            eh_crm_update_ticketmeta($ticket_id, "field_QF40", $user);
            $content_html = CRM_Ajax::eh_crm_ticket_single_view_gen($ticket_id,$pagination);
            die($content_html);
        }

        static function eh_crm_ticket_single_ticket_client() {
            $ticket_id = sanitize_text_field($_POST['ticket_id']);
            $client = sanitize_text_field($_POST['client']);
            $pagination = json_decode(stripslashes(sanitize_text_field($_POST['pagination_id'])), true);
            eh_crm_update_ticketmeta($ticket_id, "field_WC34", $client);
            $content_html = CRM_Ajax::eh_crm_ticket_single_view_gen($ticket_id,$pagination);
            die($content_html);
        }

        static function eh_crm_ticket_single_ticket_assignee() {
            $ticket_id = sanitize_text_field($_POST['ticket_id']);
            $assignee = sanitize_text_field($_POST['assignee']);
            $pagination = json_decode(stripslashes(sanitize_text_field($_POST['pagination_id'])), true);
            eh_crm_update_ticketmeta($ticket_id, "ticket_assignee", array($assignee));
            $content_html = CRM_Ajax::eh_crm_ticket_single_view_gen($ticket_id,$pagination);
            die($content_html);
        }
        
        static function eh_crm_ticket_multiple_ticket_action() {
            $tickets_id = json_decode(stripslashes(sanitize_text_field($_POST['tickets_id'])), true);
            $label = sanitize_text_field($_POST['label']);
            for($i=0;$i<count($tickets_id);$i++)
            {
                eh_crm_update_ticketmeta($tickets_id[$i], "ticket_label", $label);      
            }
        }
        
        static function eh_crm_ticket_search() {
            $search = $_POST['search'];
            if(eh_crm_get_ticket(array("ticket_id"=>$search,"ticket_parent"=>0)))
            {
                $content = CRM_Ajax::eh_crm_ticket_single_view_gen($search);
                $tab = CRM_Ajax::eh_crm_ticket_single_view_gen_head($search);
                die(json_encode(array("tab_head"=>$tab,"tab_content"=>$content,"data"=>"ticket")));
            }
            else
            {
                $ticket_ids = eh_crm_get_ticket_search($search);
                $content = CRM_Ajax::eh_crm_generate_search_result($ticket_ids,$search);
                $search_key = str_replace(" ", "_", $search);
                $search_key = str_replace('@', '_1attherate1_', $search_key);
                $search_key = str_replace('.', '_1dot1_', $search_key);
                $search_key = str_replace(';', '_1semicolon1_', $search_key);
                $search_key = str_replace('?', '_1questionmark1_', $search_key);
                $tab='<a href="#tab_content_'.$search_key.'" id="tab_content_a_'.$search_key.'" aria-controls="#'.$search_key.'" role="tab" data-toggle="tab" class="tab_a" style="font-size: 12px;padding: 11px 5px;margin-right:0px !important;"><button type="button" class="btn btn-default btn-circle close_tab pull-right"><span class="glyphicon glyphicon-remove"></span></button><div class="badge"><span class="glyphicon glyphicon-search"></span></div><span> '.(strlen($search) > 18 ? substr($search,0,18)."..." : $search).'</span></a>';
                die(json_encode(array("tab_head"=>$tab,"tab_content"=>$content,"data"=>"search")));
            }
        }
        
        static function eh_crm_generate_search_result($section_tickets_id,$search) {
            $avail_labels = eh_crm_get_settings(array("type" => "label", "filter" => "yes"), array("slug", "title", "settings_id"));
            $avail_tags = eh_crm_get_settings(array("type" => "tag", "filter" => "yes"), array("slug", "title", "settings_id"));
            $user_roles_default = array("WSDesk_Agents", "WSDesk_Supervisor","administrator");
            $users = get_users(array("role__in" => $user_roles_default));
            $users_data = array();
            for ($i = 0; $i < count($users); $i++) {
                $current = $users[$i];
                $id = $current->ID;
                $user = new WP_User($id);
                $users_data[$i]['id'] = $id;
                $users_data[$i]['name'] = $user->display_name;
                $users_data[$i]['caps'] = $user->caps;
                $users_data[$i]['email'] = $user->user_email;
            }
            $avail_caps = array("reply_tickets","delete_tickets","manage_tickets");
            $access = array();
            $logged_user = wp_get_current_user();
            $logged_user_caps = array_keys($logged_user->caps);
            if(!in_array("administrator", $logged_user->roles))
            {
                for($i=0;$i<count($logged_user_caps);$i++)
                {
                    if(!in_array($logged_user_caps[$i], $avail_caps))
                    {
                        unset($logged_user_caps[$i]);
                    }
                }
                $access = $logged_user_caps;
            }
            else
            {
                $access = $avail_caps;
            }
            ob_start();
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="panel panel-default tickets_panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php _e("Search Result", 'wsdesk'); ?> "<?php echo $search;?>"
                                    <span class="spinner_loader search_table_loader">
                                        <span class="bounce1"></span>
                                        <span class="bounce2"></span>
                                        <span class="bounce3"></span>
                                    </span>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <input type="text" class="form-control" id="search-table-filter" data-action="filter" data-filters="#search-table" placeholder="<?php _e("Filter Anything", 'wsdesk'); ?>" />
                            </div>
                            <table class="table table-hover" id="search-table">
                                <thead>
                                    <tr class="except_view">
                                        <th><?php _e("View", 'wsdesk'); ?></th>
                                        <th>#</th>
                                        <th><?php _e("Requester", 'wsdesk'); ?></th>
                                        <th><?php _e("Subject", 'wsdesk'); ?></th>
                                        <th><?php _e("Requested", 'wsdesk'); ?></th>
                                        <th><?php _e("Assignee", 'wsdesk'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(empty($section_tickets_id))
                                        {
                                            echo '<tr class="except_view">
                                                <td colspan="12">'.__("No Tickets", 'wsdesk').' </td></tr>';
                                        }
                                        else
                                        {
                                            for($i=0;$i<count($section_tickets_id);$i++)
                                            {
                                                $current = eh_crm_get_ticket(array("ticket_id"=>$section_tickets_id[$i]['ticket_id']));
                                                $current_meta = eh_crm_get_ticketmeta($section_tickets_id[$i]['ticket_id']);
                                                $action_value = '';
                                                $eye_color='';
                                                for($j=0;$j<count($avail_labels);$j++)
                                                {
                                                    if(in_array("manage_tickets", $access))
                                                    {
                                                        $action_value .= '<li id="'.$current[0]['ticket_id'].'"><a href="#" class="single_ticket_action" id="'.$avail_labels[$j]['slug'].'">'.__("Mark as", 'wsdesk').' '.$avail_labels[$j]['title'].'</a></li>';

                                                    }
                                                    if($avail_labels[$j]['slug'] == $current_meta['ticket_label'])
                                                    {
                                                        $ticket_label_slug = $avail_labels[$j]['slug'];
                                                        $ticket_label = $avail_labels[$j]['title'];
                                                        $eye_color = eh_crm_get_settingsmeta($avail_labels[$j]['settings_id'], "label_color");
                                                    }
                                                }
                                                $ticket_raiser = $current[0]['ticket_email'];
                                                if($current[0]['ticket_author'] != 0)
                                                {
                                                    $current_user = new WP_User($current[0]['ticket_author']);
                                                    $ticket_raiser = $current_user->display_name;
                                                }
                                                $ticket_assignee_name =array();
                                                $ticket_assignee_email = array();
                                                if(isset($current_meta['ticket_assignee']))
                                                {
                                                    $current_assignee = $current_meta['ticket_assignee'];
                                                    for($k=0;$k<count($current_assignee);$k++)
                                                    {
                                                        for($l=0;$l<count($users_data);$l++)
                                                        {
                                                            if($users_data[$l]['id'] == $current_assignee[$k])
                                                            {
                                                                array_push($ticket_assignee_name, $users_data[$l]['name']);
                                                                array_push($ticket_assignee_email, $users_data[$l]['email']);
                                                            }
                                                        }
                                                    }
                                                }
                                                $ticket_assignee_name = empty($ticket_assignee_name)?__("No Assignee", 'wsdesk'):implode(", ", $ticket_assignee_name);
                                                $latest_reply_id = eh_crm_get_ticket_value_count("ticket_category","agent_note" ,true,"ticket_parent",$current[0]['ticket_id'],'ticket_id','DESC','1');
                                                $latest_content = array();
                                                $attach = "";
                                                if(!empty($latest_reply_id))
                                                {
                                                    $latest_ticket_reply = eh_crm_get_ticket(array("ticket_id"=>$latest_reply_id[0]["ticket_id"]));
                                                    $latest_content['content'] = html_entity_decode(stripslashes($latest_ticket_reply[0]['ticket_content']));
                                                    $latest_content['author_email'] = $latest_ticket_reply[0]['ticket_email'];
                                                    $latest_content['reply_date'] = $latest_ticket_reply[0]['ticket_date'];
                                                    if($latest_ticket_reply[0]['ticket_author'] != 0)
                                                    {
                                                        $reply_user = new WP_User($latest_ticket_reply[0]['ticket_author']);
                                                        $latest_content['author_name'] = $reply_user->display_name;
                                                    }
                                                    else
                                                    {
                                                        $latest_content['author_name'] = __("Guest", 'wsdesk');
                                                    }
                                                    $latest_reply_meta = eh_crm_get_ticketmeta($latest_reply_id[0]["ticket_id"]);
                                                    if(isset($latest_reply_meta['ticket_attachment']))
                                                    {
                                                        $attach = ' | <small class="glyphicon glyphicon-pushpin"></small> <small style="opacity:0.7;"> '.count($latest_reply_meta['ticket_attachment']).' '.__("Attachment", 'wsdesk').'</small>';
                                                    }
                                                }
                                                else
                                                {
                                                    $latest_content['content'] = html_entity_decode(stripslashes($current[0]['ticket_content']));
                                                    $latest_content['author_email'] = $current[0]['ticket_email'];
                                                    $latest_content['reply_date'] = $current[0]['ticket_date'];
                                                    if($current[0]['ticket_author'] != 0)
                                                    {
                                                        $current_user = new WP_User($current[0]['ticket_author']);
                                                        $latest_content['author_name'] = $current_user->display_name;
                                                    }
                                                    else
                                                    {
                                                        $latest_content['author_name'] = __("Guest", 'wsdesk');
                                                    }
                                                }
                                                $ticket_tags = "";
                                                if(!empty($avail_tags))
                                                {
                                                    for($j=0;$j<count($avail_tags);$j++)
                                                    {
                                                        $current_ticket_tags=(isset($current_meta['ticket_tags'])?$current_meta['ticket_tags']:array());
                                                        for($k=0;$k<count($current_ticket_tags);$k++)
                                                        {
                                                            if($avail_tags[$j]['slug'] == $current_ticket_tags[$k])
                                                            {
                                                                $ticket_tags .= '<span class="label label-info">#'.$avail_tags[$j]['title'].'</span>';
                                                            }
                                                        }
                                                    }
                                                }
                                                $ticket_rating = (isset($current_meta['ticket_rating'])?ucfirst($current_meta['ticket_rating']):__("None", 'wsdesk'));
                                                $raiser_voice = eh_crm_get_ticket_value_count("ticket_parent",$section_tickets_id[$i]['ticket_id'],false,"ticket_category","raiser_reply");
                                                $agent_voice = eh_crm_get_ticket_value_count("ticket_parent",$section_tickets_id[$i]['ticket_id'],false,"ticket_category","agent_reply");
                                                echo '
                                                <tr class="clickable ticket_row" id="'.$current[0]['ticket_id'].'">
                                                    <td class="except_view"><button class="btn btn-default btn-xs accordion-toggle quick_view_ticket" style="background-color: '.$eye_color.' !important" data-toggle="collapse" data-target="#search_expand_'.$current[0]['ticket_id'].'" ><span class="glyphicon glyphicon-eye-open"></span></button></td>
                                                    <td>'.$current[0]['ticket_id'].'</td>
                                                    <td>'.$ticket_raiser.'</td>
                                                    <td class="wrap_content" data-toggle="wsdesk_tooltip" title="'.$current[0]['ticket_title'].'" data-container="body">'.$current[0]['ticket_title'].'</td>
                                                    <td>'. eh_crm_get_formatted_date($latest_content['reply_date']).'</td>
                                                    <td>'.$ticket_assignee_name.'</td>
                                                </tr>
                                                <tr class="except_view">
                                                    <td colspan="12" class="hiddenRow">
                                                        <div class="accordian-body collapse" id="search_expand_'.$current[0]['ticket_id'].'">
                                                            <table class="table table-striped" style="margin-bottom: 0px !important">
                                                                <thead>
                                                                    <tr>
                                                                        <td colspan="12" style="white-space: normal;">
                                                                        <div style="padding:5px 0px;">
                                                                            <small class="glyphicon glyphicon-user"></small> <small style="opacity:0.7;">'.$latest_content['author_name'].'</small>
                                                                            | <small class="glyphicon glyphicon-envelope"></small> <small style="opacity:0.7;">'.$latest_content['author_email'].'</small>
                                                                            | <small class="glyphicon glyphicon-calendar"></small> <small style="opacity:0.7;">'. eh_crm_get_formatted_date($latest_content['reply_date']).'</small>
                                                                            '.$attach.'
                                                                        </div>
                                                                        <hr>
                                                                        <p>
                                                                            '.$latest_content['content'].'
                                                                        </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>'.__("Reply Requester", 'wsdesk').'</th>
                                                                        <th>'.__("Raiser Voices", 'wsdesk').'</th>
                                                                        <th>'.__("Agent Voices", 'wsdesk').'</th>
                                                                        <th>'.__("Tags", 'wsdesk').'</th>
                                                                        <th>'.__("Rating", 'wsdesk').'</th>
                                                                        <th>'.__("Source", 'wsdesk').'</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            '.$current[0]['ticket_email'].'
                                                                        </td>
                                                                        <td>'.count($raiser_voice).'</td>
                                                                        <td>'.count($agent_voice).'</td>
                                                                        <td>'.(($ticket_tags!="")?$ticket_tags:__("No Tags", 'wsdesk')).'</td>
                                                                        <td>'.$ticket_rating.'</td>
                                                                        <td>'.((isset($current_meta['ticket_source']))?$current_meta['ticket_source']:"").'</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>';
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
        
        static function eh_crm_ticket_add_new() {
            ob_start();
            $logged_user = wp_get_current_user();
            $logged_user_caps = array_keys($logged_user->caps);
            $avail_caps = array("reply_tickets","delete_tickets","manage_tickets");
            $access = array();
            if(!in_array("administrator", $logged_user->roles))
            {
                for($i=0;$i<count($logged_user_caps);$i++)
                {
                    if(!in_array($logged_user_caps[$i], $avail_caps))
                    {
                        unset($logged_user_caps[$i]);
                    }
                }
                $access = $logged_user_caps;
            }
            else
            {
                $access = $avail_caps;
            }
            $users_data = get_users(array("role__in" => array("administrator", "WSDesk_Agents", "WSDesk_Supervisor")));
            $users = array();
            for ($i = 0; $i < count($users_data); $i++) {
                $current_user = $users_data[$i];
                $temp = array();
                $roles = $current_user->roles;
                foreach ($roles as $value) {
                    $current_role = $value;
                    $temp[$i] = ucfirst(str_replace("_", " ", $current_role));
                }
                $users[implode(' & ', $temp)][$current_user->ID] = $current_user->data->display_name;
            }
            $avail_fields = eh_crm_get_settings(array("type" => "field"), array("slug", "title", "settings_id"));
            $selected_fields = eh_crm_get_settingsmeta(0, 'selected_fields');
            $avail_tags = eh_crm_get_settings(array("type" => "tag"),array("slug","title","settings_id"));
            $avail_labels = eh_crm_get_settings(array("type" => "label"), array("slug", "title", "settings_id"));
            $ticket_label = "";
            $ticket_label_slug ="";
            for($j=0;$j<count($avail_labels);$j++)
            {
                if($avail_labels[$j]['slug'] == eh_crm_get_settingsmeta(0, "default_label"))
                {
                    $ticket_label = $avail_labels[$j]['title'];
                    $ticket_label_slug = $avail_labels[$j]['slug'];
                }
            }
            $my_current_lang = apply_filters( 'wpml_current_language', NULL );
            do_action( 'wpml_switch_language', $my_current_lang );
            $blog_info = eh_crm_wpml_translations(get_bloginfo("name"), 'bloginfo', 'bloginfo');
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb col-md-8" style="margin: 0 !important;background: none !important;border:none;padding: 8px 0px !important; ">
                            <li><?php echo $blog_info; ?></li>
                            <li><?php _e("Support", 'wsdesk'); ?>Support</li>
                            <li class="active"><span class="label label-danger">#<?php _e("New", 'wsdesk'); ?></span></li>
                            <span class="spinner_loader ticket_loader_new">
                                <span class="bounce1"></span>
                                <span class="bounce2"></span>
                                <span class="bounce3"></span>
                            </span>
                        </ol>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-sm-4 col-md-3">
                        <div class="form-group">
                            <span class="help-block"><?php _e("Assignee", 'wsdesk'); ?></span>
                            <select id="assignee_ticket_new" class="form-control" aria-describedby="helpBlock" multiple="multiple">
                                <?php
                                    foreach ($users as $key => $value) {
                                        foreach ($value as $id => $name) {
                                            echo '<option value="' . $id . '">'.$name.' | '.$key.'</option>';
                                        }                                      
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="help-block"><?php _e("Tags", 'wsdesk'); ?></span>
                            <select id="tags_ticket_new" class="form-control crm-form-element-input" multiple="multiple">
                                <?php
                                if(!empty($avail_tags))
                                {
                                    for($i=0;$i<count($avail_tags);$i++)
                                    {
                                        echo '<option value="' . $avail_tags[$i]['slug'] . '">'.$avail_tags[$i]['title'].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <hr>
                        <?php
                        for ($i = 0; $i < count($selected_fields); $i++) {
                            for ($j = 3; $j < count($avail_fields); $j++) {
                                if ($avail_fields[$j]['slug'] == $selected_fields[$i]) {
                                    $current_settings_meta = eh_crm_get_settingsmeta($avail_fields[$j]['settings_id']);
                                    $required = (isset($current_settings_meta['field_require_agent'])?$current_settings_meta['field_require_agent']:'');
                                    $required = ($required === "yes")?'required':'';
                                    if($current_settings_meta['field_type'] != "file" && $current_settings_meta['field_type'] != "google_captcha")
                                    {
                                        echo '<div class="form-group">';
                                        if($current_settings_meta['field_type'] == 'ip')
                                        {
                                            echo '<span class="help-block">' . $current_settings_meta['field_description'];
                                        }
                                        else
                                        {
                                            echo '<span class="help-block">' . $avail_fields[$j]['title'];
                                        }
                                        echo ($required === 'required') ? '<span class="input_required"> *</span></span>' : '</span>';
                                        switch($current_settings_meta['field_type'])
                                        {
                                            case 'text':
                                                $required_text = '';
                                                if($required == 'required')
                                                {
                                                    $required_text = 'text_required';
                                                }
                                                echo '<input type="text" AUTOCOMPLETE="off" class="form-control '.$required_text.' crm-form-element-input ticket_input_text_new" id="'.$avail_fields[$j]['slug'].'" placeholder="'.$current_settings_meta['field_placeholder'].'">';
                                                break;
                                            case 'ip':
                                                echo '<input type="hidden" value="'.$_SERVER['REMOTE_ADDR'].'" class="ticket_input_ip_new" id="'.$avail_fields[$j]['slug'].'" >';
                                                break;
                                            case 'date':
                                                $required_text = '';
                                                if($required == 'required')
                                                {
                                                    $required_text = 'text_required';
                                                }
                                                echo '<input type="text" AUTOCOMPLETE="off" class="form-control '.$required_text.' crm-form-element-input ticket_input_date_new" id="'.$avail_fields[$j]['slug'].'" placeholder="'.$current_settings_meta['field_placeholder'].'">';
                                                break;
                                            case 'email':
                                                $required_text = '';
                                                if($required == 'required')
                                                {
                                                    $required_text = 'text_required';
                                                }
                                                echo '<input type="email" AUTOCOMPLETE="off" class="form-control '.$required_text.' crm-form-element-input ticket_input_email_new" id="'.$avail_fields[$j]['slug'].'" placeholder="'.$current_settings_meta['field_placeholder'].'">';
                                                break;
                                            case 'phone':
                                                if($required == 'required')
                                                {
                                                    $required_text = 'text_required';
                                                }
                                                echo '<span><strong>+</strong><input type="number" AUTOCOMPLETE="off" class="form-control '.$required_text.' crm-form-element-input ticket_input_number_new" id="'.$avail_fields[$j]['slug'].'" placeholder="'.$current_settings_meta['field_placeholder'].'" style="display: inline !important; width: 97% !important"></span>';
                                                break;
                                            case 'number':
                                                $required_text = '';
                                                if($required == 'required')
                                                {
                                                    $required_text = 'text_required';
                                                }
                                                echo '<input type="number" AUTOCOMPLETE="off" class="form-control '.$required_text.' crm-form-element-input ticket_input_number_new" id="'.$avail_fields[$j]['slug'].'" placeholder="'.$current_settings_meta['field_placeholder'].'">';
                                                break;
                                            case 'password':
                                                $required_text = '';
                                                if($required == 'required')
                                                {
                                                    $required_text = 'text_required';
                                                }
                                                echo '<input type="password" AUTOCOMPLETE="false" readonly class="form-control '.$required_text.' crm-form-element-input ticket_input_pwd_new" id="'.$avail_fields[$j]['slug'].'" placeholder="'.$current_settings_meta['field_placeholder'].'" onfocus="this.removeAttribute(\'readonly\');">';
                                                break;
                                            case 'select':
                                                $field_values = $current_settings_meta['field_values'];
                                                $required_text = '';
                                                if($required == 'required')
                                                {
                                                    $required_text = 'text_required';
                                                }
                                                echo '<select class="form-control crm-form-element-input '.$required_text.' ticket_input_select_new" id="'.$avail_fields[$j]['slug'].'">';
                                                echo '<option value="">'.(isset($current_settings_meta['field_placeholder'])?htmlentities($current_settings_meta['field_placeholder']):'-').'</option>';
                                                foreach($field_values as $key => $value)
                                                {
                                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                                }
                                                echo '</select>';
                                                break;
                                            case 'radio':
                                                $required_radio = '';
                                                if($required == 'required')
                                                {
                                                    $required_radio = 'radio_required';
                                                }
                                                $field_values = $current_settings_meta['field_values'];
                                                echo '<span style="vertical-align: middle;">';
                                                foreach($field_values as $key => $value)
                                                {
                                                    echo '<input type="radio" style="margin-top: 0;" id="'.$avail_fields[$j]['slug'].'" name="'.$avail_fields[$j]['slug'].'" class="form-control '.$required_radio.' ticket_input_radio_new" value="'.$key.'"> '.$value.'<br>';

                                                }
                                                echo "</span>";
                                                break;
                                            case 'checkbox':
                                                $required_check = '';
                                                if($required == 'required')
                                                {
                                                    $required_check = 'check_required';
                                                }
                                                $field_values = $current_settings_meta['field_values'];
                                                echo '<span style="vertical-align: middle;">';
                                                foreach($field_values as $key => $value)
                                                {
                                                    echo '<input type="checkbox" style="margin-top: 0;" id="'.$avail_fields[$j]['slug'].'" class="form-control '.$required_check.' ticket_input_checkbox_new" value="'.$key.'"> '.$value.'<br>';
                                                }
                                                echo "</span>";
                                                break;
                                            case 'textarea':
                                                $required_text = '';
                                                if($required == 'required')
                                                {
                                                    $required_text = 'text_required';
                                                }
                                                echo '<textarea class="form-control '.$required_text.' ticket_input_textarea_new" id="'.$avail_fields[$j]['slug'].'" ></textarea>';
                                                break;
                                        }
                                        echo '</div>';
                                    }
                                }
                            }
                        }
                    ?>
                    </div>
                    <div class="col-sm-10 col-md-9">
                        <div class="panel panel-default new_ticket_panel">
                            <div class="panel-heading">
                                <p style="margin-top: 5px;font-size: 16px;">
                                    <?php
                                        echo '<div class="form-group"><span class="help-block">'.__("Raiser Email", 'wsdesk').' : </span><input type="email" id="ticket_email_new" class="form-control crm-form-element-input"></div>';
                                        echo '<div class="form-group"><span class="help-block">'.__("Ticket Subject", 'wsdesk').' : </span><input type="text" id="ticket_title_new" class="form-control crm-form-element-input"></div>';
                                    ?>      
                                </p>
                            </div>
                            <div class="panel-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row" style="margin-bottom: 20px;">
                                                <div class="col-md-12">
                                                    <div class="widget-area no-padding blank" style="width:100%">
                                                        <div class="status-upload">
                                                            <div class="form-group" style="padding: 5px 5px !important;">
                                                                <span class="help-block"><?php _e("Description", 'wsdesk'); ?></span>
                                                                <div rows="10" cols="30" class="form-control reply_textarea" id="reply_textarea_new" name="reply_textarea_new"></div> 
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group col-md-12">
                                                                    <span class="btn btn-primary fileinput-button">
                                                                        <i class="glyphicon glyphicon-plus"></i>
                                                                        <span><?php _e("Attachment", 'wsdesk'); ?></span>
                                                                        <input type="file" name="files" id="files_new" class="attachment_reply" multiple="">
                                                                    </span>
                                                                    <div class="btn-group pull-right">
                                                                        <button type="button" class="btn btn-primary dropdown-toggle ticket_reply_action_button_new" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <?php _e("Submit as", 'wsdesk'); ?> <span class="caret"></span>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <?php
                                                                                if(in_array("manage_tickets", $access))
                                                                                {
                                                                                    for($j=0;$j<count($avail_labels);$j++)
                                                                                    {
                                                                                        echo '<li id="new"><a href="#" class="ticket_submit_new" id="'.$avail_labels[$j]['slug'].'">'.__("Submit as", 'wsdesk').' '.$avail_labels[$j]['title'].'</a></li>';
                                                                                    }
                                                                                }
                                                                                else
                                                                                {
                                                                                    echo '<li id="new"><a href="#" class="ticket_submit_new" id="'.$ticket_label_slug.'">'.__("Submit as", 'wsdesk').' '.$ticket_label.'</a></li>';
                                                                                }
                                                                            ?>
                                                                        </ul>
                                                                      </div>
                                                                      <div class="btn-group pull-right" style="padding: 0px;margin-right: 10px;height: 35px;">
                                                                        <button type="button" class="btn btn-primary dropdown-toggle mulitple_ticket_template_button" data-toggle="dropdown">
                                                                            <span class="glyphicon glyphicon-envelope" style="margin-right:5px;"></span> <?php _e('Select Template','wsdesk'); ?> <span class="caret"></span>
                                                                        </button>
                                                                        <ul class="dropdown-menu list-group dropdown-menu-left" id="template_multiple_actions_single_new" style="min-width:250px" role="menu">
                                                                            <li>
                                                                                <div class="template_div asg">
                                                                                    <div style="visibility: visible;"></div>
                                                                                    <input type="text" class="search_template_single" id="new" placeholder="Search Template">
                                                                                    <div class="A0 A0_n"><span class="glyphicon glyphicon-search"></span></div>
                                                                                </div>
                                                                            </li>
                                                                            <li role="separator" class="divider" style="margin:0px; margin-bottom:5px !important;margin-top: 5px !important;"></li>
                                                                            <?php
                                                                            $avail_templates = eh_crm_get_settings(array("type" => "template"), array("slug", "title", "settings_id"));
                                                                            if(!$avail_templates) $avail_templates = array();
                                                                            if(!empty($avail_templates))
                                                                            {
                                                                                for($i=0;$i<count($avail_templates)&&$i<6;$i++)
                                                                                {
                                                                                    echo '<li class="list-group-item available_template available_template_new '.$avail_templates[$i]['slug'].'_li" id="new" title="'.$avail_templates[$i]['title'].'"> <span style="display: block;" class="truncate multiple_template_action '.$avail_templates[$i]['slug'].'_head" based="single" id="'.$avail_templates[$i]['slug'].'">'.$avail_templates[$i]['title'].'</span></li>';
                                                                                }
                                                                                if($i==6)
                                                                                {
                                                                                    echo '<li role="separator" class="divider available_template available_template_new" style="margin:0px; margin-bottom:5px !important;margin-top: 5px !important;"></li>';
                                                                                    echo '<center><a href="#wsdesk-template-wsdesk-popup-2">'.(count($avail_templates)-6)." more template".((count($avail_templates)-6)==1? ' is':"s are")." there".'</a></center>';
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="upload_preview_files_new"></div>
                                                            </div>
                                                        </div><!-- Status Upload  -->
                                                    </div><!-- Widget Area -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="wsdesk-template-wsdesk-popup-2" class="wsdesk-overlay">
                <div class="wsdesk-popup">
                    <div class="wsdesk-overlay-success" style="display: none;color:green">
                        <?php _e('Template Added !','wsdesk');?>
                    </div>
                    <h4>Available Templates</h4>
                    <a class="close" href="#">&times;</a>
                    <div class="content">
                        <?php
                            if(!empty($avail_templates))
                            {
                                for($i=0;$i<count($avail_templates);$i++)
                                {
                                    echo '<li class="list-group-item available_template available_template_new '.$avail_templates[$i]['slug'].'_li" id="new" title="'.$avail_templates[$i]['title'].'"> <span style="display: block;" class="truncate multiple_template_action '.$avail_templates[$i]['slug'].'_head" based="single" id="'.$avail_templates[$i]['slug'].'">'.$avail_templates[$i]['title'].'</span></li>';
                                }
                            }?>
                    </div>
                </div>
            </div>
            <?php
            $content = ob_get_clean();
            $tab = '<a href="#tab_content_new" id="tab_content_a_new" aria-controls="#new" role="tab" data-toggle="tab" class="tab_a" style="font-size: 12px;padding: 11px 5px;margin-right:0px !important;"><button type="button" class="btn btn-default btn-circle close_tab pull-right"><span class="glyphicon glyphicon-remove"></span></button><div class="badge">#New Ticket</div><span></span></a>';
            die(json_encode(array("tab_head"=>$tab,"tab_content"=>$content)));
        }
        
        static function eh_crm_ticket_new_submit() {
            $email = sanitize_text_field($_POST['email']);
            $title = sanitize_text_field($_POST['title']);
            $desc = str_replace("\n", '<br/>', $_POST['desc']);
            $submit = sanitize_text_field($_POST['submit']);
            $assignee = ((sanitize_text_field($_POST['assignee']) !== '')?explode(",", sanitize_text_field($_POST['assignee'])):array());
            $tags = ((sanitize_text_field($_POST['tags']) !== '')?explode(",", sanitize_text_field($_POST['tags'])):array());
            $input = json_decode(stripslashes(sanitize_text_field($_POST['input'])), true);
            $files = isset($_FILES["file"])?$_FILES["file"]:"";
            $vendor = "";
            if(EH_CRM_WOO_VENDOR)
            {
                $vendor = EH_CRM_WOO_VENDOR;
            }
            $id = email_exists($email);
            $args = array(
                'ticket_author' => (($id)?$id:0),
                'ticket_email' => $email,
                'ticket_title' => $title,
                'ticket_content' => $desc,
                'ticket_category' => 'raiser_reply',
                'ticket_vendor' => $vendor
            );
            $meta = array();
            $meta['ticket_assignee'] = $assignee;
            $meta['ticket_tags'] = $tags;
            foreach ($input as $key => $value) {
                $meta[$key] = $value;
            }
            if(isset($_FILES["file"]) && !empty($_FILES['file']))
            {   
                $attachment_data = CRM_Ajax::eh_crm_ticket_file_handler($files);
                $meta["ticket_attachment"] = $attachment_data['url'];
                $meta["ticket_attachment_path"] = $attachment_data['path'];
            }
            $meta['ticket_label'] = $submit;
            $meta['ticket_source'] = "Agent";
            $id=eh_crm_insert_ticket($args,$meta);
            $send = eh_crm_get_settingsmeta('0', "auto_send_creation_email");
            $response = array();
            if($send == 'enable')
            {
                eh_crm_debug_error_log(" ------------- WSDesk Email Debug Started ------------- ");
                eh_crm_debug_error_log("New ticket by Agent auto Email for Ticket #".$id);
                eh_crm_debug_error_log("Email function called for New Ticket #".$id);
                $response = CRM_Ajax::eh_crm_fire_email("new_ticket", $id);
                eh_crm_debug_error_log(" ------------- WSDesk Email Debug Ended ------------- ");
            }
            $content_html = CRM_Ajax::eh_crm_ticket_single_view_gen($id);
            $tab = CRM_Ajax::eh_crm_ticket_single_view_gen_head($id);
            die(json_encode(array("tab_head"=>$tab,"tab_content"=>$content_html,"id"=>$id,'response'=>$response)));
        }   
        static function eh_crm_check_ticket_request() {
            $url = sanitize_text_field($_POST['url']);
            $slug = json_decode(stripslashes($_POST['slug']));
            $current_page = sanitize_text_field(isset($_POST['wsdesk_current_page'])?$_POST['wsdesk_current_page']:1);
            $filter_label = sanitize_text_field(isset($_POST['label'])?$_POST['label']:'all');
            $search_tickets = sanitize_text_field(isset($_POST['search_tickets'])?$_POST['search_tickets']:'');
            if(is_user_logged_in())
            {
               $user_id = get_current_user_id();
               $user = new WP_User($user_id);
               $email = $user->user_email;
               $content = CRM_Ajax::eh_crm_user_ticket_fetch($email, $user_id,$slug, $current_page, $filter_label, $search_tickets);
               die(json_encode(array("status"=>"success","content"=>$content)));
            }
            else
            {
                $exisiting_tickets_login_label = eh_crm_get_settingsmeta(0, "exisiting_tickets_login_label");
                $exisiting_tickets_register_label = eh_crm_get_settingsmeta(0, "exisiting_tickets_register_label");
                if(empty($exisiting_tickets_login_label))
                {
                    $exisiting_tickets_login_label = __('You must Login to Check your Existing Ticket', 'wsdesk');
                }
                else
                {
                    $exisiting_tickets_login_label = eh_crm_wpml_translations($exisiting_tickets_login_label, 'exisiting_tickets_login_label', 'exisiting_tickets_login_label');
                }
                if(empty($exisiting_tickets_register_label))
                {
                    $exisiting_tickets_register_label = __('Need an Account?', 'wsdesk');
                }
                else
                {
                    $exisiting_tickets_register_label = eh_crm_wpml_translations($exisiting_tickets_register_label, 'exisiting_tickets_register_label', 'exisiting_tickets_register_label');
                }
                $url = wp_registration_url();
                $urll= $url."&redirect_to=".urlencode($_SERVER['HTTP_REFERER']);
                $content = '<div class="form-elements"><span>'.$exisiting_tickets_login_label.'</span><br><a class="btn btn-primary" href="'.wp_login_url($_SERVER['HTTP_REFERER']).'">'.__('Login', 'wsdesk').'</a></div>';
                $content .= '<div class="form-elements"><span>'.$exisiting_tickets_register_label.'</span><br><a class="btn btn-primary" href="'. $urll.'">'.__('Register', 'wsdesk').'</a></div>';
                die(json_encode(array("status"=>"success","content"=>$content)));
            }
        }
        static function eh_crm_user_ticket_fetch($email,$user,$slug = array(), $current_page, $filter_label, $search_tickets) {
            $tickets_per_page = 25;
            $email_id = eh_crm_get_ticket_value_count("ticket_email", $email,false,"ticket_parent",0, 'ticket_updated');
            $user_id = eh_crm_get_ticket_value_count("ticket_author", $user,false,"ticket_parent",0, 'ticket_updated');
            $ticket = array_values(array_unique(array_merge($user_id, $email_id),SORT_REGULAR));
            if(empty($ticket))
            {
                return __('No Tickets Found', 'wsdesk');
            }
            if($filter_label != 'all')
            {
                $filter_label_tickets = array();
                for($i=0; $i<count($ticket);  $i++)
                {
                    $current_meta = eh_crm_get_ticketmeta($ticket[$i]['ticket_id']);
                    if($current_meta['ticket_label'] == $filter_label)
                    {
                        array_push($filter_label_tickets, $ticket[$i]);
                    }
                }
                $ticket = $filter_label_tickets;
            }
            if($search_tickets != '')
            {
                $searched_tickets = array();
                for($i=0; $i<count($ticket);  $i++)
                {
                    $current = eh_crm_get_ticket(array('ticket_id'=>$ticket[$i]['ticket_id']));
                    if((strpos($current[0]['ticket_title'], $search_tickets) !== false || strpos($current[0]['ticket_content'], $search_tickets) !== false) || $search_tickets == $ticket[$i]['ticket_id'] )
                    {
                        array_push($searched_tickets, $ticket[$i]);
                    }
                }
                $ticket = $searched_tickets;
            }
            $user_roles_default = array("WSDesk_Agents", "WSDesk_Supervisor","administrator");
            $users = get_users(array("role__in" => $user_roles_default));
            $users_data = array();
            for ($i = 0; $i < count($users); $i++) {
                $current = $users[$i];
                $id = $current->ID;
                $user = new WP_User($id);
                $users_data[$i]['id'] = $id;
                $users_data[$i]['name'] = $user->display_name;
                $users_data[$i]['caps'] = $user->caps;
                $users_data[$i]['email'] = $user->user_email;
            }
            $avail_labels = eh_crm_get_settings(array("type" => "label"), array("slug", "title", "settings_id"));
            $avail_fields = eh_crm_get_settings(array("type" => "field"), array("slug", "title", "settings_id"));
            $enable = eh_crm_get_settingsmeta('0', "close_tickets");
            if(!$enable)
            {
                $enable = 'enable';
            }
            $pages = floor(count($ticket)/$tickets_per_page);
            if(count($ticket)%$tickets_per_page)
            {
                $pages++;
            }
            $right_disable = '';
            if($current_page == $pages)
            {
                $right_disable = 'disabled';
            }
            $left_disable = '';
            if($current_page == 1)
            {
                $left_disable = 'disabled';
            }

            $args = array("type" => "label");
            $fields = array("slug","title","settings_id");
            $avail_labels= eh_crm_get_settings($args,$fields);
            ob_start();
            ?>
                <div class="panel panel-default tickets_panel" style="width:1000px; overflow-x: scroll">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle filter_pagination_search pull-right" type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-filter"></span></button>
                                <ul class="dropdown-menu pull-right filter_dropdown">
                                    <?php
                                        if(!empty($avail_labels))
                                        {
                                            echo '<li><a href="#" class="filter_label" id="all">'.__('Show All','wsdesk').'</a></li>';
                                            for($i=0;$i<count($avail_labels);$i++)
                                            {
                                                $label_title = eh_crm_wpml_translations($avail_labels[$i]['title'], 'labels_'.$i.'_title', 'labels_'.$i.'_title');
                                                echo '<li><a href="#" class="filter_label" id="'.$avail_labels[$i]['slug'].'">'.__('Show ','wsdesk').$avail_labels[$i]['title'].'</a></li>';
                                            }
                                        }
                                    ?>
                                </ul>
                            </div>
                            <input type="hidden" value="all" id="filter_label_input">
                            <button type="button" <?php echo $right_disable; ?> class="btn filter_pagination_search pull-right" id="right_page"><span class="glyphicon glyphicon-chevron-right"></span></button>
                            <span class="filter_pagination_search pull-right wsdesk_current_page" id="<?php echo $current_page; ?>"><?php echo $current_page;?></span>
                            <button type="button" <?php echo $left_disable; ?> class="btn filter_pagination_search pull-right" id="left_page"><span class="glyphicon glyphicon-chevron-left"></span></button>
                            <div class="filter_pagination_search pull-right" style="position: relative">
                                <span class="glyphicon glyphicon-search pull-right" id="search_ticket_icon"></span>
                                <input type="text" name="search_tickets" id="search_tickets" class="filter_pagination_search" value="<?php echo $search_tickets; ?>" placeholder="<?php _e("Search Tickets", "wsdesk");?>">
                                
                            </div>

                            <button type="submit" class="filter-each btn btn-primary" id="submit_check_all" style="display:none;margin-right: 2em;"> <?php _e("Close Ticket(s)", 'wsdesk');?>
                            </button>
                            <?php _e("Your Tickets", 'wsdesk'); ?>
                            <span class="spinner_loader table_loader">
                                <span class="bounce1"></span>
                                <span class="bounce2"></span>
                                <span class="bounce3"></span>
                            </span>
                        </h3>
                    </div>
                    <table class="table table-hover" id="support-table">
                        <thead>
                            <tr class="except_view">
                                <?php if($enable == 'enable'){?>
                                <th><div class="filter-each"><input type="checkbox" class="ticket_select_all_check"></div></th>
                                <?php }?>
                                <th>#</th>
                                <th><?php _e("Subject", 'wsdesk'); ?></th>
                                <th><?php _e("Requested", 'wsdesk'); ?></th>
                                <th><?php _e("Assignee", 'wsdesk'); ?></th>
                                <th><?php _e("Status", 'wsdesk'); ?></th>
                                <?php  
                                    if(!empty($slug))
                                    {
                                        $selected_fields = eh_crm_get_settingsmeta(0, 'selected_fields');
                                        foreach($slug as $value)
                                        { 
                                            if(in_array($value,$selected_fields))
                                            {         
                                                for($j=0;$j<count($avail_fields);$j++)
                                                {
                                                    if($avail_fields[$j]['slug'] == $value)
                                                    {   
                                                        $avail_fields_title = eh_crm_wpml_translations($avail_fields[$j]['title'], $avail_fields[$j].'_fields_title', $avail_fields[$j].'_fields_title');
                                ?>                      <th><?php echo $avail_fields_title; ?></th>
                                <?php               }

                                                }  
                                            }    
                                        }

                                    }?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(!empty($ticket))
                                {
                                    for($i=($tickets_per_page*($current_page-1));$i<$tickets_per_page*$current_page && $i<count($ticket);$i++)
                                    {
                                        $current = eh_crm_get_ticket(array('ticket_id'=>$ticket[$i]['ticket_id']));
                                        $current_meta = eh_crm_get_ticketmeta($ticket[$i]['ticket_id']);
                                        $eye_color='';
                                        $label_name='';
                                        for($j=0;$j<count($avail_labels);$j++)
                                        {
                                            if($avail_labels[$j]['slug'] == $current_meta['ticket_label'])
                                            {
                                                $label_name = $avail_labels[$j]['title'];
                                                $eye_color = eh_crm_get_settingsmeta($avail_labels[$j]['settings_id'], "label_color");
                                            }
                                        }
                                        $ticket_assignee_name =array();
                                        if(isset($current_meta['ticket_assignee']))
                                        {
                                            $current_assignee = $current_meta['ticket_assignee'];
                                            for($k=0;$k<count($current_assignee);$k++)
                                            {
                                                for($l=0;$l<count($users_data);$l++)
                                                {
                                                    if($users_data[$l]['id'] == $current_assignee[$k])
                                                    {
                                                        array_push($ticket_assignee_name, $users_data[$l]['name']);
                                                    }
                                                }
                                            }
                                        }
                                        $ticket_assignee_name = empty($ticket_assignee_name)?__("No Assignee", 'wsdesk'):implode(", ", $ticket_assignee_name);
                                        
                                        echo  '<tr class="ticket_row" id="'.$current[0]['ticket_id'].'">';
                                        
                                            if($enable == 'enable')
                                            {
                                                echo'  <td class="except_view"><input type="checkbox" name="check" class="ticket_select_check" id="ticket_select_check" value="'.$current[0]['ticket_id'].'"></td>';
                                            }
                                            $ticket_title = eh_crm_wpml_translations($current[0]['ticket_title'], $ticket[$i]['ticket_id'].'_ticket_title', $ticket[$i]['ticket_id'].'_ticket_title');
                                            $label_name = eh_crm_wpml_translations($label_name, $ticket[$i]['ticket_id'].'_label_name', $ticket[$i]['ticket_id'].'_label_name');
                                            echo'
                                            <td><a href="'.eh_get_url_by_shortcode('[wsdesk_support display="form_support_request_table"').'?customer_ticket_num='.$current[0]['ticket_id'].'" target="_blank">'.$current[0]['ticket_id'].'</a></td>
                                            <td class="wrap_content"><a href="'.eh_get_url_by_shortcode('[wsdesk_support display="form_support_request_table"').'?customer_ticket_num='.$current[0]['ticket_id'].'" target="_blank">'.$ticket_title.'</a></td>
                                            <td>'. eh_crm_get_formatted_date($current[0]['ticket_date']).'</td>
                                            <td>'.$ticket_assignee_name.'</td>
                                            <td><span class="label label-info" style="background-color:'.$eye_color.' !important">'.$label_name.'</td>';
                                            if(!empty($slug))
                                            {   
                                                foreach ($slug as $value)
                                                {
                                                    if(array_key_exists($value,$current_meta))
                                                    {
                                                        if(!empty($current_meta[$value]))
                                                        {   
                                                            $field_id = eh_crm_get_settings(array('slug'=>$value), 'settings_id');
                                                            $field_meta = eh_crm_get_settingsmeta($field_id[0]['settings_id']);
                                                            switch($field_meta['field_type'])
                                                            {
                                                                case "text":
                                                                case "number":
                                                                case "email":
                                                                case "password":
                                                                case 'textarea':
                                                                case 'date':
                                                                case 'ip':
                                                                case 'phone':
                                                                    echo '<td>'.$current_meta[$value].'</td>';
                                                                    break;
                                                                case 'select':
                                                                    if($value == 'woo_order_id')
                                                                    {
                                                                        echo '<td>'.$current_meta[$value].'</td>';
                                                                    }
                                                                    else
                                                                    {
                                                                        echo '<td>'.$field_meta['field_values'][$current_meta[$value]].'</td>';
                                                                    }
                                                                    break;
                                                                case "radio":
                                                                case 'woo_product':
                                                                case 'woo_category':
                                                                case 'woo_tags':
                                                                case 'woo_vendors':
                                                                    echo '<td>'.$field_meta['field_values'][$current_meta[$value]].'</td>';
                                                                    break;
                                                                case "checkbox":
                                                                    $checkbox_values = array();
                                                                    foreach($current_meta[$value] as $a)
                                                                    {
                                                                        array_push($checkbox_values, $field_meta['field_values'][$a]);
                                                                    }
                                                                    echo '<td>'.implode(', ', $checkbox_values).'</td>';
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo '<td> </td>';
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo '<td> </td>';
                                                    }
                                                }
                                            }
                                        echo'</tr>';
                                    }
                                }
                                else
                                {
                                    echo'<tr class="except_view">
                                            <td colspan="5">'.__("No Tickets", 'wsdesk').'</td>
                                        </tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                    <hr/>
                <div class="ticket_load_content" style="padding:5px !important"></div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
        static function eh_crm_ticket_close_check_request()
        {
            $id_get = array();
            $id_get = json_decode(stripslashes($_POST['val']));
            for($i=0;$i<count($id_get);$i++)
            {
                eh_crm_update_ticketmeta($id_get[$i], "ticket_label", 'label_LL02');
                
            }
            die();
        }
        
        static function eh_crm_ticket_single_view_client() {
            $ticket_id = $_POST['ticket_id'];
            $content = CRM_Ajax::eh_crm_ticket_single_view_client_gen($ticket_id);
            die($content);
        }
        
        static function eh_crm_ticket_single_view_client_gen($ticket_id) {
            $current = eh_crm_get_ticket(array("ticket_id"=>$ticket_id));
            $current_meta = eh_crm_get_ticketmeta($ticket_id);
            $users_data = get_users(array("role__in" => array("administrator", "WSDesk_Agents", "WSDesk_Supervisor")));
            $users = array();
            for ($i = 0; $i < count($users_data); $i++) {
                $current_user = $users_data[$i];
                $temp = array();
                $roles = $current_user->roles;
                foreach ($roles as $value) {
                    $current_role = $value;
                    $temp[$i] = ucfirst(str_replace("_", " ", $current_role));
                }
                $users[implode(' & ', $temp)][$current_user->ID] = $current_user->data->display_name;
            }
            $avail_tags = eh_crm_get_settings(array("type" => "tag"),array("slug","title","settings_id"));
            $avail_labels = eh_crm_get_settings(array("type" => "label"), array("slug", "title", "settings_id"));
            $ticket_label = "";
            $ticket_label_slug ="";
            $eye_color = "";
            $enable = eh_crm_get_settingsmeta('0', "close_tickets");
            if(!$enable)
            {
                $enable = 'enable';
            }
            for($j=0;$j<count($avail_labels);$j++)
            {
                if($avail_labels[$j]['slug'] == $current_meta['ticket_label'])
                {
                    $ticket_label = $avail_labels[$j]['title'];
                    $ticket_label_slug = $avail_labels[$j]['slug'];
                }
                if($avail_labels[$j]['slug'] == $current_meta['ticket_label'])
                {
                    $eye_color = eh_crm_get_settingsmeta($avail_labels[$j]['settings_id'], "label_color");
                }
            }
            $ticket_tags_list = "";
            $response = array();
            $co = 0;
            if(!empty($avail_tags))
            {
                for($j=0;$j<count($avail_tags);$j++)
                {
                    $current_ticket_tags=(isset($current_meta['ticket_tags'])?$current_meta['ticket_tags']:array());
                    for($k=0;$k<count($current_ticket_tags);$k++)
                    {
                        if($avail_tags[$j]['slug'] == $current_ticket_tags[$k])
                        {
                            $args_post = array(
                                'orderby' => 'ID',
                                'numberposts' => -1,
                                'post_type' => array('post', 'product'),
                                'post__in' => eh_crm_get_settingsmeta($avail_tags[$j]['settings_id'], 'tag_posts')
                            );
                            $posts = get_posts($args_post);
                            for ($m = 0; $m < count($posts); $m++,$co++) {
                                $response[$co]['title'] = $posts[$m]->post_title;
                                $response[$co]['guid'] = $posts[$m]->guid;
                            }
                            $ticket_tags_list .= '<span class="label label-info">#'.$avail_tags[$j]['title'].'</span>';
                        }
                    }
                }
            }
            ob_start();
            $my_current_lang = apply_filters( 'wpml_current_language', NULL );
            do_action( 'wpml_switch_language', $my_current_lang );
            $blog_info = eh_crm_wpml_translations(get_bloginfo("name"), 'bloginfo', 'bloginfo');
            $ticket_label = eh_crm_wpml_translations($ticket_label, 'ticket_label_title', 'ticket_label_title');
            ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb col-md-12" style="margin: 0 !important;background: none !important;border:none;padding: 8px 0px !important; ">
                            <li><?php echo $blog_info ?></li>
                            <li><?php _e("Support", 'wsdesk'); ?></li>
                            <li><?php echo $ticket_label; ?></li>
                            <li class="active"><span class="label label-success" style="background-color:<?php echo $eye_color; ?> !important"><?php _e('Ticket','wsdesk'); ?> #<?php echo $ticket_id; ?></span></li>
                            <span class="spinner_loader ticket_loader_<?php echo $ticket_id; ?>">
                                <span class="bounce1"></span>
                                <span class="bounce2"></span>
                                <span class="bounce3"></span>
                            </span>
                        </ol>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="panel panel-default single_ticket_panel Ws-content-detail-full" id="<?php echo $ticket_id;?>">
                            
                            <div class="rightPanel" style="border-left: none;">
                                
                                <div class="panel-heading rightPanelHeader" style="width:100.5% !important;">
                                    <div class="leftFreeSpace">
                                        <div class="icon" style="top: 5% !important;"><img src="<?php echo EH_CRM_MAIN_IMG.'message_icon.png'?>"></div>
                                        <div class="tictxt">
                                <p style="margin-top: 5px;font-size: 16px;">
                                    <?php
                                        echo $current[0]['ticket_title'];
                                    ?>
                                    <span class="spinner_loader ticket_loader">
                                        <span class="bounce1"></span>
                                        <span class="bounce2"></span>
                                        <span class="bounce3"></span>
                                    </span>
                                </p>
                                <p class="info" style="margin-top: 5px;">
    <!--                                <i class="glyphicon glyphicon-user"></i> by-->
                                    <?php
                                        if($current[0]['ticket_author'] != 0)
                                        {
                                            $raiser_obj = new WP_User($current[0]['ticket_author']);
                                            echo $raiser_obj->display_name;
                                        }
                                        else
                                        {
                                            echo '<span>'.$current[0]['ticket_email'].'</span>';
                                        }
                                    ?>
                                    | <i class="glyphicon glyphicon-calendar"></i> <?php echo eh_crm_get_formatted_date($current[0]['ticket_date']); ?>
                                    | <i class="glyphicon glyphicon-comment"></i>
                                    <?php
                                        $raiser_voice = eh_crm_get_ticket_value_count("ticket_parent",$ticket_id,false,"ticket_category","raiser_reply");
                                        echo count($raiser_voice)." ".__("Raiser Voice", 'wsdesk');                                    
                                    ?>
                                    | <i class="glyphicon glyphicon-bullhorn"></i>
                                    <?php
                                        $agent_voice = eh_crm_get_ticket_value_count("ticket_parent",$ticket_id,false,"ticket_category","agent_reply");
                                        echo count($agent_voice)." ".__("Agent Voice", 'wsdesk');
                                    ?>
                                </p>
                                <p class="info" style="margin-top: 5px;">
                                    <i class="glyphicon glyphicon-tags"></i> <?php _e("Tags", 'wsdesk'); ?> : <?php echo (($ticket_tags_list!="")?$ticket_tags_list:__("No Tags", 'wsdesk')); ?>
                                </p>
                                        </div>
                                        </div>
                            </div>
                                
                                
                                
                                    <div class="row row-collapse">
                                        <div class="col-md-12 ">
                                            <div class="row newMsgFull row-collapse" style="margin-bottom: 20px; padding-left:35px;">
                                                <div class="leftFreeSpace">
                                                    <div class="icon"><img src="<?php echo get_avatar_url($current[0]['ticket_email'],array('size'=>50)); ?>" style="border-radius: 25px;"></div>
                                                    <div class="content">
                                                        <div class="message-box">
                                                    <div class="widget-area no-padding blank" style="width:100%">
                                                        <div class="status-upload">
                                                            <textarea rows="10" cols="30" class="form-control reply_textarea" id="reply_textarea_<?php echo $ticket_id; ?>" name="reply_textarea_<?php echo $ticket_id; ?>"></textarea> 
                                                            <div class="form-group">
                                                                <div class="input-group col-md-12 col-sm-12 col-xs-12">
                                                                    <span class="btn btn-primary fileinput-button">
                                                                        <i class="glyphicon glyphicon-plus"></i>
                                                                        <span><?php _e("Attachment", 'wsdesk'); ?></span>
                                                                        <input type="file" name="files" style="left: 100px;" id="files_<?php echo $ticket_id; ?>" class="attachment_reply" multiple="">
                                                                    </span>
                                                                    <div class="btn-group pull-right">
                                                                        <div class="check-box">
                                                                            <?php if($enable == 'enable'){?>
                                                                            <input type="checkbox" name="check" class="ticket_select_check" id="ticket_select_check_<?php echo $ticket_id; ?>" value="<?php echo $ticket_id; ?>" style="margin-bottom:0.5em"/>
                                                                            <?php _e('Mark as Solved','wsdesk')?>
                                                                            <?php }?>
                                                                            <button type="button" class="btn btn-primary ticket_reply_action_button" data-loading-text="<?php __("Submitting Reply...", 'wsdesk'); ?>" id="<?php echo $ticket_id; ?>" style="margin-left:1em">
                                                                            <?php _e("Submit", 'wsdesk'); ?>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="upload_preview_files_<?php echo $ticket_id;?>"></div>
                                                            </div>
                                                        </div><!-- Status Upload  -->
                                                    </div><!-- Widget Area -->
                                                        </div>
                                                </div>
                                                </div>
                                            </div>
                                            <section class="comment-list">
                                                <?php echo CRM_Ajax::eh_crm_ticket_reply_section_gen_client($ticket_id); ?>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                
            <?php
            return ob_get_clean();
        }
        
        static function eh_crm_ticket_client_section_load() {
            $ticket_id = sanitize_text_field($_POST['ticket_id']);
            $content = CRM_Ajax::eh_crm_ticket_reply_section_gen_client($ticket_id);
            die($content);
        }

        static function eh_crm_ticket_reply_section_gen_client($ticket_id) {
            ob_start();
            $reply_id = eh_crm_get_ticket_value_count("ticket_parent", $ticket_id,false,"","","ticket_updated","DESC");
            array_push($reply_id,array("ticket_id"=>$ticket_id));
            for($s=0;$s<count($reply_id);$s++)
            {
                $reply_ticket = eh_crm_get_ticket(array("ticket_id"=>$reply_id[$s]['ticket_id']));
                $reply_ticket_meta = eh_crm_get_ticketmeta($reply_id[$s]['ticket_id']);
                $replier_name ='';
                $replier_email =$reply_ticket[0]['ticket_email'];
                $replier_pic ='';
                if($reply_ticket[0]['ticket_author']!=0)
                {
                    $replier_obj = new WP_User($reply_ticket[0]['ticket_author']);
                    $replier_name = $replier_obj->display_name;
                    $replier_pic = get_avatar_url($reply_ticket[0]['ticket_author'],array('size'=>50));
                }
                else
                {
                    $replier_name = __("Guest", 'wsdesk');
                    $replier_pic = get_avatar_url($reply_ticket[0]['ticket_email'],array('size'=>50));
                }
                $attachment = "";
                if(isset($reply_ticket_meta['ticket_attachment']))
                {
                    $reply_att = $reply_ticket_meta['ticket_attachment'];
                    $attachment = '<div>';
                    for($at=0;$at<count($reply_att);$at++)
                    {
                        $current_att = $reply_att[$at];
                        $att_ext = pathinfo($current_att, PATHINFO_EXTENSION);
                        if(empty($att_ext))
                        {
                           $att_ext=''; 
                        }
                        $att_name = pathinfo($current_att, PATHINFO_FILENAME);
                        $img_ext = array("jpg","jpeg","png","gif");
                        if(in_array($att_ext, $img_ext))
                        {
                            $attachment .= '<a href="'.$current_att.'" target="_blank"><img class="img-upload clickable" style="width:200px" title="' .$att_name. '" src="'.$current_att.'"></a></p>';
                        }
                        else
                        {
                            $check_file_ext = array('doc','docx','pdf','xml','csv','xlsx','xls','txt','zip');
                            if(in_array($att_ext,$check_file_ext))
                            {
                                $attachment .= '<a href="'.$current_att.'" target="_blank" title="' .$att_name. '" class="img-upload"><div class="'.$att_ext.'"></div></a>';
                            }
                            else
                            {
                                $attachment .= '<a href="'.$current_att.'" target="_blank" title="' .$att_name. '" class="img-upload"><div class="unknown_type"></div></a>';
                            }
                        }
                    }
                    $attachment .= '</div>';
                }
                switch ($reply_ticket[0]['ticket_category']) {
                    case "agent_reply":
                    case "raiser_reply": 
                        if(($reply_ticket[0]['ticket_category'])=="agent_reply"){
                            $replier_email=""; 
                            if ($replier_name==""){
                                $replier_name="Support";
                            }
                        }    
                        if(($reply_ticket[0]['ticket_category'])=="raiser_reply"){
                            $replier_email=$replier_email."|";
                           
                        }    
                        echo '
                            <div class="conversation_each" style="width:100.5% !important;">
                                <div class="leftFreeSpace">
                                <div class="icon">
                                        <img style="border-radius: 25px;" src="'.$replier_pic.'" />
                                </div>
                                <h3>'.$replier_name.'</h3>
                                            <h4>
                                                '.$replier_email.' 
                                                '. eh_crm_get_formatted_date($reply_ticket[0]['ticket_date']).'
                                            </h4>
                                            <hr>
                                            <div class="comment-post">
                                                <p>';
                                                $input_data = html_entity_decode(stripslashes($reply_ticket[0]['ticket_content']));
                                                
                                                $input_array[0] = '/<((html)[^>]*)>(.*)\<\/(html)>/Us';
                                                $input_array[1] = '/<((head)[^>]*)>(.*)\<\/(head)>/Us';
                                                $input_array[2] = '/<((style)[^>]*)>(.*)\<\/(style)>/Us';
                                                $input_array[3] = '/<((body)[^>]*)>(.*)\<\/(body)>/Us';
                                                $input_array[4] = '/<((form)[^>]*)>(.*)\<\/(form)>/Us';
                                                $input_array[5] = '/<((input)[^>]*)>(.*)\<\/(input)>/Us';
                                                $input_array[5] = '/<((input)[^>]*)>/Us';
                                                $input_array[7] = '/<((button)[^>]*)>(.*)\<\/(button)>/Us';
                                                $input_array[8] = '/<((iframe)[^>]*)>(.*)\<\/(iframe)>/Us';
                                                $output_array[0] = '&lt;$1&gt;$3&lt;/html&gt;';
                                                $output_array[1] = '&lt;$1&gt;$3&lt;/head&gt;';
                                                $output_array[2] = '&lt;$1&gt;$3&lt;/style&gt;';
                                                $output_array[3] = '&lt;$1&gt;$3&lt;/body&gt;';
                                                $output_array[4] = '&lt;$1&gt;$3&lt;/form&gt;';
                                                $output_array[5] = '&lt;$1&gt;$3&lt;/input&gt;';
                                                $output_array[6] = '&lt;$1&gt;$3&lt;/button&gt;';
                                                $output_array[7] = '&lt;$1&gt;$3&lt;/input&gt;';
                                                $output_array[8] = '&lt;$1&gt;$3&lt;/iframe&gt;';
                                                $input_data = preg_replace($input_array, $output_array, $input_data); 
                                                
                                                echo $input_data;
                                                echo '</p>
                                                '.$attachment.'
                                            </div>
                                </div>                
                            </div>
                        ';
                        break;
                    default:
                        break;
                }
            }
            return ob_get_clean();
        }
        
        static function eh_crm_ticket_reply_raiser() {
            $files = isset($_FILES["file"])?$_FILES["file"]:"";
            $status = sanitize_text_field($_POST['close']);
            $ticket_id = sanitize_text_field($_POST['ticket_id']);
            $content = str_replace("\n", '<br/>',$_POST['ticket_reply']);
            $parent = eh_crm_get_ticket(array("ticket_id"=>$ticket_id));
            $user = wp_get_current_user();
            $category = 'raiser_reply';
            $child = array(
                'ticket_email' => $user->user_email,
                'ticket_title' => $parent[0]['ticket_title'],
                'ticket_content' => $content,
                'ticket_category' => $category,
                'ticket_parent' => $ticket_id,
                'ticket_vendor' => $parent[0]['ticket_vendor']
                );
            $child_meta = array();
            if(isset($_FILES["file"]) && !empty($_FILES['file']))
            {   
                $attachment_data = CRM_Ajax::eh_crm_ticket_file_handler($files);
                $child_meta["ticket_attachment"] = $attachment_data['url'];
                $child_meta["ticket_attachment_path"] = $attachment_data['path'];
            }
            $gen_id = eh_crm_insert_ticket($child,$child_meta);
            $submit = eh_crm_get_settingsmeta('0', "default_label");
            if($status == "close")
            {
                eh_crm_update_ticketmeta($ticket_id, "ticket_label", 'label_LL02');
            }
            else
            {
                eh_crm_update_ticketmeta($ticket_id, "ticket_label", $submit);
            }
            eh_crm_debug_error_log(" ------------- WSDesk Email Debug Started ------------- ");
            eh_crm_debug_error_log("Ticket raiser reply for Ticket #".$gen_id);
            eh_crm_debug_error_log("Email function called for reply Ticket #".$gen_id);
            CRM_Ajax::eh_crm_fire_email("reply_ticket", $gen_id);
            eh_crm_debug_error_log(" ------------- WSDesk Email Debug Ended ------------- ");
            $content_ticket = CRM_Ajax::eh_crm_ticket_single_view_client_gen($ticket_id);
            $user_id = get_current_user_id();
            $user_data = new WP_User($user_id);
            $email = $user_data->user_email;
            die(json_encode(array("ticket"=>$content_ticket)));
        }
        
        static function eh_crm_activate_oauth() {
            $client_id = sanitize_text_field($_POST['client_id']);
            $client_secret = sanitize_text_field($_POST['client_secret']);
            eh_crm_update_settingsmeta(0, "oauth_client_id", $client_id);
            eh_crm_update_settingsmeta(0, "oauth_client_secret", $client_secret);
            $oauth_obj = new EH_CRM_OAuth();
            die($oauth_obj->make_oauth_uri());
        }
        
        static function eh_crm_deactivate_oauth() {
            $oauth_obj = new EH_CRM_OAuth();
            $oauth_obj->revoke_token();
            die(include(EH_CRM_MAIN_VIEWS . "email/crm_oauth_setup.php"));
        }

        static function eh_crm_activate_email_protocol() {
            $server_url = sanitize_text_field($_POST['server_url']);
            $server_port= sanitize_text_field($_POST['server_port']);
            $email      = sanitize_text_field($_POST['email']);
            $email_pwd  = sanitize_text_field($_POST['email_pwd']);
            $delete_email = sanitize_text_field($_POST['delete_email']);
            $debug_status = eh_crm_get_settingsmeta(0, 'wsdesk_debug_status');
            if(in_array("imap", get_loaded_extensions()))
            {
                if($debug_status != 'enable')
                {
                    $imap = @imap_open("{".$server_url.":".$server_port."/imap/ssl/novalidate-cert}", $email, $email_pwd);
                }
                else
                {
                    $imap = imap_open("{".$server_url.":".$server_port."/imap/ssl/novalidate-cert}", $email, $email_pwd);
                }
                if(!$imap)
                {
                    die(json_encode(array("status"=>"failure","message"=>__("EMail Server Not Found", 'wsdesk'))));
                }
                else
                {
                    eh_crm_update_settingsmeta(0, "imap_server_url", $server_url);
                    eh_crm_update_settingsmeta(0, "imap_server_port", $server_port);
                    eh_crm_update_settingsmeta(0, "imap_server_email", $email);
                    eh_crm_update_settingsmeta(0, "imap_server_email_pwd", $email_pwd);
                    eh_crm_update_settingsmeta(0, "delete_email",$delete_email);
                    eh_crm_update_settingsmeta(0, "imap_activation", "activated");
                    die(json_encode(array("status"=>"success","message"=>__("Email IMAP Configured", 'wsdesk'),"content"=>include(EH_CRM_MAIN_VIEWS . "email/crm_imap_setup.php"))));
                }

            }
            else
            {
                die(json_encode(array("status"=>"failure","message"=>__("IMAP is not enabled in your Server", 'wsdesk'))));
            }
            
        }
        
        static function eh_crm_deactivate_email_protocol() {
            eh_crm_update_settingsmeta(0, "imap_activation", "deactivated");
            die(include(EH_CRM_MAIN_VIEWS . "email/crm_imap_setup.php"));
        }

        static function eh_crm_email_block_filter()
        {
            $new_block = json_decode(stripslashes(sanitize_text_field($_POST['new_block'])), true);
            if (!empty($new_block)) {
                
                $new_email = $new_block['email'];
                $type =  $new_block['type'];
                $block_filter = eh_crm_get_settingsmeta("0", "email_block_filters");
                if(!$block_filter)
                {
                    $block_filter = array();
                }
                $available = true;
                foreach ($block_filter as $email => $data)
                {
                    if($new_email == $email)
                    {
                        $available = false;
                    }
                }
                if($available)
                {
                    $block_filter[$new_email] = $type;
                    eh_crm_update_settingsmeta("0", "email_block_filters",$block_filter);
                }
            }
            die(include(EH_CRM_MAIN_VIEWS . "email/crm_filter_block_setup.php"));
        }
        
        static function eh_crm_subject_block_filter()
        {
            $new_block = json_decode(stripslashes(sanitize_text_field($_POST['new_block'])), true);
            if (!empty($new_block)) {
                
                $new_subject = $new_block['subject'];
                $new_type = $new_block['type'];
                $block_filter = eh_crm_get_settingsmeta("0", "subject_block_filters");
                if(!$block_filter)
                {
                    $block_filter = array();
                }
                $available = true;
                foreach ($block_filter as $index => $data)
                {
                    if($new_subject == $data)
                    {
                        $available = false;
                    }
                }
                if($available)
                {
                    $block_filter[$new_subject] = $new_type;
                    eh_crm_update_settingsmeta("0", "subject_block_filters",$block_filter);
                }
            }
            die(include(EH_CRM_MAIN_VIEWS . "email/crm_filter_block_setup.php"));
        }

        static function eh_crm_email_block_delete()
        {
            $block_remove = sanitize_text_field($_POST['block_remove']);
            $block_filter = eh_crm_get_settingsmeta("0", "email_block_filters");
            if(!$block_filter)
            {
                $block_filter = array();
            }
            foreach ($block_filter as $email => $data)
            {
                if($email === $block_remove)
                {
                    unset($block_filter[$email]);
                    eh_crm_update_settingsmeta("0", "email_block_filters",$block_filter);
                }
            }
            die(include(EH_CRM_MAIN_VIEWS . "email/crm_filter_block_setup.php"));
        }
        
        static function eh_crm_subject_block_delete()
        {
            $block_remove = sanitize_text_field($_POST['block_remove']);
            $block_filter = eh_crm_get_settingsmeta("0", "subject_block_filters");
            if(!$block_filter)
            {
                $block_filter = array();
            }
            if(isset($block_filter[$block_remove]))
            {
                unset($block_filter[$block_remove]);
                eh_crm_update_settingsmeta("0", "subject_block_filters",$block_filter);
            }


            die(include(EH_CRM_MAIN_VIEWS . "email/crm_filter_block_setup.php"));
        }
        
        static function eh_crm_fire_email($type,$ticket_id) {
            ini_set('max_execution_time', 300);
            $ticket = eh_crm_get_ticket(array("ticket_id"=>$ticket_id));
                $filter_check = array();
                $filter_check = apply_filters('wsdesk_notify_block',$filter_check,$ticket);
                if(!empty($filter_check))
                {
                    return array('status'=>true,"message"=>__('Email sent successfully','wsdesk'));
                }
            $ticket_meta = eh_crm_get_ticketmeta($ticket_id);
            $parent_id = $ticket[0]['ticket_parent'];
            $meta = array();
            if($parent_id!=0)
            {
                $meta = eh_crm_get_ticketmeta($parent_id);
            }
            else
            {
                $meta = eh_crm_get_ticketmeta($ticket_id);
            }
            eh_crm_debug_error_log("Ticket Meta - ");
            eh_crm_debug_error_log($meta);
            $ticket_assignee_name =array();
            $user_roles_default = array("WSDesk_Agents", "WSDesk_Supervisor","administrator");
            $users = get_users(array("role__in" => $user_roles_default));
            $users_data = array();
            for ($i = 0; $i < count($users); $i++) {
                $current = $users[$i];
                $id = $current->ID;
                $user = new WP_User($id);
                $users_data[$i]['id'] = $id;
                $users_data[$i]['name'] = $user->display_name;
                $users_data[$i]['caps'] = $user->caps;
                $users_data[$i]['email'] = $user->user_email;
            }
            if(isset($meta['ticket_assignee']))
            {
                $current_assignee = $meta['ticket_assignee'];
                for($k=0;$k<count($current_assignee);$k++)
                {
                    for($l=0;$l<count($users_data);$l++)
                    {
                        if($users_data[$l]['id'] == $current_assignee[$k])
                        {
                            array_push($ticket_assignee_name, $users_data[$l]['name']);
                        }
                    }
                }
            }
            $ticket_assignee = empty($ticket_assignee_name)?__("No Assignee", 'wsdesk'):implode(", ", $ticket_assignee_name);
            $ticket_tags = array();
            $avail_tags_wf = eh_crm_get_settings(array("type" => "tag"), array("slug", "title", "settings_id"));
            if(!empty($avail_tags_wf))
            {
                $current_ticket_tags=(isset($meta['ticket_tags'])?$meta['ticket_tags']:array());
                for($j=0;$j<count($avail_tags_wf);$j++)
                {
                    for($k=0;$k<count($current_ticket_tags);$k++)
                    {
                        if($avail_tags_wf[$j]['slug'] == $current_ticket_tags[$k])
                        {
                            array_push($ticket_tags,$avail_tags_wf[$j]['title']);
                        }
                    }
                }
            }
            $ticket_tags_name = empty($ticket_tags)?__("No Tags", 'wsdesk'):implode(", ", $ticket_tags);
            $replier_name ='';
            if($ticket[0]['ticket_author']!=0)
            {
                $replier_obj = new WP_User($ticket[0]['ticket_author']);
                $replier_name = $replier_obj->display_name;
            }
            $avail_labels = eh_crm_get_settings(array("type" => "label"), array("slug", "title", "settings_id"));
            $ticket_label = "";
            for($j=0;$j<count($avail_labels);$j++)
            {
                if($avail_labels[$j]['slug'] == $meta['ticket_label'])
                {
                    $ticket_label = $avail_labels[$j]['title'];
                }
            }
            $attachments = array();
            $message = "";
            $subject = "";
            if($type == "new_ticket")
            {
                $message = eh_crm_get_settingsmeta('0', "support_email_new_ticket_text");
                if($message == "")
                {
                    $message = 'Your request (#[id]) has been received on [date] and is being reviewed by our support staff.

                                To add additional comments, reply to this email.
                                
                                Your Issue:
                                [request_description]

                                Tags : [tags]

                                Regards,
                                Support';
                }
                $message = str_replace('[id]',$ticket_id,$message);
                $message = str_replace('[assignee]',$ticket_assignee,$message);
                $message = str_replace('[tags]',$ticket_tags_name,$message);
                $date = eh_crm_get_formatted_date($ticket[0]['ticket_date']);
                $message = str_replace('[date]',$date,$message);
                $message = str_replace('[request_description]',html_entity_decode(stripslashes($ticket[0]['ticket_content'])),$message);
                $subject = 'Ticket ['.$ticket_id.'] : '.$ticket[0]['ticket_title'];
            }
            else
            {
                $message = eh_crm_get_settingsmeta('0', "support_email_reply_text");
                if($message == "")
                {
                    $message = 'Your request (#[id]) has been updated. To add additional comments, reply to this email.

                                [conversation_history]';
                }
                $message = str_replace('[id]',$ticket[0]['ticket_parent'],$message);
                $message = str_replace('[assignee]',$ticket_assignee,$message);
                $message = str_replace('[tags]',$ticket_tags_name,$message);
                $date = eh_crm_get_formatted_date($ticket[0]['ticket_date']);
                $message = str_replace('[date]',$date,$message);
                $message = str_replace('[latest_reply]', eh_crm_get_ticket_latest_content($parent_id), $message);
                $message = str_replace('[latest_reply_with_notes]', eh_crm_get_ticket_latest_notes($parent_id), $message);
                $message = str_replace('[agent_replied]',$replier_name,$message);
                $message = str_replace('[status]',$ticket_label,$message);
                $selected_fields = eh_crm_get_settingsmeta(0, "selected_fields");
                if(empty($selected_fields))
                {
                    $selected_fields = array('request_email','request_title','request_description');
                }
                $avail_fields = eh_crm_get_settings(array("type" => "field"), array("slug", "title", "settings_id"));
                if($parent_id!=0)
                {
                    $tic_id = $parent_id;
                }
                else
                {
                    $tic_id = $ticket_id;
                }
                $tic = eh_crm_get_ticket(array('ticket_id'=>$tic_id));
                $tic_meta = eh_crm_get_ticketmeta($tic_id);
                foreach ($avail_fields as $field) {
                    if($field['slug'] === 'google_captcha' || !in_array($field['slug'], $selected_fields))
                    {
                        continue;
                    }
                    if (strpos($message, '['.$field['slug'].']') !== false) {
                        switch ($field['slug']) {
                            case "request_email":
                                $message = str_replace('[request_email]',$tic[0]['ticket_email'],$message);
                                break;
                            case "request_title":
                                $message = str_replace('[request_title]',$tic[0]['ticket_title'],$message);
                                break;
                            case "request_description":
                                $message = str_replace('[request_description]',html_entity_decode(stripslashes($tic[0]['ticket_content'])),$message);
                                break;
                        }
                        $field_meta = eh_crm_get_settingsmeta($field['settings_id']);
                        switch ($field_meta['field_type']) {
                            case "file":
                            case "text":
                            case "number":
                            case "email":
                            case "password":
                            case 'textarea':
                            case 'ip':
                            case 'date':
                            case 'phone':
                                $value = (isset($tic_meta[$field['slug']])?$tic_meta[$field['slug']]:"");
                                $message = str_replace('['.$field['slug'].']',$value,$message);
                                break;
                            case 'select':
                                if($field['slug']=='woo_order_id')
                                {
                                    $value = (isset($tic_meta[$field['slug']])?$tic_meta[$field['slug']]:"");
                                    $message = str_replace('['.$field['slug'].']',$value,$message);
                                }
                                else
                                {
                                    $value = (isset($tic_meta[$field['slug']])?$tic_meta[$field['slug']]:"");
                                    $option = (isset($field_meta['field_values'][$value])?$field_meta['field_values'][$value]:"");
                                    $message = str_replace('['.$field['slug'].']',$option,$message);
                                }
                                break;
                            case "checkbox":
                            case "radio":
                            case 'woo_product':
                            case 'edd_products':
                            case 'woo_category':
                            case 'woo_tags':
                            case 'woo_vendors':
                                $value = (isset($tic_meta[$field['slug']])?$tic_meta[$field['slug']]:"");
                                $option = (isset($field_meta['field_values'][$value])?$field_meta['field_values'][$value]:"");
                                $message = str_replace('['.$field['slug'].']',$option,$message);
                                break;
                        }
                     }
                }
                if (strpos($message, '[conversation_history]') !== false) {
                   if ($parent_id != 0) {
                       $reply_content = eh_crm_get_ticket_data($parent_id);
                       $msg = eh_crm_get_conversation_template($reply_content);
                       $message = str_replace('[conversation_history]', $msg, $message);
                   }
                }
                if (strpos($message, '[conversation_history_with_agent_note]') !== false)
                {
                    if ($ticket_id != 0) {
                        $reply_content = eh_crm_get_ticket_data_with_note($parent_id);
                        $msg = eh_crm_get_conversation_template($reply_content);
                        $message = str_replace('[conversation_history_with_agent_note]', $msg, $message);
                    }
                }
                $attachments = (isset($ticket_meta['ticket_attachment_path'])?$ticket_meta['ticket_attachment_path']:array());
                $subject = 'Re: '.__('Ticket','wsdesk').' ['.$ticket[0]['ticket_parent'].'] : '.$ticket[0]['ticket_title'];
            }
            $message = stripslashes($message);
            preg_match("/ticket_link page='([^']+)'/",$message,$output_page);
            if(!empty($output_page) && $parent_id != 0)
            {
                $message = str_replace('['.stripslashes($output_page[0]).']',site_url().'/'.$output_page[1].'/?customer_ticket_num='.$parent_id,$message); 
                 
            }
            $support_email_name = eh_crm_get_settingsmeta('0', "support_reply_email_name");
            $support_email = eh_crm_get_settingsmeta('0', "support_reply_email");
            $headers = array();
            $headers[]="MIME-Version: 1.0" . "\r\n";
            $headers[] = "Content-Type: text/html; charset=UTF-8 \r\n";
            if(isset($meta['ticket_cc']))
            {
                foreach ($meta['ticket_cc'] as $cc) {
                    $headers[] = 'Cc: '.$cc;
                }
            }
            if(isset($meta['ticket_bcc']))
            {
                foreach ($meta['ticket_bcc'] as $bcc) {
                    $headers[] = 'Bcc: '.$bcc;
                }
            } 
            if($support_email != '')
            {
            $headers[] = 'From: '.$support_email_name.' <'.$support_email.'>';
            }
            $to = '';
            
            if($ticket[0]['ticket_parent']==0)
            {
                $to = $ticket[0]['ticket_email'];
            }
            else
            {
                $ticket_parent = eh_crm_get_ticket(array("ticket_id"=>$ticket[0]['ticket_parent']));
                $to = $ticket_parent[0]['ticket_email'];
            }
            
            do_action('wpml_switch_language_for_email', $to);
                        
            $html = '<html>
                    <head>
                    <style type="text/css">
                        .powered_wsdesk span
                        {
                            opacity: 0.4;
                            font-size: 10px;
                            color: black;
                        }
                        .powered_wsdesk a
                        {
                            opacity: 0.4;
                            font-size: 10px;
                            color: black !important;
                        }
                    </style>
                    </head>
                     <body>';
            $html.= str_replace("\n", '<br/>', $message);
            $html.= eh_crm_get_poweredby_scripts();
            $html.= '</body></html>';
            $response = false;
            $resmes = 'Email sent successfully';
            try 
            {
                if(eh_crm_validate_email_block($to, 'send'))
                {
                    eh_crm_debug_error_log("Triggering wp_mail with these paramters ...");
                    eh_crm_debug_error_log("to - ".$to);
                    eh_crm_debug_error_log("subject - ".$subject);
                    eh_crm_debug_error_log("html - ".$html);
                    eh_crm_debug_error_log("headers - ");
                    eh_crm_debug_error_log($headers);
                    eh_crm_debug_error_log("attachments - ");
                    eh_crm_debug_error_log($attachments);
                    add_filter('wp_mail_from', function($email){
                        return eh_crm_get_settingsmeta('0', "support_reply_email");
                    });
                    add_filter('wp_mail_from_name', function($name){
                        return eh_crm_get_settingsmeta('0', "support_reply_email_name");
                    });
                    eh_crm_debug_error_log("Calling wp_mail ...");
                    $response = wp_mail($to, $subject, $html,$headers,$attachments);
                    remove_filter( 'wp_mail_from', 'get_wp_mail_from' );
                    remove_filter( 'wp_mail_from_name', 'get_wp_mail_from_name' );
                    do_action('wpml_reset_language_after_mailing');
                    eh_crm_debug_error_log("wp_mail returned: ".(($response)?"TRUE":"FALSE"));
    //                if(eh_crm_pre_check_back_to_back($support_email, $to, $subject))
    //                {
    //                    eh_crm_debug_error_log("Triggering wp_mail with these paramters ...");
    //                    eh_crm_debug_error_log("to - ".$to);
    //                    eh_crm_debug_error_log("subject - ".$subject);
    //                    eh_crm_debug_error_log("html - ".$html);
    //                    eh_crm_debug_error_log("headers - ");
    //                    eh_crm_debug_error_log($headers);
    //                    eh_crm_debug_error_log("attachments - ");
    //                    eh_crm_debug_error_log($attachments);
    //                    eh_crm_debug_error_log("Calling wp_mail ...");
    //                    $response = wp_mail($to, $subject, $html,$headers,$attachments);
    //                    eh_crm_debug_error_log("wp_mail returned: ".(($response)?"TRUE":"FALSE"));
    //                }
    //                else
    //                {
    //                    eh_crm_debug_error_log("Pre check back to back failed ...");
    //                    eh_crm_debug_error_log("Sendind Email to Admin Email ...");
    //                    $admin_email = get_option('admin_email');
    //                    $html = '<html>
    //                            <head>
    //                            <style type="text/css">
    //                                .powered_wsdesk span
    //                                {
    //                                    opacity: 0.4;
    //                                    font-size: 10px;
    //                                    color: black;
    //                                }
    //                                .powered_wsdesk a
    //                                {
    //                                    opacity: 0.4;
    //                                    font-size: 10px;
    //                                    color: black !important;
    //                                }
    //                            </style>
    //                            </head>
    //                             <body>';
    //                    $html.= 'From: '.$to.'<br/>';
    //                    $html.= 'To: '.$support_email.'<br/>';
    //                    $html.= 'Ticket Number: #'.$ticket_id.'<br/>';
    //                    $html.= 'Ticket Subject: '.str_replace('Re:', '', $subject).'<br/>';
    //                    $html.= eh_crm_get_poweredby_scripts();
    //                    $html.= '</body></html>';
    //                    $response = wp_mail($admin_email, "WSDesk Alert! Email loop found for #".$ticket_id, $html,$headers);
    //                    eh_crm_debug_error_log("wp_mail returned: ".(($response)?"TRUE":"FALSE"));
    //                }
               }
            } catch (Exception $exc) {
                $resmes = $exc->getTraceAsString();
                eh_crm_debug_error_log("exception on triggering email: ".$resmes);
            }
            eh_crm_debug_error_log("returning from triggering email: ".$resmes);
            return array('status'=>$response,"message"=>$resmes);
            
        }
        
        static function eh_crm_email_support_save() {
            $support_email_name = $_POST['support_email_name'];
            $support_email      = $_POST['support_email'];
            $new_ticket_text    = $_POST['new_ticket_text'];
            $reply_ticket_text  = $_POST['reply_ticket_text'];
            $auto_send_notif  = $_POST['auto_send_notif'];
            $send_agent_reply_mail = empty($_POST['send_agent_reply_mail'])?'disabled':$_POST['send_agent_reply_mail'];
            eh_crm_update_settingsmeta(0, "support_reply_email_name", $support_email_name);
            eh_crm_update_settingsmeta(0, "support_reply_email", $support_email);
            eh_crm_update_settingsmeta(0, "auto_send_creation_email", $auto_send_notif);
            eh_crm_update_settingsmeta(0, "support_email_new_ticket_text", $new_ticket_text);
            eh_crm_update_settingsmeta(0, "support_email_reply_text", $reply_ticket_text);
            eh_crm_update_settingsmeta(0, "send_agent_reply_mail", $send_agent_reply_mail);
            die();
        }
        
        static function eh_crm_backup_data() {
            require_once (EH_CRM_MAIN_PATH . "includes/class-crm-backup-restore.php");
            $start = $_POST['backup_date_range_start'];
            $end = $_POST['backup_date_range_end'];
            $data = $_POST['backup_data_values'];
            $B_R = new EH_CRM_Backup_Restore();
            $B_R->backup_data_xml($start, $end,$data);
        }
        
        static function eh_crm_restore_data() {
            require_once (EH_CRM_MAIN_PATH . "includes/class-crm-backup-restore.php");
            $files = isset($_FILES["file"])?$_FILES["file"]:"";
            $xml_file = "";
            $xml_path = "";
            if(isset($_FILES["file"]) && !empty($_FILES['file']))
            {   
                $attachment_data = CRM_Ajax::eh_crm_ticket_file_handler($files);
                $xml_path = $attachment_data['path'];
                $xml_file = $attachment_data['url'];
            }
            $B_R = new EH_CRM_Backup_Restore();
            $B_R->restore_data_xml($xml_file[0]);
            unlink($xml_path[0]);
            die();
        }
        
        static function eh_crm_zendesk_library() {
            try 
            {
                $response = wp_remote_get("https://wsdesk.com/wp-content/uploads/2017/03/zendesk.zip",array("timeout"=>300));
                $zip = $response['body'];
                $file = EH_CRM_MAIN_VENDOR."zendesk.zip";
                $fp = fopen($file, "w");
                fwrite($fp, $zip);
                fclose($fp);
                WP_Filesystem();
                if (unzip_file($file, EH_CRM_MAIN_VENDOR)) {
                    unlink($file);
                    die(json_encode(array("status"=>"success","body"=>include(EH_CRM_MAIN_VIEWS . "import/crm_zendesk_import.php"))));
                } 
                else
                {
                    die(json_encode(array("status"=>"failure","data"=>__("Error while Activating Zendesk", 'wsdesk'))));
                }
            } 
            catch (Exception $exc) 
            {
                die(json_encode(array("status"=>"failure","data"=>$exc->getMessage())));
            }
        }
        
        static function eh_crm_zendesk_save_data(){
            $token = sanitize_text_field($_POST['token']);
            $subdomain = sanitize_text_field($_POST['subdomain']);
            $username = sanitize_text_field($_POST['username']);
            eh_crm_update_settingsmeta(0, "zendesk_accesstoken", $token);
            eh_crm_update_settingsmeta(0, "zendesk_subdomain", $subdomain);
            eh_crm_update_settingsmeta(0, "zendesk_username", $username);
            die("success");
        }
        
        static function eh_crm_zendesk_pull_tickets() {
            eh_crm_update_settingsmeta(0, "zendesk_tickets_import", "started");
            eh_crm_write_log("");
            $page = $_POST['page'];
            $attachment = $_POST['attachment'];
            $plan = $_POST['plan'];
            require_once (EH_CRM_MAIN_PATH . "includes/class-crm-import-tickets.php");
            $import = new EH_CRM_Import_Tickets();
            $response = $import->zendesk_get_ticket($page,$attachment,$plan);
            $return = array();
            if($response['status'] == "success")
            {
                if($response['next'] !=0 )
                {
                    $return['status'] = "continue";
                    $return['next_page'] = $response['next'];
                    $return['percentage'] = ($response['total']/(100/($response['next']-1)));
                }
                else
                {
                    $return['total'] = $response['total'];
                    $return['status'] = "completed";
                    eh_crm_update_settingsmeta(0, "zendesk_tickets_import", "stopped");
                }
            }
            else
            {
                $return['status'] = "failure";
                $return['body'] = $response['message'];
            }
            die(json_encode($return));
        }
        
        static function eh_crm_live_log() {
            if (isset($_GET['action'])) {
                session_start();
                $upload = wp_upload_dir();
                $handle = fopen($upload['path']."/wsdesk_import", 'r');
                if (isset($_SESSION['offset'])) {
                  $data = stream_get_contents($handle, -1, $_SESSION['offset']);
                  if(isset($_SESSION['old_data']))
                  {
                    if($_SESSION['old_data'] == $data)
                    {
                        die();
                    }
                    else
                    {
                        $_SESSION['old_data'] = $data;
                        echo "<br/>".nl2br($data);
                    }
                  }
                  else
                  {
                    $_SESSION['old_data'] = $data;
                    echo "<br/>".nl2br($data);
                  }
                } else {
                  fseek($handle, 0, SEEK_END);
                  $_SESSION['offset'] = ftell($handle);
                } 
                die();
            }
        }
        
        static function eh_crm_zendesk_stop_pull_tickets() {
            eh_crm_update_settingsmeta(0, "zendesk_tickets_import", "stopped");
            die();
        }
        
        static function eh_crm_woo_report_products() {
            $data = (($_POST['data'] !== '')?explode(",", sanitize_text_field($_POST['data'])):array());
            $result = eh_crm_woo_products_generate_bar_values($data);
            die(json_encode($result));
        }
        
        static function eh_crm_woo_report_category() {
            $data = (($_POST['data'] !== '')?explode(",", sanitize_text_field($_POST['data'])):array());
            $result = eh_crm_woo_category_generate_bar_values($data);
            die(json_encode($result));
        }
        
        static function eh_crm_ticket_new_template() {
            $title = stripslashes(sanitize_text_field($_POST['title']));
            $content =  stripslashes($_POST['content']);
            $insert = array(
                'title' => $title,
                'filter' => 'no',
                'type' => 'template',
                'vendor' => ''
            );
            $meta = array
            (
                "template_content" => $content,
                "template_author" => get_current_user_id(),
                "template_scope" => 'global',
                "template_usage" => 0
            );
            $id = eh_crm_insert_settings($insert, $meta);
            $avail_caps = array("reply_tickets","delete_tickets","manage_tickets","manage_templates");
            $access = array();
            $logged_user = wp_get_current_user();
            $logged_user_caps = array_keys($logged_user->caps);
            if(!in_array("administrator", $logged_user->roles))
            {
                for($i=0;$i<count($logged_user_caps);$i++)
                {
                    if(!in_array($logged_user_caps[$i], $avail_caps))
                    {
                        unset($logged_user_caps[$i]);
                    }
                }
                $access = $logged_user_caps;
            }
            else
            {
                $access = $avail_caps;
            }
            $template = eh_crm_get_settings(array("settings_id"=>$id));
            $html = '';
            $html .='<li class="list-group-item available_template '.$template[0]['slug'].'_li"> <span class="truncate multiple_template_action '.$template[0]['slug'].'_head" id="'.$template[0]['slug'].'">'.$template[0]['title'].'</span>';
            if(in_array("manage_templates", $access))
            {
                $html .='<span class="pull-right"> <span class="glyphicon glyphicon-pencil ticket_template_edit_type" id="'.$template[0]['slug'].'" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Edit Template','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;"></span></span>';
            }
            $html .='</li>';
            die($html);
        }
        
        static function eh_crm_ticket_update_template() {
            $slug = stripslashes(sanitize_text_field($_POST['slug']));
            $title = stripslashes(sanitize_text_field($_POST['title']));
            $content = stripslashes($_POST['content']);
            $temp = eh_crm_get_settings(array('slug'=>$slug));
            eh_crm_update_settings($temp[0]['settings_id'], array('title'=>$title));
            eh_crm_update_settingsmeta($temp[0]['settings_id'], 'template_content', $content);
            die();
        }
        
        static function eh_crm_ticket_template_delete() {
            $slug = sanitize_text_field($_POST['slug']);
            $temp = eh_crm_get_settings(array('slug'=>$slug));
            eh_crm_delete_settings($temp[0]['settings_id']);
            die();
        }
        static function eh_crm_ticket_template_search_single() {
            $text = sanitize_text_field($_POST['text']);
            $ticket_id = sanitize_text_field($_POST['id']);
            ini_set('max_execution_time', 300);
            global $wpdb;
            $table = $wpdb->prefix . 'wsdesk_settings';
            $tablemeta = $wpdb->prefix . 'wsdesk_settingsmeta';
            $query = "SELECT DISTINCT(p.settings_id) FROM $table AS p JOIN $tablemeta AS a ON (p.settings_id = a.settings_id AND p.type='template') WHERE p.title LIKE '%$text%' OR (a.meta_key = 'template_content' AND a.meta_value LIKE '%$text%') AND p.type='template'";
            $data = $wpdb->get_results($query, ARRAY_A);
            if (!$data) {
                die("<li class='list-group-item search_template_".$ticket_id."'>".__('No template found','wsdesk')."</li>");
            }
            $html = '';
            foreach ($data as $temp) {
                $template = eh_crm_get_settings(array("settings_id"=>$temp['settings_id']));
                $html .='<li class="list-group-item search_template_'.$ticket_id.' search_template_'.$ticket_id.' '.$template[0]['slug'].'_li" id="'.$ticket_id.'" title="'.$template[0]['title'].'"> <span class="truncate multiple_template_action '.$template[0]['slug'].'_head" based="single" id="'.$template[0]['slug'].'">'.$template[0]['title'].'</span></li>';
            }
            die($html);
        }
        static function eh_crm_ticket_template_search() {
            $text = sanitize_text_field($_POST['text']);
            ini_set('max_execution_time', 300);
            global $wpdb;
            $table = $wpdb->prefix . 'wsdesk_settings';
            $tablemeta = $wpdb->prefix . 'wsdesk_settingsmeta';
            $query = "SELECT DISTINCT(p.settings_id) FROM $table AS p JOIN $tablemeta AS a ON (p.settings_id = a.settings_id AND p.type='template') WHERE p.title LIKE '%$text%' OR (a.meta_key = 'template_content' AND a.meta_value LIKE '%$text%') AND p.type='template'";
            $data = $wpdb->get_results($query, ARRAY_A);
            if (!$data) {
                die("<li class='list-group-item search_template'>".__('No template found','wsdesk')."</li>");
            }
            $avail_caps = array("reply_tickets","delete_tickets","manage_tickets","manage_templates");
            $access = array();
            $logged_user = wp_get_current_user();
            $logged_user_caps = array_keys($logged_user->caps);
            if(!in_array("administrator", $logged_user->roles))
            {
                for($i=0;$i<count($logged_user_caps);$i++)
                {
                    if(!in_array($logged_user_caps[$i], $avail_caps))
                    {
                        unset($logged_user_caps[$i]);
                    }
                }
                $access = $logged_user_caps;
            }
            else
            {
                $access = $avail_caps;
            }
            $html = '';
            foreach ($data as $temp) {
                $template = eh_crm_get_settings(array("settings_id"=>$temp['settings_id']));
                $html .='<li class="list-group-item search_template '.$template[0]['slug'].'_li" title="'.$template[0]['title'].'"> <span class="truncate multiple_template_action '.$template[0]['slug'].'_head" id="'.$template[0]['slug'].'" based="bulk">'.$template[0]['title'].'</span>';
                if(in_array("manage_templates", $access))
                {
                    $html .='<span class="pull-right"> <span class="glyphicon glyphicon-pencil ticket_template_edit_type" id="'.$template[0]['slug'].'" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Edit Template','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;"></span></span>';
                }
                $html .='</li>';
            }
            die($html);
        }
        
        static function eh_crm_ticket_edit_template_content() {
            $slug = sanitize_text_field($_POST['slug']);
            $temp = eh_crm_get_settings(array('slug'=>$slug));
            $temp_meta = eh_crm_get_settingsmeta($temp[0]['settings_id']);
            $avail_fields = eh_crm_get_settings(array("type" => "field"), array("slug", "title", "settings_id"));
            ob_start();
            ?>
            <div class="modal fade" id="edit_template_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?php _e("Edit Template",'wsdesk'); ?> - <?php echo $temp[0]['title']; ?></h4>
                  </div>
                  <div class="modal-body">
                    <p style="margin-top: 5px;font-size: 16px;">
                        <label for="edit_template_title"><small>Template title to identify</small></label>
                        <input type="text" placeholder="Enter Title" class="form-control template_title_editable" id="edit_template_title" value="<?php echo $temp[0]['title']; ?>">
                    </p>
                    <div class="panel-group" id="edit_temp_role" style="margin-bottom: 10px !important;">
                        <div class="panel panel-default">
                            <div class="panel-heading collapsed" style="padding:10px;cursor: pointer;" data-toggle="collapse" data-parent="#edit_temp_role" data-target="#edit_temp_content">
                                <span class ="email-reply-toggle"></span>
                                <h4 class="panel-title">
                                    <?php _e("Code for template", 'wsdesk'); ?>
                                </h4>
                            </div>
                            <div id="edit_temp_content" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                            [name]
                                            </div>
                                            <div class="col-md-9">
                                                <?php _e("To insert ticket raiser name in the templates", 'wsdesk'); ?>
                                            </div>
                                        </div>
                                        <span class="crm-divider"></span>
                                        <div class="row">
                                            <div class="col-md-3">
                                                [id]
                                            </div>
                                            <div class="col-md-9">
                                                <?php _e("To insert ticket number in the templates", 'wsdesk'); ?>
                                            </div>
                                        </div>
                                        <?php
                                            $selected_fields = eh_crm_get_settingsmeta(0, "selected_fields");
                                            foreach ($avail_fields as $field) {
                                                if($field['slug'] === 'google_captcha' || !in_array($field['slug'], $selected_fields))
                                                {
                                                    continue;
                                                }
                                                echo '
                                                    <span class="crm-divider"></span>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            ['.$field['slug'].']
                                                        </div>
                                                        <div class="col-md-9">
                                                           '.__("To insert ", 'wsdesk').' '.$field['title'].' '.__("field value in the template", 'wsdesk').'
                                                        </div>
                                                    </div>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='textarea' style="height: 100px" id="edit_template_content"><?php echo $temp_meta['template_content'];?></div> 
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-left delete_template" id="<?php echo $temp[0]['slug']?>"><span class="glyphicon glyphicon-remove"></span> <?php _e('Delete','wsdesk'); ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','wsdesk'); ?></button>
                    <button type="button" class="btn btn-primary edit_template" id="<?php echo $temp[0]['slug']?>"><span class="glyphicon glyphicon-ok"></span> <?php _e('Update','wsdesk'); ?></button>
                  </div>
                </div>
              </div>
            </div>
            <?php
            $html = ob_get_clean();
            die($html);
        }
        
        static function eh_crm_ticket_multiple_template_send() {
            $tickets = json_decode(stripslashes(sanitize_text_field($_POST['ticket'])), true);
            $open = json_decode(stripslashes(sanitize_text_field($_POST['opened'])), true);
            $template = sanitize_text_field($_POST['template']);
            $submit = sanitize_text_field($_POST['label']);
            $gen_html = array();
            if(!empty($tickets))
            {
                foreach ($tickets as $tic) 
                {
                    $parent = eh_crm_get_ticket(array("ticket_id" => $tic));
                    $content = eh_crm_get_template_content($template, $tic);
                    $user = wp_get_current_user();
                    $user_roles_default = array("WSDesk_Agents", "WSDesk_Supervisor","administrator");
                    $category ='';
                    if (count(array_intersect($user_roles_default, $user->roles)) != 0)
                    {
                        if($submit == "note")
                        {
                            $category = 'agent_note';
                        }
                        else
                        {
                            eh_crm_update_ticketmeta($tic, "ticket_label", $submit);
                            $category = 'agent_reply';
                        }
                    }
                    else
                    {
                        $category = 'raiser_reply';
                    }
                    $vendor = '';
                    if(EH_CRM_WOO_VENDOR)
                    {
                        $vendor = EH_CRM_WOO_VENDOR;
                    }
                    $child = array(
                        'ticket_email' => $user->user_email,
                        'ticket_title' => $parent[0]['ticket_title'],
                        'ticket_content' => $content,
                        'ticket_category' => $category,
                        'ticket_parent' => $tic,
                        'ticket_vendor' => $vendor
                        );
                    $gen_id = eh_crm_insert_ticket($child);
                    $send_agent_reply_mail = eh_crm_get_settingsmeta('0', "send_agent_reply_mail");
                    if($send_agent_reply_mail != 'disabled')
                    {
                        if($category=="agent_reply")
                        {
                            CRM_Ajax::eh_crm_fire_email("reply_ticket", $gen_id);
                        }
                    }
                    if(in_array($tic, $open))
                    {
                        $content_html = CRM_Ajax::eh_crm_ticket_single_view_gen($tic);
                        $tab = CRM_Ajax::eh_crm_ticket_single_view_gen_head($tic);
                        $gen_html[$tic] = array("tab_head"=>$tab,"tab_content"=>$content_html);
                    }
                }
            }
            die(json_encode($gen_html));
        }
        
        static function eh_crm_get_settingsmeta_from_slug() {
            $fields = "settings_id";
            $slug = sanitize_text_field($_POST['slug']);
            $args = array('slug'=>$slug);
            $settings = eh_crm_get_settings($args,$fields);
            $settings_id = $settings[0];
            $settings_meta = eh_crm_get_settingsmeta($settings_id['settings_id']);
            die(json_encode($settings_meta));
        }
        
        static function eh_crm_ticket_preview_template() {
            $slug = sanitize_text_field($_POST['slug']);
            $type = sanitize_text_field($_POST['type']);
            $tickets = json_decode(stripslashes(sanitize_text_field($_POST['ticket'])), true);
            $temp = eh_crm_get_settings(array('slug'=>$slug));
            $ticket_id = $tickets[0];
            $content = eh_crm_get_template_content($slug, $ticket_id);
            $avail_labels = eh_crm_get_settings(array("type" => "label"), array("slug", "title", "settings_id"));
            $based = '';
            $id ='';
            if($type==="bulk")
            {
                $based = "based='bulk'";
                ob_start();
                ?>
                <div class="modal fade" id="preview_template_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">(<?php echo '#'.$ticket_id; ?>) <?php _e("Template preview",'wsdesk'); ?> - <?php echo $temp[0]['title']; ?></h4>
                      </div>
                      <div class="modal-body">
                            <input type="hidden" value="<?php echo $temp[0]['slug']; ?>" id="template_id_for_confirm">
                            <?php echo $content; ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" style="margin-right:10px;" data-dismiss="modal"><?php _e('Close','wsdesk'); ?></button>
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-primary dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php _e("Submit as", 'wsdesk'); ?> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <?php
                                    for($j=0;$j<count($avail_labels);$j++)
                                    {
                                        echo '<li '.$id.'><a href="#" class="ticket_template_confirm_action" '.$based.' id="'.$avail_labels[$j]['slug'].'">'.__("Submit as", 'wsdesk').' '.$avail_labels[$j]['title'].'</a></li>';
                                    }
                                ?>
                                <li role="separator" class="divider"></li>
                                <li <?php echo $id; ?>><a href="#" class="ticket_template_confirm_action" <?php echo $based; ?> id="note"><?php _e("Submit as Note", 'wsdesk'); ?></a></li>
                                <li class="text-center"><small class="text-muted"><?php _e("Notes visible to Agents and Supervisors", 'wsdesk'); ?></small></li>
                            </ul>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                $html = ob_get_clean();
                die($html);
            }
            elseif($type==="single")
            {
                die($content);
            }
        }
        
        static function eh_crm_settings_initiate_ticket()
        {
            global $wpdb;
            $start_number = sanitize_text_field($_POST['start_number']);
            $table_name = $wpdb->prefix . 'wsdesk_tickets';
            $db_name = $wpdb->dbname;
            $query ="SELECT `AUTO_INCREMENT` as ai
                    FROM  INFORMATION_SCHEMA.TABLES
                    WHERE TABLE_SCHEMA = '".$db_name."'
                    AND   TABLE_NAME   = '".$table_name."'";
            $result = $wpdb->get_results($query,ARRAY_A);
            $return = array();
            if($result[0]['ai']<$start_number)
            {
                $alter = 'ALTER TABLE '.$table_name.' AUTO_INCREMENT ='.(int)$start_number;
                $wpdb->query($alter);
                $return = array("result"=>"success");
            }
            else
            {
                $return = array("result"=>"failed","ai"=>$result[0]['ai']);
            }
            die(json_encode($return));
        }
        
        static function uninstall_reason_submission() {
            global $wpdb;

            if ( ! isset( $_POST['reason_id'] ) ) {
                wp_send_json_error();
            }

            $data = array(
                'reason_id'     => sanitize_text_field( $_POST['reason_id'] ),
                'plugin'        => "wsdesk",
                'auth'          => 'wsdesk_uninstall_1234#',
                'date'          => gmdate("M d, Y h:i:s A"),
                'url'           => home_url(),
                'user_email'    => ($_POST['allow_contacting'])?$_POST['email']:'',
                'reason_info'   => isset( $_REQUEST['reason_info'] ) ? trim( stripslashes( $_REQUEST['reason_info'] ) ) : '',
                'software'      => $_SERVER['SERVER_SOFTWARE'],
                'php_version'   => phpversion(),
                'mysql_version' => $wpdb->db_version(),
                'wp_version'    => get_bloginfo( 'version' ),
                'locale'        => get_locale(),
                'multisite'     => is_multisite() ? 'Yes' : 'No',
                'wsdesk_version'=> EH_CRM_VERSION
            );
            $resp = wp_remote_post('https://wsdesk.com/wp-json/wsdesk/v1/uninstall', array(
                    'method'      => 'POST',
                    'timeout'     => 45,
                    'redirection' => 5,
                    'httpversion' => '1.0',
                    'blocking'    => false,
                    'headers'     => array( 'user-agent' => 'wsdesk/' . md5( esc_url( home_url() ) ) . ';' ),
                    'body'        => $data,
                    'cookies'     => array()
                )
            );
            
            wp_send_json_success();
        }
        static function wsdesk_api_create_ticket()
        {
            $enable_api = eh_crm_get_settingsmeta('0', 'enable_api');
            if($enable_api!='enable')
                die(json_encode(array('status'=>'error','message'=>'API not enabled')));
            $api_key = eh_crm_get_settingsmeta('0', 'api_key');
            if(!isset($_POST['api_key']) || $_POST['api_key']!=$api_key)
            {
                die(json_encode(array('status'=>'error','message'=>'Authentication error.')));
            }
            
            $post_values = $_POST;
            if(isset($post_values['g-recaptcha-response']))
            {
                if($post_values['g-recaptcha-response']=="")
                {
                    die("captcha_failed");
                }
                require_once "recaptcha.php";
                $settings = eh_crm_get_settings(array("slug"=>"google_captcha"),"settings_id");
                $secret = eh_crm_get_settingsmeta($settings[0]['settings_id'], "field_secret_key");
                $reCaptcha = new ReCaptcha($secret);
                $response = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"],$post_values['g-recaptcha-response']);
                if ($response == null && !$response->success) {
                    die("captcha_failed");
                }
            }
            $files = isset($_FILES["file"])?$_FILES["file"]:"";
            $email = $post_values['request_email'];
            $title = stripslashes($post_values['request_title']);
            $desc = str_replace("\n", '<br/>', stripslashes($post_values['request_description']));
            $vendor = '';
            if(EH_CRM_WOO_STATUS)
            {
                if(isset($post_values['woo_vendors']))
                {
                    $vendor = str_replace("v_","",$post_values['woo_vendors']);
                }
            }
            $user = get_user_by('email', $email);
            $args = array(
                'ticket_email' => $email,
                'ticket_title' => $title,
                'ticket_content' => $desc,
                'ticket_category' => 'raiser_reply',
                'ticket_vendor' => $vendor,
                'ticket_author' => empty($user)?0:$user->ID
            );
            if(eh_crm_get_settingsmeta(0,"auto_create_user") === 'enable')
            {
                $email_check = email_exists($email);
                if($email_check)
                {
                    $args['ticket_author'] = $email_check;
                }
                else
                {
                    
                    $maybe_username = explode('@', $email);
                    $maybe_username = sanitize_user($maybe_username[0]);
                    $counter = 1;
                    $username = $maybe_username;
                    $password = wp_generate_password(12, true);

                    while (username_exists($username)) {
                        $username = $maybe_username . $counter;
                        $counter++;
                    }

                    $user = wp_create_user($username, $password, $email);
                    if(!is_wp_error($user))
                    {
                        wp_new_user_notification($user,null,'both');
                        $args['ticket_author'] = $user;
                    }
                }
            }
            unset($post_values['request_email']);
            unset($post_values['request_title']);
            unset($post_values['request_description']);
            $meta = array();
            $req_args = array("type" => "tag");
            $fields = array("slug", "title", "settings_id");
            $avail_tags = eh_crm_get_settings($req_args, $fields);
            $tagged = array();
            if(!empty($avail_tags))
            {
                for ($i = 0, $j = 0; $i < count($avail_tags); $i++) {
                    if (preg_match('/' . strtolower($avail_tags[$i]['title']) . '/', strtolower($desc)) || preg_match('/' . strtolower($avail_tags[$i]['title']) . '/', strtolower($title))) {
                        $tagged[$j] = $avail_tags[$i]['slug'];
                        $j++;
                    }
                }
            }
            $meta['ticket_tags'] = $tagged;
            $default_assignee = eh_crm_get_settingsmeta('0', "default_assignee");
            $assignee = array();
            switch ($default_assignee) {
                case "ticket_tags":
                    $users = get_users(array("role__in" => array("WSDesk_Agents", "WSDesk_Supervisor")));
                    $user_tags = array();
                    for ($i = 0; $i < count($users); $i++) {
                        $current = $users[$i];
                        $id = $current->ID;
                        $user_tags[$id] = get_user_meta($id, "wsdesk_tags", true);
                    }
                    foreach ($user_tags as $key => $value) {
                        for($i=0;$i<count($value);$i++)
                        {
                            if(in_array($value[$i], $tagged))
                            {
                                array_push($assignee, $key);
                                break;
                            }
                        }
                    }
                    break;
                case "ticket_vendors":
                    array_push($assignee, $vendor);
                    break;
                case "no_assignee":
                    break;
                default:
                    array_push($assignee, $default_assignee);
                    break;
            }
            $meta['ticket_assignee'] = $assignee;
            $default_label = eh_crm_get_settingsmeta('0', "default_label");
            if(eh_crm_get_settings(array('slug'=>$default_label)))
            {
                $meta['ticket_label'] = $default_label;
            }
            foreach ($post_values as $key => $value) {
                $meta[$key] = $value;
            }
            if(isset($_FILES["file"]) && !empty($_FILES['file']))
            {   
                $attachment_data = CRM_Ajax::eh_crm_ticket_file_handler($files);
                $meta["ticket_attachment"] = $attachment_data['url'];
                $meta["ticket_attachment_path"] = $attachment_data['path'];
            }
            $meta['ticket_source'] = "API";
            $gen_id = eh_crm_insert_ticket($args, $meta);
            $send = eh_crm_get_settingsmeta('0', "auto_send_creation_email");
            if($send == 'enable')
            {
                eh_crm_debug_error_log(" ------------- WSDesk Email Debug Started ------------- ");
                eh_crm_debug_error_log("New ticket auto Email for Ticket #".$gen_id);
                eh_crm_debug_error_log("Email function called for New Ticket #".$gen_id);
                $response = CRM_Ajax::eh_crm_fire_email("new_ticket", $gen_id);
                eh_crm_debug_error_log(" ------------- WSDesk Email Debug Ended ------------- ");
                
            }
            $my_current_lang = apply_filters( 'wpml_current_language', NULL );
            do_action( 'wpml_switch_language', $my_current_lang );
            die(json_encode(array('status'=> 'success','message'=>__('Support Request Received Successfully','wsdesk'))));
        }
    static function eh_crm_bulk_edit()
    {
        $tickets = explode(',', $_POST['tickets']);
        $assignee = (!empty($_POST['assignee']))?explode(',', $_POST['assignee']):null;
        $labels = ($_POST['labels'])?$_POST['labels']:null;
        $tags = (!empty($_POST['tags']))?explode(',', $_POST['tags']):null;
        $subject = (!empty($_POST['subject']))?$_POST['subject']:null;
        if($_POST['reply']!="" && $_POST['reply']!="<br>")
        {
            $reply = $_POST['reply'];
            $files = isset($_FILES["file"])?$_FILES["file"]:"";
            if($files!="")
            {
                $attachment_data = CRM_Ajax::eh_crm_ticket_file_handler($files);
            }
        }
        else
        {
            $reply = null;
        }
        foreach ($tickets as $id) {
            if(!empty($assignee))
                eh_crm_update_ticketmeta($id, 'ticket_assignee', $assignee);
            if(!empty($labels))
                eh_crm_update_ticketmeta($id, 'ticket_label', $labels);
            if(!empty($tags))
                eh_crm_update_ticketmeta($id, 'ticket_tags', $tags);
            if(!empty($subject))
                eh_crm_update_ticket($id, array('ticket_title'=> $subject));
            if(!empty($reply))
            {
                $user = wp_get_current_user();
                $vendor = '';
                if(EH_CRM_WOO_VENDOR)
                {
                    $vendor = EH_CRM_WOO_VENDOR;
                }
                $parent = eh_crm_get_ticket(array("ticket_id"=>$id));
                $child = array(
                    'ticket_email' => $user->user_email,
                    'ticket_title' => $parent[0]['ticket_title'],
                    'ticket_content' => html_entity_decode($reply),
                    'ticket_category' => 'agent_reply',
                    'ticket_parent' => $id,
                    'ticket_vendor' => $vendor
                );
                $child_meta = array();
                if(!empty($files))
                {   
                    $child_meta["ticket_attachment"] = $attachment_data['url'];
                    $child_meta["ticket_attachment_path"] = $attachment_data['path'];
                }
                $gen_id = eh_crm_insert_ticket($child,$child_meta);
                $send_agent_reply_mail = eh_crm_get_settingsmeta('0', "send_agent_reply_mail");
                if($send_agent_reply_mail != 'disabled')
                {
                    eh_crm_debug_error_log(" ------------- WSDesk Email Debug Started ------------- ");
                    eh_crm_debug_error_log("Agent Replied for Ticket #".$id);
                    eh_crm_debug_error_log("Email function called for new reply #".$gen_id);
                    $response = CRM_Ajax::eh_crm_fire_email("reply_ticket",$gen_id);
                    eh_crm_debug_error_log(" ------------- WSDesk Email Debug Ended ------------- ");
                }
            }
        }
    }
    static function eh_crm_ticket_change_label()
    {
        $ticket_id = $_POST['ticket_id'];
        $label = $_POST['label'];
        $pagination = json_decode(stripslashes(sanitize_text_field($_POST['pagination'])), true);
        eh_crm_update_ticketmeta($ticket_id, 'ticket_label', $label);
        $auto_assign = eh_crm_get_settingsmeta('0','auto_assign');
        if($auto_assign == "enable")
        {
            $user = wp_get_current_user();
            $assignee = eh_crm_get_ticketmeta($ticket_id, "ticket_assignee" );
            if(empty($assignee))
            {
                eh_crm_update_ticketmeta($ticket_id, "ticket_assignee", array($user->ID));
            }
        }
        $content_html = CRM_Ajax::eh_crm_ticket_single_view_gen($ticket_id,$pagination);
        $tab = CRM_Ajax::eh_crm_ticket_single_view_gen_head($ticket_id);
        die(json_encode(array("tab_head"=>$tab,"tab_content"=>$content_html)));
    }
    static function eh_crm_verify_merge_tickets()
    {
        global $wpdb;
        $table_name = $wpdb->prefix.'wsdesk_tickets';
        $ticket_ids = json_decode(stripslashes(sanitize_text_field($_POST['ticket_ids'])));
        $parent_id = $_POST['parent_id'];
        $tickets_display = eh_crm_get_settingsmeta('0', "tickets_display");
        $current_meta = eh_crm_get_ticketmeta($parent_id);
        $selected_fields = eh_crm_get_settingsmeta(0, 'selected_fields');
        $avail_fields = eh_crm_get_settings(array("type" => "field"), array("slug", "title", "settings_id"));
        if(!$selected_fields)
        {
            $selected_fields = array();
        }
        $where = '';
        $ticket_ids = implode(',', $ticket_ids);
        $ticket_ids = $ticket_ids.','.$parent_id;
        $data = $wpdb->get_results("SELECT * FROM $table_name WHERE (ticket_id IN ($ticket_ids) OR ticket_parent IN ($ticket_ids)) AND ticket_trash = 0 ORDER BY ticket_id DESC");
        
        $assignees = (isset($current_meta['ticket_assignee'])?$current_meta['ticket_assignee']:array());
        $assignee_html = array();
        foreach($assignees as $assignee)
        {
            array_push($assignee_html, get_userdata($assignee)->display_name);
        }

        $cc = (isset($current_meta['ticket_cc'])?$current_meta['ticket_cc']:array());

        $ticket_tags = (isset($current_meta['ticket_tags'])?$current_meta['ticket_tags']:array());
        $tag_title_html = array();
        foreach ($ticket_tags as $value) {
            $tag_title = eh_crm_get_settings(array("slug" => "$value"), array("title"));
            array_push($tag_title_html, $tag_title[0]['title']);
        }
        $custom_field_html ='';
        for ($i = 0; $i < count($selected_fields); $i++) {
            for ($j = 3; $j < count($avail_fields); $j++) {
                if ($avail_fields[$j]['slug'] == $selected_fields[$i]) {
                    $field_ticket_value = (isset($current_meta[$avail_fields[$j]['slug']])?$current_meta[$avail_fields[$j]['slug']]:'');
                    $current_settings_meta = eh_crm_get_settingsmeta($avail_fields[$j]['settings_id']);
                    
                    if($current_settings_meta['field_type'] != "file" && $current_settings_meta['field_type'] != "google_captcha")
                    {
                        $custom_field_html .=   '<div class="row" style="margin-top: 10px">
                                                        <div class="col-md-3">
                                                            <p>'.$avail_fields[$j]['title'].'</p>
                                                        </div>
                                                        <div class="col-md-8" style="margin-left: 5px;">
                                                            <p>: ';                
                        switch($current_settings_meta['field_type'])
                        {
                            case 'text':
                            case 'ip':
                            case 'date':
                            case 'email':
                            case 'number':
                            case 'textarea':
                            case 'phone':
                                $custom_field_html .= $field_ticket_value;
                                break;
                            case 'radio':
                            case 'select':
                                $field_values = $current_settings_meta['field_values'];
                                if($field_ticket_value!='')
                                    $custom_field_html .= $field_values[$field_ticket_value];
                                break;
                            case 'checkbox':
                                $field_values = $current_settings_meta['field_values'];
                                $selected_values = array();
                                $field_ticket_value = ($field_ticket_value=="")?array():$field_ticket_value;
                                foreach ($field_ticket_value as $value) {
                                    array_push($selected_values, $field_values[$value]);
                                }
                                $custom_field_html .= implode(', ',$selected_values );
                                break;
                            case 'password':
                               $custom_field_html .= str_repeat('*', strlen($field_ticket_value));
                                break;
                        }
                        $custom_field_html .= '</p></div></div>';
                    }
                }
            }
        }




        $html ='<div class="col-md-3" style="border-right: 2px solid #F3EEEC; height: 400px; margin-top: 10px;">
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-3">
                            <p>'.__('Assignee','wsdesk').'</p>
                        </div>
                        <div class="col-md-8" style="margin-left: 5px;">
                        <p>: '.implode(', ',$assignee_html).'</p>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-3">
                            <p>'.__('CC','wsdesk').'</p>
                        </div>
                        <div class="col-md-8" style="margin-left: 5px;">
                        <p>: '.implode(', ',$cc).'</p>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-3">
                            <p>'.__('Tags','wsdesk').'</p>
                        </div>
                        <div class="col-md-8" style="margin-left: 5px;">
                        <p>: '.implode(', ',$tag_title_html).'</p>
                        </div>
                    </div>
                    '.$custom_field_html.'
                </div>';
        $html .= "<div class='col-md-9'>";
        foreach ($data as $value) {
            if($value->ticket_author!=0)
            {
                $replier_obj = new WP_User($value->ticket_author);
                $replier_name = $replier_obj->display_name;
                $replier_pic = get_avatar_url($value->ticket_author,array('size'=>50));
            }
            else
            {
                $replier_name = "Guest";
                $replier_pic = get_avatar_url($value->ticket_email,array('size'=>50));
            }
            $temp_parentID = ($value->ticket_parent !=0)?$value->ticket_parent:$value->ticket_id;
            $input_data = ($tickets_display!="text")? html_entity_decode(stripslashes($value->ticket_content)):stripslashes($value->ticket_content);
                                                
            $input_array[0] = '/<((html)[^>]*)>(.*)\<\/(html)>/Us';
            $input_array[1] = '/<((head)[^>]*)>(.*)\<\/(head)>/Us';
            $input_array[2] = '/<((style)[^>]*)>(.*)\<\/(style)>/Us';
            $input_array[3] = '/<((body)[^>]*)>(.*)\<\/(body)>/Us';
            $input_array[4] = '/<((form)[^>]*)>(.*)\<\/(form)>/Us';
            $input_array[5] = '/<((input)[^>]*)>(.*)\<\/(input)>/Us';
            $input_array[5] = '/<((input)[^>]*)>/Us';
            $input_array[7] = '/<((button)[^>]*)>(.*)\<\/(button)>/Us';
            $output_array[0] = '&lt;$1&gt;$3&lt;/html&gt;';
            $output_array[1] = '&lt;$1&gt;$3&lt;/head&gt;';
            $output_array[2] = '&lt;$1&gt;$3&lt;/style&gt;';
            $output_array[3] = '&lt;$1&gt;$3&lt;/body&gt;';
            $output_array[4] = '&lt;$1&gt;$3&lt;/form&gt;';
            $output_array[5] = '&lt;$1&gt;$3&lt;/input&gt;';
            $output_array[6] = '&lt;$1&gt;$3&lt;/button&gt;';
            $output_array[7] = '&lt;$1&gt;$3&lt;/input&gt;';
            $input_data = preg_replace($input_array, $output_array, $input_data); 
            $html .= '<div class="row" style="margin: 10px;">
                        <div class="icon"><img src="'.$replier_pic.'" style="border-radius: 25px;"></div>
                        <h5>'.$replier_name.' <span>(Ticket ID:'.$temp_parentID.')</span></h5>
                        <h6>'.$value->ticket_email.' | '.eh_crm_get_formatted_date($value->ticket_date).' </h6>
                        '.(($value->ticket_category === 'satisfaction_survey')?'<b>'.__("Satisfaction Comment", 'wsdesk').'</b><br>':'').'    
                        <p>'.$input_data.'</p>
                     </div>';
        }
        $html .= "</div>";
        die($html);
    }
    static function eh_crm_confirm_merge_tickets()
    {
        global $wpdb;
        $table_name = $wpdb->prefix.'wsdesk_tickets';
        $table_meta = $wpdb->prefix.'wsdesk_ticketsmeta';
        $ticket_ids = json_decode(stripslashes(sanitize_text_field($_POST['ticket_ids'])));
        $parent_id = $_POST['parent_id'];
        $pagination = json_decode(stripslashes(sanitize_text_field($_POST['pagination_id'])), true);
        foreach ($ticket_ids as $ticket_id) {
           $wpdb->get_results("UPDATE $table_name SET ticket_parent = $parent_id WHERE ticket_parent = $ticket_id OR ticket_id = $ticket_id");
           $wpdb->get_results("DELETE FROM $table_meta WHERE ticket_id = $ticket_id");
        }
        $content_html = CRM_Ajax::eh_crm_ticket_single_view_gen($parent_id,$pagination);
        $tab = CRM_Ajax::eh_crm_ticket_single_view_gen_head($parent_id);
        die(json_encode(array("tab_head"=>$tab,"tab_content"=>$content_html)));
    }
    static function eh_crm_arrange_ticket_columns()
    {
        $columns = json_decode(stripslashes($_POST['columns']), True);
        eh_crm_update_settingsmeta("0", "all_ticket_page_columns", $columns);
        die(include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_page.php"));
    }
    static function eh_crm_activate_deactivate_ticket_columns()
    {
        $slug = isset($_POST['slug'])?$_POST['slug']:die();
        $case = isset($_POST['case'])?$_POST['case']:die();
        $all_ticket_page_columns = eh_crm_get_settingsmeta("0", "all_ticket_page_columns");
        switch ($case) {
            case 'activate':
                array_push($all_ticket_page_columns, $slug);
                break;
            
            case 'deactivate':
                $key = array_search($slug, $all_ticket_page_columns);
                unset($all_ticket_page_columns[$key]);
                break;
        }
        eh_crm_update_settingsmeta("0", "all_ticket_page_columns", $all_ticket_page_columns);
        die(include(EH_CRM_MAIN_VIEWS . "settings/crm_settings_page.php"));
    }
}