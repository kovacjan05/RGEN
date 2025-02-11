<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['id']) && isset($_POST['name'])) {
        $id = (int) $_POST['id']; // Konverze na integer pro bezpečnost
        $textName = $_POST['name'];

        if (isset($_POST['load'])) {
            // Uložení aktuálně načteného textu do session
            $_SESSION['current_text'] = $textName;
            header("Location: editor.php"); // Přesměrování na editor
            exit();
        }

        if (isset($_POST['delete'])) {
            // Kontrola, jestli existuje klíč v session
            if (isset($_SESSION['textNames'][$id])) {
                unset($_SESSION['textNames'][$id]);
                $_SESSION['textNames'] = array_values($_SESSION['textNames']); // Přeuspořádání pole
            }
            header("Location: ../index.php"); // Přesměrování zpět
            exit();
        }
    }
}
