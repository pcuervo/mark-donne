<?php
global $redux_data;
get_header();
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();

	$portfolio_type = get_field('project_page_type');
	get_template_part('single-portfolio', $portfolio_type );

endwhile; endif; ?>
<?php get_footer(); ?>