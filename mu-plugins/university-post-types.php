<?php 

//CREATE CUSTOM POST TYPES
	function university_post_types() {
		//EVENT POST TYPE
		register_post_type('event', array(
			'supports' => array('title', 'editor', 'excerpt'),
			'rewrite' => array('slug' => 'events'),
			'has_archive' => true,
			'public' => true, //visible for editors and viewers of the website
			'labels' => array(
				'name' => 'Events', //name	in dashboard
				'add_new_item' => 'Add New Event',
				'edit_item' => 'Edit Event',
				'all_items' => 'All Events',
				'singular_name' => 'Event'
			),
			'menu_icon' => 'dashicons-calendar-alt', //dashboard icon
			
		));
		
		//PROGRAM POST TYPE
		register_post_type('program', array(
			'supports' => array('title', 'editor'),
			'rewrite' => array('slug' => 'programs'),
			'has_archive' => true,
			'public' => true, //visible for editors and viewers of the website
			'labels' => array(
				'name' => 'Programs', //name	in dashboard
				'add_new_item' => 'Add New Program',
				'edit_item' => 'Edit Program',
				'all_items' => 'All Programs',
				'singular_name' => 'Program'
			),
			'menu_icon' => 'dashicons-awards', //dashboard icon
			
		));
		
		//PROFESSOR POST TYPE
		register_post_type('professor', array(
			'supports' => array('title', 'editor', 'thumbnail'),
			'public' => true, //visible for editors and viewers of the website
			'labels' => array(
				'name' => 'Professors', //name	in dashboard
				'add_new_item' => 'Add New Professor',
				'edit_item' => 'Edit Professor',
				'all_items' => 'All Professors',
				'singular_name' => 'Professor'
			),
			'menu_icon' => 'dashicons-welcome-learn-more', //dashboard icon
			
		));
		
		//CAMPUS POST TYPE
		register_post_type('campus', array(
			'supports' => array('title', 'editor', 'excerpt'),
			'rewrite' => array('slug' => 'campuses'),
			'has_archive' => true,
			'public' => true, //visible for editors and viewers of the website
			'labels' => array(
				'name' => 'Campuses', //name	in dashboard
				'add_new_item' => 'Add New Campus',
				'edit_item' => 'Edit Campus',
				'all_items' => 'All Campuses',
				'singular_name' => 'Campus'
			),
			'menu_icon' => 'dashicons-location-alt', //dashboard icon
			
		));
	}
	add_action('init', 'university_post_types');

?>