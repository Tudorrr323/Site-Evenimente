<?php 
session_start(); 
require_once 'includes/dbh.inc.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$category = trim($_GET['category'] ?? '');

$sql = "
    SELECT 
        cb.order_id,
        cb.id_cos_bilet, cb.cantitate, cb.pret AS pret_bilet, cb.cod_bilet,
        e.name AS event_name, e.date AS event_date, e.location AS event_location,
        b.denumire AS ticket_name
    FROM cos_bilet cb
    JOIN bilet b ON cb.id_bilet = b.id_bilet
    JOIN event e ON b.id_event = e.id_event
";

if ($category !== '') {
    $sql .= "
        JOIN event_categories ec ON e.id_event = ec.id_event
        JOIN categories cat ON ec.id_cat = cat.id_cat
    ";
}

$sql .= " WHERE cb.id_user = ? AND cb.isBought = 1";

if ($category !== '') {
    $sql .= " AND cat.denumire = ?";
    $params = [$userId, $category];
} else {
    $params = [$userId];
}

$sql .= " ORDER BY cb.order_id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$bilete = $stmt->fetchAll(PDO::FETCH_ASSOC);

$redirectLink = "signup_manager.php";

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'manager') {
    $redirectLink = "create_events.php";
}

$groupedTickets = [];

foreach ($bilete as $bilet) {
    // Cheia de grupare - poți ajusta după ce vrei să compari exact
    $key = $bilet['order_id'] . '|' . $bilet['event_name'] . '|' . $bilet['event_date'] . '|' . $bilet['event_location'] . '|' . $bilet['ticket_name'] . '|' . $bilet['pret_bilet'];

    if (!isset($groupedTickets[$key])) {
        $groupedTickets[$key] = [
            'order_id' => $bilet['order_id'],
            'event_name' => $bilet['event_name'],
            'event_date' => $bilet['event_date'],
            'event_location' => $bilet['event_location'],
            'ticket_name' => $bilet['ticket_name'],
            'pret_bilet' => $bilet['pret_bilet'],
            'cantitate' => 0,
            'coduri_bilete' => [], // aici adunăm codurile
        ];
    }

    $groupedTickets[$key]['cantitate'] += (int)$bilet['cantitate'];

    // cod_bilet poate fi un string sau cod unic, depinde ce ai în baza de date
    $groupedTickets[$key]['coduri_bilete'][] = $bilet['cod_bilet'];
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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

        .pdf-button {
            display: inline-block;
            background-color: #810808;
            color: white;
            padding: 10px 20px;
            margin-top: 10px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
            border: none;
            padding: 6px 14px;
            font-size: 0.9rem;
            margin: 10px auto;
            width: 200px;
        }

        .pdf-button:hover {
            background-color: #a00a0a;
        }

        .pdf-button-container {
            text-align: center;
        }

        .pagination {
            text-align: center;
            margin-top: 40px;
            font-family: Arial, sans-serif;
            user-select: none;
        }

        .pagination a,
        .pagination strong {
            display: inline-block;
            margin: 0 6px;
            padding: 8px 14px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .pagination a {
            background-color: #810808;
            color: white;
            box-shadow: 0 3px 8px rgba(168, 9, 9, 0.6);
            cursor: pointer;
        }

        .pagination a:hover {
            background-color: #a00a0a;
            box-shadow: 0 4px 12px rgba(195, 12, 12, 0.8);
        }

        .pagination strong {
            background-color: #c30c0c;
            color: white;
            box-shadow: 0 4px 12px rgba(195, 12, 12, 0.9);
            cursor: default;
        }

        .pagination a:active {
            background-color: #6c0606;
            box-shadow: none;
            transform: translateY(2px);
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
                <div id="calendar-container" style="position: relative; display: inline-block;">
                    <input type="text" id="event-date-picker" style="width: 250px; padding: 8px; border-radius: 4px; display: none;">
                    <i id="calendar-icon" class="fa fa-calendar" style="cursor: pointer; font-size: 20px; margin-left: 8px;"></i>
                </div>
            </div>
        </div>
    </section>

    <section id="main-content" style="padding: 20px; max-width: 100%; margin: auto; margin-top:180px;">
        <h1 style="text-align: center; margin-bottom: 20px;">Biletele mele</h1>
        <?php if (empty($bilete)): ?>
            <p style="text-align:center; font-size:1.2rem; margin-top: 40px;">Nu ai cumpărat încă niciun bilet.</p>
        <?php else: ?>
            <?php
                $currentOrder = null;
                $orderTickets = [];
                foreach ($groupedTickets as $ticket) {
                    $orderTickets[$ticket['order_id']][] = $ticket;
                }

                krsort($orderTickets); // ordonăm comenzile descrescător

                $lineCount = 0; // număr linii afișate (nu bilete)
                
                // PAGINARE
                $linesPerPage = 15;
                $totalLines = count($groupedTickets); // fiecare grup = 1 linie
                $totalPages = ceil($totalLines / $linesPerPage);

                // Pagina curentă
                $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                $currentPage = max(1, min($currentPage, $totalPages)); // între 1 și $totalPages

                // Offset și selecție
                $start = ($currentPage - 1) * $linesPerPage;
                $pagedGroupedTickets = array_slice($groupedTickets, $start, $linesPerPage, true);

                // Regenerăm orderTickets doar cu liniile afișate în această pagină
                $orderTickets = [];
                foreach ($pagedGroupedTickets as $ticket) {
                    $orderTickets[$ticket['order_id']][] = $ticket;
                }

                krsort($orderTickets); // ordonăm comenzile descrescător

                foreach ($orderTickets as $orderId => $tickets):
                    $ticketsToShow = [];

                    foreach ($tickets as $ticket) {
                        if ($lineCount >= 15) break 2; // oprim complet dacă s-au afișat 30 de linii
                        $ticketsToShow[] = $ticket;
                        $lineCount++;
                    }

                    if (empty($ticketsToShow)) continue;
                    ?>

                    <div class="order-box">
                        <h2>Comanda #<?= htmlspecialchars($orderId) ?></h2>
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
                                <?php foreach ($ticketsToShow as $ticket): 
                                    $total = $ticket['pret_bilet'] * $ticket['cantitate'];
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($ticket['event_name']) ?></td>
                                        <td><?= htmlspecialchars($ticket['event_date']) ?></td>
                                        <td><?= htmlspecialchars($ticket['event_location']) ?></td>
                                        <td><?= htmlspecialchars($ticket['ticket_name']) ?></td>
                                        <td style="text-align: center;"><?= $ticket['cantitate'] ?></td>
                                        <td style="text-align: right;"><?= number_format((float)$ticket['pret_bilet'], 2) ?> RON</td>
                                        <td style="text-align: right;"><?= number_format($total, 2) ?> RON</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <!-- PDF form -->
                        <form action="includes/generate_ticket_pdf.php" method="post" style="margin-top: 15px;">
                            <?php foreach ($ticketsToShow as $ticket): ?>
                                <input type="hidden" name="event_name[]" value="<?= htmlspecialchars($ticket['event_name']) ?>">
                                <input type="hidden" name="event_date[]" value="<?= htmlspecialchars($ticket['event_date']) ?>">
                                <input type="hidden" name="event_location[]" value="<?= htmlspecialchars($ticket['event_location']) ?>">
                                <input type="hidden" name="ticket_name[]" value="<?= htmlspecialchars($ticket['ticket_name']) ?>">
                                <input type="hidden" name="cantitate[]" value="<?= (int)$ticket['cantitate'] ?>">
                                <input type="hidden" name="pret_bilet[]" value="<?= (float)$ticket['pret_bilet'] ?>">
                                <input type="hidden" name="cod_bilet[]" value="<?= htmlspecialchars(json_encode($ticket['coduri_bilete'])) ?>">
                            <?php endforeach; ?>
                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($orderId) ?>">
                            <div class="pdf-button-container">
                                <button type="submit" class="pdf-button">Descarcă PDF</button>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>

                <div class="pagination">
                    <?php if ($totalPages > 1): ?>
                        <div style="text-align: center; margin-top: 40px;">
                            <?php if ($currentPage > 1): ?>
                                <a href="?page=<?= $currentPage - 1 ?>" style="margin: 0 10px;">&laquo; Prev</a>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <?php if ($i == $currentPage): ?>
                                    <strong style="margin: 0 5px;"><?= $i ?></strong>
                                <?php else: ?>
                                    <a href="?page=<?= $i ?>" style="margin: 0 5px;"><?= $i ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <?php if ($currentPage < $totalPages): ?>
                                <a href="?page=<?= $currentPage + 1 ?>" style="margin: 0 10px;">Next &raquo;</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
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