<?php
// Obtener el directorio del archivo actual 
$dir = __DIR__;
//  usando la ruta relativa
require_once $dir . '/../SQLs/consultasSQL.php';
$item = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM prodes.catalogo WHERE ID_ART = ?";
    $stmt = ejecutarSQL($query, [$id]);
    if ($stmt) {
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
// Asume que ya tienes una conexión a la base de datos establecida
$sql = "SELECT * FROM prodes.filtros WHERE MODULO ='ITEM'and FILTRO= 'CATEGORIA' ";
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



    </style>
    <title>Formulario de Item</title>
</head>
<body>
<main>
<div class="container py-4">
    <div class="form-container">
        <div class="form-left">
            <p class="p-h2">Registro de Item</p>
            <p>Complete los siguientes datos para registrar o editar un Item:</p>

            <form id="FormItemAddEdit" class="FormItemAddEdit">
                <input type="hidden" name="id_art" value="<?php echo isset($item['ID_ART']) ? $item['ID_ART'] : ''; ?>">

                <div class="form-group">
                    <label for="categoria">Categoría</label>
                    <select class="form-control" id="categoria" name="categoria" required>
                        <?php
                        if ($result) {
                            foreach ($result as $row) {
                                $selected = (isset($item['CATEGORIA']) && $item['CATEGORIA'] == $row['DESCRIPCION']) ? 'selected' : '';
                                echo "<option value='{$row['DESCRIPCION']}' $selected>{$row['DESCRIPCION']}</option>";
                            }
                        } else {
                            echo "<option value='' disabled>No hay categorías disponibles</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="item">Item</label>
                    <input type="text" class="form-control" id="item" name="item" 
                           value="<?php echo isset($item['ITEM']) ? $item['ITEM'] : ''; ?>" required>
                </div>
                
                <?php if (isset($_GET['action']) && $_GET['action'] == 'add') { ?>
                    <button type="button" class="btn btn-primary" onclick="generarNumeroItem()">Generar número ITEM</button>
                    <?php }  ?>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" 
                    value="<?php echo isset($item['DESCRIPCION']) ? $item['DESCRIPCION'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="observacion">Observación</label>
                    <input type="text" class="form-control" id="observacion" name="observacion" 
                    value="<?php echo isset($item['OBSERVACION']) ? $item['OBSERVACION'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="fecha_alta">Fecha de Alta</label>
                    <input type="date" class="form-control" id="fecha_alta" name="fecha_alta"
                    value="<?php echo isset($item['FECHA_ALTA']) ? $item['FECHA_ALTA'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="habilitado">Habilitado</label>
                    <select class="form-control" id="habilitado" name="habilitado" required>
                        <option value="0" <?php echo (isset($item['HABILITADO']) && $item['HABILITADO'] == '0') ? 'selected' : ''; ?>>No</option>
                        <option value="1" <?php echo (isset($item['HABILITADO']) && $item['HABILITADO'] == '1') ? 'selected' : ''; ?>>Sí</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="fecha_baja">Fecha de Baja</label>
                    <input type="date" class="form-control" id="fecha_baja" name="fecha_baja"
                    value="<?php echo isset($item['FECHA_BAJA']) ? $item['FECHA_BAJA'] : ''; ?>">
                </div>

                <?php if (isset($_GET['action']) && $_GET['action'] == 'add') { ?>
                    <button type="button" id="AddItemSubmit" class="btn btn-primary">Agregar</button>
                    <?php } else { ?>
                    <button type="button" id="EditItemSubmit" class="btn btn-primary">Guardar</button>
                    <?php  $item['ID_ART'] ?>
                    <!-- se pasa el id de esta manera para que lo tome el ajax, 
                    no esta dentro del form GenNewPass, este no existe solo es para este boton -->
                    <?php } ?>

                <button type="button" class="btn btn-secondary" onclick="history.back()">Volver</button>
            </form>
        </div>

        <div class="form-right">
            <p class="p-h2">Foto</p>
            <img id="previewImagen" src="<?php echo isset($item['URL_ART']) ? './imag/' . $item['URL_ART'] : '#'; ?>" alt="Imagen del Item" onerror="this.style.display='none'">
            <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*">
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

<script>
function generarNumeroItem() {
    // Obtener la categoría seleccionada
    var categoria = document.getElementById("categoria").value;
    console.log("Categoría seleccionada: " + categoria); // Verifica la categoría

    // Llamada AJAX para obtener el código del ítem desde PHP
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./process/ItemGeneraNumero.php", true); // Verifica la ruta del archivo PHP
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            console.log("Estado de la solicitud: " + xhr.status); // Verifica el estado de la solicitud
            if (xhr.status === 200) {
                console.log("Respuesta del servidor: " + xhr.responseText); // Verifica la respuesta del servidor
                document.getElementById("item").value = xhr.responseText;
            }
        }
    };

    // Enviar la categoría seleccionada al archivo PHP
    xhr.send("categoria=" + encodeURIComponent(categoria));
}
</script>



</body>
</html>