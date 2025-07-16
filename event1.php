<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Eveniment</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" />
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <section id="header">
        <button id="menu-toggle" aria-label="Toggle menu" aria-expanded="false" aria-controls="navbar-left">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="header-left">
            <ul id="navbar-left">
                <li class="burger-logo">
                    <a href="index.php" class="logo-link"><img src="IMG/logo.png" alt="Logo"></a>
                <li class="mobile-search">
                    <div class="search-bar">
                        <input type="text" placeholder="Search events..." />
                        <input type="text" placeholder="Location..." />
                        <button><i class="fas fa-search"></i></button>
                    </div>
                </li>
                </li>
                <li><a href="index.php">Home</a></li>
                <li><a href="discover_events.php">Discover Events</a></li>
                <li><a href="my_tickets.php">My Tickets</a></li>
                <li><a href="virtual_events.php">Virtual Events</a></li>
                <li><a href="create_events.php">Create Events</a></li>
                <li><a href="about_us.php">About Us</a></li>
            </ul>
        </div>

        <div id="logo">
            <a href="index.php">
                <img src="IMG/logo.png" alt="Logo" width="150" height="150">
            </a>
        </div>

        <div class="header-right">
            <ul id="navbar-right">
                <li class="desktop-search">
                    <div class="search-bar">
                        <input type="text" placeholder="Search events..." />
                        <input type="text" placeholder="Location..." />
                        <button><i class="fas fa-search"></i></button>
                    </div>
                </li>
                <?php if (isset($_SESSION["user_fname"])): ?>
                    <li class="greeting" style="padding: 10px; color: #1a1a1a;">
                    <a href="profile.php" style="color: #1a1a1a; text-decoration: none;">    
                    Salut, 
                        <?= htmlspecialchars($_SESSION["user_fname"]) ?>!
                    </li>
                <?php else: ?>
                    <li class="desktop-login"><a href="login.php">Log in</a></li>
                    <li class="desktop-signup"><a href="signup.php">Sign Up</a></li>
                    <li class="mobile-login-btn">
                        <button id="mobile-login-button"><i class="fa-solid fa-user"></i></button>
                    </li>
                <?php endif; ?>
                <li><a href="cart.php"><i class="fas fa-shopping-bag"></i></a></li>
            </ul>
        </div>
    </section>

    <section id="subheader">
        <div class="category-wrapper">
            <div class="category-scroll">
                <a href="#">Stand Up</a>
                <a href="#">Comedy</a>
                <a href="#">Night Life</a>
                <a href="#">Music</a>
                <a href="#">Dating</a>
                <a href="#">Theater</a>
                <a href="#">Concerts</a>
                <a href="#">Rock</a>
                <a href="#">Pop</a>
                <a href="#">Movies</a>
                <a href="#">Workshops</a>
                <a href="#">Conferences</a>
                <a href="#">Motivational Talks</a>
                <a href="#">Food Festivals</a>
            </div>
            <div class="category-calendar">
                <i class="fas fa-calendar-alt"></i>
                <input type="date" id="event-date-picker">
            </div>
        </div>
    </section>

    <section class="main-content">
        <div class="event-card-horizontal">
            <div class="event-slider" style="position: relative; width: 800px; height: 1100px; overflow: hidden;">
                <img src="IMG/event1.png" class="event-image active-slide"
                    style="width: 100%; height: 100%; object-fit: cover; display: block;">
            </div>

            <div class="event-details">
                <h2 class="event-title">BEACH, PLEASE! Festival 2025</h2>
                <div class="event-location"><i class="fas fa-map-marker-alt"></i> Costinești, Plaja Obelisc</div>
                <div class="event-date"><i class="fas fa-clock"></i> Start: 9 Iulie 2025, ora 17:00</div>
                <div class="event-price"><i class="fas fa-ticket-alt"></i> Preț: 699 RON</div>
                <p class="event-description">
                    ATENTIE! Varsta minima pentru a participa la BEACH, PLEASE! 2025 este 14 ani. Minorii intre 14 si 15
                    ani trebuie sa fie obligatoriu insotiti de un parinte sau tutore legal. Parintele/tutorele legal
                    trebuie sa aiba, de asemenea, bilet valabil pentru a intra in festival.
                    <br /><br />
                    Toate biletele sunt NOMINALE si NETRANSMISIBILE. In momentul in care se achizitioneaza biletul,
                    trebuie completat numele complet al participantului. In cazul in care participantul nu mai poate
                    ajunge la eveniment, biletul este nul, nu se poate schimba numele de pe bilet ulterior.
                    <br /><br />
                    Biletele NU SE RETURNEAZA.
                    <br /><br />
                    Prin achizitia biletului, ati citit si sunteti de acord cu Regulamentul Oficial al Beach, Please
                    2025.
                </p>

                <div class="event-categories">
                    <span class="category-tag">Music</span>
                    <span class="category-tag">Festival</span>
                    <span class="category-tag">Beach</span>
                    <span class="category-tag">Party</span>
                </div>

                <div class="ticket-options" style="margin-top: 20px;">
                    <h4 style="margin-bottom: 10px;">Tipuri de bilete:</h4>
                    <ul>
                        <li>
                            <span class="ticket-label">AI PARTICIPAT LA BP 2024? AI CEL MAI BUN PRET! General Access — 5
                                Days Pass ⚡️ 120 EUR</span>
                            <div class="ticket-actions">
                                <input type="number" min="0" value="0" data-type="AI PARTICIPAT LA BP 2024? AI CEL MAI BUN PRET! General Access — 5 Days Pass ⚡️ 120
                                EUR" data-price="599" class="ticket-qty">
                                <span class="ticket-total-price">599 RON</span>
                            </div>
                        </li>
                        <li>
                            <span class="ticket-label">EARLYBIRD: General Access — 5 Days Pass ⚡️ 130 EUR</span>
                            <div class="ticket-actions">
                                <input type="number" min="0" value="0"
                                    data-type="EARLYBIRD: General Access — 5 Days Pass ⚡️ 130 EUR" data-price="649"
                                    class="ticket-qty">
                                <span class="ticket-total-price">649 RON</span>
                            </div>
                        </li>
                        <li>
                            <span class="ticket-label">EARLYBIRD: General Access Plus — 5 Days Pass ⚡️ 160 EUR</span>
                            <div class="ticket-actions">
                                <input type="number" min="0" value="0"
                                    data-type="EARLYBIRD: General Access Plus — 5 Days Pass ⚡️ 160 EUR" data-price="799"
                                    class="ticket-qty">
                                <span class="ticket-total-price">799 RON</span>
                            </div>
                        </li>
                        <li>
                            <span class="ticket-label">EARLYBIRD: GOLDEN CIRCLE — 5 Days Pass ⚡️ 175 EUR</span>
                            <div class="ticket-actions">
                                <input type="number" min="0" value="0"
                                    data-type="EARLYBIRD: GOLDEN CIRCLE — 5 Days Pass ⚡️ 175 EUR" data-price="874"
                                    class="ticket-qty">
                                <span class="ticket-total-price">874 RON</span>
                            </div>
                        </li>
                        <li>
                            <span class="ticket-label">EARLYBIRD: VIP — 5 Days Pass ⚡️ 300 EUR</span>
                            <div class="ticket-actions">
                                <input type="number" min="0" value="0"
                                    data-type="EARLYBIRD: VIP — 5 Days Pass ⚡️ 300 EUR" data-price="1499"
                                    class="ticket-qty">
                                <span class="ticket-total-price">1499 RON</span>
                            </div>
                        </li>
                        <li>
                            <span class="ticket-label">UPGRADE: General Access → Golden Circle ⚡ 45 EUR</span>
                            <div class="ticket-actions">
                                <input type="number" min="0" value="0"
                                    data-type="UPGRADE: General Access → Golden Circle ⚡ 45 EUR" data-price="225"
                                    class="ticket-qty">
                                <span class="ticket-total-price">225 RON</span>
                            </div>
                        </li>
                        <li>
                            <span class="ticket-label">UPGRADE: General Access —> ULTRA VIP + Golden Circle (5 Days
                                Pass) ⚡️ 270 EUR</span>
                            <div class="ticket-actions">
                                <input type="number" min="0" value="0"
                                    data-type="UPGRADE: General Access —> ULTRA VIP + Golden Circle (5 Days Pass) ⚡️ 270 EUR"
                                    data-price="1350" class="ticket-qty">
                                <span class="ticket-total-price">1350 RON</span>
                            </div>
                        </li>
                        <li>
                            <span class="ticket-label">EARLYBIRD: ULTRA VIP + GOLDEN CIRCLE — 5 Days Pass ⚡️ 400
                                EUR</span>
                            <div class="ticket-actions">
                                <input type="number" min="0" value="0"
                                    data-type="EARLYBIRD: ULTRA VIP + GOLDEN CIRCLE — 5 Days Pass ⚡️ 400 EUR"
                                    data-price="1999" class="ticket-qty">
                                <span class="ticket-total-price" style="float: right;">1999 RON</span>
                            </div>
                        </li>
                    </ul>
                    <button class="buy-ticket-btn" id="finalize-purchase" style="width: 30%; float: right;">Cumpără
                        bilet</button>
                </div>
            </div>
        </div>
    </section>

    <section id="rectangle_bar">
        <h1 style="margin-top: 40px; color: aliceblue;">Ești organizator?</h1>
        <button type="button" class="transparent-button" style="display: block; margin-top: 20px; width: 30%;">ÎNCEPE
            ACUM!</button>
    </section>
    <section class="newsletter">
        <h3>Abonează-te la newsletter!</h3>
        <p>Primește cele mai noi evenimente direct pe email.</p>
        <form class="newsletter-form" action="#" method="POST">
            <div class="newsletter-input-wrapper">
                <input type="email" name="email" placeholder="Introdu adresa ta de email" required>
                <button type="submit">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </form>
    </section>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-column">
                <center>
                    <img src="IMG/logo2.png" width="90" height="20" style="margin-bottom: 20px;">
                    <h3 style="text-align: center;">Despre noi</h3>
                    <p>Suntem o platformă dedicată organizării și descoperirii de evenimente de toate tipurile.</p>
                </center>
            </div>

            <div class="footer-column">
                <center>
                    <h3>Linkuri utile</h3>
                    <ul class="footer-policy">
                        <li><a href="#">Termeni & Condiții</a></li>
                        <li><a href="#">Politica de Confidențialitate</a></li>
                        <li><a href="#">Cookies</a></li>
                        <li><a href="#">Întrebări Frecvente</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </center>
            </div>

            <div class="footer-column">
                <h3>Urmărește-ne</h3>
                <ul class="social-icons">
                    <li><a href="https://www.youtube.com/" target="_blank">
                            <i class="fa-brands fa-youtube"></i></a></li>
                    <li><a href="https://www.tiktok.com/" target="_blank">
                            <i class="fa-brands fa-tiktok"></i></a></li>
                    <li><a href="https://www.instagram.com/" target="_blank">
                            <i class="fa-brands fa-instagram"></i></a></li>
                    <li><a href="https://www.facebook.com/" target="_blank">
                            <i class="fa-brands fa-facebook"></i></a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 Ticketa. Toate drepturile rezervate.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>