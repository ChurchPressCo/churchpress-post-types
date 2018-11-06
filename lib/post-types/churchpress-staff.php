<?php

/**
 * General purpose theme functions.
 *
 * @package     Churchpress
 * @subpackage  Genesis
 * @copyright   Copyright (c) 2014, Bottlerocket Creative, LLC.
 * @license     GPL-2.0+
 * @since       1.1.0
 */

//* Register Sermons Post Type
function churchpress_staff() {
	$args = array(
		'labels'				=> array(
			'name'				=> __( 'Staff', 'churchpress-post-types' ),
			'singular_name'		=> __( 'Staff Member', 'churchpress-post-types' ),
			'add_new_item'		=> __( 'Add New Staff Member', 'churchpress-post-types' ),
			'edit_item'			=> __( 'Edit Staff Member', 'churchpress-post-types' ),
			'view_item'			=> __( 'View Staff Member', 'churchpress-post-types' ),
			'search_items'		=> __( 'Search Staff', 'churchpress-post-types' )
		),
		'has_archive'			=> true,
		'hierarchical'			=> false,
		'menu_icon'				=> 'dashicons-admin-users',
		'menu_position'			=> 20,
		'public'				=> true,
		'supports'				=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'genesis-seo', 'genesis-cpt-archives-settings' ),
		'rewrite'				=> array( 'slug' => 'staff', 'with_front' => true ),
	);

	register_post_type( 'churchpress-staff', $args);
}