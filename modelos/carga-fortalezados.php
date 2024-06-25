<?php

include_once '../funciones/funciones.php';
date_default_timezone_set('America/Bogota');
$hoy = date("Y-m-d H:i:s");
$argumento = 'PRIMERO';
try {

  $sql = "SELECT * FROM siscpi_cualitativas";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Recorrer todas las filas
    while ($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $datos = json_decode($row['datos'], true );

      $datosArray = $datos['SEGUNDO'];
      $datos['TERCERO'] = $datosArray;
      $datosActualizados = json_encode($datos, JSON_UNESCAPED_UNICODE);

      $sqlUpdate = "UPDATE siscpi_cualitativas SET datos = '$datosActualizados' WHERE id = $id";

      if ($conn->query($sqlUpdate) === TRUE) {
        echo "Los datos han sido actualizados correctamente para la fila con ID: $id<br>";
      } else {
        echo "Error al actualizar los datos para la fila con ID: $id - " . $conn->error . "<br>";
      }
      

    }
  } else {
    echo "No se encontraron resultados.";
  }
  


  /*
  if ($result2->num_rows > 0) {

    $id_usuario = 8;
  
        $materias = array();
        $datos_bd_tra = array();
        $datos_bd_pri = array();
        $datos_bd_sec = array();
        $grados_tra = array("PRE JARDÍN", "JARDÍN", "TRANSICIÓN");
        $grados_pri = array("PRIMERO", "SEGUNDO", "TERCERO", "CUARTO", "QUINTO");
        $grados_sec = array("SEXTO", "SÉPTIMO", "OCTAVO", "NOVENO", "DÉCIMO", "UNDÉCIMO");
        $materias = array("SOCIALES", "ESPAÑOL", "MATEMÁTICAS", "NATURALES", "INGLÉS", "INFORMÁTICA", "ÉTICA Y RELIGIÓN", "ARTÍSTICA", "DEPORTE", "MÚSICA", "LECTORES", "PESP", "GLOBALIZACIÓN", "CORPORAL");

       
        while ($datos = $result2->fetch_assoc()) {

          $mat2 = $datos['notas_cualitativas_materia'];
          $sec = $datos['notas_cualitativas_sector'];
          $per = $datos['notas_cualitativas_periodo'];
          $ren = $datos['notas_cualitativas_rend'];
          $niv = $datos['notas_cualitativas_orden'];
          $fde = $datos['notas_cualitativas_fortalezas'];
          $dde = $datos['notas_cualitativas_debilidades'];
          $rde = $datos['notas_cualitativas_recomendaciones'];
          $mat_ctrl = 0;

          if ($sec === 'TRA') {


            if ($mat2 == 'CIENCIASSOCIALES') {
              $mat = 'SOCIALES';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'LENGUAJE') {
              $mat = 'ESPAÑOL';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'MATEMÁTICAS') {
              $mat = 'MATEMÁTICAS';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'CIENCIASNATURALES') {
              $mat = 'NATURALES';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'INGLÉS') {
              $mat = 'INGLÉS';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'INFORMÁTICA') {
              $mat = 'INFORMÁTICA';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'ÉTICA') {
              $mat = 'ÉTICA Y RELIGIÓN';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'ARTE') {
              $mat = 'ARTÍSTICA';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'DEPORTE') {
              $mat = 'DEPORTE';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'MÚSICA') {
              $mat = 'MÚSICA';
              $mat_ctrl = 1;
            }
  
            if ($mat2 == 'PESP') {
              $mat = 'PESP';
              $mat_ctrl = 1;
            }
  
            if ($mat2 == 'CORPORAL') {
              $mat = 'CORPORAL';
              $mat_ctrl = 1;
            }
  
            if ($mat2 == 'GLOBALIZACIÓN') {
              $mat = 'GLOBALIZACIÓN';
              $mat_ctrl = 1;
            }
  

            $datos_bd_tra[$per][$ren]['n'.$niv]['ftz'] = $fde;
            $datos_bd_tra[$per][$ren]['n'.$niv]['deb'] = $dde;
            $datos_bd_tra[$per][$ren]['n'.$niv]['rec'] = $rde;

            
            foreach ($grados_tra as $key) {

              $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
              $stmt-> bind_param('ss', $mat, $key);
              $stmt->execute();
              $result = $stmt->get_result();

              if ($result->num_rows > 0) {
                $stmt = $conn->prepare("UPDATE siscpi_cualitativas SET datos=?, usuario=?, editado=? WHERE materia=? AND grado=?");
                $stmt->bind_param('sssss', json_encode($datos_bd_tra), $id_usuario, $hoy, $mat, $key);
                $stmt->execute();
              
                if ($stmt->affected_rows) {
                  echo 'Fortalezados actualizados en materia '.$mat.' y grado '.$key;
                }
              } else {
                $stmt = $conn->prepare("INSERT INTO siscpi_cualitativas (materia, grado, datos, usuario, editado) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $mat, $key, json_encode($datos_bd_tra), $id_usuario, $hoy);
                $stmt->execute();

                if ($stmt->affected_rows) {
                  echo 'Fortalezados actualizados en materia '.$mat.' y grado '.$key;
                }
              }
            
              
            }

          }

          if ($sec === 'PRI') {


            if ($mat2 == 'CIENCIASSOCIALES') {
              $mat = 'SOCIALES';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'LENGUAJE') {
              $mat = 'ESPAÑOL';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'MATEMÁTICAS') {
              $mat = 'MATEMÁTICAS';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'CIENCIASNATURALES') {
              $mat = 'NATURALES';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'INGLÉS') {
              $mat = 'INGLÉS';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'INFORMÁTICA') {
              $mat = 'INFORMÁTICA';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'ÉTICA') {
              $mat = 'ÉTICA Y RELIGIÓN';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'ARTE') {
              $mat = 'ARTÍSTICA';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'DEPORTE') {
              $mat = 'DEPORTE';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'MÚSICA') {
              $mat = 'MÚSICA';
              $mat_ctrl = 1;
            }
  
            if ($mat2 == 'PESP') {
              $mat = 'PESP';
              $mat_ctrl = 1;
            }
  
            if ($mat2 == 'CORPORAL') {
              $mat = 'CORPORAL';
              $mat_ctrl = 1;
            }
  
            if ($mat2 == 'GLOBALIZACIÓN') {
              $mat = 'GLOBALIZACIÓN';
              $mat_ctrl = 1;
            }
  

            $datos_bd_pri[$per][$ren]['n'.$niv]['ftz'] = $fde;
            $datos_bd_pri[$per][$ren]['n'.$niv]['deb'] = $dde;
            $datos_bd_pri[$per][$ren]['n'.$niv]['rec'] = $rde;

            
            foreach ($grados_pri as $key) {

              $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
              $stmt-> bind_param('ss', $mat, $key);
              $stmt->execute();
              $result = $stmt->get_result();

              if ($result->num_rows > 0) {
                $stmt = $conn->prepare("UPDATE siscpi_cualitativas SET datos=?, usuario=?, editado=? WHERE materia=? AND grado=?");
                $stmt->bind_param('sssss', json_encode($datos_bd_pri), $id_usuario, $hoy, $mat, $key);
                $stmt->execute();
              
                if ($stmt->affected_rows) {
                  echo 'Fortalezados actualizados en materia '.$mat.' y grado '.$key;
                }
              } else {
                $stmt = $conn->prepare("INSERT INTO siscpi_cualitativas (materia, grado, datos, usuario, editado) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $mat, $key, json_encode($datos_bd_pri), $id_usuario, $hoy);
                $stmt->execute();

                if ($stmt->affected_rows) {
                  echo 'Fortalezados actualizados en materia '.$mat.' y grado '.$key;
                }
              }
            
              
            }


          }

          if ($sec === 'SEC') {


            if ($mat2 == 'CIENCIASSOCIALES') {
              $mat = 'SOCIALES';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'LENGUAJE') {
              $mat = 'ESPAÑOL';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'MATEMÁTICAS') {
              $mat = 'MATEMÁTICAS';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'CIENCIASNATURALES') {
              $mat = 'NATURALES';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'INGLÉS') {
              $mat = 'INGLÉS';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'INFORMÁTICA') {
              $mat = 'INFORMÁTICA';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'ÉTICA') {
              $mat = 'ÉTICA Y RELIGIÓN';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'ARTE') {
              $mat = 'ARTÍSTICA';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'DEPORTE') {
              $mat = 'DEPORTE';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'MÚSICA') {
              $mat = 'MÚSICA';
              $mat_ctrl = 1;
            }
  
            if ($mat2 == 'PESP') {
              $mat = 'PESP';
              $mat_ctrl = 1;
            }
  
            if ($mat2 == 'CORPORAL') {
              $mat = 'CORPORAL';
              $mat_ctrl = 1;
            }
  
            if ($mat2 == 'GLOBALIZACIÓN') {
              $mat = 'GLOBALIZACIÓN';
              $mat_ctrl = 1;
            }
  

            $datos_bd_sec[$per][$ren]['n'.$niv]['ftz'] = $fde;
            $datos_bd_sec[$per][$ren]['n'.$niv]['deb'] = $dde;
            $datos_bd_sec[$per][$ren]['n'.$niv]['rec'] = $rde;

            foreach ($grados_sec as $key) {

              $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
              $stmt-> bind_param('ss', $mat, $key);
              $stmt->execute();
              $result = $stmt->get_result();

              if ($result->num_rows > 0) {
                $stmt = $conn->prepare("UPDATE siscpi_cualitativas SET datos=?, usuario=?, editado=? WHERE materia=? AND grado=?");
                $stmt->bind_param('sssss', json_encode($datos_bd_sec), $id_usuario, $hoy, $mat, $key);
                $stmt->execute();
              
                if ($stmt->affected_rows) {
                  echo 'Fortalezados actualizados en materia '.$mat.' y grado '.$key;
                }
              } else {
                $stmt = $conn->prepare("INSERT INTO siscpi_cualitativas (materia, grado, datos, usuario, editado) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $mat, $key, json_encode($datos_bd_sec), $id_usuario, $hoy);
                $stmt->execute();

                if ($stmt->affected_rows) {
                  echo 'Fortalezados actualizados en materia '.$mat.' y grado '.$key;
                }
              }
            
              
            }



          }

        }
        



  };
  */

  /*
  if ($result2->num_rows > 0) {

    $id_usuario = 8;

    $materias = array();
    $datos_bd_tra = array();
    $datos_bd_pri = array();
    $datos_bd_sec = array();
    $grados_tra = array("PRE JARDÍN", "JARDÍN", "TRANSICIÓN");
    $grados_pri = array("PRIMERO", "SEGUNDO", "TERCERO", "CUARTO", "QUINTO");
    $grados_sec = array("SEXTO", "SÉPTIMO", "OCTAVO", "NOVENO", "DÉCIMO", "UNDÉCIMO");
    $materias = array("SOCIALES", "ESPAÑOL", "MATEMÁTICAS", "NATURALES", "INGLÉS", "INFORMÁTICA", "ÉTICA Y RELIGIÓN", "ARTÍSTICA", "DEPORTE", "MÚSICA", "LECTORES", "PESP", "GLOBALIZACIÓN", "CORPORAL");


    while ($datos = $result2->fetch_assoc()) {

      $mat2 = $datos['notas_cualitativas_materia'];
      $sec = $datos['notas_cualitativas_sector'];
      $per = $datos['notas_cualitativas_periodo'];
      $ren = $datos['notas_cualitativas_rend'];
      $niv = $datos['notas_cualitativas_orden'];
      $fde = $datos['notas_cualitativas_fortalezas'];
      $dde = $datos['notas_cualitativas_debilidades'];
      $rde = $datos['notas_cualitativas_recomendaciones'];
      $mat_ctrl = 0;

      if ($mat2 === 'MÚSICA') {
        $mat = 'MÚSICA';
        $mat_ctrl = 1;

        /*
        if ($sec === 'TRA') {

          $datos_bd_tra[$per][$ren]['n' . $niv]['ftz'] = $fde;
          $datos_bd_tra[$per][$ren]['n' . $niv]['deb'] = $dde;
          $datos_bd_tra[$per][$ren]['n' . $niv]['rec'] = $rde;


          foreach ($grados_tra as $key) {

            $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
            $stmt->bind_param('ss', $mat, $key);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
              $stmt = $conn->prepare("UPDATE siscpi_cualitativas SET datos=?, usuario=?, editado=? WHERE materia=? AND grado=?");
              $stmt->bind_param('sssss', json_encode($datos_bd_tra), $id_usuario, $hoy, $mat, $key);
              $stmt->execute();

              if ($stmt->affected_rows) {
                echo 'Fortalezados actualizados en materia ' . $mat . ' y grado ' . $key;
              }
            } else {
              $stmt = $conn->prepare("INSERT INTO siscpi_cualitativas (materia, grado, datos, usuario, editado) VALUES (?, ?, ?, ?, ?)");
              $stmt->bind_param("sssss", $mat, $key, json_encode($datos_bd_tra), $id_usuario, $hoy);
              $stmt->execute();

              if ($stmt->affected_rows) {
                echo 'Fortalezados actualizados en materia ' . $mat . ' y grado ' . $key;
              }
            }
          }
        }
        

        if ($sec === 'PRI') {

          $datos_bd_pri[$per][$ren]['n' . $niv]['ftz'] = $fde;
          $datos_bd_pri[$per][$ren]['n' . $niv]['deb'] = $dde;
          $datos_bd_pri[$per][$ren]['n' . $niv]['rec'] = $rde;


          foreach ($grados_pri as $key) {

            $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
            $stmt->bind_param('ss', $mat, $key);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
              $stmt = $conn->prepare("UPDATE siscpi_cualitativas SET datos=?, usuario=?, editado=? WHERE materia=? AND grado=?");
              $stmt->bind_param('sssss', json_encode($datos_bd_pri), $id_usuario, $hoy, $mat, $key);
              $stmt->execute();

              if ($stmt->affected_rows) {
                echo 'Fortalezados actualizados en materia ' . $mat . ' y grado ' . $key;
              }
            } else {
              $stmt = $conn->prepare("INSERT INTO siscpi_cualitativas (materia, grado, datos, usuario, editado) VALUES (?, ?, ?, ?, ?)");
              $stmt->bind_param("sssss", $mat, $key, json_encode($datos_bd_pri), $id_usuario, $hoy);
              $stmt->execute();

              if ($stmt->affected_rows) {
                echo 'Fortalezados actualizados en materia ' . $mat . ' y grado ' . $key;
              }
            }
          }
        }

        if ($sec === 'SEC') {

          $datos_bd_sec[$per][$ren]['n' . $niv]['ftz'] = $fde;
          $datos_bd_sec[$per][$ren]['n' . $niv]['deb'] = $dde;
          $datos_bd_sec[$per][$ren]['n' . $niv]['rec'] = $rde;

          foreach ($grados_sec as $key) {

            $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
            $stmt->bind_param('ss', $mat, $key);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
              $stmt = $conn->prepare("UPDATE siscpi_cualitativas SET datos=?, usuario=?, editado=? WHERE materia=? AND grado=?");
              $stmt->bind_param('sssss', json_encode($datos_bd_sec), $id_usuario, $hoy, $mat, $key);
              $stmt->execute();

              if ($stmt->affected_rows) {
                echo 'Fortalezados actualizados en materia ' . $mat . ' y grado ' . $key;
              }
            } else {
              $stmt = $conn->prepare("INSERT INTO siscpi_cualitativas (materia, grado, datos, usuario, editado) VALUES (?, ?, ?, ?, ?)");
              $stmt->bind_param("sssss", $mat, $key, json_encode($datos_bd_sec), $id_usuario, $hoy);
              $stmt->execute();

              if ($stmt->affected_rows) {
                echo 'Fortalezados actualizados en materia ' . $mat . ' y grado ' . $key;
              }
            }
          }
        }
      }

    }

  };
  */


  /*
  if ($result2->num_rows > 0) {

    $id_usuario = 8;

    $materias = array();
    $datos_bd_tra = array();
    $datos_bd_pri = array();
    $datos_bd_sec = array();
    $grados_tra = array("PRE JARDÍN", "JARDÍN", "TRANSICIÓN");
    $grados_pri = array("PRIMERO", "SEGUNDO", "TERCERO", "CUARTO", "QUINTO");
    $grados_sec = array("SEXTO", "SÉPTIMO", "OCTAVO", "NOVENO", "DÉCIMO", "UNDÉCIMO");
    $materias = array("SOCIALES", "ESPAÑOL", "MATEMÁTICAS", "NATURALES", "INGLÉS", "INFORMÁTICA", "ÉTICA Y RELIGIÓN", "ARTÍSTICA", "DEPORTE", "MÚSICA", "LECTORES", "PESP", "GLOBALIZACIÓN", "CORPORAL");


    while ($datos = $result2->fetch_assoc()) {

      $sec = $datos['notas_cualitativas_sector'];
      $mat_ctrl = 0;

      if ($sec === 'TRA') {

        $mat2 = $datos['notas_cualitativas_materia'];
        $per = $datos['notas_cualitativas_periodo'];
        $ren2 = $datos['notas_cualitativas_rend'];
        $niv = $datos['notas_cualitativas_orden'];
        $fde = $datos['notas_cualitativas_fortalezas'];
        $dde = $datos['notas_cualitativas_debilidades'];
        $rde = $datos['notas_cualitativas_recomendaciones'];
        $mat_ctrl = 0;

        if ($ren2 == 'BASICO') {
          $ren = 'BÁSICO';
        } else {
          $ren = $ren2;
        }


        if ($mat2 == 'MATEMÁTICAS') {
          $mat = 'MATEMÁTICAS';
          $mat_ctrl = 1;
        }

        if ($mat2 == 'INGLÉS') {
          $mat = 'INGLÉS';
          $mat_ctrl = 1;
        }

        if ($mat2 == 'ARTE') {
          $mat = 'ARTÍSTICA';
          $mat_ctrl = 1;
        }

        if ($mat2 == 'PESP') {
          $mat = 'PESP';
          $mat_ctrl = 1;
        }

        if ($mat2 == 'CORPORAL') {
          $mat = 'CORPORAL';
          $mat_ctrl = 1;
        }

        if ($mat2 == 'GLOBALIZACIÓN') {
          $mat = 'GLOBALIZACIÓN';
          $mat_ctrl = 1;
        }

        $datos_bd_tra[$per][$ren]['n' . $niv]['ftz'] = $fde;
        $datos_bd_tra[$per][$ren]['n' . $niv]['deb'] = $dde;
        $datos_bd_tra[$per][$ren]['n' . $niv]['rec'] = $rde;

        $datos_bd_tra[$per][$ren]['n' . 2]['ftz'] = $fde;
        $datos_bd_tra[$per][$ren]['n' . 2]['deb'] = $dde;
        $datos_bd_tra[$per][$ren]['n' . 2]['rec'] = $rde;

        $datos_bd_tra[$per][$ren]['n' . 3]['ftz'] = $fde;
        $datos_bd_tra[$per][$ren]['n' . 3]['deb'] = $dde;
        $datos_bd_tra[$per][$ren]['n' . 3]['rec'] = $rde;


        

        if ($mat_ctrl === 1) {
          foreach ($grados_tra as $key) {

            $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
            $stmt->bind_param('ss', $mat, $key);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
              $stmt = $conn->prepare("UPDATE siscpi_cualitativas SET datos=?, usuario=?, editado=? WHERE materia=? AND grado=?");
              $stmt->bind_param('sssss', json_encode($datos_bd_tra), $id_usuario, $hoy, $mat, $key);
              $stmt->execute();

              if ($stmt->affected_rows) {
                echo 'Fortalezados actualizados en materia ' . $mat . ' y grado ' . $key;
              }
            } else {
              $stmt = $conn->prepare("INSERT INTO siscpi_cualitativas (materia, grado, datos, usuario, editado) VALUES (?, ?, ?, ?, ?)");
              $stmt->bind_param("sssss", $mat, $key, json_encode($datos_bd_tra), $id_usuario, $hoy);
              $stmt->execute();

              if ($stmt->affected_rows) {
                echo 'Fortalezados actualizados en materia ' . $mat . ' y grado ' . $key;
              }
            }
          }
        }

      }
    }
  };
  */
} catch (\Exception $e) {
  $error = $e->getMessage();
  echo $error;
}
