<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["content"])) {
    $_SESSION["editor_content"] = $_POST["content"];
    echo "Uloženo do session";
}

// Pokud existuje uložený obsah, předá se do editoru
$editorContent = isset($_SESSION["editor_content"]) ? $_SESSION["editor_content"] : "";
