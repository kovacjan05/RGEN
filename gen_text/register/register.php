<?php
session_start();
require_once '../conn_db/connected_database.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Input validation
    if (empty($firstname) || empty($lastname) || empty($username) || empty($password)) {
        $errors[] = 'Všechna pole musí být vyplněna.';
    } elseif (strlen($password) < 8) {
        $errors[] = 'Heslo musí mít alespoň 8 znaků.';
    }

    if (empty($errors)) {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = 'Uživatelské jméno již existuje.';
        } else {
            // Insert data into the database with hashed password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, username, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $firstname, $lastname, $username, $hashed_password);

            if ($stmt->execute()) {
                $success = 'Registrace byla úspěšná!';
            } else {
                $errors[] = 'Nastala chyba při ukládání do databáze.';
            }
        }
    }

    // Send JSON response
    if (!empty($errors)) {
        echo json_encode(['errors' => $errors]);
    } else {
        echo json_encode(['success' => $success]);
    }
    exit;
}
