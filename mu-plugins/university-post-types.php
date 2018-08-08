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
	}
	add_action('init', 'university_post_types');

?>