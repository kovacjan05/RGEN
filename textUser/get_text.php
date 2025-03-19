<?php
session_start();

// Pole pro odpověď
$response = [];

// Pokud je v session generovaný text
if (!empty($_SESSION['generated_text'])) {
    $response['generated_text'] = $_SESSION['generated_text'];
}

// Pokud je v session text z databáze
if (!empty($_SESSION['text-from-database'])) {
    $response['text_from_database'] = $_SESSION['text-from-database'];
}

// Pokud není žádný text
if (empty($response)) {
    $response['error'] = "Žádný text nebyl nalezen.";
}

// Nastavení hlavičky pro JSON
header('Content-Type: application/json');

// Odeslání odpovědi
echo json_encode($response);
exit;
