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
                        <input type="text" placeholder="Search events..." />
                        <input type="text" placeholder="Location..." />
                        <button><i class="fas fa-search"></i></button>
                    </div>
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
                <li class="desktop-login"><a href="login.php">Log in</a></li>
                <li class="desktop-signup"><a href="signup.php">Sign Up</a></li>
                <li class="mobile-login-btn">
                    <button id="mobile-login-button"><i class="fa-solid fa-user"></i></button>
                </li>
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

    <section id="register">
        <div id="rectangle">
            <form action="action_page.php" style="border:1px solid #ccc">
                <div class="container">
                    <h1 style="text-align: center;">Forgot Password</h1>
                    <p style="text-align: center;">Please enter your email and we'll send you a link to reset your password.</p>
                    <hr>

                    <label for="email"><b>Email</b></label>
                    <input type="email" placeholder="Your Email" name="email" id="email" required>

                    <div class="clearfix">
                        <button type="submit" class="resetpassbtn">Reset Password</button>
                    </div>
                </div>
            </form>
        </div>
    </section>


    <script src="./phone/js/intlTelInput.js"></script>
    <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {});
    </script>
    <script src="script.js"></script>
</body>

</html>