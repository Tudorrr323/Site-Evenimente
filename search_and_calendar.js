document.getElementById("event-date-picker").addEventListener("change", function () {
    const selectedDate = this.value;
    if (selectedDate) {
        window.location.href = "discover_events.php?date=" + encodeURIComponent(selectedDate);
    }
});

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

    document.addEventListener('DOMContentLoaded', () => {
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

            // ascunde rezultatele dacă dai click în afara searchbar-ului
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.search-results-container')) {
                    liveResults.style.display = 'none';
                }
            });
        });
    });