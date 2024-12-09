<?php


echo "hello";

// Zahrnutí souboru s připojením k databázi
include 'conn_db/connected_database.php';
echo "hello";

// Kontrola, zda je proměnná $conn nastavena
if (!$conn) {
    die("Chyba: Nepodařilo se připojit k databázi.");
}

// Získání vstupů z formuláře
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

// Ověření, že jsou vstupy vyplněny
if (!$username || !$password) {
    die("Chyba: Uživatelské jméno a heslo musí být vyplněné.");
}

// Kontrola, zda uživatel již existuje
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", var: $username);
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


<?php

// echo "hello";

// if (file_exists('db_connect.php')) {
//     include 'db_connect.php';

    
// // Získání vstupů z formuláře
// $username = $_POST['username'];
// $password = $_POST['password'];

// // Kontrola, zda uživatel již existuje
// $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
// $stmt->bind_param("s", $username);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     echo "Uživatel s tímto jménem již existuje.";
// } else {
//     // Hashování hesla
//     $hashed_password = password_hash($password, PASSWORD_BCRYPT);

//     // Vložení nového uživatele
//     $stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
//     $stmt->bind_param("ss", $username, $hashed_password);
//     if ($stmt->execute()) {
//         echo "Registrace úspěšná!";
//     } else {
//         echo "Chyba při registraci: " . $stmt->error;
//     }
// }

// $conn->close();

// }

// else {

//     echo 'Soubor db_connect.php nebyl nalezen.';
// }
?>