<?php
session_start();
require_once '../conn_db/connected_database.php';

$generatedText = "";

$pocetOdstavcu = $_POST['odstavce'] ?? null;
$celkovyPocetSlov = $_POST['slovaOdstavec'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pocetOdstavcu >= 1 && $celkovyPocetSlov >= 1) {

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
            $_SESSION['generated_text'] = "Neplatná volba jazyka!";
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

        $paragraphs = [];
        $wordsPerParagraph = max(1, floor($totalWords / $pocetOdstavcu));

        for ($i = 0; $i < $pocetOdstavcu; $i++) {


            $startIndex = $i * $wordsPerParagraph;
            $paragraphWords = array_slice($words, $startIndex, $wordsPerParagraph);


            if (empty($paragraphWords)) break;
            $paragraphs[] = implode(" ", $paragraphWords);
        }

        $generatedText = implode("\n\n\n", $paragraphs);
    } else {
        $generatedText = "Žádný text nebyl nalezen pro zvolený jazyk.";
    }

    $_SESSION['generated_text'] = $generatedText;
    $stmt->close();
} else {
    $_SESSION['generated_text'] = "Chybné zadání parametrů!";
}

$conn->close();
header("Location: ../index.php");
exit;
