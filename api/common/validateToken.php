<?php
include_once __DIR__ . '/includeJWT.php';

use \Firebase\JWT\JWT;

function validateToken($stringJWT, $keyJWT)
{

    if ($stringJWT) {
        try {

            $decoded = JWT::decode($stringJWT, $keyJWT, array('HS256'));

            return array("status" => true, "data" => $decoded->data);
        } catch (Exception $e) {

            return array("status" => false, "data" => $e->getMessage());
        }
    } else {

        return array("status" => false, "data" => "JWT empty");
    }
}
