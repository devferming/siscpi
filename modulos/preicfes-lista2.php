<?php $nivel = 2;
require_once '../funciones/configuracion.php';
require_once  SESIONES;
  
  date_default_timezone_set('America/Bogota');

if ($_SESSION['nivel'] == 8) :

  require_once FUNCIONES;
  // Templates
  require_once HEADER;
  require_once BARRA;
  require_once NAVEGACION;
  //$code = $_GET['code'];
  //$materia = $_GET['materia'];

  $grado_desc = $_SESSION['datos']['gra_esc'];
  $id_login = $_SESSION['logid'];

  try {
    $stmt = $conn->prepare("SELECT * FROM siscpi_alumnos WHERE id_login=?");
    $stmt->bind_param("i", $id_login);
    $stmt->execute();
    $predatos = $stmt->get_result();
    $datos = $predatos->fetch_assoc();
    $temp_dat = json_decode($datos['datos'], true);
    $alum_idx2 = $datos['id'];
  
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
              <i class="fa fa-user-plus"></i>
              Tus Simulacros
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!--<li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Matricula nueva</li>-->
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
                <h3 class="card-title">Simulacros publicados<strong></strong></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
        <table id="asig-lista" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Asignación</th>
                <th>Fecha</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <!-- :::: ASIGNACIONES PUBLICADAS :::: -->
              <?php
                    try {
                      $stmt = $conn->prepare("SELECT * FROM siscpi_simulacros WHERE simul_grado=?");
                      $stmt->bind_param("s", $grado_desc);
                      $stmt->execute();
                      $resultado = $stmt->get_result();
                    } catch (\Exception $e) {
                        $error = $e->getMessage();
                        echo $error;
                    }
                    while($datos_guia = $resultado->fetch_assoc()){ ?>
              <tr>
                <td>
                  <p>Simulacro #<?php echo $datos_guia['simul_orden'];?>
                  
                  <?php
                    $id_simul = $datos_guia['simul_id'];
                    try {
                      $stmt = $conn->prepare("SELECT simule_status FROM siscpi_simulacros_e WHERE simule_simul_id=? AND simule_alum_id=?");
                      $stmt->bind_param("ii", $id_simul, $alum_idx2);
                      $stmt->execute();
                      $resultado_subidas = $stmt->get_result();
                      $datos_entrega = $resultado_subidas->fetch_assoc();
                    } catch (\Exception $e) {
                        $error = $e->getMessage();
                        echo $error;
                    } 
                      if (isset($datos_entrega['simule_status']) ? $datos_entrega['simule_status'] == 2 : 0) { ?>
                        <span class="badge badge-success">Entregado</span></p>
                      <?php  
                      } else { ?>
                        <span class="badge badge-warning">No entregado</span></p>
                      <?php  
                      }
                      ?>
                    
                </td>
                <td>
                  <?php
                  $nac_fec1 = $datos_guia['simul_fecha'];
                  $nac_fec = DateTime::createFromFormat('Y-m-d', $nac_fec1)->format('d-m-Y'); 
                  ?>
                      
                  <p><?php echo $nac_fec;?></p>
                </td>
                <td>
                  <div class="btn-group" md5>
                    <button type="button" class="btn btn-success dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="true">
                      <span>Opciones</span>
                    </button>
                    <div class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(68px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="preicfes-param2.php?id=<?php echo 	$datos_guia['simul_id'] ?>">Explorar</a>
                        
                        <?php
                          $hoy = date("Y-m-d");
                          
                          $fecha_actual = strtotime(date("d-m-Y"));
                          $fecha_entrada = strtotime($nac_fec);
                          if ($fecha_actual > $fecha_entrada) { ?>
                            <a class="dropdown-item" href="preifces-entregas2.php?simul_id=<?php echo $datos_guia['simul_id']?>&id=<?php echo $alum_idx2 ?>">Resultados</a>
                            <?php
                          }
                        ?>
                        <!--<a class="dropdown-item" href="#">Analizar</a>-->
                    </div>
                  </div>
                </td>
              </tr>
              <?php };
              $conn->close();
              $stmt->close();
              ?>
              <!-- :::: /ASIGNACIONES PUBLICADAS :::: -->
            </tbody>
            <tfoot>
              <tr>
                <th>Asignación</th>
                <th>Fecha</th>
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
