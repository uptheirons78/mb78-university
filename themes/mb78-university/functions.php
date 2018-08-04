<?php

	function university_files() {
		//wp_enqueue_script is used to load JS files
		//third arg: indicates if js file has or not dependencies
		//fourth arg is about the version
		//fifth arg, a boolean, is about you want or not to load js before or not the bottom of the body tag
		//ATTENTION: only in development use microtime() to avoid caching. NEVER ON LIVE PRODUCTION
		wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);
		//wp_enqueue_style is used to load CSS, font-awesome, fonts
		wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
		wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
		wp_enqueue_style('university_main_styles', get_stylesheet_uri(), NULL, microtime());
	}
	//with this we tell wp what to do
	//first arg: it is what type of instruction we are going to give wp
	//second arg: it gives wp the name of function we are going to run (we create the function)
	add_action('wp_enqueue_scripts', 'university_files');
	
	function university_features() {
		add_theme_support('title-tag');
		//register custom menus
		register_nav_menu('headerMenuLocation', 'Header Menu Location');
		register_nav_menu('footerAMenuLocation', 'Footer A Menu Location');
		register_nav_menu('footerBMenuLocation', 'Footer B Menu Location');
	}
	add_action('after_setup_theme', 'university_features');

?>