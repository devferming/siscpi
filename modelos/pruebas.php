<?php
include_once '../funciones/funciones.php';
date_default_timezone_set('America/Bogota');
$hoy = date("Y-m-d H:i:s");
$argumento = 'PRIMERO';


try {

  $mat = "NATURALES";
  $per = "1";
  $gra = "3";
  $apn = "1";
  $key = "po-bio&ap-1";
  $api = "1";
  $id_usuario = "6";

  $stmt = $conn->prepare("SELECT * FROM siscpi_materias WHERE mat_des_materia=?");
  $stmt->bind_param('s', $mat);
  $stmt->execute();
  $malla_result = $stmt->get_result();
  $row_malla = $malla_result->fetch_assoc();

    $malla_actual = json_decode($row_malla['mat_malla'], true);
    $malla_up = $malla_actual;
    $malla_up["p-".$per]["g-".$gra]["a-".$apn]["key"] = $key.'&'.$api; //AQUI!

    echo '<pre>';
      print_r($row_malla);
    echo '<pre>';

    /*
    try {
      $stmt = $conn->prepare("UPDATE siscpi_materias SET mat_malla=?, mat_editado=? WHERE mat_des_materia=?");
      $stmt->bind_param('sss', json_encode($malla_up), $hoy, $mat);
      $stmt->execute();

      if ($stmt->affected_rows) {
        $respuesta = [
          'respuesta' => 'exito',
          'comentario' => '¡Malla actualizada! Aprendizaje registrado con exito',
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
    */


  /*

  try {
    $stmt = $conn->prepare("UPDATE siscpi_materias SET mat_malla=?, mat_editado=? WHERE mat_des_materia=?");
    $stmt->bind_param('sss', json_encode($malla_up), $hoy, $mat);
    $stmt->execute();

    if ($stmt->affected_rows) {
      $respuesta = [
        'respuesta' => 'exito',
        'comentario' => '¡Malla actualizada! Aprendizaje registrado con exito',
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

  /*

  $objeto = '{"p-1" : {"g-3" : {"ap-1" : "Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro vel fuga odio praesentium magni dolores, odit corrupti quo sed minus quaerat ratione repellendus distinctio velit enim consequuntur nulla, rem soluta.","ap-2" : "Lorem2 ipsum dolor sit amet consectetur adipisicing elit. Porro vel fuga odio praesentium magni dolores, odit corrupti quo sed minus quaerat ratione repellendus distinctio velit enim consequuntur nulla, rem soluta.","ap-3" : "Lorem3 ipsum dolor sit amet consectetur adipisicing elit. Porro vel fuga odio praesentium magni dolores, odit corrupti quo sed minus quaerat ratione repellendus distinctio velit enim consequuntur nulla, rem soluta."} } }';

  $data_nueva2 = json_decode($objeto);
  $data_nueva = json_encode($data_nueva2);
  $mat = "NATURALES";

  $stmt = $conn->prepare("UPDATE siscpi_materias SET mat_aprendizajes=? WHERE mat_des_materia=?");
  $stmt->bind_param('ss', $data_nueva, $mat);
  $stmt->execute();

  

  $textoJSON = json_encode(array(
    "Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid nesciunt quas, hic inventore et eius? Error voluptas tenetur, architecto excepturi odit rerum! Aliquid natus recusandae tenetur eum! Consequatur, laboriosam? Laudantium.",
    "Cuando la aldea de la hoja danza el fuego quema, y la sombra del fuego iluminará la aldea"
  ));

  $mat = 'NATURALES';
  $gra = 'TERCERO';
  $id = 6;


  $stmt = $conn->prepare("INSERT INTO siscpi_aprendizajes (materia, grado, datos, usuario, editado) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $mat, $gra, $textoJSON, $id, $hoy);
  $stmt->execute();



  /*
  $id_usuario = 18;

  $ida = 18;
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

  $list_alum = array();


  try {
    $stmt = $conn->prepare("SELECT * FROM siscpi_users WHERE id_login=?");
    $stmt->bind_param("i", $ida);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $datos_user = json_decode($row['datos'], true);
    //$materia = 

    if ($result->num_rows > 0) {

      try {
        $stmt_alumnos = $conn->prepare("SELECT * FROM siscpi_alumnos");
        $stmt_alumnos->execute();
        $result_alumnos = $stmt_alumnos->get_result();
        $alumnos = array();
        while ($row_alumnos = $result_alumnos->fetch_assoc()) {

        $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
        $stmt->bind_param("i", $row_alumnos['id']);
        $stmt->execute();
        $notas_resultado = $stmt->get_result();
        $notas_row = $notas_resultado->fetch_assoc();
        
        
        $alumnos[$row_alumnos['id']['datos']] = json_decode($row_alumnos['datos'], true);
        $alumnos[$row_alumnos['id']['notas']] = json_decode($notas_resultado['datos'], true);
        

        $alumnos[$row_alumnos['id']] = array('datos' => json_decode($row_alumnos['datos'], true), 'notas' => json_decode($notas_row['datos'], true));
          
        }
      } catch (\Exception $e) {
        $error = $e->getMessage();
        echo $error;
      }

      if ($result_alumnos->num_rows > 0) {

        foreach ($datos_user['pro_mat'] as $materia) {

          $list_alum['mat'] = $materia;

          if (isset($codigos[$materia])) {
            $codMat = $codigos[$materia];

            for ($i = 1; $i < 15; $i++) {
  
              if (isset($datos_user['on' . $codMat . $i]) ? $datos_user['on' . $codMat . $i] : 0 == 1) {
                
                if (isset(GRADOS[$i])) {
                  [$gra, $sec, $log] = GRADOS[$i];

                  echo '<pre>';
                  print_r($list_alum);
                  echo '</pre>';
        

                  echo $list_alum['mat'][$materia].'<br>';
                  echo $materia;

                  $stmt_materias = $conn->prepare("SELECT * FROM siscpi_materias WHERE mat_des_materia=?");
                  $stmt_materias->bind_param("s", $materia);
                  $stmt_materias->execute();
                  $result_materias = $stmt_materias->get_result();
                  $row_materias = $result_materias->fetch_assoc();
                
                  $log = $row_materias[$log . $per]; // Cantidad de logros para la materia

                  //echo ':::::::::::::::::::::::::::::::::::::::::::::::::::Notas en grado '.$i.':::::::::::::::::::::::::::::::::::::::::::::::<br>';
                  
                  foreach ($alumnos as $id_alum => $dat_alum) {
                    //$acumulada = 0;
    
                    if ($dat_alum['datos']['gra_esc'] == $gra) {

                      $acumulada = 0;
                      $fn = '';
                      
                      $nom_alum = $dat_alum['datos']['per_ape'] . " " . $dat_alum['datos']['sdo_ape'] . " " . $dat_alum['datos']['per_nom'] . " " . $dat_alum['datos']['sdo_nom'];

                      //echo $nom_alum.'<br>';

                      $list_alum['mat'][$materia]['grd'][$gra][$id_alum] = ['nom' => $nom_alum];
                      
                      
                      if (isset($dat_alum['notas']['p-'.$per]['m-'.$materia])) {

                        $notas = $dat_alum['notas']['p-'.$per]['m-'.$materia];
                      
                        for ($l = 1; $l <= $log; $l++) {
                          //echo 'Logro: '.$l.'<br>';
                          $name = 'logro'.$l;
                          
                          if (isset($notas['l-'.$l])) {

                            $$name  = 0;

                            
                            for ($j = 1; $j <= 5; $j++) {
                              $nota_key = 'ev' . $j;

                              $nota = isset($notas['l-' . $l][$nota_key]) ? $notas['l-' . $l][$nota_key] : null;
      
                              switch ($nota) {
                                case '':
                                case null:
                                  ${"nota_ev" . $j} = 0;
                                  break;
                                default:
                                  ${"nota_ev" . $j} = $nota;
                                  break;
                              }
                              //echo 'lg'.$l.'-ev'.$j.': '.$nota.'<br>';

                            }
                            
  
                          } else {
                            $$name  = 0;
                          }
      
                          
                          $def70 = (($nota_ev1 + $nota_ev2 + $nota_ev3) / 3) * 0.7;
                          $def20 = $nota_ev4 * 0.2;
                          $def10 = $nota_ev5 * 0.1;
      
                          $def70 = number_format($def70, 1, '.', '');
                          $def20 = number_format($def20, 1, '.', '');
                          $def10 = number_format($def10, 1, '.', '');
      
                          $def2 = number_format($def70 + $def20 + $def10, 1, '.', '');
      
                          $$name  = $def2;
                          
                          
                          echo 'def 70: '.$def70.'<br>';
                          echo 'def 20: '.$def20.'<br>';
                          echo 'def 10: '.$def10.'<br>';
                          echo 'defintiva : '.$$name.'<br>';
                          

                          isset(RENDIMIENTOS[$sec]) ? [$rendimiento, $bandera, $cualitativo] = RENDIMIENTOS[$sec][$def2] : 0;

                          //echo 'Desempeño: '.$rendimiento.'<br>';

                          $list_alum[$materia][$gra][$id_alum] = ['PROPÓSITO'.$l => ['ev1' => $nota_ev1, 'ev2' => $nota_ev2, 'ev3' => $nota_ev3, 'ev4' => $nota_ev4, 'ev5' => $nota_ev5, 'd70' => $def70, 'd20' => $def20, 'd10' => $def10, 'def' => $def2, 'des' => $rendimiento]];
                        }
  
                      }
                      
                    }
  
                  } 
  
                }

              }

            }
  
          }
  
        }

  
      }
  
      
      $notas = json_decode($notas_detalle['datos'], true);
      $notas_actuales = $notas['p-'.$per];
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

  //die(json_encode($respuesta));
  */

  /* 

  $sql = "SELECT * FROM siscpi_cualitativas";
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
    // Recorrer todas las filas
    while ($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $datos = json_decode($row['datos'], true );

      $datosArray = $datos['TERCERO'];
      $datos['CUARTO'] = $datosArray;
      $datosActualizados = json_encode($datos, JSON_UNESCAPED_UNICODE);

      $sqlUpdate = "UPDATE siscpi_cualitativas SET datos = '$datosActualizados' WHERE id = $id";

      if ($conn->query($sqlUpdate) === TRUE) {
        echo "Los datos han sido actualizados correctamente para la fila con ID: $id<br>";
      } else {
        echo "Error al actualizar los datos para la fila con ID: $id - " . $conn->error . "<br>";
      }
      

    }
  } else {
    echo "No se encontraron resultados.";
  }
  */
  


  /*
  if ($result2->num_rows > 0) {

    $id_usuario = 8;
  
        $materias = array();
        $datos_bd_tra = array();
        $datos_bd_pri = array();
        $datos_bd_sec = array();
        $grados_tra = array("PRE JARDÍN", "JARDÍN", "TRANSICIÓN");
        $grados_pri = array("PRIMERO", "SEGUNDO", "TERCERO", "CUARTO", "QUINTO");
        $grados_sec = array("SEXTO", "SÉPTIMO", "OCTAVO", "NOVENO", "DÉCIMO", "UNDÉCIMO");
        $materias = array("SOCIALES", "ESPAÑOL", "MATEMÁTICAS", "NATURALES", "INGLÉS", "INFORMÁTICA", "ÉTICA Y RELIGIÓN", "ARTÍSTICA", "DEPORTE", "MÚSICA", "LECTORES", "PESP", "GLOBALIZACIÓN", "CORPORAL");

       
        while ($datos = $result2->fetch_assoc()) {

          $mat2 = $datos['notas_cualitativas_materia'];
          $sec = $datos['notas_cualitativas_sector'];
          $per = $datos['notas_cualitativas_periodo'];
          $ren = $datos['notas_cualitativas_rend'];
          $niv = $datos['notas_cualitativas_orden'];
          $fde = $datos['notas_cualitativas_fortalezas'];
          $dde = $datos['notas_cualitativas_debilidades'];
          $rde = $datos['notas_cualitativas_recomendaciones'];
          $mat_ctrl = 0;

          if ($sec === 'TRA') {


            if ($mat2 == 'CIENCIASSOCIALES') {
              $mat = 'SOCIALES';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'LENGUAJE') {
              $mat = 'ESPAÑOL';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'MATEMÁTICAS') {
              $mat = 'MATEMÁTICAS';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'CIENCIASNATURALES') {
              $mat = 'NATURALES';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'INGLÉS') {
              $mat = 'INGLÉS';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'INFORMÁTICA') {
              $mat = 'INFORMÁTICA';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'ÉTICA') {
              $mat = 'ÉTICA Y RELIGIÓN';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'ARTE') {
              $mat = 'ARTÍSTICA';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'DEPORTE') {
              $mat = 'DEPORTE';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'MÚSICA') {
              $mat = 'MÚSICA';
              $mat_ctrl = 1;
            }
  
            if ($mat2 == 'PESP') {
              $mat = 'PESP';
              $mat_ctrl = 1;
            }
  
            if ($mat2 == 'CORPORAL') {
              $mat = 'CORPORAL';
              $mat_ctrl = 1;
            }
  
            if ($mat2 == 'GLOBALIZACIÓN') {
              $mat = 'GLOBALIZACIÓN';
              $mat_ctrl = 1;
            }
  

            $datos_bd_tra[$per][$ren]['n'.$niv]['ftz'] = $fde;
            $datos_bd_tra[$per][$ren]['n'.$niv]['deb'] = $dde;
            $datos_bd_tra[$per][$ren]['n'.$niv]['rec'] = $rde;

            
            foreach ($grados_tra as $key) {

              $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
              $stmt-> bind_param('ss', $mat, $key);
              $stmt->execute();
              $result = $stmt->get_result();

              if ($result->num_rows > 0) {
                $stmt = $conn->prepare("UPDATE siscpi_cualitativas SET datos=?, usuario=?, editado=? WHERE materia=? AND grado=?");
                $stmt->bind_param('sssss', json_encode($datos_bd_tra), $id_usuario, $hoy, $mat, $key);
                $stmt->execute();
              
                if ($stmt->affected_rows) {
                  echo 'Fortalezados actualizados en materia '.$mat.' y grado '.$key;
                }
              } else {
                $stmt = $conn->prepare("INSERT INTO siscpi_cualitativas (materia, grado, datos, usuario, editado) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $mat, $key, json_encode($datos_bd_tra), $id_usuario, $hoy);
                $stmt->execute();

                if ($stmt->affected_rows) {
                  echo 'Fortalezados actualizados en materia '.$mat.' y grado '.$key;
                }
              }
            
              
            }

          }

          if ($sec === 'PRI') {


            if ($mat2 == 'CIENCIASSOCIALES') {
              $mat = 'SOCIALES';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'LENGUAJE') {
              $mat = 'ESPAÑOL';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'MATEMÁTICAS') {
              $mat = 'MATEMÁTICAS';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'CIENCIASNATURALES') {
              $mat = 'NATURALES';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'INGLÉS') {
              $mat = 'INGLÉS';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'INFORMÁTICA') {
              $mat = 'INFORMÁTICA';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'ÉTICA') {
              $mat = 'ÉTICA Y RELIGIÓN';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'ARTE') {
              $mat = 'ARTÍSTICA';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'DEPORTE') {
              $mat = 'DEPORTE';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'MÚSICA') {
              $mat = 'MÚSICA';
              $mat_ctrl = 1;
            }
  
            if ($mat2 == 'PESP') {
              $mat = 'PESP';
              $mat_ctrl = 1;
            }
  
            if ($mat2 == 'CORPORAL') {
              $mat = 'CORPORAL';
              $mat_ctrl = 1;
            }
  
            if ($mat2 == 'GLOBALIZACIÓN') {
              $mat = 'GLOBALIZACIÓN';
              $mat_ctrl = 1;
            }
  

            $datos_bd_pri[$per][$ren]['n'.$niv]['ftz'] = $fde;
            $datos_bd_pri[$per][$ren]['n'.$niv]['deb'] = $dde;
            $datos_bd_pri[$per][$ren]['n'.$niv]['rec'] = $rde;

            
            foreach ($grados_pri as $key) {

              $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
              $stmt-> bind_param('ss', $mat, $key);
              $stmt->execute();
              $result = $stmt->get_result();

              if ($result->num_rows > 0) {
                $stmt = $conn->prepare("UPDATE siscpi_cualitativas SET datos=?, usuario=?, editado=? WHERE materia=? AND grado=?");
                $stmt->bind_param('sssss', json_encode($datos_bd_pri), $id_usuario, $hoy, $mat, $key);
                $stmt->execute();
              
                if ($stmt->affected_rows) {
                  echo 'Fortalezados actualizados en materia '.$mat.' y grado '.$key;
                }
              } else {
                $stmt = $conn->prepare("INSERT INTO siscpi_cualitativas (materia, grado, datos, usuario, editado) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $mat, $key, json_encode($datos_bd_pri), $id_usuario, $hoy);
                $stmt->execute();

                if ($stmt->affected_rows) {
                  echo 'Fortalezados actualizados en materia '.$mat.' y grado '.$key;
                }
              }
            
              
            }


          }

          if ($sec === 'SEC') {


            if ($mat2 == 'CIENCIASSOCIALES') {
              $mat = 'SOCIALES';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'LENGUAJE') {
              $mat = 'ESPAÑOL';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'MATEMÁTICAS') {
              $mat = 'MATEMÁTICAS';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'CIENCIASNATURALES') {
              $mat = 'NATURALES';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'INGLÉS') {
              $mat = 'INGLÉS';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'INFORMÁTICA') {
              $mat = 'INFORMÁTICA';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'ÉTICA') {
              $mat = 'ÉTICA Y RELIGIÓN';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'ARTE') {
              $mat = 'ARTÍSTICA';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'DEPORTE') {
              $mat = 'DEPORTE';
              $mat_ctrl = 1;
            }
            
            if ($mat2 == 'MÚSICA') {
              $mat = 'MÚSICA';
              $mat_ctrl = 1;
            }
  
            if ($mat2 == 'PESP') {
              $mat = 'PESP';
              $mat_ctrl = 1;
            }
  
            if ($mat2 == 'CORPORAL') {
              $mat = 'CORPORAL';
              $mat_ctrl = 1;
            }
  
            if ($mat2 == 'GLOBALIZACIÓN') {
              $mat = 'GLOBALIZACIÓN';
              $mat_ctrl = 1;
            }
  

            $datos_bd_sec[$per][$ren]['n'.$niv]['ftz'] = $fde;
            $datos_bd_sec[$per][$ren]['n'.$niv]['deb'] = $dde;
            $datos_bd_sec[$per][$ren]['n'.$niv]['rec'] = $rde;

            foreach ($grados_sec as $key) {

              $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
              $stmt-> bind_param('ss', $mat, $key);
              $stmt->execute();
              $result = $stmt->get_result();

              if ($result->num_rows > 0) {
                $stmt = $conn->prepare("UPDATE siscpi_cualitativas SET datos=?, usuario=?, editado=? WHERE materia=? AND grado=?");
                $stmt->bind_param('sssss', json_encode($datos_bd_sec), $id_usuario, $hoy, $mat, $key);
                $stmt->execute();
              
                if ($stmt->affected_rows) {
                  echo 'Fortalezados actualizados en materia '.$mat.' y grado '.$key;
                }
              } else {
                $stmt = $conn->prepare("INSERT INTO siscpi_cualitativas (materia, grado, datos, usuario, editado) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $mat, $key, json_encode($datos_bd_sec), $id_usuario, $hoy);
                $stmt->execute();

                if ($stmt->affected_rows) {
                  echo 'Fortalezados actualizados en materia '.$mat.' y grado '.$key;
                }
              }
            
              
            }



          }

        }
        



  };
  */

  /*
  if ($result2->num_rows > 0) {

    $id_usuario = 8;

    $materias = array();
    $datos_bd_tra = array();
    $datos_bd_pri = array();
    $datos_bd_sec = array();
    $grados_tra = array("PRE JARDÍN", "JARDÍN", "TRANSICIÓN");
    $grados_pri = array("PRIMERO", "SEGUNDO", "TERCERO", "CUARTO", "QUINTO");
    $grados_sec = array("SEXTO", "SÉPTIMO", "OCTAVO", "NOVENO", "DÉCIMO", "UNDÉCIMO");
    $materias = array("SOCIALES", "ESPAÑOL", "MATEMÁTICAS", "NATURALES", "INGLÉS", "INFORMÁTICA", "ÉTICA Y RELIGIÓN", "ARTÍSTICA", "DEPORTE", "MÚSICA", "LECTORES", "PESP", "GLOBALIZACIÓN", "CORPORAL");


    while ($datos = $result2->fetch_assoc()) {

      $mat2 = $datos['notas_cualitativas_materia'];
      $sec = $datos['notas_cualitativas_sector'];
      $per = $datos['notas_cualitativas_periodo'];
      $ren = $datos['notas_cualitativas_rend'];
      $niv = $datos['notas_cualitativas_orden'];
      $fde = $datos['notas_cualitativas_fortalezas'];
      $dde = $datos['notas_cualitativas_debilidades'];
      $rde = $datos['notas_cualitativas_recomendaciones'];
      $mat_ctrl = 0;

      if ($mat2 === 'MÚSICA') {
        $mat = 'MÚSICA';
        $mat_ctrl = 1;

        /*
        if ($sec === 'TRA') {

          $datos_bd_tra[$per][$ren]['n' . $niv]['ftz'] = $fde;
          $datos_bd_tra[$per][$ren]['n' . $niv]['deb'] = $dde;
          $datos_bd_tra[$per][$ren]['n' . $niv]['rec'] = $rde;


          foreach ($grados_tra as $key) {

            $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
            $stmt->bind_param('ss', $mat, $key);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
              $stmt = $conn->prepare("UPDATE siscpi_cualitativas SET datos=?, usuario=?, editado=? WHERE materia=? AND grado=?");
              $stmt->bind_param('sssss', json_encode($datos_bd_tra), $id_usuario, $hoy, $mat, $key);
              $stmt->execute();

              if ($stmt->affected_rows) {
                echo 'Fortalezados actualizados en materia ' . $mat . ' y grado ' . $key;
              }
            } else {
              $stmt = $conn->prepare("INSERT INTO siscpi_cualitativas (materia, grado, datos, usuario, editado) VALUES (?, ?, ?, ?, ?)");
              $stmt->bind_param("sssss", $mat, $key, json_encode($datos_bd_tra), $id_usuario, $hoy);
              $stmt->execute();

              if ($stmt->affected_rows) {
                echo 'Fortalezados actualizados en materia ' . $mat . ' y grado ' . $key;
              }
            }
          }
        }
        

        if ($sec === 'PRI') {

          $datos_bd_pri[$per][$ren]['n' . $niv]['ftz'] = $fde;
          $datos_bd_pri[$per][$ren]['n' . $niv]['deb'] = $dde;
          $datos_bd_pri[$per][$ren]['n' . $niv]['rec'] = $rde;


          foreach ($grados_pri as $key) {

            $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
            $stmt->bind_param('ss', $mat, $key);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
              $stmt = $conn->prepare("UPDATE siscpi_cualitativas SET datos=?, usuario=?, editado=? WHERE materia=? AND grado=?");
              $stmt->bind_param('sssss', json_encode($datos_bd_pri), $id_usuario, $hoy, $mat, $key);
              $stmt->execute();

              if ($stmt->affected_rows) {
                echo 'Fortalezados actualizados en materia ' . $mat . ' y grado ' . $key;
              }
            } else {
              $stmt = $conn->prepare("INSERT INTO siscpi_cualitativas (materia, grado, datos, usuario, editado) VALUES (?, ?, ?, ?, ?)");
              $stmt->bind_param("sssss", $mat, $key, json_encode($datos_bd_pri), $id_usuario, $hoy);
              $stmt->execute();

              if ($stmt->affected_rows) {
                echo 'Fortalezados actualizados en materia ' . $mat . ' y grado ' . $key;
              }
            }
          }
        }

        if ($sec === 'SEC') {

          $datos_bd_sec[$per][$ren]['n' . $niv]['ftz'] = $fde;
          $datos_bd_sec[$per][$ren]['n' . $niv]['deb'] = $dde;
          $datos_bd_sec[$per][$ren]['n' . $niv]['rec'] = $rde;

          foreach ($grados_sec as $key) {

            $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
            $stmt->bind_param('ss', $mat, $key);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
              $stmt = $conn->prepare("UPDATE siscpi_cualitativas SET datos=?, usuario=?, editado=? WHERE materia=? AND grado=?");
              $stmt->bind_param('sssss', json_encode($datos_bd_sec), $id_usuario, $hoy, $mat, $key);
              $stmt->execute();

              if ($stmt->affected_rows) {
                echo 'Fortalezados actualizados en materia ' . $mat . ' y grado ' . $key;
              }
            } else {
              $stmt = $conn->prepare("INSERT INTO siscpi_cualitativas (materia, grado, datos, usuario, editado) VALUES (?, ?, ?, ?, ?)");
              $stmt->bind_param("sssss", $mat, $key, json_encode($datos_bd_sec), $id_usuario, $hoy);
              $stmt->execute();

              if ($stmt->affected_rows) {
                echo 'Fortalezados actualizados en materia ' . $mat . ' y grado ' . $key;
              }
            }
          }
        }
      }

    }

  };
  */


  /*
  if ($result->num_rows > 0) {

    $id_usuario = 8;

    $materias = array();
    $datos_bd_tra = array();
    $datos_bd_pri = array();
    $datos_bd_sec = array();
    $grados_tra = array("PRE JARDÍN", "JARDÍN", "TRANSICIÓN");
    $grados_pri = array("PRIMERO", "SEGUNDO", "TERCERO", "CUARTO", "QUINTO");
    $grados_sec = array("SEXTO", "SÉPTIMO", "OCTAVO", "NOVENO", "DÉCIMO", "UNDÉCIMO");
    $materias = array("SOCIALES", "ESPAÑOL", "MATEMÁTICAS", "NATURALES", "INGLÉS", "INFORMÁTICA", "ÉTICA Y RELIGIÓN", "ARTÍSTICA", "DEPORTE", "MÚSICA", "LECTORES", "PESP", "GLOBALIZACIÓN", "CORPORAL");

    
    while ($datos = $result2->fetch_assoc()) {

      $sec = $datos['notas_cualitativas_sector'];
      $mat_ctrl = 0;

      if ($sec === 'TRA') {

        $mat2 = $datos['notas_cualitativas_materia'];
        $per = $datos['notas_cualitativas_periodo'];
        $ren2 = $datos['notas_cualitativas_rend'];
        $niv = $datos['notas_cualitativas_orden'];
        $fde = $datos['notas_cualitativas_fortalezas'];
        $dde = $datos['notas_cualitativas_debilidades'];
        $rde = $datos['notas_cualitativas_recomendaciones'];
        $mat_ctrl = 0;

        if ($ren2 == 'BASICO') {
          $ren = 'BÁSICO';
        } else {
          $ren = $ren2;
        }


        if ($mat2 == 'MATEMÁTICAS') {
          $mat = 'MATEMÁTICAS';
          $mat_ctrl = 1;
        }

        if ($mat2 == 'INGLÉS') {
          $mat = 'INGLÉS';
          $mat_ctrl = 1;
        }

        if ($mat2 == 'ARTE') {
          $mat = 'ARTÍSTICA';
          $mat_ctrl = 1;
        }

        if ($mat2 == 'PESP') {
          $mat = 'PESP';
          $mat_ctrl = 1;
        }

        if ($mat2 == 'CORPORAL') {
          $mat = 'CORPORAL';
          $mat_ctrl = 1;
        }

        if ($mat2 == 'GLOBALIZACIÓN') {
          $mat = 'GLOBALIZACIÓN';
          $mat_ctrl = 1;
        }

        $datos_bd_tra[$per][$ren]['n' . $niv]['ftz'] = $fde;
        $datos_bd_tra[$per][$ren]['n' . $niv]['deb'] = $dde;
        $datos_bd_tra[$per][$ren]['n' . $niv]['rec'] = $rde;

        $datos_bd_tra[$per][$ren]['n' . 2]['ftz'] = $fde;
        $datos_bd_tra[$per][$ren]['n' . 2]['deb'] = $dde;
        $datos_bd_tra[$per][$ren]['n' . 2]['rec'] = $rde;

        $datos_bd_tra[$per][$ren]['n' . 3]['ftz'] = $fde;
        $datos_bd_tra[$per][$ren]['n' . 3]['deb'] = $dde;
        $datos_bd_tra[$per][$ren]['n' . 3]['rec'] = $rde;


        

        if ($mat_ctrl === 1) {
          foreach ($grados_tra as $key) {

            $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
            $stmt->bind_param('ss', $mat, $key);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
              $stmt = $conn->prepare("UPDATE siscpi_cualitativas SET datos=?, usuario=?, editado=? WHERE materia=? AND grado=?");
              $stmt->bind_param('sssss', json_encode($datos_bd_tra), $id_usuario, $hoy, $mat, $key);
              $stmt->execute();

              if ($stmt->affected_rows) {
                echo 'Fortalezados actualizados en materia ' . $mat . ' y grado ' . $key;
              }
            } else {
              $stmt = $conn->prepare("INSERT INTO siscpi_cualitativas (materia, grado, datos, usuario, editado) VALUES (?, ?, ?, ?, ?)");
              $stmt->bind_param("sssss", $mat, $key, json_encode($datos_bd_tra), $id_usuario, $hoy);
              $stmt->execute();

              if ($stmt->affected_rows) {
                echo 'Fortalezados actualizados en materia ' . $mat . ' y grado ' . $key;
              }
            }
          }
        }

      }
    }
  };
  */
  
  
} catch (\Exception $e) {
  $error = $e->getMessage();
  echo $error;
}




