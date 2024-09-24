<?php
/**
 * Plugin Name: Roomly - Hotel Booking Plugin for WordPress
 * Plugin URI: https://github.com/albbmg/roomly
 * Description: Roomly is a hotel booking plugin for WordPress that allows users to book rooms, pay online, and receive booking confirmations.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://github.com/albbmg
 * Text Domain: roomly
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

// Cargar la clase principal del plugin
require_once plugin_dir_path( __FILE__ ) . 'includes/class-roomly-plugin.php';

// Cargar la clase de Elementor para los widgets
require_once plugin_dir_path( __FILE__ ) . 'includes/class-roomly-elementor.php';

function roomly_init() {
    $plugin = new Roomly_Plugin();
    $plugin->run();
}

add_action( 'plugins_loaded', 'roomly_init' );

function roomly_include_booking_form() {
    $template = plugin_dir_path( __FILE__ ) . 'templates/booking-form.php';
    if ( file_exists( $template ) ) {
        include $template;
    } else {
        echo 'Booking form template not found!';
    }
}
