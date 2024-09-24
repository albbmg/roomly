<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Roomly_Plugin {

    public function run() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_assets' ] );
    }

    public function enqueue_frontend_assets() {
        wp_enqueue_style( 'roomly-styles', plugin_dir_url( __FILE__ ) . '../assets/css/roomly-styles.css', [], '1.0.0' );
        wp_enqueue_script( 'roomly-scripts', plugin_dir_url( __FILE__ ) . '../assets/js/roomly-scripts.js', [ 'jquery' ], '1.0.0', true );
    }
}
