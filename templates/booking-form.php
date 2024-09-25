<form id="roomly-booking-form" class="roomly-booking-form" method="POST" action="">
    <h3>Book Your Stay</h3>

    <!-- Check-in y check-out -->
    <label for="checkin_date">Check-in Date:</label>
    <input type="text" id="checkin_date" name="checkin_date" required>

    <label for="checkout_date">Check-out Date:</label>
    <input type="text" id="checkout_date" name="checkout_date" required>

    <!-- Tipos de habitaciones -->
    <label for="room_type">Room Type:</label>
    <select id="room_type" name="room_type">
        <option value="standard" data-price="100">Standard - $100/night</option>
        <option value="suite" data-price="150">Suite - $150/night</option>
        <option value="deluxe" data-price="200">Deluxe - $200/night</option>
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
