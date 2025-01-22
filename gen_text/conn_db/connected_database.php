<?php
// Nastavení připojení
$servername = 'localhost';
$username = 'root';
$password = 'Rocnikac69';
$dbname = 'slovniky';

// Zkuste se připojit k databázi
$conn = new mysqli($servername, $username, $password, $dbname);

// Ověření připojení
if ($conn->connect_error) {
    die("Chyba připojení k databázi: " . $conn->connect_error);
}
$conn->set_charset("utf8");
