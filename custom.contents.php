<?php
/*
Plugin Name: Custom contents for a WordPress site
Description: Adds custom post types and custom fiels to a WordPress site.
Version: 0.1
Author: montera34
Author URI: http://montera34.com
License: GPLv3+
 */

// VARS
$ur_ver = "0.1";

// INCLUDE CONFIG FILE
require_once('config.php');

// ACTIONS and FILTERS
// load plugin text domain for string translations
add_action( 'plugins_loaded', 'm34_cc_load_textdomain' );

// Add custom post types and taxonomies
add_action(  'init', 'm34_cc_create_post_type', 0 );
//add_action( 'init', 'm34_cc_build_taxonomies', 0 );
register_activation_hook( __FILE__, 'm34_cc_rewrite_flush' );


// TEXT DOMAIN AND STRING TRANSLATION
function m34_cc_load_textdomain() {
	load_plugin_textdomain( 'm34_cc', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' ); 
}

// POST TYPES
function m34_cc_create_post_type() {
	global $cpts;
	foreach ( $cpts as $cpt => $data ) {
		register_post_type( $cpt, array(
			'labels' => $data['labels'],
			'description' => '',
			'has_archive' => true,
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'menu_position' => 5,
			'menu_icon' => $data['icon'],
			'hierarchical' => $data['hierarchical'],
			'query_var' => true,
			'supports' => $data['fields'],
			'rewrite' => array('slug'=>$data['slug'],'with_front'=>false),
			'can_export' => true,
			'_builtin' => false,
			//'capability_type' => 'post'
		));
	}
}

// rewrite flush rules to init post type and taxonomies
function m34_cc_rewrite_flush() {
	m34_cc_create_post_type();
	flush_rewrite_rules();
}


