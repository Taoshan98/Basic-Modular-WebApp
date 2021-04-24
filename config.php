<?php
session_start();
include "includes/helperFunctions.php";
define('APP_PATH_HTML', $_SERVER['DOCUMENT_ROOT'] . "/");

/** Database Configuration */
require_once(APP_PATH_HTML . "classes/database/Database.php");
$dbConn = new Database('ip', 'dbname', 'dbuser', 'dbpass');
