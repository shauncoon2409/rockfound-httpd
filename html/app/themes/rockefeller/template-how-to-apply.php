<?php
/*
Template Name: How to Apply
*/

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

$containerClasses = 'borderless';

$context['header'] = array(
  "breadcrumb" => "Home / How to Apply ",
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
  'title' => 'How to Apply',
  'content' => $post->get_field('rail_content')
);

$context['newsletter'] = array(
  "title" => "Newsletter—Stay updated on Climate Change"
);


Timber::render('template-3.twig', $context);