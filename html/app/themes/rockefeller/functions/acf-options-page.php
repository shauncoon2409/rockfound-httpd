<?php
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title'	=> 'Theme Options',
		'menu_title'	=> 'Theme Options',
		'menu_slug' 	=> 'theme-options',
		'parent_slug'	=> '',
		'position'		=> false,
		'icon_url'		=> false,
	));
	

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Site Navigation',
		'menu_title'	=> 'Site Navigation',
		'menu_slug'		=> 'theme-global-navigation',
		'parent_slug'	=> 'theme-options',
		'position'		=> false,
	));


	acf_add_options_sub_page(array(
		'page_title' 	=> 'Site Footer',
		'menu_title'	=> 'Site Footer',
		'menu_slug'		=> 'theme-global-footer',
		'parent_slug'	=> 'theme-options',
		'position'		=> false,
	));
}