<?php
// Obtener el directorio del archivo actual 
$dir = __DIR__;
//  usando la ruta relativa
require_once $dir . '/../SQLs/consultasSQL.php';

// Columnas a mostrar en la tabla
$columns = ['ID_ART', 'CATEGORIA', 'ITEM', 'DESCRIPCION','OBSERVACION'];
// Nombre de la tabla
$table = "prodes.catalogo";
// Clave principal de la tabla
$id = 'ID_ART';
// Campo a buscar
$campo = isset($_POST['campo']) ? $_POST['campo'] : null;
// Filtrado
$where = '';
if ($campo != null) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}
// Limites
$limit = isset($_POST['registros']) ? $_POST['registros'] : 10;
$pagina = isset($_POST['pagina']) ? $_POST['pagina'] : 0;

if (!$pagina) {
    $inicio = 0;
    $pagina = 1;
} else {
    $inicio = ($pagina - 1) * $limit;
}
$sLimit = "LIMIT $inicio , $limit";
// Ordenamiento
$sOrder = "";
if (isset($_POST['orderCol'])) {
    $orderCol = $_POST['orderCol'];
    $oderType = isset($_POST['orderType']) ? $_POST['orderType'] : 'asc';

    $sOrder = "ORDER BY " . $columns[intval($orderCol)] . ' ' . $oderType;
}
// Consulta
$sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . "
FROM $table $where $sOrder $sLimit";
$resultado = selectSQL($sql);
$num_rows = $resultado->rowCount();
//logError("llega aca: $sql");
// Consulta para total de registros filtrados
$sqlFiltro = "SELECT FOUND_ROWS()";
$resFiltro = selectSQL($sqlFiltro);
$row_filtro = $resFiltro->fetch(PDO::FETCH_NUM);
$totalFiltro = $row_filtro[0];

// Consulta para total de registros
$sqlTotal = "SELECT count($id) FROM $table";
$resTotal = selectSQL($sqlTotal);
$row_total = $resTotal->fetch(PDO::FETCH_NUM);
$totalRegistros = $row_total[0];

// Mostrado resultados
$output = [];
$output['totalRegistros'] = $totalRegistros;
$output['totalFiltro'] = $totalFiltro;
$output['data'] = '';
$output['paginacion'] = '';

if ($num_rows > 0) {
    while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $output['data'] .= '<tr>';
        foreach ($columns as $column) {
            $output['data'] .= '<td>' . htmlspecialchars($row[$column]) . '</td>';  
        }
        $output['data'] .= '<td><a class="btn btn-warning btn-sm" href="?sec=ItemAddEdit&id=' . $row['ID_ART'] . '">
            <i class="ri-edit-2-fill"></i> Editar</a></td>';
        $output['data'] .= '<td><a class="btn btn-danger btn-sm" onclick="confirmDeshabilitar(' . $row['ID_ART'] . ')">
            <i class="ri-delete-bin-5-fill"></i> Eliminar</a></td>';
        $output['data'] .= '</tr>';
    }
} else {
    $output['data'] .= '<tr>';
    $output['data'] .= '<td colspan="7">Sin resultados</td>';
    $output['data'] .= '</tr>';
}

// Paginación
if ($totalRegistros > 0) {
    $totalPaginas = ceil($totalFiltro / $limit);

    $output['paginacion'] .= '<nav>';
    $output['paginacion'] .= '<ul class="pagination">';

    $numeroInicio = max(1, $pagina - 4);
    $numeroFin = min($totalPaginas, $numeroInicio + 9);

    for ($i = $numeroInicio; $i <= $numeroFin; $i++) {
        $output['paginacion'] .= '<li class="page-item' . ($pagina == $i ? ' active' : '') . '">';
        $output['paginacion'] .= '<a class="page-link" href="#" onclick="nextPage(' . $i . ')">' . $i . '</a>';
        $output['paginacion'] .= '</li>';
    }

    $output['paginacion'] .= '</ul>';
    $output['paginacion'] .= '</nav>';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
