<?php
global $redux_data;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<title><?php wp_title('|', true, 'right' ) ?><?php bloginfo('name'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />

	<!-- Favicon -->
	<?php
	if ( !empty($redux_data['custom-favicon']['url']) ):
	?>
		<link rel="shortcut icon" href="<?php echo esc_url($redux_data['custom-favicon']['url']) ?>">
	<?php endif; ?>

     <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>


     <?php wp_head(); ?>
</head>
<body <?php body_class();?>>

	<div id="loader-overlay">
		<div class="spinner">
			<div class="front"></div>
			<div class="back"></div>
		</div>
	</div>
	<div class="top-border"></div>
	<div class="right-border"></div>
	<div class="bottom-border"></div>
	<div class="left-border"></div>

	<header id="header">

		<div id="sidebar-content">

			<?php if ( !empty($redux_data['custom-logo']['url'] )): ?>

				<div class="logo">
					<a href="<?php echo home_url(); ?>"><img src="<?php echo esc_url($redux_data['custom-logo']['url']); ?>" alt="<?php bloginfo('name'); ?>"></a>
				</div>

			<?php else : ?>

				<div class="logo">
					<h1 class="logo-title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
				</div>

			<?php endif; ?>

			<div class="site-tagline">
				<h2><?php echo get_bloginfo('description'); ?></h2>
			</div>

			<!-- Anteriormente nav-container -->

			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-container">
				<span class="sr-only">Toggle navigation</span>
				<i class="fa fa-bars"></i>
			</button>

			<?php if( !empty($redux_data['siderbar-text']) ) : ?>
			<div class="sidebar-textarea">
				<?php echo do_shortcode($redux_data['siderbar-text']); ?>
			</div>
			<?php endif; ?>

			<?php do_action('icl_language_selector'); ?>

			<!-- nav-container -->
			<?php
			if ( has_nav_menu('sidebar-menu') ) { ?>
				<nav id="nav-container" class="collapse navbar-collapse">
					<?php
					wp_nav_menu( array(
						'theme_location'  => 'sidebar-menu',
						'menu_class'      => 'sf-menu'
					));
				?>
				</nav>
			<?php } ?>

			<div class="social-container">
				<?php if( !empty( $redux_data['facebook']) ) : ?>
					<a href="<?php echo esc_url($redux_data['facebook']); ?>" target="_blank"><i class="fa fa-facebook"></i></a>
				<?php endif; ?>
				<?php if( !empty( $redux_data['twitter']) ) : ?>
					<a href="<?php echo esc_url($redux_data['twitter']); ?>" target="_blank"><i class="fa fa-twitter"></i></a>
				<?php endif; ?>
				<?php if( !empty( $redux_data['behance']) ) : ?>
					<a href="<?php echo esc_url($redux_data['behance']); ?>" target="_blank"><i class="fa fa-behance"></i></a>
				<?php endif; ?>
				<?php if( !empty( $redux_data['dribbble']) ) : ?>
					<a href="<?php echo esc_url($redux_data['dribbble']); ?>" target="_blank"><i class="fa fa-dribbble"></i></a>
				<?php endif; ?>
				<?php if( !empty( $redux_data['pinterest']) ) : ?>
					<a href="<?php echo esc_url($redux_data['pinterest']); ?>" target="_blank"><i class="fa fa-pinterest"></i></a>
				<?php endif; ?>
				<?php if( !empty( $redux_data['instagram']) ) : ?>
					<a href="<?php echo esc_url($redux_data['instagram']); ?>" target="_blank"><i class="fa fa-instagram"></i></a>
				<?php endif; ?>
				<?php if( !empty( $redux_data['deviantart']) ) : ?>
					<a href="<?php echo esc_url($redux_data['deviantart']); ?>" target="_blank"><i class="fa fa-deviantart"></i></a>
				<?php endif; ?>
				<?php if( !empty( $redux_data['google']) ) : ?>
					<a href="<?php echo esc_url($redux_data['google']); ?>" target="_blank"><i class="fa fa-google"></i></a>
				<?php endif; ?>
				<?php if( !empty( $redux_data['linkedin']) ) : ?>
					<a href="<?php echo esc_url($redux_data['linkedin']); ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
				<?php endif; ?>
				<?php if( !empty( $redux_data['flickr']) ) : ?>
					<a href="<?php echo esc_url($redux_data['flickr']); ?>" target="_blank"><i class="fa fa-flickr"></i></a>
				<?php endif; ?>
				<?php if( !empty( $redux_data['youtube']) ) : ?>
					<a href="<?php echo esc_url($redux_data['youtube']); ?>" target="_blank"><i class="fa fa-youtube"></i></a>
				<?php endif; ?>
				<?php if( !empty( $redux_data['vimeo-square']) ) : ?>
					<a href="<?php echo esc_url($redux_data['vimeo-square']); ?>" target="_blank"><i class="fa fa-vimeo-square"></i></a>
				<?php endif; ?>
				<?php if( !empty( $redux_data['tumblr']) ) : ?>
					<a href="<?php echo esc_url($redux_data['tumblr']); ?>" target="_blank"><i class="fa fa-tumblr"></i></a>
				<?php endif; ?>
				<?php if( !empty( $redux_data['medium']) ) : ?>
					<a href="<?php echo esc_url($redux_data['medium']); ?>" target="_blank"><i class="fa fa-medium"></i></a>
				<?php endif; ?>
			</div>

			<div class="footer-text">
				<p><?php echo wp_kses_post($redux_data['footer-text']); ?></p>
			</div>

		</div><!-- end sidebar-content -->

	</header><!--end header-->

	<div class="main-content">