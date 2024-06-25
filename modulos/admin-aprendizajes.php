<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once  SESIONES;

if ($_SESSION['nivel'] == 6) :

  require_once FUNCIONES;

  // Templates
  require_once HEADER;
  require_once BARRA;
  require_once NAVEGACION;

  function quitarAcentos($cadena) {
    $acentos = array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú');
    $sinAcentos = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U');
    
    $cadena = str_replace($acentos, $sinAcentos, $cadena);
    return $cadena;
}


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
              Banco de Aprendizajes
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
            } catch (\Exception $e) {
              $error = $e->getMessage();
              echo $error;
            }

          ?>


            <div class="card card-navy card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-edit"></i>
                  Aprendizajes - <?php echo htmlspecialchars($materia) ?>
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
                      [$gra_actual, $sec_actual, $log_actual] = GRADOS[$i];
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

                              if (isset(GRADOS[$i])) {
                                [, $sec,] = GRADOS[$i];
                              }

                              $aprendizajes = json_decode($row['mat_subdiv'], true);
                              $max_ap = $aprendizajes[$sec];

                              ?>
                              <?php

                              foreach ($max_ap as $clave => $valor) {
                                
                                ?>

                              


                                <label for="" class="badge badge-pill badge-secondary aprendizajes__header"><?php echo 'Aprendizajes de ' . $clave ?></label>

                                <?php

                                if (isset(SUBDIV[$clave])) {
                                  $apo = SUBDIV[$clave];

                                  for ($k = 1; $k <= intval($valor); $k++) {

                                    $ap_per = 'p-' . $j;
                                    $ap_gra = 'g-' . $i;
                                    $ap_apo = 'po-'. $apo;
                                    $ap_ape = 'ap-' . $k;
  
                                    if(isset($ap_actuales[$ap_per][$ap_gra][$ap_apo][$ap_ape])){
                                      $ap_des = $ap_actuales[$ap_per][$ap_gra][$ap_apo][$ap_ape];
                                    }else {
                                      $ap_des = '';
                                    }
                                  
                                    $temp_id = strtolower(quitarAcentos($clave));
  
                                    ?>
  
                                   
                                    <label for=""><?php echo 'Aprendizaje #' . $k ?></label>
                                    <textarea 
                                      id="<?php echo $apo . $ap_per . $ap_gra . $ap_ape ?>"
                                      type="text" class="form-control col-sm-12 customape"
                                      data-tipo="textoaprendizaje"
                                      data-per="<?php echo $ap_per ?>"
                                      data-gra="<?php echo $ap_gra ?>"
                                      data-apo="<?php echo $ap_apo ?>"
                                      data-ape="<?php echo $ap_ape ?>"
                                      data-mat="<?php echo $materia ?>"
                                      placeholder="No se econtraron registros"
                                    ><?php echo $ap_des ?></textarea><br>
  
                                <?php }
  
                                }

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

  function desModal(mat, gra) {

    var modalContainer = document.getElementById('modal-container');
    modalContainer.innerHTML = '';

    (async () => {

      const data = {
        cmd: "sqlap",
        user_id: logId,
        mat: mat,
        gra: gra
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
          banco.forEach(function(apDesc) {

            let div = document.createElement('div');
            div.className = 'col-sm-12';

            let formGroup = document.createElement('div');
            formGroup.className = 'form-group';

            let p = document.createElement('p');
            p.style.cursor = 'pointer';
            p.onclick = function() {
              cambiaForta('');
            };

            let contentText = document.createTextNode(apDesc);
            let hr = document.createElement('hr');

            p.appendChild(contentText);
            p.appendChild(hr);
            formGroup.appendChild(p);
            div.appendChild(formGroup);
            modalContainer.appendChild(div);

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

  
</script>