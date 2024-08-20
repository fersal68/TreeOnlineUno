<?php
// Obtener el directorio del archivo actual (sqls.php)
$dir = __DIR__;
// Incluir config.php usando la ruta relativa
require_once $dir . '/../config/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$dir = __DIR__;

require $dir . '/../PHPMailer/src/Exception.php';
require $dir . '/../PHPMailer/src/PHPMailer.php';
require $dir . '/../PHPMailer/src/SMTP.php';




function enviarCorreo($toEmail, $toName, $subject, $body) {
$mail = new PHPMailer(true);

try {
    // Configuración del servidor
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = MAIL;
    $mail->Password = MAIL_PASS ;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Configuración del remitente y destinatario
    $mail->setFrom( MAIL , MAIL_NOMBRE);
    $mail->addAddress($toEmail, $toName);   //$toEmail = mail de destino  --- $toName = nombre del destino
    // Configuración de la codificación
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = $subject;  //esto es el asundo del mail
    $mail->Body    = $body;    // esto es el cuerpo del mail
    $mail->AltBody = strip_tags($body);

    $mail->send();
    return true;
} catch (Exception $e) {
    error_log("Error al enviar el correo: {$mail->ErrorInfo}");
    return false;
}
}
?>