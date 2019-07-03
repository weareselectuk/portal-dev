<?php
if (!defined('ABSPATH')) {
    exit;
}
ob_start();
$selected = eh_crm_get_settingsmeta("0", "selected_fields");
if(empty($selected))
{
    $selected = array('request_email','request_title','request_description');
    
    eh_crm_update_settingsmeta("0", "selected_fields", array_values($selected));
}

$key = array_search("request_description", $selected);
unset($selected[$key]);
$key = array_search("request_title", $selected);
unset($selected[$key]);
$key = array_search("request_email", $selected);
unset($selected[$key]);	
$default = array('id', 'requestor', 'subject', 'requested', 'assignee', 'feedback');
$all_ticket_page_columns = eh_crm_get_settingsmeta("0", "all_ticket_page_columns");
if($all_ticket_page_columns === false)
{
	$all_ticket_page_columns = $default;
	eh_crm_update_settingsmeta("0", "all_ticket_page_columns", $all_ticket_page_columns);
}
foreach ($default as $value) {
	if(array_search($value, $all_ticket_page_columns) === false)
	{
		array_push($selected, $value);
	}
}
?>
<div class="crm-form-element">
    <div class="col-md-12">
        <div style="vertical-align: middle">
            <label for="ticket_fields" style="padding-right:1em !important;"><?php _e('Ticket Page','wsdesk'); ?></label>
        </div>
        <div class="panel panel-default crm-panel" style="margin-top: 15px !important;margin-bottom: 0px !important;">
            <div class="panel-body" style="padding: 5px !important;">
                <div class="col-sm-6" style="padding-right: 5px !important;padding-left: 5px !important;">
                    <span class="col-md-12" style="text-align: center;padding: 5px 0px;"><?php _e('Inactive Columns','wsdesk'); ?></span><br>
                    <ul class="list-group">
                    <?php
                    if(!array_diff($selected, $all_ticket_page_columns))
                    {
                        echo '<li class="list-group-item list-group-item-info">'.__('No inactive column','wsdesk').'</li>';
                    }
                    else
                    {
                    	$all_ticket_page_columns_deactivated = array_diff($selected, $all_ticket_page_columns);
                        foreach($all_ticket_page_columns_deactivated as $all_ticket_page_column)
                        {
                        	switch ($all_ticket_page_column) {
	                        	case 'id':
	            				case 'requestor':
	            				case 'subject':
	            				case 'requested':
	            				case 'assignee':
	            				case 'feedback':
	            					echo '<li class="list-group-item list-group-item-info" id="'.$all_ticket_page_column.'"> '.ucfirst($all_ticket_page_column).'<span class="pull-right"><span style="margin-right:5px; cursor:pointer; text-decoration:underline" class="ticket_page_column_activate" id="'.$all_ticket_page_column.'"><span class="glyphicon glyphicon-ok-circle" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Activate','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;"></span></span></li>';
	            					break;
            					default:
	                        		$settings_id = eh_crm_get_settings(array('slug' => $all_ticket_page_column));
	            					echo '<li class="list-group-item list-group-item-info" id="'.$all_ticket_page_column.'"> '.$settings_id[0]['title'].'<span class="pull-right"><span style="margin-right:5px; cursor:pointer; text-decoration:underline" class="ticket_page_column_activate" id="'.$all_ticket_page_column.'"><span class="glyphicon glyphicon-ok-circle" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Activate','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;"></span></span></li>';
	                            	
                            }
                        }
                    }
                    ?>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <span class="col-md-12" style="text-align: center;padding: 5px 0px;"><?php _e('Active Columns','wsdesk'); ?></span><br>
                    <ul class="list-group list-group-sortable-connected list-group-page-data list-border-settings" ondragend="drag_page_column(event)">
                    <?php
                    	if(empty($all_ticket_page_columns))
                    	{
                    		echo '<li class="list-group-item list-group-item-info">'.__('No active column','wsdesk').'</li>';
                    	}
                    	else{
                    		foreach ($all_ticket_page_columns as $all_ticket_page_column) {
                    			switch ($all_ticket_page_column) {
                    				case 'id':
                    				case 'requestor':
                    				case 'subject':
                    				case 'requested':
                    				case 'assignee':
                    				case 'feedback':
                    					echo '<li class="list-group-item list-group-item-success ticket_page_column_list" id="'.$all_ticket_page_column.'">
                    							<span class="dashicons dashicons-menu" style="cursor:move;margin-right:5px;"></span> '.ucfirst($all_ticket_page_column).'
                    							<span class="pull-right">
                    							<span style="margin-right:5px; cursor:pointer; text-decoration:underline" class="ticket_page_column_deactivate" id="'.$all_ticket_page_column.'">
                    							<span class="glyphicon glyphicon-remove-circle" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Deactivate','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;">
                                                    </span>
                                                    </span>
                                                    </span>
                                                    </li>';
                    					break;
                    				default:
                    					$settings_id = eh_crm_get_settings(array('slug' => $all_ticket_page_column));
                    					echo '<li class="list-group-item list-group-item-success ticket_page_column_list" id="'.$all_ticket_page_column.'">
                    							<span class="dashicons dashicons-menu" style="cursor:move;margin-right:5px;"></span> '.$settings_id[0]['title'].'
                    							<span class="pull-right">
                    							<span style="margin-right:5px; cursor:pointer; text-decoration:underline" class="ticket_page_column_deactivate" id="'.$all_ticket_page_column.'">
                    							<span class="glyphicon glyphicon-remove-circle" data-toggle="wsdesk_tooltip" data-container="body" title="'.__('Deactivate','wsdesk').'" style="margin-right:5px;cursor:pointer;font-size: large;">
                                                </span>
                                                </span>
                                                </span>
                                                </li>';
                    			}
                    		}
                    	}
                    ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
return ob_get_clean();