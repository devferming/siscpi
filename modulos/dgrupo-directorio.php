<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once  SESIONES;

if ($_SESSION['nivel'] == 6 || $_SESSION['nivel'] == 3) :
  require_once FUNCIONES;
  // Templates
  require_once HEADER;
  require_once BARRA;
  require_once NAVEGACION;
  // Modulo
  $datos = $_GET['data'];
  $datos = unserialize($datos);
  $gra = $datos['gra'];
  if ($gra !== 'dgrupo') {
    $dgrupo = $gra ;
    $dgrupo_sec = $datos['sec']; ;
  } else {
    $dgrupo = $_SESSION['datos']['pro_dgr'];
    $dgrupo_sec = $_SESSION['datos']['pro_dgs'];
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
              DIRECCIÓN DE GRUPO
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
            <h3 class="card-title">Directorio: <strong><?php echo $dgrupo.' ('.$dgrupo_sec.')'; ?></strong></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="mat-lista" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Alumno</th>
                  <th>Contacto</th>
                  <th>Acudiente</th>
                  <th>Madre</th>
                  <th>Padre</th>
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

                while ($datos = $result->fetch_assoc()) {
                  $datos_alum = json_decode($datos['datos'], true);
                  $id_alum = $datos['id'];
                  $grado = $datos_alum['gra_esc'];

                  $dgrupo2 = $dgrupo;

                  if ($dgrupo === 'JARDÍN') {
                    $dgrupo2 = 'PRE JARDÍN';
                  }

                  if (($grado == $dgrupo OR $grado == $dgrupo2) && $datos_alum['gra_sec'] === $dgrupo_sec) { ?>

                    <tr>
                      <td>
                        <?php echo $datos_alum['per_ape'] . ' ' . $datos_alum['per_nom']. '<br>'; ?>
                        <?php echo '<strong>Doc: </strong>' . $datos_alum['ide_tip'].' '.$datos_alum['ide_num'] . '<br>'; ?>
                        <?php echo '<strong>Fecha N: </strong>' . $datos_alum['nac_fec'] . '<br>'; ?>
                      </td>


                      <td>

                        <?php echo '<strong>Dir: </strong>' . $datos_alum['dir_dir'] . '<br>';
                        echo '<strong>Celular: </strong>' . $datos_alum['tel_mov'] . '<br>';
                        ?>
                      </td>
                      <td>
                        <p>

                          <?php
                          echo $datos_alum['acu_nom'] . '<br>';
                          echo '<strong>Celular: </strong>' . $datos_alum['acu_cel'] . '<br>';
                          
                          echo '<strong>Ocupación: </strong>' . $datos_alum['acu_ocu'] . '<br>';
                          ?>
                        </p>
                      </td>

                      <td>
                        <p>
                          <?php
                          echo $datos_alum['mad_nom'] . '<br>';
                          echo '<strong>Celular: </strong>' . $datos_alum['mad_cel'] . '<br>';
                          echo '<strong>Ocupación: </strong>' . $datos_alum['mad_ocu'] . '<br>';
                          ?>
                        </p>
                      </td>

                      <td>
                        <p>

                          <?php
                          echo $datos_alum['pad_nom'] . '<br>';
                          echo '<strong>Celular: </strong>' . $datos_alum['pad_cel'] . '<br>';
                          
                          echo '<strong>Ocupación: </strong>' . $datos_alum['pad_ocu'] . '<br>';
                          ?>
                        </p>
                      </td>
                    </tr>

                <?php
                  }
                };
                $conn->close();
                ?>

              </tbody>
              <tfoot>
                <tr>
                  <th>Alumno</th>
                  <th>Contacto</th>
                  <th>Acudiente</th>
                  <th>Madre</th>
                  <th>Padre</th>
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

<?php
  // Footer
  require_once FOOTER;
endif;
?>