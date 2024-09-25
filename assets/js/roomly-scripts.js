// Inicializar el selector de fechas Flatpickr y manejar lógica de reservas
document.addEventListener('DOMContentLoaded', function () {
    // Variables globales
    let roomTypeSelect = document.getElementById('room_type');
    let checkinDateInput = document.getElementById('checkin_date');
    let checkoutDateInput = document.getElementById('checkout_date');
    let totalPriceInput = document.getElementById('total_price');
    let guestsInput = document.getElementById('guests');

    // Inicializar Flatpickr para check-in
    flatpickr(checkinDateInput, {
        dateFormat: "Y-m-d",
        minDate: "today",
        onChange: function(selectedDates, dateStr) {
            // Actualizar la fecha mínima de check-out cuando se selecciona check-in
            checkoutDateInput._flatpickr.set('minDate', dateStr);
            calculateTotalPrice();
        }
    });

    // Inicializar Flatpickr para check-out
    flatpickr(checkoutDateInput, {
        dateFormat: "Y-m-d",
        minDate: "today",
        onChange: function() {
            calculateTotalPrice();
        }
    });

    // Calcular el precio total al cambiar el tipo de habitación
    roomTypeSelect.addEventListener('change', function() {
        calculateTotalPrice();
        updateGuestCapacity(); // Actualizar la capacidad de huéspedes según la habitación seleccionada
    });

    // Función para calcular el precio total
    function calculateTotalPrice() {
        let checkinDate = new Date(checkinDateInput.value);
        let checkoutDate = new Date(checkoutDateInput.value);
        let nights = (checkoutDate - checkinDate) / (1000 * 60 * 60 * 24); // Diferencia en días
        let pricePerNight = parseInt(roomTypeSelect.options[roomTypeSelect.selectedIndex].getAttribute('data-price'));

        if (!isNaN(nights) && nights > 0 && !isNaN(pricePerNight)) {
            let totalPrice = nights * pricePerNight;
            totalPriceInput.value = '$' + totalPrice.toFixed(2);
        } else {
            totalPriceInput.value = '$0';
        }
    }

    // Función para actualizar el número máximo de huéspedes según la habitación seleccionada
    function updateGuestCapacity() {
        let maxCapacity = roomTypeSelect.options[roomTypeSelect.selectedIndex].getAttribute('data-capacidad');
        guestsInput.setAttribute('max', maxCapacity);
    }

    // Inicializa la capacidad de la habitación al cargar
    updateGuestCapacity();
});
