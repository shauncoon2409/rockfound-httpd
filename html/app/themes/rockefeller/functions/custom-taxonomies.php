<?php


	function make_taxonomy_labels($singular, $plural, $overrides = array()) {
		$labels = array(
			'name'                       => $plural,
			'singular_name'              => $singular,
			'menu_name'                  => ucfirst( $plural ),
			'all_items'                  => 'All '.$plural,
			'parent_item'                => 'Parent '.$singular.'',
			'parent_item_colon'          => 'Parent '.$singular.':',
			'new_item_name'              => 'New '.$singular.' Name',
			'add_new_item'               => 'Add New '.$singular.'',
			'edit_item'                  => 'Edit '.$singular.'',
			'update_item'                => 'Update '.$singular.'',
			'separate_items_with_commas' => 'Separate '.$plural.' with commas',
			'search_items'               => 'Search '.$plural,
			'add_or_remove_items'        => 'Add or remove '.$plural.'',
			'choose_from_most_used'      => 'Choose from the most used '.$plural.'',
			'not_found'                  => 'Not Found',
		);

		if ( !empty($override) )
		{
			$labels = array_replace($labels, $overrides);
		}

		return $labels;
	}


    register_taxonomy('category', array());
    register_taxonomy('post_tag', array());


	$args = array(
		'labels'                     => make_taxonomy_labels('Region', 'Regions'),
		'hierarchical'               => false,
		'public'                     => false,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'           		 => array( 'slug' => 'region-name' ),
	);
	register_taxonomy( 'regions', array( 'post', 'grant', 'initative', 'topic', 'news_post' ), $args );


	$args = array(
		'labels'                     => make_taxonomy_labels('Stragetic Approach', 'Stragetic Approaches'),
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'rewrite'           		 => array( 'slug' => 'strategic-approach' ),
	);
	register_taxonomy( 'approaches', array( 'strategy' ), $args );
