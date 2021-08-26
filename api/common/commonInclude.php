<?php
include_once '../config/database.php';
include_once '../config/common.php';

$database = new Database();
$db = $database->getConnection();
$common = new Common();
