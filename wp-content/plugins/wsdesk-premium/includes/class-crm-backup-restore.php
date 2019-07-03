<?php
if (!defined('ABSPATH')) {
    exit;
}
class EH_CRM_Backup_Restore {
    //functions to generate back up file
	function backup_data_xml($start,$end,$data)
    {
    	$json = array();
    	if(in_array('settings', $data))
    	{
    		$json['settings'] = $this->get_settings_data();
    	}
    	if (in_array('tickets', $data))
    	{
    		$json['tickets'] = $this->get_tickets_data($start, $end);
    	}
        header("Content-Disposition: attachment; filename=".time().'_wsdesk_backup.json');
        header("Content-Type: application/json; charset=UTF-8");
        print(json_encode($json));
    }
    function get_settings_data()
    {
    	global $wpdb;
    	$table = $wpdb->prefix . 'wsdesk_settings';
    	$query = "SELECT * FROM $table";
    	$settings_data = array();
    	$settings = $wpdb->get_results($query, ARRAY_A);
    	array_push($settings, array('settings_id' => 0));
    	foreach ($settings as $value) {
    		$settings_datum['data'] = $value;
    		$settings_datum['meta'] = $this->get_settingsmeta_data($value['settings_id']);
    		array_push($settings_data, $settings_datum);
    	}
    	return $settings_data;
    }
    function get_settingsmeta_data($settings_id)
    {
    	global $wpdb;
    	$table = $wpdb->prefix . 'wsdesk_settingsmeta';
    	$query = "SELECT  meta_value, meta_key FROM $table WHERE settings_id=$settings_id";
    	$settingsmeta = $wpdb->get_results($query, ARRAY_A);
    	return $settingsmeta;
    }
    function get_tickets_data($start, $end)
    {
    	global $wpdb;
    	$dates = $this->get_date_range($start, $end);
    	$table = $wpdb->prefix . 'wsdesk_tickets';
    	$tickets_data = array();
    	foreach ($dates as $date) {
    		$query = "SELECT * FROM $table WHERE ticket_date LIKE '%$date%' AND ticket_parent = 0";
    		$parent_tickets = $wpdb->get_results($query, ARRAY_A);
    		if(!empty($parent_tickets))
    		{
                foreach ($parent_tickets as $parent_ticket) {
                    $tickets_datum['parent_tickets'] = $parent_ticket;
                    $tickets_datum['parent_ticketsmeta'] = $this->get_ticketsmeta_data($parent_ticket['ticket_id']);
                    $tickets_datum['child_tickets'] = $this->get_child_ticket_data($parent_ticket['ticket_id']);
                    array_push($tickets_data, $tickets_datum);
                }
    		}
    	}
        return $tickets_data;
    }
    function get_ticketsmeta_data($ticket_id)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'wsdesk_ticketsmeta';
        $query = "SELECT  meta_value, meta_key FROM $table WHERE ticket_id=$ticket_id";
        $ticketsmeta = $wpdb->get_results($query, ARRAY_A);
        return $ticketsmeta;
    }
    function get_child_ticket_data($ticket_id)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'wsdesk_tickets';
        $query = "SELECT * FROM $table WHERE ticket_parent = $ticket_id";
        $child_tickets = $wpdb->get_results($query, ARRAY_A);
        foreach ($child_tickets as $key => $child_ticket) {
            $child_meta = $this->get_ticketsmeta_data($child_ticket['ticket_id']);
            $child_tickets[$key]['child_meta'] = $child_meta;
        }
        return $child_tickets;
    }
    function get_date_range($start, $end)
    {
    	$start = ($start!='')?strtotime($start) : 0;
    	$end = ($end!='')?strtotime($end) : time();
    	$dates = array();

    	while($start <= $end)
    	{
    		array_push($dates, date('M d, Y', $start));
    		$start += 86400;
    	}
    	return $dates;
    }

    //functions to perform restore
    function restore_data_xml($file)
    {
        $json = file_get_contents($file);
        $json = substr($json, 0, strlen($json)-1);
        $json = json_decode($json, true);
        if(isset($json['settings']))
            $this->restore_settings_data($json['settings']);
        if(isset($json['tickets']))
            $this->restore_tickets_data($json['tickets']);
    }
    function restore_settings_data($settings)
    {
        global $wpdb;
        $settings_table = $wpdb->prefix . 'wsdesk_settings';
        $settingsmeta_table = $wpdb->prefix . 'wsdesk_settingsmeta';
        $this->delete_existing_data('wsdesk_settings');
        $this->delete_existing_data('wsdesk_settingsmeta');
        foreach ($settings as $setting) {
            if($setting['data']['settings_id'])
                $this->insert_into_table($settings_table, $setting['data']);
            foreach ($setting['meta'] as $key => $value) {
                $value['settings_id'] = $setting['data']['settings_id'];
                $this->insert_into_table($settingsmeta_table, $value);
            }
        }
    }
    function insert_into_table($table, $data)
    {
        global $wpdb;
        $column_names = array_keys($data);
        $column_names = "(".implode(", ", $column_names).")";
        foreach ($data as $key => $value) {
            $data[$key] = str_replace("'", "\'", $value);
        }
        $column_values = "('".implode("', '", $data)."')";
        $query = "INSERT INTO $table $column_names VALUES $column_values";
        $wpdb->get_results($query, ARRAY_A);
    }
    function restore_tickets_data($tickets)
    {
        global $wpdb;
        $tickets_table = $wpdb->prefix . 'wsdesk_tickets';
        $ticketsmeta_table = $wpdb->prefix . 'wsdesk_ticketsmeta';
        $this->delete_existing_data('wsdesk_tickets');
        $this->delete_existing_data('wsdesk_ticketsmeta');
        foreach ($tickets as $ticket) {
            $this->insert_into_table($tickets_table, $ticket['parent_tickets']);
            foreach ($ticket['parent_ticketsmeta'] as $parent_meta) {
                $parent_meta['ticket_id'] = $ticket['parent_tickets']['ticket_id'];
                $this->insert_into_table($ticketsmeta_table, $parent_meta);
            }
            foreach ($ticket['child_tickets'] as $child_ticket) {
                foreach ($child_ticket['child_meta'] as $child_meta) {
                    $child_meta['ticket_id'] = $child_ticket['ticket_id'];
                    $this->insert_into_table($ticketsmeta_table, $child_meta);
                }
                unset($child_ticket['child_meta']);
                $this->insert_into_table($tickets_table, $child_ticket);
            }
        }
    }
    function delete_existing_data($table_name)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $table_name;
        $query = "DELETE FROM $table_name";
        $wpdb->get_results($query, ARRAY_A);
    }
}