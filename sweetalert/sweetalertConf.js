function showAlert(title, text, icon) {
    Swal.fire({
        title: `<h2 style="color: #d4af37; text-shadow: 1px 1px 2px #000; padding-bottom: 10px; margin-bottom: 20px;">${title}</h2>`,
        html: text,
        icon: icon,
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#d4af37',
        background: '#fff',
        customClass: {
            popup: 'sweetalert-custom-popup'
        }
    });
}
