<?php
session_start();
require_once '../conn_db/connected_database.php';

$pocetOdstavcu = isset($_POST['odstavce']) ? (int)$_POST['odstavce'] : 0;
$slovaOdstavec = isset($_POST['slovaOdstavec']) ? (int)$_POST['slovaOdstavec'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pocetOdstavcu > 0 && $slovaOdstavec > 0) {
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

$conn->close();
header("Location: ../index.php");
exit;
