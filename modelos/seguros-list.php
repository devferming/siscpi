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

  $usuario = 6;
  $id_alumno = $datos_alum['id'];

  $datos['dir_dir'] = 'CL 23 #55 A44';
  $datos['dir_bar'] = 'COSTATLANTICO';
  $datos['ide_num'] = $init;
  $datos['per_ape'] = $datos['sdo_ape'];
  $datos['sdo_ape'] = '';
  $datos['sdo_nom'] = '';
  $datos['tel_mov'] = '333';
  $datos['alu_mai'] = 'alu@gmail.com';
  $datos['mad_doc'] = $init;
  $datos['mad_nom'] = 'Madre de'.' '.$datos['per_nom'];
  $datos['mad_cel'] = '333';
  $datos['mad_mai'] = 'madre@gmail.com';
  $datos['pad_doc'] = $init;
  $datos['pad_nom'] = 'Padre de'.' '.$datos['per_nom'];
  $datos['pad_cel'] = '333';
  $datos['pad_mai'] = 'padre@gmail.com';
  $datos['acu_doc'] = $init;
  $datos['acu_nom'] = 'Acudiente de'.' '.$datos['per_nom'];
  $datos['acu_cel'] = '333';
  $datos['acu_mai'] = 'acudiente@gmail.com';


  $datos_finales = json_encode($datos);

  $stmt = $conn->prepare("UPDATE siscpi_alumnos SET datos=?, usuario=?, editado=? WHERE id=?");
  $stmt->bind_param('sisi', $datos_finales, $usuario, $hoy, $id_alumno);
  $stmt->execute();

  $init++;
}
