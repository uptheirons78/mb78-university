<?php  get_header(); ?>
  
<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>);"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">Our Past Events</h1>
    <div class="page-banner__intro">
      <p>See what we did at the university</p>
    </div>
  </div>  
</div>

<div class="container container--narrow page-section">
  <?php
  	//CREATE A CUSTOM QUERY FOR PAST EVENTS
  	$today = date('Ymd'); //TODAY date in PHP
    $pastEvents = new WP_Query(array(
      'paged' => get_query_var('paged', 1),//we need it for pagination!!!!!
      'post_type' => 'event',
      'meta_key' => 'event_date',
      'orderby' => 'meta_value_num', //this is how to order the custom query
      'order' => 'ASC', //ASC = ascending or DESC = descending (default value)
      'meta_query' => array( //this for filtering past events, they'll be escluded from home page events section
        array(
          'key' => 'event_date',
          'compare' => '<',
          'value' => $today,
          'type' => 'numeric'
        )  
      )
    )); 
  ?>
  <?php if( $pastEvents->have_posts() ) : ?>
  <?php while( $pastEvents->have_posts() ) : $pastEvents->the_post() ?>
  
    <div class="event-summary">
      <a class="event-summary__date t-center" href="#">
        <span class="event-summary__month"><?php
          //THIS IS HOW TO USE THE CUSTOM FIELD EVENT DATE: get_field() and the_field()
          $eventDate = new DateTime( get_field('event_date') ); //DateTime is a PHP class
          echo $eventDate->format('M');
        ?></span>
        <span class="event-summary__day"><?php echo $eventDate->format('d'); ?></span>  
      </a>
      <div class="event-summary__content">
        <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
        <p><?php echo wp_trim_words(get_the_content(), 18); ?> <a href="#" class="nu gray">Learn more</a></p>
      </div>
    </div>
  
  <?php endwhile; ?>
  <?php endif; ?>
  
  <?php echo paginate_links(array(
  	'total' => $pastEvents->max_num_pages
  )); ?>
  
</div>
  
<?php get_footer(); ?>