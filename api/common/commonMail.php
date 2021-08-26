<?php
require $_SERVER['DOCUMENT_ROOT'] . '/horas_api/mail/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/horas_api/mail/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/horas_api/mail/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendMailFunction($htmlFile, $ModifiedArray, $from, $aliasFrom, $sendTo, $subject)
{
    $body = file_get_contents($htmlFile);

    foreach ($ModifiedArray as $clave => $valor) {
        $body = str_replace("{{" . $clave . "}}", $valor, $body);
    }

    $mail = new PHPMailer(true);

    $mail->From = $from;

    $mail->FromName = $aliasFrom;

    $mail->addAddress($sendTo, "Recipient Name");

    $mail->isHTML(true);

    $mail->Subject = $subject;

    $mail->Body = $body;

    $mail->AltBody = "Actualice su explorador, y comuniquese a servicio al cliente indicando el problema. Error: 305ET";

    try {
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
