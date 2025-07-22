<?php
require_once 'dbh.inc.php';

$q = trim($_GET['q'] ?? '');
$city = trim($_GET['city'] ?? '');
$limit = intval($_GET['limit'] ?? 3);

$sql = "SELECT * FROM event WHERE 1=1";
$params = [];

if (!empty($q)) {
    $sql .= " AND name LIKE ?";
    $params[] = "%$q%";
}

if (!empty($city)) {
    $sql .= " AND city LIKE ?";
    $params[] = "%$city%";
}

$sql .= " ORDER BY date ASC LIMIT $limit";  // inject direct numărul

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($events) {
    foreach ($events as $event) {
        echo '<div class="search-result-item" style="padding: 10px; border-bottom: 1px solid #eee;">';
        echo '<a href="event.php?id_event=' . $event['id_event'] . '" style="text-decoration: none; color: black;">';
        echo '<strong>' . htmlspecialchars($event['name']) . '</strong><br>';
        echo '<small><i class="fas fa-map-marker-alt"></i> ' . htmlspecialchars($event['city']) . '</small>';
        echo '</a>';
        echo '</div>';
    }
} else {
    echo '<div style="padding: 10px;">Niciun rezultat.</div>';
}
?>