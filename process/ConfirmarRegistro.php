<?php
$dir = __DIR__;
//  usando la ruta relativa
require_once $dir . '/../SQLs/consultasSQL.php';

if (isset($_GET['usuario'])) {
    $usuario = clean_string($_GET['usuario']);

    $bloqueo = 0; // Desbloquear al usuario

    $campos = " BLOQUEO = ?";
    $condicion = "USUARIO = ?";
    $params = [  $bloqueo, $usuario];


    if  (ejecutar_SQL("UPDATE prodes.usuarios SET $campos WHERE $condicion", $params)=== TRUE) {
        //header("Location: confirmacion_exitosa.php");
        echo "se actualizo";
        exit();        
    } else {
        echo "Error: ubo un error al actualizar.";
    }



} else {
    echo "Error: Usuario no especificado.";
}
?>