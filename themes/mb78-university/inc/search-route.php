<?php

	add_action('rest_api_init', 'universityRegisterSearch');
	
	function universityRegisterSearch() {
		register_rest_route('university/v1', 'search', [
			'methods' => WP_REST_SERVER::READABLE, //also simple 'GET', but this is safer in any kind of hosting server
			'callback' => 'universitySearchResults'
		]);
	}
	
	function universitySearchResults($data) {
		$mainQuery = new WP_Query([
			'post_type' => ['post', 'page', 'professor', 'event', 'campus', 'program'],
			's' => sanitize_text_field($data['term']) //search params
		]);
		
		$results = [
			'generalInfo' => [],
			'professors' => [],
			'programs' => [],
			'events' => [],
			'campuses' => [],
		];
		
		while( $mainQuery->have_posts() ) {
			$mainQuery->the_post();
			
			if(get_post_type() == 'post' || get_post_type() == 'page') {
				array_push($results['generalInfo'], [
					'title' => get_the_title(),
					'permalink' => get_the_permalink()
				]);
			}
			
			if(get_post_type() == 'professor') {
				array_push($results['professors'], [
					'title' => get_the_title(),
					'permalink' => get_the_permalink()
				]);
			}			
			
			if(get_post_type() == 'campus') {
				array_push($results['campuses'], [
					'title' => get_the_title(),
					'permalink' => get_the_permalink()
				]);
			}
			
			if(get_post_type() == 'program') {
				array_push($results['programs'], [
					'title' => get_the_title(),
					'permalink' => get_the_permalink()
				]);
			}
			
			if(get_post_type() == 'event') {
				array_push($results['events'], [
					'title' => get_the_title(),
					'permalink' => get_the_permalink()
				]);
			}
			
		}
		
		return $results;
	}
	
?>