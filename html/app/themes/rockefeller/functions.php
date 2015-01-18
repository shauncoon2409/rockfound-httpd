<?php

	if (!class_exists('Timber')){
		add_action( 'admin_notices', function(){
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . admin_url('plugins.php#timber') . '">' . admin_url('plugins.php') . '</a></p></div>';
		});
		return;
	}

	require_once('functions/admin-menu-fixes.php');
	require_once('functions/theme-setup.php');
	require_once('functions/acf-fields-export.php');
	require_once('functions/acf-options-page.php');

	class StarterSite extends TimberSite {

		function __construct(){
			add_theme_support('post-formats');
			add_theme_support('post-thumbnails');
			add_theme_support('menus');
			add_filter('timber_context', array($this, 'add_to_context'));
			add_filter('get_twig', array($this, 'add_to_twig'));
			add_action('init', array($this, 'register_post_types'));
			add_action('init', array($this, 'register_taxonomies'));
			parent::__construct();
		}

		function register_post_types() {
			require('functions/custom-post-types.php');
		}

		function register_taxonomies() {
			require('functions/custom-taxonomies.php');
		}

		function add_to_context($context) {
			$context['foo'] = 'bar';
			$context['stuff'] = 'I am a value set in your functions.php file';
			$context['notes'] = 'These values are available everytime you call Timber::get_context();';
			$context['menu'] = new TimberMenu();
			$context['site'] = $this;
			return $context;
		}

		function add_to_twig($twig) {
			/* this is where you can add your own fuctions to twig */
			$twig->addExtension(new Twig_Extension_StringLoader());
			$twig->addFilter('myfoo', new Twig_Filter_Function('myfoo'));
			return $twig;
		}

	}

	new StarterSite();

	require_once('functions/timber-helpers.php');
