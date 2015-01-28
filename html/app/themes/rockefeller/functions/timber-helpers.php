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


	function rocke_setup_subnav_data($nav_field) {
		$subnav = get_field($nav_field, 'option');
		$return = array();

		if ( ! is_array($subnav) )
			return $return;

		foreach ($subnav as $index => $navItem) {
			$return[$index]['title'] = $navItem['title'];
			$return[$index]['url'] = $navItem['url'];

			if ($navItem['content_type'] === 'dynamic')
			{
				$picked = array();
				$default = array();
				$args = array('order' => 'ASC','orderby' => 'title');

				switch ( $navItem['type'] )
				{
					case "topics":
						$picked = Timber::get_posts($navItem['picked_topics']);

						$args['post_type'] = 'topic';
						$args['posts_per_page'] = '' + ( 27 - sizeof($picked) );
						$args['post__not_in'] = $navItem['picked_topics'];
						$default = Timber::get_posts($args);

						break;

					case "initiatives":
						$picked = Timber::get_posts($navItem['picked_inits']);

						$args['post_type'] = 'initiative';
						$args['posts_per_page'] = '' + ( 27 - sizeof($picked) );
						$args['post__not_in'] = $navItem['picked_inits'];
						$default = Timber::get_posts($args);

						break;
				}

				$posts = array_merge($picked, $default);
				$links = array();

				foreach ($posts as $i => $post) {
					$links[$i] = array(
						'title'	=> $post->post_title,
						'url'	=>	$post->link
					);
				}

				$return[$index]['content_type'] = 'linklist';
				$return[$index]['links'] = $links;
			}

			elseif ($navItem['content_type'] === 'manual')
			{
				$return[$index]['content_type'] = 'linklist';
				$return[$index]['links'] = $navItem['mlist'];
			}

			elseif ($navItem['content_type'] === 'featured')
			{
				$return[$index]['content_type'] = 'carousel';
				$return[$index]['carousel'] = Timber::get_posts( $navItem['featured'] );
			}
		}

		return $return;
	}


	// This probably needs some caching yo....
	add_filter('timber_context', 'add_global_nav_data');
	function add_global_nav_data($data){


		$data['globalNav'] = TimberHelper::transient('rocke_gloabal_nav', function(){
			$gn_overviews = array(
				'gn1' => get_field('gn1_overview', 'option'),
				'gn2' =>get_field('gn2_overview', 'option'),
				'gn3' =>get_field('gn3_overview', 'option'),
				'gn4' =>get_field('gn4_overview', 'option'),
				'gn5' =>get_field('gn5_overview', 'option')
			);

			$gn_overview_results = array();

			foreach ($gn_overviews as $i => $option) {
				$gn_overview_results[$i] = ( !empty($option) ) ? Timber::get_posts( $option ) : array();
			}

			$global_nav = array(
				array(
					"title"		=> get_field('gn1_text', 'option'),
					"link"		=> get_field('gn1_page', 'option'),
					"all_text"	=> get_field('gn1_all_text', 'option'),
					"overview"  => $gn_overview_results['gn1'],
					"content" 	=> rocke_setup_subnav_data('gn1'),
				),
				array(
					"title"		=> get_field('gn2_text', 'option'),
					"link"		=> get_field('gn2_page', 'option'),
					"all_text"	=> get_field('gn2_all_text', 'option'),
					"overview"  => $gn_overview_results['gn2'],
					"content" 	=> rocke_setup_subnav_data('gn2'),
				),
				array(
					"title"		=> get_field('gn3_text', 'option'),
					"link"		=> get_field('gn3_page', 'option'),
					"all_text"	=> get_field('gn3_all_text', 'option'),
					"overview"  => $gn_overview_results['gn3'],
					"content" 	=> rocke_setup_subnav_data('gn3'),
				),
				array(
					"title"		=> get_field('gn4_text', 'option'),
					"link"		=> home_url('/blog/'),
					"all_text"	=> get_field('gn4_all_text', 'option'),
					"overview"  => $gn_overview_results['gn4'],
					"content" 	=> rocke_setup_subnav_data('gn4'),
				),
				array(
					"title"		=> get_field('gn5_text', 'option'),
					"link"		=> get_field('gn5_page', 'option'),
					"all_text"	=> get_field('gn5_all_text', 'option'),
					"overview"  => $gn_overview_results['gn5'],
					"content" 	=> rocke_setup_subnav_data('gn5'),
				),
			);

			return $global_nav;
		}, 10800); // 3 hrs

		// delete_transient( 'rocke_gloabal_nav' );

	    return $data;
	}