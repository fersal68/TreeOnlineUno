<?php
// Obtener el directorio del archivo actual 
$dir = __DIR__;
//  usando la ruta relativa
require_once $dir . '/../SQLs/consultasSQL.php';
$user = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "SELECT * FROM prodes.usuarios WHERE ID = ?";
   
    $stmt = ejecutarSQL($query, [$id]);
    if ($stmt) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }
  
}


// Asume que ya tienes una conexión a la base de datos establecida
$sql = "SELECT * FROM prodes.filtros WHERE MODULO ='USUARIO'and FILTRO= 'PROVINCIA' ";
$result = selectSQL($sql);
?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 56px; /* Ajusta el relleno superior para que no se superponga con la barra de navegación */
        }
        .p-h2 {
            color: #d4af37; /* Color dorado para el texto */
            text-shadow: 1px 1px 2px #000; /* Sombra para el texto */
            padding-bottom: 10px; /* Espaciado inferior para el texto */
            margin-bottom: 20px; /* Margen inferior para el texto */
            border-bottom: 2px solid #000; /* Línea inferior negra para el texto */
            font-size: 2rem; /* Tamaño de fuente similar al h2 */
            font-weight: bold; /* Negrita */
}
        .form-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            background-color: #f8f9fa;
            border: 1px solid #000;
            padding: 20px;
            border-radius: 5px;
        }
        .form-left {
            flex: 1;
            min-width: 300px;
        }
        .form-right {
            flex: 1;
            min-width: 300px;
        }
        .form-right img {
            width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .btn-primary {
            background-color: #000;
            border-color: #d4af37;
        }
        .btn-primary:hover {
            background-color: #d4af37;
            border-color: #000;
        }
        .btn-secondary {
            background-color: #000;
            border-color: #d4af37;
        }
        .btn-secondary:hover {
            background-color: #d4af37;
            border-color: #000;
        }
        /* tamaño de la imagen */
        .form-right img {
           width: 100%; /* Esto hace que la imagen ocupe el 100% del ancho del contenedor */
           max-width: 300px; /* Ajusta este valor al tamaño máximo deseado */
           height: auto; /* Mantiene la proporción de la imagen */
           border: 1px solid #ddd; /* Añade un borde a la imagen */
           border-radius: 4px; /* Redondea las esquinas de la imagen */
           padding: 5px; /* Añade un padding alrededor de la imagen */
           object-fit: cover; /* Asegura que la imagen cubra todo el contenedor */
           display: block; /* Asegura que la imagen sea un bloque */
           margin: 0 auto; /* Centra la imagen horizontalmente */
}



    </style>
    <title>Formulario de Usuario</title>
</head>
<body>
<main>
    <div class="container py-4">
        <div class="form-container">
            <div class="form-left">
                <p class="p-h2">Registro de Usuario</p>
                <p>Complete los siguientes datos para registrar o editar un usuario:</p>

                <form id="UsuarioAddEdit" class="UsuarioAddEdit">
                    <input type="hidden" name="id" value="<?php echo isset($user['ID']) ? $user['ID'] : ''; ?>">
                    <div class="form-group">
                        <!-- esto es para deshabilitar el campo -->
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario"
                                value="<?php echo isset($user['USUARIO']) ? $user['USUARIO'] : ''; ?>"
                                <?php echo isset($user['USUARIO']) && !empty($user['USUARIO']) ? 'readonly' : ''; ?> required>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Apellido y Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" 
                         value="<?php echo isset($user['NOMBRE']) ? $user['NOMBRE'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="dni">DNI</label>
                        <input type="text" class="form-control" id="dni" name="dni" 
                        value="<?php echo isset($user['DNI']) ? $user['DNI'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="domicilio">Domicilio</label>
                        <input type="text" class="form-control" id="domicilio" name="domicilio" 
                        value="<?php echo isset($user['DIRECCION']) ? $user['DIRECCION'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="provincia">Provincia</label>
                        <select class="form-control" id="provincia" name="provincia" required>
                <?php
                       if ($result) {
                         foreach ($result as $row) {
                         $selected = (isset($user['PCIA']) && $user['PCIA'] == $row['DESCRIPCION']) ? 'selected' : '';
                         echo "<option value='{$row['DESCRIPCION']}' $selected>{$row['DESCRIPCION']}</option>";
                         }
                         } else {
                         echo "<option value='' disabled>No hay filtros disponibles</option>";
                         }
                ?>
                       </select>
                    </div>
                    <div class="form-group">
                        <label for="localidad">Localidad</label>
                        <input type="text" class="form-control" id="localidad" name="localidad" 
                        value="<?php echo isset($user['LOCALIDAD']) ? $user['LOCALIDAD'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" 
                        value="<?php echo isset($user['TELEFONO']) ? $user['TELEFONO'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="mail">Email</label>
                        <input type="email" class="form-control" id="mail" name="mail" 
                        value="<?php echo isset($user['EMAIL']) ? $user['EMAIL'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="imagen">Imagen</label>
                        <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="bloqueo">Bloqueo</label>
                        <select class="form-control" id="bloqueo" name="bloqueo" required>
                            <option value="0" <?php echo (isset($user['BLOQUEO']) && $user['BLOQUEO'] == '0') ? 'selected' : ''; ?>>No</option>
                            <option value="1" <?php echo (isset($user['BLOQUEO']) && $user['BLOQUEO'] == '1') ? 'selected' : ''; ?>>Sí</option>
                            <option value="3" <?php echo (isset($user['BLOQUEO']) && $user['BLOQUEO'] == '3') ? 'selected' : ''; ?>>Pide Contraseña</option>
                            <option value="4" <?php echo (isset($user['BLOQUEO']) && $user['BLOQUEO'] == '4') ? 'selected' : ''; ?>>Deshabilitado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <!-- esto es para deshabilitar el campo -->
                        <label for="fecha_alta">Fecha de Alta</label>
                        <input type="date" class="form-control" id="fecha_alta" name="fecha_alta"
                                 value="<?php echo isset($user['FECHA_ALTA']) ? $user['FECHA_ALTA'] : ''; ?>"
                              <?php echo isset($user['FECHA_ALTA']) && !empty($user['FECHA_ALTA']) ? 'readonly' : ''; ?> required>
                    </div>
                    <?php if (isset($_GET['action']) && $_GET['action'] == 'add') { ?>
                    <button type="button" id="AddSubmit" class="btn btn-primary">Agregar</button>
                    <?php } else { ?>
                    <button type="button" id="EditSubmit" class="btn btn-primary">Guardar</button>
                    <button type="button" id="GenNewPass" class="btn btn-secondary" data-id="<?php echo isset($user['ID']) ? $user['ID'] : ''; ?>">Generar nueva contraseña</button>
                    <!-- se pasa el id de esta manera para que lo tome el ajax, no esta dentro del form GenNewPass, este no existe solo es para este boton -->
                    <?php } ?>
                    <button type="button" class="btn btn-secondary" onclick="history.back()">Volver</button>
                </form>
            </div>

            <div class="form-right">
                 <p class="p-h2">Foto</p>
                 <img id="previewImagen" src="<?php echo isset($user['URL']) ? './imag/' . $user['URL'] : '#'; ?>" alt="Imagen del Usuario" onerror="this.style.display='none'">
            </div>
        </div>
    </div>
</main>


<script>
    document.getElementById('imagen').onchange = function (event) {
        var reader = new FileReader();
        reader.onload = function(){
            var previewImagen = document.getElementById('previewImagen');
            previewImagen.src = reader.result;
            previewImagen.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    };
</script>

</body>
</html>