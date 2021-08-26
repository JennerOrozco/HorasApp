<?php
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../objects/user.php';
include_once '../common/commonIncludeJWT.php';

use \Firebase\JWT\JWT;

include_once '../common/commonInclude.php';

$data = json_decode(file_get_contents("php://input"));

$user = new User($db);

$user->email = $data->email;

$email_exists = $user->emailExists();


if ($email_exists && password_verify($data->password, $user->password)) {

    $token = array(
        "iat" => $issued_at,
        "exp" => $expiration_time,
        "iss" => $issuer,
        "data" => $common->objectToResponse("id,firstName,lastName,email", $user)
    );

    $jwt = JWT::encode($token, $key);

    $Response = array(
        "message" => "Successful login.",
        "jwt" => $jwt
    );

    $common->response200($Response);
} else {
    $common->response404("Login failed.");
}
