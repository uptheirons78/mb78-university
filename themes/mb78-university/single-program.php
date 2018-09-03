<?php get_header(); ?>

<!--WORDPRESS LOOP-->
<?php if( have_posts() ) : while ( have_posts() ) : ?>
<?php the_post(); ?>
<?php pageBanner(); ?>
  
  <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p>
        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program') ?>">
          <i class="fa fa-home" aria-hidden="true"></i>
          All Programs
        </a> 
        <span class="metabox__main"><?php the_title(); ?>
        </span>
      </p>
    </div>
    <div class="generic-content">
      <?php the_field('main_body_content'); ?>  
    </div>
    
    <?php
      $relatedProfessors = new WP_Query(array(
        'posts_per_page' => -1, // -1 will return all events posts
        'post_type' => 'professor',
        'orderby' => 'title', //this is how to order the custom query
        'order' => 'ASC', //ASC = ascending or DESC = descending (default value)
        'meta_query' => array(
          array( //this for filtering professors related to the page program
          	'key' => 'related_programs',
          	'compare' => 'LIKE',
          	'value' => '"' . get_the_ID() . '"'
          )
        )
      ));  
    ?>
    <?php if( $relatedProfessors->have_posts() ) : ?>
    
    		<?php echo '<hr class="section-break">'; ?>
		    <?php echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>'; ?>
		    <?php if($relatedProfessors->have_posts()) : ?>
		    <ul class="professor-cards">
		    <?php while($relatedProfessors->have_posts()) : $relatedProfessors->the_post(); ?>
		      <li class="professor-card__list-item">
		        <a class="professor-card" href="<?php the_permalink(); ?>">
		        <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>">
		        <span class="professor-card__name"><?php the_title(); ?></span>
		        </a>
		      </li>
		    <?php endwhile; ?>
		    <?php endif; ?>
		    </ul>
		 <?php endif; ?>
		 <?php wp_reset_postdata(); //reset global post object...use it when u run multiple custom queries on a page ?>
    
    <?php
      $today = date('Ymd'); //TODAY date in PHP
      $homepageEvents = new WP_Query(array(
        'posts_per_page' => 2, // -1 will return all events posts
        'post_type' => 'event',
        'meta_key' => 'event_date',
        'orderby' => 'meta_value_num', //this is how to order the custom query
        'order' => 'ASC', //ASC = ascending or DESC = descending (default value)
        'meta_query' => array( //this for filtering past events, they'll be escluded from home page events section
          array(
            'key' => 'event_date',
            'compare' => '>=',
            'value' => $today,
            'type' => 'numeric'
          ),
          array( //this for filtering events related to the page program
          	'key' => 'related_programs',
          	'compare' => 'LIKE',
          	'value' => '"' . get_the_ID() . '"'
          )
        )
      ));  
    ?>
    <?php if( $homepageEvents->have_posts() ) : ?>
    
    		<?php echo '<hr class="section-break">'; ?>
		    <?php echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>'; ?>
		    
		    <?php if($homepageEvents->have_posts()) : ?>
		    <?php while($homepageEvents->have_posts()) : $homepageEvents->the_post(); ?>
		      <?php get_template_part('template-parts/content-event'); ?>
		    <?php endwhile; ?>
		    <?php endif; ?>
		    
		 <?php endif; ?>
    
    <?php wp_reset_postdata(); ?>
    <?php $relatedCampuses = get_field('related_campus'); ?>
    
    <?php if ($relatedCampuses) : ?>
      <?php echo '<hr class="section-break">'; ?>
      <?php echo "<h2 class='headline headline--medium'>" . get_the_title() . " is available at these campuses:</h2>"; ?>
      <ul class="min-list link-list">
        <?php 
          foreach($relatedCampuses as $campus) {
        ?>
          <li><a href="<?php echo get_the_permalink($campus); ?>"><?php echo get_the_title($campus); ?></a></li>
        <?php  }
        ?>
      </ul>
    <?php endif;?>
    
  </div>
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>