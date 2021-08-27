<?php
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../common/commonInclude.php';
include_once '../objects/user.php';

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

$common->inputMappingObj($data, $user);

$user->user = substr($data->firstName, 0, -1) . $data->lastName;

$result = $user->create();

if (
    !empty($user->firstName) && !empty($user->company) &&    !empty($user->lastName) &&    !empty($user->email) &&    !empty($user->password) &&   $result["success"] == true
) {
    $common->response200("User was created.");
} else {
    $common->response404("User was not created.");
}
