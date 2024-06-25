<?php

$nivel = 2;

function buscar_incomplete($array)
{
  foreach ($array as $value) {
    if (is_array($value)) {
      // Llamada recursiva si el valor es un array
      if (buscar_incomplete($value)) {
        return true;
      }
    } else {
      // Verificar si el valor contiene "incomplete"
      if (strpos($value, 'incomplete') !== false) {
        return true;
      }
    }
  }
  return false;
};

function planificador($conn, $materia)
{


  $reconteo1 = [];

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

  if (isset($codigos[$materia])) {
    $codMat = $codigos[$materia];
  }

  try {
    $stmt = $conn->prepare("SELECT * FROM siscpi_materias WHERE mat_des_materia=?");
    $stmt->bind_param("s", $materia);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $ap_actuales = json_decode($row['mat_aprendizajes'], true);
    $ml_actuales = json_decode($row['mat_malla'], true);
    $plan_actual = json_decode($row['mat_planificador'], true);
    $log_actuales = json_decode($row['mat_logros'], true);
  } catch (\Exception $e) {
    $error = $e->getMessage();
    echo $error;
  }


  for ($x = 1; $x <= 4; $x++) {

    for ($n = 1; $n < 15; $n++) {

      if (isset($_SESSION['datos']['on' . $codMat . $n]) && $_SESSION['datos']['on' . $codMat . $n] == 1) {

        for ($est = 1; $est <= 3; $est++) {

          if (isset($plan_actual['p-' . $x]['g-' . $n]['est']['est' . $est])) {
            $longitud = strlen($plan_actual['p-' . $x]['g-' . $n]['est']['est' . $est]);
            $reconteo1[$materia]['p-' . $x]['g-' . $n]['est']['est' . $est] = $longitud < 5 ? 'incomplete' : 'completo';
          } else {
            $reconteo1[$materia]['p-' . $x]['g-' . $n]['est']['est' . $est] = 'incomplete';
          }

          if (isset($plan_actual['p-' . $x]['g-' . $n]['nlp']['est' . $est])) {
            $longitud = strlen($plan_actual['p-' . $x]['g-' . $n]['nlp']['est' . $est]);
            $reconteo1[$materia]['p-' . $x]['g-' . $n]['nlp']['est' . $est] = $longitud < 5 ? 'incomplete' : 'completo';
          } else {
            $reconteo1[$materia]['p-' . $x]['g-' . $n]['nlp']['est' . $est] = 'incomplete';
          }

          if (isset(GRADOS[$n])) {
            [$gra_ac, $sec_ac] = GRADOS[$n];
          }

          $log = $log_actuales['p-' . $x]['g-' . $n]; // Cantidad de logros para la materia

          for ($a = 1; $a <= $log; $a++) {

            if (isset($plan_actual['p-' . $x]['g-' . $n]['ap-' . $a]['acc'])) {

              for ($a2 = 1; $a2 <= 4; $a2++) {

                $crr_acc = isset($plan_actual['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]) ? $plan_actual['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2] : 'NA';

                if ($crr_acc !== 'NA') {

                  $aar = strlen($crr_acc['aar']);
                  $aap = strlen($crr_acc['aap']);
                  $adb = strlen($crr_acc['adb']);
                  $acs = strlen($crr_acc['acs']);
                  $afc = strlen($crr_acc['afc']);

                  $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['aar'] = $aar < 5 ? 'incomplete' : 'completo';
                  $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['aap'] = $aap < 5 ? 'incomplete' : 'completo';
                  $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['adb'] = $adb < 5 ? 'incomplete' : 'completo';
                  $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['acs'] = $acs < 5 ? 'incomplete' : 'completo';
                  $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['afc'] = $afc < 5 ? 'incomplete' : 'completo';
                } else {
                  $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['aar'] = 'incomplete';
                  $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['aap'] = 'incomplete';
                  $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['adb'] = 'incomplete';
                  $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['acs'] = 'incomplete';
                  $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['afc'] = 'incomplete';
                }
              }
            } else {
              $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc'] = 'incomplete';
            }

            if (isset($plan_actual['p-' . $x]['g-' . $n]['ap-' . $a]['eje'])) {

              $crr_eje = isset($plan_actual['p-' . $x]['g-' . $n]['ap-' . $a]['eje']) ? $plan_actual['p-' . $x]['g-' . $n]['ap-' . $a]['eje'] : 'NA';

              if ($crr_eje !== 'NA') {
                $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['eje'] = strlen($crr_eje) < 5 ? 'incomplete' : 'completo';
              } else {
                $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['eje'] = 'incomplete';
              }
            } else {
              $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['eje'] = 'incomplete';
            }

            if (isset($ml_actuales["p-" . $x]["g-" . $n]["a-" . $a]["key"])) {
              $xclaves1 = explode('&', $ml_actuales["p-" . $x]["g-" . $n]["a-" . $a]["key"]);

              $longitud1  = strlen($ap_actuales["p-" . $x]["g-" . $n][$xclaves1[0]][$xclaves1[1]]);

              $longitud2  = strlen(isset($ml_actuales["p-" . $x]["g-" . $n]["a-" . $a]["cpt"]) ? $ml_actuales["p-" . $x]["g-" . $n]["a-" . $a]["cpt"] : '');
              $longitud3  = strlen(isset($ml_actuales["p-" . $x]["g-" . $n]["a-" . $a]["cmp"]) ? $ml_actuales["p-" . $x]["g-" . $n]["a-" . $a]["cmp"] : '');

              $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['des'] = $longitud1 < 1 ? 'incomplete' : 'completo';
              $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['cpt'] = $longitud2 < 1 ? 'incomplete' : 'completo';
              $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['cmp'] = $longitud3 < 1 ? 'incomplete' : 'completo';
            } else {
              $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['des'] = 'incomplete';
              $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['cpt'] = 'incomplete';
              $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['cmp'] = 'incomplete';
            };
          }
        }
      }
    }
  }

  return [$ap_actuales, $ml_actuales, $plan_actual, $codMat, $reconteo1, $row];
};

function planificador2($conn, $materia)
{


  $reconteo1 = [];

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

  if (isset($codigos[$materia])) {
    $codMat = $codigos[$materia];
  }

  try {
    $stmt = $conn->prepare("SELECT * FROM siscpi_materias WHERE mat_des_materia=?");
    $stmt->bind_param("s", $materia);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $ap_actuales = json_decode($row['mat_aprendizajes'], true);
    $ml_actuales = json_decode($row['mat_malla'], true);
    $plan_actual = json_decode($row['mat_planificador'], true);
    $log_actuales = json_decode($row['mat_logros'], true);
  } catch (\Exception $e) {
    $error = $e->getMessage();
    echo $error;
  }


  for ($x = 1; $x <= 4; $x++) {

    for ($n = 1; $n < 15; $n++) {

      for ($est = 1; $est <= 3; $est++) {

        if (isset($plan_actual['p-' . $x]['g-' . $n]['est']['est' . $est])) {
          $longitud = strlen($plan_actual['p-' . $x]['g-' . $n]['est']['est' . $est]);
          $reconteo1[$materia]['p-' . $x]['g-' . $n]['est']['est' . $est] = $longitud < 5 ? 'incomplete' : 'completo';
        } else {
          $reconteo1[$materia]['p-' . $x]['g-' . $n]['est']['est' . $est] = 'incomplete';
        }

        if (isset($plan_actual['p-' . $x]['g-' . $n]['nlp']['est' . $est])) {
          $longitud = strlen($plan_actual['p-' . $x]['g-' . $n]['nlp']['est' . $est]);
          $reconteo1[$materia]['p-' . $x]['g-' . $n]['nlp']['est' . $est] = $longitud < 5 ? 'incomplete' : 'completo';
        } else {
          $reconteo1[$materia]['p-' . $x]['g-' . $n]['nlp']['est' . $est] = 'incomplete';
        }

        if (isset(GRADOS[$n])) {
          [$gra_ac, $sec_ac] = GRADOS[$n];
        }

        $log = $log_actuales['p-' . $x]['g-' . $n]; // Cantidad de logros para la materia

        for ($a = 1; $a <= $log; $a++) {

          if (isset($plan_actual['p-' . $x]['g-' . $n]['ap-' . $a]['acc'])) {

            for ($a2 = 1; $a2 <= 4; $a2++) {

              $crr_acc = isset($plan_actual['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]) ? $plan_actual['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2] : 'NA';

              if ($crr_acc !== 'NA') {

                $aar = strlen($crr_acc['aar']);
                $aap = strlen($crr_acc['aap']);
                $adb = strlen($crr_acc['adb']);
                $acs = strlen($crr_acc['acs']);
                $afc = strlen($crr_acc['afc']);

                $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['aar'] = $aar < 5 ? 'incomplete' : 'completo';
                $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['aap'] = $aap < 5 ? 'incomplete' : 'completo';
                $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['adb'] = $adb < 5 ? 'incomplete' : 'completo';
                $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['acs'] = $acs < 5 ? 'incomplete' : 'completo';
                $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['afc'] = $afc < 5 ? 'incomplete' : 'completo';
              } else {
                $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['aar'] = 'incomplete';
                $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['aap'] = 'incomplete';
                $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['adb'] = 'incomplete';
                $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['acs'] = 'incomplete';
                $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc']['acc-' . $a2]['afc'] = 'incomplete';
              }
            }
          } else {
            $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['acc'] = 'incomplete';
          }

          if (isset($plan_actual['p-' . $x]['g-' . $n]['ap-' . $a]['eje'])) {

            $crr_eje = isset($plan_actual['p-' . $x]['g-' . $n]['ap-' . $a]['eje']) ? $plan_actual['p-' . $x]['g-' . $n]['ap-' . $a]['eje'] : 'NA';

            if ($crr_eje !== 'NA') {
              $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['eje'] = strlen($crr_eje) < 5 ? 'incomplete' : 'completo';
            } else {
              $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['eje'] = 'incomplete';
            }
          } else {
            $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['eje'] = 'incomplete';
          }

          if (isset($ml_actuales["p-" . $x]["g-" . $n]["a-" . $a]["key"])) {
            $xclaves1 = explode('&', $ml_actuales["p-" . $x]["g-" . $n]["a-" . $a]["key"]);

            $longitud1  = strlen($ap_actuales["p-" . $x]["g-" . $n][$xclaves1[0]][$xclaves1[1]]);

            $longitud2  = strlen(isset($ml_actuales["p-" . $x]["g-" . $n]["a-" . $a]["cpt"]) ? $ml_actuales["p-" . $x]["g-" . $n]["a-" . $a]["cpt"] : '');
            $longitud3  = strlen(isset($ml_actuales["p-" . $x]["g-" . $n]["a-" . $a]["cmp"]) ? $ml_actuales["p-" . $x]["g-" . $n]["a-" . $a]["cmp"] : '');

            $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['des'] = $longitud1 < 1 ? 'incomplete' : 'completo';
            $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['cpt'] = $longitud2 < 1 ? 'incomplete' : 'completo';
            $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['cmp'] = $longitud3 < 1 ? 'incomplete' : 'completo';
          } else {
            $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['des'] = 'incomplete';
            $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['cpt'] = 'incomplete';
            $reconteo1[$materia]['p-' . $x]['g-' . $n]['ap-' . $a]['cmp'] = 'incomplete';
          };
        }
      }
    }
  }

  return [$ap_actuales, $ml_actuales, $plan_actual, $codMat, $reconteo1, $row];
};


if ($_SERVER["REQUEST_METHOD"] === "POST") {
  include_once './funciones.php';
  include_once './sesiones.php';
  include_once './configuracion.php';

  $data = json_decode(file_get_contents('php://input'), true);

  $respuesta = array();


  if (isset($data['materia'])) {
    if ($data['cmd']  === 'plan1') {
      $infoPlan = planificador($conn, $data['materia']);
      $respuesta['respuesta'] = $infoPlan[4][$data['materia']];
      die(json_encode($respuesta));
    } else if ($data['cmd']  === 'plan2') {
      $infoPlan = planificador2($conn, $data['materia']);
      $respuesta['respuesta'] = $infoPlan[4][$data['materia']];
      die(json_encode($respuesta));
    }
  }
}
