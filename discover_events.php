<?php
session_start();
require_once 'includes/dbh.inc.php';

// Determinăm pagina curentă, default 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$eventsPerPage = 10;
$offset = ($page - 1) * $eventsPerPage;

// Număr total evenimente (pentru paginare)
$totalEventsStmt = $pdo->query("SELECT COUNT(*) FROM event");
$totalEvents = $totalEventsStmt->fetchColumn();
$totalPages = ceil($totalEvents / $eventsPerPage);

// Preluare evenimente pentru pagina curentă cu LIMIT
$stmt = $pdo->prepare("SELECT * FROM event ORDER BY date ASC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $eventsPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

$q = trim($_GET['q'] ?? '');
$city = trim($_GET['city'] ?? '');

$sql = "SELECT * FROM event WHERE 1=1";
$params = [];

if (!empty($q)) {
    $sql .= " AND name LIKE ?";
    $params[] = "%$q%";
}

if (!empty($city)) {
    $sql .= " AND city LIKE ?";
    $params[] = "%$city%";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$events = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticketa</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" />
    <link rel="stylesheet" href="style.css">

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
                </li>
                <li class="mobile-search">
                    <div class="search-bar">
                        <input type="text" placeholder="Events..." />
                        <input type="text" placeholder="City..." />
                        <button><i class="fas fa-search"></i></button>
                    </div>
                </li>
                <li><a href="index.php">Home</a></li>
                <li><a class="active" href="discover_events.php">Discover Events</a></li>
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
                <li class="greeting">
                    <a href="profile.php">Salut, <?= htmlspecialchars($_SESSION["user_fname"]) ?>!</a>
                </li>
                <?php else: ?>
                <li><a href="login.php">Log in</a></li>
                <li><a href="signup.php">Sign Up</a></li>
                <?php endif; ?>

                <li>
                <a href="cart.php" style="color: black;">
                    <i class="fas fa-shopping-bag"></i>
                </a>
                </li>
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

                echo '
                <div class="event-card-horizontal">
                    <div class="event-image-wrapper" style="width: 400px; height: 300px; overflow: hidden;">
                        <img src="IMG/' . $imgpath . '" alt="Eveniment" class="event-image">
                    </div>
                    <div class="event-details">
                        <h3 class="event-title">' . $name . '</h3>';
                        if (!$isVirtual) {
                                echo '<p class="event-location" style="margin: 4px 0; font-size:18px;"><i class="fas fa-map-marker-alt"></i> ' . $city . '</p>';
                            }
                        echo '
                        <p class="event-date"><i class="fas fa-calendar-alt"></i> ' . $date . '</p>
                        <p class="event-organiser"><i class="fas fa-clipboard-list"></i> ' . $organiser .'</p>
                        <p class="event-description">' . $description . '</p>
                        <div class="event-categories">' . $categoryTagsHtml . '</div>
                        <a href="event.php?id_event=' . $id . '" class="buy-ticket-btn" style="width: 30%; float: right; display: inline-block; 
                        text-decoration: none; text-align: center; color: white;">
                            Ia bilet
                        </a>
                    </div>
                </div>';
                }
            }
            else {
                echo '<p>Nu există evenimente disponibile.</p>';
            }
            ?>
            <div class="pagination" style="text-align:center; margin-top: 30px;">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>" class="pagination-btn">&laquo; Prev</a>
                <?php endif; ?>

                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                    <?php if ($p == $page): ?>
                        <strong><?= $p ?></strong>
                    <?php else: ?>
                        <a href="?page=<?= $p ?>" class="pagination-btn"><?= $p ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>" class="pagination-btn">Next &raquo;</a>
                <?php endif; ?>
            </div>
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