<?php
/*
Template Name: How to Apply
*/

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

$containerClasses = 'borderless';

if( $post->parent ) {
  $parent = $post->parent->post_title;
} else {
  $parent = 'Home';
}

$context['header'] = array(
  "breadcrumb" => $parent . " / " . $post->post_title,
  "currentPage" => $post->post_title,
  "headerTitle" => $post->post_title,
  "type" => "white"
);

$context['textBlock'] = array(
  'containerClasses' => $containerClasses,
  'title' => $post->get_field('introduction'),
  'content' => $post->post_content
);

$context['howToApply'] = array(
  'title' => $post->post_title,
  'content' => $post->get_field('rail_content')
);

$context['newsletter'] = array(
  "title" => "Newsletter—Stay updated on Climate Change"
);


Timber::render('template-3.twig', $context);