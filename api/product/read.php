<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../config/common.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$product = new Product($db);

  
// read products will be here
// query products
$stmt = $product->read();

$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
    $arrayResponse = new Common();
    $returnData = $arrayResponse->response($stmt);    
    http_response_code(200);  
    echo json_encode($returnData);
}
  
// no products found will be here
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}