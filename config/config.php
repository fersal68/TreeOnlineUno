<?php

//Ruta de la app
define('RUTA_APP', dirname(dirname(__FILE__)))  ;

//Ruta de la url

define('RUTA_URL', '__URL__');

define('NOMBRESITIO', '_NOMBRE_SITIO');


//coneccion a base de datos MySQL
define('MySQL_USER', 'root');
define('MySQL_PASS', 'D3s@rrollo1E');
define('MySQL_BASE', 'mysql:host=localhost;dbname=prodes');


//Seteo del MAIL
define('MAIL', 'comunicado.fs@gmail.com');
define('MAIL_PASS', 'uitwhenymqihrorw');
define('MAIL_NOMBRE', 'comunicadosfs soporte');

//Empresa 
define('NOM_FANTACIA', 'Prode');
define('NOM_FANTACIA_IMG', './images/logo.png');
define('NOM_IMG_PAGINA', './images/logo.ico'); //icono de la pestaña de la pagina
// title
define('TITLE_L', 'ingreso');
// fondo de la aplicacion
define('IMG_FONDO', ''); /*./images/fondo.jpg*/
//footer
define('TITLE_FOOTER', '2024 Desarrollos.F.S.');
// carperta del proyecto
define('RUTA_IMG', '/online/images');




//Ruta donde estan los mensajes de alerta
define('ALERTA', './Alertas/sweetalert.js');


define('CSS', './Consulta_Tabla/js/fresh-table.js');

define('SERVIDOR', 'http://192.1.2.20:81/Pesajeweb/');
define('RUTA_CSS', SERVIDOR.'/public/css/');
define('RUTA_FONTS', SERVIDOR.'/public/css/');
define('RUTA_JS', SERVIDOR.'/public/js');
define('RUTA_ADMLTE', SERVIDOR.'/public/');
define('RUTA_HIGHCHARTS', SERVIDOR.'/public/graficos/');
define('RUTA_INICIO', SERVIDOR.'app/views/usuarios/usuario_login.php');

?>