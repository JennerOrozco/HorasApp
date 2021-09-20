<?php
include_once __DIR__ . '/../../common/headerGET.php';
include_once __DIR__ . '/../../common/includeCommon.php';

include_once __DIR__ . '/../../objects/user.php';

$user = new User($db);

$userResult = $user->getAll();

if ($common->validateStatus($userResult)) {

    $common->response200($userResult);
} else {
    $common->response404("No data found.");
}
