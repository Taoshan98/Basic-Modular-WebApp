<?php

$dbConn = '';
include $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$result = $dbConn->query("DELETE FROM `prodotti` WHERE `id` = :id", array("id" => $_GET['id']));
