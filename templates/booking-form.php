<form id="roomly-booking-form" class="roomly-booking-form" method="POST" action="">
    <h3>Book Your Stay</h3>

    <!-- Check-in y check-out -->
    <label for="checkin_date">Check-in Date:</label>
    <input type="text" id="checkin_date" name="checkin_date" required>

    <label for="checkout_date">Check-out Date:</label>
    <input type="text" id="checkout_date" name="checkout_date" required>

    <!-- Tipos de habitaciones (dinámico desde el CPT) -->
    <label for="room_type">Room Type:</label>
    <select id="room_type" name="room_type">
        <?php
        // Hacer una consulta a las habitaciones del CPT
        $args = array(
            'post_type' => 'roomly_habitaciones',
            'posts_per_page' => -1
        );
        $habitaciones = new WP_Query( $args );

        if ( $habitaciones->have_posts() ) :
            while ( $habitaciones->have_posts() ) : $habitaciones->the_post();
                // Obtener los metadatos personalizados
                $precio = get_post_meta( get_the_ID(), '_roomly_precio', true );
                $capacidad = get_post_meta( get_the_ID(), '_roomly_capacidad', true );
                ?>
                <option value="<?php the_title(); ?>" data-price="<?php echo esc_attr( $precio ); ?>" data-capacidad="<?php echo esc_attr( $capacidad ); ?>">
                    <?php the_title(); ?> - $<?php echo esc_html( $precio ); ?>/night (Capacidad: <?php echo esc_html( $capacidad ); ?> personas)
                </option>
                <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<option>' . __( 'No hay habitaciones disponibles', 'roomly' ) . '</option>';
        endif;
        ?>
    </select>

    <!-- Número de huéspedes -->
    <label for="guests">Number of Guests:</label>
    <input type="number" id="guests" name="guests" min="1" max="10" required>

    <!-- Mostrar precio -->
    <label for="total_price">Total Price:</label>
    <input type="text" id="total_price" name="total_price" value="$0" readonly>

    <!-- Peticiones especiales -->
    <label for="special_requests">Special Requests (Optional):</label>
    <textarea id="special_requests" name="special_requests" rows="4"></textarea>

    <input type="submit" value="Book Now">
</form>
