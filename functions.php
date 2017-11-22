<?php
/**
 * Theme Functions
 *
 * @package Tiga CMS
 * @since   1.0.0
 * @version 1.0.0
 */

require(get_stylesheet_directory() . '/inc/flash-message.php'); 
require(get_stylesheet_directory() . '/inc/extras.php'); 
require(get_stylesheet_directory() . '/app/login.php'); 
require(get_stylesheet_directory() . '/app/dashboard.php'); 
require(get_stylesheet_directory() . '/app/articles.php'); 

/**
 * Main theme init
 */
function init_tiga_cms() {
	show_admin_bar( false );
	add_theme_support( 'post-thumbnails' );
}
add_action( 'init', 'init_tiga_cms' );

/**
 * Enqueue demo scripts
 */
function demo_scripts() {
	// styles
	wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' );
	wp_enqueue_style( 'tiga-style', get_stylesheet_uri() );
	
	// media uploader
	wp_enqueue_media();

	// js jquery
	wp_register_script('jquery-3.2.1', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js', false, '3.2.1', true);
	wp_enqueue_script('jquery-3.2.1');

	// js modernizr
  	wp_register_script('modernizr',  'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', false, '2.8.3', true);
	wp_enqueue_script('modernizr');
	
	// js popper
	wp_register_script('popper',  'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js', false, '1.12.3', true);
	wp_enqueue_script('popper');
  	
  	// js bootstarp
  	wp_register_script('bootstrap-js', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/js/bootstrap.min.js', false, '4.0.0-beta.2', true);
	wp_enqueue_script('bootstrap-js');

	// media uploader
	wp_register_script('media-uploader-js', get_template_directory_uri() . '/assets/media-uploader.js');
	wp_enqueue_script('media-uploader-js');

	// js script
	wp_register_script('script-js', get_template_directory_uri() . '/assets/script.js');
	wp_enqueue_script('script-js');
}
add_action( 'wp_enqueue_scripts', 'demo_scripts' );

/**
 * Create DB table for demo purpose
 */
function create_demo_db_table() {
	global $wpdb;
	$db_name = 'items';
	$charset_collate = $wpdb->get_charset_collate();

	if ( $wpdb->get_var( "SHOW TABLES LIKE '$db_name'") !== $db_name ) {
		$sql = 'CREATE TABLE ' . $db_name . " 
				( `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, 
				  `name` varchar(255) NOT NULL, 
				  `price` varchar(255) NOT NULL, 
				  `description` text NOT NULL, 
				  PRIMARY KEY  (`id`) 
			  ) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
}
add_action( 'init', 'create_demo_db_table' );