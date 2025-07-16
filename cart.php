<?php
session_start();
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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
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
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        #cart-table th,
        #cart-table td {
            padding: 12px 16px;
            border: 1px solid #ddd;
            text-align: left;
        }

        #cart-table th {
            background-color: #810808;
            color: white;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        #main-content {
            flex: 1;
        }

        /* Te asiguri că footerul e jos și are puțin spațiu */
        footer.footer {
            background-color: #e6e6e6;
            color: white;
            padding: 20px;
        }

        button.increase,
        button.decrease,
        button.remove {
            padding: 4px 10px;
            margin: 0 5px;
            background-color: #810808;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
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

        /* Butonul de cumpărare */
        #buy-button {
            margin-top: 20px;
            padding: 12px 30px;
            background-color: #810808;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: block;
            margin-left: auto;
            margin-right: auto;
            transition: background-color 0.3s ease;
            width: 400px;
            text-align: center;
        }

        #buy-button:hover {
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
                <li class="mobile-search">
                    <div class="search-bar">
                        <input type="text" placeholder="Search events..." />
                        <input type="text" placeholder="Location..." />
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
                        <input type="text" placeholder="Search events..." />
                        <input type="text" placeholder="Location..." />
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
                <a href="#">Stand Up</a>
                <a href="#">Comedy</a>
                <a href="#">Night Life</a>
                <a href="#">Music</a>
                <a href="#">Dating</a>
                <a href="#">Theater</a>
                <a href="#">Concerts</a>
                <a href="#">Rock</a>
                <a href="#">Pop</a>
                <a href="#">Movies</a>
                <a href="#">Workshops</a>
                <a href="#">Conferences</a>
                <a href="#">Motivational Talks</a>
                <a href="#">Food Festivals</a>
            </div>
            <div class="category-calendar">
                <i class="fas fa-calendar-alt"></i>
                <input type="date" id="event-date-picker">
            </div>
        </div>
    </section>

    <section id="main-content" style="margin-top: 180px;">
        <h1>Coșul tău de bilete</h1>

        <?php if (isset($_SESSION['order_success'])): ?>
            <div style="margin-top: 20px; background-color: #d4edda; color: #155724; padding: 15px; border-radius: 6px; border: 1px solid #c3e6cb;">
                <?= htmlspecialchars($_SESSION['order_success']); ?>
            </div>
            <script>
                // Șterge coșul local după ce a fost afișat mesajul de succes
                localStorage.removeItem('cart');
                localStorage.removeItem('eventDetails');
            </script>
        <?php unset($_SESSION['order_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['order_error'])): ?>
    <div style="margin-top: 20px; background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; border: 1px solid #f5c6cb;">
        <?= htmlspecialchars($_SESSION['order_error']); ?>
    </div>
    <?php unset($_SESSION['order_error']); ?>
<?php endif; ?>

        <table id="cart-table">
            <thead>
                <tr>
                    <th>Tip bilet</th>
                    <th>Preț unitar</th>
                    <th>Cantitate</th>
                    <th>Data</th>
                    <th>Locație</th>
                    <th>Preț total</th>
                    <th>Acțiuni</th>
                </tr>
            </thead>
            <tbody>
                <!-- aici se vor adauga randurile -->
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">Total de plată</td>
                    <td id="total-price">0 RON</td>
                </tr>
            </tfoot>
        </table>

        <?php if (isset($_SESSION['user_id'])): ?>
            <form method="post" action="includes/buy_cart.php" style="margin-top: 20px;">
                <button type="submit" style="background-color:#810808; color:white; padding:10px 20px; border:none; border-radius:5px; cursor:pointer;">
                    Cumpără bilete
                </button>
            </form>
        <?php else: ?>
            <p>Trebuie să fii logat pentru a cumpăra bilete. <a href="login.php">Loghează-te aici</a>.</p>
        <?php endif; ?>
    </section>

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

        cart.forEach(item => {
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

        // Calculează și afișează totalul general
        const totalCartPrice = cart.reduce((sum, item) => {
            return sum + Number(item.price) * Number(item.quantity);
        }, 0);

        document.getElementById('total-price').textContent = `${totalCartPrice} RON`;

        tbody.querySelectorAll('.increase').forEach((btn, index) => {
            btn.addEventListener('click', () => {
                cart[index].quantity++;
                localStorage.setItem('cart', JSON.stringify(cart));
                location.reload(); // reîncarcă pagina ca să actualizeze tabela
            });
        });

        tbody.querySelectorAll('.decrease').forEach((btn, index) => {
            btn.addEventListener('click', () => {
                if (cart[index].quantity > 1) {
                    cart[index].quantity--;
                    localStorage.setItem('cart', JSON.stringify(cart));
                    location.reload();
                }
            });
        });

        tbody.querySelectorAll('.remove').forEach((btn, index) => {
            btn.addEventListener('click', () => {
                cart.splice(index, 1); // șterge elementul
                localStorage.setItem('cart', JSON.stringify(cart));
                location.reload();
            });
        });

        const buyButton = document.getElementById('buy-button');
        buyButton.addEventListener('click', () => {
            <?php if (isset($_SESSION["user_fname"])): ?>
                if(cart.length === 0) {
                    alert('Coșul este gol!');
                    return;
                }
                // Aici poți pune redirect spre pagina de checkout sau procesare
                alert('Mulțumim pentru cumpărare! Procesăm comanda...');
                // exemplu redirect:
                // window.location.href = 'checkout.php';
            <?php else: ?>
                // dacă nu e logat, du-l la login
                window.location.href = 'login.php';
            <?php endif; ?>
        });

        document.getElementById('buy-form')?.addEventListener('submit', function (e) {
            const cartDataField = document.getElementById('cartData');
            cartDataField.value = JSON.stringify(cart); // trimite conținutul localStorage în hidden field
        });

    </script>

    <script>
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const event = JSON.parse(localStorage.getItem('eventDetails')) || {};

    // Completare tabel etc... (presupunem că deja ai acea logică)

    const buyButton = document.getElementById('buy-button');

    if (buyButton) {
        buyButton.addEventListener('click', () => {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length === 0) {
                e.preventDefault();
                alert("Coșul este gol! Nu poți plasa o comandă fără bilete.");
            }

            fetch('includes/buy_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(cart.map(item => ({
                    type: item.type,
                    price: item.price,
                    quantity: item.quantity,
                    location: event.location || '-',
                    description: event.description || '',
                    id_event: event.id_event || null
                })))
            })
            .then(response => {
                if (response.ok) {
                    localStorage.removeItem('cart');
                    localStorage.removeItem('eventDetails');
                    alert("Mulțumim pentru comandă!");
                    window.location.reload(); // reîncarcă pagina
                } else {
                    alert("Eroare la procesarea comenzii.");
                }
            });
        });
    }
</script>
    
    <script src="script.js"></script>
</body>

</html>