<?php
/*
    Plugin Name:       Churchpress Custom Post Types
    Plugin URI:        https://github.com/calvinmakes/churchpress-post-types
    Description:       The official custom post types for Churchpress themes
    Author:            Churchpress
    Version:           1.2
    Author URI:        https://churchpress.co
    Text Domain:       churchpress-post-types
    Domain Path:       /languages/
    GitHub Plugin URI: https://github.com/ChurchPressCo/churchpress-post-types
    GitHub Branch:     master
*/

defined('ABSPATH') or die("No script kiddies please!");


add_action( 'plugins_loaded', 'churchpress_load_translations' );
/**
 * Load translations.
 */
function churchpress_load_translations() {

  /** Set unique textdomain string */
  $cppt_textdomain = 'churchpress-post-types';

  /** The 'plugin_locale' filter is also used by default in load_plugin_textdomain() */
  $locale = apply_filters( 'plugin_locale', get_locale(), $cppt_textdomain );

  /** Set filter for WordPress languages directory */
  $cppt_wp_lang_dir = apply_filters(
    'cppt_filter_wp_lang_dir',
    trailingslashit( WP_LANG_DIR ) . trailingslashit( $cppt_textdomain ) . $cppt_textdomain . '-' . $locale . '.mo'
  );

  /** Translations: First, look in WordPress' "languages" folder = custom & update-safe! */
  load_textdomain( $cppt_textdomain, $cppt_wp_lang_dir );

  /** Translations: Secondly, look in plugin's "languages" folder = default */
  load_plugin_textdomain(
    $cppt_textdomain,
    FALSE,
    trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) . 'languages'
  );

}


require_once("lib/post-types/churchpress-sermons.php");
require_once("lib/post-types/churchpress-staff.php");
require_once("lib/taxonomies/churchpress-cpt-taxonomies.php");

/**
  *
  * Register Custom Taxonomies
  * @author Calvin Makes
  * @version 1.0.0
  *
  */

add_action( 'genesis_setup', 'churchpress_staff_taxonomies' );
add_action( 'genesis_setup', 'churchpress_sermon_taxonomies' );

/**
  *
  * Fire Custom Post Type Functions
  * @author Calvin Makes
  * @version 1.0.0
  *
  */

//* Churchpress Sermons
add_action( 'genesis_setup', 'churchpress_sermons' );
add_action( 'admin_init', 'churchpress_sermons_meta_admin' );
add_action( 'init', 'churchpress_remove_subtitles_support' );
function churchpress_remove_subtitles_support() {
  remove_post_type_support( 'churchpress-sermons', 'subtitles' );
}

//* Churchpress Staff
add_action( 'genesis_setup', 'churchpress_staff' );
add_action( 'init', 'churchpress_add_subtitles_support' );
function churchpress_add_subtitles_support() {
    add_post_type_support( 'churchpress-staff', 'subtitles' );
}


/**
  *
  * Register Custom Post Type Widgets
  * @author StudioPress
  * @author Jo Waltham
  * @author Pete Favelle
  * @author Robin Cornett
  * @author Calvin Makes
  * @version 1.0.0
  *
  */
add_action( 'init', 'churchpress_widgets_init' );
function churchpress_widgets_init() {
	if ( 'genesis' !== basename( get_template_directory() ) ) {
		add_action( 'admin_init', 'churchpress_deactivate' );
		add_action( 'admin_notices', 'churchpress_notice' );
		return;
	}

}

function churchpress_deactivate() {
	deactivate_plugins( plugin_basename( __FILE__ ) );
}

function churchpress_notice() {

  $notice = sprintf(
    __( '%s only work with the Genesis Framework. It has been <strong>deactivated</strong>.', 'churchpress-post-types' ),
    '<strong>' . __( 'Churchpress Widgets', 'churchpress-post-types' ) . '</strong>'
  );

	printf(
    '<div class="error"><p>%s</p></div>',
    $notice

  );

}

// Register the widget
add_action( 'widgets_init', 'churchpress_register_widget' );
function churchpress_register_widget() {
  register_widget( 'Churchpress_Sermon_Widget' );
  register_widget( 'Churchpress_Featured_Post');
  register_widget( 'Churchpress_Simple_CTA_Widget');
}

require plugin_dir_path( __FILE__ ) . 'lib/widgets/churchpress-sermons-widget.php';
require plugin_dir_path( __FILE__ ) . 'lib/widgets/churchpress-featured-post-widget.php';
require plugin_dir_path( __FILE__ ) . 'lib/widgets/churchpress-simple-cta-widget.php';
