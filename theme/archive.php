<?php /*
 ---- archive page template ---- 
NOTE: SAME AS HOME TEMPLATE
*/
?>
<?php get_header(); ?>

<div class="layout-blogroll">
	<div class="layout-basic">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				
			 	<?php amt_get_template_part('blogroll', 'post'); ?>

			<?php endwhile; ?>
		<?php endif; /*have_posts*/ ?>
	</div>
</div>


<?php get_footer(); ?>