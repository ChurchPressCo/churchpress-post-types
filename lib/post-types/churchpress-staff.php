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
		'supports'				=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'page-attributes', 'genesis-seo', 'genesis-cpt-archives-settings' ),
		'rewrite'				=> array( 'slug' => 'staff', 'with_front' => true ),
	);

	register_post_type( 'churchpress-staff', $args );
}


//* Add meta box fields
function churchpress_staff_meta_admin() {

	//* Add additional meta information to the staff post type
	add_action( 'add_meta_boxes', 'churchpress_add_staff_meta_box' );
	function churchpress_add_staff_meta_box() {
		add_meta_box(
			'churchpress_staff_subtitle', // $id
			__( 'Position/Title', 'churchpress-post-types' ), // $title
			'churchpress_staff_subtitle_admin', // $callback
			'churchpress-staff', // $screen
			'after_title', // $context
			'high', // $priority
			'' // $callback_args
		);
	}

	add_action( 'edit_form_after_title', 'churchpress_meta_box_position' );
	function churchpress_meta_box_position() {
		global $post, $wp_meta_boxes;

		do_meta_boxes( 'churchpress-staff', 'after_title', $post );
		unset( $wp_meta_boxes[ get_post_type( $post ) ]['after_title'] );
	}

	function churchpress_staff_subtitle_admin( $post ) {

		wp_nonce_field( 'churchpress_subtitle_field', 'churchpress_subtitle_field_nonce' );

		// Retrieve current information based on post ID
		$staff_title = get_post_meta( $post->ID, 'churchpress_subtitle', true );

			echo '<label for="churchpress_subtitle_field" aria-label="Subtitle"></label>',
				'<input type="text" id="staff-title" name="churchpress_subtitle_field" value="' . $staff_title . '" class="widefat" style="width: 100%;" size="30" />';

	}

	//* Save the fields
	add_action( 'save_post', 'churchpress_staff_meta_save', 10, 3 );
	function churchpress_staff_meta_save( $post_id, $post, $update ) {

		if ( ! isset( $_POST['churchpress_subtitle_field_nonce'] ) || ! wp_verify_nonce( $_POST['churchpress_subtitle_field_nonce'], 'churchpress_subtitle_field' ) ) {
			return $post_id;
		}

		if( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		if( defined("DOING_AUTOSAVE") && DOING_AUTOSAVE ) {
			return false;
		}

		$slug = 'churchpress-staff';

		if ( $slug != $post->post_type ) {
			return;
		}

		//* OK - It's safe for us to do stuff now */

		//* Make sure that it is set.
		if ( ! isset( $_POST['churchpress_subtitle_field'] ) ) {
			return;
		}

		//* Sanatize
		$title_data = sanitize_text_field( $_POST['churchpress_subtitle_field'] );

		//* Update the meta field in the database.
		if ( isset( $_POST['churchpress_subtitle_field'] ) ) {
			update_post_meta( $post_id, 'churchpress_subtitle', $title_data );
		}
	}
}
