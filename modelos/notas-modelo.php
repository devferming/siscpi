<?php
session_start();

if (!isset($_SESSION["usuario"]) || !isset($_SESSION["logid"]) || ($_SESSION["nivel"] != 6 && $_SESSION["nivel"] != 3 && $_SESSION["nivel"] != 1 && $_SESSION["nivel"] != 5)) {
  die(json_encode(array('respuesta' => "error", 'comentario' => "Permiso denegado")));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  include_once '../funciones/funciones.php';
  $nivel = 1;
  require_once '../funciones/configuracion.php';
  date_default_timezone_set('America/Bogota');
  $hoy = date("Y-m-d H:i:s");

  $data = json_decode(file_get_contents('php://input'), true);
  $respuesta = array();

  $valores_permitidos = array("ftznuevo", "notnueva", "ftzatc", "sqlftz", "regconv", "actconv", "regicfes", "acticonv", "alumnotsql", "sqlcnv", "planilla", 'regnov');


  if (!in_array($data['cmd'], $valores_permitidos)) {
    die(json_encode(array('respuesta' => "error", 'comentario' => "Comando no válido")));
  }

  if (!isset($data["user_id"]) || !is_numeric($data["user_id"])) {
    die(json_encode(array('respuesta' => "error", 'comentario' => "Id de Usuario no válido")));
  }

  if ($data["user_id"] != $_SESSION["logid"]) {
    die(json_encode(array('respuesta' => "error", 'comentario' => "Id de Usuario no válido")));
  }

  //Ejecuta actualización de fotalezado
  if ($data['cmd'] == 'ftznuevo') {

    $id_usuario = $data['user_id'];

    unset($data['user_id']);
    unset($data['cmd']);

    $mat = strtoupper(preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ () ])', '', $data['mat']));
    $gra = strtoupper(preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ () ])', '', $data['gra']));
    $per = strtoupper(preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ () ])', '', $data['per']));
    $ren = strtoupper(preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ () ])', '', $data['ren']));
    $niv = preg_replace('([^A-Za-z0-9 () ])', '', $data['niv']);
    $tip = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ () ])', '', $data['tip']);
    $des = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 , . # ( ) - ])', '', $data['des']);

    $ftz_des = '';
    if ($tip == 'ftz') {
      $ftz_des = 'FORTALEZAS';
    } elseif ($tip == 'deb') {
      $ftz_des = 'DEBILIDADES';
    } elseif ($tip == 'rec') {
      $ftz_des = 'RECOMENDACIONES';
    }

    $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
    $stmt->bind_param("ss", $mat, $gra);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
      $stmt->close();
      $stmt = $conn->prepare("INSERT INTO siscpi_cualitativas (materia, grado, usuario, editado) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $mat, $gra, $id_usuario, $hoy);
      $stmt->execute();

      if ($stmt->affected_rows > 0) {
        $stmt->close();

        $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
        $stmt->bind_param("ss", $mat, $gra);
        $stmt->execute();
        $result = $stmt->get_result();
      } else {
        $respuesta['respuesta'] = 'error';
        $respuesta['comentario'] = 'Error COD: E000X2, CONTACTE CON SOPORTE TÉCNICO';
        die(json_encode($respuesta));
      }
    }

    $result2 = $result->fetch_assoc();
    $datos = json_decode($result2['datos'], true);

    $id_data = $result2['id'];
    $data_nueva = $datos;
    $data_nueva[$per][$ren][$niv][$tip] = $des;
    $datos_finales = json_encode($data_nueva);

    try {
      $stmt = $conn->prepare("UPDATE siscpi_cualitativas SET datos=?, usuario=?, editado=NOW() WHERE id=?");
      $stmt->bind_param("ssi", $datos_finales, $id_usuario, $id_data);
      $stmt->execute();

      if ($stmt->affected_rows) {
        $respuesta['respuesta'] = 'exito';
        $respuesta['comentario'] = $ftz_des . ' actualizadas correctamente';
      } else {
        $respuesta['respuesta'] = 'error';
        $respuesta['comentario'] = 'Las ' . $ftz_des . ' no pudieron ser actualizadas';
      }
    } catch (Exception $e) {
      $respuesta['respuesta'] = 'error';
      $respuesta['comentario'] = 'FALLO LA CONSULTA: ' . $e->getMessage();
    }

    $stmt->close();

    die(json_encode($respuesta));
  }

  //Ejecuta actualización de notas
  if ($data['cmd'] == 'notnueva') {

    $id_usuario = $data['user_id'];
    unset($data['user_id']);
    unset($data['cmd']);

    $ev1 = preg_replace('([^0-9.])', '', $data['ev1']);
    $ev2 = preg_replace('([^0-9.])', '', $data['ev2']);
    $ev3 = preg_replace('([^0-9.])', '', $data['ev3']);
    $ev4 = preg_replace('([^0-9.])', '', $data['ev4']);
    $ev5 = preg_replace('([^0-9.])', '', $data['ev5']);
    $ida = filter_var($data['ida'], FILTER_VALIDATE_INT);
    $per = filter_var($data['per'], FILTER_VALIDATE_INT);
    $log = filter_var($data['log'], FILTER_VALIDATE_INT);
    $lfn = filter_var($data['lfn'], FILTER_VALIDATE_INT);
    $mat = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ ])', '', $data['mat']);
    $grd = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ ])', '', $data['grd']);

    $periodos = ['PRIMERO', 'SEGUNDO', 'TERCERO', 'CUARTO'];
    $periodo = isset($periodos[$per - 1]) ? $periodos[$per - 1] : '';

    function calDef($conn, $per, $mat, $lfn, $ida, $grd, $hoy, $ev1, $ev2, $ev3, $ev4, $ev5, $periodo, $id_usuario)
    {
      $in = 1;
      $fn = $lfn;
      $acumulada = 0;

      $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
      $stmt->bind_param("i", $ida);
      $stmt->execute();
      $notas_resultado = $stmt->get_result();
      $notas_detalle = $notas_resultado->fetch_assoc();
      $notas = [];

      if ($notas_resultado->num_rows > 0) {
        $notas = json_decode($notas_detalle['datos'], true);
      }

      for ($i = $in; $i <= $fn; $i++) {

        $notas_l = array();

        if (isset($notas['p-' . $per]['m-' . $mat]['l-' . $i])) {
          $notas_l = $notas['p-' . $per]['m-' . $mat]['l-' . $i];
        }

        $nota_ev1 = $notas_l['ev1'] ?? 0;
        $nota_ev2 = $notas_l['ev2'] ?? 0;
        $nota_ev3 = $notas_l['ev3'] ?? 0;
        $nota_ev4 = $notas_l['ev4'] ?? 0;
        $nota_ev5 = $notas_l['ev5'] ?? 0;

        $nota_ev1 = empty($nota_ev1) ? 0 : $nota_ev1;
        $nota_ev2 = empty($nota_ev2) ? 0 : $nota_ev2;
        $nota_ev3 = empty($nota_ev3) ? 0 : $nota_ev3;
        $nota_ev4 = empty($nota_ev4) ? 0 : $nota_ev4;
        $nota_ev5 = empty($nota_ev5) ? 0 : $nota_ev5;

        $def70 = number_format(($nota_ev1 + $nota_ev2 + $nota_ev3) / 3 * 0.7, 2, '.', '');
        $def20 = number_format($nota_ev4 * 0.2, 2, '.', '');
        $def10 = number_format($nota_ev5 * 0.1, 2, '.', '');
        $def2 = number_format($def70 + $def20 + $def10, 1, '.', '');
        $acumulada += $def2;
      }

      $final = number_format($acumulada / $lfn, 1, '.', '');
      $notas['p-' . $per]['m-' . $mat]['ncn'] = $final;

      $rendimiento = '';
      $bandera = '';
      $cualitativo = 0;

      $final = number_format((float)$acumulada / $lfn, 1, '.', '');
      $notas['p-' . $per]['m-' . $mat]['ncn'] = $final;

      if ($grd == 'PRIMERO' || $grd == 'SEGUNDO' || $grd == 'TERCERO' || $grd == 'CUARTO' || $grd == 'QUINTO' || $grd == 'PRE JARDÍN' || $grd == 'JARDÍN' || $grd == 'TRANSICIÓN') {
        if ($final <= 2.7) {
          $rendimiento = 'BAJO';
          $bandera = 'danger';
          $cualitativo = 3;
        } elseif ($final >= 2.8 and $final <= 2.9) {
          $rendimiento = 'BAJO';
          $bandera = 'danger';
          $cualitativo = 2;
        } elseif ($final >= 3 and $final <= 3.1) {
          $rendimiento = 'BAJO';
          $bandera = 'danger';
          $cualitativo = 1;
        } elseif ($final >= 3.2 and $final <= 3.4) {
          $rendimiento = 'BÁSICO';
          $bandera = 'warning';
          $cualitativo = 3;
        } elseif ($final >= 3.5 and $final <= 3.7) {
          $rendimiento = 'BÁSICO';
          $bandera = 'warning';
          $cualitativo = 2;
        } elseif ($final >= 3.8 and $final <= 3.9) {
          $rendimiento = 'BÁSICO';
          $bandera = 'warning';
          $cualitativo = 1;
        } elseif ($final >= 4 and $final <= 4.2) {
          $rendimiento = 'ALTO';
          $bandera = 'success';
          $cualitativo = 3;
        } elseif ($final >= 4.3 and $final <= 4.4) {
          $rendimiento = 'ALTO';
          $bandera = 'success';
          $cualitativo = 2;
        } elseif ($final == 4.5) {
          $rendimiento = 'ALTO';
          $bandera = 'success';
          $cualitativo = 1;
        } elseif ($final >= 4.6 and $final <= 4.7) {
          $rendimiento = 'SUPERIOR';
          $bandera = 'dark';
          $cualitativo = 3;
        } elseif ($final >= 4.8 and $final <= 4.9) {
          $rendimiento = 'SUPERIOR';
          $bandera = 'dark';
          $cualitativo = 2;
        } elseif ($final == 5) {
          $rendimiento = 'SUPERIOR';
          $bandera = 'dark';
          $cualitativo = 1;
        }
      } elseif ($grd == 'SEXTO' || $grd == 'SÉPTIMO' || $grd == 'OCTAVO') {
        if ($final <= 2.8) {
          $rendimiento = 'BAJO';
          $bandera = 'danger';
          $cualitativo = 3;
        } elseif ($final >= 2.9 and $final <= 3.1) {
          $rendimiento = 'BAJO';
          $bandera = 'danger';
          $cualitativo = 2;
        } elseif ($final >= 3.2 and $final <= 3.3) {
          $rendimiento = 'BAJO';
          $bandera = 'danger';
          $cualitativo = 1;
        } elseif ($final >= 3.4 and $final <= 3.5) {
          $rendimiento = 'BÁSICO';
          $bandera = 'warning';
          $cualitativo = 3;
        } elseif ($final >= 3.6 and $final <= 3.7) {
          $rendimiento = 'BÁSICO';
          $bandera = 'warning';
          $cualitativo = 2;
        } elseif ($final >= 3.8 and $final <= 4) {
          $rendimiento = 'BÁSICO';
          $bandera = 'warning';
          $cualitativo = 1;
        } elseif ($final >= 4.1 and $final <= 4.2) {
          $rendimiento = 'ALTO';
          $bandera = 'success';
          $cualitativo = 3;
        } elseif ($final >= 4.3 and $final <= 4.4) {
          $rendimiento = 'ALTO';
          $bandera = 'success';
          $cualitativo = 2;
        } elseif ($final == 4.5) {
          $rendimiento = 'ALTO';
          $bandera = 'success';
          $cualitativo = 1;
        } elseif ($final >= 4.6 and $final <= 4.7) {
          $rendimiento = 'SUPERIOR';
          $bandera = 'dark';
          $cualitativo = 3;
        } elseif ($final >= 4.8 and $final <= 4.9) {
          $rendimiento = 'SUPERIOR';
          $bandera = 'dark';
          $cualitativo = 2;
        } elseif ($final == 5) {
          $rendimiento = 'SUPERIOR';
          $bandera = 'dark';
          $cualitativo = 1;
        }
      } elseif ($grd == 'NOVENO' || $grd == 'DÉCIMO' || $grd == 'UNDÉCIMO') {
        if ($final <= 3) {
          $rendimiento = 'BAJO';
          $bandera = 'danger';
          $cualitativo = 3;
        } elseif ($final >= 3.1 and $final <= 3.4) {
          $rendimiento = 'BAJO';
          $bandera = 'danger';
          $cualitativo = 2;
        } elseif ($final >= 3.5 and $final <= 3.7) {
          $rendimiento = 'BAJO';
          $bandera = 'danger';
          $cualitativo = 1;
        } elseif ($final == 3.8) {
          $rendimiento = 'BÁSICO';
          $bandera = 'warning';
          $cualitativo = 3;
        } elseif ($final == 3.9) {
          $rendimiento = 'BÁSICO';
          $bandera = 'warning';
          $cualitativo = 2;
        } elseif ($final == 4) {
          $rendimiento = 'BÁSICO';
          $bandera = 'warning';
          $cualitativo = 1;
        } elseif ($final >= 4.1 and $final <= 4.2) {
          $rendimiento = 'ALTO';
          $bandera = 'success';
          $cualitativo = 3;
        } elseif ($final >= 4.3 and $final <= 4.4) {
          $rendimiento = 'ALTO';
          $bandera = 'success';
          $cualitativo = 2;
        } elseif ($final == 4.5) {
          $rendimiento = 'ALTO';
          $bandera = 'success';
          $cualitativo = 1;
        } elseif ($final >= 4.6 and $final <= 4.7) {
          $rendimiento = 'SUPERIOR';
          $bandera = 'dark';
          $cualitativo = 3;
        } elseif ($final >= 4.8 and $final <= 4.9) {
          $rendimiento = 'SUPERIOR';
          $bandera = 'dark';
          $cualitativo = 2;
        } elseif ($final == 5) {
          $rendimiento = 'SUPERIOR';
          $bandera = 'dark';
          $cualitativo = 1;
        }
      }

      $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
      $stmt->bind_param("ss", $mat, $grd);
      $stmt->execute();
      $result = $stmt->get_result();
      $banco = $result->fetch_assoc();

      $notas_clt2 = json_decode($banco['datos'], true);
      $notas_clt = $notas_clt2[$periodo];

      $fort = $notas_clt[$rendimiento]['n' . $cualitativo]['ftz'];
      $debi = $notas_clt[$rendimiento]['n' . $cualitativo]['deb'];
      $reco = $notas_clt[$rendimiento]['n' . $cualitativo]['rec'];

      $notas['p-' . $per]['m-' . $mat]['ftz'] = $periodo . '+' . $rendimiento . '+n' . $cualitativo . '+ftz';
      $notas['p-' . $per]['m-' . $mat]['deb'] = $periodo . '+' . $rendimiento . '+n' . $cualitativo . '+deb';
      $notas['p-' . $per]['m-' . $mat]['rec'] = $periodo . '+' . $rendimiento . '+n' . $cualitativo . '+rec';

      $notas_nuevas = json_encode($notas);

      try {
        $stmt = $conn->prepare("UPDATE siscpi_notas SET datos=?, usuario=?, editado=? WHERE id_alumno=?");
        $stmt->bind_param('sssi', $notas_nuevas, $id_usuario, $hoy, $ida);
        $stmt->execute();

        $respuesta = array(
          'respuesta' => 'exito',
          'comentario' => 'Notas registradas exitosamente',
          'notaev1' => $ev1,
          'notaev2' => $ev2,
          'notaev3' => $ev3,
          'notaev4' => $ev4,
          'notaev5' => $ev5,
          'notactv' => $final,
          'fort' => $fort,
          'debi' => $debi,
          'reco' => $reco,
          'pila' => $notas_clt
        );
      } catch (Exception $e) {
        echo "FALLO N2:" . $e->getMessage();
      }

      return ($respuesta);
    }

    try {
      $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
      $stmt->bind_param("i", $ida);
      $stmt->execute();
      $resultado_detalles = $stmt->get_result();
      $resultado_notas = $resultado_detalles->fetch_assoc();

      if ($resultado_detalles->num_rows > 0) {
        $notas_actuales = json_decode($resultado_notas['datos'], true);

        $notas_up = $notas_actuales;
        $notas_up['p-' . $per]['m-' . $mat]['l-' . $log] = array(
          'ev1' => $ev1,
          'ev2' => $ev2,
          'ev3' => $ev3,
          'ev4' => $ev4,
          'ev5' => $ev5
        );

        $stmt = $conn->prepare("UPDATE siscpi_notas SET datos=?, usuario=?, editado=? WHERE id_alumno=?");
        $stmt->bind_param('sssi', json_encode($notas_up), $id_usuario, $hoy, $ida);
        $stmt->execute();

        if ($stmt->affected_rows) {
          $respuesta = calDef($conn, $per, $mat, $lfn, $ida, $grd, $hoy, $ev1, $ev2, $ev3, $ev4, $ev5, $periodo, $id_usuario);
        } else {
          $respuesta = array(
            'respuesta' => 'error',
            'comentario' => 'Las notas no pudieron ser registradas, intente nuevamente. Si el problema persiste contacte con Soporte Técnico'
          );
        }
      } else {
        $notas = array(
          'p-' . $per => array(
            'm-' . $mat => array(
              'l-' . $log => array(
                'ev1' => $ev1,
                'ev2' => $ev2,
                'ev3' => $ev3,
                'ev4' => $ev4,
                'ev5' => $ev5
              )
            )
          )
        );

        $stmt = $conn->prepare("INSERT INTO siscpi_notas (id_alumno, datos, usuario, editado) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $ida, json_encode($notas), $id_usuario, $hoy);
        $stmt->execute();
        $id_registro_cobrador = $stmt->insert_id;

        if ($id_registro_cobrador > 0) {
          $respuesta = calDef($conn, $per, $mat, $lfn, $ida, $grd, $hoy, $ev1, $ev2, $ev3, $ev4, $ev5, $periodo, $id_usuario);
        } else {
          $respuesta = array(
            'respuesta' => 'error',
            'comentario' => 'Las notas no pudieron ser registradas, intente nuevamente. Si el problema persiste contacte con Soporte Técnico'
          );
        }
      }
    } catch (Exception $e) {
      echo "FALLO N2:" . $e->getMessage();
    }




    die(json_encode($respuesta));
  }

  //Ejecuta actualización de notas cualitativas
  if ($data['cmd'] == 'ftzatc') {
    $tip = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ ])', '', $data['cmd2']);
    $ida = filter_var($data['ida'], FILTER_VALIDATE_INT);
    $mat = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ ])', '', $data['mat']);
    $gra = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ ])', '', $data['gra']);
    $per = filter_var($data['per'], FILTER_VALIDATE_INT);
    $des = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0123456789 +])', '', $data['des']);
    $id_usuario = $data['user_id'];

    if ($tip == 'ftz') {
      $cod3 = 'Fortaleza';
    } else if ($tip == 'rec') {
      $cod3 = 'Recomendación';
    } else if ($tip == 'deb') {
      $cod3 = 'Debilidad';
    }

    $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
    $stmt->bind_param('i', $ida);
    $stmt->execute();
    $notas_result = $stmt->get_result();
    $row_notas = $notas_result->fetch_assoc();

    if ($notas_result->num_rows > 0) {

      $notas = json_decode($row_notas['datos'], true);
      $notas_up = array_merge([], $notas);
      $notas_up['p-' . $per]['m-' . $mat][$tip] = $des;

      try {
        $stmt = $conn->prepare("UPDATE siscpi_notas SET datos=?, usuario=?, editado=? WHERE id_alumno=?");
        $stmt->bind_param('sssi', json_encode($notas_up), $id_usuario, $hoy, $ida);
        $stmt->execute();

        if ($stmt->affected_rows) {
          $respuesta = [
            'respuesta' => 'exito',
            'comentario' => $cod3 . ' registrada exitosamente',
          ];
        } else {
          $respuesta = [
            'respuesta' => 'error',
            'comentario' => 'No se pudo registrar la ' . $cod3,
          ];
        }
      } catch (Exception $e) {
        echo "FALLO N2:" . $e->getMessage();
      }
    } else {
      $respuesta = [
        'respuesta' => 'error',
        'comentario' => 'Debe registrar al menos una nota cuantitativa',
      ];
    }

    die(json_encode($respuesta));
  }

  //Ejecuta consulta sobre fortalezados disponibles
  if ($data['cmd'] == 'sqlftz') {

    $mat = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ ] )', '', $data['mat']);
    $gra = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ ] )', '', $data['gra']);

    $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
    $stmt->bind_param('ss', $mat, $gra);
    $stmt->execute();
    $notas_result = $stmt->get_result();
    $row_notas = $notas_result->fetch_assoc();

    if ($notas_result->num_rows > 0) {

      $notas = json_decode($row_notas['datos'], true);
      $respuesta = [
        'respuesta' => 'exito',
        'data' => json_encode($notas)
      ];
    } else {
      $respuesta = [
        'respuesta' => 'error',
        'comentario' => 'Error ajecutar la consulta, no se encontraron fortalezados',
      ];
    }

    die(json_encode($respuesta));
  }

  //Registro de nota convivencia
  if ($data['cmd'] == 'regconv') {
    $id_usuario = $data['user_id'];
    $ida = filter_var($data['ida'], FILTER_VALIDATE_INT);
    $per = filter_var($data['per'], FILTER_VALIDATE_INT);
    $sec = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ ])', '', $data['sec']);
    $gra = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ ])', '', $data['gra']);
    $not = preg_replace('([^0-9.])', '', $data['not']);

    try {
      $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
      $stmt->bind_param("i", $ida);
      $stmt->execute();
      $notas_resultado = $stmt->get_result();

      if ($notas_resultado->num_rows > 0) {
        $notas_detalle = $notas_resultado->fetch_assoc();
        $notas_actuales = json_decode($notas_detalle['datos'], true);

        if (!empty($notas_actuales['p-' . $per])) {
          $notas_actuales['p-' . $per]['ncv'] = $not;
          $notas_up = json_encode($notas_actuales);

          $stmt = $conn->prepare("UPDATE siscpi_notas SET datos=?, usuario=?, editado=? WHERE id_alumno=?");
          $stmt->bind_param('sssi', $notas_up, $id_usuario, $hoy, $ida);
          $stmt->execute();

          if ($stmt->affected_rows) {

            $final_not = number_format((float)$not, 1, '.', '');
            isset(RENDIMIENTOS[$sec]) ? [$rendimiento, $bandera, $cualitativo] = RENDIMIENTOS[$sec][$final_not] : 0;

            $respuesta = array(
              'respuesta' => 'exito',
              'comentario' => 'Nota de Convivencia registrada correctamente',
              'not' => $not,
              'ida' => $ida,
              'rendimiento' => $rendimiento,
              'bandera' => $bandera,
              'cualitativo' => $cualitativo
            );
          } else {
            $respuesta = array(
              'respuesta' => 'error',
              'comentario' => 'Las notas no pudieron ser registradas, intente nuevamente. Si el problema persiste contacte con Soporte Técnico'
            );
          }
        } else {
          $respuesta = array(
            'respuesta' => 'error',
            'comentario' => 'No se pudo registrar la nota de Convivencia porque el Periodo arrojó "null", contacte con Soporte Técnico'
          );
        }
      } else {
        $respuesta = array(
          'respuesta' => 'error',
          'comentario' => 'Primero registre al menos la nota de un aprendizaje'
        );
      }
    } catch (Exception $e) {
      echo "FALLO N2:" . $e->getMessage();
    }

    die(json_encode($respuesta));
  }

  //Registra y actualiza la descripción de Convivencia
  if ($data['cmd'] == 'actconv') {
    $ide = filter_var($data['ide'], FILTER_VALIDATE_INT);
    $ida = filter_var($data['ida'], FILTER_VALIDATE_INT);
    $per = filter_var($data['per'], FILTER_VALIDATE_INT);
    $ind = preg_replace('([^A-Za-zZÑñáéíóúüÁÉÍÓÚÜ0-9 ])', '', $data['ind']);

    if ($ind === 'dcv') {
      $orden = 1;
    } elseif ($ind === 'dcv2') {
      $orden = 2;
    } elseif ($ind === 'dcv3') {
      $orden = 3;
    }

    try {
      $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
      $stmt->bind_param("i", $ida);
      $stmt->execute();
      $resultado_detalles = $stmt->get_result();


      if ($resultado_detalles->num_rows > 0) {
        $resultado_notas = $resultado_detalles->fetch_assoc();
        $notas_actuales = json_decode($resultado_notas['datos'], true);

        if (!$notas_actuales['p-' . $per] == null) {

          $notas_actuales['p-' . $per][$ind] = $ide;
          $notas_up = json_encode($notas_actuales);

          try {
            $stmt = $conn->prepare("UPDATE siscpi_notas SET datos=?, usuario=?, editado=? WHERE id_alumno=?");
            $stmt->bind_param('sssi', $notas_up, $id_usuario, $hoy, $ida);
            $stmt->execute();

            if ($stmt->affected_rows) {

              $respuesta = array(
                'respuesta' => 'exito',
                'comentario' => 'Indicador registrado correctamente',
                'orden' => $orden,
                'revision' => $ind
              );
            } else {
              $respuesta = array(
                'respuesta' => 'error',
                'comentario' => 'El indicador no pudo ser registrado, intente nuevamente. Si el problema persiste contacte con Soporte Técnico'
              );
            }
          } catch (Exception $e) {
            echo "FALLO N2:" . $e->getMessage();
          }
        } else {

          $respuesta = array(
            'respuesta' => 'error',
            'comentario' => 'No se pudo registar la Descripción porque el Periodo arrojó "null", contacte con Soporte Técnico'
          );
        }
      } else {

        $respuesta = array(
          'respuesta' => 'error',
          'comentario' => 'Primero resgistre al menos la nota de un aprendizaje'
        );
      }
    } catch (Exception $e) {
      echo "FALLO N2:" . $e->getMessage();
    }

    die(json_encode($respuesta));
  }

  //Registro de nota ICFES
  if ($data['cmd'] == 'regicfes') {
    $id_usuario = $data['user_id'];
    $ida = filter_var($data['ida'], FILTER_VALIDATE_INT);
    $per = filter_var($data['per'], FILTER_VALIDATE_INT);
    $sec = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ ])', '', $data['sec']);
    $gra = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ ])', '', $data['gra']);
    $mat = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ ])', '', $data['mat']);
    $not = preg_replace('([^0-9.])', '', $data['not']);

    try {
      $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
      $stmt->bind_param("i", $ida);
      $stmt->execute();
      $notas_resultado = $stmt->get_result();

      if ($notas_resultado->num_rows > 0) {
        $notas_detalle = $notas_resultado->fetch_assoc();
        $notas_actuales = json_decode($notas_detalle['datos'], true);

        if (!empty($notas_actuales['p-' . $per])) {

          $notas_actuales['p-' . $per]['icf_' . $mat] = $not;

          $not_soc = number_format(isset($notas_actuales['p-' . $per]['icf_soc']) ? $notas_actuales['p-' . $per]['icf_soc'] : 0);
          $not_esp = number_format(isset($notas_actuales['p-' . $per]['icf_esp']) ? $notas_actuales['p-' . $per]['icf_esp'] : 0);
          $not_mat = number_format(isset($notas_actuales['p-' . $per]['icf_mat']) ? $notas_actuales['p-' . $per]['icf_mat'] : 0);
          $not_nat = number_format(isset($notas_actuales['p-' . $per]['icf_nat']) ? $notas_actuales['p-' . $per]['icf_nat'] : 0);
          $not_ing = number_format(isset($notas_actuales['p-' . $per]['icf_ing']) ? $notas_actuales['p-' . $per]['icf_ing'] : 0);

          $icfes_def = $not_soc + $not_esp + $not_mat + $not_nat + $not_ing;

          $notas_actuales['p-' . $per]['icf'] = $icfes_def;


          $notas_up = json_encode($notas_actuales);

          $stmt = $conn->prepare("UPDATE siscpi_notas SET datos=?, usuario=?, editado=? WHERE id_alumno=?");
          $stmt->bind_param('sssi', $notas_up, $id_usuario, $hoy, $ida);
          $stmt->execute();

          if ($stmt->affected_rows) {

            $final_not = number_format($icfes_def);

            if ($final_not >= 0 && $final_not <= 221) {
              $rendimiento = 'INSUFICIENTE';
              $bandera = 'danger';
              $color = '#dc3545';
            } elseif ($final_not >= 222 && $final_not <= 325) {
              $rendimiento = 'BÁSICO';
              $bandera = 'warning';
              $color = '#ffc107';
            } elseif ($final_not >= 326 && $final_not <= 437) {
              $rendimiento = 'SATISFÁCTORIO';
              $bandera = 'success';
              $color = '#28a745';
            } elseif ($final_not >= 438) {
              $rendimiento = 'AVANZADO';
              $bandera = 'dark';
              $color = '#343a40';
            }


            $respuesta = array(
              'respuesta' => 'exito',
              'comentario' => 'Nota ICFES registrada correctamente',
              'not' => $not,
              'def' => $icfes_def,
              'ida' => $ida,
              'rendimiento' => $rendimiento,
              'bandera' => $bandera,
              'color' => $color
            );
          } else {
            $respuesta = array(
              'respuesta' => 'error',
              'comentario' => 'Las notas no pudieron ser registradas, intente nuevamente. Si el problema persiste contacte con Soporte Técnico'
            );
          }
        } else {
          $respuesta = array(
            'respuesta' => 'error',
            'comentario' => 'No se pudo registrar la nota ICFES porque el Periodo arrojó "null", contacte con Soporte Técnico'
          );
        }
      } else {
        $respuesta = array(
          'respuesta' => 'error',
          'comentario' => 'El alumno debe tener al menos la nota de un aprendizaje'
        );
      }
    } catch (Exception $e) {
      echo "FALLO N2:" . $e->getMessage();
    }

    die(json_encode($respuesta));
  }

  //Registro de Indicadores de Convivencia
  if ($data['cmd'] == 'acticonv') {
    $subcmd = preg_replace('([^0-9])', '', $data['subcmd']);

    if ($subcmd == 1) {

      $convi_id = preg_replace('([^0-9])', '', $data['convi_id']);
      $text = preg_replace('([^A-Za-zZÑñáéíóúüÁÉÍÓÚÜ0-9 # , () ° : . _ -])', '', $data['text']);

      try {
        $stmt = $conn->prepare("UPDATE siscpi_iconvivencia SET notas_convivencia_descripcion=?, notas_convivencia_editado=? WHERE notas_convivencia_id=?");
        $stmt->bind_param('ssi', $text, $hoy, $convi_id);
        $stmt->execute();

        if ($stmt->affected_rows) {
          $respuesta = array(
            'respuesta' => 'exito',
            'comentario' => 'Indicador Actualizado',
            'newtext' => $text
          );
        } else {
          $respuesta = array(
            'respuesta' => 'error',
            'comentario' => 'El indicador no pudo ser actualizado, intente nuevamente. Si el problema persiste contacte con Soporte Técnico'
          );
        };
      } catch (Exception $e) {
        echo "FALLO N2:" . $e->getMessage();
      }
    } elseif ($subcmd == 2) {

      $text = preg_replace('([^A-Za-zZÑñáéíóúüÁÉÍÓÚÜ0-9 # , () ° : . _ -])', '', $data['text']);

      try {
        $stmt = $conn->prepare("INSERT INTO siscpi_iconvivencia (notas_convivencia_descripcion, notas_convivencia_editado) VALUES (?, ?)");
        $stmt->bind_param("ss", $text, $hoy);
        $stmt->execute();
        $id_registro = $stmt->insert_id;

        if ($id_registro > 0) {

          $respuesta = array(
            'respuesta' => 'exito',
            'comentario' => 'Indicador registrado'
          );
        } else {
          $respuesta = array(
            'respuesta' => 'error',
            'comentario' => 'El nuevo indicador no pudo ser registrado, intente nuevamente. Si el problema persiste contacte con Soporte Técnico'
          );
        };
      } catch (Exception $e) {
        echo "FALLO N2:" . $e->getMessage();
      }
    }

    die(json_encode($respuesta));
  }

  //Ejecuta Consulta de notas
  if ($data['cmd'] == 'alumnotsql') {

    $id_usuario = $data['user_id'];
    unset($data['user_id']);
    unset($data['cmd']);

    $ida = filter_var($data['id'], FILTER_VALIDATE_INT);
    $per = filter_var($data['per'], FILTER_VALIDATE_INT);

    try {
      $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
      $stmt->bind_param("i", $ida);
      $stmt->execute();
      $notas_resultado = $stmt->get_result();
      $notas_detalle = $notas_resultado->fetch_assoc();

      if ($notas_resultado->num_rows > 0) {
        $notas = json_decode($notas_detalle['datos'], true);
        $notas_actuales = $notas['p-' . $per];
        $respuesta = array(
          'respuesta' => 'exito',
          'notas_actuales' => json_encode($notas_actuales)
        );
      } else {
        $notas_actuales = [];
        $respuesta = array(
          'respuesta' => 'exito',
          'notas_actuales' => json_encode($notas_actuales)
        );
      }
    } catch (Exception $e) {
      echo "FALLO N2:" . $e->getMessage();
    }

    die(json_encode($respuesta));
  }

  //Ejecuta consulta sobre id de fortalezados de convivencia
  if ($data['cmd'] == 'sqlcnv') {

    $dcv_id = filter_var($data['dcv_id'], FILTER_VALIDATE_INT);
    $dcv2_id = filter_var($data['dcv2_id'], FILTER_VALIDATE_INT);
    $dcv3_id = filter_var($data['dcv3_id'], FILTER_VALIDATE_INT);

    if ($dcv_id > 0) {
      $stmt = $conn->prepare("SELECT * FROM siscpi_iconvivencia WHERE notas_convivencia_id =?");
      $stmt->bind_param('i', $dcv_id);
      $stmt->execute();
      $notas_result = $stmt->get_result();
      $row_notas = $notas_result->fetch_assoc();
      $dcv_desc = $row_notas['notas_convivencia_descripcion'];
    } else {
      $dcv_desc = '';
    }


    if ($dcv2_id > 0) {
      $stmt = $conn->prepare("SELECT * FROM siscpi_iconvivencia WHERE notas_convivencia_id =?");
      $stmt->bind_param('i', $dcv2_id);
      $stmt->execute();
      $notas_result2 = $stmt->get_result();
      $row_notas2 = $notas_result2->fetch_assoc();
      $dcv_desc2 = $row_notas2['notas_convivencia_descripcion'];
    } else {
      $dcv_desc2 = '';
    }

    if ($dcv3_id > 0) {
      $stmt = $conn->prepare("SELECT * FROM siscpi_iconvivencia WHERE notas_convivencia_id =?");
      $stmt->bind_param('i', $dcv3_id);
      $stmt->execute();
      $notas_result3 = $stmt->get_result();
      $row_notas3 = $notas_result3->fetch_assoc();
      $dcv_desc3 = $row_notas3['notas_convivencia_descripcion'];
    } else {
      $dcv_desc3 = '';
    }

    if ($dcv_id > 0 || $dcv2_id > 0 || $dcv3_id > 0) {
      $respuesta = [
        'respuesta' => 'exito',
        'dcv_desc' => $dcv_desc,
        'dcv_desc2' => $dcv_desc2,
        'dcv_desc3' => $dcv_desc3
      ];
    } else {
      $respuesta = [
        'respuesta' => 'error',
        'comentario' => 'Id de convivencia es < 0',
      ];
    }

    die(json_encode($respuesta));
  }

  //Retorna el JSON para descargar la planilla de notas en XLSX
  if ($data['cmd'] == 'planilla') {

    $id_usuario = $data['user_id'];
    unset($data['user_id']);
    unset($data['cmd']);

    $per = filter_var($data['per'], FILTER_VALIDATE_INT);

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


    try {

      $alumnos = array();

      $stmt = $conn->prepare("SELECT * FROM siscpi_users WHERE id_login=?");
      $stmt->bind_param("i", $id_usuario);
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

                  if (isset($temp_not['p-' . $per]['m-' . $materia])) {
                    $alumnos[$materia][$gra][$row_alumnos['id']] = array('doc' => $temp_dat['ide_num'], 'nom' => $temp_dat['per_ape'] . ' ' . $temp_dat['sdo_ape'] . ' ' . $temp_dat['per_nom'] . ' ' . $temp_dat['sdo_nom'], 'notas' => $temp_not['p-' . $per]['m-' . $materia]);
                  }
                }
              }
            } catch (\Exception $e) {
              $error = $e->getMessage();
              echo $error;
            }
          }
        }
      }


      $respuesta = array(
        'respuesta' => 'exito',
        'datos' => json_encode($alumnos)
      );
    } catch (\Exception $e) {
      $error = $e->getMessage();
      echo $error;
    }

    die(json_encode($respuesta));
  }

  //Registro de nota de recuperación
  if ($data['cmd'] == 'regnov') {
    $id_usuario = $data['user_id'];
    $ida = filter_var($data['ida'], FILTER_VALIDATE_INT);
    $per = filter_var($data['per'], FILTER_VALIDATE_INT);
    $not = strtoupper(preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ () ])', '', $data['not']));
    $mat = strtoupper(preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ () ])', '', $data['mat']));
    $sec = strtoupper(preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ () ])', '', $data['sec']));
    $lon = filter_var($data['lon'], FILTER_VALIDATE_INT);
    $lac = filter_var($data['lac'], FILTER_VALIDATE_INT);
    $fno = preg_replace('([^0-9.])', '', $data['fno']);

    try {
      $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
      $stmt->bind_param("i", $ida);
      $stmt->execute();
      $notas_resultado = $stmt->get_result();

      if ($notas_resultado->num_rows > 0) {
        $notas_detalle = $notas_resultado->fetch_assoc();
        $notas = json_decode($notas_detalle['datos'], true);

        if (!empty($notas['p-' . $per])) {

          $notas['p-' . $per]['m-' . $mat]['l-' . $lon]['nov'] = $not;

          $notas_logros_defi = 0;

          for ($lo = 1; $lo <= $lac; $lo++) {

            if (isset($notas['p-' . $per]['m-' . $mat]['l-' . $lo]['nov'])) {
              $crr_novedad = $notas['p-' . $per]['m-' . $mat]['l-' . $lo]['nov'];
              $def_novedad = $crr_novedad === 'RECUPERADO' ? NOVEDADES[$sec]['BÁSICO'] : 0;
            } else {
              $def_novedad = 'S/R';
            }

            $nota_logro_70 = 0;
            $nota_logro_20 = 0;
            $nota_logro_10 = 0;

            for ($ev = 1; $ev <= 5; $ev++) {

              $nota_ev = isset($notas['p-' . $per]['m-' . $mat]['l-' . $lo]['ev' . $ev]) ? $notas['p-' . $per]['m-' . $mat]['l-' . $lo]['ev' . $ev] : 0;

              if ($ev === 1 or $ev === 2 or $ev === 3) {
                $nota_logro_70 += number_format($nota_ev, 1);
              }

              if ($ev === 4) {
                $nota_logro_20 += number_format($nota_ev, 1);
              }

              if ($ev === 5) {
                $nota_logro_10 += number_format($nota_ev, 1);
              }
            }

            $def70 = ($nota_logro_70 / 3) * 0.7;
            $def20 = $nota_logro_20 * 0.2;
            $def10 = $nota_logro_10 * 0.1;
            $def = number_format($def70 + $def20 + $def10, 1, '.', '');

            if (isset($notas['p-' . $per]['m-' . $mat]['l-' . $lo]['nov'])) {

              if ($def_novedad === 0 or $def_novedad === 'S/R') {
                $notas_logros_defi = $notas_logros_defi + $def;
              } else {
                $notas_logros_defi = $notas_logros_defi + $def_novedad;
              }
            } else {
              $notas_logros_defi  = $notas_logros_defi + $def;
            }
          }

          $nota_final_def = number_format(($notas_logros_defi / $lac), 1);
          $notas['p-' . $per]['m-' . $mat]['ncn'] = $nota_final_def;


          $buscar_nota = strval($nota_final_def);
          $ren = RENDIMIENTOS[$sec][$buscar_nota][0];
          $ban = RENDIMIENTOS[$sec][$buscar_nota][1];

          if ($ren === 'BÁSICO') {
            $notas['p-' . $per]['m-' . $mat]['nov'] = 'REC';
          } else {
            $notas['p-' . $per]['m-' . $mat]['nov'] = 'NRE';
          }

          $notas_up = json_encode($notas);

          $stmt = $conn->prepare("UPDATE siscpi_notas SET datos=?, usuario=?, editado=? WHERE id_alumno=?");
          $stmt->bind_param('sssi', $notas_up, $id_usuario, $hoy, $ida);
          $stmt->execute();

          if ($stmt->affected_rows) {

            $nota_final = $not === 'RECUPERADO' ?  NOVEDADES[$sec]['BÁSICO'] : $fno;

            $nre = $nota_final;

            $respuesta = array(
              'respuesta' => 'exito',
              'comentario' => 'Novedad registrada correctamente',
              'not' => $not,
              'ida' => $ida,
              'per' => $per,
              'def' => $nota_final_def,
              'ren' => $ren,
              'ban' => $ban,
              'nre' => $nre,
              'lon' => $lon
            );
          } else {
            $respuesta = array(
              'respuesta' => 'error',
              'comentario' => 'La novedad no pudo ser registrada, intente nuevamente. Si el problema persiste contacte con Soporte Técnico'
            );
          }
        } else {

          $notas_actuales['p-' . $per] = [' '];
          $notas_up2 = json_encode($notas_actuales);
          $stmt = $conn->prepare("UPDATE siscpi_notas SET datos=?, usuario=?, editado=? WHERE id_alumno=?");
          $stmt->bind_param('sssi', $notas_up2, $id_usuario, $hoy, $ida);
          $stmt->execute();
          if ($stmt->affected_rows) {
            $respuesta = array(
              'respuesta' => 'error',
              'comentario' => 'El estudiante no posee nota en el periodo seleccionado. Se creo un nuevo contenedor de notas. Intente nuevamente para completar la operación'
            );
          } else {
            $respuesta = array(
              'respuesta' => 'error',
              'comentario' => 'No se pudo registrar la novedad porque el Periodo arrojó "null", contacte con Soporte Técnico'
            );
          }
        }
      } else {
        $respuesta = array(
          'respuesta' => 'error',
          'comentario' => 'Para registrar una novedad, primero se deben establecer las notas normal del periodo'
        );
      }
    } catch (Exception $e) {
      echo "FALLO N2:" . $e->getMessage();
    }

    die(json_encode($respuesta));
  }
  
} else {
  die(json_encode(array('respuesta' => "error", 'comentario' => "REQUEST_METHOD no permitido")));
}
