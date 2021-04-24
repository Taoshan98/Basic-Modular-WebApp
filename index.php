<?php
include $_SERVER['DOCUMENT_ROOT'] . "/config.php";

// Se l'utente non è loggato lo reindirizzo alla schermata di login
if (!isset($_SESSION['loggedIn'])) {
    header('Location: modules/login');
    exit;
}

if (!isset($_POST['m'])){
    $_POST['m'] = "dashboard";
}

header('Location: modules/' . $_POST['m']);
