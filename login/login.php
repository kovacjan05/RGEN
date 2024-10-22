<?php
session_start(); 

$servername = "localhost";
$username = "root"; 
$password = "";   
$dbname = "uzivatele";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Chyba při připojení: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
 
        $row = $result->fetch_assoc();
        
 
        if (password_verify($pass, $row['password'])) {
            
            $_SESSION['username'] = $user;
            echo "Přihlášení úspěšné! Vítej, " . $user;

        } else {
            
            echo "Nesprávné heslo!";
        }
    } else {
        echo "Uživatelské jméno neexistuje!";
    }

    $stmt->close();
}

$conn->close();
?>