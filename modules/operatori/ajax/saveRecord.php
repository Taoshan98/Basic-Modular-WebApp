<?php

$dbConn = '';
include $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$return = ['saved' => false];

if (!empty($_POST['nome']) && !empty($_POST['cognome'])) {

    $date = new DateTime();
    $created_at = $date->format('Y-m-d H:i:s');

    $arrayToSave = array(
        "nome" => $_POST['nome'],
        "cognome" => $_POST['cognome'],
        "created_at" => $created_at
    );

    if ($_GET['typeView'] === "add") {

        $result = $dbConn->query("
        INSERT INTO `operatori` (`nome`, `cognome`, `created_at`) 
        VALUES (:nome,:cognome, :created_at)", $arrayToSave);

    } else {

        $result = $dbConn->query("
        UPDATE `operatori` 
        SET 
            `nome` = :nome,
            `cognome` = :cognome,
            `created_at` = :created_at
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
