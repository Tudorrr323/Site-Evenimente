<?php 
session_start(); 
require_once 'includes/dbh.inc.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

$sql = "
    SELECT 
        c.id_cos, cb.cantitate, cb.pret AS pret_bilet,
        e.name AS event_name, e.date AS event_date, e.location AS event_location,
        b.denumire AS ticket_name
    FROM cos_bilet cb
    JOIN cos c ON cb.id_cos = c.id_cos
    JOIN bilet b ON cb.id_bilet = b.id_bilet
    JOIN event e ON b.id_event = e.id_event
";

$params = [$userId];
$category = trim($_GET['category'] ?? '');

if ($category !== '') {
    // Adăugăm join-urile necesare pentru categorie
    $sql .= "
        JOIN event_categories ec ON e.id_event = ec.id_event
        JOIN categories cat ON ec.id_cat = cat.id_cat
    ";
}

// Clauza WHERE de bază (filtrare după user și comenzi cumpărate)
$sql .= " WHERE c.id_user = ? AND c.isBought = 1 ";

if ($category !== '') {
    // Filtrare după denumirea categoriei
    $sql .= " AND cat.denumire = ? ";
    $params[] = $category;
}

$sql .= " ORDER BY c.id_cos DESC, e.date DESC ";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$orders = [];
foreach ($rows as $row) {
    $orders[$row['id_cos']][] = $row;
}

$redirectLink = "signup_manager.php";

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'manager') {
    $redirectLink = "create_events.php";
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Tickets - Ticketa</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" />
    <link rel="stylesheet" href="style.css" />
    <style>
        .order-box {
            margin-bottom: 40px;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 10px;
        }
        .order-box h2 {
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #eee;
        }

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
                <li><a class="active" href="my_tickets.php">My Tickets</a></li>
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
                <div class="category-calendar">
                        <input type="date" id="event-date-picker">
                </div>
            </div>
        </div>
    </section>

    <section id="main-content" style="padding: 20px; max-width: 100%; margin: auto; margin-top:180px;">
        <h1 style="text-align: center;">Biletele mele</h1>
        <?php if (empty($orders)): ?>
            <p>Nu ai cumpărat încă niciun bilet.</p>
        <?php else: ?>
            <?php foreach ($orders as $id_cos => $bilete): ?>
                <div class="order-box">
                    <h2>Comandă #<?= $id_cos ?></h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Eveniment</th>
                                <th>Data</th>
                                <th>Locație</th>
                                <th>Tip bilet</th>
                                <th>Cantitate</th>
                                <th>Preț / bilet</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $total_comanda = 0;
                                foreach ($bilete as $b): 
                                    $total = $b['pret_bilet'] * $b['cantitate'];
                                    $total_comanda += $total;
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($b['event_name']) ?></td>
                                    <td><?= htmlspecialchars($b['event_date']) ?></td>
                                    <td><?= htmlspecialchars($b['event_location']) ?></td>
                                    <td><?= htmlspecialchars($b['ticket_name']) ?></td>
                                    <td style="text-align: center;"><?= $b['cantitate'] ?></td>
                                    <td style="text-align: right;"><?= number_format($b['pret_bilet'], 2) ?> RON</td>
                                    <td style="text-align: right;"><?= number_format($total, 2) ?> RON</td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="6" style="text-align: right;"><strong>Total comandă:</strong></td>
                                <td style="text-align: right;"><strong><?= number_format($total_comanda, 2) ?> RON</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <form method="post" action="includes/generate_ticket_pdf.php" target="_blank">
                        <?php foreach ($bilete as $b): ?>
                            <input type="hidden" name="event_name[]" value="<?= htmlspecialchars($b['event_name']) ?>">
                            <input type="hidden" name="event_date[]" value="<?= htmlspecialchars($b['event_date']) ?>">
                            <input type="hidden" name="event_location[]" value="<?= htmlspecialchars($b['event_location']) ?>">
                            <input type="hidden" name="ticket_name[]" value="<?= htmlspecialchars($b['ticket_name']) ?>">
                            <input type="hidden" name="cantitate[]" value="<?= $b['cantitate'] ?>">
                            <input type="hidden" name="pret_bilet[]" value="<?= $b['pret_bilet'] ?>">
                        <?php endforeach; ?>
                        <button class="btn-group" style="width: 20%; display: block; margin: 0 auto; margin-top: 20px; background-color: #810808; color: white;
                        border: none; padding: 10px 18px; font-size: 15px; border-radius: 25px; cursor: pointer; transition: background-color 0.3s; white-space: nowrap; 
                        height: fit-content; align-self: start;" 
                        type="submit">Descarcă PDF</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

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