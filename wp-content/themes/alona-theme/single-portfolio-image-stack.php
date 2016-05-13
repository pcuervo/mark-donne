<?php
global $redux_data;
?>
<section  id="portfolio-single-stack">
<?php
if ( ! post_password_required() ) :

	if( have_rows('images') ):

		function resizeValue($value){
			$value_reminder = $value % 480;
			if( $value_reminder >= 240) {
				$value_new = $value - $value_reminder + 480;
				return $value_new;
			} else {
				$value_new = $value - $value_reminder;
				return $value_new;
			}
		}

	?>

	<ul class="project-images masonry-grid" data-cols="2">

		<?php while ( have_rows('images') ) : the_row();

		if ( get_sub_field('image') ) :

			$image = get_sub_field('image');
		?>

			<li <?php echo (get_sub_field('full_width') ? 'data-width = "full"' : 'data-width = "half"' ) ?> class="project-image masonry-grid-item">
				<?php
				$image_width_new = resizeValue( $image['width'] );
				$image_height_new = resizeValue( $image['height'] );

				$image_resized = sdesigns_aq_resize( $image['url'], $image_width_new,  $image_height_new, true );

				?>

				<img src="<?php echo esc_url($image_resized); ?>" alt="<?php echo esc_attr($image['alt']) ?>">
			</li>
		<?php endif; ?>

		<?php endwhile; ?>

	</ul>

<?php endif; //have_rows

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
						if ( sdesigns_back_to_portfolio_link() ) {
							echo '<a href="' . sdesigns_back_to_portfolio_link() . '" class="back-to-portfolio"><i class="fa fa-chevron-left"></i>' . __("Back to Portfolio", 'subsolar') . '</a>';
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
