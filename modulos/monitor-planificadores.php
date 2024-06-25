<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once '../funciones/servicios.php';
require_once  SESIONES;

if ($_SESSION['nivel'] == 3 || $_SESSION['nivel'] == 1) :

  require_once FUNCIONES;

  // Templates   
  require_once HEADER;
  require_once BARRA;
  require_once NAVEGACION;

?>

  <script>
    const logId = <?php echo json_encode($_SESSION['logid']); ?>;
    const modelo = '../modelos/malla-modelo.php'
  </script>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              <i class="fa fa-file-lines"></i>
              Planificador Bimestral
            </h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">


        <?php

        $complete_background = '#28A745';
        $complete_text = 'white';
        $incomplete_background = '#FFC107';
        $incomplete_text = 'black';

        foreach (MATERIAS as $materia => $materia_info) {

          [$ap_actuales, $ml_actuales, $plan_actual, $codMat, $reconteo1, $row] = planificador2($conn, $materia);
          $reconteo = $reconteo1;

          $class_gado_acc = false;
          $log_actuales = json_decode($row['mat_logros'], true);

        ?>

          <div class="card card-navy card-outline">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Planificador - <?php echo htmlspecialchars($materia) ?>
              </h3>
            </div>
            <div class="card-body">
              <!--h4>Custom Content Below</!--h4-->
              <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">

                <?php

                for ($i = 1; $i < 15; $i++) {

                  for ($per_acc = 1; $per_acc <= 4; $per_acc++) {
                    buscar_incomplete($reconteo[$materia]['p-' . $per_acc]['g-' . $i]) ? $class_gado_acc = true : '';
                  }

                  if ($class_gado_acc) {
                    $class_grd = 'background-color:' . $incomplete_background . '; color:' . $incomplete_text . '; margin-right: 5px';
                  } else {
                    $class_grd = 'background-color:' . $complete_background . '; color:' . $complete_text . '; margin-right: 5px';
                  }
                ?>
                  <li class="nav-item">
                    <a class="nav-link" id="tab-<?php echo htmlspecialchars($codMat . $i) ?>" data-toggle="pill" href="#tab<?php echo htmlspecialchars($codMat . $i) ?>" role="tab" aria-controls="tab<?php echo htmlspecialchars($codMat . $i) ?>" aria-selected="false" style="<?php echo $class_grd ?>;"><?php echo htmlspecialchars($i) . '°' ?></a>
                  </li>
                <?php
                }
                ?>

              </ul>

              <div class="tab-content" id="custom-content-below-tabContent">

                <?php
                for ($i = 1; $i < 15; $i++) {

                  if (isset(GRADOS[$i])) {
                    [$gra_actual, $sec_actual] = GRADOS[$i];
                  }



                ?>
                  <div class="tab-pane fade" id="tab<?php echo htmlspecialchars($codMat . $i) ?>" role="tabpanel" aria-labelledby="contenttab">
                    <br>

                    <?php

                    for ($j = 1; $j <= 4; $j++) {

                      if (buscar_incomplete($reconteo[$materia]['p-' . $j]['g-' . $i])) {
                        $class_per = 'background-color:' . $incomplete_background . '; color:' . $incomplete_text . ';';
                      } else {
                        $class_per = 'background-color:' . $complete_background . '; color:' . $complete_text . ';';
                      }

                    ?>


                      <div class="card card-success collapsed-card">
                        <div class="card-header" style="<?php echo $class_per ?>" id="tabper-<?php echo htmlspecialchars($codMat . $j) ?>">
                          <h3 class="card-title"><?php echo 'Periodo ' . $j ?></h3>
                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                              <i class="fas fa-plus"></i></button>
                          </div>
                        </div>
                        <div class="card-body col-sm-12" style="display: none;">

                          <?php

                          if (buscar_incomplete($reconteo[$materia]['p-' . $j]['g-' . $i]['est'])) {
                            $class_est = 'background-color:' . $incomplete_background . '; color:' . $incomplete_text . ';' . 'border: none;';
                          } else {
                            $class_est = 'background-color:' . $complete_background . '; color:' . $complete_text . ';' . 'border: none;';
                          }

                          if (buscar_incomplete($reconteo[$materia]['p-' . $j]['g-' . $i]['nlp'])) {
                            $class_nlp = 'background-color:' . $incomplete_background . '; color:' . $incomplete_text . ';' . 'border: none;';
                          } else {
                            $class_nlp = 'background-color:' . $complete_background . '; color:' . $complete_text . ';' . 'border: none;';
                          }

                          ?>

                          <div class="col-sm-10">
                            <button id="tabest-<?php echo htmlspecialchars($codMat . $j . $i) ?>" style="<?php echo $class_est ?>;" type="button" class="btn btn-primary" onclick="modalEstandar(
                                  '<?php echo $materia ?>',
                                  '<?php echo $j ?>',
                                  '<?php echo $i ?>',
                                  '<?php echo 'tabest-' . htmlspecialchars($codMat . $j . $i) ?>',
                                  '<?php echo 'tab-' . htmlspecialchars($codMat . $i) ?>',
                                  '<?php echo 'tabper-' . htmlspecialchars($codMat . $j) ?>',
                                  'est'
                                )">Estandar</button>
                            <button id="tabnlp-<?php echo htmlspecialchars($codMat . $j . $i) ?>" style="<?php echo $class_nlp ?>;" type="button" class="btn btn-primary" onclick="modalEstandar(
                                  '<?php echo $materia ?>',
                                  '<?php echo $j ?>',
                                  '<?php echo $i ?>',
                                  '<?php echo 'tabnlp-' . htmlspecialchars($codMat . $j . $i) ?>',
                                  '<?php echo 'tab-' . htmlspecialchars($codMat . $i) ?>',
                                  '<?php echo 'tabper-' . htmlspecialchars($codMat . $j) ?>',
                                  'nlp'
                                )">Núcleo P.</button>
                          </div>


                          <br>


                          <?php

                          $log = $log_actuales['p-' . $j]['g-' . $i]; // Cantidad de logros para la materia
                          for ($k = 1; $k <= $log; $k++) { ?>

                            <div>
                              <div class="col-sm-12">
                                <div class="form-group">
                                  <label for="" class="badge badge-pill badge-secondary aprendizajes__header"><?php echo 'Aprendizaje ' . $k ?></label>

                                  <fieldset class="fiel-custom">
                                    <legend>Aprendizaje</legend>
                                    <p>
                                      <?php
                                      if (isset($ml_actuales["p-" . $j]["g-" . $i]["a-" . $k]["key"])) {
                                        $claves = explode('&', $ml_actuales["p-" . $j]["g-" . $i]["a-" . $k]["key"]);
                                        echo $ap_actuales["p-" . $j]["g-" . $i][$claves[0]][$claves[1]];
                                      } else { ?>
                                        <span style="color:red">No hay aprendizaje registrado, por favor dirijase al menu <b>Malla Curricular</b> y establezca un aprendizaje. </span>
                                      <?php
                                      };
                                      ?>
                                    </p>
                                  </fieldset>
                                  <br>

                                  <fieldset class="fiel-custom">
                                    <legend>Competencia</legend>
                                    <p>
                                      <?php echo isset($ml_actuales["p-" . $j]["g-" . $i]["a-" . $k]['cpt']) ? $ml_actuales["p-" . $j]["g-" . $i]["a-" . $k]['cpt'] : '<span style="color:red">No hay competencia registrada, por favor dirijase al menu <b>Malla Curricular</b> y establezca una competencia. </span>' ?>
                                    </p>
                                  </fieldset>
                                  <br>

                                  <fieldset class="fiel-custom">
                                    <legend>Componente</legend>
                                    <p>
                                      <?php echo isset($ml_actuales["p-" . $j]["g-" . $i]["a-" . $k]['cmp']) ? $ml_actuales["p-" . $j]["g-" . $i]["a-" . $k]['cmp'] : '<span style="color:red">No hay componente registrado, por favor dirijase al menu <b>Malla Curricular</b> y establezca un componente. </span>' ?>
                                    </p>
                                  </fieldset>

                                </div>
                              </div> <!-- col -->

                              <?php

                              if (isset($plan_actual["p-" . $j]["g-" . $i]["ap-" . $k]) && isset($plan_actual["p-" . $j]["g-" . $i]["ap-" . $k]['eje'])) {
                                $eje_desc = $plan_actual["p-" . $j]["g-" . $i]["ap-" . $k]['eje'];
                              } else {
                                $eje_desc = '';
                              }

                              ?>

                              <div class="col-sm-12">
                                <div class="form-group">
                                  <label>Ejes temáticos:</label>
                                  <div class="input-group">
                                    <textarea style="<?php echo strlen($eje_desc) < 20 ? 'border: 1px solid ' . $incomplete_background . ';' : '' ?>" type="text" class="form-control ejes-tematicos" id="<?php echo 'et' . $codMat . $j . $i . $k ?>" data-mat="<?php echo $materia ?>" data-per="<?php echo $j ?>" data-gra="<?php echo $i ?>" data-ape="<?php echo $k ?>" data-tab-one="<?php echo 'tab-' . htmlspecialchars($codMat . $i) ?>" data-tab-per="<?php echo 'tabper-' . htmlspecialchars($codMat . $j) ?>"><?php echo $eje_desc ?></textarea>
                                    <div class="invalid-feedback">
                                      Este campo es obligatorio.
                                    </div>
                                  </div>
                                </div>
                              </div> <!-- col -->

                              <br>

                              <?php

                              $style_acc1 = 'btn btn-warning';
                              $style_acc2 = 'btn btn-warning';
                              $style_acc3 = 'btn btn-warning';
                              $style_acc4 = 'btn btn-warning';

                              $style_tag = 'style_';

                              //print_r($reconteo[$materia]['p-' . $j]['g-' . $i]['ap-' . $k]);

                              if (isset($reconteo[$materia]['p-' . $j]['g-' . $i]['ap-' . $k]) && isset($reconteo[$materia]['p-' . $j]['g-' . $i]['ap-' . $k]['acc'])) {

                                if ($reconteo[$materia]['p-' . $j]['g-' . $i]['ap-' . $k]['acc'] !== 'incomplete') {

                                  foreach ($reconteo[$materia]['p-' . $j]['g-' . $i]['ap-' . $k]['acc'] as $clave1 => $valor1) {

                                    $crr_style = false;

                                    if (buscar_incomplete($valor1)) {
                                      $crr_style = true;
                                    }

                                    $crr_style ? '' : ${$style_tag . str_replace("-", "", $clave1)} = 'btn btn-success';
                                  }
                                }
                              } else {
                                $style_acc1 = 'btn btn-warning';
                                $style_acc2 = 'btn btn-warning';
                                $style_acc3 = 'btn btn-warning';
                                $style_acc4 = 'btn btn-warning';
                              }



                              ?>

                              <div class="col-sm-10">

                                <button id="tabperacc1-<?php echo htmlspecialchars($codMat . $j . $k . $i) ?>" type="button" class="<?php echo $style_acc1 ?>" onclick="modalAcciones(
                                        1,
                                        '<?php echo $k ?>',
                                        '<?php echo $j ?>',
                                        '<?php echo $materia ?>',
                                        '<?php echo $i ?>',
                                        'tabperacc1-<?php echo htmlspecialchars($codMat . $j . $k . $i) ?>',
                                        '<?php echo 'tab-' . htmlspecialchars($codMat . $i) ?>',
                                        '<?php echo 'tabper-' . htmlspecialchars($codMat . $j) ?>'
                                      )">Accion #1
                                </button>

                                <button id="tabperacc2-<?php echo htmlspecialchars($codMat . $j . $k . $i) ?>" type="button" class="<?php echo $style_acc2 ?>" onclick="modalAcciones(
                                        2,
                                        '<?php echo $k ?>',
                                        '<?php echo $j ?>',
                                        '<?php echo $materia ?>',
                                        '<?php echo $i ?>',
                                        'tabperacc2-<?php echo htmlspecialchars($codMat . $j . $k . $i) ?>',
                                        '<?php echo 'tab-' . htmlspecialchars($codMat . $i) ?>',
                                        '<?php echo 'tabper-' . htmlspecialchars($codMat . $j) ?>'
                                      )">Accion #2
                                </button>

                                <button id="tabperacc3-<?php echo htmlspecialchars($codMat . $j . $k . $i) ?>" type="button" class="<?php echo $style_acc3 ?>" onclick="modalAcciones(
                                        3,
                                        '<?php echo $k ?>',
                                        '<?php echo $j ?>',
                                        '<?php echo $materia ?>',
                                        '<?php echo $i ?>',
                                        'tabperacc3-<?php echo htmlspecialchars($codMat . $j . $k . $i) ?>',
                                        '<?php echo 'tab-' . htmlspecialchars($codMat . $i) ?>',
                                        '<?php echo 'tabper-' . htmlspecialchars($codMat . $j) ?>'
                                      )">Accion #3
                                </button>

                                <button id="tabperacc4-<?php echo htmlspecialchars($codMat . $j . $k . $i) ?>" type="button" class="<?php echo $style_acc4 ?>" onclick="modalAcciones(
                                        4,
                                        '<?php echo $k ?>',
                                        '<?php echo $j ?>',
                                        '<?php echo $materia ?>',
                                        '<?php echo $i ?>',
                                        'tabperacc4-<?php echo htmlspecialchars($codMat . $j . $k . $i) ?>',
                                        '<?php echo 'tab-' . htmlspecialchars($codMat . $i) ?>',
                                        '<?php echo 'tabper-' . htmlspecialchars($codMat . $j) ?>'
                                      )">Accion #4
                                </button>

                              </div>

                            </div>
                            <br>
                            <br>

                          <?php
                          }
                          ?>

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

  <div class="modal fade" id="modal-acciones">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">

            <small>
              <strong>
                <span id="modal-acciones-mat">Aprendizaje</span>
              </strong>
            </small>

            <small>
              <span id="modal-acciones-tittle">Aprendizaje</span>
            </small>

            <small id="tittle-desc"></small>

            <small>
              <span>Periodo: </span>
            </small>

            <small id="tittle-per"></small>

          </h5>
          <h6></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">


          <div class="row">

            <div class="col-sm-12">
              <div class="form-group">
                <label>Fecha <span class="accTittle"></span></label>
                <div class="input-group">
                  <input type="text" class="form-control float-right acc-fecha" name="accFcValue" id="accFcValue">
                </div>
              </div>
            </div> <!-- col -->

            <div class="col-sm-12">
              <div class="form-group">
                <label>Acción Reflexiva <span class="accTittle"></span></label>
                <div class="input-group">
                  <textarea type="text" class="form-control" id="accArValue"></textarea>
                </div>
              </div>
            </div> <!-- col -->

            <div class="col-sm-12">
              <div class="form-group">
                <label>Actividad planeada y evaluación <span class="accTittle"></span></label>
                <div class="input-group">
                  <textarea type="text" class="form-control" id="accApValue"></textarea>
                </div>
              </div>
            </div> <!-- col -->

            <div class="col-sm-12">
              <div class="form-group">
                <label>DBA <span class="accTittle"></span></label>
                <div class="input-group">
                  <textarea type="text" class="form-control" id="accDbValue"></textarea>
                </div>
              </div>
            </div> <!-- col -->

            <div class="col-sm-12">
              <div class="form-group">
                <label>Competencias Socioemocionales <span class="accTittle"></span></label>
                <div class="input-group">
                  <textarea type="text" class="form-control" id="accCsValue"></textarea>
                </div>
              </div>
            </div> <!-- col -->


            <input type="hidden" id="acc-mat" value="">
            <input type="hidden" id="acc-per" value="">
            <input type="hidden" id="acc-gra" value="">
            <input type="hidden" id="acc-cod" value="">
            <input type="hidden" id="acc-ord" value="">
            <input type="hidden" id="acc-ape" value="">
            <input type="hidden" id="acc-ide" value="">
            <input type="hidden" id="est-acc-one" value="">
            <input type="hidden" id="tab-acc-per" value="">


          </div>
          <!-- /.row -->

        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-success" onClick="regAcciones()">Confirmar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->


  <div class="modal fade" id="modal-estandar">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">

            <small>
              <strong>
                <i class="fas fa-user"></i>
                <span id="modal-estandar-tittle">Estandar</span>
              </strong>
            </small>

            <small id="mat-desc"></small>

            <small>
              <strong>
                <span>Periodo: </span>
              </strong>
            </small>

            <small id="mat-per"></small>

          </h5>
          <h6></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">


          <div class="row">

            <div class="col-sm-12">
              <div class="form-group">
                <label>#1</label>
                <div class="input-group">
                  <textarea type="text" class="form-control" id="est1"></textarea>
                </div>
              </div>
            </div> <!-- col -->

            <div class="col-sm-12">
              <div class="form-group">
                <label>#2</label>
                <div class="input-group">
                  <textarea type="text" class="form-control" id="est2"></textarea>
                </div>
              </div>
            </div> <!-- col -->

            <div class="col-sm-12">
              <div class="form-group">
                <label>#3</label>
                <div class="input-group">
                  <textarea type="text" class="form-control" id="est3"></textarea>
                </div>
              </div>
            </div> <!-- col -->

            <input type="hidden" id="est-mat" value="">
            <input type="hidden" id="est-per" value="">
            <input type="hidden" id="est-gra" value="">
            <input type="hidden" id="est-cod" value="">
            <input type="hidden" id="est-ide" value="">
            <input type="hidden" id="est-one" value="">
            <input type="hidden" id="tab-per" value="">

          </div>
          <!-- /.row -->


        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-success" onClick="regEstandar()">Confirmar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

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
    timer: 2000,
  });

  function buscarIncompleto(objeto) {
    let result = false;

    for (let clave in objeto) {
      if (typeof objeto[clave] === 'object') {

        if (buscarIncompleto(objeto[clave])) {
          return true;
        }

      } else if (typeof objeto[clave] === 'string' && objeto[clave].includes('incomplete')) {
        result = true;
      }
    }

    return result;
  }

  function modalEstandar(mat, per, gra, estId, tabone, tabper, estDesc) {

    let modalTittle = ''
    if (estDesc === 'est') {
      modalTittle = 'Estandar'
    } else if (estDesc === 'nlp') {
      modalTittle = 'Núcleo problémico'
    }

    const tittle = document.querySelector('#modal-estandar-tittle')

    const matDes = document.querySelector("#mat-desc")
    const matPer = document.querySelector("#mat-per")
    const estMat = document.querySelector("#est-mat")
    const estPer = document.querySelector("#est-per")
    const estGra = document.querySelector("#est-gra")
    const estCod = document.querySelector("#est-cod")
    const estIde = document.querySelector("#est-ide")
    const estOne = document.querySelector("#est-one")
    const tabPer = document.querySelector("#tab-per")

    const est1 = document.querySelector("#est1")
    const est2 = document.querySelector("#est2")
    const est3 = document.querySelector("#est3")

    est1.value = '';
    est2.value = '';
    est3.value = '';


    //matStan.(per)
    matDes.textContent = mat
    matPer.textContent = per
    estMat.value = mat
    estPer.value = per
    estGra.value = gra
    estCod.value = estDesc
    estIde.value = estId
    estOne.value = tabone
    tabPer.value = tabper
    tittle.textContent = modalTittle

    const data = {
      cmd: "estsql",
      mat: mat,
      per: per,
      gra: gra,
      est: estDesc,
      user_id: logId,
    };

    (async () => {

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

          const res = JSON.parse(responseData.comentario)

          est1.value = res.est1;
          est2.value = res.est2;
          est3.value = res.est3;

        } else {
          Toast.fire({
            icon: 'error',
            title: responseData.comentario
          })
        }

      } catch (error) {
        console.error(error);
      }

    })();

    $('#modal-estandar').modal();

  }

  function regEstandar() {

    const estMat = document.querySelector("#est-mat").value
    const estPer = document.querySelector("#est-per").value
    const estGra = document.querySelector("#est-gra").value
    const estCod = document.querySelector("#est-cod").value
    const estIde = document.querySelector("#est-ide").value
    const estOne = document.querySelector("#est-one").value
    const tabPer = document.querySelector("#tab-per").value

    const estStyle = document.querySelector(`#${estIde}`)

    const est1 = document.querySelector("#est1").value
    const est2 = document.querySelector("#est2").value
    const est3 = document.querySelector("#est3").value

    $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:flex;');

    (async () => {

      const data = {
        cmd: "estreg",
        mat: estMat,
        per: estPer,
        gra: estGra,
        est: estCod,
        est1: est1,
        est2: est2,
        est3: est3,
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

          let finalStyle = false

          responseData.est1.length < 5 ? finalStyle = true : ''
          responseData.est2.length < 5 ? finalStyle = true : ''
          responseData.est3.length < 5 ? finalStyle = true : ''

          if (finalStyle) {
            estStyle.setAttribute('style', 'background: <?php echo $incomplete_background ?>; color: <?php echo $incomplete_text ?>; border: none')
          } else {
            estStyle.setAttribute('style', 'background: <?php echo $complete_background ?>; color: <?php echo $complete_text ?>; border: none')
          }

          $('#modal-estandar').modal('hide');

          const getPlanificador = (baseUrl) => {
            fetch(baseUrl, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                  materia: estMat,
                  cmd: 'plan2'
                })
              })
              .then(response => response.json())
              .then(data => {

                const perTittle = document.querySelector(`#${tabPer}`);
                const grdTittle = document.querySelector(`#${estOne}`);

                let gradState = 0;
                for (let index = 1; index <= 4; index++) {

                  perResult = buscarIncompleto(data.respuesta[`p-${index}`][`g-${estGra}`]);
                  perResult ? gradState += 1 : '';

                  if (index === +estPer && perResult) {
                    perTittle.setAttribute('style', 'background: #FFC107; color: black');
                  } else {
                    index === +estPer ? perTittle.setAttribute('style', 'background: #28A745; color, white') : '';
                  };

                };

                if (gradState > 0) {
                  grdTittle.setAttribute('style', 'background: #FFC107; color: black; margin-right: 5px;')
                } else {
                  grdTittle.setAttribute('style', 'background: #28A745; color: white; margin-right: 5px;')
                }

              })
              .catch(error => {
                console.error('Error:', error);
              });
          };

          getPlanificador('../funciones/servicios.php');


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

  function modalAcciones(order, ap, per, mat, gra, accId, tabone, tabper) {

    const accTittles = document.querySelectorAll('.accTittle')
    const tittleDesc = document.querySelector('#tittle-desc')
    const tittlePer = document.querySelector('#tittle-per')
    const modalAccionesMat = document.querySelector('#modal-acciones-mat')

    const accIde = document.querySelector("#acc-ide")

    const estOne = document.querySelector("#est-acc-one")
    const tabPer = document.querySelector("#tab-acc-per")



    tittleDesc.textContent = `#${ap}`
    tittlePer.textContent = `#${per}`
    modalAccionesMat.textContent = mat

    accTittles.forEach(element => {
      element.textContent = `#${order}`
    });


    const estMat = document.querySelector("#acc-mat")
    const estPer = document.querySelector("#acc-per")
    const estGra = document.querySelector("#acc-gra")
    const estCod = document.querySelector("#acc-cod")
    const estOrd = document.querySelector("#acc-ord")
    const estApe = document.querySelector("#acc-ape")

    estMat.value = mat
    estPer.value = per
    estGra.value = gra
    estCod.value = 'acc'
    estOrd.value = order
    estApe.value = ap
    accIde.value = accId

    estOne.value = tabone
    tabPer.value = tabper



    const accArValue = document.querySelector("#accArValue")
    const accApValue = document.querySelector("#accApValue")
    const accDbValue = document.querySelector("#accDbValue")
    const accCsValue = document.querySelector("#accCsValue")
    const accFcValue = document.querySelector("#accFcValue")

    const data = {
      cmd: "accsql",
      mat: mat,
      per: per,
      gra: gra,
      ap: ap,
      order: order,
      user_id: logId,
    };

    (async () => {

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

          const res = JSON.parse(responseData.comentario)

          accArValue.value = res.aar ? res.aar : ''
          accApValue.value = res.aap ? res.aap : ''
          accDbValue.value = res.adb ? res.adb : ''
          accCsValue.value = res.acs ? res.acs : ''
          accFcValue.value = res.afc ? res.afc : ''

          $('#modal-acciones').modal();

        } else {
          Toast.fire({
            icon: 'error',
            title: responseData.comentario
          })
        }

      } catch (error) {
        console.error(error);
      }

    })();


  }

  function regAcciones() {

    const estMat = document.querySelector("#acc-mat").value
    const estPer = document.querySelector("#acc-per").value
    const estGra = document.querySelector("#acc-gra").value
    const estCod = document.querySelector("#acc-cod").value
    const estOrd = document.querySelector("#acc-ord").value
    const estApe = document.querySelector("#acc-ape").value
    const estIde = document.querySelector("#acc-ide").value

    const accStyle = document.querySelector(`#${estIde}`)

    const accArValue = document.querySelector("#accArValue").value
    const accApValue = document.querySelector("#accApValue").value
    const accDbValue = document.querySelector("#accDbValue").value
    const accCsValue = document.querySelector("#accCsValue").value
    const accFcValue = document.querySelector("#accFcValue").value

    const estOne = document.querySelector("#est-acc-one").value
    const tabPer = document.querySelector("#tab-acc-per").value



    $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:flex;');
    (async () => {

      const data = {
        cmd: "accreg",
        mat: estMat,
        per: estPer,
        gra: estGra,
        est: estCod,
        aar: accArValue,
        aap: accApValue,
        adb: accDbValue,
        acs: accCsValue,
        afc: accFcValue,
        ord: estOrd,
        ape: estApe,
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

          let finalStyle = false

          responseData.aar.length < 5 ? finalStyle = true : ''
          responseData.aap.length < 5 ? finalStyle = true : ''
          responseData.adb.length < 5 ? finalStyle = true : ''
          responseData.acs.length < 5 ? finalStyle = true : ''
          responseData.afc.length < 5 ? finalStyle = true : ''

          if (finalStyle) {
            accStyle.setAttribute('style', 'background: <?php echo $incomplete_background ?>; color: <?php echo $incomplete_text ?>; border: none')
          } else {
            accStyle.setAttribute('style', 'background: <?php echo $complete_background ?>; color: <?php echo $complete_text ?>; border: none')
          }

          $('#modal-acciones').modal('hide');

          const getPlanificador = (baseUrl) => {
            fetch(baseUrl, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                  materia: estMat,
                  cmd: 'plan2'
                })
              })
              .then(response => response.json())
              .then(data => {

                const perTittle = document.querySelector(`#${tabPer}`);
                const grdTittle = document.querySelector(`#${estOne}`);

                let gradState = 0;
                for (let index = 1; index <= 4; index++) {

                  perResult = buscarIncompleto(data.respuesta[`p-${index}`][`g-${estGra}`]);
                  perResult ? gradState += 1 : '';

                  if (index === +estPer && perResult) {
                    perTittle.setAttribute('style', 'background: #FFC107; color: black');
                  } else {
                    index === +estPer ? perTittle.setAttribute('style', 'background: #28A745; color, white') : '';
                  };

                };

                if (gradState > 0) {
                  grdTittle.setAttribute('style', 'background: #FFC107; color: black; margin-right: 5px;')
                } else {
                  grdTittle.setAttribute('style', 'background: #28A745; color: white; margin-right: 5px;')
                }

              })
              .catch(error => {
                console.error('Error:', error);
              });
          };

          getPlanificador('../funciones/servicios.php');

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

  /*Controlador del input Fecha*/

  const cumple = document.querySelector("#accFcValue");

  cumple.maxLength = 10;

  //Añade los separadores '/' automáticamente
  cumple.addEventListener("keydown", (event) => {
    if (event.keyCode !== 46 && event.keyCode !== 8) {
      let fecha = event.target.value;
      if (fecha.length === 2) {
        event.target.value = fecha + "/";
      }

      if (fecha.length === 5) {
        event.target.value = fecha + "/";
      }

      if (fecha.length > 10) {
        event.preventDefault();
      }
    }
  });


  let ejesTematicos = document.querySelectorAll(".ejes-tematicos");

  ejesTematicos.forEach((input) => {

    const textInput = document.querySelector(`#${input.id}`);
    textInput.addEventListener("change", (event) => {
      const mat = event.target.getAttribute("data-mat")
      const per = event.target.getAttribute("data-per")
      const gra = event.target.getAttribute("data-gra")
      const ape = event.target.getAttribute("data-ape")
      const ide = event.target.getAttribute("id")
      const des = event.target.value

      const tabOne = event.target.getAttribute("data-tab-one")
      const tabPer = event.target.getAttribute("data-tab-per")


      const dat = [mat, per, gra, ape, des]
      guardarEje(dat, ide, tabOne, tabPer);

    });

  });


  async function guardarEje(dat, ide, tabOne, tabPer) {

    const txtArea = document.querySelector(`#${ide}`)

    const [mat, per, gra, ape, des] = dat
    const data = {
      cmd: "ejenuevo",
      mat: mat,
      per: per,
      gra: gra,
      ape: ape,
      des: des,
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

      const dataServer = await response.json();

      if (dataServer.respuesta === "exito") {
        Toast.fire({
          icon: "success",
          title: dataServer.comentario,
        });

        dataServer.des.length < 5 ? txtArea.setAttribute('style', 'border: 1px solid <?php echo $incomplete_background ?>') : txtArea.setAttribute('style', '')

        const getPlanificador = (baseUrl) => {

          fetch(baseUrl, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                materia: estMat,
                cmd: 'plan2'
              })
            })
            .then(response => response.json(data))
            .then(data => {

              const perTittle = document.querySelector(`#${tabPer}`);
              const grdTittle = document.querySelector(`#${tabOne}`);

              let gradState = 0;
              for (let index = 1; index <= 4; index++) {

                perResult = buscarIncompleto(data.respuesta[`p-${index}`][`g-${gra}`]);
                perResult ? gradState += 1 : '';

                if (index === +per && perResult) {
                  perTittle.setAttribute('style', 'background: #FFC107; color: black');
                } else {
                  index === +per ? perTittle.setAttribute('style', 'background: #28A745; color, white') : '';
                };

              };

              if (gradState > 0) {
                grdTittle.setAttribute('style', 'background: #FFC107; color: black; margin-right: 5px;')
              } else {
                grdTittle.setAttribute('style', 'background: #28A745; color: white; margin-right: 5px;')
              }

            })
            .catch(error => {
              console.error('Error:', error);
            });
        };

        getPlanificador('../funciones/servicios.php');



      } else {
        Toast.fire({
          icon: "error",
          title: dataServer.comentario,
        });
      }

    } catch (error) {
      console.error(error);
    }

  }

  $('#accFcValue').daterangepicker()
</script>