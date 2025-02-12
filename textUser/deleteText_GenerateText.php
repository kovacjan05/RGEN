<?php
session_start();
require_once '../conn_db/connected_database.php';
printf("database ready");
// Ověření, zda je uživatel přihlášen
if (!isset($_SESSION['username'])) {
    http_response_code(401);
    exit("Uživatel není přihlášen.");
}

$username = $_SESSION['username'];

// Získání ID uživatele
$stmt = $conn->prepare("SELECT id FROM slovniky.users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userId = $row['id'];
} else {
    http_response_code(401);
    exit("Uživatel nenalezen.");
}
print_r("uzivatel gut");
// Ověření, zda byl odeslán požadavek na smazání
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    if (!isset($_POST['name']) || empty($_POST['name'])) {
        exit("Chyba: Název textu chybí.");
    }
    print_r("request gut");
    $textName = $_POST['name'];

    // Smazání textu z databáze
    $stmt = $conn->prepare("DELETE FROM slovniky.user_texts WHERE user_id = ? AND name = ?");
    $stmt->bind_param("is", $userId, $textName);

    if ($stmt->execute()) {
        // Aktualizace session, aby se smazaný text neukazoval
        if (($key = array_search($textName, $_SESSION['findTexts'])) !== false) {
            unset($_SESSION['findTexts'][$key]);
        }

        header("Location: ../index.php"); // Přesměrování zpět
        exit("Text úspěšně smazán.");
    } else {
        exit("Chyba při mazání: " . $stmt->error);
    }
}

$stmt->close();
$conn->close();
