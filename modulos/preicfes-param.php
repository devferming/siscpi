<?php $nivel = 2;
require_once '../funciones/configuracion.php';
require_once  SESIONES;

if ($_SESSION['nivel'] == 3 || $_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 6) :
  require_once FUNCIONES;
  // Templates
  require_once HEADER;
  require_once BARRA;
  require_once NAVEGACION;

  $datos = $_GET['data'];
  $datos = unserialize($datos);
  $gcode = $datos['d1'];
  $grado = $datos['d2'];

  if (!filter_var($gcode, FILTER_VALIDATE_INT)) {
    die("ERROR!");
  };

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
              Nuevo Simulacro
            </h1>
            <h5>Grado: <code><?php echo $grado ?></code></h5>
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


        <form role="form" name="guardar-simul" id="guardar-simul" method="post" action="#" enctype="multipart/form-data">

        <div class="card card-warning">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-edit"></i> Inglés</h3>
          </div>
          <!-- /.card-header -->

          <div class="card-body">

            <div class="row">

              <div class="col-sm-2">
                <div class="form-group">
                <label>Inglés</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fab fa-diaspora"></i></span>
                    </div>
                    <select class="form-control bloquear" name="ingles" id="ingles" required>
                      <option selected value="N/A">N/A</option>
                      <option value="SI">SI</option>
                    </select>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div> 
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Primera Pregunta</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>
                    <input type="text" class="form-control number2 bloquear" name="simul-pregunta-ingles1" id="simul-pregunta-ingles1">
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>                   
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Última Pregunta</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>

                    <input type="text" class="form-control number2 bloquear" name="simul-pregunta-ingles2" id="simul-pregunta-ingles2">

                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>                   
                  </div>
                </div>
              </div> <!-- col -->

            </div>
          </div>
        </div> <!-- col -->

        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-edit"></i> Ciencias Naturales</h3>
          </div>
          <!-- /.card-header -->

          <div class="card-body">

            <div class="row">

              <div class="col-sm-2">
                <div class="form-group">
                <label>Naturales</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fab fa-diaspora"></i></span>
                    </div>
                    <select class="form-control bloquear" name="naturales" id="naturales" required>
                      <option selected value="N/A">N/A</option>
                      <option value="SI">SI</option>
                    </select>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div> 
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Primera Pregunta</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>

                    <input type="text" class="form-control number2 bloquear" name="simul-pregunta-naturales1" id="simul-pregunta-naturales1">

                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>                   
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Última Pregunta</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>

                    <input type="text" class="form-control number2 bloquear" name="simul-pregunta-naturales2" id="simul-pregunta-naturales2">

                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>                   
                  </div>
                </div>
              </div> <!-- col -->

            </div>
          </div>
        </div> <!-- col -->

        <div class="card card-secondary">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-edit"></i> Lenguaje</h3>
          </div>
          <!-- /.card-header -->

          <div class="card-body">

            <div class="row">

              <div class="col-sm-2">
                <div class="form-group">
                <label>Lenguaje</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fab fa-diaspora"></i></span>
                    </div>
                    <select class="form-control bloquear" name="lenguaje" id="lenguaje" required>
                      <option selected value="N/A">N/A</option>
                      <option value="SI">SI</option>
                    </select>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div> 
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Primera Pregunta</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>

                    <input type="text" class="form-control number2 bloquear" name="simul-pregunta-lenguaje1" id="simul-pregunta-lenguaje1">

                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>                   
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Última Pregunta</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>

                    <input type="text" class="form-control number2 bloquear" name="simul-pregunta-lenguaje2" id="simul-pregunta-lenguaje2">

                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>                   
                  </div>
                </div>
              </div> <!-- col -->

            </div>
          </div>
        </div> <!-- col -->

        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-edit"></i> Matemáticas</h3>
          </div>
          <!-- /.card-header -->

          <div class="card-body">

            <div class="row">

              <div class="col-sm-2">
                <div class="form-group">
                <label>Matemáticas</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fab fa-diaspora"></i></span>
                    </div>
                    <select class="form-control bloquear" name="matematicas" id="matematicas" required>
                      <option selected value="N/A">N/A</option>
                      <option value="SI">SI</option>
                    </select>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div> 
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Primera Pregunta</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>

                    <input type="text" class="form-control number2 bloquear" name="simul-pregunta-matematicas1" id="simul-pregunta-matematicas1">

                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>                   
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Última Pregunta</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>

                    <input type="text" class="form-control number2 bloquear" name="simul-pregunta-matematicas2" id="simul-pregunta-matematicas2">

                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>                   
                  </div>
                </div>
              </div> <!-- col -->

            </div>
          </div>
        </div> <!-- col -->

        <div class="card card-danger">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-edit"></i> Ciencias Sociales</h3>
          </div>
          <!-- /.card-header -->

          <div class="card-body">

            <div class="row">

              <div class="col-sm-2">
                <div class="form-group">
                <label>Sociales</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fab fa-diaspora"></i></span>
                    </div>
                    <select class="form-control bloquear" name="sociales" id="sociales" required>
                      <option selected value="N/A">N/A</option>
                      <option value="SI">SI</option>
                    </select>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div> 
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Primera Pregunta</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>

                    <input type="text" class="form-control number2 bloquear" name="simul-pregunta-sociales1" id="simul-pregunta-sociales1">

                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>                   
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Última Pregunta</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>

                    <input type="text" class="form-control number2 bloquear" name="simul-pregunta-sociales2" id="simul-pregunta-sociales2">

                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>                   
                  </div>
                </div>
              </div> <!-- col -->

            </div>
          </div>
        </div> <!-- col -->

        <div class="card card-navy">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-edit"></i> Filosofía</h3>
          </div>
          <!-- /.card-header -->

          <div class="card-body">

            <div class="row">

              <div class="col-sm-2">
                <div class="form-group">
                <label>Filosofía</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fab fa-diaspora"></i></span>
                    </div>
                    <select class="form-control bloquear" name="filosofia" id="filosofia" required>
                      <option selected value="N/A">N/A</option>
                      <option value="SI">SI</option>
                    </select>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div> 
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Primera Pregunta</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>

                    <input type="text" class="form-control number2 bloquear" name="simul-pregunta-filosofia1" id="simul-pregunta-filosofia1">

                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>                   
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Última Pregunta</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>

                    <input type="text" class="form-control number2 bloquear" name="simul-pregunta-filosofia2" id="simul-pregunta-filosofia2">

                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>                   
                  </div>
                </div>
              </div> <!-- col -->

            </div>
          </div>
        </div> <!-- col -->

        <div class="card card-purple">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-edit"></i> Física</h3>
          </div>
          <!-- /.card-header -->

          <div class="card-body">

            <div class="row">

              <div class="col-sm-2">
                <div class="form-group">
                <label>Filosofía</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fab fa-diaspora"></i></span>
                    </div>
                    <select class="form-control bloquear" name="fisica" id="fisica" required>
                      <option selected value="N/A">N/A</option>
                      <option value="SI">SI</option>
                    </select>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div> 
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Primera Pregunta</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>

                    <input type="text" class="form-control number2 bloquear" name="simul-pregunta-fisica1" id="simul-pregunta-fisica1">

                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>                   
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-2">
                <div class="form-group">
                  <label>Última Pregunta</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>

                    <input type="text" class="form-control number2 bloquear" name="simul-pregunta-fisica2" id="simul-pregunta-fisica2">

                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>                   
                  </div>
                </div>
              </div> <!-- col -->

            </div>
          </div>
        </div> <!-- col -->

        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-edit"></i> Datos finales</h3>
          </div>
          <!-- /.card-header -->

          <div class="card-body">

        
          
              <div class="col-sm-12">
                <div class="form-group">
                  <label>Instrucciones u observaciones</label>
                  <textarea class="form-control" rows="5" name="simul-inst" id="simul-inst"></textarea>
                </div>
              </div> <!-- col -->

              <div class="col-sm-12">
                <div class="form-group">
                  <label>Fecha de realización</label>
                  <input class="form-control" type="date" name="simul-fecha" id="simul-fecha" required>
                </div>
              </div> <!-- col -->

              <div class="col-sm-12">
                <div class="form-group">
                  <label>Tiempo Máximo (en minutos)</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>

                    <select class="form-control bloquear" name="simul-tiempo" id="simul-tiempo" required>
                      <option value=" " class="seleccionados" disabled selected> </option>
                      <option value="30" class="seleccionados">30</option>
                      <option value="60" class="seleccionados">60</option>
                      <option value="90" class="seleccionados">90</option>
                      <option value="120" class="seleccionados">120</option>
                      <option value="150" class="seleccionados">150</option>
                      <option value="180" class="seleccionados">180</option>
                      <option value="210" class="seleccionados">210</option>
                      <option value="240" class="seleccionados">240</option>
                      <option value="270" class="seleccionados">270</option>
                      <option value="300" class="seleccionados">300</option>
                      <option value="400" class="seleccionados">400</option>
                      <option value="500" class="seleccionados">500</option>
                      <option value="600" class="seleccionados">600</option>
                      <option value="700" class="seleccionados">700</option>
                      <option value="800" class="seleccionados">800</option>
                      <option value="900" class="seleccionados">900</option>
                    </select>

                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>                   
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-12">
                <div class="form-group">
                  <label>Archivo PDF</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="simul-pdf" id="simul-pdf" accept="application/pdf" required>
                      <label class="custom-file-label" for="av-asig-guia">Elije un archivo</label>
                    </div>
                  </div>
                </div>
              </div> <!-- col -->




            
          </div>

          <!-- /.card-body -->
          <div class="card-footer">
            <input type="hidden" name="cmd" id="cmd" value="simulnuevo">
            <input type="hidden" name="simul-grado" id="simul-grado" value="<?php echo $gcode ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['logid'] ?>">
            <button type="submit" class="btn btn-success">Cargar</button>
            <button type="button" class="btn btn-warning" onclick="volverListaAsig('<?php echo $grado; ?>');">Pruebas Cargadas</button>
          </div>

        </div>
        <!-- /.card -->

        

          

          <br>

        </form>

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

  function volverListaAsig(grado) {

    window.location.href = 'preifces-lista.php?grado='+grado;


  }

</script>

<script type="text/javascript">
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
</script>

<script>

  $('input[type="file"]').on('change', function(){
    var ext = $( this ).val().split('.').pop();
    if ($( this ).val() != '') {
      if(ext == "pdf"){
        //alert("La extensión es: " + ext);
        if($(this)[0].files[0].size > 20971520){
          Swal.fire({
              icon: 'warning',
              title: '¡Archivo muy pesado!',
              text: 'Se solicita un archivo no mayor a 2 Megabytes'
              //footer: '<a href>¿Porque ocurrió esto?</a>'
            })           
          $(this).val('');
        }else{
          $("#modal-gral").hide();
        }
      }
      else
      {
        $( this ).val('');
        Swal.fire({
              icon: 'warning',
              title: '¡El archivo no es PDF!',
              text: 'Se solicita un archivo con extención .pdf'
              //footer: '<a href>¿Porque ocurrió esto?</a>'
            })
      }
    }
  });

</script>



