// Inicializar el selector de fechas Flatpickr
document.addEventListener('DOMContentLoaded', function () {
    // Selector de fecha de Check-in
    flatpickr("#checkin_date", {
        dateFormat: "Y-m-d",
        minDate: "today", // No permitir seleccionar fechas anteriores a hoy
        onChange: function(selectedDates, dateStr, instance) {
            // Configurar el selector de checkout con una fecha mínima
            let checkoutPicker = document.getElementById('checkout_date');
            checkoutPicker._flatpickr.set('minDate', dateStr);
        }
    });

    // Selector de fecha de Check-out
    flatpickr("#checkout_date", {
        dateFormat: "Y-m-d",
        minDate: "today"
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // Variables globales para calcular el precio
    let roomTypeSelect = document.getElementById('room_type');
    let checkinDateInput = document.getElementById('checkin_date');
    let checkoutDateInput = document.getElementById('checkout_date');
    let totalPriceInput = document.getElementById('total_price');

    // Inicializar Flatpickr (asegúrate de haberlo incluido antes)
    flatpickr(checkinDateInput, {
        dateFormat: "Y-m-d",
        minDate: "today",
        onChange: function(selectedDates, dateStr) {
            // Actualizar la fecha mínima de checkout cuando se elige check-in
            checkoutDateInput._flatpickr.set('minDate', dateStr);
            calculateTotalPrice();
        }
    });

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
    });

    // Función para calcular el precio total
    function calculateTotalPrice() {
        let checkinDate = new Date(checkinDateInput.value);
        let checkoutDate = new Date(checkoutDateInput.value);
        let nights = (checkoutDate - checkinDate) / (1000 * 60 * 60 * 24); // Diferencia en días
        let pricePerNight = parseInt(roomTypeSelect.options[roomTypeSelect.selectedIndex].getAttribute('data-price'));

        if (!isNaN(nights) && nights > 0) {
            let totalPrice = nights * pricePerNight;
            totalPriceInput.value = '$' + totalPrice.toFixed(2);
        } else {
            totalPriceInput.value = '$0';
        }
    }
});
