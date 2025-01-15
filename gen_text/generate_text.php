<?php
// Připojení k databázi
require_once '../conn_db/connected_database.php';

// Nastavení znakové sady na UTF-8


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Získání vstupních hodnot
    $vyberJazyk = $_POST['vyber'] ?? '';
    $pocetOdstavcu = intval($_POST['odstavce'] ?? 1);
    $slovaNaOdstavec = intval($_POST['slovaOdstavec'] ?? 50);

    // Dotaz pro výběr textů z databáze
    $stmt = $conn->prepare("SELECT text FROM slovniky WHERE jazyk = ? ORDER BY RAND() LIMIT ?");
    $stmt->bind_param("si", $vyberJazyk, $pocetOdstavcu);
    $stmt->execute();
    $result = $stmt->get_result();

    $vygenerovanyText = '';

    while ($row = $result->fetch_assoc()) {
        $text = explode(' ', $row['slovniky']);
        $odstavec = array_slice($text, 0, $slovaNaOdstavec);
        $vygenerovanyText .= '<p>' . implode(' ', $odstavec) . '</p>';
    }

    $stmt->close();
    $conn->close();

    // Vrácení vygenerovaného textu jako JSON pro zobrazení na stránce
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['text' => $vygenerovanyText]);
    exit;
}
