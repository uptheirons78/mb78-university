<?php get_header(); ?>

<!--WORDPRESS LOOP-->
<?php if( have_posts() ) : while ( have_posts() ) : ?>
<?php the_post(); ?>
<?php pageBanner(); ?>
  
  <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p>
        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus') ?>">
          <i class="fa fa-home" aria-hidden="true"></i>
          All Campuses
        </a> 
        <span class="metabox__main"><?php the_title(); ?>
        </span>
      </p>
    </div>
    
    <div class="generic-content">
      <?php the_content(); ?>  
    </div>
    <div class="acf-map">
	  
	  	<?php $mapLocation = get_field('map_location'); ?>
	  	<div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng'] ?>">
	  		<h3><?php the_title(); ?></h3>
	  		<?php echo $mapLocation['address']; ?>
	  	</div>
	  
	  </div>
    
    
    <?php
      $relatedPrograms = new WP_Query(array(
        'posts_per_page' => -1, // -1 will return all events posts
        'post_type' => 'program',
        'orderby' => 'title', //this is how to order the custom query
        'order' => 'ASC', //ASC = ascending or DESC = descending (default value)
        'meta_query' => array(
          array( //this for filtering professors related to the page program
          	'key' => 'related_campus',
          	'compare' => 'LIKE',
          	'value' => '"' . get_the_ID() . '"'
          )
        )
      ));  
    ?>
    <?php if( $relatedPrograms->have_posts() ) : ?>
    
    		<?php echo '<hr class="section-break">'; ?>
		    <?php echo '<h2 class="headline headline--medium">Programs Available at this Campus</h2>'; ?>
		    <?php if($relatedPrograms->have_posts()) : ?>
		    <ul class="min-list link-list">
		    <?php while($relatedPrograms->have_posts()) : $relatedPrograms->the_post(); ?>
		      <li >
		        <a  href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		      </li>
		    <?php endwhile; ?>
		    <?php endif; ?>
		    </ul>
		 <?php endif; ?>
		 <?php wp_reset_postdata(); //reset global post object...use it when u run multiple custom queries on a page ?>
    
  </div>
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>