<?php
session_start();
require_once 'dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_event = $_POST['id_event'];
    $name = $_POST['name'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $city = $_POST['city'];
    $type = $_POST['type'];

    // Preluăm imgPath existent
    $stmt = $pdo->prepare("SELECT imgpath FROM event WHERE id_event = ?");
    $stmt->execute([$id_event]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);
    $imgPath = $existing['imgpath'];

    // Actualizare imagine doar dacă a fost trimisă
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $uploadDir = '../IMG/';
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // În baza de date salvăm doar numele fișierului, nu și calea
            $imgPath = $fileName;
        }
}

    // UPDATE
    $stmt = $pdo->prepare("UPDATE event 
        SET name = ?, location = ?, date = ?, description = ?, city = ?, type = ?, imgpath = ?
        WHERE id_event = ?");
    $stmt->execute([$name, $location, $date, $description, $city, $type, $imgPath, $id_event]);

    echo "<script>alert('Eveniment actualizat cu succes!'); window.location.href = '../my_events.php';</script>";
    exit();
}
?>
