<?php session_start(); 
require_once 'includes/dbh.inc.php';
?>
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
                        <input type="text" placeholder="Events..." />
                        <input type="text" placeholder="City..." />
                        <button><i class="fas fa-search"></i></button>
                    </div>
                </li>
                </li>
                <li><a class="active" href="index.php">Home</a></li>
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
                        <input type="text" placeholder="Events..." />
                        <input type="text" placeholder="City..." />
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
                <div class="category-scroll">
                <?php
                    try {
                        $stmt = $pdo->query("SELECT * FROM categories ORDER BY id_cat ASC");
                        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        echo "Eroare la preluarea categoriilor: " . $e->getMessage();
                    }

                    if ($categories) {
                        foreach ($categories as $category) {
                            $denumire = htmlspecialchars($category['denumire']);

                            echo '<a href="#" class="category-link">' . $denumire . '</a>';
                        }
                    } else {
                        echo '<p>Nu există categorii disponibile.</p>';
                    }
                    ?>
                </div>
                <div class="category-calendar">
                        <input type="date" id="event-date-picker">
                </div>
            </div>
        </div>
    </section>
    <section id="hero">
        <section class="main-content">
            <?php
            try {
                $stmt = $pdo->query("SELECT * FROM event ORDER BY date ASC");
                $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Eroare la preluarea evenimentelor: " . $e->getMessage();
            }

            echo '
            <h2 style="text-align: center; position: relative; margin-top: 20px; margin-bottom: 40px;">Evenimente Populare</h2>
            <section class="event-section">
            <div class="event-grid">
            ';

            if ($events) {
                foreach ($events as $event) {
                    // pregătește datele
                    $id = htmlspecialchars($event['id_event']);
                    $name = htmlspecialchars($event['name']);
                    $location = htmlspecialchars($event['location']);
                    $city = htmlspecialchars($event['city']);
                    $date = date("j F Y", strtotime($event['date']));
                    $organiser = htmlspecialchars($event['organiser']);
                    $imgpath = htmlspecialchars($event['imgpath']);
                    $description = ($event['description']);

                    $isVirtual = ($event['type'] === 'virtual');

                    echo '
                    <a href="event.php?id_event=' . $id . '" class="event-card-link">
                        <div class="event-card">
                            <img src="IMG/' . $imgpath . '" alt="Eveniment" class="event-image">
                            <h3 class="event-title">' . $name . '</h3>
                            <p class="event-organiser" style="margin: 4px 0; font-size:18px;"><i class="fas fa-clipboard-list"></i> ' . $organiser .'</p>';
                            if (!$isVirtual) {
                                echo '<p class="event-location" style="margin: 4px 0; font-size:18px;"><i class="fas fa-map-marker-alt"></i> ' . $city . '</p>';
                            }
                        echo '
                            <p class="event-date" style="margin: 4px 0; font-size:18px;"><i class="fas fa-calendar-alt"></i> ' . $date . '</p>
                        </div>
                    </a>
                    ';
                }
            } else {
                echo '<p>Nu există evenimente disponibile.</p>';
            }
            ?>
        </section>
    </section>

    <section id="rectangle_bar">
        <h1 style="margin-top: 40px; color: aliceblue;">Ești organizator?</h1>
        <button type="button" class="transparent-button"
            style="display: block; margin-top: 20px; width: 30%;">ÎNCEPE ACUM!</button>
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