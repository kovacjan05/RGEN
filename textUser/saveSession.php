<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["content"])) {
    $_SESSION["editor_content"] = $_POST["content"]; // NE base64!
    echo "Uloženo do session";
}

// Pokud existuje uložený obsah, předáme ho do editoru
$editorContent = isset($_SESSION["editor_content"]) ? $_SESSION["editor_content"] : "";
