<?php
include_once '../funciones/funciones.php';
date_default_timezone_set('America/Bogota');
$hoy = date("Y-m-d H:i:s");
$argumento = 'PRIMERO';


try {
  $stmt = $conn->prepare("SELECT * FROM siscpi_alumnos");
  $stmt->execute();
  $result = $stmt->get_result();
} catch (\Exception $e) {
  $error = $e->getMessage();
  echo $error;
}

$init = 1;
while ($datos_alum = $result->fetch_assoc()) {

  $datos = json_decode($datos_alum['datos'], true);
  echo $init . ';' . $datos['per_ape'] . ';' . $datos['sdo_ape'] . ';' . $datos['per_nom'] . ';' . $datos['sdo_nom']
    . ';' . $datos['nac_fec'].';'.$datos['alu_gen']
    . ';' . $datos['ide_tip'] . ';' . $datos['ide_num'] . ';' . $datos['gra_esc'] . '<br>';

  $init++;
}
