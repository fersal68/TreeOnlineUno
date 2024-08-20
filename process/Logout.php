<?php



// Proceso de logout
session_start();
session_unset(); // Limpia todas las variables de sesión
session_destroy(); // Destruye la sesión

// Redirigir a la página de inicio con mensaje de confirmación
//header("window.location.href = menu.php");
echo "
<script>
window.location.href = '/online/index.php'; // Ruta absoluta
  
</script>
";
exit();
?>