<?php

function sdesigns_custom_styles() {
global $redux_data;

$main_color = esc_attr($redux_data['color-main']);
$secondary_color = esc_attr($redux_data['color-secondary']);
?>

<style type="text/css">

/* Main Color */

.button:hover, .page-nav a:hover {
  background: <?php echo $main_color; ?>;
  border: 1px solid <?php echo $main_color; ?>;
}
.highlight {
  color: <?php echo $main_color; ?>;
}
::selection {
  background: <?php echo $main_color; ?>;
}
::-moz-selection {
  background: <?php echo $main_color; ?>;
}
.spinner .front {
  background-color: <?php echo $main_color; ?>;
}
#nav-container .sub-menu {
  border-top: 3px solid <?php echo $main_color; ?>;
}
.logo-title a {
  color: <?php echo $main_color; ?>;
}
.social-container a:hover {
  color: <?php echo $main_color; ?>;
}
.agency-s-icon i {
  color: <?php echo $main_color; ?>;
}
.masonry-grid-item h5:before {
  background-color: <?php echo $main_color; ?>;
}
.portfolio-vertical .owl-prev, .portfolio-vertical .owl-next {
  color: <?php echo $main_color; ?>;
}
.portfolio-vertical .owl-prev {
  border-left: 5px solid <?php echo $main_color; ?>;
}
.portfolio-vertical .owl-prev:hover {
  border-left: 50px solid <?php echo $main_color; ?>;
}
.portfolio-vertical .owl-next {
  border-right: 5px solid <?php echo $main_color; ?>;
}
.portfolio-vertical .owl-next:hover {
  border-right: 50px solid <?php echo $main_color; ?>;
}
.portfolio-horizontal-item .item-description {
  border-left: 5px solid <?php echo $main_color; ?>;
}
.portfolio-horizontal-item:hover .item-description {
  border-left: 8px solid <?php echo $main_color; ?>;
}
.single-project-title {
  background-color: <?php echo $main_color; ?>;
}
.project-details li i {
  color: <?php echo $main_color; ?>;
}
#portfolio-single-slider .section-title {
  background-color: <?php echo $main_color; ?>;
}
.member-description {
  border-top: 5px solid <?php echo $main_color; ?>;
}
.member-social {
  border-left: 5px solid <?php echo $main_color; ?>;
}
.service-icon:before {
  background-color: <?php echo $main_color; ?>;
}
.contactform input:focus {
  background: <?php echo $main_color; ?>;
}
.contactform textarea:focus {
  background: <?php echo $main_color; ?>;
}
.post-meta i {
  color: <?php echo $main_color; ?>;
}
.single-post-meta_bottom  a:hover {
    background-color: <?php echo $main_color; ?>;
}
.single-post-meta i {
  color: <?php echo $main_color; ?>;
}
.comment-meta a:hover {
  color: <?php echo $main_color; ?>;
}
.comment-form input[type="submit"]:hover, .pass-input:hover, input[type="submit"]:hover {
  background: <?php echo $main_color; ?>;
}
.error-header:after {
  background-color: <?php echo $main_color; ?>;
}
.panel-heading.active {
  background-color: <?php echo $main_color; ?>;
  border-color: <?php echo $main_color; ?>;
}
blockquote {
  border-color: <?php echo $main_color; ?>;
}
.password-protected {
  background-color: <?php echo $main_color; ?>;
}
.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
  background-color: <?php echo $main_color; ?>;
  border: 1px solid <?php echo $main_color; ?>;
}



/* Secondary Color */
#nav-container {
  background-color: <?php echo $secondary_color; ?>;
}
.spinner .back {
     background-color: <?php echo $secondary_color; ?>;
}
#header {
    background-color: <?php echo $secondary_color; ?>;
}
.filters li a:hover, .filters li.selected a {
     border-bottom: 3px solid <?php echo $secondary_color; ?>;
}
.portfolio-horizontal-item:hover .item-description {
  background-color: <?php echo $secondary_color; ?>;
}
.section-bg {
    background-color: <?php echo $secondary_color; ?>;
}
.project-details {
    background-color: <?php echo $secondary_color; ?>;
}
.post-description {
    background-color: <?php echo $secondary_color; ?>;
}
.single-post-meta {
    background-color: <?php echo $secondary_color; ?>;
}
.comment-form input[type="submit"], .pass-input, input[type="submit"] {
    border: 1px solid <?php echo $secondary_color; ?>;
}
.button, .page-nav a {
    border: 1px solid <?php echo $secondary_color; ?>;
}
.post-meta_bottom  a {
    background-color: <?php echo $secondary_color; ?>;
}

/* Nav Text Color */

#nav-container a {
  color:<?php echo esc_attr($redux_data['color-nav-link']); ?>;
}
#nav-container a:hover {
  color: <?php echo esc_attr($redux_data['color-nav-hover']); ?>;
  background-color: <?php echo esc_attr($redux_data['color-nav-bg-hover']); ?>;
}
#nav-container .sub-menu a {
    color: <?php echo esc_attr($redux_data['color-nav-submenu-link']); ?>;;
}
/*#nav-container .current-menu-item a {
   color: <?php echo $redux_data['color-nav-link']; ?>;
}*/
#nav-container sub-menu .current-menu-item a {
   color: <?php echo esc_attr($redux_data['color-nav-current']); ?>;
}
.post-description, .project-details, .post-meta_bottom a {
   color: <?php echo esc_attr($redux_data['color-blog-projects-main']); ?>;
}
.post-description, .single-post-meta a {
  color: <?php echo esc_attr($redux_data['color-blog-projects-secondary']); ?>;
}

/* Background Image */
.main-content {
    background-color: <?php echo esc_attr($redux_data['background']['background-color']); ?>;
    background-image: url('<?php echo esc_attr($redux_data['background']['background-image']); ?>');
    background-repeat: <?php echo esc_attr($redux_data['background']['background-repeat']); ?>;
}

/* Dividers */

<?php
if( $redux_data['dividers-switch']) : ?>
.divider, .divider-inv {
    display: none;
}
.section-title {
  margin-bottom: 50px;
}
<?php endif; ?>

<?php
if( $redux_data['page-title-switch']) : ?>
.section-title {
    display: none;
}
.section-title {
  margin-bottom: 50px;
}
<?php endif; ?>

<?php
if( !empty( $redux_data['custom-css']) ) {
  echo esc_attr($redux_data['custom-css']);
}
?>
</style>

<?php }
add_action( 'wp_head', 'sdesigns_custom_styles', 100 );

function sdesigns_custom_scripts() {
global $redux_data;
?>


<script type="text/javascript">

jQuery(window).ready(function($) {

})

</script>

<?php
}

add_action( 'wp_footer', 'sdesigns_custom_scripts', 20 );