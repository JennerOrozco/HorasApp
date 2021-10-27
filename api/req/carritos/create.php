<?php
include_once __DIR__ . '/../../common/headerPOST.php';
include_once __DIR__ . '/../../common/includeCommon.php';

include_once __DIR__ . '/../../objects/carritos.php';

$carritos = new Carritos($db);

if ($common->validateInput($data, "carro,moto,lancha,camion,avion")) {

    $db->beginTransaction();

    $common->inputMappingObj($data, $carritos);

    $carritosResult = $carritos-> createCarritos();

    if ($common->validateStatus($carritosResult)) {

        $db->commit();

        $common->response200($carritosResult);
    } else {

        $db->rollBack();

        $common->response503("Unable to create.");
    }
} else {

    $common->response404("Data is incomplete.");
}