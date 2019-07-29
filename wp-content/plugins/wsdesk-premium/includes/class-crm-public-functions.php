<?php
if (!defined('ABSPATH')) {
    exit;
}

function eh_random_slug_generate($size) {
    $alpha_key = '';
    $keys = range('A', 'Z');
    for ($i = 0; $i < 2; $i++) {
        $alpha_key .= $keys[array_rand($keys)];
    }
    $length = $size - 2;
    $key = '';
    $keys = range(0, 9);
    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }
    return $alpha_key . $key;
}

/**
 * Insert Data into wsdesk_settings table.
 *
 *
 * @param array $args (title,filter,type,vendor)
 * @param array $meta (meta_key,meta_value) | Optional
 * @return int The Settings ID on success. The value 0 or false on failure.
 */
function eh_crm_insert_settings($args, $meta = NULL,$override = "") {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_settings';
    $defaults = array(
        'title' => '',
        'filter' => 'no',
        'type' => '',
        'vendor' => ''
    );
    $data = wp_parse_args($args, $defaults);
    $slug_check = true;
    do {
        if($override==="")
        {
            $data['slug'] = $data['type'] . '_' . eh_random_slug_generate(4);
        }
        else
        {
            $data['slug'] = $override;
        }
        if (!$wpdb->get_var("SELECT COUNT(*) FROM $table WHERE slug = '".$data['slug']."'")) {
            $slug_check = false;
        }
    } while ($slug_check);
    $result = $wpdb->insert($table, $data);
    $settings_id = (int) $wpdb->insert_id;
    if ($meta !== NULL) {
        foreach ($meta as $key => $value) {
            eh_crm_insert_settingsmeta($settings_id, $key, $value);
        }
    }
    if (!$result) {
        return false;
    }
    return $settings_id;
}

/**
 * Update Existing Data into wsdesk_settings table.
 *
 *
 * @param int|string $id Corresponding Settings ID that needs to be updated
 * @param array $data (title,type,filter,vendor)
 * @return bool True on success. False on failure.
 */
function eh_crm_update_settings($id, $data) {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_settings';
    if (!$wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE settings_id = %d", (int) $id))) {
        return false;
    }
    $where = array('settings_id' => (int) $id);
    $result = $wpdb->update($table, $data, $where);
    if (!$result) {
        return false;
    }
    return true;
}

/**
 * Delete Existing Data from wsdesk_settings table.
 *
 *
 * @param int|string $id Corresponding Settings ID that needs to be deleted
 * @return bool True on success. False on failure.
 */
function eh_crm_delete_settings($id) {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_settings';
    $table_meta = $wpdb->prefix . 'wsdesk_settingsmeta';
    if (!$wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE settings_id = %d", (int) $id))) {
        return false;
    }
    $query = "DELETE FROM $table WHERE settings_id = $id";
    $result = $wpdb->query($query);
    $meta_query = "DELETE FROM $table_meta WHERE settings_id = $id";
    $wpdb->query($meta_query);
    if (!$result) {
        return false;
    }
    return true;
}

/**
 * Get Existing Data into wsdesk_settings table.
 *
 *
 * @param array $args (type,vendor,settings_id,slug,title,filter) | Filter By column and value Eg: array('settings_id'=>4)
 * @param array|string $fields (type,vendor,settings_id,slug,title,filter) | Optional (Fields to return)
 * @return array Filtered or provided ID data as key value pair
 */
function eh_crm_get_settings($args, $fields = NULL) {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_settings';
    $query_search = '';
    $query_field = '';
    if ($fields !== NULL) {
        if (is_array($fields)) {
            $query_field = implode(',', $fields);
        } else {
            $query_field = $fields;
        }
    } else {
        $query_field = '*';
    }
    if (is_array($args)) {
        $a = 1;
        foreach ($args as $key => $value) {
            switch ($key) {
                case 'type':
                    $query_search .= "type = '" . $args['type'] . "'";
                    break;
                case 'vendor':
                    $query_search .= "vendor = '" . $args['vendor'] . "'";
                    break;
                case 'settings_id':
                    $query_search .= "settings_id = " . (int) $args['settings_id'];
                    break;
                case 'slug':
                    $query_search .= "slug = '" . $args['slug'] . "'";
                    break;
                case 'title':
                    $query_search .= "title = '" . $args['title'] . "'";
                    break;
                case 'filter':
                    $query_search .= "filter = '" . $args['filter'] . "'";
                    break;
                default:
                    break;
            }
            if ($a < count(array_keys($args))) {
                $query_search .= " AND ";
                $a++;
            }
        }
    }
    $query = "select $query_field from $table WHERE $query_search";
    $data = $wpdb->get_results($query, ARRAY_A);
    if (!$data) {
        return array();
    }
    return $data;
}

/**
 * Insert Data into wsdesk_settingsmeta table.
 *
 *
 * @param int|string $id settings ID
 * @param string $key meta key
 * @param string $value meta value
 * @return bool True on success. False on failure.
 */
function eh_crm_insert_settingsmeta($id, $key, $value) {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_settingsmeta';
    if ($wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE meta_key = %s AND settings_id = %d", $key, (int) $id))) {
        return false;
    }
    if (is_array($value)) {
        $data = serialize($value);
    } else {
        $data = $value;
    }
    $result = $wpdb->insert($table, array(
        'settings_id' => (int) $id,
        'meta_key' => $key,
        'meta_value' => $data
    ));
    if (!$result) {
        return false;
    }
    return true;
}

/**
 * Update Data into wsdesk_settingsmeta table.
 *
 *
 * @param int|string $id settings ID
 * @param string $key meta key
 * @param string $value meta value
 * @return bool True on success. False on failure.
 */
function eh_crm_update_settingsmeta($id, $key, $value) {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_settingsmeta';
    if (!$wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE meta_key = %s AND settings_id = %d", $key, (int) $id))) {
        $response = eh_crm_insert_settingsmeta($id, $key, $value);
        if (!$response) {
            return false;
        }
        return true;
    }
    $where = array('settings_id' => (int) $id, 'meta_key' => $key);
    if (is_array($value)) {
        $data = array("meta_value" => serialize($value));
    } else {
        $data = array("meta_value" => $value);
    }
    $result = $wpdb->update($table, $data, $where);
    if (!$result) {
        return false;
    }
    return true;
}

/**
 * Delete Data from wsdesk_settingsmeta table.
 *
 *
 * @param int|string $id settings ID
 * @param string $key meta key
 * @return bool True on success. False on failure.
 */
function eh_crm_delete_settingsmeta($id, $key) {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_settingsmeta';
    if (!$wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE meta_key = %s AND settings_id = %d", $key, (int) $id))) {
        return false;
    }
    $query = "DELETE FROM $table WHERE settings_id = $id AND meta_key = '$key'";
    $result = $wpdb->query($query);
    if (!$result) {
        return false;
    }
    return true;
}

/**
 * Delete Data from wsdesk_settingsmeta table.
 *
 *
 * @param int|string $id settings ID
 * @param string $key meta key | Optional 
 * @return mixed ( If provided will return particular value or will return array of all meta of settings ID)
 */
function eh_crm_get_settingsmeta($id, $key = NULL) {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_settingsmeta';
    $meta_key = '';
    $retrived = array();
    if ($key !== NULL) {
        $meta_key = " AND meta_key = '" . $key . "'";
    }
    $data = $wpdb->get_results($wpdb->prepare("SELECT meta_key,meta_value FROM $table WHERE settings_id = %d" . $meta_key, (int) $id), ARRAY_A);
    if (!$data) {
        return false;
    }
    if ($key !== NULL) {
        return is_serialized($data[0]['meta_value']) ? unserialize($data[0]['meta_value']) : $data[0]['meta_value'];
    }
    for ($i = 0; $i < count($data); $i++) {
        $retrived[$data[$i]['meta_key']] = is_serialized($data[$i]['meta_value']) ? unserialize($data[$i]['meta_value']) : $data[$i]['meta_value'];
    }
    return is_serialized($retrived) ? unserialize($retrived) : $retrived;
}

/**
 * Insert Data into wsdesk_tickets table.
 *
 *
 * @param array $args (ticket_title,ticket_email,ticket_content,ticket_category,ticket_vendor)
 * @param array $meta (meta_key,meta_value) | Optional
 * @return int The Tickets ID on success. The value 0 or false on failure.
 */
function eh_crm_insert_ticket($args, $meta = array(),$import=FALSE) {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';
    $defaults = array(
        'ticket_author' => (is_user_logged_in()) ? get_current_user_id() : 0,
        'ticket_date' => gmdate("M d, Y h:i:s A"),
        'ticket_updated' => current_time('mysql'),
        'ticket_email' => '',
        'ticket_title' => '',
        'ticket_content' => '',
        'ticket_category' => '',
        'ticket_vendor' => '',
        'ticket_trash' => 0
    );
    $data = wp_parse_args($args, $defaults);
    $result = $wpdb->insert($table, $data);
    $ticket_id = (int) $wpdb->insert_id;
    if(!isset($data['ticket_parent']))
    {
        $meta['trigger_status'] = "created";
        $meta['trigger_changes'] = "none";
    }
    else
    {
        eh_crm_update_ticket($data['ticket_parent'], array("ticket_updated" => current_time('mysql')));
        eh_crm_update_ticketmeta($data['ticket_parent'], "trigger_status", "updated");
        if($data['ticket_category'] == 'raiser_reply')
            eh_crm_update_ticketmeta($data['ticket_parent'],"ticket_submitted","raiser_reply");
        else
            eh_crm_update_ticketmeta($data['ticket_parent'],"ticket_submitted",$data['ticket_author']);
    }
    if (!empty($meta)) {
        foreach ($meta as $key => $value) {
            eh_crm_insert_ticketmeta($ticket_id, $key, $value);
        }
    }
    if(!$import)
    {
        eh_crm_get_trigger_check_ticket($ticket_id);
    }
    if (!$result) {
        return false;
    }
    return $ticket_id;
}

/**
 * Update Existing Data into wsdesk_tickets table.
 *
 *
 * @param int|string $id Corresponding Settings ID that needs to be updated
 * @param array $data (ticket_title,ticket_email,ticket_content,ticket_category,ticket_vendor)
 * @return bool True on success. False on failure.
 */
function eh_crm_update_ticket($id, $data) {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';
    if (!$wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE ticket_id = %d", (int) $id))) {
        return false;
    }
    $where = array('ticket_id' => (int) $id);
    $result = $wpdb->update($table, $data, $where);
    if (!$result) {
        return false;
    }
    return true;
}

/**
 * Trash Existing Data from wsdesk_tickets table.
 *
 *
 * @param int|string $id Corresponding Settings ID that needs to be deleted
 * @return bool True on success. False on failure.
 */
function eh_crm_trash_ticket($id) {
    $result = eh_crm_update_ticket($id, array("ticket_trash"=>1));
    if (!$result) {
        return false;
    }
    return true;
}

/**
 * Restore Trash Existing Data from wsdesk_tickets table.
 *
 *
 * @param int|string $id Corresponding Settings ID that needs to be deleted
 * @return bool True on success. False on failure.
 */
function eh_crm_restore_trash_ticket($id) {
    $result = eh_crm_update_ticket($id, array("ticket_trash"=>0));
    if (!$result) {
        return false;
    }
    return true;
}

/**
 * Delete Existing Data from wsdesk_tickets table.
 *
 *
 * @param int|string $id Corresponding Settings ID that needs to be deleted
 * @return bool True on success. False on failure.
 */
function eh_crm_delete_ticket($id) {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';
    $table_meta = $wpdb->prefix . 'wsdesk_ticketsmeta';
    if (!$wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE ticket_id = %d", (int) $id))) {
        return false;
    }
    $meta = eh_crm_get_ticketmeta($id);
    if(isset($meta["ticket_attachment_path"]))
    {
        $attachment = $meta['ticket_attachment_path'];
        for($i=0;$i<count($attachment);$i++)
        {
            wp_delete_file($attachment[$i]);           
        }
    }
    $meta_query = "DELETE FROM $table_meta WHERE ticket_id = $id";
    $wpdb->query($meta_query);
    $query = "DELETE FROM $table WHERE ticket_id = $id";
    $result = $wpdb->query($query);
    if (!$result) {
        return false;
    }
    return true;
}

function eh_crm_get_ticket_search($value) {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';
    $vendor = '';
    if(EH_CRM_WOO_VENDOR)
    {
        $vendor = " AND ticket_vendor = '".EH_CRM_WOO_VENDOR."'";
    }
    $query = "select ticket_id from $table WHERE lower(concat(ticket_title,ticket_email,ticket_content,ticket_date)) LIKE lower('%$value%') AND ticket_trash = 0 AND ticket_parent=0 $vendor ORDER BY ticket_id DESC";
    $data = $wpdb->get_results($query, ARRAY_A);
    if (!$data) {
        return array();
    }
    return $data;
}
/**
 * Get Existing Data into wsdesk_tickets table.
 *
 *
 * @param array $args (ticket_title,ticket_email,ticket_content,ticket_category,ticket_vendor,ticket_parent) | ticket_email By column and value Eg: array('ticket_id'=>4)
 * @param array|string $fields (ticket_title,ticket_email,ticket_content,ticket_category,ticket_vendor) | Optional (Fields to return)
 * @return array Filtered or provided ID data as key value pair
 */
function eh_crm_get_ticket($args, $fields = NULL) {
    ini_set('max_execution_time', 300);
    $args['ticket_trash'] = 0;
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';
    $query_search = '';
    $query_field = '';
    if ($fields !== NULL) {
        if (is_array($fields)) {
            $query_field = implode(',', $fields);
        } else {
            $query_field = $fields;
        }
    } else {
        $query_field = '*';
    }
    if (is_array($args)) {
        $a = 1;
        foreach ($args as $key => $value) {
            switch ($key) {
                case 'ticket_id':
                    $query_search .= "ticket_id = " . (int) $args['ticket_id'];
                    break;
                case 'ticket_author':
                    $query_search .= "ticket_author = '" . $args['ticket_author'] . "'";
                    break;
                case 'ticket_email':
                    $query_search .= "ticket_email = '" . $args['ticket_email'] . "'";
                    break;
                case 'ticket_date':
                    $query_search .= "ticket_date = '" . $args['ticket_date'] . "'";
                    break;
                case 'ticket_title':
                    $query_search .= "ticket_title = '" . $args['ticket_title'] . "'";
                    break;
                case 'ticket_parent':
                    $query_search .= "ticket_parent = '" . $args['ticket_parent'] . "'";
                    break;
                case 'ticket_category':
                    $query_search .= "ticket_category = '" . $args['ticket_category'] . "'";
                    break;
                case 'ticket_vendor':
                    $query_search .= "ticket_vendor = '" . $args['ticket_vendor'] . "'";
                    break;
                case 'ticket_trash':
                    $query_search .= "ticket_trash = '" . $args['ticket_trash'] . "'";
                    break;
                default:
                    break;
            }
            if ($a < count(array_keys($args))) {
                $query_search .= " AND ";
                $a++;
            }
        }
    }
    $query = "select $query_field from $table WHERE $query_search";
    $data = $wpdb->get_results($query, ARRAY_A);
    if (!$data) {
        return false;
    }
    if(isset($data[0]['ticket_content']))
    {
        $data[0]['ticket_content'] = preg_replace('/<((script)[^>]*)>(.*)\<\/(script)>/Us', '&lt;$1&gt;$3&lt;/script&gt;', $data[0]['ticket_content']);
        $data[0]['ticket_content'] = htmlentities($data[0]['ticket_content']);
    }
    return $data;
}

/**
 * Insert Data into wsdesk_ticketsmeta table.
 *
 *
 * @param int|string $id ticket ID
 * @param string $key meta key
 * @param string $value meta value
 * @return bool True on success. False on failure.
 */
function eh_crm_insert_ticketmeta($id, $key, $value) {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_ticketsmeta';
    $query = "SELECT COUNT(*) FROM $table WHERE meta_key = '".$key."' AND ticket_id =".(int)$id;
    if ($wpdb->get_var($query)) {
        return false;
    }
    if (is_array($value)) {
        $data = serialize($value);
    } else {
        $data = $value;
    }
    $result = $wpdb->insert($table, array(
        'ticket_id' => (int) $id,
        'meta_key' => $key,
        'meta_value' => $data
    ));
    if (!$result) {
        return false;
    }
    return true;
}

/**
 * Update Data into wsdesk_ticketsmeta table.
 *
 *
 * @param int|string $id ticket ID
 * @param string $key meta key
 * @param string $value meta value
 * @return bool True on success. False on failure.
 */
function eh_crm_update_ticketmeta($id, $key, $value,$avoid = TRUE) {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_ticketsmeta';
    if (!$wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE meta_key = %s AND ticket_id = %d", $key, (int) $id))) {
        $response = eh_crm_insert_ticketmeta($id, $key, $value);
        if (!$response) {
            return false;
        }
        return true;
    }    
    $existing = eh_crm_get_ticketmeta($id,$key);
    if(is_array($existing))
    {
        $array_diff = array_diff($value, $existing);
        if(empty($array_diff))
        {
            $avoid = false;
        }
    }
    else
    {
        if($value==$existing)
        {
            $avoid = false;
        }
    }
    $where = array('ticket_id' => (int) $id, 'meta_key' => $key);
    if (is_array($value)) {
        $data = array("meta_value" => serialize($value));
    } else {
        $data = array("meta_value" => $value);
    }
    $result = $wpdb->update($table, $data, $where);
    if($avoid)
    {
        eh_crm_trigger_status_update($id,$key);
    }
    if (!$result) {
        return false;
    }
    return true;
}

function eh_crm_trigger_status_update($id,$key)
{
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_ticketsmeta';
    if (!$wpdb->get_var("SELECT COUNT(*) FROM $table WHERE meta_key = 'trigger_status' AND ticket_id = ".((int) $id))) {
        eh_crm_insert_ticketmeta($id, "trigger_status", "updated");
    }
    $value = "updated";
    $where = array('ticket_id' => (int) $id, 'meta_key' => "trigger_status");
    $data = array("meta_value" => $value);
    $result = $wpdb->update($table, $data, $where);
    if($key === "ticket_label" || $key === "ticket_assignee" || $key==="ticket_tags")
    {
        if (!$wpdb->get_var("SELECT COUNT(*) FROM $table WHERE meta_key = 'trigger_changes' AND ticket_id = ".((int) $id))) {
            eh_crm_insert_ticketmeta($id, "trigger_changes", $key);
        }
        $where = array('ticket_id' => (int) $id, 'meta_key' => "trigger_changes");
        $data = array("meta_value" => $key);
        $result = $wpdb->update($table, $data, $where);
    }
    eh_crm_get_trigger_check_ticket($id);
    if (!$result) {
        return false;
    }
    return true;
}

/**
 * Delete Data from wsdesk_ticketsmeta table.
 *
 *
 * @param int|string $id ticket ID
 * @param string $key meta key
 * @return bool True on success. False on failure.
 */
function eh_crm_delete_ticketmeta($id, $key) {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_ticketsmeta';
    if (!$wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE meta_key = %s AND ticket_id = %d", $key, (int) $id))) {
        return false;
    }
    $query = "DELETE FROM $table WHERE ticket_id = $id AND meta_key = '$key'";
    $result = $wpdb->query($query);
    if (!$result) {
        return false;
    }
    return true;
}

/**
 * Delete Data from wsdesk_ticketsmeta table.
 *
 *
 * @param int|string $id ticket ID
 * @param string $key meta key | Optional 
 * @return mixed ( If provided will return particular value or will return array of all meta of ticket ID)
 */
function eh_crm_get_ticketmeta($id, $key = NULL) {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_ticketsmeta';
    $meta_key = '';
    $retrived = array();
    if ($key !== NULL) {
        $meta_key = " AND meta_key = '" . $key . "'";
    }
    $data = $wpdb->get_results($wpdb->prepare("SELECT meta_key,meta_value FROM $table WHERE ticket_id = %d" . $meta_key, (int) $id), ARRAY_A);
    if (!$data) {
        return false;
    }
    if ($key !== NULL) {
        return is_serialized($data[0]['meta_value']) ? unserialize($data[0]['meta_value']) : $data[0]['meta_value'];
    }
    for ($i = 0; $i < count($data); $i++) {
        $retrived[$data[$i]['meta_key']] = is_serialized($data[$i]['meta_value']) ? unserialize($data[$i]['meta_value']) : $data[$i]['meta_value'];
    }
    return is_serialized($retrived) ? unserialize($retrived) : $retrived;
}

function eh_crm_get_vendor_tickets()
{
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';
    $where = '';
    if(EH_CRM_WOO_VENDOR)
    {
        $where = " WHERE ticket_vendor = '".EH_CRM_WOO_VENDOR."'";
    }
    $data = $wpdb->get_results("SELECT ticket_id FROM $table".$where, ARRAY_A);
    $id = array();
    if (!$data) {
        return array();
    } else {
        for ($i = 0; $i < count($data); $i++) {
            array_push($id, $data[$i]['ticket_id']);
        }
    }
    return $id;
}

/**
 * Get Value Count Data from wsdesk_ticketsmeta table.
 *
 *
 * @param string $key meta key
 * @param string $value meta value
 * @param string $order order by value
 * @param string $type Desc by default (sort type)
 * @param string $limit limit number of rows
 * @param string $offset starting from
 * @return array (Returns all match ticket_id)
 */
function eh_crm_get_ticketmeta_value_count($key, $value,$order = 'ticket_id', $type = 'DESC', $limit = 0,$offset=0) {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $tablemeta = $wpdb->prefix . 'wsdesk_ticketsmeta';
    $table = $wpdb->prefix . 'wsdesk_tickets';
    $where = '';
    $id = array();
    $return_id = array();
    if ($key !== NULL) {
        $where = "meta_key = '%s'";
        if ($order !== '') {
            $where .= " ORDER BY " . $order;
        }
        if($type !== '')
        {
            $where.= " " .$type;
        }
    }
    $vendor_id = eh_crm_get_vendor_tickets();
    $data = $wpdb->get_results("SELECT m.ticket_id,m.meta_value FROM $tablemeta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.meta_key = '$key' AND f.ticket_trash=0 ORDER BY f.$order $type", ARRAY_A);
    if (!$data) {
        return array();
    } else {
        for ($i = 0; $i < count($data); $i++) {
            if(in_array($data[$i]['ticket_id'], $vendor_id))
            {
                $meta_value = is_serialized($data[$i]['meta_value']) ? unserialize($data[$i]['meta_value']) : $data[$i]['meta_value'];
                if (is_array($meta_value)) {
                    if (in_array($value, $meta_value)) {
                        array_push($id, array("ticket_id"=>$data[$i]['ticket_id']));
                    }
                    elseif(is_array($value))
                    {
                        if ($meta_value === $value) {
                            array_push($id, array("ticket_id"=>$data[$i]['ticket_id']));
                        }
                    }
                } else {
                    if ($meta_value === $value) {
                        array_push($id, array("ticket_id"=>$data[$i]['ticket_id']));
                    }
                }
            }
        }
        if($limit!=0)
        {
            $return_id = array_slice($id,$offset,$limit);
        }
        else
        {
            $return_id = $id;
        }
    }
    return $return_id;
}

/**
 * Get Value Count Data from wsdesk_ticketsmeta table.
 *
 *
 * @param string $key tickets key
 * @param string $value tickets value
 * @param string $not (check not equal to) | Default False
 * @param string $exp_key tickets key
 * @param string $exp_value tickets value
 * @param string $order order by value
 * @param string $type Desc by default (sort type)
 * @param string $limit limit number of rows
 * @param string $offset starting from
 * @return array (Returns all match ticket_id)
 */
function eh_crm_get_ticket_value_count($key, $value, $not = false, $exp_key = '', $exp_value = '', $order = 'ticket_id', $type = 'DESC', $limit = '',$offset='') {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';
    $where = '';
    if ($key !== NULL) {
        if ($not === false) {
            $where .= " WHERE $key = '$value'";
        } else {
            $where .= " WHERE $key != '$value'";
        }
        if($where === "")
        {
            if(EH_CRM_WOO_VENDOR)
            {
                if($limit != 'vendor')
                {
                    $where .= " AND ticket_vendor = '".EH_CRM_WOO_VENDOR."'";
                }
            }
            if($where === "")
            {
                $where .= " WHERE ticket_trash = 0";
            }
        }
        else
        {
            if(EH_CRM_WOO_VENDOR)
            {
                if($limit != 'vendor')
                {
                    $where .= " AND ticket_vendor = '".EH_CRM_WOO_VENDOR."'";
                }
            }
            if($where === "")
            {
                $where .= " WHERE ticket_trash = 0";
            }
            else
            {
                $where .= " AND ticket_trash = 0";
            }
        }
        if ($exp_key !== '') {
            $where .= " AND $exp_key = '$exp_value'";
        }
        if ($order !== '') {
            $where .= " ORDER BY " . $order;
        }
        if($type !== '')
        {
            $where.= " " .$type;
        }
        if($limit!=='' && $limit!== 'vendor')
        {
            if($offset!='')
            {
                $where.=" LIMIT ".$offset.", ".$limit;
            }
            else 
            {
                $where.=" LIMIT ".$limit;
            }
        }
    } else {
        return array();
    }
    $data = $wpdb->get_results("SELECT ticket_id FROM $table".$where, ARRAY_A);
    if (!$data) {
        return array();
    }
    return $data;
}

/**
* Returns ticket_id of all tickets in the database irrespective of trash value. Used in factory reset.
**/
function eh_crm_get_all_tickets()
{
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';
    $data = $wpdb->get_results("SELECT ticket_id FROM $table", ARRAY_A);
    if (!$data) {
        return array();
    }
    return $data;
}
/** Reports Data **/
function eh_crm_generate_bar_values($get_for = 'all',$from_date,$to_date)
{
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';
    $vendor = '';
    $from_date = floor((time()-strtotime($from_date))/(60*60*24));
    $to_date = floor((time()-strtotime($to_date))/(60*60*24));
    if(EH_CRM_WOO_VENDOR)
    {
        $vendor = " AND ticket_vendor = '".EH_CRM_WOO_VENDOR."'";
    }
    $bar = array();
    for ($i = $from_date; $i >= $to_date; $i--) {
        $day = date('M d, Y', time() - $i * 86400);
        $data = $wpdb->get_results("SELECT ticket_id FROM $table WHERE ticket_parent = 0 AND ticket_trash = 0 AND ticket_date LIKE '%$day%' $vendor", ARRAY_A);
        $count = 0;
        if($get_for != "all")
        {
            for($j=0;$j<count($data);$j++)
            {
                $current_meta = eh_crm_get_ticketmeta($data[$j]['ticket_id'], "ticket_assignee");
                if($current_meta)
                {
                    if (in_array($get_for, $current_meta)) {
                            $count++;
                    }
                }
            }
            array_push($bar, array("y"=>$day,"a"=>$count));
        }
        else
        {
            array_push($bar, array("y"=>$day,"a"=>count($data)));
        }
    }
    return $bar;
}

function eh_crm_generate_donut_values($get_for = 'all',$from_date,$to_date)
{
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';
    $donut = array();
    $result = array();
    $week_tickets = array();
    $week_tickets_replies = array();
    $colors = array();
    $vendor = '';
    $from_date = floor((time()-strtotime($from_date))/(60*60*24));
    $to_date = floor((time()-strtotime($to_date))/(60*60*24));
    if(EH_CRM_WOO_VENDOR)
    {
        $vendor = " AND ticket_vendor = '".EH_CRM_WOO_VENDOR."'";
    }
    $user_roles_default = array("WSDesk_Agents", "WSDesk_Supervisor","administrator");
    for ($i = $from_date; $i >= $to_date; $i--) {
        $day = date('M d, Y', time() - $i * 86400);
        $data = $wpdb->get_results("SELECT ticket_id FROM $table WHERE ticket_parent = 0 AND ticket_trash = 0 AND ticket_date LIKE '%$day%' $vendor", ARRAY_A);
        for($j=0;$j<count($data);$j++)
        {
            array_push($week_tickets, $data[$j]['ticket_id']);
        }
    }
    for ($i = $from_date; $i >= $to_date; $i--) {
        $day = date('M d, Y', time() - $i * 86400);
        $data = $wpdb->get_results("SELECT ticket_id FROM $table WHERE ticket_parent != 0 AND ticket_trash = 0 AND ticket_date LIKE '%$day%' $vendor", ARRAY_A);
        for($j=0;$j<count($data);$j++)
        {
            array_push($week_tickets_replies, $data[$j]['ticket_id']);
        }
    }
    if($get_for == "all")
    {   
        $users = get_users(array("role__in" => $user_roles_default));
        for ($i = 0; $i < count($users); $i++) {
            $user_tickets = array();
            $current = $users[$i];
            $id = $current->ID;
            $user = new WP_User($id);
            $count = eh_crm_get_ticketmeta_value_count("ticket_assignee", $id);
            for($j=0;$j<count($count);$j++)
            {
                array_push($user_tickets, $count[$j]['ticket_id']);
            }
            $result = array_intersect($week_tickets, $user_tickets);
            array_push($donut, array("label"=>$user->display_name,"value"=>count($result)));
        }
        return $donut;
    }    
    else
    { 
        $user = get_user_by("ID",$get_for);
        $assigned = eh_crm_get_ticketmeta_value_count("ticket_assignee",$user->ID);
        $user_tickets_as = array();
        for($j=0;$j<count($assigned);$j++)
        {

            array_push($user_tickets_as, $assigned[$j]['ticket_id']);
        }
        array_push($donut, array("label"=>"Assigned","value"=>count(array_intersect($week_tickets, $user_tickets_as))));
        array_push($colors,"#79b2c4");
        $labels = eh_crm_get_settings(array("type" => "label"), array("slug", "title", "settings_id"));
        for($l=0;$l<count($labels);$l++)
        {
            $label_color = eh_crm_get_settingsmeta($labels[$l]['settings_id'],"label_color");
            $status = eh_crm_get_ticketmeta_value_count("ticket_label",$labels[$l]['slug']);
            $user_tickets_so =array();
            for($j=0;$j<count($status);$j++)
            {
                array_push($user_tickets_so, $status[$j]['ticket_id']);
            }
            array_push($donut, array("label"=>$labels[$l]['title'],"value"=>count(array_intersect($week_tickets,array_intersect($user_tickets_as, $user_tickets_so)))));
            array_push($colors,$label_color);
        }
        $user_tickets_re = array();
        $replies = eh_crm_get_ticket_value_count("ticket_parent",0,TRUE,"ticket_author",$user->ID);
        for($j=0;$j<count($replies);$j++)
        {
            array_push($user_tickets_re, $replies[$j]['ticket_id']);
        }
        array_push($donut, array("label"=>"Replies","value"=>count(array_intersect($week_tickets_replies, $user_tickets_re))));
        array_push($colors,"#6181e2");
        $data['donut'] = $donut;
        $data['color'] = $colors;
        return $data;
    }
}
function eh_crm_generate_line_values($get_for = 'all',$from_date,$to_date)
{
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';
    $vendor = '';
    $from_date = floor((time()-strtotime($from_date))/(60*60*24));
    $to_date = floor((time()-strtotime($to_date))/(60*60*24));
    if(EH_CRM_WOO_VENDOR)
    {
        $vendor = " AND ticket_vendor = '".EH_CRM_WOO_VENDOR."'";
    }
    $lines = array();
    for ($i = $from_date; $i >= $to_date; $i--) {
        $day = date('M d, Y', time() - $i * 86400);
        $eday = date('Y-m-d', time() - $i * 86400);
        $data = $wpdb->get_results("SELECT ticket_id FROM $table WHERE ticket_parent = 0 AND ticket_trash = 0 AND ticket_date LIKE '%$day%' $vendor", ARRAY_A);
        $new_count = 0;
        $sol_count = 0;
        $good = 0;
        $bad = 0;
        if($get_for != "all")
        {
            for($j=0;$j<count($data);$j++)
            {
                $current_meta = eh_crm_get_ticketmeta($data[$j]['ticket_id'], "ticket_assignee");
                if($current_meta)
                {
                    if (in_array($get_for, $current_meta)) {
                            $new_count++;
                            $current_meta = eh_crm_get_ticketmeta($data[$j]['ticket_id'], "ticket_label");
                            if($current_meta)
                            {
                                if ($current_meta == "label_LL02") {
                                        $sol_count++;
                                }
                            }
                    }
                    $rating = eh_crm_get_ticketmeta($data[$j]['ticket_id']);
                    if(isset($rating['ticket_rating']))
                    {
                        if($rating['ticket_rating'] === "great")
                        {
                            $good++;
                        }
                        else
                        {
                            $bad++;
                        }
                    }
                }
            }
            array_push($lines, array("y"=>$eday,"a"=>$new_count,"b"=>$sol_count,"c"=>$good,"d"=>$bad));
        }
        else
        {
            for($j=0;$j<count($data);$j++)
            {
                $current_meta = eh_crm_get_ticketmeta($data[$j]['ticket_id'], "ticket_label");
                if($current_meta)
                {
                    if ($current_meta == "label_LL02") {
                            $sol_count++;
                    }
                }
                $rating = eh_crm_get_ticketmeta($data[$j]['ticket_id']);
                if(isset($rating['ticket_rating']))
                {
                    if($rating['ticket_rating'] === "great")
                    {
                        $good++;
                    }
                    else
                    {
                        $bad++;
                    }
                }
            }
            array_push($lines, array("y"=>$eday,"a"=>count($data),"b"=>$sol_count,"c"=>$good,"d"=>$bad));
        }
    }
    return $lines;
}
function eh_crm_generate_donut_satisfaction_values($get_for = 'all',$from_date,$to_date)
{
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';
    $tablemeta = $wpdb->prefix . 'wsdesk_ticketsmeta';
    $donut = array();
    $result = array();
    $week_tickets = array();
    $week_tickets_replies = array();
    $colors = array();
    $vendor = '';
    $donut = array();
    $to_date = date('Y-m-d', strtotime($to_date)+(60*60*24));
    $ticket_ids = array();
    if(EH_CRM_WOO_VENDOR)
    {
        $vendor = " AND ticket_vendor = '".EH_CRM_WOO_VENDOR."'";
    }
    $user_roles_default = array("WSDesk_Agents", "WSDesk_Supervisor","administrator");
    if($get_for != 'all')
    {
        $assigned = $wpdb->get_results("SELECT m.ticket_id,m.meta_value FROM $tablemeta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.meta_key = 'ticket_assignee' AND f.ticket_trash=0 AND f.ticket_parent=0 AND f.ticket_updated BETWEEN '$from_date' and '$to_date' ORDER BY f.ticket_id DESC", ARRAY_A);
        foreach ($assigned as $tickets) {
            if(in_array($get_for, unserialize($tickets['meta_value'])))
            {
                array_push($ticket_ids, $tickets['ticket_id']);
            }
        }
        if(!empty($ticket_ids))
            $ticket_ids = implode(',' , $ticket_ids);
        else
        {
            $ticket_ids = 0;
        }
        $good = $wpdb->get_results("SELECT COUNT(*) FROM $tablemeta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.meta_key = 'ticket_rating' AND m.meta_value = 'great' AND f.ticket_id IN ($ticket_ids) AND f.ticket_updated BETWEEN '$from_date' and '$to_date' ORDER BY f.ticket_id DESC", ARRAY_A);
        $good = $good[0]['COUNT(*)'];
        array_push($donut, array('label'=>"Good", "value"=>$good));
        array_push($colors, "#88fcb6");
        $bad = $wpdb->get_results("SELECT COUNT(*) FROM $tablemeta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.meta_key = 'ticket_rating' AND m.meta_value = 'Bad' AND f.ticket_id IN ($ticket_ids) AND f.ticket_updated BETWEEN '$from_date' and '$to_date' ORDER BY f.ticket_id DESC", ARRAY_A);
        $bad = $bad[0]['COUNT(*)'];
        array_push($donut, array('label'=>"Bad", "value"=>$bad));
        array_push($colors, '#f7aba5');
        $data = array();
        $data['donut'] = $donut;
        $data['color'] = $colors;
        return $data;
    }
    else
    {
        $good = $wpdb->get_results("SELECT COUNT(*) FROM $tablemeta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.meta_key = 'ticket_rating' AND m.meta_value = 'great' AND f.ticket_updated BETWEEN '$from_date' and '$to_date' AND f.ticket_trash = 0 ORDER BY f.ticket_id DESC", ARRAY_A);
        $good = $good[0]['COUNT(*)'];
        array_push($donut, array('label'=>"Good", "value"=>$good));
        array_push($colors, "#88fcb6");
        $bad = $wpdb->get_results("SELECT COUNT(*) FROM $tablemeta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.meta_key = 'ticket_rating' AND m.meta_value = 'Bad' AND f.ticket_updated BETWEEN '$from_date' and '$to_date' AND f.ticket_trash = 0 ORDER BY f.ticket_id DESC", ARRAY_A);
        $bad = $bad[0]['COUNT(*)'];
        array_push($donut, array('label'=>"Bad", "value"=>$bad));
        array_push($colors, '#f7aba5');
        $data = array();
        $data['donut'] = $donut;
        $data['color'] = $colors;
        return $data;
    }
}
function eh_crm_woo_products_generate_bar_values($args = array())
{
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';
    $vendor = '';
    if(EH_CRM_WOO_VENDOR)
    {
        $vendor = " AND ticket_vendor = '".EH_CRM_WOO_VENDOR."'";
    }
    $bar = array();
    $count = array();
    for ($i = 6; $i >= 0; $i--) {
        $day = date('M d, Y', time() - $i * 86400);
        $data = $wpdb->get_results("SELECT ticket_id FROM $table WHERE ticket_parent = 0 AND ticket_trash = 0 AND ticket_date LIKE '%$day%' $vendor", ARRAY_A);
        for($j=0;$j<count($data);$j++)
        {
            $current_meta = eh_crm_get_ticketmeta($data[$j]['ticket_id'], "woo_product");
            if(empty($args))
            {
                if($current_meta && $current_meta !== "")
                {
                    if(!isset($count[$current_meta]))
                    {
                        $count[$current_meta] = 1;
                    }
                    else
                    {
                        $count[$current_meta] = $count[$current_meta]+1;
                    }
                }
            }
            else
            {
                if(in_array($current_meta, $args))
                {
                    if(!isset($count[$current_meta]))
                    {
                        $count[$current_meta] = 1;
                    }
                    else
                    {
                        $count[$current_meta] = $count[$current_meta]+1;
                    }

                }
            }
        }
    }
    arsort($count,SORT_REGULAR);
    $count_p = array_slice($count,0,7);
    if(count($count_p)!==0)
    {
        foreach ($count_p as $key => $value) {
            $field = eh_crm_get_settings(array("slug"=>"woo_product"));
            if($field)
            {
                $field_meta = eh_crm_get_settingsmeta($field[0]['settings_id'],"field_values");
                if(isset($field_meta[$key]))
                {
                    array_push($bar, array("y"=>substr($field_meta[$key], 0,20),"a"=>$value));
                }
            }
            else
            {
                array_push($bar, array("y"=>"No data","a"=>0));
            }
        }
    }
    else
    {
        array_push($bar, array("y"=>"No data","a"=>0));
    }
    return $bar;
}
function eh_crm_woo_category_generate_bar_values($args = array())
{
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';
    $vendor = '';
    if(EH_CRM_WOO_VENDOR)
    {
        $vendor = " AND ticket_vendor = '".EH_CRM_WOO_VENDOR."'";
    }
    $bar = array();
    $count = array();
    for ($i = 6; $i >= 0; $i--) {
        $day = date('M d, Y', time() - $i * 86400);
        $data = $wpdb->get_results("SELECT ticket_id FROM $table WHERE ticket_parent = 0 AND ticket_trash = 0 AND ticket_date LIKE '%$day%' $vendor", ARRAY_A);
        for($j=0;$j<count($data);$j++)
        {
            $current_meta = eh_crm_get_ticketmeta($data[$j]['ticket_id'], "woo_category");
            if(empty($args))
            {
                if($current_meta && $current_meta !== "")
                {
                    if(!isset($count[$current_meta]))
                    {
                        $count[$current_meta] = 1;
                    }
                    else
                    {
                        $count[$current_meta] = $count[$current_meta]+1;
                    }
                }
            }
            else
            {
                if(in_array($current_meta, $args))
                {
                    if(!isset($count[$current_meta]))
                    {
                        $count[$current_meta] = 1;
                    }
                    else
                    {
                        $count[$current_meta] = $count[$current_meta]+1;
                    }

                }
            }
        }
    }
    arsort($count,SORT_REGULAR);
    $count_p = array_slice($count,0,7);
    if(count($count_p)!==0)
    {
        foreach ($count_p as $key => $value) {
            $field = eh_crm_get_settings(array("slug"=>"woo_category"));
            if($field)
            {
                $field_meta = eh_crm_get_settingsmeta($field[0]['settings_id'],"field_values");
                if(isset($field_meta[$key]))
                {
                    array_push($bar, array("y"=>substr($field_meta[$key], 0,20),"a"=>$value));
                }
            }
            else
            {
                array_push($bar, array("y"=>"No data","a"=>0));
            }
        }
    }
    else
    {
        array_push($bar, array("y"=>"No data","a"=>0));
    }
    return $bar;
}
function eh_crm_generate_donut_values_tags($from_date, $to_date)
{
    global $wpdb;
    $tablemeta = $wpdb->prefix.'wsdesk_ticketsmeta';
    $table = $wpdb->prefix.'wsdesk_tickets';
    $avail_tags_wf = eh_crm_get_settings(array("type" => "tag"), array("slug", "title", "settings_id"));
    $from_date = floor((time()-strtotime($from_date))/(60*60*24));
    $to_date = floor((time()-strtotime($to_date))/(60*60*24));
    $donut = array();
    foreach ($avail_tags_wf as $key=>$value) {
        $donut[$key]['label'] = $value['title'];
        $donut[$key]['value'] = 0;
        for ($j = $from_date; $j >= $to_date; $j--) {
            $day = date('M d, Y', time() - $j * 86400);
            $data = $wpdb->get_results("SELECT m.ticket_id,m.meta_value FROM $tablemeta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.meta_key = 'ticket_tags' AND f.ticket_trash=0 AND f.ticket_date LIKE '%$day%' ORDER BY f.ticket_id DESC", ARRAY_A);
            for($i=0;$i<count($data); $i++)
            {
                $meta_value = unserialize($data[$i]['meta_value']);
                if(in_array($value['slug'], $meta_value))
                    $donut[$key]['value']++; 
            }
        }
    }
    return $donut;
}
//Generate Bar values for Average resolution time
function eh_crm_generate_bar_values_Avg($get_for = 'all',$from_date,$to_date)
{
    $date_starting = strtotime(eh_crm_get_formatted_date($from_date));
    $date_ending = strtotime(eh_crm_get_formatted_date($to_date));
    $user_roles_default = array("WSDesk_Agents", "WSDesk_Supervisor","administrator");
    if($get_for == "all")
    {   
        $in_min = array();
        $users = get_users(array("role__in" => $user_roles_default));
        for ($i = 0; $i < count($users); $i++)
        {
            $current = $users[$i];
            $in_minutes = eh_crm_all_agents($current->ID,$date_starting,$date_ending,$get_for);
            if( $in_minutes['resolution_time'] != 0 && $in_minutes['solved_tickets'][0] !=0 )
            {
                array_push($in_min,array($in_minutes['resolution_time'],$current->display_name,$in_minutes['solved_tickets'][0]));
            }
        }
        return $in_min; 
    }    
    else
    {   
        $user = get_user_by("ID",$get_for);
        $assigned = eh_crm_get_ticketmeta_value_count("ticket_assignee",$user->ID);
        $date_hour_minute = eh_crm_all_agents($user->ID,$date_starting,$date_ending,$get_for);
        return $date_hour_minute;
    }
}
//To check the Avgerage resolution time for all or particular agent.
function eh_crm_all_agents($id,$date_starting,$date_ending,$get_for)
{   
    $day = array();
    $time = array();
    $solved_tickets = array();
    $Minutes = 0;
    $Hours = 0;
    $solving_time = 0;
    $l = 0;
    $difference = eh_crm_total_time($id,$date_starting,$date_ending);
    for($i=0;$i<count($difference);$i++)
    {
        if($i==0)
        {
            $solved_tickets[$l] = count($difference);
            $l++;
        }
        if(!$difference[0])
        {
            $day[0] = 0;
        }
        else
        {
            $day[$i] = eh_crm_dateDiffe($difference[$i]['ticket_date'],$difference[$i]['ticket_updated']);  
        }
    }
    if(count($day) == 0)
    {
        $day[0][0] = 1;
    } 
    else
    {
        for($i=0;$i<count($day);$i++)
        {   
            $solving_time = $solving_time+$day[$i][0];       
            $Minutes = $Minutes+$day[$i][2];
            $Hours = $Hours+$day[$i][1];
        }
    }
    if($get_for == "all")
    {
        $days = ($solving_time/count($day))*24*60; 
        $Hours = ($Hours/count($day))*60;
        $Minutes = ($Minutes/count($day));
        $Minutes =intval($days+$Hours+$Minutes)+1;
        if(!$solved_tickets)
        {
            return array('resolution_time'=>$Minutes,'solved_tickets'=>0);   
        }
        else
        {
            return array('resolution_time'=>$Minutes,'solved_tickets'=>$solved_tickets);
        }
    }
    else
    {
        $days = intval($solving_time/count($day));
        $hours = intval($Hours/count($day));
        $minutes = intval($Minutes/count($day));
        $days_int = intval($solving_time%count($day))*24;
        $hours_int = intval(($Hours%count($day)))*60; 
        $hours = $hours+intval($days_int/count($day));
        $minutes = $minutes+intval($hours_int/count($day))+1;
        while($hours >= 24)
        {
            $hours = $hours-24;
            $days = $days+1;
        }
        while($minutes >= 60)
        {
            $minutes = $minutes-60;
            $hours = $hours+1;
        }
        return array($days,$hours,$minutes);
    }           
}
//To Get Total time of Solved tickets
function eh_crm_total_time($id,$date_starting,$date_ending)
{   
    $start = array();
    $end = array();
    $assigned = eh_crm_get_ticketmeta_value_count("ticket_assignee",$id);
    $assigned_ticket_ids = array();
    foreach ($assigned as $value) 
    {
        array_push($assigned_ticket_ids, $value['ticket_id']);
    }
    $solved_tickets = eh_crm_get_ticketmeta_value_count("ticket_label", "label_LL02");
    $solved_ticket_ids = array();
    foreach ($solved_tickets as $value)
    {
        array_push($solved_ticket_ids, $value['ticket_id']);
    }
    $assigned_and_solved = array_intersect($assigned_ticket_ids, $solved_ticket_ids);
    $difference = array();
    foreach($assigned_and_solved as $value)
    {   
        $ticket_id_get = array('ticket_id'=>$value);
        $query = eh_crm_get_ticket($ticket_id_get);
        $ticket_date_time = strtotime($query[0]['ticket_date']);
        if($ticket_date_time >= $date_starting && $ticket_date_time <= ($date_ending + (60*60*24)))
        {   
            $difference_each = array('ticket_date'=>$query[0]['ticket_date'], 'ticket_updated'=>$query[0]['ticket_updated']);
            array_push($difference, $difference_each);
        }
    }
    return $difference;
}
//To get the Days,Hours and Minutes Difference between From date,To date
function eh_crm_dateDiffe($from_date, $to_date) 
{  
    $from_date = strtotime($from_date);
    $to_date = strtotime($to_date);
    $diff = $to_date-$from_date;
    $days = floor($diff / 86400);
    $hours = floor(($diff-$days*86400)/3600);
    $minutes = floor(($diff-($days*86400+$hours*3600))/60);
    return array($days,$hours,$minutes);
}
/** view and Trigger section**/
function eh_crm_get_view_tickets($slug,$limit = 0,$offset=0)
{
    ini_set('max_execution_time', 300);
    $view       = eh_crm_get_settings(array("slug"=>$slug,"type"=>"view"),array("slug","settings_id","title"));
    $view_meta  = eh_crm_get_settingsmeta($view[0]['settings_id']);
    $conditions = $view_meta['view_conditions'];
    $format     = $view_meta['view_format'];
    $tickets_id = array();
    $result = array();
    foreach ($conditions as $cond_key => $cond_value) {
        $com_group = eh_crm_condition_validate_tickets($cond_value);
        switch ($cond_key) {
            case "and":
                if(count($com_group)>1)
                {
                    array_push($result,call_user_func_array('array_intersect', $com_group));
                }
                else
                {
                    array_push($result,$com_group);
                }
                break;
            case "or":
                if(count($com_group)>1)
                {
                    array_push($result,array_unique(call_user_func_array('array_merge', $com_group)));
                }
                else
                {
                    array_push($result,$com_group);
                }
                break;
            default:
                if($format === "and")
                {
                    if(count($com_group)>1)
                    {
                        array_push($result,call_user_func_array('array_intersect', $com_group));
                    }
                    else
                    {
                        array_push($result,$com_group);
                    }
                }
                else
                {
                    if(count($com_group)>1)
                    {
                        array_push($result,array_unique(call_user_func_array('array_merge', $com_group)));
                    }
                    else
                    {
                        array_push($result,$com_group);
                    }
                }
                break;
        }
    }
    $view_result = array();
    $alter_result = array();
    if(count($conditions)!=1)
    {
        foreach ($result as $cvalue) {
            $temp_result = array();
            eh_crm_walk_recursive($cvalue,$temp_result);
            array_push($alter_result,$temp_result);
        }
        if($format === "and")
        {
            $view_result = call_user_func_array('array_intersect', $alter_result);
        }
        else
        {
            $view_result = array_unique(call_user_func_array('array_merge', $alter_result));
        }
    }
    else
    {
        $view_result = $result;
    }
    $ids = array();
    eh_crm_walk_recursive($view_result,$ids);
    foreach ($ids as $val) {
        array_push($tickets_id, array('ticket_id'=> $val));
    }
    usort($tickets_id, 'eh_crm_sort_tickets_order');
    if($limit!=0)
    {
        $return_id = array_slice($tickets_id,$offset,$limit);
    }
    else
    {
        $return_id = $tickets_id;
    }
    return $return_id;
}
function eh_crm_walk_recursive($data,&$ids)
{
    if(is_array($data))
    {
        foreach ($data as $value) {
            eh_crm_walk_recursive($value,$ids);
        }
    }
    else
    {
        array_push($ids, $data);
    }
}
function eh_crm_sort_tickets_order($a, $b)
{
    if ($a['ticket_id'] == $b['ticket_id']) {
        return 0;
    }
    return ($a['ticket_id'] < $b['ticket_id']) ? 1 : -1;
}

function eh_crm_condition_validate_tickets($cond_value)
{
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';
    $table_meta = $wpdb->prefix . 'wsdesk_ticketsmeta';
    $return_id = array();
    $vendor_id = eh_crm_get_vendor_tickets();
    foreach($cond_value as $grp_single)
    {
        $val_id = array();
        $cond_type = $grp_single['type'];
        $cond_oper = $grp_single['operator'];
        $cond_val  = $grp_single['value'];
        switch ($cond_type) {
            case "ticket_status":
                $data = array();
                switch ($cond_val) {
                    case "created":
                        $data = eh_crm_get_ticketmeta_value_count("trigger_status", "created");
                        break;
                    case "updated":
                        $data = eh_crm_get_ticketmeta_value_count("trigger_status", "updated");
                        break;
                    default:
                        break;
                }
                if ($data) {
                    for ($i = 0; $i < count($data); $i++) {
                        array_push($val_id,$data[$i]['ticket_id']);
                    }
                }
                break;
            case "ticket_label":
                if($cond_oper=='not')
                {
                    $data = $wpdb->get_results("SELECT m.ticket_id,m.meta_value FROM $table_meta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.meta_key = 'ticket_label' AND f.ticket_trash = 0 AND m.meta_value NOT LIKE '$cond_val' ORDER BY f.ticket_updated DESC", ARRAY_A);
                }
                else if ($cond_oper=='in') {
                    $data = $wpdb->get_results("SELECT m.ticket_id,m.meta_value FROM $table_meta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.meta_key = 'ticket_label' AND f.ticket_trash = 0 AND m.meta_value LIKE '$cond_val' ORDER BY f.ticket_updated DESC", ARRAY_A);
                }
                else
                {
                    $data = $wpdb->get_results("SELECT m.ticket_id,m.meta_value FROM $table_meta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.meta_key = 'ticket_label' AND f.ticket_trash = 0 ORDER BY f.ticket_updated DESC", ARRAY_A);
                }
                $data = $wpdb->get_results("SELECT m.ticket_id,m.meta_value FROM $table_meta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.meta_key = 'ticket_label' AND f.ticket_trash = 0 ORDER BY f.ticket_updated DESC", ARRAY_A);
                if ($data) {
                    for ($i = 0; $i < count($data); $i++) {
                        $meta_value = is_serialized($data[$i]['meta_value']) ? unserialize($data[$i]['meta_value']) : $data[$i]['meta_value'];
                        switch ($cond_oper) {
                            case "not":
                                if ($meta_value != $cond_val) {
                                    array_push($val_id,$data[$i]['ticket_id']);
                                }
                                break;
                            case "in":
                                if ($meta_value == $cond_val) {
                                    array_push($val_id,$data[$i]['ticket_id']);
                                }
                                break;
                            case "changed":
                                $updated = eh_crm_get_ticketmeta($data[$i]['ticket_id'], "trigger_status");
                                $changed = eh_crm_get_ticketmeta($data[$i]['ticket_id'], "trigger_changes");
                                if($updated === "updated" && $changed=== "ticket_label" && $meta_value == $cond_val)
                                {
                                    array_push($val_id,$data[$i]['ticket_id']);
                                }
                                break;
                        }
                    }
                }
                break;
            case "ticket_assignee":
                $data = $wpdb->get_results("SELECT m.ticket_id,m.meta_value FROM $table_meta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.meta_key = 'ticket_assignee' AND f.ticket_trash = 0 ORDER BY f.ticket_updated DESC", ARRAY_A);
                $current_user = get_current_user_id();
                if ($data) {
                    for ($i = 0; $i < count($data); $i++) {
                        $meta_value = is_serialized($data[$i]['meta_value']) ? unserialize($data[$i]['meta_value']) : $data[$i]['meta_value'];
                        switch ($cond_oper) {
                            case "not":
                                if ($cond_val=="current") {
                                    if(!in_array($current_user, $meta_value)){
                                        array_push($val_id,$data[$i]['ticket_id']);
                                    }
                                }
                                else if($cond_val !== "un")
                                {
                                    if (!in_array($cond_val,$meta_value)) {
                                        array_push($val_id,$data[$i]['ticket_id']);
                                    }
                                }
                                
                                else
                                {
                                    if(!empty($meta_value))
                                    {
                                        array_push($val_id,$data[$i]['ticket_id']);
                                    }
                                }
                                break;
                            case "in":

                                if ($cond_val=="current") {
                                    if(in_array($current_user, $meta_value)){
                                        array_push($val_id,$data[$i]['ticket_id']);
                                    }
                                }
                                else if($cond_val !== "un")
                                {
                                    if (in_array($cond_val,$meta_value) || ($cond_val == 'any' && !empty($meta_value))) {
                                        array_push($val_id,$data[$i]['ticket_id']);
                                    }
                                }
                                else
                                {
                                    if(empty($meta_value))
                                    {
                                        array_push($val_id,$data[$i]['ticket_id']);
                                    }
                                }
                                break;
                            case "changed":
                                $updated = eh_crm_get_ticketmeta($data[$i]['ticket_id'], "trigger_status");
                                $changed = eh_crm_get_ticketmeta($data[$i]['ticket_id'], "trigger_changes");
                                if($updated === "updated" && $changed === "ticket_assignee" &&(in_array($cond_val,$meta_value) || $cond_val=='any' || ($cond_val == "current" && in_array($current_user, $meta_value))))
                                {
                                    array_push($val_id,$data[$i]['ticket_id']);
                                }
                                break;
                        }
                    }
                }
                break;
            case "ticket_tags":
                $data = $wpdb->get_results("SELECT m.ticket_id,m.meta_value FROM $table_meta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.meta_key = 'ticket_tags' AND f.ticket_trash = 0 ORDER BY f.ticket_updated DESC", ARRAY_A);
                if ($data) {
                    for ($i = 0; $i < count($data); $i++) {
                        $meta_value = is_serialized($data[$i]['meta_value']) ? unserialize($data[$i]['meta_value']) : $data[$i]['meta_value'];
                        switch ($cond_oper) 
                        {
                            case "atleast":
                                if ( count ( array_intersect($cond_val, $meta_value) ) > 0 ) {
                                    array_push($val_id,$data[$i]['ticket_id']);
                                }
                                break;
                            case "none":
                                if ( count ( array_intersect($cond_val, $meta_value) ) == 0 ) {
                                    array_push($val_id,$data[$i]['ticket_id']);
                                }
                                break;
                            case "all":
                                if ( count ( array_intersect($cond_val, $meta_value) ) == count($cond_val) ) {
                                    array_push($val_id,$data[$i]['ticket_id']);
                                }
                                break;
                        }
                    }
                }
                break;
            case "request_email":
            case "request_title":
            case "request_description":
                $search = "";
                switch ($cond_type) {
                    case "request_title":
                        $search = "ticket_title";
                        break;
                    case "request_email":
                        $search = "ticket_email";
                        break;
                    case "request_description":
                        $search = "ticket_content";
                        break;
                    default:
                        break;
                }
                switch ($cond_oper) {
                    case "contains":
                        $query = "select ticket_id from $table WHERE lower($search) LIKE lower('%$cond_val%') AND ticket_parent=0 AND ticket_trash = 0 ORDER BY ticket_updated DESC";
                        $data = $wpdb->get_results($query, ARRAY_A);
                        break;
                    case "none":
                        $query = "select ticket_id from $table WHERE lower($search) NOT LIKE lower('%$cond_val%') AND ticket_parent=0 AND ticket_trash = 0 ORDER BY ticket_updated DESC";
                        $data = $wpdb->get_results($query, ARRAY_A);
                }
                if ($data) {
                    for ($i = 0; $i < count($data); $i++) {
                        array_push($val_id,$data[$i]['ticket_id']);
                    }
                }
                break;
            case "ticket_forwarded":
                $data = $wpdb->get_results("SELECT m.ticket_id,m.meta_value FROM $table_meta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.meta_key = 'ticket_forwarded' AND f.ticket_trash = 0 ORDER BY f.ticket_updated DESC", ARRAY_A);
                if ($data) {
                    for ($i = 0; $i < count($data); $i++) {
                        $meta_value = is_serialized($data[$i]['meta_value']) ? unserialize($data[$i]['meta_value']) : $data[$i]['meta_value'];
                        switch($cond_oper)
                        {
                            case 'in':
                                if(in_array($cond_val,$meta_value))
                                {
                                    array_push($val_id,$data[$i]['ticket_id']);
                                }
                                break;
                            case 'not':
                                if(!in_array($cond_val,$meta_value))
                                {
                                    array_push($val_id,$data[$i]['ticket_id']);
                                }
                                break;
                        }
                    }
                }
                break;
            case "ticket_submitted":
            $data = $wpdb->get_results("SELECT m.ticket_id,m.meta_value FROM $table_meta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.meta_key = 'ticket_submitted' AND f.ticket_trash = 0 ORDER BY f.ticket_updated DESC", ARRAY_A);
                if ($data) {
                    for ($i = 0; $i < count($data); $i++) {
                        $meta_value = is_serialized($data[$i]['meta_value']) ? unserialize($data[$i]['meta_value']) : $data[$i]['meta_value'];
                        if(is_numeric($meta_value))
                        {
                            if(in_array($meta_value, $cond_val) || in_array('agent_reply', $cond_val))
                            {
                                array_push($val_id,$data[$i]['ticket_id']); 
                            }
                        }
                        else if(in_array($meta_value, $cond_val))
                        {
                            array_push($val_id,$data[$i]['ticket_id']);
                        }
                    }
                }
                break;
            default:
                $data = $wpdb->get_results("SELECT m.ticket_id,m.meta_value FROM $table_meta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.meta_key = '$cond_type' AND f.ticket_trash = 0 ORDER BY f.ticket_updated DESC", ARRAY_A);
                if ($data) {
                    for ($i = 0; $i < count($data); $i++) {
                        $meta_value = is_serialized($data[$i]['meta_value']) ? unserialize($data[$i]['meta_value']) : $data[$i]['meta_value'];
                        switch ($cond_oper)
                        {
                            case "atleast":
                                if ( count ( array_intersect($cond_val, $meta_value) ) > 0 ) {
                                    array_push($val_id,$data[$i]['ticket_id']);
                                }
                                break;
                            case "none":
                                if(is_array($cond_val))
                                {
                                    if ( count ( array_intersect($cond_val, $meta_value) ) == 0 ) {
                                        array_push($val_id,$data[$i]['ticket_id']);
                                    }
                                }
                                else
                                {
                                    if(!preg_match('/' . strtolower($cond_val) . '/', strtolower($meta_value)))
                                    {
                                        array_push($val_id,$data[$i]['ticket_id']);
                                    }
                                }
                                break;
                            case "all":
                                if ( count ( array_intersect($cond_val, $meta_value) ) == count($cond_val) ) {
                                    array_push($val_id,$data[$i]['ticket_id']);
                                }
                                break;
                            case "contains":
                                if(preg_match('/' . strtolower($cond_val) . '/', strtolower($meta_value)))
                                {
                                    array_push($val_id,$data[$i]['ticket_id']);
                                }
                                break;
                            case "not":
                                if(is_array($meta_value))
                                {
                                    if (!in_array($cond_val,$meta_value)) {
                                        array_push($val_id,$data[$i]['ticket_id']);
                                    }
                                }
                                else
                                {
                                    if ($cond_val != $meta_value) {
                                        array_push($val_id,$data[$i]['ticket_id']);
                                    }
                                }
                                break;
                            case "in":
                                if ($cond_val === $meta_value) {
                                    array_push($val_id,$data[$i]['ticket_id']);
                                }
                                break;
                            case "date_equal":
                                switch ($cond_val) {
                                    case 'TODAY':
                                        $cal_val = strtotime('today');
                                        if ($cal_val === strtotime($meta_value)) {
                                            array_push($val_id,$data[$i]['ticket_id']);
                                        }
                                        break;
                                    case 'TOMORROW':
                                        $cal_val = strtotime('tomorrow');
                                        if ($cal_val === strtotime($meta_value)) {
                                            array_push($val_id,$data[$i]['ticket_id']);
                                        }
                                        break;
                                    case 'YESTERDAY':
                                        $cal_val = strtotime('yesterday');
                                        if ($cal_val === strtotime($meta_value)) {
                                            array_push($val_id,$data[$i]['ticket_id']);
                                        }
                                        break;
                                    default:
                                        if (strtotime($cond_val) === strtotime($meta_value)) {
                                            array_push($val_id,$data[$i]['ticket_id']);
                                        }
                                        break;
                                }
                                break;
                            case "date_greater":
                                switch ($cond_val) {
                                    case 'TODAY':
                                        $cal_val = strtotime('today');
                                        if ($cal_val < strtotime($meta_value)) {
                                            array_push($val_id,$data[$i]['ticket_id']);
                                        }
                                        break;
                                    case 'TOMORROW':
                                        $cal_val = strtotime('tomorrow');
                                        if ($cal_val < strtotime($meta_value)) {
                                            array_push($val_id,$data[$i]['ticket_id']);
                                        }
                                        break;
                                    case 'YESTERDAY':
                                        $cal_val = strtotime('yesterday');
                                        if ($cal_val < strtotime($meta_value)) {
                                            array_push($val_id,$data[$i]['ticket_id']);
                                        }
                                        break;
                                    default:
                                        if (strtotime($cond_val) < strtotime($meta_value)) {
                                            array_push($val_id,$data[$i]['ticket_id']);
                                        }
                                        break;
                                }
                                break;
                            case "date_smaller":
                                switch ($cond_val) {
                                    case 'TODAY':
                                        $cal_val = strtotime('today');
                                        if ($cal_val > strtotime($meta_value)) {
                                            array_push($val_id,$data[$i]['ticket_id']);
                                        }
                                        break;
                                    case 'TOMORROW':
                                        $cal_val = strtotime('tomorrow');
                                        if ($cal_val > strtotime($meta_value)) {
                                            array_push($val_id,$data[$i]['ticket_id']);
                                        }
                                        break;
                                    case 'YESTERDAY':
                                        $cal_val = strtotime('yesterday');
                                        if ($cal_val > strtotime($meta_value)) {
                                            array_push($val_id,$data[$i]['ticket_id']);
                                        }
                                        break;
                                    default:
                                        if (strtotime($cond_val) > strtotime($meta_value)) {
                                            array_push($val_id,$data[$i]['ticket_id']);
                                        }
                                        break;
                                }
                                break;
                        }
                    }
                }
                break;
        }
        $validated = array_intersect($vendor_id, $val_id);
        array_push($return_id,$validated);
    }
    return $return_id;
}

function eh_crm_view_tickets_group($tickets_ids,$group_by)
{
    $ids = array();
    foreach ($tickets_ids as $id_value) {
        array_push($ids, $id_value['ticket_id']);
    }
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';
    $vendor = '';
    if(EH_CRM_WOO_VENDOR)
    {
        $vendor = " AND ticket_vendor = '".EH_CRM_WOO_VENDOR."'";
    }
    $table_meta = $wpdb->prefix . 'wsdesk_ticketsmeta';
    $grouped = array();
    if(empty($ids))
    {
        return $grouped;
    }
    switch ($group_by)
    {
        case "ticket_label":
            $data = $wpdb->get_results("SELECT m.ticket_id,m.meta_value FROM $table_meta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.ticket_id IN ( ". implode(',', $ids)." ) AND m.meta_key = 'ticket_label' AND f.ticket_trash = 0 ORDER BY f.ticket_updated DESC", ARRAY_A);
            if ($data) {
                for ($i = 0; $i < count($data); $i++) {
                    $meta_value = is_serialized($data[$i]['meta_value']) ? unserialize($data[$i]['meta_value']) : $data[$i]['meta_value'];
                    $label = eh_crm_get_settings(array("slug"=>$meta_value,"type"=>"label"));
                    $grouped["Label : ".$label[0]['title']][] = array("ticket_id"=>$data[$i]['ticket_id']);
                }
            }
            break;
        case "ticket_assignee":
            $data = $wpdb->get_results("SELECT m.ticket_id,m.meta_value FROM $table_meta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.ticket_id IN ( ". implode(',', $ids)." ) AND m.meta_key = 'ticket_assignee' AND f.ticket_trash = 0 ORDER BY f.ticket_updated DESC", ARRAY_A);
            if ($data) {
                for ($i = 0; $i < count($data); $i++) {
                    $meta_value = is_serialized($data[$i]['meta_value']) ? unserialize($data[$i]['meta_value']) : $data[$i]['meta_value'];
                    $users = array();
                    foreach ($meta_value as $u_id) {
                        $cur_user = get_user_by("ID", $u_id);
                        array_push($users, $cur_user->display_name);
                    }
                    $arr_key = "";
                    if(empty($users))
                    {
                        $arr_key = "Assignee : Unassigned";
                    }
                    else
                    {
                        $arr_key = "Assignee : ".implode(', ', $users);
                    }
                    $grouped[$arr_key][] = array("ticket_id"=>$data[$i]['ticket_id']);
                }
            }
            break;
        case "ticket_tags":
            $data = $wpdb->get_results("SELECT m.ticket_id,m.meta_value FROM $table_meta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.ticket_id IN ( ". implode(',', $ids)." ) AND m.meta_key = 'ticket_tags' AND f.ticket_trash = 0 ORDER BY f.ticket_updated DESC", ARRAY_A);
            if ($data) {
                for ($i = 0; $i < count($data); $i++) {
                    $meta_value = is_serialized($data[$i]['meta_value']) ? unserialize($data[$i]['meta_value']) : $data[$i]['meta_value'];
                    $tags = array();
                    foreach ($meta_value as $t_id) {
                        $tag = eh_crm_get_settings(array("slug"=>$t_id,"type"=>"tag"));
                        array_push($tags, $tag[0]['title']);
                    }
                    if(empty($tags))
                    {
                        $arr_key = "Tags : Unassigned";
                    }
                    else
                    {
                        $arr_key = "Tags : ".implode(', ', $tags);
                    }
                    $grouped[$arr_key][] = array("ticket_id"=>$data[$i]['ticket_id']);
                }
            }
            break;
        case "request_email":
        case "request_title":
            $search = "";
            $append = "";
            switch ($group_by) {
                case "request_title":
                    $append = "Ticket Title : ";
                    $search = "ticket_title";
                    break;
                case "request_email":
                    $append = "Ticket Email : ";
                    $search = "ticket_email";
                    break;
                default:
                    break;
            }
            $query = "select ticket_id,$search from $table WHERE ticket_id IN ( ". implode(',', $ids)." ) AND ticket_parent=0 AND ticket_trash = 0 $vendor ORDER BY ticket_updated DESC";
            $data = $wpdb->get_results($query, ARRAY_A);
            if ($data) {
                for ($i = 0; $i < count($data); $i++) {
                    $grouped[$append.$data[$i][$search]][] = array("ticket_id"=>$data[$i]['ticket_id']);
                }
            }
            break;
        case "":
            $grouped = $tickets_ids;
            break;
        default:
            $data = $wpdb->get_results("SELECT m.ticket_id,m.meta_value FROM $table_meta m JOIN $table f ON m.ticket_id = f.ticket_id WHERE m.ticket_id IN ( ". implode(',', $ids)." ) AND m.meta_key = '$group_by' AND f.ticket_trash = 0 ORDER BY f.ticket_updated DESC", ARRAY_A);
            if ($data) {
                for($i=0;$i<count($tickets_ids);$i++) {
                    $tickets_ids[$i]['meta_value'] = "";
                }
                foreach($tickets_ids as $ti_k => $ti_id) {
                    for($j=0;$j<count($data);$j++)
                    {
                        if($data[$j]['ticket_id'] === $ti_id['ticket_id'])
                        {
                            unset($tickets_ids[$ti_k]);
                        }
                    }
                }
                $data = array_merge_recursive($data,$tickets_ids);
                for ($i = 0; $i < count($data); $i++) {
                    $meta_value = is_serialized($data[$i]['meta_value']) ? unserialize($data[$i]['meta_value']) : $data[$i]['meta_value'];
                    $field = eh_crm_get_settings(array("slug"=>$group_by,"type"=>"field"));
                    $field_meta = eh_crm_get_settingsmeta($field[0]['settings_id']);
                    if(is_array($meta_value))
                    {
                        $defaults = array();
                        foreach ($meta_value as $f_id) 
                        {                            
                            if(isset($field_meta['field_values']))
                            {
                                array_push($defaults, $field_meta['field_values'][$f_id]);
                            }
                        }
                        $arr_key="";
                        if(empty($defaults))
                        {
                            $arr_key = $field[0]['title']." : Not Mentioned";
                        }
                        else
                        {
                            $arr_key = $field[0]['title']." : ".implode(', ', $defaults);
                        }
                        $grouped[$arr_key][] = array("ticket_id"=>$data[$i]['ticket_id']);
                    }
                    else
                    {
                        
                        if(isset($field_meta['field_values']))
                        {
                            $arr_key="";
                            if($meta_value === "")
                            {
                                $arr_key = $field[0]['title']." : Not Mentioned";
                            }
                            else
                            {
                                $arr_key = $field[0]['title']." : ".$field_meta['field_values'][$meta_value];
                            }
                            $grouped[$arr_key][] = array("ticket_id"=>$data[$i]['ticket_id']);
                        }
                        else
                        {
                            $arr_key="";
                            if($meta_value === "")
                            {
                                $arr_key = $field[0]['title']." : Not Mentioned";
                            }
                            else
                            {
                                $arr_key = $field[0]['title']." : ".$meta_value;
                            }
                            $grouped[$arr_key][] = array("ticket_id"=>$data[$i]['ticket_id']);
                        }
                    }
                }
            }
            break;
    }
    return $grouped;
}

function eh_crm_get_view_data()
{
    $get_agent_users = get_users(array("role__in" => array("WSDesk_Agents", "WSDesk_Supervisor","administrator")));
    $condition_assignee = array();
    for ($i = 0; $i < count($get_agent_users); $i++) {
        $current = $get_agent_users[$i];
        $id = $current->ID;
        $user = new WP_User($id);
        $condition_assignee[$i]['id'] = $id;
        $condition_assignee[$i]['name'] = $user->display_name;
    }
    $condition_fields = eh_crm_get_settings(array("type" => "field"),array("slug","title","settings_id"));
    $condition_labels = eh_crm_get_settings(array("type" => "label"),array("slug","title","settings_id"));
    $condition_tags = eh_crm_get_settings(array("type" => "tag"),array("slug","title","settings_id"));
    $options = '<option value="">'.__('Select a Condition', 'wsdesk').'</option>';
    $group_by = '<option value="">'.__('No Group', 'wsdesk').'</option>';
    $script = array();
    $label_script = array();
    $tags_script = array();
    $assignee_script = array();

    //New view for e-mail forwarded
    $forwarded_script['operator'] = array("not"=>__("Is Not","wsdesk"),"in"=>__("In", "wsdesk"));
    $forwarded_script['type'] = "text";
    $options .= '<option value="ticket_forwarded">'.__("Ticket : To Email (Forwarded From Email)", "wsdesk").'</option>';
    $forwarded_script['values'] = array();
    $script['ticket_forwarded'] = $forwarded_script;
    
    if(!empty($condition_labels))
    {
        $label_values = array();
        $label_script['operator'] = array("not"=>"Not in","in"=>"In");
        for($i=0;$i<count($condition_labels);$i++)
        {
            $label_values[$condition_labels[$i]["slug"]] = $condition_labels[$i]["title"];
        }
        $label_script['type'] = "select";
        $label_script['values'] = $label_values;
    }
    if(!empty($label_script))
    {
        $options .= '<option value="ticket_label">'.__("Ticket : Assigned -> Label (Status)", "wsdesk").'</option>';
        $group_by .= '<option value="ticket_label">'.__("Ticket Label (Status)", "wsdesk").'</option>';
        $script['ticket_label'] = $label_script;
    }
    if(!empty($condition_assignee))
    {
        $assignee_values = array();
        $assignee_script['operator'] = array("not"=>__("Not Assigned to", "wsdesk"),"in"=>__("Assigned to", "wsdesk"));
        for($i=0;$i<count($condition_assignee);$i++)
        {
            $assignee_values[$condition_assignee[$i]["id"]] = $condition_assignee[$i]["name"];
        }
        $assignee_values["un"] = __("Unassigned", "wsdesk");
        $assignee_values['current'] = __("Current User", "wsdesk");
        $assignee_script['type'] = "select";
        $assignee_script['values'] = $assignee_values;
    }
    if(!empty($assignee_script))
    {
        $options .= '<option value="ticket_assignee">'.__("Ticket : Assigned -> Assignee", "wsdesk").'</option>';
        $group_by .= '<option value="ticket_assignee">'.__("Ticket Assignee", "wsdesk").'</option>';
        $script['ticket_assignee'] = $assignee_script;
    }
    if(!empty($condition_tags))
    {
        $tag_values = array();
        $tags_script['operator'] = array("atleast"=>__("Atleast any one tag","wsdesk"),"none"=>__("None of the tag", "wsdesk"),"all"=>__("All the specified Tags","wsdesk"));
        for($i=0;$i<count($condition_tags);$i++)
        {
            $tag_values[$condition_tags[$i]["slug"]] = $condition_tags[$i]["title"];
        }
        $tags_script['type'] = "multiselect";
        $tags_script['values'] = $tag_values;
    }
    if(!empty($tags_script))
    {
        $options .= '<option value="ticket_tags">'.__('Ticket : Assigned -> Tags').'</option>';
        $group_by .= '<option value="ticket_tags">'.__('Ticket Tags').'</option>';
        $script['ticket_tags'] = $tags_script;
    }
    for($i=0;$i<count($condition_fields);$i++)
    {
        $field_values = array();
        $field_meta = eh_crm_get_settingsmeta($condition_fields[$i]["settings_id"]);
        switch ($field_meta['field_type']) {
            case "text":
                $field_values['operator'] = array("contains"=>"Contains the Word","none"=>"Does not contain the Word");
                $field_values['type'] = "text";
                $options .= '<option value="'.$condition_fields[$i]["slug"].'">Ticket : Field -> '.$condition_fields[$i]["title"].'</option>';
                $group_by .= '<option value="'.$condition_fields[$i]["slug"].'">'.$condition_fields[$i]["title"].'</option>';
                $script[$condition_fields[$i]["slug"]] = $field_values;
                break;
            case "date":
                $field_values['operator'] = array("date_equal"=>"Date is","date_greater"=>"Date after","date_smaller"=>"Date before");
                $field_values['type'] = "text";
                $options .= '<option value="'.$condition_fields[$i]["slug"].'">Ticket : Field -> '.$condition_fields[$i]["title"].'</option>';
                $group_by .= '<option value="'.$condition_fields[$i]["slug"].'">'.$condition_fields[$i]["title"].'</option>';
                $script[$condition_fields[$i]["slug"]] = $field_values;
                break;
            case "textarea":
                $field_values['operator'] = array("contains"=>"Contains the Word","none"=>"Does not contain the Word");
                $field_values['type'] = "text";
                $options .= '<option value="'.$condition_fields[$i]["slug"].'">Ticket : Field -> '.$condition_fields[$i]["title"].'</option>';
                $script[$condition_fields[$i]["slug"]] = $field_values;
                break;
            case "email":
                $field_values['operator'] = array("contains"=>"Contains the Word in Email","none"=>"Does not contain the Word in EMail");
                $field_values['type'] = "text";
                $options .= '<option value="'.$condition_fields[$i]["slug"].'">Ticket : Field -> '.$condition_fields[$i]["title"].'</option>';
                $group_by .= '<option value="'.$condition_fields[$i]["slug"].'">'.$condition_fields[$i]["title"].'</option>';
                $script[$condition_fields[$i]["slug"]] = $field_values;
                break;
            case "phone":
            case "number":
                $field_values['operator'] = array("contains"=>"Contains the Number","none"=>"Does not contain the Number");
                $field_values['type'] = "text";
                $options .= '<option value="'.$condition_fields[$i]["slug"].'">Ticket : Field -> '.$condition_fields[$i]["title"].'</option>';
                $group_by .= '<option value="'.$condition_fields[$i]["slug"].'">'.$condition_fields[$i]["title"].'</option>';
                $script[$condition_fields[$i]["slug"]] = $field_values;
                break;
            case "select":
                $field_values['operator'] = array("not"=>"Not in","in"=>"In");
                $field_values['type'] = "select";
                $field_values['values'] = $field_meta['field_values'];
                $options .= '<option value="'.$condition_fields[$i]["slug"].'">Ticket : Field -> '.$condition_fields[$i]["title"].'</option>';
                $group_by .= '<option value="'.$condition_fields[$i]["slug"].'">'.$condition_fields[$i]["title"].'</option>';
                $script[$condition_fields[$i]["slug"]] = $field_values;
                break;
            case "radio":
                $field_values['operator'] = array("not"=>"Not in","in"=>"In");
                $field_values['type'] = "select";
                $field_values['values'] = $field_meta['field_values'];
                $options .= '<option value="'.$condition_fields[$i]["slug"].'">Ticket : Field -> '.$condition_fields[$i]["title"].'</option>';
                $group_by .= '<option value="'.$condition_fields[$i]["slug"].'">'.$condition_fields[$i]["title"].'</option>';
                $script[$condition_fields[$i]["slug"]] = $field_values;
                break;
            case "checkbox":
                $field_values['operator'] = array("atleast"=>"Atleast any one of the Values","none"=>"None of the Value","all"=>"All the specified Values");
                $field_values['type'] = "multiselect";
                $field_values['values'] = $field_meta['field_values'];
                $options .= '<option value="'.$condition_fields[$i]["slug"].'">Ticket : Field -> '.$condition_fields[$i]["title"].'</option>';
                $group_by .= '<option value="'.$condition_fields[$i]["slug"].'">'.$condition_fields[$i]["title"].'</option>';
                $script[$condition_fields[$i]["slug"]] = $field_values;
            default:
                break;
        }
    }
    $options .= '<option value="ticket_source">Ticket : Source -> Received Through</option>';
    $source_script['operator'] = array("not"=>"Not in","in"=>"In");
    $source_script['type'] = "select";
    $source_script['values'] = array("Form"=>"Form","EMail"=>"EMail","Zendesk"=>"Zendesk","Agent"=>"Agent", "API"=>"API");
    $script["ticket_source"] = $source_script;
    $script['options'] = $options;
    $script['group'] = $group_by;
    return $script;
}

function eh_crm_get_trigger_data()
{
    $get_agent_users = get_users(array("role__in" => array("WSDesk_Agents", "WSDesk_Supervisor","administrator")));
    $condition_assignee = array();
    for ($i = 0; $i < count($get_agent_users); $i++) {
        $current = $get_agent_users[$i];
        $id = $current->ID;
        $user = new WP_User($id);
        $condition_assignee[$i]['id'] = $id;
        $condition_assignee[$i]['name'] = $user->display_name;
    }
    $condition_fields = eh_crm_get_settings(array("type" => "field"),array("slug","title","settings_id"));
    $condition_labels = eh_crm_get_settings(array("type" => "label"),array("slug","title","settings_id"));
    $condition_tags = eh_crm_get_settings(array("type" => "tag"),array("slug","title","settings_id"));
    $options = '<option value="">Select a Condition</option>';
    $script = array();

    //New view for e-mail forwarded
    $forwarded_script['operator'] = array("not"=>__("Is Not","wsdesk"),"in"=>__("In", "wsdesk"));
    $forwarded_script['type'] = "text";
    $options .= '<option value="ticket_forwarded">'.__("Ticket : To Email (Forwarded From Email)", "wsdesk").'</option>';
    $forwarded_script['values'] = array();
    $script['ticket_forwarded'] = $forwarded_script;
    
    $options .= '<option value="ticket_status">Ticket :</option>';
    $ticket_script['operator'] = array("in"=>"Is");
    $ticket_script['type'] = "select";
    $ticket_script['values'] = array("created"=>"Created","updated"=>"Updated");
    $script["ticket_status"] = $ticket_script;

    $options .= '<option value="ticket_submitted">Ticket : Submitted</option>';
    $ticket_script['operator'] = array("in"=>"By");
    $ticket_script['type'] = "multiselect";
    $submit_values['agent_reply'] = "Any Agent";
    $submit_values['raiser_reply'] = "Ticket Raiser";
    for ($i = 0; $i < count($get_agent_users); $i++) {
        $submit_values[$get_agent_users[$i]->ID] = $get_agent_users[$i]->display_name;
    }
    $ticket_script['values'] = $submit_values;
    $script["ticket_submitted"] = $ticket_script;
    
    $label_script = array();
    $tags_script = array();
    $assignee_script = array();
    if(!empty($condition_labels))
    {
        $label_values = array();
        $label_script['operator'] = array("not"=>"Is Not","in"=>"Is","changed"=>"Changed to");
        for($i=0;$i<count($condition_labels);$i++)
        {
            $label_values[$condition_labels[$i]["slug"]] = $condition_labels[$i]["title"];
        }
        $label_script['type'] = "select";
        $label_script['values'] = $label_values;
    }
    if(!empty($label_script))
    {
        $options .= '<option value="ticket_label">Ticket : Assigned -> Status</option>';
        $script['ticket_label'] = $label_script;
    }
    if(!empty($condition_assignee))
    {
        $assignee_values = array();
        $assignee_script['operator'] = array("not"=>"Not Assigned to","in"=>"Assigned to","changed"=>"Changed to");
        for($i=0;$i<count($condition_assignee);$i++)
        {
            $assignee_values[$condition_assignee[$i]["id"]] = $condition_assignee[$i]["name"];
        }
        $assignee_values["any"] = "Anyone";
        $assignee_values["un"] = "Unassigned";
        $assignee_values['current'] = "Current User";
        $assignee_script['type'] = "select";
        $assignee_script['values'] = $assignee_values;
    }
    if(!empty($assignee_script))
    {
        $options .= '<option value="ticket_assignee">Ticket : Assigned -> Assignee</option>';
        $script['ticket_assignee'] = $assignee_script;
    }
    if(!empty($condition_tags))
    {
        $tag_values = array();
        $tags_script['operator'] = array("atleast"=>"Atleast any one tag","none"=>"None of the tag","all"=>"All the specified Tags");
        for($i=0;$i<count($condition_tags);$i++)
        {
            $tag_values[$condition_tags[$i]["slug"]] = $condition_tags[$i]["title"];
        }
        $tags_script['type'] = "multiselect";
        $tags_script['values'] = $tag_values;
    }
    if(!empty($tags_script))
    {
        $options .= '<option value="ticket_tags">Ticket : Assigned -> Tags</option>';
        $script['ticket_tags'] = $tags_script;
    }
    $options .= '<option value="ticket_source">Ticket : Source -> Received Through</option>';
    $source_script['operator'] = array("not"=>"Not in","in"=>"In");
    $source_script['type'] = "select";
    $source_script['values'] = array("Form"=>"Form","EMail"=>"EMail","Zendesk"=>"Zendesk", "API"=>"API");
    $script["ticket_source"] = $source_script;
    for($i=0;$i<count($condition_fields);$i++)
    {
        $field_values = array();
        $field_meta = eh_crm_get_settingsmeta($condition_fields[$i]["settings_id"]);
        switch ($field_meta['field_type']) {
            case "text":
                $field_values['operator'] = array("contains"=>"Contains the Word","none"=>"Does not contain the Word");
                $field_values['type'] = "text";
                $options .= '<option value="'.$condition_fields[$i]["slug"].'">Ticket : Field -> '.$condition_fields[$i]["title"].'</option>';
                $script[$condition_fields[$i]["slug"]] = $field_values;
                break;
            case "date":
                $field_values['operator'] = array("date_equal"=>"Date is","date_greater"=>"Date after","date_smaller"=>"Date before");
                $field_values['type'] = "text";
                $options .= '<option value="'.$condition_fields[$i]["slug"].'">Ticket : Field -> '.$condition_fields[$i]["title"].'</option>';
                $script[$condition_fields[$i]["slug"]] = $field_values;
                break;
            case "textarea":
                $field_values['operator'] = array("contains"=>"Contains the Word","none"=>"Does not contain the Word");
                $field_values['type'] = "text";
                $options .= '<option value="'.$condition_fields[$i]["slug"].'">Ticket : Field -> '.$condition_fields[$i]["title"].'</option>';
                $script[$condition_fields[$i]["slug"]] = $field_values;
                break;
            case "email":
                $field_values['operator'] = array("contains"=>"Contains the Word in Email","none"=>"Does not contain the Word in EMail");
                $field_values['type'] = "text";
                $options .= '<option value="'.$condition_fields[$i]["slug"].'">Ticket : Field -> '.$condition_fields[$i]["title"].'</option>';
                $script[$condition_fields[$i]["slug"]] = $field_values;
                break;
            case "phone":
            case "number":
                $field_values['operator'] = array("contains"=>"Contains the Number","none"=>"Does not contain the Number");
                $field_values['type'] = "text";
                $options .= '<option value="'.$condition_fields[$i]["slug"].'">Ticket : Field -> '.$condition_fields[$i]["title"].'</option>';
                $script[$condition_fields[$i]["slug"]] = $field_values;
                break;
            case "select":
                $field_values['operator'] = array("not"=>"Not in","in"=>"In");
                $field_values['type'] = "select";
                $field_values['values'] = $field_meta['field_values'];
                $options .= '<option value="'.$condition_fields[$i]["slug"].'">Ticket : Field -> '.$condition_fields[$i]["title"].'</option>';
                $script[$condition_fields[$i]["slug"]] = $field_values;
                break;
            case "radio":
                $field_values['operator'] = array("not"=>"Not in","in"=>"In");
                $field_values['type'] = "select";
                $field_values['values'] = $field_meta['field_values'];
                $options .= '<option value="'.$condition_fields[$i]["slug"].'">Ticket : Field -> '.$condition_fields[$i]["title"].'</option>';
                $script[$condition_fields[$i]["slug"]] = $field_values;
                break;
            case "checkbox":
                $field_values['operator'] = array("atleast"=>"Atleast any one of the Values","none"=>"None of the Value","all"=>"All the specified Values");
                $field_values['type'] = "multiselect";
                $field_values['values'] = $field_meta['field_values'];
                $options .= '<option value="'.$condition_fields[$i]["slug"].'">Ticket : Field -> '.$condition_fields[$i]["title"].'</option>';
                $script[$condition_fields[$i]["slug"]] = $field_values;
            default:
                break;
        }
    }
    $script['options'] = $options;
    return $script;
}

function eh_crm_get_trigger_action_data()
{
    $get_agent_users = get_users(array("role__in" => array("WSDesk_Agents", "WSDesk_Supervisor","administrator")));
    $action_assignee = array();
    for ($i = 0; $i < count($get_agent_users); $i++) {
        $current = $get_agent_users[$i];
        $id = $current->ID;
        $user = new WP_User($id);
        $action_assignee[$i]['id'] = $id;
        $action_assignee[$i]['name'] = $user->display_name;
    }
    $action_labels = eh_crm_get_settings(array("type" => "label"),array("slug","title","settings_id"));
    $action_tags = eh_crm_get_settings(array("type" => "tag"),array("slug","title","settings_id"));
    $options = '<option value="">Select a Action</option>';
    $script = array();
    $label_script = array();
    $tags_script = array();
    $assignee_script = array();
    if(!empty($action_labels))
    {
        $label_values = array();
        for($i=0;$i<count($action_labels);$i++)
        {
            $label_values[$action_labels[$i]["slug"]] = $action_labels[$i]["title"];
        }
        $label_script['type'] = "select";
        $label_script['values'] = $label_values;
    }
    if(!empty($label_script))
    {
        $options .= '<option value="ticket_label">Ticket : Change -> Label (Status)</option>';
        $script['ticket_label'] = $label_script;
    }
    if(!empty($action_assignee))
    {
        $assignee_values = array();
        for($i=0;$i<count($action_assignee);$i++)
        {
            $assignee_values[$action_assignee[$i]["id"]] = $action_assignee[$i]["name"];
        }
        $assignee_values["un"] = "Unassigned";
        $assignee_script['type'] = "select";
        $assignee_script['values'] = $assignee_values;
    }
    if(!empty($assignee_script))
    {
        $options .= '<option value="ticket_assignee">Ticket : Change -> Assignee</option>';
        $script['ticket_assignee'] = $assignee_script;
    }
    if(!empty($action_tags))
    {
        $tag_values = array();
        for($i=0;$i<count($action_tags);$i++)
        {
            $tag_values[$action_tags[$i]["slug"]] = $action_tags[$i]["title"];
        }
        $tags_script['type'] = "multiselect";
        $tags_script['values'] = $tag_values;

        $add_tags_script['type'] = "multiselect";
        $add_tags_script['values'] = $tag_values;
    }
    if(!empty($tags_script))
    {
        $options .= '<option value="ticket_tags">Ticket : Change -> Tags</option>';
        $script['ticket_tags'] = $tags_script;

        $options .= '<option value="ticket_add_tags">Ticket : Add -> Tags</option>';
        $script['ticket_add_tags'] = $add_tags_script;
    } 
    $options .= '<option value="notify">Notification -> Email to</option>';
    $notify_script['type'] = "notification";
    $notify_values = array("requestor"=>"Ticket Requester","assignee"=>"Ticket Assignee");
    for($i=0;$i<count($action_assignee);$i++)
    {
        $notify_values[$action_assignee[$i]["id"]] = "Agent : ".$action_assignee[$i]["name"];
    }
    $notify_script['values'] = $notify_values;
    $script["notify"] = $notify_script;
    if(EH_CRM_WSDESK_SMS_NOTIFICATION_STATUS)
    {
        $options .= '<option value="sms">Notification -> SMS to</option>';
        $notify_script['type'] = "sms";
        $script["sms"] = $notify_script;
    }
    $script['options'] = $options;
    return $script;
}

function eh_crm_get_trigger_tickets($slug){
    ini_set('max_execution_time', 300);
    $trigger       = eh_crm_get_settings(array("slug"=>$slug,"type"=>"trigger"),array("slug","settings_id","title"));
    $trigger_meta  = eh_crm_get_settingsmeta($trigger[0]['settings_id']);
    $conditions = $trigger_meta['trigger_conditions'];
    $format     = $trigger_meta['trigger_format'];
    $tickets_id = array();
    $result = array();
    foreach ($conditions as $cond_key => $cond_value) {
        $com_group = eh_crm_condition_validate_tickets($cond_value);
        $data = array();
        switch ($cond_key) {
           case "and":
                if(count($com_group)>1)
                {
                    $data = array_keys(array_flip(call_user_func_array('array_intersect', $com_group)));
                }
                else
                {
                    $data = array_shift($com_group);
                }
                break;
            case "or":
                if(count($com_group)>1)
                {
                    $data = array_keys(array_flip(call_user_func_array('array_merge', $com_group)));
                }
                else
                {
                    $data = array_shift($com_group);
                }
                break;
            default:
                if($format === "and")
                {
                    if(count($com_group)>1)
                    {
                        $data = array_keys(array_flip(call_user_func_array('array_intersect', $com_group)));
                    }
                    else
                    {
                        $data = array_shift($com_group);
                    }
                }
                else
                {
                    if(count($com_group)>1)
                    {
                        $data = array_keys(array_flip(call_user_func_array('array_merge', $com_group)));
                    }
                    else
                    {
                        $data = array_shift($com_group);
                    }
                }
                break;
        }
        array_push($result, $data);
    }
    $trigger_result = array();
    if(count($conditions)>1)
    {
        if($format === "and")
        {
            array_push($trigger_result,array_keys(array_flip(call_user_func_array('array_intersect', $result))));
        }
        else
        {
            array_push($trigger_result,array_keys(array_flip(call_user_func_array('array_merge', $result))));
        }
    }
    else
    {
        $trigger_result = $result;
    }
    foreach ($trigger_result as $value) {
        foreach ($value as $val) {
            array_push($tickets_id, array('ticket_id'=> $val));
        }
    }
    return $tickets_id;
}

function eh_crm_get_trigger_check_ticket($id)
{
    $trigger = eh_crm_get_settings(array("type"=>"trigger"));
    $selected_triggers = eh_crm_get_settingsmeta(0, "selected_triggers");
    $scheduled_trigger_array = get_option('wsdesk_scheduled_triggers');
    if(!$selected_triggers)
    {
        $selected_triggers = array();
    }
    if(!$scheduled_trigger_array)
    {
        $scheduled_trigger_array = array();
    }
    $triggered_tic = array();
    for($i=0;$i<count($trigger);$i++)
    {
        if(in_array($trigger[$i]['slug'], $selected_triggers))
        {
            $meta = eh_crm_get_settingsmeta($trigger[$i]['settings_id']);
            $ids = eh_crm_get_trigger_tickets($trigger[$i]['slug']);
            if(isset($meta["trigger_schedule"]) && $meta["trigger_schedule"] == "")
            {
                for($j=0;$j<count($ids);$j++)
                {
                    if($ids[$j]['ticket_id'] == $id)
                    {
                        eh_crm_trigger_perform_action($trigger[$i]['slug'],array(array("ticket_id"=>$id)));
                        array_push($triggered_tic,$id);
                    }
                }
            }
            else if(isset($meta["trigger_schedule"]) && $meta["trigger_schedule"] != "")
            {
                for($j=0;$j<count($ids);$j++)
                {
                    if($ids[$j]['ticket_id'] == $id)
                    {
                        $scheduled_trigger = array(
                            'ticket_id'=>$id,
                            'trigger_slug'=>$trigger[$i]['slug'],
                            'action_time'=> time(),
                            'triggered'=>'no'
                        );
                        $notfound = true;
                        foreach ($scheduled_trigger_array as $key => $value) {
                            if($value['ticket_id']==$id && $value['trigger_slug'] == $trigger[$i]['slug'])
                            {
                                $scheduled_trigger_array[$key] = $scheduled_trigger;
                                $notfound = false;
                            }
                        }
                        if($notfound)
                        {
                            array_push($scheduled_trigger_array, $scheduled_trigger);
                        }
                        update_option('wsdesk_scheduled_triggers',$scheduled_trigger_array);
                    }
                }
            }
        }
    }
    for($i=0;$i<count(array_unique($triggered_tic));$i++)
    {
        eh_crm_update_ticketmeta($triggered_tic[$i], "trigger_status", "triggered",FALSE);
        eh_crm_update_ticketmeta($triggered_tic[$i], "trigger_changes", "none",FALSE);
        eh_crm_update_ticketmeta($triggered_tic[$i], "ticket_submitted", "none",FALSE);
    }
}

function eh_crm_trigger_perform_action($slug,$ticket_ids){
    $trigger       = eh_crm_get_settings(array("slug"=>$slug,"type"=>"trigger"),array("slug","settings_id","title"));
    $trigger_meta  = eh_crm_get_settingsmeta($trigger[0]['settings_id']);
    $actions        = $trigger_meta['trigger_actions'];
    $conditions        = $trigger_meta['trigger_conditions'];
    for($i=0;$i<count($ticket_ids);$i++)
    {
        $ticket =  eh_crm_get_ticket(array('ticket_id'=>$ticket_ids[$i]['ticket_id']));
        if($ticket[0]['ticket_parent']!=0)
            $ticket_ids[$i]['ticket_id'] = $ticket[0]['ticket_parent'];
    
        $status = eh_crm_get_ticketmeta($ticket_ids[$i]['ticket_id'], "trigger_status");
        if($status !=="triggered")
        {
            foreach ($actions as $action) {
                switch ($action['type']) {
                    case "ticket_label":
                        eh_crm_update_ticketmeta($ticket_ids[$i]['ticket_id'], "ticket_label", $action['value'],false);
                        break;
                    case "ticket_assignee":
                        if($action['value']!=="un")
                        {
                            eh_crm_update_ticketmeta($ticket_ids[$i]['ticket_id'], "ticket_assignee", array($action['value']),false);
                        }
                        else
                        {
                            eh_crm_update_ticketmeta($ticket_ids[$i]['ticket_id'], "ticket_assignee", array(),false);
                        }
                        break;
                    case "ticket_tags":
                        eh_crm_update_ticketmeta($ticket_ids[$i]['ticket_id'], "ticket_tags", $action['value'],false);
                        break;
                    case "ticket_add_tags":
                        $ticket_tags = eh_crm_get_ticketmeta($ticket_ids[$i]['ticket_id'], "ticket_tags");
                        foreach ($action['value'] as $value) {
                            if(!in_array($value, $ticket_tags))
                            {
                                array_push($ticket_tags, $value);
                            }
                        }
                        eh_crm_update_ticketmeta($ticket_ids[$i]['ticket_id'], "ticket_tags", $ticket_tags,false);
                        break;
                    case "notify":
                        $ticket = eh_crm_get_ticket(array("ticket_id"=>$ticket_ids[$i]['ticket_id']));
                        $ticket_meta = eh_crm_get_ticketmeta($ticket_ids[$i]['ticket_id']);
                        $email = array();
                        foreach($action['value'] as $act_val)
                        {
                            switch ($act_val) {
                                case "requestor":
                                    array_push($email, $ticket[0]['ticket_email']);
                                    break;
                                case "assignee":
                                    $assignee = eh_crm_get_ticketmeta($ticket[0]['ticket_id'], "ticket_assignee");
                                    foreach ($assignee as $value) {
                                        $user = new WP_User($value);
                                        array_push($email, $user->user_email);
                                    }
                                    break;
                                default:
                                    $user = new WP_User($act_val);
                                if($user && isset($user->roles) && !empty($user->roles))
                                    {
                                        foreach( $user->roles as $role)
                                        {
                                                switch ($role)
                                                {
                                                        case 'WSDesk_Agents':
                                                                array_push($email, $user->user_email);
                                                        break;
                                                        case 'administrator':
                                                                array_push($email, $user->user_email);
                                                        break;
                                                        case 'WSDesk_Supervisor':
                                                                array_push($email, $user->user_email);
                                                        break;
                                                }
                                        }
                                    }
                                    break;
                            }
                        }
                        $subject = 'Ticket ['.$ticket_ids[$i]['ticket_id'].'] : '.$action['subject'];
                        $message = $action['body'];
                        $condition_true_fale = array();
                        if(!empty($email) && !empty($conditions))
                        {   if(isset($conditions['and']))
                            {
                                foreach($conditions['and'] as $key => $value)
                                {
                                    $condition_type = $value['type'];
                                    if($condition_type == 'ticket_status')
                                    {
                                        $condition_type = 'trigger_status';
                                    }
                                    $condition_operator = $value['operator'];
                                    $condition_value = $value['value'];
                                    if($condition_operator == 'in' && $condition_value == $ticket_meta[$condition_type])
                                    {
                                        $condition_true_fale[$key] = 1;
                                    }
                                    else if($condition_operator != 'in' && $condition_value != $ticket_meta[$condition_type])
                                    {
                                        $condition_true_fale[$key] = 1;
                                    }else
                                    {
                                        $condition_true_fale[$key] = 0;
                                    }
                                    
                                }
                                
                                if(count(array_unique($condition_true_fale)) === 1)
                                {
                                    eh_crm_trigger_fire_email($ticket_ids[$i]['ticket_id'], $email, $subject, $message);
                                }
                            }else{
                                eh_crm_trigger_fire_email($ticket_ids[$i]['ticket_id'], $email, $subject, $message);    
                            }
                            
                        }
                        break;
                    case 'sms':
                        if(EH_CRM_WSDESK_SMS_NOTIFICATION_STATUS)
                        {
                            $ticket = eh_crm_get_ticket(array("ticket_id"=>$ticket_ids[$i]['ticket_id']));
                            $to_numbers = array();
                            foreach($action['value'] as $act_val)
                            {
                                switch ($act_val) {
                                    case "requestor":
                                        $phone_number = eh_crm_get_ticketmeta($ticket_ids[$i]['ticket_id'], "phone_number");
                                        if(!empty($phone_number))
                                            array_push($to_numbers, $phone_number);
                                        break;
                                    case "assignee":
                                        $assignee = eh_crm_get_ticketmeta($ticket[0]['ticket_id'], "ticket_assignee");
                                        foreach ($assignee as $value) {
                                            $phone_number = get_user_meta( $value, 'wsdesk_sms_phone_no', true );
                                            if(!empty($phone_number))
                                            {
                                                array_push($to_numbers, $phone_number);
                                            }
                                        }
                                        break;
                                    default:
                                        $phone_number = get_user_meta( $act_val, 'wsdesk_sms_phone_no', true );
                                        if(!empty($phone_number))
                                        {
                                            array_push($to_numbers, $phone_number);
                                        }
                                        break;
                                }
                            }
                            $message = $action['body'];
                            $condition_true_fale = array();
                            if(!empty($to_numbers) && !empty($conditions))
                            {   if(isset($conditions['and']))
                                {
                                    foreach($conditions['and'] as $key => $value)
                                    {
                                        $condition_type = $value['type'];
                                        if($condition_type == 'ticket_status')
                                        {
                                            $condition_type = 'trigger_status';
                                        }
                                        $condition_operator = $value['operator'];
                                        $condition_value = $value['value'];
                                        if($condition_operator == 'in' && $condition_value == $ticket_meta[$condition_type])
                                        {
                                            $condition_true_fale[$key] = 1;
                                        }
                                        else if($condition_operator != 'in' && $condition_value != $ticket_meta[$condition_type])
                                        {
                                            $condition_true_fale[$key] = 1;
                                        }else
                                        {
                                            $condition_true_fale[$key] = 0;
                                        }
                                    }
                                    
                                    if(count(array_unique($condition_true_fale)) === 1)
                                    {
                                        eh_crm_trigger_fire_sms($ticket_ids[$i]['ticket_id'], $to_numbers, $message);
                                    }
                                }else{
                                    eh_crm_trigger_fire_sms($ticket_ids[$i]['ticket_id'], $to_numbers, $message);    
                                }
                                
                            }
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    }
}

function eh_crm_trigger_fire_email($ticket_id,$to,$subject,$message){
    $ticket = eh_crm_get_ticket(array("ticket_id"=>$ticket_id));
    $meta = eh_crm_get_ticketmeta($ticket_id);
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
    $ticket_assignee = empty($ticket_assignee_name)?"No Assignee":implode(", ", $ticket_assignee_name);
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
    $ticket_tags_name = empty($ticket_tags)?"No Tags":implode(", ", $ticket_tags);
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
    
    $message = str_replace('[id]',$ticket_id,$message);
    $subject = str_replace('[id]',$ticket_id,$subject);
    $message = str_replace('[assignee]',$ticket_assignee,$message);
    $message = str_replace('[tags]',$ticket_tags_name,$message);
    $date = eh_crm_get_formatted_date($ticket[0]['ticket_date']);
    $message = str_replace('[date]',$date,$message);
    $message = str_replace('[latest_reply]', eh_crm_get_ticket_latest_content($ticket_id),$message);
    $message = str_replace('[latest_reply_with_notes]', eh_crm_get_ticket_latest_notes($ticket_id),$message);
    $message = str_replace('[agent_replied]',$replier_name,$message);
    $subject = str_replace('[request_title]',$ticket[0]['ticket_title'],$subject);
    $message = str_replace('[status]',$ticket_label,$message);
    $selected_fields = eh_crm_get_settingsmeta(0, "selected_fields");
    $avail_fields = eh_crm_get_settings(array("type" => "field"), array("slug", "title", "settings_id"));
    foreach ($avail_fields as $field) {
        if($field['slug'] === 'google_captcha' || !in_array($field['slug'], $selected_fields))
        {
            continue;
        }
        if (strpos($message, '['.$field['slug'].']') !== false) {
            switch ($field['slug']) {
                case "request_email":
                    $message = str_replace('[request_email]',$ticket[0]['ticket_email'],$message);
                    break;
                case "request_title":
                    $message = str_replace('[request_title]',$ticket[0]['ticket_title'],$message);
                    break;
                case "request_description":
                    $message = str_replace('[request_description]',$ticket[0]['ticket_content'],$message);
                    break;
            }
            $field_meta = eh_crm_get_settingsmeta($field['settings_id']);
            switch ($field_meta['field_type']) {
                case "file":
                    $file_value = (isset($meta['ticket_attachment'])? $meta['ticket_attachment']:array());
                    $file_data = '';
                    if(!empty($file_value))
                    {
                        foreach($file_value as $tic_attachemnt)
                        {
                            $file_data .= $tic_attachemnt.'<br />';
                        }
                    }
                    $message = str_replace('['.$field['slug'].']',$file_data,$message);
                    break;
                case "text":
                case "number":
                case "email":
                case "password":
                case 'textarea':
                case 'date':
                case 'ip':
                case 'phone':
                    $value = (isset($meta[$field['slug']])?$meta[$field['slug']]:"");
                    $message = str_replace('['.$field['slug'].']',$value,$message);
                    break;
                case 'select':
                    if($field['slug']=='woo_order_id')
                    {
                        $value = (isset($meta[$field['slug']])?$meta[$field['slug']]:"");
                        $message = str_replace('['.$field['slug'].']',$value,$message);
                    }
                    else
                    {
                        $value = (isset($meta[$field['slug']])?$meta[$field['slug']]:"");
                        $option = (isset($field_meta['field_values'][$value])?$field_meta['field_values'][$value]:"");
                        $message = str_replace('['.$field['slug'].']',$option,$message);
                    }
                    break;
                case "checkbox":
                case "radio":
                case 'woo_product':
                case 'woo_category':
                case 'woo_tags':
                case 'woo_vendors':
                    $value = (isset($meta[$field['slug']])?$meta[$field['slug']]:"");
                    $option = (isset($field_meta['field_values'][$value])?$field_meta['field_values'][$value]:"");
                    $message = str_replace('['.$field['slug'].']',$option,$message);
                    break;
            }
         }
    }
    if (strpos($message, '[conversation_history]') !== false) {
        if ($ticket_id != 0) {
            $reply_content = eh_crm_get_ticket_data($ticket_id);
            $msg = eh_crm_get_conversation_template($reply_content);
            $message = str_replace('[conversation_history]', $msg, $message);
        }
    }
    if (strpos($message, '[conversation_history_with_agent_note]') !== false)
    {
        if ($ticket_id != 0) {
            $reply_content = eh_crm_get_ticket_data_with_note($ticket_id);
            $msg = eh_crm_get_conversation_template($reply_content);
            $message = str_replace('[conversation_history_with_agent_note]', $msg, $message);
        }
    }
    if(eh_get_url_by_shortcode('[wsdesk_satisfaction]') !== "")
    {
        if(!defined('WSDESK_SATISFACTION_URL_TEXT'))
        {
            $url_text = 'Give a Support Review';
        }
        else
        {
            $url_text = WSDESK_SATISFACTION_URL_TEXT;
        }
        $message = str_replace('[satisfaction_data]',"<a href='".eh_get_url_by_shortcode('[wsdesk_satisfaction]')."?id=".$ticket[0]['ticket_id']."&wsdesk_author=".$ticket[0]['ticket_email']."' targer='_blank' rel='nofollow'>".$url_text."</a>",$message);
    }
    do_action('wpml_switch_language_for_email', $to);
    $support_email_name = eh_crm_get_settingsmeta('0', "support_reply_email_name");
    $support_email = eh_crm_get_settingsmeta('0', "support_reply_email");
    $headers = array();
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    if($support_email != '')
    {
        $headers[] = 'From: '.$support_email_name.' <'.$support_email.'>';
    }
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
    $html.= htmlspecialchars_decode(str_replace("\n", '<br/>', $message));
    $html.= eh_crm_get_poweredby_scripts();
    $html.= '</body></html>';
    try {
        if(eh_crm_validate_email_block($to, 'send'))
        {
            wp_mail($to, $subject, $html,$headers);
            do_action('wpml_reset_language_after_mailing');
        }
    } catch (Exception $exc) {
        error_log($exc->getTraceAsString());
    }
}

function eh_crm_trigger_fire_sms($ticket_id, $to_numbers, $message){
    $ticket = eh_crm_get_ticket(array("ticket_id"=>$ticket_id));
    $meta = eh_crm_get_ticketmeta($ticket_id);
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
    $ticket_assignee = empty($ticket_assignee_name)?"No Assignee":implode(", ", $ticket_assignee_name);
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
    $ticket_tags_name = empty($ticket_tags)?"No Tags":implode(", ", $ticket_tags);
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
    $message = str_replace('[id]',$ticket_id,$message);
    $message = str_replace('[assignee]',$ticket_assignee,$message);
    $message = str_replace('[tags]',$ticket_tags_name,$message);
    $date = eh_crm_get_formatted_date($ticket[0]['ticket_date']);
    $message = str_replace('[date]',$date,$message);
    $message = str_replace('[latest_reply]', eh_crm_get_ticket_latest_content($ticket_id),$message);
    $message = str_replace('[latest_reply_with_notes]', eh_crm_get_ticket_latest_notes($ticket_id),$message);
    $message = str_replace('[agent_replied]',$replier_name,$message);
    $message = str_replace('[request_title]',$ticket[0]['ticket_title'],$message);
    $message = str_replace('[status]',$ticket_label,$message);
    $selected_fields = eh_crm_get_settingsmeta(0, "selected_fields");
    $avail_fields = eh_crm_get_settings(array("type" => "field"), array("slug", "title", "settings_id"));
    foreach ($avail_fields as $field) {
        if($field['slug'] === 'google_captcha' || !in_array($field['slug'], $selected_fields))
        {
            continue;
        }
        if (strpos($message, '['.$field['slug'].']') !== false) {
            switch ($field['slug']) {
                case "request_email":
                    $message = str_replace('[request_email]',$ticket[0]['ticket_email'],$message);
                    break;
                case "request_title":
                    $message = str_replace('[request_title]',$ticket[0]['ticket_title'],$message);
                    break;
                case "request_description":
                    $message = str_replace('[request_description]',$ticket[0]['ticket_content'],$message);
                    break;
            }
            $field_meta = eh_crm_get_settingsmeta($field['settings_id']);
            switch ($field_meta['field_type']) {
                case "file":
                    $file_value = (isset($meta['ticket_attachment'])? $meta['ticket_attachment']:array());
                    $file_data = '';
                    if(!empty($file_value))
                    {
                        foreach($file_value as $tic_attachemnt)
                        {
                            $file_data .= $tic_attachemnt.'<br />';
                        }
                    }
                    $message = str_replace('['.$field['slug'].']',$file_data,$message);
                    break;
                case "text":
                case "number":
                case "email":
                case "password":
                case 'textarea':
                case 'date':
                case 'ip':
                case 'phone':
                    $value = (isset($meta[$field['slug']])?$meta[$field['slug']]:"");
                    $message = str_replace('['.$field['slug'].']',$value,$message);
                    break;
                case 'select':
                    if($field['slug']=='woo_order_id')
                    {
                        $value = (isset($meta[$field['slug']])?$meta[$field['slug']]:"");
                        $message = str_replace('['.$field['slug'].']',$value,$message);
                    }
                    else
                    {
                        $value = (isset($meta[$field['slug']])?$meta[$field['slug']]:"");
                        $option = (isset($field_meta['field_values'][$value])?$field_meta['field_values'][$value]:"");
                        $message = str_replace('['.$field['slug'].']',$option,$message);
                    }
                    break;
                case "checkbox":
                case "radio":
                case 'woo_product':
                case 'woo_category':
                case 'woo_tags':
                case 'woo_vendors':
                    $value = (isset($meta[$field['slug']])?$meta[$field['slug']]:"");
                    $option = (isset($field_meta['field_values'][$value])?$field_meta['field_values'][$value]:"");
                    $message = str_replace('['.$field['slug'].']',$option,$message);
                    break;
            }
         }
    }
    if(eh_get_url_by_shortcode('[wsdesk_satisfaction]') !== "")
    {
        if(!defined('WSDESK_SATISFACTION_URL_TEXT'))
        {
            $url_text = 'Give a Support Review';
        }
        else
        {
            $url_text = WSDESK_SATISFACTION_URL_TEXT;
        }
        $message = str_replace('[satisfaction_data]',"<a href='".eh_get_url_by_shortcode('[wsdesk_satisfaction]')."?id=".$ticket[0]['ticket_id']."&wsdesk_author=".$ticket[0]['ticket_email']."' targer='_blank' rel='nofollow'>".$url_text."</a>",$message);
    }
    foreach ($to_numbers as $number) {
        WSDesk_Sms_Addon_Class::wsdesk_send_sms($number, $message);
    }
}
function eh_get_url_by_shortcode($shortcode) {
    global $wpdb;

    $url = '';

    $sql = "SELECT ID
        FROM " . $wpdb->posts . "
        WHERE
            post_type = 'page'
            AND post_status='publish'
            AND post_content LIKE '%" . $shortcode . "%'";

    if ($id = $wpdb->get_var($sql)) {
        $url = get_permalink($id);
    }

    return $url;
}

function eh_get_clients() {
    global $wpdb;

    $sql = "SELECT ID
        FROM " . $wpdb->posts . "
        WHERE
            post_type = 'clients'
            AND post_status='publish'
            AND post_content LIKE '%" . $shortcode . "%'";

    if ($id = $wpdb->get_var($sql)) {
        $url = get_permalink($id);
    }

    return $url;
}

function eh_crm_get_clients() {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wasp_posts';

    $query = "SELECT * FROM $table WHERE `wasp_posts`.`post_type` = 'clients'";
    $data = $wpdb->get_results($query, ARRAY_A);
    if (!$data) {
        return array();
    }
    return $data;
}

function eh_crm_get_poweredby_scripts()
{
    if(!defined('WSDESK_POWERED_EMAIL'))
    {
        return' <br>
                <div class="powered_wsdesk"><span>Email is a service from '. get_bloginfo('name').'.</span><span> '.__('Powered by', 'wsdesk').' WSDesk</span></div>
                ';
    }
    else
    {
        return "";
    }
}

function eh_crm_write_log($body)
{
    $upload = wp_upload_dir();
    $fp = fopen($upload['path']."/wsdesk_import", "w+");
    fwrite($fp, date("M d, Y h:i:s A",time())." : ".$body);
    fclose($fp);
}

function eh_crm_validate_subject_block($subject)
{
    $block_filter = eh_crm_get_settingsmeta("0", "subject_block_filters");
    if(!$block_filter)
    {
        $block_filter = array();
    }
    foreach ($block_filter as $substr => $type) {
        if($type =='Beginning')
        {
            if(strpos($subject, $substr)===0)
                return false;
        }
        else if($type == 'Anywhere')
        {
            if(strpos($subject,$substr)!== FALSE)
                return false;
        }
    }
    return true;
}

function eh_crm_validate_email_block($email,$status)
{
    $block_filter = eh_crm_get_settingsmeta("0", "email_block_filters");
    if(!$block_filter)
    {
        $block_filter = array();
    }
    $keys = array_keys($block_filter);
    foreach ($keys as $block) 
    {
        if(is_array($email))
        {
            foreach ($email as $smail) {
                if(strpos($smail, $block) !== false)
                {
                    $stat = explode(',', $block_filter[$block]);
                    if(in_array($status, $stat))
                    {
                        return false;
                    }
                }
            }
        }
        else 
        {
            if(strpos($email, $block) !== false)
            {
                $stat = explode(',', $block_filter[$block]);
                if(in_array($status, $stat))
                {
                    return false;
                }
            }
        }
    }
    return true;
}

/**
 * Get Ticket details from ticket table.
 *
 */
function eh_crm_get_ticket_data($parent_id) {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';

    $query = "SELECT * FROM $table WHERE (ticket_parent = $parent_id OR ticket_id = $parent_id) AND ticket_trash = 0 AND ticket_category!='agent_note' AND ticket_category!='satisfaction_survey' ORDER BY ticket_id DESC";
    $data = $wpdb->get_results($query, ARRAY_A);
    if (!$data) {
        return array();
    }
    return $data;
}

/*
 * Get Ticket details from ticket atble including agent notes.
 *
*/
function eh_crm_get_ticket_data_with_note($parent_id) {
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';

    $query = "SELECT * FROM $table WHERE (ticket_parent = $parent_id OR ticket_id = $parent_id) AND ticket_trash = 0 AND ticket_category!='satisfaction_survey' ORDER BY ticket_id DESC";
    $data = $wpdb->get_results($query, ARRAY_A);
    if (!$data) {
        return array();
    }
    return $data;
}

/*
* Get ticket_content of the latest raiser_reply or agent_reply
*/
function eh_crm_get_ticket_latest_content($parent_id)
{
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';
    $query = "SELECT MAX(ticket_id) FROM $table WHERE (ticket_parent = $parent_id OR ticket_id = $parent_id) AND ticket_trash = 0 AND ticket_category!='agent_note' AND ticket_category!='satisfaction_survey' ORDER BY ticket_id DESC";
    $data = $wpdb->get_results($query, ARRAY_A);
    if (!$data) {
        return array();
    }
    $ticket_id = $data[0]['MAX(ticket_id)'];
    $data = eh_crm_get_ticket(array("ticket_id"=>$ticket_id),array("ticket_content"));
    return html_entity_decode(stripslashes($data[0]['ticket_content']));
}
function eh_crm_get_ticket_latest_notes($parent_id)
{
    ini_set('max_execution_time', 300);
    global $wpdb;
    $table = $wpdb->prefix . 'wsdesk_tickets';
    $query = "SELECT MAX(ticket_id) FROM $table WHERE (ticket_parent = $parent_id OR ticket_id = $parent_id) AND ticket_trash = 0 AND ticket_category!='satisfaction_survey' ORDER BY ticket_id DESC";
    $data = $wpdb->get_results($query, ARRAY_A);
    if (!$data) {
        return array();
    }
    $ticket_id = $data[0]['MAX(ticket_id)'];
    $data = eh_crm_get_ticket(array("ticket_id"=>$ticket_id),array("ticket_content"));
    return html_entity_decode(stripslashes($data[0]['ticket_content']));
}
/**
 * Get Ticket conversation history template.
 *
 */
function eh_crm_get_conversation_template($conversation_details) {
    $msg = '';
    if (!empty($conversation_details)) {
        $msg = '<div style="margin-top:25px;max-width: 920px;">';
    
        foreach ($conversation_details as $content) {

            $user = get_user_by('email', $content['ticket_email']);
            $name = '';
            if (!empty($user)) {
                $name = $user->display_name;
            }
            if($name === "")
            {
                $name = $content['ticket_email'];
            }
            $msg.= '<table cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding:15px 0;border-top:1px dotted #c5c5c5" width="100%"><table style="table-layout:fixed" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr> <td style="padding:0 15px 0 15px;width:40px" valign="top"> <img src="' . get_avatar_url($content['ticket_email']) . '" style="height:auto;line-height:100%;outline:none;text-decoration:none;border-radius:5px" width="40" height="40"> </td> <td style="padding:0;margin:0" width="100%" valign="top"> <p style="font-size:15px;line-height:18px;margin-bottom:0;margin-top:0;padding:0;color:#1b1d1e"> <strong>' . $name . '</strong> </p> <p style="font-size:13px;line-height:25px;margin-bottom:15px;margin-top:0;padding:0;color:#bbbbbb"> ' . eh_crm_get_formatted_date($content['ticket_date']) . ' </p> <p class="" style="color:#2b2e2f;font-size:14px;line-height:22px;margin:15px 0"> ' . stripslashes($content['ticket_content']) . ' </p> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table>';
        }
    
        $msg . '</div>';
    }
    return $msg;
}

/**
 * Get Ticket Template content.
 *
 * @param string $template_id Template ID that will be rendered
 * @param string $ticket_id Ticket ID which needs to be replaced
 */

function eh_crm_get_template_content($template,$ticket)
{
    $temp = eh_crm_get_settings(array('slug'=>$template));
    $avail_fields = eh_crm_get_settings(array("type" => "field"), array("slug", "title", "settings_id"));
    $tic = eh_crm_get_ticket(array('ticket_id'=>$ticket));
    $tic_meta = eh_crm_get_ticketmeta($ticket);
    $user = get_user_by('email', $tic[0]['ticket_email']);
    $name = '';
    if (!empty($user)) {
        $name = $user->display_name;
    }
    if($name === "")
    {
        $name = explode('@', $tic[0]['ticket_email']);
        $name = sanitize_user($name[0]);
    }
    $temp_meta = eh_crm_get_settingsmeta($temp[0]['settings_id']);
    $content = $temp_meta['template_content'];
    $content = str_replace('[id]',$ticket,$content);
    $content = str_replace('[name]',$name,$content);
    $selected_fields = eh_crm_get_settingsmeta(0, "selected_fields");
    foreach ($avail_fields as $field) {
        if($field['slug'] === 'google_captcha' || !in_array($field['slug'], $selected_fields))
        {
            continue;
        }
        if (strpos($content, '['.$field['slug'].']') !== false) {
            switch ($field['slug']) {
                case "request_email":
                    $content = str_replace('[request_email]',$tic[0]['ticket_email'],$content);
                    break;
                case "request_title":
                    $content = str_replace('[request_title]',$tic[0]['ticket_title'],$content);
                    break;
                case "request_description":
                    $content = str_replace('[request_description]',$tic[0]['ticket_content'],$content);
                    break;
            }
            $field_meta = eh_crm_get_settingsmeta($field['settings_id']);
            switch ($field_meta['field_type']) {
                case "file":
                    $file_value = (isset($tic_meta['ticket_attachment'])? $tic_meta['ticket_attachment']:array());
                    $file_data = '';
                    if(!empty($file_value))
                    {
                        foreach($file_value as $tic_attachemnt)
                        {
                            $file_data .= $tic_attachemnt.'<br />';
                        }
                    }
                    $content = str_replace('['.$field['slug'].']',$file_data,$content);
                    break;
                case "text":
                case "number":
                case "email":
                case "password":
                case 'textarea':
                case "phone":
                    $value = (isset($tic_meta[$field['slug']])?$tic_meta[$field['slug']]:"");
                    $content = str_replace('['.$field['slug'].']',$value,$content);
                    break;
                case "checkbox":
                case "radio":
                case "select":
                case 'woo_product':
                case 'woo_category':
                case 'woo_tags':
                case 'woo_vendors':
                    $value = (isset($tic_meta[$field['slug']])?$tic_meta[$field['slug']]:"");
                    $option = (isset($field_meta['field_values'][$value])?$field_meta['field_values'][$value]:"");
                    $content = str_replace('['.$field['slug'].']',$option,$content);
                    break;
            }
        }
    }
    return $content;
}

function eh_crm_db_collation($table_name)
{
    global $wpdb;
    $table_name = $wpdb->prefix.$table_name;
    $data = $wpdb->get_results("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '".$table_name."'");
    foreach ($data as $dataa) 
    {
        foreach ($dataa as $key =>$value) 
        {
            eh_crm_db_debug_error_log($key.' = '.$value);
        }
    }
}

function eh_crm_debug_error_log($reponse)
{
    $add_log = eh_crm_get_settingsmeta(0, "wsdesk_debug_status");
    if($add_log == 'enable')
    {
        $backtrace = debug_backtrace();
        error_log('['.gmdate("M d, Y h:i:s A").'] - '.'( '.$backtrace[1]['class'].'::'.$backtrace[1]['function'].' ) '.print_r($reponse,true));
    }
}

function eh_crm_db_debug_error_log($reponse)
{
    $add_log = eh_crm_get_settingsmeta(0, "wsdesk_debug_status");
    if($add_log == 'enable')
    {
        $backtrace = debug_backtrace();
        error_log('['.gmdate("M d, Y h:i:s A").'] - '.'( '.$backtrace[1]['function'].' ) '.print_r($reponse,true));
    }
}

function eh_crm_get_formatted_date($date)
{
    $timeformat = get_option('date_format').' '.get_option('time_format');
    $return = ((get_option('timezone_string')!=="")?local_date_i18n($timeformat, strtotime($date)):date_i18n($timeformat,strtotime("+".(get_option('gmt_offset')*60)." minutes", strtotime($date))));
    return $return;
}

function local_date_i18n($format, $timestamp) {
    $timezone_str = get_option('timezone_string') ?: 'UTC';
    $timezone = new \DateTimeZone($timezone_str);

    // The date in the local timezone.
    $date = new \DateTime(null, $timezone);
    $date->setTimestamp($timestamp);
    $date_str = $date->format('Y-m-d H:i:s');

    // Pretend the local date is UTC to get the timestamp
    // to pass to date_i18n().
    $utc_timezone = new \DateTimeZone('UTC');
    $utc_date = new \DateTime($date_str, $utc_timezone);
    $timestamp = $utc_date->getTimestamp();

    return date_i18n($format, $timestamp, true);
}

function eh_crm_pre_check_back_to_back($email,$to,$subject)
{
    $speaking = eh_crm_get_settingsmeta(0, "email_status_check");
    if(!$speaking)
    {
        $speaking = array();
    }
    if(!empty($speaking))
    {
        $count = 0;
        $subject= str_replace('Re: ', '', $subject);
        $subject= preg_replace("/Ticket\s*\[.*?\] : /", "", $subject,-1);
        foreach ($speaking as $speak) {
            $stamp = time() - $speak['stamp'];
            if($speak['from'] == $email && $speak['to'] == $to && $speak['subject'] == $subject && $stamp<600)
            {
                $count++;
            }
        }
        if($count >= 5)
        {
            return false;
        }
    }
    $dump = array(
        'from'      => $email,
        'to'        => $to,
        'subject'   => $subject,
        'stamp'     =>time()
    );
    array_push($speaking, $dump);
    eh_crm_update_settingsmeta(0, "email_status_check", $speaking);
    return true;
}
function eh_crm_filter_email_content($content)
{
    $tickets_display = eh_crm_get_settingsmeta('0', "tickets_display");
    if($tickets_display == 'html')
    {
        return $content;
    }
    $content = str_replace('<','&lt;', $content);
    $content = str_replace('>', '&gt;', $content);
    $content = str_replace('&lt;br/&gt;', '<br>', $content);
    $content = str_replace('&lt;ol&gt;', '<ol>', $content);
    $content = str_replace('&lt;/ol&gt;', '</ol>', $content);
    $content = str_replace('&lt;ul&gt;', '<ul>', $content);
    $content = str_replace('&lt;/ul&gt;', '</ul>', $content);
    $content = str_replace('&lt;li&gt;', '<li>', $content);
    $content = str_replace('&lt;/li&gt;', '</li>', $content);
    $my_file = 'filtered.txt';
    $handle = fopen($my_file, 'w') or die('Cannot open file: '.$my_file);
    $data = $content;
    fwrite($handle, $data);
    return $content;
}
function eh_crm_wpml_translations($string_value, $string_name, $string_title)
{
    $package = array(
        'kind' => 'WSDesk',
        'name' => 'wsdesk-support',
        'title' => 'WSDesk Support',
        'edit_link' => 'LINK TO EDIT THE FORM',
        'view_link' => 'LINK TO VIEW THE FORM'
    );
    $string_type = "LINE";
    do_action('wpml_register_string', $string_value, $string_name, $package, $string_title, $string_type);
    return apply_filters( 'wpml_translate_string', $string_value, $string_name, $package );
}
function eh_crm_collapse_ticket_content($content)
{
    if(substr_count($content, '</p>') >= substr_count($content, '<br>') )
    {
        $delimiter = '</p>';
    }
    else
    {
        $delimiter = '<br>';
    }
    $content_arr = explode($delimiter, $content);
    if(count($content_arr) <= 30)
        return $content;
    else
    {
        $main_content = array_slice($content_arr,0, 30);
        $hide_content = array_slice($content_arr, 30, count($content_arr)-1);
        $content = implode($delimiter, $main_content);
        $rand =  mt_rand();
        $content .= '<br><a href="#" class="content_more" id="'.$rand.'">'.__("Show More", "wschat").'</a>';
        $content .= '<a href="#" class="content_less" id="'.$rand.'">'.__("Show Less", "wschat").'</a>';
        $content .= '<div id="hide_content_'.$rand.'" style="display: none;">'.implode($delimiter, $hide_content).'</div>';
        return $content;

    }
}