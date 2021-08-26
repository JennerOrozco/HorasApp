<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../common/commonInclude.php';
include_once '../objects/product.php';

$product = new Product($db);

$stmt = $product->read();

$num = $stmt->rowCount();

if ($num > 0) {
    $returnData = $common->response($stmt);

    $common->response200($returnData);
} else {
    $common->response404("No data found.");
}
