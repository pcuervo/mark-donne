<?php
/* Template Name: Services */
global $redux_data;
get_header();
?>

<section class="section-block">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<h1 id="headline" class="section-title" ><?php the_title(); ?></h1>

	<div class="divider"></div>

	<div class="container-fluid">

		<div class="row">
			<div class="col-sm-12 subtitle">
				<?php the_content(); ?>
			</div><!-- end col-sm-12 -->
		</div><!-- end row -->

		<?php
		if( have_rows('services_list') ): ?>

		<div class="row services-list">

		<?php while ( have_rows('services_list') ) : the_row(); ?>

			<div class="col-sm-6">

				<div class="service-box">
					<div class="service-icon">
						<?php the_sub_field('icon'); ?>
					</div>
					<div class="service-description">
						<h5><?php the_sub_field('title'); ?></h5>
						<p><?php the_sub_field('description'); ?></p>
					</div>
				</div><!-- end service-box -->

			</div><!-- end col-sm-6 -->

			<?php endwhile; ?>

		</div><!-- end row -->

		<?php endif; ?>

	</div><!-- end container-fluid -->

<?php endwhile; endif; ?>

</section>

<?php get_footer(); ?>