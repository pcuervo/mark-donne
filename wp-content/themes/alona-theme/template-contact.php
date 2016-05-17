<?php
/* Template Name: Contact */
global $redux_data;
get_header();

wp_register_script( 'gmaps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false', 'jquery', '1.0' );

wp_enqueue_script('gmaps');
wp_enqueue_script('validation');

// Contact Form
$nameError = __( 'Please enter your name.', 'subsolar' );
$emailError = __( 'Please enter your email address.', 'subsolar' );
$emailInvalidError = __( 'You entered an invalid email address.', 'subsolar' );
$messageError = __( 'Please enter a message.', 'subsolar' );

if(isset($_POST['submitted'])) {
	$name = trim($_POST['contactName']);
	$email = trim($_POST['email']);
	$message = trim($_POST['message']);
	$to_email = get_field("receiving_email");

	$subject = "[".get_bloginfo('name')."] - Email From: ".$email;
	$message = "
	Name : {$name},
	Email : {$email}

	$message
	";
	$emailSent = wp_mail($to_email,$subject,$message);
}


?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


<div class="half-width full-height hidden contact-media-container">
	<?php if ( get_field('left_column') == 'image' ) : ?>
		<?php
		$image = get_field('image');
		?>
		<div class="bgimage" data-bgimage="<?php echo $image ? esc_url($image['url']) : '' ?>"></div>
	<?php else : ?>
		<div id="google-maps"></div>
	<?php endif; ?>
</div><!-- end left-side -->

<div class="half-width contacts-container">

	<div class="container-fluid">

		<div class="row wow fadeIn row-contacts">

			<h1 id="headline" class="section-title wow bounceIn" ><?php the_title(); ?></h1>

			<div class="divider"></div>

			<div class="contact-content col-sm-12">
				<?php the_content(); ?>
			</div><!-- end col-sm-12 -->

			<?php
			if( have_rows('contact_us_information') ): ?>

				<?php while ( have_rows('contact_us_information') ) : the_row(); ?>

				<div class="col-sm-6">
					<div class="contact-box">
						<?php the_sub_field('icon'); ?>
						<span class="italics"><?php the_sub_field('description'); ?></span>
					</div>
				</div><!-- end col-sm-6 -->

				<?php endwhile; ?>

			<?php endif; ?>

		</div><!-- end row -->

		<div class="row">
			<div class="col-sm-12">

				<?php if(isset($emailSent) && $emailSent == true) { ?>

				<div class="thanks centered">
					<p><?php _e('Thanks, your email was sent successfully.', 'subsolar') ?></p>
				</div>

				<?php } else { ?>

				<?php if(isset($hasError) || isset($captchaError)) { ?>
				<p class="error"><?php _e('Sorry, an error occured.', 'subsolar') ?><p>
					<?php } ?>

				<form action="<?php the_permalink(); ?>" id="contactForm" method="post">
					<ul class="contactform">
						<li>
							<span class="contact-input-icon">
								<i class="fa fa-user"></i>
							</span>
							<div class="input-field">
								<input type="text" name="contactName" id="contactName" value="" class="required requiredField" placeholder="<?php _e('Name', 'subsolar') ?>"/>
							</div>
						</li>

						<li>
							<span class="contact-input-icon">
								<i class="fa fa-envelope"></i>
							</span>
							<div class="input-field">
								<input type="text" name="email" id="email" value="" class="required requiredField email" placeholder="<?php _e('Email', 'subsolar') ?>"/>
							</div>
						</li>

						<li class="textarea">
							<span class="contact-input-icon">
								<i class="fa fa-pencil"></i>
							</span>
							<div class="input-field">
								<textarea name="message" id="message" rows="6" cols="20" class="required requiredField" placeholder="<?php _e('Write your message...', 'subsolar') ?>"></textarea>
							</div>
						</li>

						<li class="buttons text-right">
							<input type="hidden" name="submitted" id="submitted" value="true" />
							<button type="submit" class="button"><?php _e('Send Email', 'subsolar'); ?></button>
						</li>
					</ul>
				</form>
				<?php } ?>

			</div><!-- end col-sm-12 -->
		</div><!-- end rows -->

	</div><!-- end container-fluid -->

</div><!-- end right-side -->


<?php
$location = get_field('location');

if( ! empty($location) ):
?>


<script>
window.onload = function () {

	var styles = [
	 	{
			featureType: "all",
			elementType: "all",
			stylers: [
				{ saturation: -100 } // <-- THIS
			]
		}
	];

	var lat = <?php echo esc_attr($location['lat']); ?>;
	var lng = <?php echo esc_attr($location['lng']); ?>;
	var image = '<?php echo esc_url(get_field("map_marker")); ?>';

	var myLatlng = new google.maps.LatLng(lat, lng); // Latitude and Longitude

	var options = {
		mapTypeControlOptions: {
			mapTypeIds: ['Styled']
		},
		center: myLatlng,
		zoom: <?php echo esc_attr(get_field('zoom_level')); ?>,
		disableDefaultUI: true,

		mapTypeId: 'Styled'
	};

	var div = document.getElementById('google-maps');

	var map = new google.maps.Map(div, options);
	var styledMapType = new google.maps.StyledMapType(styles, { name: 'Styled' });

	var marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		icon: image
	});

	map.mapTypes.set('Styled', styledMapType);

};

</script>

<?php endif; ?>

<script type="text/javascript">
jQuery(document).ready(function($){

	$("#contactForm").validate({
		messages: {
			contactName: '<?php echo wp_kses_post($nameError); ?>',
			email: {
				required: '<?php echo wp_kses_post($emailError); ?>',
				email: '<?php echo wp_kses_post($emailInvalidError); ?>'
			},
			message: '<?php echo wp_kses_post($messageError); ?>'
		},
		errorPlacement: function(error, element) {
			error.prependTo('.buttons');
		}
	});

});
</script>


<?php endwhile; endif; ?>

<?php get_footer(); ?>