       <?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a seperate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/




// let's create the function for the custom type
function cpt_client() { 
	// creating (registering) the custom type 
	register_post_type( 'clients', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Clients', 'post type general name'), /* This is the Title of the Group */
			'singular_name' => __('Client', 'post type singular name'), /* This is the individual type */
			'add_new' => __('Add New', 'custom post type item'), /* The add new menu item */
			'add_new_item' => __('Add New Client'), /* Add New Display Title */
			'edit' => __( 'Edit' ), /* Edit Dialog */
			'edit_item' => __('Edit Client'), /* Edit Display Title */
			'new_item' => __('New Client'), /* New Display Title */
			'view_item' => __('View Client'), /* View Display Title */
			'search_items' => __('Search Clients'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Select Support Clients' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 1, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-groups', /* the icon for the custom post type menu  https://developer.wordpress.org/resource/dashicons/ */
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'show_in_menu' => 'was-portal',
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
	 	) /* end of options */
	); /* end of register post type */

	
}

// adding the function to the Wordpress init
add_action( 'init', 'cpt_logins');

// let's create the function for the custom type
function cpt_logins() { 
	// creating (registering) the custom type 
	register_post_type( 'logins', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Logins', 'post type general name'), /* This is the Title of the Group */
			'singular_name' => __('Login', 'post type singular name'), /* This is the individual type */
			'add_new' => __('Add New', 'custom post type item'), /* The add new menu item */
			'add_new_item' => __('Add New Login'), /* Add New Display Title */
			'edit' => __( 'Edit' ), /* Edit Dialog */
			'edit_item' => __('Edit Login'), /* Edit Display Title */
			'new_item' => __('New Login'), /* New Display Title */
			'view_item' => __('View Login'), /* View Display Title */
			'search_items' => __('Search Logins'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Select Support Logins' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 6, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-admin-network', /* the icon for the custom post type menu  https://developer.wordpress.org/resource/dashicons/ */
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'show_in_menu' => 'was-portal',
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
	 	) /* end of options */
	); /* end of register post type */

	
}


// adding the function to the Wordpress init
add_action( 'init', 'cpt_client');



function cpt_asset() { 
	// creating (registering) the custom type 
	register_post_type( 'assets', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Assets', 'post type general name'), /* This is the Title of the Group */
			'singular_name' => __('Asset', 'post type singular name'), /* This is the individual type */
			'add_new' => __('Add New', 'custom post type item'), /* The add new menu item */
			'add_new_item' => __('Add New Asset'), /* Add New Display Title */
			'edit' => __( 'Edit' ), /* Edit Dialog */
			'edit_item' => __('Edit Asset'), /* Edit Display Title */
			'new_item' => __('New Asset'), /* New Display Title */
			'view_item' => __('View Asset'), /* View Display Title */
			'search_items' => __('Search Assets'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Select Support Assets' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 4, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-admin-plugins', /* the icon for the custom post type menu  https://developer.wordpress.org/resource/dashicons/ */
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'show_in_menu' => 'was-portal',
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
	 	) /* end of options */
	); /* end of register post type */

	
}


// adding the function to the Wordpress init
add_action( 'init', 'cpt_asset');


function cpt_service() { 
	// creating (registering) the custom type 
	register_post_type( 'services', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Services', 'post type general name'), /* This is the Title of the Group */
			'singular_name' => __('Service', 'post type singular name'), /* This is the individual type */
			'add_new' => __('Add New', 'custom post type item'), /* The add new menu item */
			'add_new_item' => __('Add New Service'), /* Add New Display Title */
			'edit' => __( 'Edit' ), /* Edit Dialog */
			'edit_item' => __('Edit Service'), /* Edit Display Title */
			'new_item' => __('New Service'), /* New Display Title */
			'view_item' => __('View Service'), /* View Display Title */
			'search_items' => __('Search Services'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Select Support Services' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 5, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-admin-generic', /* the icon for the custom post type menu  https://developer.wordpress.org/resource/dashicons/ */
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'show_in_menu' => 'was-portal',
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
	 	) /* end of options */
	); /* end of register post type */

	
} 

// adding the function to the Wordpress init
add_action( 'init', 'cpt_service');



function cpt_site() { 
	// creating (registering) the custom type 
	register_post_type( 'sites', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Sites', 'post type general name'), /* This is the Title of the Group */
			'singular_name' => __('Site', 'post type singular name'), /* This is the individual type */
			'add_new' => __('Add New', 'custom post type item'), /* The add new menu item */
			'add_new_item' => __('Add New Site'), /* Add New Display Title */
			'edit' => __( 'Edit' ), /* Edit Dialog */
			'edit_item' => __('Edit Site'), /* Edit Display Title */
			'new_item' => __('New Site'), /* New Display Title */
			'view_item' => __('View Site'), /* View Display Title */
			'search_items' => __('Search Sites'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Select Support Sites' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 2, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-admin-multisite', /* the icon for the custom post type menu  https://developer.wordpress.org/resource/dashicons/ */
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'show_in_menu' => 'was-portal',
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
	 	) /* end of options */
	); /* end of register post type */

	
} 

// adding the function to the Wordpress init
add_action( 'init', 'cpt_site');



function cpt_staff() { 
	// creating (registering) the custom type 
	register_post_type( 'staff', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Staff', 'post type general name'), /* This is the Title of the Group */
			'singular_name' => __('Staff', 'post type singular name'), /* This is the individual type */
			'add_new' => __('Add New Staff Member', 'custom post type item'), /* The add new menu item */
			'add_new_item' => __('Add New Staff Member'), /* Add New Display Title */
			'edit' => __( 'Edit' ), /* Edit Dialog */
			'edit_item' => __('Edit Staff'), /* Edit Display Title */
			'new_item' => __('New Staff Member'), /* New Display Title */
			'view_item' => __('View staff'), /* View Display Title */
			'search_items' => __('Search Staff'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Select Support Staff' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 3, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-admin-users', /* the icon for the custom post type menu  https://developer.wordpress.org/resource/dashicons/ */
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'show_in_menu' => 'was-portal',
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
	 	) /* end of options */
	); /* end of register post type */

	
} 

// adding the function to the Wordpress init
add_action( 'init', 'cpt_staff');



// Register Custom Post Type
function tasks_post_type() {

	$labels = array(
		'name'                  => 'Tasks',
		'singular_name'         => 'Task',
		'menu_name'             => 'Tasks',
		'name_admin_bar'        => 'Tasks',
		'archives'              => 'Task Archives',
		'attributes'            => 'Task Attributes',
		'parent_item_colon'     => 'Parent Migration:',
		'all_items'             => 'All Tasks',
		'add_new_item'          => 'Add New Item',
		'add_new'               => 'New Task',
		'new_item'              => 'New Item',
		'edit_item'             => 'Edit Task',
		'update_item'           => 'Update Task',
		'view_item'             => 'View Task',
		'view_items'            => 'View Tasks',
		'search_items'          => 'Search Item',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into item',
		'uploaded_to_this_item' => 'Uploaded to this item',
		'items_list'            => 'Items list',
		'items_list_navigation' => 'Items list navigation',
		'filter_items_list'     => 'Filter items list',
	);
	$args = array(
		'label'                 => 'Task',
		'description'           => 'Tasks, subset of Migrations',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'custom-fields', 'page-attributes' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 8,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_menu' => 'was-portal',
	);
	register_post_type( 'tasks', $args );

}
add_action( 'init', 'tasks_post_type', 0 );
/*
for more information on taxonomies, go here:
http://codex.wordpress.org/Function_Reference/register_taxonomy
*/

function cpt_asset_diary_entry() { 
	// creating (registering) the custom type 
	register_post_type( 'asset_diary_entries', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Asset Diary Entries', 'post type general name'), /* This is the Title of the Group */
			'singular_name' => __('Site', 'post type singular name'), /* This is the individual type */
			'add_new' => __('Add New', 'custom post type item'), /* The add new menu item */
			'add_new_item' => __('Add New Diary Entry'), /* Add New Display Title */
			'edit' => __( 'Edit' ), /* Edit Dialog */
			'edit_item' => __('Edit Site'), /* Edit Display Title */
			'new_item' => __('New Site'), /* New Display Title */
			'view_item' => __('View Site'), /* View Display Title */
			'search_items' => __('Search Sites'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Asset Diary Entries' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 7, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-admin-multisite', /* the icon for the custom post type menu  https://developer.wordpress.org/resource/dashicons/ */
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'show_in_menu' => 'was-portal',
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
	 	) /* end of options */
	); /* end of register post type */

	
} 

// adding the function to the Wordpress init
add_action( 'init', 'cpt_asset_diary_entry');	

?>