<?php
/**
 * Plugin Name: WP Plugin Quote
 * Plugin URI:  https://treemix-developer.com/
 * Description: A quote plugin for WordPress.
 * Version:     1.0.0
 * Author:      TREEMIX
 * Author URI:  https://treemix-developer.com/
 * Text Domain: wp-plugin-quote
 * License:     GPL-3.0+
 * License URI: https://treemix-developer.com/
 * Domain Path: /languages
 */

define( 'WP_PLUGIN_QUOTE_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

include trailingslashit( WP_PLUGIN_QUOTE_DIR )."includes/WP_Plugin_Quote.php";
include trailingslashit( WP_PLUGIN_QUOTE_DIR ) . 'includes/WP_Plugin_Quote_Registration.php';
include trailingslashit( WP_PLUGIN_QUOTE_DIR ) . 'includes/WP_Plugin_Quote_Widget.php';

if ( !class_exists( 'WP_Plugin_Quote' ) ) {

    WP_Plugin_Quote::get_instance();

}