<?php $nivel = 2;

require_once '../funciones/configuracion.php';

require_once FUNCIONES;

// Templates
require_once HEADER;
//require_once BARRA;
//require_once NAVEGACION;


try {
  $id_elec = 2;
  $stmt = $conn->prepare("SELECT * FROM siscpi_elecciones WHERE id=?");
  $stmt->bind_param("i", $id_elec);
  $stmt->execute();
  $result = $stmt->get_result();
  $datos_stmt = $result->fetch_assoc();
  $conte = json_decode($datos_stmt['conteo'], true);
} catch (\Exception $e) {
  $error = $e->getMessage();
  echo $error;
}

$opcion1 = $conte['can_uno'];
$opcion2 = $conte['can_dos'];
$opcion3 = $conte['vot_nul'];
$participacion = $opcion1 + $opcion2 + $opcion3;


?>

<body class="layout-top-nav layout-navbar-fixed " style="height: auto;">


  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light border-bottom-0">
      <div style="display: flex;
      justify-content: center;
      align-content: center;
      width: 100%;">
        <button type="button" class="btn btn-success" onclick="reloadPage()">ACTUALIZAR</button>
      </div>

    </nav>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">


            <div class="col-sm-12 text-center" style="margin-top:3%; margin-bottom:2%">
              <br>
              <h1>
                <i class="fa fa-hand-pointer"></i>
                ELECCIONES PERSONERO 2024 <strong>RESULTADOS</strong>
              </h1>
            </div><!-- /.col -->


          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->

      <section class="content">
        <div class="row">
          <div class="col-md-4">
            <div class="card card-success card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src=<?php echo DIST . "img/candidato1.png" ?> alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">GIHANNE MARIAGA</h3>
                <p class="text-muted text-center">CANDIDATA #1</p>
                <h3 class="text-center">



                  <strong>
                    <?php
                    echo $opcion1;
                    ?>
                  </strong> Votos

                </h3>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <div class="col-md-4">
            <!-- Profile Image -->
            <div class="card card-warning card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src=<?php echo DIST . "img/candidato2.png" ?> alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">DYLAN SARMIENTO</h3>
                <p class="text-muted text-center">CANDIDATO #2</p>
                <h3 class="text-center">

                  <strong>
                    <?php
                    echo $opcion2;
                    ?>
                  </strong> Votos

                </h3>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-secondary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src=<?php echo DIST . "img/boxed-bg.jpg" ?> alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">VOTO EN BLANCO</h3>
                <p class="text-muted text-center">--*--</p>
                <h3 class="text-center">

                  <strong>
                    <?php
                    echo $opcion3;
                    ?>
                  </strong> Votos

                </h3>
              </div>
            </div>
          </div>
        </div>;
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="row">

            <div class="col-12 col-sm-6 col-md-3">

              <?php
              $sql = "SELECT COUNT(id) AS etotales FROM siscpi_alumnos";
              $result = $conn->query($sql);
              $votante = $result->fetch_assoc();
              ?>

              <div class="info-box" style="background-color: #343a40;color: #fff;">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Total Electores</span>
                  <span class="info-box-number">
                    <?php echo $votante['etotales'];
                    ?>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">

              <?php
              $por_par = ($participacion * 100) / $votante['etotales'];
              $por_par2 = round($por_par, 2);
              ?>



              <div class="info-box" style="background-color: #343a40;color: #fff;">
                <span class="info-box-icon bg-success elevation-1" style="font-size: 1.2rem"><?php echo $por_par2 . '%'
                                                                                              ?></span>

                <div class="info-box-content">
                  <span class="info-box-text">Total participación</span>
                  <span class="info-box-number">
                    <?php
                    echo $participacion;
                    ?>
                    Votos
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>

            </div>

            <div class="col-12 col-sm-6 col-md-3">

              <?php
              $votos_abs = $votante['etotales'] - $participacion;
              $abs_por = ($votos_abs * 100) / $votante['etotales'];
              $abs_por2 = round($abs_por, 2);
              ?>


              <div class="info-box" style="background-color: #343a40;color: #fff;">
                <span class="info-box-icon bg-warning elevation-1" style="font-size: 1.2rem"><?php echo $abs_por2 . '%'
                                                                                              ?></span>

                <div class="info-box-content">
                  <span class="info-box-text">Total abstención</span>
                  <span class="info-box-number">
                    <?php
                    echo $votos_abs;
                    ?>
                    Votos
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>

            </div>

            <div class="col-12 col-sm-6 col-md-3">

              <div class="info-box" style="background-color: #343a40;color: #fff;">
                <span class="info-box-icon bg-light elevation-1" style="font-size: 1.2rem">0%</span>

                <div class="info-box-content">
                  <span class="info-box-text">Total votos nulos</span>
                  <span class="info-box-number">
                    0
                    Votos
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>

            </div>


          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <?php
    // Footer
    require_once FOOTER;
    ?>


    <script>
      function reloadPage() {
        document.location.reload()
      }
    </script>