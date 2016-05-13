<?php
global $redux_data;
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post();

	$format = get_post_format();

	get_template_part( 'content', $format);
	?>

	<div class="comments-container">
		<?php comments_template( '', true ); ?>
	</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>