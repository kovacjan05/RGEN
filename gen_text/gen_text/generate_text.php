<?php
// Připojení k databázi
require_once '../conn_db/connected_database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Získání vstupních hodnot
    $vyberJazyk = $_POST['vyber'] ?? '';
    $pocetOdstavcu = intval($_POST['odstavce'] ?? 1);
    $celkovyPocetSlov = intval($_POST['slovaOdstavec'] ?? 50);

    // Kontrola vstupů
    if ($vyberJazyk === '' || $pocetOdstavcu <= 0 || $celkovyPocetSlov <= 0) {
        http_response_code(400); // Chybná data
        exit;
    }

    // Dotaz pro výběr textu z databáze podle jazyka
    $stmt = $conn->prepare("SELECT obsah FROM text WHERE jazyk = ? LIMIT 1");
    $stmt->bind_param("s", $vyberJazyk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(404); // Žádný text nenalezen
        exit;
    }

    $row = $result->fetch_assoc();
    $celaBankaTextu = explode(' ', $row['obsah']); // Rozdělení textu do slov

    // Generování textu
    $vygenerovanyText = '';
    $slovaNaOdstavec = ceil($celkovyPocetSlov / $pocetOdstavcu); // Počet slov na odstavec
    $slovaNaOdstavec = max(1, $slovaNaOdstavec); // Zajištění minimálně jednoho slova na odstavec

    for ($i = 0; $i < $pocetOdstavcu; $i++) {
        $startIndex = rand(0, max(0, count($celaBankaTextu) - $slovaNaOdstavec)); // Náhodný začátek odstavce
        $odstavec = array_slice($celaBankaTextu, $startIndex, $slovaNaOdstavec); // Výběr části textu
        $vygenerovanyText .= '<p>' . implode(' ', $odstavec) . '</p>'; // Vytvoření HTML odstavce
    }

    $stmt->close();
    $conn->close();

    // Vrácení vygenerovaného textu jako JSON
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['text' => $vygenerovanyText]);
    exit;
}
