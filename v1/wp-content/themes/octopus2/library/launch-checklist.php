<?php
/* The Launch checklist
If this is still present on the live website ... someone didn't follow the cheklist!
*/


// let's create the function for the custom type
function custom_post_checklist() { 
	// creating (registering) the custom type 
	register_post_type( 'checklist', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Checklist Items', 'post type general name'), /* This is the Title of the Group */
			'singular_name' => __('Checklist Item', 'post type singular name'), /* This is the individual type */
			'add_new' => __('Add New', 'custom post type item'), /* The add new menu item */
			'add_new_item' => __('Add New Checklist Item'), /* Add New Display Title */
			'edit' => __( 'Edit' ), /* Edit Dialog */
			'edit_item' => __('Edit Checklist Items'), /* Edit Display Title */
			'new_item' => __('New Checklist Item'), /* New Display Title */
			'view_item' => __('View Checklist Item'), /* View Display Title */
			'search_items' => __('Search Checklist Items'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Pre-launch checklist items' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-sos', /* the icon for the custom post type menu http://melchoyce.github.io/dashicons/ */
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
	 	) /* end of options */
	); /* end of register post type */
	
} 

	// adding the function to the Wordpress init
	add_action( 'init', 'custom_post_checklist');
	
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	
	// now let's add custom categories (these act like categories)
    register_taxonomy( 'item_priority', 
    	array('checklist'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    	array('hierarchical' => true,     /* if this is true it acts like categories */             
    		'labels' => array(
    			'name' => __( 'Item Priorities' ), /* name of the custom taxonomy */
    			'singular_name' => __( 'Item Priority' ), /* single taxonomy name */
    			'search_items' =>  __( 'Search Item Priorities' ), /* search title for taxomony */
    			'all_items' => __( 'All Item Priorities' ), /* all title for taxonomies */
    			'parent_item' => __( 'Parent Item Priority' ), /* parent title for taxonomy */
    			'parent_item_colon' => __( 'Parent Item Priority:' ), /* parent taxonomy title */
    			'edit_item' => __( 'Edit Item Priority' ), /* edit custom taxonomy title */
    			'update_item' => __( 'Update Item Priority' ), /* update title for taxonomy */
    			'add_new_item' => __( 'Add New Item Priority' ), /* add new title for taxonomy */
    			'new_item_name' => __( 'New Item Priority Name' ) /* name title for taxonomy */
    		),
    		'show_ui' => true,
    		'query_var' => true,
    	)
    );   
    
	

?>