<?php
session_start();
require_once '../conn_db/connected_database.php';

if (!isset($_SESSION['username']) || !isset($_POST['name'])) {
    exit("error");
}

$username = $_SESSION['username'];
$name = trim($_POST['name']);

// Získání ID uživatele
$stmt = $conn->prepare("SELECT id FROM slovniky.users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    exit("error");
}

$row = $result->fetch_assoc();
$userId = $row['id'];

// Kontrola, jestli už existuje text se stejným názvem
$stmt = $conn->prepare("SELECT id FROM slovniky.user_texts WHERE user_id = ? AND name = ?");
$stmt->bind_param("is", $userId, $name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    exit("duplicate"); // Název už existuje
}

exit("ok"); // Název je volný
