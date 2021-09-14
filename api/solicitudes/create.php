<?php
include_once '../common/commonHeaderPOST.php';
include_once '../common/commonInclude.php';
include_once '../objects/solicitudes.php';
include '../common/commonMail.php';

$solicitudes = new Solicitudes($db);
if (
    !empty($data->nombre) &&    !empty($data->apellido) &&    !empty($data->compania) &&    !empty($data->correo) &&    !empty($data->telefono)
) {

    $common->inputMappingObj($data, $solicitudes);

    $result = $solicitudes->create();

    if ($result["success"] == true) {

        $word = array();
        $word["nombrePersona"] = $data->nombre . " " . $data->apellido;
        $word["nombreCompania"] = $data->compania;
        $word["correo"] = $data->correo;
        $word["telefono"] = $data->telefono;


        $response = sendMailFunction("../htmlTemplate/createRequest.html", $word, "adminSupport@kaeserservicios.com", "Soporte Aplicacion", "jf.orozco3@gmail.com", "KAESER SERVICE - Creacion de Usuario - " . $data->compania);

        if ($response) {
            $common->response200(array("message" => "solicitudes was Created", "id" => $result["id"]));
        }
    } else {
        $common->response503("Unable to create solicitudes.");
    }
} else {
    $common->response404("Unable to create solicitudes. Data is incomplete.");
}
