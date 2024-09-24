<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Roomly_Elementor {

    public function __construct() {
        // Inicializa los widgets cuando Elementor esté cargado
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
    }

    public function register_widgets() {
        if ( defined( 'ELEMENTOR_PATH' ) && class_exists( 'Elementor\Widget_Base' ) ) {
            require_once plugin_dir_path( __FILE__ ) . 'elementor-widgets/class-roomly-elementor-booking-widget.php';
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Roomly_Elementor_Booking_Widget() );
        }
    }
}

new Roomly_Elementor();
