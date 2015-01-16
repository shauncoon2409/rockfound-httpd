<?php
/*
Template Name: Template 3 (Detail Page)
*/

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

$containerClasses = 'borderless';

$context['header'] = array();

$context['gridA3_5'] = array(
	'containerClasses' => $containerClasses,
	'blocks' => array(
		array(
		  'link' => '#bio1',
		  'image' => 'http://placekitten.com/g/165/165',
		  'name' => 'Lorenzo Howard',
		  'position' => 'Bellagio Fellow',
		)
	)
);


$context['textBlock'] = array(
	'containerClasses' => $containerClasses,
	'title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam finibus porttitor bibendum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris at nunc ac nibh facilisis vestibulum in vel diam. Integer consectetur ut massa id cursus.',
	'content' => '<p>Integer non lacus est. Duis pretium eget nibh nec pretium. Ut at commodo erat, vel aliquet ante. Nam eros nisi, luctus vitae ipsum at, condimentum egestas orci. Pellentesque fermentum purus sem, eu posuere ante condimentum vel. Praesent porttitor, enim eget aliquam vehicula, dolor tortor mattis magna, et tempus nibh ligula at eros. In volutpat, lacus quis ullamcorper pretium, libero mi ultrices nibh, at congue metus ipsum ut sem. Cras vitae sapien ac urna fermentum sagittis. Nam ultricies metus in augue ornare, a placerat tellus ultrices. Aenean volutpat urna nisl, sed mattis risus aliquam sed. Maecenas congue elementum lorem ac lacinia. Nullam egestas lacinia sem, a posuere mi finibus in. Aenean convallis nibh convallis leo laoreet, quis placerat eros congue.</p> <p>Integer non lacus est. Duis pretium eget nibh nec pretium. Ut at commodo erat, vel aliquet ante. Nam eros nisi, luctus vitae ipsum at, condimentum egestas orci. Pellentesque fermentum purus sem, eu posuere ante condimentum vel. Praesent porttitor, enim eget aliquam vehicula, dolor tortor mattis magna, et tempus nibh ligula at eros. In volutpat, lacus quis ullamcorper pretium, libero mi ultrices nibh, at congue metus ipsum ut sem. Cras vitae sapien ac urna fermentum sagittis. Nam ultricies metus in augue ornare, a placerat tellus ultrices. Aenean volutpat urna nisl, sed mattis risus aliquam sed. Maecenas congue elementum lorem ac lacinia. Nullam egestas lacinia sem, a posuere mi finibus in. Aenean convallis nibh convallis leo laoreet, quis placerat eros congue.</p>'
);


$context['quote'] = array(
	'containerClasses' => $containerClasses,
    'topic' => "",
    'date' => "October 3, 11:45AM",
    'text' => "How can humanity best serve oceans and fish so as to protect their symbiosis?",
    'cite' => "Philo Alto, Amazon"
);


$context['grid6'] = array(
	'containerClasses' => $containerClasses,
	'gridtype' => 'grid-6-2',
	'blocks' => array(
		array(
			'title' => "10k",
			'info' => "Lorem ipsum dolor sit amet, consectetur"
		),
		array(
			'title' => "67%",
			'info' => "Sed do eiusmod tempor incididunt ut labora"
		),
		array(
			'title' => "3M",
			'info' => "Incididunt ut labore et dolore magna aliqua"
		)
	)
);


$context['quote2'] = array(
	'containerClasses' => $containerClasses,
    'topic' => "Perspective on Climate Change",
    'date' => "October 3, 11:45AM",
    'text' => "How can humanity best serve oceans and fish so as to protect their symbiosis?",
    'cite' => "Philo Alto, Amazon"
);


$context['gridA3_1'] = array(
	'containerClasses' => $containerClasses,
	'blocks' => array(
		array(
		  'image' => "http://placekitten.com/g/160/160",
		  'qtext' => 'By definition, we are dealing with a "super wicked challenge" that requires new types of approaches...',
		  'qcite' => 'Valorie Beckham, Bellagio Fellow',
		),
		array(
		  'image' => "http://placekitten.com/g/160/160",
		  'qtext' => 'The idea is very simple: better managed fisheries are more profitable than poorly managed...',
		  'qcite' => 'Daniel Herrera, Bellagio Fellow',
		),
		array(
		  'image' => "http://placekitten.com/g/160/160",
		  'qtext' => 'By definition, we are dealing with a "super wicked challenge" that requires new types of approaches...',
		  'qcite' => 'Valorie Beckham, Bellagio Fellow',
		),
		array(
		  'type' => "more-block"
		)
	)
);


$context['gridA3_3'] = array(
	'containerClasses' => $containerClasses,
	'blocks' => array(
		array(
			'type' => 'spacer',
			'color' => 'white',
		),
		array(
			'color' => 'blue',
			'link' => '#',
			'title' => 'African Media Initiative',
		),
		array(
			'type' => 'spacer',
			'color' => 'extra-light-gray',
		),
		array(
			'color' => 'yellow',
			'link' => '#',
			'title' => 'African Media Initiative',
		),
		array(
			'type' => 'spacer',
			'color' => 'white',
		),
		array(
			'color' => 'blue',
			'link' => '#',
			'title' => 'African Media Initiative',
		),
		array(
			'color' => 'yellow',
			'link' => '#',
			'title' => 'African Media Initiative',
		),
		array(
			'type' => 'spacer',
			'color' => 'white',
		),
		array(
			'color' => 'teal',
			'link' => '#',
			'title' => 'African Media Initiative',
		),
		array(
			'type' => 'spacer',
			'color' => 'white',
		),
		array(
			'type' => 'more-block'
		)
	)
);


$context['gridA4'] = array(
	'containerClasses' => $containerClasses,
	"block1" => array( 
      "link" => "#",
      "title" => "Template 3: Blog 1",
      "date" => "September 13, 2014",
      "subImage" => "http://placekitten.com/325/325",
      "classes" => ""
	),
	"block2" => array( 
      "link" => "#",
      "title" => "Template 3: Blog 2",
      "date" => "September 15, 2014",
      "classes" => "sandstone small-text",
	),
	"block3" => array( 
      "link" => "#",
      "title" => "Template 3: Blog 3",
      "date" => "September 17, 2014",
      "classes" => "yellow small-text",
	),
	"block4" => array( 
      "link" => "#",
      "title" => "Template 3: Blog 4",
      "date" => "September 19, 2014",
      "classes" => "yellow small-text",
	),
	"block5" => array( 
      "link" => "#",
      "subImage" => "http://placekitten.com/g/325/325",
      "title" => "Template 3",
      "date" => "September 24, 2014",
      "classes" => "large-text with-text",
    )
);


$context['timeline'] = array(
	'containerClasses' => $containerClasses,
	'title' => 'Topic 3 Demo',
	'filters' => array(
		'twitter' => 'Field Notes',
		'blog' => 'Stories'
	),
	'events' => array(
		array(
	        "id" => "e1",
	        "type" => "blog",
	        "image" => "http://placekitten.com/g/320/320",
	        "title" => "To save our fisheries, we need a new approach. The world may be running out of fish, but are we also running out of approaches to the problem?",
	        "author" => "Banny Banerlier",
	        "authorLink" => "#banny",
	        "date" => "1411880385",
	        "link" => "#blog-post"
		),
		array(
	        "id" => "e2",
	        "type" => "blog",
	        "image" => "http://placekitten.com/g/320/320",
	        "title" => "To save our fisheries, we need a new approach. The world may be running out of fish, but are we also running out of approaches to the problem?",
	        "author" => "Banny Banerlier",
	        "authorLink" => "#banny",
	        "date" => "1411880385",
	        "link" => "#blog-post"
		),
		array(
	        "id" => "e3",
	        "type" => "blog",
	        "image" => "http://placekitten.com/g/320/320",
	        "title" => "To save our fisheries, we need a new approach. The world may be running out of fish, but are we also running out of approaches to the problem?",
	        "author" => "Banny Banerlier",
	        "authorLink" => "#banny",
	        "date" => "1411880385",
	        "link" => "#blog-post"
		),
		array(
	        "id" => "e4",
	        "type" => "blog",
	        "image" => "http://placekitten.com/g/320/320",
	        "title" => "To save our fisheries, we need a new approach. The world may be running out of fish, but are we also running out of approaches to the problem?",
	        "author" => "Banny Banerlier",
	        "authorLink" => "#banny",
	        "date" => "1411880385",
	        "link" => "#blog-post"
		),
		array(
	        "id" => "e5",
	        "type" => "blog",
	        "image" => "http://placekitten.com/g/320/320",
	        "title" => "To save our fisheries, we need a new approach. The world may be running out of fish, but are we also running out of approaches to the problem?",
	        "author" => "Banny Banerlier",
	        "authorLink" => "#banny",
	        "date" => "1411880385",
	        "link" => "#blog-post"
		),
		array(
	        "id" => "e6",
	        "type" => "blog",
	        "image" => "http://placekitten.com/g/320/320",
	        "title" => "To save our fisheries, we need a new approach. The world may be running out of fish, but are we also running out of approaches to the problem?",
	        "author" => "Banny Banerlier",
	        "authorLink" => "#banny",
	        "date" => "1411880385",
	        "link" => "#blog-post"
		),
		array(
	        "id" => "e7",
	        "type" => "blog",
	        "image" => "http://placekitten.com/g/320/320",
	        "title" => "To save our fisheries, we need a new approach. The world may be running out of fish, but are we also running out of approaches to the problem?",
	        "author" => "Banny Banerlier",
	        "authorLink" => "#banny",
	        "date" => "1411880385",
	        "link" => "#blog-post"
		),
		array(
	        "id" => "e8",
	        "type" => "blog",
	        "image" => "http://placekitten.com/g/320/320",
	        "title" => "To save our fisheries, we need a new approach. The world may be running out of fish, but are we also running out of approaches to the problem?",
	        "author" => "Banny Banerlier",
	        "authorLink" => "#banny",
	        "date" => "1411880385",
	        "link" => "#blog-post"
		),
	)
);


$context['newsletter'] = array(
	"title" => "Newsletter—Stay updated on Climate Change"
);


Timber::render('template-3.twig', $context);