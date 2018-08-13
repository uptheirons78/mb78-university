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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

?>