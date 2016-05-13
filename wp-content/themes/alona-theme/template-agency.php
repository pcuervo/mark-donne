<?php
/* Template Name: Agency */
global $redux_data;
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php
if( have_rows('slider') ): ?>

<div class="sd-slider agency-slider">

	<ul class="sd-slides">

	<?php while ( have_rows('slider') ) : the_row();

		$total_items = count( get_field('slider'));
	?>
		<li>
			<div class="slide-image bgimage flip" data-pos="0" data-bgimage="<?php the_sub_field('image'); ?>"></div>
			<div class="slide-caption bgimage flip" data-pos="1">
				<span class="caption-title"><?php echo do_shortcode(get_sub_field('caption_title')); ?></span>
					<div class="divider-inv"></div>
					<span class="caption-subtitle"><?php echo do_shortcode(get_sub_field('caption_tagline')); ?></span>
			</div><!-- end slide-caption -->
		</li>

	<?php endwhile; ?>

	</ul>

	<?php if( $total_items !== 1 ): ?>
	<div class="sd-slider-controls">
		<div class="sd-slider-controls-direction">
			<a class="sd-slider-prev" href=""></a>
			<a class="sd-slider-next" href=""></a>
		</div>
	</div><!-- end sd-sldier-controls -->
	<?php endif; ?>

</div>
<?php endif; ?>

<section class="agency-block">

	<div class="container-fluid">

		<div class="row">

			<?php if( get_field('title') ) : ?>
			<h1 id="headline" class="section-title" ><?php echo wp_kses_post(get_field('title')); ?></h1>
			<div class="divider"></div>
			<?php endif; ?>

			<div class="tagline"><?php echo wp_kses_post(get_field('what_we_do_tagline')); ?></div>

			<?php if(have_rows('what_we_do')): ?>
			<?php while ( have_rows('what_we_do') ) : the_row(); ?>

			<div class="col-sm-6">
				<div class="agency-s-box">
					<div class="agency-s-icon">
						<i class="icon-basic-<?php the_sub_field('icon'); ?>"></i>
					</div>
					<div class="agency-s-description">
						<a class="agency-s-title"href=""><?php the_sub_field('title'); ?></a>
						<p><?php echo do_shortcode( get_sub_field('description') ); ?></p>
					</div>
				</div><!-- end service-box -->
			</div><!-- end col-sm-6 -->

			<?php endwhile; ?>
			<?php endif; ?>

		</div><!-- end row -->

	</div><!-- end container-fluid -->

</section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>