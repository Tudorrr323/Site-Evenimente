<?php
session_start();
require_once 'includes/dbh.inc.php';

// Verificăm dacă utilizatorul este logat
if (!isset($_SESSION["user_fname"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile User</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" />
    <link rel="stylesheet" href="style.css">

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f9f9f9;
        }

        .profile-container {
            max-width: 600px;
            margin-top: 180px;
            margin-bottom: 20px;
            text-align: center;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #810808;
        }

        .profile-info {
            margin-top: 30px;
        }

        .profile-info p {
            font-size: 16px;
            margin: 10px 0;
        }

        .btn-group {
            margin-top: 30px;
            text-align: center;
        }

        .btn-group a {
            display: inline-block;
            margin: 8px;
            padding: 10px 20px;
            background-color: #810808;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }

        .btn-group a:hover {
            background-color: #5a0606;
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
                <li class="mobile-search">
                    <div class="search-bar">
                        <input type="text" placeholder="Events..." />
                        <input type="text" placeholder="City..." />
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

    <center>
    <div class="profile-container">
        <h2>Profilul Meu</h2>

        <div class="profile-info">
            <p><strong>Id:</strong> <?= htmlspecialchars($_SESSION["user_id"] ?? "N/A") ?></p>
            <p><strong>Prenume:</strong> <?= htmlspecialchars($_SESSION["user_fname"] ?? "N/A") ?></p>
            <p><strong>Nume:</strong> <?= htmlspecialchars($_SESSION["user_lname"] ?? "N/A") ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION["user_email"] ?? "N/A") ?></p>
            <p><strong>Telefon:</strong> <?= htmlspecialchars($_SESSION["user_phone"] ?? "N/A") ?></p>
            <p><strong>Data nașterii:</strong> <?= htmlspecialchars($_SESSION["user_bday"] ?? "N/A") ?></p>
            <p><strong>Rol:</strong> <?= htmlspecialchars($_SESSION["user_role"] ?? "N/A") ?></p>
        </div>

        <div class="btn-group">
            <a href="includes/logout.php">Logout</a>
            <a href="reset_password.php">Schimbă parola</a>
            <a href="change_email.php">Schimbă email</a>
        </div>
    </div>
    </center>

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