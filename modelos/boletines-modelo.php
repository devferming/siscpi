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

  $valores_permitidos = array("boletines-consulta");


  if (!in_array($data['cmd'], $valores_permitidos)) {
    die(json_encode(array('respuesta' => "error", 'comentario' => "Comando no válido")));
  }

  if (!isset($data["user_id"]) || !is_numeric($data["user_id"])) {
    die(json_encode(array('respuesta' => "error", 'comentario' => "Id de Usuario no válido")));
  }

  if ($data["user_id"] != $_SESSION["logid"]) {
    die(json_encode(array('respuesta' => "error", 'comentario' => "Id de Usuario no válido")));
  }

  //Retorna objeto json con los datos de los boletines de los alumnos del grado seleccionado
  if ($data['cmd'] == 'boletines-consulta') {

    unset($data['user_id']);
    unset($data['cmd']);

    $gra = strtoupper(preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ () ])', '', $data['gra']));
    $sec = strtoupper(preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ () ])', '', $data['sec']));
    $per = strtoupper(preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ () ])', '', $data['per']));

    try {

      $stmt_alumnos = $conn->prepare("SELECT * FROM siscpi_alumnos");
      $stmt_alumnos->execute();
      $result_alumnos = $stmt_alumnos->get_result();
      $alumnos = array();

      while ($row_alumnos = $result_alumnos->fetch_assoc()) {

        $temp_dat = json_decode($row_alumnos['datos'], true);

        if ($temp_dat['gra_esc'] == $gra && $temp_dat['gra_sec'] == $sec && $temp_dat['estatus'] == "MATRICULADO") {
          $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
          $stmt->bind_param("i", $row_alumnos['id']);
          $stmt->execute();
          $notas_resultado = $stmt->get_result();
          $notas_row = $notas_resultado->fetch_assoc();

          $temp_not = json_decode($notas_row['datos'], true);
          
          $alumnos[$row_alumnos['id']] = array('datos' => $temp_dat, 'notas' => $temp_not);
  
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

    $stmt_alumnos->close();
    $conn->close();

    die(json_encode($respuesta));
  }
 

} else {
  die(json_encode(array('respuesta' => "error", 'comentario' => "REQUEST_METHOD no permitido")));
}
