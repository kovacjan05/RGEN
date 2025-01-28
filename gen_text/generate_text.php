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
// exit;<?php




session_start();
require_once '../conn_db/connected_database.php';

$generatedText = "";

// Získání vstupních dat z formuláře
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
            $_SESSION['error_message'] = "Neplatná volba jazyka!";
            header("Location: ../index.php");
            exit;
    }

    // Vyhledání textu na základě jazyka
    $sql = "SELECT obsah FROM slovniky.text WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $index);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $text = $row['obsah'];

        // Generování požadovaného textu
        $words = explode(" ", $text);
        $totalWords = count($words);
        $generatedText = "";

        // Rozdělení textu na požadovaný počet odstavců a slov
        $wordCounter = 0;
        for ($i = 0; $i < $pocetOdstavcu; $i++) {
            $paragraph = "";
            for ($j = 0; $j < $celkovyPocetSlov; $j++) {
                if ($wordCounter >= $totalWords) {
                    $wordCounter = 0; // Reset při nedostatku slov
                }
                $paragraph .= $words[$wordCounter++] . " ";
            }
            $generatedText .= trim($paragraph) . "\n\n"; // Přidání prázdného řádku mezi odstavce
            //echo $generatedText;
        }
    } else {
        $generatedText = "Žádný text nebyl nalezen pro zvolený jazyk.";
    }

    $_SESSION['generated_text'] = $generatedText;
    $stmt->close();
} else {
    $_SESSION['error_message'] = "Zadejte platné hodnoty pro počet odstavců a počet slov.";
}

$conn->close();

// Přesměrování zpět na hlavní stránku
header("Location: ../index.php");
exit;
