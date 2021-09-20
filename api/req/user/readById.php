<?php
include_once __DIR__ . '/../../common/headerPOST.php';
include_once __DIR__ . '/../../common/includeCommon.php';

include_once __DIR__ . '/../../objects/user.php';

$user = new User($db);

if ($common->validateInput($data, "id")) {

    $common->inputMappingObj($data, $user);

    $userResult = $user->getById();

    if ($common->validateStatus($userResult)) {

        $common->response200($userResult);
    } else {

        $common->response404("No data found.");
    }
} else {

    $common->response404("Datos incompletos.");
}
