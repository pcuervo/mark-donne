<?php
/* Template Name: Portfolio Horizontal */
global $redux_data;
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<section class="portfolio-horizontal-section">

	<ul class="portfolio-horizontal">

	<?php

	$term_args = array();
	$exclude_cats = get_field('exclude_categories');
	$projects_per_page = get_field('projects_per_page') ? get_field('projects_per_page') : -1;
	$page_id = get_the_ID();

	if( !empty($exclude_cats[0]['category']) ) {
		$exclude_cats_ids = array();
		foreach( $exclude_cats as $cat) {
			array_push($exclude_cats_ids, $cat['category']->term_id);
		}
		$term_args['exclude_tree'] = $exclude_cats_ids;
	}

	if( get_query_var( 'paged' ) )
		$paged = get_query_var( 'paged' );
	else {
		if( get_query_var( 'page' ) )
			$paged = get_query_var( 'page' );
		else
			$paged = 1;
		set_query_var( 'paged', $paged );
	}
	$args = array(
		'post_type' => 'portfolio',
		'posts_per_page' => $projects_per_page,
		'paged' => $paged
		);

	if( !empty($exclude_cats[0]['category']) ) {
		$args['tax_query'] = array(array(
			'taxonomy' => 'portfolio_category',
			'field' => 'term_id',
			'terms' => $exclude_cats_ids,
			'operator' => 'NOT IN'
		));
	}

	$the_query = new WP_Query($args); ?>


	<?php
	if ($the_query->have_posts()) : while  ($the_query->have_posts()) : $the_query->the_post();

	$item_terms = wp_get_post_terms($post->ID, 'portfolio_category');
	$thumb = get_field('project_thumbnail');
	$term_slugs_array = array();
	$term_names_array = array();

	foreach( $item_terms as $term ) {
		array_push($term_slugs_array,$term->slug);
		array_push($term_names_array,$term->name);
	}

	?>

		<li class="portfolio-horizontal-item">
			<a class="project-link" href="<?php the_permalink(); ?>" data-page-id="<?php echo esc_attr($page_id); ?>">
				<div class="portfolio-mask"></div>
				<div class="item-image bgimage" data-bgimage="<?php echo esc_url($thumb['url']); ?>" >
					</div>
				<div class="item-description">
					<h5><?php the_title(); ?></h5>
					<span><?php echo implode(', ', $term_names_array); ?></span>
				</div>
			</a>
		</li><!-- end item -->

	<?php

	endwhile; ?>

	</ul><!-- end portfolio-horizontal -->
	<div class="page-nav">
		<span class="nav-prev"><?php previous_posts_link('Previous'); ?></span>
		<span class="nav-next"><?php next_posts_link('Next', $the_query->max_num_pages); ?></span>
	</div>
	<?php
	endif;
	wp_reset_postdata(); ?>

</section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>