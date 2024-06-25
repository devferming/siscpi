<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once  SESIONES;

if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 5) :

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

  <script>
    const logId = <?php echo json_encode($_SESSION['logid']); ?>;
    const modelo = '../modelos/matricula-modelo.php'
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
              GESTIÓN DE MATRICULAS
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
            <h3 class="card-title">Alumnos matriculados en grado <strong><span><?php echo $grado_desc; ?></span></strong></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="mat-lista" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Nombre y Apellido</th>
                  <th>N° Documento</th>
                  <th>Grado</th>
                  <th>Estatus</th>
                  <th>Acciones</th>
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

                while ($datos_alum = $result->fetch_assoc()) {

                  $id = $datos_alum['id'];
                  $datos = json_decode($datos_alum['datos'], true);

                  $rev_est = isset($datos['estatus']) ? $datos['estatus'] : 'NO ESPESIFICADO';

                  if ($datos['gra_esc'] == $grado_desc) { ?>

                    <tr style="background: <?php echo $rev_est === 'MATRICULADO' ? '#fff' : '#ffafaf"'; ?>">
                      <td>
                        <?php echo $datos['per_ape'] . ' ' . $datos['per_nom'] ?>
                      </td>
                      <td>
                        <?php echo $datos['ide_num']; ?>
                      </td>
                      <td>
                        <?php echo $datos['gra_esc'] . ' (' . $datos['gra_sec'] . ')'; ?>
                        <div class="btn-group">
                          <button type="button" class="btn btn-success dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="true">
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <div class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(68px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <button type="button" class="dropdown-item" onclick="changeSection(<?php echo $id ?>, 'A')">Sección A</button>
                            <button type="button" class="dropdown-item" onclick="changeSection(<?php echo $id ?>, 'B')">Sección B</button>
                            <button type="button" class="dropdown-item" onclick="changeSection(<?php echo $id ?>, 'C')">Sección C</button>
                            <button type="button" class="dropdown-item" onclick="changeSection(<?php echo $id ?>, 'U')">Sección U</button>
                          </div>
                        </div>
                      </td>
                      <td>
                        <?php echo $rev_est ?>
                      </td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-success dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="true">
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <div class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(68px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <a class="dropdown-item" href="matricula-nueva.php?id=<?php echo $id ?>&atc=1">Ficha</a>
                            <button type="button" class="dropdown-item btn-mat-pdf" value="<?php echo $id ?>" data-uid="<?php echo $_SESSION['logid'] ?>" data-per="1" data-gra="<?php echo $grado ?>" data-sec="<?php echo $datos['gra_sec']?>">Boletín 1°</button>
                            <button type="button" class="dropdown-item btn-mat-pdf" value="<?php echo $id ?>" data-uid="<?php echo $_SESSION['logid'] ?>" data-per="2" data-gra="<?php echo $grado ?>" data-sec="<?php echo $datos['gra_sec']?>">Boletín 2°</button>
                            <button type="button" class="dropdown-item btn-mat-pdf" value="<?php echo $id ?>" data-uid="<?php echo $_SESSION['logid'] ?>" data-per="3" data-gra="<?php echo $grado ?>" data-sec="<?php echo $datos['gra_sec']?>">Boletín 3°</button>
                            <button type="button" class="dropdown-item btn-mat-pdf" value="<?php echo $id ?>" data-uid="<?php echo $_SESSION['logid'] ?>" data-per="4" data-gra="<?php echo $grado ?>" data-sec="<?php echo $datos['gra_sec']?>">Boletín 4°</button>
                            <button type="button" class="dropdown-item btn-mat-pdf5" value="<?php echo $id ?>" data-uid="<?php echo $_SESSION['logid'] ?>" data-per="4" data-gra="<?php echo $grado ?>">Informe Final</button>
                            <button type="button" class="dropdown-item" onclick="changeStatus(<?php echo $id ?>, '<?php echo $rev_est === 'MATRICULADO' ? 'Retirar' : 'Matricular' ?>')">
                              <?php
                              echo $rev_est === 'MATRICULADO' ? 'Retirar' : 'Matricular';
                              ?>
                            </button>
                            <!-- <button type="button" class="dropdown-item" onclick="deleteAlum(<?php echo $id ?>)">
                              Eliminar
                            </button> -->
                          </div>
                        </div>
                      </td>
                    </tr>


                <?php
                  }
                };
                $conn->close()
                ?>


              </tbody>
              <tfoot>
                <tr>
                  <th>Nombre y Apellido</th>
                  <th>N° Documento</th>
                  <th>Grado</th>
                  <th>Estatus</th>
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


<script>
  const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 2000,
  });

  async function changeSection(idAlum, newSecc) {

    const data = {
      cmd: "seccion-nueva",
      idAlum: idAlum,
      newSecc: newSecc,
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

        window.location.reload();

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


  async function changeStatus(idAlum, newStatus) {

    const data = {
      cmd: "nuevo-estatus",
      idAlum: idAlum,
      newStatus: newStatus,
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

        window.location.reload();

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

  async function deleteAlum(idAlum) {

    const data = {
      cmd: "eliminar-alum",
      idAlum: idAlum,
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

        window.location.reload();

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
</script>