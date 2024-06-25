<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once  SESIONES;

if ($_SESSION['nivel'] == 3 || $_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 6) :
  require_once FUNCIONES;
  // Templates
  require_once HEADER;
  require_once BARRA;
  require_once NAVEGACION;

  $datos = $_GET['data'];
  $datos = unserialize($datos);
  $per = $datos['d1'];
  $grado_desc = $datos['d2'];
  $grado_sec = $datos['d3'];

  if (!filter_var($per, FILTER_VALIDATE_INT)) {
    die("ERROR!");
  };

  if (isset(GRADOS_COD[$grado_desc])) {
    $grad_cod = GRADOS_COD[$grado_desc];

    if (isset(GRADOS[$grad_cod])) {
      [$gra, $sec, $log] = GRADOS[$grad_cod];
    }
  }

  $crr_mat = $_SESSION['datos']['pro_mat'];

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
              Gestión de notas ICFES
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
            <h3 class="card-title">Grado: <strong><span><?php echo $grado_desc . '(' . $grado_sec . ')'; ?></span></strong> &nbsp Periodo: <strong><span><?php echo $periodo; ?></span></strong></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="tablageneral" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Estudiante</th>
                  <th>SOC</th>
                  <th>ESP</th>
                  <th>MAT</th>
                  <th>NAT</th>
                  <th>ING</th>
                  <th>DEF</th>
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

                foreach ($alumnos as $alumno) {
                  $dat_alum = $alumno['datos']; //Obtiene todos los datos del alumno
                  $ida = $alumno['id']; //Obtiene el ID del alumno
                  $nom_alum = $dat_alum['per_ape'] . " " . $dat_alum['per_nom'];

                  if ($dat_alum['gra_esc'] == $grado_desc && $dat_alum['gra_sec'] === $grado_sec) {

                    $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
                    $stmt->bind_param("i", $ida);
                    $stmt->execute();
                    $notas_resultado = $stmt->get_result();
                    $notas_detalle = $notas_resultado->fetch_assoc();
                    $notas = json_decode($notas_detalle['datos'], true);

                    $icf = number_format(isset($notas["p-" . $per]['icf']) ? $notas["p-" . $per]['icf'] : 0);
                    $icf_soc = number_format(isset($notas["p-" . $per]['icf_soc']) ? $notas["p-" . $per]['icf_soc'] : 0);
                    $icf_esp = number_format(isset($notas["p-" . $per]['icf_esp']) ? $notas["p-" . $per]['icf_esp'] : 0);
                    $icf_mat = number_format(isset($notas["p-" . $per]['icf_mat']) ? $notas["p-" . $per]['icf_mat'] : 0);
                    $icf_nat = number_format(isset($notas["p-" . $per]['icf_nat']) ? $notas["p-" . $per]['icf_nat'] : 0);
                    $icf_ing = number_format(isset($notas["p-" . $per]['icf_ing']) ? $notas["p-" . $per]['icf_ing'] : 0);


                    if ($icf >= 0 && $icf <= 221) {
                      $rendimiento = 'INSUFICIENTE';
                      $bandera = 'danger';
                      $color = '#dc3545';
                    } elseif ($icf >= 222 && $icf <= 325) {
                      $rendimiento = 'BÁSICO';
                      $bandera = 'warning';
                      $color = '#ffc107';
                    } elseif ($icf >= 326 && $icf <= 437) {
                      $rendimiento = 'SATISFÁCTORIO';
                      $bandera = 'success';
                      $color = '#28a745';
                    } elseif ($icf >= 438) {
                      $rendimiento = 'AVANZADO';
                      $bandera = 'dark';
                      $color = '#343a40';
                    }

                ?>

                    <tr>
                      <td>
                        <i class="fas fa-user"></i><?php echo  ' ' . $dat_alum['per_ape'] . " " . $dat_alum['per_nom']; ?>
                      </td>
                      <td>
                        <?php
                        if (in_array('SOCIALES', $crr_mat) OR $_SESSION['logid'] == 38) { ?>
                          <span class="badge badge-pill zoom" style="cursor:pointer; background-color: #6C757D; color: white;" onclick="modalIcfe(
                            '<?php echo $ida ?>',
                            '<?php echo $periodo ?>',
                            '<?php echo $nom_alum ?>',
                            '<?php echo 'soc' ?>',
                            '<?php echo $icf_soc ?>'
                          )" id="not-soc-<?php echo $ida ?>">
                            <?php echo $icf_soc ?>
                          </span>
                        <?php
                        } else { ?>
                          <?php echo $icf_soc ?>
                        <?php
                        }
                        ?>

                      </td>
                      <td>
                        <?php
                        if (in_array('ESPAÑOL', $crr_mat) OR $_SESSION['logid'] == 38) { ?>
                          <span class="badge badge-pill zoom" style="cursor:pointer; background-color: #6C757D; color:white;" onclick="modalIcfe(
                            '<?php echo $ida ?>',
                            '<?php echo $periodo ?>',
                            '<?php echo $nom_alum ?>',
                            '<?php echo 'esp' ?>',
                            '<?php echo $icf_esp ?>'
                          )" id="not-esp-<?php echo $ida ?>">
                            <?php echo $icf_esp ?>
                          </span>
                        <?php
                        } else { ?>
                          <?php echo $icf_esp ?>
                        <?php
                        }
                        ?>
                      </td>
                      <td>
                        <?php
                        if (in_array('MATEMÁTICAS', $crr_mat) OR $_SESSION['logid'] == 38) { ?>
                          <span class="badge badge-pill zoom" style="cursor:pointer; background-color: #6C757D; color:white;" onclick="modalIcfe(
                            '<?php echo $ida ?>',
                            '<?php echo $periodo ?>',
                            '<?php echo $nom_alum ?>',
                            '<?php echo 'mat' ?>',
                            '<?php echo $icf_mat ?>'
                          )" id="not-mat-<?php echo $ida ?>">
                            <?php echo $icf_mat ?>
                          </span>
                          </span>
                        <?php
                        } else { ?>
                          <?php echo $icf_mat ?>
                        <?php
                        }
                        ?>
                      </td>
                      <td>
                        <?php
                        if (in_array('NATURALES', $crr_mat) or $_SESSION['logid'] == 38) { ?>
                          <span class="badge badge-pill zoom" style="cursor:pointer; background-color: #6C757D; color:white" onclick="modalIcfe(
                            '<?php echo $ida ?>',
                            '<?php echo $periodo ?>',
                            '<?php echo $nom_alum ?>',
                            '<?php echo 'nat' ?>',
                            '<?php echo $icf_nat ?>',
                          )" id="not-nat-<?php echo $ida ?>">
                            <?php echo $icf_nat ?>
                          </span>
                        <?php
                        } else { ?>
                          <?php echo $icf_nat ?>
                        <?php
                        }
                        ?>
                      </td>
                      <td>
                        <?php
                        if (in_array('INGLÉS', $crr_mat) or $_SESSION['logid'] == 38) { ?>
                          <span class="badge badge-pill zoom" style="cursor:pointer; background-color: #6C757D; color:white" onclick="modalIcfe(
                            '<?php echo $ida ?>',
                            '<?php echo $periodo ?>',
                            '<?php echo $nom_alum ?>',
                            '<?php echo 'ing' ?>',
                            '<?php echo $icf_ing ?>'
                          )" id="not-ing-<?php echo $ida ?>">
                            <?php echo $icf_ing ?>
                          </span>
                        <?php
                        } else { ?>
                          <?php echo $icf_ing ?>
                        <?php
                        }
                        ?>
                      </td>
                      <td>
                        <span class="small" style="color: <?php echo $color ?>; font-size: 0.8rem; font-weight: 500;" id="def-icfes-<?php echo $ida ?>">
                          <?php echo $icf . ' (' . $rendimiento . ')' ?>
                        </span>
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
                  <th>SOC</th>
                  <th>ESP</th>
                  <th>MAT</th>
                  <th>NAT</th>
                  <th>ING</th>
                  <th>DEF</th>
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

  <div class="modal fade" id="icfe-mod">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <small><strong><i class="fas fa-user"></i><?php echo ' ' ?><span id="icfe-alu">Fermin</span></strong></small>
            <small><span id="icfe-alu-span"></span></small>
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
                <label><span class="badge badge-pill">Definitiva ICFES</span></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text badge-warning"><i class="fas fa-edit"></i></span>
                  </div>
                  <input type="text" class="form-control" name="icfes-cal" id="icfes-cal" data-tipo="solonumero">
                </div>
              </div>
            </div> <!-- col -->

            <input type="hidden" id="icfe-ida" value="">
            <input type="hidden" id="icfe-per" value="">
            <input type="hidden" id="icfe-mat" value="">
          </div>
          <!-- /.row -->


        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-success" onClick="regIcfes()">Confirmar</button>
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

  function modalIcfe(ida, per, alu, mat, not) {

    $('#icfe-alu').text(alu);
    $('#icfe-alu-span').text(` - Calificación final ICFES (${mat})`);
    $('#icfe-ida').val(ida);
    $('#icfe-per').val(per);
    $('#icfe-mat').val(mat);
    $('#icfes-cal').val(not)

    $('#icfe-mod').modal();


  }

  async function regIcfes() {

    const crr_mat = $('#icfe-mat').val();

    const response = await fetch("../modelos/notas-modelo.php", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        ida: $('#icfe-ida').val(),
        not: $('#icfes-cal').val(),
        mat: crr_mat,
        per: '<?php echo $per ?>',
        user_id: '<?php echo json_encode($_SESSION['logid']); ?>',
        sec: '<?php echo $sec ?>',
        gra: '<?php echo $gra ?>',
        cmd: 'regicfes'
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

      $(`#not-${crr_mat}-${data.ida}`).text(data.not);
      $('#icfe-mod').modal('hide');
      $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:none;');

      /*  const element = document.querySelector(`#def-icfes-${data.ida}`);
       element.className = '';
       element.classList.add('badge', 'badge-pill', `badge-${data.bandera}`, 'zoom'); */

      const element = document.querySelector(`#def-icfes-${data.ida}`);
      console.log(element)
      element.textContent = `${data.def} (${data.rendimiento})`
      element.style.color = data.color;
      //element2.textContent = data.rendimiento;

    } else {
      Toast.fire({
        icon: 'error',
        title: data.comentario
      });
      $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:none;');
    }
  }
</script>