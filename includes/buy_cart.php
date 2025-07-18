<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'], $_SESSION['current_order_id'])) {
    require_once 'dbh.inc.php';

    $userId = $_SESSION['user_id'];
    $id_cos = $_SESSION['current_order_id'];

    // Decodez cartData (JSON cu biletele)
    $cart = isset($_POST['cartData']) ? json_decode($_POST['cartData'], true) : [];

    if (empty($cart)) {
        $_SESSION['order_error'] = "Coșul este gol! Nu poți plasa o comandă fără bilete.";
        header("Location: ../cart.php");
        exit();
    }

    $totalQuantity = 0;
    $totalPrice = 0;

    // Calculez total cantitate și preț
    foreach ($cart as $item) {
        $qty = (int)$item['quantity'];
        $price = (float)$item['price'];
        $totalQuantity += $qty;
        $totalPrice += $qty * $price;
    }

    try {
        // Inserez fiecare bilet din cart în cos_bilet
        foreach ($cart as $item) {
            $id_bilet = isset($item['id_bilet']) ? $item['id_bilet'] : null;
            $cantitate = (int)$item['quantity'];
            $pret = (float)$item['price'];

            // Dacă nu ai id_bilet în date, trebuie să-l adaugi în cart când îl construiești în JS!
            if ($id_bilet === null) {
                // Dacă nu ai id_bilet, nu putem insera corect — afișează eroare sau treci peste
                continue;
            }

            $stmt = $pdo->prepare("INSERT INTO cos_bilet (id_cos, id_bilet, cantitate, pret) VALUES (?, ?, ?, ?)");
            $stmt->execute([$id_cos, $id_bilet, $cantitate, $pret]);
        }

        // Actualizez cos-ul
        $stmt = $pdo->prepare("UPDATE cos 
            SET isBought = 1, cantitate = :cantitate, pret = :pret_total 
            WHERE id_cos = :id_cos AND id_user = :id_user");
        $stmt->execute([
            ':cantitate' => $totalQuantity,
            ':pret_total' => $totalPrice,
            ':id_cos' => $id_cos,
            ':id_user' => $userId
        ]);

        // Șterg sesiunea comenzii curente
        unset($_SESSION['current_order_id']);

        $_SESSION['order_success'] = "Mulțumim pentru comandă! Comanda ta a fost procesată cu succes.";
        header("Location: ../cart.php");
        exit();

    } catch (PDOException $e) {
        echo "Eroare la cumpărare: " . $e->getMessage();
    }
} else {
    header("Location: ../cart.php");
    exit();
}

