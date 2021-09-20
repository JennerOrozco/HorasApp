<?php
include_once __DIR__ . '/commonVariables.php';
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/class/crud.php';


$database = new Database($db_var_host, $db_var_db_name, $db_var_username, $db_var_password);

$db = $database->getConnection();
$common = new CRUD();
