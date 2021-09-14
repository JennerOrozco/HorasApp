<?php
include_once '../common/commonHeaderPOST.php';
include_once '../common/commonInclude.php';
include_once '../objects/user.php';

$user = new User($db);

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
