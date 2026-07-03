<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['lang'])) {

    if ($_GET['lang'] == 'ar' || $_GET['lang'] == 'en') {
        $_SESSION['lang'] = $_GET['lang'];
    }
}

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = "ar";
}

$langcod = $_SESSION['lang'];

$languageFile = __DIR__ . "/languages/" . $langcod . ".php";

if (file_exists($languageFile)) {
    include $languageFile;
} else {
    include __DIR__ . "/languages/ar.php";
}