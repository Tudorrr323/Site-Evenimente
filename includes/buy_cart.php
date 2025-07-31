<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    require_once 'dbh.inc.php';

    $userId = $_SESSION['user_id'];

    // Decodez cartData
    $cart = isset($_POST['cartData']) ? json_decode($_POST['cartData'], true) : [];

    if (empty($cart)) {
        $_SESSION['order_error'] = "Coșul este gol! Nu poți plasa o comandă fără bilete.";
        header("Location: ../cart.php");
        exit();
    }

    $bilete = [];

    try {
        // Generează un order_id unic pentru comanda aceasta
        $order_id = 'TICK' . date('YmdHis') . bin2hex(random_bytes(3));

        foreach ($cart as $item) {
    $id_bilet = isset($item['id_bilet']) ? $item['id_bilet'] : null;
    $cantitate_noua = (int)$item['quantity'];
    $pret = (float)$item['price'];

    if ($id_bilet === null) continue;

    // Numără biletele neconfirmate pentru user și bilet
    $stmtCount = $pdo->prepare("SELECT COUNT(*) FROM cos_bilet WHERE id_user = ? AND id_bilet = ? AND isBought = 0");
    $stmtCount->execute([$userId, $id_bilet]);
    $bilete_existente = (int)$stmtCount->fetchColumn();

    if ($cantitate_noua > $bilete_existente) {
        // Trebuie să adaug bilete noi în cos
        $cate_de_adaugat = $cantitate_noua - $bilete_existente;

        $stmtInsert = $pdo->prepare("INSERT INTO cos_bilet (id_bilet, cantitate, pret, pret_total, isBought, id_user, cod_bilet, added_at) VALUES (?, 1, ?, ?, 0, ?, ?, ?)");

        for ($i = 0; $i < $cate_de_adaugat; $i++) {
            $cod_bilet = 'B' . date('YmdHis') . bin2hex(random_bytes(3));
            $added_at = date('Y-m-d H:i:s');
            $stmtInsert->execute([$id_bilet, $pret, $pret, $userId, $cod_bilet, $added_at]);
        }
    }
    // Ștergere bilete dacă cantitate a scăzut
if ($cantitate_noua < $bilete_existente) {
    $cate_de_sters = (int)($bilete_existente - $cantitate_noua);

    $limit = $cate_de_sters;
    $sql = "SELECT id_cos_bilet FROM cos_bilet WHERE id_user = ? AND id_bilet = ? AND isBought = 0 LIMIT $limit";
    $stmtSelect = $pdo->prepare($sql);
    $stmtSelect->execute([$userId, $id_bilet]);
    $ids_de_sters = $stmtSelect->fetchAll(PDO::FETCH_COLUMN);

    if ($ids_de_sters) {
        $in  = str_repeat('?,', count($ids_de_sters) - 1) . '?';
        $stmtDelete = $pdo->prepare("DELETE FROM cos_bilet WHERE id_cos_bilet IN ($in)");
        $stmtDelete->execute($ids_de_sters);
    }
}

// Confirmare bilete pentru cumpărare
$stmtCount = $pdo->prepare("SELECT COUNT(*) FROM cos_bilet WHERE id_user = ? AND id_bilet = ? AND isBought = 0");
$stmtCount->execute([$userId, $id_bilet]);
$bilete_neconfirmate = (int)$stmtCount->fetchColumn();

$de_confirmat = min($cantitate_noua, $bilete_neconfirmate);

if ($de_confirmat > 0) {
    $limit = (int)$de_confirmat;
    $sql = "SELECT id_cos_bilet FROM cos_bilet WHERE id_user = ? AND id_bilet = ? AND isBought = 0 LIMIT $limit";
    $stmtSelect = $pdo->prepare($sql);
    $stmtSelect->execute([$userId, $id_bilet]);
    $ids_de_confirmat = $stmtSelect->fetchAll(PDO::FETCH_COLUMN);

    $stmtUpdate = $pdo->prepare("UPDATE cos_bilet SET pret = ?, pret_total = ?, isBought = 1, order_id = ? WHERE id_cos_bilet = ?");

    foreach ($ids_de_confirmat as $id_cos_bilet) {
        $stmtUpdate->execute([$pret, $pret, $order_id, $id_cos_bilet]);
    }
}

    // Selectează codurile biletelor cumpărate pentru acest order și bilet
    $stmtCod = $pdo->prepare("SELECT cod_bilet FROM cos_bilet WHERE id_user = ? AND id_bilet = ? AND isBought = 1 AND order_id = ?");
    $stmtCod->execute([$userId, $id_bilet, $order_id]);
    $bilete_cumparate = $stmtCod->fetchAll(PDO::FETCH_COLUMN);

    $coduri_bilete = $bilete_cumparate;

    $bilete[] = [
        'event_name' => $item['event_name'] ?? '',
        'event_date' => $item['event_date'] ?? '',
        'event_location' => $item['event_location'] ?? '',
        'ticket_name' => $item['type'] ?? '',
        'cantitate' => $de_confirmat,
        'pret_bilet' => $pret,
        'isBought' => 1,
        'cod_bilete' => json_encode($coduri_bilete),
        'order_id' => $order_id
    ];
}


        $_SESSION['tickets_to_download'] = $bilete;
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
