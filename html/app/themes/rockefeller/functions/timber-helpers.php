<?php

	function convert_to_timber_posts($posts_array)
	{
		if (! is_array($posts_array) )
		{
			return false;
		}

		if (empty($posts_array))
		{
			return array();
		}

		$return = array();

		foreach ($posts_array as $new_post)
		{
			if ( is_integer($new_post) )
			{
				$return[$new_post] = new TimberPost($new_post);
			}
			else if ( isset($new_post->ID) )
			{
				$return[$new_post->ID] = new TimberPost($new_post->ID);
			}
		}

		return $return;
	}


	add_filter('timber_context', 'add_options_to_context');
	function add_options_to_context($data){

		$data['dynamicLinks'] = array(
			'regions'		=> Timber::get_terms('regions'),
			'topics'		=> Timber::get_posts(array('post_type' => 'topic', 'order' => 'ASC', 'orderby' => 'title', 'posts_per_page' => '27')),
			'initiatives'	=> Timber::get_posts(array('post_type' => 'initiative', 'order' => 'ASC', 'orderby' => 'title', 'posts_per_page' => '27'))
		);

		$data['globalNav'] = array(
			array(
				"title"		=> get_field('gn1_text', 'option'),
				"link"		=> get_field('gn1_page', 'option'),
				"content" 	=> get_field('gn1', 'option')
			),
			array(
				"title"		=> get_field('gn2_text', 'option'),
				"link"		=> get_field('gn2_page', 'option'),
				"content" 	=> get_field('gn2', 'option')
			),
			array(
				"title"		=> get_field('gn3_text', 'option'),
				"link"		=> get_field('gn3_page', 'option'),
				"content" 	=> get_field('gn3', 'option')
			),
			array(
				"title"		=> get_field('gn4_text', 'option'),
				"link"		=> home_url('/blog/'),
				"content" 	=> get_field('gn4', 'option')
			),
			array(
				"title"		=> get_field('gn1_text', 'option'),
				"link"		=> get_field('gn1_page', 'option'),
				"content" 	=> get_field('gn5', 'option')
			),
		);

	    return $data;
	}