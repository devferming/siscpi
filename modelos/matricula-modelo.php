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
  $valores_permitidos = array("consultamunicipios", "alumno-nuevo", "alumno-actualizar", "alumno-consulta", "consultadocnumero", "mat-lotes", "informe-consulta", "informe-consulta5", "seccion-nueva", "nuevo-estatus", "eliminar-alum");
  if (!in_array($data['cmd'], $valores_permitidos)) {
    die(json_encode(array('respuesta' => "error", 'comentario' => "Comando no válido")));
  }
  if (!isset($data["user_id"]) || !is_numeric($data["user_id"])) {
    die(json_encode(array('respuesta' => "error", 'comentario' => "Id de Usuario no válido")));
  }
  //Consulta que Doc Alum no este ya registrado
  if ($data['cmd'] == 'consultadocnumero') {
    try {
      $doc_num = preg_replace('([^0-9])', '', $data['docnum']);
      try {
        $stmt = $conn->prepare("SELECT * FROM siscpi_alumnos");
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
          $grado = $datos['gra_esc'];
        }
      }
      if ($existe == 2) {
        $respuesta['respuesta'] = 'error';
        $respuesta['comentario'] = 'Documento registrado para alumno: ' . $nombre . ' ' . $apellido . ' del grado: ' . $grado;
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
  //Consulta Datos del Alumno
  if ($data['cmd'] == 'alumno-consulta') {
    try {
      $id_alumno = preg_replace('([^0-9])', '', $data['id']);
      $stmt = $conn->prepare("SELECT * FROM siscpi_alumnos WHERE id=?");
      $stmt->bind_param("i", $id_alumno);
      $stmt->execute();
      $result = $stmt->get_result();
      $datos = $result->fetch_assoc();
      if ($result->num_rows > 0) {
        $respuesta['respuesta'] = 'exito';
        $respuesta['datos'] = $datos;
        $respuesta['id'] = $id_alumno;
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
  //Registra Alumno Nuevo
  if ($data['cmd'] == 'alumno-nuevo') {
    try {
      $stmt = $conn->prepare("SELECT * FROM siscpi_alumnos");
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
      $doc_num = preg_replace('([^0-9])', '', $data['ide_num']['value']);
      if ($doc_num == $alum_doc) {
        $existe = 2;
        $nombre = $datos['per_nom'];
        $apellido = $datos['per_ape'];
        $grado = $datos['gra_esc'];
      }
    }
    if ($existe == 2) {
      $respuesta['respuesta'] = 'error';
      $respuesta['comentario'] = 'Documento registrado para alumno: ' . $nombre . ' ' . $apellido . ' del grado: ' . $grado;
    } else {
      $id_usuario = $data['user_id'];
      $alum_grd = $data['alumGrd'];
      $fecha_mat = date("d/m/Y", strtotime($hoy));
      unset($data['cmd']);
      unset($data['user_id']);
      unset($data['alum_id']);
      unset($data['alumGrd']);
      $stmt = $conn->prepare("SELECT * FROM siscpi_grados WHERE gdo_des_grado=?");
      $stmt->bind_param("s", $alum_grd);
      $stmt->execute();
      $result = $stmt->get_result();
      $datos_alum = $result->fetch_assoc();
      $datos = json_decode($datos_alum['gdo_des_folio'], true);
      $key_fol = 0;
      if (empty($datos)) {
        $key_fol = 1;
      } else {
        foreach ($datos as $k => $v) {
          if ($k > $key_fol) {
            $key_fol = $k;
          }
        }
        $key_fol++;
      }
      $data_nueva = array();
      $data_nueva['fec_mat'] = $fecha_mat;
      $data_nueva['alu_fol'] = $key_fol;
      $data_nueva['estatus'] = 'MATRICULADO';
      foreach ($data as $key => $value) {
        if ($data[$key]['tipo'] == 'solotexto') {
          $nuevo_valor = preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ ])', '', $data[$key]['value']);
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
        $stmt = $conn->prepare("INSERT INTO siscpi_alumnos (datos, usuario, editado) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $datos_finales, $id_usuario, $hoy);
        $stmt->execute();
        $id_obtenido = $stmt->insert_id;
        if ($id_obtenido > 0) {
          $datos[$key_fol] = $id_obtenido;
          $datos_folio = json_encode($datos);
          $stmt = $conn->prepare("UPDATE siscpi_grados SET gdo_des_folio=?, gdo_des_editado= NOW() WHERE gdo_des_grado=?");
          $stmt->bind_param("ss", $datos_folio, $alum_grd);
          $stmt->execute();
          if ($stmt->affected_rows) {
            $respuesta['respuesta'] = 'exito';
            $respuesta['comentario'] = 'Alumno registrado correctamente';
            $respuesta['idObtenido'] = $id_obtenido;
            $respuesta['idUser'] = $id_usuario;
          } else {
            $respuesta['respuesta'] = 'error';
            $respuesta['comentario'] = 'No se pudo completar el registro del alumno, falto registrar el Folio';
          };
        } else {
          $respuesta['respuesta'] = 'error';
          $respuesta['comentario'] = 'El alumno no pudo ser registrado';
        };
      } catch (Exception $e) {
        echo "FALLO LA CONSULTA:" . $e->getMessage();
      }
    }
    $stmt->close();
    die(json_encode($respuesta));
  }
  //Registra Alumnos por Lotes
  if ($data['cmd'] == 'mat-lotes') {
    $id_usuario = $data['user_id'];
    unset($data['cmd']);
    unset($data['user_id']);
    $fecha_mat = date("d/m/Y", strtotime($hoy));
    $mat_ids = $data['dataMad'];
    $alu_reg = 0;

    try {
      foreach ($mat_ids as $clave => $valor) {
        $alum_id = $clave;
        $stmt = $conn->prepare("SELECT * FROM alumnos WHERE alum_id=?");
        $stmt->bind_param("i", $alum_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $datos_alum = $resultado->fetch_assoc();
        $alu_ide = $datos_alum['alum_id'];
        $grado_viejo = $datos_alum['alum_grado'];

        switch ($grado_viejo) {
          case 'PRE JARDÍN':
            $alum_grd = 'JARDÍN';
            break;
          case 'JARDÍN':
            $alum_grd = 'TRANSICIÓN';
            break;
          case 'TRANSICIÓN':
            $alum_grd = 'PRIMERO';
            break;
          case 'PRIMERO':
            $alum_grd = 'SEGUNDO';
            break;
          case 'SEGUNDO':
            $alum_grd = 'TERCERO';
            break;
          case 'TERCERO':
            $alum_grd = 'CUARTO';
            break;
          case 'CUARTO':
            $alum_grd = 'QUINTO';
            break;
          case 'QUINTO':
            $alum_grd = 'SEXTO';
            break;
          case 'SEXTO':
            $alum_grd = 'SÉPTIMO';
            break;
          case 'SÉPTIMO':
            $alum_grd = 'OCTAVO';
            break;
          case 'OCTAVO':
            $alum_grd = 'NOVENO';
            break;
          case 'NOVENO':
            $alum_grd = 'DÉCIMO';
            break;
          case 'DÉCIMO':
            $alum_grd = 'UNDÉCIMO';
            break;
          default:
            $alum_grd = '';
            break;
        }
        if ($alu_ide > 0) {
          $stmt = $conn->prepare("SELECT * FROM siscpi_grados WHERE gdo_des_grado=?");
          $stmt->bind_param("s", $alum_grd);
          $stmt->execute();
          $result = $stmt->get_result();
          $datos_grado = $result->fetch_assoc();
          $datos = json_decode($datos_grado['gdo_des_folio'], true);

          $key_fol = 0;
          if (empty($datos)) {
            $key_fol = 1;
          } else {
            foreach ($datos as $k => $v) {
              if ($k > $key_fol) {
                $key_fol = $k;
              }
            }
            $key_fol++;
          }
          $nuevo_alumno = array();
          $nuevo_alumno['fec_mat'] = $fecha_mat;
          $nuevo_alumno['alu_fol'] = $key_fol;
          $nuevo_alumno['estatus'] = 'MATRICULADO';
          $nuevo_alumno['ide_tip'] = $datos_alum['alum_doc_tipo'];
          $nuevo_alumno['ide_num'] = $datos_alum['alum_doc_numero'];
          $nuevo_alumno['ide_exp'] = $datos_alum['alum_doc_lugar'];
          $nuevo_alumno['per_ape'] = $datos_alum['alum_1er_apellido'];
          $nuevo_alumno['sdo_ape'] = $datos_alum['alum_2do_apellido'];
          $nuevo_alumno['per_nom'] = $datos_alum['alum_1er_nombre'];
          $nuevo_alumno['sdo_nom'] = $datos_alum['alum_2do_nombre'];
          $alum_nac_fecha2 = $datos_alum['alum_nac_fecha'];
          if ($alum_nac_fecha2 == '0000-00-00') {
            $alum_nac_fecha = '20/10/1987';
            $edad = '35';
          } else {
            $alum_nac_fecha = DateTime::createFromFormat('Y-m-d', $alum_nac_fecha2)->format('d/m/Y');
            $hoy2 = new DateTime();
            $alum_nac_fecha_obj = DateTime::createFromFormat('d/m/Y', $alum_nac_fecha);
            $edad = date_diff($alum_nac_fecha_obj, $hoy2)->y;
          }
          $nuevo_alumno['nac_fec'] = $alum_nac_fecha;
          $nuevo_alumno['age_num'] = $edad;
          $nuevo_alumno['alu_gen'] = $datos_alum['alum_genero'];
          $nuevo_alumno['nac_dep'] = 'ATLÁNTICO';
          $nuevo_alumno['nac_mun'] = 'MALAMBO';
          $nuevo_alumno['dir_dir'] = $datos_alum['alum_direccion'];
          $nuevo_alumno['dir_bar'] = $datos_alum['alum_barrio'];
          $nuevo_alumno['dir_loc'] = $datos_alum['alum_telf_local'];
          $nuevo_alumno['tel_mov'] = $datos_alum['alum_telf_movil'];
          $nuevo_alumno['alu_mai'] = $datos_alum['alum_mail'];
          $nuevo_alumno['alu_est'] = '1';
          $nuevo_alumno['sis_niv'] = 'A';
          $nuevo_alumno['alu_get'] = 'NINGUNO';
          $nuevo_alumno['n97_nom'] = '';
          $nuevo_alumno['n97_ani'] = '';
          $nuevo_alumno['n98_nom'] = '';
          $nuevo_alumno['n98_ani'] = '';
          $nuevo_alumno['n99_nom'] = $datos_alum['alum_grado_0'];
          $nuevo_alumno['n99_ani'] = '';
          $nuevo_alumno['n1_nom'] = $datos_alum['alum_grado_1'];
          $nuevo_alumno['n1_ani'] = '';
          $nuevo_alumno['n2_nom'] = $datos_alum['alum_grado_2'];
          $nuevo_alumno['n2_ani'] = '';
          $nuevo_alumno['n3_nom'] = $datos_alum['alum_grado_3'];
          $nuevo_alumno['n3_ani'] = '';
          $nuevo_alumno['n4_nom'] = $datos_alum['alum_grado_4'];
          $nuevo_alumno['n4_ani'] = '';
          $nuevo_alumno['n5_nom'] = $datos_alum['alum_grado_5'];
          $nuevo_alumno['n5_ani'] = '';
          $nuevo_alumno['n6_nom'] = $datos_alum['alum_grado_6'];
          $nuevo_alumno['n6_ani'] = '';
          $nuevo_alumno['n7_nom'] = $datos_alum['alum_grado_7'];
          $nuevo_alumno['n7_ani'] = '';
          $nuevo_alumno['n8_nom'] = $datos_alum['alum_grado_8'];
          $nuevo_alumno['n8_ani'] = '';
          $nuevo_alumno['n9_nom'] = $datos_alum['alum_grado_9'];
          $nuevo_alumno['n9_ani'] = '';
          $nuevo_alumno['n10_nom'] = $datos_alum['alum_grado_10'];
          $nuevo_alumno['n10_ani'] = '';
          $nuevo_alumno['n11_nom'] = $datos_alum['alum_grado_11'];
          $nuevo_alumno['n11_ani'] = '';
          $stmt = $conn->prepare("SELECT * FROM acudientes WHERE acu_id_alumno=?");
          $stmt->bind_param("i", $alum_id);
          $stmt->execute();
          $resultado2 = $stmt->get_result();
          $datos_alum2 = $resultado2->fetch_assoc();
          $nuevo_alumno['acu_par'] = $datos_alum2['acu_parentesco'];
          $nuevo_alumno['acu_doc'] = $datos_alum2['acu_doc_numero'];
          $nuevo_alumno['acu_nom'] = $datos_alum2['acu_1er_nombre'] . ' ' . $datos_alum2['acu_1er_apellido'];
          $nuevo_alumno['acu_cel'] = $datos_alum2['acu_telf_movil'];
          $nuevo_alumno['acu_ocu'] = '';
          $nuevo_alumno['acu_mai'] = $datos_alum2['acu_mail'];
          $mad_paren = 'MADRE';
          $pad_paren = 'PADRE';
          $stmt = $conn->prepare("SELECT * FROM padres WHERE padres_id_alumno=? AND padres_parentesco=?");
          $stmt->bind_param("is", $alum_id, $mad_paren);
          $stmt->execute();
          $resultado3 = $stmt->get_result();
          $datos_alum3 = $resultado3->fetch_assoc();
          $stmt->bind_param("is", $alum_id, $pad_paren);
          $stmt->execute();
          $resultado4 = $stmt->get_result();
          $datos_alum4 = $resultado4->fetch_assoc();
          $nuevo_alumno['mad_doc'] = $datos_alum3['padres_doc_numero'];
          $nuevo_alumno['mad_nom'] = $datos_alum3['padres_1er_nombre'] . ' ' . $datos_alum3['padres_1er_apellido'];
          $nuevo_alumno['mad_cel'] = $datos_alum3['padres_telf_movil'];
          $nuevo_alumno['mad_ocu'] = '';
          $nuevo_alumno['mad_mai'] = $datos_alum3['padres_mail'];
          $nuevo_alumno['pad_doc'] = $datos_alum4['padres_doc_numero'];
          $nuevo_alumno['pad_nom'] = $datos_alum4['padres_1er_nombre'] . ' ' . $datos_alum4['padres_1er_apellido'];
          $nuevo_alumno['pad_cel'] = $datos_alum4['padres_telf_movil'];
          $nuevo_alumno['pad_ocu'] = '';
          $nuevo_alumno['pad_mai'] = $datos_alum4['padres_mail'];
          $nuevo_alumno['ani_esc'] = '2023';
          $nuevo_alumno['gra_esc'] = $alum_grd;
          $nuevo_alumno['gra_jor'] = 'MAÑANA';
          $nuevo_alumno['obs_mat'] = '';
          $datos_finales = json_encode($nuevo_alumno);
          try {
            $stmt = $conn->prepare("INSERT INTO siscpi_alumnos (datos, usuario, editado) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $datos_finales, $id_usuario, $hoy);
            $stmt->execute();
            $id_obtenido = $stmt->insert_id;
            if ($id_obtenido > 0) {
              $datos[$key_fol] = $id_obtenido;
              $datos_folio = json_encode($datos);
              $stmt = $conn->prepare("UPDATE alumnos SET alum_id_nuevo=?, alum_editado = NOW() WHERE alum_id = ?");
              $stmt->bind_param("ii", $id_obtenido, $alu_ide);
              $stmt->execute();
              $stmt = $conn->prepare("UPDATE siscpi_grados SET gdo_des_folio=?, gdo_des_editado= NOW() WHERE gdo_des_grado=?");
              $stmt->bind_param("ss", $datos_folio, $alum_grd);
              $stmt->execute();
              if ($stmt->affected_rows) {
                $alu_reg += 1;
              }
            }
          } catch (Exception $e) {
            echo "FALLO LA REGITRO DE UNO DE LOS ALUMNOS:" . $e->getMessage();
          }
        }
      }

      if ($alu_reg > 0) {
        $respuesta['respuesta'] = 'exito';
        $respuesta['comentario'] = 'Alumnos registrados con éxito';
      } else {
        $respuesta['respuesta'] = 'error';
        $respuesta['comentario'] = 'No se pudo completar el registro de los alumnos, contacte con soporte técnico';
      }
    } catch (\Exception $e) {
      $error = $e->getMessage();
      echo $error;
    }

    $stmt->close();
    die(json_encode($respuesta));
  }
  //Ejecuta actualización de Alumno
  if ($data['cmd'] == 'alumno-actualizar') {
    $id_usuario = $data['user_id'];
    $id_alumno = $data['alum_id'];
    unset($data['cmd']);
    unset($data['user_id']);
    unset($data['alum_id']);
    unset($data['alumGrd']);
    $stmt = $conn->prepare("SELECT * FROM siscpi_alumnos WHERE id=?");
    $stmt->bind_param("i", $id_alumno);
    $stmt->execute();
    $result = $stmt->get_result();
    $datos2 = $result->fetch_assoc();
    $datos = json_decode($datos2['datos'], true);
    $data_nueva = array();
    $data_nueva['fec_mat'] = $datos['fec_mat'];
    $data_nueva['alu_fol'] = $datos['alu_fol'];
    foreach ($data as $key => $value) {
      if ($data[$key]['tipo'] == 'solotexto') {
        $nuevo_valor = strtoupper(preg_replace('([^A-Za-zÑñáéíóúüÁÉÍÓÚÜ () ])', '', $data[$key]['value']));
        $data_nueva[$key] = $nuevo_valor;
      } elseif ($data[$key]['tipo'] == 'solonumero') {
        $nuevo_valor = preg_replace('([^0-9. ])', '', $data[$key]['value']);
        $data_nueva[$key] = $nuevo_valor;
      } elseif ($data[$key]['tipo'] == 'textoynumero') {
        $nuevo_valor = strtoupper(preg_replace('([^A-Za-zZÑñáéíóúüÁÉÍÓÚÜ0-9 ])', '', $data[$key]['value']));
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
      $stmt = $conn->prepare("UPDATE siscpi_alumnos SET datos=?, usuario=?, editado= NOW() WHERE id=?");
      $stmt->bind_param("sss", $datos_finales, $id_usuario, $id_alumno);
      $stmt->execute();
      if ($stmt->affected_rows) {
        $respuesta['respuesta'] = 'exito';
        $respuesta['comentario'] = 'Alumno actualizado correctamente';
        $respuesta['idObtenido'] = $id_alumno;
        $respuesta['idUser'] = $id_usuario;
      } else {
        $respuesta['respuesta'] = 'error';
        $respuesta['comentario'] = 'El alumno no pudo ser actualizado';
      };
    } catch (Exception $e) {
      echo "FALLO LA CONSULTA:" . $e->getMessage();
    }
    $stmt->close();
    die(json_encode($respuesta));
  }

  //Ejecuta actualización de seccion de un Alumno
  if ($data['cmd'] == 'seccion-nueva') {
    $id_usuario = $data['user_id'];
    $id_alumno = $data['idAlum'];
    $new_secc = $data['newSecc'];
    unset($data['cmd']);
    unset($data['userId']);
    unset($data['idAlum']);

    $stmt = $conn->prepare("SELECT * FROM siscpi_alumnos WHERE id=?");
    $stmt->bind_param("i", $id_alumno);
    $stmt->execute();
    $result = $stmt->get_result();
    $datos2 = $result->fetch_assoc();
    $datos = json_decode($datos2['datos'], true);

    try {

      $datos['gra_sec'] = $new_secc;

      $temp_new = json_encode($datos);


      $stmt = $conn->prepare("UPDATE siscpi_alumnos SET datos=?, editado= NOW() WHERE id =?");
      $stmt->bind_param("si", $temp_new, $id_alumno);
      $stmt->execute();
      if ($stmt->affected_rows) {
        $respuesta['respuesta'] = 'exito';
        $respuesta['comentario'] = 'Sección actualizada correctamente';
        $respuesta['idObtenido'] = $id_alumno;
        $respuesta['idUser'] = $id_usuario;
      } else {
        $respuesta['respuesta'] = 'error';
        $respuesta['comentario'] = 'La Sección, no pudo ser actualizada';
      };
    } catch (Exception $e) {
      echo "FALLO LA CONSULTA:" . $e->getMessage();
    }
    $stmt->close();
    die(json_encode($respuesta));
  }

  //Ejecuta actualización de Status de un Alumno
  if ($data['cmd'] == 'nuevo-estatus') {
    $id_usuario = $data['user_id'];
    $id_alumno = $data['idAlum'];
    $new_stat = $data['newStatus'];
    unset($data['cmd']);
    unset($data['userId']);
    unset($data['idAlum']);

    $stmt = $conn->prepare("SELECT * FROM siscpi_alumnos WHERE id=?");
    $stmt->bind_param("i", $id_alumno);
    $stmt->execute();
    $result = $stmt->get_result();
    $datos2 = $result->fetch_assoc();
    $datos = json_decode($datos2['datos'], true);

    try {

      $datos['estatus'] = $new_stat === 'Matricular' ? 'MATRICULADO' : 'RETIRADO';

      $temp_new = json_encode($datos);


      $stmt = $conn->prepare("UPDATE siscpi_alumnos SET datos=?, editado= NOW() WHERE id =?");
      $stmt->bind_param("si", $temp_new, $id_alumno);
      $stmt->execute();
      if ($stmt->affected_rows) {
        $respuesta['respuesta'] = 'exito';
        $respuesta['comentario'] = 'Estatus actualizado correctamente';
        $respuesta['idObtenido'] = $id_alumno;
        $respuesta['idUser'] = $id_usuario;
      } else {
        $respuesta['respuesta'] = 'error';
        $respuesta['comentario'] = 'El Estatus, no pudo ser actualizado';
      };
    } catch (Exception $e) {
      echo "FALLO LA CONSULTA:" . $e->getMessage();
    }
    $stmt->close();
    die(json_encode($respuesta));
  }

  //Ejecuta la eliminacion de un Alumno
  if ($data['cmd'] == 'eliminar-alum') {
    $id_usuario = $data['user_id'];
    $id_alumno = $data['idAlum'];
    unset($data['cmd']);
    unset($data['userId']);
    unset($data['idAlum']);

    try {

      $stmt = $conn->prepare("DELETE FROM siscpi_alumnos WHERE id=?");
      $stmt->bind_param("i", $id_alumno);
      $stmt->execute();

      if ($stmt->affected_rows) {
        $respuesta['respuesta'] = 'exito';
        $respuesta['comentario'] = 'Alumno eliminado correctamente';
        $respuesta['idObtenido'] = $id_alumno;
        $respuesta['idUser'] = $id_usuario;
      } else {
        $respuesta['respuesta'] = 'error';
        $respuesta['comentario'] = 'El Alumno no pudo ser eliminado';
      };

    } catch (Exception $e) {
      echo "FALLO LA CONSULTA:" . $e->getMessage();
    }
    $stmt->close();
    die(json_encode($respuesta));
  }


  //Consulta Informe del Alumno
  if ($data['cmd'] == 'informe-consulta') {

    try {
      $id_alumno = preg_replace('([^0-9])', '', $data['id']);
      $per = filter_var($data['per'], FILTER_VALIDATE_INT);

      $stmt = $conn->prepare("SELECT * FROM siscpi_alumnos WHERE id=?");
      $stmt->bind_param("i", $id_alumno);
      $stmt->execute();
      $result = $stmt->get_result();
      $datos = $result->fetch_assoc();

      if ($result->num_rows > 0) {

        $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
        $stmt->bind_param("i", $id_alumno);
        $stmt->execute();
        $notas_resultado = $stmt->get_result();
        $notas_detalle = $notas_resultado->fetch_assoc();

        if ($notas_resultado->num_rows > 0) {
          $notas = json_decode($notas_detalle['datos'], true);
          $notas_actuales = json_encode($notas['p-' . $per]);

          $datos_alumno = [
            $id_alumno => ['mat' => $datos['datos'], 'not' => $notas_actuales]
          ];

          $respuesta = array(
            'respuesta' => 'exito',
            'dat_alum' => json_encode($datos_alumno)
          );
        } else {

          $notas_vacias = [];

          $datos_alumno = [
            $id_alumno => ['mat' => $datos['datos'], 'not' => $notas_vacias]
          ];

          $respuesta = array(
            'respuesta' => 'exito',
            'dat_alum' => json_encode($datos_alumno)
          );
        }
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

  //Consulta Informe Final del Alumno
  if ($data['cmd'] == 'informe-consulta5') {

    try {
      $id_alumno = preg_replace('([^0-9])', '', $data['id']);
      $per = filter_var($data['per'], FILTER_VALIDATE_INT);

      $stmt = $conn->prepare("SELECT * FROM siscpi_alumnos WHERE id=?");
      $stmt->bind_param("i", $id_alumno);
      $stmt->execute();
      $result = $stmt->get_result();
      $datos = $result->fetch_assoc();

      if ($result->num_rows > 0) {

        $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
        $stmt->bind_param("i", $id_alumno);
        $stmt->execute();
        $notas_resultado = $stmt->get_result();
        $notas_detalle = $notas_resultado->fetch_assoc();

        if ($notas_resultado->num_rows > 0) {
          $notas = json_decode($notas_detalle['datos'], true);
          $notas_actuales = $notas;

          $datos_alumno = [
            $id_alumno => ['mat' => $datos['datos'], 'not' => json_encode($notas_actuales)]
          ];

          $respuesta = array(
            'respuesta' => 'exito',
            'dat_alum' => json_encode($datos_alumno)
          );
        } else {

          $notas_vacias = [];

          $datos_alumno = [
            $id_alumno => ['mat' => $datos['datos'], 'not' => $notas_vacias]
          ];

          $respuesta = array(
            'respuesta' => 'exito',
            'dat_alum' => json_encode($datos_alumno)
          );
        }
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
} else {
  die(json_encode(array('respuesta' => "error", 'comentario' => "REQUEST_METHOD no permitido")));
}
