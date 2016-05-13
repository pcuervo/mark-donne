
<?php
/* Template Name: Fullscreen Slider */
global $redux_data;
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<?php
	if( have_rows('slider') ): ?>

	<div class="sd-slider full-slider">

		<div class="sd-slides">

		<?php while ( have_rows('slider') ) : the_row();

			$total_items = count( get_field('slider'));
		?>
		<?php if( get_sub_field('link') ) : ?>
		<a href="<?php the_sub_field('link'); ?>">
		<?php endif; ?>
		
			<div class="sd-single-slide">
				

				<div class="slide-image-wrapper">
					<div class="bgimage" data-bgimage="<?php the_sub_field('image'); ?>"></div>
				</div>
				<div class="caption-table">
					<div class="slide-caption">
						<span class="caption-title"><?php echo do_shortcode(get_sub_field('caption_title')); ?></span>
						<?php if( get_sub_field('caption_title') ) : ?>
						<div class="divider-inv"></div>
						<?php endif; ?>
						<span class="caption-subtitle"><?php the_sub_field('caption_tagline'); ?></span>
					</div><!-- end slide-caption -->
				</div><!-- end caption-table -->
				
			</div>
		<?php if( get_sub_field('link') ) : ?>
			</a>
		<?php endif; ?>
		

		<?php endwhile; ?>

		</div>

		<?php if( $total_items !== 1 ): ?>
		<div class="sd-slider-controls">
			<div class="sd-slider-controls-direction">
				<a class="sd-slider-prev" href=""></a>
				<a class="sd-slider-next" href=""></a>
			</div>
		</div><!-- end sd-sldier-controls -->
		<?php endif; ?>

	</div>

	<script>

		jQuery(document).ready(function($){

			"use strict";

			if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
				var onMobile = true;
			} else {
				var onMobile = false;
			}

			/*===========================================================*/
			/*  OWL Fullscreen Slider
			/*===========================================================*/

			var fullscreenOwl = $('.full-slider .sd-slides');

			if( onMobile) {
				fullscreenOwl.find('.slide-caption').css('opacity', 1);
				$('.full-slider').addClass('onMobile');
			}


			var translated = false;

			fullscreenOwl.on('initialized.owl.carousel translated.owl.carousel', function(){
				translated = true;
			})

			fullscreenOwl.on('translate.owl.carousel', function(){
				translated = false;
			})

			fullscreenOwl.on('initialized.owl.carousel translated.owl.carousel dragged.owl.carousel', function showCaptions(event) {

				if (translated && !onMobile) {

					var currentSlideIndex = event.item.index;
					var $currentSlide = $('.full-slider .sd-single-slide').eq(currentSlideIndex);
					var $wrapper = $currentSlide.find('.slide-image-wrapper');
					var $caption = $currentSlide.find('.slide-caption');

					$caption.velocity({
						opacity: [ 1, 0 ],
						scale: [ 1, 0.95 ],
					},{
						delay: 200,
						duration: 600
					})


					$wrapper.velocity({
						top: [ 20, 40 ],
						left: [ 20, 40 ],
						right: [ 20, 40 ],
						bottom: [ 20, 40 ]
					},{
						easing: "ease-out",
						duration: 300
					})

				}


			});

			if( onMobile ) {
				var smartSpeed = 250;
			} else {
				var smartSpeed = 1000;
			}

			fullscreenOwl.owlCarousel({
				loop: <?php echo ($total_items == 1) ? 'false' : 'true' ?>,
				autoplay: false,
				smartSpeed: smartSpeed,
				navText: '',
				dots: false,
				items: 1,
				mouseDrag: <?php echo ($total_items == 1) ? 'false' : 'true' ?>
			});

			/*===========================================================*/
			/*  Fullscreen Olw Slider Click and Drag Callouts
			/*===========================================================*/


			fullscreenOwl.on('drag.owl.carousel', function(event) {

				var $this = $(this);
				var numSlides = $this.find('.owl-item').length;

				if ( !onMobile && numSlides > 1 ) {
					fadeOutSlide();
				}

			})

			$('.sd-slider-next, .sd-slider-prev',$('.full-slider')).on('click', function(event){
				event.preventDefault()
				var $this = $(this);
				fadeOutSlide($this);
			})

			<?php if( get_field('automatic_slide') ) : ?>

			var interval = (parseInt(<?php echo wp_kses_post(get_field('slide_delay')); ?>, 10) + parseInt(smartSpeed, 10))

			var slideInterval = setInterval(function() {
				fadeOutSlide($('.full-slider'));
				fullscreenOwl.trigger('next.owl');
			}, interval);


			fullscreenOwl.on('dragged.owl.carousel', function(event) {

				slideInterval = setInterval(function() {
					fadeOutSlide($('.full-slider'));
					fullscreenOwl.trigger('next.owl');
				}, interval);
			})

			fullscreenOwl.on('drag.owl.carousel', function(event) {
				clearInterval(slideInterval);
			})

			$('.sd-slider-next, .sd-slider-prev',$('.full-slider')).on('click', function(event){
				clearInterval(slideInterval);
				setTimeout(function(){
					slideInterval = setInterval(function() {
						fadeOutSlide($('.full-slider'));
						fullscreenOwl.trigger('next.owl');
					}, interval);
				}, 0);
			})

			<?php endif; ?>


			function fadeOutSlide($this){

				if( !onMobile ) {
					var $allCaptions = $('.full-slider .slide-caption');
					var $allWrappers = $('.full-slider .slide-image-wrapper');

					$allCaptions.velocity({
						opacity: 0,
						scale: [ 0.90, 1 ],
					},{
						duration: 600
					})

					$allWrappers.velocity({
						top: 40,
						left: 40,
						right: 40,
						bottom: 40
					},{
						easing: "ease-out",
						duration: 300,
						complete: function(){

							if(typeof($this) != "undefined" && $this !== null) {
								if( $this.hasClass('sd-slider-next')){
									fullscreenOwl.trigger('next.owl');
								} else if( $this.hasClass('sd-slider-prev')) {
									fullscreenOwl.trigger('prev.owl');
								}
							}

						}
					})
				}

				
			}


		})

	</script>

	<?php endif; ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>