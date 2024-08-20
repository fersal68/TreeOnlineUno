$(document).ready(function() {  //la carga del documento el ID= del form y el ID= del boton
    $('#FiltroForm').on('click', '#FiltSubmit', function() {
    var formData = {
        formulario: 'FiltroForm',
        filModulo: $('#modulo').val(),
        filFiltro: $('#filtro').val(),
        filDescripcion: $('#descripcion').val(),
    };

    $.ajax({
        url: './process/ControlDeMedulos.php',
        type: 'POST',
        data: formData,
        success: function(response) {
            response = response.trim(); // Asegúrate de que no haya espacios en blanco
            console.log('Cleaned Response:', response); // Verifica la respuesta en la consola
            if (response === 'success') {
                Swal.fire({
                    title: 'Registro',
                    text: 'Se Ingresó al Filtro, ' + formData.filDescripcion,
                    icon: 'success'
                }).then(() => {
                    location.reload();
                });
            } else if (response === 'insert_error') {
                Swal.fire({
                    title: 'Error',
                    text: 'No se pudo dar ingreso al Filtro.',
                    icon: 'error'
                });
            } else if (response === 'missing_fields') {
                Swal.fire({
                    title: 'Error',
                    text: 'Faltan campos requeridos en el formulario.',
                    icon: 'error'
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'No Se Pudo Dar Ingreso Al Filtro',
                    icon: 'error'
                });
            }

            // Limpiar los campos del formulario
            $('#FiltroForm')[0].reset();
        },
        error: function() {
            Swal.fire({
                title: 'Error',
                text: 'Ocurrió un error. Por favor, inténtalo de nuevo.',
                icon: 'error'
            });
        }
    });
});


});