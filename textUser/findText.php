<?php
session_start();
require_once '../conn_db/connected_database.php';

// Ověření, zda je uživatel přihlášen
if (!isset($_SESSION['username'])) {
    http_response_code(401);
    exit("Uživatel není přihlášen.");
}

$username = $_SESSION['username'];

// Získání ID uživatele
$stmt = $conn->prepare("SELECT id FROM slovniky.users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userId = $row['id'];
    $_SESSION['userId'] = $userId;
} else {
    http_response_code(401);
    exit("Uživatel nenalezen.");
}

// Načtení **pouze názvů** textů
$stmt = $conn->prepare("SELECT name FROM slovniky.user_texts WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$_SESSION['findTexts'] = [];

while ($row = $result->fetch_assoc()) {
    $_SESSION['findTexts'][] = $row['name']; // uklada se pouze jméno textu
    print_r($row['name']);
}
print_r("///////////////////////////////////////////");
print_r($_SESSION['findTexts']);
$stmt->close();
$conn->close();
header("Refresh:3");
header("Location: ../index.php");
exit();
