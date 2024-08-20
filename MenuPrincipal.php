<?php 
$dir = __DIR__;
require_once $dir . '/config/config.php';
session_start(); // Asegúrate de que la sesión esté iniciada 
// Define $sec si no está definido en $_GET
$sec = isset($_GET['sec']) ? $_GET['sec'] : 'sesiones';
// Definir la URL base
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo NOM_FANTACIA; ?></title>  <!-- aca se coloca el titulo de fom-->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="<?php echo NOM_IMG_PAGINA; ?>">
  <link rel="stylesheet" href="./fonts/remixicon.css"> <!-- Iconos de RemixIcon -->
  <link rel="stylesheet" href="./sweetalert/sweetalert2.min.css">
  <link rel="stylesheet" href="./css/MenuPrincipal.css">
  <!-- <link rel="stylesheet" href="./css/Loading.css">  estilo de la imagen de carga -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Bootstrap CSS (si es necesario) -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">



<script> 
        const baseUrl = '<?php echo $baseUrl; ?>'; // Pasar la URL base a JavaScript // direccion dinamica
  </script>
  <?php    // Carga el CSS específico de la sección si existe
        $cssFile = "./css/" . $sec . ".css";
        if (file_exists($cssFile)) {
            echo '<link rel="stylesheet" href="'.$cssFile.'">';
        } 
  ?>

</head>
<body>

<nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">
  <a class="navbar-brand" href="#"><img src="./images/logo.png" alt="Página de inicio"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="?sec=Registracion">Registrarse</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Admin<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="?sec=Usuarios">Altas</a></li>
          <li><a class="dropdown-item" href="?sec=Filtros">Seteos</a></li>
          <li><a class="dropdown-item" href="?sec=Item">Item</a></li>
          <li><a class="dropdown-item" href="?sec=Preciario">Preciario</a></li>
          <li><a class="dropdown-item" href="?sec=PreciarioMuestra">Catalogo</a></li>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Menu<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Mi Informacion</a></li>
          <li><a class="dropdown-item" href="#">Altas</a></li>
          <li><a class="dropdown-item" href="#">Cambio de contraseña</a></li>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Responsable<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Altas</a></li>
          <li><a class="dropdown-item" href="#">Cuentas de Banco</a></li>
          <li><a class="dropdown-item" href="#">Mi Informacion</a></li>
          <li><a class="dropdown-item" href="#">Resultados</a></li>
          <li><a class="dropdown-item" href="#">Cambio de contraseña</a></li>
        </ul>
      </li>
      <li class="nav-item">
        <!-- <a class="nav-link" href="#">Login</a>-->
        <a class="nav-link" href="#" id="loginBtn"><i class="ri-user-fill"></i><span>Login</span></a>
      </li>
    </ul>
  </div>  
</nav>
<br>

<div class="container content-container">
   <!--  <h3>Aquí va el contenido</h3>
  <p>En esta zona va el contenido de tu página</p>
  <div class="container" id="mainContainer">
        Contenido dinámico cargado aquí -->
        <?php
            if ($_GET) {
                $sec = $_GET["sec"];
                if (file_exists("./process/" . $sec . ".php"))
                    include("./process/" . $sec . ".php");
                elseif (file_exists("./process/" . $sec . ".html"))
                    include("./process/" . $sec . ".html");
                else
                    echo 'Perdón pero la página solicitada no existe';
            } else {
                //include("./process/sesiones.php");
                //include("./process/blank.php");
            }
        ?>
</div>



<footer class="footer">
        <p>Contacto: info@catlover.com | Telefono: (123) 456-7890</p>
        <div class="social-icons">
        <a href="#"><i class="ri-facebook-box-fill"></i><span class="footer-title">Facebook</span></a>
        <a href="#"><i class="ri-instagram-line"></i><span class="footer-title">Instagram</span></a>
    </div>
    <p>&copy; <?php echo TITLE_FOOTER; ?> Todos los derechos reservados.</p>
</footer>

    <!-- Contenedor del modal de login --  -->
    <div id="loginModalContainer"></div>  
    <!-- Modal -->
<script  src="./js/loginModalContainer.js"></script>    

<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    -->
<?php        // Carga el JS específico de la sección si existe
    $jsFile = "./js/" . $sec . ".js";
    if (file_exists($jsFile)) {
    echo '<script src="'.$jsFile.'"></script>';
    }
?>
<script  src="./sweetalert/sweetalertConf.js"></script>
<script  src="./sweetalert/sweetalert2@11.js"></script>


</body>
</html>