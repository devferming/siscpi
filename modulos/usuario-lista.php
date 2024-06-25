<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once  SESIONES;

if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2 || $_SESSION['nivel'] == 5) :
  require_once FUNCIONES;
  // Templates
  require_once HEADER;
  require_once BARRA;
  require_once NAVEGACION;

  // Modulo



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
              Gestión de Usuarios
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
            <h3 class="card-title">Usuarios registrados actualmente</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="mat-lista" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Rol</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php

                try {
                  $stmt = $conn->prepare("SELECT * FROM siscpi_users");
                  $stmt->execute();
                  $result = $stmt->get_result();
                } catch (\Exception $e) {
                  $error = $e->getMessage();
                  echo $error;
                }

                while ($datos = $result->fetch_assoc()) {
                  $datos_user = json_decode($datos['datos'], true);
                  $id_user = $datos['id']; ?>

                    <tr>
                      <td>
                        <?php echo $datos_user['per_ape'] . ' ' . $datos_user['per_nom'] . '<br>'; ?>
                        <?php echo '<strong>Doc: </strong>' . $datos_user['ide_tip'] . ' ' . $datos_user['ide_num'] . '<br>'; ?>
                        <?php echo '<strong>Fecha N: </strong>' . $datos_user['nac_fec'] . '<br>'; ?>
                      </td>


                      <td>
                        <?php echo $datos_user['use_rol'] ?>
                      </td>

                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-success dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="true">
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <div class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(68px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <a class="dropdown-item" href="usuario-nuevo.php?id=<?php echo $id_user ?>&atc=1">Ficha</a>

                            <!-- <button type="button" class="dropdown-item" onclick="deleteAlum(<?php //echo $id ?>)">
                              Eliminar
                            </button> -->
                          </div>
                        </div>
                      </td>
                    </tr>

                <?php
                };
                $conn->close();
                ?>

              </tbody>
              <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Rol</th>
                  <th>Acciones</th>
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