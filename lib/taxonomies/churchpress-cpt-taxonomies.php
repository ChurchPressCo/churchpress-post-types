<?php

/**
 * Custom Taxonomies for CPTs
 *
 * @package     Churchpress
 * @author 		Calvin Makes
 * @subpackage  Genesis
 * @copyright   Copyright (c) 2014, Bottlerocket Creative, LLC.
 * @license     GPL-2.0+
 * @since       1.1.0
 */

function churchpress_staff_taxonomies() {

	$labels = array(
		'name'				=> _x( 'Staff Categories', 'Taxonomy plural name', 'churchpress-post-types' ),
		'singular_name'		=> _x( 'Staff Category', 'Taxonomy singular name', 'churchpress-post-types' ),
		'search_items'		=> __( 'Search Staff Categories', 'churchpress-post-types' ),
		'all_items'         => __( 'All Staff Categories', 'churchpress-post-types' ),
		'parent_item'       => __( 'Parent Staff Category', 'churchpress-post-types' ),
		'parent_item_colon' => __( 'Parent Staff Category:', 'churchpress-post-types' ),
		'edit_item'         => __( 'Edit Staff Category', 'churchpress-post-types' ),
		'update_item'       => __( 'Update Staff Category', 'churchpress-post-types' ),
		'add_new_item'      => __( 'Add New Staff Category', 'churchpress-post-types' ),
		'new_item_name'     => __( 'New Staff Category', 'churchpress-post-types' ),
		'menu_name'         => __( 'Staff Categories', 'churchpress-post-types' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'staff-category' ),
	);

	register_taxonomy( 'staff', array('churchpress-staff'), $args);
}

function churchpress_sermon_taxonomies() {

	$labels = array(
		'name'				=> _x( 'Sermon Categories', 'Taxonomy plural name', 'churchpress-post-types' ),
		'singular_name'		=> _x( 'Sermon Category', 'Taxonomy singular name', 'churchpress-post-types' ),
		'search_items'		=> __( 'Search Sermon Categories', 'churchpress-post-types' ),
		'all_items'         => __( 'All Sermon Categories', 'churchpress-post-types' ),
		'parent_item'       => __( 'Parent Sermon Category', 'churchpress-post-types' ),
		'parent_item_colon' => __( 'Parent Sermon Category:', 'churchpress-post-types' ),
		'edit_item'         => __( 'Edit Sermon Category', 'churchpress-post-types' ),
		'update_item'       => __( 'Update Sermon Category', 'churchpress-post-types' ),
		'add_new_item'      => __( 'Add New Sermon Category', 'churchpress-post-types' ),
		'new_item_name'     => __( 'New Sermon Category', 'churchpress-post-types' ),
		'menu_name'         => __( 'Sermon Categories', 'churchpress-post-types' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'sermon-category' ),
	);

	register_taxonomy( 'sermon', array('churchpress-sermon'), $args);
}
