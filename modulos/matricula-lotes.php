<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once  SESIONES;


if ($_SESSION['nivel'] == 1) :

  require_once FUNCIONES;

  // Templates
  require_once HEADER;
  require_once BARRA;
  require_once NAVEGACION;

  $grado = $_GET['grado'];

  if (!filter_var($grado, FILTER_VALIDATE_INT)) {
    die("ERROR!");
  };

  try {
    $stmt = $conn->prepare("SELECT gdo_des_grado FROM siscpi_grados WHERE gdo_cod_grado=?");
    $stmt->bind_param("i", $grado);
    $stmt->execute();
    $result = $stmt->get_result();
    $datos = $result->fetch_assoc();
    $grado_desc = $datos['gdo_des_grado'];
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
              MATRÍCULA POR LOTES
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
            <h3 class="card-title">Alumnos matriculados en grado <strong><span><?php echo $grado_desc; ?></span></strong></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="mat-lista" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Apellido y nombre</th>
                  <th>N° Documento</th>
                  <th>2022</th>
                  <th>2023</th>
                </tr>
              </thead>
              <tbody>
                <?php
                try {
                  $stmt2 = $conn->prepare("SELECT * FROM alumnos WHERE alum_grado=?");
                  $stmt2->bind_param("s", $grado_desc);
                  $stmt2->execute();
                  $resultado2 = $stmt2->get_result();
                } catch (\Exception $e) {
                  $error = $e->getMessage();
                  echo $error;
                }
                while ($datos_alum = $resultado2->fetch_assoc()) { ?>
                  <tr>
                    <td>
                      <?php echo $datos_alum['alum_1er_apellido'], " ", $datos_alum['alum_1er_nombre']; ?>
                    </td>
                    <td>
                      <?php echo $datos_alum['alum_doc_numero']; ?>
                    </td>
                    <td>
                      <?php echo $datos_alum['alum_grado']; ?>
                    </td>
                    <td>
                      <?php if ($datos_alum['alum_id_nuevo'] > 0) {
                      ?>
                        Matriculado
                      <?php
                      } else {
                      ?>
                        <div class="input-group">
                          <label>
                            <input type="checkbox" class="chkBox form-control" name="m2023-<?php echo $datos_alum['alum_id'] ?>" id="m2023-<?php echo $datos_alum['alum_id'] ?>" value=0 data-idalum="<?php echo $datos_alum['alum_id'] ?>">
                          </label>
                        </div>
                      <?php
                      } ?>
                    </td>
                  </tr>
                <?php };
                $conn->close();
                ?>

              </tbody>
              <tfoot>
                <tr>
                  <th>Apellido y Nombre</th>
                  <th>N° Documento</th>
                  <th>2022</th>
                  <th>2023</th>
                </tr>
              </tfoot>
            </table>
            <input type="hidden" id="userId" data-usid="<?php echo $_SESSION['logid'] ?>">
          </div>
          <!-- /.card-body -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <button class="btn btn-success btn-floating btn-translucent btn-custom-flotante" id="matricularLoteBtn" style="position: fixed; bottom: 0; right: 0; margin-bottom: 25px;
    margin-right: 25px;">
      <i class="fas fa-check"></i>
    </button>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
  // Footer
  require_once FOOTER;
endif;

?>