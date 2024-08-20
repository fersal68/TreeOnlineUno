function confirmLogout() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Saldrás del menú. ¿Estás seguro de continuar?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, salir',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, redirige al script de logout
            window.location.href = './process/Logout.php';
        }
    });
}