<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../common/commonInclude.php';
include_once '../objects/product.php';

$product = new Product($db);
$productResult = $product->readProducts();

if ($productResult["success"] == true) {    
    $common->response200(array("data" => $productResult["data"]));
} else {
    $common->response404("No data found.");
}
