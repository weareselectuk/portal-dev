<?php
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

    function eh_crm_reports_page_tabs($current = 'agent') {
        $tabs = array(
            'agent'   => __("Agents Reports", 'wsdesk'),
            'date_wise' => __("Date wise Reports", 'wsdesk')
        );
        if(EH_CRM_WOO_STATUS)
        {
            $tabs['woocommerce'] = __("WooCommerce Reports", 'wsdesk');
        }
        $html =  '<h2 class="nav-tab-wrapper" style="margin-right:20px;">';
        foreach( $tabs as $tab => $name ){
            $class = ($tab == $current) ? 'nav-tab-active' : '';
            $style = ($tab == $current) ? '' : '';
            $html .=  '<a style="text-decoration:none !important;'.$style.'" class="nav-tab ' . $class . '" href="?page=wsdesk_reports&tab=' . $tab . '">' . $name . '</a>';
        }
        $html .= '</h2>';
        echo $html;
    }
    $tab = (!empty($_GET['tab']))? esc_attr($_GET['tab']) : 'agent';
    eh_crm_reports_page_tabs($tab);
    if($tab == 'agent' ) 
    {
        ?>
        <div class="table-box table-box-main" id='agent_section' style="margin-top: 10px;">
            <?php echo wsdesk_agents_reports_view_section(); ?>
        </div>
    </div>
        <?php
    }
    else if($tab == "date_wise"){
    ?>
        <div class="table-box table-box-main" id='woocommerce_section' style="margin-top: 10px;">
           <?php echo wsdesk_date_wise_view_section(); ?>
        </div> 
    <?php
    }
    else {
        ?>
        <div class="table-box table-box-main" id='woocommerce_section' style="margin-top: 10px;">
           <?php echo wsdesk_woo_reports_view_section(); ?>
        </div>  
    </div>
        <?php
    }
function wsdesk_agents_reports_view_section()
{  
    ob_start();
    $user = (isset($_GET['user'])?$_GET['user']:"all");
    $duration = (isset($_GET['duration'])?$_GET['duration']:"last_7");
    $from_date = (isset($_GET['from_date'])?$_GET['from_date']:date("Y-m-d",time()-(7*86400)));
    $to_date = (isset($_GET['to_date'])?$_GET['to_date']:date("Y-m-d",time()));
    if(strtotime($to_date)<strtotime($from_date))
    {
        $to_date = date("Y-m-d",time());
        $from_date = date("Y-m-d",time()-(7*86400));
        echo "<script>alert('From Date cannot be beyond To Date.')</script>";
    }
    $user_name = "";
    $sol = eh_crm_get_settings(array("slug" => "label_LL02"), array("settings_id"));
    $sol_col = eh_crm_get_settingsmeta($sol[0]['settings_id'], "label_color");
    $color = array();
    switch ($duration) {
        case "last_7":
            $message = __("Last 7 Days", "wsdesk");
            break;
        case "last_30":
            $message = __("Last 30 Days", "wsdesk");
            break;
        case "custom":
            $message = $from_date. __("to", "wsdesk") .$to_date;
    }
    if($user!="all")
    {
        $user_check = get_user_by("ID",$user);
        if($user_check)
        {
            $user_roles_default = array("WSDesk_Agents", "WSDesk_Supervisor","administrator");
            $role = array_intersect($user_roles_default,$user_check->roles);
            if(!empty($role))
            {
                $user_name = $user_check->display_name;
                $bar = eh_crm_generate_bar_values($user,$from_date,$to_date);
                $donut_data = eh_crm_generate_donut_values($user,$from_date,$to_date);
                $bar_avg_time = eh_crm_generate_bar_values_Avg($user,$from_date,$to_date);
                $donut_satisfaction_data = eh_crm_generate_donut_satisfaction_values($user,$from_date,$to_date);
                $donut = $donut_data['donut'];
                $color = $donut_data['color'];
                $donut_satisfaction = $donut_satisfaction_data['donut'];
                $donut_satisfaction_color = $donut_satisfaction_data['color'];
                $lines = eh_crm_generate_line_values($user,$from_date,$to_date);
            }
            else
            {
                wp_die(sprintf('<center><h1>'.__("Oops", 'wsdesk').' !</h1><h4>'.__("User is not having any WSDesk Role", 'wsdesk').'</h4><a href="'. admin_url("admin.php?page=wsdesk_reports").'">'.__("Back to Reports", 'wsdesk').'</a></center>'));
            }
        }
        else
        {
            wp_die(sprintf('<center><h1>'.__("Oops", 'wsdesk').' !</h1><h4>'.__("User not found", 'wsdesk').'</h4><a href="'. admin_url("admin.php?page=wsdesk_reports").'">'.__("Back to Reports", 'wsdesk').'</a></center>'));
        }
    }
    else
    {
        $user_name = "All";
        $bar = eh_crm_generate_bar_values($user,$from_date,$to_date);
        $donut = eh_crm_generate_donut_values($user,$from_date,$to_date);
        $bar_avg_time = eh_crm_generate_bar_values_Avg($user,$from_date,$to_date);
        $lines = eh_crm_generate_line_values($user,$from_date,$to_date);
        $donut_satisfaction_data = eh_crm_generate_donut_satisfaction_values($user,$from_date,$to_date);
        $donut_satisfaction = $donut_satisfaction_data['donut'];
        $donut_satisfaction_color = $donut_satisfaction_data['color'];
    }
    ?>
    <div class="container wrapper" id="reports_page_view">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default reports_panel">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php _e("WSDesk - Agents Reports", 'wsdesk');?></h3>
                    </div>
                    <div class="panel-body" id="reports_panel_body" style="text-align: center">
                        <form method="GET">
                            <input type="hidden" name="page" id="page" value="wsdesk_reports">
                            <span class="help-block"><?php _e("Select the Agents/Supervisors to show report?", 'wsdesk');?></span>
                            <select id="user" name="user" style="display: inline !important;" class="form-control" aria-describedby="helpBlock">
                                <option value="all" <?php echo ($user=="all")?"selected":"" ?> >All</option>
                                <?php
                                    $user_roles_default = array("WSDesk_Agents", "WSDesk_Supervisor","administrator");
                                    $users = get_users(array("role__in" => $user_roles_default));
                                    $users_data =array();
                                    for ($i = 0; $i < count($users); $i++) {
                                        $current = $users[$i];
                                        $id = $current->ID;
                                        $user_data = new WP_User($id);
                                        $users_data[$i]['id'] = $id;
                                        $users_data[$i]['name'] = $user_data->display_name;
                                    }
                                    for($i=0;$i<count($users_data);$i++)
                                    {
                                        $selected = "selected";
                                        echo '<option value="'.$users_data[$i]["id"].'" '.(($user==$users_data[$i]["id"])?$selected:"").'>'.$users_data[$i]["name"].'</option>';
                                    }
                                ?>
                            </select>
                            <span class="help-block"><?php _e("Select the Duration:", 'wsdesk');?></span>
                            <select id="duration" name="duration" style="display: inline !important;" class="form-control" aria-describedby="helpBlock">
                                <option value="last_7" <?php echo ($duration=="last_7")?"selected":"" ?>><?php _e("Last 7 Days", 'wsdesk');?></option>
                                <option value="last_30" <?php echo ($duration=="last_30")?"selected":"" ?>><?php _e("Last 30 Days", 'wsdesk');?></option>
                                <option value="custom" <?php echo ($duration=="custom")?"selected":"" ?>><?php _e("Custom", 'wsdesk');?></option>
                            </select>

                            <?php
                            switch ($duration) {
                                case 'custom':
                                    $display = "inline";
                                    break;
                                
                                default:
                                    $display = "none";
                                    break;
                            }
                            ?>
                            <div class = "from_date" style="display: <?php echo $display;?>;">
                                <span class="help-block"><?php _e("Select the From Date:", 'wsdesk');?></span>
                                <input style="width: 30%; display: inline !important;" value="<?php echo $from_date;?>" type="date" name="from_date" id="from_date" class="form-control" aria-describedby="helpBlock">
                            </div>
                            <div class="to_date" style="display: <?php echo $display;?>">
                                <span class="help-block"><?php _e("Select the To Date:", 'wsdesk');?></span>
                                <input style="width: 30%; display: inline !important;" value="<?php echo $to_date;?>" type="date" name="to_date" id="to_date" class="form-control" aria-describedby="helpBlock">
                            </div>
                            <br>
                            <input type="submit" style="margin-top: 10px" class="btn btn-primary" value="<?php _e("Show Report", 'wsdesk');?>">
                        </form>
                    </div>
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?php _e("$message Status of New Tickets", 'wsdesk');?> : <?php echo $user_name; ?> </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="7days-ticket" style="height: 250px;"></div>
                                        <script>
                                            Morris.Bar({
                                                element: '7days-ticket',
                                                data: <?php echo json_encode($bar);?>,
                                                xkey: 'y',
                                                ykeys: ['a'],
                                                labels: ["<?php _e('Tickets', 'wsdesk');?>", "<?php _e('Date', 'wsdesk');?>"],
                                                resize:true
                                            });
                                        </script>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?php _e("$message Status of Agent Tickets", 'wsdesk');?> : <?php echo $user_name;?></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div id="assignee-contribution" style="height: 250px;"></div>
                                                    <script>
                                                        Morris.Donut({
                                                            element: 'assignee-contribution',
                                                            data: <?php echo json_encode($donut);?>,
                                                            <?php echo ((!empty($color))?"colors: ".json_encode($color).",":"");?>
                                                            resize:true
                                                        });
                                                    </script>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="panel panel-default">
                                                    <table class="table table-hover">
                                                    <?php
                                                        for($i=0;$i<count($donut);$i++) {
                                                            if(!empty($color))
                                                            {
                                                                echo "<tr style='background:".$color[$i]."'>";
                                                            }
                                                            else
                                                            {
                                                                echo "<tr>";
                                                            }
                                                            echo "<td>".$donut[$i]['label']."</td>";
                                                            echo "<td>".$donut[$i]['value']."</td>";
                                                            echo "</tr>";
                                                        }
                                                    ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?php _e("$message Status of New and Solved Ticket", 'wsdesk');?> : <?php echo $user_name; ?></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="new-solved-status" style="height: 250px;"></div>
                                        <script>
                                            Morris.Area({
                                                element: 'new-solved-status',
                                                data: <?php echo json_encode($lines);?>,
                                                xkey: 'y',
                                                ykeys: ['a', 'b', 'c', 'd'],
                                                lineColors: ['#0b62a4','<?php echo $sol_col;?>','#57b755','#e87681'],
                                                labels: ["<?php _e('New Tickets', 'wsdesk');?>", "<?php _e('Solved Tickets', 'wsdesk');?>", "<?php _e("Good Rating", 'wsdesk');?>", "<?php _e("Bad Rating", 'wsdesk');?>"],
                                                behaveLikeLine:true,
                                                resize: true
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?php _e("$message Satisfaction Survey", 'wsdesk');?> : <?php echo $user_name; ?></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div id="assignee-satisfaction" style="height: 250px;"></div>
                                                <script>
                                                    Morris.Donut({
                                                        element: 'assignee-satisfaction',
                                                        data: <?php echo json_encode($donut_satisfaction);?>,
                                                        <?php echo ((!empty($donut_satisfaction_color))?"colors: ".json_encode($donut_satisfaction_color).",":"");?>
                                                        resize:true
                                                    });
                                                </script>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="panel panel-default">
                                                    <table class="table table-hover">
                                                    <?php
                                                        for($i=0;$i<count($donut_satisfaction);$i++)
                                                        {
                                                            if(!empty($color))
                                                            {
                                                                echo "<tr style='background:".$donut_satisfaction_color[$i]."'>";
                                                            }
                                                            else
                                                            {
                                                                echo "<tr>";
                                                            }
                                                            echo "<td>".$donut_satisfaction[$i]['label']."</td>";
                                                            echo "<td>".$donut_satisfaction[$i]['value']."</td>";
                                                            echo "</tr>";
                                                        }
                                                    ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="row" style="padding-top: 10px;">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">
                                            <?php
                                                echo $message." ".__("Status of Solved Tickets",'wsdesk');
                                                echo ": ".$user_name;
                                                if($user == "all")
                                                {
                                                    echo' '.__("Average Solving Time in Minutes",'wsdesk');
                                                }
                                            ?>
                                            </h3>
                                        </div>
                                        <div class="panel-body">
                                            <?php if($user == "all") {  ?>
                                                <div id="avg_resolution" style="height: 250px;"></div>
                                                <script>
                                                    Morris.Bar({
                                                    barSizeRatio:0.2,
                                                    element: 'avg_resolution',
                                                    data: <?php  echo json_encode($bar_avg_time);?>,
                                                    xkey: ['1'],
                                                    ykeys: ['0','2'],
                                                    labels: ["<?php _e('Avg Solving time', 'wsdesk');?>", "<?php _e('Solved Tickets', 'wsdesk');?>"],
                                                    barShape:'soft',
                                                    xLabelAngle:50,
                                                    resize:true
                                                    });
                                                </script> 
                                            <?php }  
                                                if($user != "all"){
                                            ?>         
                                                    <h3><?php _e("Average Resolution Time of ",'wsdesk');_e("$user_name",'wsdesk');?></h3>
                                                    <h5>
                                                    <?php
                                                        echo $bar_avg_time[0].' '.__("Days",'wsdesk').' '.$bar_avg_time[1].' '.__("Hours",'wsdesk').' '.$bar_avg_time[2].' '.__("Minutes",'wsdesk');
                                                    ?></h5>              
                                            <?php } ?>            
                                        </div>
                                    </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
    <?php
    return ob_get_clean();
}
function wsdesk_woo_reports_view_section()
{
    ob_start();
    $pro_bar = eh_crm_woo_products_generate_bar_values();
    $cat_bar = eh_crm_woo_category_generate_bar_values();
    ?>
    <div class="container wrapper" id="woo_reports_page_view">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default woo_reports_panel">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php _e('WSDesk - WooCommerce Reports', 'wsdesk');?></h3>
                    </div>
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?php _e('Last 7 Days status of new tickets', 'wsdesk');?> : <span id="change_product_name"><?php _e('Top Products', 'wsdesk');?></span></h3>
                                    </div>
                                    <div class="panel-body" id="reports_panel_body" style="text-align: center">
                                        <div class="loader" id="woo_product_loader"></div>
                                        <span class="help-block"><?php _e('Select the Product(s) to show report?', 'wsdesk');?></span>
                                        <select id="show_product" multiple name="show_product" style="display: inline !important;" class="form-control" aria-describedby="helpBlock">
                                            <?php
                                                $field = eh_crm_get_settings(array("slug"=>"woo_product"));
                                                if($field)
                                                {
                                                    $field_meta = eh_crm_get_settingsmeta($field[0]['settings_id'],"field_values");
                                                    foreach ($field_meta as $key => $value)
                                                    {
                                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <br>
                                        <button style="margin-top: 10px" class="btn btn-primary" id="woo_product_report_custom"><?php _e('Show Report', 'wsdesk');?></button>
                                    </div>
                                    <div id="7days-woo-product-ticket" style="height: 250px;"></div>
                                    <script>
                                        var woo_product_bar_chart = Morris.Bar({
                                            element: '7days-woo-product-ticket',
                                            data: <?php echo json_encode($pro_bar);?>,
                                            xkey: 'y',
                                            ykeys: ['a'],
                                            labels: ["<?php _e('Tickets', 'wsdesk');?>", "<?php _e('Product', 'wsdesk');?>"],
                                            resize:true
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?php _e('Last 7 Days status of new tickets', 'wsdesk');?> : <span id="change_product_name"><?php _e('Top Categories', 'wsdesk');?></span></h3>
                                    </div>
                                    <div class="panel-body" id="reports_panel_body" style="text-align: center">
                                        <div class="loader" id="woo_category_loader"></div>
                                        <span class="help-block"><?php _e('Select the Category(s) to show report?', 'wsdesk');?></span>
                                        <select id="show_category" multiple name="show_category" style="display: inline !important;" class="form-control" aria-describedby="helpBlock">
                                            <?php
                                                $cat_field = eh_crm_get_settings(array("slug"=>"woo_category"));
                                                if($cat_field)
                                                {
                                                    $field_meta = eh_crm_get_settingsmeta($cat_field[0]['settings_id'],"field_values");
                                                    foreach ($field_meta as $key => $value)
                                                    {
                                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <br>
                                        <button style="margin-top: 10px" class="btn btn-primary" id="woo_category_report_custom"><?php _e('Show Report', 'wsdesk');?></button>
                                    </div>
                                    <div id="7days-woo-category-ticket" style="height: 250px;"></div>
                                    <script>
                                        var woo_category_bar_chart = Morris.Bar({
                                            element: '7days-woo-category-ticket',
                                            data: <?php echo json_encode($cat_bar);?>,
                                            xkey: 'y',
                                            ykeys: ['a'],
                                            labels: ["<?php _e('Tickets', 'wsdesk');?>", "<?php _e('Category', 'wsdesk');?>"],
                                            resize:true
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
function wsdesk_date_wise_view_section()
{
    ob_start();
    $duration = (isset($_GET['duration'])?$_GET['duration']:"last_7");
    $from_date = (isset($_GET['from_date'])?$_GET['from_date']:date("Y-m-d",time()-(7*86400)));
    $to_date = (isset($_GET['to_date'])?$_GET['to_date']:date("Y-m-d",time()));
    if(strtotime($to_date)<strtotime($from_date))
    {
        $to_date = date("Y-m-d",time());
        $from_date = date("Y-m-d",time()-(7*86400));
        echo "<script>alert('From Date cannot be beyond To Date.')</script>";
    }
    switch ($duration) {
        case "last_7":
            $message = "Last 7 Days";
            break;
        case "last_30":
            $message = "Last 30 Days";
            break;
        case "custom":
            $message = "$from_date to $to_date";
    }
    $donut = eh_crm_generate_donut_values_tags($from_date,$to_date);
    ?>
    <div class="container wrapper" id="reports_page_view">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default reports_panel">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php _e("WSDesk - Date Wise Reports", 'wsdesk');?></h3>
                    </div>
                    <div class="panel-body" id="reports_panel_body" style="text-align: center">
                        <form method="GET" action="<?php echo admin_url()."admin.php?page=wsdesk_reports&tab=date_wise";?>">
                            <input type="hidden" name="page" id="page" value="wsdesk_reports">
                            <input type="hidden" name="tab" id="tab" value="date_wise">
                            <span class="help-block"><?php _e("Select the Duration:", 'wsdesk');?></span>
                            <select id="duration" name="duration" style="display: inline !important;" class="form-control" aria-describedby="helpBlock">
                                <option value="last_7" <?php echo ($duration=="last_7")?"selected":"" ?>><?php _e("Last 7 Days", 'wsdesk');?></option>
                                <option value="last_30" <?php echo ($duration=="last_30")?"selected":"" ?>><?php _e("Last 30 Days", 'wsdesk');?></option>
                                <option value="custom" <?php echo ($duration=="custom")?"selected":"" ?>><?php _e("Custom", 'wsdesk');?></option>
                            </select>

                            <?php
                            switch ($duration) {
                                case 'custom':
                                    $display = "inline";
                                    break;
                                
                                default:
                                    $display = "none";
                                    break;
                            }
                            ?>
                            <div class = "from_date" style="display: <?php echo $display;?>;">
                                <span class="help-block"><?php _e("Select the From Date:", 'wsdesk');?></span>
                                <input style="width: 30%; display: inline !important;" value="<?php echo $from_date;?>" type="date" name="from_date" id="from_date" class="form-control" aria-describedby="helpBlock">
                            </div>
                            <div class="to_date" style="display: <?php echo $display;?>">
                                <span class="help-block"><?php _e("Select the To Date:", 'wsdesk');?></span>
                                <input style="width: 30%; display: inline !important;" value="<?php echo $to_date;?>" type="date" name="to_date" id="to_date" class="form-control" aria-describedby="helpBlock">
                            </div>
                            <br>
                            <input type="submit" style="margin-top: 10px" class="btn btn-primary" value="<?php _e("Show Report", 'wsdesk');?>">
                        </form>
                    </div>
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-md-12">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?php _e("$message Status of Tickets by Tags", 'wsdesk');?></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div id="date_wise" style="height: 250px;"></div>
                                                    <script>
                                                        Morris.Donut({
                                                            element: 'date_wise',
                                                            data: <?php echo json_encode($donut);?>,
                                                            resize:true
                                                        });
                                                    </script>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="panel panel-default">
                                                    <table class="table table-hover">
                                                    <?php
                                                        for($i=0;$i<count($donut);$i++) {
                                                            if(!empty($color))
                                                            {
                                                                echo "<tr style='background:".$color[$i]."'>";
                                                            }
                                                            else
                                                            {
                                                                echo "<tr>";
                                                            }
                                                            echo "<td>".$donut[$i]['label']."</td>";
                                                            echo "<td>".$donut[$i]['value']."</td>";
                                                            echo "</tr>";
                                                        }
                                                    ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
return ob_get_clean();
}