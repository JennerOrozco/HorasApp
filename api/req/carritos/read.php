<?php
include_once __DIR__ . '/../../common/headerGET.php';
include_once __DIR__ . '/../../common/includeCommon.php';

include_once __DIR__ . '/../../objects/carritos.php';

$carritos = new Carritos($db);

$carritosResult = $carritos->getAll();


if ($common->validateStatus($carritosResult)) {

    $common->response200($carritosResult);
} else {
    $common->response404("No data found.");
}