<?php
include_once __DIR__ . '/../../common/headerPOST.php';
include_once __DIR__ . '/../../common/includeCommon.php';
include_once __DIR__ . '/../../common/includeJWT.php';

include_once __DIR__ . '/../../objects/user.php';

use \Firebase\JWT\JWT;

$user = new User($db);

$common->inputMappingObj($data, $user);

$userExist = $user->existField("user");


if ($userExist && password_verify($data->password, $user->password)) {

    $token = array(
        "iat" => $issued_at,
        "exp" => $expiration_time,
        "iss" => $issuer,
        "data" => $common->responseToObject("id,nombres,correo", $user)
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
