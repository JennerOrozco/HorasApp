<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../config/common.php';


$database = new Database();

$db = $database->getConnection();

$product = new Product($db);

$stmt = $product->read();

$num = $stmt->rowCount();

$common = new Common();

if ($num > 0) {
    $returnData = $common->response($stmt);

    $common->response200($returnData);
} else {
    $common->response404("No data found.");
}
