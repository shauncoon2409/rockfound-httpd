<?php

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post; // Main post for the page.

$containerClasses = 'borderless full-width';


// Set header info.
// --------------------------

$context['header'] = array(
  "breadcrumb" => "Careers / Career ",
  "currentPage" => $post->post_title,
  "headerTitle" => $post->post_title,
  "type" => "internal yellow"
);


// Set Content (textblock)
// --------------------------
$context['textBlock'] = array(
  'containerClasses' => $containerClasses,
  'title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam finibus porttitor bibendum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris at nunc ac nibh facilisis vestibulum in vel diam. Integer consectetur ut massa id cursus.',
  'content' => $post->post_content
);



// Set Newsletter Info
// --------------------------

$context['newsletter'] = array(
  "title" => "Newsletter"
);


Timber::render('template-3.twig', $context);