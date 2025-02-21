<?php
session_start();
$_SESSION['generated_text'] = null;
$_SESSION['text-from-database'] = null;
header("Location: ../index.php");
exit();
