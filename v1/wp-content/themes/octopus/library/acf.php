<?php

/****************************
	ADVANCED CUSTOM FIELD OPTIONS
****************************/

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme Settings',
		'menu_slug' => 'theme-settings'
	));

}



?>