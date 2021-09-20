<?php
include_once './../../common/includeCommon.php';
include_once './../../common/headerPOST.php.php';
include_once './../../common/commonMail.php';

if (
    $common->validateInput($data, "nombre,apellido,compania,correo,telefono")
) {
    $word = array();
    $word["nombrePersona"] = $data->nombre . " " . $data->apellido;
    $word["nombreCompania"] = $data->compania;
    $word["correo"] = $data->correo;
    $word["telefono"] = $data->telefono;

    $responseEmail = sendMailFunction("../htmlTemplate/cotizacion.html", $word, "adminSupport@kaeserservicios.com", "Soporte Aplicacion Kaeser", "jf.orozco3@gmail.com", "KAESER SERVICE - Cotizacion ");

    if ($common->validateStatus($responseEmail)) {

        $common->response200($common->abstractMessage($responseEmail));
    } else {
        $common->response503("No se pudo mandar el correo.");
    }
} else {
    $common->response404("Datos incompletos.");
}
