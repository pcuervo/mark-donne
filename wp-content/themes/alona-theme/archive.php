<?php
get_header();
?>

<section class="blog-section">

	<?php if( have_posts() ) : ?>

	<div class="additional-content">
		<?php if (is_category()) { ?>
		<h3><?php _e('Showing posts from category: ', 'subsolar'); ?><?php single_cat_title(); ?></h3>
		<?php } elseif (is_tag()) { ?>
		<h3><?php _e('Showing posts with tag: ', 'subsolar'); ?><?php single_tag_title(); ?></h3>
		<?php } elseif (is_author()) { ?>
		<h3><?php _e('Posts by: ', 'subsolar'); ?><?php echo get_the_author_meta('display_name'); ?></h3>
		<?php } elseif (is_day()) { ?>
		<h3><?php _e('Posts from: ', 'subsolar'); ?><?php the_time('l, F j, Y'); ?></h3>
		<?php } elseif (is_month()) { ?>
		<h3><?php _e('Posts from: ', 'subsolar'); ?><?php the_time('F Y'); ?></h3>
		<?php } elseif (is_year()) { ?>
		<h3><?php _e('Posts from: ', 'subsolar'); ?><?php the_time('Y'); ?></h3>
		<?php } ?>
		</div>

	<div class="blog-posts">

		<?php while( have_posts() ) : the_post() ?>

		<?php
		$format = get_post_format(); ?>

		<div class="blog-item">

			<div class="post-box">

				<!-- Gallery Post -->
				<?php if( $format == 'gallery' ) : ?>

				<?php if( have_rows('images') ): ?>
				<div class="blog-slider">
					<ul class="blog-slides">
					<?php while ( have_rows('images') ) : the_row();
						$image = get_sub_field('image');
					?>
						<?php echo wp_get_attachment_image( $image['id'], 'blog-thumb' ); ?>
					<?php endwhile; ?>
					</ul>
				</div><!-- end blog-slider -->
				<?php endif; ?>

				<!-- Standart or Video Post -->
				<?php else : ?>
					<div class="post-thumbnail">
						<?php the_post_thumbnail('blog-thumb'); ?>
					</div><!-- end post-thumbnail -->
				<?php endif; ?>

				<div class="post-description">
					<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<div class="post-meta">
						<?php
						$terms = wp_get_post_terms( $post->ID, 'category' );
						$terms_html_array = array();

						foreach($terms as $term) {
							$term_name = $term->name;
							$term_link = get_term_link( $term->slug, $term->taxonomy );
							array_push($terms_html_array, "<a href={$term_link} class='italics' >{$term_name}</a>");
						}

						$terms_string = implode(', ',$terms_html_array);
						?>
						<i class="icon-basic-folder"></i><?php echo wp_kses_post($terms_string); ?>
						<i class="icon-basic-calendar"></i><a href="#" class="italics"><?php the_time('d M y') ?></a>
					</div>
					<?php the_excerpt(); ?>
				</div><!-- end post-description -->
			</div><!-- end post-box -->
		</div><!-- end blog-item -->

	<?php endwhile; else : ?>

	<div class="additional-content">
		<h3><?php _e('Sorry, no posts found.', 'subsolar'); ?></h3>
		<div class="error404-search">
			<?php get_search_form(); ?>
		</div>
	</div>

	<?php endif; ?>

	</div><!-- end blog-posts -->

	<div class="page-nav">
		<span class="nav-prev"><?php next_posts_link('Previous'); ?></span>
		<span class="nav-next"><?php previous_posts_link('Next'); ?></span>
	</div>

</section>




<?php get_footer(); ?>