<?php 
$dir = __DIR__;
// Usando la ruta relativa
require_once $dir . '/../SQLs/consultasSQL.php';

$modulo = $filtro = null;

// Verificar si 'MODULO' y 'FILTRO' están presentes en el GET
if (isset($_GET['modulo']) && isset($_GET['filtro'])) {
    $modulo = clean_string($_GET['modulo']);
    $filtro = clean_string($_GET['filtro']);
}

?>

<div class="container">
    <div class="page-header">
        <h1>Busqueda de Filtros <small class="tittles-pages-logo"></small></h1>
    </div>
    <div class="row">
        <!-- División izquierda -->
        <div class="col-sm-6">
            <div id="container-form">
                <form id="FiltroForm" class="FiltroForm">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <legend><i class="fa fa-filter"></i> &nbsp; Ingresar Filtro</legend>
                                <div class="fieldset-border">
                                    <div class="form-group label-floating">
                                        <label class="control-label" for="modulo"><i class="fa fa-cogs"></i>&nbsp; Módulo</label>
                                        <input class="form-control" value = "<?php echo $_GET['modulo']?>" id="modulo" type="text" required name="modulo" maxlength="50">
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label" for="filtro"><i class="fa fa-filter"></i>&nbsp; Filtro</label>
                                        <input class="form-control"  value = "<?php echo $_GET['filtro']?>" id="filtro" type="text" required name="filtro" maxlength="50">
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label" for="descripcion"><i class="fa fa-info-circle"></i>&nbsp; Descripción</label>
                                        <input class="form-control" id="descripcion" type="text" required name="descripcion" maxlength="100">
                                    </div>
                                    <button type="button" id="FiltSubmit" class="btn btn-primary">Agregar Filtro</button>
                                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Volver</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- División derecha -->
        <div class="col-sm-6 col-with-border">
            <div class="row">
                <div class="col-sm-12">
                    <p class="text-center lead">Listado de Filtros</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    logError(" Modulo: $modulo | filtro: $filtro ") ;
                    if ($modulo && $filtro): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Módulo</th>
                                    <th>Filtro</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT MODULO, FILTRO, DESCRIPCION FROM filtros WHERE modulo = ? AND filtro = ?";
                                $parametros = [$modulo, $filtro];
                                logError("Intentando ejecutar SQL: $sql | Parámetros: " . print_r($parametros, true));
                                $stmt = ejecutarSQL($sql, $parametros);
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['MODULO']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['FILTRO']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['DESCRIPCION']) . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No se proporcionaron los parámetros necesarios para la búsqueda.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>