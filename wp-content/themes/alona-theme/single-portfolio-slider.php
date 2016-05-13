<?php
global $redux_data;
?>
<section  id ="portfolio-single-slider">
<?php
if ( ! post_password_required() ) :
	if( have_rows('project') ):

	$total_items = count( get_field('project'));

	if( $total_items > 1 ): ?>

		<div class="post-slider sd-slider">
			<div class="sd-slides">

				<?php while ( have_rows('project') ) : the_row();

					if( get_row_layout() == 'image' ):
						$image = get_sub_field('image'); ?>
						<img src="<?php echo esc_url($image['url']) ?>" alt="<?php echo esc_attr($image['alt']) ?>">
					<?php
					elseif( get_row_layout() == 'video' ):

						$video = get_sub_field('video_url'); ?>
						<?php echo wp_oembed_get($video); ?>

					<?php endif;

				endwhile; ?>

			</div>
			<div class="sd-slider-controls">
				<div class="sd-slider-controls-direction">
					<a class="sd-slider-prev" href="" style="border-color: <?php echo esc_attr(get_field('arrows_color')); ?>"></a>
					<a class="sd-slider-next" href="" style="border-color: <?php echo esc_attr(get_field('arrows_color')); ?>"></a>
				</div>
			</div><!-- end sd-slider-controls -->

		</div><!-- end post-slider -->


<?php 
		endif; // if( $total_items > 1 )
?>
	<?php if ( $total_items == 1) : ?>

		<div class="single-project-media">

			<?php while ( have_rows('project') ) : the_row();

				if( get_row_layout() == 'image' ):
					$image = get_sub_field('image'); ?>
					<img src="<?php echo esc_url($image['url']) ?>" alt="<?php echo esc_attr($image['alt']) ?>">
				<?php
				elseif( get_row_layout() == 'video' ):

					$video = get_sub_field('video_url'); ?>
					<?php echo wp_oembed_get($video); ?>

				<?php endif;

			endwhile; ?>

		</div>

	<?php endif; ?>

	<?php
	endif;//have_rows
endif; //password required
?>

	<div class="section-bg">

		<div class="container-fluid">

			<div class="row">

				<div class="col-sm-8 white-bg"></div>

				<div class="col-sm-4 col-sm-push-8 no-pad">

				<div class="single-project-title"><h1><?php the_title(); ?></h1></div>

					<ul class="project-details">
						<?php
						$terms = wp_get_post_terms( $post->ID, 'portfolio_category' );
						$terms_array = array();

						foreach($terms as $term) {
							array_push($terms_array, $term->name);
						}
						$terms_string = implode(', ',$terms_array);
						?>
						<?php if( $terms_array ) : ?>
						<li><i class="fa fa-briefcase"></i><?php echo wp_kses_post($terms_string); ?></li>
						<?php endif; ?>
						<?php if( get_field('date') ) : ?>
						<li><i class="fa fa-calendar-o"></i><?php echo wp_kses_post(get_field('date')); ?></li>
						<?php endif; ?>
						<?php if( get_field('client') ) : ?>
						<li><i class="fa fa-users"></i><?php echo wp_kses_post(get_field('client')); ?></li>
						<?php endif; ?>

						<?php
						if (isset($_SERVER['HTTP_REFERER'])) {
							echo '<a href="' . $_SERVER['HTTP_REFERER'] . '"><i class="fa fa-chevron-left"></i>' . __("Back to Portfolio", 'subsolar') . '</a>';
						}
						?>

					</ul>

				</div><!-- end col-sm-4 -->

				<div class="col-sm-8 col-sm-pull-4">

					<div class="project-description">

						<?php the_content(); ?>

					</div>

				</div><!-- end col-sm-8 -->

			</div><!-- end row -->

		</div><!-- end container-fluid -->

	</div><!-- end section-bg -->
	<?php
	if( $redux_data['project-nav-switch']) {
		sdesigns_portfolio_nav($post->ID);
	} 
	?>

</section>