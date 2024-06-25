<?php
$nivel = 1;
require_once 'funciones/configuracion.php';
require_once SESIONES;
if (isset($_SESSION['nivel']) && in_array($_SESSION['nivel'], NIVELES)) {
    require_once FUNCIONES;
    require_once HEADER;
    require_once BARRA;
    require_once NAVEGACION;
    require_once 'modulos/dashboard.php';
    require_once FOOTER;
} else {
    header("Location: acceso_denegado.php");
    exit();
}
?>