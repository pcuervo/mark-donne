<?php
global $redux_data;
get_header();
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<section class="member-single-section">

		<?php
		$photo_array = get_field('member_photo');
		?>

		<div class="member-single-photo half-width full-height bgimage flip-onload" data-bgimage="<?php echo esc_url($photo_array['url']); ?>">

			<!-- <img src="images/member-single.jpg" alt=""> -->

		</div><!-- end left-side -->

		<div class="half-width member-single-description flip-onload" data-pos="1">

			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">

						<h1 class="member-single-name"><?php the_title(); ?></h1>

						<div class="member-single-content">
							<?php the_content(); ?>

						</div><!-- end member-content -->

						<?php
						if( have_rows('social_links') ): ?>

							<div class="member-social">
								<span class="italics"><?php _e('Contact me at:', 'subsolar'); ?></span>
								<div class="social-container">

							<?php while ( have_rows('social_links') ) : the_row(); ?>

							<a href="<?php the_sub_field('link'); ?>"><i class="fa fa-<?php the_sub_field('social_media'); ?>"></i></a>

							<?php endwhile; ?>

							</div>
						</div><!-- end member-social -->

						<?php endif; ?>

					</div><!-- end col-md-12 -->
				</div><!-- end row -->
			</div><!-- end container-fluid -->

		</div><!-- end helf-width right-side -->

	</section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>