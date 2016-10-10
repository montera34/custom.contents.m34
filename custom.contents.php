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

// ACTIONS
// and
// FILTERS
//
// load plugin text domain for string translations
add_action( 'plugins_loaded', 'm34_cc_load_textdomain' );
// register post types and taxonomies
add_action(  'init', 'm34_cc_create_post_type', 0 );
add_action( 'init', 'm34_cc_build_taxonomies', 0 );
register_activation_hook( __FILE__, 'm34_cc_rewrite_flush' );
// Adds custom metaboxes
add_action( "add_meta_boxes", "m34_cc_metaboxes", 10, 2 );
add_action("save_post", "m34_cc_save_metaboxes", 10, 3);
// register and load scripts
add_action( 'admin_enqueue_scripts', 'm34_cc_load_admin_scripts' );

// TEXT DOMAIN
// and
// STRING TRANSLATION
function m34_cc_load_textdomain() {
	load_plugin_textdomain( 'm34_cc', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' ); 
}

// ADMIN SCRIPTS
function m34_cc_load_admin_scripts() {
	//	global $fields;
	//	$fields data is not loaded in this moment
	//	i dont know why
//	if ( in_array('color',$fields) ) {
		wp_enqueue_style( 'wp-color-picker' ); 
		wp_enqueue_script( 'wp-color-picker' );
//	}
//	if ( in_array('date',$fields) ) {
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_style( 'jquery-style', 'http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );
//	}

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

// TAXONOMIES
function m34_cc_build_taxonomies() {
	global $taxs;
	foreach ( $taxs as $tax => $data ) {
		register_taxonomy( $tax, $data['cpts'], array(
			'labels' => $data['labels'],
			'description' => $data['description'],
			'hierarchical' => $data['hierarchical'],
			'query_var' => $data['slug'],
			'rewrite' => array( 'slug' => $data['slug'], 'with_front' => false ),
			'show_admin_column' => true
		) );
	}
}

// REWRITE FLUSH RULES
// to init post type and taxonomies
function m34_cc_rewrite_flush() {
	m34_cc_create_post_type();
	flush_rewrite_rules();
}

// CUSTOM METABOXES
function m34_cc_metaboxes() {
	global $prefix;
	global $fields;
	foreach ( $fields as $pt => $f ) {
		add_meta_box(
			$prefix.'_'.$pt,
			__('Extra fields for this content','m34_cc'),
			"m34_cc_metaboxes_callback",
			$pt,
			$f['context'],
			$f['priority']
		);
	}
}

function m34_cc_metaboxes_callback($post) {

	global $fields;
	// Add an nonce field so we can check for it later.
	wp_nonce_field('m34_cc_metaboxes_callback', "m34-cc-".$post->post_type."-nonce"); 
	foreach ( $fields[$post->post_type]['fields'] as $id => $data ) {
		$value = get_post_meta( $post->ID, $id, true );

		echo '<p>
			<strong><label for="'.$id.'">'.$data["name"].'</label></strong><br />';

		if ( $data['type'] == 'wysiwyg' ) {
			wp_editor($value,$id);
		} else {
			echo '<input type="text" class="'.$id.'" name="'.$id.'" value="' . esc_attr( $value ) . '" /><br /><span class="howto">'.$data["description"].'</span>';
		}
 		if ( $data['type'] == 'color' ) {
			echo '<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".'.$id.'").wpColorPicker();
			});
			</script>';
		} elseif ( $data['type'] == 'date' ) {
			echo '<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".'.$id.'").datepicker({
					dateFormat : "yy-mm-dd"
				});
			});
			</script>';
		}
		echo '</p>';
	}
}

function m34_cc_save_metaboxes($post_id, $post, $update) {

	global $fields;
	
	// Check if our nonce is set.
	// Verify that the nonce is valid.
	if ( !isset($_POST["m34-cc-".$post->post_type."-nonce"]) || !wp_verify_nonce($_POST["m34-cc-".$post->post_type."-nonce"], 'm34_cc_metaboxes_callback') )
		return $post_id;

	// Check the user's permissions.
	if( !current_user_can("edit_post", $post_id))
		return $post_id;

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
		return $post_id;

	foreach ( $fiels[$post->post_type]['fields'] as $id => $data ) {

		if( isset($_POST[$id]) ) {
			$value = sanitize_text_field($_POST[$id]);
			update_post_meta($post_id, $id, $value);
		}
	}   
}
// end
// CUSTOM METABOXES
