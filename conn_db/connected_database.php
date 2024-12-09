<?php
echo "Připojení k databázi";

// Nastavení připojení
$servername = 'localhost';
$username = 'root';
$password = 'Rocnikac69';
$dbname = 'db';

// Zkuste se připojit k databázi
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Nastavte vlastnosti PDO, jako je chybový režim (OPTION_EXCEPTION) pro lepší zachycení chyb
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Úspěšně připojeno k databázi";
} catch (PDOException $e) {
    // Pokud se něco pokazí při připojování, zobrazí se chybová zpráva
    echo "Chyba připojení k databázi: " . $e->getMessage();
}
?>