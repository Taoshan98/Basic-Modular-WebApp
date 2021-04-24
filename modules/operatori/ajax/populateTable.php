<?php
$dbConn = '';
include $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$operatori = $dbConn->query("SELECT * FROM `operatori`");

$operatori = array_map(function ($operatore) {
    return [$operatore['id'], $operatore['nome'], $operatore['cognome']];
}, $operatori);

echo json_encode($operatori);
