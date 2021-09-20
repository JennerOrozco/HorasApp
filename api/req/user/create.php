<?php
include_once __DIR__ . '/../../common/headerPOST.php';
include_once __DIR__ . '/../../common/includeCommon.php';

include_once __DIR__ . '/../../objects/user.php';

$user = new User($db);

if ($common->validateInput($data, "nombres,correo,password,user")) {

    $db->beginTransaction();

    $common->inputMappingObj($data, $user);

    $userResult = $user->createUser();

    if ($common->validateStatus($userResult)) {

        $db->commit();

        $common->response200($userResult);
    } else {

        $db->rollBack();

        $common->response503("Unable to create.");
    }
} else {

    $common->response404("Data is incomplete.");
}
