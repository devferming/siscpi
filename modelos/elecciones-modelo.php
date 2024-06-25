<?php
session_start();

if (!isset($_SESSION["usuario"]) || !isset($_SESSION["logid"]) || $_SESSION["nivel"] != 1) {
  die(json_encode(array('respuesta' => "error", 'comentario' => "Permiso denegado")));
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

  include_once '../funciones/funciones.php';
  date_default_timezone_set('America/Bogota');
  $hoy = date("Y-m-d H:i:s");

  $data = json_decode(file_get_contents('php://input'), true);
  $respuesta = array();

  $valores_permitidos = array("con-mesa", "hab-mesa", "env-voto");


  if (!in_array($data['cmd'], $valores_permitidos)) {
    die(json_encode(array('respuesta' => "error", 'comentario' => "Comando no válido")));
  }

  if (!isset($data["user_id"]) || !is_numeric($data["user_id"])) {
    die(json_encode(array('respuesta' => "error", 'comentario' => "Id de Usuario no válido")));
  }

  //Consulta disponibilidad de mesa electoral
  if ($data['cmd'] == 'con-mesa') {

    $id_elec = 2;

    try {

      try {
        $stmt = $conn->prepare("SELECT * FROM siscpi_elecciones WHERE id=?");
        $stmt->bind_param("i", $id_elec);
        $stmt->execute();
        $result = $stmt->get_result();
        $datos_stmt = $result->fetch_assoc();
        $datos = json_decode($datos_stmt['mesas'], true);
      } catch (\Exception $e) {
        $error = $e->getMessage();
        echo $error;
      }

      $disponible = "sin disponibilidad";
      foreach ($datos as $mesa => $estado) {
        if ($estado == 'desocupada') {
          if ($mesa == 'mesa_001') {
            $disponible = '1';
          } else if ($mesa == 'mesa_002') {
            $disponible = '2';
          } else if ($mesa == 'mesa_003') {
            $disponible = '3';
          } else if ($mesa == 'mesa_004') {
            $disponible = '4';
          } else if ($mesa == 'mesa_005') {
            $disponible = '5';
          }

          break;
        }
      }

      if ($disponible == "sin disponibilidad") {
        $respuesta['respuesta'] = 'error';
        $respuesta['mesa'] = 'No hay mesas disponibles';
      } else {
        $respuesta['respuesta'] = 'exito';
        $respuesta['mesa'] = $disponible;
      }
    } catch (\Exception $e) {
      $error = $e->getMessage();
      echo $error;
    }

    $stmt->close();

    die(json_encode($respuesta));
  }

  //Consulta disponibilidad de mesa electoral
  if ($data['cmd'] == 'hab-mesa') {

    $mesa = preg_replace('([^0-9])', '', $data['mes']);
    $aid = preg_replace('([^0-9])', '', $data['aid']);
    $id_elec = 2;


    try {

      try {
        $stmt = $conn->prepare("SELECT * FROM siscpi_elecciones WHERE id=?");
        $stmt->bind_param("i", $id_elec);
        $stmt->execute();
        $result = $stmt->get_result();
        $datos_stmt = $result->fetch_assoc();
        $mesas = json_decode($datos_stmt['mesas'], true);
        $turno = json_decode($datos_stmt['turno'], true);
      } catch (\Exception $e) {
        $error = $e->getMessage();
        echo $error;
      }

      if ($mesa == '1') {
        $mesa_new = 'mesa_001';
      } else if ($mesa == '2') {
        $mesa_new = 'mesa_002';
      } else if ($mesa == '3') {
        $mesa_new = 'mesa_003';
      } else if ($mesa == '4') {
        $mesa_new = 'mesa_004';
      } else if ($mesa == '5') {
        $mesa_new = 'mesa_005';
      }

      $mesas[$mesa_new] = 'ocupada';
      $turno[$mesa_new] = $aid;

      $mesas_nuevo = json_encode($mesas);
      $turno = json_encode($turno);

      try {
        $stmt = $conn->prepare("UPDATE siscpi_elecciones SET mesas=?, turno=?, editado= NOW() WHERE id=?");
        $stmt->bind_param("ssi", $mesas_nuevo, $turno, $id_elec);
        $stmt->execute();

        if ($stmt->affected_rows) {

          try {
            $stmt = $conn->prepare("SELECT * FROM siscpi_alumnos WHERE id=?");
            $stmt->bind_param("i", $aid);
            $stmt->execute();
            $result = $stmt->get_result();
            $datos_stmt = $result->fetch_assoc();
            $datos_alum = json_decode($datos_stmt['datos'], true);

            $datos_alum['ele_esc'] = '2';
            $datos_nuevos = json_encode($datos_alum);

            $stmt = $conn->prepare("UPDATE siscpi_alumnos SET datos=?, editado= NOW() WHERE id=?");
            $stmt->bind_param("si", $datos_nuevos, $aid);
            $stmt->execute();

            if ($stmt->affected_rows) {
              $respuesta['respuesta'] = 'exito';
              $respuesta['comentario'] = 'Mesa habilitada';
              $respuesta['info'] = 'Mesa ' . $mesa . ' habilitada para: ' . $datos_alum['per_nom'] . ' ' . $datos_alum['per_ape'];
            } else {
              $respuesta['respuesta'] = 'error';
              $respuesta['comentario'] = 'No se pudo habilitar la votación';
            };
          } catch (\Exception $e) {
            $error = $e->getMessage();
            echo $error;
          }
        } else {
          $respuesta['respuesta'] = 'error';
          $respuesta['comentario'] = 'No se pudo habilitar la mesa';
        };
      } catch (\Exception $e) {
        $error = $e->getMessage();
        echo $error;
      }
    } catch (\Exception $e) {
      $error = $e->getMessage();
      echo $error;
    }

    $stmt->close();

    die(json_encode($respuesta));
  }

  if ($data['cmd'] == 'env-voto') {

    $mesa_ac = preg_replace('([^A-Za-zZÑñáéíóúüÁÉÍÓÚÜ0-9 # , () ° : . _ -])', '', $data['mesa_ac']);
    $voto_op = preg_replace('([^0-9])', '', $data['voto_op']);
    $id_elec = 2;


    try {

      try {
        $stmt = $conn->prepare("SELECT * FROM siscpi_elecciones WHERE id=?");
        $stmt->bind_param("i", $id_elec);
        $stmt->execute();
        $result = $stmt->get_result();
        $datos_stmt = $result->fetch_assoc();
        $conte = json_decode($datos_stmt['conteo'], true);
        $mesas = json_decode($datos_stmt['mesas'], true);
        $turno = json_decode($datos_stmt['turno'], true);
      } catch (\Exception $e) {
        $error = $e->getMessage();
        echo $error;
      }

      if ($mesa_ac == '1') {
        $mesa_new = 'mesa_001';
      } else if ($mesa_ac == '2') {
        $mesa_new = 'mesa_002';
      } else if ($mesa_ac == '3') {
        $mesa_new = 'mesa_003';
      } else if ($mesa_ac == '4') {
        $mesa_new = 'mesa_004';
      } else if ($mesa_ac == '5') {
        $mesa_new = 'mesa_005';
      }

      $estado_turno = $turno[$mesa_new];

      if ($estado_turno > 0) {
        if ($voto_op == 1) {
          $voto = 'can_uno';
        } else  if ($voto_op == 2) {
          $voto = 'can_dos';
        } else  if ($voto_op == 3) {
          $voto = 'vot_nul';
        }

        $votos_actuales = $conte[$voto];
        $votos_nuevos = $votos_actuales + 1;
        $conte[$voto] = $votos_nuevos;
        $conteo_nuevo = json_encode($conte);

        $mesas[$mesa_new] = 'desocupada';
        $mesas_nueva = json_encode($mesas);

        $aid = $turno[$mesa_new];
        $turno[$mesa_new] = '0';
        $turno_nuevo = json_encode($turno);

        try {
          $stmt = $conn->prepare("UPDATE siscpi_elecciones SET conteo=?, mesas=?, turno=?, editado= NOW() WHERE id=?");
          $stmt->bind_param("sssi", $conteo_nuevo, $mesas_nueva, $turno_nuevo, $id_elec);
          $stmt->execute();

          if ($stmt->affected_rows) {

            try {
              $stmt = $conn->prepare("SELECT * FROM siscpi_alumnos WHERE id=?");
              $stmt->bind_param("i", $aid);
              $stmt->execute();
              $result = $stmt->get_result();
              $datos_stmt = $result->fetch_assoc();
              $datos_alum = json_decode($datos_stmt['datos'], true);

              $datos_alum['ele_esc'] = '3';
              $datos_nuevos = json_encode($datos_alum);

              $stmt = $conn->prepare("UPDATE siscpi_alumnos SET datos=?, editado= NOW() WHERE id=?");
              $stmt->bind_param("si", $datos_nuevos, $aid);
              $stmt->execute();

              if ($stmt->affected_rows) {
                $respuesta['respuesta'] = 'exito';
                $respuesta['comentario'] = 'Votos registrado exitosamente';
              } else {
                $respuesta['respuesta'] = 'error';
                $respuesta['comentario'] = 'El voto no pudo ser registrado';
              };
            } catch (\Exception $e) {
              $error = $e->getMessage();
              echo $error;
            }
          } else {
            $respuesta['respuesta'] = 'error';
            $respuesta['comentario'] = 'Algo salió mal';
          };
        } catch (\Exception $e) {
          $error = $e->getMessage();
          echo $error;
        }
      } else {
        $respuesta['respuesta'] = 'error';
        $respuesta['comentario'] = 'Mesa Cerrada';
      }
    } catch (\Exception $e) {
      $error = $e->getMessage();
      echo $error;
    }

    $stmt->close();

    die(json_encode($respuesta));
  }
} else {
  die(json_encode(array('respuesta' => "error", 'comentario' => "REQUEST_METHOD no permitido")));
}
