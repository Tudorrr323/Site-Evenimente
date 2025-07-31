<?php
session_start();
require_once 'includes/dbh.inc.php';

$redirectLink = "signup_manager.php";

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'manager') {
    $redirectLink = "create_events.php";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Eveniment</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        .search-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: white;
            padding: 8px 12px;
            border-radius: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .search-bar input[type="text"] {
            border: none;
            outline: none;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 14px;
            background-color: #f1f1f1;
        }

        .search-bar button {
            background-color: #000000;
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .search-bar button:hover {
            background-color: #a00a0a;
        }

        .search-results-container {
            position: relative;
        }

        .live-results {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: white;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-height: 300px;
            overflow-y: auto;
            display: none;
        }

        .search-result-item {
            padding: 10px;
            border-bottom: 1px solid #f0f0f0;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .search-result-item:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }

        li::marker {
        content: none !important;
        }
    </style>
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
                </li>
                <li class="mobile-search">
                    <div class="search-results-container">
                        <div class="search-bar">
                            <input type="text" class="search-input" id="search-input" placeholder="Events..." />
                            <input type="text" class="city-input" id="city-input" placeholder="City..." />
                            <button type="button"><i class="fas fa-search"></i></button>
                        </div>
                    <div class="live-results" id="live-results-mobile"></div>
                </li>
                <li><a href="index.php">Home</a></li>
                <li><a href="discover_events.php">Discover Events</a></li>
                <li><a href="my_tickets.php">My Tickets</a></li>
                <li><a href="virtual_events.php">Virtual Events</a></li>
                <?php
                    $createHref = "signup_manager.php";

                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'manager') {
                        $createHref = "create_events.php";
                    }
                ?>
                <li><a href="<?= $createHref ?>">Create Events</a></li>
                <li><a class="active" href="about_us.php">About Us</a></li>
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
                    <div class="search-results-container">
                        <div class="search-bar">
                            <input type="text" class="search-input" placeholder="Events..." />
                            <input type="text" class="city-input" placeholder="City..." />
                            <button class="search-button" type="button"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="live-results" id="live-results-desktop"></div>
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
                <div class="category-scroll">
                <?php
                    try {
                        $stmt = $pdo->query("SELECT * FROM categories ORDER BY id_cat ASC");
                        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        echo "Eroare la preluarea categoriilor: " . $e->getMessage();
                    }

                    if ($categories) {
                        foreach ($categories as $categoryItem) {
                            $denumire = htmlspecialchars($categoryItem['denumire']);
                            $urlCategory = urlencode($denumire);
                            echo '<a href="discover_events.php?category=' . $urlCategory . '" class="category-link">' . $denumire . '</a>';
                        }
                    } else {
                        echo '<p>Nu există categorii disponibile.</p>';
                    }
                ?>
                </div>
                <div id="calendar-container" style="position: relative; display: inline-block;">
                    <input type="text" id="event-date-picker" style="width: 250px; padding: 8px; border-radius: 4px; display: none;">
                    <i id="calendar-icon" class="fa fa-calendar" style="cursor: pointer; font-size: 20px; margin-left: 8px;"></i>
                </div>
            </div>
        </div>
    </section>

    <section class="about-us">
        <h3>About Us</h3>
        <center>
            <div style="max-width: 1000px; width: 100%; margin: 0 auto; padding: 20px 40px;">
                <p style="text-align: justify; line-height: 1.8;">
                    Ticketa este mai mult decât o simplă platformă de vânzare de bilete – este locul unde evenimentele prind
                    viață, iar comunitățile se conectează prin experiențe memorabile.
                    <br /><br />
                    Lansată din pasiune pentru divertisment, inovație și accesibilitate, Ticketa își propune să devină
                    principala destinație online pentru toți cei care doresc să participe, să creeze sau să descopere
                    evenimente – fie că sunt concerte live, spectacole de teatru, conferințe, festivaluri, evenimente
                    virtuale sau petreceri private.
                    <br /><br />
                    <b style="font-size: 20px">Misiunea noastră</b>
                    <br />
                    Misiunea Ticketa este de a face evenimentele mai accesibile, mai organizate și mai ușor de gestionat,
                    atât pentru participanți, cât și pentru organizatori. Credem că fiecare eveniment merită să fie
                    descoperit, iar fiecare persoană ar trebui să aibă posibilitatea de a se bucura de el.
                    <br /><br />
                    <b style="font-size: 20px">Ce ne face diferiți</b>
                    <br />
                    -Interfață intuitivă pentru utilizatori, cu opțiuni rapide de căutare și filtrare.
                    <br />
                    -Instrumente avansate pentru organizatori: creare de evenimente, gestionarea vânzărilor și comunicarea cu
                    participanții.
                    <br />
                    -Suport pentru evenimente fizice și virtuale, adaptat noilor realități.
                    <br />
                    -Plăți securizate, confirmări imediate și acces rapid la bilete.
                    <br />
                    -Experiență personalizată prin recomandări bazate pe preferințele tale.
                    <br /><br />
                    <b style="font-size: 20px">Comunitatea Ticketa</b>
                    <br />
                    Suntem o echipă dinamică de developeri, designeri, specialiști în marketing și pasionați de evenimente.
                    Lucrăm constant pentru a îmbunătăți platforma, a aduce evenimente mai diverse și a oferi sprijin real
                    tuturor organizatorilor – de la branduri mari la inițiative locale.
                    <br /><br />
                    <b style="font-size: 20px">Alătură-te nouă</b>
                    <br />
                    Fie că ești un participant în căutarea următoarei aventuri sau un organizator gata să lanseze un nou
                    eveniment, Ticketa este aici să te ajute. Împreună, facem ca fiecare moment să conteze.
                </p>
                <img src="IMG/office_about_us.jpg" style="width: 100%; height: auto; display: block; margin-top: 20px;" alt="Despre noi" />
            </div>
        </center>

        <section id="rectangle_bar">
            <h1 style="margin-top: 40px; color: aliceblue;">Ești organizator?</h1>
            <a href="<?= $redirectLink ?>" class="transparent-button"
            style="display: block; margin-top: 20px; width: 30%;">ÎNCEPE ACUM!</a>
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

    </section>

    <footer class="footer" style="bottom: 0; width: 100%;">
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
    <script src="search_and_calendar.js"></script>

</body>

</html>