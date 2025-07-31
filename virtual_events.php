<?php
session_start();
require_once 'includes/dbh.inc.php';

// Determinăm pagina curentă, default 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$eventsPerPage = 10;
$offset = ($page - 1) * $eventsPerPage;

// Număr total evenimente (pentru paginare)
$totalEventsStmt = $pdo->query("SELECT COUNT(*) FROM event WHERE type = 'virtual'");
$totalEvents = $totalEventsStmt->fetchColumn();
$totalPages = ceil($totalEvents / $eventsPerPage);

$filterDate = isset($_GET['date']) ? $_GET['date'] : null;

if ($filterDate) {
    $stmt = $pdo->prepare("SELECT * FROM event WHERE type = 'virtual' AND DATE(`date`) = :filterDate ORDER BY date ASC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':filterDate', $filterDate, PDO::PARAM_STR);
} else {
    $stmt = $pdo->prepare("SELECT * FROM event WHERE type = 'virtual' ORDER BY date ASC LIMIT :limit OFFSET :offset");
}

$stmt->bindValue(':limit', $eventsPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        .event-description {
            display: -webkit-box;
            -webkit-line-clamp: 10;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .event-image-wrapper {
            width: 400px;
            height: 300px;
            overflow: hidden;
            display: flex;
            align-items: center;      /* vertical centrare */
            justify-content: center;  /* orizontal centrare */
            background-color: #fff;   /* sau altă culoare */
        }

        .event-image-wrapper img.event-image {
            width: 100%;
            height: 100%;
            object-fit: contain;  /* păstrează proporțiile și se încadrează complet */
        }

        .pagination a.pagination-btn {
            margin: 0 5px;
            padding: 8px 12px;
            background-color: #ffffffff;
            color: black;
            text-decoration: none;
            border-radius: 4px;
        }

        .pagination strong {
            margin: 0 5px;
            padding: 8px 12px;
            background-color: #000000ff;
            color: white;
            border-radius: 4px;
        }

        .pagination a.pagination-btn:hover {
            background-color: #a0a0a0ff;
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
                <li><a class="active" href="virtual_events.php">Virtual Events</a></li>
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

    <section id="hero">
        <section class="main-content">
            <?php
            if ($events) {
                foreach ($events as $event) {
                $id = $event['id_event'];
                $name = htmlspecialchars($event['name']);
                $location = htmlspecialchars($event['location']);
                $city = htmlspecialchars($event['city']);
                $date = date("j F Y", strtotime($event['date']));
                $organiser = htmlspecialchars($event['organiser']);
                $imgpath = htmlspecialchars($event['imgpath']);
                $description = nl2br($event['description']);

                $isVirtual = ($event['type'] === 'virtual');

                $stmtCat = $pdo->prepare("
                    SELECT c.denumire 
                    FROM event_categories ec
                    JOIN categories c ON ec.id_cat = c.id_cat
                    WHERE ec.id_event = ?
                ");
                $stmtCat->execute([$id]);
                $eventCategories = $stmtCat->fetchAll(PDO::FETCH_COLUMN);

                $categoryTagsHtml = '';
                foreach ($eventCategories as $catName) {
                    $categoryTagsHtml .= '<span class="category-tag">' . htmlspecialchars($catName) . '</span> ';
                }

                $isFilm = in_array('Film', $eventCategories);
                $isExpired = !$isFilm && (strtotime($event['date']) < time());

                $buttonHtml = $isExpired
                    ? '<a href="event.php?id_event=' . $id . '" class="buy-ticket-btn" style="width: 30%; float: right; display: inline-block; 
                        background-color: #810808; text-decoration: none; text-align: center; color: white;">
                        Vezi detalii
                    </a>'
                    : '<a href="event.php?id_event=' . $id . '" class="buy-ticket-btn" style="width: 30%; float: right; display: inline-block; 
                        background-color: #810808; text-decoration: none; text-align: center; color: white;">
                        Ia bilet
                    </a>';

                echo '
                    <div class="event-card-horizontal">
                        <div class="event-image-wrapper" style="width: 400px; height: 300px; overflow: hidden;">
                            <img src="IMG/' . $imgpath . '" alt="Eveniment" class="event-image">
                        </div>
                        <div class="event-details">
                            <h3 class="event-title">' . $name . '</h3>';

                            if ($isExpired) {
                                echo '<p class="expired-label" style="color: red; font-weight: bold;">Eveniment expirat</p>';
                            }

                            if (!$isVirtual) {
                                echo '<p class="event-location" style="margin: 4px 0; font-size:18px;"><i class="fas fa-map-marker-alt"></i> ' . $city . '</p>';
                            }

                echo '
                            <p class="event-date"><i class="fas fa-calendar-alt"></i> ' . $date . '</p>
                            <p class="event-organiser"><i class="fas fa-clipboard-list"></i> ' . $organiser . '</p>
                            <p class="event-description">' . $description . '</p>
                            <div class="event-categories">' . $categoryTagsHtml . '</div>
                            ' . $buttonHtml . '
                        </div>
                    </div>';
                }
            }
            else {
                echo '<p>Nu există evenimente disponibile.</p>';
            }
            ?>
            <div class="pagination" style="margin-top: 30px; text-align: center;">
                <?php
                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($i == $page) {
                        echo '<strong>' . $i . '</strong>';
                    } else {
                        echo '<a class="pagination-btn" href="?page=' . $i . '">' . $i . '</a>';
                    }
                }
                ?>
            </div>
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