<?php
/**
 * Plugin Name: Elementor Responsive Owl Carousel
 * Description: A highly customizable & responsive carousel plugin for Elementor page builder based on Owl Carousel
 * Plugin URI: https://github.com/thenahidul/gf-owl-carousel-elementor
 *
 * Version: 1.0.0
 * Author: Gutefy
 * Author URI: https://portfolio.gutefy.com
 *
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Text Domain: gf-owl-carousel-elementor
 * Domain Path: /languages
 *
 * Requires at least: 6.0
 * Tested up to: 6.4.1
 * Requires PHP version: 7.4
 *
 * Elementor tested up to: 3.17.3
 * Elementor Pro tested up to: 3.17.1
 */

defined( 'ABSPATH' ) || exit;

use Owl_Carousel_Elementor\Plugin;

/**
 * Define useful constants
 */
define( "GF_OWL_CAROUSEL_VERSION", '1.1.0' );
define( "GF_OWL_CAROUSEL_PLUGIN_FILE", __FILE__ );
define( "GF_OWL_CAROUSEL_PLUGIN_PATH", __DIR__ );
define( "GF_OWL_CAROUSEL_PLUGIN_URL", plugins_url( '', GF_OWL_CAROUSEL_PLUGIN_FILE ) );
define( "GF_OWL_CAROUSEL_PLUGIN_ASSETS", GF_OWL_CAROUSEL_PLUGIN_URL . '/assets' );

/**
 * Plugin function
 *
 * The main plugin function that initializes the plugin
 *
 * @since 1.0.0
 */
function owl_carousel_elementor_addon() {
	// Load plugin file
	require_once( GF_OWL_CAROUSEL_PLUGIN_PATH . '/includes/plugin.php' );
	// Run the plugin
	Plugin::instance();
}

add_action( 'plugins_loaded', 'owl_carousel_elementor_addon' );

/**
 * Plugin activation
 *
 * Add options to database upon plugin activation
 *
 * @since 1.0.0
 */
function gf_owl_carousel_activate() {
	update_option( 'GF_OWL_CAROUSEL_VERSION', GF_OWL_CAROUSEL_VERSION );
	add_option( 'gf_owl_carousel_installed', time() );
}

register_activation_hook( __FILE__, 'gf_owl_carousel_activate' );
