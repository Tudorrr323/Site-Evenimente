<?php
session_start();
require_once 'includes/dbh.inc.php';

// Verificăm dacă utilizatorul este logat
if (!isset($_SESSION["user_fname"])) {
    header("Location: login.php");
    exit();
}

$company = '';

if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT company FROM user WHERE id_user = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $company = $result['company'];
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

        .edit-button, .add-tickets-button {
            width: 140px;           /* dimensiune fixă */
            display: inline-flex;          /* flex inline */
            justify-content: center;       /* centrare orizontală */
            align-items: center;   
            margin: 10px 20px;
            padding: 8px 14px;
            border-radius: 5px;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            white-space: nowrap;    /* textul rămâne pe un singur rând */
            box-sizing: border-box; /* include padding în lățime */
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .edit-button {
            background: #810808;
        }

        .edit-button:hover {
            background: #5a0505;
            transform: scale(1.05);
        }

        .add-tickets-button {
            background: #810808;
        }

        .add-tickets-button:hover {
            background: #5a0505;
            transform: scale(1.05);
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

    <section class="my-events">
        <h2 style="text-align:center; margin-top: 30px;">Evenimentele tale</h2>

        <div class="event-list" style="display: flex; flex-direction: column; gap: 30px; padding: 30px 10%; max-width: 1500px; margin: auto; margin-top: 120px;">
            <?php
            $organiserName = $_SESSION["user_fname"];

            try {
                $stmt = $pdo->prepare("SELECT * FROM event WHERE organiser = :organiser ORDER BY date DESC");
                $stmt->execute(['organiser' => $company]);
                $myEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($myEvents) {
                    foreach ($myEvents as $event) {
                        echo '<div class="event-row" style="display: flex; gap: 20px; border: 1px solid #ccc; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); background: #fff;">';

                        echo '<div class="event-image" style="flex: 0 0 300px; height: 200px; overflow: hidden;">';
                        echo '<img src="IMG/' . htmlspecialchars($event['imgpath']) . '" alt="Imagine Eveniment" style="width: 100%; height: 100%; object-fit: cover;">';
                        echo '</div>';

                        echo '<div class="event-details" style="flex: 1; padding: 20px;">';
                        echo '<h3 style="margin-top: 0;">' . htmlspecialchars($event['name']) . '</h3>';
                        echo '<p><strong>Locație:</strong> ' . htmlspecialchars($event['location']) . '</p>';
                        echo '<p><strong>Oraș:</strong> ' . htmlspecialchars($event['city']) . '</p>';
                        echo '<p><strong>Data:</strong> ' . htmlspecialchars($event['date']) . '</p>';
                        echo '<p><strong>Tip:</strong> ' . htmlspecialchars($event['type']) . '</p>';
                        echo '<p style="margin-top: 10px;">' . $event['description'] . '</p>';

                        echo '<a href="edit_event.php?id_event=' . $event['id_event'] . '" class="edit-button">Edit event</a>';
                        echo '<a href="add_tickets.php?id_event=' . $event['id_event'] . '" class="add-tickets-button">Adaugă bilete</a>';

                        // Preluare bilete pentru evenimentul curent
                        $stmtTickets = $pdo->prepare("SELECT * FROM bilet WHERE id_event = ?");
                        $stmtTickets->execute([$event['id_event']]);
                        $tickets = $stmtTickets->fetchAll(PDO::FETCH_ASSOC);

                        if ($tickets) {
                            echo '<div style="margin-top: 20px;">';
                            echo '<h4>Bilete disponibile:</h4>';
                            echo '<ul style="list-style:none; padding-left:0;">';
                            foreach ($tickets as $ticket) {
                                echo '<li style="margin-bottom: 12px; border-bottom: 1px solid #ddd; padding-bottom: 8px;">';
                                echo '<strong>' . htmlspecialchars($ticket['denumire']) . '</strong> - ' . htmlspecialchars($ticket['description']) . 
                                    ' - Preț: ' . htmlspecialchars($ticket['pret']) . ' lei';
                                echo ' &nbsp;&nbsp; ';
                                echo '<a href="edit_ticket.php?id_bilet=' . $ticket['id_bilet'] . '" class="edit-button" style="width:auto; padding:4px 10px; font-size:13px;">Editează bilet</a>';
                                echo ' ';
                                echo '<a href="includes/delete_ticket.php?id_bilet=' . $ticket['id_bilet'] . '" class="edit-button" style="background:#c0392b; width:auto; padding:4px 10px; font-size:13px;" onclick="return confirm(\'Sigur vrei să ștergi acest bilet?\')">Șterge bilet</a>';
                                echo '</li>';
                            }
                            echo '</ul>';
                            echo '</div>';
                        } else {
                            echo '<p style="margin-top:20px; font-style: italic; color: #555;">Nu există bilete pentru acest eveniment.</p>';
                        }

                        echo '</div>'; // close event-details
                        echo '</div>'; // close event-row
                    }
                } else {
                    echo "<p style='text-align:center; margin-top:20px;'>Nu ai creat niciun eveniment încă.</p>";
                }
            } catch (PDOException $e) {
                echo "<p style='color:red; text-align:center;'>Eroare la preluarea evenimentelor: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
            ?>
        </div>
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