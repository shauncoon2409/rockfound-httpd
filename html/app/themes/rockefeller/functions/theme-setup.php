<?php

	add_theme_support('soil-clean-up');         // Enable clean up from Soil
	add_theme_support('soil-relative-urls');    // Enable relative URLs from Soil
	add_theme_support('soil-nice-search');      // Enable /?s= to /search/ redirect from Soil
	add_theme_support('jquery-cdn');            // Enable to load jQuery from the Google CDN

	function rocke_theme_support() {
		add_theme_support('title-tag');
		add_theme_support('html5', array('caption', 'comment-form', 'comment-list'));
		// add_editor_style('/assets/css/editor-style.css');
	}
	add_action('after_setup_theme', 'rocke_theme_support');


	function rocke_scripts() {

		if (WP_ENV === 'development' || WP_ENV === 'local') {
			$assets = array(
				'css'       => '/assets/dist/css/all.css',
				'js'        => '/assets/dist/js/main.js',
				'jquery'    => '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js'
			);
		} else {
			$assets     = array(
				'css'       => '/assets/dist/' . asset_path('css/all.min.css'),
				'js'        => '/assets/dist/' .  asset_path('js/main.min.js'),
				'jquery'    => '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'
			);
		}

		// Add compiled stylesheet.
		wp_enqueue_style('rocke_css', get_template_directory_uri() . $assets['css'], false, null);

		// Add jQuery CDN
		wp_deregister_script('jquery');
		wp_register_script('jquery', $assets['jquery'], array(), null, true);
		add_filter('script_loader_src', 'rocke_jquery_local_fallback', 10, 2);

		// Add script files.
		wp_enqueue_script('jquery');
		wp_enqueue_script('rocke_js', get_template_directory_uri() . $assets['js'], array(), null, true);
	}
	add_action('wp_enqueue_scripts', 'rocke_scripts', 100);


	// Add local jQuery fallback script.
	// http://wordpress.stackexchange.com/a/12450
	function rocke_jquery_local_fallback($src, $handle = null) {
		static $add_jquery_fallback = false;
		
		if ($add_jquery_fallback) {
			echo '<script>window.jQuery || document.write(\'<script src="' . get_template_directory_uri() . '/assets/vendor/jquery/dist/jquery.min.js?1.11.1"><\/script>\')</script>' . "\n";
			$add_jquery_fallback = false;
		}
		
		if ($handle === 'jquery') {
			$add_jquery_fallback = true;
		}
		
		return $src;
	}
	add_action('wp_head', 'rocke_jquery_local_fallback');


	function asset_path($filename) {
		$manifest_path = get_template_directory() . '/assets/dist/rev-manifest.json';
		$manifest = array();

		if (file_exists($manifest_path)) {
			$manifest = json_decode(file_get_contents($manifest_path), TRUE);
		}

		if (array_key_exists($filename, $manifest)) {
			return $manifest[$filename];
		}

		return $filename;
	}