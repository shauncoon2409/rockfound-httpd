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
