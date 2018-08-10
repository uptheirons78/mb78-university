<?php get_header(); ?>

<!--WORDPRESS LOOP-->
<?php if( have_posts() ) : while ( have_posts() ) : ?>
<?php the_post(); ?>
<?php pageBanner(); ?>
  
  <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p>
        <a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>">
          <i class="fa fa-home" aria-hidden="true"></i>
          Blog Home
        </a> 
        <span class="metabox__main">Posted by <?php the_author_posts_link(); ?> on <?php the_time('d M Y'); ?> in <?php echo get_the_category_list(', '); ?>
        </span>
      </p>
    </div>
    <div class="generic-content">
      <?php the_content(); ?>  
    </div>
  </div>
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>