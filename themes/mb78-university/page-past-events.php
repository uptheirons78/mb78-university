<?php  get_header(); ?>
<?php pageBanner(array(
  'title' => 'Our Past Events',
  'subtitle' => 'See what we did at the university.'
)) ?>

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
  
  <?php get_template_part('template-parts/content-event'); ?>
  
  <?php endwhile; ?>
  <?php endif; ?>
  
  <?php echo paginate_links(array(
  	'total' => $pastEvents->max_num_pages
  )); ?>
  
</div>
  
<?php get_footer(); ?>