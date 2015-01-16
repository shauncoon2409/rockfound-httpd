<?php

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post; // Main post for the page.

$containerClasses = 'borderless';


// Set header info.
// --------------------------

$context['header'] = array(
	"breadcrumb" => "Grants / Grantee ",
	"currentPage" => $post->post_title,
	"headerTitle" => $post->post_title,
	"type" => "internal yellow"
);



// Set Content (textblock)
// --------------------------
$context['textBlock'] = array(
	"content" => $post->post_content
);



// Get Grants
// --------------------------
$grants = array();

foreach ($post->get_field('grants_awarded') as $grant_post) {
	$grant = new TimberPost($grant_post->ID);

	$grants[$grant->ID] = array(
		"title"			=> $grant->post_title,
		"slug"			=> $grant->slug,
		"amount"		=> $grant->get_field('grant_amount'),
		"term_start" 	=> $grant->get_field('grant_term_start'),
		"term_end"		=> $grant->get_field('grant_term_end'),
		"desc"			=> $grant->get_field('description'),
		
		"topics"		=> convert_to_timber_posts($grant->get_field('grant_topics')),
		"initiatives"	=> convert_to_timber_posts($grant->get_field('grant_initiatives')),
		"regions"		=> wp_get_post_terms( $grant_post->ID, 'regions' ),

		"officer"		=> convert_to_timber_posts($grant->get_field('grant_officer')),
	);
}
$context['grants'] = $grants;




// Set timline info
// --------------------------

$social_feeds = new Rocke_social_feeds();

$social_timline_events = $social_feeds->get_social_feeds(
	$post->get_field('twitter_id'), 
	$post->get_field('instagram_username')
);

$blog_timline_events = Timber::get_posts(array(
	'post_type' => 'post',
	'meta_query' => array(
		array(
			'key' => 'related_tags',
			'value' => '"' . $post->ID . '"',
			'compare' => 'LIKE'
		)
	)
));


$context['timeline'] = array(
	'containerClasses' => $containerClasses,
	'title' => 'Grantee Updates',
	'filters' => array(
		'socialfeed' => 'Field Notes',
		'blog' => 'Stories'
	),

	'events' => $social_timline_events
);



// Set Newsletter Info
// --------------------------

$context['newsletter'] = array(
	"title" => "Newsletter"
);


Timber::render('template-3.twig', $context);