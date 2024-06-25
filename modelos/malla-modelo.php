<?php
session_start();

if (!isset($_SESSION["usuario"]) || !isset($_SESSION["logid"]) || ($_SESSION["nivel"] != 6 && $_SESSION["nivel"] != 3 && $_SESSION["nivel"] != 1)) {
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

  $valores_permitidos = array("sqlap", "apenuevo", "mllatc", "cmpnuevo", "estreg", "estsql", "accreg", "accsql", "ejenuevo");


  if (!in_array($data['cmd'], $valores_permitidos)) {
    die(json_encode(array('respuesta' => "error", 'comentario' => "Comando no válido")));
  }

  if (!isset($data["user_id"]) || !is_numeric($data["user_id"])) {
    die(json_encode(array('respuesta' => "error", 'comentario' => "Id de Usuario no válido")));
  }

  if ($data["user_id"] != $_SESSION["logid"]) {
    die(json_encode(array('respuesta' => "error", 'comentario' => "Id de Usuario no válido")));
  }

  //Ejecuta consulta sobre Aprendizajes disponibles
  if ($data['cmd'] == 'sqlap') {

    $mat = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ] )', '', $data['mat']);
    $per = intval(preg_replace('([^A-Za-z0-9 () ])', '', $data['per']));
    $gra = intval(preg_replace('([^A-Za-z0-9 () ])', '', $data['gra']));


    if ($gra === 1) {
      $grado = 'PRIMERO';
    } else if ($gra === 2) {
      $grado = 'SEGUNDO';
    } else if ($gra === 3) {
      $grado = 'TERCERO';
    } else if ($gra === 4) {
      $grado = 'CUARTO';
    } else if ($gra === 5) {
      $grado = 'QUINTO';
    } else if ($gra === 6) {
      $grado = 'SEXTO';
    } else if ($gra === 7) {
      $grado = 'SÉPTIMO';
    } else if ($gra === 8) {
      $grado = 'OCTAVO';
    } else if ($gra === 9) {
      $grado = 'NOVENO';
    } else if ($gra === 10) {
      $grado = 'DÉCIMO';
    } else if ($gra === 11) {
      $grado = 'UNDÉCIMO';
    } else if ($gra === 12) {
      $grado = 'PRE JARDÍN';
    } else if ($gra === 13) {
      $grado = 'JARDÍN';
    } else if ($gra === 14) {
      $grado = 'TRANSICIÓN';
    }



    $stmt = $conn->prepare("SELECT * FROM siscpi_materias WHERE mat_des_materia=?");
    $stmt->bind_param('s', $mat);
    $stmt->execute();
    $notas_result = $stmt->get_result();
    $row_notas = $notas_result->fetch_assoc();

    if ($notas_result->num_rows > 0) {

      $notas = json_decode($row_notas['mat_aprendizajes'], true);
      $respuesta = [
        'respuesta' => 'exito',
        'data' => json_encode($notas["p-" . $per]["g-" . $gra])
      ];
    } else {
      $respuesta = [
        'respuesta' => 'error',
        'comentario' => 'Error ajecutar la consulta, no se encontraron Aprendizajes',
      ];
    }

    die(json_encode($respuesta));
  }

  //Ejecuta actualización de Aprendizaje
  if ($data['cmd'] == 'apenuevo') {

    $id_usuario = $data['user_id'];

    unset($data['user_id']);
    unset($data['cmd']);

    $mat = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['mat']);
    $per = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['per']);
    $gra = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['gra']);
    $apo = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['apo']);
    $ape = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['ape']);
    $des = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['des']);


    $stmt = $conn->prepare("SELECT * FROM siscpi_materias WHERE mat_des_materia=?");
    $stmt->bind_param("s", $mat);
    $stmt->execute();
    $result = $stmt->get_result();
    $result2 = $result->fetch_assoc();

    $datos = json_decode($result2['mat_aprendizajes'], true);

    $id_data = $result2['mat_id'];
    $data_nueva = $datos;
    $data_nueva[$per][$gra][$apo][$ape] = $des;
    $datos_finales = json_encode($data_nueva);

    try {
      $stmt = $conn->prepare("UPDATE siscpi_materias SET mat_aprendizajes=?, mat_editado=NOW() WHERE mat_id=?");
      $stmt->bind_param("si", $datos_finales, $id_data);
      $stmt->execute();

      if ($stmt->affected_rows) {
        $respuesta['respuesta'] = 'exito';
        $respuesta['comentario'] = 'Aprendizaje actualizado correctamente';
      } else {
        $respuesta['respuesta'] = 'error';
        $respuesta['comentario'] = 'No se pudo actualizar el aprendizaje, intente nuevamente';
      }
    } catch (Exception $e) {
      $respuesta['respuesta'] = 'error';
      $respuesta['comentario'] = 'FALLO LA CONSULTA: ' . $e->getMessage();
    }

    $stmt->close();

    die(json_encode($respuesta));
  }

  //Ejecuta actualización de Malla Curricular
  if ($data['cmd'] == 'mllatc') {

    $mat = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['mat']);
    $per = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['per']);
    $gra = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['gra']);
    $apn = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['apn']);
    $key = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['key']);
    $api = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['api']);
    $id_usuario = $data['user_id'];

    $stmt = $conn->prepare("SELECT * FROM siscpi_materias WHERE mat_des_materia=?");
    $stmt->bind_param('s', $mat);
    $stmt->execute();
    $malla_result = $stmt->get_result();
    $row_malla = $malla_result->fetch_assoc();

    $malla_actual = json_decode($row_malla['mat_malla'], true);
    $malla_up = $malla_actual;
    $malla_up["p-" . $per]["g-" . $gra]["a-" . $apn]["key"] = $key . '&' . $api; //AQUI!

    try {
      $stmt = $conn->prepare("UPDATE siscpi_materias SET mat_malla=?, mat_editado=? WHERE mat_des_materia=?");
      $stmt->bind_param('sss', json_encode($malla_up), $hoy, $mat);
      $stmt->execute();

      if ($stmt->affected_rows) {
        $respuesta = [
          'respuesta' => 'exito',
          'comentario' => '¡Aprendizaje actualizado con exito',
        ];
      } else {
        $respuesta = [
          'respuesta' => 'error',
          'comentario' => 'No se pudo registrar el aprendizaje, intente nuevamente. Si el problema persiste, contacte con soporte técnico'
        ];
      }
    } catch (Exception $e) {
      echo "FALLO N2:" . $e->getMessage();
    }

    die(json_encode($respuesta));
  }

  //Ejecuta actualización de Componente y Competencias
  if ($data['cmd'] == 'cmpnuevo') {

    $mat = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['mat']);
    $per = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['per']);
    $gra = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['gra']);
    $apn = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['apn']);
    $clv = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['clv']);
    $des = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['des']);
    $id_usuario = $data['user_id'];

    $tittle = $clv === 'cpt' ? 'Competencia' : 'Componente';
    $tittle_letter = $clv === 'cpt' ? 'a' : 'o';


    $stmt = $conn->prepare("SELECT * FROM siscpi_materias WHERE mat_des_materia=?");
    $stmt->bind_param('s', $mat);
    $stmt->execute();
    $malla_result = $stmt->get_result();
    $row_malla = $malla_result->fetch_assoc();

    $malla_actual = json_decode($row_malla['mat_malla'], true);
    $malla_up = $malla_actual;
    $malla_up["p-" . $per]["g-" . $gra]["a-" . $apn][$clv] = $des;

    try {
      $stmt = $conn->prepare("UPDATE siscpi_materias SET mat_malla=?, mat_editado=? WHERE mat_des_materia=?");
      $stmt->bind_param('sss', json_encode($malla_up), $hoy, $mat);
      $stmt->execute();

      if ($stmt->affected_rows) {
        $respuesta = [
          'respuesta' => 'exito',
          'comentario' => '¡' . $tittle . ' actualizad' . $tittle_letter . ' con exito!',
        ];
      } else {
        $respuesta = [
          'respuesta' => 'error',
          'comentario' => 'No se pudo registrar el ' . $tittle . ', intente nuevamente. Si el problema persiste, contacte con soporte técnico'
        ];
      }
    } catch (Exception $e) {
      echo "FALLO N2:" . $e->getMessage();
    }

    die(json_encode($respuesta));
  }

  //Ejecuta Consulta de Planificador Bimestral (Estandar y Núcleo)
  if ($data['cmd'] == 'estsql') {

    $mat = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['mat']);
    $per = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['per']);
    $gra = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['gra']);
    $est = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['est']);

    $stmt = $conn->prepare("SELECT * FROM siscpi_materias WHERE mat_des_materia=?");
    $stmt->bind_param('s', $mat);
    $stmt->execute();
    $plan_result = $stmt->get_result();
    $row_plan = $plan_result->fetch_assoc();

    if ($stmt->affected_rows) {

      $plan_actual = json_decode($row_plan['mat_planificador'], true);
      $plan_up = $plan_actual["p-" . $per]["g-" . $gra][$est];

      $respuesta = [
        'respuesta' => 'exito',
        'comentario' => json_encode($plan_up)
      ];
    } else {
      $respuesta = [
        'respuesta' => 'error',
        'comentario' => 'Ocurrio un error al consultar le planificador, por favor intente de nuevo, si el problema persiste, contacte con soporte técnico'
      ];
    }

    die(json_encode($respuesta));
  }

  //Ejecuta actualización de Planificador Bimestral (Estandar y Núcleo)
  if ($data['cmd'] == 'estreg') {

    $mat = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['mat']);
    $per = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['per']);
    $gra = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['gra']);
    $est = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['est']);

    $est1 = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['est1']);
    $est2 = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['est2']);
    $est3 = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['est3']);

    $id_usuario = $data['user_id'];

    if ($est === 'est') {
      $tittle = 'Estandar';
      $tittle_letter = 'o';
    } else if ($est === 'nlp') {
      $tittle = 'Núcleo Problémico';
      $tittle_letter = 'o';
    }

    $stmt = $conn->prepare("SELECT * FROM siscpi_materias WHERE mat_des_materia=?");
    $stmt->bind_param('s', $mat);
    $stmt->execute();
    $plan_result = $stmt->get_result();
    $row_plan = $plan_result->fetch_assoc();

    $plan_actual = json_decode($row_plan['mat_planificador'], true);
    $plan_up = $plan_actual;
    $plan_up["p-" . $per]["g-" . $gra][$est] = ["est1" => $est1, "est2" => $est2, "est3" => $est3];

    try {
      $stmt = $conn->prepare("UPDATE siscpi_materias SET mat_planificador=?, mat_editado=? WHERE mat_des_materia=?");
      $stmt->bind_param('sss', json_encode($plan_up), $hoy, $mat);
      $stmt->execute();

      if ($stmt->affected_rows) {
        $respuesta = [
          'respuesta' => 'exito',
          'comentario' => '¡' . $tittle . ' actualizad' . $tittle_letter . ' con exito!',
          'est1' => $est1,
          'est2' => $est2,
          'est3' => $est3
        ];
      } else {
        $respuesta = [
          'respuesta' => 'error',
          'comentario' => 'No se pudo actualizar el ' . $tittle . ', intente nuevamente. Si el problema persiste, contacte con soporte técnico'
        ];
      }
    } catch (Exception $e) {
      echo "FALLO N2:" . $e->getMessage();
    }

    die(json_encode($respuesta));
  }

  //Ejecuta actualización de Planificador Bimestral (Acciones)
  if ($data['cmd'] == 'accreg') {

    $mat = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['mat']);
    $per = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['per']);
    $gra = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['gra']);
    $est = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['est']);

    $aar = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['aar']);
    $aap = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['aap']);
    $adb = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['adb']);
    $acs = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['acs']);
    $afc = preg_replace('([^0-9 /])', '', $data['afc']);

    $ord = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['ord']);
    $ape = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['ape']);

    $id_usuario = $data['user_id'];


    $stmt = $conn->prepare("SELECT * FROM siscpi_materias WHERE mat_des_materia=?");
    $stmt->bind_param('s', $mat);
    $stmt->execute();
    $plan_result = $stmt->get_result();
    $row_plan = $plan_result->fetch_assoc();

    $plan_actual = json_decode($row_plan['mat_planificador'], true);
    $plan_up = $plan_actual;

    $plan_up["p-" . $per]["g-" . $gra]['ap-' . $ape]['acc']['acc-' . $ord] = ["aar" => $aar, "aap" => $aap, "adb" => $adb, "acs" => $acs, "afc" => $afc];

    try {
      $stmt = $conn->prepare("UPDATE siscpi_materias SET mat_planificador=?, mat_editado=? WHERE mat_des_materia=?");
      $stmt->bind_param('sss', json_encode($plan_up), $hoy, $mat);
      $stmt->execute();

      if ($stmt->affected_rows) {
        $respuesta = [
          'respuesta' => 'exito',
          'comentario' => '¡Acciones actualizadas con Éxito!',
          'aar' => $aar,
          'aap' => $aap,
          'adb' => $adb,
          'acs' => $acs,
          'afc' => $afc
        ];
      } else {
        $respuesta = [
          'respuesta' => 'error',
          'comentario' => 'No se pudo actualizar las Acciones, intente nuevamente. Si el problema persiste, contacte con soporte técnico'
        ];
      }
    } catch (Exception $e) {
      echo "FALLO N2:" . $e->getMessage();
    }

    die(json_encode($respuesta));
  }

  //Ejecuta Consulta de Planificador Bimestral (Acciones)
  if ($data['cmd'] == 'accsql') {

    $mat = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['mat']);
    $per = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['per']);
    $gra = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['gra']);
    $ap = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['ap']);
    $order = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['order']);

    $stmt = $conn->prepare("SELECT * FROM siscpi_materias WHERE mat_des_materia=?");
    $stmt->bind_param('s', $mat);
    $stmt->execute();
    $plan_result = $stmt->get_result();
    $row_plan = $plan_result->fetch_assoc();

    if ($stmt->affected_rows) {

      $plan_actual = json_decode($row_plan['mat_planificador'], true);
      if (isset($plan_actual["p-" . $per]["g-" . $gra]['ap-' . $ap]['acc']['acc-' . $order])) {
        $plan_up = $plan_actual["p-" . $per]["g-" . $gra]['ap-' . $ap]['acc']['acc-' . $order];
      } else {
        $plan_up = [];
      }

      $respuesta = [
        'respuesta' => 'exito',
        'comentario' => json_encode($plan_up)
      ];
    } else {
      $respuesta = [
        'respuesta' => 'error',
        'comentario' => 'Ocurrio un error al consultar le planificador, por favor intente de nuevo, si el problema persiste, contacte con soporte técnico'
      ];
    }

    die(json_encode($respuesta));
  }

  //Ejecuta actualización de Componente y Competencias
  if ($data['cmd'] == 'ejenuevo') {

    $mat = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['mat']);
    $per = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['per']);
    $gra = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['gra']);
    $ape = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['ape']);
    $des = preg_replace('/[^A-Za-zÑñáéíóúüÁÉÍÓÚÜ0-9 . ( ) , -]/u', '', $data['des']);


    $stmt = $conn->prepare("SELECT * FROM siscpi_materias WHERE mat_des_materia=?");
    $stmt->bind_param('s', $mat);
    $stmt->execute();
    $plan_result = $stmt->get_result();
    $row_plan = $plan_result->fetch_assoc();

    $plan_actual = json_decode($row_plan['mat_planificador'], true);
    $plan_up = $plan_actual;
    $plan_up["p-" . $per]["g-" . $gra]["ap-" . $ape]['eje'] = $des;

    try {
      $stmt = $conn->prepare("UPDATE siscpi_materias SET mat_planificador=?, mat_editado=? WHERE mat_des_materia=?");
      $stmt->bind_param('sss', json_encode($plan_up), $hoy, $mat);
      $stmt->execute();

      if ($stmt->affected_rows) {
        $respuesta = [
          'respuesta' => 'exito',
          'comentario' => '¡Eje Temático actualizado con exito!',
          'des' => $des
        ];
      } else {
        $respuesta = [
          'respuesta' => 'error',
          'comentario' => 'No se pudo actualizar el Eje Temático intente nuevamente. Si el problema persiste, contacte con soporte técnico'
        ];
      }
    } catch (Exception $e) {
      echo "FALLO N2:" . $e->getMessage();
    }

    die(json_encode($respuesta));
  }


} else {
  die(json_encode(array('respuesta' => "error", 'comentario' => "REQUEST_METHOD no permitido")));
}
