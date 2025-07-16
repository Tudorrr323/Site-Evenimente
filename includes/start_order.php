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
    $tickets = json_decode($_POST['tickets'], true);

    if (empty($tickets)) {
        $_SESSION['order_error'] = "Nu ai selectat bilete.";
        header('Location: ../event1.php');
        exit();
    }

    try {
        // 1. Creează comanda cu isBought=0
        $stmt = $pdo->prepare("INSERT INTO cos (id_user, isBought) VALUES (:id_user, 0)");
        $stmt->execute([':id_user' => $userId]);
        $id_cos = $pdo->lastInsertId();

        // 2. Inserează biletele
        $stmt_bilet = $pdo->prepare("
            INSERT INTO bilet (denumire, pret, quantity, id_cos)
            VALUES (:denumire, :pret, :quantity, :id_cos)
        ");

        foreach ($tickets as $ticket) {
            $stmt_bilet->execute([
                ':denumire' => $ticket['type'],
                ':pret' => $ticket['price'],
                ':quantity' => $ticket['quantity'],
                ':id_cos' => $id_cos
            ]);
        }

        // Poți salva id-ul comenzii în sesiune pentru a-l folosi mai departe
        $_SESSION['current_order_id'] = $id_cos;

        // Redirect la coș să finalizeze comanda
        header('Location: ../cart.php');
        exit();

    } catch (PDOException $e) {
        // În caz de eroare, afisează sau salvează mesajul
        $_SESSION['order_error'] = "Eroare la creare comandă: " . $e->getMessage();
        header('Location: ../cart.php');
        exit();
    }
} else {
    header('Location: ../login.php');
    exit();
}
