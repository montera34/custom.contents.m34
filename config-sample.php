<?php 
// CUSTOM POST TYPES DATA
$cpts = array(
	'cpt-id' => array(
		'labels' => array(
			'name' => __( '','m34_cc' ),
			'singular_name' => __( '','m34_cc' ),
			'add_new_item' => __( 'Add','m34_cc' ),
			'edit' => __( 'Edit','m34_cc' ),
			'edit_item' => __( 'Edit this','m34_cc' ),
			'new_item' => __( 'New','m34_cc' ),
			'view' => __( 'View','m34_cc' ),
			'view_item' => __( 'View this','m34_cc' ),
			'search_items' => __( 'Search','m34_cc' ),
			'not_found' => __( 'Nothing found','m34_cc' ),
			'not_found_in_trash' => __( 'Nothong in the Trash','m34_cc' )
		),
		'slug' => 'cpt-slug',
		'icon' => 'dashicon-name',// https://developer.wordpress.org/resource/dashicons
		'fields' => array('title','editor','author','thumbnail'),
		'hierarchical' => false, // if true this post type will be as pages

	)
);
?>
