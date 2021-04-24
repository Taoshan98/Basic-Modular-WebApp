<?php

$dbConn = '';
include $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$return = ['saved' => false];

if (!empty($_POST['id_operatore']) && !empty($_POST['id_prodotto']) && !empty($_POST['quantita'])){

    $date = new DateTime();
    $created_at = $date->format('Y-m-d H:i:s');

    $arrayToSave = array(
        "id_operatore" => $_POST['id_operatore'],
        "id_prodotto" => $_POST['id_prodotto'],
        "quantita" => $_POST['quantita'],
        "created_at" => $created_at
    );

    if ($_GET['typeView'] === "add") {
        $result = $dbConn->query("
        INSERT INTO `ordine` (`id_operatore`, `id_prodotto`, `quantita`, `created_at`) 
        VALUES (:id_operatore,:id_prodotto, :quantita, :created_at)", $arrayToSave);
    } else {
        $result = $dbConn->query("
        UPDATE `ordine` 
        SET 
            `id_operatore` = :id_operatore,
            `id_prodotto` = :id_prodotto,
            `quantita` = :quantita,
            `created_at` = :created_at
        WHERE `id`= :id",
            array_merge(
                $arrayToSave,
                array("id" => $_GET['id']
                )
            )
        );
    }

    $return = ['saved' => true];
}

echo json_encode($return);
