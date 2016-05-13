<?php
add_action("init","sdesigns_custom_post_types");
function sdesigns_custom_post_types(){

	register_post_type( 'portfolio',
		array(
			'labels' => array(
				'name' =>  __('Portfolio', 'subsolar'),
				'singular_name' => __('Portfolio', 'subsolar'),
				),
			'hierarchical' => false,
			'public' => true,
			'supports' => array('title','editor','thumbnail', 'page-attributes'),
			'rewrite' => array(
				'slug' => ''
				)
		)
	);

	register_taxonomy(
		'portfolio_category',
		array (
			0 => 'portfolio',
			),
		array(
			'hierarchical' => true,
			'label' =>  __('Portfolio Category', 'subsolar'),
			'show_ui' => true,
			'query_var' => true,
			'singular_label' => __('Portfolio Category', 'subsolar')
		)
	);

	register_post_type( 'members',
		array(
			'labels' => array(
				'name' =>  __('Team Members', 'subsolar'),
				'singular_name' => __('Member', 'subsolar'),
				'add_new_item'  => __( 'New Member', 'subsolar' )
				),
			'public' => true,
			'supports' => array('title','editor'),
			'rewrite' => array(
				'slug' => 'member',
				'with_front' => true
				)
		)
	);

}