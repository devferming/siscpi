<?php
  include_once 'funciones/sesiones.php';
  include_once 'funciones/funciones.php';
  if($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2):
  include_once 'templates/header.php';
  include_once 'templates/barra.php';
  include_once 'templates/navegacion.php';
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
              USUARIOS REGISTRADOS 
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Matricula</a></li>
              <li class="breadcrumb-item active">Matriculados</li>
            </ol>
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
                <h3 class="card-title">Usuarios (No estudiantes) registrados en el sistema</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="mat-lista" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nombre y Apellido</th>
                    <th>Rol</th>
                    <th>Asignatura</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    try {
                      $rol = 'ESTUDIANTE';
                      $stmt = $conn->prepare("SELECT users_id, users_1er_nombre, users_1er_apellido, users_rol, users_asignatura, users_dgrupo, users_id_logins FROM usuarios WHERE users_rol !=?");
                      $stmt->bind_param("s", $rol);
                      $stmt->execute();
                      $resultado = $stmt->get_result();
                    } catch (\Exception $e) {
                        $error = $e->getMessage();
                        echo $error;
                    }
                    while($datos = $resultado->fetch_assoc()){ ?>
                  <tr>
                    <td>
                      <?php echo $datos['users_1er_nombre']," ",$datos['users_1er_apellido'];?>
                    </td>
                    <td>
                      <?php echo $datos['users_rol'];?>
                    </td>
                    <td>
                      <?php echo $datos['users_asignatura'];?>
                    </td>
                    <td>
                    <?php
                    $id_login = $datos['users_id_logins'];
                    ?>
                    <?php echo $datos['users_dgrupo'];?>
                    </td>
                    <td>
                      <div class="btn-group">
                      <button type="button" class="btn btn-success dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="true">
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <div class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(68px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="usuario-actualizar.php?id=<?php echo $datos['users_id_logins'];?>">Ficha</a>
                        <a class="dropdown-item logins_form" id_log="<?php echo $id_login?>" onclick="desplegar(<?php echo $id_login?>);">Logín</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <?php };
                  $conn->close();
                  ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Nombre y Apellido</th>
                    <th>Rol</th>
                    <th>Asignatura</th>
                    <th>Dirección</th>
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
    include_once 'templates/footer.php';
    endif;
  ?> 
