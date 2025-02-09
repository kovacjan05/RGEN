<?php
// Spuštění session
session_start();

// Připojení k databázi (nahraďte podle vašeho nastavení)
require_once 'db_connection.php'; // Soubor pro připojení k DB

// Získání dat ze session
$user_id = $_SESSION['user_id'];
$text_content = $_SESSION['generateText'];

// Získání názvu textu z POST dat
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['name']) && !empty($data['name'])) {
    $name = $data['name'];

    // SQL dotaz pro vložení dat
    $stmt = $pdo->prepare("INSERT INTO user_text (user_id, name, text_content) VALUES (?, ?, ?)");
    if ($stmt->execute([$user_id, $name, $text_content])) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Chyba při vkládání do databáze."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Název textu je prázdný."]);
}
