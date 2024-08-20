<?php
$dir = __DIR__;
require_once $dir . '/../SQLs/consultasSQL.php';
require_once $dir . '/../Mail/EnviarCorreo.php';
session_start();
$formulario = clean_string($_POST['formulario']);
logError("Formulario recibido: $formulario");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    logError("Método POST detectado");

    if (isset($_POST['formulario']) && $_POST['formulario'] === 'UsuarioAddEdit') {
        logError("Formulario UsuarioAddEdit detectado");

        $id = isset($_POST['id']) ? $_POST['id'] : '';  
        $usuario = strtoupper(trim(clean_string($_POST['usuario'])));
        $nombre = strtoupper(trim(clean_string($_POST['nombre'])));
        $dni = trim(clean_string($_POST['dni']));
        $domicilio = strtoupper(trim(clean_string($_POST['domicilio'])));
        $provincia = trim(clean_string($_POST['provincia']));
        $localidad = trim(clean_string($_POST['localidad']));
        $telefono = trim(clean_string($_POST['telefono']));
        $mail = trim(clean_string($_POST['mail']));
        $bloqueo = trim(clean_string($_POST['bloqueo']));
        $fecha_alta = trim(clean_string($_POST['fecha_alta']));

        logError("Datos recibidos - ID: $id, Usuario: $usuario, Nombre: $nombre, DNI: $dni, Domicilio: $domicilio, Provincia: $provincia, Localidad: $localidad, Telefono: $telefono, Email: $mail, Bloqueo: $bloqueo, Fecha de alta: $fecha_alta");

        if (!empty($_FILES['imagen']['name'])) {
            logError("Imagen subida detectada");
        
            // Subida de imagen
            $target_dir = "../imag/";
            $target_file = $target_dir . basename($_FILES['imagen']['name']);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
            // Compruebe si el archivo de imagen es una imagen real o una imagen falsa
            $check = getimagesize($_FILES['imagen']['tmp_name']);
            if ($check === false) {
                echo 'file_error';
                logError("Error: El archivo no es una imagen");
                exit;
            }
        
            // Verifique el tamaño del archivo (5 MB máximo)
            if ($_FILES['imagen']['size'] > 5000000) {
                echo 'file_error_tam';
                logError("Error: El archivo es demasiado grande");
                exit;
            }
        
            // Permitir ciertos formatos de archivo
            $allowedFormats = array("jpg", "jpeg", "png", "gif");
            if (!in_array($imageFileType, $allowedFormats)) {
                echo 'file_error_formato';
                logError("Error: Formato de archivo no permitido");
                exit;
            }
        
            // Mover el archivo subido a la carpeta destino
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
                $imagen = basename($_FILES['imagen']['name']);
                logError("Imagen subida con éxito: $imagen");
            } else {
                echo 'file_error_mov';
                logError("Error al mover el archivo subido");
                exit;
            }
        } else if (!empty($_POST['imagen'])) {
            // Si hay una imagen proporcionada en el campo URL, usar esa
            $imagen = clean_string($_POST['imagen']);
            logError("Imagen recibida del formulario: $imagen");
        } else {
            // Si no hay imagen proporcionada, usar la imagen predeterminada
            $imagen = 'UserDefaul.png';
            logError("Imagen predeterminada: $imagen");
        }

        // Verificar campos requeridos
        $requiredFields = [
            'usuario' => 'Usuario',
            'nombre' => 'Nombre',
            'dni' => 'DNI',
            'domicilio' => 'Domicilio',
            'provincia' => 'Provincia',
            'localidad' => 'Localidad',
            'telefono' => 'Telefono',
            'mail' => 'Email',
            'bloqueo' => 'Bloqueo'
        ];

        $missingFields = [];
        foreach ($requiredFields as $field => $label) {
            if (empty($$field)) {
                $missingFields[] = $label;
            }
        }

        if (!empty($missingFields)) {
            $missingFieldsList = implode(', ', $missingFields);
            logError("Campos faltantes: $missingFieldsList");
            echo 'missing_fields';
            exit;
        }

        // Verificar si el usuario o el email ya están registrados (excepto para el usuario actual en edición)
        if (empty($id)) {
            logError("Insertando nuevo usuario");

            $sql = "SELECT * FROM prodes.usuarios WHERE USUARIO = ? OR EMAIL = ?";
            $stmt = ejecutarSQL($sql, [$usuario, $mail]);
            $BuscaUser = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($BuscaUser) {
                logError("Usuario o email ya existe");
                echo 'user_exists';
                exit;
            }
        } else {
            logError("Actualizando usuario existente");

            $sql = "SELECT * FROM prodes.usuarios WHERE (USUARIO = ? OR EMAIL = ?) AND ID != ?";
            $stmt = ejecutarSQL($sql, [$usuario, $mail, $id]);
            $BuscaUser = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($BuscaUser) {
                logError("Usuario o email ya existe");
                echo 'user_exists';
                exit;
            }
        }

        if (empty($id)) {
            // Inserción de usuario
            logError("Preparando inserción de usuario");
            // Nuevo usuario
            $password = generarPassword();
            $password_encrypted = encriptar_password($password);
            $bloqueo = 3; // Solicitar cambio de contraseña
            $fecha_alta = date('y-m-d');
            $campos = "USUARIO, PASSWORD, NOMBRE, DNI, DIRECCION, PCIA, LOCALIDAD, TELEFONO, EMAIL, URL, BLOQUEO, FECHA_ALTA";
            $valores = "?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?";
            $params = [$usuario, $password_encrypted, $nombre, $dni, $domicilio, $provincia, $localidad, $telefono, $mail, $imagen, $bloqueo, $fecha_alta];

            logError("Parámetros de inserción: " . print_r($params, true));

            if (ejecutar_SQL("INSERT INTO prodes.usuarios ($campos) VALUES($valores)", $params)) {
                echo 'insert_success|' . $password . '|' . $usuario . '|' . $nombre; /* Agrega el nombre de usuario y el nombre
                                de esta manera envias al formulario principar que utilñizarlas en la descripcion de formulario  */
            } else {
                echo 'insert_error';
            }
        } else {
             // Usuario existente
             $sql = "SELECT password FROM prodes.usuarios WHERE ID = ?";
             $stmt = ejecutarSQL($sql, [$id]);

           if ($stmt !== false) {
            $usuarioExistente = $stmt->fetch(PDO::FETCH_ASSOC);
            $password_encrypted = $usuarioExistente['password'];

            logError("Preparando actualización de usuario");
            $campos = "NOMBRE = ?, PASSWORD = ?, DIRECCION = ?, LOCALIDAD = ?, PCIA = ?, TELEFONO = ?, EMAIL = ?, BLOQUEO = ?, URL = ?, DNI = ?";
            $condicion = "ID = ?";
            $params = [$nombre, $password_encrypted, $domicilio, $localidad, $provincia, $telefono, $mail, $bloqueo, $imagen, $dni, $id];

            logError("Parámetros de actualización: " . print_r($params, true));

            if (ejecutar_SQL("UPDATE prodes.usuarios SET $campos WHERE $condicion", $params)=== TRUE) {
            echo 'update_success';
            logError("Coorecto");
            } else {
            echo 'update_error';
            }
            } else {
            echo 'update_error';
           }
        }
    } else if ($formulario === 'DeshabilitarUsuario') {  /* esto es para seshabilitar al usuario */
        logError("Formulario DeshabilitarUsuario detectado");

        $id = isset($_POST['id']) ? $_POST['id'] : '';
        if (!empty($id)) {
            $fecha_hoy = date('Y-m-d');
            $sql = "UPDATE prodes.usuarios SET bloqueo = 4, fecha_baja = ? WHERE ID = ?";
            $params = [$fecha_hoy, $id];

            if (ejecutarSQL($sql, $params)) {
                echo 'success';
                logError("Usuario con ID $id deshabilitado con éxito");
            } else {
                echo 'error';
                logError("Error al deshabilitar el usuario con ID $id");
            }
        } else {
            echo 'error';
            logError("ID de usuario no proporcionado");
        }
    }  else if ($formulario === 'GenNewPass') {
        logError("Formulario GenNewPass detectado");

        $id = isset($_POST['id']) ? $_POST['id'] : '';

        if (!empty($id)) {
            $sql = "SELECT USUARIO, NOMBRE, EMAIL FROM prodes.usuarios WHERE ID = ?";
            $stmt = ejecutarSQL($sql, [$id]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                $newPassword = generarPassword();
                $newPasswordEncrypted = encriptar_password($newPassword);
                $bloqueo = 3; // Solicitar cambio de contraseña

                $sql = "UPDATE prodes.usuarios SET PASSWORD = ?, BLOQUEO = ?, FECHA_BAJA = NOW() WHERE ID = ?";
                $params = [$newPasswordEncrypted, $bloqueo, $id];

                if (ejecutar_SQL($sql, $params)) {
                    /* se agregi esta linea para el envio de mail */
                    
                $email = trim($usuario['EMAIL']);
                $username = strtolower($usuario['NOMBRE']);
                $subject = "Nueva Contraseña Generada";
                $body = "Hola $username,<br><br>Se ha generado una nueva contraseña para tu cuenta. Tu nueva contraseña es: $newPassword<br><br>Por favor, cambia esta contraseña al iniciar sesión.<br><br>Saludos,<br>El equipo de soporte";

                if (enviarCorreo($email, $username, $subject, $body)) {
                    echo 'genpass_success|' . $newPassword . '|' . $username;
                } else {
                    echo 'email_error';
                }
                } else {
                    echo 'genpass_error';
                }
            } else {
                echo 'user_not_found';
            }
        } else {
            echo 'missing_id';
        }
        /* esto es para el cambio de contraseña*/
    }  else if ($formulario === 'ChangePassword') {
        $username = strtoupper(trim(clean_string($_POST['username'])));
        $sql = "SELECT ID FROM prodes.usuarios WHERE USUARIO = ?";
        $stmt = ejecutarSQL($sql, [$username]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        $id =  $usuario['ID'];

        $newPassword = clean_string($_POST['newPassword']);
        
        if (!empty($username) && !empty($newPassword)) {
            $newPasswordEncrypted = encriptar_password($newPassword);
            $bloqueo = 0; // Desbloquear al usuario

            $campos = " PASSWORD = ?,  BLOQUEO = ?";
            $condicion = "ID = ?";
            $params = [ $newPasswordEncrypted, $bloqueo, $id];


            if  (ejecutar_SQL("UPDATE prodes.usuarios SET $campos WHERE $condicion", $params)=== TRUE) {
                //logError("password_changed  $username ");
                echo 'password_changed';
            } else {
                logError("password_change_error  $username ");
                echo 'password_change_error';
            }
        } else {
            echo 'missing_fields';
        }
    }
   

/* 
    


*/










}
?>

