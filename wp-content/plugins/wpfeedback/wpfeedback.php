<?php
/**
 * Plugin Name: WP Feedback
 * Plugin URI: https://wpfeedback.co/
 * Description: Client feedback in 1 click - WP Feedback
 *
 * Version: 1.0.6.1
 * Requires at least: 5.0
 *
 * Author: WP Feedback
 * Author URI: https://wpfeedback.co/
 *
 * Text Domain: wpfeedback
 * Domain Path: /languages/
 *
 * License: GPL-3.0-or-later
 *
 *
 * @author    WP Feedback <info@wpfeedback.co>
 * @copyright 2019 WP FeedBack
 * @license   GPL-3.0-or-later
 * @package   WP FeedBack
 */
/**
 * If this file is called directly, abort.
 **/
if (!defined('WPINC')) {
    die;
}

if (!defined('WPF_PLUGIN_NAME'))
    define('WPF_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('WPF_PLUGIN_DIR'))
    define('WPF_PLUGIN_DIR', plugin_dir_path(__FILE__));

if (!defined('WPF_PLUGIN_URL'))
    define('WPF_PLUGIN_URL', plugin_dir_url(__FILE__));

if (!defined('WPF_VERSION'))
    define('WPF_VERSION', '1.0.6.1');

if ( is_multisite() ) {
    $site_url =  network_site_url();
} else{
    $site_url =  site_url();
}

if (!defined('WPF_SITE_URL'))
    define('WPF_SITE_URL', $site_url);

// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
define('EDD_SL_STORE_URL', 'https://wpfeedback.co/'); // IMPORTANT: change the name of this constant to something unique to prevent conflicts with other plugins using this system
// the download ID. This is the ID of your product in EDD and should match the download ID visible in your Downloads list (see example below)
define('EDD_SL_ITEM_ID', 311); // IMPORTANT: change the name of this constant to something unique to prevent conflicts with other plugins using this system

if (!class_exists('EDD_SL_Plugin_Updater')) {
    // load our custom updater if it doesn't already exist
    include(dirname(__FILE__) . '/inc/EDD_SL_Plugin_Updater.php');
}

// retrieve our license key from the DB
$wpf_license_key = trim(get_option('wpf_license_key'));
// setup the updater
$edd_updater = new EDD_SL_Plugin_Updater(EDD_SL_STORE_URL, __FILE__, array(
    'version' => WPF_VERSION,        // current version number
    'license' => $wpf_license_key,    // license key (used get_option above to retrieve from DB)
    'item_id' => EDD_SL_ITEM_ID,    // id of this plugin
    'author' => 'Ace Digital London',    // author of this plugin
    'url' => WPF_SITE_URL,
    'beta' => false // set to true if you wish customers to receive update notifications of beta releases
));
//print_r($edd_updater); exit;
/*
* Register hooks that are fired when the plugin is activated or deactivated.
* When the plugin is deleted, the uninstall.php file is loaded.
*/
register_activation_hook( __FILE__, array( 'WP_Feedback', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WP_Feedback', 'deactivate' ) );

if (!function_exists('wpfeedback_post_type')) {

// Register Custom Post Type
    function wpfeedback_post_type()
    {

        $labels = array(
            'name' => _x('Wp feedback Types', 'Post Type General Name', 'wpfeedback'),
            'singular_name' => _x('Wp feedback Type', 'Post Type Singular Name', 'wpfeedback'),
            'menu_name' => __('WP feedBack', 'wpfeedback'),
            'name_admin_bar' => __('WP feedBack Type', 'wpfeedback'),
            'archives' => __('WP feedBack Item Archives', 'wpfeedback'),
            'attributes' => __('WP feedBack Item Attributes', 'wpfeedback'),
            'parent_item_colon' => __('WP feedBack Parent Item:', 'wpfeedback'),
            'all_items' => __('WP feedBack All Items', 'wpfeedback'),
            'add_new_item' => __('WP feedBack Add New Item', 'wpfeedback'),
            'add_new' => __('Add New WP feedBack', 'wpfeedback'),
            'new_item' => __('WP feedBack New Item', 'wpfeedback'),
            'edit_item' => __('WP feedBack Edit Item', 'wpfeedback'),
            'update_item' => __('WP feedBack Update Item', 'wpfeedback'),
            'view_item' => __('WP feedBack View Item', 'wpfeedback'),
            'view_items' => __('WP feedBack View Items', 'wpfeedback'),
            'search_items' => __('WP feedBack Search Item', 'wpfeedback'),
            'not_found' => __('Not found WP feedBack', 'wpfeedback'),
            'not_found_in_trash' => __('WP feedBack Not found in Trash', 'wpfeedback'),
            'featured_image' => __('WP feedBack Featured Image', 'wpfeedback'),
            'set_featured_image' => __('WP feedBack Set featured image', 'wpfeedback'),
            'remove_featured_image' => __('WP feedBack Remove featured image', 'wpfeedback'),
            'use_featured_image' => __('WP feedBack Use as featured image', 'wpfeedback'),
            'insert_into_item' => __('WP feedBack Insert into item', 'wpfeedback'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'wpfeedback'),
            'items_list' => __('WP feedBack Items list', 'wpfeedback'),
            'items_list_navigation' => __('WP feedBack Items list navigation', 'wpfeedback'),
            'filter_items_list' => __('WP feedBack Filter items list', 'wpfeedback'),
        );
        $args = array(
            'label' => __('Wp feedback Type', 'wpfeedback'),
            'description' => __('Post Type Description', 'wpfeedback'),
            'labels' => $labels,
            'supports' => array('title', 'editor', 'comments', 'author'),
            //'taxonomies'            => array( '', '' ),
            'hierarchical' => false,
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-editor-help',
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => false,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'capability_type' => 'page',
        );
        register_post_type('wpfeedback', $args);

    }

    add_action('init', 'wpfeedback_post_type', 0);

}


if (!function_exists('wp_feedback_task_status_taxonomy')) {

// Register Task status Custom Taxonomy
    function wp_feedback_task_status_taxonomy()
    {

        $labels = array(
            'name' => _x('Task status', 'Taxonomy General Name', 'wp_feedback'),
            'singular_name' => _x('Task status', 'Taxonomy Singular Name', 'wp_feedback'),
            'menu_name' => __('Task status', 'wp_feedback'),
            'all_items' => __('All Task status', 'wp_feedback'),
            'parent_item' => __('Parent Item', 'wp_feedback'),
            'parent_item_colon' => __('Parent Item:', 'wp_feedback'),
            'new_item_name' => __('New Task status', 'wp_feedback'),
            'add_new_item' => __('New Task status', 'wp_feedback'),
            'edit_item' => __('Edit Task status', 'wp_feedback'),
            'update_item' => __('Update Task status', 'wp_feedback'),
            'view_item' => __('View Task status', 'wp_feedback'),
            'separate_items_with_commas' => __('Separate items with commas', 'wp_feedback'),
            'add_or_remove_items' => __('Add or remove Task status', 'wp_feedback'),
            'choose_from_most_used' => __('Choose from the most used', 'wp_feedback'),
            'popular_items' => __('Popular Task status', 'wp_feedback'),
            'search_items' => __('Search Task status', 'wp_feedback'),
            'not_found' => __('Not Found Task status', 'wp_feedback'),
            'no_terms' => __('No Task status', 'wp_feedback'),
            'items_list' => __('Task status list', 'wp_feedback'),
            'items_list_navigation' => __('Task status list navigation', 'wp_feedback'),
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
        );
        register_taxonomy('task_status', array('wpfeedback'), $args);

    }

    add_action('init', 'wp_feedback_task_status_taxonomy', 0);

}


if (!function_exists('wp_feedback_task_priority_taxonomy')) {

// Register Task urgency Custom Taxonomy
    function wp_feedback_task_priority_taxonomy()
    {

        $labels = array(
            'name' => _x('Task urgency', 'Taxonomy General Name', 'wp_feedback'),
            'singular_name' => _x('Task urgency', 'Taxonomy Singular Name', 'wp_feedback'),
            'menu_name' => __('Task urgency', 'wp_feedback'),
            'all_items' => __('All Task urgency', 'wp_feedback'),
            'parent_item' => __('Parent Item', 'wp_feedback'),
            'parent_item_colon' => __('Parent Item:', 'wp_feedback'),
            'new_item_name' => __('New Task urgency', 'wp_feedback'),
            'add_new_item' => __('New Task urgency', 'wp_feedback'),
            'edit_item' => __('Edit Task urgency', 'wp_feedback'),
            'update_item' => __('Update Task urgency', 'wp_feedback'),
            'view_item' => __('View Task urgency', 'wp_feedback'),
            'separate_items_with_commas' => __('Separate items with commas', 'wp_feedback'),
            'add_or_remove_items' => __('Add or remove Task urgency', 'wp_feedback'),
            'choose_from_most_used' => __('Choose from the most used', 'wp_feedback'),
            'popular_items' => __('Popular Task urgency', 'wp_feedback'),
            'search_items' => __('Search Task urgency', 'wp_feedback'),
            'not_found' => __('Not Found Task urgency', 'wp_feedback'),
            'no_terms' => __('No Task urgency', 'wp_feedback'),
            'items_list' => __('Task urgency list', 'wp_feedback'),
            'items_list_navigation' => __('Task urgency list navigation', 'wp_feedback'),
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
        );
        register_taxonomy('task_priority', array('wpfeedback'), $args);

    }

    add_action('init', 'wp_feedback_task_priority_taxonomy', 0);

}

if (!function_exists('wp_feedback_register_task_priority_terms')) {
    function wp_feedback_register_task_priority_terms()
    {
        $taxonomy = 'task_priority';
        $terms = array(
            '0' => array(
                'name' => 'Low',
                'slug' => 'low',
                'description' => '',
            ),
            '1' => array(
                'name' => 'Medium',
                'slug' => 'medium',
                'description' => '',
            ),
            '2' => array(
                'name' => 'High',
                'slug' => 'high',
                'description' => '',
            ),
            '3' => array(
                'name' => 'Critical',
                'slug' => 'critical',
                'description' => '',
            ),
        );

        foreach ($terms as $term_key => $term) {
            if (!term_exists($term['name'], 'task_priority')) {
                wp_insert_term(
                    $term['name'],
                    $taxonomy,
                    array(
                        'description' => $term['description'],
                        'slug' => $term['slug'],
                    )
                );
            }
            //unset( $term ); 
        }

    }
}
add_action('init', 'wp_feedback_register_task_priority_terms', 0);


if (!function_exists('wp_feedback_register_task_status_terms')) {
    function wp_feedback_register_task_status_terms()
    {
        $taxonomy = 'task_status';
        $terms = array(
            '0' => array(
                'name' => 'Open',
                'slug' => 'open',
                'description' => '',
            ),
            '1' => array(
                'name' => 'In Progress',
                'slug' => 'in-progress',
                'description' => '',
            ),
            '2' => array(
                'name' => 'Pending Review',
                'slug' => 'pending-review',
                'description' => '',
            ),
            '3' => array(
                'name' => 'Complete',
                'slug' => 'complete',
                'description' => '',
            ),
        );

        foreach ($terms as $term_key => $term) {
            if (!term_exists($term['name'], 'task_status')) {
                wp_insert_term(
                    $term['name'],
                    $taxonomy,
                    array(
                        'description' => $term['description'],
                        'slug' => $term['slug'],
                    )
                );
            }
            //unset( $term ); 
        }

    }
}
add_action('init', 'wp_feedback_register_task_status_terms', 0);

/**
 * Create the admin menu.
 */
add_action('admin_menu', 'wp_feedback_admin_menu');
function wp_feedback_admin_menu()
{
    global $current_user;
    $wpf_powered_by = get_option('wpf_powered_by');
    $selected_roles = get_option('wpf_selcted_role');
    $selected_roles = explode(',', $selected_roles);

    if ( is_multisite() ) {
        $main_menu_id =  'wpfeedback_page_tasks'; 
    }
    else{
        $main_menu_id =  'wp_feedback'; 
    }

    if(in_array($current_user->roles[0], $selected_roles)){
        $wpf_user_type = wpf_user_type();
        $badge = '';
        if($wpf_powered_by=='yes'){
            $wpf_main_menu_label = 'Feedback';
        }
        else{
            $wpf_main_menu_label = 'WP Feedback';
        }
        add_menu_page(
            __($wpf_main_menu_label, 'wp_feedback'),
            __($wpf_main_menu_label, 'wp_feedback') . $badge,
            $main_menu_id,
            $main_menu_id,
            'read',
            WPF_PLUGIN_URL . 'images/wpf-favicon.png',
            80
        );
        add_submenu_page(
            $main_menu_id,
            __('Tasks Center', 'wp_feedback'),
            __('Tasks Center', 'wp_feedback'),
            'read',
            'wpfeedback_page_tasks',
            'wpfeedback_page_tasks'
        );
        if($wpf_user_type == 'advisor'){
            add_submenu_page(
                $main_menu_id,
                __('Settings', 'wp_feedback'),
                __('Settings', 'wp_feedback'),
                'read',
                'wpfeedback_page_settings',
                'wpfeedback_page_settings'
            );
        }
        if($wpf_user_type == 'advisor' || $wpf_user_type == 'king'){
            add_submenu_page(
                $main_menu_id,
                __('Integrations', 'wp_feedback'),
                __('Integrations', 'wp_feedback'),
                'read',
                'wpfeedback_page_integrate',
                'wpfeedback_page_integrate'
            );
        }
        if($wpf_user_type == 'advisor'){
            add_submenu_page(
                $main_menu_id,
                __('Support', 'wp_feedback'),
                __('Support', 'wp_feedback'),
                'read',
                'wpfeedback_page_support',
                'wpfeedback_page_support'
            );
            add_submenu_page(
                $main_menu_id,
                __('Upgrade', 'wp_feedback'),
                __('Upgrade', 'wp_feedback'),
                'read',
                'https://wpfeedback.co/#start'
            );
        }
    }    
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wpf_setting_action_links');
function wpf_setting_action_links($links)
{
    $links[] = '<a href="' . esc_url(get_admin_url(null, 'admin.php?page=wpfeedback_page_settings&wpf_setting=1')) . '">Settings</a>';
    return $links;
}

function wpfeedback_page_settings()
{
    global $current_user;
    $initial_setup = get_option("wpf_initial_setup");
    if($initial_setup != 'yes' ){
        require_once(WPF_PLUGIN_DIR . 'inc/admin/wpf_backend_initial_setup.php');
    }
    else{
        require_once(WPF_PLUGIN_DIR . 'inc/admin/page-settings.php');
    }
}

function wpfeedback_page_tasks()
{
    global $current_user;
    require_once(WPF_PLUGIN_DIR . 'inc/admin/page-settings.php');
}

function wpfeedback_page_integrate()
{
    global $current_user;
    require_once(WPF_PLUGIN_DIR . 'inc/admin/page-settings.php');
}

function wpfeedback_page_support(){
    global $current_user;
    require_once(WPF_PLUGIN_DIR . 'inc/admin/page-settings.php');
}

/*
* Require admin functionality
*/
require_once(WPF_PLUGIN_DIR . 'inc/wpf_function.php');
require_once(WPF_PLUGIN_DIR . 'inc/wpf_email_notifications.php');
require_once(WPF_PLUGIN_DIR . 'inc/wpf_admin_functions.php');
if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX)) {
    /*
     * Verify license
     */
    $wpf_license_key = get_option('wpf_license_key');

    $outputObject = wpf_license_key_license_item($wpf_license_key);
    if ($outputObject['license'] == 'valid') {
        update_option('wpf_license', $outputObject['license'],'no');
        update_option('wpf_license_expires', $outputObject['expires'],'no');
    } else {
        update_option('wpf_license', $outputObject['license'],'no');
    }
}

add_action('admin_enqueue_scripts', 'wpfeedback_add_stylesheet_to_admin');
function wpfeedback_add_stylesheet_to_admin()
{
    wp_register_style('wpf_admin_style', WPF_PLUGIN_URL . 'css/admin.css', false, WPF_VERSION);
    wp_enqueue_style('wpf_admin_style');

    wp_register_script('wpf_admin_script', WPF_PLUGIN_URL . 'js/admin.js', array('jquery'), WPF_VERSION, true);
    wp_enqueue_script('wpf_admin_script');

    wp_register_script('wpf_jscolor_script', WPF_PLUGIN_URL . 'js/jscolor.js', array('jquery'), WPF_VERSION, true);
    wp_enqueue_script('wpf_jscolor_script');

    wp_register_script('wpf_browser_info_script', WPF_PLUGIN_URL . 'js/wpf_browser_info.js', array('jquery'), WPF_VERSION, true);
    wp_enqueue_script('wpf_browser_info_script');

    wp_enqueue_media();
}

add_action('wp_enqueue_scripts', 'wpfeedback_add_stylesheet_frontend');
function wpfeedback_add_stylesheet_frontend()
{
    $wpf_check_page_builder_active = wpf_check_page_builder_active();
    $enabled_wpfeedback = wpf_check_if_enable();

    wp_register_style('wpf_admin_style', WPF_PLUGIN_URL . 'css/admin.css', false, WPF_VERSION);
    wp_enqueue_style('wpf_admin_style');

    if ($enabled_wpfeedback==1) {
        wp_register_style('wpf_wpfb-front_script', WPF_PLUGIN_URL . 'css/wpfb-front.css', false, WPF_VERSION);
        wp_enqueue_style('wpf_wpfb-front_script');

        wp_register_style('wpf_bootstrap_script', WPF_PLUGIN_URL . 'css/bootstrap.min.css', false, WPF_VERSION);
        wp_enqueue_style('wpf_bootstrap_script');
        if ($wpf_check_page_builder_active == 0) {
            wp_register_script('wpf_browser_info_script', WPF_PLUGIN_URL . 'js/wpf_browser_info.js', array('jquery'), WPF_VERSION, true);
            wp_enqueue_script('wpf_browser_info_script');

            wp_register_script('wpf_app_script', WPF_PLUGIN_URL . 'js/app.js', array('jquery'), WPF_VERSION, true);
            wp_enqueue_script('wpf_app_script');

            wp_register_script('wpf_html2canvas_script', WPF_PLUGIN_URL . 'js/html2canvas.js', array('jquery'), WPF_VERSION, true);
            wp_enqueue_script('wpf_html2canvas_script');

            wp_register_script('wpf_popper_script', WPF_PLUGIN_URL . 'js/popper.min.js', array('jquery'), WPF_VERSION, true);
            wp_enqueue_script('wpf_popper_script');

            wp_register_script('wpf_custompopover_script', WPF_PLUGIN_URL . 'js/custompopover.js', array('jquery'), WPF_VERSION, true);
            wp_enqueue_script('wpf_custompopover_script');

            wp_register_script('wpf_selectoroverlay_script', WPF_PLUGIN_URL . 'js/selectoroverlay.js', array('jquery'), WPF_VERSION, true);
            wp_enqueue_script('wpf_selectoroverlay_script');

            wp_register_script('wpf_xyposition_script', WPF_PLUGIN_URL . 'js/xyposition.js', array('jquery'), WPF_VERSION, true);
            wp_enqueue_script('wpf_xyposition_script');

            wp_register_script('wpf_bootstrap_script', WPF_PLUGIN_URL . 'js/bootstrap.min.js', array('jquery'), WPF_VERSION, true);
            wp_enqueue_script('wpf_bootstrap_script');

        }
    }
}

/*==========All Java script for Admin footer=========*/
add_action('admin_footer', 'wpf_media_selector_print_scripts');
function wpf_media_selector_print_scripts()
{
    global $wpdb,$post, $current_user; //for this example only :)
    $author_id = $current_user->ID;
    $my_saved_attachment_post_id = get_option('wpfeedback_logo_id', 0);
    $wpf_user_type = wpf_user_type();

    $currnet_user_information = wpf_get_current_user_information();
    $current_role = $currnet_user_information['role'];
    $current_user_name = $currnet_user_information['display_name'];
    $current_user_id = $currnet_user_information['user_id'];
    $wpf_website_builder = get_option('wpf_website_developer');
    if($current_user_name=='Guest'){
        $wpf_website_client = get_option('wpf_website_client');
        $wpf_current_role = 'guest';
        if($wpf_website_client){
            $wpf_website_client_info = get_userdata($wpf_website_client);
            if($wpf_website_client_info){
                if($wpf_website_client_info->display_name==''){
                    $current_user_name = $wpf_website_client_info->user_nicename;
                }
                else{
                    $current_user_name = $wpf_website_client_info->display_name;
                }
            }
        }

    }
    $current_user_name = addslashes($current_user_name);
    $wpf_show_front_stikers = get_option('wpf_show_front_stikers');

    $wpfb_users = do_shortcode('[wpf_user_list_front]');
    $wpf_all_pages = wpf_get_page_list();
    $ajax_url = admin_url('admin-ajax.php');
    $plugin_url = WPF_PLUGIN_URL;
    $wpf_comment_time = date( 'd-m-Y H:i', current_time( 'timestamp', 0 ) );

    $sound_file = esc_url(plugins_url('images/wpf-screenshot-sound.mp3', __FILE__));

//    Old logic to count latest task bubble number, was changed after the delete task feature was introduced
//    $comment_count_obj = wp_count_posts('wpfeedback');
//    $comment_count = $comment_count_obj->publish + 1;

    $table =  $wpdb->prefix . 'postmeta';
    $latest_count = $wpdb->get_results("SELECT meta_value FROM $table WHERE meta_key = 'task_comment_id' ORDER BY meta_id DESC LIMIT 1 ");
    $comment_count = $latest_count[0]->meta_value + 1;

    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    echo "<script>var wpf_comment_time='$wpf_comment_time',wpf_all_pages ='$wpf_all_pages' ,ipaddress='$ipaddress', current_role='$current_role', wpf_current_role='$wpf_user_type', current_user_name='$current_user_name', current_user_id='$current_user_id', wpf_website_builder='$wpf_website_builder', wpfb_users = '$wpfb_users',  ajaxurl = '$ajax_url', wpf_screenshot_sound = '$sound_file', plugin_url = '$plugin_url', comment_count='$comment_count', wpf_show_front_stikers='$wpf_show_front_stikers';</script>";
    if (isset($_REQUEST['page'])) {
        if ($_REQUEST['page'] == 'wpfeedback_page_settings' || $_REQUEST['page'] == 'wpfeedback_page_tasks' || $_REQUEST['page'] == 'wpfeedback_page_integrate' || $_REQUEST['page'] == 'wpfeedback_page_upgrade' || $_REQUEST['page'] == 'wpfeedback_page_support') {
            ?>
            <script type='text/javascript'>
                var current_task = 0;
                var current_user_id = "<?php echo $author_id; ?>";
                var wpf_user_type = "<?php echo $wpf_user_type; ?>";

                function getParameterByName(name) {
                    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
                    var regexS = "[\\?&]" + name + "=([^&#]*)";
                    var regex = new RegExp(regexS);
                    var results = regex.exec(window.location.href);
                    if (results == null)
                        return "";
                    else
                        return decodeURIComponent(results[1].replace(/\+/g, " "));
                }

                /*
                * wpf Add ons tab code
                */
                function wpf_add_ons_form(val) {
                    alert(val);
                    if (val) {
                        jQuery.ajax({
                            method: "POST",
                            url: ajaxurl,
                            data: {action: "wpf_notify_admin_add_ons_func", add_ons: val},
                            success: function (data) {
                                //jQuery("#tag_post").remove();
                                alert(data);
                            }
                        });
                    }

                }

                /*
                * wpf task filter code
                */
                function wp_feedback_cat_filter() {
                    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
                    var task_status = [];
                    jQuery.each(jQuery("#wpf_filter_form input[name='task_status']:checked"), function () {
                        task_status.push(jQuery(this).val());
                    });
                    //alert("My task status are: " + task_status.join(","));
                    var selected_task_status_values = task_status.join(",");

                    var task_priority = [];
                    jQuery.each(jQuery("#wpf_filter_form input[name='task_priority']:checked"), function () {
                        task_priority.push(jQuery(this).val());
                    });
                    // alert("My task urgency are: " + task_priority.join(","));
                    var selected_task_priority_values = task_priority.join(",");

                    var author_list = [];
                    jQuery.each(jQuery("#wpf_filter_form input[name='author_list']:checked"), function () {
                        author_list.push(jQuery(this).val());
                    });
                    // alert("My task urgency are: " + task_priority.join(","));
                    var selected_author_list_values = author_list.join(",");
                    //if(selected_task_status_values || selected_task_priority_values || selected_author_list_values){
                    jQuery.ajax({
                        method: "POST",
                        url: ajaxurl,
                        data: {
                            action: "wpfeedback_get_post_list_ajax",
                            task_status: selected_task_status_values,
                            task_priority: selected_task_priority_values,
                            author_list: selected_author_list_values
                        },
                        beforeSend: function () {
                            jQuery('.wpf_loader_admin').show();
                        },
                        success: function (data) {
                            //Comment
                            jQuery('.wpf_loader_admin').hide();
                            jQuery('#all_wpf_list').html(data);
                            /*console.log(data);*/
                        }
                    });
                    // }
                }

                function get_wpf_message_form(comment_post_ID, curren_user_id) {
                    var html = '<div id="wpf_chat_box"><form action="" method="post" id="wpf_form" class="comment-form" enctype="multipart/form-data"><p class="comment-form-comment"><textarea placeholder="Write your Message" id="wpf_comment" name="comment" maxlength="65525" required="required"></textarea><input type="hidden" name="comment_post_ID" value="' + comment_post_ID + '" id="comment_post_ID">  <input type="hidden" name="curren_user_id" value="' + curren_user_id + '" id="curren_user_id"><p class="form-submit chat_button"><input name="submit" type="button" id="send_chat" onclick="send_chat_message()" class="submit wpf_button submit" value="Send message"><a href="javascript:void(0)" class="wpf_upload_button wpf_button" onchange="wpf_upload_file_admin('+comment_post_ID+');"><input type="file" name="wpf_uploadfile" id="wpf_uploadfile" data-elemid="'+comment_post_ID+'" class="wpf_uploadfile"><i class="fa fa-upload" aria-hidden="true"></i></a></p><p id="wpf_upload_error" class="wpf_hide">You are trying to upload an invalid filetype <br> Allowd File Types: JPG, PNG, GIF, PDF, DOC, DOCX and XLSX</p></form></div></div>';
                    return html;
                }
                function send_chat_message() {
                    jQuery("#get_masg_loader").show();
                    jQuery(".get_masg_loader").show();
                    var wpf_comment = jQuery('#wpf_comment').val();
                    var post_id = jQuery('#comment_post_ID').val();
                    var author_id = "<?php echo $author_id; ?>";
                    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
                    if (jQuery('#wpf_comment').val().trim().length > 0) {
                        jQuery.ajax({
                            method: "POST",
                            url: ajaxurl,
                            data: {
                                action: "insert_wpf_comment_func",
                                post_id: post_id,
                                author_id: author_id,
                                wpf_comment: wpf_comment
                            },
                            beforeSend: function () {
                                jQuery('.wpf_loader_admin').show();
                            },
                            success: function (data) {
                                jQuery('.wpf_loader_admin').hide();
                                jQuery("#wpf_not_found").remove();
                                //jQuery("#tag_post").remove();
                                jQuery("#tag_post").html('');
                                if (jQuery('#wpf_message_list li').length == 0) {
                                    jQuery('ul#wpf_message_list').html(data);
                                } else {
                                    jQuery('ul#wpf_message_list li:last').after(data);
                                }
                                jQuery("#wpf_comment").val("");
                                jQuery("#addcart_loader").fadeOut();
                                jQuery("#get_masg_loader").hide();
                                jQuery(".get_masg_loader").hide();
                                jQuery('#wpf_message_content').animate({scrollTop: jQuery('#wpf_message_content').prop("scrollHeight")}, 2000);
                            }
                        })
                    } else {
                        jQuery("#get_masg_loader").hide();
                        jQuery('ul#wpf_message_list').animate({scrollTop: jQuery("ul#wpf_message_list li").last().offset().top}, 1000);
                        jQuery("#wpf_comment").focus();
                        jQuery("#get_masg_loader").hide();
                    }
                }

                function task_status_changed(sel) {
                    // alert(sel.value);
                    var task_info = [];
                    var task_notify_users = [];

                    jQuery.each(jQuery('#wpf_attributes_content input[name="author_list"]:checked'), function () {
                        task_notify_users.push(jQuery(this).val());
                    });
                    task_notify_users = task_notify_users.join(",");

                    task_info['task_id'] = current_task;
                    task_info['task_status'] = sel.value;
                    task_info['task_notify_users'] = task_notify_users;

                    var task_info_obj = jQuery.extend({}, task_info);
                    jQuery.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        type: 'POST',
                        data: {action: "wpfb_set_task_status", task_info: task_info_obj},
                        beforeSend: function () {
                            jQuery('.wpf_loader_admin').show();
                        },
                        success: function (data) {
                            // alert(data);wpf_get_page_list
                            jQuery('.wpf_loader_admin').hide();
                            jQuery('#wpf-task-' + current_task).data('task_status', sel.value);
                        }
                    });
                }

                function task_priority_changed(sel) {
                    // alert(sel.value);
                    var task_info = [];
                    var task_priority = sel.value;


                    task_info['task_id'] = current_task;
                    task_info['task_priority'] = task_priority;

                    var task_info_obj = jQuery.extend({}, task_info);
                    jQuery.ajax({
                        method: "POST",
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        data: {action: "wpfb_set_task_priority", task_info: task_info_obj},
                        beforeSend: function () {
                            jQuery('.wpf_loader_admin').show();
                        },
                        success: function (data) {
                            // alert(data);
                            jQuery('.wpf_loader_admin').hide();
                            jQuery('#wpf-task-' + current_task).data('task_priority', sel.value);
                        }
                    });
                }

                function update_notify_user(user_id) {
                    var task_info = [];
                    var task_notify_users = [];

                    jQuery.each(jQuery('#wpf_attributes_content input[name="author_list_task"]:checked'), function () {
                        task_notify_users.push(jQuery(this).val());
                    });
                    task_notify_users = task_notify_users.join(",");

                    task_info['task_id'] = current_task;
                    task_info['task_notify_users'] = task_notify_users;

                    var task_info_obj = jQuery.extend({}, task_info);

                    jQuery.ajax({
                        method: "POST",
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        data: {action: "wpfb_set_task_notify_users", task_info: task_info_obj},
                        beforeSend: function () {
                            jQuery('.wpf_loader_admin').show();
                        },
                        success: function (data) {
                            // alert(data);
                            jQuery('.wpf_loader_admin').hide();
                            jQuery('#wpf-task-' + current_task).data('task_notify_users', task_notify_users);
                        }
                    });
                }

                function send_image_chat_message() {
                    jQuery("#chat_file").unbind().change(function () {
                        jQuery("#get_masg_loader").show();
                        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
                        var wpf_comment = '';
                        var post_id = jQuery('#comment_post_ID').val();
                        var author_id = current_user_id;
                        if (post_id != null) {
                            jQuery.ajax({
                                method: "POST",
                                url: ajaxurl,
                                data: {
                                    action: "insert_null_wpf_comment_func",
                                    post_id: post_id,
                                    author_id: author_id,
                                    wpf_comment: wpf_comment
                                },
                                success: function (data) {
                                    //alert(data);
                                    //jQuery("ul#wpf_message_list li:last").append(data);
                                    jQuery("#wpf_comment").val("");
                                    jQuery("#addcart_loader").fadeOut();
                                    var comment_id = data;
                                    var fd = new FormData();
                                    var file = jQuery(document).find('input[type="file"]');
                                    var caption = jQuery(this).find('input[name=chat_file]');
                                    //var individual_file = file[0].files[0];
                                    var individual_file = jQuery('#chat_file')[0].files[0];
                                    fd.append("comment_id", comment_id);
                                    fd.append("author_id", author_id);
                                    fd.append("file", individual_file);
                                    var individual_capt = caption.val();
                                    fd.append("caption", individual_capt);
                                    fd.append('action', 'insert_wpf_comment_img_func');
                                    jQuery.ajax({
                                        type: 'POST',
                                        url: ajaxurl,
                                        data: fd,
                                        contentType: false,
                                        processData: false,
                                        success: function (response) {
                                            jQuery("input[name=chat_file]").val('');
                                            var image_url = response;
                                            if (jQuery('ul#wpf_message_list li').length == 0) {
                                                jQuery('ul#wpf_message_list').html(response);
                                            } else {
                                                jQuery('ul#wpf_message_list li:last').after(response);
                                            }
                                            //console.log(image_url);
                                            jQuery("#get_masg_loader").hide();
                                            jQuery('ul#wpf_message_list').animate({scrollTop: jQuery("ul#wpf_message_list li").last().offset().top}, 1000);
                                        }
                                    });
                                }
                            })
                        } else {
                            alert('error');
                        }
                    });
                }

                //get chat based on WPF post select
                function get_wpf_chat(obj, tg) {
                    var post_id = jQuery(obj).data("postid");
                    if (tg === undefined) {
                        tg = false;
                    }
                    jQuery("ul#all_wpf_list li.wpf_list").removeClass('active');
                    jQuery(obj).parent().addClass('active');
                    //alert(jQuery(obj).data("postid"));
                    //var post_author_id = <?php echo $author_id; ?>;
                    var post_author_id = jQuery(obj).data('uid');
                    var post_task_type = jQuery(obj).data('task_type');
                    var post_task_no = jQuery(obj).data("task_no");
                    var task_status = jQuery(obj).data("task_status");
                    var task_page_url = jQuery(obj).data("task_page_url");
                    var task_page_title = jQuery(obj).data("task_page_title");
                    var task_config_author_name = jQuery(obj).data("task_config_author_name");
                    var task_author_name = jQuery(obj).data("task_author_name");


                    var task_config_author_res = jQuery(obj).data("task_config_author_res");
                    var task_config_author_browser = jQuery(obj).data("task_config_author_browser");
                    var task_config_author_browserversion = jQuery(obj).data("task_config_author_browserversion");
                    var task_config_author_ipaddress = jQuery(obj).data("task_config_author_ipaddress");
                    var task_config_author_name = jQuery(obj).data("task_config_author_name");
                    var task_notify_users = jQuery(obj).data("task_notify_users");

                    var task_priority = jQuery(obj).data("task_priority");
                    var click = 'yes';
                    var additional_info_html = '<p>Screen-size: ' + task_config_author_res + '</p><p>Browser: ' + task_config_author_browser + ' ' + task_config_author_browserversion + '</p><p>Created by: ' + task_author_name + '</p><p>User IP: ' + task_config_author_ipaddress + '</p><p>Task ID: ' + post_id + '</p>';
                    jQuery.ajax({
                        method: "POST",
                        url: ajaxurl,
                        data: {
                            action: "list_wpf_comment_func",
                            post_id: post_id,
                            post_author_id: post_author_id,
                            click: click
                        },
                        beforeSend: function () {
                            jQuery('.wpf_loader_admin').show();
                        },
                        success: function (data) {
                            current_task = post_id;
                            jQuery('.wpf_loader_admin').hide();
                            jQuery("#wpf_not_found").remove();
                            // console.log(task_status);
                            jQuery("#get_masg_loader").hide();
                            jQuery("div#wpf_task_details .wpf_task_num_top").html(post_task_no);
                            jQuery("div#wpf_task_details .wpf_task_title_top").html(task_page_title);
                            jQuery("div#wpf_task_details .wpf_task_details_top").html(task_config_author_name);
                            jQuery("div#wpf_attributes_content #additional_information").html(additional_info_html);
                            //jQuery('#wpf_delete_task_container').html('<a href="javascript:void(0)" target="_blank" class="wpf_task_delete_btn"><i class="fa fa-trash-alt"></i> Delete Task</a><p class="wpf_hide" id="wpf_task_delete">Are you sure you want to delete? <a href="javascript:void(0);" class="wpf_task_delete" data-taskid='+ post_id +' data-elemid='+post_task_no+'>Yes</a></p>');
                            if(current_user_id == post_author_id || wpf_user_type == 'advisor'){
                                jQuery('#wpf_delete_task_container').html('<a href="javascript:void(0)" target="_blank" class="wpf_task_delete_btn"><i class="fa fa-trash-alt"></i> Delete Task</a><p class="wpf_hide" id="wpf_task_delete">Are you sure you want to delete? <a href="javascript:void(0);" class="wpf_task_delete" data-taskid='+ post_id +' data-elemid='+post_task_no+'>Yes</a></p>');
                            }else{
                                jQuery('#wpf_delete_task_container').html('');
                            }

                            jQuery("#task_task_status_attr").val(task_status);
                            jQuery("#task_task_priority_attr").val(task_priority);
                            if(post_task_type == 'general'){
                                 jQuery("#wpfb_attr_task_page_link").attr("href", task_page_url+"?wpf_general_taskid="+post_id);
                            }else{
                                jQuery("#wpfb_attr_task_page_link").attr("href", task_page_url+"?wpf_taskid="+post_task_no);
                            }
                            

                            if(typeof task_notify_users=='string'){
                                var task_notify_users_arr = task_notify_users.split(',');
                            }
                            else{
                                var task_notify_users_arr = [task_notify_users.toString()];
                            }
                            jQuery('#wpf_attributes_content input[name="author_list_task"]').each(function () {
                                jQuery(this).prop('checked', false);
                            });
                            jQuery('#wpf_attributes_content input[name="author_list_task"]').each(function () {
                                if (jQuery.inArray(this.value, task_notify_users_arr) != '-1') {
                                    jQuery(this).prop('checked', true);
                                }
                            });

                            chat_form = get_wpf_message_form(post_id, post_author_id);
                            jQuery('#wpf_message_form').html(chat_form);
                            if (data == 0) {
                                chat_form = get_wpf_message_form(post_id, post_author_id);
                                jQuery('#wpf_message_form').html(chat_form);
                            } else {
                                var chat_form = get_wpf_message_form(post_id, post_author_id);
                                jQuery('#wpf_message_form').html(chat_form);
                                jQuery('ul#wpf_message_list').html(data);
                            }
                            jQuery('#wpf_message_content').animate({scrollTop: jQuery('#wpf_message_content').prop("scrollHeight")}, 2000);
                        }
                    });
                }

                jQuery(document).ready(function ($) {
                    var wpfeedback_page = getParameterByName('page');
                    if (wpfeedback_page == "wpfeedback_page_tasks") {
                        jQuery("button.wpf_tab_item.wpf_tasks").trigger('click');
                    }
                    if (wpfeedback_page == "wpfeedback_page_settings") {
                        jQuery("button.wpf_tab_item.wpf_settings").trigger('click');
                    }
                    if (wpfeedback_page == "wpfeedback_page_integrate") {
                        jQuery("button.wpf_tab_item.wpf_addons").trigger('click');
                    }
                    if (wpfeedback_page == "wpfeedback_page_support") {
                        jQuery("button.wpf_tab_item.wpf_support").trigger('click');
                    }

                    // Uploading files
                    var file_frame;
                    if(wp.media!=undefined){
                        var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
                        var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this
                        jQuery('#upload_image_button').on('click', function (event) {
                            event.preventDefault();
                            // If the media frame already exists, reopen it.
                            if (file_frame) {
                                // Set the post ID to what we want
                                file_frame.uploader.uploader.param('post_id', set_to_post_id);
                                // Open frame
                                file_frame.open();
                                return;
                            } else {
                                // Set the wp.media post id so the uploader grabs the ID we want when initialised
                                wp.media.model.settings.post.id = set_to_post_id;
                            }
                            // Create the media frame.
                            file_frame = wp.media.frames.file_frame = wp.media({
                                title: 'Select a image to upload',
                                button: {
                                    text: 'Use this image',
                                },
                                multiple: false	// Set to true to allow multiple files to be selected
                            });
                            // When an image is selected, run a callback.
                            file_frame.on('select', function () {
                                // We set multiple to false so only get one image from the uploader
                                attachment = file_frame.state().get('selection').first().toJSON();
                                // Do something with attachment.id and/or attachment.url here
                                $('#image-preview').attr('src', attachment.url).css('width', 'auto');
                                $('#image_attachment_id').val(attachment.id);
                                // Restore the main post ID
                                wp.media.model.settings.post.id = wp_media_post_id;
                            });
                            // Finally, open the modal
                            file_frame.open();
                        });
                        // Restore the main ID when the add media button is pressed
                        jQuery('a.add_media').on('click', function () {
                            wp.media.model.settings.post.id = wp_media_post_id;
                        });
                    }
                });
            </script>
        <?php }
    }
}

function show_wpf_comment_button()
{
    global $wpdb;
    $currnet_user_information = wpf_get_current_user_information();
    $current_role = $currnet_user_information['role'];
    $current_user_name = $currnet_user_information['display_name'];
    $current_user_id = $currnet_user_information['user_id'];
    $wpf_website_builder = get_option('wpf_website_developer');
    if($current_user_name=='Guest'){
        $wpf_website_client = get_option('wpf_website_client');
        $wpf_current_role = 'guest';
        if($wpf_website_client){
            $wpf_website_client_info = get_userdata($wpf_website_client);
            if($wpf_website_client_info){
                if($wpf_website_client_info->display_name==''){
                    $current_user_name = $wpf_website_client_info->user_nicename;
                }
                else{
                    $current_user_name = $wpf_website_client_info->display_name;
                }
            }
        }

    }
    else{
        $wpf_current_role = get_user_meta($current_user_id,'wpf_user_type',true);
    }
    $current_user_name = addslashes($current_user_name);
    $current_page_url = get_permalink();
    $current_page_title = get_the_title();
    $current_page_id = get_the_id();

    $wpf_show_front_stikers = get_option('wpf_show_front_stikers');

    $wpfb_users = do_shortcode('[wpf_user_list_front]');
    $ajax_url = admin_url('admin-ajax.php');
    $plugin_url = WPF_PLUGIN_URL;

    $sound_file = esc_url(plugins_url('images/wpf-screenshot-sound.mp3', __FILE__));

//    Old logic to count latest task bubble number, was changed after the delete task feature was introduced
//    $comment_count_obj = wp_count_posts('wpfeedback');
//    $comment_count = $comment_count_obj->publish + 1;

    $table =  $wpdb->prefix . 'postmeta';
    $latest_count = $wpdb->get_results("SELECT meta_value FROM $table WHERE meta_key = 'task_comment_id' ORDER BY meta_id DESC LIMIT 1 ");
    /*$comment_count = $latest_count[0]->meta_value + 1;*/
    if($latest_count){
        $comment_count = $latest_count[0]->meta_value + 1; 
    }else{
        $comment_count = 1; 
    }

    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    $wpf_powered_class = '';
    $wpf_powered_by = get_option('wpf_powered_by');
    $enabled_wpfeedback = get_option('wpf_enabled');
    $selected_roles = get_option('wpf_selcted_role');
    $selected_roles = explode(',', $selected_roles);
    if ($wpf_powered_by == 'yes') {
        $wpf_powered_class = 'hide';
    }
    $wpf_check_page_builder_active = wpf_check_page_builder_active();
    $wpf_active = wpf_check_if_enable();
    if($current_user_id>0){
        $wpf_daily_report = get_option('wpf_daily_report');
        $wpf_weekly_report = get_option('wpf_weekly_report');
        $wpf_go_to_dashboard_btn = '<div class="wpf_sidebar_dashboard"><a href="'.admin_url().'admin.php?page=wpfeedback_page_tasks" target="_blank">Go to the Dashboard <i class="fa fa-columns"></i></a></div>';
        $wpf_go_to_dashboard_btn.='<div class="wpf_report_trigger">';
        if($wpf_daily_report=='yes'){
            $wpf_go_to_dashboard_btn.='<a href="javascript:wpf_send_report(\'daily_report\')"><i class="fa fa-envelope"></i> Daily Report</a>';
        }
        if($wpf_weekly_report=='yes'){
            $wpf_go_to_dashboard_btn.='<a href="javascript:wpf_send_report(\'weekly_report\')"><i class="fa fa-envelope"></i> Weekly Report</a>';
        }
        $wpf_go_to_dashboard_btn.='<span id="wpf_front_report_sent_span" class="wpf_hide text-success">Your report was sent</span></div>';
    }
    else{
        $wpf_go_to_dashboard_btn = '';
    }

    if ( $wpf_active == 1 && $wpf_check_page_builder_active == 0 ){
        echo "<script>var ipaddress='$ipaddress', current_role='$current_role', wpf_current_role='$wpf_current_role', current_user_name='$current_user_name', current_user_id='$current_user_id', wpf_website_builder='$wpf_website_builder', wpfb_users = '$wpfb_users',  ajaxurl = '$ajax_url', current_page_url = '$current_page_url', current_page_title = '$current_page_title', current_page_id = '$current_page_id', wpf_screenshot_sound = '$sound_file', plugin_url = '$plugin_url', comment_count='$comment_count', wpf_show_front_stikers='$wpf_show_front_stikers';</script>";
        echo '<div id="wpf_already_comment" class="wpf_hide"><p class="wpf_btn">Task already exist for this element</p></div><div id="wpf_launcher" data-html2canvas-ignore="true" ><div class="wpf_launch_buttons"><div class="wpf_start_comment"><a href="javascript:enable_comment();" title="Click to give your feedback!" data-placement="left" class="comment_btn"><i class="fa fa-plus"></i></a></div>
        <div class="wpf_expand"><a href="javascript:expand_sidebar()" id="wpf_expand_btn"><img alt="" src="'.WPF_PLUGIN_URL.'images/wpficon.png" class="wpf_none_comment"/></a></div></div>
        <div class="wpf_sidebar_container" style="opacity: 0; margin-right: -300px";>
        <div class="wpf_sidebar_header">
        <!-- =================Top Tabs================-->
        <button class="wpf_tab_sidebar wpf_thispage wpf_active" onclick="openWPFTab(\'wpf_thispage\')" >On This Page</button>
        <button class="wpf_tab_sidebar wpf_allpages"  onclick="openWPFTab(\'wpf_allpages\')" >All Pages</button>
        </div>
        
        <div class="wpf_sidebar_content">
        <div class="wpf_sidebar_loader wpf_hide"></div>
        <div id="wpf_thispage" class="wpf_thispage_tab wpf_container"><ul id="wpf_thispage_container"></ul></div>
        <div id="wpf_allpages" class="wpf_allpages_tab wpf_container" style="display:none";><ul id="wpf_allpages_container"></ul></div>
        </div>
        <div class="wpf_sidebar_options">
		<div class="wpf_sidebar_generaltask"><a href="javascript:void(0)" onclick="wpf_new_general_task(0)"><i class="fa fa-plus-square"></i> General Task</a></div>
        <div class="wpf_sidebar_checkboxes"><input type="checkbox" name="wpfb_display_tasks" id="wpfb_display_tasks" /> <label for="wpfb_display_tasks">Show Tasks</label></div>
		<div class="wpf_sidebar_checkboxes"><input type="checkbox" name="wpfb_display_completed_tasks" id="wpfb_display_completed_tasks" /> <label for="wpfb_display_completed_tasks">Show Completed</label></div>
        '.$wpf_go_to_dashboard_btn.'
        </div>
        <div class="wpf_sidebar_footer ' . $wpf_powered_class . '"><a href="https://wpfeedback.co/powered" target="_blank">Powered by <img alt="" src="'.WPF_PLUGIN_URL.'images/WPFeedback-icon.png" /> <span>WPFeedback</span></a></div>
        </div>
        </div>
        <div id="wpf_enable_comment" class="wpf_hide"><p>Commenting enabled</p><a class="wpf_comment_mode_general_task" id="wpf_comment_mode_general_task" href="javascript:void(0)" onclick="wpf_new_general_task(0)"><i class="fa fa-plus-square"></i> General Task</a><a href="javascript:disable_comment();" id="disable_comment_a">Cancel</a></div>';
        $wpf_get_user_type =esc_attr( get_the_author_meta( 'wpf_user_initial_setup', $current_user_id ) );
        if($wpf_get_user_type == '' && $current_user_id && in_array($current_role, $selected_roles)){
            require_once(WPF_PLUGIN_DIR . 'inc/frontend/wpf_frontend_initial_setup.php');
        }
        require_once(WPF_PLUGIN_DIR . 'inc/frontend/wpf_general_task_modal.php');
    }
}

add_action('wp_footer', 'show_wpf_comment_button');

// Remove wpfeedback CPT page in menu
function wpf_disable_comments_admin_menu()
{
    remove_menu_page('edit.php?post_type=wpfeedback');
}

add_action('admin_menu', 'wpf_disable_comments_admin_menu');

/* Remove 'wpfeedback' comment type in admin side*/
add_action('pre_get_comments', 'wpf_exclude_comments');
function wpf_exclude_comments($query)
{
    if ($query->query_vars['type'] !== 'wp_feedback') {
        $query->query_vars['type__not_in'] = array_merge((array)$query->query_vars['type__not_in'], array('wp_feedback'));
    }
}

add_action( 'admin_head', 'wpf_upgrade_menu_page_redirect' );
function wpf_upgrade_menu_page_redirect() {
    $wpf_license = get_option('wpf_license');
    $wpf_user_type = wpf_user_type();
    if($wpf_license !='valid'){
    ?>
    <style type="text/css">
        div#wpf_tasks {
        position: relative;
        }
        div#wpf_tasks:before {
        position: absolute;
        width: 100%;
        background-color: rgba(255, 255, 255, 0.85);
        height: 100%;
        left: 0;
        content: "Please click on the Settings tab and verify your license to start using the plugin";
        padding-top: 15%;
        text-align: center;
        font-size: 30px;
        color: var(--main-wpf-color);
        font-weight: 700;
        text-decoration: none;
        font-family: 'Exo', sans-serif;
        }
    </style>
<?php } if($wpf_user_type == 'advisor'){?>
    <script type="text/javascript">
        jQuery(document).ready( function($) {   
            jQuery('#toplevel_page_wp_feedback ul li').last().find('a').attr('target','_blank');  
        });
    </script>
    <?php }
}
require_once(WPF_PLUGIN_DIR . 'inc/wpf_class.php');
function wpf_activation_redirect( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        $url = admin_url( 'admin.php?page=wpfeedback_page_settings' );
        wp_redirect( $url );
        exit;
    }
}
add_action( 'activated_plugin', 'wpf_activation_redirect', 10, 1 );
function wpf_check_page_builder_active(){
    $page_builder = 0;
    /*========Check Divi editor Active========*/
    if ( isset($_GET['et_fb']) ) {
        $page_builder = 1;
    }
    /*------Check wpbeaver editor Active-------*/
    else if (class_exists('FLBuilderModel') && FLBuilderModel::is_builder_active() ) {
        $page_builder = 1;
    }
    /*========Check brizy editor Active========*/
    else if( isset( $_GET['brizy-edit'] ) || isset( $_GET['brizy-edit-iframe'] )  || isset( $_GET['brizy_post'] ) ){
        $page_builder = 1;
    }
    /*=======Check oxygen editor Active========*/
    else if ( isset($_GET['ct_builder']) || isset($_GET['ct_template']) ) {
        $page_builder = 1;
    }
    /*=======Check Cornerstone editor Active========*/
    else if ( isset($_POST['cs_preview_state']) ) {
        $page_builder = 1;
    }
    /*------Check Visual Composer Active========*/
    else if( isset($_GET['vc_editable'])){
        $page_builder =1;
    }
    /*------Check elementor editor Active========*/
    else if ( defined( 'ELEMENTOR_VERSION' )) {
        if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
            $page_builder =1;
        }
        else{
            $page_builder =0;
        }
    }
    else {
        $page_builder = 0;
    }
    return $page_builder;
}