<?php
// Spuštění session
session_start();

// Připojení k databázi
require_once '../conn_db/connected_database.php';

// Ověření, zda je uživatel přihlášen

$username = $_SESSION['username'];

// Získání ID uživatele
$stmt = $conn->prepare("SELECT id FROM slovniky.users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userId = $row['id'];
} else {
    http_response_code(401);
    exit("Uživatel nenalezen.");
}

echo "ID uživatele: $userId <br>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['name']) || empty($_POST['name'])) {
        //header("Location: ../index.php");
        exit("pepi nadpis");
    }

    if (!isset($_SESSION['editor_content2']) || empty($_SESSION['editor_content2'])) {
        //header("Location: ../index.php");
        print_r($_SESSION['editor_content2']);
        exit("Obsah článku nesmí být prázdný.");
    }



    $name = $_POST['name'];
    $text_content = json_encode($_SESSION['editor_content2']);

    // Uložení do databáze
    $stmt = $conn->prepare("INSERT INTO slovniky.user_texts (user_id, name, text_content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $userId, $name, $text_content);

    if ($stmt->execute()) {
        header("Location: findText.php");
        exit("nende to");
    } else {
        exit("Chyba při ukládání do databáze: " . $stmt->error);
    }
}
