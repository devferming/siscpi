<?php
include_once '../funciones/funciones.php';
date_default_timezone_set('America/Bogota');
$hoy = date("Y-m-d H:i:s");

try {

  $stmt = $conn2->prepare("SELECT * FROM alumnos");
  //$stmt->bind_param('s', $mat);
  $stmt->execute();
  $alum_result = $stmt->get_result();

  while ($row_alum = $alum_result->fetch_assoc()) {

    if ($row_alum['alum_grado'] === 'UNDÉCIMO') {

      $id_alumno = $row_alum['alum_id'];

      $stmt = $conn2->prepare("SELECT * FROM acudientes WHERE acu_id_alumno=?");
      $stmt->bind_param('s', $id_alumno);
      $stmt->execute();
      $acu_result = $stmt->get_result();
      $row_acu = $acu_result->fetch_assoc();

      $paren_mad = 'MADRE';
      $paren_pad = 'PADRE';

      $stmt = $conn2->prepare("SELECT * FROM padres WHERE padres_id_alumno=? AND padres_parentesco=?");
      $stmt->bind_param('ss', $id_alumno, $paren_mad);
      $stmt->execute();
      $mad_result = $stmt->get_result();
      $row_mad = $mad_result->fetch_assoc();

      $stmt = $conn2->prepare("SELECT * FROM padres WHERE padres_id_alumno=? AND padres_parentesco=?");
      $stmt->bind_param('ss', $id_alumno, $paren_pad);
      $stmt->execute();
      $pad_result = $stmt->get_result();
      $row_pad = $pad_result->fetch_assoc();

      echo $row_alum['alum_1er_apellido'] . ';' . $row_alum['alum_2do_apellido'] . ';' . $row_alum['alum_1er_nombre'] . ';' . $row_alum['alum_2do_nombre'] . ';' . $row_alum['alum_telf_movil'] . ';' . $row_acu['acu_telf_movil'] . ';' . $row_mad['padres_telf_movil']. ';' . $row_pad['padres_telf_movil'] . '<br>';
    }
  }
} catch (\Exception $e) {
  $error = $e->getMessage();
  echo $error;
}
