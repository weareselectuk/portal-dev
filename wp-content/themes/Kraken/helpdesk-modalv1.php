<?php
/*
$ticketData = eh_crm_get_ticket_data($value->ticket_id);
$meta = eh_crm_get_ticketmeta($value->ticket_id);
$ticketData2 = eh_crm_get_ticket_data_with_note(2);
$ticket_tags = array();
$avail_tags_wf = eh_crm_get_settings(array("type" => "tag"), array("slug", "title", "settings_id"));*/
$ticket = $value->ticket_id;
$current = eh_crm_get_ticket(array("ticket_id"=>$value->ticket_id));
$current_meta = eh_crm_get_ticketmeta($value->ticket_id);
$avail_fields = eh_crm_get_settings(array("type" => "field"), array("slug", "title", "settings_id"));
$selected_fields = eh_crm_get_settingsmeta(0, 'selected_fields');
$avail_tags = eh_crm_get_settings(array("type" => "tag"),array("slug","title","settings_id"));
$avail_labels = eh_crm_get_settings(array("type" => "label"), array("slug", "title", "settings_id"));
$raiser_name ='';
$raiser_email = $current[0]['ticket_email'];
if($current[0]['ticket_author']!=0)
{
    $raiser_obj = new WP_User($current[0]['ticket_author']);
    $raiser_name = $raiser_obj->display_name;
}
else
{
    $raiser_name = "Guest";
}
$ticket_label = "";
$eye_color = "";
for($j=0;$j<count($avail_labels);$j++)
{
    if($avail_labels[$j]['slug'] == $current_meta['ticket_label'])
    {
        $ticket_label = $avail_labels[$j]['title'];
    }
    if($avail_labels[$j]['slug'] == $current_meta['ticket_label'])
    {
        $eye_color = eh_crm_get_settingsmeta($avail_labels[$j]['settings_id'], "label_color");
    }
}
$logged_user = wp_get_current_user();
$logged_user_caps = array_keys($logged_user->caps);
$avail_caps = array("reply_tickets","delete_tickets","manage_tickets","manage_templates");
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
$assignee = (isset($current_meta['ticket_assignee'])?$current_meta['ticket_assignee']:array());
$assignee_name = array();
if($assignee!=="")
{
    foreach ($users as $key => $value) {
        foreach ($value as $id => $name) {
            if (in_array($id, $assignee)) {
                array_push($assignee_name, $name);
            }
        }                                    
    }
}
$cc = (isset($current_meta['ticket_cc'])?$current_meta['ticket_cc']:array());
$cc_selected = array();
if(!empty($cc))
{
    foreach ($cc as $key => $value) {
        array_push($cc_selected, $value);
    }
}
$bcc_selected = array();
$bcc = (isset($current_meta['ticket_bcc'])?$current_meta['ticket_bcc']:array());
if(!empty($bcc))
{
    foreach ($bcc as $key => $value) {
        array_push($bcc_selected, $value);
    }
}
$ticket_tags = (isset($current_meta['ticket_tags'])?$current_meta['ticket_tags']:array());
$tags_selected = array();
if($ticket_tags!=="" && !empty($avail_tags))
{
    for($i=0;$i<count($avail_tags);$i++)
    {
        if(in_array($avail_tags[$i]['slug'], $ticket_tags))
        {
            array_push($tags_selected, $avail_tags[$i]['title']);
        }

    }
}
?>

<div class="modal fade" id="ticket_<?php echo $ticket;?>" tabindex="-1" role="dialog" aria-labelledby="helpdeskticket" aria-hidden="true">
<div class="tab-content">
<div class="helpdesk_container" style="background-color:#F7F7F7;height:100%;overflow:hidden;">
                  <div class="modal-dialog" role="document" style="height:98%;">
                    <div class="modal-content" style="background-color:white;width:140%;margin-left:-20%;height:98%;">
                      <div class="modal-header" style="border-bottom: 1px solid #99999F;padding-bottom: 5px;margin-bottom: 5px;">
<div class="helpdesk_top_selectors">

<div class="ticket_status" style="background-color:<?php echo $eye_color;?>; border:1px solid #3773B9;width:10%; height:36px;margin-right:15px;float:left;color:white;text-align:center;padding-top:8px;">
<?php echo $ticket_label; ?>
                </div>
                <a data-title="Select Client" href="#" id="helpdesk-fieldx"
                      name="field_WC34" data-type="select" data-value="<?php echo $value->clientid;?>" data-source="[{value:'Low',text:'Low'},{value:'Medium',text:'Medium'},{value:'High',text:'High'}]"
                      data-pk="<?php echo $ticket;?>" class="editable editable-click"><?php echo get_the_title($value->clientid);?></a>
<select class="ticket_site" style="background-color:#76D5E3;border:1px solid #76D5E3;width:15%;min-width:100px;margin-right:15px;float:left;">Assigned to the Site<span><option value="<?php echo $value->siteid;?>" selected="selected"><?php echo get_the_title($value->siteid);?></option>
<option value="34" selected="selected">was_swindon</option></span></select>
<select class="ticket_user" style="background-color:#F23A30;border:1px solid #F23A30;width:15%;min-width:100px;margin-right:15px;float:left;">Assigned to User<span><option value="<?php echo $value->userid;?>" selected="selected"><?php $assigned_user = get_userdata($value->userid); echo $assigned_user->display_name;?></option></span></select>
<select class="ticket_asset" style="background-color:#268EEE;border:1px solid #268EEE;width:15%;min-width:100px;margin-right:30px;float:left;">Assigned to Asset<span><option value="<?php echo $value->assetid;?>" selected="selected"><?php echo $value->assetid;?></option></span></select>
<div class="ticket_ID" style="border:1px solid #F51F1F;width:8%;float:left;height:36px;"><div class="id_title" style="color:#F51F1F;width:25%;float:left;height:36px;">ID</div><div class="id_number" style="background-color:#F51F1F;color:white;width:75%;float:left;height:36px;text-align:center;padding-top:8px;"><?php echo $ticket;?></div></div>
<div class="right_menu_items" style="float:right;">
    <div class="user_details"></div>
    <button class="btn btn-primary btn-icon editable-submit" type="submit" id="helpdesk-fieldx" onclick="eh_crm_ticket_single_save_props()">
                                    <span class="glyphicon glyphicon-saved"></span> Save Properties
                                  </button>
    <button type="button" data-dismiss="modal" class="btn btn-secondary" >X</button>
</div>


</div>
</div>

<div class="body_container" style="height:93%;overflow-y:auto;">
<div class="left_column_container" style="width:80%;float:left;">
    <div class="hd_ticket_container" style="margin-top:45px;margin-left:35px;">
    <div class="hd_ticket_title" style="font-weight:bold;text-transform:capitalize;font-size:30px; color:#99999F;"><?php echo $current[0]['ticket_title'];
					 ?></div>
        <div class="hd_ticket_subtitle" style="color:#99999F;"><?php echo $current[0]['ticket_content']
					 ?></div>
</div>
<?php /*
<div class="task_container" style="height:250px;">
    <div class="task_title" style="color:#F1852E; margin-left:35px;margin-top:30px;font-size:25px;">Task</div><div class="task_tasklist"><ul><li></li><li><?php echo print_r ($current_meta) ?></li></ul></div> </div>
*/ ?>
    <div class="attachments_container"> <div class="attachments_title" style="color:#F1852E; margin-left:35px;margin-top:30px;font-size:25px;">Attachments</div>
</div>
</div>
<div class="helpdesk_sidebar" style="float:left;width:15%;background-color: #F7F7F7;height: 60%;margin-top:35px;border: solid .5px #CCCCCC;">
<div class="assigned_agent_container" style="border: solid .5px #CCCCCC;height:10%;"><div class="ticket_assigned_agent" style="left: 20%;top:5%;position: relative;font-weight: bold;font-size: 17px;color: #A8A8AD;">
Assigned to<br><span><?php if(!empty($assignee_name)){echo implode(', ', $assignee_name);}else{echo '-';}?></span>
</div></div>
<div class="due_date_container" style="border: solid .5px #CCCCCC;height:10%;"><div class="due_date" style="left: 20%;top:20%;position: relative;font-weight: bold;font-size: 17px;color: #A8A8AD;"><i style="font-size: 30px !important;margin-left: -20px;margin-right: 20px;
}" class="fa fa-calendar"></i> Due Date <br> <?php echo $current_meta['field_KZ90']?>
</div></div>
<div class="ticket_status_container" style="border: solid .5px #CCCCCC;height:13%;display:flow-root;"><div class="ticket_status_sidebar" style="left: 20%;position: relative;font-weight: bold;font-size: 17px;color: #A8A8AD;">Status 
</div><div class="ticket_status" style="border-radius:3px;background-color: <?php echo $eye_color;?>; height: 36px; margin-left: 42px;float: left;color: white;text-align: center;padding-top: 8px; width: 45%;">
<?php echo $ticket_label; ?> </div></div>
<div class="ticket_priority_container" style="border: solid .5px #CCCCCC;height:13%;display:flow-root;"><div class="ticket_priority_sidebar" style="left: 20%;position: relative;font-weight: bold;font-size: 17px;color: #A8A8AD; width: 45%;">Priority
</div><div class="priority_status" style="border-radius:3px;background-color:#5F6DD9; height: 36px; margin-left: 42px;float: left;color: white;text-align: center;padding-top: 8px; width: 45%;display:flow-root;"><a id="helpdesk-fieldx" data-title="Select Priority" href="#" 
                      name="field_HN27" data-type="select" data-value="<?php $current_meta['field_HN27']?>" data-source="[{value:'Low',text:'Low'},{value:'Medium',text:'Medium'},{value:'High',text:'High'}]"
                      data-pk="<?php echo $ticket;?>" class="editable editable-click"><?php echo $current_meta['field_HN27']?></a></div></div>
<div class="ticket_tags_container" style="border: solid .5px #CCCCCC;height:13%;display:flow-root;"><div class="ticket_tags_sidebar" style="left: 20%;position: relative;font-weight: bold;font-size: 17px;color: #A8A8AD;">Tag
</div><div class="priority_status" style="border-radius:3px;background-color: #F5023A; height: 36px; margin-left: 42px;float: left;color: white;text-align: center;padding-top: 8px;width: 45%;"><?php  
$tags = unserialize($value->ticket_tgs);
$tag = $wpdb->get_var( "SELECT {$wpdb->prefix}wsdesk_settings.title FROM {$wpdb->prefix}wsdesk_settings WHERE slug = '{$tags[0]}'" ); 
     echo ($meta['ticket_tags']);?></div></div>
<div class="ticket_watching_container" style="border: solid .5px #CCCCCC;height:15%;display:flow-root;"><div class="ticket_watching_sidebar" style="left: 20%;position: relative;font-weight: bold;font-size: 17px;color: #A8A8AD;">Watching
</div><div class="watching_status_1" style="background-color: #1FA3F5; height: 36px; margin-left: 42px;float: left;color: white;text-align: center;padding-top: 8px;width:17%">AW</div>
<div class="watching_status_2" style="background-color: #1FA3F5; height: 36px; margin-left: 10px;float: left;color: white;text-align: center;padding-top: 8px;width:17%">LT</div>
<div class="watching_status_3" style="background-color: #1FA3F5; height: 36px; margin-left: 10px;float: left;color: white;text-align: center;padding-top: 8px;width:17%">ET</div></div>
</div>
<div class="conversation_container" style="width:45%;float:left;margin-left:35px;">
<?php
$current_ticket = $ticket;
$convostr = "
SELECT *
FROM {$wpdb->prefix}wsdesk_tickets 
WHERE {$wpdb->prefix}wsdesk_tickets.ticket_parent = '{$current_ticket}'
ORDER BY {$wpdb->prefix}wsdesk_tickets.ticket_updated DESC
";
$conversations = $wpdb->get_results($convostr, OBJECT);




if ($conversations) : ?>
<div class="conversation_title" style="color:#F1852E;font-size:20px;">Conversation <a data-toggle="modal" data-target="#add_convo" style="color:#A5A8AC">
						<i class="fa fa-plus" style="color:#A5A8AC"></i>
					</a></div>
<?php foreach ($conversations as $key2 => $value2) {

$current_user = get_userdata($value2->ticket_author);
					 ?>
<div class="conversation_column <?php echo $value2->ticket_category;?>" style="width:88%;margin-top:13px;">
<div class="ticket_container <?php echo $value2->ticket_category;?>" style="background-color:#F2F2F2;">
        
    
    <div class="ticket_content <?php echo $value2->ticket_category;?>" style="font-size:14px; color:#99999F; margin-left: 0px; padding-top: 9px; background-color: #F2F2F2;"><?php echo $value2->ticket_content;?></div>
    
    <div class="bottom_container <?php echo $value2->ticket_category;?>" style="color: white; margin-bottom: 20px;background-color: #A5A8AC;margin-top: -2px;border-radius: 0px 0px 5px 5px;height: 20px;z-index: 1000;position: relative;left: 2px;margin-left: -2px;width:100%">
      <div class="hd_ticket_date" style="float:left;margin-right:20px;"><?php echo $value2->ticket_date;?> |</div><div class="hd_ticket_client" style="float:left;margin-right:20px;"> <?php echo $value2->ticket_category;?></div><div class="right_bottom" style="float:right;"><div class="hd_ticket_requester" style="float:left;margin-right:20px;">By: <?php echo $current_user->display_name?></div></div></div>
      </div>
      </div>
        <?php }; ?>
        <?php
  
  else :
  
    echo '<p>Client Has No Notes</p>'; ?>

    <?php endif;?>



</div>

<div class="asset_diary_container" style="width:45%;float:left;"> 
<div class="title_asset_diary" style="color:#F1852E;font-size:20px; float:left;">Asset Diary <?php echo $value->assetid;?>  <a data-toggle="modal" data-target="#diary_event" style="color:#A5A8AC">
						<i class="fa fa-plus" style="color:#A5A8AC"></i>
					</a></div>
<div class="asset_modals" style="float:left;margin-left:50px;"><a href="#assetstatus_<?php echo $value->assetid;?>" data-toggle="modal" data-target="#assetstatus2_<?php echo $value->assetid;?>"> <span class="fa fa-check-circle fa-lg " style="color:#50AE54" title="Asset Status"></span></a>
                     <a href="#assetprolicense_<?php echo $value->assetid;?>" data-toggle="modal" data-target="#assetprolicense2_<?php echo $value->assetid;?>"><span class="fab fa-product-hunt fa-lg " title="Guru License"></span></a>
                     <a href="#assetbackup_<?php echo $value->assetid;?>" data-toggle="modal" data-target="#assetbackup2_<?php echo $value->assetid;?>"><span class="fas fa-database fa-lg " title="Backup"></span></a>
                     <a href="#assetpatchmanagement_<?php echo $value->assetid;?>" data-toggle="modal" data-target="#assetpatchmanagement2_<?php echo $value->assetid;?>"> <span class="fas fa-tasks fa-lg " title="Patch Management"></span></a>
                     <a href="#assetlogins_<?php echo $value->assetid;?>" data-toggle="modal" data-target="#assetlogins2_<?php echo $value->assetid;?>"><span class="fas fa-sign-in-alt fa-lg " title="Asset Logins"></span></a>
                     <a href="#assetex05_<?php echo $value->assetid;?>" data-toggle="modal" data-target="#assetex052_<?php echo $value->assetid;?>"> <span class="fas fa-lock fa-lg false" title="Encryption"></span></a>
                     <a href="#assetsecurity_<?php echo $value->assetid;?>" data-toggle="modal" data-target="#assetsecurity2_<?php echo $value->assetid;?>"> <span class="fas fa-key fa-lg " title="Security Manager"></span></a>
                     <a href="#assetspecs_<?php echo $value->assetid;?>" data-toggle="modal" data-target="#assetspecs2_<?php echo $value->assetid;?>"><span class="fas fa-glasses fa-lg " title="Specifications"></span></a>
                     <a href="#assetwarranty_<?php echo $value->assetid;?>" data-toggle="modal" data-target="#assetwarranty2_<?php echo $value->assetid;?>"><span class="fas fa-pound-sign fa-lg " title="Purchasing &amp; Warranty Information"></span></a>                     
                    </div>
                    <div class="modalsloader"><?php
                     include get_template_directory() . '/assets-modal2.php'; ?></div> 
                    <?php

// get all associated services associated with this client

 $args = array(
        'post_type' => 'asset_diary_entries',
        'posts_per_page' => 999,
        'orderby' => 'title',
        'order' => 'ASC',
        'meta_query' => array(
          array(
            'key'     => 'asset_id',
            'value'   => $value->assetid,
            'compare' => '=',
    ),
  )
);

$the_query = new WP_Query( $args );

if ($the_query->have_posts()) :  ?>
   
                    <div class="title_asset_diary" style="color:#F1852E;font-size:20px;float:left;margin-left:20px;"><?php $meta_key = 'netbios_name'; $id = $value->assetid;?><?php echo get_post_meta( $id, $meta_key, true ); $id = $meta_key = '';?></div>
                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                    <div class="ticket_container" style="height:105px;border-radius:5px;margin:25px;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);background-color: #F2F2F2;width: 100%;left: -24px;position: relative;margin-bottom: 0px;">

<div class="ticket_top_container" style="background-color:#F2F2F2;">
        <div class="ticket_title" style="font-size:18px; color:#7B7C7E;font-weight:bold;margin-left:15px;margin-top:41px;border-bottom: 1px solid #99999F; margin-right: 19px;"><?php echo get_the_title() ?></div>
    </div>
    <div class="ticket_content" style="font-size:14px; color:#99999F;margin-left:15px;padding-top:9px;"><?php echo get_the_content() ?></div>
    </div>
    <div class="bottom_container" style="color: white;background-color: #A5A8AC;margin-top: -2px;border-radius: 0px 0px 5px 5px;height: 20px;z-index: 1000;position: relative;left: 2px;margin-left: -2px;">
        <div class="hd_ticket_id" style="float:left;margin-right:20px;">0013 |</div><div class="hd_ticket_date" style="float:left;margin-right:20px;">18/09/2018 |</div><div class="hd_ticket_time" style="float:left;margin-right:20px;">13:25 |</div><div class="hd_ticket_client" style="float:left;margin-right:20px;"> We Are Select</div><div class="right_bottom" style="float:right;"><div class="hd_ticket_engineer" style="float:left;margin-right:20px;">Engineer: Aaron Williams</div><div class="hd_ticket_requester" style="float:left;margin-right:20px;">Requester: Mike Smith</div></div></div>

<?php endwhile; ?>
<?php endif; ?>
    </div>


</div>
</div>
</div>
</div>
</div>
</div>