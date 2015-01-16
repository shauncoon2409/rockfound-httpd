<?php

	function make_post_type_labels($singular, $plural, $overrides = array()) {
		$labels = array(
			'name'                => $plural,
			'singular_name'       => $singular,
			'menu_name'           => $plural,
			'parent_item_colon'   => 'Parent '.$singular.':',
			'all_items'           => $plural,
			'view_item'           => 'View '.$singular,
			'add_new_item'        => 'Add New '.$singular,
			'add_new'             => 'Add New',
			'edit_item'           => 'Edit '.$singular,
			'update_item'         => 'Update '.$singular,
			'search_items'        => 'Search '.$plural,
			'not_found'           => 'Not found',
			'not_found_in_trash'  => 'Not found in Trash',
		);

		if ( !empty($override) )
		{
			$labels = array_replace($labels, $overrides);
		}

		return $labels;
	}


	// Grant
	// ----------------------------------
	$args = array(
		'label'               => 'grant',
		'description'         => 'Created by Internal Systems',
		'labels'              => make_post_type_labels('Grant', 'Grants'),
		'supports'            => array( 'title' ),
		'taxonomies'          => array( 'regions' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php',
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'grant', $args );


	// Grantee
	// ----------------------------------
	$args = array(
		'label'               => 'grantee',
		'description'         => 'Created by Internal Systems',
		'labels'              => make_post_type_labels('Grantee', 'Grantees'),
		'supports'            => array( 'title', 'editor'),
		'taxonomies'          => array( 'regions' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php',
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'grantee', $args );


	// Initiative
	// ----------------------------------
	$args = array(
		'label'               => 'initiative',
		'description'         => 'Created by Internal Systems',
		'labels'              => make_post_type_labels('Initative', 'Initiatives'),
		'supports'            => array( 'title', 'editor', 'thumbnail'),
		'taxonomies'          => array( 'regions' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php',
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'initiative', $args );


	// Person
	// ----------------------------------
	$args = array(
		'label'               => 'person',
		'description'         => 'Created by Internal Systems',
		'labels'              => make_post_type_labels('Person', 'People'),
		'supports'            => array( 'title', 'editor'),
		'taxonomies'          => array( 'regions' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php',
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'person', $args );


	// Topic
	// ----------------------------------
	$args = array(
		'label'               => 'topic',
		'description'         => '',
		'labels'              => make_post_type_labels('Topic', 'Topics'),
		'supports'            => array( 'title', 'editor'),
		'taxonomies'          => array( 'regions' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php',
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'topic', $args );



	// News Article
	// ----------------------------------
	$args = array(
		'label'               => 'news_post',
		'description'         => '',
		'labels'              => make_post_type_labels('News & Media', 'News & Media'),
		'supports'            => array( 'title', 'editor'),
		'taxonomies'          => array( 'regions' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php',
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'news_post', $args );


	// Career Opportunity
	// ----------------------------------
	$args = array(
		'label'               => 'career_post',
		'description'         => '',
		'labels'              => make_post_type_labels('Career Opportunity', 'Career Opportunities'),
		'supports'            => array( 'title', 'editor'),
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php',
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'career_post', $args );


	// Insight
	// ----------------------------------
	$args = array(
		'label'               => 'insight',
		'description'         => 'Featured collections of questions and answers',
		'labels'              => make_post_type_labels('Insight', 'Insights'),
		'supports'            => array( 'title', 'editor'),
		'taxonomies'          => array( 'regions' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php',
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'insight', $args );


	// Strategy
	// ----------------------------------
	$args = array(
		'label'               => 'strategy',
		'description'         => '',
		'labels'              => make_post_type_labels('Strategic Sub-Approach', 'Strategic Sub-Approaches'),
		'supports'            => array( 'title', 'editor' ),
		'taxonomies'          => array( 'approaches' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php',
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'strategy', $args );


	// Question
	// ----------------------------------
	$args = array(
		'label'               => 'question',
		'description'         => 'Create questions for Q&A Module',
		'labels'              => make_post_type_labels('Question', 'Questions'),
		'supports'            => array( 'title', 'editor'),
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php',
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'question', $args );


	// Answer
	// ----------------------------------
	$args = array(
		'label'               => 'answer',
		'description'         => 'Create answers for Q&A Module',
		'labels'              => make_post_type_labels('Answer', 'Answers'),
		'supports'            => array( 'title', 'editor'),
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php',
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'answer', $args );


	// Answer
	// ----------------------------------
	$args = array(
		'label'               => 'residency',
		'description'         => 'Residency',
		'labels'              => make_post_type_labels('Residency', 'Residencies'),
		'supports'            => array( 'title', 'editor'),
		'taxonomies'          => array( 'regions' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php',
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'residency', $args );


	// Conferences
	// ----------------------------------
	$args = array(
		'label'               => 'conference',
		'description'         => 'Conference',
		'labels'              => make_post_type_labels('Conference', 'Conferences'),
		'supports'            => array( 'title', 'editor'),
		'taxonomies'          => array( 'regions' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php',
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'conference', $args );


	// Conferences
	// ----------------------------------
	$args = array(
		'label'               => 'report',
		'description'         => 'Report',
		'labels'              => make_post_type_labels('Report', 'Reports'),
		'supports'            => array( 'title' ),
		'taxonomies'          => array( 'regions' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => 'edit.php',
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 4,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'report', $args );
