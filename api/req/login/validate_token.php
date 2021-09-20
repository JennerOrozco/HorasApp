<?php
include_once __DIR__ . '/../../common/headerPOST.php';
include_once __DIR__ . '/../../common/includeCommon.php';

include_once __DIR__ . '/../../common/validateToken.php';

$validate = validateToken($data->jwt, $key);

if ($common->validateStatus($validate)) {

    $common->response200($validate);
} else {
    $common->response404($common->abstractMessage($validate));
}
