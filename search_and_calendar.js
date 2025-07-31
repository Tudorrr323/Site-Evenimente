document.querySelectorAll(".search-bar button").forEach(btn => {
        btn.addEventListener("click", function () {
            // Căutăm în cadrul containerului actual
            const container = this.closest('.search-bar');
            const q = container.querySelector(".search-input")?.value.trim() || '';
            const city = container.querySelector(".city-input")?.value.trim() || '';

            console.log("Searching for:", q, city); // pt debugging

            const url = `discover_events.php?q=${encodeURIComponent(q)}&city=${encodeURIComponent(city)}`;
            window.location.href = url;
        });
    });

document.addEventListener("DOMContentLoaded", function () {
    const dateInput = document.getElementById("event-date-picker");
    const calendarIcon = document.getElementById("calendar-icon");

    if (!dateInput || !calendarIcon) {
        console.warn("Nu am găsit inputul sau iconița pentru calendar.");
        return;
    }

    // Initializează Flatpickr pe input
    const picker = flatpickr(dateInput, {
        mode: "range",
        dateFormat: "Y-m-d",
        onClose: function (selectedDates) {
            if (selectedDates.length === 2) {
                const start = selectedDates[0].toISOString().split('T')[0];
                const end = selectedDates[1].toISOString().split('T')[0];
                window.location.href = `discover_events.php?start_date=${encodeURIComponent(start)}&end_date=${encodeURIComponent(end)}`;
            }
        }
    });

    // La click pe iconiță deschide calendarul și arată inputul (invizibil anterior)
    calendarIcon.addEventListener("click", () => {
        dateInput.style.display = "inline-block";
        dateInput.focus();
        picker.open();
    });

    // Căutare simplă la click pe buton
    document.querySelectorAll(".search-bar button").forEach(btn => {
        btn.addEventListener("click", function () {
            const container = this.closest('.search-bar');
            const q = container.querySelector(".search-input")?.value.trim() || '';
            const city = container.querySelector(".city-input")?.value.trim() || '';

            const url = `discover_events.php?q=${encodeURIComponent(q)}&city=${encodeURIComponent(city)}`;
            window.location.href = url;
        });
    });

    // Căutare live
    document.querySelectorAll('.search-results-container').forEach(container => {
        const searchInput = container.querySelector('.search-input');
        const cityInput = container.querySelector('.city-input');
        const liveResults = container.querySelector('.live-results');

        function searchLive() {
            const q = searchInput.value.trim();
            const city = cityInput.value.trim();

            if (q.length < 1 && city.length < 1) {
                liveResults.innerHTML = '';
                liveResults.style.display = 'none';
                return;
            }

            fetch(`includes/search_backend.php?q=${encodeURIComponent(q)}&city=${encodeURIComponent(city)}&limit=3`)
                .then(res => res.text())
                .then(data => {
                    liveResults.innerHTML = data;
                    liveResults.style.display = data.trim() ? 'block' : 'none';
                });
        }

        searchInput.addEventListener('input', searchLive);
        cityInput.addEventListener('input', searchLive);

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.search-results-container')) {
                liveResults.style.display = 'none';
            }
        });
    });
});

