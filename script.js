document.addEventListener("DOMContentLoaded", function () {
    const datePicker = document.getElementById("event-date-picker");

    datePicker.addEventListener("change", function () {
        const selectedDate = this.value; // Format: YYYY-MM-DD
        if (selectedDate) {
            // Redirecționează către o pagină cu data selectată ca parametru
            window.location.href = `events_by_date.html?date=${selectedDate}`;
        }
    });
});