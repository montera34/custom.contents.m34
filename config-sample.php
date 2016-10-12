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

// TAXONOMIES DATA
$taxs = array(
	'tax-id' => array(
		'labels' => array(
			'name' => __( '','m34_cc' ),
			'singular_name' => __( '','m34_cc' ),
			'search_items' => __( 'Search','m34_cc' ),
			'all_items' => __( 'All items','m34_cc' ),
			'parent_item' => __( 'Parent','m34_cc' ),
			'parent_item_colon' => __( 'Parent:','m34_cc' ),
			'edit_item' => __( 'Edit','m34_cc' ),
			'update_item' => __( 'Update','m34_cc' ),
			'add_new_item' => __( 'Add new','m34_cc' ),
			'new_item_name' => __( 'Name of the new item' ),
			'menu_name' => __( '','m34_cc' )
		),
		'slug' => 'tax-slug',
		'description' => __( '','m34_cc' ),
		'cpts' => array(),
		'hierarchical' => true
	)
);

// PREFIX
// for all post meta and term meta fields
$prefix = "_prefix";

// POST CUSTOM META BOXES
$fields = array(
	'cpt-id' => array(
		'context' => 'normal', // context: normal, side, advanced
		'priority' => 'default', // priority: high, core, default, low
		'fields' => array(
			$prefix.'metabox-id' => array(
				'name' => __('','m34_cc'),
				'description' => __('','m34_cc'),
				'type' => 'text', // text, date, color, wysiwyg
			),
			$prefix.'metabox2-id' => array(
				'name' => __('','m34_cc'),
				'description' => __('','m34_cc'),
				'type' => 'text',
			)
		)
	),
	'cpt2-id' => array(
		'context' => 'normal', // context: normal, side, advanced
		'priority' => 'default', // priority: high, core, default, low
		'fields' => array(
			$prefix.'metabox3-id' => array(
				'name' => __('','m34_cc'),
				'description' => __('','m34_cc'),
				'type' => 'wysiwyg',
				'args' => array(
					'media_buttons' => 'false',
					'textarea_rows' => '5'
				)

			)
		)
	)
);

// TERM META
$term_meta = array(
	'cpt-id' => array(
		'fields' => array(
			$prefix.'metabox-id' => array(
				'name' => __('','m34_cc'),
				'description' => __('','m34_cc'),
				'type' => 'text' // text, image
			),
			$prefix.'metabox2-id' => array(
				'name' => __('','m34_cc'),
				'description' => __('','m34_cc'),
				'type' => 'image'
			)
		)
	),
	'cpt2-id' => array(
		'fields' => array(
			$prefix.'metabox3-id' => array(
				'name' => __('','m34_cc'),
				'description' => __('','m34_cc'),
				'type' => 'text'
			)
		)
	)
);
?>
