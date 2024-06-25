<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once  SESIONES;

if ($_SESSION['nivel'] == 6) :
  require_once FUNCIONES;
  // Templates
  require_once HEADER;
  require_once BARRA;
  require_once NAVEGACION;

  $datos = $_GET['data'];
  $datos = unserialize($datos);
  $per = $datos['d1'];
  $grado_desc = $_SESSION['datos']['pro_dgr'];
  $dgrupo_sec = $_SESSION['datos']['pro_dgs'];

  if (!filter_var($per, FILTER_VALIDATE_INT)) {
    die("ERROR!");
  };

  if (isset(GRADOS_COD[$grado_desc])) {
    $grad_cod = GRADOS_COD[$grado_desc];

    if (isset(GRADOS[$grad_cod])) {
      [$gra, $sec, $log] = GRADOS[$grad_cod];
    }
  }

  try {

    $stmt = $conn->prepare("SELECT ped_des_periodo FROM siscpi_periodos WHERE ped_cod_periodo=?");
    $stmt->bind_param("i", $per);
    $stmt->execute();
    $resultado2 = $stmt->get_result();
    $descripcion2 = $resultado2->fetch_assoc();
    $periodo = $descripcion2['ped_des_periodo'];
  } catch (\Exception $e) {
    $error = $e->getMessage();
    echo $error;
  }

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              <i class="fa fa-users-cog"></i>
              INDICADORES DE CONVIVENCIA
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
            <h3 class="card-title">Grado: <strong><?php echo $grado_desc.' ('.$dgrupo_sec.') '; ?></strong>Periodo: <strong><?php echo $periodo; ?></strong></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="tablageneral" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Estudiante</th>
                  <th>Indicador</th>
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

                while ($row  = $result->fetch_assoc()) {
                  $dat_alum = json_decode($row['datos'], true); //Obtiene todos los datos del alumno
                  $ida = $row['id']; //Obtiene el ID del alumno
                  $nom_alum = $dat_alum['per_ape'] . " " . $dat_alum['per_nom'];

                  $dgrupo2 = $grado_desc;

                  if ($grado_desc === 'JARDÍN') {
                    $dgrupo2 = 'PRE JARDÍN';
                  }

                  if (($dat_alum['gra_esc'] == $grado_desc OR $dat_alum['gra_esc'] == $dgrupo2) && $dat_alum['gra_sec'] === $dgrupo_sec) {

                    $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
                    $stmt->bind_param("i", $ida);
                    $stmt->execute();
                    $notas_resultado = $stmt->get_result();
                    $convivencia = 0;

                    try {
                        if ($notas_resultado->num_rows > 0) {
                          $notas_detalle = $notas_resultado->fetch_assoc();
                          $notas = json_decode($notas_detalle['datos'], true);

                          $convivencia = isset($notas["p-" . $per]['ncv']) ? $notas["p-" . $per]['ncv'] : 0;
                          $convivencia1 = isset($notas["p-" . $per]['dcv']) ? $notas["p-" . $per]['dcv'] : 0;
                          $convivencia2 = isset($notas["p-" . $per]['dcv2']) ? $notas["p-" . $per]['dcv2'] : 0;
                          $convivencia3 = isset($notas["p-" . $per]['dcv3']) ? $notas["p-" . $per]['dcv3'] : 0;

                          $cnv1_id = 0;
                        } else {
                          $convivencia = 0;
                          $cnv1_id = 0;
                        }
                      } catch (\Exception $e) {
                      $error = $e->getMessage();
                      echo $error;
                    }
                    
                    $final_convivencia = number_format((float)$convivencia, 1, '.', '');
                    isset(RENDIMIENTOS[$sec]) ? [$rendimiento, $bandera, $cualitativo] = RENDIMIENTOS[$sec][$final_convivencia] : 0;
                    
                    
                    if ($convivencia1 > 0) {
                      $stmt = $conn->prepare("SELECT * FROM siscpi_iconvivencia WHERE notas_convivencia_id =?");
                      $stmt->bind_param("i", $convivencia1);
                      $stmt->execute();
                      $result_ncv1 = $stmt->get_result();
                      $result_desc = $result_ncv1->fetch_assoc();
                      $convi_desc = $result_desc['notas_convivencia_descripcion'];
                    } else {
                      $convi_desc = "Sin registros";
                    }
                    
                    if ($convivencia2 > 0) {
                      $stmt = $conn->prepare("SELECT * FROM siscpi_iconvivencia WHERE notas_convivencia_id =?");
                      $stmt->bind_param("i", $convivencia2);
                      $stmt->execute();
                      $result_ncv2 = $stmt->get_result();
                      $result_desc2 = $result_ncv2->fetch_assoc();
                      $convi_desc2 = $result_desc2['notas_convivencia_descripcion'];
                    } else {
                      $convi_desc2 = "Sin registros";
                    }

                    if ($convivencia3 > 0) {
                      $stmt = $conn->prepare("SELECT * FROM siscpi_iconvivencia WHERE notas_convivencia_id =?");
                      $stmt->bind_param("i", $convivencia3);
                      $stmt->execute();
                      $result_ncv3 = $stmt->get_result();
                      $result_desc3 = $result_ncv3->fetch_assoc();
                      $convi_desc3 = $result_desc3['notas_convivencia_descripcion'];
                    } else {
                      $convi_desc3 = "Sin registros";
                    }
                    

                    ?>

                    <tr>
                      <td>
                        <i class="fas fa-user"></i><?php echo  $dat_alum['per_ape'] . " " . $dat_alum['per_nom']; ?>

                        <span class="badge badge-pill badge-<?php echo $bandera ?> zoom" style="cursor:pointer;" onclick="modalConvi('<?php echo $ida ?>', '<?php echo $periodo ?>', '<?php echo $nom_alum ?>')" id="btnconvi-a<?php echo $ida ?>"> Def: <?php echo $final_convivencia ?></span><br>

                      </td>

                      <td class="col-sm-9">

                        <strong style="cursor:pointer"><span style="color: blue" onclick="desModal('<?php echo $ida ?>', 'forta', 'dcv')">DESC 1: </span></strong>
                        <span id="des-forta-1-<?php echo $ida ?>"><?php echo $convi_desc ?></span>
                        <br>

                        <strong style="cursor:pointer"><span style="color: #6C757D" onclick="desModal('<?php echo $ida ?>', 'forta', 'dcv2')">DESC 2 (opcional): </span></strong>
                        <span id="des-forta-2-<?php echo $ida ?>"><?php echo $convi_desc2 ?></span>
                        <br>

                        <strong style="cursor:pointer"><span style="color: blue" onclick="desModal('<?php echo $ida ?>', 'forta', 'dcv3')">DESC 3 (Padres): </span></strong>
                        <span id="des-forta-3-<?php echo $ida ?>"><?php echo $convi_desc3 ?></span>

                      </td>
                    </tr>

                    <?php
                  }

                  ?>


                  <?php
                };
                ?>

              </tbody>
              <tfoot>
                <tr>
                  <th>Estudiante</th>
                  <th>Indicador</th>
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

  <div class="modal fade" id="modal-forta">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><small><strong><i class="fas fa-user"></i><span>Banco de indicadores de Convivencia</span></strong></small></h5>
          <h6></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">


          <div class="row">

            <?php

            $stmt = $conn->prepare("SELECT * FROM siscpi_iconvivencia");
            //$stmt->bind_param("i", $grado);
            $stmt->execute();
            $banco_desc2 = $stmt->get_result();

            while ($banco = $banco_desc2->fetch_assoc()) {

              if ($banco['notas_convivencia_descripcion'] !== 'N/A') { ?>

                <div class="col-sm-12">
                  <div class="form-group">
                    <p style="cursor:pointer; background-color: #87cefa4a" onclick="cambiaForta('<?php echo $banco['notas_convivencia_descripcion'] ?>', '<?php echo $banco['notas_convivencia_id'] ?>')">
                      <?php echo $banco['notas_convivencia_descripcion'] ?>
                      <hr>
                    </p>
                  </div>
                </div> <!-- col -->


            <?php
              }
            }


            ?>

            <input type="hidden" id="idalum-forta" value="">
            <input type="hidden" id="indice-forta" value="">

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

            <input type="hidden" id="idalum-convi" value="">
            <input type="hidden" id="perlum-convi" value="">
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

  function modalConvi(ida, per, alu) {

    $('#modal-convi-alumno').text(alu);
    $('#idalum-convi').val(ida);
    $('#perlum-convi').val(per);
    $('#modal-convi').modal();

  }

  async function regConvi() {
    const response = await fetch("../modelos/notas-modelo.php", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        ida: $('#idalum-convi').val(),
        not: $('#cal-convi').val(),
        per: '<?php echo $per ?>',
        user_id: '<?php echo json_encode($_SESSION['logid']); ?>',
        sec: '<?php echo $sec ?>',
        gra: '<?php echo $gra ?>',
        cmd: 'regconv'
      })
    });

    const data = await response.json();

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 8000
    });

    if (data.respuesta === 'exito') {
      Toast.fire({
        icon: 'success',
        title: data.comentario
      });

      $('#btnconvi-a' + data.ida).text('Def: '+data.not);
      $('#modal-convi').modal('hide');
      $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:none;');

      const element = document.querySelector(`#btnconvi-a${data.ida}`);
      element.className = '';
      element.classList.add('badge', 'badge-pill', `badge-${data.bandera}`, 'zoom');

    } else {
      Toast.fire({
        icon: 'error',
        title: data.comentario
      });
      $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:none;');
    }
  }

  async function cambiaForta(desc, id) {
    const ide_alum = document.querySelector('#idalum-forta').value;
    const per = <?= $per ?>;
    const ind2 = document.querySelector('#indice-forta').value;

    try {
      const response = await fetch("../modelos/notas-modelo.php", {
        method: 'POST',
        body: JSON.stringify({
          'cmd': 'actconv',
          'ide': id,
          'ida': ide_alum,
          'per': per,
          'ind': ind2,
          'user_id': '<?php echo json_encode($_SESSION['logid']); ?>'
        })
      });

      if (response.ok) {
        const resultado = await response.json();
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 8000
        });

        if (resultado.respuesta == 'exito') {
          document.querySelector('#des-forta-' + resultado.orden + '-' + ide_alum).textContent = desc;

          Toast.fire({
            icon: 'success',
            title: resultado.comentario
          });

          $('#modal-forta').modal('hide');

        } else {
          Toast.fire({
            icon: 'error',
            title: resultado.comentario
          });

          $('#modal-forta').modal('hide');

        }
      } else {
        throw new Error('Error en la solicitud');
      }
    } catch (error) {
      console.error(error);
    }
  }

  function notaConvivencia(soc, esp, mat, nat, ing, inf, art, etc, mus, dep, alu) {

    $('#modal-convi-alumno').text(alu);

    $('#conv-soc').text(' - ' + soc);
    $('#conv-esp').text(' - ' + esp);
    $('#conv-mat').text(' - ' + mat);
    $('#conv-nat').text(' - ' + nat);
    $('#conv-ing').text(' - ' + ing);
    $('#conv-inf').text(' - ' + inf);
    $('#conv-art').text(' - ' + art);
    $('#conv-etc').text(' - ' + etc);
    $('#conv-mus').text(' - ' + mus);
    $('#conv-dep').text(' - ' + dep);

    $('#modal-convi').modal();

  }

  function desModal(ida, tipo, ind) {

    $('#idalum-' + tipo).val(ida);
    $('#indice-' + tipo).val(ind);
    $('#modal-' + tipo).modal();
  }
</script>