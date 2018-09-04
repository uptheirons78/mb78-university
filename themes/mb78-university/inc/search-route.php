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
					'permalink' => get_the_permalink(),
					'postType' => get_post_type(),
					'authorName' => get_the_author()
				]);
			}
			
			if(get_post_type() == 'professor') {
				array_push($results['professors'], [
					'title' => get_the_title(),
					'permalink' => get_the_permalink(),
					'image' => get_the_post_thumbnail_url(0, 'professorLandscape'),
				]);
			}			
			
			if(get_post_type() == 'campus') {
				array_push($results['campuses'], [
					'title' => get_the_title(),
					'permalink' => get_the_permalink()
				]);
			}
			
			if(get_post_type() == 'program') {
				$relatedCampuses = get_field('related_campus'); //containes all related campuses of a program
				
				//if there are related campuses
				if ($relatedCampuses) {
					//loop through them
					foreach($relatedCampuses as $campus) {
						//push them inside $results['campuses'] creating a title and a permalink key-value pair
						array_push($results['campuses'], [
							'title' => get_the_title($campus),	
							'permalink' => get_the_permalink($campus)	
						]);
					}
				}
				
				array_push($results['programs'], [
					'title' => get_the_title(),
					'permalink' => get_the_permalink(),
					'id' => get_the_id()
				]);
			}
			
			if(get_post_type() == 'event') {
				$eventDate = new DateTime( get_field('event_date') );
				$description = null;
				if(has_excerpt()) {
		      $description = get_the_excerpt();
		    } else {
		      $description = wp_trim_words(get_the_content(), 18);
		    }
				
				array_push($results['events'], [
					'title' => get_the_title(),
					'permalink' => get_the_permalink(),
					'month' => $eventDate->format('M'),
					'day' => $eventDate->format('d'),
					'description' => $description
				]);
			}
			
		}
		
		if($results['programs']) {
			
			$programsMetaQuery = ['relation' => 'OR'];
			
			foreach($results['programs'] as $item) {
				array_push($programsMetaQuery, [
						'key' => 'related_programs',
						'compare' => 'LIKE',
						'value' => '"' . $item['id'] . '"'
					]);
			}
			
			
			
			$programRelationshipQuery = new WP_Query([
				'post_type' => ['professor', 'event'],
				'meta_query' => $programsMetaQuery
			]);
			
			while($programRelationshipQuery->have_posts()) {
				$programRelationshipQuery->the_post();
			
				if(get_post_type() == 'professor') {
					array_push($results['professors'], [
						'title' => get_the_title(),
						'permalink' => get_the_permalink(),
						'image' => get_the_post_thumbnail_url(0, 'professorLandscape'),
					]);
				}
				
				if(get_post_type() == 'event') {
					$eventDate = new DateTime( get_field('event_date') );
					$description = null;
					if(has_excerpt()) {
			      $description = get_the_excerpt();
			    } else {
			      $description = wp_trim_words(get_the_content(), 18);
			    }
					
					array_push($results['events'], [
						'title' => get_the_title(),
						'permalink' => get_the_permalink(),
						'month' => $eventDate->format('M'),
						'day' => $eventDate->format('d'),
						'description' => $description
					]);
				}
				
			}
			
			// to avoid duplicates in the array created by the above queries, due to the presence of search term in the body of professors post type
			// ex: search term "biology", a program, but the word is also in the description of a professor like "I love biology"
			$results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
			$results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
			
		}
		
		return $results;
	}
	
?>