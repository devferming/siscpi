<?php
  include_once 'funciones/sesiones.php';
  include_once 'funciones/funciones.php';

  if($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2):

  include_once 'templates/header.php';
  include_once 'templates/barra.php';
  include_once 'templates/navegacion.php';

  $id = $_GET['id'];

  if (!filter_var($id, FILTER_VALIDATE_INT)) {
    die("ERROR!");
  }

  try {

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE users_id_logins=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $datos = $resultado->fetch_assoc();
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
              <i class="fa fa-user-cog"></i>
              ACTUALIZACIÓN DE USUARIO
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Usuarios</a></li>
              <li class="breadcrumb-item"><a href="#">Usuarios registrados</a></li>
              <li class="breadcrumb-item active">Actualizar usuario</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">


        <form role="form" name="user_actualizar" id="user_actualizar" method="post" action="usuario-modelo.php" class="needs-validation" novalidate autocomplete="on">

          <div class="card card-navy">
            <div class="card-header">

              <h3 class="card-title"><i class="fa fa-user"></i> Datos del usuario</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <div class="row">

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Tipo de documento</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select class="form-control bloquear" name="user_ide_tip" required>
                          <option selected ><?php echo $datos['users_doc_tipo'];?></option>
                          <option value="CC">CC</option>
                          <option value="CE">CE</option>
                          <option disabled>-</option>
                          <option value="PEP">PEP</option>
                          <option value="PASAPORTE">PASAPORTE</option>
                          <option value="CI (VZLA)">CI (VZLA)</option>
                        </select>
                        <div class="invalid-feedback">
                          Este campo es obligatorio.
                        </div>                   
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Numero de documento</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                        </div>
                        <input type="text" class="form-control number bloquear" name="user_ide_num" id="user_ide_num" Keyup="formatodemiles(this)" value="<?php echo $datos['users_doc_numero'];?>" required>
                        <div class="invalid-feedback">
                          Este campo es obligatorio.
                        </div>                   
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Primer Apellido</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                        </div>
                        <input type="text" class="form-control letter mayusculas bloquear" name="user_per_ape" value="<?php echo $datos['users_1er_apellido'];?>" required>
                        <div class="invalid-feedback">
                          Este campo es obligatorio.
                        </div>                   
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Segundo Apellido</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                        </div>
                        <input type="text" class="form-control letter mayusculas bloquear" name="user_sdo_ape" value="<?php echo $datos['users_2do_apellido'];?>">
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Primer Nombre</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                        </div>
                        <input type="text" class="form-control letter mayusculas bloquear" name="user_per_nom" value="<?php echo $datos['users_1er_nombre'];?>" required>
                        <div class="invalid-feedback">
                          Este campo es obligatorio.
                        </div>                   
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Segundo Nombre</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                        </div>
                        <input type="text" class="form-control letter mayusculas bloquear" name="user_sdo_nom" value="<?php echo $datos['users_2do_nombre'];?>">
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Genero</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                        </div>
                        <select class="form-control bloquear" name="user_gen" required>
                          <option selected ><?php echo $datos['users_genero'];?></option>
                          <option value="MASCULINO">MASCULINO</option>
                          <option value="FEMENINO">FEMENINO</option>
                        </select>
                        <div class="invalid-feedback">
                          Este campo es obligatorio.
                        </div>                   
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Fecha de Nacimiento</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>

                        <?php 

                        $fecha = $datos['users_nac_fecha'];
                        $nac_fec = DateTime::createFromFormat('Y-m-d', $fecha)->format('d/m/Y');  

                        ?>

                        <input type="text" class="form-control bloquear" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" name="user_nac_fec" value="<?php echo $nac_fec;?>" required>
                        <div class="invalid-feedback">
                          Este campo es obligatorio.
                        </div>                   
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Lugar de Nacimiento</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                        </div>
                        <input type="text" class="form-control letter mayusculas bloquear" name="user_nac_lug" value="<?php echo $datos['users_nac_lugar'];?>">
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Departamento</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                        </div>
                        <input type="text" class="form-control letter mayusculas bloquear" name="user_nac_dep" value="<?php echo $datos['users_departamento'];?>">
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Municipio</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                        </div>
                        <input type="text" class="form-control letter mayusculas bloquear" name="user_dir_mun" value="<?php echo $datos['users_municipio'];?>">
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Barrio</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                        </div>
                        <input type="text" class="form-control letter mayusculas bloquear" name="user_dir_bar" value="<?php echo $datos['users_barrio'];?>">
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Dirección</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                        </div>
                        <input type="text" class="form-control direccion mayusculas bloquear" name="user_dir_dir" value="<?php echo $datos['users_direccion'];?>">
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Número Teléfono móvil</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                        </div>
                        <input type="text" class="form-control bloquear" name="user_tel_mov" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?php echo $datos['users_telf_movil'];?>">
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Número Teléfono Local</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                        </div>
                        <input type="text" class="form-control bloquear" name="user_tel_loc" data-inputmask='"mask": "999-9999"' data-mask value="<?php echo $datos['users_telf_local'];?>">
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>E-mail</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                        </div>
                        <input type="text" class="form-control correo bloquear" name="user_mai" value="<?php echo $datos['users_mail'];?>">
                      </div>
                    </div>
                  </div> <!-- col -->

                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->


          <div class="card card-navy">
            <div class="card-header">

              <h3 class="card-title"><i class="fa fa-user"></i> Datos de acceso al sistema</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <div class="row">

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Rol</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select class="form-control bloquear" name="user_rol" id="user_rol" required>
                          <option selected ><?php echo $datos['users_rol'];?></option>
                          <option value="RECTOR(A)">RECTOR(A)</option>
                          <option value="COORDINADOR(A)">COORDINADOR(A)</option>
                          <option value="SECRETARIA">SECRETARIA</option>
                          <option value="DOCENTE">DOCENTE</option>
                        </select>
                        <div class="invalid-feedback">
                          Este campo es obligatorio.
                        </div>                   
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Nickname</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                        </div>

                        <?php
                        
                        $id_login = $datos['users_id_logins'];

                        try {

                          $stmt2 = $conn->prepare("SELECT * FROM logins WHERE logins_id_login=?");
                          $stmt2->bind_param("i", $id_login);
                          $stmt2->execute();
                          $resultado2 = $stmt2->get_result();
                          $datos2 = $resultado2->fetch_assoc();
                        } catch (\Exception $e) {
                            $error = $e->getMessage();
                            echo $error;
                        } 

                        ?>

                        <input type="text" class="form-control nickname minusculas bloquear" name="user_user" value="<?php echo $datos2['logins_nickname'];?>" required>
                        <div class="invalid-feedback">
                          Este campo es obligatorio.
                        </div>                   
                      </div>
                    </div>
                  </div> <!-- col -->

                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <div class="card card-navy" style="display:block" id="perfil_docente">
            <div class="card-header">

              <h3 class="card-title"><i class="fa fa-user"></i> Perfil Usuario</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <div class="row">


                <div class="col-sm-3">
                    <div class="form-group">
                      <label>Asignatura</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select class="form-control bloquear" name="user_materia" id="user_materia" required>
                          <option selected ><?php echo $datos['users_asignatura'];?></option>
                          <option value="INGLÉS">INGLÉS</option>
                          <option value="BIOLOGÍA">BIOLOGÍA</option>
                          <option value="QUÍMICA">QUÍMICA</option>
                          <option value="CIENCIAS NATURALES">CIENCIAS NATURALES</option>
                          <option value="LENGUAJE">LENGUAJE</option>
                          <option value="MATEMÁTICAS">MATEMÁTICAS</option>
                          <option value="CIENCIAS SOCIALES"> CIENCIAS SOCIALES</option>
                          <option value="INFORMÁTICA">INFORMÁTICA</option>
                          <option value="ARTE Y ÉTICA">ARTE Y ÉTICA</option>
                          <option value="DEPORTE">DEPORTE</option>
                          <option value="N/A">N/A</option>
                          <option value="T/A">T/A</option>
                        </select>
                        <div class="invalid-feedback">
                          Este campo es obligatorio.
                        </div>                   
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Dirección de Grupo</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select class="form-control bloquear" name="user_dgrupo" id="user_dgrupo" required>
                          <option selected ><?php echo $datos['users_dgrupo'];?></option>
                          <option value="PRE JARDÍN">PRE JARDÍN</option>
                          <option value="JARDÍN">JARDÍN</option>
                          <option value="TRANSICIÓN">TRANSICIÓN</option>
                          <option value="PRIMERO">PRIMERO</option>
                          <option value="SEGUNDO">SEGUNDO</option>
                          <option value="TERCERO">TERCERO</option>
                          <option value="CUARTO">CUARTO</option>
                          <option value="QUINTO">QUINTO</option>
                          <option value="SEXTO">SEXTO</option>
                          <option value="SEPTIMO">SÉPTIMO</option>
                          <option value="OCTAVO">OCTAVO</option>
                          <option value="NOVENO">NOVENO</option>
                          <option value="DECIMO">DÉCIMO</option>
                          <option value="UNDECIMO">UNDÉCIMO</option>
                          <option value="N/A">N/A</option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Sección</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <select class="form-control bloquear" name="user_dgrupo_seccion" id="user_dgrupo_seccion" required>
                          <option selected ><?php echo $datos['users_dgrupo_seccion'];?></option>
                          <option value="U">U</option>
                          <option value="A">A</option>
                          <option value="B">B</option>
                          <option value="N/A">N/A</option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- col -->


                
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label style="color: white"> PJ</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><strong>PJ</strong></span>
                        </div>
                        <select class="form-control bloquear" name="ipj" id="ipj" required>
                          <option selected ><?php echo $datos['users_pj'];?></option>
                          <option value="N/A">N/A</option>
                          <option value="SI">SI</option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- col -->

                  
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label style="color: white"> J</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><strong>J</strong></span>
                        </div>
                        <select class="form-control bloquear" name="ij" id="ij" required>
                          <option selected ><?php echo $datos['users_j'];?></option>
                          <option value="N/A">N/A</option>
                          <option value="SI">SI</option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- col -->


                <div class="col-sm-2">
                    <div class="form-group">
                      <label style="color: white"> T</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><strong>T</strong></span>
                        </div>
                        <select class="form-control bloquear" name="itrans" id="itrans" required>
                          <option selected ><?php echo $datos['users_t'];?></option>
                          <option value="N/A">N/A</option>
                          <option value="SI">SI</option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- col -->



                <div class="col-sm-2">
                    <div class="form-group">
                      <label style="color: white"> 1</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><strong>1°</strong></span>
                        </div>
                        <select class="form-control bloquear" name="iprimero" id="iprimero" required>
                          <option selected ><?php echo $datos['users_1ro'];?></option>
                          <option value="N/A">N/A</option>
                          <option value="SI">SI</option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-2">
                    <div class="form-group">
                    <label style="color: white"> 2</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><strong>2°</strong></span>
                        </div>
                        <select class="form-control bloquear" name="isegundo" id="isegundo" required>
                          <option selected ><?php echo $datos['users_2do'];?></option>
                          <option value="N/A">N/A</option>
                          <option value="SI">SI</option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-2">
                    <div class="form-group">
                    <label style="color: white"> 3</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><strong>3°</strong></span>
                        </div>
                        <select class="form-control bloquear" name="itercero" id="itercero" required>
                          <option selected ><?php echo $datos['users_3ro'];?></option>
                          <option value="N/A">N/A</option>
                          <option value="SI">SI</option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-2">
                    <div class="form-group">
                    <label style="color: white"> 4</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><strong>4°</strong></span>
                        </div>
                        <select class="form-control bloquear" name="icuarto" id="icuarto" required>
                          <option selected ><?php echo $datos['users_4to'];?></option>
                          <option value="N/A">N/A</option>
                          <option value="SI">SI</option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- col -->
                  
                  <div class="col-sm-2">
                    <div class="form-group">
                    <label style="color: white"> 5</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><strong>5°</strong></span>
                        </div>
                        <select class="form-control bloquear" name="iquinto" id="iquinto" required>
                          <option selected ><?php echo $datos['users_5to'];?></option>
                          <option value="N/A">N/A</option>
                          <option value="SI">SI</option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-2">
                    <div class="form-group">
                    <label style="color: white"> 6</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><strong>6°</strong></span>
                        </div>
                        <select class="form-control bloquear" name="isexto" id="isexto" required>
                          <option selected ><?php echo $datos['users_6to'];?></option>
                          <option value="N/A">N/A</option>
                          <option value="SI">SI</option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-2">
                    <div class="form-group">
                    <label style="color: white"> 7</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><strong>7°</strong></span>
                        </div>
                        <select class="form-control bloquear" name="iseptimo" id="iseptimo" required>
                          <option selected ><?php echo $datos['users_7mo'];?></option>
                          <option value="N/A">N/A</option>
                          <option value="SI">SI</option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-2">
                    <div class="form-group">
                    <label style="color: white"> 8</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><strong>8°</strong></span>
                        </div>
                        <select class="form-control bloquear" name="ioctavo" id="ioctavo" required>
                          <option selected ><?php echo $datos['users_8vo'];?></option>
                          <option value="N/A">N/A</option>
                          <option value="SI">SI</option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-2">
                    <div class="form-group">
                    <label style="color: white"> 9</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><strong>9°</strong></span>
                        </div>
                        <select class="form-control bloquear" name="inoveno" id="inoveno" required>
                          <option selected ><?php echo $datos['users_9no'];?></option>
                          <option value="N/A">N/A</option>
                          <option value="SI">SI</option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- col -->

                  <div class="col-sm-2">
                    <div class="form-group">
                    <label style="color: white"> 10</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><strong>10°</strong></span>
                        </div>
                        <select class="form-control bloquear" name="idecimo" id="idecimo" required>
                          <option selected ><?php echo $datos['users_10mo'];?></option>
                          <option value="N/A">N/A</option>
                          <option value="SI">SI</option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- col -->
                  
                  <div class="col-sm-2">
                    <div class="form-group">
                    <label style="color: white"> 11</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><strong>11°</strong></span>
                        </div>
                        <select class="form-control bloquear" name="iundecimo" id="iundecimo" required>
                          <option selected ><?php echo $datos['users_11mo'];?></option>
                          <option value="N/A">N/A</option>
                          <option value="SI">SI</option>
                        </select>
                      </div>
                    </div>
                  </div> <!-- col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->



          <div class="card-footer">
            <input type="hidden" name="user" value="actualizar">
            <input type="hidden" name="nivel" id="nivel"  value="<?php echo $datos2['logins_nivel'];?>">
            <input type="hidden" name="id_logins" value="<?php echo $datos2['logins_id_login'];?>">


              <button type="submit" class="btn btn-success">Actualizar</button>

          </div>
        </form>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <?php
    include_once 'templates/footer.php';
    endif;
  ?>
