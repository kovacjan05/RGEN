<?php
session_start();

try {
    // Připojení k SQLite databázi
    $database = new PDO('sqlite:db/usersDB.db');
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        // SQL dotaz pro výběr uživatele
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $database->prepare($sql);
        $stmt->bindParam(':username', $user, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Ověření hesla
            if (password_verify($pass, $row['password'])) {
                // Vytvoření session
                $_SESSION['username'] = $user;
                echo "Přihlášení úspěšné! Vítej, " . $user;
            } else {
                echo "Nesprávné heslo!";
            }
        } else {
            echo "Uživatelské jméno neexistuje!";
        }
    }
} catch (PDOException $e) {
    echo "Chyba připojení: " . $e->getMessage();
}
