<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

class Roomly_Elementor_Booking_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'roomly_booking_widget';
    }

    public function get_title() {
        return __( 'Roomly Booking Form', 'roomly' );
    }

    public function get_icon() {
        return 'fa fa-calendar';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'roomly' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'roomly' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Book Your Room', 'roomly' ),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $template = plugin_dir_path( dirname( __FILE__ ) ) . '../templates/booking-form.php';

        error_log( 'Generated template path: ' . $template );

        if ( file_exists( $template ) ) {
            include $template;
        } else {
            echo 'Booking form template not found!';
        }
    }
}
