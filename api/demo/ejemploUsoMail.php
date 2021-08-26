<?php
include '../common/commonMail.php';

$word = array();
$word["Titulo"] = "TITULO DEMO";
$word["Nombre"] = "Nombre DEMO";
$word["Apellido"] = "Apellido DEMO";

$Response = sendMailFunction("../htmlTemplate/index.php", $word, "support@horasApp.com", "Soporte Aplicacion", "jf.orozco3@gmail.com", "Demo  - SendMail");

if ($Response) {
    echo "Ok";
} else {
    echo "Fail";
}
