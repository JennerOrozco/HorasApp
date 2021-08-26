<?php
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once 'validateToken.php';
$data = json_decode(file_get_contents("php://input"));


$validate = validateToken($data->jwt, $key);

if ($validate['status'] == true) {

    echo "Correcto";
} else {
    echo "Fail";
}
