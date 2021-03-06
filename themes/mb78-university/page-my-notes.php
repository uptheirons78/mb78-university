<?php
	//if a User is not logged in redirect him/her to Home page
	if (!is_user_logged_in()) {
		wp_redirect( esc_url( site_url('/') ) );
		exit;
	}
?>
<?php get_header(); ?>

<!--WORDPRESS LOOP-->
<?php if( have_posts() ) : while ( have_posts() ) : ?>
<?php the_post(); ?>
<?php pageBanner(); ?>

  <div class="container container--narrow page-section">
  	
  	<div class="create-note">
  		<h2 class="headline headline-medium">Create New Note</h2>
  		<input class="new-note-title" type="text" placeholder="Title"/>
  		<textarea class="new-note-body" placeholder="Your note here ..."></textarea>
  		<span class="submit-note">Create Note</span>
  		<span class="note-limit-message">Note Limit Reached. Delete an existing note to make room for a new one</span>
  	</div>
  	
  	<ul class="min-list link-list" id="my-notes">
  		<?php
  			$userNotes = new WP_Query([ //custom query
  				'post_type' => 'note', //only Notes
  				'posts_per_page' => -1, //every notes
  				'author' => get_current_user_id() // notes only from current user
  			]);
  		?>
  		<?php while ($userNotes->have_posts()) : ?>
  		<?php $userNotes->the_post(); ?>
  		
  		<li data-id="<?php the_id() ?>">
  			<input readonly class="note-title-field" value="<?php echo str_replace('Private: ', '', esc_attr( get_the_title() )); ?>" type="text" name=""/>
  			<span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
  			<span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
  			<textarea readonly class="note-body-field"><?php echo esc_textarea( get_the_content() ); ?></textarea>
  			<span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
  		</li>
  		
  		<?php endwhile; ?>
  		
  	</ul>  
  </div>
  
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>