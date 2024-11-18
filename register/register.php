<?php

// Připojení k databázi

$conn = new mysqli('localhost', 'root', 'Rocnikac69', 'db');
echo "hello";
if ($conn->connect_error) {
    die("Chyba připojení: " . $conn->connect_error);
}
echo "hello";

// Získání vstupů z formuláře
$username = $_POST['username'];
$password = $_POST['password'];

// Kontrola, zda uživatel již existuje
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Uživatel s tímto jménem již existuje.";
} else {
    // Hashování hesla
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Vložení nového uživatele
    $stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);
    if ($stmt->execute()) {
        echo "Registrace úspěšná!";
    } else {
        echo "Chyba při registraci: " . $stmt->error;
    }
}

$conn->close();
?>
