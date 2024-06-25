<?php $nivel = 2;
require_once '../funciones/configuracion.php';
require_once  SESIONES;

if ($_SESSION['nivel'] == 8) :
  require_once FUNCIONES;
  // Templates
  require_once HEADER;
  require_once BARRA;
  require_once NAVEGACION;

  //$code = $_GET['code'];
  $id = $_GET['id_alum'];
  $alum_idx2 = $id;
  $id_simul = $_GET['id_simul'];
    

  if (!filter_var($id, FILTER_VALIDATE_INT)) {
    die("ERROR!");
  };

    date_default_timezone_set('America/Bogota');

    $stmt = $conn->prepare("SELECT simule_status FROM siscpi_simulacros_e WHERE simule_simul_id=? AND simule_alum_id=?");
    $stmt->bind_param("ii", $id_simul, $id);
    $stmt->execute();
    $revision = $stmt->get_result();
    $revision2 = $revision->fetch_assoc();
    $status_rev = $revision2['simule_status'];



    if ($status_rev == 1) {
      
      $stmt = $conn->prepare("SELECT simule_hora_final FROM siscpi_simulacros_e WHERE simule_simul_id=? AND simule_alum_id=?");
      $stmt->bind_param("ii", $id_simul, $id);
      $stmt->execute();
      $rev_fecha = $stmt->get_result();
      $rev_fecha2 = $rev_fecha->fetch_assoc();
     
      $nuevafecha = $rev_fecha2['simule_hora_final'];
  
    } else if ($status_rev == 3) {
        
        echo "'<script>console.log('entro')</script>'";

      try {

        $stmt = $conn->prepare("SELECT simul_tiempo FROM siscpi_simulacros WHERE simul_id=?");
        $stmt->bind_param("i", $id_simul);
        $stmt->execute();
        $result_min = $stmt->get_result();
        $result_min2 = $result_min->fetch_assoc();
        $cod_min = $result_min2['simul_tiempo'];
    
        $hoy = date("Y-m-d H:i:s"); 
        $minutos = $cod_min;
        $nuevafecha = strtotime ( '+'.$minutos.' minute' , strtotime  ( $hoy ) ) ;
        $nuevafecha = date ( 'm/d/Y h:i A' , $nuevafecha );
        $status = 1;

        $stmt = $conn->prepare("UPDATE siscpi_simulacros_e SET simule_hora_final=?, simule_status=?, simule_editado=NOW() WHERE simule_simul_id=? AND simule_alum_id=?");
        $stmt->bind_param("siii", $nuevafecha, $status, $id_simul, $id );
        $stmt->execute();
    
        $id_registro = $stmt->affected_rows;

        if($id_registro > 0){
          
        } else {
          die("ERROR!");
        };
    
      } catch (Exception $e) {
        echo "Error:" . $e->getMessage();
      } 

    } else {

      try {

        $stmt = $conn->prepare("SELECT simul_tiempo FROM siscpi_simulacros WHERE simul_id=?");
        $stmt->bind_param("i", $id_simul);
        $stmt->execute();
        $result_min = $stmt->get_result();
        $result_min2 = $result_min->fetch_assoc();
        $cod_min = $result_min2['simul_tiempo'];
    
        $hoy = date("Y-m-d H:i:s"); 
        $minutos = $cod_min;
        $nuevafecha = strtotime ( '+'.$minutos.' minute' , strtotime  ( $hoy ) ) ;
        $nuevafecha = date ( 'm/d/Y h:i A' , $nuevafecha );
        $status = 1;
    
        $stmt = $conn->prepare("INSERT INTO siscpi_simulacros_e (simule_simul_id, simule_alum_id, simule_hora_final, simule_status, simule_editado) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $id_simul, $id, $nuevafecha, $status, $hoy);
        $stmt->execute();
    
        $id_registro = $stmt->insert_id;
    
        if($id_registro > 0){
          
        } else {
          die("ERROR!");
        };
    
      } catch (Exception $e) {
        echo "Error:" . $e->getMessage();
      } 

    };


  try {

    $stmt = $conn->prepare("SELECT * FROM siscpi_simulacros WHERE simul_id=?");
    $stmt->bind_param("i", $id_simul);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $info_guia = $resultado->fetch_assoc();
  } catch (\Exception $e) {
      $error = $e->getMessage();
      echo $error;
  } 

  try {
    $stmt = $conn->prepare("SELECT * FROM siscpi_simulacros_e WHERE simule_simul_id=? AND simule_alum_id=?");
    $stmt->bind_param("ii", $id_simul, $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $info_guia2 = $resultado->fetch_assoc();
  } catch (\Exception $e) {
      $error = $e->getMessage();
      echo $error;
  }

    $mat_actual = json_decode($info_guia2['simule_respuestas'], true);

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              <i class="fa fa-thumbs-up"></i>
              ¡Éxito en tu prueba!
            </h1>

            <h5><?php echo 'Grado - '.$_SESSION['datos']['gra_esc'] ?>: <code>Simulacro #<?php echo $info_guia['simul_orden'] ?> </code></h5>
            

            

          </div><!-- /.col -->

          <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
              <h5>Tiempo restante: <code id="countdown"></code></h5>
              </ol>
            </div>
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

            <div class="card card-success">

              <div class="card-header">
                <h3 class="card-title"><?php echo $_SESSION['datos']['per_nom'].' '.$_SESSION['datos']['per_ape']; ?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                </div>
                
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" onclick="desplegar2();">
                    <i class="fas fa-edit"></i> Anotar Respuesta</button>
                </div>

              </div>

              <div class="card-body p-0" style="display: block;">

              <iframe src="<?php echo $info_guia['simul_ruta']; ?>" width="100%" height="600px" allowfullscreen webkitallowfullscreen></iframe>

              </div>
              <!-- /.card-body -->

            </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="modal-notasp">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <small>
                Hoja de respuesta de:
                <strong>
                <span><?php echo $_SESSION['datos']['per_nom'].' '.$_SESSION['datos']['per_ape']; ?></span>
                </strong>
            </small>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form role="form" name="respuestas_simulacro" id="respuestas_simulacro" method="post" action="#">

          <div class="modal-body">
                    

    
            <div class="card-body">
              <!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
              <div id="accordion">

                <?php

                  $si_ingles = json_decode($info_guia['simul_materia_ingles'], true);
                  $si_naturales = json_decode($info_guia['simul_materia_naturales'], true);
                  $si_lenguaje = json_decode($info_guia['simul_materia_lenguaje'], true);
                  $si_matematicas = json_decode($info_guia['simul_materia_matematicas'], true);
                  $si_sociales = json_decode($info_guia['simul_materia_sociales'], true);
                  $si_filosofia = json_decode($info_guia['simul_materia_filosofia'], true);
                  $si_fisica = json_decode($info_guia['simul_materia_fisica'], true);
                 
                  $total_preguntas = 0;

                  if ($si_ingles['ingles_status'] == 'SI') {

                        $ingles_p1x = $si_ingles['ingles_p1'];
                        $ingles_p2x = $si_ingles['ingles_p2'];
                        $ingles_p1 = (int)$ingles_p1x;
                        $ingles_p2 = (int)$ingles_p2x;
                    
                    ?>

                        <div class="card card-warning">
                          <div class="card-header">
                            <h4 class="card-title w-100">
                              <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapse1" aria-expanded="false">
                              <span><i class="fas fa-pencil-alt"></i>  Respuestas de Inglés: <strong id="nro_entregas"></strong></span>
                              </a>
                            </h4>
                          </div>
                          <div id="collapse1" class="collapse" data-parent="#accordion" >
                            <div class="card-body" id="#respuestas-ingles">
                    
                            <?php
                            $suma_ingles = $ingles_p1;
                            for ($i = $ingles_p1; $i <= $ingles_p2; $i++) {
                              
                              $respuestar1 = isset($mat_actual["" . 'p-'.$suma_ingles . ""]) ? $mat_actual["" . 'p-'.$suma_ingles . ""] : '';
                              
                              
                              ?>


                              <div class="col-sm-12">
                                <div class="form-group">
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><?php echo $suma_ingles ?></span>
                                    </div>

                                      <select class="form-control bloquear" name="p-<?php echo $suma_ingles ?>" id="p-<?php echo $suma_ingles ?>" >
                                        <option value=" " class="seleccionados" readonly selected> </option>
                                        <option value="A" class="seleccionados">A</option>
                                        <option value="B" class="seleccionados">B</option>
                                        <option value="C" class="seleccionados">C</option>
                                        <option value="D" class="seleccionados">D</option>
                                        <option value="E" class="seleccionados">E</option>
                                        <option value="F" class="seleccionados">F</option>
                                        <option value="G" class="seleccionados">G</option>
                                        <option value="H" class="seleccionados">H</option>
                                      </select>

                                    <div class="invalid-feedback">
                                      Este campo es obligatorio.
                                    </div>                   
                                  </div>
                                </div>
                              </div> <!-- col -->

                              <script>
                                function buscarSelect()
                                {
                                  // creamos un variable que hace referencia al select
                                  var select=document.getElementById('p-<?php echo $suma_ingles ?>');
                                
                                  // obtenemos el valor a buscar
                                  var buscar='<?php echo $respuestar1 ?>';
                                
                                  // recorremos todos los valores del select
                                  for(var i=1;i<select.length;i++)
                                  {
                                    if(select.options[i].text==buscar)
                                    {
                                      // seleccionamos el valor que coincide
                                      select.selectedIndex=i;
                                    }
                                  }
                                }

                                buscarSelect();
                              </script>

                            <?php             
                                $suma_ingles += 1;
                                $total_preguntas += 1;
                            }
                            ?> 
                                    
                            </div>
                          </div>
                        </div>

                        
                    <?php        

                  }

                  if ($si_naturales['naturales_status'] == 'SI') {

                    $naturales_p1x = $si_naturales['naturales_p1'];
                    $naturales_p2x = $si_naturales['naturales_p2'];
                    $naturales_p1 = (int)$naturales_p1x;
                    $naturales_p2 = (int)$naturales_p2x;

                    ?>

                    <div class="card card-primary">
                      <div class="card-header">
                        <h4 class="card-title w-100">
                          <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapse2" aria-expanded="false">
                          <span><i class="fas fa-pencil-alt"></i>  Respuestas de Naturales: <strong id="nro_entregas"></strong></span>
                          </a>
                        </h4>
                      </div>
                      <div id="collapse2" class="collapse" data-parent="#accordion" >
                        <div class="card-body" id="respuestas-naturales">
                
                        <?php

                        $suma_naturales = $naturales_p1;
                        
                        for ($i = $naturales_p1; $i <= $naturales_p2; $i++) {
                          
                          $respuestar2 = isset($mat_actual["" . 'p-'.$suma_naturales . ""]) ? $mat_actual["" . 'p-'.$suma_naturales . ""] : '';
                          
                          
                          ?>
                        

                          <div class="col-sm-12">
                            <div class="form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><?php echo $suma_naturales ?></span>
                                </div>

                                  <select class="form-control bloquear" name="p-<?php echo $suma_naturales ?>" id="p-<?php echo $suma_naturales ?>" >
                                    <option value=" " class="seleccionados" readonly selected> </option>
                                    <option value="A" class="seleccionados">A</option>
                                    <option value="B" class="seleccionados">B</option>
                                    <option value="C" class="seleccionados">C</option>
                                    <option value="D" class="seleccionados">D</option>
                                  </select>

                                <div class="invalid-feedback">
                                  Este campo es obligatorio.
                                </div>                   
                              </div>
                            </div>
                          </div> <!-- col -->

                          <script>
                            function buscarSelect()
                            {
                              // creamos un variable que hace referencia al select
                              var select=document.getElementById('p-<?php echo $suma_naturales ?>');
                            
                              // obtenemos el valor a buscar
                              var buscar='<?php echo $respuestar2 ?>';
                            
                              // recorremos todos los valores del select
                              for(var i=1;i<select.length;i++)
                              {
                                if(select.options[i].text==buscar)
                                {
                                  // seleccionamos el valor que coincide
                                  select.selectedIndex=i;
                                }
                              }
                            }

                            buscarSelect();
                          </script>

                        <?php             
                            $suma_naturales += 1;
                            $total_preguntas += 1;
                        }
                        ?>  

                               
                        </div>
                      </div>
                    </div>

                    
                    <?php        
                  }

                  if ($si_lenguaje['lenguaje_status'] == 'SI') {

                    $lenguaje_p1x = $si_lenguaje['lenguaje_p1'];
                    $lenguaje_p2x = $si_lenguaje['lenguaje_p2'];
                    $lenguaje_p1 = (int)$lenguaje_p1x;
                    $lenguaje_p2 = (int)$lenguaje_p2x;

                
                    ?>

                    <div class="card card-secondary">
                      <div class="card-header">
                        <h4 class="card-title w-100">
                          <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapse3" aria-expanded="false">
                          <span><i class="fas fa-pencil-alt"></i>  Respuestas de Lenguaje: <strong id="nro_entregas"></strong></span>
                          </a>
                        </h4>
                      </div>
                      <div id="collapse3" class="collapse" data-parent="#accordion" >
                        <div class="card-body" id="respuestas-lenguaje">
                
                        <?php
                        $suma_lenguaje = $lenguaje_p1;
                        for ($i = $lenguaje_p1; $i <= $lenguaje_p2; $i++) {
                          
                          $respuestar3 = isset($mat_actual["" . 'p-'.$suma_lenguaje . ""]) ? $mat_actual["" . 'p-'.$suma_lenguaje . ""] : '';
                          
                          ?>


                          <div class="col-sm-12">
                            <div class="form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><?php echo $suma_lenguaje ?></span>
                                </div>

                                  <select class="form-control bloquear" name="p-<?php echo $suma_lenguaje ?>" id="p-<?php echo $suma_lenguaje ?>" >
                                    <option value=" " class="seleccionados" readonly selected> </option>
                                    <option value="A" class="seleccionados">A</option>
                                    <option value="B" class="seleccionados">B</option>
                                    <option value="C" class="seleccionados">C</option>
                                    <option value="D" class="seleccionados">D</option>
                                  </select>

                                <div class="invalid-feedback">
                                  Este campo es obligatorio.
                                </div>                   
                              </div>
                            </div>
                          </div> <!-- col -->

                          <script>
                            function buscarSelect()
                            {
                              // creamos un variable que hace referencia al select
                              var select=document.getElementById('p-<?php echo $suma_lenguaje ?>');
                            
                              // obtenemos el valor a buscar
                              var buscar='<?php echo $respuestar3 ?>';
                            
                              // recorremos todos los valores del select
                              for(var i=1;i<select.length;i++)
                              {
                                if(select.options[i].text==buscar)
                                {
                                  // seleccionamos el valor que coincide
                                  select.selectedIndex=i;
                                }
                              }
                            }

                            buscarSelect();
                          </script>

                        <?php             
                            $suma_lenguaje += 1;
                            $total_preguntas += 1;

                        }
                        ?>         
                        </div>
                      </div>
                    </div>

                    
                    <?php        
                  }

                  if ($si_matematicas['matematicas_status'] == 'SI') {

                    $matematicas_p1x = $si_matematicas['matematicas_p1'];
                    $matematicas_p2x = $si_matematicas['matematicas_p2'];
                    $matematicas_p1 = (int)$matematicas_p1x;
                    $matematicas_p2 = (int)$matematicas_p2x;

                
                    ?>

                    <div class="card card-info">
                      <div class="card-header">
                        <h4 class="card-title w-100">
                          <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapse4" aria-expanded="false">
                          <span><i class="fas fa-pencil-alt"></i>  Respuestas de Matematicas: <strong id="nro_entregas"></strong></span>
                          </a>
                        </h4>
                      </div>
                      <div id="collapse4" class="collapse" data-parent="#accordion" >
                        <div class="card-body" id="respuestas-matematicas">
                
                        <?php
                        $suma_matematicas = $matematicas_p1;
                        for ($i = $matematicas_p1; $i <= $matematicas_p2; $i++) { 
                          
                          $respuestar4 = isset($mat_actual["" . 'p-'.$suma_matematicas . ""]) ? $mat_actual["" . 'p-'.$suma_matematicas . ""] : '';
                          
                          ?>


                          <div class="col-sm-12">
                            <div class="form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><?php echo $suma_matematicas ?></span>
                                </div>

                                  <select class="form-control bloquear" name="p-<?php echo $suma_matematicas ?>" id="p-<?php echo $suma_matematicas ?>" >
                                    <option value=" " class="seleccionados" readonly selected> </option>
                                    <option value="A" class="seleccionados">A</option>
                                    <option value="B" class="seleccionados">B</option>
                                    <option value="C" class="seleccionados">C</option>
                                    <option value="D" class="seleccionados">D</option>
                                  </select>

                                <div class="invalid-feedback">
                                  Este campo es obligatorio.
                                </div>                   
                              </div>
                            </div>
                          </div> <!-- col -->

                          <script>
                            function buscarSelect()
                            {
                              // creamos un variable que hace referencia al select
                              var select=document.getElementById('p-<?php echo $suma_matematicas ?>');
                            
                              // obtenemos el valor a buscar
                              var buscar='<?php echo $respuestar4 ?>';
                            
                              // recorremos todos los valores del select
                              for(var i=1;i<select.length;i++)
                              {
                                if(select.options[i].text==buscar)
                                {
                                  // seleccionamos el valor que coincide
                                  select.selectedIndex=i;
                                }
                              }
                            }

                            buscarSelect();
                          </script>

                        <?php             
                            $suma_matematicas += 1;
                            $total_preguntas += 1;

                        }
                        ?>         
                        </div>
                      </div>
                    </div>

                    
                    <?php   

                  }

                  if ($si_sociales['sociales_status'] == 'SI') {

                    $sociales_p1x = $si_sociales['sociales_p1'];
                    $sociales_p2x = $si_sociales['sociales_p2'];
                    $sociales_p1 = (int)$sociales_p1x;
                    $sociales_p2 = (int)$sociales_p2x;

                
                    ?>

                    <div class="card card-danger">
                      <div class="card-header">
                        <h4 class="card-title w-100">
                          <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapse5" aria-expanded="false">
                          <span><i class="fas fa-pencil-alt"></i>  Respuestas de Sociales: <strong id="nro_entregas"></strong></span>
                          </a>
                        </h4>
                      </div>
                      <div id="collapse5" class="collapse" data-parent="#accordion" >
                        <div class="card-body" id="respuestas-sociales">
                
                        <?php
                        $suma_sociales = $sociales_p1;
                        for ($i = $sociales_p1; $i <= $sociales_p2; $i++) {
                          
                          $respuestar5 = isset($mat_actual["" . 'p-'.$suma_sociales . ""]) ? $mat_actual["" . 'p-'.$suma_sociales . ""] : '';
                          
                          ?>


                          <div class="col-sm-12">
                            <div class="form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><?php echo $suma_sociales ?></span>
                                </div>

                                  <select class="form-control bloquear" name="p-<?php echo $suma_sociales ?>" id="p-<?php echo $suma_sociales ?>" >
                                    <option value=" " class="seleccionados" readonly selected> </option>
                                    <option value="A" class="seleccionados">A</option>
                                    <option value="B" class="seleccionados">B</option>
                                    <option value="C" class="seleccionados">C</option>
                                    <option value="D" class="seleccionados">D</option>
                                  </select>

                                <div class="invalid-feedback">
                                  Este campo es obligatorio.
                                </div>                   
                              </div>
                            </div>
                          </div> <!-- col -->

                          <script>
                            function buscarSelect()
                            {
                              // creamos un variable que hace referencia al select
                              var select=document.getElementById('p-<?php echo $suma_sociales ?>');
                            
                              // obtenemos el valor a buscar
                              var buscar='<?php echo $respuestar5 ?>';
                            
                              // recorremos todos los valores del select
                              for(var i=1;i<select.length;i++)
                              {
                                if(select.options[i].text==buscar)
                                {
                                  // seleccionamos el valor que coincide
                                  select.selectedIndex=i;
                                }
                              }
                            }

                            buscarSelect();
                          </script>

                        <?php             
                            $suma_sociales += 1;
                            $total_preguntas += 1;

                        }
                        ?>         
                        </div>
                      </div>
                    </div>

                    
                    <?php   
                  }

                  if ($si_filosofia['filosofia_status'] == 'SI') {

                    $filosofia_p1x = $si_filosofia['filosofia_p1'];
                    $filosofia_p2x = $si_filosofia['filosofia_p2'];
                    $filosofia_p1 = (int)$filosofia_p1x;
                    $filosofia_p2 = (int)$filosofia_p2x;

                
                    ?>

                    <div class="card card-dark">
                      <div class="card-header">
                        <h4 class="card-title w-100">
                          <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapse6" aria-expanded="false">
                          <span><i class="fas fa-pencil-alt"></i>  Respuestas de Filosofia: <strong id="nro_entregas"></strong></span>
                          </a>
                        </h4>
                      </div>
                      <div id="collapse6" class="collapse" data-parent="#accordion" >
                        <div class="card-body" id="respuestas-filosofia">
                
                        <?php
                        $suma_filosofia = $filosofia_p1;
                        for ($i = $filosofia_p1; $i <= $filosofia_p2; $i++) {
                          
                          $respuestar6 = isset($mat_actual["" . 'p-'.$suma_filosofia . ""]) ? $mat_actual["" . 'p-'.$suma_filosofia . ""] : '';
                          
                          ?>


                          <div class="col-sm-12">
                            <div class="form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><?php echo $suma_filosofia ?></span>
                                </div>

                                  <select class="form-control bloquear" name="p-<?php echo $suma_filosofia ?>" id="p-<?php echo $suma_filosofia ?>" >
                                    <option value=" " class="seleccionados" readonly selected> </option>
                                    <option value="A" class="seleccionados">A</option>
                                    <option value="B" class="seleccionados">B</option>
                                    <option value="C" class="seleccionados">C</option>
                                    <option value="D" class="seleccionados">D</option>
                                  </select>

                                <div class="invalid-feedback">
                                  Este campo es obligatorio.
                                </div>                   
                              </div>
                            </div>
                          </div> <!-- col -->

                          <script>
                            function buscarSelect()
                            {
                              // creamos un variable que hace referencia al select
                              var select=document.getElementById('p-<?php echo $suma_filosofia ?>');
                            
                              // obtenemos el valor a buscar
                              var buscar='<?php echo $respuestar6 ?>';
                            
                              // recorremos todos los valores del select
                              for(var i=1;i<select.length;i++)
                              {
                                if(select.options[i].text==buscar)
                                {
                                  // seleccionamos el valor que coincide
                                  select.selectedIndex=i;
                                }
                              }
                            }

                            buscarSelect();
                          </script>

                        <?php             
                            $suma_filosofia += 1;
                            $total_preguntas += 1;

                        }
                        ?>         
                        </div>
                      </div>
                    </div>

                    
                    <?php   
                  }

                  if ($si_fisica['fisica_status'] == 'SI') {

                    $fisica_p1x = $si_fisica['fisica_p1'];
                    $fisica_p2x = $si_fisica['fisica_p2'];
                    $fisica_p1 = (int)$fisica_p1x;
                    $fisica_p2 = (int)$fisica_p2x;

                
                    ?>

                    <div class="card card-success">
                      <div class="card-header">
                        <h4 class="card-title w-100">
                          <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapse7" aria-expanded="false">
                          <span><i class="fas fa-pencil-alt"></i>  Respuestas de Física: <strong id="nro_entregas"></strong></span>
                          </a>
                        </h4>
                      </div>
                      <div id="collapse7" class="collapse" data-parent="#accordion" >
                        <div class="card-body" id="respuestas-fisica">
                
                        <?php
                        $suma_fisica = $fisica_p1;
                        for ($i = $fisica_p1; $i <= $fisica_p2; $i++) {
                          
                          $respuestar7 = isset($mat_actual["" . 'p-'.$suma_fisica . ""]) ? $mat_actual["" . 'p-'.$suma_fisica . ""] : '';
                          
                          ?>


                          <div class="col-sm-12">
                            <div class="form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><?php echo $suma_fisica ?></span>
                                </div>

                                  <select class="form-control bloquear" name="p-<?php echo $suma_fisica ?>" id="p-<?php echo $suma_fisica ?>" >
                                    <option value=" " class="seleccionados" readonly selected> </option>
                                    <option value="A" class="seleccionados">A</option>
                                    <option value="B" class="seleccionados">B</option>
                                    <option value="C" class="seleccionados">C</option>
                                    <option value="D" class="seleccionados">D</option>
                                  </select>

                                <div class="invalid-feedback">
                                  Este campo es obligatorio.
                                </div>                   
                              </div>
                            </div>
                          </div> <!-- col -->

                          <script>
                            function buscarSelect()
                            {
                              // creamos un variable que hace referencia al select
                              var select=document.getElementById('p-<?php echo $suma_fisica ?>');
                            
                              // obtenemos el valor a buscar
                              var buscar='<?php echo $respuestar7 ?>';
                            
                              // recorremos todos los valores del select
                              for(var i=1;i<select.length;i++)
                              {
                                if(select.options[i].text==buscar)
                                {
                                  // seleccionamos el valor que coincide
                                  select.selectedIndex=i;
                                }
                              }
                            }

                            buscarSelect();
                          </script>

                        <?php             
                            $suma_fisica += 1;
                            $total_preguntas += 1;

                        }

                        ?>         
                        </div>
                      </div>
                    </div>

                    
                    <?php   
                  }


                
                ?>

              </div>
            </div>
            <!-- /.card-body -->


          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" id="cerrar_modal_nota" data-dismiss="modal">Cerrar</button>
            
            <input type="hidden" name="cmd" value="respuestas">
            <input type="hidden" name="evaluacion" id="evaluacion" value="<?php echo $id_simul ?>">
            <input type="hidden" name="evaluaciontp" id="evaluaciontp" value="<?php echo $total_preguntas ?>">
            <input type="hidden" name="alum_id" id="alum_id" value="<?php echo $id ?>">
            <button type="submit" class="btn btn-success">Enviar Respuestas</button>
          </div>

        </form>

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->


<?php
// Footer
require_once FOOTER;
endif;
?>

<script>

  function volverListaAsig2(dato1, dato2, dato3) {

    window.location.href = 'av-asignaciones-lista-2.php?grado='+dato2+'&materia='+dato1+'&code='+dato3;

  }
</script>

<script type="text/javascript">

  $(document).ready(function () {
    bsCustomFileInput.init();
  });
  
</script>

<script>
  function borrarArchivo(r){

    var ruta = r;

    console.log(ruta);

    datos = {
      ruta: ruta,
    };

    $.ajax({
      data: datos,
      url: "funciones/borrar-file.php",
      type: "post",
      dataType: "json",
      success: function (data) {
        var resultado = data;

        if (resultado.respuesta == "exito") {
        /*  Swal.fire({
            position: "center",
            icon: "success",
            title: "Operación realizada correctamente",
            showConfirmButton: false,
            timer: 1500,
          }); */
          location.reload();
          } else {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Algo salió mal",
              showConfirmButton: true,
            });
        }
        
      },
    });

    return false;
  };
</script>

<script>

  function desplegar2(/*p1, p2, p3, p4, p5, p6*/) {

    $("#modal-notasp").modal("show");

  }

  $('#cerrar_modal_nota').on('click', function (e) {
      console.log('cerrar mdodal');
      $('.seleccionados').attr('selected', false);

    })

</script>

<script>
var end = new Date(<?php echo '"'.$nuevafecha.'"'?>);

    var _second = 1000;
    var _minute = _second * 60;
    var _hour = _minute * 60;
    var _day = _hour * 24;
    var timer;

    function showRemaining() {
        var now = new Date();
        var distance = end - now;
        if (distance < 0) {

            clearInterval(timer);
            document.getElementById('countdown').innerHTML = '¡Tiempo agotado!';

            var informacion = document.getElementById('respuestas_simulacro');

            var datos = new FormData(informacion);

            $.ajax({
              type: 'post',
              data: datos,
              url: 'preifces-modelo.php',
              dataType: 'json',
              contentType: false,
              processData: false,
              async: true,
              cache: false,
              success: function(data){
                var resultado = data;
                console.log(data);
                
                if(resultado.respuesta == 'exito'){

                  $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:none;');
                  Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Tus respuestas fueron guardadas automáticamente",
                    showConfirmButton: false,
                    timer: 5000,
                  });
      
                  window.location.href = 'preifces-lista2.php?grado='+resultado.grado;

                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error',
                  })
                }
      
              }
      
            }); 

            console.log(datos);

            


            return;
        }
        var days = Math.floor(distance / _day);
        var hours = Math.floor((distance % _day) / _hour);
        var minutes = Math.floor((distance % _hour) / _minute);
        var seconds = Math.floor((distance % _minute) / _second);

        document.getElementById('countdown').innerHTML = hours + ':';
        document.getElementById('countdown').innerHTML += minutes + ':';
        document.getElementById('countdown').innerHTML += seconds ;
    }

    timer = setInterval(showRemaining, 1000);
</script>

<script>

  function accesoDenegado(){

    Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Something went wrong!',
    footer: '<a href>Why do I have this issue?</a>'
  })


  };

</script>