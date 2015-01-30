<?php

	function change_post_object_label() {
	    global $wp_post_types;

	    $labels = &$wp_post_types['post']->labels;
	    $labels->name = 'Blog Posts';
	    $labels->singular_name = 'Blog Post';
	    $labels->add_new = 'Add Blog Post';
	    $labels->add_new_item = 'Add Blog Post';
	    $labels->edit_item = 'Edit Blog Posts';
	    $labels->new_item = 'Blog Post';
	    $labels->view_item = 'View Blog Post';
	    $labels->search_items = 'Search Blog Posts';
	    $labels->not_found = 'No Blog Posts found';
	    $labels->not_found_in_trash = 'No Blog Posts found in Trash';
	    $labels->menu_name = "Blog Posts";
	    $labels->name_admin_bar = "Blog Post";
	}
	add_action( 'init', 'change_post_object_label' );


	function rocke_custom_admin_menu() {

		global $submenu;

		foreach ($submenu['edit.php'] as $index => $menu_item ) {

			// Ditch all the non-post-type items.
			if ( ! preg_grep("/edit\.php/", $menu_item) )
			{
				unset($submenu['edit.php'][$index]); 
			}

			// Rename "Posts" to make it clear this is only for the blog.
			else if ( array_search('edit.php', $menu_item) )
			{
				$submenu['edit.php'][$index][0] = 'Blog Posts';
			}
		}

		// Add Taxonomy Menu Item.
		add_menu_page(
			'Regions', 
			'Regions', 
			'manage_categories', 
			'edit-tags.php?taxonomy=regions', 
			'',
			'dashicons-tag',
			6
		);

		add_menu_page(
			'Strategic Approaches',
			'Strategic Approaches',
			'manage_categories', 
			'edit-tags.php?taxonomy=approaches', 
			'',
			'dashicons-tag',
			7
		);

	}
	add_action('admin_menu', 'rocke_custom_admin_menu');