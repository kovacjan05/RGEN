<?php
// Zahrnutí souboru s připojením k databázi
require_once '../conn_db/connected_database.php';  // Opravená cesta k souboru připojení k databázi

// Kontrola, zda je připojení platné
if (!$conn) {
    die("Chyba: Nepodařilo se připojit k databázi.");
}

// Získání vstupů z formuláře
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;
$firstname = $_POST['firstname'] ?? null;
$lastname = $_POST['lastname'] ?? null;

// Ověření, že jsou vstupy vyplněny
if (!$username || !$password || !$firstname || !$lastname) {
    die("Chyba: Všechna pole musí být vyplněná.");
}

// Kontrola, zda uživatel již existuje
$stmt = $conn->prepare("SELECT * FROM slovniky.users WHERE username = ?");
$stmt->bind_param("s", $username);  // Parametr typu string pro username
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Uživatel s tímto jménem již existuje.";
} else {
    // Hashování hesla
    //$hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Vložení nového uživatele
    $stmt = $conn->prepare("INSERT INTO slovniky.users (username, password, firstName, lastName) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $firstname, $lastname);  // Parametry typu string pro všechny sloupce
    if ($stmt->execute()) {
        echo "Registrace úspěšná!";
    } else {
        echo "Chyba při registraci: " . $stmt->error;
    }
}

$conn->close();
