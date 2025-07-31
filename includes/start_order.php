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
        header('Location: ../index.php');
        exit();
    }

    try {
        // Generezi un order_id unic pentru întreaga comandă
        $order_id = 'TICK' . date('YmdHis') . bin2hex(random_bytes(3));

        $sql = "INSERT INTO cos_bilet (id_bilet, cantitate, pret, pret_total, isBought, id_user, cod_bilet, added_at, order_id)
                VALUES (:id_bilet, :cantitate, :pret, :pret_total, :isBought, :id_user, :cod_bilet, :added_at, :order_id)";
        $stmt = $pdo->prepare($sql);

        foreach ($cart as $item) {
            $id_bilet = $item['id_bilet'];
            $cantitate = (int)$item['quantity'];
            $pret = (float)$item['price'];
            $isBought = 0;

            for ($i = 0; $i < $cantitate; $i++) {
                $cod_bilet = 'B' . date('YmdHis') . bin2hex(random_bytes(3));
                $added_at = date('Y-m-d H:i:s');  // ora curentă

                $stmt->execute([
                    ':id_bilet' => $id_bilet,
                    ':cantitate' => 1,
                    ':pret' => $pret,
                    ':pret_total' => $pret,
                    ':isBought' => $isBought,
                    ':id_user' => $userId,
                    ':cod_bilet' => $cod_bilet,
                    ':added_at' => $added_at,
                    ':order_id' => $order_id
                ]);
            }
        }

        $_SESSION['success_message'] = "Comanda a fost salvată cu succes!";
        header('Location: ../cart.php');
        exit();

    } catch (PDOException $e) {
        $_SESSION['order_success'] = "Mulțumim pentru comandă! Comanda ta a fost procesată cu succes.";
        header('Location: ../cart.php');
        exit();
    }
} else {
    header('Location: ../login.php');
    exit();
}
