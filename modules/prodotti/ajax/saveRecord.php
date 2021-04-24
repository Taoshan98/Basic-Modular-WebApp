<?php

$dbConn = '';
include $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$return = ['saved' => false];

if (!empty($_POST['descrizione']) && !empty($_POST['costo_unitario'])) {

    $arrayToSave = array(
        "descrizione" => $_POST['descrizione'],
        "costo_unitario" => $_POST['costo_unitario'],
    );

    if ($_GET['typeView'] === "add") {

        $result = $dbConn->query("
        INSERT INTO `prodotti` (`descrizione`, `costo_unitario`) 
        VALUES (:descrizione,:costo_unitario)", $arrayToSave);

    } else {

        $result = $dbConn->query("
        UPDATE `prodotti` 
        SET 
            `descrizione` = :descrizione,
            `costo_unitario` = :costo_unitario
        WHERE `id`= :id",
            array_merge(
                $arrayToSave,
                array(
                    "id" => $_GET['id']
                )
            )
        );

    }

    $return = ['saved' => true];

}

echo json_encode($return);
