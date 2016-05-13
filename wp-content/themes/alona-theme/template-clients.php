<?php
/* Template Name: Clients */
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
		if( have_rows('clients_list') ): ?>

		<div class="row clients-list">

		<?php while ( have_rows('clients_list') ) : the_row(); ?>

			<div class="col-sm-4">

				<?php
				$image = get_sub_field('image');
				?>

				<div class="client-box">
					<div class="client-image">
					<?php echo wp_get_attachment_image($image['id'], 'client-img'); ?>
					</div>
					<div class="client-description">
						<p><?php the_sub_field('description'); ?></p>
					</div>
				</div><!-- end client-box -->
			</div><!-- end col-sm-4 -->


			<?php endwhile; ?>

		</div><!-- end row -->

		<?php endif; ?>

	</div><!-- end container-fluid -->

<?php endwhile; endif; ?>

</section>

<?php get_footer(); ?>