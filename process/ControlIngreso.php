<?php
// Obtener el directorio del archivo actual 
$dir = __DIR__;
//  usando la ruta relativa
require_once $dir . '/../SQLs/consultasSQL.php';
//require_once $dir . '/../SQLs/ConectarSQL.php';
// viene la informacion del modal de ingreso ---   <div id="loginModalContainer"></div>  
// mas la funcion js "./js/ControlIngreso.js" --- este abre el modal y manda la informacion a este y devuelve el resultado
session_start(); // Asegúrate de que la sesión esté iniciada 

$formulario = clean_string($_POST['formulario']);
logError("formulario: $formulario " );
// Verificar si se ha enviado el formulario
if (isset($_POST['formulario'])) {

    switch ($formulario) {
        case 'FormLogin':
                $username = clean_string($_POST['username']);
                $password = clean_string($_POST['password']);
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $sql = "SELECT PASSWORD, BLOQUEO FROM prodes.usuarios WHERE USUARIO = ?";
                $stmt = ejecutarSQL($sql, [$username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    if (password_verify($password, $user['PASSWORD'])== 1) {
                        if ($user['BLOQUEO'] == 3) {
                            echo 'change_password';
                            logError("usuario: $username requiere cambio de contraseña.");
                        } else {
                            $_SESSION['usuario'] = $username;
                            echo 'success';
                            logError("usuario: $username  | Resultado: ". password_verify($password, $user['PASSWORD']));
                        }
                    } else {
                        echo 'error_pass';
                        logError($formulario.'- Control Ingreso - Usuario o contraseña incorrectos.');
                    }
                } else {
                    echo 'error_no';
                    logError($formulario.'- Control Ingreso - Usuario no encontrado.');
                }
            } else {
                echo 'error';
                logError($formulario .'- Faltan campos requeridos en el formulario de inicio de sesión.');
            }
            break;
        default:
            echo 'Formulario no reconocido.';
            logError($formulario.'- Formulario no reconocido');
            break;
    }
}
?>
