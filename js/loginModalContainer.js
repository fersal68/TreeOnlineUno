$(document).ready(function() {
    // Manejar el formulario de login --- al apretar el boton aparece el formulario login
    $('#loginBtn').on('click', function() {
        $('#loginModalContainer').load('./process/login.php', function() {
            $('#loginModal').modal('show');
        });
    });
    // Manejar el formulario de login ---al apretar el boton del modal - envia la informacion
    $('#loginModalContainer').on('click', '#loginSubmit', function() {
        var username = $('#username').val();
        var password = $('#password').val();
        var formulario = 'FormLogin';

        $.ajax({
            url: './process/ControlIngreso.php',
            type: 'POST',
            data: {
                formulario: formulario,
                username: username,
                password: password
            },
            success: function(response) {
                console.log(response);  // Verifica la respuesta aquí
                if (response.trim() === 'success') {
                    Swal.fire({   //mensaje de 
                        title: 'Login exitoso',
                        text: 'Bienvenido, ' + username,
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });  //mensaje
                } else if (response.trim() === 'change_password') {
                    // Cerrar el modal de login antes de mostrar el formulario de cambio de contraseña
                    $('#loginModal').modal('hide');
                    Swal.fire({
                        title: 'Cambio de Contraseña',
                        html: '<p>Tu cuenta requiere un cambio de contraseña. Por favor, ingresa y confirma tu nueva contraseña.</p>' +
                        '<input type="password" id="newPassword" class="swal2-input" placeholder="Nueva Contraseña" enabled>' +
                        '<input type="password" id="confirmPassword" class="swal2-input" placeholder="Confirmar Contraseña" enabled>',
                        focusConfirm: false,
                        preConfirm: () => {
                            const newPassword = Swal.getPopup().querySelector('#newPassword').value;
                            const confirmPassword = Swal.getPopup().querySelector('#confirmPassword').value;
                            if (!newPassword || !confirmPassword) {
                                Swal.showValidationMessage(`Por favor ingresa ambas contraseñas`);
                            }
                            if (newPassword !== confirmPassword) {
                                Swal.showValidationMessage(`Las contraseñas no coinciden`);
                            }
                            return { newPassword: newPassword, confirmPassword: confirmPassword };
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Cambiar Contraseña',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: './process/process.php',
                                type: 'POST',
                                data: {
                                    formulario: 'ChangePassword',
                                    username: username,  // Pasa el username aquí
                                    newPassword: result.value.newPassword
                                },
                                success: function(response) {
                                    console.log('Response:', response);  // Agrega este console.log para verificar la respuesta
                                    if (response.trim() === 'password_changed') {
                                        Swal.fire({
                                            title: 'Contraseña Actualizada',
                                            text: 'Tu contraseña ha sido actualizada correctamente. Por favor, inicia sesión nuevamente.',
                                            icon: 'success'
                                        }).then(() => {
                                            location.reload();
                                            //window.location.href = 'login.php'; // Redirigir al login
                                        });
                                    } else if (response.trim() === 'password_change_error') {
                                        Swal.fire({
                                            title: 'Error',
                                            text: 'Error: Hubo un Error Al Actualizar La Contraseña.',
                                            icon: 'error'
                                        });
                                    } else if (response.trim() === 'missing_fields') {
                                        Swal.fire({
                                            title: 'Error',
                                            text: 'Error: Faltan campos requeridos en el formulario.',
                                            icon: 'error'
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Error',
                                            text: 'Hubo un problema al actualizar tu contraseña. Por favor, intenta nuevamente.',
                                            icon: 'error'
                                        });
                                    }
                                }
                            });
                        }
                    });
                } else if (response.trim() === 'error_pass') {
                    Swal.fire({   //mensaje de 
                        title: 'Error',
                        text: 'Usuario o contraseña incorrectos.',
                        icon: 'error'
                    });  //mensaje
                } else if (response.trim() === 'error_no') {
                    Swal.fire({   //mensaje de 
                        title: 'Error',
                        text: ' Usuario no encontrado.',
                        icon: 'error'
                    });  //mensaje
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Credenciales incorrectas',
                        icon: 'error'
                    });
                }
                // Limpiar los campos del formulario
                $('#username').val('');
                $('#password').val('');
            },
            error: function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error. Por favor, inténtalo de nuevo.',
                    icon: 'error'
                });
                // Limpiar los campos del formulario
                $('#username').val('');
                $('#password').val('');
            }
        });
    });

    // Alternar visibilidad de la contraseña
    $(document).on('click', '#togglePassword', function() {
        var passwordField = $('#password');
        var passwordToggle = $(this);
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            passwordToggle.removeClass('ri-eye-off-fill').addClass('ri-eye-fill');
        } else {
            passwordField.attr('type', 'password');
            passwordToggle.removeClass('ri-eye-fill').addClass('ri-eye-off-fill');
        }
    });
});