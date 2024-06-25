<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once  SESIONES;

if ($_SESSION['nivel'] == 1) :

  require_once FUNCIONES;

  // Templates
  require_once HEADER;
  //require_once BARRA;
  //require_once NAVEGACION;

  $mesa_activa = $_GET['m'];

  if (!filter_var($mesa_activa, FILTER_VALIDATE_INT)) {
    die("ERROR!");
  };

?>

  <body class="layout-top-nav layout-navbar-fixed " style="height: auto;">


    <div class="wrapper">

      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-light border-bottom-0">
        <!-- Left navbar links -->

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <p class="nav-link" href="#" role="button">

            </p>
          </li>
        </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">


              <div class="col-sm-12 text-center" style="margin-top:3%; margin-bottom:2%">
                <h1>
                  <i class="fa fa-hand-pointer"></i>
                  ELECCIONES PERSONERO 2024 <strong>(MESA <?php echo $mesa_activa?> )</strong>
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
                  <div class="text-center">
                    <button type="button" class="btn btn-success" onclick="votar('1')">VOTAR</button>
                  </div>
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
                  <div class="text-center">
                    <button type="button" class="btn btn-success" onclick="votar('2')">VOTAR</button>
                  </div>
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
                  <div class="text-center">
                    <button type="button" class="btn btn-success" onclick="votar('3')">VOTAR</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

      </div>
      <!-- /.content-wrapper -->

      <script>
        function votar(opcion) {

          let candidato;

          if (opcion == '1') {
            candidato = 'GIHANNE MARIAGA'
          } else if (opcion == '2') {
            candidato = 'DYLAN SARMIENTO'
          } else if (opcion == '3') {
            candidato = 'EN BLANCO'
          }

          Swal.fire({
            title: 'VOTAR ' + candidato,
            text: "¿Estas seguro de tu elección?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Confirmar",
          }).then((result) => {
            if (result.isConfirmed) {

              const enviarVoto = async () => {

                try {
                  let data = {
                    'cmd': 'env-voto',
                    'user_id': <?php echo $_SESSION['logid'] ?>,
                    'mesa_ac': <?php echo $mesa_activa ?>,
                    'voto_op': opcion
                  };


                  const response = await fetch('../modelos/elecciones-modelo.php', {
                    method: "POST",
                    headers: {
                      "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data),
                  });

                  const dataServer = await response.json();

                  if (dataServer.respuesta === 'exito') {
                    Swal.fire({
                      icon: 'success',
                      title: 'Voto registrado',
                      text: dataServer.comentario
                    });
                  }

                  if (dataServer.respuesta === 'error') {
                    Swal.fire({
                      icon: 'error',
                      title: 'Error en votación',
                      text: dataServer.comentario
                    });
                  }



                } catch (error) {
                  console.error(error);
                }

              }

              enviarVoto()



            } else {
              //window.location.reload();
            }
          });
        }
      </script>


    <?php
    // Footer
    require_once FOOTER;
  endif;
    ?>