<?php
session_start();
require_once 'includes/dbh.inc.php';

// Verificare autentificare și rol manager
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'manager') {
    header('Location: login.php');
    exit();
}

// Obține compania utilizatorului logat
$stmt = $pdo->prepare("SELECT company FROM user WHERE id_user = ?");
$stmt->execute([$_SESSION['user_id']]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$userData) {
    die("Utilizator inexistent.");
}
$company = $userData['company'];

// Preluare evenimente organizate de compania userului
$stmt = $pdo->prepare("SELECT id_event, name FROM event WHERE organiser = ? ORDER BY date DESC");
$stmt->execute([$company]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validează datele primite
    $id_event = $_POST['id_event'] ?? '';
    $ticket_title = trim($_POST['ticket_title'] ?? '');
    $ticket_desc = trim($_POST['ticket_desc'] ?? '');
    $ticket_price = $_POST['ticket_price'] ?? '';
    $loc_eveniment = trim($_POST['loc_eveniment'] ?? '');

    if (!$id_event || !$ticket_title || !$ticket_desc || !$ticket_price || !$loc_eveniment) {
        $errors[] = "Toate câmpurile sunt obligatorii.";
    } elseif (!is_numeric($ticket_price) || $ticket_price < 0) {
        $errors[] = "Prețul trebuie să fie un număr pozitiv.";
    }

    // Verifică dacă id_event există în evenimentele utilizatorului
    $valid_event = false;
    foreach ($events as $ev) {
        if ($ev['id_event'] == $id_event) {
            $valid_event = true;
            break;
        }
    }
    if (!$valid_event) {
        $errors[] = "Eveniment invalid.";
    }

    if (empty($errors)) {
        // Introducere bilet în baza de date
        $insert = $pdo->prepare("INSERT INTO bilet (denumire, pret, loc_eveniment, description, id_event) VALUES (?, ?, ?, ?, ?)");
        $success_insert = $insert->execute([$ticket_title, $ticket_price, $loc_eveniment, $ticket_desc, $id_event]);

        if ($success_insert) {
            $success = "Biletul a fost adăugat cu succes!";
        } else {
            $errors[] = "Eroare la adăugarea biletului în baza de date.";
        }
    }
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

        form {
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
        }
        input[type=text], input[type=number], textarea, select {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        button {
            margin-top: 20px;
            background-color: #810808;
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #a00a0a;
        }
        .message {
            max-width: 500px;
            margin: 20px auto;
            padding: 10px;
            border-radius: 6px;
            font-weight: 600;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
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

    <section style="margin-top: 180px;">
        <h2 style="text-align:center; margin-top:30px;">Adaugă Bilet la Eveniment</h2>

        <?php if (!empty($errors)): ?>
            <div class="message error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="message success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form action="add_tickets.php" method="POST">
            <label for="id_event">Selectează Evenimentul:</label>
            <select name="id_event" id="id_event" required>
                <option value="">-- Alege eveniment --</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?= $event['id_event'] ?>" <?= (isset($id_event) && $id_event == $event['id_event']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($event['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="ticket_title">Titlu Bilet:</label>
            <input type="text" name="ticket_title" id="ticket_title" required value="<?= htmlspecialchars($_POST['ticket_title'] ?? '') ?>" />

            <label for="ticket_desc">Descriere Bilet:</label>
            <textarea name="ticket_desc" id="ticket_desc" required><?= htmlspecialchars($_POST['ticket_desc'] ?? '') ?></textarea>

            <label for="ticket_price">Preț Bilet (lei):</label>
            <input type="number" name="ticket_price" id="ticket_price" min="0" step="0.01" required value="<?= htmlspecialchars($_POST['ticket_price'] ?? '') ?>" />

            <label for="loc_eveniment">Locul Evenimentului:</label>
            <input type="text" name="loc_eveniment" id="loc_eveniment" required value="<?= htmlspecialchars($_POST['loc_eveniment'] ?? '') ?>" />

            <button type="submit">Adaugă Bilet</button>
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
    <script src="search_and_calendar.js"></script>
    
</body>

</html>