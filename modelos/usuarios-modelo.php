<?php
session_start();

if (!isset($_SESSION["usuario"]) || !isset($_SESSION["logid"]) || ($_SESSION["nivel"] != 1 && $_SESSION["nivel"] != 5)) {
  die(json_encode(array('respuesta' => "error", 'comentario' => "Permiso denegado")));
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

  include_once '../funciones/funciones.php';
  date_default_timezone_set('America/Bogota');
  $hoy = date("Y-m-d H:i:s");

  $data = json_decode(file_get_contents('php://input'), true);
  $respuesta = array();

  $valores_permitidos = array("consultadocnumero", "consultamunicipios", "usuario-nuevo", "user-consulta", "usuario-actualizar");


  if (!in_array($data['cmd'], $valores_permitidos)) {
    die(json_encode(array('respuesta' => "error", 'comentario' => "Comando no válido")));
  }

  if (!isset($data["user_id"]) || !is_numeric($data["user_id"])) {
    die(json_encode(array('respuesta' => "error", 'comentario' => "Id de Usuario no válido")));
  }

  //Consulta que Doc usuario no este ya registrado
  if ($data['cmd'] == 'consultadocnumero') {

    try {

      $doc_num = preg_replace('([^0-9])', '', $data['docnum']);

      try {
        $stmt = $conn->prepare("SELECT * FROM siscpi_users");
        $stmt->execute();
        $result = $stmt->get_result();
      } catch (\Exception $e) {
        $error = $e->getMessage();
        echo $error;
      }


      $existe = 1;
      while ($datos_alum = $result->fetch_assoc()) {

        $datos = json_decode($datos_alum['datos'], true);
        $alum_doc = preg_replace('([^0-9])', '', $datos['ide_num']);

        if ($doc_num == $alum_doc) {
          $existe = 2;
          $nombre = $datos['per_nom'];
          $apellido = $datos['per_ape'];
        }
      }

      if ($existe == 2) {
        $respuesta['respuesta'] = 'error';
        $respuesta['comentario'] = 'Documento registrado para usuario: ' . $nombre . ' ' . $apellido;
      } else {
        $respuesta['respuesta'] = 'exito';
      }
    } catch (\Exception $e) {
      $error = $e->getMessage();
      echo $error;
    }

    $stmt->close();

    die(json_encode($respuesta));
  }

  //Consulta Municipios según Departamento seleccionado
  if ($data['cmd'] == 'consultamunicipios') {

    try {

      $ide_departamento = preg_replace('([^0-9])', '', $data['departamento']);

      $stmt = $conn->prepare("SELECT * FROM siscpi_municipios WHERE id_departamento=?");
      $stmt->bind_param("i", $ide_departamento);
      $stmt->execute();
      $result = $stmt->get_result();
      $municipios = array();
      while ($municipio = $result->fetch_assoc()) {
        $municipios[] = $municipio;
      }

      if (count($municipios) > 0) {
        $respuesta['respuesta'] = 'exito';
        $respuesta['municipios'] = $municipios;
      } else {
        $respuesta['respuesta'] = 'error';
        $respuesta['comentario'] = 'No se pudo obtener el listado de Municipios, por favor intente nuevamente';
      }
    } catch (\Exception $e) {
      $error = $e->getMessage();
      echo $error;
    }
    $stmt->close();

    die(json_encode($respuesta));
  }

  //Registra Usuario Nuevo
  if ($data['cmd'] == 'usuario-nuevo') {

    try {
      $stmt = $conn->prepare("SELECT * FROM siscpi_users");
      $stmt->execute();
      $result = $stmt->get_result();
    } catch (\Exception $e) {
      $error = $e->getMessage();
      echo $error;
    }

    $existe = 1;
    while ($datos_users = $result->fetch_assoc()) {

      $datos = json_decode($datos_users['datos'], true);
      $user_doc = preg_replace('([^0-9])', '', $datos['ide_num']);
      $doc_num = preg_replace('([^0-9])', '', $data['ide_num']['value']);

      if ($doc_num == $user_doc) {
        $existe = 2;
        $nombre = $datos['per_nom'];
        $apellido = $datos['per_ape'];
      }
    }

    if ($existe == 2) {
      $respuesta['respuesta'] = 'error';
      $respuesta['comentario'] = 'Documento registrado para usuario: ' . $nombre . ' ' . $apellido;
    } else {

      $id_usuario = $data['user_id'];
      $fecha_mat = date("d/m/Y", strtotime($hoy));

      unset($data['cmd']);
      unset($data['user_id']);

      $data_nueva = array();
      $data_nueva['fec_mat'] = $fecha_mat;
      $data_nueva['estatus'] = 'ACTIVO';


      foreach ($data as $key => $value) {

        if ($data[$key]['tipo'] == 'solotexto') {
          $nuevo_valor = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ , () ° : .])', '', $data[$key]['value']);
          $data_nueva[$key] = $nuevo_valor;
        } elseif ($data[$key]['tipo'] == 'solonumero') {
          $nuevo_valor = preg_replace('([^0-9. ])', '', $data[$key]['value']);
          $data_nueva[$key] = $nuevo_valor;
        } elseif ($data[$key]['tipo'] == 'textoynumero') {
          $nuevo_valor = preg_replace('([^A-Za-zZÑñáéíóúüÁÉÍÓÚÜ0-9 ])', '', $data[$key]['value']);
          $data_nueva[$key] = $nuevo_valor;
        } elseif ($data[$key]['tipo'] == 'correo') {
          $nuevo_valor = preg_replace('([^a-zA-Z0-9 @_.-])', '', $data[$key]['value']);
          $data_nueva[$key] = $nuevo_valor;
        } elseif ($data[$key]['tipo'] == 'fecha') {
          $nuevo_valor = preg_replace('([^0-9 /])', '', $data[$key]['value']);
          $data_nueva[$key] = $nuevo_valor;
        } elseif ($data[$key]['tipo'] == 'telefono' || $data[$key]['tipo'] == 'direccion') {
          $nuevo_valor = preg_replace('([^A-Za-zZÑñáéíóúüÁÉÍÓÚÜ0-9 # , () ° : . _ -])', '', $data[$key]['value']);
          $data_nueva[$key] = $nuevo_valor;
        } else {
          $nuevo_valor = '';
          $data_nueva[$key] = $nuevo_valor;
        }
      }

      try {

        $doc_obtenido = $data_nueva['ide_num'];
        $usuario = preg_replace("/\./", "", $doc_obtenido);
        $nombre = $data_nueva['per_nom'] . ' ' . $data_nueva['per_ape'];

        if ($data_nueva['use_rol'] === 'RECTOR(A)') {
          $acceso = 2;
        } elseif ($data_nueva['use_rol'] === 'COORDINADOR(A)') {
          $acceso = 3;
        } elseif ($data_nueva['use_rol'] === 'COORD. ICFES') {
          $acceso = 4;
        } elseif ($data_nueva['use_rol'] === 'SECRETARIA') {
          $acceso = 5;
        } elseif ($data_nueva['use_rol'] === 'DOCENTE') {
          $acceso = 6;
        } elseif ($data_nueva['use_rol'] === 'PSICÓLOGO') {
          $acceso = 7;
        } elseif ($data_nueva['use_rol'] === 'SYSTEM ADMIN') {
          $acceso = 1;
        }

        $intentos = 0;
        $status = 'ACTIVO';

        $opciones = ['cost' => 12];
        $password_hashed = password_hash($usuario, PASSWORD_BCRYPT, $opciones) . "/n";

        $stmt = $conn->prepare("INSERT INTO siscpi_logins (logins_nickname, logins_nombre, logins_password, logins_nivel, logins_intentos, logins_status, logins_editado) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiiss", $usuario, $nombre, $password_hashed, $acceso, $intentos, $status, $hoy);
        $stmt->execute();
        $user_idlog = $stmt->insert_id;
      } catch (Exception $e) {
        echo "FALLO LA CREACIÓN DEL LOGIN" . $e->getMessage();
      }


      if ($user_idlog > 0) {

        $datos_finales = json_encode($data_nueva);

        try {
          $stmt = $conn->prepare("INSERT INTO siscpi_users (id_login, datos, usuario, editado) VALUES (?, ?, ?, ?)");
          $stmt->bind_param("isss", $user_idlog, $datos_finales, $id_usuario, $hoy);
          $stmt->execute();
          $id_obtenido = $stmt->insert_id;

          if ($id_obtenido > 0) {

            $respuesta['respuesta'] = 'exito';
            $respuesta['comentario'] = 'Usuario registrado correctamente';
            $respuesta['idObtenido'] = $id_obtenido;
            $respuesta['idUser'] = $id_usuario;
          } else {
            $respuesta['respuesta'] = 'error';
            $respuesta['comentario'] = 'El Usuario no pudo ser registrado';
          };
        } catch (Exception $e) {
          echo "FALLO LA CONSULTA:" . $e->getMessage();
        }
      } else {
        $respuesta['respuesta'] = 'error';
        $respuesta['comentario'] = 'No se pudo crear el ID de inicio de sesión';
      };
    }


    $stmt->close();

    die(json_encode($respuesta));
  }

  //Consulta Datos del usuario
  if ($data['cmd'] == 'user-consulta') {
    try {
      $id_user = preg_replace('([^0-9])', '', $data['id']);
      $stmt = $conn->prepare("SELECT * FROM siscpi_users WHERE id=?");
      $stmt->bind_param("i", $id_user);
      $stmt->execute();
      $result = $stmt->get_result();
      $datos = $result->fetch_assoc();
      if ($result->num_rows > 0) {
        $respuesta['respuesta'] = 'exito';
        $respuesta['datos'] = $datos;
        $respuesta['id'] = $id_user;
      } else {
        $respuesta['respuesta'] = 'error';
      }
    } catch (\Exception $e) {
      $error = $e->getMessage();
      echo $error;
    }
    $stmt->close();
    die(json_encode($respuesta));
  }

  //Ejecuta actualización de Usuario
  if ($data['cmd'] == 'usuario-actualizar') {

    $id_usuario = $data['user_id'];

    unset($data['cmd']);
    unset($data['user_id']);
    $fecha_mat = date("d/m/Y", strtotime($hoy));


    $stmt = $conn->prepare("SELECT * FROM siscpi_users WHERE id=?");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $datos2 = $result->fetch_assoc();
    $datos = json_decode($datos2['datos'], true);
    $user_id_login = $datos2['id_login'];

    $data_nueva = array();
    $data_nueva['fec_mat'] = $fecha_mat;
    $data_nueva['estatus'] = 'ACTIVO';

    foreach ($data as $key => $value) {

        if ($data[$key]['tipo'] == 'solotexto') {
          $nuevo_valor = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ , () ° : .])', '', $data[$key]['value']);
          $data_nueva[$key] = $nuevo_valor;
        } elseif ($data[$key]['tipo'] == 'solonumero') {
          $nuevo_valor = preg_replace('([^0-9. ])', '', $data[$key]['value']);
          $data_nueva[$key] = $nuevo_valor;
        } elseif ($data[$key]['tipo'] == 'textoynumero') {
          $nuevo_valor = preg_replace('([^A-Za-zZÑñáéíóúüÁÉÍÓÚÜ0-9 ])', '', $data[$key]['value']);
          $data_nueva[$key] = $nuevo_valor;
        } elseif ($data[$key]['tipo'] == 'correo') {
          $nuevo_valor = preg_replace('([^a-zA-Z0-9 @_.-])', '', $data[$key]['value']);
          $data_nueva[$key] = $nuevo_valor;
        } elseif ($data[$key]['tipo'] == 'fecha') {
          $nuevo_valor = preg_replace('([^0-9 /])', '', $data[$key]['value']);
          $data_nueva[$key] = $nuevo_valor;
        } elseif ($data[$key]['tipo'] == 'telefono' || $data[$key]['tipo'] == 'direccion') {
          $nuevo_valor = preg_replace('([^A-Za-zZÑñáéíóúüÁÉÍÓÚÜ0-9 # , () ° : . _ -])', '', $data[$key]['value']);
          $data_nueva[$key] = $nuevo_valor;
        } else {
          $nuevo_valor = '';
          $data_nueva[$key] = $nuevo_valor;
        }
        
    }

    $datos_finales = json_encode($data_nueva);

    try {
      $stmt = $conn->prepare("UPDATE siscpi_users SET datos=?, usuario=?, editado= NOW() WHERE id=?");
      $stmt->bind_param("sss", $datos_finales, $_SESSION["logid"], $id_usuario);
      $stmt->execute();

      if ($stmt->affected_rows) {

        try {

          $doc_obtenido = $data_nueva['ide_num'];
          $usuario = preg_replace("/\./", "", $doc_obtenido);
          $nombre = $data_nueva['per_nom'] . ' ' . $data_nueva['per_ape'];

          if ($data_nueva['use_rol'] === 'RECTOR(A)') {
            $acceso = 2;
          } elseif ($data_nueva['use_rol'] === 'COORDINADOR(A)') {
            $acceso = 3;
          } elseif ($data_nueva['use_rol'] === 'COORD. ICFES') {
            $acceso = 4;
          } elseif ($data_nueva['use_rol'] === 'SECRETARIA') {
            $acceso = 5;
          } elseif ($data_nueva['use_rol'] === 'DOCENTE') {
            $acceso = 6;
          } elseif ($data_nueva['use_rol'] === 'PSICÓLOGO') {
            $acceso = 7;
          } elseif ($data_nueva['use_rol'] === 'SYSTEM ADMIN') {
            $acceso = 1;
          }

          $intentos = 0;
          $status = 'ACTIVO';

         /*  $opciones = ['cost' => 12];
          $password_hashed = password_hash($usuario, PASSWORD_BCRYPT, $opciones) . "/n"; */

          $stmt = $conn->prepare("UPDATE siscpi_logins SET logins_nickname=?, logins_nombre=?, logins_nivel=?, logins_intentos=?, logins_status=?, logins_editado = NOW() WHERE logins_id_login=?");
          $stmt->bind_param("ssiisi", $usuario, $nombre, $acceso, $intentos, $status, $user_id_login);
          $stmt->execute();

          if($stmt->affected_rows){
            $respuesta['respuesta'] = 'exito';
            $respuesta['comentario'] = 'Usuario actualizado correctamente';
            $respuesta['idObtenido'] = $id_usuario;
            $respuesta['idUser'] = $_SESSION["logid"];
          } else {
            $respuesta['respuesta'] = 'error';
            $respuesta['comentario'] = 'El usuario no pudo ser actualizado';
          };

        } catch (Exception $e) {
          echo "FALLO LA CREACIÓN DEL LOGIN" . $e->getMessage();
        }
      } else {
        $respuesta['respuesta'] = 'error';
        $respuesta['comentario'] = 'El usuario no pudo ser actualizado';
      };
    } catch (Exception $e) {
      echo "FALLO LA CONSULTA:" . $e->getMessage();
    }

    $stmt->close();

    die(json_encode($respuesta));
  }
} else {
  die(json_encode(array('respuesta' => "error", 'comentario' => "REQUEST_METHOD no permitido")));
}
