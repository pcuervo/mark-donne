<?php

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');

if ( post_password_required() ) { ?>
<p class="password-protected"><?php _e("This post is password protected. Enter the password to view comments.",'subsolar'); ?></p>
<?php
return;
}
?>

<?php if ( have_comments() ) :

	/* Display Comments */
	if ( ! empty($comments_by_type['comment']) ) : ?>

		<div class="commentslist-container bg-color">

			<h3 id="comments"><?php _e('Recent Comments', 'subsolar'); ?></h3>

			<ul class="commentlist">
				<?php wp_list_comments('type=comment&callback=sdesigns_comments'); ?>
			</ul>

		</div>

		<?php endif; // end display comments

		/* Display pings */
		if ( ! empty($comments_by_type['pings']) ) : ?>
		<h3 id="pings">Trackbacks and Pingbacks</h3>

		<ul class="pinglist">
			<?php wp_list_comments('type=pings&callback=sdesigns_list_pings'); ?>
		</ul>
		<?php endif; // end display pings

		/* Pagination check */
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

		<div class="page-nav">
			<span class="nav-prev"><?php previous_comments_link( __("Older comments", 'subsolar' ) ) ?></span>
			<span class="nav-next"><?php next_comments_link( __("Newer comments", 'subsolar' ) ) ?></span>
		</div>

		<?php endif; // end pagination check

		/* Check if comments are closed */
		elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'subsolar' ) ) : ?>

		<!-- If comments are closed. -->
		<p class="alert alert-info"><?php _e("Comments are closed", 'subsolar'); ?>.</p>

	<?php endif;


	if ( comments_open() ) :

		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );

	$fields = array(
		'fields' => apply_filters( 'comment_form_default_fields', array(

			'author' =>
			'<p class="comment-form-author col-sm-4"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
			'" size="30"' . $aria_req . ' placeholder="' .
			( $req ? '*' : '' ) .
			' ' . __( 'Name', 'subsolar' ) . '" /></p>',

			'email' =>
			'<p class="comment-form-email col-sm-4"><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
			'" size="30"' . $aria_req . ' placeholder="' .
			( $req ? '*' : '' ) .
			' ' . __( 'Email', 'subsolar' ) . '" /></p>',

			'url' =>
			'<p class="comment-form-url col-sm-4">' .
			'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
			'" size="30" placeholder="' . __( 'Website', 'subsolar' ) . '" /></p>'
			)
		),

		'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="4" aria-required="true" placeholder="' . __('Comment', 'subsolar' ) . '"></textarea></p>',
		'must_log_in' => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'subsolar' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
		'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out &raquo;</a>', 'subsolar' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'title_reply' => __('Leave a Comment', 'subsolar'),
		'title_reply_to' => __('Leave a Reply to %s', 'subsolar'),
		'cancel_reply_link' => __('Cancel Reply', 'subsolar'),
		'label_submit' => __('Post Comment', 'subsolar')
		);

	comment_form($fields);











	endif; // if you delete this the sky will fall on your head ?>
