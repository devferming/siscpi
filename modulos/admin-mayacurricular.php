<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once  SESIONES;

if ($_SESSION['nivel'] == 6) :

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
              Maya Curricular Anual
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

        if (isset($_SESSION['datos']['pro_mat']) && is_array($_SESSION['datos']['pro_mat'])) {
          foreach ($_SESSION['datos']['pro_mat'] as $materia) {

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
              $log_actuales = json_decode($row['mat_logros'], true);
            } catch (\Exception $e) {
              $error = $e->getMessage();
              echo $error;
            }

            ?>


            <div class="card card-navy card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-edit"></i>
                  Malla anual - <?php echo htmlspecialchars($materia) ?>
                </h3>
              </div>
              <div class="card-body">
                <!--h4>Custom Content Below</!--h4-->
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">

                  <?php
                  for ($i = 1; $i < 15; $i++) {
                    if (isset($_SESSION['datos']['on' . $codMat . $i]) && $_SESSION['datos']['on' . $codMat . $i] == 1) {
                  ?>
                      <li class="nav-item">
                        <a class="nav-link" id="tab-<?php echo htmlspecialchars($codMat . $i) ?>" data-toggle="pill" href="#tab<?php echo htmlspecialchars($codMat . $i) ?>" role="tab" aria-controls="tab<?php echo htmlspecialchars($codMat . $i) ?>" aria-selected="false"><?php echo htmlspecialchars($i) . '°' ?></a>
                      </li>
                  <?php
                    }
                  }
                  ?>

                </ul>

                <div class="tab-content" id="custom-content-below-tabContent">

                  <?php
                  for ($i = 1; $i < 15; $i++) {

                    if (isset(GRADOS[$i])) {
                      [$gra_actual, $sec_actual ] = GRADOS[$i];
                    }


                    if (isset($_SESSION['datos']['on' . $codMat . $i]) && $_SESSION['datos']['on' . $codMat . $i] == 1) {

                    ?>
                      <div class="tab-pane fade" id="tab<?php echo htmlspecialchars($codMat . $i) ?>" role="tabpanel" aria-labelledby="contenttab">
                        <br>

                        <?php

                        for ($j = 1; $j <= 4; $j++) { ?>

                          <div class="card card-success collapsed-card">
                            <div class="card-header">
                              <h3 class="card-title"><?php echo 'Periodo ' . $j ?></h3>
                              <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                  <i class="fas fa-plus"></i></button>
                              </div>
                            </div>
                            <div class="card-body col-sm-12" style="display: none;">


                              <?php

                              $log = $log_actuales['p-'.$j]['g-'.$i]; // Cantidad de logros para la materia

                              for ($k = 1; $k <= $log; $k++) { ?>

                                <div>
                                  <label for="" class="badge badge-pill badge-secondary malla__header" onclick="desModal('<?php echo $materia ?>', '<?php echo $j ?>', '<?php echo $i ?>', '<?php echo $k ?>', '<?php echo $codMat ?>')"><?php echo ' Aprendizaje ' . $k ?><small> - <i class="fa-solid fa-hand-pointer"></i> Clic para seleccionar</small></label>
                                  <p id="<?php echo $codMat . $j . $i . $k ?>">
                                    <?php

                                    if (isset($ml_actuales["p-" . $j]["g-" . $i]["a-" . $k]["key"])) {
                                      $claves = explode('&', $ml_actuales["p-" . $j]["g-" . $i]["a-" . $k]["key"]);
                                      echo $ap_actuales["p-" . $j]["g-" . $i][$claves[0]][$claves[1]];
                                    } else {
                                      echo 'S/R';
                                    };
                                    
                                    ?>

                                  </p>

                                  <?php
                                        /*
                                    echo '<pre>';
                                      print_r($ml_actuales);
                                    echo '</pre>'; */
                                  
                                  
                                  ?>


                                  <label for="">Competencia</label>
                                  <textarea
                                    type="text"
                                    class="form-control other-inputs"
                                    id="<?php echo 'cpt-'.$codMat.$i.$j.$k ?>"
                                    data-mat="<?php echo $materia ?>"
                                    data-per="<?php echo $j ?>"
                                    data-gra="<?php echo $i ?>"
                                    data-apn="<?php echo $k ?>"
                                    data-clv="<?php echo 'cpt' ?>"
                                    placeholder="No se encontraron registros"
                                    ><?php echo isset($ml_actuales["p-".$j]["g-".$i]["a-".$k]['cpt']) ? $ml_actuales["p-".$j]["g-".$i]["a-".$k]['cpt'] : '' ?></textarea>

                                  <label for="">Componente</label>
                                  <textarea
                                    type="text"
                                    class="form-control other-inputs"
                                    id="<?php echo 'cmp-'.$codMat.$i.$j.$k ?>"
                                    data-mat="<?php echo $materia ?>"
                                    data-per="<?php echo $j ?>"
                                    data-gra="<?php echo $i ?>"
                                    data-apn="<?php echo $k ?>"
                                    data-clv="<?php echo 'cmp' ?>"
                                    placeholder="No se encontraron registros"
                                    ><?php echo isset($ml_actuales["p-".$j]["g-".$i]["a-".$k]['cmp']) ? $ml_actuales["p-".$j]["g-".$i]["a-".$k]['cmp'] : '' ?></textarea>
                                </div>
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
                  }
                  ?>

                </div>
              </div>

            </div>
          <?php
          }
        } else {
          // Manejar el caso en el que $_SESSION['datos']['pro_mat'] no exista o no sea un array
        }
        ?>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="modal-ap">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><small><strong><i class="fas fa-user"></i><span>Banco de Aprendizajes <span id="modal-ap-titulo"></span></span></strong></small></h5>
          <h6></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

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

  function desModal(mat, per, gra, apn, codMat) {

    var modalContainer = document.getElementById('modal-container');
    modalContainer.innerHTML = '';

    (async () => {

      const data = {
        cmd: "sqlap",
        user_id: logId,
        mat: mat,
        per: per,
        gra: gra,
        apn: apn
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
          let banco = JSON.parse(responseData.data);

          Object.entries(banco).map(([pKey, pData]) => {

            const sub = {
              ing: 'Inglés',
              bio: 'Biología',
              qui: 'Química',
              fis: 'Física',
              cas: 'Castellano',
              pla: 'Plan Lector',
              ari: 'Aritmética',
              gtr: 'Geometría',
              est: 'Estadística',
              mat: 'Matemáticas',
              geo: 'Geografía',
              his: 'Historia',
              dec: 'Democracia y Paz',
              eco: 'Economía Política',
              fil: 'Filosofía',
              inf: 'Informática',
              etc: 'Ética',
              reg: 'Religión',
              dep: 'Deporte',
              mus: 'Música',
              art: 'Arte',
              glo: 'Globalización',
              pes: 'Pesp',
              cor: 'Corporal'
            }

            const matSub = pKey.split('-')[1]
            const matNom = sub[matSub]

            Object.entries(pData).map(([apInfo, apDes]) => {

              let div = document.createElement('div');
              div.className = 'col-sm-12';

              let formGroup = document.createElement('div');
              formGroup.className = 'form-group';

              let p = document.createElement('p');
              p.style.cursor = 'pointer';
              p.onclick = function() {
                cambiaApe(mat, per, gra, apn, pKey, apInfo, apDes, codMat);
              };

              let small = document.createElement('small');
              small.style.fontWeight = 'bold'
              small.style.fontSize = '0.8em'

              let contentTittle = document.createTextNode(`${matNom} ${apInfo}:`);
              let contentText = document.createTextNode(apDes);
              let hr = document.createElement('hr');

              small.appendChild(contentTittle)
              p.appendChild(contentText);
              p.appendChild(hr);
              formGroup.appendChild(small);
              formGroup.appendChild(p);
              div.appendChild(formGroup);
              modalContainer.appendChild(div);
            })

          });

        } else {
          Toast.fire({
            icon: 'error',
            title: responseData.comentario
          })
        }

      } catch (error) {
        console.error(error);
      }

      //$('#idalum-forta').val(ida);
      $('#modal-ap').modal();


    })();
  }

  function cambiaApe(mat, per, gra, apn, pKey, apInfo, apDes, codMat) {

    $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:flex;');

    const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 8000,
    });

    (async () => {

      const data = {
        cmd: "mllatc",
        mat: mat,
        per: per,
        gra: gra,
        apn: apn,
        key: pKey,
        api: apInfo,
        user_id: logId
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


          $('#'+ codMat + per + gra + apn).text(apDes); //AQUI!
          console.log('#' + per + gra + apn)
          $('#modal-ap').modal('hide');

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