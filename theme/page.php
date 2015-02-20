<?php /* ---- page template ---- */ ?>
<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>

		<?php
		// check if the flexible content field has rows of data
		if( have_rows('layouts') ):
		 
		     // loop through the rows of data
		    while ( have_rows('layouts') ) : the_row();
		 		$layout = get_row_layout();
		 		echo '<div class="layout-container">';
		 			amt_get_template_part('layout', $layout);
		 		echo '</div>';
		    endwhile;
		 
		else :

			amt_get_template_part('page', 'basic');	

		endif;
		?>

	<?php endwhile; ?>
<?php endif; /*have_posts*/ ?>

<?php get_footer(); ?>