<?php
include_once '../common/commonHeaderPOST.php';
include_once '../common/commonInclude.php';
include_once '../objects/solicitudes.php';
include_once '../objects/user.php';

$solicitudes = new Solicitudes($db);
$user = new User($db);

if (
    !empty($data->id)
) {

    $common->inputMappingObj($data, $solicitudes);

    $result = $solicitudes->create();

    if ($result["success"] == true) {

        $common->response200(array("message" => "solicitudes was Created", "id" => $result["id"]));
    } else {
        $common->response503("Unable to create solicitudes.");
    }
} else {
    $common->response404("Unable to delete solicitud. Data is incomplete.");
}
