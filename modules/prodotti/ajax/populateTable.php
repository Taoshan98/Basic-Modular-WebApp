<?php
$dbConn = '';
include $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$prodotti = $dbConn->query("SELECT * FROM `prodotti`");

$prodotti = array_map(function ($prodotto) {
    return [$prodotto['id'], $prodotto['descrizione'], "€ " . number_format($prodotto['costo_unitario'], 2)];
}, $prodotti);

echo json_encode($prodotti);
