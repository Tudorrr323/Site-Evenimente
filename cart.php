<?php
session_start();
require_once 'includes/dbh.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Site Eveniment</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" />
    <link rel="stylesheet" href="style.css" />
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

    <div id="main-wrapper">
    <section id="main-content" style="margin-top: 180px;">
    <h1>Coșul tău de bilete</h1>

    <?php if (isset($_SESSION['order_success'])): ?>
        <div style="margin-top:20px; background-color:#d4edda; color:#155724; padding:15px; border-radius:6px; border:1px solid #c3e6cb;">
            <?= htmlspecialchars($_SESSION['order_success']); ?>
        </div>
        <script>
            localStorage.removeItem('cart');
            localStorage.removeItem('eventDetails');
        </script>
    <?php unset($_SESSION['order_success']); endif; ?>

    <?php if (isset($_SESSION['order_error'])): ?>
        <div style="margin-top:20px; background-color:#f8d7da; color:#721c24; padding:15px; border-radius:6px; border:1px solid #f5c6cb;">
            <?= htmlspecialchars($_SESSION['order_error']); ?>
        </div>
    <?php unset($_SESSION['order_error']); endif; ?>

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

    <?php if (isset($_SESSION['user_id'])): ?>
        <?php if (isset($_SESSION['current_order_id'])): ?>
            <form id="buy-form" action="includes/buy_cart.php" method="POST" onsubmit="return prepareCartData();">
                <input type="hidden" name="cartData" id="cartData" />
                <button id="buy-button" type="submit">Cumpără bilete</button>
            </form>
        <?php else: ?>
            <p style="color: orange;">Nu ai un coș activ pentru cumpărare.</p>
        <?php endif; ?>
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
            <td>${price} RON</td>
            <td>
                <button class="decrease">-</button>
                <span class="quantity">${quantity}</span>
                <button class="increase">+</button>
            </td>
            <td>${event.date || '-'}</td>
            <td>${event.location || '-'}</td>
            <td class="item-total">${total} RON</td>
            <td><button class="remove">Șterge</button></td>
        `;
        tbody.appendChild(tr);
    });

    // Calculează total general
    const totalCartPrice = cart.reduce((sum, item) => sum + Number(item.price) * Number(item.quantity), 0);
    document.getElementById('total-price').textContent = `${totalCartPrice} RON`;

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
</body>
</html>
