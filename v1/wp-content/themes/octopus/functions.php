<?php

// Get Bones Core Up & Running!
require_once('library/bones.php');            // core functions (don't remove)
require_once('library/custom-post-type.php'); // custom post type example
require_once('library/launch-checklist.php'); // the launch checklist
require_once('library/wp-bootstrap-navwalker.php');

/***************
  SCRIPTS
***************/

add_action('wp_enqueue_scripts', 'plugin_head_styles_scripts');
function plugin_head_styles_scripts() {

  // Global stylesheets -->
  
  
  wp_enqueue_style( 'icons-stylesheet', get_template_directory_uri() . '/library/assets/css/icons/icomoon/styles.css', array(), '1.0.0' );

  wp_enqueue_style( 'bootstrap-stylesheet', get_template_directory_uri() . '/library/assets/css/bootstrap.css', array(), '1.0.0' );
  wp_enqueue_style( 'core-stylesheet', get_template_directory_uri() . '/library/assets/css/core.css', array(), '1.0.0' );
  wp_enqueue_style( 'components-stylesheet', get_template_directory_uri() . '/library/assets/css/components.css', array(), '1.0.0' );
  wp_enqueue_style( 'colours-stylesheet', get_template_directory_uri() . '/library/assets/css/colors.css', array(), '1.0.0' );
  wp_enqueue_style( 'dropdown-stylesheet', get_template_directory_uri() . '/library/assets/css/drop-menu.css', array(), '1.0.0' );
  wp_enqueue_style( 'font-stylesheet', get_template_directory_uri() . '/library/assets/css/icons/fontawesome/styles.min.css', array(), '1.0.0' );
  wp_enqueue_style( 'font-awesome-v5', 'https://use.fontawesome.com/releases/v5.2.0/css/all.css', array(), '1.0.0' );
  //wp_enqueue_style( 'font-awesome-v4-shims', 'https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css', array(), '1.0.0' );
  wp_enqueue_style( 'font-awesome-stylesheet', 'https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css', array(), '1.0.0' );
  wp_enqueue_style( 'bootstrap-stylesheet', get_template_directory_uri() . '/library/assets/css/bootstrap.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'scroll-stylesheet', get_template_directory_uri() . '/library/assets/css/scroll.css', array(), '1.0.0' );
  wp_enqueue_style( 'maps-stylesheet', get_template_directory_uri() . '/library/assets/css/maps.css', array(), '1.0.0' );
  wp_enqueue_style( 'toggles-stylesheet', get_template_directory_uri() . '/library/assets/css/toggle-buttons.css', array(), '1.0.0' );
  wp_enqueue_style( 'support-centre-stylesheet', get_template_directory_uri() . '/library/assets/css/support-centre.css', array(), '1.0.0' );

 

  
	// Core JS files -->
  wp_enqueue_script('jquery', get_template_directory_uri().'/library/assets/js/core/libraries/jquery.min.js', array(), '1.0.0' );

  wp_enqueue_script( 'bootstrap-script',  get_template_directory_uri().'/library/assets/js/core/libraries/bootstrap.min.js', array( 'jquery' ), '1.0.0', false );
	wp_enqueue_script( 'jquery-core',  get_template_directory_uri().'/library/assets/js/core/jquery.3.2.1.min.js', array( 'jquery' ), '1.0.0', false );

	wp_enqueue_script( 'jquery-mockjax', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-mockjax/1.6.2/jquery.mockjax.js', array(), '1.0.0' );


	
	
 // Theme JS files -->
 
  
  //wp_enqueue_script( 'Hidden',  get_template_directory_uri().'/library/assets/js/show-more.js', array( 'jquery' ), '1.0.0', false );
  // wp_enqueue_script( 'd3-tooltip-script',  get_template_directory_uri().'/library/assets/js/plugins/visualization/d3/d3_tooltip.js', array( 'jquery' ), '1.0.0', false );
  wp_enqueue_script( 'switchery-script',  get_template_directory_uri().'/library/assets/js/plugins/forms/styling/switchery.min.js', array( 'jquery' ), '1.0.0', false );
  wp_enqueue_script( 'uniform-script',  get_template_directory_uri().'/library/assets/js/plugins/forms/styling/uniform.min.js', array( 'jquery' ), '1.0.0', false );
  //wp_enqueue_script( 'tooltop-script',  get_template_directory_uri().'/library/assets/js/tooltip.js', array( 'jquery' ), '1.0.0', false );
  wp_enqueue_script( 'multiselect-script',  get_template_directory_uri().'/library/assets/js/plugins/forms/selects/bootstrap_multiselect.js', array( 'jquery' ), '1.0.0', false );
  //wp_enqueue_script( 'moment-script',  get_template_directory_uri().'/library/assets/js/plugins/moment.min.js', array( 'jquery' ), '1.0.0', false );
  //wp_enqueue_script( 'moment-full',  get_template_directory_uri().'/library/assets/js/plugins/moment.js', array( 'jquery' ), '1.0.0', false );
 
  wp_enqueue_script( 'password-hide-show', 'https://cdnjs.cloudflare.com/ajax/libs/hideshowpassword/2.0.8/hideShowPassword.min.js', array(), '1.0.0' ); 
  wp_enqueue_script( 'fixed native',  get_template_directory_uri().'/library/assets/js/pages/layout_fixed_native.js', array( 'jquery' ), '1.0.0', false ); 
  wp_enqueue_script( 'core-script',  get_template_directory_uri().'/library/assets/js/core/app.js', array( 'jquery' ), '1.0.0', false );
  wp_enqueue_script( 'custom-script',  get_template_directory_uri().'/library/js/custom.js', array( 'jquery' ), '1.0.0', false );
  // wp_enqueue_script( 'tabs-refresh',  get_template_directory_uri().'/library/assets/refresh-tabs.js', array( 'jquery' ), '1.0.0', false );

if(is_singular(array( 'assets', 'users', 'sites', 'clients', 'services', 'tasks', 'migrations' ))) {
  wp_enqueue_script( 'form-editable',  get_template_directory_uri().'/library/assets/js/plugins/forms/editable/editable.min.js', array( 'jquery' ), '1.0.0', false );
  wp_enqueue_script( 'form-editable-page',  get_template_directory_uri().'/library/assets/js/pages/form_editable.js', array( 'jquery' ), '1.0.0', false );
}

  
  
	// New stuff
	// wp_enqueue_script( 'custom-script',  'https://code.jquery.com/jquery-3.2.1.min.js', array(), '1.0.0' );
	// wp_enqueue_script( 'custom-script',  get_template_directory_uri().'/assets/vendor/popper.js/umd/popper.min.js', array( 'jquery' ), '1.0.0', false );
	// wp_enqueue_script( 'custom-script',  get_template_directory_uri().'/assets/vendor/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '1.0.0', false );
	// wp_enqueue_script( 'custom-script',  get_template_directory_uri().'/assets/vendor/jquery.cookie/jquery.cookie.js', array( 'jquery' ), '1.0.0', false );
	// wp_enqueue_script( 'custom-script',  get_template_directory_uri().'/assets/vendor/chart.js/Chart.min.js', array( 'jquery' ), '1.0.0', false );
	// wp_enqueue_script( 'custom-script',  get_template_directory_uri().'/assets/vendor/jquery-validation/jquery.validate.min.js', array( 'jquery' ), '1.0.0', false );
	// wp_enqueue_script( 'custom-script',  get_template_directory_uri().'/assets/js/charts-home.js', array( 'jquery' ), '1.0.0', false );
	// wp_enqueue_script( 'custom-script',  get_template_directory_uri().'/assets/js/front.js', array( 'jquery' ), '1.0.0', false );
	
	
	
}



/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'thumb-900', 900, 600, false );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
    register_sidebar(array(
    	'id' => 'sidebar1',
    	'name' => 'Sidebar',
    	'description' => 'Used on every page.',
    	'before_widget' => '<div id="%1$s" class="widget large-12 medium-12 small-6 %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));
    
} 

/************* ADDITIONAL NICETIES *********************/

require_once('library/comments.php');  // comment layout
//require_once('library/navwalker.php');  // navigation walker
//require_once('library/excerpt.php');  // custom excerpt length
//require_once('library/child-ancestor.php');  // is child page / is ancestor page
require_once('library/acf.php');  // is child page / is ancestor page
//require_once('library/youtube.php');  // youtube functions


/************* NINJA FORMS *********************/


function populate_clients($options, $settings) {
  if( $settings['key'] == 'client_1512654799935' || $settings['key'] == 'client_1516811251409' || $settings['key'] == 'client_1512655368899' || $settings['key'] == 'company_1512655076971'){
          $args = array(
        'post_type' => 'clients',
        'posts_per_page' => 99,
        'orderby' => 'title',
        'order' => 'ASC'
      );

      $the_query = new WP_Query( $args );

      if ($the_query->have_posts()) : {
        if ( 'clients' == get_post_type() ) {

        $options = array(
          'label' =>  get_the_title(),
          'value' =>  get_the_id()
      );
      $options[] = array(
        'label' =>  get_the_title(),
        'value' =>  get_the_id()
    );
  }
  elseif ( 'users' == get_post_type() ) {
    global $wp_query;
    $options = array();
    $options[] = array(
      
       'label' => get_the_title( $my_meta = get_post_meta( $wp_query->post->ID, 'client', true ) ),
       'value' =>  get_post_meta( $wp_query->post->ID, 'client', true )
    );
 }
 else {$options = array();

 $options[] = array(
       'label' =>  'Please select',
       'value' =>  ''
   );
  }
}
        
        while ( $the_query->have_posts() ) : $the_query->the_post();
          $options[] = array(
              'label' =>  get_the_title(),
              'value' =>  get_the_id()
          );
        endwhile;
        
      endif;
      wp_reset_postdata();
    }
    
   return $options;
}
add_filter('ninja_forms_render_options','populate_clients', 10, 2);


function populate_sites($options, $settings) {
  if( $settings['key'] == 'site_1512655373832' || $settings['key'] == 'site_1512662334035' || $settings['key'] == 'site_1512655082550' ){

      $args = array(
        'post_type' => 'sites',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'meta_query' => array('relation' => 'or',
          array(
          'key'     => 'client',
				'value' => get_the_id(),
				'compare' => '=',
      ),
      array(
        'relation' => 'or',
        array(
          'key'     => 'client',
          'value'   => get_post_meta(get_the_ID(), 'client', true),
          'compare' => '='
        ),
      )
     )
    );

      $the_query = new WP_Query( $args );

      if ($the_query->have_posts()) :

        $options = array();

        $options[] = array(
              'label' =>  'Please select',
              'value' =>  ''
          );
        
        while ( $the_query->have_posts() ) : $the_query->the_post();
          $options[] = array(
              'label' =>  get_the_title(),
              'value' =>  get_the_id()
          );
        endwhile;
        
      endif;

      wp_reset_postdata();

      

   }

   return $options;
}
add_filter('ninja_forms_render_options','populate_sites', 10, 2);



function populate_users($options, $settings) {
  if( $settings['key'] == 'user_1512655389894' || $settings['key'] == 'user_1512662350425' ){

      $args = array(
        'post_type' => 'users',
        'posts_per_page' => 99,
        'orderby' => 'title',
        'order' => 'ASC',
        'meta_query' => array('relation' => 'or',
          array(
          'key'     => 'client',
				'value' => get_the_id(),
				'compare' => '=',
      ),
      array(
        'relation' => 'or',
        array(
          'key'     => 'client',
          'value'   => get_post_meta(get_the_ID(), 'client', true),
          'compare' => '='
        ),
      )
     )
    );

      $the_query = new WP_Query( $args );

      if ($the_query->have_posts()) :

        $options = array();

        $options[] = array(
              'label' =>  'Please select',
              'value' =>  ''
          );


        while ( $the_query->have_posts() ) : $the_query->the_post();
          $options[] = array(
              'label' =>  get_the_title(),
              'value' =>  get_the_id()
          );
        endwhile;
        
      endif;

      wp_reset_postdata();

      

   }

   return $options;
}
add_filter('ninja_forms_render_options','populate_users', 10, 2);

function populate_migrations($options, $settings) {
  if( $settings['key'] == 'migration_1523602923671' || $settings['key'] == 'migration_1523602923671' ){

      $args = array(
        'post_type' => 'migrations',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
      );

      $the_query = new WP_Query( $args );

      if ($the_query->have_posts()) :

        $options = array();

        $options[] = array(
              'label' =>  'Please select',
              'value' =>  ''
          );

        while ( $the_query->have_posts() ) : $the_query->the_post();
          $options[] = array(
              'label' =>  get_the_title(),
              'value' =>  get_the_title()
          );
        endwhile;
        
      endif;

      wp_reset_postdata();

      

   }

   return $options;
}
add_filter('ninja_forms_render_options','populate_migrations', 10, 2);


/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 */
function ja_global_enqueues() {
  wp_enqueue_style(
    'jquery-auto-complete',
    'https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.css',
    array(),
    '1.0.7'
  );
  wp_enqueue_script(
    'jquery-auto-complete',
    'https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js',
    array( 'jquery' ),
    '1.0.7',
    true
  );
  wp_enqueue_script(
    'global',
    get_template_directory_uri() . '/library/js/global.js',
    array( 'jquery' ),
    '1.0.0',
    true
  );
  wp_localize_script(
    'global',
    'global',
    array(
      'ajax' => admin_url( 'admin-ajax.php' ),
    )
  );
}
add_action( 'wp_enqueue_scripts', 'ja_global_enqueues' );
/**
 * Live autocomplete search feature.
 *
 * @since 1.0.0
 */
function ja_ajax_search() {
  $results = new WP_Query( array(
    'post_type'     => array( 'clients', 'assets', 'services', 'sites', 'users' ),
    'post_status'   => 'publish',
    'nopaging'      => true,
    'posts_per_page'=> 100,
    's'             => stripslashes( $_POST['search'] ),
  ) );
  $items = array();
  if ( !empty( $results->posts ) ) {
    foreach ( $results->posts as $result ) {
      $items[] = $result->post_title;
    }
  }
  wp_send_json_success( $items );
}
add_action( 'wp_ajax_search_site',        'ja_ajax_search' );
add_action( 'wp_ajax_nopriv_search_site', 'ja_ajax_search' );


function getUsersAndSites() {

  $users = get_posts(array(
      'post_type' => 'users',
      'posts_per_page' => '-1',
      'meta_key' => 'client',
      'meta_value' => $_POST['client_id']
  ));

  $html = array();

  $html['users'] = '<option value="" selected="selected">Please select</option>';
  if ($users && !empty($users)){
    foreach ($users as $key => $user) {
      $html['users'] .= '<option value="' . $user->ID . '">' . get_the_title($user) . '</option>';
    }
  }

  $sites = get_posts(array(
      'post_type' => 'sites',
      'posts_per_page' => '-1',
      'meta_key' => 'client',
      'meta_value' => $_POST['client_id']
  ));

  $html['sites'] = '<option value="" selected="selected">Please select</option>';
  if ($sites && !empty($sites)){
    foreach ($sites as $key => $site) {
      $html['sites'] .= '<option value="' . $site->ID . '">' . get_the_title($site) . '</option>';
    }
  }

  wp_send_json_success($html);
  
}
add_action( 'wp_ajax_getUsersAndSites',        'getUsersAndSites' );
add_action( 'wp_ajax_nopriv_getUsersAndSites', 'getUsersAndSites' );


function getUsersBySite() {

  $users = get_posts(array(
      'post_type' => 'users',
      'posts_per_page' => '-1',
      'meta_key' => 'site',
      'meta_value' => $_POST['siteId']
  ));

  $html = array();

  $html['users'] = '<option value="" selected="selected">Please select</option>';
  if ($users && !empty($users)){
    foreach ($users as $key => $user) {
      $html['users'] .= '<option value="' . $user->ID . '">' . get_the_title($user) . '</option>';
    }
  }

  wp_send_json_success($html);
  
}
add_action( 'wp_ajax_getUsersBySite',        'getUsersBySite' );
add_action( 'wp_ajax_nopriv_getUsersBySite', 'getUsersBySite' );


add_action('wp_ajax_updatePostMeta', 'updatePostMetaCallback');
add_action('wp_ajax_nopriv_updatePostMeta', 'updatePostMetaCallback');

function updatePostMetaCallback(){

  $post_id = $_POST['post_id'];
  $meta_key = $_POST['meta_key'];
  $meta_value = $_POST['meta_value'];

  if (isset($post_id) && !empty($post_id)){
    var_dump($_POST);
    update_post_meta( $post_id, $meta_key, $meta_value);
  }



  wp_die();

}

add_action( 'wp_enqueue_scripts', 'myajax_data', 99 );
function myajax_data(){
  wp_localize_script( 'custom-script', 'myajax', 
    array(
      'url' => admin_url('admin-ajax.php')
    )
  );  

}


add_action('init', 'myStartSession', 1);
function myStartSession() {
    if(!session_id()) {
        session_start();
    }

    if (isset($_GET['topbar']) && !empty($_GET['topbar'])) {
      $post_id = $_GET['topbar'];
      $_SESSION['selected_client'] = $post_id;
    }
    
}
?>

<?php
function admin_redirect() {
  if ( !is_user_logged_in()) {
    wp_redirect( home_url() );
    exit;
  }
  }
  add_action('get_header', 'admin_redirect');

function v_getUrl() {
  $url  = isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ? 'https' : 'http';
  $url .= '://' . $_SERVER['SERVER_NAME'];
  $url .= in_array( $_SERVER['SERVER_PORT'], array('80', '443') ) ? '' : ':' . $_SERVER['SERVER_PORT'];
  $url .= $_SERVER['REQUEST_URI'];
  return $url;
}
function v_forcelogin() {
  if( !is_user_logged_in() ) {
    $url = v_getUrl();
    $whitelist = apply_filters('v_forcelogin_whitelist', array());
    $redirect_url = apply_filters('v_forcelogin_redirect', $url);
    if( preg_replace('/\?.*/', '', $url) != preg_replace('/\?.*/', '', wp_login_url()) && !in_array($url, $whitelist) ) {
      wp_safe_redirect( wp_login_url( $redirect_url ), 302 ); exit();
    }
  }
}
add_action('init', 'v_forcelogin'); ?>

<?php
function wpse_226690_admin_menu() {
    add_menu_page(
        'WAS Portal',
        'WAS Portal',
        'read',
        'was-portal',
        '', // Callback, leave empty
        'dashicons-admin-generic',
        2 // Position
    );
}

add_action( 'admin_menu', 'wpse_226690_admin_menu' );
?>

