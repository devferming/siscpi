<?php

if($_SERVER["REQUEST_METHOD"] === "POST")
{

  include_once 'funciones/funciones.php';

  date_default_timezone_set('America/Bogota');

  $hoy = date("Y-m-d H:i:s");

  //::::::::::::::CREAR USUARIO:::::::::::::::://
  if($_POST['user'] == 'nuevo'){

    $user_ide_tip = filter_var($_POST['user_ide_tip'], FILTER_SANITIZE_STRING);
    $user_ide_num = filter_var($_POST['user_ide_num'], FILTER_SANITIZE_STRING);
    $user_per_ape = mb_strtoupper(filter_var($_POST['user_per_ape'], FILTER_SANITIZE_STRING),'utf-8');
    $user_sdo_ape = mb_strtoupper(filter_var($_POST['user_sdo_ape'], FILTER_SANITIZE_STRING),'utf-8');
    $user_per_nom = mb_strtoupper(filter_var($_POST['user_per_nom'], FILTER_SANITIZE_STRING),'utf-8');
    $user_sdo_nom = mb_strtoupper(filter_var($_POST['user_sdo_nom'], FILTER_SANITIZE_STRING),'utf-8');
    $user_gen = filter_var($_POST['user_gen'], FILTER_SANITIZE_STRING);
    $user_nac_fec2 = filter_var($_POST['user_nac_fec'], FILTER_SANITIZE_STRING);
    $user_nac_fec = DateTime::createFromFormat('d/m/Y', $user_nac_fec2)->format('Y-m-d'); 

    $user_nac_lug = mb_strtoupper(filter_var($_POST['user_nac_lug'], FILTER_SANITIZE_STRING),'utf-8');
    $user_nac_dep = mb_strtoupper(filter_var($_POST['user_nac_dep'], FILTER_SANITIZE_STRING),'utf-8');
    $user_dir_dir = mb_strtoupper(filter_var($_POST['user_dir_dir'], FILTER_SANITIZE_STRING),'utf-8');
    $user_dir_mun = mb_strtoupper(filter_var($_POST['user_dir_mun'], FILTER_SANITIZE_STRING),'utf-8');
    $user_dir_bar = mb_strtoupper(filter_var($_POST['user_dir_bar'], FILTER_SANITIZE_STRING),'utf-8');
    $user_tel_mov = filter_var($_POST['user_tel_mov'], FILTER_SANITIZE_STRING);
    $user_tel_loc = filter_var($_POST['user_tel_loc'], FILTER_SANITIZE_STRING);
    $user_mai = filter_var($_POST['user_mai'], FILTER_SANITIZE_STRING);
    $user_ipj = filter_var($_POST['ipj'], FILTER_SANITIZE_STRING);
    $user_ij = filter_var($_POST['ij'], FILTER_SANITIZE_STRING);
    $user_itrans = filter_var($_POST['itrans'], FILTER_SANITIZE_STRING);
    $user_iprimero = filter_var($_POST['iprimero'], FILTER_SANITIZE_STRING);
    $user_isegundo = filter_var($_POST['isegundo'], FILTER_SANITIZE_STRING);
    $user_itercero = filter_var($_POST['itercero'], FILTER_SANITIZE_STRING);
    $user_icuarto = filter_var($_POST['icuarto'], FILTER_SANITIZE_STRING);
    $user_iquinto = filter_var($_POST['iquinto'], FILTER_SANITIZE_STRING);
    $user_isexto = filter_var($_POST['isexto'], FILTER_SANITIZE_STRING);
    $user_iseptimo = filter_var($_POST['iseptimo'], FILTER_SANITIZE_STRING);
    $user_ioctavo = filter_var($_POST['ioctavo'], FILTER_SANITIZE_STRING);
    $user_inoveno = filter_var($_POST['inoveno'], FILTER_SANITIZE_STRING);
    $user_idecimo = filter_var($_POST['idecimo'], FILTER_SANITIZE_STRING);
    $user_iundecimo = filter_var($_POST['iundecimo'], FILTER_SANITIZE_STRING);

    $user_rol = filter_var($_POST['user_rol'], FILTER_SANITIZE_STRING);
    $user_materia = filter_var($_POST['user_materia'], FILTER_SANITIZE_STRING);
    $user_dgrupo = filter_var($_POST['user_dgrupo'], FILTER_SANITIZE_STRING);
    $user_dgrupo_seccion = filter_var($_POST['user_dgrupo_seccion'], FILTER_SANITIZE_STRING);
    $usuario = strtolower(filter_var($_POST['user_user'], FILTER_SANITIZE_STRING));
    $password = filter_var($_POST['user_password'], FILTER_SANITIZE_STRING);

    $acceso = filter_var($_POST['nivel'], FILTER_SANITIZE_STRING);

    $nombre = $user_per_nom . " " . $user_per_ape;
    $intentos = 0;
    $status = 'ACTIVO';

    


    try {

        $opciones = [
          'cost' => 12,
        ];

      $password_hashed = password_hash($password, PASSWORD_BCRYPT, $opciones). "/n";


      $stmt = $conn->prepare("INSERT INTO logins (logins_nickname, logins_nombre, logins_password, logins_nivel, logins_intentos, logins_status, logins_editado) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("sssiiss", $usuario, $nombre, $password_hashed, $acceso, $intentos, $status, $hoy);
      $stmt->execute();



      $id_registro = $stmt->insert_id;

      if($id_registro > 0){

        try {

          $stmt = $conn->prepare("INSERT INTO usuarios (users_doc_tipo, users_doc_numero, users_1er_apellido, users_2do_apellido, users_1er_nombre, users_2do_nombre, users_genero, users_nac_fecha, users_nac_lugar, users_departamento, users_municipio, users_barrio, users_direccion, users_telf_movil, users_telf_local, users_mail, users_rol, users_asignatura, users_dgrupo, users_dgrupo_seccion, users_id_logins, users_pj, users_j, users_t, users_1ro, users_2do, users_3ro, users_4to, users_5to, users_6to, users_7mo, users_8vo, users_9no, users_10mo, users_11mo, user_editado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
          $stmt->bind_param("ssssssssssssssssssssssssssssssssssss", $user_ide_tip, $user_ide_num, $user_per_ape, $user_sdo_ape, $user_per_nom, $user_sdo_nom, $user_gen, $user_nac_fec, $user_nac_lug, $user_nac_dep, $user_dir_mun, $user_dir_bar, $user_dir_dir, $user_tel_mov, $user_tel_loc, $user_mai, $user_rol, $user_materia, $user_dgrupo, $user_dgrupo_seccion, $id_registro, $user_ipj, $user_ij, $user_itrans, $user_iprimero, $user_isegundo, $user_itercero, $user_icuarto, $user_iquinto, $user_isexto, $user_iseptimo, $user_ioctavo, $user_inoveno, $user_idecimo, $user_iundecimo, $hoy);
          $stmt->execute();

          $id_registro2 = $stmt->insert_id;
          
          
          if($id_registro2 > 0){
          
              $respuesta = array(
                  'respuesta' => 'exito',
                  'id_usuario' => $id_registro2
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

      $stmt->close();
      $conn->close();

    } catch (Exception $e) {
      echo "Error:" . $e->getMessage();
    }

    die(json_encode($respuesta));

  } 

  //::::::::::::::ACTUALIZAR USUARIO:::::::::::::::://
  if($_POST['user'] == 'actualizar'){

    $user_ide_tip = filter_var($_POST['user_ide_tip'], FILTER_SANITIZE_STRING);
    $user_ide_num = filter_var($_POST['user_ide_num'], FILTER_SANITIZE_STRING);
    $user_per_ape = mb_strtoupper(filter_var($_POST['user_per_ape'], FILTER_SANITIZE_STRING),'utf-8');
    $user_sdo_ape = mb_strtoupper(filter_var($_POST['user_sdo_ape'], FILTER_SANITIZE_STRING),'utf-8');
    $user_per_nom = mb_strtoupper(filter_var($_POST['user_per_nom'], FILTER_SANITIZE_STRING),'utf-8');
    $user_sdo_nom = mb_strtoupper(filter_var($_POST['user_sdo_nom'], FILTER_SANITIZE_STRING),'utf-8');
    $user_gen = filter_var($_POST['user_gen'], FILTER_SANITIZE_STRING);
    $user_nac_fec2 = filter_var($_POST['user_nac_fec'], FILTER_SANITIZE_STRING);
    $user_nac_fec = DateTime::createFromFormat('d/m/Y', $user_nac_fec2)->format('Y-m-d'); 

    $user_nac_lug = mb_strtoupper(filter_var($_POST['user_nac_lug'], FILTER_SANITIZE_STRING),'utf-8');
    $user_nac_dep = mb_strtoupper(filter_var($_POST['user_nac_dep'], FILTER_SANITIZE_STRING),'utf-8');
    $user_dir_dir = mb_strtoupper(filter_var($_POST['user_dir_dir'], FILTER_SANITIZE_STRING),'utf-8');
    $user_dir_mun = mb_strtoupper(filter_var($_POST['user_dir_mun'], FILTER_SANITIZE_STRING),'utf-8');
    $user_dir_bar = mb_strtoupper(filter_var($_POST['user_dir_bar'], FILTER_SANITIZE_STRING),'utf-8');
    $user_tel_mov = filter_var($_POST['user_tel_mov'], FILTER_SANITIZE_STRING);
    $user_tel_loc = filter_var($_POST['user_tel_loc'], FILTER_SANITIZE_STRING);
    $user_mai = filter_var($_POST['user_mai'], FILTER_SANITIZE_STRING);
    $user_ipj = filter_var($_POST['ipj'], FILTER_SANITIZE_STRING);
    $user_ij = filter_var($_POST['ij'], FILTER_SANITIZE_STRING);
    $user_itrans = filter_var($_POST['itrans'], FILTER_SANITIZE_STRING);
    $user_iprimero = filter_var($_POST['iprimero'], FILTER_SANITIZE_STRING);
    $user_isegundo = filter_var($_POST['isegundo'], FILTER_SANITIZE_STRING);
    $user_itercero = filter_var($_POST['itercero'], FILTER_SANITIZE_STRING);
    $user_icuarto = filter_var($_POST['icuarto'], FILTER_SANITIZE_STRING);
    $user_iquinto = filter_var($_POST['iquinto'], FILTER_SANITIZE_STRING);
    $user_isexto = filter_var($_POST['isexto'], FILTER_SANITIZE_STRING);
    $user_iseptimo = filter_var($_POST['iseptimo'], FILTER_SANITIZE_STRING);
    $user_ioctavo = filter_var($_POST['ioctavo'], FILTER_SANITIZE_STRING);
    $user_inoveno = filter_var($_POST['inoveno'], FILTER_SANITIZE_STRING);
    $user_idecimo = filter_var($_POST['idecimo'], FILTER_SANITIZE_STRING);
    $user_iundecimo = filter_var($_POST['iundecimo'], FILTER_SANITIZE_STRING);

    $user_rol = filter_var($_POST['user_rol'], FILTER_SANITIZE_STRING);
    $user_materia = filter_var($_POST['user_materia'], FILTER_SANITIZE_STRING);
    $user_dgrupo = filter_var($_POST['user_dgrupo'], FILTER_SANITIZE_STRING);
    $user_dgrupo_seccion = filter_var($_POST['user_dgrupo_seccion'], FILTER_SANITIZE_STRING);
    $usuario = strtolower(filter_var($_POST['user_user'], FILTER_SANITIZE_STRING));
    //$password = filter_var($_POST['user_password'], FILTER_SANITIZE_STRING);

    $acceso = filter_var($_POST['nivel'], FILTER_VALIDATE_INT);
    $id_logins = filter_var($_POST['id_logins'], FILTER_VALIDATE_INT);


    $nombre = $user_per_nom . " " . $user_per_ape;
    $intentos = 0;
    $status = 'ACTIVO';


    try {


      $stmt = $conn->prepare("UPDATE logins SET logins_nickname=?, logins_nombre=?, logins_nivel=?, logins_intentos=?, logins_status=?, logins_editado= NOW() WHERE logins_id_login =?");
      $stmt->bind_param("ssiisi", $usuario, $nombre, $acceso, $intentos, $status, $id_logins);
      $stmt->execute();

      if($stmt->affected_rows){

        try {

          $stmt = $conn->prepare("UPDATE usuarios SET users_doc_tipo=?, users_doc_numero=?, users_1er_apellido=?, users_2do_apellido=?, users_1er_nombre=?, users_2do_nombre=?, users_genero=?, users_nac_fecha=?, users_nac_lugar=?, users_departamento=?, users_municipio=?, users_barrio=?, users_direccion=?, users_telf_movil=?, users_telf_local=?, users_mail=?, users_rol=?, users_asignatura=?, users_dgrupo=?, users_dgrupo_seccion=?, users_pj=?, users_j=?, users_t=?, users_1ro=?, users_2do=?, users_3ro=?, users_4to=?, users_5to=?, users_6to=?, users_7mo=?, users_8vo=?, users_9no=?, users_10mo=?, users_11mo=?, user_editado= NOW() WHERE users_id_logins=?");
          $stmt->bind_param("ssssssssssssssssssssssssssssssssssi", $user_ide_tip, $user_ide_num, $user_per_ape, $user_sdo_ape, $user_per_nom, $user_sdo_nom, $user_gen, $user_nac_fec, $user_nac_lug, $user_nac_dep, $user_dir_mun, $user_dir_bar, $user_dir_dir, $user_tel_mov, $user_tel_loc, $user_mai, $user_rol, $user_materia, $user_dgrupo, $user_dgrupo_seccion, $user_ipj, $user_ij, $user_itrans, $user_iprimero, $user_isegundo, $user_itercero, $user_icuarto, $user_iquinto, $user_isexto, $user_iseptimo, $user_ioctavo, $user_inoveno, $user_idecimo, $user_iundecimo, $id_logins);
          $stmt->execute();

          if($stmt->affected_rows){
          
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

      $stmt->close();
      $conn->close();

    } catch (Exception $e) {
      echo "Error:" . $e->getMessage();
    }

    die(json_encode($respuesta));

  } 

  //::::::::::::::CONSULTA LOGIN USUARIO:::::::::::::::://
  if($_POST['user'] == 'login'){

    $id_logins = filter_var($_POST['id_user'], FILTER_VALIDATE_INT);

    try {

      $stmt = $conn->prepare("SELECT * FROM logins WHERE logins_id_login=?");
      $stmt->bind_param("i", $id_logins);
      $stmt->execute();
      $resultado = $stmt->get_result();
      $fila = $resultado->fetch_assoc();

      if($resultado->num_rows >= "1"){

      $respuesta = array(
      'id' => $fila['logins_id_login'],
      'nombre' => $fila['logins_nombre'],
      'nickname' => $fila['logins_nickname']
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

  //::::::::::::::ACTUALIZAR LOGIN USUARIO:::::::::::::::://
  if($_POST['user'] == 'login_act'){

    $id_logins = filter_var($_POST['id_login_l'], FILTER_VALIDATE_INT);
    $user_name = filter_var($_POST['user_nombre_l'], FILTER_SANITIZE_STRING);
    $user_nick= strtolower(filter_var($_POST['user_nick_l'], FILTER_SANITIZE_STRING));
    $user_pass = filter_var($_POST['user_password_l'], FILTER_SANITIZE_STRING);

    try {

      $opciones = [
        'cost' => 12,
      ];

    $password_hashed = password_hash($user_pass, PASSWORD_BCRYPT, $opciones). "/n";


    $stmt = $conn->prepare("UPDATE logins SET logins_nickname=?, logins_nombre=?, logins_password=?, logins_editado= NOW() WHERE logins_id_login =?");
    $stmt->bind_param("sssi", $user_nick, $user_name, $password_hashed, $id_logins);
    $stmt->execute();

    if($stmt->affected_rows){

      $respuesta = array(
        'respuesta' => 'exito',
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




  //:::::::::::ACTUALIZAR ADMINISTRADOR:::::::::::::://
  /*if($_POST['registro'] == 'actualizar'){

    $usuario = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $acceso = $_POST['nivel'];
    $password = $_POST['password'];

    $id_registro = $_POST['id_registro'];

    try {

      if (empty($_POST['password'])) {
        $stmt = $conn->prepare("UPDATE admins SET usuario = ?, nombre = ?, editado = NOW(), nivel = ? WHERE id_admin = ?");
        $stmt->bind_param("ssii", $usuario, $nombre, $acceso, $id_registro);
      } else {

        $opciones = array(
            'cost' => 12
        );

        $password_hashed = password_hash($password, PASSWORD_BCRYPT, $opciones);


        $stmt = $conn->prepare("UPDATE admins SET usuario = ?, nombre = ?, password = ?, editado = NOW(), nivel = ? WHERE id_admin = ?");
        $stmt->bind_param("sssii", $usuario, $nombre, $password_hashed, $acceso, $id_registro);

      };

      $stmt->execute();

      if ($stmt->affected_rows) {
        $respuesta = array(
          'respuesta' => 'exito',
          'id_actualizado' => $stmt->insert_id
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

  //:::::::::::ELIMINAR ADMINISTRADOR:::::::::::::://
  if($_POST['registro'] == 'eliminar'){
    $id_borrar = $_POST['id'];

    try {
      $stmt = $conn->prepare("DELETE FROM admins WHERE id_admin = ?");
      $stmt->bind_param("i", $id_borrar);
      $stmt->execute();

      if ($stmt->affected_rows) {
        $respuesta = array(
          'respuesta' => 'exito',
          'id_eliminado' => $id_borrar
        );
      } else {
        $respuesta = array(
          'respuesta' => 'error'
        );
      }

    } catch (Exception $e) {
      echo "Error:" . $e->getMessage();
    }

    die(json_encode($respuesta));

  }*/
}
