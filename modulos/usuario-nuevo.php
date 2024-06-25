<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once  SESIONES;

if (isset($_GET['atc'])) {
  if (filter_var($_GET['atc'] == 1)) {
    $ejecutar_jr = $_GET['atc'];
    $id = $_GET['id'];
    $titulo = 'ACTUALIZAR USUARIO';
    $tex_btn = 'Actualizar';
  } else {
    die("ERROR! Los parámetros no son válidos");
  }
} else {
  $titulo = 'USUARIO NUEVO';
  $tex_btn = 'Registrar';
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
      <div class="container-fluid cajon form-customizado" data-modelo="../modelos/usuarios-modelo.php" id="mat_nueva">

        <div class="card card-navy">
          <div class="card-header">

            <h3 class="card-title"><i class="fa fa-user"></i> Datos del usuario</h3>

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
                      <option value="CC">CC</option>
                      <option value="CE">CE</option>
                      <option disabled>-</option>
                      <option value="CI (VZLA)" title="Cédula de Identidad Venezolana">CI (VZLA)</option>
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
                  <label>Rol</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>
                    <select class="form-control" name="use_rol" id="use_rol" data-tipo="solotexto" required>
                      <option disabled selected> </option>
                      <option value="RECTOR(A)">RECTOR(A)</option>
                      <option value="COORDINADOR(A)">COORDINADOR(A)</option>
                      <option value="COORD. ICFES">COORD. ICFES</option>
                      <option value="SECRETARIA">SECRETARIA</option>
                      <option value="DOCENTE">DOCENTE</option>
                      <option value="PSICÓLOGO">PSICÓLOGO</option>
                      <option value="SYSTEM ADMIN">SYSTEM ADMIN</option>
                    </select>
                    <div class="invalid-feedback">
                      Este campo es obligatorio.
                    </div>
                  </div>
                </div>
              </div> <!-- col -->

            </div>
            <!-- /.Información del Usuario -->

          </div><!-- /.container-fluid -->
        </div>

        <div id="docente-container"></div>

        <div class="card-footer">
          <input type="hidden" name="cmd" id="cmd" value="usuario-nuevo">
          <input type="hidden" name="user-id" id="user-id" value="<?php echo $_SESSION['logid'] ?>">
          <button type="button" class="btn btn-success" id="btn-submit"><?php echo $tex_btn ?></button>
          <button type="button" class="btn btn-secondary" onclick="window.location.reload();">Reiniciar</button>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php

  // Footer
  require_once FOOTER;

  ?>

  <script>
    function crearContainerDocente(mats) {
      let container = document.querySelector('#docente-container');

      const gradosDiv = document.createElement("div");
      gradosDiv.innerHTML = `
        <div class="card card-secondary">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-users"></i>Datos Operativos</h3>
          </div>
          <div class="card-body">
            <div class="row">

              <div class="col-12 col-sm-7">
                <div class="form-group">
                  <label>Materias</label>
                  <div class="select2-primary">
                    <select class="select2 form-control" multiple="multiple" style="width: 100%;" name="pro_mat" id="pro_mat" data-tipo="solotexto">
                    <option>SOCIALES</option>
                    <option>ESPAÑOL</option>
                    <option>MATEMÁTICAS</option>
                    <option>NATURALES</option>
                    <option>INGLÉS</option>
                    <option>INFORMÁTICA</option>
                    <option>ÉTICA Y RELIGIÓN</option>
                    <option>ARTÍSTICA</option>
                    <option>DEPORTE</option>
                    <option>MÚSICA</option>
                    <option>LECTORES</option>
                    <option>PESP</option>
                    <option>GLOBALIZACIÓN</option>
                    <option>CORPORAL</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-sm-3">
                <div class="form-group">
                  <label>Dirección de grupo</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                    </div>
                    <select class="form-control" name="pro_dgr" id="pro_dgr" data-tipo="solotexto">
                      <option disabled selected> </option>
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

              <div class="col-sm-2">
              <div class="form-group">
                <label>Sección</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                  </div>
                  <select class="form-control" name="pro_dgs" id="pro_dgs" data-tipo="solotexto">
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

            </div>
            <div id="docente-container2"></div>
          </div>
        </div>
      `;
      container.appendChild(gradosDiv);

      if (mats !== 'new') {
        $('#pro_mat option').each(function() {
          if (mats.includes($(this).text())) {
            $(this).prop('selected', true);
          }
        });
      }

      $('#pro_mat').select2();
      checksDiv(mats, 1)

      $('#pro_mat').on("select2:select select2:unselect", function(crrSelect) {
        const materias = Array.from(crrSelect.target.selectedOptions).map(
          (option) => option.value
        );
        checksDiv(materias, 2)
      });
    }

    function checksDiv(mats, cmd) {
      const container2 = document.getElementById("docente-container2");

      const matArray = mats

      const codMats = {
        'SOCIALES': 'soc',
        'ESPAÑOL': 'esp',
        'MATEMÁTICAS': 'mat',
        'NATURALES': 'nat',
        'INGLÉS': 'ing',
        'INFORMÁTICA': 'inf',
        'ÉTICA Y RELIGIÓN': 'eyr',
        'ARTÍSTICA': 'art',
        'DEPORTE': 'dep',
        'MÚSICA': 'mus',
        'LECTORES': 'lec',
        'PESP': 'psp',
        'GLOBALIZACIÓN': 'glo',
        'CORPORAL': 'cor'
      }

      if (cmd === 2) {
        for (const key in codMats) {
          Object.hasOwnProperty.call(codMats, key)
          if (!mats.includes(key)) {
            const divRemove = document.querySelector(`#${codMats[key]}`)
            divRemove ? divRemove.remove() : ''
          }
        }
      }

      if (mats !== 'new') {
        matArray.forEach((materia) => {

          let materiaDiv = document.querySelector(`#${codMats[materia]}`)

          if (materiaDiv) {
            return
          } else {
            materiaDiv = document.createElement("div");

            materiaDiv.innerHTML = `
              <div class="card card-secondary" id="${codMats[materia]}">
                <div class="card-header">
                  <h3 class="card-title"><i class="fa fa-users"></i> Grados (${materia})</h3>
                </div>
                <div class="card-body">
                  <div class="row">
                  </div>
                </div>
              </div>
            `;
          }

          const checkboxesRow = materiaDiv.querySelector(".row");

          for (let i = 1; i <= 14; i++) {
            const checkboxCol = document.createElement("div");
            checkboxCol.classList.add("col-sm-3");

            checkboxCol.innerHTML = `
              <div class="form-group">
                <div class="input-group">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value=0 name="on${codMats[materia] + i}" id="on${codMats[materia] + i}" data-tipo="solonumero">
                    <label class="form-check-label" for="on${codMats[materia] + i}">
                      ${i}°
                    </label>
                  </div>
                  <div class="invalid-feedback">
                    Este campo es obligatorio.
                  </div>
                </div>
              </div>
            `;

            checkboxesRow.appendChild(checkboxCol);
          }

          container2.appendChild(materiaDiv);

        });

        const checkboxes = document.querySelectorAll(".form-check-input");
        checkboxes.forEach((checkbox) => {
          checkbox.onclick = (event) => {
            const checkboxValue = event.target.checked;
            if (checkboxValue) {
              checkbox.setAttribute("checked", "checked");
              event.target.value = 1;
            } else {
              checkbox.removeAttribute("checked");
              event.target.value = 0;
            }
          };
        });
      }

    }

    <?php if (isset($ejecutar_jr) && $ejecutar_jr == 1) : ?>
      const formComando = document.querySelector("#cmd");
      formComando.value = 'usuario-actualizar'

      const formAlumId = document.querySelector("#user-id");
      formAlumId.value = <?php echo $id ?>

      const hacerSubmit = async () => {

        try {

          let data = {
            'cmd': 'user-consulta',
            'id': <?php echo $id ?>,
            'user_id': <?php echo $_SESSION['logid'] ?>
          };

          const response = await fetch('../modelos/usuarios-modelo.php', {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify(data),
          });

          const dataServer = await response.json();

          if (dataServer.respuesta === 'exito') {

            const datos = JSON.parse(dataServer.datos['datos'])

            if (datos.use_rol === 'DOCENTE') {
              crearContainerDocente(datos.pro_mat)
            }

            Object.entries(datos).forEach(([key, value]) => {

              if (key !== 'fec_mat' && key !== 'alu_fol' && key !== 'estatus' && key !== 'pro_mat') {
                let input = document.querySelector(`#${key}`);
                //console.log(key + ' ' + value);

                if (input.type === 'checkbox' && value == 1) {
                  input.setAttribute('checked', true);
                }

                input.value = value
              }
              
            })

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

    const inputRol = document.querySelector("#use_rol");
    inputRol.addEventListener("change", async (e) => {

      if (e.target.value === "DOCENTE") {
        crearContainerDocente('new')
      } else {
        const teacherContainer = document.querySelector('#docente-container').firstChild
        teacherContainer ? teacherContainer.remove() : ''
      }

    });
  </script>

<?php

endif;

?>