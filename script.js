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

document.addEventListener('DOMContentLoaded', () => {
  const menuToggle = document.getElementById('menu-toggle');
  const navbarLeft = document.getElementById('navbar-left');

  // toggle burger menu
  menuToggle.addEventListener('click', (e) => {
    e.stopPropagation(); // nu lăsăm click-ul să se propage în body
    const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';

    if (isExpanded) {
      navbarLeft.classList.remove('show');
      menuToggle.setAttribute('aria-expanded', 'false');
    } else {
      navbarLeft.classList.add('show');
      menuToggle.setAttribute('aria-expanded', 'true');
    }
  });

  // închide meniul când dai click oriunde în afara lui
  document.addEventListener('click', (e) => {
    const isClickInsideMenu = navbarLeft.contains(e.target);
    const isClickOnToggle = menuToggle.contains(e.target);

    if (!isClickInsideMenu && !isClickOnToggle) {
      navbarLeft.classList.remove('show');
      menuToggle.setAttribute('aria-expanded', 'false');
    }
  });
});

document.getElementById('mobile-login-button').addEventListener('click', () => {
    // De exemplu redirecționează pe pagina login
    window.location.href = 'login.html';
});