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

function roomly_enqueue_scripts() {
    // Incluir Flatpickr CSS
    wp_enqueue_style( 'flatpickr-css', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css' );
    // Incluir Flatpickr JS
    wp_enqueue_script( 'flatpickr-js', 'https://cdn.jsdelivr.net/npm/flatpickr', [], false, true );

    // Tus scripts personalizados (roomly-scripts.js que vamos a usar para inicializar Flatpickr)
    wp_enqueue_script( 'roomly-scripts', plugin_dir_url( __FILE__ ) . 'assets/js/roomly-scripts.js', [ 'jquery' ], '1.0', true );
    wp_enqueue_style( 'roomly-styles', plugin_dir_url( __FILE__ ) . 'assets/css/roomly-styles.css' );
}
add_action( 'wp_enqueue_scripts', 'roomly_enqueue_scripts' );


function roomly_register_custom_post_type() {
    $labels = array(
        'name'               => __( 'Habitaciones', 'roomly' ),
        'singular_name'      => __( 'Habitación', 'roomly' ),
        'menu_name'          => __( 'Habitaciones', 'roomly' ),
        'name_admin_bar'     => __( 'Habitación', 'roomly' ),
        'add_new'            => __( 'Añadir Nueva', 'roomly' ),
        'add_new_item'       => __( 'Añadir Nueva Habitación', 'roomly' ),
        'new_item'           => __( 'Nueva Habitación', 'roomly' ),
        'edit_item'          => __( 'Editar Habitación', 'roomly' ),
        'view_item'          => __( 'Ver Habitación', 'roomly' ),
        'all_items'          => __( 'Todas las Habitaciones', 'roomly' ),
        'search_items'       => __( 'Buscar Habitaciones', 'roomly' ),
        'not_found'          => __( 'No se encontraron habitaciones', 'roomly' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'habitaciones' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-admin-home', // Icono del menú
        'supports'           => array( 'title', 'editor', 'thumbnail' ),
    );

    register_post_type( 'roomly_habitaciones', $args );
}
add_action( 'init', 'roomly_register_custom_post_type' );

function roomly_add_meta_boxes() {
    add_meta_box(
        'roomly_habitacion_details',
        __( 'Detalles de la Habitación', 'roomly' ),
        'roomly_render_habitacion_metabox',
        'roomly_habitaciones',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'roomly_add_meta_boxes' );

function roomly_render_habitacion_metabox( $post ) {
    // Obtener los valores guardados
    $precio = get_post_meta( $post->ID, '_roomly_precio', true );
    $capacidad = get_post_meta( $post->ID, '_roomly_capacidad', true );
    $temporada_alta = get_post_meta( $post->ID, '_roomly_temporada_alta', true );

    // Metabox HTML
    ?>
    <p>
        <label for="roomly_precio"><?php _e( 'Precio por noche', 'roomly' ); ?></label>
        <input type="number" name="roomly_precio" id="roomly_precio" value="<?php echo esc_attr( $precio ); ?>" placeholder="100" />
    </p>
    <p>
        <label for="roomly_capacidad"><?php _e( 'Capacidad (número de personas)', 'roomly' ); ?></label>
        <input type="number" name="roomly_capacidad" id="roomly_capacidad" value="<?php echo esc_attr( $capacidad ); ?>" placeholder="2" />
    </p>
    <p>
        <label for="roomly_temporada_alta"><?php _e( 'Temporada Alta (Precio adicional)', 'roomly' ); ?></label>
        <input type="number" name="roomly_temporada_alta" id="roomly_temporada_alta" value="<?php echo esc_attr( $temporada_alta ); ?>" placeholder="50" />
    </p>
    <?php
}

// Guardar los datos del metabox
function roomly_save_habitacion_metabox( $post_id ) {
    if ( array_key_exists( 'roomly_precio', $_POST ) ) {
        update_post_meta( $post_id, '_roomly_precio', $_POST['roomly_precio'] );
    }
    if ( array_key_exists( 'roomly_capacidad', $_POST ) ) {
        update_post_meta( $post_id, '_roomly_capacidad', $_POST['roomly_capacidad'] );
    }
    if ( array_key_exists( 'roomly_temporada_alta', $_POST ) ) {
        update_post_meta( $post_id, '_roomly_temporada_alta', $_POST['roomly_temporada_alta'] );
    }
}
add_action( 'save_post', 'roomly_save_habitacion_metabox' );
