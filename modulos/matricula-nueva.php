<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once  SESIONES;

if (isset($_GET['atc'])) {
  if (filter_var($_GET['atc'] == 1)) {
    $ejecutar_jr = $_GET['atc'];
    $id = $_GET['id'];
    $titulo = 'ACTUALIZAR MATRÍCULA';
    $tex_btn = 'Actualizar';
  } else {
    die("ERROR! Los parámetros no son válidos");
  }
} else {
  $titulo = 'MATRÍCULA NUEVA';
  $tex_btn = 'Matricular';
}

if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 5) :

  require_once FUNCIONES;

  // Templates
  require_once HEADER;
  require_once BARRA;
  require_once NAVEGACION;
  // Modulo
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
              <?php echo $titulo ?>
            </h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid cajon form-customizado" data-modelo="../modelos/matricula-modelo.php" id="mat_nueva">

        <div class="card card-navy">
          <div class="card-header">

            <h3 class="card-title"><i class="fa fa-user"></i> Información del Alumno</h3>

          </div>
          <!-- /.card-header -->
          <div class="card-body">

            <div class="row">

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Tipo de identificación</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>
                    <select class="form-control" name="ide_tip" id="ide_tip" data-tipo="solotexto" required>
                      <option disabled selected> </option>
                      <option value="NUIP">NUIP</option>
                      <option value="TI">TI</option>
                      <option value="RC">RC</option>
                      <option value="CC">CC</option>
                      <option disabled>-</option>
                      <option value="CI (VZLA)" title="Cédula de Identidad Venezolana">CI (VZLA)</option>
                      <option value="PN (VZLA)" title="Partida de nacimiento Venezolana">PN (VZLA)</option>
                      <option value="PP (VZLA)" title="Pasaporte Venezolano">PP (VZLA)</option>
                      <option value="PPT (VZLA)" title="Permiso de Protección Temporal">PPT (VZLA)</option>
                      <option value="PEP (VZLA)" title="Permiso Especial de Permanencia">PEP (VZLA)</option>
                    </select>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Numero de identificación</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <input type="text" class="form-control" name="ide_num" id="ide_num" data-tipo="solonumero" required>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Lugar de expedición</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <input type="text" class="form-control" name="ide_exp" id="ide_exp" data-tipo="solotexto" required>
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
                    <input type="text" class="form-control" name="per_ape" id="per_ape" data-tipo="solotexto" required>
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
                    <input type="text" class="form-control" name="sdo_ape" id="sdo_ape" data-tipo="solotexto">
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
                    <input type="text" class="form-control" name="per_nom" id="per_nom" data-tipo="solotexto" required>
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
                    <input type="text" class="form-control" name="sdo_nom" id="sdo_nom" data-tipo="solotexto">
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
                    <input type="text" class="form-control" name="nac_fec" id="nac_fec" data-tipo="fecha" required placeholder="dd/mm/aaa">
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Edad</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control soloLectura" name="age_num" id="age_num" data-tipo="solonumero" required>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
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
                    <select class="form-control" name="alu_gen" id="alu_gen" data-tipo="solotexto">
                      <option disabled selected> </option>
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
                  <label>Dep. de nacimiento</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <select class="form-control" name="nac_dep" id="nac_dep" data-tipo="solotexto" required>
                      <?php
                      try {
                        $stmt = $conn->prepare("SELECT * FROM siscpi_departamentos");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $atlanticoImprimido = false;
                        while ($departamentos = $result->fetch_assoc()) {
                          if ($departamentos['departamento'] == 'ATLANTICO' && !$atlanticoImprimido) {
                            $atlanticoImprimido = true; ?>
                            <option value="<?php echo htmlspecialchars($departamentos['departamento']) ?>" data-ide="<?php echo htmlspecialchars($departamentos['id']) ?>" selected><?php echo htmlspecialchars($departamentos['departamento']) ?></option>
                          <?php } else { ?>
                            <option value="<?php echo htmlspecialchars($departamentos['departamento']) ?>" data-ide="<?php echo htmlspecialchars($departamentos['id']) ?>"><?php echo htmlspecialchars($departamentos['departamento']) ?></option>
                      <?php }
                        }
                      } catch (\Exception $e) {
                        $error = $e->getMessage();
                        echo $error;
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Mun. de nacimiento</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <select class="form-control" name="nac_mun" id="nac_mun" data-tipo="solotexto" required>
                      <?php
                      try {
                        $id_dep = 2;
                        $stmt = $conn->prepare("SELECT * FROM siscpi_municipios WHERE id_departamento=?");
                        $stmt->bind_param("i", $id_dep);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $malamboImprimido = false;
                        while ($municipios = $result->fetch_assoc()) {
                          if ($municipios['municipio'] == 'MALAMBO' && !$malamboImprimido) {
                            $malamboImprimido = true; ?>
                            <option value="<?php echo htmlspecialchars($municipios['municipio']) ?>" data-ide="<?php echo htmlspecialchars($municipios['id']) ?>" selected><?php echo htmlspecialchars($municipios['municipio']) ?></option>
                          <?php } else { ?>
                            <option value="<?php echo htmlspecialchars($municipios['municipio']) ?>" data-ide="<?php echo htmlspecialchars($municipios['id']) ?>"><?php echo htmlspecialchars($municipios['municipio']) ?></option>
                      <?php }
                        }
                      } catch (\Exception $e) {
                        $error = $e->getMessage();
                        echo $error;
                      }
                      ?>

                    </select>
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Dirección Residencia</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <input type="text" class="form-control" name="dir_dir" id="dir_dir" data-tipo="direccion">
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
                    <input type="text" class="form-control" name="dir_bar" id="dir_bar" data-tipo="direccion">
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Localidad</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <input type="text" class="form-control" name="dir_loc" id="dir_loc" data-tipo="direccion">
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Teléfono de Emergencias</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <input type="text" class="form-control" name="tel_mov" id="tel_mov" data-tipo="telefono" data-inputmask='"mask": "(999) 999-9999"' data-mask>
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
                    <input type="text" class="form-control" name="alu_mai" id="alu_mai" data-tipo="correo">
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Estrato</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <select class="form-control" name="alu_est" id="alu_est" data-tipo="solonumero">
                      <option disabled selected> </option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                    </select>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Nivel Sisben</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <input type="text" class="form-control soloLectura" name="sis_niv" id="sis_niv" data-tipo="solonumero" required>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-3">
                <div class="form-group">
                  <label>G. Etnico</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <select class="form-control" name="alu_get" id="alu_get" data-tipo="solotexto">
                      <option disabled selected> </option>
                      <option value="RAIZALES">RAIZALES</option>
                      <option value="AFROCOLOMBIANOS">AFROCOLOMBIANOS</option>
                      <option value="MOCANA">MOCANA</option>
                      <option value="OTRO">OTRO</option>
                      <option value="NINGUNO">NINGUNO</option>
                    </select>
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
        <!-- /.Información del Alumno -->

        <div class="card card-navy">
          <div class="card-header">

            <h3 class="card-title"><i class="fa fa-user"></i> Historia Académica</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            <div class="row">

              <div class="row col-sm-6">
                <div class="col-sm-10">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><strong>P</strong></i></span>
                      </div>
                      <input type="text" class="form-control" name="n96_nom" id="n96_nom" data-tipo="textoynumero">
                    </div>
                  </div>
                </div> <!-- col -->

                <div class="col-sm-2">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="n96_ani" id="n96_ani" data-tipo="solonumero" placeholder="Año">
                    </div>
                  </div>
                </div> <!-- col -->

              </div>
              <!-- /.row -->

              <div class="row col-sm-6">
                <div class="col-sm-10">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><strong>PJ</strong></i></span>
                      </div>
                      <input type="text" class="form-control" name="n97_nom" id="n97_nom" data-tipo="textoynumero">
                    </div>
                  </div>
                </div> <!-- col -->

                <div class="col-sm-2">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="n97_ani" id="n97_ani" data-tipo="solonumero" placeholder="Año">
                    </div>
                  </div>
                </div> <!-- col -->

              </div>
              <!-- /.row -->

              <div class="row col-sm-6">
                <div class="col-sm-10">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><strong>J</strong></i></span>
                      </div>
                      <input type="text" class="form-control" name="n98_nom" id="n98_nom" data-tipo="textoynumero">
                    </div>
                  </div>
                </div> <!-- col -->

                <div class="col-sm-2">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="n98_ani" id="n98_ani" data-tipo="solonumero" placeholder="Año">
                    </div>
                  </div>
                </div> <!-- col -->

              </div>
              <!-- /.row -->

              <div class="row col-sm-6">
                <div class="col-sm-10">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><strong>T</strong></i></span>
                      </div>
                      <input type="text" class="form-control" name="n99_nom" data-tipo="textoynumero" id="n99_nom">
                    </div>
                  </div>
                </div> <!-- col -->

                <div class="col-sm-2">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="n99_ani" id="n99_ani" data-tipo="solonumero" placeholder="Año">
                    </div>
                  </div>
                </div> <!-- col -->

              </div>
              <!-- /.row -->

              <div class="row col-sm-6">
                <div class="col-sm-10">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><strong>1</strong></i></span>
                      </div>
                      <input type="text" class="form-control" name="n1_nom" id="n1_nom" data-tipo="textoynumero">
                    </div>
                  </div>
                </div> <!-- col -->

                <div class="col-sm-2">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="n1_ani" id="n1_ani" data-tipo="solonumero" placeholder="Año">
                    </div>
                  </div>
                </div> <!-- col -->

              </div>
              <!-- /.row -->

              <div class="row col-sm-6">
                <div class="col-sm-10">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><strong>2</strong></i></span>
                      </div>
                      <input type="text" class="form-control" name="n2_nom" id="n2_nom" data-tipo="textoynumero">
                    </div>
                  </div>
                </div> <!-- col -->

                <div class="col-sm-2">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="n2_ani" id="n2_ani" data-tipo="solonumero" placeholder="Año">
                    </div>
                  </div>
                </div> <!-- col -->

              </div>
              <!-- /.row -->

              <div class="row col-sm-6">
                <div class="col-sm-10">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><strong>3</strong></i></span>
                      </div>
                      <input type="text" class="form-control" name="n3_nom" id="n3_nom" data-tipo="textoynumero">
                    </div>
                  </div>
                </div> <!-- col -->

                <div class="col-sm-2">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="n3_ani" id="n3_ani" data-tipo="solonumero" placeholder="Año">
                    </div>
                  </div>
                </div> <!-- col -->

              </div>
              <!-- /.row -->

              <div class="row col-sm-6">
                <div class="col-sm-10">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><strong>4</strong></i></span>
                      </div>
                      <input type="text" class="form-control" name="n4_nom" id="n4_nom" data-tipo="textoynumero">
                    </div>
                  </div>
                </div> <!-- col -->

                <div class="col-sm-2">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="n4_ani" id="n4_ani" data-tipo="solonumero" placeholder="Año">
                    </div>
                  </div>
                </div> <!-- col -->

              </div>
              <!-- /.row -->

              <div class="row col-sm-6">
                <div class="col-sm-10">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><strong>5</strong></i></span>
                      </div>
                      <input type="text" class="form-control" name="n5_nom" id="n5_nom" data-tipo="textoynumero">
                    </div>
                  </div>
                </div> <!-- col -->

                <div class="col-sm-2">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="n5_ani" id="n5_ani" data-tipo="solonumero" placeholder="Año">
                    </div>
                  </div>
                </div> <!-- col -->

              </div>
              <!-- /.row -->

              <div class="row col-sm-6">
                <div class="col-sm-10">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><strong>6</strong></i></span>
                      </div>
                      <input type="text" class="form-control" name="n6_nom" id="n6_nom" data-tipo="textoynumero">
                    </div>
                  </div>
                </div> <!-- col -->

                <div class="col-sm-2">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="n6_ani" id="n6_ani" data-tipo="solonumero" placeholder="Año">
                    </div>
                  </div>
                </div> <!-- col -->

              </div>
              <!-- /.row -->

              <div class="row col-sm-6">
                <div class="col-sm-10">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><strong>7</strong></i></span>
                      </div>
                      <input type="text" class="form-control" name="n7_nom" id="n7_nom" data-tipo="textoynumero">
                    </div>
                  </div>
                </div> <!-- col -->

                <div class="col-sm-2">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="n7_ani" id="n7_ani" data-tipo="solonumero" placeholder="Año">
                    </div>
                  </div>
                </div> <!-- col -->

              </div>
              <!-- /.row -->

              <div class="row col-sm-6">
                <div class="col-sm-10">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><strong>8</strong></i></span>
                      </div>
                      <input type="text" class="form-control" name="n8_nom" id="n8_nom" data-tipo="textoynumero">
                    </div>
                  </div>
                </div> <!-- col -->

                <div class="col-sm-2">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="n8_ani" id="n8_ani" data-tipo="solonumero" placeholder="Año">
                    </div>
                  </div>
                </div> <!-- col -->

              </div>
              <!-- /.row -->

              <div class="row col-sm-6">
                <div class="col-sm-10">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><strong>9</strong></i></span>
                      </div>
                      <input type="text" class="form-control" name="n9_nom" id="n9_nom" data-tipo="textoynumero">
                    </div>
                  </div>
                </div> <!-- col -->

                <div class="col-sm-2">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="n9_ani" id="n9_ani" data-tipo="solonumero" placeholder="Año">
                    </div>
                  </div>
                </div> <!-- col -->

              </div>
              <!-- /.row -->

              <div class="row col-sm-6">
                <div class="col-sm-10">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><strong>10</strong></i></span>
                      </div>
                      <input type="text" class="form-control" name="n10_nom" id="n10_nom" data-tipo="textoynumero">
                    </div>
                  </div>
                </div> <!-- col -->

                <div class="col-sm-2">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="n10_ani" id="n10_ani" data-tipo="solonumero" placeholder="Año">
                    </div>
                  </div>
                </div> <!-- col -->

              </div>
              <!-- /.row -->

              <div class="row col-sm-6">
                <div class="col-sm-10">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><strong>11</strong></i></span>
                      </div>
                      <input type="text" class="form-control" name="n11_nom" id="n11_nom" data-tipo="textoynumero">
                    </div>
                  </div>
                </div> <!-- col -->

                <div class="col-sm-2">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="n11_ani" id="n11_ani" data-tipo="solonumero" placeholder="Año">
                    </div>
                  </div>
                </div> <!-- col -->

              </div>
              <!-- /.row -->

            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- Historia Académica-->

        <div class="card card-navy">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-user"></i> Información de los Padres y Acudientes</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            <div class="row caja-fondo">

              <div class="row col-sm-12" style="text-align: center;">
                <p style="margin:auto;">
                  <span badge-pill style="background-color: #001F3F; color: white; border-radius: 10px; padding-left: 10px; padding-right: 10px;">MADRE</span>
                </p><br><br>
              </div>

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Numero de documento</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <input type="text" class="form-control" name="mad_doc" id="mad_doc" data-tipo="solonumero">
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Nombre y Apellido</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <input type="text" class="form-control" name="mad_nom" id="mad_nom" data-tipo="solotexto">
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
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
                    <input type="text" class="form-control" name="mad_cel" id="mad_cel" data-tipo="telefono" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Ocupación:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <input type="text" class="form-control" name="mad_ocu" id="mad_ocu" data-tipo="solotexto">
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
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
                    <input type="text" class="form-control" name="mad_mai" id="mad_mai" data-tipo="correo">
                  </div>
                </div>
              </div> <!-- col -->

            </div>
            <!-- /.row -->

            <br>

            <div class="row caja-fondo">

              <div class="row col-sm-12" style="text-align: center;">
                <p style="margin:auto;">
                  <span badge-pill style="background-color: #001F3F; color: white; border-radius: 10px; padding-left: 10px; padding-right: 10px;">PADRE</span>
                </p><br><br>
              </div>

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Numero de documento</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <input type="text" class="form-control" name="pad_doc" id="pad_doc" data-tipo="solonumero">
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Nombre y Apellido</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <input type="text" class="form-control" name="pad_nom" id="pad_nom" data-tipo="solotexto">
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
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
                    <input type="text" class="form-control" name="pad_cel" id="pad_cel" data-tipo="telefono" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Ocupación:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <input type="text" class="form-control" name="pad_ocu" id="pad_ocu" data-tipo="solotexto">
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
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
                    <input type="text" class="form-control" name="pad_mai" id="pad_mai" data-tipo="correo">
                  </div>
                </div>
              </div> <!-- col -->


            </div>
            <!-- /.row -->

            <br>

            <div class="row caja-fondo">

              <div class="row col-sm-12" style="text-align: center;">
                <p style="margin:auto;">
                  <span badge-pill style="background-color: #001F3F; color: white; border-radius: 10px; padding-left: 10px; padding-right: 10px;">ACUDIENTE</span>
                </p><br><br>
              </div>

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Parentesco</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>
                    <select class="form-control" name="acu_par" id="acu_par" data-tipo="solotexto" required>
                      <option disabled selected> </option>
                      <option value="MADRE">MADRE</option>
                      <option value="PADRE">PADRE</option>
                      <option value="ABUELO(A)">ABUELO(A)</option>
                      <option value="TÍO(A)">TÍO(A)</option>
                      <option value="HERMANO(A)">HERMANO(A)</option>
                      <option value="PRIMO(A)">PRIMO(A)</option>
                      <option value="PADRASTRO/MADRASTRA">PADRASTRO/MADRASTRA</option>
                      <option value="PROFESOR(A)">PROFESOR(A)</option>
                      <option value="VECINO(A)">VECINO(A)</option>
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
                    <input type="text" class="form-control" name="acu_doc" id="acu_doc" data-tipo="solonumero" required>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Nombre y Apellido</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <input type="text" class="form-control" name="acu_nom" id="acu_nom" data-tipo="solotexto" required>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
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
                    <input type="text" class="form-control" name="acu_cel" id="acu_cel" data-tipo="telefono" data-inputmask='"mask": "(999) 999-9999"' data-mask required>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Ocupación:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <input type="text" class="form-control" name="acu_ocu" id="acu_ocu" data-tipo="solotexto">
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
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
                    <input type="text" class="form-control" name="acu_mai" id="acu_mai" data-tipo="correo">
                  </div>
                </div>
              </div> <!-- col -->


            </div>
            <!-- /.row -->


          </div>
          <!-- /.card-body -->
        </div>
        <!-- Información de los Padres y Acudientes-->

        <div class="card card-navy">
          <div class="card-header">

            <h3 class="card-title"><i class="fa fa-user"></i> Datos Institucionales</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            <div class="row">

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Año escolar</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <?php
                    $anio_actual = 2023;
                    ?>
                    <input disabled type="text" class="form-control" name="ani_esc" id="ani_esc" data-tipo="solonumero" value="2023" required>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Grado</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>
                    <select class="form-control" name="gra_esc" id="gra_esc" data-tipo="solotexto" required>
                      <option disabled selected> </option>
                      <option value="PRE JARDÍN">PRE JARDÍN</option>
                      <option value="JARDÍN">JARDÍN</option>
                      <option value="TRANSICIÓN">TRANSICIÓN</option>
                      <option value="PRIMERO">PRIMERO</option>
                      <option value="SEGUNDO">SEGUNDO</option>
                      <option value="TERCERO">TERCERO</option>
                      <option value="CUARTO">CUARTO</option>
                      <option value="QUINTO">QUINTO</option>
                      <option value="SEXTO">SEXTO</option>
                      <option value="SÉPTIMO">SÉPTIMO</option>
                      <option value="OCTAVO">OCTAVO</option>
                      <option value="NOVENO">NOVENO</option>
                      <option value="DÉCIMO">DÉCIMO</option>
                      <option value="UNDÉCIMO">UNDÉCIMO</option>
                    </select>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
                  </div>
                </div>
              </div> <!-- col -->

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Jornada</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>
                    <select class="form-control" name="gra_jor" id="gra_jor" data-tipo="solotexto" required>
                      <option disabled selected> </option>
                      <option value="MAÑANA">MAÑANA</option>
                      <option value="TARDE">TARDE</option>
                    </select>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
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
                    <select class="form-control" name="gra_sec" id="gra_sec" data-tipo="solotexto" required>
                      <option disabled selected> </option>
                      <option value="A">A</option>
                      <option value="B">B</option>
                      <option value="U">U</option>
                    </select>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
                  </div>
                </div>
              </div> <!-- col -->
              

              <div class="col-sm-12">
                <div class="form-group">
                  <label>Observacion</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                    </div>
                    <textarea type="text" class="form-control" name="obs_mat" id="obs_mat" data-tipo="textoynumero"></textarea>
                  </div>
                </div>
              </div> <!-- col -->

            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- Datos Institucionales -->


        <div class="card-footer">
          <input type="hidden" name="cmd" id="cmd" value="alumno-nuevo">
          <input type="hidden" name="user-id" id="user-id" value="<?php echo $_SESSION['logid'] ?>">
          <input type="hidden" name="alum-id" id="alum-id" value=0>
          <button type="button" class="btn btn-success" id="btn-submit"><?php echo $tex_btn ?></button>
          <button type="button" class="btn btn-secondary" onclick="window.location.reload();">Reiniciar</button>
        </div>

        <br>

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
    <?php if (isset($ejecutar_jr) && $ejecutar_jr == 1) : ?>
      const formComando = document.querySelector("#cmd");
      formComando.value = 'alumno-actualizar'

      const formAlumId = document.querySelector("#alum-id");
      formAlumId.value = <?php echo $id ?>

      const hacerSubmit = async () => {

        try {
          let data = {
            'cmd': 'alumno-consulta',
            'id': <?php echo $id ?>,
            'user_id': <?php echo $_SESSION['logid'] ?>
          };
          const response = await fetch('../modelos/matricula-modelo.php', {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify(data),
          });
          const dataServer = await response.json();

          if (dataServer.respuesta === 'exito') {

            const datos = JSON.parse(dataServer.datos['datos'])

            Object.entries(datos).forEach(([key, value]) => {

              if (key !== 'fec_mat' && key !== 'alu_fol' && key !== 'estatus') {
                let input = document.querySelector(`#${key}`);
                console.log(key+' '+value);
                
                input.value = value
                /*
                if (input.type === 'checkbox' && value == 1) {
                  input.setAttribute('checked', true);
                }
                */
              }

            });

          }

          if (dataServer.respuesta === 'error') {
            console.log('Errorazo');
          }



        } catch (error) {
          console.error(error);
        }

      }

      hacerSubmit()

    <?php endif; ?>
  </script>

<?php

endif;

?>