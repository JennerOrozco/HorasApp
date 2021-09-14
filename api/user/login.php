<?php
include_once '../common/commonHeaderPOST.php';
include_once '../objects/user.php';
include_once '../common/commonIncludeJWT.php';
include_once '../common/commonInclude.php';

use \Firebase\JWT\JWT;

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
