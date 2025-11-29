<?php
/*
* Plugin Name: Search Engines Blocked in Header
* Plugin URI: https://github.com/divibanks/search-engines-blocked-in-header
* Description: Display the 'Search Engines Discouraged' notification in the WordPress Toolbar if blog_public option is unchecked.
* Author: Patrick Lumumba
* Version: 2.1.0
* Author URI: https://lumumbas.blog
* License: GPLv2 or later
* License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
* Text Domain: search-engines-blocked-in-header
*
* @package search-engines-blocked-in-header
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Add notice to admin bar if search engines are discouraged
 */
add_action( 'admin_bar_menu', 'sebih_search_engines_blocked', 1000 );
function sebih_search_engines_blocked() {
	global $wp_admin_bar;

	if ( ! is_super_admin() || ! is_admin_bar_showing() ) {
		return;
	}

	if ( ! get_option( 'blog_public' ) ) {
		$wp_admin_bar->add_menu( array(
			'id'    => 'search_engines_blocked',
			'title' => __( 'Search Engines Discouraged', 'search-engines-blocked-in-header' ),
			'href'  => admin_url( 'options-reading.php' ),
			'meta'  => array(
				'class' => 'sebih-toolbar-alert'
			)
		) );
	}
}

/**
 * Load plugin text domain
 */
add_action( 'plugins_loaded', 'sebih_load_textdomain' );
function sebih_load_textdomain() {
	load_plugin_textdomain( 'search-engines-blocked-in-header', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/**
 * Enqueue custom CSS
 */
add_action( 'admin_enqueue_scripts', 'sebih_enqueue_assets' );
function sebih_enqueue_assets() {
	if ( ! get_option( 'blog_public' ) && is_admin_bar_showing() ) {
		wp_enqueue_style(
			'sebih-custom-css',
			plugin_dir_url( __FILE__ ) . 'css/sebih_custom.css',
			array(),
			'1.0.0' // Version added to avoid caching issues
		);
	}
}
