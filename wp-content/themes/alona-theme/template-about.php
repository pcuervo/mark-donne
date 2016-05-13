<?php
/* Template Name: About */
global $redux_data;
get_header();
?>

<section class="section-block">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <h1 id="headline" class="section-title" ><?php the_title(); ?></h1>

    <div class="divider"></div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12 subtitle">
                <?php the_content(); ?>
            </div><!-- end col-md-12 -->

            <?php
            $args = array(
                'post_type' => 'members',
                'posts_per_page' => -1
                );

            $the_query = new WP_Query($args);

            if ($the_query->have_posts()) : while  ($the_query->have_posts()) : $the_query->the_post();

                $image = get_field('member_thumbnail'); ?>

                <div class="col-md-4">

                    <div class="member-box">
                        <a class="member-ajax-popup" href="<?php the_permalink(); ?>">
                            <div class="member-photo">
                                <div class="member-mask">
                                    <span class="zoom-plus"></span>
                                </div>
                                <?php echo wp_get_attachment_image( $image['id'], 'member-thumbnail' ); ?>
                            </div>
                        </a>

                        <div class="member-description">
                            <h5><?php the_title(); ?></h5>
                            <span class="member-title italics"><?php echo wp_kses_post(get_field('member_position')); ?></span>
                        </div>
                    </div><!-- end member-box -->

                </div><!-- end col-md-4 -->

            <?php

            endwhile; endif;
            wp_reset_query(); ?>

        </div><!-- end row -->

    </div><!-- end container-fluid -->

    <?php endwhile; endif; ?>

</section>

<?php get_footer(); ?>