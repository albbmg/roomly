<form id="roomly-booking-form" class="roomly-booking-form" method="POST" action="">
    <h3>Book Your Stay</h3>

    <label for="checkin_date">Check-in Date:</label>
    <input type="date" id="checkin_date" name="checkin_date" required>

    <label for="checkout_date">Check-out Date:</label>
    <input type="date" id="checkout_date" name="checkout_date" required>

    <label for="room_type">Room Type:</label>
    <select id="room_type" name="room_type">
        <option value="standard">Standard</option>
        <option value="suite">Suite</option>
        <option value="deluxe">Deluxe</option>
    </select>

    <label for="guests">Number of Guests:</label>
    <input type="number" id="guests" name="guests" min="1" max="10" required>

    <label for="special_requests">Special Requests (Optional):</label>
    <textarea id="special_requests" name="special_requests" rows="4"></textarea>

    <input type="submit" value="Book Now">
</form>
