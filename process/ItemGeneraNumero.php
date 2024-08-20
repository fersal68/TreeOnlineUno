<?php
// Obtener el directorio del archivo actual 
$dir = __DIR__;
//  usando la ruta relativa
require_once $dir . '/../SQLs/consultasSQL.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Asegúrate de recibir la categoría
    $categoriaSeleccionada = isset($_POST['categoria']) ? $_POST['categoria'] : '';

    // Llama a la función que generará el código del ítem
    function generarCodigoItem($categoriaSeleccionada) {
        // Definir el prefijo según las primeras 3 letras de la categoría
        $prefijo = strtoupper(substr($categoriaSeleccionada, 0, 3));

        // Consulta SQL para obtener el último número consecutivo para esa categoría
        $sql = "SELECT MAX(SUBSTRING(ITEM, 4, 6) * 1) as max_codigo 
                FROM prodes.catalogo 
                WHERE ITEM LIKE '{$prefijo}%'";
        
        // Ejecutar la consulta
        $resultado = ejecutarSQL($sql, []);

        // Verificar si la consulta se ejecutó correctamente
        if ($resultado && $resultado->rowCount() > 0) {
            // Obtener el resultado como un arreglo asociativo
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            $ultimoNumero = isset($fila['max_codigo']) ? $fila['max_codigo'] : 0;
        } else {
            // Si no hay resultados, inicializar a 0
            $ultimoNumero = 0;
        }

        // Sumamos 1 al último número y lo formateamos con ceros a la izquierda
        $nuevoNumero = str_pad($ultimoNumero + 1, 6, '0', STR_PAD_LEFT);

        // Generar el código final del ítem
        $codigoItem = $prefijo . $nuevoNumero;

        return $codigoItem;
    }

    // Genera el código del ítem basado en la categoría seleccionada
    $codigoItemGenerado = generarCodigoItem($categoriaSeleccionada);

    // Devolver el código generado
    echo $codigoItemGenerado;
}
?>