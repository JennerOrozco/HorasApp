<?php
include_once '../common/commonHeaderGET.php';
include_once '../common/commonInclude.php';
include_once '../objects/solicitudes.php';

$solicitudes = new Solicitudes($db);
$solicitudesResult = $solicitudes->readAll();

if ($solicitudesResult["success"] == true) {
    $common->response200(array("data" => $solicitudesResult["data"]));
} else {
    $common->response404("No data found.");
}
