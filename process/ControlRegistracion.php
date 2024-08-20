<?php
// Obtener el directorio del archivo actual 
$dir = __DIR__;
//  usando la ruta relativa
require_once $dir . '/../SQLs/consultasSQL.php';
require_once $dir . '/../Mail/EnviarCorreo.php';
//require_once $dir . '/../SQLs/ConectarSQL.php';
// la funcion de errores se encuentra en consultasSQL.php
$formulario = clean_string($_POST['formulario']);
// Verificar si se ha enviado el formulario
if (isset($_POST['formulario']) && $_POST['formulario'] === 'RegistracionFrom') {
    $fecha_hoy = date('Y-m-d');
    // Limpiar los datos de entrada
    $user_m = clean_string($_POST['regname']);
    $pass = clean_string(encriptar_password($_POST['regpass']));
    $nombre_m = clean_string($_POST['regfullname'] . ' ' . $_POST['reglastname']);
    $direccion_m = clean_string($_POST['regdir']);
    $telefono = clean_string($_POST['regphone']);
    $email_m = clean_string($_POST['regemail']);
    $dni = clean_string($_POST['regdni']);
    // Convertir el dato a mayuscula
    $user = strtoupper(trim($user_m));
    $direccion = strtoupper(trim($direccion_m));
    $data_lowercase = strtolower($nombre_m);
    $nombre = strtoupper(trim($data_lowercase));
    $email = trim($email_m);

    // Convertir la primera letra de cada palabra a mayúsculas
    //$nombre = ucwords($data_lowercase);



    // Verificar si las variables no están vacías
    if (!empty($dni) && !empty($nombre) && !empty($telefono) && !empty($email) && !empty($direccion) && !empty($user) && !empty($pass)) {
        // Verificar si el usuario o el email ya existen // quite por ahora el control de mail, solo lo hace por usuario
        //$checkUserSQL = "SELECT * FROM prodes.usuarios WHERE USUARIO = ? OR EMAIL = ?";
        //$checkUserStmt = ejecutarSQL($checkUserSQL, [$user, $email]);
        $checkUserSQL = "SELECT * FROM prodes.usuarios WHERE USUARIO = ? ";
        $checkUserStmt = ejecutarSQL($checkUserSQL, [$user ]);
        if ($checkUserStmt && $checkUserStmt->rowCount() > 0) {
            logError($formulario."- El usuario o el email ya están registrados: Usuario: $user, Email: $email");
            echo 'user_exists'; // Cambia este mensaje para diferenciar el error
        } else {
            $bloqueo = 3;
            $url = 'UserDefaul.png';
            // Proceder con la inserción
            $campos = "USUARIO, PASSWORD, FECHA_ALTA, NOMBRE, DIRECCION, TELEFONO, EMAIL ,BLOQUEO ,URL , DNI";
            $valores = "?, ?, ?, ?, ?, ?, ?, ?,? , ?";
            $params = [$user, $pass, $fecha_hoy, $nombre, $direccion, $telefono, $email,$bloqueo,$url, $dni];

            if (ejecutarSQL("INSERT INTO prodes.usuarios ($campos) VALUES($valores)", $params)) {
                // Enviar correo de confirmación
                $confirmLink = "http://localhost:81/TreeOnlineUno/process/ConfirmarRegistro.php?usuario=" . urlencode($user);
                $subject = "Bienvenido a nuestra plataforma";
                $body = "Hola $nombre,<br><br>Te damos la bienvenida a nuestra plataforma. Tu nombre de usuario es: $user<br><br>Para completar tu registro, por favor haz clic en el siguiente enlace:<br><br><a href='$confirmLink'>Confirmar Registro</a><br><br>Gracias,<br>El equipo de soporte";

                if (enviarCorreo($email, $nombre, $subject, $body)) {
                    echo 'success';
                } else {
                    echo 'email_error';
                }

            } else {
                echo 'insert_error'; // Cambia este mensaje para diferenciar el error
                logError($formulario."- Error en la inserción de datos");
            }
        }
    } else {
        logError($formulario. '- Faltan campos requeridos en el formulario de registro.');
        echo 'missing_fields';
    }
} else {
    logError($formulario -'- Formulario no enviado.');
    echo 'Error';
}
?>