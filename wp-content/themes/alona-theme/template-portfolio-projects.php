<?php
/* Template Name: Portfolio Projects */
global $redux_data;
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post();

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
	$terms = get_terms('portfolio_category', $term_args);

	if( $terms ) : ?>

	<div class="filter-container">
		<ul class="filters">
			<li class="filter selected"><a href="#" data-filter="*"><?php _e('Show All', 'subsolar') ?></a></li>

			<?php foreach( $terms as $term ) : ?>

			<li class="filter"><a href="#" data-filter=".isotope-category-<?php echo esc_attr( $term->slug); ?>"><?php echo wp_kses_post($term->name); ?></a></li>

			<?php endforeach; ?>
		</ul>
	</div><!-- end filer-container -->
	<?php
	endif;

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

	<ul id="portfolio" class="masonry-grid" data-cols="3">

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

	$filter_classes = array_map( 'sdesigns_populate_categories_array', $term_slugs_array);

	?>
		<li class="masonry-grid-item <?php echo implode(' ', $filter_classes); ?>">
			<a class="project-link" href="<?php the_permalink(); ?>" data-page-id="<?php echo esc_attr($page_id); ?>">
				<div class="thumb-wrapper">
					<?php
					$image_resized = sdesigns_aq_resize( $thumb['url'], 400, 440, true );
					?>
					<img src="<?php echo esc_url($image_resized); ?>" alt="<?php echo esc_attr($thumb['alt']) ?>">
				</div><!-- end thumb-wrapper -->
				<div class="project-info">
					<h5><?php the_title(); ?></h5>
						<span class="italics"><?php echo implode(', ', $term_names_array); ?></span>
				</div>
			</a>
		</li>

	<?php

	endwhile; ?>
	</ul>
	<div class="page-nav">
		<span class="nav-prev"><?php previous_posts_link('Previous'); ?></span>
		<span class="nav-next"><?php next_posts_link('Next', $the_query->max_num_pages); ?></span>
	</div>
	<?php
	endif;
	wp_reset_postdata();

endwhile;
endif; ?>

<?php get_footer(); ?>