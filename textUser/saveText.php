<?php
session_start();
require_once '../conn_db/connected_database.php';

if (!isset($_SESSION['username'])) {
    echo json_encode(["status" => "error", "message" => "Uživatel není přihlášen."]);
    exit();
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
    echo json_encode(["status" => "error", "message" => "Uživatel nenalezen."]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['Textname'])) {
        echo json_encode(["status" => "error", "message" => "Název textu je povinný."]);
        exit();
    }

    if (empty($_SESSION['editor_content'])) {
        echo json_encode(["status" => "error", "message" => "Obsah článku nesmí být prázdný."]);
        exit();
    }

    $name = trim($_POST['Textname']);
    $text_content = json_encode($_SESSION['editor_content']);

    // Ověření, zda už existuje text se stejným názvem
    $stmt = $conn->prepare("SELECT id FROM slovniky.user_texts WHERE user_id = ? AND name = ?");
    $stmt->bind_param("is", $userId, $name);
    $stmt->execute();

    if ($stmt->get_result()->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Název textu už je jednou uložen."]);
        header("Location: ../textUser/findText.php");
        exit();
    }

    // Uložení do databáze
    $stmt = $conn->prepare("INSERT INTO slovniky.user_texts (user_id, name, text_content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $userId, $name, $text_content);

    if ($stmt->execute()) {
        $_SESSION['text-from-database'] = null;
        $_SESSION['generated_text'] = null;
        echo json_encode(["status" => "success", "message" => "Text byl úspěšně uložen."]);
        header("Location: ../textUser/findText.php");
        exit();
    } else {
        echo json_encode(["status" => "error", "message" => "Chyba při ukládání do databáze."]);
        header("Location: ../textUser/findText.php");
        exit();
    }
    header("Location: ../textUser/findText.php");
}

$conn->close();
