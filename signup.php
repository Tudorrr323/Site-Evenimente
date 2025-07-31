<?php
session_start();
require_once 'includes/dbh.inc.php';
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
    <link href="./phone/css/demo.css" rel="stylesheet">
    <link href="./phone/css/intlTelInput.css" rel="stylesheet">

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
    </style>
</head>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    console.log("JS works inline");

    const form = document.querySelector("form");
    const password = document.getElementById("password");
    const repeatPassword = document.getElementById("repeat-password");

    form.addEventListener("submit", function (e) {
      console.log("Submit triggered");
      if (password.value !== repeatPassword.value) {
        e.preventDefault();
        alert("Parolele nu se potrivesc!");
      }
    });
  });
</script>

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

    <section id="register">
        <div id="rectangle">
            <form id="signup-form" action="includes/formhandler.inc.php" method="post" style="border:1px solid #ccc">
                <div class="container">
                    <h1 style="text-align: center;">Sign Up</h1>
                    <p style="text-align: center;">Please fill in this form to create an account.</p>

                    <div class="name-row">
                        <div class="half-field">
                            <label for="first_name"><b>First Name</b></label>
                            <input type="text" name="fname" placeholder="First Name" required>
                        </div>
                        <div class="half-field">
                            <label for="first_name"><b>Last Name</b></label>
                            <input type="text" name="lname" placeholder="Last Name" required>
                        </div>
                    </div>

                    <label for="email"><b>Email</b></label>
                    <input type="email" name="email" placeholder="Email" required>

                    <label for="pwd"><b>Password</b></label>
                    <input type="password" name="pwd" placeholder="Password" id="password" required>

                    <label for="pwd"><b>Repeat Password</b></label>
                    <input type="password" name="pwd-repeat" placeholder="Repeat Password" id="repeat-password"
                        required>
                    <p id="password-error" style="color: red; display: none; font-size: 14px; margin-top: 5px;">Parolele
                        nu se potrivesc.</p>

                    <div class="name-row">
                        <div class="half-field">
                            <label for="phone"><b>Phone Number</b></label>
                            <input type="text" name="phone" placeholder="Phone Number" id="phone" pattern="[0-9]{7,15}"
                                required>
                        </div>

                        <div class="half-field">
                            <label for="bday"><b>Birthday</b></label>
                            <input type="date" name="bday" placeholder="Birthday" id="bday" required>
                        </div>
                    </div>

                    <input type="hidden" name="role" value="user" />

                    <div class="clearfix">
                        <button type="submit" class="signupbtn">Sign Up</button>
                    </div>

                    <a href="login.php" class="text-link">Already have an account?</a>
                    <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms &
                            Privacy</a>.</p>
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
    <script src="search_and_calendar.js"></script>
    
</body>

</html>