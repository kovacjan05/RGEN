<?php
session_start();
require_once '../conn_db/connected_database.php';

// Reset obou session proměnných
$_SESSION['generated_text'] = null;
$_SESSION['text-from-database'] = null;

// 1️⃣ Pokud se odeslal formulář pro generování textu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['odstavce'], $_POST['slovaOdstavec'])) {
    $pocetOdstavcu = (int)$_POST['odstavce'];
    $slovaOdstavec = (int)$_POST['slovaOdstavec'];

    if ($pocetOdstavcu > 0 && $slovaOdstavec > 0) {
        $vybranyJazyk = $_POST['vyber'] ?? null;
        $index = null;

        switch ($vybranyJazyk) {
            case "čeština":
                $index = 1;
                break;
            case "pravnická čeština":
                $index = 2;
                break;
            case "latina":
                $index = 3;
                break;
            case "němčina":
                $index = 4;
                break;
            case "angličtina":
                $index = 5;
                break;
            case "slovenština":
                $index = 6;
                break;
            case "čapkova čeština":
                $index = 1;
                break;
            default:
                $_SESSION['generated_text'] = ["Neplatná volba jazyka!"];
                header("Location: ../index.php");
                exit;
        }

        $sql = "SELECT obsah FROM slovniky.text WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $index);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $fullText = $row['obsah'];

            $words = explode(" ", $fullText);
            $totalWords = count($words);
            $generatedParagraphs = [];
            $wordIndex = 0;

            for ($i = 0; $i < $pocetOdstavcu; $i++) {
                $paragraphWords = [];

                for ($j = 0; $j < $slovaOdstavec; $j++) {
                    if ($wordIndex >= $totalWords) {
                        $wordIndex = 0;
                    }
                    $paragraphWords[] = $words[$wordIndex];
                    $wordIndex++;
                }

                $generatedParagraphs[] = implode(" ", $paragraphWords);
            }

            $_SESSION['generated_text'] = $generatedParagraphs;
        } else {
            $_SESSION['generated_text'] = ["Žádný text nebyl nalezen pro zvolený jazyk."];
        }

        $_SESSION["saveText"] = $_SESSION['generated_text'];
        $stmt->close();
    } else {
        $_SESSION['generated_text'] = ["Chybné zadání parametrů!"];
    }
}

// 2️⃣ Pokud se odeslal formulář s "loadText", načte text z databáze

$userId = $_SESSION['userId']; // Získání user ID

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loadText'], $_POST['name'])) {
    $textName = $_POST['name'];

    // 1️⃣ Nejprve získáme všechny texty, které má uživatel uložené
    $stmt = $conn->prepare("SELECT name FROM slovniky.user_texts WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $userTexts = [];
    while ($row = $result->fetch_assoc()) {
        $userTexts[] = $row['name'];
    }
    $stmt->close();

    // 2️⃣ Ověříme, zda daný text patří tomuto uživateli
    if (in_array($textName, $userTexts)) {
        // 3️⃣ Pokud ano, načteme obsah textu
        $stmt = $conn->prepare("SELECT text_content FROM slovniky.user_texts WHERE name = ? AND user_id = ?");
        $stmt->bind_param("si", $textName, $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['text-from-database'] = json_decode($row['text_content'], true);
        } else {
            $_SESSION['text-from-database'] = "<p>Text nenalezen.</p>";
        }

        $stmt->close();
    } else {
        $_SESSION['text-from-database'] = "<p>Nemáte uložený žádný text s tímto názvem.</p>";
    }
}

$conn->close();
header("Location: ../index.php");
exit;
