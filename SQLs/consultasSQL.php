<?php 

$dir = __DIR__;
// usando la ruta relativa
require_once $dir . '/../SQLs/conectarSQL.php';


function logError($message) {
    $date = date('Y-m-d H:i:s');
    //error_log("[$date] $message\n", 3, './errores/Errores.log'); // Guardar el mensaje de error en un archivo de log
    //error_log("[$date] $message\n", 3, '../log/Errores.log'); 
    error_log("[$date] $message\n", 3, './Errores.log'); 
}

function encriptar_password($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Función para generar una contraseña aleatoria
function generarPassword($longitud = 8) {
    $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < $longitud; $i++) {
        $password .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $password;
}


/* Función para limpiar datos */
function clean_string($string) {
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
} 


/*  funcion devuelve un resultado*/
function ejecutarSQL($sql, $params = []) {
    $conn = conectar();
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        logError("SQL: $sql | Error: " . $e->getMessage());
        return false;
    }
} 

/*  funcion devuelve verdadero falso*/
function ejecutar_SQL($sql, $params = []) {
    $conn = conectar();
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        // Verificamos el número de filas afectadas para determinar si la operación fue exitosa
        if ($stmt->rowCount() > 0) {
            logError("SQL ejecutado con éxito: $sql | Parámetros: " . print_r($params, true));
            return true; // Devolvemos true para indicar éxito
        } else {
            logError("SQL ejecutado, pero sin filas afectadas: $sql | Parámetros: " . print_r($params, true));
            return false; // Devolvemos false si no hay filas afectadas
        }
    } catch (PDOException $e) {
        logError("SQL: $sql | Error: " . $e->getMessage());
        return false;
    }
}

function ejecutarSoloSQL($sql) {
    $conn = conectar();
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        logError("SQL: $sql | Error: " . $e->getMessage());
        return false;
    }
}

function insertSQL($tabla, $campos, $valores) {
    $sql = "INSERT INTO $tabla ($campos) VALUES($valores)";
    return ejecutarSQL($sql);
}
function insertSQL_($tabla, $campos, $valores, $params) {
    $sql = "INSERT INTO $tabla ($campos) VALUES($valores)";
    return ejecutarSQL($sql, $params);
}

function updateSQL($tabla, $campos, $condicion, $params) {
    $sql = "UPDATE $tabla SET $campos WHERE $condicion";
    return ejecutarSQL($sql, $params);
}

function deleteSQL($tabla, $condicion) {
    $sql = "DELETE FROM $tabla WHERE $condicion";
    return ejecutarSQL($sql);
}

function selectAll($table, $columns = '*') {
    $sql = "SELECT $columns FROM $table";
    return ejecutarSQL($sql);
}

function selectSQL($sql) {
    return ejecutarSoloSQL($sql);
}





?>