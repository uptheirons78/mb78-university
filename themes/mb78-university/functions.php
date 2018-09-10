<?php
	//this fs to manage page banner in professor, event and program pages
	function pageBanner($args = NULL) {
		if(!$args['title']) {
			$args['title'] = get_the_title();
		}
		
		if(!$args['subtitle']) {
			$args['subtitle'] = get_field('page_banner_subtitle');
		}
		
		if(!$args['photo']) {
			if( get_field('page_banner_background_image') ) {
				$args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
			} else {
				$args['photo'] = get_theme_file_uri('/images/ocean.jpg');
			}
			
		}
?>
		<div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo'] ?>);">
      </div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
        <div class="page-banner__intro">
          <p><?php echo $args['subtitle'] ?></p>
        </div>
      </div>  
    </div>
<?php
	}
?>


<?php

	//include a file for staying organize
	require get_theme_file_path('/inc/search-route.php');
	require get_theme_file_path('/inc/like-route.php');
	
	// add customs endpoint for Wordpress Rest API
	function university_custom_rest() {
		//register_rest_field: 3 params - post type, field name, callback function to retrieve and add data to JSON
		//it is possible to add as many fields as you want !
		register_rest_field('post', 'authorName', [
			'get_callback' => function() {return get_the_author();}	
		]);	
		
		//add a field in rest api for counting how many notes a user published
		register_rest_field('note', 'userNoteCount', [
			'get_callback' => function() {
				return count_user_posts(get_current_user_id(), 'note');
			}	
		]);	
	}
	
	add_action('rest_api_init', 'university_custom_rest');
	
	function university_files() {
		//wp_enqueue_script is used to load JS files
		//third arg: indicates if js file has or not dependencies
		//fourth arg is about the version
		//fifth arg, a boolean, is about you want or not to load js before or not the bottom of the body tag
		//Google Maps
		wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=' . getenv('GMAPS'), NULL, '1.0', true);
		//ATTENTION: only in development use microtime() to avoid caching. NEVER ON LIVE PRODUCTION
		wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);
		//wp_enqueue_style is used to load CSS, font-awesome, fonts
		wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
		wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
		wp_enqueue_style('university_main_styles', get_stylesheet_uri(), NULL, microtime());
		//Useful to create a RELATIVE URL for live search results (made with JS and not PHP)
		wp_localize_script('main-university-js', 'universityData', array(
				'root_url' => get_site_url(),
				'nonce' => wp_create_nonce('wp_rest') //it creates a randomly generated number for a user session
			));
	}
	//with this we tell wp what to do
	//first arg: it is what type of instruction we are going to give wp
	//second arg: it gives wp the name of function we are going to run (we create the function)
	add_action('wp_enqueue_scripts', 'university_files');
	
	function university_features() {
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails'); //featured images
		//IMAGES
		add_image_size('professorLandscape', 400, 260, true); //nickname, width, height, crop or not
		add_image_size('professorPortrait', 480, 620, true); //nickname, width, height, crop or not
		add_image_size('pageBanner', 1500, 350, true); //nickname, width, height, crop or not
		//register custom menus
		register_nav_menu('headerMenuLocation', 'Header Menu Location');
		register_nav_menu('footerAMenuLocation', 'Footer A Menu Location');
		register_nav_menu('footerBMenuLocation', 'Footer B Menu Location');
	}
	add_action('after_setup_theme', 'university_features');
	
	//QUERIES based on URL 
	function university_adjust_queries($query) {
		$today = date('Ymd');
		//is_admin() return true if you are on admin dashboard, we don't want to modify dashboard behaviour
		
		if( !is_admin() && is_post_type_archive('campus') && $query->is_main_query() ) {
			$query->set('posts_per_page', -1);
		}		
		
		if( !is_admin() && is_post_type_archive('program') && $query->is_main_query() ) {
			$query->set('orderby', 'title');
			$query->set('order', 'ASC');
			$query->set('posts_per_page', -1);
		}
		
		
		if( !is_admin() && is_post_type_archive('event') && $query->is_main_query() ) {
			$query->set('meta_key', 'event_date');
			$query->set('orderby', 'meta_value_num');
			$query->set('order', 'ASC');
			//next query filter past events. we don't want to show them in events archive page
			$query->set('meta_query', array( 
				array (
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
              )  
      ));
		}
	}
	add_action('pre_get_posts', 'university_adjust_queries');
	
	//Add Google Maps API Key to ADVANCED CUSTOM FIELDS
	function universityMapKey($api) {
		$api['key'] = getenv('GMAPS'); //using an ENV VARIABLE
		return $api;
	}
	add_filter('acf/fields/google_map/api', 'universityMapKey');
	
	// Redirect subscriber accounts  out of admin dashboard and onto the home page
	function redirectSubsToFrontend() {
		
		$ourCurrentUser = wp_get_current_user();
		
		if( count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] == 'subscriber' ) {
			
			wp_redirect( site_url('/') );
			exit;
			
		}
	}
	add_action('admin_init', 'redirectSubsToFrontend');
	
	// Remove admin bar when a simple subscriber account is logged in
	function removeAdminBarForSubscribers() {
		
		$ourCurrentUser = wp_get_current_user();
		
		if( count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] == 'subscriber' ) {
			
			show_admin_bar(false);
			
		}
	}
	add_action('wp_loaded', 'removeAdminBarForSubscribers');
	
	//CUSTOMIZE LOGIN SCREEN
	
	function ourHeaderUrl() {
		return esc_url( site_url('/') );
	}
	add_filter('login_headerurl', 'ourHeaderUrl'); //change the url on login page icon hover (usually Wordpress.org);
	
	
	function ourLoginCSS() {
		wp_enqueue_style('university_main_styles', get_stylesheet_uri(), NULL, microtime());
		wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
	}
	add_action('login_enqueue_scripts', 'ourLoginCSS'); //add stylesheets also to login screen (and Google Fonts if you want)
	
	
	function ourLoginTitle() {
		return get_bloginfo('name');
	}
	add_filter('login_headertitle', 'ourLoginTitle'); //change Wordpress icon on login screen with the site title
	
	
	
	
	// Force Note Posts to be PRIVATE
	// 10 is function priority, the lower the number the earlier it will run
	// 2 is the number of paramenters for the function
	add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);
	
	function makeNotePrivate($data, $postarr) {
			// if post type is NOTE
			if($data['post_type'] == 'note') {
				// only if current user has more than 4 NOTE POSTS and they are not trashed (!$postarr['ID'])),
				// so they have an ID ...
				if (count_user_posts(get_current_user_id(), 'note') > 4 && !$postarr['ID']) {
					// 1. prevent him to post a new one
					die("Reached Limit");
				}
				// 2. sanitize data both in title and body field to avoid html
				$data['post_title'] = sanitize_text_field($data['post_title']); // avoid html in title
				$data['post_content'] = sanitize_textarea_field($data['post_content']); // avoid html in body
			}
			
			// if post type is NOTE and its status is not trash
			if($data['post_type'] == 'note' && $data['post_status'] != 'trash') {
				// 3. set the status to be PRIVATE
				$data['post_status'] = 'private';
				
			}
			return $data;
	}
	
	
	
	
	
	
	
	
	

?>