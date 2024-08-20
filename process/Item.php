
<?php
// Obtener el directorio del archivo actual 
$dir = __DIR__;
//  usando la ruta relativa

// index.php o el archivo principal de tu proyecto

// Definir la URL base
//$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/';

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <script>
        // Pasar la URL base a JavaScript
        
        //const baseUrl = '<?php echo $baseUrl; ?>';
    </script>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <main>
        <div class="container py-4 text-center">
        <p class="p-h2">Item</p>
            <!-- <h2>Usuarios</h2>-->

            <div class="row g-4">
                <div class="col-auto text-start">
                    <label for="num_registros" class="col-form-label">Mostrar: </label>
                </div>
                <div class="col-auto text-start">
                    <select name="num_registros" id="num_registros" class="form-select">
                        <option value="10">10</option>
                        <option value="250">250</option>
                        <option value="500">500</option>
                        <option value="1000">1000</option>
                    </select>
                </div>
                <div class="col-auto text-start">
                    <label for="num_registros" class="col-form-label">registros </label>
                </div>
                <div class="col-md-4 col-xl-5"></div>
                <div class="col-6 col-md-1 text-end">
                    <label for="campo" class="col-form-label">Buscar: </label>
                </div>
                <div class="col-6 col-md-3 text-end">
                    <input type="text" name="campo" id="campo" class="form-control">
                </div>
                <div class="col-auto">
                <button id="btnAgregarItem" name="btnAgregarItem" class="btn btn-primary d-flex align-items-center" >
                    <!-- existe una funcion le lo envia a una pagina ?sec=UsuarioAddEdit&action=add -->
                    <i class="ri-add-circle-fill"></i>
                    <span>Agregar Item</span>
                </button>
            </div>
            </div>

            <div class="row py-4">
                <div class="col">
                    <table class="table table-sm table-bordered table-striped">
                        <thead>
                            <th class="sort asc">Art. ID</th>
                            <th class="sort asc">Categoria</th>
                            <th class="sort asc">Item</th>
                            <th class="sort asc">Descripcion</th>
                            <th class="sort asc">Observacion</th>
                            <th></th> <!-- aca van los botones editar eliminar -->
                            <th></th> <!-- aca van los botones editar eliminar -->
                        </thead>

                        <!-- El id del cuerpo de la tabla. -->
                        <tbody id="content">

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row justify-content-between">
                <div class="col-12 col-md-4">
                    <label id="lbl-total"></label>
                </div>
                <div class="col-12 col-md-4" id="nav-paginacion"></div>
                <input type="hidden" id="pagina" value="1">
                <input type="hidden" id="orderCol" value="0">
                <input type="hidden" id="orderType" value="asc">
            </div>
        </div>
    </main>

    <!-- Contenedor del modal -->

    <!-- Modal 
    <script  src="./js/FiltroModalContainer.js"></script>    -->
    <script>
        // Llamando a la función getData() al cargar la página
        document.addEventListener("DOMContentLoaded", getData);

        // Función para obtener datos con AJAX
        function getData() {
            let input = document.getElementById("campo").value;
            let num_registros = document.getElementById("num_registros").value;
            let content = document.getElementById("content");
            let pagina = document.getElementById("pagina").value;
            let orderCol = document.getElementById("orderCol").value;
            let orderType = document.getElementById("orderType").value;

            if (orderType == 'asc') {
                orderType = 'desc';
            } else {
                orderType = 'asc';
            }
            let url =  "./process/ItemControl.php"; // toma la direccion de forma dinamica
            //let url = "FiltrosControl.php";
            let formData = new FormData();
            formData.append('campo', input);
            formData.append('registros', num_registros);
            formData.append('pagina', pagina);
            formData.append('orderCol', orderCol);
            formData.append('orderType', orderType);

            fetch(url, {
                    method: "POST",
                    body: formData
                }).then(response => response.json())
                .then(data => {
                    content.innerHTML = data.data;
                    document.getElementById("lbl-total").innerHTML = 'Mostrando ' + data.totalFiltro + ' de ' + data.totalRegistros + ' registros';
                    document.getElementById("nav-paginacion").innerHTML = data.paginacion;
                }).catch(err => console.log(err));
        }

        // Ordenamiento de columna
        document.querySelectorAll(".sort").forEach(th => {
            th.addEventListener("click", function() {
                let orderCol = this.cellIndex;
                let orderType = document.getElementById("orderType").value;
                document.getElementById("orderCol").value = orderCol;
                document.getElementById("orderType").value = orderType;
                getData();
            });
        });

        // Paginación
        function nextPage(pagina) {
            document.getElementById('pagina').value = pagina;
            getData();
        }

        // Número de registros a mostrar
        document.getElementById("num_registros").addEventListener("change", function() {
            document.getElementById("pagina").value = 1;
            getData();
        });

        // Campo de búsqueda
        document.getElementById("campo").addEventListener("keyup", function() {
            document.getElementById("pagina").value = 1;
            getData();
        })

        document.getElementById('btnAgregarItem').addEventListener('click', function() {
    // Aquí puedes abrir un modal o redirigir a otra página
    // Por ejemplo, para abrir un modal:
    //$('#miModalAgregarUsuario').modal('show');
    // O para redirigir a otra página:
     window.location.href = 'MenuPrincipal.php?sec=ItemAddEdit&action=add';
    })
    </script>
    


</body>

</html>
