<?php 

//CREATE CUSTOM POST TYPES
	function university_post_types() {
		//EVENT POST TYPE
		register_post_type('event', array(
			'capability_type' => 'event', //to add custom post type to Members "create new role"
			'map_meta_cap' => true, //to add custom post type to Members "create new role"
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
			'supports' => array('title'),
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
			'show_in_rest' => true,
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
			'capability_type' => 'campus',
			'map_meta_cap' => true,
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
		
		//NOTES POST TYPE
		register_post_type('note', array(
			'capability_type' => 'note', //give permissions to note post type
			'map_meta_cap' => true, //allows to give permissions
			'show_in_rest' => true, //make it visible in WP REST API
			'supports' => array('title', 'editor'), //show these items in Create New Note page 
			'public' => false, // !visible for editors and viewers of the website
			'show_ui' => true, // visible in dashboard for the user
			'labels' => array(
				'name' => 'Notes', //name	in dashboard
				'add_new_item' => 'Add New Note',
				'edit_item' => 'Edit Note',
				'all_items' => 'All Notes',
				'singular_name' => 'Note'
			),
			'menu_icon' => 'dashicons-welcome-write-blog', //dashboard icon
		));
		
		//LIKES POST TYPE
		register_post_type('like', array(
			'supports' => array('title'), 
			'public' => false,
			'show_ui' => true, // visible in dashboard for the user
			'labels' => array(
				'name' => 'Likes', //name	in dashboard
				'add_new_item' => 'Add New Like',
				'edit_item' => 'Edit Like',
				'all_items' => 'All Likes',
				'singular_name' => 'Like'
			),
			'menu_icon' => 'dashicons-heart', //dashboard icon
		));
	}
	add_action('init', 'university_post_types');

?>