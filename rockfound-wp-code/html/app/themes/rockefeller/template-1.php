<?php
/*
Template Name: Template 1 (Home Page)
*/

$context = Timber::get_context();
$post = new TimberPost();

$context['mission_statement'] = $post->get_field('mission_statement');


$topics = array();

foreach ($post->get_field('featured_topics') as $featured) {
	$topic_post = new TimberPost($featured->ID);

	$topic = array();

	$topic['id'] = $topic_post->ID;

	$topic['header'] = array(
		'backgroundImg' => $topic_post->thumbnail(),
		'headerContent' => $topic_post->get_field('topic_synopsis'),
		'headerTitle' => $topic_post->post_title,
		'bgcolor' => $topic_post->get_field('header_color')
	);


	/*


	$topic['slideshow'] = array(
	);

	// Top 5: Trending Blog Posts for Topic
	$topic['gridA4'] = array(
	);

	// 3 featured Initiative + social item for each initative.
	$topic['gridC5'] = array(
	);

	// Latest Quote for given topic
	$topic['quote'] = array(
	);

	// Responses to Quote ^
	$topic['gridA3_1'] = array(
	);

	// Region map. (Front-end still WIP)
	// In the basic state the map shows the benefitting regions for the selected topic (continents are highlighted).
	$topic['map'] = array(
	);

	// Newsletter
	$topic['newsletter'] = array(
	);
	*/

	$topics[] = $topic;

}

$context['topics'] = $topics;


Timber::render('template-1.twig', $context);