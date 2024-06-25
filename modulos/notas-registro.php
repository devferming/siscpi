<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once  SESIONES;

if ($_SESSION['nivel'] == 6) :

  require_once FUNCIONES;

  // Templates
  require_once HEADER;
  require_once BARRA;
  require_once NAVEGACION;

  $dat = $_GET['data'];
  $dat = unserialize($dat);
  $hoy = date("Y-m-d H:i:s");

  $da1 = $dat['d1']; //grado
  $da2 = $dat['d2']; // periodo
  $da3 = $dat['d3']; // materia
  $da4 = $dat['d4']; // mateseccion
  $use = $_SESSION['logid']; // ID de usuario

  if (!filter_var($da1, FILTER_VALIDATE_INT) || !filter_var($da2, FILTER_VALIDATE_INT)) {
    die("ERROR!");
  }

  $mat = array_key_exists($da3, MATERIAS) ? $da3 : '';
  $per = isset(PERIODOS[$da2]) ? PERIODOS[$da2] : '';
  $gra = $sec = $lno = ''; //Grado, Sector, y llave para el select de logros

  if (isset(GRADOS[$da1])) {
    [$gra, $sec] = GRADOS[$da1];
  }

  $stmt = $conn->prepare("SELECT * FROM siscpi_materias WHERE mat_des_materia=?");
  $stmt->bind_param("s", $mat);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  $ml_actuales = json_decode($row['mat_malla'], true);
  $ap_actuales = json_decode($row['mat_aprendizajes'], true);
  $log_actuales = json_decode($row['mat_logros'], true);

  $log = $log_actuales['p-'.$da2]['g-'.$da1]; // Cantidad de logros para la materia

?>

  <script>
    const logId = <?php echo json_encode($_SESSION['logid']); ?>;
    const modelo = '../modelos/notas-modelo.php'
  </script>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              <i class="fa fa-users-cog"></i>
              ASIGNACION DE NOTAS
            </h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">


        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              Grado: <strong><span><?php echo $gra . ' (' . $da4 . ')'; ?></span></strong> &nbsp;
              Periodo: <strong><span><?php echo $per; ?></span></strong> &nbsp;
              Materia: <strong><span><?php echo $mat; ?></span></strong>
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="tablageneral" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Estudiante</th>
                  <th>Asignaciones</th>
                </tr>
              </thead>
              <tbody>

                <?php

                try {
                  $stmt = $conn->prepare("SELECT * FROM siscpi_alumnos");
                  $stmt->execute();
                  $result = $stmt->get_result();
                } catch (\Exception $e) {
                  $error = $e->getMessage();
                  echo $error;
                }

                $alumnos = array();

                while ($rowx2  = $result->fetch_assoc()) {
                  $dat_alumx2 = json_decode($rowx2['datos'], true); //Obtiene todos los datos del alumno
                  $ide_alumx2 = $rowx2['id']; //Obtiene el ID del alumno

                  // Añadir el nombre completo del alumno al array
                  $alumnos[] = array(
                    'nombre' => $dat_alumx2['per_ape'] . " " . $dat_alumx2['per_nom'],
                    'datos' => $dat_alumx2,
                    'id' => $ide_alumx2
                  );
                }

                // Función de comparación para ordenar por nombre
                function comparar_nombres($a, $b)
                {
                  return strcmp($a['nombre'], $b['nombre']);
                }

                // Ordenar el array de alumnos por nombre
                usort($alumnos, 'comparar_nombres');

                foreach  ($alumnos as $alumno) {
                  $dat_alum = $alumno['datos']; //Obtiene todos los datos del alumno
                  $ide_alum = $alumno['id']; //Obtiene el ID del alumno
                  $acumulada = 0;

                  if ($dat_alum['gra_esc'] === $gra && $dat_alum['gra_sec'] === $da4 && $dat_alum['estatus'] === 'MATRICULADO') { ?>


                    <tr>

                      <td>
                        <i class="fas fa-user"></i><?php echo ' ' . $nom_alum = $dat_alum['per_ape'] . " " . $dat_alum['per_nom']; ?><br>
                        <?php

                        $in = 1;
                        $fn = $log;

                        for ($i = $in; $i <= $fn; $i++) {

                          $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
                          $stmt->bind_param("i", $ide_alum);
                          $stmt->execute();
                          $notas_resultado = $stmt->get_result();

                          if ($notas_resultado->num_rows > 0) {
                            $notas_detalle = $notas_resultado->fetch_assoc();
                            $notas = json_decode($notas_detalle['datos'], true);

                            $nota_ev1 = 0;
                            $nota_ev2 = 0;
                            $nota_ev3 = 0;
                            $nota_ev4 = 0;
                            $nota_ev5 = 0;

                            for ($j = 1; $j <= 5; $j++) {
                              $nota_key = 'ev' . $j;
                              $nota = isset($notas['p-' . $da2]['m-' . $mat]['l-' . $in][$nota_key]) ? $notas['p-' . $da2]['m-' . $mat]['l-' . $in][$nota_key] : null;

                              switch ($nota) {
                                case '':
                                case null:
                                  ${"nota_ev" . $j} = 0;
                                  break;
                                default:
                                  ${"nota_ev" . $j} = $nota;
                                  break;
                              }
                            }
                          } else {
                            $nota_ev1 = 0;
                            $nota_ev2 = 0;
                            $nota_ev3 = 0;
                            $nota_ev4 = 0;
                            $nota_ev5 = 0;
                          }



                          $def70 = (($nota_ev1 + $nota_ev2 + $nota_ev3) / 3) * 0.7;
                          $def20 = $nota_ev4 * 0.2;
                          $def10 = $nota_ev5 * 0.1;

                          $def2 = number_format($def70 + $def20 + $def10, 1, '.', '');

                          /////////////////////////////////////

                          if (isset($ml_actuales["p-" . $da2]["g-" . $da1]["a-" . $in]["key"])) {
                            $claves = explode('&', $ml_actuales["p-" . $da2]["g-" . $da1]["a-" . $in]["key"]);
                            $claves2 = explode('-', $claves[0]);

                            $area_tittle = array_search($claves2[1], SUBDIV);
                            $area_tittle_pass = 1;
                          } else {
                            $area_tittle = '';
                            $area_tittle_pass = 0;
                          };
                        ?>

                          <fieldset class="fiel-custom">
                            <legend><small>AP-<?php echo $in . ' - ' . $area_tittle; ?></small></legend>
                            <p>

                              <?php

                              if ($area_tittle_pass === 1) { ?>

                                <span class="badge badge-pill badge-primary" id="e1-a<?php echo $ide_alum . '-l' . $in ?>"><?php echo $nota_ev1 ?></span>
                                <span class="badge badge-pill badge-primary" id="e2-a<?php echo $ide_alum . '-l' . $in ?>"><?php echo $nota_ev2 ?></span>
                                <span class="badge badge-pill badge-primary" id="e3-a<?php echo $ide_alum . '-l' . $in ?>"><?php echo $nota_ev3 ?></span>
                                <span class="badge badge-pill badge-warning" style="background-color:blueviolet;color:white" id="e4-a<?php echo $ide_alum . '-l' . $in ?>"><?php echo $nota_ev4 ?></span>
                                <span class="badge badge-pill badge-dark" style="background-color:#e83e8c;color:white" id="e5-a<?php echo $ide_alum . '-l' . $in ?>"><?php echo $nota_ev5 ?></span>

                                <a style="color:#212529; cursor:pointer;">
                                  <i class="fas fa-edit zoom" onClick="modalNota(
                                    '<?php echo $in ?>',
                                    '<?php echo $ide_alum ?>',
                                    '<?php echo $nom_alum ?>'
                                    )">
                                  </i>
                                </a>

                                <span>Def: <span id="dl-a<?php echo $ide_alum . '-l' . $in ?>"><?php echo $def2 ?></span></span>
                                <br>

                              <?php
                              } else { ?>

                                <small style="color: red;">¡Aprendizaje no registrado!</small>

                              <?php
                              }

                              ?>

                            </p>
                          </fieldset>

                        <?php
                          $in += 1;
                          $acumulada += $def2;
                        }

                        $final = number_format((float)$acumulada / $log, 1, '.', '');
                        isset(RENDIMIENTOS[$sec]) ? [$rendimiento, $bandera, $cualitativo] = RENDIMIENTOS[$sec][$final] : 0;

                        ?>

                        <hr>
                        <span>Rendimiento: <strong id="final-a<?php echo $ide_alum ?>"><?php echo $final ?></strong> <span class="badge badge-pill badge-<?php echo $bandera ?>" id="bandera-a<?php echo $ide_alum ?>"><?php echo $rendimiento ?> </span></span>
                      </td>

                      <td class="col-sm-9">

                        <?php

                        $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
                        $stmt->bind_param("ss", $mat, $gra);
                        $stmt->execute();
                        $result3 = $stmt->get_result();
                        $row2 = $result3->fetch_assoc();
                        $notasclv_datos = json_decode($row2['datos'], true);

                        $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
                        $stmt->bind_param("i", $ide_alum);
                        $stmt->execute();
                        $result2 = $stmt->get_result();


                        if ($result2->num_rows > 0) {
                          $row = $result2->fetch_assoc();
                          $notas_cnv = json_decode($row['datos'], true);

                          if (isset($notas_cnv['p-' . $da2]['m-' . $mat]['ftz'])) {
                            $ftz_mat_id = $notas_cnv['p-' . $da2]['m-' . $mat]['ftz'];
                            $ftz_array = explode('+', $ftz_mat_id);
                            $ftz_per = $ftz_array[0];
                            $ftz_ren = $ftz_array[1];
                            $ftz_niv = $ftz_array[2];
                            $ftz_des = $ftz_array[3];
                            $nota_ftz_desc = $notasclv_datos[$ftz_per][$ftz_ren][$ftz_niv][$ftz_des];
                          } else {
                            $nota_ftz_desc = '0';
                          }

                          if (isset($notas_cnv['p-' . $da2]['m-' . $mat]['deb'])) {
                            $deb_mat_id = $notas_cnv['p-' . $da2]['m-' . $mat]['deb'];
                            $deb_array = explode('+', $deb_mat_id);
                            $deb_per = $deb_array[0];
                            $deb_ren = $deb_array[1];
                            $deb_niv = $deb_array[2];
                            $deb_des = $deb_array[3];
                            $nota_deb_desc = $notasclv_datos[$deb_per][$deb_ren][$deb_niv][$deb_des];
                          } else {
                            $nota_deb_desc = '0';
                          }

                          if (isset($notas_cnv['p-' . $da2]['m-' . $mat]['rec'])) {
                            $rec_mat_id = $notas_cnv['p-' . $da2]['m-' . $mat]['rec'];
                            $rec_array = explode('+', $rec_mat_id);
                            $rec_per = $rec_array[0];
                            $rec_ren = $rec_array[1];
                            $rec_niv = $rec_array[2];
                            $rec_des = $rec_array[3];
                            $nota_rec_desc = $notasclv_datos[$rec_per][$rec_ren][$rec_niv][$rec_des];
                          } else {
                            $nota_rec_desc = '0';
                          }

                        } else {
                          $nota_ftz_desc = '0';
                          $nota_deb_desc = '0';
                          $nota_rec_desc = '0';
                        }



                        ?>

                        <strong style="cursor:pointer"><span style="color: blue" onclick="desModal('<?php echo $ide_alum ?>', 'ftz','<?php echo $per ?>')">Fortalezas: </span></strong>
                        <span id="des-forta-<?php echo $ide_alum ?>"><?php echo $nota_ftz_desc ?></span>
                        <br>

                        <strong style="cursor:pointer"><span style="color: red" onclick="desModal('<?php echo $ide_alum ?>', 'deb','<?php echo $per ?>')">Debilidades: </span></strong>
                        <span id="des-debil-<?php echo $ide_alum ?>"><?php echo $nota_deb_desc ?></span>
                        <br>

                        <strong style="cursor:pointer"><span style="color: #1f8435" onclick="desModal('<?php echo $ide_alum ?>', 'rec','<?php echo $per ?>')">Recomendaciones: </span></strong>
                        <span id="des-recom-<?php echo $ide_alum ?>"><?php echo $nota_rec_desc ?></span>

                      </td>

                    </tr>


                <?php
                  }
                }

                ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>Estudiante</th>
                  <th>Asignaciones</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <div class="modal fade" id="modal-notas">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><small><strong><i class="fas fa-user"></i><?php echo ' ' ?><span id="modal-notas-alumno">Fermin</span></strong></small> <small>- Logro: #<span id="modal-numero-logro">1</span></small></h5>
          <h6></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">


          <div class="row">

            <?php
            for ($e = 1; $e <= 5; $e++) {
              switch ($e) {
                case 4:
                  $titulo = 'ACTITUDINAL';
                  $badge = 'style="background-color:#8A2BE2;color:white"';
                  break;
                case 5:
                  $titulo = 'EXÁMEN';
                  $badge = 'style="background-color:#e83e8c;color:white"';
                  break;
                default:
                  $titulo = 'EVALUACIÓN #' . $e;
                  $badge = 'style="background-color:#007BFF;color:white"';
              }

            ?>

              <div class="col-sm-12">
                <div class="form-group">
                  <label><span class="badge badge-pill <?php echo $badge ?>"><?php echo $titulo ?></span></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" <?php echo $badge ?>><i class="fas fa-edit"></i></span>
                    </div>
                    <select class="form-control bloquear" name="ev<?php echo $e ?>" id="ev<?php echo $e ?>">
                      <option value="" selected></option>
                      <?php
                      for ($i = 2; $i < 5; $i += 0.1) {
                      ?>
                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                      <?php
                      }
                      ?>
                    </select>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
                  </div>
                </div>
              </div> <!-- col -->

            <?php
            }
            ?>

            <input type="hidden" id="idalum" value="">
            <input type="hidden" id="numlog" value="">

          </div>
          <!-- /.row -->


        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-success" onClick="regNotas()">Confirmar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <div class="modal fade" id="modal-forta">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><small><strong><i class="fas fa-user"></i><span>Banco de fortalezas (<?php echo $mat ?>)</span></strong></small></h5>
          <h6></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <?php /*
          <div class="row">

            <?php

            $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
            $stmt->bind_param("ss", $mat, $gra);
            $stmt->execute();
            $result_ftz = $stmt->get_result();
            $des_ftz = $result_ftz->fetch_assoc();
            $banco2 = json_decode($des_ftz['datos'], true);
            $banco = $banco2[$per];

            $orden = array('SUPERIOR', 'ALTO', 'BÁSICO', 'BAJO');

            foreach ($orden as $nivel) {
              if (isset($banco[$nivel])) {
                foreach ($banco[$nivel] as $key2 => $value2) {
                  if (isset($value2['ftz'])) {
                    $id = $per . '+' . $nivel . '+' . $key2 . '+ftz';
                    $concatenatedKeys = $key2 . ' (' . $nivel . ')';
                    $content = $value2['ftz'];
                    echo '<div class="col-sm-12">';
                    echo '<div class="form-group">';
                    echo '<p style="cursor:pointer; background-color: #87cefa4a" onclick="cambiaForta(\'' . $id . '\', \'' . $content . '\')">';
                    echo '<strong>' . $concatenatedKeys . '</strong>';
                    echo '<br>';
                    echo $content;
                    echo '<hr>';
                    echo '</p>';
                    echo '</div>';
                    echo '</div>';
                  }
                }
              }
            }

            ?>

            <input type="hidden" id="idalum-forta" value="">



          </div>}
          */ ?>

          <div class="row" id="modal-container">
            <!-- Aquí se generará dinámicamente el contenido del modal -->
          </div>

          <input type="hidden" id="idalum-forta" value="">

        </div>
        <!-- /.modal-body -->

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <div class="modal fade" id="modal-debil">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><small><strong><i class="fas fa-user"></i><span>Banco de debilidades (<?php echo $mat ?>)</span></strong></small></h5>
          <h6></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">


          <div class="row">

            <?php

            $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
            $stmt->bind_param("ss", $mat, $periodo);
            $stmt->execute();
            $banco_desc2 = $stmt->get_result();

            while ($banco = $banco_desc2->fetch_assoc()) {

              if ($banco['datos'] !== 'N/A') { ?>

                <div class="col-sm-12">
                  <div class="form-group">

                    <p style="cursor:pointer; background-color: #87cefa4a" onclick="cambiaDebil('<?php echo 'id de la nota cualitaiva' ?>')">
                      <strong><?php echo 'rendiminiento en texto' . ' (' . 'nivel del rendimineto' . ')' ?>: </strong>
                      <?php echo 'debilidades' ?>
                      <hr>
                    </p>
                  </div>
                </div> <!-- col -->


            <?php
              }
            }


            ?>

            <input type="hidden" id="idalum-debil" value="">

          </div>
          <!-- /.row -->


        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <div class="modal fade" id="modal-recom">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><small><strong><i class="fas fa-user"></i><span>Banco de recomendaciones (<?php echo $mat ?>)</span></strong></small></h5>
          <h6></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">


          <div class="row">

            <?php

            $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
            $stmt->bind_param("ss", $mat, $periodo);
            $stmt->execute();
            $banco_desc2 = $stmt->get_result();

            while ($banco = $banco_desc2->fetch_assoc()) {

              if ($banco['datos'] !== 'N/A') { ?>

                <div class="col-sm-12">
                  <div class="form-group">

                    <p style="cursor:pointer; background-color: #87cefa4a" onclick="cambiaRecom('<?php echo 'ide de la nota cualitativa' ?>')">
                      <strong><?php echo 'rendimineto en texto' . ' (' . 'nivel del rendimiento' . ')' ?>: </strong>
                      <?php echo 'recomendaciones' ?>
                      <hr>
                    </p>
                  </div>
                </div> <!-- col -->


            <?php
              }
            }


            ?>

            <input type="hidden" id="idalum-recom" value="">

          </div>
          <!-- /.row -->


        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <?php /*         
  <div class="modal fade" id="modal-convi">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><small><strong><i class="fas fa-user"></i><?php echo ' ' ?><span id="modal-convi-alumno">Fermin</span></strong></small> <small>- Calificación por Conviviencia<span id="modal-numero-logro"></span></small></h5>
          <h6></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="row">

            <div class="col-sm-12">
              <div class="form-group">
                <label><span class="badge badge-pill">CONVIVENCIA</span></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text badge-warning"><i class="fas fa-edit"></i></span>
                  </div>
                  <select class="form-control bloquear" name="cal-convi" id="cal-convi">
                    <option value="" selected></option>
                    <?php
                    for ($i = 2.5; $i < 5; $i += 0.1) {
                    ?>
                      <option value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php
                    }
                    ?>
                  </select>
                  <div class="invalid-feedback">
                    Este campo es obligatorio.
                  </div>
                </div>
              </div>
            </div> <!-- col -->

            <input type="hidden" id="idalum-convi" value="">
            <input type="hidden" id="perlum-convi" value="">
            <input type="hidden" id="matlum-convi" value="">
          </div>
          <!-- /.row -->


        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-success" onClick="regConvi()">Confirmar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  */ ?>



<?php
  // Footer
  require_once FOOTER;
endif;
?>

<script>
  const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 8000,
  });

  function modalNota(log, ida, alu) {

    $('#modal-notas-alumno').text(alu);
    $('#idalum').val(ida);
    $('#numlog').val(log);
    $('#modal-numero-logro').text(log);

    let n1 = $('#e1-a' + ida + '-l' + log).text();
    let n2 = $('#e2-a' + ida + '-l' + log).text();
    let n3 = $('#e3-a' + ida + '-l' + log).text();
    let n4 = $('#e4-a' + ida + '-l' + log).text();
    let n5 = $('#e5-a' + ida + '-l' + log).text();

    function buscarSelect2(dato, status) {
      // creamos un variable que hace referencia al select
      let select = document.getElementById(dato);

      // obtenemos el valor a buscar
      let buscar = status;

      // recorremos todos los valores del select
      for (var i = 1; i < select.length; i++) {
        if (select.options[i].text == buscar) {
          // seleccionamos el valor que coincide
          select.selectedIndex = i;
        }
      }
    }

    if (n1 > 0) {
      buscarSelect2('ev1', n1);
    } else {
      $("#ev1")[0].selectedIndex = 0;
    };
    if (n2 > 0) {
      buscarSelect2('ev2', n2);
    } else {
      $("#ev2")[0].selectedIndex = 0;
    };
    if (n3 > 0) {
      buscarSelect2('ev3', n3);
    } else {
      $("#ev3")[0].selectedIndex = 0;
    };
    if (n4 > 0) {
      buscarSelect2('ev4', n4);
    } else {
      $("#ev4")[0].selectedIndex = 0;
    };
    if (n5 > 0) {
      buscarSelect2('ev5', n5);
    } else {
      $("#ev5")[0].selectedIndex = 0;
    };

    $('#modal-notas').modal();

  }

  function regNotas() {

    const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 8000,
    });

    $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:flex;');

    const ev1 = $('#ev1').val();
    const ev2 = $('#ev2').val();
    const ev3 = $('#ev3').val();
    const ev4 = $('#ev4').val();
    const ev5 = $('#ev5').val();
    const ida = $('#idalum').val();
    const log = $('#numlog').val();
    const fn = '<?php echo $log ?>';
    const grd = '<?php echo $gra ?>';

    (async () => {

      const data = {
        cmd: "notnueva",
        user_id: logId,
        ev1: ev1,
        ev2: ev2,
        ev3: ev3,
        ev4: ev4,
        ev5: ev5,
        ida: ida,
        mat: "<?php echo $mat ?>",
        per: "<?php echo $da2 ?>",
        log: log,
        lfn: fn,
        grd: grd,
      };

      try {
        const response = await fetch(modelo, {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(data),
        });

        const responseData = await response.json();

        if (responseData.respuesta == 'exito') {

          Toast.fire({
            icon: 'success',
            title: responseData.comentario
          })

          if (responseData.notaev1 !== '') {
            $('#e1-a' + ida + '-l' + log).text(responseData.notaev1);
          }
          if (responseData.notaev2 !== '') {
            $('#e2-a' + ida + '-l' + log).text(responseData.notaev2);
          }
          if (responseData.notaev3 !== '') {
            $('#e3-a' + ida + '-l' + log).text(responseData.notaev3);
          }
          if (responseData.notaev4 !== '') {
            $('#e4-a' + ida + '-l' + log).text(responseData.notaev4);
          }
          if (responseData.notaev5 !== '') {
            $('#e5-a' + ida + '-l' + log).text(responseData.notaev5);
          }

          let n1p = Number(parseFloat($('#e1-a' + ida + '-l' + log).text()).toFixed(1));
          let n2p = Number(parseFloat($('#e2-a' + ida + '-l' + log).text()).toFixed(1));
          let n3p = Number(parseFloat($('#e3-a' + ida + '-l' + log).text()).toFixed(1));
          let n4p = Number(parseFloat($('#e4-a' + ida + '-l' + log).text()).toFixed(1));
          let n5p = Number(parseFloat($('#e5-a' + ida + '-l' + log).text()).toFixed(1));

          let def70x = (((((n1p + n2p + n3p) / 3)) * 70) / 100) + ((n4p * 20) / 100) + ((n5p * 10) / 100);
          let defparx = Number(parseFloat(def70x).toFixed(1));
          $('#dl-a' + ida + '-l' + log).text(defparx);

          let final = responseData.notactv;
          $('#final-a' + ida).text(final);

          let grad = '<?php echo $gra ?>';

          if (grad == 'PRIMERO' | grad == 'SEGUNDO' | grad == 'TERCERO' | grad == 'CUARTO' | grad == 'QUINTO' | grad == 'PRE JARDÍN' | grad == 'JARDÍN' | grad == 'TRANSICIÓN') {
            if (final <= 3.1) {
              rend = 'BAJO';
              band = 'badge badge-pill badge-danger';
            } else if (final >= 3.2 & final <= 3.9) {
              rend = 'BÁSICO';
              band = 'badge badge-pill badge-warning';
            } else if (final >= 4 & final <= 4.5) {
              rend = 'ALTO';
              band = 'badge badge-pill badge-success';
            } else if (final >= 4.6 & final <= 5) {
              rend = 'SUPERIOR';
              band = 'badge badge-pill badge-dark';
            }

          } else if (grad == 'SEXTO' | grad == 'SÉPTIMO' | grad == 'OCTAVO') {
            if (final <= 3.3) {
              rend = 'BAJO';
              band = 'badge badge-pill badge-danger';
            } else if (final >= 3.4 & final <= 4) {
              rend = 'BÁSICO';
              band = 'badge badge-pill badge-warning';
            } else if (final >= 4.1 & final <= 4.5) {
              rend = 'ALTO';
              band = 'badge badge-pill badge-success';
            } else if (final >= 4.6 & final <= 5) {
              rend = 'SUPERIOR';
              band = 'badge badge-pill badge-dark';
            }

          } else if (grad == 'NOVENO' | grad == 'DÉCIMO' | grad == 'UNDÉCIMO') {
            if (final <= 3.7) {
              rend = 'BAJO';
              band = 'badge badge-pill badge-danger';
            } else if (final >= 3.8 & final <= 4) {
              rend = 'BÁSICO';
              band = 'badge badge-pill badge-warning';
            } else if (final >= 4.1 & final <= 4.5) {
              rend = 'ALTO';
              band = 'badge badge-pill badge-success';
            } else if (final >= 4.6 & final <= 5) {
              rend = 'SUPERIOR';
              band = 'badge badge-pill badge-dark';
            }

          }

          $('#bandera-a' + ida).attr('class', band);
          $('#bandera-a' + ida).text(rend);

          $('#des-forta-' + ida).text(responseData.fort);
          $('#des-debil-' + ida).text(responseData.debi);
          $('#des-recom-' + ida).text(responseData.reco);


          $('#modal-notas').modal('hide');
          $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:none;');


        } else {
          Toast.fire({
            icon: 'error',
            title: resultado.comentario
          })
          $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:none;');
        }


      } catch (error) {
        console.error(error);
      }

    })();

  }

  function desModal(ida, tipo, per) {

    var modalContainer = document.getElementById('modal-container');
    modalContainer.innerHTML = '';

    (async () => {

      const data = {
        cmd: "sqlftz",
        user_id: logId,
        mat: "<?php echo $mat ?>",
        gra: '<?php echo $gra ?>'
      };

      try {
        const response = await fetch(modelo, {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(data),
        });

        const responseData = await response.json();
        console.log(responseData)

        if (responseData.respuesta == 'exito') {

          let banco2 = JSON.parse(responseData.data);

          console.log(banco2)
          let tipoDatos = banco2[per];
          const subKeyMapping = {
            'n1': 1,
            'n2': 2,
            'n3': 3
          };

          const tiposOrdenados = ['SUPERIOR', 'ALTO', 'BÁSICO', 'BAJO'];

          tiposOrdenados.forEach(function(tipoOrdenado) {
            if (tipoDatos[tipoOrdenado]) {
              Object.entries(tipoDatos[tipoOrdenado]).forEach(function([nivel, ftzObjec]) {

                Object.entries(ftzObjec).forEach(function([ftzTipo, ftzDesc]) {
                  let subkey2 = subKeyMapping[nivel];
                  let tipo2 = Object.keys(ftzObjec).find(key => key === tipo);

                  if (tipo2 === ftzTipo) {
                    let id = per + '+' + tipoOrdenado + '+' + nivel + '+' + tipo;
                    let concatenatedKeys = tipoOrdenado + ' (' + subkey2 + ')';

                    let div = document.createElement('div');
                    div.className = 'col-sm-12';

                    let formGroup = document.createElement('div');
                    formGroup.className = 'form-group';

                    let p = document.createElement('p');
                    p.style.cursor = 'pointer';
                    p.style.backgroundColor = '#87cefa4a';
                    p.onclick = function() {
                      cambiaForta(id, tipo, ftzObjec[ftzTipo]);
                    };

                    let strong = document.createElement('strong');
                    strong.textContent = concatenatedKeys;

                    let br = document.createElement('br');

                    let contentText = document.createTextNode(ftzObjec[ftzTipo]);

                    let hr = document.createElement('hr');

                    p.appendChild(strong);
                    p.appendChild(br);
                    p.appendChild(contentText);
                    p.appendChild(hr);

                    formGroup.appendChild(p);

                    div.appendChild(formGroup);

                    modalContainer.appendChild(div);
                  }
                });
              });
            }
          });







        } else {
          Toast.fire({
            icon: 'error',
            title: resultado.comentario
          })
        }


      } catch (error) {
        console.error(error);
      }

      $('#idalum-forta').val(ida);
      $('#modal-forta').modal();


    })();


  }


  function cambiaForta(desc, tipo, content) {

    $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:flex;');

    const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 8000,
    });

    (async () => {

      let ide_a = $('#idalum-forta').val();

      const data = {
        cmd: "ftzatc",
        cmd2: tipo,
        ida: ide_a,
        mat: "<?php echo $mat ?>",
        gra: "<?php echo $gra ?>",
        per: "<?php echo $da2 ?>",
        des: desc,
        user_id: logId,
      };

      try {
        const response = await fetch(modelo, {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(data),
        });

        const responseData = await response.json();
        if (responseData.respuesta == 'exito') {

          Toast.fire({
            icon: 'success',
            title: responseData.comentario
          })

          let ftz2;
          let nombreModal;

          if (tipo === 'ftz') {
            ftz2 = 'des-forta-'
            nombreModal = 'Fortalezas'
          } else if (tipo === 'deb') {
            ftz2 = 'des-debil-'
            nombreModal = 'Debilidades'
          } else if (tipo === 'rec') {
            ftz2 = 'des-recom-'
            nombreModal = 'Recomendaciones'
          }

          console.log(tipo);
          console.log('#' + ftz2 + '-' + ide_a);

          $('#' + ftz2 + ide_a).text(content);
          $('#modal-forta').modal('hide');

        } else {
          Toast.fire({
            icon: 'error',
            title: responseData.comentario
          })
        }

      } catch (error) {
        console.error(error);
      }

      $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:none;');

    })();


  }
  
</script>