<?php
if($_SERVER["REQUEST_METHOD"] === "POST")
{
  if(isset($_POST['login-user'])){
    $usuario = preg_replace('([^0-9.])', '', $data['nickname']);
    $password = preg_replace('([^0-9.])', '', $data['password']);

    include_once '../funciones/funciones.php';
        try {
          $stmt = $conn->prepare("SELECT * FROM siscpi_logins WHERE logins_nickname=?");
          $stmt->bind_param("s", $usuario);
          $stmt->execute();
          $resultado = $stmt->get_result();
            if($resultado->num_rows >= "1"){
              $existe = $resultado->fetch_assoc();
              $status = $existe['logins_status'];
              $user_id = $existe['logins_id_login'];
              $nickname = $existe['logins_nickname'];
              $user_nombre = $existe['logins_nombre'];
              $user_nivel = $existe['logins_nivel'];
              $user_password = $existe['logins_password'];

              if ($status == 'BLOQUEADO') {
                $respuesta = array(
                  'respuesta' => 'bloqueado'
                );
              } else {
                  if ($user_nivel == 8) {
                    $stmt = $conn->prepare("SELECT * FROM siscpi_alumnos WHERE id_login=?");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $resultado2 = $stmt->get_result();
                    $datos = $resultado2->fetch_assoc();
                    $datos_alumno = json_decode($datos['datos'], true);

                    $alum_grado = $datos_alumno['gra_esc'];

                    $stmt = $conn->prepare("SELECT * FROM siscpi_grados WHERE gdo_des_grado=?");
                    $stmt->bind_param("s", $alum_grado);
                    $stmt->execute();
                    $resultado3 = $stmt->get_result();
                    $datos2 = $resultado3->fetch_assoc();
                    $alum_grad_code = $datos2['gdo_cod_grado'];

                  } else {
                    $stmt = $conn->prepare("SELECT * FROM siscpi_users WHERE id_login=?");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $user_dat = $result->fetch_assoc();
                    $datos = json_decode($user_dat['datos'], true);
                    $datos_usuario = $datos;
                  }

                  if(password_verify($password, $user_password)){
                    $intentos = 0;
                    $stmt = $conn->prepare("UPDATE siscpi_logins SET logins_intentos=?, logins_editado= NOW() WHERE logins_nickname =?");
                    $stmt->bind_param("is", $intentos, $usuario);
                    $stmt->execute();
                    if ($user_nivel == 8) {
                      session_start();
                      $_SESSION['usuario'] = $nickname;
                      $_SESSION['nombre'] = $user_nombre;
                      $_SESSION['nivel'] = $user_nivel;
                      $_SESSION['logid'] = $user_id;
                      $_SESSION['datos'] = $datos_alumno;
                    } else {
                      session_start();
                      $_SESSION['usuario'] = $nickname;
                      $_SESSION['nombre'] = $user_nombre;
                      $_SESSION['nivel'] = $user_nivel;
                      $_SESSION['logid'] = $user_id;
                      $_SESSION['datos'] = $datos_usuario;
                    }
                    $respuesta = array(
                      'respuesta' => 'aprobado',
                      'usuario' => $user_nombre,
                      'nivel' => $user_nivel
                    );
                  } else {
                    try {
                      $stmt = $conn->prepare("SELECT logins_intentos FROM siscpi_logins WHERE logins_nickname=?");
                      $stmt->bind_param("s", $usuario);
                      $stmt->execute();
                      $resultado = $stmt->get_result();
                      $existe = $resultado->fetch_assoc();
                      $intentos = $existe['logins_intentos'];
                      $intentos2 = $intentos + 1;
                      $stmt = $conn->prepare("UPDATE siscpi_logins SET logins_intentos=?, logins_editado= NOW() WHERE logins_nickname =?");
                      $stmt->bind_param("is", $intentos2, $usuario);
                      $stmt->execute();
                      $stmt = $conn->prepare("SELECT logins_intentos FROM siscpi_logins WHERE logins_nickname=?");
                      $stmt->bind_param("s", $usuario);
                      $stmt->execute();
                      $resultado = $stmt->get_result();
                      $existe = $resultado->fetch_assoc();
                      $intentos = $existe['logins_intentos'];
                      if ($intentos >= 10) {
                        $status = 'BLOQUEADO';
                        $stmt = $conn->prepare("UPDATE siscpi_logins SET logins_status=?, logins_editado= NOW() WHERE logins_nickname =?");
                        $stmt->bind_param("ss", $status, $usuario);
                        $stmt->execute();
                        $respuesta = array(
                          'respuesta' => 'bloqueado',
                        );
                      } else {
                        $respuesta = array(
                          'respuesta' => 'advertencia',
                        );
                      }
                    } catch (Exception $e) {
                      echo "Error:" . $e->getMessage();
                      }
                  }
              }
            } else {
              $respuesta = array(
                'respuesta' => 'nouser'
              );
            }
          $stmt->close();
          $conn->close();
        } catch (Exception $e) {
            echo "Error:" . $e->getMessage();
        }
  } else {
      $respuesta = array(
      'respuesta' => 'error'
      );
    }
    die(json_encode($respuesta));
}
  //::::::::::::::LOGIN:::::::::::::::::::::::::::::://
?>
