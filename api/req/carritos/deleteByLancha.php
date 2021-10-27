<?php
include_once __DIR__ . '/../../common/headerPOST.php';
include_once __DIR__ . '/../../common/includeCommon.php';

include_once __DIR__ . '/../../objects/carritos.php';

$carritos = new Carritos($db);

if ($common->validateInput($data, "{stringInsert}")) {

    $db->beginTransaction();

    $common->inputMappingObj($data, $carritos);

    $carritosResult = $carritos-> deleteByLancha();
    

    if ($common->validateStatus($carritosResult)) {

        $db->commit();

        $common->response200($carritosResult);
    } else {

        $db->rollBack();

        $common->response503("Unable to delete.");
    }
} else {

    $common->response404("Data is incomplete.");
}


<?php
include_once __DIR__ . '/../../common/headerGET.php';
include_once __DIR__ . '/../../common/includeCommon.php';



$carritos = new Carritos($db);

$carritosResult = $carritos->getAll();


if ($common->validateStatus($carritosResult)) {

    $common->response200($carritosResult);
} else {
    $common->response404("No data found.");
}


