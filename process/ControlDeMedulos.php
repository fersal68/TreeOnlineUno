<?php
// Obtener el directorio del archivo actual 
$dir = __DIR__;
//  usando la ruta relativa
require_once $dir . '/../SQLs/consultasSQL.php';

session_start(); // Asegúrate de que la sesión esté iniciada 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
logError("Método POST detectado");

$formulario = clean_string($_POST['formulario']);
logError("formulario: $formulario " );
// Verificar si se ha enviado el formulario
if (isset($_POST['formulario'])) {

    switch ($formulario) {
        /*Elimina los filtros*/
        case 'FiltroFormDelete':
                $filtroid = clean_string($_POST['id']);
            if (!empty($filtroid)) {
                $sql = "DELETE FROM prodes.filtros WHERE ID_FIL = ?";
                $params = [$filtroid];
                $resultado = ejecutar_SQL($sql, $params);
                if ($resultado) {
                    if ($resultado) {
                        echo 'success_del';
                    } else {
                        echo 'error_delete';
                    }
                } else {
                    echo 'error_no';
                    logError($formulario.'- Borrado Filtro - Filtro no Encontrado.');
                }
            } else {
                echo 'error';
                logError($formulario .'- Faltan campos requeridos En Filtro.');
            }
            break;
            
         /*agrega los filtros*/
         case 'FiltroForm':      
                $filModulo = clean_string($_POST['filModulo']);
                $filFiltro = clean_string($_POST['filFiltro']);
                $filDescripcion = clean_string($_POST['filDescripcion']);
            if (!empty($filModulo) && !empty($filFiltro) && !empty($filDescripcion)) {
                $campos = "MODULO, FILTRO, DESCRIPCION";
                $valores = "? , ?, ?";
                $params = [$filModulo, $filFiltro, $filDescripcion];
        
                $resultado = ejecutar_SQL("INSERT INTO prodes.filtros ($campos) VALUES($valores)", $params);

                    if ($resultado) {
                        echo 'success';
                    } else {
                        echo 'insert_error';
                    }
             } else {
                echo 'error';
                logError($formulario .'- Faltan campos requeridos En Filtro.');
            }
            break;

            case 'AddItem':
                $categoria = clean_string($_POST['categoria']);
                $item = clean_string($_POST['item']);
                $descripcion = clean_string($_POST['descripcion']);
                $observacion = clean_string($_POST['observacion']);
                $habilitado = clean_string($_POST['habilitado']);
                $url_art = '';  // Inicializa con una cadena vacía
                $fechaHoy = date('d-m-y');
            
                // Manejar la imagen
                if (!empty($_FILES['imagen']['name'])) {
                    $target_dir = "../imag/";
                    $target_file = $target_dir . basename($_FILES['imagen']['name']);
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            
                    // Verifica si el archivo es una imagen real
                    $check = getimagesize($_FILES['imagen']['tmp_name']);
                    if ($check === false) {
                        echo 'file_error'; // El archivo no es una imagen
                        exit;
                    }
            
                    // Verifica el tamaño del archivo (5 MB máximo)
                    if ($_FILES['imagen']['size'] > 5000000) {
                        echo 'file_error'; // Archivo demasiado grande
                        exit;
                    }
            
                    // Permite ciertos formatos de archivo
                    $allowedFormats = array("jpg", "jpeg", "png", "gif");
                    if (!in_array($imageFileType, $allowedFormats)) {
                        echo 'file_error'; // Formato de archivo no permitido
                        exit;
                    }
            
                    // Mover el archivo subido a la carpeta destino
                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
                        $url_art = basename($_FILES['imagen']['name']);
                    } else {
                        echo 'file_error'; // Error al mover el archivo
                        exit;
                    }
                } else if (!empty($_POST['imagen'])) {
                    $url_art = clean_string($_POST['imagen']); // Imagen proporcionada en el formulario
                } else {
                    $url_art = 'art_default.png'; // Imagen predeterminada
                }
            
                // Verificar campos requeridos
                $requiredFields = [
                    'item' => 'item',
                    'descripcion' => 'descripcion'
                ];
            
                $missingFields = [];
                foreach ($requiredFields as $field => $label) {
                    if (empty($$field)) {
                        $missingFields[] = $label;
                    }
                }
            
                if (!empty($missingFields)) {
                    $missingFieldsList = implode(', ', $missingFields);
                    echo 'missing_fields|' . $missingFieldsList;
                    exit;
                }
            
                $sql = "INSERT INTO prodes.catalogo (CATEGORIA, ITEM, DESCRIPCION, OBSERVACION, FECHA_ALTA, HABILITADO, URL_ART) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $params = [$categoria, $item, $descripcion, $observacion, $fechaHoy, $habilitado, $url_art];
            
                $resultado = ejecutar_SQL($sql, $params);
            
                if ($resultado) {
                    echo 'success';
                } else {
                    echo 'error_insert';
                }
                break;






          /*Editar un articulo*/           
            case 'ItemAddEdit':
                $id_art = isset($_POST['id_art']) ? clean_string($_POST['id_art']) : null;
                $categoria = clean_string($_POST['categoria']);
                $item = clean_string($_POST['item']);
                $descripcion = clean_string($_POST['descripcion']);
                $observacion = clean_string($_POST['observacion']);
                $fecha_alta = clean_string($_POST['fecha_alta']);
                $habilitado = clean_string($_POST['habilitado']);
                $fecha_baja = clean_string($_POST['fecha_baja']);
        
                if ($id_art) {
                    // Editar el ítem
                    $sql = "UPDATE prodes.items SET CATEGORIA = ?, ITEM = ?, DESCRIPCION = ?, OBSERVACION = ?, FECHA_ALTA = ?, HABILITADO = ?, FECHA_BAJA = ? WHERE ID_ART = ?";
                    $params = [$categoria, $item, $descripcion, $observacion, $fecha_alta, $habilitado, $fecha_baja, $id_art];
                    $resultado = ejecutar_SQL($sql, $params);
        
                    if ($resultado) {
                        echo 'success_edit';
                    } else {
                        echo 'error_update';
                        logError('Error al actualizar el Item.');
                    }
                } else {
                    // Agregar un nuevo ítem
                    $sql = "INSERT INTO prodes.items (CATEGORIA, ITEM, DESCRIPCION, OBSERVACION, FECHA_ALTA, HABILITADO, FECHA_BAJA) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $params = [$categoria, $item, $descripcion, $observacion, $fecha_alta, $habilitado, $fecha_baja];
                    $resultado = ejecutar_SQL($sql, $params);
        
                    if ($resultado) {
                        echo 'success_add';
                    } else {
                        echo 'error_insert';
                        logError('Error al agregar el Item.');
                    }
                }
                break;


            













        default:
            echo 'Formulario no reconocido.';
            logError($formulario.'- Formulario no reconocido');
            break;
    }
}




}
?>