<?php
// Načtení připojení z connected_database.php
require_once '../conn_db/connected_database.php'; // Ujistěte se, že cesta je správná

if ($conn->connect_error) {
    die("Chyba připojení k databázi: " . $conn->connect_error);
}

// Kontrola, zda jsou data odeslána metodou POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Vyhledání uživatele v databázi
        $stmt = $conn->prepare("SELECT password FROM slovniky.users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Ověření hesla bez hashování
            if ($password === $row['password']) {  // Přímé porovnání hesel bez hashování
                // Přihlášení úspěšné

                //echo " <br><br>vitej";
                session_start();
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit;
            } else {
                echo "Nesprávné heslo.";
            }
        } else {
            echo "Uživatel nenalezen.";
        }

        $stmt->close(); // Zavřít statement
    } else {
        echo "Prosím vyplňte všechna pole.";
    }
} else {
    echo "Nepovolený přístup.";
}

// Zavření připojení
$conn->close();
