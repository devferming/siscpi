<?php
session_start();

if (!isset($_SESSION["usuario"]) || !isset($_SESSION["logid"]) || ($_SESSION["nivel"] != 6 && $_SESSION["nivel"] != 3 && $_SESSION["nivel"] != 1)) {
  die(json_encode(array('respuesta' => "error", 'comentario' => $_SESSION["nivel"])));
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

  include_once '../funciones/funciones.php';
  $nivel = 1;
  require_once '../funciones/configuracion.php';
  date_default_timezone_set('America/Bogota');
  $hoy = date("Y-m-d H:i:s");

  $data = json_decode(file_get_contents('php://input'), true);
  $respuesta = array();

  $valores_permitidos = array("simulnuevo", "respuestas");

  if (!in_array($_POST['cmd'], $valores_permitidos)) {
    die(json_encode(array('respuesta' => "error", 'comentario' => "Comando no válido")));
  }

  if (!isset($_POST["user_id"]) || !is_numeric($_POST["user_id"])) {
    die(json_encode(array('respuesta' => "error", 'comentario' => "Id de Usuario no válido")));
  }

  if ($_POST["user_id"] != $_SESSION["logid"]) {
    die(json_encode(array('respuesta' => "error", 'comentario' => "Id de Usuario no válido")));
  }
  
  
  //Guarda el Nuevo Simulacro en BD
  if ($_POST['cmd'] == 'simulnuevo') {

    
    $inst = $_POST['simul-inst'];
    $fecha = $_POST['simul-fecha'];
    $tiempo = $_POST['simul-tiempo'];
    $grado = $_POST['simul-grado'];

    $ingles_status = $_POST['ingles'];
    $ingles_p1 = $_POST['simul-pregunta-ingles1'];
    $ingles_p2 = $_POST['simul-pregunta-ingles2'];

    $ingles1 = array(
      'ingles_status' => $ingles_status,
      'ingles_p1' => $ingles_p1,
      'ingles_p2' => $ingles_p2
    );

    $ingles = json_encode($ingles1);

    $naturales_status = $_POST['naturales'];
    $naturales_p1 = $_POST['simul-pregunta-naturales1'];
    $naturales_p2 = $_POST['simul-pregunta-naturales2'];

    $naturales1 = array(
      'naturales_status' => $naturales_status,
      'naturales_p1' => $naturales_p1,
      'naturales_p2' => $naturales_p2
    );

    $naturales = json_encode($naturales1);


    $lenguaje_status = $_POST['lenguaje'];
    $lenguaje_p1 = $_POST['simul-pregunta-lenguaje1'];
    $lenguaje_p2 = $_POST['simul-pregunta-lenguaje2'];

    $lenguaje1 = array(
      'lenguaje_status' => $lenguaje_status,
      'lenguaje_p1' => $lenguaje_p1,
      'lenguaje_p2' => $lenguaje_p2
    );

    $lenguaje = json_encode($lenguaje1);


    $matematicas_status = $_POST['matematicas'];
    $matematicas_p1 = $_POST['simul-pregunta-matematicas1'];
    $matematicas_p2 = $_POST['simul-pregunta-matematicas2'];

    $matematicas1 = array(
      'matematicas_status' => $matematicas_status,
      'matematicas_p1' => $matematicas_p1,
      'matematicas_p2' => $matematicas_p2
    );

    $matematicas = json_encode($matematicas1);


    $sociales_status = $_POST['sociales'];
    $sociales_p1 = $_POST['simul-pregunta-sociales1'];
    $sociales_p2 = $_POST['simul-pregunta-sociales2'];

    $sociales1 = array(
      'sociales_status' => $sociales_status,
      'sociales_p1' => $sociales_p1,
      'sociales_p2' => $sociales_p2
    );

    $sociales = json_encode($sociales1);

    $filosofia_status = $_POST['filosofia'];
    $filosofia_p1 = $_POST['simul-pregunta-filosofia1'];
    $filosofia_p2 = $_POST['simul-pregunta-filosofia2'];

    $filosofia1 = array(
      'filosofia_status' => $filosofia_status,
      'filosofia_p1' => $filosofia_p1,
      'filosofia_p2' => $filosofia_p2
    );

    $filosofia = json_encode($filosofia1);

    $fisica_status = $_POST['fisica'];
    $fisica_p1 = $_POST['simul-pregunta-fisica1'];
    $fisica_p2 = $_POST['simul-pregunta-fisica2'];

    $fisica1 = array(
      'fisica_status' => $fisica_status,
      'fisica_p1' => $fisica_p1,
      'fisica_p2' => $fisica_p2
    );

    $fisica = json_encode($fisica1);


    try {

      $stmt = $conn->prepare("SELECT gdo_des_grado FROM siscpi_grados WHERE gdo_cod_grado=?");
      $stmt->bind_param("i", $grado);
      $stmt->execute();
      $result_grado = $stmt->get_result();
      $result_grado2 = $result_grado->fetch_assoc();
      $cod_grado = $result_grado2['gdo_des_grado'];

      $stmt = $conn->prepare("SELECT MAX(simul_orden) AS max_orden FROM siscpi_simulacros WHERE simul_grado=?");
      $stmt->bind_param("s", $cod_grado);
      $stmt->execute();
      $result_simul = $stmt->get_result();
      $result_simul2 = $result_simul->fetch_assoc();
      $orden_simul = $result_simul2['max_orden'];

      if (isset($orden_simul)) {
        $orden3 = $orden_simul + 1;
      } else {
        $orden3 = 1;
      }
    } catch (\Exception $e) {
      $error = $e->getMessage();
      echo $error;
    }



    $banco = "../simulacros/subidos/$cod_grado/";

    $ext = pathinfo($_FILES['simul-pdf']['name'], PATHINFO_EXTENSION);


    if (!is_dir($banco)) {
      mkdir($banco, 0755, true);
    }

    $simul_status = 1;

    if (move_uploaded_file($_FILES['simul-pdf']['tmp_name'], $banco . 'G' . $grado . 'S' . $orden3 . "." . $ext)) {
      $doc_url = $banco . 'G' . $grado . 'S' . $orden3 . "." . $ext;

      try {

        $stmt = $conn->prepare("INSERT INTO siscpi_simulacros (simul_grado, simul_materia_ingles, simul_materia_naturales, simul_materia_lenguaje, simul_materia_matematicas, simul_materia_sociales, simul_materia_filosofia, simul_materia_fisica, simul_orden, simul_inst, simul_fecha, simul_tiempo, simul_ruta, simul_editado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssisssss", $cod_grado, $ingles, $naturales, $lenguaje, $matematicas, $sociales, $filosofia, $fisica, $orden3, $inst, $fecha, $tiempo, $doc_url, $hoy);
        $stmt->execute();

        $id_registro2 = $stmt->insert_id;

        $stmt = $conn->prepare("INSERT INTO siscpi_simulacros_r (simulr_simul_id, simulr_editado) VALUES (?, ?)");
        $stmt->bind_param("is", $id_registro2, $hoy);
        $stmt->execute();

        $id_registro = $stmt->insert_id;

        if ($id_registro > 0) {
          $respuesta = array(
            'respuesta' => 'exito',
            'id_creado' => $id_registro,
            'grado' => $cod_grado,
            'comentario' => 'Prueba cargada exitosamente'

          );
        } else {
          $respuesta = array(
            'respuesta' => 'error',
            'comentario' => 'Ocurrio un arror al cargar la prueba, intente nuevamente, si el problema persiste, contácte con Soporte Técnico'
          );
        };

        $stmt->close();
        $conn->close();
      } catch (Exception $e) {
        echo "Error:" . $e->getMessage();
      }
    } else {
      $respuesta = array(
        'respuesta' => error_get_last()
      );
    }


    die(json_encode($respuesta, JSON_UNESCAPED_UNICODE));

  }

  //Guarda las respuestas del estudiante
  if($_POST['cmd'] == 'respuestas'){


    $simul_id = $_POST['evaluacion'];
    $simul_tp = $_POST['evaluaciontp'];
    $alum_id = $_POST['alum_id'];

    try {

      $stmt = $conn->prepare("SELECT * FROM simulacros WHERE simul_id=?");
      $stmt->bind_param("i", $simul_id);
      $stmt->execute();
      $resultado = $stmt->get_result();
      $info_guia = $resultado->fetch_assoc();
    } catch (\Exception $e) {
        $error = $e->getMessage();
        echo $error;
    } 

    
    $si_ingles = json_decode($info_guia['simul_materia_ingles'], true);
    $si_naturales = json_decode($info_guia['simul_materia_naturales'], true);
    $si_lenguaje = json_decode($info_guia['simul_materia_lenguaje'], true);
    $si_matematicas = json_decode($info_guia['simul_materia_matematicas'], true);
    $si_sociales = json_decode($info_guia['simul_materia_sociales'], true);
    $si_filosofia = json_decode($info_guia['simul_materia_filosofia'], true);
    $si_fisica = json_decode($info_guia['simul_materia_fisica'], true);
   
    $total_preguntas;
    
    $respuestas=array();


    if ($si_ingles['ingles_status'] == 'SI') {

      $ingles_p1_2 = $si_ingles['ingles_p1'];
      $ingles_p2_2 = $si_ingles['ingles_p2'];

      $ingles_p1 = (int) $ingles_p1_2;
      $ingles_p2 = (int) $ingles_p2_2;


      $respuesta1 = 'p-'.$ingles_p1;
      $respuesta_1 = $_POST["" . $respuesta1 . ""];
      $respuestas["" . $respuesta1 . ""] = $respuesta_1;


      $suma_ingles = $ingles_p1;
      for ($i = $ingles_p1; $i < $ingles_p2; $i++) {

        $suma_ingles += 1;
        $respuesta1 = 'p-'.$suma_ingles;
        $respuesta_1 = $_POST["" . $respuesta1 . ""];
        $respuestas["" . $respuesta1 . ""] = $respuesta_1;

      }
    }

    if ($si_naturales['naturales_status'] == 'SI') {

      $naturales_p1_2 = $si_naturales['naturales_p1'];
      $naturales_p2_2 = $si_naturales['naturales_p2'];

      $naturales_p1 = (int) $naturales_p1_2;
      $naturales_p2 = (int) $naturales_p2_2;

      $respuesta1 = 'p-'.$naturales_p1;
      $respuesta_1 = $_POST["" . $respuesta1 . ""];
      $respuestas["" . $respuesta1 . ""] = $respuesta_1;

      $suma_naturales = $naturales_p1;
      for ($i = $naturales_p1; $i < $naturales_p2; $i++) {

        $suma_naturales += 1;
        $respuesta1 = 'p-'.$suma_naturales;
        $respuesta_1 = $_POST["" . $respuesta1 . ""];
        $respuestas["" . $respuesta1 . ""] = $respuesta_1;

      }
    }

    if ($si_lenguaje['lenguaje_status'] == 'SI') {

      $lenguaje_p1_2 = $si_lenguaje['lenguaje_p1'];
      $lenguaje_p2_2 = $si_lenguaje['lenguaje_p2'];

      $lenguaje_p1 = (int) $lenguaje_p1_2;
      $lenguaje_p2 = (int) $lenguaje_p2_2;

      $respuesta1 = 'p-'.$lenguaje_p1;
      $respuesta_1 = $_POST["" . $respuesta1 . ""];
      $respuestas["" . $respuesta1 . ""] = $respuesta_1;


      $suma_lenguaje = $lenguaje_p1;
      for ($i = $lenguaje_p1; $i < $lenguaje_p2; $i++) {

        $suma_lenguaje += 1;
        $respuesta1 = 'p-'.$suma_lenguaje;
        $respuesta_1 = $_POST["" . $respuesta1 . ""];
        $respuestas["" . $respuesta1 . ""] = $respuesta_1;

      }
    }

    if ($si_matematicas['matematicas_status'] == 'SI') {

      $matematicas_p1_2 = $si_matematicas['matematicas_p1'];
      $matematicas_p2_2 = $si_matematicas['matematicas_p2'];

      $matematicas_p1 = (int) $matematicas_p1_2;
      $matematicas_p2 = (int) $matematicas_p2_2;

      $respuesta1 = 'p-'.$matematicas_p1;
      $respuesta_1 = $_POST["" . $respuesta1 . ""];
      $respuestas["" . $respuesta1 . ""] = $respuesta_1;


      $suma_matematicas = $matematicas_p1;
      for ($i = $matematicas_p1; $i < $matematicas_p2; $i++) {

        $suma_matematicas += 1;
        $respuesta1 = 'p-'.$suma_matematicas;
        $respuesta_1 = $_POST["" . $respuesta1 . ""];
        $respuestas["" . $respuesta1 . ""] = $respuesta_1;

      }
    }

    if ($si_sociales['sociales_status'] == 'SI') {

      $sociales_p1_2 = $si_sociales['sociales_p1'];
      $sociales_p2_2 = $si_sociales['sociales_p2'];

      $sociales_p1 = (int) $sociales_p1_2;
      $sociales_p2 = (int) $sociales_p2_2;

      $respuesta1 = 'p-'.$sociales_p1;
      $respuesta_1 = $_POST["" . $respuesta1 . ""];
      $respuestas["" . $respuesta1 . ""] = $respuesta_1;


      $suma_sociales = $sociales_p1;
      for ($i = $sociales_p1; $i < $sociales_p2; $i++) {

        $suma_sociales += 1;
        $respuesta1 = 'p-'.$suma_sociales;
        $respuesta_1 = $_POST["" . $respuesta1 . ""];
        $respuestas["" . $respuesta1 . ""] = $respuesta_1;

      }
    }

    if ($si_filosofia['filosofia_status'] == 'SI') {

      $filosofia_p1_2 = $si_filosofia['filosofia_p1'];
      $filosofia_p2_2 = $si_filosofia['filosofia_p2'];

      $filosofia_p1 = (int) $filosofia_p1_2;
      $filosofia_p2 = (int) $filosofia_p2_2;

      $respuesta1 = 'p-'.$filosofia_p1;
      $respuesta_1 = $_POST["" . $respuesta1 . ""];
      $respuestas["" . $respuesta1 . ""] = $respuesta_1;


      $suma_filosofia = $filosofia_p1;
      for ($i = $filosofia_p1; $i < $filosofia_p2; $i++) {

        $suma_filosofia += 1;
        $respuesta1 = 'p-'.$suma_filosofia;
        $respuesta_1 = $_POST["" . $respuesta1 . ""];
        $respuestas["" . $respuesta1 . ""] = $respuesta_1;

      }
    }

    if ($si_fisica['fisica_status'] == 'SI') {

      $fisica_p1_2 = $si_fisica['fisica_p1'];
      $fisica_p2_2 = $si_fisica['fisica_p2'];

      $fisica_p1 = (int) $fisica_p1_2;
      $fisica_p2 = (int) $fisica_p2_2;

      $respuesta1 = 'p-'.$fisica_p1;
      $respuesta_1 = $_POST["" . $respuesta1 . ""];
      $respuestas["" . $respuesta1 . ""] = $respuesta_1;


      $suma_fisica = $fisica_p1;
      for ($i = $fisica_p1; $i < $fisica_p2; $i++) {

        $suma_fisica += 1;
        $respuesta1 = 'p-'.$suma_fisica;
        $respuesta_1 = $_POST["" . $respuesta1 . ""];
        $respuestas["" . $respuesta1 . ""] = $respuesta_1;

      }
    }

    $respuestas_final = json_encode($respuestas);

    $status = 1;
    
    try {

      $alum_grado = $_SESSION["datos"]['gra_esc'];

      if (isset(GRADOS_COD[$alum_grado])) {
        $alum_gradox = GRADOS_COD[$alum_grado];
      }

      $stmt = $conn->prepare("UPDATE siscpi_simulacros_e SET simule_respuestas=?, simule_status=?, simule_editado = NOW() WHERE simule_simul_id=? AND simule_alum_id=?");
      $stmt->bind_param("siii", $respuestas_final, $status, $simul_id, $alum_id);
      $stmt->execute();

      $registro = $stmt->affected_rows;

      if($registro > 0){
        $respuesta = array(
          'respuesta' => 'exito',
          'grado' => $alum_gradox
        );
      } else {
        $respuesta = array(
          'respuesta' => 'error'
        );
      };

      $stmt->close();
      $conn->close();

    } catch (Exception $e) {
      echo "Error:" . $e->getMessage();
    } 

    die(json_encode($respuesta));
  
  }

  


} else {
  die(json_encode(array('respuesta' => "error", 'comentario' => "REQUEST_METHOD no permitido")));
}
