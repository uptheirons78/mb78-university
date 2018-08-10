<?php  get_header(); ?>
<?php pageBanner(array(
  'title' => 'All Events',
  'subtitle' => 'See what is going on our world'
)) ?>
  
<div class="container container--narrow page-section">
  
  <?php if( have_posts() ) : ?>
  <?php while( have_posts() ) : the_post() ?>
  
  <?php get_template_part('template-parts/content-event'); ?>
  
  <?php endwhile; ?>
  <?php endif; ?>
  
  <?php echo paginate_links(); ?>
  
  <hr class="section-break">
  <p>Looking for our past events ? <a href="<?php echo site_url('/past-events') ?>">Check out past events archive.</a></p>
  
</div>
  
<?php get_footer(); ?>