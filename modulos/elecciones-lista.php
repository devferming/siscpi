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
          <div class="col-sm-12 text-center" style="margin-top:3%; margin-bottom:2%">
            <h1>
              <i class="fa fa-hand-pointer"></i>
              ELECCIONES PERSONERO 2024
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
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
            <h3 class="card-title">Electores registrados en grado <strong><span><?php echo $grado_desc; ?></span></strong></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="mat-lista" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Nombre y Apellido</th>
                  <th>N° Documento</th>
                  <th>Grado</th>
                  <th>Estado</th>
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

                  if ($datos['gra_esc'] == $grado_desc) { ?>

                    <tr>
                      <td>
                        <?php echo $datos['per_ape'], " ", $datos['per_nom']; ?>
                      </td>
                      <td>
                        <?php echo $datos['ide_num']; ?>
                      </td>
                      <td>
                        <?php echo $datos['gra_esc']; ?>
                      </td>

                      <td>
                        <?php

                        if (isset($datos['ele_esc'])) {
                          $valor_actual = intval($datos['ele_esc']);
                          if ($valor_actual == 1) {
                            echo '
                            <span class="badge badge-danger">Sin votar2</span>
                            ';
                          } else if ($valor_actual == 2) {
                            echo '
                            <span class="badge badge-warning">Votando...</span>
                            ';
                          } else if ($valor_actual == 3) {
                            echo '
                            <span class="badge badge-success">¡Ya votó!</span>
                            ';
                          }
                        } else {
                          echo '
                          <span class="badge badge-danger">Sin votar</span>
                          ';
                        }

                        ?>
                      </td>


                      <td>

                        <?php

                        if (isset($datos['ele_esc'])) {
                          if ($datos['ele_esc'] == '1') { ?>
                            <button type="button" class="btn btn-primary btn-sm" onclick="habilitarVoto('<?php echo $id ?>')"><i class="fas fa-check"></i></button>
                          <?php
                          }
                        } else { ?>
                          <button type="button" class="btn btn-primary btn-sm" onclick="habilitarVoto('<?php echo $id ?>')"><i class="fas fa-check"></i></button>
                        <?php
                        }

                        ?>
                      </td>



                    </tr>

                <?php
                  }
                }
                $conn->close();
                ?>


              </tbody>
              <tfoot>
                <tr>
                  <th>Nombre y Apellido</th>
                  <th>N° Documento</th>
                  <th>Grado</th>
                  <th>Estado</th>
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

  <script>
    function habilitarVoto(id) {

      
      const consultaMesa = async () => {

        try {

          let data = {
            'cmd': 'con-mesa',
            'user_id': <?php echo $_SESSION['logid'] ?>
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
              title: 'Mesa ' + dataServer.mesa + ' disponible',
              text: "¿Desear habilitar votación?",
              icon: "success",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              cancelButtonText: "Cancelar",
              confirmButtonText: "Habilitar",
            }).then((result) => {
              if (result.isConfirmed) {

                let numMesa = dataServer.mesa

                const habilitarTurno = async () => {
                  try {
                    let data = {
                      cmd: "hab-mesa",
                      mes: numMesa,
                      aid: id,
                      user_id: <?php echo $_SESSION['logid'] ?>,
                    };
                    const response = await fetch('../modelos/elecciones-modelo.php', {
                      method: "POST",
                      headers: {
                        "Content-Type": "application/json"
                      },
                      body: JSON.stringify(data),
                    });
                    const dataServer = await response.json();
                    if (dataServer.respuesta === "exito") {

                      Swal.fire({
                        icon: 'success',
                        title: dataServer.comentario,
                        text: dataServer.info
                      });
                      setTimeout(() => {
                        location.reload()
                      }, 2000);

                    }

                    if (dataServer.respuesta === "error") {
                      console.log("error");
                    }
                  } catch (error) {
                    console.error(error);
                  }
                };

                habilitarTurno();


              } else {
                //window.location.reload();
              }
            });

          }

          if (dataServer.respuesta === 'error') {
            Swal.fire({
              icon: 'error',
              title: 'Espere un momento',
              text: dataServer.mesa
            });
          }


        } catch (error) {
          console.error(error);
        }

      }

      consultaMesa()
      
      
    }
  </script>


<?php
  // Footer
  require_once FOOTER;
endif;
?>