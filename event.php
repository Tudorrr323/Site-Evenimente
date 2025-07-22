<?php
session_start();
require_once "includes/dbh.inc.php";

if (!isset($_GET['id_event'])) {
    die("Evenimentul nu a fost specificat.");
}

$event_id = intval($_GET['id_event']);

$stmt = $pdo->prepare("SELECT * FROM event WHERE id_event = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

$stmtBilete = $pdo->prepare("SELECT * FROM bilet WHERE id_event = ?");
$stmtBilete->execute([$event_id]);
$bilete = $stmtBilete->fetchAll(PDO::FETCH_ASSOC);

if (!$event) {
    echo "Evenimentul nu a fost găsit. Query folosit: SELECT * FROM event WHERE id_event = $event_id";
    exit;
}

$eventDate = new DateTime($event['date']);
$now = new DateTime();
$isVirtual = (isset($event['type']) && strtolower($event['type']) === 'virtual');

$eventStarted = !$isVirtual && ($now >= $eventDate);

$stmtCat = $pdo->prepare("
    SELECT c.denumire 
    FROM event_categories ec
    JOIN categories c ON ec.id_cat = c.id_cat
    WHERE ec.id_event = ?
");
$stmtCat->execute([$event_id]);
$eventCategories = $stmtCat->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Eveniment</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" />
    <link rel="stylesheet" href="style.css">
    <style>
        .event-card-horizontal:hover {
        transform: none !important;
    }
        .ticket-actions {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
        flex-wrap: nowrap;
    }

    .ticket-actions input.ticket-qty {
        width: 60px;
    }

    .ticket-total-price {
        white-space: nowrap;
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

    <section class="main-content">
        <div class="event-card-horizontal">
            <div class="event-slider" style="position: relative; width: 800px; height: 1100px; overflow: hidden;">
                <img src="IMG/<?= htmlspecialchars($event['imgpath']) ?>" class="event-image active-slide"
                    style="width: 100%; height: 100%; object-fit: contain; display: block;">
            </div>

            <div class="event-details">
                <h2 class="event-title"><?= htmlspecialchars($event['name']) ?></h2>
                <div class="event-location"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($event['location']) ?></div>
                <div class="event-date"><i class="fas fa-clock"></i> Start: <?= htmlspecialchars($event['date']) ?></div>
                <div class="event-description"><?= $event['description'] ?></div>

                <div class="event-categories">
                    <?php foreach ($eventCategories as $catName): ?>
                        <span class="category-tag"><?= htmlspecialchars($catName) ?></span>
                    <?php endforeach; ?>
                </div>

                <div class="ticket-options" style="margin-top: 20px;">
                    <h4 style="margin-bottom: 10px;">Tipuri de bilete:</h4>
                    <ul>
                        <?php foreach ($bilete as $bilet): 
                            $descTrimmed = trim(strtolower($bilet['description']));
                            $isSoldOut = ($descTrimmed === 'sold out');
                        ?>
                            <li style="margin-bottom: 20px; <?= $isSoldOut ? 'opacity: 0.6;' : '' ?>">
                                <div style="margin-bottom: 8px;">
                                    <span class="ticket-label" style="display: block; font-weight: bold; font-size: 16px;">
                                        <?= htmlspecialchars($bilet['denumire']) ?>
                                    </span>

                                    <?php if (!$isSoldOut): ?>
                                        <span class="ticket-description" style="display: block; font-size: 14px; color: #555;">
                                            <?= nl2br($bilet['description']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span style="color: red; font-weight: bold;">Sold out</span>
                                    <?php endif; ?>
                                </div>

                                <div class="ticket-actions">
                                    <input 
                                        type="number" 
                                        min="0" 
                                        value="0" 
                                        data-id="<?= $bilet['id_bilet'] ?>" 
                                        data-type="<?= htmlspecialchars($bilet['denumire']) ?>" 
                                        data-price="<?= (float)$bilet['pret'] ?>" 
                                        class="ticket-qty"
                                        <?= $isSoldOut || $eventStarted ? 'disabled' : '' ?>>
                                    <span class="ticket-total-price"><?= (float)$bilet['pret'] ?> RON</span>
                                </div>
                            </li>
                        <?php endforeach; ?>

                        <?php if ($event_id === 25): ?>
                            <li style="margin-bottom: 20px;">
                                <a href="https://grattacielo.org/" target="_blank" style="font-weight: bold; font-size: 16px; color: #007BFF; text-decoration: underline;">
                                    Vezi detalii aici
                                </a>
                            </li>
                        <?php endif; ?>
                        </ul>

                    <?php if ($event_id !== 25): ?>
                        <button 
                            class="buy-ticket-btn" 
                            id="finalize-purchase" 
                            style="width: 30%; float: right;"
                            <?= $eventStarted ? 'disabled title="Evenimentul a început, nu mai poți cumpăra bilete."' : '' ?>>
                            Cumpără bilet
                        </button>
                    <?php endif; ?>

                    <form method="post" action="includes/start_order.php" id="ticket-form">
                        <input type="hidden" name="tickets" id="tickets-json">
                    </form>
                </div>
            </div>
        </div>
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
        document.getElementById("finalize-purchase").addEventListener("click", function () {
        if (this.disabled) {
            alert("Evenimentul a început și nu mai poți cumpăra bilete.");
            return;
        }

        const ticketInputs = document.querySelectorAll('.ticket-qty');
        const tickets = [];

        ticketInputs.forEach(input => {
            const quantity = parseInt(input.value);
            if (quantity > 0) {
                const id_bilet = input.getAttribute('data-id');
                const type = input.getAttribute('data-type').trim();
                const price = parseInt(input.getAttribute('data-price'));

                tickets.push({ id_bilet: id_bilet, type: type, price: price, quantity: quantity });
            }
        });

        if (tickets.length === 0) {
            alert("Te rugăm să selectezi cel puțin un bilet.");
            return;
        }

        // Salvează biletele în localStorage ca backup
        localStorage.setItem('cart', JSON.stringify(tickets));

        // Salvează și detalii eveniment
        localStorage.setItem('eventDetails', JSON.stringify({
            location: "<?= addslashes($event['location']) ?>",
            date: "<?= addslashes($event['date']) ?>",
            id_event: <?= $event['id_event'] ?>
        }));

        // Trimite formularul către start_order.php
        document.getElementById('tickets-json').value = JSON.stringify(tickets);
        document.getElementById('ticket-form').submit();
    });
</script>
</body>

</html>