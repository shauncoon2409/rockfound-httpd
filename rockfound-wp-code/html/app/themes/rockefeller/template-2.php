<?php
/*
Template Name: Template 2 (Regions)
*/

$context = Timber::get_context();
$post = new TimberPost();

$context['breadcrumb'] = "Our Work / Regions /";
$context['currentPage'] = 'All Regions';

$context['mapPath'] = get_stylesheet_directory_uri() . '/assets/dist/images/regionsmap.svg';

Timber::render('template-2.twig', $context);