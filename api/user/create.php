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

$user->firstName = $data->firstName;
$user->lastName = $data->lastName;
$user->company = $data->company;
$user->email = $data->email;
$user->password = $data->password;
$user->user = substr($data->firstName, 0, -1) . $data->lastName;

if (
    !empty($user->firstName) && !empty($user->company) &&    !empty($user->lastName) &&    !empty($user->email) &&    !empty($user->password) &&    $user->create()
) {
    $common->response200("User was created.");
} else {
    $common->response404("User was not created.");
}
