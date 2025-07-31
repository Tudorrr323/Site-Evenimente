<?php
session_start();
require_once 'includes/dbh.inc.php';

$redirectLink = "signup_manager.php";

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'manager') {
    $redirectLink = "create_events.php";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Site Eveniment</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        body { 
            font-family: Arial, sans-serif; 
            padding: 20px; 
            background: #f9f9f9; 
        }

        h1 { 
            color: #810808; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
            background: white; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th, td { 
            padding: 12px 15px; 
            border: 1px solid #ddd; 
            text-align: left; 
        }

        th { 
            background-color: #810808; 
            color: white; 
        }

        tfoot td { 
            font-weight: bold;
        }

        #cart-table { 
            margin-top: 30px;
        }

        button.increase, 
        button.decrease, 
        button.remove {
            padding: 4px 10px; margin: 0 5px;
            background-color: #810808; color: white;
            border: none; border-radius: 4px; cursor: pointer; text-align: center;
        }

        button.increase, 
        button.decrease { 
            width: 20%; 
        }

        button.remove { 
            background-color: #a00; 
        }

        button:hover { 
            background-color: #5a0606; 
        }

        #buy-button {
            margin-top: 20px; padding: 12px 30px;
            background-color: #810808; color: white;
            font-size: 18px; border: none; border-radius: 5px;
            cursor: pointer; display: block; margin: 20px auto 0;
            width: 400px; text-align: center;
            transition: background-color 0.3s ease;
        }

        #buy-button:hover { 
            background-color: #5a0606; 
        }

        html, body {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        #main-wrapper {
            flex: 1;
            padding: 20px;
        }

        footer.footer {
            background-color: #e6e6e6;
            color: #1a1a1a;
            padding: 20px;
            width: 100%;
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
                <li class="mobile-search">
                    <div class="search-results-container">
                        <div class="search-bar">
                            <input type="text" class="search-input" id="search-input" placeholder="Events..." />
                            <input type="text" class="city-input" id="city-input" placeholder="City..." />
                            <button type="button"><i class="fas fa-search"></i></button>
                        </div>
                    <div class="live-results" id="live-results-mobile"></div>
                </li>
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
                        Salut, <?= htmlspecialchars($_SESSION["user_fname"]) ?>!
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

    <div id="main-wrapper">
        <section id="main-content" style="margin-top: 180px;">
        <h1>Coșul tău de bilete</h1>

        <?php if (isset($_SESSION['order_success'])): ?>
            <div style="margin-top:20px; background-color:#d4edda; color:#155724; padding:15px; border-radius:6px; border:1px solid #c3e6cb;">
                <?= htmlspecialchars($_SESSION['order_success']); ?>
            </div>

            <?php if (isset($_SESSION['tickets_to_download']) && is_array($_SESSION['tickets_to_download'])): ?>
                <form method="POST" action="includes/generate_ticket_pdf.php" style="margin-top: 15px;">
                    <?php foreach ($_SESSION['tickets_to_download'] as $ticket): ?>
                        <input type="hidden" name="event_name[]" value="<?= htmlspecialchars($ticket['event_name']) ?>">
                        <input type="hidden" name="event_date[]" value="<?= htmlspecialchars($ticket['event_date']) ?>">
                        <input type="hidden" name="event_location[]" value="<?= htmlspecialchars($ticket['event_location']) ?>">
                        <input type="hidden" name="ticket_name[]" value="<?= htmlspecialchars($ticket['ticket_name']) ?>">
                        <input type="hidden" name="cantitate[]" value="<?= htmlspecialchars($ticket['cantitate']) ?>">
                        <input type="hidden" name="pret_bilet[]" value="<?= htmlspecialchars($ticket['pret_bilet']) ?>">
                        <input type="hidden" name="cod_bilet[]" value='<?= htmlspecialchars($ticket['cod_bilete']) ?>'>
                    <?php endforeach; ?>

                    <!-- Trimite un singur order_id scalar -->
                    <input type="hidden" name="order_id" value="<?= htmlspecialchars($_SESSION['tickets_to_download'][0]['order_id']) ?>">

                    <button class="btn-group" style="width: 20%; display: block; margin: 0 auto; margin-top: 20px; background-color: #810808; color: white;
                        border: none; padding: 10px 18px; font-size: 15px; border-radius: 25px; cursor: pointer; transition: background-color 0.3s; white-space: nowrap; 
                        height: fit-content; align-self: start;" 
                        type="submit">Descarcă Biletele PDF</button>
                </form>
            <?php endif; ?>

            <script>
                localStorage.removeItem('cart');
                localStorage.removeItem('eventDetails');
            </script>
            <?php unset($_SESSION['order_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['order_error'])): ?>
            <div style="margin-top:20px; background-color:#f8d7da; color:#721c24; padding:15px; border-radius:6px; border:1px solid #f5c6cb;">
                <?= htmlspecialchars($_SESSION['order_error']); ?>
            </div>
            <?php unset($_SESSION['order_error']); ?>
        <?php endif; ?>

        <table id="cart-table">
            <thead>
                <tr>
                    <th>Denumire</th>
                    <th>Preț unitar</th>
                    <th>Cantitate</th>
                    <th>Data</th>
                    <th>Locație</th>
                    <th>Preț total</th>
                    <th>Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                <!-- Rândurile se vor adăuga din JS -->
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">Total de plată</td>
                    <td id="total-price">0 RON</td>
                </tr>
            </tfoot>
        </table>

        <div id="empty-cart-message" style="display: none; color: red; font-weight: bold;">
            Nu ai niciun coș activ.
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
            <form id="buy-form" action="includes/buy_cart.php" method="POST" onsubmit="return prepareCartData();">
                <input type="hidden" name="cartData" id="cartData" />
                <button id="buy-button" type="submit">Cumpără bilete</button>
            </form>
            <?php else: ?>
                <p>Trebuie să fii logat pentru a cumpăra bilete. <a href="login.php">Loghează-te aici</a>.</p>
            <?php endif; ?>
        </section>
    </div>

<footer class="footer" style="bottom: 0; width: 100%;">
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

<script>
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const event = JSON.parse(localStorage.getItem('eventDetails')) || {};

    const tbody = document.querySelector('#cart-table tbody');

    cart.forEach((item) => {
        const price = Number(item.price);
        const quantity = Number(item.quantity);
        const total = price * quantity;

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${item.type}</td>
            <td>${price.toFixed(2).replace(/\.00$/, '')} RON</td>
            <td>
                <button class="decrease">-</button>
                <span class="quantity">${quantity}</span>
                <button class="increase">+</button>
            </td>
            <td>${event.date || '-'}</td>
            <td>${event.location || '-'}</td>
            <td class="item-total">${total.toFixed(2)} RON</td>
            <td><button class="remove">Șterge</button></td>
        `;
        tbody.appendChild(tr);
    });

    // Calculează total general
    const totalCartPrice = cart.reduce((sum, item) => sum + Number(item.price) * Number(item.quantity), 0);
    document.getElementById('total-price').textContent = `${totalCartPrice.toFixed(2)} RON`;

    if (cart.length === 0) {
        // Ascund formularul de cumpărare
        const buyForm = document.getElementById('buy-form');
        if (buyForm) {
            buyForm.style.display = 'none';
        }

        // Arăt mesajul "Nu ai niciun coș activ"
        const emptyMessage = document.getElementById('empty-cart-message');
        if (emptyMessage) {
            emptyMessage.style.display = 'block';
        }
    }

    // Evenimente butoane
    tbody.querySelectorAll('.increase').forEach((btn, i) => {
        btn.addEventListener('click', () => {
            cart[i].quantity++;
            localStorage.setItem('cart', JSON.stringify(cart));
            location.reload();
        });
    });
    tbody.querySelectorAll('.decrease').forEach((btn, i) => {
        btn.addEventListener('click', () => {
            if (cart[i].quantity > 1) {
                cart[i].quantity--;
                localStorage.setItem('cart', JSON.stringify(cart));
                location.reload();
            }
        });
    });
    tbody.querySelectorAll('.remove').forEach((btn, i) => {
        btn.addEventListener('click', () => {
            cart.splice(i, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            location.reload();
        });
    });

    // Pregătește datele din coș pentru trimitere
    function prepareCartData() {
        const cartData = localStorage.getItem('cart');
        document.getElementById('cartData').value = cartData ? cartData : '[]';
        return true;
    }
</script>

<script src="script.js"></script>
<script src="search_and_calendar.js"></script>

</body>
</html>
