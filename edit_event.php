<?php
session_start();
require_once 'includes/dbh.inc.php';

// Verificare autentificare și rol
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'manager') {
    header('Location: login.php');
    exit();
}

// Obține evenimentul
if (!isset($_GET['id_event'])) {
    die("Evenimentul nu a fost specificat.");
}

$id_event = intval($_GET['id_event']);

// Obține compania userului pentru verificare drepturi
$stmt = $pdo->prepare("SELECT company FROM user WHERE id_user = ?");
$stmt->execute([$_SESSION['user_id']]);
$userData = $stmt->fetch();

if (!$userData) die("Utilizator inexistent.");

$company = $userData['company'];

// Obține datele evenimentului
$stmt = $pdo->prepare("SELECT * FROM event WHERE id_event = ? AND organiser = ?");
$stmt->execute([$id_event, $company]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    die("Nu ai permisiunea să editezi acest eveniment.");
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

        .edit-form-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background-color: #f9f9f9;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            font-family: 'Segoe UI', sans-serif;
            margin-top: 180px;
        }

        .edit-form-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .edit-form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #444;
        }

        .edit-form-container input[type="text"],
        .edit-form-container input[type="date"],
        .edit-form-container textarea,
        .edit-form-container select {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            transition: border 0.3s;
        }

        .edit-form-container input:focus,
        .edit-form-container textarea:focus,
        .edit-form-container select:focus {
            border-color: #810808;
            outline: none;
        }

        .edit-form-container textarea {
            resize: vertical;
            min-height: 100px;
        }

        .edit-form-container button {
            width: 100%;
            background-color: #810808;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .edit-form-container button:hover {
            background-color: #6842f3;
            transform: scale(1.03);
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

    <div class="edit-form-container">
        <h2>Editează Evenimentul</h2>
        <form action="includes/update_event.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_event" value="<?= $event['id_event'] ?>">

            <label>Nume:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($event['name']) ?>" required>

            <label>Locație:</label>
            <input type="text" name="location" value="<?= htmlspecialchars($event['location']) ?>" required>

            <label>Data:</label>
            <input type="date" name="date" value="<?= htmlspecialchars($event['date']) ?>" required>

            <label>Descriere:</label>
            <textarea name="description" required><?= htmlspecialchars($event['description']) ?></textarea>

            <label>Oraș:</label>
            <input type="text" name="city" value="<?= htmlspecialchars($event['city']) ?>" required>

            <label>Tip:</label>
            <select name="type">
                <option value="fizic" <?= $event['type'] === 'fizic' ? 'selected' : '' ?>>Fizic</option>
                <option value="virtual" <?= $event['type'] === 'virtual' ? 'selected' : '' ?>>Virtual</option>
            </select>

            <label>Imagine nouă (opțional):</label>
            <input type="file" name="image">

            <button type="submit">Salvează modificările</button>
        </form>
    </div>

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
    <script src="search_and_calendar.js"></script>
    
</body>

</html>