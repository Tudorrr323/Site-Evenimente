<?php
session_start();
require_once 'dbh.inc.php';

// Verificare login
if (!isset($_SESSION["user_fname"])) {
    header("Location: login.php");
    exit();
}

// Preluare id_bilet din GET și validare
if (!isset($_GET['id_bilet']) || !is_numeric($_GET['id_bilet'])) {
    die("ID bilet invalid.");
}

$id_bilet = (int)$_GET['id_bilet'];

// Ștergere bilet din baza de date
$stmt = $pdo->prepare("DELETE FROM bilet WHERE id_bilet = ?");
$stmt->execute([$id_bilet]);

// Redirecționare spre pagina evenimentelor
header("Location: ../my_events.php");
exit();
?>
