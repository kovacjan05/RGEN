<?php
session_start();
require_once '../conn_db/connected_database.php';

if (!isset($_SESSION['username'])) {
    exit("error: Uživatel není přihlášen.");
}

$username = $_SESSION['username'];

// Získání ID uživatele
$stmt = $conn->prepare("SELECT id FROM slovniky.users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $userId = $row['id'];
} else {
    exit("error: Uživatel nenalezen.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['Textname'])) {
        exit("error: Název textu je povinný.");
    }

    if (empty($_SESSION['editor_content'])) {
        exit("error: Obsah článku nesmí být prázdný.");
    }

    $name = trim($_POST['Textname']);
    $text_content = json_encode($_SESSION['editor_content']);

    // Ověření, zda už existuje text se stejným názvem
    $stmt = $conn->prepare("SELECT id FROM slovniky.user_texts WHERE user_id = ? AND name = ?");
    $stmt->bind_param("is", $userId, $name);
    $stmt->execute();

    if ($stmt->get_result()->num_rows > 0) {
        header("Location: ../textUser/findText.php");
        exit("error: Text s tímto názvem už máte uložený.");
    }

    // Uložení do databáze
    $stmt = $conn->prepare("INSERT INTO slovniky.user_texts (user_id, name, text_content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $userId, $name, $text_content);

    if ($stmt->execute()) {
        $_SESSION['text-from-database'] = null;
        $_SESSION['generated_text'] = null;
        exit("success");
    } else {
        exit("error: Chyba při ukládání do databáze.");
    }
}

$conn->close();
