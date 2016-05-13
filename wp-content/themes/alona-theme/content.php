<article <?php post_class(); ?>>

<?php if( has_post_thumbnail() ) : ?>

<div class="featured-image-wrapper">

	<figure class="post-thumbnail">
		<?php the_post_thumbnail('blog-thumb'); ?>
	</figure>

</div><!-- end featured-image-wrapper -->

<?php endif; ?>

<div class="container-fluid">

	<div class="row">

		<div class="col-sm-12 blog-content-wrapper">

			<header class="blog-header">
				<h1 class="single-post-title"><?php the_title(); ?></h1>
			</header>

			<div class="single-post-meta">
				<?php
				$archive_year  = get_the_time('Y');
				$archive_month = get_the_time('m');
				?>
				<div class="post-meta-date-wrapper">
					<i class="fa fa-calendar-o"></i><span class="post-meta-date"><a href="<?php echo get_month_link( $archive_year, $archive_month); ?>"><?php the_time('d M y') ?></a></span>
				</div><!-- end post-meta-date-wrapper -->
				<div class="post-meta-category-wrapper">
					<i class="fa fa-tags"></i><span class="post-meta-category"><?php the_category(', '); ?></span>
				</div><!-- end post-meta-category-wrapper -->
			</div>

			<div class="post-content">
				<?php the_content(); ?>
			</div>

			<?php

			sdesigns_wp_link_pages();

			if ( has_tag() ): ?>

			<div class="post-meta post-meta_bottom">
				<?php the_tags('',''); ?>
			</div><!-- end post-meta -->

			<?php endif; ?>

		</div><!-- end col-sm -->

	</div><!-- end row -->

</div><!-- end container-fluid -->


</article>