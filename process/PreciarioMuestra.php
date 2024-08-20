<?php

// Obtener el directorio del archivo actual 
$dir = __DIR__;
//  usando la ruta relativa
require_once $dir . '/../SQLs/consultasSQL.php';
// Configura la fecha de hoy
$hoy = date('Y-m-d');

// Realiza la consulta
$sql = "SELECT ID_PRE, a.ID_ART, a.DESCRIPCION, PRECIO, FECHA_VIG, FECHA_VTO, URL_ART, OBSERVACION 
        FROM prodes.preciario a 
        INNER JOIN prodes.catalogo b ON a.ID_ART = b.ID_ART 
        WHERE FECHA_VIG <= '$hoy' AND FECHA_VTO >= '$hoy'";

// Ejecuta la consulta
$resultado = selectSQL($sql);


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
.cards-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-between;
}

.card {
    flex: 1 1 calc(33.33% - 20px); /* Ocupa 33.33% del ancho menos el espacio entre tarjetas */
    box-sizing: border-box;
}

@media (max-width: 768px) {
    .card {
        flex: 1 1 calc(50% - 20px); /* Ocupa 50% del ancho en pantallas medianas */
    }
}

@media (max-width: 576px) {
    .card {
        flex: 1 1 100%; /* Ocupa 100% del ancho en pantallas pequeñas */
    }
}

.card img {
    width: 100%;
    height: auto;
}
</style>
    <title>Catálogo de Productos</title>
</head>
<body>

<div class="cards-container">
    <?php
    while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $urlArt = $row['URL_ART'];
        $descripcion = $row['DESCRIPCION'];
        $observacion = $row['OBSERVACION'];
        $precio = $row['PRECIO'];

        echo "
        <div class='card'>
            <img src='./imag/$urlArt' alt='Imagen del artículo'>
            <div class='card-body'>
                <h5 class='card-title'>$descripcion</h5>
                <p class='card-text'>$observacion</p>
                <h6 class='card-subtitle mb-2 text-muted'>Precio: $$precio</h6>
                <div class='d-flex justify-content-between'>
                    <a href='#' class='btn btn-primary'>
                        <i class='ri-shopping-cart-fill'></i> Agregar al carrito
                    </a>
                    <a href='#' class='btn btn-success'>
                        <i class='ri-check-fill'></i> Comprar
                    </a>
                </div>
            </div>
        </div>
        ";
    }
    ?>
</div>

</body>
</html>