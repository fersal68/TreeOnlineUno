$(document).ready(function() {
    $('#UsuarioAddEdit').on('click', '#AddSubmit', function() {
        var formData = new FormData($('#UsuarioAddEdit')[0]);
        formData.append('formulario', 'UsuarioAddEdit');

        $.ajax({
            url: './process/process.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);  // Muestra la respuesta completa en la consola
                /* de esta manera obtenemos las variames de la respuesta y la podemos mostrar en el formulario*/
                var responseParts = response.split('|'); // Divide la respuesta en partes usando '|' como separador
                var responseCode = responseParts[0]; // Almacena el código de respuesta (ej. 'insert_success')
                var generatedPassword = responseParts[1] || ''; // Toma el Password
                var usuario = responseParts[2] || ''; // Toma el nombre de usuario
                var nombre = responseParts[3] || ''; // Toma el nombre

                if (responseCode === 'insert_success') {
                    Swal.fire({
                        title: 'Registro',
                        text: 'Se ingresó al usuario: '+  usuario +', La contraseña generada es: ' + generatedPassword + ' (guarde esta contraseña).',
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                } else if (response.trim() === 'insert_error') {
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudo dar ingreso al usuario por un error en la inserción.',
                        icon: 'error'
                    });
                }  else if (response.trim() === 'file_error') {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error: El archivo no es una imagen.',
                        icon: 'error'
                    });
                }  else  if (response.trim() === 'file_error_tam') {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error: El archivo es demasiado grande.',
                        icon: 'error'
                    });
                }  else if (response.trim() === 'file_error_formato') {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error: Formato de archivo no permitido. Los que se adminten ("jpg", "jpeg", "png", "gif")',
                        icon: 'error'
                    });
                }  else if (response.trim() === 'file_error_mov') {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error: Al mover el archivo subido.',
                        icon: 'error'
                    });
                }  else if (response.trim() === 'missing_fields') {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error: Faltan campos requeridos en el formulario.',
                        icon: 'error'
                    });
                }  else  if (response.trim() === 'user_exists') {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error: Usuario o email ya existe.',
                        icon: 'error'
                    });
                }  else {
                    Swal.fire({
                        title: 'Error',
                        text: 'No Se Pudo Dar Ingreso Al Usuario',
                        icon: 'error'
                    });
                }
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

    $('#UsuarioAddEdit').on('click', '#EditSubmit', function() {
        var formData = new FormData($('#UsuarioAddEdit')[0]);
        formData.append('formulario', 'UsuarioAddEdit');

        $.ajax({
            url: './process/process.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log("Response from server: ", response);
                if (response.trim() === 'update_success') {
                    Swal.fire({
                        title: 'Registro',
                        text: 'Se Pudo Actualizar al Usuario, ' + formData.get('nombre'),
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                } else if (response.trim() === 'update_error') {
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudo Actualizar al usuario.',
                        icon: 'error'
                    });
                } else if (response.trim() === 'file_error') {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error: El archivo no es una imagen.',
                        icon: 'error'
                    });
                }  else  if (response.trim() === 'file_error_tam') {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error: El archivo es demasiado grande.',
                        icon: 'error'
                    });
                }  else if (response.trim() === 'file_error_formato') {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error: Formato de archivo no permitido. Los que se adminten ("jpg", "jpeg", "png", "gif")',
                        icon: 'error'
                    });
                }  else if (response.trim() === 'file_error_mov') {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error: Al mover el archivo subido.',
                        icon: 'error'
                    });
                }  else if (response.trim() === 'missing_fields') {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error: Faltan campos requeridos en el formulario.',
                        icon: 'error'
                    });
                }  else  if (response.trim() === 'user_exists') {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error: Usuario o email ya existe.',
                        icon: 'error'
                    });
                }  else {
                    Swal.fire({
                        title: 'Error',
                        text: 'No Se Pudo Dar Ingreso Al Usuario',
                        icon: 'error'
                    });
                }
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
    /*   este es para el boton actualiza contraseña*/
    $('#UsuarioAddEdit').on('click', '#GenNewPass', function() {
        var userId = $(this).data('id'); // Obtener el ID del atributo data-id
        var usuario = $('#usuario').val(); // Obtener el nombre de usuario del formulario

        if (!userId) {
            Swal.fire({
                title: 'Error',
                text: 'No se pudo obtener el ID del usuario.',
                icon: 'error'
            });
            return;
        }

        Swal.fire({
            title: 'Advertencia',
            text: 'Si aceptas, se actualizará la contraseña del usuario ' + usuario + '.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData($('#UsuarioAddEdit')[0]);
                formData.append('formulario', 'GenNewPass');
                formData.append('id', userId); // Pasar el ID como parte de formData

        $.ajax({
            url: './process/process.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                var responseParts = response.split('|');
                var responseCode = responseParts[0];
                var generatedPassword = responseParts[1] || '';
                var usuario = responseParts[2] || '';

                if (responseCode === 'genpass_success') {
                    Swal.fire({
                    title: 'Nueva Contraseña',
                    text: 'Se generó una nueva contraseña para el usuario: ' + usuario + '. La nueva contraseña es: ' + generatedPassword + ' (guarde esta contraseña).',
                    icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                    title: 'Error',
                    text: 'No se pudo generar una nueva contraseña.',
                    icon: 'error'
                    });
                        }
                    },
                    error: function() {
                    Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error. Por favor, inténtalo de nuevo.',
                    icon: 'error'
                    });
                    }
                });
            }
        });
    });




});
