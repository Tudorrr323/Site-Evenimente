<?php
require_once 'dbh.inc.php';

$q = trim($_GET['q'] ?? '');
$city = trim($_GET['city'] ?? '');
$limit = intval($_GET['limit'] ?? 3);

$today = date('Y-m-d');

// Pornim query-ul cu join pe categorii (presupunem tabelă event_categories și categories)
$sql = "
    SELECT DISTINCT e.*
    FROM event e
    LEFT JOIN event_categories ec ON e.id_event = ec.id_event
    LEFT JOIN categories c ON ec.id_cat = c.id_cat
    WHERE (e.date >= ? OR c.denumire = ?)
";

$params = [$today, 'Film'];

if (!empty($q)) {
    $sql .= " AND e.name LIKE ?";
    $params[] = "%$q%";
}

if (!empty($city)) {
    $sql .= " AND e.city LIKE ?";
    $params[] = "%$city%";
}

$sql .= " ORDER BY e.date ASC LIMIT $limit";

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
