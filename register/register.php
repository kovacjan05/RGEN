<?php
session_start();
require_once '../conn_db/connected_database.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($firstname) || empty($lastname) || empty($username) || empty($password)) {
        $errors[] = 'Všechna pole musí být vyplněna.';
        $_SESSION['registrError'] = true;
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = 'Uživatelské jméno již existuje.';
        } else {

            $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, username, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $firstname, $lastname, $username, $password);

            if ($stmt->execute()) {
                $success = 'Registrace byla úspěšná!';
            } else {
                $errors[] = 'Nastala chyba při ukládání do databáze.';
            }
        }
    }
}

// Uložení zpráv do SESSION a přesměrování
echo "<script>console.log('$errors.');</script>";
echo "<script>console.log('$success.');</script>";
$_SESSION['errors'] = $errors;
$_SESSION['success'] = $success;
header('Location: ../index.php');
exit;
