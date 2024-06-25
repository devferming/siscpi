<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once  SESIONES;

if ($_SESSION['nivel'] == 3 || $_SESSION['nivel'] == 1) :

  require_once FUNCIONES;

  // Templates
  require_once HEADER;
  require_once BARRA;
  require_once NAVEGACION;

  $datos = $_GET['data'];
  $datos = unserialize($datos);

  $d1 = $datos['d1'];

  if (!filter_var($d1, FILTER_VALIDATE_INT)) {
    die("ERROR!");
  };

  if ($d1 == 1) {
    $periodo = 'PRIMERO';
  } elseif ($d1 == 2) {
    $periodo = 'SEGUNDO';
  } elseif ($d1 == 3) {
    $periodo = 'TERCERO';
  } elseif ($d1 == 4) {
    $periodo = 'CUARTO';
  }

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
              Gestión de fortalezados
            </h1>
            <h6>
              </code> Periodo: <code><?php echo htmlspecialchars($periodo) ?></code>
            </h6>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">


        <?php

          foreach (MATERIAS as $materia => $info) {
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
            } ?>


            <div class="card card-navy card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-edit"></i>
                  Fortalezados (<?php echo htmlspecialchars($materia) ?>)
                </h3>
              </div>
              <div class="card-body">
                <!--h4>Custom Content Below</!--h4-->
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">

                  <?php
                  for ($i = 1; $i < 15; $i++) {
                  ?>
                      <li class="nav-item">
                        <a class="nav-link" id="tab-<?php echo htmlspecialchars($codMat.$i) ?>" data-toggle="pill" href="#tab<?php echo htmlspecialchars($codMat.$i) ?>" role="tab" aria-controls="tab<?php echo htmlspecialchars($codMat.$i) ?>" aria-selected="false"><?php echo htmlspecialchars($i) . '°' ?></a>
                      </li>
                  <?php
                  }
                  ?>

                </ul>

                <div class="tab-content" id="custom-content-below-tabContent">

                  <?php
                  for ($i = 1; $i < 15; $i++) {

                      ?>
                      <div class="tab-pane fade" id="tab<?php echo htmlspecialchars($codMat.$i) ?>" role="tabpanel" aria-labelledby="contenttab">
                        <br>

                        <?php
                        $niveles = array(
                          's1' => array('valor' => 1, 'texto' => 'SUPERIOR'),
                          's2' => array('valor' => 2, 'texto' => 'SUPERIOR'),
                          's3' => array('valor' => 3, 'texto' => 'SUPERIOR'),
                          'a1' => array('valor' => 1, 'texto' => 'ALTO'),
                          'a2' => array('valor' => 2, 'texto' => 'ALTO'),
                          'a3' => array('valor' => 3, 'texto' => 'ALTO'),
                          'b1' => array('valor' => 1, 'texto' => 'BÁSICO'),
                          'b2' => array('valor' => 2, 'texto' => 'BÁSICO'),
                          'b3' => array('valor' => 3, 'texto' => 'BÁSICO'),
                          'z1' => array('valor' => 1, 'texto' => 'BAJO'),
                          'z2' => array('valor' => 2, 'texto' => 'BAJO'),
                          'z3' => array('valor' => 3, 'texto' => 'BAJO')
                        );

                        foreach ($niveles as $key => $nivel2) {
                          $nivelTexto = $nivel2['texto'];
                          $nivelValor = $nivel2['valor'];

                          if ($i == 1) {
                            $grado = 'PRIMERO';
                          } else if ($i == 2) {
                            $grado = 'SEGUNDO';
                          } else if ($i == 3) {
                            $grado = 'TERCERO';
                          } else if ($i == 4) {
                            $grado = 'CUARTO';
                          } else if ($i == 5) {
                            $grado = 'QUINTO';
                          } else if ($i == 6) {
                            $grado = 'SEXTO';
                          } else if ($i == 7) {
                            $grado = 'SÉPTIMO';
                          } else if ($i == 8) {
                            $grado = 'OCTAVO';
                          } else if ($i == 9) {
                            $grado = 'NOVENO';
                          } else if ($i == 10) {
                            $grado = 'DÉCIMO';
                          } else if ($i == 11) {
                            $grado = 'UNDÉCIMO';
                          } else if ($i == 12) {
                            $grado = 'PRE JARDÍN';
                          } else if ($i == 13) {
                            $grado = 'JARDÍN';
                          } else if ($i == 14) {
                            $grado = 'TRANSICIÓN';
                          }
                        ?>

                          <div class="card card-success collapsed-card">
                            <div class="card-header">
                              <h3 class="card-title"><?php echo htmlspecialchars($i . '°- ' . $nivelTexto . ' ' . $nivelValor) ?></h3>
                              <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                  <i class="fas fa-plus"></i></button>
                              </div>
                            </div>
                            <div class="card-body" style="display: none;">

                              <?php
                              try {
                                $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
                                $stmt->bind_param("ss", $materia, $grado);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $result2 = $result->fetch_assoc();

                                $niveles2 = array(
                                  "BAJO" => "bj",
                                  "BÁSICO" => "bs",
                                  "ALTO" => "al",
                                  "SUPERIOR" => "su"
                                );


                                $niv = isset($niveles2[$nivelTexto]) ? $niveles2[$nivelTexto] : "";
                                $idftz = 'ftz' . $codMat . $i . $niv . $nivelValor;
                                $iddeb = 'deb' . $codMat . $i . $niv . $nivelValor;
                                $idrec = 'rec' . $codMat . $i . $niv . $nivelValor;

                                if (isset($result2)) {
                                  $clv_dat = json_decode($result2['datos'], true);
                                  $ftz = isset($clv_dat[$periodo][$nivelTexto]['n' . $nivelValor]['ftz']) ? $clv_dat[$periodo][$nivelTexto]['n' . $nivelValor]['ftz'] : 'No se encontraron Fortalezas registradas';
                                  $deb = isset($clv_dat[$periodo][$nivelTexto]['n' . $nivelValor]['deb']) ? $clv_dat[$periodo][$nivelTexto]['n' . $nivelValor]['deb'] : 'No se encontraron Debilidades registradas';
                                  $rec = isset($clv_dat[$periodo][$nivelTexto]['n' . $nivelValor]['rec']) ? $clv_dat[$periodo][$nivelTexto]['n' . $nivelValor]['rec'] : 'No se encontraron Recomendaciones registradas';
                                } else {
                                  $ftz = 'No se encontraron Fortalezas registradas';
                                  $deb = 'No se encontraron Debilidades registradas';
                                  $rec = 'No se encontraron Recomendaciones registradas';
                                }
                              } catch (\Exception $e) {
                                $error = $e->getMessage();
                                echo htmlspecialchars($error);
                              }

                              $array_ftz = array(
                                "mat" => $materia,
                                "gra" => $grado,
                                "per" => $periodo,
                                "ren" => $nivelTexto,
                                "niv" => $nivelValor,
                                "tip" => 'ftz'
                              );

                              $array_deb = array(
                                "mat" => $materia,
                                "gra" => $grado,
                                "per" => $periodo,
                                "ren" => $nivelTexto,
                                "niv" => $nivelValor,
                                "tip" => 'deb'
                              );

                              $array_rec = array(
                                "mat" => $materia,
                                "gra" => $grado,
                                "per" => $periodo,
                                "ren" => $nivelTexto,
                                "niv" => $nivelValor,
                                "tip" => 'rec'
                              );

                              ?>

                              <label for="">FORTALEZAS</label>
                              <textarea type="text" class="form-control customclv" id="<?php echo $idftz ?>" data-tipo="textofortalezado" data-info="<?php echo htmlspecialchars(json_encode($array_ftz)) ?>"><?php echo htmlspecialchars($ftz) ?></textarea>

                              <label for="">DEBILIDADES</label>
                              <textarea type="text" class="form-control customclv" id="<?php echo $iddeb ?>" data-tipo="textofortalezado" data-info="<?php echo htmlspecialchars(json_encode($array_deb)) ?>"><?php echo htmlspecialchars($deb) ?></textarea>

                              <label for="">RECOMENDACIONES</label>
                              <textarea type="text" class="form-control customclv" id="<?php echo $idrec ?>" data-tipo="textofortalezado" data-info="<?php echo htmlspecialchars(json_encode($array_rec)) ?>"><?php echo htmlspecialchars($rec) ?></textarea>

                            </div>
                            <!-- /.card-body -->
                          </div>
                          <!-- /.card -->
                        <?php
                        }
                        ?>

                      </div>

                  <?php
                  }
                  ?>

                </div>
              </div>

            </div>
        <?php
          }
        ?>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
  // Footer
  require_once FOOTER;
  endif;
?>

<script>
</script>