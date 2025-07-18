document.addEventListener("DOMContentLoaded", function () {
  const datePicker = document.getElementById("event-date-picker");

  datePicker.addEventListener("change", function () {
    const selectedDate = this.value;
    if (selectedDate) {
      window.location.href = `events_by_date.php?date=${selectedDate}`;
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
  window.location.href = 'login.php';
});

const navLinks = document.querySelectorAll('#navbar-left a, #navbar-right a');

navLinks.forEach(link => {
  // Compară linkul cu locația paginii
  if (link.href === window.location.href) {
    link.classList.add('active');
  }
});