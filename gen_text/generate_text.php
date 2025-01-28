<?php
// require_once '../conn_db/connected_database.php';

// $generatedText = "";

// $pocetOdstavcu = $_POST['odstavce'] ?? null;
// $celkovyPocetSlov = $_POST['slovaOdstavec'] ?? null;

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pocetOdstavcu >= 1 && $celkovyPocetSlov >= 1) {

//     $vybranyJazyk = $_POST['vyber'] ?? null;

//     echo " pocet odstavcu = $pocetOdstavcu, celkovy pocet slov = $celkovyPocetSlov, vybrany jazyk = $vybranyJazyk";


//     $index = null;

//     switch ($vybranyJazyk) {
//         case "čeština":
//             $index = 1;
//             break;
//         case "pravnická čeština":
//             $index = 2;
//             break;
//         case "latina":
//             $index = 3;
//             break;
//         case "němčina":
//             $index = 4;
//             break;
//         case "angličtina":
//             $index = 5;
//             break;
//         case "slovenština":
//             $index = 6;
//             break;
//         case "čapkova čeština":
//             $index = 1;
//             break;
//         default:
//             echo json_encode(['error' => "Neplatná volba jazyka!"]);
//             exit;
//     }


//     echo "index = $index";

//     $sql = "SELECT obsah FROM slovniky.text WHERE id = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("i", $index);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows > 0) {
//         // Uložení vygenerovaného textu
//         $row = $result->fetch_assoc();
//         $generatedText = $row['obsah'];
//         echo $row['obsah'];
//         $_SESSION['generated_text'] = $generatedText;
//     } else {
//         $generatedText = "Žádný text nebyl nalezen pro zvolený jazyk.";
//     }

//     $stmt->close();
// } else {
//     echo "problem (tento error vymazat)";
// }

// $conn->close();
// echo $generatedText;

// //header('Content-Type: application/json; charset=utf-8');
// //echo json_encode(['text' => $generatedText]);
// exit;
?>



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

        // Rozdělení textu na slova
        $words = explode(" ", $fullText);
        $totalWords = count($words);

        // Vytvoření odstavců
        $paragraphs = [];
        $wordsPerParagraph = max(1, floor($totalWords / $pocetOdstavcu)); // Počet slov na odstavec

        for ($i = 0; $i < $pocetOdstavcu; $i++) {


            $startIndex = $i * $wordsPerParagraph;
            $paragraphWords = array_slice($words, $startIndex, $wordsPerParagraph);


            if (empty($paragraphWords)) break;
            $paragraphs[] = implode(" ", $paragraphWords);
        }

        $generatedText = implode("\n\n", $paragraphs); // Odstavce oddělené prázdným řádkem
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
