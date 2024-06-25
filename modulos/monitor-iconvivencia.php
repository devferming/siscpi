<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once  SESIONES;

if ($_SESSION['nivel'] == 3 || $_SESSION['nivel'] == 1) :

  require_once FUNCIONES;
  // Templates
  require_once HEADER;
  require_once BARRA;
  require_once NAVEGACION;

?>

  <script>
    const logId = <?php echo json_encode($_SESSION['logid']); ?>;
    const modelo = '../modelos/notas-modelo.php'
  </script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              <i class="fa fa-poll"></i>
              Gestión de indicadores de convivencia
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
        <div class="card card-secondary">

          <div class="card-header">
            <h3 class="card-title">Indicadores registrados</h3>
            <div class="card-tools">
            </div>

          </div>
          <!-- /.card-header -->

          <div class="card-body">

            <?php

            try {
              $stmt = $conn->prepare("SELECT * FROM siscpi_iconvivencia");
              $stmt->execute();
              $con_desc2 = $stmt->get_result();
            } catch (\Exception $e) {
              $error = $e->getMessage();
              echo $error;
            } ?>



            <div class="card-body">

              <?php

              while ($con_desc = $con_desc2->fetch_assoc()) { ?>

                <label for=""><?php echo 'INDICADOR ID ' . $con_desc['notas_convivencia_id'] . ':' ?></label>
                <textarea type="text" class="form-control texto-convi col-sm-12" data-con-id="<?php echo $con_desc['notas_convivencia_id'] ?>" id="text-convi-<?php echo $con_desc['notas_convivencia_id'] ?>"><?php echo htmlspecialchars($con_desc['notas_convivencia_descripcion']) ?></textarea> <br>

              <?php
              } ?>

              <label for="" style="color:green">
                AÑADIR NUEVO
                <span class="badge badge-pill badge-success zoom" onclick="guardaConvi()" style="cursor:pointer;">GUARDAR</span>
              </label>
              <textarea type="text" class="form-control texto-aprendizajes col-sm-12" id="con-nuevo"></textarea>

            </div>
            <!-- /.card-body -->

          </div>
          <!-- /.card-body -->

        </div>
        <!-- /.card -->
      </div>
      <!-- /.container-fluid -->
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
  let aptexto = document.querySelectorAll('.texto-convi')
  Array.prototype.slice.call(aptexto)
    .forEach(function(apcatch) {
      apcatch.addEventListener('change', async function(e) {

        let convi_text = this.value;
        let convi_id = this.getAttribute('data-con-id');

        const response = await fetch("../modelos/notas-modelo.php", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            cmd: 'acticonv',
            subcmd: 1,
            text: convi_text,
            convi_id: convi_id,
            user_id: '<?php echo json_encode($_SESSION['logid']); ?>',
          })
        });

        const data = await response.json();

        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 8000
        });

        if (data.respuesta == 'exito') {
          Toast.fire({
            icon: 'success',
            title: data.comentario
          });

          $('#text-convi-' + convi_id).text(data.newtext);

        } else {
          Toast.fire({
            icon: 'error',
            title: resultado.comentario
          })
        }

      }, false)
    })

  async function guardaConvi() {

    let con_text = $('#con-nuevo').val();

    const response = await fetch("../modelos/notas-modelo.php", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        cmd: 'acticonv',
        subcmd: 2,
        text: con_text,
        user_id: '<?php echo json_encode($_SESSION['logid']); ?>',
      })
    });

    const data = await response.json();

    const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 8000
        });


    if (data.respuesta == 'exito') {

      Toast.fire({
        icon: 'success',
        title: data.comentario
      })

      location.reload();

    } else {

      Toast.fire({
        icon: 'error',
        title: data.comentario
      })

    }

  }
</script>