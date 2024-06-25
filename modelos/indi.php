<?php

include_once '../funciones/funciones.php';
date_default_timezone_set('America/Bogota');
$hoy = date("Y-m-d H:i:s");
$argumento = 'PRIMERO';

// echo '<pre>';
// print_r($row);
// echo '</pre>';

try {

  define('GRADOS', [
    1 => array('PRIMERO', 'PRI', 'mat_logros_pri_p'),
    2 => array('SEGUNDO', 'PRI', 'mat_logros_pri_p'),
    3 => array('TERCERO', 'PRI', 'mat_logros_pri_p'),
    4 => array('CUARTO', 'PRI', 'mat_logros_pri_p'),
    5 => array('QUINTO', 'PRI', 'mat_logros_pri_p'),
    6 => array('SEXTO', 'SEC', 'mat_logros_sec_p'),
    7 => array('SÉPTIMO', 'SEC', 'mat_logros_sec_p'),
    8 => array('OCTAVO', 'SEC', 'mat_logros_sec_p'),
    9 => array('NOVENO', 'BAC', 'mat_logros_sec_p'),
    10 => array('DÉCIMO', 'BAC', 'mat_logros_sec_p'),
    11 => array('UNDÉCIMO', 'BAC', 'mat_logros_sec_p')
    //12 => array('PRE JARDÍN', 'TRA', 'mat_logros_tra_p'),
    //13 => array('JARDÍN', 'TRA', 'mat_logros_tra_p'),
    //14 => array('TRANSICIÓN', 'TRA', 'mat_logros_tra_p'),
  ]);

  $id_usuario = 6;
  $materia = 'INGLÉS';
  $sub_materia = 'LECTORES';
  $per = 'QUINTO';

  $sql = "SELECT * FROM indicadores";
  $result = $conn2->query($sql);

  $array_indicadores = [];
  while ($row = $result->fetch_assoc()) {
    // echo '<pre>';
    // print_r($row);
    // echo '</pre>';

    if ($row['indi_materia'] === $materia) {
 
      foreach (GRADOS as $grados_dat){
        $inper = $row['indi_periodo'];
        $grado = $grados_dat[0];
        $logro = $row['indi_logro'];
        $loniv = 'n'.$row['indi_logro_nivel'];
        $iarea = $row['indi_area'];
        $idesc = $row['indi_logro_descripcion'];

        if ($iarea === 'ACADÉMICO' && $inper === 'FINAL' && $row['indi_grado'] === $grado) {
          if($logro === 'SUPERIOR'){
            $array_indicadores[$sub_materia][$grado][$per][$logro][$loniv]['ftz'] = $idesc;
            $array_indicadores[$sub_materia][$grado][$per][$logro][$loniv]['deb'] = ' ';
          } elseif ($logro === 'ALTO') {
            $array_indicadores[$sub_materia][$grado][$per][$logro][$loniv]['ftz'] = $idesc;
            $array_indicadores[$sub_materia][$grado][$per][$logro][$loniv]['deb'] = ' ';
          } elseif ($logro === 'BÁSICO') {
            $array_indicadores[$sub_materia][$grado][$per][$logro][$loniv]['ftz'] = $idesc;
            $array_indicadores[$sub_materia][$grado][$per][$logro][$loniv]['deb'] = ' ';
          } elseif ($logro === 'BAJO') {
            $array_indicadores[$sub_materia][$grado][$per][$logro][$loniv]['deb'] = $idesc;
          }
        } elseif ($iarea === 'ACTITUDINAL' && $inper === 'FINAL' && $row['indi_grado'] === $grado) {
          if ($logro === 'BAJO' && $row['indi_logro_nivel'] === '1') {
            $array_indicadores[$sub_materia][$grado][$per]['BÁSICO']['n1']['deb'] = $idesc;
          } elseif ($logro === 'BAJO' && $row['indi_logro_nivel'] === '2') {
            $array_indicadores[$sub_materia][$grado][$per]['BÁSICO']['n2']['deb'] = $idesc;
          } elseif ($logro === 'BAJO' && $row['indi_logro_nivel'] === '3') {
            $array_indicadores[$sub_materia][$grado][$per]['BÁSICO']['n3']['deb'] = $idesc;
          } elseif ($logro === 'BÁSICO' && $row['indi_logro_nivel'] === '3') {
            $array_indicadores[$sub_materia][$grado][$per]['BAJO']['n1']['ftz'] = $idesc;
          }
        } elseif ($iarea === 'PROCEDIMENTAL' && $inper === 'FINAL' && $row['indi_grado'] === $grado) {
          if ($logro === 'BÁSICO' && $row['indi_logro_nivel'] === '2') {
            $array_indicadores[$sub_materia][$grado][$per]['BAJO']['n3']['ftz'] = $idesc;
          } elseif ($logro === 'BÁSICO' && $row['indi_logro_nivel'] === '3') {
            $array_indicadores[$sub_materia][$grado][$per]['BAJO']['n2']['ftz'] = $idesc;
          }
        } 
      }
    }
  }
  
  foreach ($array_indicadores as $materia => $datos_materia) {
     foreach ($datos_materia as $grado => $datos_grado) {

      $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
      $stmt->bind_param("ss", $materia, $grado);
      $stmt->execute();
      $result = $stmt->get_result();
      $result2 = $result->fetch_assoc();
      $datos_actuales = json_decode($result2['datos'], true);

      foreach ($datos_grado as $periodo => $datos_periodo) {
        foreach ($datos_periodo as $rendimiento => $datos_rendimiento) {
          foreach ($datos_rendimiento as $nivel => $datos_nivel) {
            foreach ($datos_nivel as $tipo => $descripcion) {
              $datos_actuales[$periodo][$rendimiento][$nivel][$tipo] = $descripcion;
              $datos_actuales[$periodo][$rendimiento][$nivel]['rec'] = $datos_actuales['TERCERO'][$rendimiento][$nivel]['rec'];
            }  
          }
        }
      }

      $id_data = $result2['id'];
      $datos_finales = json_encode($datos_actuales);

      try {
        $stmt = $conn->prepare("UPDATE siscpi_cualitativas SET datos=?, usuario=?, editado=NOW() WHERE id=?");
        $stmt->bind_param("ssi", $datos_finales, $id_usuario, $id_data);
        $stmt->execute();
  
        if ($stmt->affected_rows) {
          $respuesta['respuesta'] = 'exito';
          $respuesta['comentario'] = 'ftz actualizadas correctamente';
        } else {
          $respuesta['respuesta'] = 'error';
          $respuesta['comentario'] = 'ftz no pudieron ser actualizadas';
        }
      } catch (Exception $e) {
        $respuesta['respuesta'] = 'error';
        $respuesta['comentario'] = 'FALLO LA CONSULTA: ' . $e->getMessage();
      }

      echo $respuesta['comentario'].'<br>';

     } 
} 

} catch (\Exception $e) {
  $error = $e->getMessage();
  echo $error;
}
