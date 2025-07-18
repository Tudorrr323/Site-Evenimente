<?php
ob_start();
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['tickets'])) {
    require_once 'dbh.inc.php';

    $userId = $_SESSION['user_id'];
    $cart = json_decode($_POST['tickets'], true);

    if (empty($cart)) {
        $_SESSION['order_error'] = "Nu ai selectat bilete.";
        header('Location: ../event1.php');
        exit();
    }

    $totalCantitate = 0;
    $totalPrice = 0;
    foreach ($cart as $item) {
        $totalCantitate += (int)$item['quantity'];
        $totalPrice += (float)$item['price'] * (int)$item['quantity'];
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO cos (id_user, isBought, cantitate, pret) 
            VALUES (:id_user, 0, :cantitate, :pret_total)");
        $stmt->execute([
            ':id_user' => $userId,
            ':cantitate' => $totalCantitate,
            ':pret_total' => $totalPrice
        ]);

        $_SESSION['current_order_id'] = $pdo->lastInsertId();
        $_SESSION['cart_items'] = $cart;

        header('Location: ../cart.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['order_error'] = "Eroare la creare comandă: " . $e->getMessage();
        header('Location: ../cart.php');
        exit();
    }
} else {
    header('Location: ../login.php');
    exit();
}
