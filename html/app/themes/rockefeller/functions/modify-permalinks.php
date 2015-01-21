<?php

	// Change permalink structure for non-detail page items
	function rocke_modify_permalinks( $permalink, $post ) 
	{
		switch ( get_post_type( $post ) ) 
		{
			case 'grant':

				$result = wp_cache_get( 'permalink_'.$post->ID );
				if ( $result === false ) {

					$parents = Timber::get_posts(array(
						'post_type' => 'grantee',
						'posts_per_page' => 1,
						'meta_query' => array(
							array(
								'key' => 'grants_awarded',
								'value' => '"' . $post->ID . '"',
								'compare' => 'LIKE'
							)
						)
					));

					$parent = array_shift($parents);

					$result = ($parent !== null) ? $parent->link . "#" . $post->post_name : '';

					wp_cache_set( 'permalink_'.$post->ID, $result, 'permalinks', 3 * HOUR_IN_SECONDS );
				}

				$permalink = $result;

				break;
		}

		return $permalink;
	}
	add_filter( 'post_type_link', 'rocke_modify_permalinks', 10, 2 );



	// Change permalink structure for non-detail page items
	function rocke_modify_term_permalinks( $url, $term, $taxonomy )
	{
		switch ( $taxonomy ) 
		{
			case 'regions':
				$url = home_url('/regions/#' . $term);
				break;
		}

		return $url;
	}
	add_filter( 'term_link', 'rocke_modify_term_permalinks', 10, 2 );