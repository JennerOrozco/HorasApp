<?php
include_once __DIR__ . '/../../common/headerPOST.php';
include_once __DIR__ . '/../../common/includeCommon.php';

include_once __DIR__ . '/../../objects/carritos.php';

$carritos = new Carritos($db);

if ($common->validateInput($data, "lancha")) {

    $common->inputMappingObj($data, $carritos);

    $carritosResult = $carritos->getByLancha();

    if ($common->validateStatus($carritosResult)) {

    $common->response200($carritosResult);
    } else {
        $common->response404("No data found.");
    }
} else {

    $common->response404("Datos incompletos.");
}
