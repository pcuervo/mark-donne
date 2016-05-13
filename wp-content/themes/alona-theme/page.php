<?php
global $redux_data;
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<section <?php post_class('section-block'); ?>>

    <div class="container-fluid">
        <?php if( $post->post_title != "" ) : ?>
        <h1 id="headline" class="section-title" ><?php the_title(); ?></h1>
        <div class="divider"></div>
        <?php endif; ?>

        <?php the_content(); ?>

        <?php sdesigns_wp_link_pages(); ?>
    </div>

</section><!-- end section-block -->

<?php endwhile; else : ?>

	<div class="additional-content">
		<h3><?php _e('Sorry, no posts found.', 'subsolar'); ?></h3>
	</div>

<?php endif; ?>

<?php get_footer(); ?>