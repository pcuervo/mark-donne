<?php
global $redux_data;

/*===========================================================*/
/*    Theme Initialization
/*===========================================================*/

if( ! defined('THEME_URL') ) { define('THEME_URL', get_template_directory_uri() ); }
if( ! defined('THEME_INCLUDES') ) { define('THEME_INCLUDES', get_template_directory()  . '/includes'); }

if ( !function_exists( 'sdesigns_init' ) ) {
	function sdesigns_init() {

		add_theme_support( 'automatic-feed-links' );

		register_nav_menu( 'sidebar-menu', __('Sidebar Menu', 'subsolar') );

		/* Thumbnails Support */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 50, 50, true );
		add_image_size( 'member-thumbnail', 220, 300, true );
		add_image_size( 'grid-thumb', 400, 280, true );
		add_image_size( 'blog-featured', 1000, 600, false );
		add_image_size( 'project-thumb', 400, 440, true );
		add_image_size( 'vertical-thumb', 450, 1500, true );
		add_image_size( 'client-img', 300, 200, true );

		add_theme_support(
			'post-formats',
			array(
				'gallery',
				'video'
				)
			);

	}
}

add_action( 'after_setup_theme', 'sdesigns_init' );

require_once( THEME_INCLUDES . '/class-tgm-plugin-activation.php' );
require_once( THEME_INCLUDES . '/tgm-plugin-activator.php' );

// Aqua Resizer
require_once( THEME_INCLUDES . '/aq_resizer.php' );

// Redux Framework
require_once( THEME_INCLUDES . '/admin/admin-init.php' );

require_once( THEME_INCLUDES . '/custom-styles.php' );

include_once( 'acf/acf.php');
require_once( THEME_INCLUDES . '/acf-fontawesome/acf-font-awesome.php' );
include_once( THEME_INCLUDES . '/custom-fields.php');

include_once( THEME_INCLUDES . '/custom-post-types.php');


/*===========================================================*/
/*    ACF Direcories
/*===========================================================*/

add_filter('acf/settings/path', 'my_acf_settings_path');

function my_acf_settings_path( $path ) {

	// update path
	$path = get_template_directory() . '/acf/';


	// return
	return $path;

}


add_filter('acf/settings/dir', 'my_acf_settings_dir');

function my_acf_settings_dir( $dir ) {

	// update path
	$dir = get_template_directory_uri() . '/acf/';

	// return
	return $dir;

}


add_filter('acf/settings/show_updates', '__return_false');
// add_filter('acf/settings/show_admin', '__return_false');

/*===========================================================*/
/*    Content Width
/*===========================================================*/
if ( ! isset( $content_width ) )
	$content_width = 1000;


/*===========================================================*/
/*    Loading Scripts
/*===========================================================*/

if (!function_exists( 'sdesigns_register_scripts' ) ) {
	function sdesigns_register_scripts() {

		global $redux_data;

		wp_register_script( 'custom', get_template_directory_uri() . '/assets/js/custom.js', 'jquery', '1.0', 1.0, true );
		wp_register_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', 'jquery', 1.0, true );
		wp_register_script( 'plugins', get_template_directory_uri() . '/assets/js/plugins.js', 'jquery' );
		wp_register_script( 'matchHeight', get_template_directory_uri() . '/assets/js/jquery.matchHeight-min.js', 'jquery' );

		wp_enqueue_script('jquery');
		wp_enqueue_script('bootstrap');
		wp_enqueue_script('plugins');
		wp_enqueue_script('matchHeight');
		wp_enqueue_script('custom');

		wp_localize_script( 'custom', 'sdesigns', array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajax-nonce')
			));

		/* Loading Styles */

		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '1.0');
		wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '1.0');
		wp_enqueue_style( 'linea', get_template_directory_uri() . '/assets/css/linea.css', array(), '1.0');
		wp_enqueue_style( 'owl', get_template_directory_uri() . '/assets/css/owl.carousel.min.css', array(), '1.0');
		wp_enqueue_style( 'perfectscrollbar', get_template_directory_uri() . '/assets/css/perfect-scrollbar.min.css', array(), '1.0');
		wp_enqueue_style( 'styles', get_template_directory_uri() . '/assets/css/styles.css', array(), '1.0');
		wp_enqueue_style( 'googleLora', 'http://fonts.googleapis.com/css?family=Lora:400italic', array(), '1.0');
	}
}

add_action('wp_enqueue_scripts', 'sdesigns_register_scripts');


/*===========================================================*/
/*    Custom Excerpt More
/*===========================================================*/
if ( !function_exists( 'sdesigns_excerpt_more' ) ) {
	function sdesigns_excerpt_more( $more ) {
		return '...';
	}
}
add_filter('excerpt_more', 'sdesigns_excerpt_more');


/*===========================================================*/
/*    Excerpt Read More
/*===========================================================*/
if ( !function_exists( 'sdesigns_excerpt_read_more_link' ) ) {
	function sdesigns_excerpt_read_more_link($output) {
		global $post;

		return $output . '<p class="read-more-p"><a href="' . get_permalink($post->ID) . '" class="more"><i class="fa fa-arrow-right"></i>' . __('Continue Reading', 'subsolar') . '</a></p>';
	}
}
add_filter('the_excerpt', 'sdesigns_excerpt_read_more_link');

/*===========================================================*/
/*    Custom Read More
/*===========================================================*/

if ( !function_exists( 'sdesigns_custom_readMore' ) ) {
	function sdesigns_custom_readMore() {
		global $post;
		return '<p class="read-more-p"><a href="' . get_permalink($post->ID) . '" class="more"><i class="fa fa-arrow-right"></i>' . __('Continue Reading', 'subsolar') . '</a></p>';
	}
}
add_filter( 'the_content_more_link', 'sdesigns_custom_readMore' );

/*===========================================================*/
/*    Subsolar Video
/*===========================================================*/

if ( !function_exists( 'sdesigns_video' ) ) {
	function sdesigns_video( $postid ) {

		/* Gets the audio url from the audio metabox in Post Edit */
		$video_url = get_field('featured_video');

		if ( $video_url ) {

			$video_extensions = implode('|', wp_get_video_extensions() );
			$match = array();

			preg_match('/(http|https):\/\/(www\.)?[\w-_\.]+\.[a-zA-Z]+\/((([\w-_\/]+)\/)?[\w-_\.]+\.('.$video_extensions.'))/', $video_url, $match);

				if ( $match ) { // Checks if the file is uploaded and fires the HTML5 player shortcode

					$attr = array(
						'src'      => $video_url,
						'poster'   => '',
						'loop'     => '',
						'autoplay' => '',
						'preload'  => 'metadata',
						'height'   => 280,
						'width'    => empty( $content_width ) ? 640 : $content_width,
						);

					echo wp_video_shortcode( $attr );
				}
			 else { // Fires oEmbed
				$embed_code = wp_oembed_get($video_url);
				echo wp_kses_post($embed_code);
			 }
		}
	}
}


/*===========================================================*/
/*    Comments
/*===========================================================*/

if ( !function_exists( 'sdesigns_comments' ) ) {
	function sdesigns_comments($comment, $args, $depth) {

		$GLOBALS['comment'] = $comment; ?>

		<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
			<article class="comment-content">
				<header class="comment-header">
					<figure>
						<?php
						$avatar_size = 50;
						echo get_avatar($comment, $avatar_size); ?>
					</figure>
					<h5 class="comment-author"><?php comment_author_link(); ?></h5>
					<span class="comment-meta"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_date(); ?> - <?php comment_time(); ?></a><?php edit_comment_link(__('[Edit]', 'subsolar'),'  ','') ?> &middot; <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span>
				</header>

				<?php if ( $comment->comment_approved == 0 ) : ?>

				<p class="awaiting-moderation alert"><?php _e('Your comment is awaiting moderation', 'subsolar'); ?></p>

			<?php endif; ?>

			<?php comment_text(); ?>
		</article>
		<?php

	}
}

/*===========================================================*/
/*    Pingbacks
/*===========================================================*/

if ( !function_exists( 'sdesigns_list_pings' ) ) {
	function sdesigns_list_pings($comment, $args, $depth) {

		$GLOBALS['comment'] = $comment; ?>

		<li <?php comment_class('pingback'); ?> id="comment-<?php comment_ID() ?>">
			<article class="comment-content">
				<header class="ping-header">
					<h5 class="comment-author"><?php _e('Pingback:', 'subsolar'); ?></h5>
					<span class="comment-meta"><?php edit_comment_link(__('[Edit]', 'subsolar'),'  ','') ?></span>
				</header>
				<?php comment_author_link(); ?>
			</article>
		</li>
		<?php
	}
}

/*===========================================================*/
/*	Localization
/*===========================================================*/

if ( !function_exists( 'sdesigns_theme_localization' ) ) {
	function sdesigns_theme_localization() {

		load_theme_textdomain( 'subsolar', get_template_directory() . '/lang' );

	}
}

add_action('after_setup_theme', 'sdesigns_theme_localization');

/*===========================================================*/
/*	Check for [gallery] shortcode in a post
/*===========================================================*/

if ( !function_exists( 'sdesigns_check_for_gallery' ) ) {
	function sdesigns_check_for_gallery($content) {

		global $post;

		// false because we have to search through the posts first
		$found = false;

		if( has_shortcode( $content, 'gallery') ) {
			 // we have found a post with the shortcode
			$found = true;
		}

		if ( $found && !is_page($post->ID) ){
			add_shortcode( 'gallery', 'sdesigns_modified_gallery_shortcode' ); //the modified (empty) shortcode
		}
		return $content;
	}
}

// add_action('the_content', 'sdesigns_check_for_gallery');

/*===========================================================*/
/*	Don't output thumbnails with the [gallery] shortcode
/*===========================================================*/

if ( !function_exists( 'sdesigns_modified_gallery_shortcode' ) ) {

	function sdesigns_modified_gallery_shortcode($attr) {
		return '';
	}
}

/*===========================================================*/
/*    Custom wp_link_pages
/*===========================================================*/

if ( !function_exists( 'sdesigns_wp_link_pages' ) ) {
	function sdesigns_wp_link_pages( $args = '' ) {
		$defaults = array(
			'before' => '<p class="link-pages" ><strong>' . __('Pages:', 'subsolar' ) . '</strong> ',
			'after' => '</p>',
			'text_before' => '',
			'text_after' => '',
			'next_or_number' => 'number',
			'nextpagelink' => __( 'Next page', 'subsolar' ),
			'previouspagelink' => __( 'Previous page', 'subsolar' ),
			'pagelink' => '%',
			'echo' => 1
			);

		$r = wp_parse_args( $args, $defaults );
		$r = apply_filters( 'wp_link_pages_args', $r );
		extract( $r, EXTR_SKIP );

		global $page, $numpages, $multipage, $more, $pagenow;

		$output = '';
		if ( $multipage ) {
			if ( 'number' == $next_or_number ) {
				$output .= $before;
				for ( $i = 1; $i < ( $numpages + 1 ); $i = $i + 1 ) {
					$j = str_replace( '%', $i, $pagelink );
					$output .= ' ';
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
						$output .= _wp_link_page( $i );
					else
						$output .= '<span class="current-post-page">';

					$output .= $text_before . $j . $text_after;
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
						$output .= '</a>';
					else
						$output .= '</span>';
				}
				$output .= $after;
			} else {
				if ( $more ) {
					$output .= $before;
					$i = $page - 1;
					if ( $i && $more ) {
						$output .= _wp_link_page( $i );
						$output .= $text_before . $previouspagelink . $text_after . '</a>';
					}
					$i = $page + 1;
					if ( $i <= $numpages && $more ) {
						$output .= _wp_link_page( $i );
						$output .= $text_before . $nextpagelink . $text_after . '</a>';
					}
					$output .= $after;
				}
			}
		}

		if ( $echo )
			echo wp_kses_post($output);

		return $output;
	}
}

/*===========================================================*/
/*    Password Form
/*===========================================================*/

if ( !function_exists( 'sdesigns_password_form' ) ) {
	function sdesigns_password_form() {
		global $post;
		$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
		$output = '<form class="protected-post-form" action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post">
		' . '<p>' . __( "This post is password protected. To view it please enter your password below:", 'subsolar' ) . '</p>' . '
		<label class="pass-label" for="' . $label . '">' . __( "PASSWORD:", 'subsolar' ) . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" /><input class="pass-input button normal" type="submit" name="Submit" class="button" value="' . esc_attr__( "Submit" ) . '" />
		</form>
		';
		return $output;
	}
}
add_filter( 'the_password_form', 'sdesigns_password_form' );


/*===========================================================*/
/*    Fix Shortcodes Newline
/*===========================================================*/
if ( !function_exists( 'sdesigns_the_content_filter' ) ) {
	function sdesigns_the_content_filter($content) {

		// array of custom shortcodes requiring the fix
		$block = join("|",array("collapse","collapsibles", "tabs", "tab"));

		// opening tag
		$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);

		// closing tag
		$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);

		return $rep;

	}
}

add_filter('the_content', 'sdesigns_the_content_filter');

/*===========================================================*/
/*    Add Members CPT to Front Page Dropdown
/*===========================================================*/

function sdesigns_modify_front_pages_dropdown()
{
    add_filter( 'get_pages', 'sdesigns_add_cpt_to_pages_on_front' );
}

add_action( 'admin_head-options-reading.php', 'sdesigns_modify_front_pages_dropdown' );

function sdesigns_add_cpt_to_pages_on_front( $r ) {
    $args = array(
        'post_type' => 'members'
    );
    $stacks = get_posts( $args );
    $r = array_merge( $r, $stacks );

    return $r;
}

/*===========================================================*/
/*    Sessions Init
/*===========================================================*/
function sdesigns_aq_resize( $src, $w, $h, $crop ) {
	if( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'photon' ) ) {
		$args = array(
			'resize' => $w . ', ' . $h
		);
		return jetpack_photon_url( $src, $args );
	} else {
		return aq_resize( $src, $w, $h, $crop, true, true);
	}
}

/*===========================================================*/
/*    Sessions Init
/*===========================================================*/

add_action('init', 'sdesigns_start_session', 1);
add_action('wp_logout', 'sdesigns_end_session');
add_action('wp_login', 'sdesigns_end_session');

function sdesigns_start_session() {
    if(!session_id()) {
        session_start();
    }
}

function sdesigns_end_session() {
    session_destroy ();
}



function my_acf_format_value( $value, $post_id, $field ) {
	
	// run do_shortcode on all textarea values
	$value = do_shortcode($value);
	
	
	// return
	return $value;
}

// add_filter('acf/format_value/type=textarea', 'my_acf_format_value', 10, 3);


/*===========================================================*/
/*    Populate Portfolio Category Array
/*===========================================================*/


function sdesigns_populate_categories_array($value){
	return 'isotope-category-' . $value;
}


/*===========================================================*/
/*    Search blog posts only
/*===========================================================*/

function _filter_ssd_search_blog_posts($query) {
	if ( ($query->is_search) && get_query_var('post_type') != 'deal' ) {
		$query->set('post_type', 'post');
	}
	return $query;
}

add_filter('pre_get_posts','_filter_ssd_search_blog_posts');

/*===========================================================*/
/*    Back To Portfolio Link
/*===========================================================*/

function sdesigns_back_to_portfolio_link() {

	$project_terms = wp_get_post_terms(  get_the_ID(), 'portfolio_category' );
	$project_terms_array = array();

	// GET CATEGORIES OF PROJECT
	foreach($project_terms as $term) {
		array_push($project_terms_array, $term->term_id);
	}

	$args = array(
		'post_type' => 'page',
		'meta_key' => '_wp_page_template',
		'meta_value' => 'template-portfolio-grid.php',
		'posts_per_page' => -1
		);


	$portfolios_query = new WP_Query($args);

	$found = false;

	if ($portfolios_query->have_posts()) : while ($portfolios_query->have_posts()) : $portfolios_query->the_post();
		
		$exclude_cats = get_field('exclude_categories', get_the_ID());

		if( !empty($exclude_cats[0]['category']) ) {
			$exclude_cats_ids = array();
			foreach( $exclude_cats as $cat) {
				array_push($exclude_cats_ids, $cat['category']->term_id);
			}
		}

		if ( !$found ) {
			if ( !in_array($exclude_cats_ids, $project_terms_array) ) {
				$found = true;
				$portfolio_id = get_the_ID();
			}
		}
	
	
	endwhile; endif;

	wp_reset_postdata();

	if ( isset($portfolio_id) ) {
		return get_permalink($portfolio_id);
	} else {
		return false;
	}

	
}

/*===========================================================*/
/*    Portfolio Next/Prev
/*===========================================================*/


function sdesigns_portfolio_nav($portfolio_id){
	
	// $portfolio_id = url_to_postid( $_SESSION['portfolioLink'] );
	$exclude_cats = get_field('exclude_categories', $portfolio_id);

	$args = array(
		'post_type' => 'portfolio',
		'posts_per_page' => -1
	);

	if( !empty($exclude_cats[0]['category']) ) {
		$exclude_cats_ids = array();
		foreach( $exclude_cats as $cat) {
			array_push($exclude_cats_ids, $cat['category']->term_id);
		}

		

		$args['tax_query'] = array(array(
			'taxonomy' => 'portfolio_category',
			'field' => 'term_id',
			'terms' => $exclude_cats_ids,
			'operator' => 'NOT IN'
		));
	}

		$projects_query = new WP_Query($args);

		$projects_ids = array();

		if ($projects_query->have_posts()) : while ($projects_query->have_posts()) : $projects_query->the_post();
		
			array_push($projects_ids, get_the_ID());
		
		endwhile; endif;
		wp_reset_query();
		
		// $portfolio_id = url_to_postid($_SESSION['portfolioLink']);

		$key = array_search( get_the_ID(), $projects_ids); //gets the position of the current project from all the projects in the portfolio page
		?>
		<div class="project-nav">
		<?php
		if ( $key == 0 ) { ?>
			<a href="<?php echo get_permalink( $projects_ids[$key+1] ); ?>" class="project-nav-next"><?php echo get_the_title($projects_ids[$key+1]) ?><i class="fa fa-chevron-right"></i></a>
		<?php 
		} elseif ( array_key_exists( $key+1, $projects_ids) ) { ?>
			<a href="<?php echo get_permalink( $projects_ids[$key-1] ); ?>" class="project-nav-prev"><i class="fa fa-chevron-left"></i><?php echo get_the_title($projects_ids[$key-1]) ?></a>
			<a href="<?php echo get_permalink( $projects_ids[$key+1] ); ?>" class="project-nav-next"><?php echo get_the_title($projects_ids[$key+1]) ?><i class="fa fa-chevron-right"></i></a>
		<?php
		} else { ?>
			<a href="<?php echo get_permalink( $projects_ids[$key-1] ); ?>" class="project-nav-prev"><i class="fa fa-chevron-left"></i><?php echo get_the_title($projects_ids[$key-1]) ?></a>
		<?php
		}
		?>
		</div>
		<?php


}



/*===========================================================*/
/*    Portfolio slug for page
/*===========================================================*/


add_filter( 'wp_unique_post_slug_is_bad_hierarchical_slug', 'sdesigns_portfolio_is_bad_hierarchical_slug', 10, 4 );
function sdesigns_portfolio_is_bad_hierarchical_slug( $is_bad_hierarchical_slug, $slug, $post_type, $post_parent ) {
    if ( !$post_parent && $slug == 'portfolio' )
        return true;
    return $is_bad_hierarchical_slug;
}

add_filter( 'wp_unique_post_slug_is_bad_flat_slug', 'sdesigns_portfolio_is_bad_flat_slug', 10, 3 );
function sdesigns_portfolio_is_bad_flat_slug( $is_bad_flat_slug, $slug, $post_type ) {
    if ( $slug == 'portfolio' )
        return true;
    return $is_bad_flat_slug;
}