/* esto es para que aparezca el loadin girando 
function showLoading() {
    document.getElementById('loading').style.display = 'block';
}*/

/* con esta generamos el nombre del usuario, coloca el nombre y le agrega la primera letra del nombre */
document.addEventListener('DOMContentLoaded', function() {
    const regFullName = document.getElementById('regfullname');
    const regLastName = document.getElementById('reglastname');
    const regName = document.getElementById('regname');

    function generateUsername() {
        const fullName = regFullName.value.trim();
        const lastName = regLastName.value.trim();

        if (fullName && lastName) {
            const firstLetter = fullName.charAt(0).toLowerCase();
            const randomString = Math.random().toString(36).substring(2, 5);
            const username = `${lastName.toLowerCase()}${firstLetter}${randomString}`;
            
            regName.value = username.substring(0, 9); // Asegurarse de que el nombre de usuario no exceda los 9 caracteres
        }
    }
/*esto es el control de contraseña, si las dos no son iguales no se habilita el boton-->*/
    regFullName.addEventListener('input', generateUsername);
    regLastName.addEventListener('input', generateUsername);

    const password = document.getElementById('regpass');
    const confirmPassword = document.getElementById('regpass2');
    const submitButton = document.querySelector('button[type="submit"]');

    function validatePasswords() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity("Las contraseñas no coinciden");
            submitButton.disabled = true;
        } else {
            confirmPassword.setCustomValidity("");
            submitButton.disabled = false;
        }
    }

    password.addEventListener('input', validatePasswords);
    confirmPassword.addEventListener('input', validatePasswords);
});

/*es el envio de informacion del formulario para la registracion-->*/

$(document).ready(function() {  //la carga del documento el ID= del form y el ID= del boton
    $('#RegistracionForm').on('click', '#RegSubmit', function() {
        var formData = {
            formulario: 'RegistracionFrom',
            regdni: $('#regdni').val(),
            regfullname: $('#regfullname').val(),
            reglastname: $('#reglastname').val(),
            regphone: $('#regphone').val(),
            regemail: $('#regemail').val(),
            regdir: $('#regdir').val(),
            regname: $('#regname').val(),
            regpass: $('#regpass').val()
        };

        $.ajax({
            url: './process/ControlRegistracion.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log(response);
                if (response === 'success') {
                    Swal.fire({
                        title: 'Registro',
                        text: 'Se Ingresó al Usuario, ' + formData.regname,
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                } else if (response === 'user_exists') {
                    Swal.fire({
                        title: 'error',
                        text: 'El usuario o el email ya están registrados.',
                        icon: 'error'
                    });
                } else if (response === 'insert_error') {
                    Swal.fire({
                        title: 'error',
                        text: 'No se pudo dar ingreso al usuario por un error en la inserción.',
                        icon: 'error'
                    });
                } else if (response === 'missing_fields') {
                    Swal.fire({
                        title: 'error',
                        text: 'Faltan campos requeridos en el formulario.',
                        icon: 'error'
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'No Se Pudo Dar Ingreso Al Usuario',
                        icon: 'error'
                    });
                }

                // Limpiar los campos del formulario
                $('#RegistracionFrom')[0].reset();
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

