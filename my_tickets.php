<?php 
session_start(); 
require_once 'includes/dbh.inc.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Preluăm toate biletele cumpărate, ordonate după comenzi
$sql = "
    SELECT 
        c.id_cos, cb.cantitate, cb.pret AS pret_bilet,
        e.name AS event_name, e.date AS event_date, e.location AS event_location,
        b.denumire AS ticket_name
    FROM cos_bilet cb
    JOIN cos c ON cb.id_cos = c.id_cos
    JOIN bilet b ON cb.id_bilet = b.id_bilet
    JOIN event e ON b.id_event = e.id_event
    WHERE c.id_user = ? AND c.isBought = 1
    ORDER BY c.id_cos DESC, e.date DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$userId]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Grupăm biletele după id_cos
$orders = [];
foreach ($rows as $row) {
    $orders[$row['id_cos']][] = $row;
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

        #live-results {
            position: absolute;
            top: calc(100% + 4px); /* puțin spațiu sub bara */
            left: 0;
            width: 100%;
            background: white;
            border: 1px solid #ccc;
            display: none;
            z-index: 5;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .search-results-container {
            position: relative;
            width: max-content; /* sau o lățime fixă dacă vrei să o limitezi */
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
                <li><a class="active" href="my_tickets.php">My Tickets</a></li>
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
                <div class="search-results-container">
                    <div class="search-bar">
                    <input type="text" id="search-input" placeholder="Events..." />
                    <input type="text" id="city-input" placeholder="City..." />
                    <button type="button"><i class="fas fa-search"></i></button>
                    </div>
                    <div id="live-results"></div>
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
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('search-input');
            const cityInput = document.getElementById('city-input');
            const liveResults = document.getElementById('live-results');

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

            document.addEventListener('click', (e) => {
                if (!e.target.closest('.search-results-container')) {
                liveResults.style.display = 'none';
                }
            });
        });
    </script>
    </body>

</html>