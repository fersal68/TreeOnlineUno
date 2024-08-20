<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$dir = __DIR__;

require $dir . '/../PHPMailer/src/Exception.php';
require $dir . '/../PHPMailer/src/PHPMailer.php';
require $dir . '/../PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Configuración del servidor
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Cambia esto si usas otro proveedor
    $mail->SMTPAuth = true;
    $mail->Username = 'comunicado.fs@gmail.com'; // Tu dirección de correo
    $mail->Password = 'uitwhenymqihrorw'; // Tu contraseña de correo
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Configuración del remitente y destinatario
    $mail->setFrom('comunicado.fs@gmail.com', 'comunicadosfs soporte');
    $mail->addAddress('ferchu0013@hotmail.com', 'Salaburu.Fernando');

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'este es el asunto';
    $mail->Body    = 'esto es el cuerpo del mail ';
    $mail->AltBody = 'ojala este llegue jejejeej';

    $mail->send();
    echo 'Correo enviado correctamente';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
?>
