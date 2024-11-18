<?php
// Připojení k databázi
echo "Chyba připojení: ";
$conn = new mysqli('localhost', 'root', '', 'usersdb');
if ($conn->connect_error) {
    die("Chyba připojení: " . $conn->connect_error);
}
echo "Chyba připojení: ";
// Získání vstupů z formuláře
$username = $_POST['username'];
$password = $_POST['password'];
echo "Chyba připojení: ";
// Vyhledání uživatele v databázi
$stmt = $conn->prepare("SELECT password_hash FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Ověření hesla
    if (password_verify($password, $row['password_hash'])) {
        echo "Přihlášení úspěšné!";
        // Nastavení session nebo přesměrování
        session_start();
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
    } else {
        echo "Nesprávné heslo.";
    }
} else {
    echo "Uživatel nenalezen.";
}

$conn->close();
?>
