<?php
$dbConn = '';
include $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$ordini = $dbConn->query("SELECT * FROM `ordine`");
$prodotti = $dbConn->query("SELECT * FROM `prodotti`");
$operatori = $dbConn->query("SELECT * FROM `operatori`");

$arrayIdProdotti = array_column($prodotti, 'id');
$arrayIdOperatori = array_column($operatori, 'id');

$arrayReturn = array();
foreach ($ordini as $ordine) {

    $operatore = $operatori[array_search($ordine['id_operatore'], $arrayIdOperatori, true)];
    $prodotto = $prodotti[array_search($ordine['id_prodotto'], $arrayIdProdotti, true)];

    $arrayReturn[] = array(
        $ordine['id'],
        $operatore['nome'] . " " . $operatore['cognome'],
        $prodotto['descrizione'],
        $ordine['quantita'],
        "€ " . number_format($ordine['quantita'] * $prodotto['costo_unitario'], 2),
        explode(" ", $ordine['created_at'])[0]
    );
}

echo json_encode($arrayReturn);
