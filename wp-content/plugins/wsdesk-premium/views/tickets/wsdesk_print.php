<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WSDesk_Print {
    public $ticket_id;
    public function __construct() {
        if (current_user_can('activate_plugins') || current_user_can('crm_role')) {
            add_action('admin_menu', array($this, 'wsdesk_print_admin_menus'),100);
            add_action('admin_init', array($this, 'wsdesk_print_setup'));
        }
    }

    public function wsdesk_print_admin_menus() {
        if(isset($_GET['ticket']) && isset($_GET['master']))
        {
            $this->ticket_id = $_GET['ticket'];
            $current = eh_crm_get_ticket(array("ticket_id"=>$this->ticket_id,"ticket_parent"=>0));
            if($current && md5($current[0]['ticket_email']) == $_GET['master'])
            {
                add_dashboard_page('', '', 'read', 'wsdesk_print', '');
            }
        }
    }

    public function wsdesk_print_setup() {
        if (empty($_GET['page']) || 'wsdesk_print' !== $_GET['page']) {
            return;
        }
        wp_enqueue_style('wp-admin');
        wp_enqueue_style('jquery');
        ob_start();
        $this->print_header();
        $this->print_content();
        $this->print_footer();
        exit;
    }
    public function print_header() {
        ?>
        <!DOCTYPE html>
        <html <?php language_attributes(); ?>>
        <head>
            <meta name="viewport" content="width=device-width" />
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title><?php esc_html_e( 'WSDesk &rsaquo; Print #'.$this->ticket_id, 'wsdesk' ); ?></title>
            <link rel="stylesheet" id="ticket-css" href="<?php echo EH_CRM_MAIN_CSS . "crm_tickets.css"?>" type="text/css" media="all">
            <link rel="stylesheet" id="new-ticket-css" href="<?php echo EH_CRM_MAIN_CSS . "new-style.css"?>" type="text/css" media="all">
            <link rel="stylesheet" id="bootstrap-css" href="<?php echo EH_CRM_MAIN_CSS . "bootstrap.css";?>" type="text/css" media="all">
            <link rel="stylesheet" id="boot-css" href="<?php echo EH_CRM_MAIN_CSS . "boot.css";?>" type="text/css" media="all">
            <link rel="stylesheet" id="print-css" href="<?php echo EH_CRM_MAIN_CSS . "print.css";?>" type="text/css" media="all">
            <?php do_action( 'admin_print_styles' ); ?>
            <script type="text/javascript">
                var ajaxurl = '<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>';
            </script>
        </head>
        <body class="wsdesk_wrapper" id="print_body">
            <div class="Ws-content-detail-full" style="width:100%;">
                <div class="rightPanel" style="border-left: 0px !important;width:100%;">
        <?php
    }
    public function print_footer() {
        ?>
                </div>
            </div>
            <div class="footer">
                <div class="copyright"><div class="powered_wsdesk"><?php _e('Powered by', 'wsdesk'); ?> WSDesk</div></div>
            </div>
            <?php
                wp_print_scripts( 'jquery' );
            ?>
            <script>
                jQuery( document ).ready(function() {
                    jQuery('.get_attachement_image').each(function(){
                        var img = jQuery(this).css('background-image');
                        img = img.substring(img.indexOf('url("')+5,img.indexOf('")'));
                        var html = '<img class="img-upload clickable" style="width:50px" src="'+img+'">';
                        jQuery(this).html(html);
                    });
                    window.print();
                });
            </script>
            </body>
        </html>
        <?php
    }
    public function print_content()
    {
        $current = eh_crm_get_ticket(array("ticket_id"=>$this->ticket_id));
        $current_meta = eh_crm_get_ticketmeta($this->ticket_id);
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
        <div class="rightPanelHeader">
            <div class="leftFreeSpace">
                <div class="tictxt">
                <p style="margin-top: 5px;font-size: 20px;">
                        <?php
                            echo '#'.$this->ticket_id.' ';
                            echo $current[0]['ticket_title'];
                        ?>                                
                    </p>
                    <p style="margin-top: 5px;" class="info">
                        <i class="glyphicon glyphicon-user"></i> by
                        <?php
                            echo '<span>'.$current[0]['ticket_email'].'</span>';
                        ?>
                        | <i class="glyphicon glyphicon-calendar"></i> <?php echo eh_crm_get_formatted_date($current[0]['ticket_date']); ?>
                    </p>
                    <p style="margin-top: 5px;" class="info">
                        <i class="glyphicon glyphicon-comment"></i>
                        <?php
                            $raiser_voice = eh_crm_get_ticket_value_count("ticket_parent",$this->ticket_id,false,"ticket_category","raiser_reply");
                            echo count($raiser_voice)." ".__("Raiser Voice", 'wsdesk');                                    
                        ?>
                        | <i class="glyphicon glyphicon-bullhorn"></i>
                        <?php
                            $agent_voice = eh_crm_get_ticket_value_count("ticket_parent",$this->ticket_id,false,"ticket_category","agent_reply");
                            echo count($agent_voice)." ".__("Agent Voice", 'wsdesk');
                        ?>
                        | <i class="glyphicon glyphicon-star"></i> Rating : <?php echo (isset($current_meta['ticket_rating'])?ucfirst($current_meta['ticket_rating']):__("None", 'wsdesk')); ?>
                    </p>
                    <br>
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
                                    $order_id_url = array();
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
                                            array_push($order_id_url,'#'.$order);
                                            $cou++;
                                        }
                                    }
                                    echo '<p style="margin-top: 5px;" class="info"><i class="glyphicon glyphicon-shopping-cart"></i> '.__("Total Orders", 'wsdesk').' : '.$order_count.' | '.__("Recent Order", 'wsdesk').' : [ '.implode(', ',$order_id_url).' ]';
                                    if($woo_price == "enable" || $role == "administrator")
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
                    ?>
                </div>
            </div>
        </div>
        <div class="media-print">
            <div class="media-bod">
                <div class="table-container">
                    <table class="print_table"  style="border-right: 1px solid lightgray;">
                        <tr>
                            <td>
                                <h5><?php _e('Status','wsdesk'); ?></h5>
                            </td>
                            <td class="center-td">
                                :
                            </td>
                            <td>
                                <h5><span style="color: <?php echo $eye_color;?>;"><?php echo $ticket_label; ?> </span></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h5><?php _e('Assignee','wsdesk'); ?></h5>
                            </td>
                            <td class="center-td">
                                :
                            </td>
                            <td>
                                <h5><?php if(!empty($assignee_name)){echo implode(', ', $assignee_name);}else{echo '-';}?></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h5><?php _e('Tags','wsdesk'); ?></h5>
                            </td>
                            <td class="center-td">
                                :
                            </td>
                            <td>
                                <h5><?php if(!empty($tags_selected)){echo implode(', ', $tags_selected);}else{echo '-';}?></h5>
                            </td>
                        </tr>
                        <?php
                        if(!empty($cc_selected))
                        {
                            ?>
                            <tr>
                                <td>
                                    <h5><?php _e('Cc','wsdesk'); ?></h5>
                                </td>
                                <td class="center-td">
                                    :
                                </td>
                                <td>
                                    <h5><?php echo implode(', ', $cc_selected);?></h5>
                                </td>
                            </tr>
                            <?php
                        }
                        if(!empty($cc_selected))
                        {
                            ?>
                            <tr>
                                <td>
                                    <h5><?php _e('Bcc','wsdesk'); ?></h5>
                                </td>
                                <td class="center-td">
                                    :
                                </td>
                                <td>
                                    <h5><?php echo implode(', ', $bcc_selected);?></h5>
                                </td>
                            </tr>
                             <?php
                        }
                        ?>
                    </table>
                    <table class="print_table" style="margin-left:20px;">
                        <?php 
                        for ($i = 0; $i < count($selected_fields); $i++) {
                            for ($j = 3; $j < count($avail_fields); $j++) {
                                if ($avail_fields[$j]['slug'] == $selected_fields[$i]) {
                                    $field_ticket_value = (isset($current_meta[$avail_fields[$j]['slug']])?$current_meta[$avail_fields[$j]['slug']]:'-');
                                    $current_settings_meta = eh_crm_get_settingsmeta($avail_fields[$j]['settings_id']);
                                    if($current_settings_meta['field_type'] != "file" && $current_settings_meta['field_type'] != "google_captcha")
                                    {
                                        switch($current_settings_meta['field_type'])
                                        {
                                            case 'text':
                                            case 'date':
                                            case 'email':
                                            case 'number':
                                            case 'password':
                                            case 'textarea':
                                            case 'phone':
                                                echo '<tr>
                                                    <td>
                                                        <h5>'.$avail_fields[$j]['title'].'</h5>
                                                    </td>
                                                    <td class="center-td">
                                                        :
                                                    </td>
                                                    <td>
                                                        <h5>'.$field_ticket_value.'</h5>
                                                    </td>
                                                </tr>';
                                                break;
                                            case 'select':
                                            case 'radio':
                                                $gen_val = array();
                                                $field_values = $current_settings_meta['field_values'];
                                                foreach($field_values as $key => $value)
                                                {
                                                    if($key==$field_ticket_value)
                                                    {
                                                        array_push($gen_val, $value);
                                                    }
                                                }
                                                echo '<tr>
                                                    <td>
                                                        <h5>'.$avail_fields[$j]['title'].'</h5>
                                                    </td>
                                                    <td class="center-td">
                                                        :
                                                    </td>
                                                    <td>
                                                        <h5>'.((!empty($gen_val))?implode(', ', $gen_val):"-").'</h5>
                                                    </td>
                                                </tr>';
                                                break;
                                            case 'checkbox':
                                                $gen_val = array();
                                                $field_values = $current_settings_meta['field_values'];
                                                $field_ticket_value = is_array($field_ticket_value)?$field_ticket_value:array();
                                                foreach($field_values as $key => $value)
                                                {
                                                    if(in_array($key,$field_ticket_value))
                                                    {
                                                        array_push($gen_val, $value);
                                                    }
                                                }
                                                echo '<tr>
                                                    <td>
                                                        <h5>'.$avail_fields[$j]['title'].'</h5>
                                                    </td>
                                                    <td class="center-td">
                                                        :
                                                    </td>
                                                    <td>
                                                        <h5>'.((!empty($gen_val))?implode(', ', $gen_val):"-").'</h5>
                                                    </td>
                                                </tr>';
                                                break;
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <?php
        $reply_id = eh_crm_get_ticket_value_count("ticket_parent", $this->ticket_id,false,"","","ticket_updated","DESC");
        array_push($reply_id,array("ticket_id"=>$this->ticket_id));
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
                        $attachment .= '<img class="img-upload clickable" style="width:200px" title="' .$att_name. '" src="'.$current_att.'">';
                    }
                    else
                    {
                        $check_file_ext = array('doc','docx','pdf','xml','csv','xlsx','xls','txt','zip');
                        if(in_array($att_ext,$check_file_ext))
                        {
                            $attachment .= '<div class="'.$att_ext.' get_attachement_image"></div>';
                        }
                        else
                        {
                            $attachment .= '<div class="unknown_type get_attachement_image"></div>';
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
                    <h4>'.$replier_email.' | '. eh_crm_get_formatted_date($reply_ticket[0]['ticket_date']).' </h4>
                    '.(($reply_ticket[0]['ticket_category'] === 'satisfaction_survey')?'<b>'.__("Satisfaction Comment", 'wsdesk').'</b><br>':'').'    
                    <p>';
                    echo html_entity_decode(stripslashes($reply_ticket[0]['ticket_content']));
                    echo '</p>
                    '.$attachment.'
                    </div>
                </div>';
        }
    }
}
new WSDesk_Print();
