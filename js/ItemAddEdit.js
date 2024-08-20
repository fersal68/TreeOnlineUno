$(document).ready(function() {
   /*  $('#FormItemAddEdit').on('click', '#AddItemSubmit', function() {

        var formData = {
            formulario: 'AddItem',
        };*/

        $('#FormItemAddEdit').on('click', '#AddItemSubmit', function() {
            var formData = new FormData($('#FormItemAddEdit')[0]);
            formData.append('formulario', 'AddItem');        

        $.ajax({
            url: './process/ControlDeMedulos.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                response = response.trim(); // Limpiar espacios en blanco

                if (response === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Item agregado exitosamente.',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.location.href = 'catalogo.php'; // Redirige a la página deseada
                    });
                } else if (response === 'file_error') {
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudo subir la Imagen. Controle: formato (jpg, jpeg, png, gif), tamaño máximo 5 MB.',
                        icon: 'error'
                    });
                } else if (response.startsWith('missing_fields|')) {
                    var missingFields = response.split('|')[1];
                    Swal.fire({
                        title: 'Campos faltantes',
                        text: 'Por favor complete los siguientes campos: ' + missingFields,
                        icon: 'warning'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al agregar el item.',
                        confirmButtonText: 'Aceptar'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error en la solicitud.',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });
});