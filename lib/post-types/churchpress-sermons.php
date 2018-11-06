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
function churchpress_sermons() {
	$args = array(
		'labels'				=> array(
			'name'				=> __( 'Sermons', 'churchpress-post-types' ),
			'singular_name'		=> __( 'Sermon', 'churchpress-post-types' ),
			'add_new_item'		=> __( 'Add New Sermon', 'churchpress-post-types' ),
			'edit_item'			=> __( 'Edit Sermon', 'churchpress-post-types' ),
			'view_item'			=> __( 'View Sermon', 'churchpress-post-types' ),
			'search_items'		=> __( 'Search Sermons', 'churchpress-post-types' )
		),
		'has_archive'			=> true,
		'hierarchical'			=> false,
		'menu_icon'				=> 'dashicons-microphone',
		'menu_position'			=> 20,
		'public'				=> true,
		'supports'				=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'genesis-seo', 'genesis-cpt-archives-settings' ),
		'rewrite'				=> array( 'slug' => 'sermons', 'with_front' => true ),
	);

	register_post_type( 'churchpress-sermon', $args);
}

//* Add meta box fields
function churchpress_sermons_meta_admin() {

	//* Add additional meta information to the Events post type
	add_action( 'add_meta_boxes', 'churchpress_add_sermon_meta_box' );
	function churchpress_add_sermon_meta_box() {
		add_meta_box(
			'churchpress_sermon_details',
			__( 'Sermon Details', 'churchpress-post-types' ),
			'churchpress_display_sermon_details_admin',
			'churchpress-sermon',
			'side'
		);
	}

	function churchpress_display_sermon_details_admin( $post ) {

		wp_nonce_field( 'churchpress_speaker_field', 'churchpress_speaker_field_nonce' );
		wp_nonce_field( 'churchpress_sermon_date_field', 'churchpress_sermon_date_field_nonce' );
		wp_nonce_field( 'churchpress_soundcloud_url_field', 'churchpress_soundcloud_url_field_nonce' );

		// Retrieve current information based on post ID
		$sermon_speaker = get_post_meta( $post->ID, '_churchpress_speaker_field', true );
		$sermon_date = get_post_meta( $post->ID, '_churchpress_sermon_date_field', true );
	    $soundcloud_url = get_post_meta( $post->ID, '_churchpress_soundcloud_url_field', true );

    	echo	'<label for="churchpress_sermon_speaker">' . __( 'Speaker', 'churchpress-post-types' ) . '</label>',
				'<input type="text" id="sermon-speaker" name="churchpress_speaker_field" value="' . $sermon_speaker . '" size="25" style="width: 100%;" />',

				'<label for="churchpress_sermon_date">' . __( 'Sermon Date', 'churchpress-post-types' ) . '</label>',
				'<input type="date" id="sermon-date" name="churchpress_sermon_date_field" value="' . $sermon_date . '" size="25" style="width: 100%;" />',

				'<label for="churchpress_souncloud_url">' . __( 'Soundcloud URL', 'churchpress-post-types' ) . '</label>',
				'<input type="text" id="soundcloud-url" name="churchpress_soundcloud_url_field" value="' . $soundcloud_url . '" size="25" style="width: 100%;" />';

	}

	//* Save the fields
	add_action( 'save_post', 'churchpress_sermons_meta_save', 10, 3 );
	function churchpress_sermons_meta_save( $post_id, $post, $update ) {

		$slug = 'churchpress-sermon';

		if ( $slug != $post->post_type ) {
			return;
		}

		//* OK - It's safe for us to do stuff now */

		//* Make sure that it is set.
		if ( ! isset( $_POST['churchpress_speaker_field'] ) ) {
			return;
		}
		if ( ! isset( $_POST['churchpress_sermon_date_field'] ) ) {
			return;
		}
		if ( ! isset( $_POST['churchpress_soundcloud_url_field'] ) ) {
			return;
		}

		//* Sanatize
		$speaker_data = sanitize_text_field( $_REQUEST['churchpress_speaker_field'] );
		$sermon_date_data = sanitize_text_field( $_REQUEST['churchpress_sermon_date_field'] );
		$soundclourd_url_data = sanitize_text_field( $_REQUEST['churchpress_soundcloud_url_field'] );

		//* Update the meta field in the database.
		if ( isset( $_REQUEST['churchpress_speaker_field'] ) ) {
			update_post_meta( $post_id, '_churchpress_speaker_field', $speaker_data );
		}
		if ( isset( $_REQUEST['churchpress_sermon_date_field'] ) ) {
			update_post_meta( $post_id, '_churchpress_sermon_date_field', $sermon_date_data );
		}
		if ( isset( $_REQUEST['churchpress_soundcloud_url_field'] ) ) {
			update_post_meta( $post_id, '_churchpress_soundcloud_url_field', $soundclourd_url_data );
		}
	}
}
