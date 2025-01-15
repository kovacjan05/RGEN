<?php
require_once '../conn_db/connected_database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        http_response_code(400); // Chybná data
        exit;
    }

    $stmt = $conn->prepare("SELECT password FROM slovniky.users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            session_start();
            $_SESSION['username'] = $username;
            http_response_code(200); // Přihlášení úspěšné
        } else {
            http_response_code(401); // Nesprávné heslo
        }
    } else {
        http_response_code(401); // Uživatel nenalezen
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405); // Metoda není povolena
    exit;
}
