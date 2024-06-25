<?php

include_once '../funciones/funciones.php';
date_default_timezone_set('America/Bogota');
$hoy = date("Y-m-d H:i:s");
$argumento = 'PRIMERO';


try {

  $stmt_alumnos = $conn->prepare("SELECT * FROM siscpi_alumnos");
  $stmt_alumnos->execute();
  $result_alumnos = $stmt_alumnos->get_result();

  while ($datos = $result_alumnos->fetch_assoc()) {

    $alum_id = $datos['id'];

    $temp_dat = json_decode($datos['datos'], true);
    $temp_dat['gra_sec'] = 'U';

    $temp_new = json_encode($temp_dat);


    $stmt = $conn->prepare("UPDATE siscpi_alumnos SET datos=?, editado= NOW() WHERE id =?");
    $stmt->bind_param("si", $temp_new, $alum_id);
    $stmt->execute();

    $id_registro2 = $stmt->insert_id;

    if ($stmt->affected_rows) {
      $respuesta = array(
        'respuesta' => 'exito',
      );
    } else {
      $respuesta = array(
        'respuesta' => 'error'
      );
    };

    
  }
} catch (\Exception $e) {
  $error = $e->getMessage();
  echo $error;
}


/* 
try {

  
  $id_usuario = 25;
  $per = 1;

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
    11 => array('UNDÉCIMO', 'BAC', 'mat_logros_sec_p'),
    12 => array('PRE JADRÍN', 'TRA', 'mat_logros_tra_p'),
    13 => array('JARDÍN', 'TRA', 'mat_logros_tra_p'),
    14 => array('TRANSICIÓN', 'TRA', 'mat_logros_tra_p'),
  ]);

  define('RENDIMIENTOS', [
    'TRA' => [
        '0' => array('BAJO', 'danger', 3),
        '0.0' => array('BAJO', 'danger', 3),
        '0.1' => array('BAJO', 'danger', 3),
        '0.2' => array('BAJO', 'danger', 3),
        '0.3' => array('BAJO', 'danger', 3),
        '0.4' => array('BAJO', 'danger', 3),
        '0.5' => array('BAJO', 'danger', 3),
        '0.6' => array('BAJO', 'danger', 3),
        '0.7' => array('BAJO', 'danger', 3),
        '0.8' => array('BAJO', 'danger', 3),
        '0.9' => array('BAJO', 'danger', 3),
        '1.0' => array('BAJO', 'danger', 3),
        '1' => array('BAJO', 'danger', 3),
        '1.1' => array('BAJO', 'danger', 3),
        '1.2' => array('BAJO', 'danger', 3),
        '1.3' => array('BAJO', 'danger', 3),
        '1.4' => array('BAJO', 'danger', 3),
        '1.5' => array('BAJO', 'danger', 3),
        '1.6' => array('BAJO', 'danger', 3),
        '1.7' => array('BAJO', 'danger', 3),
        '1.8' => array('BAJO', 'danger', 3),
        '1.9' => array('BAJO', 'danger', 3),
        '2.0' => array('BAJO', 'danger', 3),
        '2' => array('BAJO', 'danger', 3),
        '2.1' => array('BAJO', 'danger', 3),
        '2.2' => array('BAJO', 'danger', 3),
        '2.3' => array('BAJO', 'danger', 3),
        '2.4' => array('BAJO', 'danger', 3),
        '2.5' => array('BAJO', 'danger', 3),
        '2.6' => array('BAJO', 'danger', 3),
        '2.7' => array('BAJO', 'danger', 3),
        '2.8' => array('BAJO', 'danger', 2),
        '2.9' => array('BAJO', 'danger', 2),
        '3.0' => array('BAJO', 'danger', 1),
        '3' => array('BAJO', 'danger', 1),
        '3.1' => array('BAJO', 'danger', 1),
        '3.2' => array('BÁSICO', 'warning', 3),
        '3.3' => array('BÁSICO', 'warning', 3),
        '3.4' => array('BÁSICO', 'warning', 3),
        '3.5' => array('BÁSICO', 'warning', 2),
        '3.6' => array('BÁSICO', 'warning', 2),
        '3.7' => array('BÁSICO', 'warning', 2),
        '3.8' => array('BÁSICO', 'warning', 1),
        '3.9' => array('BÁSICO', 'warning', 1),
        '4.0' => array('ALTO', 'success', 3),
        '4' => array('ALTO', 'success', 3),
        '4.1' => array('ALTO', 'success', 3),
        '4.2' => array('ALTO', 'success', 3),
        '4.3' => array('ALTO', 'success', 2),
        '4.4' => array('ALTO', 'success', 2),
        '4.5' => array('ALTO', 'success', 1),
        '4.6' => array('SUPERIOR', 'dark', 3),
        '4.7' => array('SUPERIOR', 'dark', 3),
        '4.8' => array('SUPERIOR', 'dark', 2),
        '4.9' => array('SUPERIOR', 'dark', 2),
        '5.0' => array('SUPERIOR', 'dark', 1),
        '5' => array('SUPERIOR', 'dark', 1)
    ],
    'PRI' => [
        '0' => array('BAJO', 'danger', 3),
        '0.0' => array('BAJO', 'danger', 3),
        '0.1' => array('BAJO', 'danger', 3),
        '0.2' => array('BAJO', 'danger', 3),
        '0.3' => array('BAJO', 'danger', 3),
        '0.4' => array('BAJO', 'danger', 3),
        '0.5' => array('BAJO', 'danger', 3),
        '0.6' => array('BAJO', 'danger', 3),
        '0.7' => array('BAJO', 'danger', 3),
        '0.8' => array('BAJO', 'danger', 3),
        '0.9' => array('BAJO', 'danger', 3),
        '1.0' => array('BAJO', 'danger', 3),
        '1' => array('BAJO', 'danger', 3),
        '1.1' => array('BAJO', 'danger', 3),
        '1.2' => array('BAJO', 'danger', 3),
        '1.3' => array('BAJO', 'danger', 3),
        '1.4' => array('BAJO', 'danger', 3),
        '1.5' => array('BAJO', 'danger', 3),
        '1.6' => array('BAJO', 'danger', 3),
        '1.7' => array('BAJO', 'danger', 3),
        '1.8' => array('BAJO', 'danger', 3),
        '1.9' => array('BAJO', 'danger', 3),
        '2.0' => array('BAJO', 'danger', 3),
        '2' => array('BAJO', 'danger', 3),
        '2.1' => array('BAJO', 'danger', 3),
        '2.2' => array('BAJO', 'danger', 3),
        '2.3' => array('BAJO', 'danger', 3),
        '2.4' => array('BAJO', 'danger', 3),
        '2.5' => array('BAJO', 'danger', 3),
        '2.6' => array('BAJO', 'danger', 3),
        '2.7' => array('BAJO', 'danger', 3),
        '2.8' => array('BAJO', 'danger', 2),
        '2.9' => array('BAJO', 'danger', 2),
        '3.0' => array('BAJO', 'danger', 1),
        '3' => array('BAJO', 'danger', 1),
        '3.1' => array('BAJO', 'danger', 1),
        '3.2' => array('BÁSICO', 'warning', 3),
        '3.3' => array('BÁSICO', 'warning', 3),
        '3.4' => array('BÁSICO', 'warning', 3),
        '3.5' => array('BÁSICO', 'warning', 2),
        '3.6' => array('BÁSICO', 'warning', 2),
        '3.7' => array('BÁSICO', 'warning', 2),
        '3.8' => array('BÁSICO', 'warning', 1),
        '3.9' => array('BÁSICO', 'warning', 1),
        '4.0' => array('ALTO', 'success', 3),
        '4' => array('ALTO', 'success', 3),
        '4.1' => array('ALTO', 'success', 3),
        '4.2' => array('ALTO', 'success', 3),
        '4.3' => array('ALTO', 'success', 2),
        '4.4' => array('ALTO', 'success', 2),
        '4.5' => array('ALTO', 'success', 1),
        '4.6' => array('SUPERIOR', 'dark', 3),
        '4.7' => array('SUPERIOR', 'dark', 3),
        '4.8' => array('SUPERIOR', 'dark', 2),
        '4.9' => array('SUPERIOR', 'dark', 2),
        '5.0' => array('SUPERIOR', 'dark', 1),
        '5' => array('SUPERIOR', 'dark', 1)
    ],
    'SEC' => [
        '0' => array('BAJO', 'danger', 3),
        '0.0' => array('BAJO', 'danger', 3),
        '0.1' => array('BAJO', 'danger', 3),
        '0.2' => array('BAJO', 'danger', 3),
        '0.3' => array('BAJO', 'danger', 3),
        '0.4' => array('BAJO', 'danger', 3),
        '0.5' => array('BAJO', 'danger', 3),
        '0.6' => array('BAJO', 'danger', 3),
        '0.7' => array('BAJO', 'danger', 3),
        '0.8' => array('BAJO', 'danger', 3),
        '0.9' => array('BAJO', 'danger', 3),
        '1.0' => array('BAJO', 'danger', 3),
        '1' => array('BAJO', 'danger', 3),
        '1.1' => array('BAJO', 'danger', 3),
        '1.2' => array('BAJO', 'danger', 3),
        '1.3' => array('BAJO', 'danger', 3),
        '1.4' => array('BAJO', 'danger', 3),
        '1.5' => array('BAJO', 'danger', 3),
        '1.6' => array('BAJO', 'danger', 3),
        '1.7' => array('BAJO', 'danger', 3),
        '1.8' => array('BAJO', 'danger', 3),
        '1.9' => array('BAJO', 'danger', 3),
        '2.0' => array('BAJO', 'danger', 3),
        '2' => array('BAJO', 'danger', 3),
        '2.1' => array('BAJO', 'danger', 3),
        '2.2' => array('BAJO', 'danger', 3),
        '2.3' => array('BAJO', 'danger', 3),
        '2.4' => array('BAJO', 'danger', 3),
        '2.5' => array('BAJO', 'danger', 3),
        '2.6' => array('BAJO', 'danger', 3),
        '2.7' => array('BAJO', 'danger', 3),
        '2.8' => array('BAJO', 'danger', 3),
        '2.9' => array('BAJO', 'danger', 2),
        '3.0' => array('BAJO', 'danger', 2),
        '3' => array('BAJO', 'danger', 2),
        '3.1' => array('BAJO', 'danger', 2),
        '3.2' => array('BAJO', 'danger', 1),
        '3.3' => array('BAJO', 'danger', 1),
        '3.4' => array('BÁSICO', 'warning', 3),
        '3.5' => array('BÁSICO', 'warning', 3),
        '3.6' => array('BÁSICO', 'warning', 2),
        '3.7' => array('BÁSICO', 'warning', 2),
        '3.8' => array('BÁSICO', 'warning', 1),
        '3.9' => array('BÁSICO', 'warning', 1),
        '4.0' => array('BÁSICO', 'warning', 1),
        '4' => array('BÁSICO', 'warning', 1),
        '4.1' => array('ALTO', 'success', 3),
        '4.2' => array('ALTO', 'success', 3),
        '4.3' => array('ALTO', 'success', 2),
        '4.4' => array('ALTO', 'success', 2),
        '4.5' => array('ALTO', 'success', 1),
        '4.6' => array('SUPERIOR', 'dark', 3),
        '4.7' => array('SUPERIOR', 'dark', 3),
        '4.8' => array('SUPERIOR', 'dark', 2),
        '4.9' => array('SUPERIOR', 'dark', 2),
        '5.0' => array('SUPERIOR', 'dark', 1),
        '5' => array('SUPERIOR', 'dark', 1)
    ],
    'BAC' => [
        '0' => array('BAJO', 'danger', 3),
        '0.0' => array('BAJO', 'danger', 3),
        '0.1' => array('BAJO', 'danger', 3),
        '0.2' => array('BAJO', 'danger', 3),
        '0.3' => array('BAJO', 'danger', 3),
        '0.4' => array('BAJO', 'danger', 3),
        '0.5' => array('BAJO', 'danger', 3),
        '0.6' => array('BAJO', 'danger', 3),
        '0.7' => array('BAJO', 'danger', 3),
        '0.8' => array('BAJO', 'danger', 3),
        '0.9' => array('BAJO', 'danger', 3),
        '1.0' => array('BAJO', 'danger', 3),
        '1' => array('BAJO', 'danger', 3),
        '1.1' => array('BAJO', 'danger', 3),
        '1.2' => array('BAJO', 'danger', 3),
        '1.3' => array('BAJO', 'danger', 3),
        '1.4' => array('BAJO', 'danger', 3),
        '1.5' => array('BAJO', 'danger', 3),
        '1.6' => array('BAJO', 'danger', 3),
        '1.7' => array('BAJO', 'danger', 3),
        '1.8' => array('BAJO', 'danger', 3),
        '1.9' => array('BAJO', 'danger', 3),
        '2.0' => array('BAJO', 'danger', 3),
        '2' => array('BAJO', 'danger', 3),
        '2.1' => array('BAJO', 'danger', 3),
        '2.2' => array('BAJO', 'danger', 3),
        '2.3' => array('BAJO', 'danger', 3),
        '2.4' => array('BAJO', 'danger', 3),
        '2.5' => array('BAJO', 'danger', 3),
        '2.6' => array('BAJO', 'danger', 3),
        '2.7' => array('BAJO', 'danger', 3),
        '2.8' => array('BAJO', 'danger', 3),
        '2.9' => array('BAJO', 'danger', 3),
        '3.0' => array('BAJO', 'danger', 3),
        '3' => array('BAJO', 'danger', 3),
        '3.1' => array('BAJO', 'danger', 2),
        '3.2' => array('BAJO', 'danger', 2),
        '3.3' => array('BAJO', 'danger', 2),
        '3.4' => array('BAJO', 'danger', 2),
        '3.5' => array('BAJO', 'danger', 1),
        '3.6' => array('BAJO', 'danger', 1),
        '3.7' => array('BAJO', 'danger', 1),
        '3.8' => array('BÁSICO', 'warning', 3),
        '3.9' => array('BÁSICO', 'warning', 2),
        '4.0' => array('BÁSICO', 'warning', 1),
        '4' => array('BÁSICO', 'warning', 1),
        '4.1' => array('ALTO', 'success', 3),
        '4.2' => array('ALTO', 'success', 3),
        '4.3' => array('ALTO', 'success', 2),
        '4.4' => array('ALTO', 'success', 2),
        '4.5' => array('ALTO', 'success', 1),
        '4.6' => array('SUPERIOR', 'dark', 3),
        '4.7' => array('SUPERIOR', 'dark', 3),
        '4.8' => array('SUPERIOR', 'dark', 2),
        '4.9' => array('SUPERIOR', 'dark', 2),
        '5.0' => array('SUPERIOR', 'dark', 1),
        '5' => array('SUPERIOR', 'dark', 1)
    ],
  ]);

  $codigos = array(
    "SOCIALES" => "soc",
    "ESPAÑOL" => "esp",
    "MATEMÁTICAS" => "mat",
    "NATURALES" => "nat",
    "INGLÉS" => "ing",
    "INFORMÁTICA" => "inf",
    "ÉTICA Y RELIGIÓN" => "eyr",
    "ARTÍSTICA" => "art",
    "DEPORTE" => "dep",
    "MÚSICA" => "mus",
    "LECTORES" => "lec",
    "PESP" => "psp",
    "GLOBALIZACIÓN" => "glo",
    "CORPORAL" => "cor"
  );

  $alumnos = array();

  $stmt = $conn->prepare("SELECT * FROM siscpi_users WHERE id_login=?");
  $stmt->bind_param("i", $id_usuario );
  $stmt->execute();
  $prof_resultado = $stmt->get_result();
  $prof_row = $prof_resultado->fetch_assoc();
  $prof_dat = json_decode($prof_row['datos'], true);

  foreach ($prof_dat['pro_mat'] as $materia) {

    if (isset($codigos[$materia])) {
      $codMat = $codigos[$materia];
    }

    for ($i = 1; $i < 15; $i++) {

      if (isset(GRADOS[$i])) {
        [$gra, $sec, $log] = GRADOS[$i];
      }
      
        if (isset($prof_dat['on' . $codMat . $i]) ? $prof_dat['on' . $codMat . $i] == 1 : 0) {

          try {

            $stmt_alumnos = $conn->prepare("SELECT * FROM siscpi_alumnos");
            $stmt_alumnos->execute();
            $result_alumnos = $stmt_alumnos->get_result();
            
            while ($row_alumnos = $result_alumnos->fetch_assoc()) {
    
              $temp_dat = json_decode($row_alumnos['datos'], true);
      
              if ($temp_dat['gra_esc'] == $gra) {
                $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
                $stmt->bind_param("i", $row_alumnos['id']);
                $stmt->execute();
                $notas_resultado = $stmt->get_result();
                $notas_row = $notas_resultado->fetch_assoc();
                $temp_not = json_decode($notas_row['datos'], true);

                if (isset($temp_not['p-'.$per]['m-'.$materia])) {
                  $alumnos[$materia][$gra][$row_alumnos['id']] = array('doc' => $temp_dat['ide_num'], 'nom' => $temp_dat['per_ape'].' '.$temp_dat['sdo_ape'].' '.$temp_dat['per_ape'].' '.$temp_dat['sdo_ape'], 'notas' => $temp_not['p-'.$per]['m-'.$materia]);
                }

              }
      
            }
    
            $respuesta = array(
              'respuesta' => 'exito',
              'alumnos' => json_encode($alumnos)
            );
    
          } catch (\Exception $e) {
            $error = $e->getMessage();
            echo $error;
          }
          
  
        }

    }

  }
  

  $arranque = 0;
  $acceso = 8;
  $intentos = 0;
  $status = 'ACTIVO';
  $grado = 'PRIMERO';

  $stmt_alumnos = $conn->prepare("SELECT * FROM siscpi_alumnos");
  $stmt_alumnos->execute();
  $result_alumnos = $stmt_alumnos->get_result();

  while ($datos = $result_alumnos->fetch_assoc()) {

    $temp_dat = json_decode($datos['datos'], true);
    $alum_id = $datos['id'];

    if ($temp_dat['gra_esc'] == $grado && (empty($datos['id_login']) || $datos['id_login'] == 0)) {

      $datos2 = str_replace(".", "", $temp_dat['ide_num']);

      $nombre = $temp_dat['per_nom'] . ' ' . $temp_dat['per_ape'];
      echo $alum_id . ';' . $temp_dat['gra_esc'] . ';' . ' Usuario' . '; ' . $datos2 . ' Password' . '; ' . $datos2 . ' Nombre' . '; ' . $nombre . '<br>';

      $opciones = [
        'cost' => 12,
      ];

      $password_hashed = password_hash($datos2, PASSWORD_BCRYPT, $opciones) . "/n";


      $stmt = $conn->prepare("INSERT INTO siscpi_logins (logins_nickname, logins_nombre, logins_password, logins_nivel, logins_intentos, logins_status, logins_editado) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("sssiiss", $datos2, $nombre, $password_hashed, $acceso, $intentos, $status, $hoy);
      $stmt->execute();

      $id_registro = $stmt->insert_id;

      if ($id_registro > 0) {

        try {

          $stmt = $conn->prepare("UPDATE siscpi_alumnos SET id_login=?, editado= NOW() WHERE id =?");
          $stmt->bind_param("ii", $id_registro, $alum_id);
          $stmt->execute();

          $id_registro2 = $stmt->insert_id;


          if ($stmt->affected_rows) {

            $respuesta = array(
              'respuesta' => 'exito',
            );
          } else {
            $respuesta = array(
              'respuesta' => 'error'
            );
          };
        } catch (Exception $e) {
          echo "Error:" . $e->getMessage();
        }
      } else {
        $respuesta = array(
          'respuesta' => 'error'
        );
      };
    }

  }

  
  $nivel = 8;
  $status = 'BLOQUEADO';
  $intentos = 0;
  $intentos2 = 'ACTIVO';

  $stmt = $conn->prepare("SELECT * FROM siscpi_logins WHERE logins_nivel =? AND logins_status =? ");
  $stmt->bind_param("is", $nivel, $status);
  $stmt->execute();
  $resultado2 = $stmt->get_result();

  while ($datos = $resultado2->fetch_assoc()) {
    $id_alum = $datos['id_login'];
    $stmt = $conn->prepare("UPDATE logins SET logins_intentos=?, logins_status=? WHERE logins_id_login =?");
    $stmt->bind_param("isi", $intentos, $intentos2, $id_alum);
    $stmt->execute();
  }

} catch (\Exception $e) {
  $error = $e->getMessage();
  echo $error;
}
 */