<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'], $_SESSION['current_order_id'])) {
    require_once 'dbh.inc.php';

    $userId = $_SESSION['user_id'];
    $id_cos = $_SESSION['current_order_id'];
    $cart = json_decode($_POST['cartData'], true);

    if (empty($cart)) {
        $_SESSION['order_error'] = "Coșul este gol! Nu poți plasa o comandă fără bilete.";
        header("Location: ../cart.php");
        exit();
    }

    $isBought = 1;

    try {
        // 1. Creează o nouă comandă
        $stmt = $pdo->prepare("UPDATE cos SET isBought = 1 WHERE id_cos = :id_cos AND id_user = :id_user");
        $stmt->execute([
            ':id_cos' => $id_cos,
            ':id_user' => $userId
        ]);

        $id_cos = $pdo->lastInsertId(); // id-ul coșului nou

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
