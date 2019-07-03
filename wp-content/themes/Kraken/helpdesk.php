<?php /*Template Name: HelpDesk*/ get_header(); ?>
<script type="text/javascript" src="http://v2.weareselect.uk/wp-content/plugins/wsdesk-premium/assets/js/bootstrap.js?ver=5.0.3"></script>
<script type="text/javascript" src="http://v2.weareselect.uk/wp-content/plugins/wsdesk-premium/assets/js/crm_tickets.js?ver=5.0.3"></script>
<script type="text/javascript" src="http://v2.weareselect.uk/wp-content/plugins/wsdesk-premium/assets/js/dialog.js?ver=5.0.3"></script>
<script type="text/javascript" src="http://v2.weareselect.uk/wp-content/plugins/wsdesk-premium/assets/js/quill.min.js?ver=5.0.3"></script>
<script type="text/javascript" src="http://v2.weareselect.uk/wp-content/plugins/wsdesk-premium/assets/js/select2.js?ver=5.0.3"></script>
<script type="text/javascript" src="http://v2.weareselect.uk/wp-content/plugins/wsdesk-premium/assets/js/wsdesk-cookie.js?ver=5.0.3"></script>
<?php
$default_deep_link = eh_crm_get_settingsmeta('0', "default_deep_link");
if($default_deep_link && !isset($_GET['view']) && !isset($_GET['order']))
{
    echo "<script>window.history.pushState('Tickets', 'Title', wsdesk_data.ticket_admin_url+'&'+'".$default_deep_link."')</script>";
}
echo '<div class="wsdesk_wrapper">';
$plugin_name = 'wsdesk';
$status = get_option($plugin_name . '_activation_status');
if($status=="inactive" || empty($status))
{
    ?>
    <div class="row" id="alert_for_activation">
        <div class="col-md-12">
            <div class="alert alert-danger aw_wsdesk_activate_alert" role="alert">
                <?php _e('Activate your WSDesk. Check','wsdesk');?> <a href="https://elextensions.com/my-account/my-api-keys/" style="text-decoration: underline !important;" target="_blank" class="alert-link"><?php _e('My Account','wsdesk');?></a> <?php _e('for API Keys. If knew the API Key already please enter in','wsdesk');?> <a href="<?php echo admin_url("admin.php?page=wsdesk_settings");?>" style="text-decoration: underline !important;" target="_blank" class="alert-link"><?php _e('Settings','wsdesk');?></a> <?php _e('Page','wsdesk');?>
            </div>
        </div>
    </div>
<?php
}
$tab_head = "";
$tab_content = "";
$t_id = (isset($_GET['tid'])?$_GET['tid']:FALSE);
if($t_id)
{
    $data = eh_crm_get_ticket(array("ticket_id"=>$t_id,"ticket_parent"=>0));
    if($data)
    {
        $all_section_ids = eh_crm_get_ticket_value_count("ticket_parent",0,false,"","","ticket_updated","DESC","",0);
        $pagination_ids = array();
        foreach ($all_section_ids as $tic) {
            array_push($pagination_ids,$tic['ticket_id']);
        }
        $tab_head = '<li role="presentation" class="active visible_tab" id="tab_' . $t_id . '" style="min-width:200px;">'. CRM_Ajax::eh_crm_ticket_single_view_gen_head($t_id) .'</li>';
        $tab_content = '<div class="tab-pane new-style-tab-pane active direct_load_tid" id="tab_content_' . $t_id . '">'. CRM_Ajax::eh_crm_ticket_single_view_gen($t_id,$pagination_ids) .'</div>';
    }
    else
    {
        ?>
        <div class="row" id="alert_for_activation">
            <div class="col-md-12">
                <div class="alert alert-danger aw_wsdesk_activate_alert" role="alert">
                    <?php _e('Invalid Ticket Number','wsdesk');?> [ <b>#<?php echo $t_id;?></b> ]
                </div>
            </div>
        </div>
        <?php
    }
}
?>
<div class="container wrapper" id="tickets_page_view">
    <div class="row">
        <div class="col-md-12">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading col-md-12">
                    <ul class="nav nav-tabs col-md-11 elaborate" role="tablist" style="margin-left: 0em;">
                        <li class="<?php echo ($tab_head === "")?"active":""; ?> all_tickets" role="presentation">
                            <a onclick="setURLFunc('tickets')" href="#all_tickets_tab" aria-controls="all" style="text-align: center;padding: 13px 15px;margin-right:0px !important;" data-toggle="tab" class="tab_a">
                                <?php _e('All Tickets','wsdesk');?>
                            </a>
                        </li>
                        <?php echo $tab_head; ?>
                        <li role="presentation" class="dropdown"> 
                            <a href="#" id="myTabDrop1" class="dropdown-toggle tab_a" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="true" style="text-align: center;padding: 13px 15px;margin-right:0px !important;">
                                <span class="caret"></span> <?php _e('More','wsdesk');?></a>
                            <ul class="dropdown-menu collapse_ul" aria-labelledby="myTabDrop1" id="myTabDrop1-contents"style="overflow-x: hidden">
                            </ul>
                        </li>
                    </ul>
                    <div class="col-md-1 nav-tabs">
                        <div class="pull-right side_bar">
                            <a href="#" class="add-ticket tab_a" style="text-align: center;" data-placement="bottom" data-toggle="wsdesk_tooltip" title="<?php _e('New Ticket','wsdesk');?>" data-container="body">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </div>
                        <div class="pull-right">
                            <div class="input-group stylish-input-group" style="margin: 3px 5px;">
                                <input type="text" class="form-control" id="search_ticket_input"  placeholder="Search" data-placement="bottom" data-toggle="wsdesk_tooltip" title="<?php _e('Search Ticket','wsdesk');?>" data-container="body">
                                <span class="glyphicon glyphicon-search clickable form-control-feedback" id="search_ticket_icon"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="alert alert-success" style="z-index: 1100;display: none;" role="alert">
                            <div id="success_alert_text"></div>
                        </div>
                        <div class="alert alert-warning" style="z-index: 1100;display: none;" role="alert">
                            <div id="warning_alert_text"></div>
                        </div>
                        <div class="tab-pane <?php echo ($tab_content === "")?"active":""; ?>" id="all_tickets_tab">
                            <?php echo include(EH_CRM_MAIN_VIEWS."tickets/crm_tickets_all.php"); ?>
                        </div>
                        <?php echo $tab_content; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>