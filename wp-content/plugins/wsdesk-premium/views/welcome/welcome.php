<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WSDesk_Setup_Wizard {
        private $step   = '';
        private $steps  = array();
    public function __construct() {
            if (current_user_can( 'activate_plugins' ) ) {
                add_action( 'admin_menu', array( $this, 'wsdesk_admin_menus' ) );
                add_action( 'admin_init', array( $this, 'wsdesk_setup_wizard' ) );
            }
            update_option("wsdesk_setup_wizard",'shown');
    }
        
    public function wsdesk_admin_menus() {
            add_dashboard_page( '', '', 'manage_options', 'wsdesk-setup', '' );
    }

    /**
     * Show the setup wizard.
     */
    public function wsdesk_setup_wizard() {
        if ( empty( $_GET['page'] ) || 'wsdesk-setup' !== $_GET['page'] ) {
            return;
        }
        $default_steps = array(
            'introduction' => array(
                'name'    => __( 'Start', 'wsdesk' ),
                'view'    => array( $this, 'wsdesk_setup_introduction' ),
                'handler' => '',
            ),
            'pages' => array(
                'name'    => __( 'Support Setup', 'wsdesk' ),
                'view'    => array( $this, 'wsdesk_setup_pages' ),
                'handler' => array( $this, 'wsdesk_setup_pages_save' ),
            ),
            'fields' => array(
                'name'    => __( 'Ticket  Fields', 'wsdesk' ),
                'view'    => array( $this, 'wsdesk_setup_fields' ),
                'handler' => '',
            ),
            'email' => array(
                'name'    => __( 'Email Client', 'wsdesk' ),
                'view'    => array( $this, 'wsdesk_setup_email' ),
                'handler' => '',
            ),
            'agents' => array(
                'name'    => __( 'WSDesk Agents', 'wsdesk' ),
                'view'    => array( $this, 'wsdesk_setup_agents' ),
                'handler' => '',
            ),
            'next_steps' => array(
                'name'    => __( 'Ready!', 'wsdesk' ),
                'view'    => array( $this, 'wsdesk_setup_ready' ),
                'handler' => '',
            ),
        );

        $this->steps = $default_steps;
        $this->step = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : 'introduction';
        if ( ! empty( $_POST['save_step'] ) && isset( $this->steps[ $this->step ]['handler'] ) ) {
            call_user_func( $this->steps[ $this->step ]['handler'], $this );
        }
                wp_register_script("material-bootstrap-wizard", EH_CRM_MAIN_JS . "welcome/material-bootstrap-wizard.js");
                wp_register_script("bootstrap", EH_CRM_MAIN_JS . "bootstrap.js");
                wp_register_script("jquery.bootstrap", EH_CRM_MAIN_JS . "welcome/jquery.bootstrap.js");
                wp_register_script("jquery.validate.min", EH_CRM_MAIN_JS . "welcome/jquery.validate.min.js");
                wp_enqueue_style('wp-admin');
                wp_enqueue_style('jquery');
                $page = (isset($_GET['page']) ? $_GET['page'] : '');
                if ($page=='wsdesk-setup') {
                    wp_register_script("dialog", EH_CRM_MAIN_JS . "dialog.js");
                    wp_enqueue_style("dialog", EH_CRM_MAIN_CSS . "dialog.css");
                    wp_enqueue_style("select2", EH_CRM_MAIN_CSS . "select2.css");
                    wp_register_script("select2", EH_CRM_MAIN_JS . "select2.js");
                    if($this->step === 'fields')
                    {
                        wp_register_script("crm_settings", EH_CRM_MAIN_JS . "crm_settings.js");
                        $js_var = eh_crm_js_translation_obj('settings');
                        wp_localize_script('crm_settings', 'js_obj', $js_var);
                        wp_enqueue_style("crm_settings", EH_CRM_MAIN_CSS . "crm_settings.css");
                        wp_enqueue_script( 'jquery-ui-datepicker');
                        wp_enqueue_style( 'jquery-ui' , EH_CRM_MAIN_CSS."jquery-ui.css");
                        wp_register_script("dragDrop", EH_CRM_MAIN_JS . "DragDrop.js");
                    }
                    if($this->step === 'agents')
                    {
                        wp_register_script("crm_agents", EH_CRM_MAIN_JS . "crm_agents.js");
                        wp_enqueue_style("crm_agents", EH_CRM_MAIN_CSS . "crm_agents.css");
                        $js_var = eh_crm_js_translation_obj('agents');
                        wp_localize_script('crm_agents', 'js_obj', $js_var);
                    }
                    if($this->step === 'email')
                    {
                        wp_register_script("crm_email", EH_CRM_MAIN_JS . "crm_email.js");
                        wp_enqueue_style("crm_email", EH_CRM_MAIN_CSS . "crm_email.css");
                        $js_var = eh_crm_js_translation_obj('email');
                        wp_localize_script('crm_email', 'js_obj', $js_var);
                    }
                }
        ob_start();
        $this->setup_wizard_header();
                if($this->step != 'introduction')
                {
                    $this->setup_wizard_steps();
                }
        $this->setup_wizard_content();
        $this->setup_wizard_footer();
        exit;
    }
    public function get_next_step_link( $step = '' ) {
        if ( ! $step ) {
            $step = $this->step;
        }

        $keys = array_keys( $this->steps );
        if ( end( $keys ) === $step ) {
            return admin_url();
        }

        $step_index = array_search( $step, $keys );
        if ( false === $step_index ) {
            return '';
        }
                
        return add_query_arg( 'step', $keys[ $step_index + 1 ] );
    }

    /**
     * Setup Wizard Header.
     */
    public function setup_wizard_header() {
        ?>
        <!DOCTYPE html>
        <html <?php language_attributes(); ?>>
        <head>
            <meta name="viewport" content="width=device-width" />
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title><?php esc_html_e( 'WSDesk &rsaquo; Setup Wizard', 'wsdesk' ); ?></title>
                        <link rel="stylesheet" id="setup-css" href="<?php echo EH_CRM_MAIN_CSS . "welcome/setup.css";?>" type="text/css" media="all">
            <link rel="stylesheet" id="bootstrap-css" href="<?php echo EH_CRM_MAIN_CSS . "/welcome/bootstrap.min.css";?>" type="text/css" media="all">
                        <link rel="stylesheet" id="bootstrap-css" href="<?php echo EH_CRM_MAIN_CSS . "boot.css";?>" type="text/css" media="all">
                        <link rel="stylesheet" id="material-bootstrap-wizard-css" href="<?php echo EH_CRM_MAIN_CSS . "welcome/material-bootstrap-wizard.css";?>" type="text/css" media="all">
                        <?php do_action( 'admin_print_styles' ); ?>
                        <?php do_action( 'admin_head' ); ?>
                        <script type="text/javascript">
                            var ajaxurl = '<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>';
                        </script>
        </head>
                <body style="background-color:#f1f1f1 !important;">
                    <center>
                        <div class="logo" style="margin-bottom:20px;">
                            <a href="https://elextensions.com/plugin/wsdesk-wordpress-support-desk-plugin/" target="_blank">
                                <img src="<?php echo EH_CRM_MAIN_IMG."wsdesk.png";?>">
                            </a>
                        </div>
                        <a href="<?php echo esc_url( admin_url() ); ?>" ><?php esc_html_e( 'Return to the WordPress Dashboard', 'wsdesk' ); ?></a>
                    </center>
                <div class="container" style="margin-bottom:30px;">
                    <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">
                                
                                    <div class="wizard-container" style="padding-top: 30px !important">
                                        <div class="setup-wsdesk-card wizard-card" data-color="red" id="wizard">
                                            <?php
                                                switch ($this->step) {
                                                    case "introduction":
                                                        ?>
                                                        <div class="wizard-header" style="padding-bottom:10px !important;margin-top:20px !important;">
                                                            <h1 class="wizard-title" style="font-weight: bold;">
                                                                <?php esc_html_e( 'Thank you for choosing WSDesk to power your online support!', 'wsdesk' ); ?>
                                                            </h1>
                                                        </div>
                                                        <?php

                                                        break;
                                                    case 'next_steps':
                                                        ?>
                                                        <div class="wizard-header">
                                                            <h3 class="wizard-title" style="font-weight: bold;">
                                                                <?php  esc_html_e( 'Your helpdesk is ready!', 'wsdesk' ); ?>
                                                            </h3>
                                                        </div>
                                                        <?php
                                                        break;
                                                    default:
                                                        ?>
                                                        <div class="wizard-header">
                                                            <h3 class="wizard-title" style="font-weight: bold;">
                                                                <?php  esc_html_e( 'WSDesk - Quick Setup Wizard', 'wsdesk' ); ?>
                                                            </h3>
                                                        </div>
                                                        <?php
                                                        break;
                                                }
                                            ?>
        <?php
    }

    /**
     * Setup Wizard Footer.
     */
    public function setup_wizard_footer() {
            ?>
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                        if($this->step === 'fields')
                        {
                            wp_print_scripts( 'jquery-ui-datepicker' );
                        }
                        wp_print_scripts( 'jquery' );
                        wp_print_scripts( 'bootstrap' );
                        wp_print_scripts( 'dialog' );
                        wp_print_scripts( 'jquery.bootstrap' );
                        wp_print_scripts( 'material-bootstrap-wizard' );
                        wp_print_scripts( 'jquery.validate.min' );
                        if($this->step === 'fields')
                        {
                            wp_print_scripts( 'crm_settings' );
                            wp_print_scripts( 'dragDrop' );
                        }
                        wp_print_scripts( 'select2' );
                        if($this->step === 'agents')
                        {
                            wp_print_scripts( 'crm_agents' );
                        }
                        if($this->step === 'email')
                        {
                            wp_print_scripts( 'crm_email' );
                        }
                    ?>
                    </body>
            </html>
            <?php
    }

    /**
     * Output the steps.
     */
    public function setup_wizard_steps() {
        $ouput_steps = $this->steps;
                array_shift( $ouput_steps );
        ?>
                <div class="wizard-navigation">
                    <ul>
                        <?php foreach ( $ouput_steps as $step_key => $step ) : ?>
                        <li  style="margin-bottom: 0px !important;" class="<?php
                                if ( $step_key === $this->step ) {
                                        echo 'active';
                                } elseif ( array_search( $this->step, array_keys( $this->steps ) ) > array_search( $step_key, array_keys( $this->steps ) ) ) {
                                        echo 'done';
                                }
                                ?>">
                            <a href="#<?php echo $step_key;?>" style="pointer-events:none;" data-toggle="tab"><?php echo esc_attr_e($step['name']); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
        <?php
    }

    public function setup_wizard_content() {
        echo '<div class="tab-content wsdesk-setup-content"><div class="loader"></div>';
        call_user_func( $this->steps[ $this->step ]['view'], $this );
        echo '</div>';
    }

    public function wsdesk_setup_introduction() {
        ?>
            <center>
                <p><?php _e( 'This quick setup wizard will help you configure the basic settings. <br/><strong>It’s completely optional and shouldn’t take longer.</strong>', 'wsdesk' ); ?></p>
                <p><?php _e( 'No time right now? If you don’t want to go through the wizard, you can skip and configure it later under settings.', 'wsdesk' ); ?></p>
        <p>
                    <a href="<?php echo esc_url( admin_url("admin.php?page=wsdesk_tickets") ); ?>" class="btn btn-default wsdesk-setup-actions"><?php esc_html_e( 'Not right now', 'wsdesk' ); ?></a>
                    <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="btn-info btn wsdesk-setup-actions"><?php esc_html_e( 'Let\'s setup now!', 'wsdesk' ); ?></a>
        </p>
                </center>
        <?php
    }

    public function wsdesk_setup_pages() {
        ?>
                <center>
                    <div style="margin-top:10px;">
                        <form method="post">
                            <p style="margin: 0 0 15px;"><?php printf( __( 'Set your support page title, email ID and ticket starting ticket ID.', 'wsdesk' ), esc_url( admin_url( 'edit.php?post_type=page' ) ) ); ?></p>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-sm-6">
                                        <div class="input-group" style="width:90%">
                                            <div class="form-group1" style="margin:0px !important;">
                                                <span class="input-group-addon" style="padding: 6px 15px 10px !important;">
                                                    <span class="glyphicon glyphicon-envelope" style="font-size: 35px;"></span>
                                                </span>
                                                <label for="support_email" style="color:black;"><?php _e('WSDesk Support Email','wsdesk'); ?></label>
                                                <br>
                                                <label for="support_email"><small><?php _e('The email ID which is used for support responses','wsdesk'); ?></small></label>
                                                <br>
                                                <input name="support_email" id="support_email" type="email" class="form-control1" style="font-size: 20px;height: 40px;width:80%;" placeholder="support@example.com">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group" style="width:90%">
                                            <div class="form-group1" style="margin:0px !important;">
                                                <span class="input-group-addon" style="padding: 6px 15px 10px !important;">
                                                    <span class="glyphicon glyphicon-list-alt" style="font-size: 35px;"></span>
                                                </span>
                                                <label for="page_name" style="color:black;"><?php _e('Starting Ticket ID','wsdesk'); ?></label>
                                                <br>
                                                <label for="page_name"><small><?php _e('You can set your first Ticket\'s ID here.','wsdesk'); ?></small></label>
                                                <br>
                                                <input name="ticket_id" id="ticket_id" type="text" class="form-control1" style="font-size: 20px;width:80%;height: 40px;" placeholder="<?php _e('Default Ticket ID is 1','wsdesk'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="input-group" style="width:90%">
                                        <div class="form-group1" style="margin:0px !important;">
                                            <span class="input-group-addon" style="padding: 6px 15px 10px !important;">
                                                <span class="glyphicon glyphicon-headphones" style="font-size: 35px;"></span>
                                            </span>
                                            <label for="page_name" style="color:black;"><?php _e('WSDesk Support Page Title','wsdesk'); ?></label>
                                            <br>
                                            <label for="page_name"><small><?php _e('Title which will be displayed on your site','wsdesk'); ?></small></label>
                                            <br>
                                            <input name="page_name" id="page_name" type="text" class="form-control1" style="font-size: 20px;width:80%;height: 40px;" placeholder="<?php _e('Enter page title','wsdesk'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group" style="width:90%">
                                        <div class="form-group1" style="margin:0px !important;">
                                            <span class="input-group-addon" style="padding: 6px 15px 10px !important;">
                                                <span class="glyphicon glyphicon-headphones" style="font-size: 35px;"></span>
                                            </span>
                                            <label for="page_name" style="color:black;"><?php _e('WSDesk Individual Ticket Page Title','wsdesk'); ?></label>
                                            <br>
                                            <label for="page_name"><small><?php _e('Title which will be displayed on your site','wsdesk'); ?></small></label>
                                            <br>
                                            <input name="single_ticket_page_name" id="page_name" type="text" class="form-control1" style="font-size: 20px;width:80%;height: 40px;" placeholder="<?php _e('Enter page title','wsdesk'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group" style="width:90%">
                                        <div class="form-group1" style="margin:0px !important;">
                                            <span class="input-group-addon" style="padding: 6px 15px 10px !important;">
                                                <span class="glyphicon glyphicon-headphones" style="font-size: 35px;"></span>
                                            </span>
                                            <label for="page_name" style="color:black;"><?php _e('WSDesk Existing Ticket Page Title','wsdesk'); ?></label>
                                            <br>
                                            <label for="page_name"><small><?php _e('Title which will be displayed on your site','wsdesk'); ?></small></label>
                                            <br>
                                            <input name="existing_ticket_page_name" id="page_name" type="text" class="form-control1" style="font-size: 20px;width:80%;height: 40px;" placeholder="<?php _e('Enter page title','wsdesk'); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div  class="pull-right" style="margin-top: 15px;">
                                <p style="padding: 0px 20px;">
                                    <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="btn-default btn wsdesk-setup-actions"><?php esc_html_e( 'Skip this step', 'wsdesk' ); ?></a>
                                    <input type="submit" class="btn-info btn wsdesk-setup-actions" value="<?php esc_attr_e( 'Save & Continue', 'wsdesk' ); ?>" name="save_step"/>
                                    <?php wp_nonce_field( 'wsdesk-setup' ); ?>
                                </p>
                            </div>
                        </form>
                    </div>
                </center>
        <?php
    }

    public function wsdesk_setup_pages_save() {
            check_admin_referer( 'wsdesk-setup' );
            global $wpdb;
            $table_name = $wpdb->prefix . 'wsdesk_tickets';
            $name = ($_POST['page_name'] !== "")?sanitize_text_field($_POST['page_name']):__("Support",'wsdesk');
            $single_ticket_page_name = ($_POST['single_ticket_page_name'] !== "")?sanitize_text_field($_POST['single_ticket_page_name']):__("Single Ticket View",'wsdesk');
            $existing_ticket_page_name = ($_POST['existing_ticket_page_name'] !== "")?sanitize_text_field($_POST['existing_ticket_page_name']):__("Existing Tickets",'wsdesk');

            $email = ($_POST['support_email'] !== "")?sanitize_text_field($_POST['support_email']):"";
            $ticket_id = ($_POST['ticket_id'] !== "" && is_numeric($_POST['ticket_id']))?sanitize_text_field($_POST['ticket_id']):"";
            $post = array(
                  'comment_status' => 'closed',
                  'ping_status' =>  'closed' ,
                  'post_author' => get_current_user_id(),
                  'post_content'  => '[wsdesk_support display="form"]',
                  'post_status' => 'publish' ,
                  'post_title' => $name,
                  'post_type' => 'page',
            );
            $newvalue = wp_insert_post( $post, false );
            if(!is_wp_error($newvalue))
            {
                update_option( 'wsdesk_support_page', $newvalue );
            }

            $post['post_content'] = '[wsdesk_support display="form_support_request_table"]';
            $post['post_title'] = $single_ticket_page_name;
            $newvalue = wp_insert_post( $post, false );

            $post['post_content'] = '[wsdesk_support display="check_request"]';
            $post['post_title'] = $existing_ticket_page_name;
            $newvalue = wp_insert_post( $post, false );
            
            eh_crm_update_settingsmeta(0, "support_reply_email", $email);
            if($ticket_id!="")
            {
                $wpdb->query("ALTER TABLE $table_name AUTO_INCREMENT = $ticket_id");
            }
            wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
            exit;
    }

    /**
     * Locale settings.
     */
    public function wsdesk_setup_fields() {
        ?>
                <div class="row" style="margin-top:15px;">
                    <div class="col-md-12">
                        <center>
                            <h2><?php _e('Configure your support form fields','wsdesk'); ?></h2>
                        </center>
                    </div>
                </div>
                <div class="tab-pane" id="ticket_fields_tab" style="display: block;">
                    <?php echo include(EH_CRM_MAIN_VIEWS."settings/crm_settings_fields.php"); ?>
                </div>
                <div class="row">
                    <div class="col-md-12" style="margin-left:15px;">
                        <small><?php _e('Save your changes before going to next step.','wsdesk'); ?></small>
                    </div>
                </div>
                <div class="row">
                        <div class="col-md-6 col-sm-offset-3">
                            <div class="alert alert-success" style="display: none" role="alert">
                                <div id="success_alert_text"></div>
                            </div>
                            <div class="alert alert-danger" style="display: none" role="alert">
                                <div id="danger_alert_text"></div>
                            </div>
                        </div>
                    <span class="crm-divider"></span>
                    <center>
                        <div  class="pull-right" style="margin-top: 15px;">
                            <p style="padding: 0px 20px;">
                                <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="btn btn-default"><?php esc_html_e( 'Skip this step', 'wsdesk' ); ?></a>
                                <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="btn btn-info"><?php esc_html_e( 'Continue', 'wsdesk' ); ?></a>
                            </p>
                        </div>
                    </center>
                </div>
        <?php
    }
        
    /**
     * Shipping and taxes.
     */
    public function wsdesk_setup_email() {
            ?>
                <div class="row" style="margin-top:15px;">
                    <div class="col-md-12">
                        <center>
                            <h2><?php _e('Configure your Email client to create tickets','wsdesk'); ?></h2>
                        </center>
                    </div>
                </div>
                <div class="tab-pane col-sm-offset-2 col-sm-8" id="imap_setup_tab" style="display: block;">
                        <?php echo include(EH_CRM_MAIN_VIEWS."email/crm_imap_setup.php"); ?>
                </div>
                <div class="row">
                        <div class="col-md-6 col-sm-offset-3">
                            <div class="alert alert-success" style="display: none" role="alert">
                                <div id="success_alert_text"></div>
                            </div>
                            <div class="alert alert-danger" style="display: none" role="alert">
                                <div id="danger_alert_text"></div>
                            </div>
                        </div>
                    <span class="crm-divider"></span>
                    <center>
                        <div class="pull-right" style="margin-top: 15px;">
                            <p style="padding: 0px 20px;">
                                <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="btn btn-default"><?php esc_html_e( 'Skip this step', 'wsdesk' ); ?></a>
                                <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="btn btn-info"><?php esc_html_e( 'Continue', 'wsdesk' ); ?></a>
                            </p>
                        </div>
                    </center>
                </div>
            <?php
    }
        
        public function wsdesk_setup_agents() {
            ?>
                <div class="row" style="margin-top:15px;">
                    <div class="col-md-12">
                        <center>
                            <h2><?php _e('Setup your support agents to handle tickets','wsdesk'); ?></h2>
                        </center>
                    </div>
                </div>
                <div class="tab-pane col-sm-12" style="display: block;">
                        <?php echo include(EH_CRM_MAIN_VIEWS."agents/crm_agents_main.php"); ?>
                </div>
                <div class="row">
                    <span class="crm-divider"></span>
                    <center>
                        <div  class="pull-right" style="margin-top: 15px;">
                            <p style="padding: 0px 20px;">
                                <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="btn btn-default"><?php esc_html_e( 'Skip this step', 'wsdesk' ); ?></a>
                                <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="btn btn-info"><?php esc_html_e( 'Continue', 'wsdesk' ); ?></a>
                            </p>
                        </div>
                    </center>
                </div>

            <?php
    }

        /**
     * Final step.
     */
    public function wsdesk_setup_ready() {
            $page = get_option("wsdesk_support_page");
            $support_url = get_permalink($page);
            ?>
            <div class="row" style="margin:20px 0px;">
                <div class="col-sm-12" style="background-color:#f5f5f5;padding: 10px;">
                    <div class="col-sm-3" style="text-align:center;">
                        <label><?php _e('Configure your Helpdesk','wsdesk'); ?></label><br>
                        <a class="btn btn-primary btn-lg" href="<?php echo esc_url( admin_url('admin.php?page=wsdesk_settings')); ?>"><?php esc_html_e( 'Go to Settings', 'wsdesk' ); ?></a>
                    </div>
                    <div class="col-sm-3" style="text-align:center;">
                        <label><?php _e('Get started with your first ticket','wsdesk'); ?></label><br>
                        <a class="btn btn-primary btn-lg" href="<?php echo esc_url( $support_url ); ?>"><?php esc_html_e( 'Create a ticket!', 'wsdesk' ); ?></a>
                    </div>
                    <div class="col-sm-6">
                        <ul>
                            <li style="font-size:15px;margin-bottom: 10px;"><span class="glyphicon glyphicon-link"></span> <a style="cursor:pointer;" href="https://elextensions.com/documentation/#wsdesk-wordpress-helpdesk-plugin" target="_blank"><?php esc_html_e( 'WSDesk Documentation', 'wsdesk' ); ?></a></li>
                            <li style="font-size:15px;margin-bottom: 10px;"><span class="glyphicon glyphicon-link"></span> <a style="cursor:pointer;" href="https://wsdesk.com/setting-up-google-oauth-for-wsdesk/" target="_blank"><?php esc_html_e( 'Read how to setup Google OAuth.', 'wsdesk' ); ?></a></li>
                            <li style="font-size:15px;margin-bottom: 10px;"><span class="glyphicon glyphicon-link"></span> <a style="cursor:pointer;" href="https://wsdesk.com/steps-to-import-tickets-from-zendesk/" target="_blank"><?php esc_html_e( 'How to import tickets from Zendesk?', 'wsdesk' ); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
    }
}

new WSDesk_Setup_Wizard();