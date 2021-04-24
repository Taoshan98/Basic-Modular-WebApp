<?php
$dbConn = '';
include $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$arrayCredentials = array(
    "username" => ($_POST['username'] ?? null),
    "password" => ($_POST['password'] ?? null)
);

$return = json_encode(["isVerified" => false]);

//i campi email e password sono obbligatori, quindi li valido anche lato server
if (!empty($_POST['password']) || !empty($_POST['username'])) {

    if ($_POST['typeAction'] === "login"){
        $result = $dbConn->query("SELECT `username`, `password` FROM `users` WHERE `username` = :username AND `password` = :password",
            array("username" => $arrayCredentials['username'], "password" => hashPassword($arrayCredentials['password'])));
    }else{
        $result = $dbConn->query("INSERT INTO `users` (`username`, `password`) VALUES (:username,:password)",
            array("username" => $arrayCredentials['username'], "password" => hashPassword($arrayCredentials['password'])));
    }

    if (!empty($result)) {
        $_SESSION['loggedIn'] = true;
        $return = json_encode(["isVerified" => true]);
    }

    echo $return;
}
