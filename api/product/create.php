<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../common/commonInclude.php';
include_once '../objects/product.php';

$product = new Product($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->name) &&    !empty($data->price) &&    !empty($data->description) &&    !empty($data->category_id)
) {

    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->category_id = $data->category_id;
    $product->created = date('Y-m-d H:i:s');

    if ($product->create()) {
        $common->response200("Product was created.");
    } else {
        $common->response503("Unable to create product.");
    }
} else {
    $common->response404("Unable to create product. Data is incomplete.");
}
