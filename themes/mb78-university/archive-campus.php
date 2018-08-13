<?php  get_header(); ?>
<?php pageBanner(array(
  'title' => 'Our Campuses',
  'subtitle' => 'We have different campuses for everyone'
)) ?>

<div class="container container--narrow page-section">
  
  <div class="acf-map">
  <?php if( have_posts() ) : ?>
  <?php while( have_posts() ) : the_post() ?>
  	<?php $mapLocation = get_field('map_location'); ?>
  	<div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng'] ?>">
  		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
  		<?php echo $mapLocation['address']; ?>
  	</div>
  <?php endwhile; ?>
  <?php endif; ?>
  </div>
  
</div>
  
<?php get_footer(); ?>