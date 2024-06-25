<?php
$nivel = 2;
define('GRADOS1', [
  1 => array('PRIMERO', 'PRI', 'mat_logros_pri_p', ['U']),
  2 => array('SEGUNDO', 'PRI', 'mat_logros_pri_p', ['U']),
  3 => array('TERCERO', 'PRI', 'mat_logros_pri_p', ['U']),
  4 => array('CUARTO', 'PRI', 'mat_logros_pri_p', ['U']),
  5 => array('QUINTO', 'PRI', 'mat_logros_pri_p', ['U']),
  6 => array('SEXTO', 'SEC', 'mat_logros_sec_p', ['U']),
  7 => array('SÉPTIMO', 'SEC', 'mat_logros_sec_p', ['U']),
  8 => array('OCTAVO', 'SEC', 'mat_logros_sec_p', ['A', 'B']),
  9 => array('NOVENO', 'BAC', 'mat_logros_sec_p', ['U']),
  10 => array('DÉCIMO', 'BAC', 'mat_logros_sec_p', ['A', 'B']),
  11 => array('UNDÉCIMO', 'BAC', 'mat_logros_sec_p', ['U']),
  12 => array('PRE JADRÍN', 'TRA', 'mat_logros_tra_p', ['U']),
  13 => array('JARDÍN', 'TRA', 'mat_logros_tra_p', ['U']),
  14 => array('TRANSICIÓN', 'TRA', 'mat_logros_tra_p', ['A', 'B']),
]);

define('GRADOS2', [
  1 => array('PRIMERO', 'PRI', 'mat_logros_pri_p', ['U']),
  2 => array('SEGUNDO', 'PRI', 'mat_logros_pri_p', ['U']),
  3 => array('TERCERO', 'PRI', 'mat_logros_pri_p', ['U']),
  4 => array('CUARTO', 'PRI', 'mat_logros_pri_p', ['U']),
  5 => array('QUINTO', 'PRI', 'mat_logros_pri_p', ['U']),
  6 => array('SEXTO', 'SEC', 'mat_logros_sec_p', ['U']),
  7 => array('SÉPTIMO', 'SEC', 'mat_logros_sec_p', ['U']),
  8 => array('OCTAVO', 'SEC', 'mat_logros_sec_p', ['A', 'B']),
  9 => array('NOVENO', 'BAC', 'mat_logros_sec_p', ['U']),
  10 => array('DÉCIMO', 'BAC', 'mat_logros_sec_p', ['A', 'B']),
  11 => array('UNDÉCIMO', 'BAC', 'mat_logros_sec_p', ['U']),
]);

?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-light-navy">
  <!-- Brand Logo -->
  <a href="#" class="brand-link navbar-info text-lg bg-navy" style="padding:8px">
    <img src=<?php echo DIST . "img/cpi_logo.png" ?> alt="Sistema CPI Logo" class="brand-image img-circle elevation-0">
    <span class="brand-text">SISTEMA CPI</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <!--<div class="image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>-->
      <div class="info">
        <a href="#" class="d-block"><?php echo $_SESSION['nombre']; ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-child-indent nav-compact" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview">
          <a href=<?php echo PRINCIPAL . "index.php" ?> class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Inicio
            </p>
          </a>
        </li>


        <?php if ($_SESSION['nivel'] === 1 || $_SESSION['nivel'] === 5) : ?>
          <!-- Modulo de Matrículas -->
          <li class="nav-item has-treeview">

            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Gestión Matrícula
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">

              <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 3 || $_SESSION['nivel'] === 5) : ?>
                <li class="nav-item">
                  <a href=<?php echo MODULOS . "matricula-nueva.php" ?> class="nav-link">
                    <i class="far fas fa-user-plus nav-icon"></i>
                    <p>Matricular</p>
                  </a>
                </li>
              <?php endif; ?>

              <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 3) : ?>
                <li class="nav-item">
                  <a href="pages/charts/flot.html" class="nav-link">
                    <i class="far fas fa-users nav-icon"></i>
                    <p>Mat. Lotes
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">

                    <?php if ($_SESSION['nivel'] == 1) : ?>
                      <li class="nav-item">
                        <a href=<?php echo MODULOS . "matricula-lotes.php?grado=97" ?> class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Pre Jardín</p>
                        </a>
                      </li>
                    <?php endif; ?>

                    <?php if ($_SESSION['nivel'] == 1) : ?>
                      <li class="nav-item">
                        <a href=<?php echo MODULOS . "matricula-lotes.php?grado=98" ?> class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Jardín</p>
                        </a>
                      </li>
                    <?php endif; ?>

                    <?php if ($_SESSION['nivel'] == 1) : ?>
                      <li class="nav-item">
                        <a href=<?php echo MODULOS . "matricula-lotes.php?grado=99" ?> class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Transición</p>
                        </a>
                      </li>
                    <?php endif; ?>

                    <?php if ($_SESSION['nivel'] == 1) : ?>
                      <li class="nav-item">
                        <a href=<?php echo MODULOS . "matricula-lotes.php?grado=1" ?> class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Primero</p>
                        </a>
                      </li>
                    <?php endif; ?>

                    <?php if ($_SESSION['nivel'] == 1) : ?>
                      <li class="nav-item">
                        <a href=<?php echo MODULOS . "matricula-lotes.php?grado=2" ?> class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Segundo</p>
                        </a>
                      </li>
                    <?php endif; ?>

                    <?php if ($_SESSION['nivel'] == 1) : ?>
                      <li class="nav-item">
                        <a href=<?php echo MODULOS . "matricula-lotes.php?grado=3" ?> class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Tercero</p>
                        </a>
                      </li>
                    <?php endif; ?>

                    <?php if ($_SESSION['nivel'] == 1) : ?>
                      <li class="nav-item">
                        <a href=<?php echo MODULOS . "matricula-lotes.php?grado=4" ?> class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Cuarto</p>
                        </a>
                      </li>
                    <?php endif; ?>

                    <?php if ($_SESSION['nivel'] == 1) : ?>
                      <li class="nav-item">
                        <a href=<?php echo MODULOS . "matricula-lotes.php?grado=5" ?> class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Quinto</p>
                        </a>
                      </li>
                    <?php endif; ?>

                    <?php if ($_SESSION['nivel'] == 1) : ?>
                      <li class="nav-item">
                        <a href=<?php echo MODULOS . "matricula-lotes.php?grado=6" ?> class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Sexto</p>
                        </a>
                      </li>
                    <?php endif; ?>

                    <?php if ($_SESSION['nivel'] == 1) : ?>
                      <li class="nav-item">
                        <a href=<?php echo MODULOS . "matricula-lotes.php?grado=7" ?> class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Séptimo</p>
                        </a>
                      </li>
                    <?php endif; ?>

                    <?php if ($_SESSION['nivel'] == 1) : ?>
                      <li class="nav-item">
                        <a href=<?php echo MODULOS . "matricula-lotes.php?grado=8" ?> class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Octavo</p>
                        </a>
                      </li>
                    <?php endif; ?>

                    <?php if ($_SESSION['nivel'] == 1) : ?>
                      <li class="nav-item">
                        <a href=<?php echo MODULOS . "matricula-lotes.php?grado=9" ?> class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Noveno</p>
                        </a>
                      </li>
                    <?php endif; ?>

                    <?php if ($_SESSION['nivel'] == 1) : ?>
                      <li class="nav-item">
                        <a href=<?php echo MODULOS . "matricula-lotes.php?grado=10" ?> class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Décimo</p>
                        </a>
                      </li>
                    <?php endif; ?>

                  </ul>
                </li>
              <?php endif; ?>


              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fas fa-users nav-icon"></i>
                  <p>Matriculados
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">

                  <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] === 5) : ?>
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "matricula-lista.php?grado=12" ?> class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pre Jardín</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 5) : ?>
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "matricula-lista.php?grado=13" ?> class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Jardín</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 5) : ?>
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "matricula-lista.php?grado=14" ?> class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Transición</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 5) : ?>
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "matricula-lista.php?grado=1" ?> class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Primero</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 5) : ?>
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "matricula-lista.php?grado=2" ?> class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Segundo</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 5) : ?>
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "matricula-lista.php?grado=3" ?> class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tercero</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 5) : ?>
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "matricula-lista.php?grado=4" ?> class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cuarto</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 5) : ?>
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "matricula-lista.php?grado=5" ?> class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Quinto</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 5) : ?>
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "matricula-lista.php?grado=6" ?> class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Sexto</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 5) : ?>
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "matricula-lista.php?grado=7" ?> class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Séptimo</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 5) : ?>
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "matricula-lista.php?grado=8" ?> class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Octavo</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 5) : ?>
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "matricula-lista.php?grado=9" ?> class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Noveno</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 5) : ?>
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "matricula-lista.php?grado=10" ?> class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Décimo</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 5) : ?>
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "matricula-lista.php?grado=11" ?> class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Undécimo</p>
                      </a>
                    </li>
                  <?php endif; ?>

                </ul>
              </li>

            </ul>
          </li><!-- / Modulo de Matrículas -->

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-secret"></i>
              <p>
                Reportes 2024
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <?php

            foreach (GRADOS1 as $gra_cod => $gra_des) {
              $grado_lista = $gra_des[0];
              $datos = ['gra' => $grado_lista];
              $datos = serialize($datos);
              $datos = urlencode($datos);

            ?>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href=<?php echo MODULOS . "monitor-reportes.php?data=" . $datos ?> class="nav-link">
                    <i class="fas fa-chart-pie nav-icon"></i>
                    <p><?php echo $grado_lista ?></p>
                  </a>
                </li>
              </ul>

            <?php
            }

            ?>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-secret"></i>
              <p>
                Reportes 2023
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <?php

            foreach (GRADOS1 as $gra_cod => $gra_des) {
              $grado_lista = $gra_des[0];
              $datos = ['gra' => $grado_lista];
              $datos = serialize($datos);
              $datos = urlencode($datos);

            ?>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href=<?php echo MODULOS . "monitor-reportes-2023.php?data=" . $datos ?> class="nav-link">
                    <i class="fas fa-chart-pie nav-icon"></i>
                    <p><?php echo $grado_lista ?></p>
                  </a>
                </li>
              </ul>

            <?php
            }

            ?>
          </li>
        <?php endif; ?>

        <?php /*
        <?php if ($_SESSION['nivel'] == 2 || $_SESSION['nivel'] == 1 || $_SESSION['id'] == 44) : ?>
          <!-- Modulo Monitor de Aulas -->
          <li class="nav-item has-treeview">

            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-desktop"></i>
              <p>
                Monitor de Aulas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon far fas fa-users"></i>
                  <p>Salones
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">

                  <li class="nav-item">
                    <a href="av-room5.php?rname=<?php echo 'cpiroomt21588' ?>" class="nav-link">
                      <i class="fas fa-chalkboard-teacher nav-icon"></i>
                      <p>(T) Keisy Camargo</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="av-room5.php?rname=<?php echo 'cpiroomt22687' ?>" class="nav-link">
                      <i class="fas fa-chalkboard-teacher nav-icon"></i>
                      <p>(T) Wendy Arrieta</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-chalkboard-teacher nav-icon"></i>
                      <p>Primero
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g1m3&mat=LENGUAJE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>LENGUAJE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g1m5&mat=CIENCIAS SOCIALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS SOCIALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g1m4&mat=MATEMÁTICAS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MATEMÁTICAS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g1m2&mat=CIENCIAS NATURALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS NATURALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g1m1&mat=INGLÉS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INGLÉS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g1m6&mat=INFORMÁTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INFORMÁTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g1m7&mat=ARTE Y ÉTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>ARTE Y ÉTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g1m8&mat=DEPORTE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>DEPORTE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g1m9&mat=MÚSICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MÚSICA</p>
                        </a>
                      </li>

                    </ul>

                  </li>

                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-chalkboard-teacher nav-icon"></i>
                      <p>Segundo
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g2m3&mat=LENGUAJE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>LENGUAJE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g2m5&mat=CIENCIAS SOCIALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS SOCIALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g2m4&mat=MATEMÁTICAS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MATEMÁTICAS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g2m2&mat=CIENCIAS NATURALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS NATURALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g2m1&mat=INGLÉS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INGLÉS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g2m6&mat=INFORMÁTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INFORMÁTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g2m7&mat=ARTE Y ÉTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>ARTE Y ÉTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g2m8&mat=DEPORTE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>DEPORTE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g2m9&mat=MÚSICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MÚSICA</p>
                        </a>
                      </li>


                    </ul>

                  </li>

                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-chalkboard-teacher nav-icon"></i>
                      <p>Tercero
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g3m3&mat=LENGUAJE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>LENGUAJE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g3m5&mat=CIENCIAS SOCIALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS SOCIALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g3m4&mat=MATEMÁTICAS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MATEMÁTICAS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g3m2&mat=CIENCIAS NATURALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS NATURALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g3m1&mat=INGLÉS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INGLÉS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g3m6&mat=INFORMÁTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INFORMÁTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g3m7&mat=ARTE Y ÉTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>ARTE Y ÉTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g3m8&mat=DEPORTE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>DEPORTE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g3m9&mat=MÚSICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MÚSICA</p>
                        </a>
                      </li>


                    </ul>

                  </li>

                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-chalkboard-teacher nav-icon"></i>
                      <p>Cuarto
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g4m3&mat=LENGUAJE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>LENGUAJE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g4m5&mat=CIENCIAS SOCIALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS SOCIALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g4m4&mat=MATEMÁTICAS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MATEMÁTICAS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g4m2&mat=CIENCIAS NATURALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS NATURALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g4m1&mat=INGLÉS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INGLÉS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g4m6&mat=INFORMÁTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INFORMÁTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g4m7&mat=ARTE Y ÉTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>ARTE Y ÉTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g4m8&mat=DEPORTE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>DEPORTE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g4m9&mat=MÚSICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MÚSICA</p>
                        </a>
                      </li>


                    </ul>

                  </li>

                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-chalkboard-teacher nav-icon"></i>
                      <p>Quinto
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g5m3&mat=LENGUAJE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>LENGUAJE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g5m5&mat=CIENCIAS SOCIALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS SOCIALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g5m4&mat=MATEMÁTICAS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MATEMÁTICAS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g5m2&mat=CIENCIAS NATURALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS NATURALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g5m1&mat=INGLÉS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INGLÉS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g5m6&mat=INFORMÁTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INFORMÁTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g5m7&mat=ARTE Y ÉTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>ARTE Y ÉTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g5m8&mat=DEPORTE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>DEPORTE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g5m9&mat=MÚSICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MÚSICA</p>
                        </a>
                      </li>


                    </ul>

                  </li>

                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-chalkboard-teacher nav-icon"></i>
                      <p>Sexto
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g6m3&mat=LENGUAJE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>LENGUAJE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g6m5&mat=CIENCIAS SOCIALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS SOCIALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g6m4&mat=MATEMÁTICAS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MATEMÁTICAS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g6m2&mat=CIENCIAS NATURALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS NATURALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g6m1&mat=INGLÉS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INGLÉS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g6m6&mat=INFORMÁTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INFORMÁTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g6m7&mat=ARTE Y ÉTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>ARTE Y ÉTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g6m8&mat=DEPORTE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>DEPORTE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g6m9&mat=MÚSICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MÚSICA</p>
                        </a>
                      </li>


                    </ul>

                  </li>

                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-chalkboard-teacher nav-icon"></i>
                      <p>Séptimo
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g7m3&mat=LENGUAJE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>LENGUAJE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g7m5&mat=CIENCIAS SOCIALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS SOCIALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g7m4&mat=MATEMÁTICAS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MATEMÁTICAS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g7m2&mat=CIENCIAS NATURALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS NATURALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g7m1&mat=INGLÉS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INGLÉS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g7m6&mat=INFORMÁTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INFORMÁTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g7m7&mat=ARTE Y ÉTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>ARTE Y ÉTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g7m8&mat=DEPORTE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>DEPORTE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g7m9&mat=MÚSICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MÚSICA</p>
                        </a>
                      </li>


                    </ul>

                  </li>

                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-chalkboard-teacher nav-icon"></i>
                      <p>Octavo
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g8m3&mat=LENGUAJE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>LENGUAJE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g8m5&mat=CIENCIAS SOCIALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS SOCIALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g8m4&mat=MATEMÁTICAS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MATEMÁTICAS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g8m2&mat=CIENCIAS NATURALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS NATURALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g8m1&mat=INGLÉS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INGLÉS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g8m6&mat=INFORMÁTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INFORMÁTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g8m7&mat=ARTE Y ÉTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>ARTE Y ÉTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g8m8&mat=DEPORTE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>DEPORTE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g8m9&mat=MÚSICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MÚSICA</p>
                        </a>
                      </li>


                    </ul>

                  </li>

                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-chalkboard-teacher nav-icon"></i>
                      <p>Noveno
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g9m3&mat=LENGUAJE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>LENGUAJE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g9m5&mat=CIENCIAS SOCIALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS SOCIALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g9m4&mat=MATEMÁTICAS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MATEMÁTICAS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g9m2&mat=CIENCIAS NATURALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS NATURALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g9m1&mat=INGLÉS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INGLÉS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g9m6&mat=INFORMÁTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INFORMÁTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g9m7&mat=ARTE Y ÉTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>ARTE Y ÉTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g9m8&mat=DEPORTE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>DEPORTE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g9m9&mat=MÚSICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MÚSICA</p>
                        </a>
                      </li>


                    </ul>

                  </li>

                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-chalkboard-teacher nav-icon"></i>
                      <p>Décimo
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g10m3&mat=LENGUAJE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>LENGUAJE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g10m5&mat=CIENCIAS SOCIALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS SOCIALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g10m4&mat=MATEMÁTICAS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MATEMÁTICAS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g10m2&mat=CIENCIAS NATURALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS NATURALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g10m1&mat=INGLÉS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INGLÉS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g10m6&mat=INFORMÁTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INFORMÁTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g10m7&mat=ARTE Y ÉTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>ARTE Y ÉTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g10m8&mat=DEPORTE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>DEPORTE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g10m9&mat=MÚSICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MÚSICA</p>
                        </a>
                      </li>


                    </ul>

                  </li>

                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-chalkboard-teacher nav-icon"></i>
                      <p>Undécimo
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g11m3&mat=LENGUAJE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>LENGUAJE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g11m5&mat=CIENCIAS SOCIALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS SOCIALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g11m4&mat=MATEMÁTICAS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MATEMÁTICAS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g11m2&mat=CIENCIAS NATURALES" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>CIENCIAS NATURALES</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g11m1&mat=INGLÉS" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INGLÉS</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g11m6&mat=INFORMÁTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>INFORMÁTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g11m7&mat=ARTE Y ÉTICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>ARTE Y ÉTICA</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g11m8&mat=DEPORTE" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>DEPORTE</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g11m9&mat=MÚSICA" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>MÚSICA</p>
                        </a>
                      </li>


                    </ul>

                  </li>

                </ul>
              </li>


            </ul>
          </li>
          <!-- / Modulo Monitor de Aulas -->
        <?php endif; ?>

        <?php if ($_SESSION['nivel'] == 2 || $_SESSION['nivel'] == 1 || $_SESSION['id'] == 44) : ?>
          <!-- Modulo de Monitor de Notas -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-desktop"></i>
              <p>
                Monitor de Notas
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fa-calendar-alt nav-icon"></i>
                  <p>1° Periodo</p>
                </a>

                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=1&per=1" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Primero</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=2&per=1" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Segundo</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=3&per=1" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tercero</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=4&per=1" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Cuarto</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=5&per=1" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Quinto</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=6&per=1" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Sexto</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=7&per=1" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Séptimo</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=8&per=1" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Octavo</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=9&per=1" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Noveno</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=10&per=1" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Décimo</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=11&per=1" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Undécimo</p>
                    </a>
                  </li>

                </ul>

              </li>

              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fa-calendar-alt nav-icon"></i>
                  <p>2° Periodo</p>
                </a>

                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=1&per=2" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Primero</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=2&per=2" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Segundo</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=3&per=2" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tercero</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=4&per=2" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Cuarto</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=5&per=2" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Quinto</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=6&per=2" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Sexto</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=7&per=2" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Séptimo</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=8&per=2" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Octavo</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=9&per=2" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Noveno</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=10&per=2" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Décimo</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=11&per=2" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Undécimo</p>
                    </a>
                  </li>

                </ul>

              </li>

              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fa-calendar-alt nav-icon"></i>
                  <p>3° Periodo</p>
                </a>

                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=1&per=3" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Primero</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=2&per=3" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Segundo</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=3&per=3" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tercero</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=4&per=3" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Cuarto</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=5&per=3" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Quinto</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=6&per=3" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Sexto</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=7&per=3" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Séptimo</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=8&per=3" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Octavo</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=9&per=3" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Noveno</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=10&per=3" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Décimo</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="monitor-notas.php?grado=11&per=3" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Undécimo</p>
                    </a>
                  </li>

                </ul>

              </li>

            </ul>
          </li>
          <!-- / Modulo de Monitor de Notas -->
        <?php endif; ?>

        <?php if ($_SESSION['nivel'] == 2 || $_SESSION['nivel'] == 1 || $_SESSION['id'] == 44) : ?>
          <!-- Modulo Indicadores de Conviviencia -->
          <li class="nav-item has-treeview">
            <a href="notas-convivencia.php" class="nav-link">
              <i class="nav-icon fas fa-heart"></i>
              <p>
                Indicadores Convivencia
              </p>
            </a>
          </li>
          <!-- / Modulo Indicadores de Conviviencia -->
        <?php endif; ?>

        */ ?>

        <!-- Modulo monitor de Coordinación -->
        <?php
        if ($_SESSION['nivel'] == 3) :
        ?>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa-solid fa-phone-volume "></i>
              <p>
                Directorio
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <?php

            foreach (GRADOS1 as $gra_cod => $gra_des) {
              $grado_lista = $gra_des[0];

              $control_sec = count($gra_des[3]);

              if ($control_sec > 1) {

                for ($isec = 0; $isec < $control_sec; $isec++) {
                  $datos = ['gra' => $grado_lista, 'sec' => $gra_des[3][$isec]];
                  $datos = serialize($datos);
                  $datos = urlencode($datos);
            ?>

                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "dgrupo-directorio.php?data=" . $datos ?> class="nav-link">
                        <i class="fas fa-chart-pie nav-icon"></i>
                        <p><?php echo $grado_lista . ' (' . $gra_des[3][$isec] . ')' ?></p>
                      </a>
                    </li>
                  </ul>

                <?php
                }
              } else {

                $datos = ['gra' => $grado_lista, 'sec' => $gra_des[3][0]];
                $datos = serialize($datos);
                $datos = urlencode($datos);

                ?>

                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href=<?php echo MODULOS . "dgrupo-directorio.php?data=" . $datos ?> class="nav-link">
                      <i class="fas fa-chart-pie nav-icon"></i>
                      <p><?php echo $grado_lista ?></p>
                    </a>
                  </li>
                </ul>

              <?php
              }

              ?>

            <?php
            }

            ?>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa-solid fa-chart-line"></i>
              <p>
                Reportes
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <?php

            foreach (GRADOS1 as $gra_cod => $gra_des) {
              $grado_lista = $gra_des[0];
              $datos = ['gra' => $grado_lista];
              $datos = serialize($datos);
              $datos = urlencode($datos);

            ?>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href=<?php echo MODULOS . "monitor-reportes.php?data=" . $datos ?> class="nav-link">
                    <i class="fas fa-chart-pie nav-icon"></i>
                    <p><?php echo $grado_lista ?></p>
                  </a>
                </li>
              </ul>

            <?php
            }

            ?>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa-regular fa-face-smile"></i>
              <p>
                Convivencia
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item has-treeview">
                <a href=<?php echo MODULOS . "monitor-iconvivencia.php" ?> class="nav-link">
                  <i class="nav-icon fas fa-heart"></i>
                  <p>
                    Indicadores
                  </p>
                </a>
              </li>

              <?php /*
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-user-secret"></i>
                  <p>
                    Periodo 1
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>

                <?php

                foreach (GRADOS1 as $gra_cod => $gra_des) {
                  $grado_lista = $gra_des[0];

                  $datos = ['d1' => 1, 'd2' => $grado_lista];
                  $datos = serialize($datos);
                  $datos = urlencode($datos);

                ?>

                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "monitor-convivencia.php?data=" . $datos ?> class="dropdown-item logins_form nav-link">
                        <i class="fas fa-user-pen nav-icon"></i>
                        <p><?php echo $grado_lista ?></p>
                      </a>
                    </li>
                  </ul>

                <?php
                }

                ?>
              </li>

              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-user-secret"></i>
                  <p>
                    Periodo 2
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>

                <?php

                foreach (GRADOS1 as $gra_cod => $gra_des) {
                  $grado_lista = $gra_des[0];

                  $datos = ['d1' => 2, 'd2' => $grado_lista];
                  $datos = serialize($datos);
                  $datos = urlencode($datos);

                ?>

                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "monitor-convivencia.php?data=" . $datos ?> class="dropdown-item logins_form nav-link">
                        <i class="fas fa-user-pen nav-icon"></i>
                        <p><?php echo $grado_lista ?></p>
                      </a>
                    </li>
                  </ul>

                <?php
                }

                ?>
              </li>

              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-user-secret"></i>
                  <p>
                    Periodo 3
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>

                <?php

                foreach (GRADOS1 as $gra_cod => $gra_des) {
                  $grado_lista = $gra_des[0];

                  $datos = ['d1' => 3, 'd2' => $grado_lista];
                  $datos = serialize($datos);
                  $datos = urlencode($datos);

                ?>

                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "monitor-convivencia.php?data=" . $datos ?> class="dropdown-item logins_form nav-link">
                        <i class="fas fa-user-pen nav-icon"></i>
                        <p><?php echo $grado_lista ?></p>
                      </a>
                    </li>
                  </ul>

                <?php
                }

                ?>
              </li>
              */ ?>

              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-user-secret"></i>
                  <p>
                    Periodo 1
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>

                <?php

                foreach (GRADOS1 as $gra_cod => $gra_des) {
                  $grado_lista = $gra_des[0];

                  $datos = ['d1' => 1, 'd2' => $grado_lista];
                  $datos = serialize($datos);
                  $datos = urlencode($datos);

                ?>

                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "monitor-convivencia.php?data=" . $datos ?> class="dropdown-item logins_form nav-link">
                        <i class="fas fa-user-pen nav-icon"></i>
                        <p><?php echo $grado_lista ?></p>
                      </a>
                    </li>
                  </ul>

                <?php
                }

                ?>
              </li>

              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-user-secret"></i>
                  <p>
                    Periodo 2
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>

                <?php

                foreach (GRADOS1 as $gra_cod => $gra_des) {
                  $grado_lista = $gra_des[0];

                  $datos = ['d1' => 2, 'd2' => $grado_lista];
                  $datos = serialize($datos);
                  $datos = urlencode($datos);

                ?>

                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "monitor-convivencia.php?data=" . $datos ?> class="dropdown-item logins_form nav-link">
                        <i class="fas fa-user-pen nav-icon"></i>
                        <p><?php echo $grado_lista ?></p>
                      </a>
                    </li>
                  </ul>

                <?php
                }

                ?>
              </li>

            </ul>

          </li>

          <?php
          $datos = ['d1' => 1];
          $datos = serialize($datos);
          $datos = urlencode($datos);
          ?>

          <li class="nav-item">
            <a href=<?php echo MODULOS . "monitor-fortalezados.php?data=" . $datos ?> class="nav-link">
              <i class="fa-solid fa-list-ol nav-icon"></i>
              <p>Fortalezados</p>
            </a>
          </li>

          <li class="nav-item">
            <a href=<?php echo MODULOS . "monitor-planificadores.php?data=" . $datos ?> class="nav-link">
              <i class="fa-solid fa-file-signature nav-icon"></i>
              <p>Planificadores</p>
            </a>
          </li>

        <?php endif; ?>
        <!-- / Modulo monitor de Coordinación -->

        <!-- Modulo asignación Notas ICFES -->
        <?php
        $crr_mat = isset($_SESSION['datos']['pro_mat']) ? $_SESSION['datos']['pro_mat'] : ['NA' => 'NA'];
        if (
          $_SESSION['nivel'] == 1
          || $_SESSION['logid'] == 38
          || in_array('SOCIALES', $crr_mat)
          || in_array('ESPAÑOL', $crr_mat)
          || in_array('MATEMÁTICAS', $crr_mat)
          || in_array('NATURALES', $crr_mat)
          || in_array('INGLÉS', $crr_mat)
        ) :
        ?>
          <li class="nav-item has-treeview">

            <a href="#" class="nav-link">
              <i class="nav-icon fa-solid fa-flag-checkered"></i>
              <p>
                Notas ICFES
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>


            <ul class="nav nav-treeview">

              <?php /* Primer Periodo:
              <li class="nav-item has-treeview">

                <a href="#" class="nav-link">
                  <i class="nav-icon fa-solid fa-pen"></i>
                  <p>
                    Periodo 1
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>

                <?php

                foreach (GRADOS1 as $gra_cod => $gra_des) {

                  if ($gra_cod !== 12 && $gra_cod !== 13 && $gra_cod !== 14) {
                    $sec_info = $gra_des[3];
                    $grado_lista = $gra_des[0];
                    $control_sec = count($sec_info);

                    if ($control_sec > 1) {
                      for ($isec = 0; $isec < $control_sec; $isec++) {

                        $datos = ['d1' => 1, 'd2' => $grado_lista, 'd3' => $sec_info[$isec]];
                        $datos = serialize($datos);
                        $datos = urlencode($datos);

                ?>

                        <ul class="nav nav-treeview">
                          <li class="nav-item">
                            <a href=<?php echo MODULOS . "icfes-notas.php?data=" . $datos ?> class="dropdown-item logins_form nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p><?php echo $grado_lista . ' (' . $sec_info[$isec] . ')' ?></p>
                            </a>
                          </li>
                        </ul>

                      <?php
                      }
                    } else {

                      $datos = ['d1' => 1, 'd2' => $grado_lista, 'd3' => $sec_info[0]];
                      $datos = serialize($datos);
                      $datos = urlencode($datos);
                      ?>

                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href=<?php echo MODULOS . "icfes-notas.php?data=" . $datos ?> class="dropdown-item logins_form nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p><?php echo $grado_lista ?></p>
                          </a>
                        </li>
                      </ul>

                <?php
                    }
                  }
                }

                ?>
              </li>
            */ ?>

              <li class="nav-item has-treeview">

                <a href="#" class="nav-link">
                  <i class="nav-icon fa-solid fa-pen"></i>
                  <p>
                    Periodo 2
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>

                <?php

                foreach (GRADOS1 as $gra_cod => $gra_des) {

                  if ($gra_cod !== 12 && $gra_cod !== 13 && $gra_cod !== 14) {
                    $sec_info = $gra_des[3];
                    $grado_lista = $gra_des[0];
                    $control_sec = count($sec_info);

                    if ($control_sec > 1) {
                      for ($isec = 0; $isec < $control_sec; $isec++) {

                        $datos = ['d1' => 2, 'd2' => $grado_lista, 'd3' => $sec_info[$isec]];
                        $datos = serialize($datos);
                        $datos = urlencode($datos);

                ?>

                        <ul class="nav nav-treeview">
                          <li class="nav-item">
                            <a href=<?php echo MODULOS . "icfes-notas.php?data=" . $datos ?> class="dropdown-item logins_form nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p><?php echo $grado_lista . ' (' . $sec_info[$isec] . ')' ?></p>
                            </a>
                          </li>
                        </ul>

                      <?php
                      }
                    } else {

                      $datos = ['d1' => 2, 'd2' => $grado_lista, 'd3' => $sec_info[0]];
                      $datos = serialize($datos);
                      $datos = urlencode($datos);
                      ?>

                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href=<?php echo MODULOS . "icfes-notas.php?data=" . $datos ?> class="dropdown-item logins_form nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p><?php echo $grado_lista ?></p>
                          </a>
                        </li>
                      </ul>

                <?php
                    }
                  }
                }

                ?>
              </li>

            </ul>


          </li>
        <?php endif; ?>
        <!-- / Modulo asignación Notas ICFES -->

        <!-- Modulo de Dirección de Grupo -->
        <?php
        $dgrupo_nav = isset($_SESSION['datos']['pro_dgr']) ? $_SESSION['datos']['pro_dgr'] : '';
        if ($_SESSION['nivel'] == 6 && !empty($dgrupo_nav)) :
        ?>
          <li class="nav-item has-treeview">

            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-secret"></i>
              <p>
                Dirección de grupo
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <?php
                $datos = ['gra' => 'dgrupo'];
                $datos = serialize($datos);
                $datos = urlencode($datos);
                ?>

                <a href=<?php echo MODULOS . "dgrupo-directorio.php?data=" . $datos ?> class="dropdown-item nav-link">
                  <i class="fas fa-address-book nav-icon"></i>
                  <p>Directorio</p>
                </a>

              </li>

            </ul>

            <?php
            if (!($_SESSION['datos']['pro_dgr'] == 'TRANSICIÓN' or $_SESSION['datos']['pro_dgr'] == 'JARDÍN' or $_SESSION['datos']['pro_dgr'] == 'JARDÍN')) :
            ?>

              <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="pages/charts/flot.html" class="nav-link">
                    <i class="nav-icon fa-solid fa-chart-line""></i>
                    <p>Reportes</p>
                  </a>

                  <ul class=" nav nav-treeview">

                      <?php
                      $datos = ['d1' => 1];
                      $datos = serialize($datos);
                      $datos = urlencode($datos);
                      ?>

                <li class="nav-item">
                  <a href=<?php echo MODULOS . "dgrupo-reporte-periodo.php?data=" . $datos ?> class="nav-link">
                    <i class="fas fa-chart-pie nav-icon"></i>
                    <p>Periodo 1</p>
                  </a>
                </li>

                <?php
                $datos = ['d1' => 2];
                $datos = serialize($datos);
                $datos = urlencode($datos);
                ?>

                <li class="nav-item">
                  <a href=<?php echo MODULOS . "dgrupo-reporte-periodo.php?data=" . $datos ?> class="nav-link">
                    <i class="fas fa-chart-pie nav-icon"></i>
                    <p>Periodo 2</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href=<?php echo MODULOS . "dgrupo-reporte-general.php" ?> class="nav-link">
                    <i class="fas fa-chart-pie nav-icon"></i>
                    <p>General</p>
                  </a>
                </li>

              </ul>
          </li>

      </ul>


    <?php endif; ?>

    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="#" class="dropdown-item logins_form nav-link">
          <i class="fas fa-user-pen nav-icon"></i>
          <p>Convivencia</p>
        </a>

        <?php
          $datos = ['d1' => 1];
          $datos = serialize($datos);
          $datos = urlencode($datos);

        ?>

        <?php if ($_SESSION['logid'] == 59) : ?>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href=<?php echo MODULOS . "dgrupo-convivencia.php?data=" . $datos ?> class="dropdown-item logins_form nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>1er Periodo</p>
              </a>
            </li>
          </ul>

        <?php endif; ?>

        <?php
          $datos = ['d1' => 2];
          $datos = serialize($datos);
          $datos = urlencode($datos);

        ?>


        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href=<?php echo MODULOS . "dgrupo-convivencia.php?data=" . $datos ?> class="dropdown-item logins_form nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>2do Periodo</p>
            </a>
          </li>
        </ul>

      </li>
    </ul>

    <?php /*
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="#" class="dropdown-item logins_form nav-link">
          <i class="fas fa-user-pen nav-icon"></i>
          <p>Asistencia</p>
        </a>

        <?php
        $datos = ['d1' => 1];
        $datos = serialize($datos);
        $datos = urlencode($datos);

        if ($_SESSION['datos']['pro_dgr'] == 'TRANSICIÓN') {
          define('GRADOS3', [
            12 => array('PRE JADRÍN', 'TRA', 'mat_logros_tra_p'),
            13 => array('JARDÍN', 'TRA', 'mat_logros_tra_p'),
            14 => array('TRANSICIÓN', 'TRA', 'mat_logros_tra_p'),
          ]);

          foreach (GRADOS3 as $gra_cod => $gra_des) {
            $grado_lista = $gra_des[0];
            $datos = ['d1' => 1, 'd2' => $grado_lista];
            $datos = serialize($datos);
            $datos = urlencode($datos);

          ?>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href=<?php echo MODULOS . "monitor-convivencia.php?data=" . $datos ?> class="nav-link">
                  <i class="fas fa-chart-pie nav-icon"></i>
                  <p><?php echo $grado_lista ?></p>
                </a>
              </li>
            </ul>

          <?php
          }
        } else { ?>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href=<?php echo MODULOS . "dgrupo-convivencia.php?data=" . $datos ?> class="dropdown-item logins_form nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>1er Periodo</p>
              </a>
            </li>
          </ul>

        <?php
        }
        ?>
      </li>
    </ul>
    */ ?>

    </li>
  <?php endif; ?>
  <!-- / Modulo de Dirección de Grupo -->

  <!-- Modulo de Notas -->
  <?php if ($_SESSION['nivel'] == 6 && $_SESSION['datos']['per_ape'] !== 'ICFES') : ?>
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-edit"></i>
        <p>
          Notas
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>

      <ul class="nav nav-treeview">

        <li class="nav-item">
          <a href="pages/charts/flot.html" class="nav-link">
            <i class="far fas fa-pen nav-icon"></i>
            <p>2do Periodo</p>
            <?php $per_text = 'PRIMERO';
            $per_val = 2 ?>
          </a>

          <ul class="nav nav-treeview">

            <?php
            $datos = ['d1' => $per_val];
            $datos = serialize($datos);
            $datos = urlencode($datos);
            ?>

            <li class="nav-item">
              <a href=<?php echo MODULOS . "notas-fortalezados.php?data=" . $datos ?> class="nav-link">
                <i class="fa-solid fa-list-ol nav-icon"></i>
                <p>Fortalezados</p>
              </a>
            </li>


            <?php
            foreach ($_SESSION['datos']['pro_mat'] as $materia) { ?>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p><?php echo $materia ?></p>
                </a>

                <ul class="nav nav-treeview">

                  <?php

                  $codigos = array(
                    "SOCIALES" => "soc",
                    "ESPAÑOL" => "esp",
                    "MATEMÁTICAS" => "mat",
                    "NATURALES" => "nat",
                    "INGLÉS" => "ing",
                    "INFORMÁTICA" => "inf",
                    "ÉTICA Y RELIGIÓN" => "eyr",
                    "ARTÍSTICA" => "art",
                    "DEPORTE" => "dep",
                    "MÚSICA" => "mus",
                    "LECTORES" => "lec",
                    "PESP" => "psp",
                    "GLOBALIZACIÓN" => "glo",
                    "CORPORAL" => "cor"
                  );

                  if (isset($codigos[$materia])) {
                    $codMat = $codigos[$materia];
                  }

                  for ($i = 1; $i < 15; $i++) {

                    if ($_SESSION['datos']['on' . $codMat . $i] == 1) {

                      if (isset(GRADOS1[$i])) {
                        [$gra_info, $str_info, $log_info, $sec_info] = GRADOS1[$i];
                      }

                      $control_sec = count($sec_info);

                      if ($control_sec > 1) {

                        if ($_SESSION['datos']['pro_dgr'] === 'TRANSICIÓN') {

                          $datos = ['d1' => $i, 'd2' => $per_val, 'd3' => $materia, 'd4' => $_SESSION['datos']['pro_dgs']];
                          $datos = serialize($datos);
                          $datos = urlencode($datos);

                  ?>

                          <li class="nav-item">
                            <a href=<?php echo MODULOS . "notas-registro.php?data=" . $datos ?> class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p><?php echo 'Grado ' . $i . '°' . ' (' . $_SESSION['datos']['pro_dgs'] . ')'  ?></p>
                            </a>
                          </li>


                          <?php
                        } else {

                          for ($isec = 0; $isec < $control_sec; $isec++) {

                            $datos = ['d1' => $i, 'd2' => $per_val, 'd3' => $materia, 'd4' => $sec_info[$isec]];
                            $datos = serialize($datos);
                            $datos = urlencode($datos);

                          ?>

                            <li class="nav-item">
                              <a href=<?php echo MODULOS . "notas-registro.php?data=" . $datos ?> class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo 'Grado ' . $i . '°' . ' (' . $sec_info[$isec] . ')' ?></p>
                              </a>
                            </li>

                        <?php
                          }
                        }
                      } else {

                        $datos = ['d1' => $i, 'd2' => $per_val, 'd3' => $materia, 'd4' => 'U'];
                        $datos = serialize($datos);
                        $datos = urlencode($datos);

                        ?>

                        <li class="nav-item">
                          <a href=<?php echo MODULOS . "notas-registro.php?data=" . $datos ?> class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p><?php echo 'Grado ' . $i . '°' ?></p>
                          </a>
                        </li>

                      <?php
                      }

                      ?>


                  <?php
                    }
                  }
                  ?>

                </ul>
              </li>
            <?php
            };
            ?>

          </ul>

        </li>

        <?php /*
              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fas fa-pen nav-icon"></i>
                  <p>2do Periodo</p>
                  <?php $per_text = 'SEGUNDO';
                  $per_val = 2 ?>S
                </a>

                <ul class="nav nav-treeview">

                  <?php
                  $datos = ['d1' => $per_val];
                  $datos = serialize($datos);
                  $datos = urlencode($datos);
                  ?>

                  <li class="nav-item">
                    <a href=<?php echo MODULOS . "notas-fortalezados.php?data=" . $datos ?> class="nav-link">
                      <i class="fa-solid fa-list-ol nav-icon"></i>
                      <p>Fortalezados</p>
                    </a>
                  </li>


                  <?php
                  foreach ($_SESSION['datos']['pro_mat'] as $materia) { ?>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p><?php echo $materia ?></p>
                      </a>

                      <ul class="nav nav-treeview">

                        <?php

                        $codigos = array(
                          "SOCIALES" => "soc",
                          "ESPAÑOL" => "esp",
                          "MATEMÁTICAS" => "mat",
                          "NATURALES" => "nat",
                          "INGLÉS" => "ing",
                          "INFORMÁTICA" => "inf",
                          "ÉTICA Y RELIGIÓN" => "eyr",
                          "ARTÍSTICA" => "art",
                          "DEPORTE" => "dep",
                          "MÚSICA" => "mus",
                          "LECTORES" => "lec",
                          "PESP" => "psp",
                          "GLOBALIZACIÓN" => "glo",
                          "CORPORAL" => "cor"
                        );

                        if (isset($codigos[$materia])) {
                          $codMat = $codigos[$materia];
                        }

                        for ($i = 1; $i < 15; $i++) {
                          if (isset($_SESSION['datos']['on' . $codMat . $i]) && $_SESSION['datos']['on' . $codMat . $i] == 1) {

                            $datos = ['d1' => $i, 'd2' => $per_val, 'd3' => $materia];
                            $datos = serialize($datos);
                            $datos = urlencode($datos);

                        ?>

                            <li class="nav-item">
                              <a href=<?php echo MODULOS . "notas-registro.php?data=" . $datos ?> class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo 'Grado ' . $i . '°' ?></p>
                              </a>
                            </li>

                        <?php
                          }
                        }
                        ?>

                      </ul>
                    </li>
                  <?php
                  }
                  ?>
                </ul>

              </li>

              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fas fa-pen nav-icon"></i>
                  <p>3er Periodo</p>
                  <?php $per_text = 'TERCERO';
                  $per_val = 3 ?>
                </a>

                <ul class="nav nav-treeview">

                  <?php
                  $datos = ['d1' => $per_val];
                  $datos = serialize($datos);
                  $datos = urlencode($datos);
                  ?>

                  <li class="nav-item">
                    <a href=<?php echo MODULOS . "notas-fortalezados.php?data=" . $datos ?> class="nav-link">
                      <i class="fa-solid fa-list-ol nav-icon"></i>
                      <p>Fortalezados</p>
                    </a>
                  </li>


                  <?php
                  foreach ($_SESSION['datos']['pro_mat'] as $materia) { ?>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p><?php echo $materia ?></p>
                      </a>

                      <ul class="nav nav-treeview">

                        <?php

                        $codigos = array(
                          "SOCIALES" => "soc",
                          "ESPAÑOL" => "esp",
                          "MATEMÁTICAS" => "mat",
                          "NATURALES" => "nat",
                          "INGLÉS" => "ing",
                          "INFORMÁTICA" => "inf",
                          "ÉTICA Y RELIGIÓN" => "eyr",
                          "ARTÍSTICA" => "art",
                          "DEPORTE" => "dep",
                          "MÚSICA" => "mus",
                          "LECTORES" => "lec",
                          "PESP" => "psp",
                          "GLOBALIZACIÓN" => "glo",
                          "CORPORAL" => "cor"
                        );

                        if (isset($codigos[$materia])) {
                          $codMat = $codigos[$materia];
                        }

                        for ($i = 1; $i < 15; $i++) {
                          if (isset($_SESSION['datos']['on' . $codMat . $i]) && $_SESSION['datos']['on' . $codMat . $i] == 1) {

                            $datos = ['d1' => $i, 'd2' => $per_val, 'd3' => $materia];
                            $datos = serialize($datos);
                            $datos = urlencode($datos);

                        ?>

                            <li class="nav-item">
                              <a href=<?php echo MODULOS . "notas-registro.php?data=" . $datos ?> class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo 'Grado ' . $i . '°' ?></p>
                              </a>
                            </li>

                        <?php
                          }
                        }
                        ?>

                      </ul>
                    </li>
                  <?php
                  }
                  ?>
                </ul>

              </li>
              

              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fas fa-pen nav-icon"></i>
                  <p>4to Periodo</p>
                  <?php $per_text = 'CUARTO';
                  $per_val = 4 ?>
                </a>

                <ul class="nav nav-treeview">

                  <?php
                  $datos = ['d1' => $per_val];
                  $datos = serialize($datos);
                  $datos = urlencode($datos);
                  ?>

                  <li class="nav-item">
                    <a href=<?php echo MODULOS . "notas-fortalezados.php?data=" . $datos ?> class="nav-link">
                      <i class="fa-solid fa-list-ol nav-icon"></i>
                      <p>Fortalezados</p>
                    </a>
                  </li>


                  <?php
                  foreach ($_SESSION['datos']['pro_mat'] as $materia) { ?>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p><?php echo $materia ?></p>
                      </a>

                      <ul class="nav nav-treeview">

                        <?php

                        $codigos = array(
                          "SOCIALES" => "soc",
                          "ESPAÑOL" => "esp",
                          "MATEMÁTICAS" => "mat",
                          "NATURALES" => "nat",
                          "INGLÉS" => "ing",
                          "INFORMÁTICA" => "inf",
                          "ÉTICA Y RELIGIÓN" => "eyr",
                          "ARTÍSTICA" => "art",
                          "DEPORTE" => "dep",
                          "MÚSICA" => "mus",
                          "LECTORES" => "lec",
                          "PESP" => "psp",
                          "GLOBALIZACIÓN" => "glo",
                          "CORPORAL" => "cor"
                        );

                        if (isset($codigos[$materia])) {
                          $codMat = $codigos[$materia];
                        }

                        for ($i = 1; $i < 15; $i++) {
                          if (isset($_SESSION['datos']['on' . $codMat . $i]) && $_SESSION['datos']['on' . $codMat . $i] == 1) {

                            $datos = ['d1' => $i, 'd2' => $per_val, 'd3' => $materia];
                            $datos = serialize($datos);
                            $datos = urlencode($datos);

                        ?>

                            <li class="nav-item">
                              <a href=<?php echo MODULOS . "notas-registro.php?data=" . $datos ?> class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo 'Grado ' . $i . '°' ?></p>
                              </a>
                            </li>

                        <?php
                          }
                        }
                        ?>

                      </ul>
                    </li>
                  <?php
                  }
                  ?>
                </ul>

              </li>

              */ ?>

      </ul>
    </li>
  <?php endif; ?>
  <!-- / Modulo de Notas -->

  <!-- Modulo de Novedades -->
  <?php if ($_SESSION['nivel'] == 6 && $_SESSION['datos']['per_ape'] !== 'ICFES') : ?>

    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fa-solid fa-bell"></i>

        <p>
          Novedades (P2)
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>

      <?php $per_text = 'SEGUNDO';
      $per_val = 2 ?>

      <ul class="nav nav-treeview">

        <?php /*
              <?php
              $datos = ['d1' => $per_val];
              $datos = serialize($datos);
              $datos = urlencode($datos);
              ?>

              <li class="nav-item">
                <a href=<?php echo MODULOS . "notas-fortalezados.php?data=" . $datos ?> class="nav-link">
                  <i class="fa-solid fa-list-ol nav-icon"></i>
                  <p>Fortalezados</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="#" class="dropdown-item logins_form nav-link">
                  <i class="fas fa-user-pen nav-icon"></i>
                  <p>Convivencia</p>
                </a>

                <?php
                $datos = ['d1' => 5];
                $datos = serialize($datos);
                $datos = urlencode($datos);

                if ($_SESSION['datos']['pro_dgr'] == 'TRANSICIÓN') {
                  define('GRADOS3', [
                    12 => array('PRE JARDÍN', 'TRA', 'mat_logros_tra_p'),
                    13 => array('JARDÍN', 'TRA', 'mat_logros_tra_p'),
                    14 => array('TRANSICIÓN', 'TRA', 'mat_logros_tra_p'),
                  ]);

                  foreach (GRADOS3 as $gra_cod => $gra_des) {
                    $grado_lista = $gra_des[0];
                    $datos = ['d1' => 5, 'd2' => $grado_lista];
                    $datos = serialize($datos);
                    $datos = urlencode($datos);

                ?>

                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href=<?php echo MODULOS . "dgrupo-convivencia-final.php?data=" . $datos ?> class="nav-link">
                          <i class="fas fa-chart-pie nav-icon"></i>
                          <p><?php echo $grado_lista ?></p>
                        </a>
                      </li>
                    </ul>

                  <?php
                  }
                } else { ?>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "dgrupo-convivencia-final.php?data=" . $datos ?> class="dropdown-item logins_form nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>5to Periodo</p>
                      </a>
                    </li>
                  </ul>

                <?php
                }
                ?>
              </li>
              */ ?>

        <?php
        foreach ($_SESSION['datos']['pro_mat'] as $materia) { ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p><?php echo $materia ?></p>
            </a>

            <ul class="nav nav-treeview">

              <?php

              $codigos = array(
                "SOCIALES" => "soc",
                "ESPAÑOL" => "esp",
                "MATEMÁTICAS" => "mat",
                "NATURALES" => "nat",
                "INGLÉS" => "ing",
                "INFORMÁTICA" => "inf",
                "ÉTICA Y RELIGIÓN" => "eyr",
                "ARTÍSTICA" => "art",
                "DEPORTE" => "dep",
                "MÚSICA" => "mus",
                "LECTORES" => "lec",
                "PESP" => "psp",
                "GLOBALIZACIÓN" => "glo",
                "CORPORAL" => "cor"
              );

              if (isset($codigos[$materia])) {
                $codMat = $codigos[$materia];
              }

              for ($i = 1; $i < 15; $i++) {

                if (isset($_SESSION['datos']['on' . $codMat . $i]) && $_SESSION['datos']['on' . $codMat . $i] == 1) {

                  if (isset(GRADOS1[$i])) {
                    [$gra_info, $str_info, $log_info, $sec_info] = GRADOS1[$i];
                  }

                  $control_sec = count($sec_info);

                  if ($control_sec > 1) {

                    if ($_SESSION['datos']['pro_dgr'] === 'TRANSICIÓN') {

                      $datos = ['d1' => $i, 'd2' => $per_val, 'd3' => $materia, 'd4' => $sec_info[$isec]];
                      $datos = serialize($datos);
                      $datos = urlencode($datos);

              ?>

                      <li class="nav-item">
                        <a href=<?php echo MODULOS . "notas-novedades.php?data=" . $datos ?> class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p><?php echo 'Grado ' . $i . '°' . ' (' . $_SESSION['datos']['pro_dgs'] . ')'  ?></p>
                        </a>
                      </li>


                      <?php
                    } else {

                      for ($isec = 0; $isec < $control_sec; $isec++) {

                        $datos = ['d1' => $i, 'd2' => $per_val, 'd3' => $materia, 'd4' => $sec_info[$isec]];
                        $datos = serialize($datos);
                        $datos = urlencode($datos);

                      ?>

                        <li class="nav-item">
                          <a href=<?php echo MODULOS . "notas-novedades.php?data=" . $datos ?> class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p><?php echo 'Grado ' . $i . '°' . ' (' . $sec_info[$isec] . ')' ?></p>
                          </a>
                        </li>

                    <?php
                      }
                    }
                  } else {

                    $datos = ['d1' => $i, 'd2' => $per_val, 'd3' => $materia, 'd4' => 'U'];
                    $datos = serialize($datos);
                    $datos = urlencode($datos);

                    ?>

                    <li class="nav-item">
                      <a href=<?php echo MODULOS . "notas-novedades.php?data=" . $datos ?> class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p><?php echo 'Grado ' . $i . '°' ?></p>
                      </a>
                    </li>

              <?php
                  }
                }
              }
              ?>

            </ul>
          </li>
        <?php
        }
        ?>
      </ul>

    </li>
  <?php endif; ?>
  <!-- / Modulo de Novedades -->

  <!-- Modulo de planillas -->
  <?php if ($_SESSION['nivel'] == 6 && $_SESSION['datos']['per_ape'] !== 'ICFES') : ?>
  <?php endif; ?>
  <!-- / Modulo de planillas -->

  <!-- Modulo de Administrativo -->
  <?php if ($_SESSION['nivel'] == 6 && $_SESSION['datos']['per_ape'] !== 'ICFES') : ?>
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fa-solid fa-table"></i>
        <p>
          Administrativo
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>


      <?php $per_val = 1; ?>

      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href=<?php echo MODULOS . "admin-aprendizajes.php" ?> class="nav-link planillas">
            <i class="far fa-circle nav-icon"></i>
            <p>Aprendizajes</p>
          </a>
        </li>
      </ul>

      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href=<?php echo MODULOS . "admin-mayacurricular.php" ?> class="nav-link planillas">
            <i class="far fa-circle nav-icon"></i>
            <p>Malla curricular</p>
          </a>
        </li>
      </ul>


      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href=<?php echo MODULOS . "admin-planificador.php" ?> class="nav-link planillas">
            <i class="far fa-circle nav-icon"></i>
            <p>Planificador</p>
          </a>
        </li>
      </ul>

      <ul class="nav nav-treeview">
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fa-solid fa-table"></i>
            <p>
              Planillas
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>

          <?php $per_val = 1; ?>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" data-model="<?php echo MODELOS . "notas-modelo.php"; ?>" data-per="<?php echo $per_val ?>" data-use="<?php echo $_SESSION['logid'] ?>" class="nav-link planillas" id="<?php echo 'p' . $_SESSION['logid'] . $per_val ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>1er Periodo</p>
              </a>
            </li>
          </ul>

          <?php /*
                <?php $per_val = 2; ?>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" data-model="<?php echo MODELOS . "notas-modelo.php"; ?>" data-per="<?php echo $per_val ?>" data-use="<?php echo $_SESSION['logid'] ?>" class="nav-link planillas" id="<?php echo 'p' . $_SESSION['logid'] . $per_val ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>2do Periodo</p>
                    </a>
                  </li>
                </ul>
                <?php $per_val = 3; ?>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" data-model="<?php echo MODELOS . "notas-modelo.php"; ?>" data-per="<?php echo $per_val ?>" data-use="<?php echo $_SESSION['logid'] ?>" class="nav-link planillas" id="<?php echo 'p' . $_SESSION['logid'] . $per_val ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>3er Periodo</p>
                    </a>
                  </li>
                </ul>
                <?php $per_val = 4; ?>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" data-model="<?php echo MODELOS . "notas-modelo.php"; ?>" data-per="<?php echo $per_val ?>" data-use="<?php echo $_SESSION['logid'] ?>" class="nav-link planillas" id="<?php echo 'p' . $_SESSION['logid'] . $per_val ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>4to Periodo</p>
                    </a>
                  </li>
                </ul>
                */ ?>

      </ul>


    </li>


    </li>


  <?php endif; ?>
  <!-- / Modulo de planillas -->


  <?php /*

        <?php if ($_SESSION['nivel'] == 3 && $_SESSION['users_mat_code'] != 99) : ?>
          <!-- Aula Virtual Profesores -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Aula Virtual
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <?php /*
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fas fa-pen nav-icon"></i>
                  <p>Asignaciones</p>
                </a>

                <ul class="nav nav-treeview">


                  <?php if ($_SESSION['users_pj'] == 'SI') : ?>

                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pre Jardín</p>
                      </a>
                    </li>

                  <?php endif; ?>

                  <?php if ($_SESSION['users_j'] == 'SI') : ?>

                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Jardín</p>
                      </a>
                    </li>

                  <?php endif; ?>

                  <?php if ($_SESSION['users_t'] == 'SI') : ?>

                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Transición</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_1ro'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-asignaciones-lista.php?grado=1" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Primero</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_2do'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-asignaciones-lista.php?grado=2" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Segundo</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_3ro'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-asignaciones-lista.php?grado=3" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tercero</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_4to'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-asignaciones-lista.php?grado=4" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cuarto</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_5to'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-asignaciones-lista.php?grado=5" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Quinto</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_6to'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-asignaciones-lista.php?grado=6" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Sexto</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_7mo'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-asignaciones-lista.php?grado=7" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Séptimo</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_8vo'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-asignaciones-lista.php?grado=8" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Octavo</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_9no'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-asignaciones-lista.php?grado=9" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Noveno</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_10mo'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-asignaciones-lista.php?grado=10" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Décimo</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_11mo'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-asignaciones-lista.php?grado=11" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Undécimo</p>
                      </a>
                    </li>
                  <?php endif; ?>

                </ul>

              </li>
            </ul>
             ?>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fas fa-pen nav-icon"></i>
                  <p>Salones</p>
                </a>

                <ul class="nav nav-treeview">


                  <?php if ($_SESSION['users_pj'] == 'SI') : ?>

                    <li class="nav-item">
                      <a href="av-room1.php?grado=97" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pre Jardín</p>
                      </a>
                    </li>

                  <?php endif; ?>

                  <?php if ($_SESSION['users_j'] == 'SI') : ?>

                    <li class="nav-item">
                      <a href="av-room1.php?grado=98" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Jardín</p>
                      </a>
                    </li>

                  <?php endif; ?>

                  <?php if ($_SESSION['users_t'] == 'SI') : ?>

                    <li class="nav-item">
                      <a href="av-room1.php?grado=99" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Transición</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_1ro'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-room1.php?grado=1" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Primero</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_2do'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-room1.php?grado=2" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Segundo</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_3ro'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-room1.php?grado=3" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tercero</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_4to'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-room1.php?grado=4" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cuarto</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_5to'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-room1.php?grado=5" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Quinto</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_6to'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-room1.php?grado=6" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Sexto</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_7mo'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-room1.php?grado=7" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Séptimo</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_8vo'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-room1.php?grado=8" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Octavo</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_9no'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-room1.php?grado=9" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Noveno</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_10mo'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-room1.php?grado=10" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Décimo</p>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if ($_SESSION['users_11mo'] == 'SI') : ?>
                    <li class="nav-item">
                      <a href="av-room1.php?grado=11" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Undécimo</p>
                      </a>
                    </li>
                  <?php endif; ?>

                </ul>

              </li>
            </ul>

          </li><!-- / Aula Virtual Profesores -->
        <?php endif; ?>

        <?php if ($_SESSION['nivel'] == 3 && $_SESSION['users_mat_code'] == 99) : ?>
          <!-- Aula Virtual Preescolar docente-->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Aula Virtual
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">

              <!--         
            <li class="nav-item">
                  <a href="pages/charts/flot.html" class="nav-link">
                    <i class="far fas fa-pen nav-icon"></i>
                    <p>Asignaciones</p>
                  </a>
            </li>
            -->
              <li class="nav-item">
                <a href="av-room4.php" class="nav-link">
                  <i class="far fas fa-pen nav-icon"></i>
                  <p>Salon Preescolar</p>
                </a>
              </li>

            </ul>

          </li><!-- / Aula Virtual Preescolar docente -->
        <?php endif; ?>

        <?php if ($_SESSION['nivel'] !== 4) : ?>
          <!-- Salón de Conferencia -->
          <li class="nav-item has-treeview">
            <a href="av-room3.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Salón de Conferencias
              </p>
            </a>
          </li><!-- / Salón de Conferencia -->
        <?php endif; ?>

        <?php if ($_SESSION['nivel'] == 'NEO') : ?>
          <!-- Modulo de Seguimiento -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-search"></i>
              <p>
                Seguimiento
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fas fa-smile nav-icon"></i>
                  <p>Convivencia</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fas fa-eye nav-icon"></i>
                  <p>Observador</p>
                </a>
              </li>

            </ul>

          </li><!-- / Modulo de Seguimiento -->
        <?php endif; ?>

        <?php if ($_SESSION['nivel'] == 4 && $_SESSION['alum_grado'] !== 97 && $_SESSION['alum_grado'] !== 98 && $_SESSION['alum_grado'] !== 99) : ?>
          <!-- Aula Virtual Estudiantes-->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Aula Virtual
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <?php /*
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fas fa-pen nav-icon"></i>
                  <p>Asignaciones</p>
                </a>

                <ul class="nav nav-treeview">

                  <?php

                  $no_incluir = 'T/A';

                  try {
                    $stmt = $conn->prepare("SELECT * FROM materias WHERE mat_des_materia !=?");
                    $stmt->bind_param("s", $no_incluir);
                    $stmt->execute();
                    $des_materias = $stmt->get_result();
                  } catch (\Exception $e) {
                    $error = $e->getMessage();
                    echo $error;
                  }


                  while ($des_materias2 = $des_materias->fetch_assoc()) { ?>

                    <li class="nav-item">
                      <a href="av-asignaciones-lista-2.php?grado=<?php echo $_SESSION['alum_grado']; ?>&materia=<?php echo $des_materias2['mat_des_materia']; ?>&code=<?php echo $_SESSION['alum_grado']; ?>" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p><?php echo $des_materias2['mat_des_materia']; ?></p>
                      </a>
                    </li>

                  <?php };
                  ?>


                </ul>

              </li>
            </ul>
             ?>


            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fas fa-pen nav-icon"></i>
                  <p>Salones</p>
                </a>

                <ul class="nav nav-treeview">

                  <?php

                  try {
                    $stmt = $conn->prepare("SELECT * FROM materias");
                    $stmt->execute();
                    $des_materias = $stmt->get_result();
                  } catch (\Exception $e) {
                    $error = $e->getMessage();
                    echo $error;
                  }

                  while ($des_materias2 = $des_materias->fetch_assoc()) {


                    if (
                      $des_materias2['mat_des_materia'] != 'T/A' and
                      $des_materias2['mat_des_materia'] != 'ARTE' and
                      $des_materias2['mat_des_materia'] != 'ÉTICA' and
                      $des_materias2['mat_des_materia'] != 'GLOBALIZACIÓN' and
                      $des_materias2['mat_des_materia'] != 'PESP' and
                      $des_materias2['mat_des_materia'] != 'CORPORAL'
                    ) { ?>

                      <li class="nav-item">
                        <a href="av-room2.php?room_id=g<?php echo $_SESSION['alum_grado'] . 'm' . $des_materias2['mat_cod_materia'] ?>&mat=<?php echo $des_materias2['mat_des_materia']; ?>" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p><?php echo $des_materias2['mat_des_materia']; ?></p>
                        </a>
                      </li>

                  <?php
                    }
                  };
                  ?>

                </ul>

              </li>
            </ul>

          </li><!-- / Aula Virtual Estudiantes-->
        <?php endif; ?>

        <?php if ($_SESSION['nivel'] == 4 && $_SESSION['alum_grado'] == 97 || $_SESSION['nivel'] == 4 && $_SESSION['alum_grado'] == 98 || $_SESSION['nivel'] == 4 && $_SESSION['alum_grado'] == 99) : ?>
          <!-- Aula Virtual Preescolar estudiantes-->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Aula Virtual
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">

              <!--         
            <li class="nav-item">
                  <a href="pages/charts/flot.html" class="nav-link">
                    <i class="far fas fa-pen nav-icon"></i>
                    <p>Asignaciones</p>
                  </a>
            </li>
            -->
              <li class="nav-item">
                <a href="av-room5.php?rname=<?php echo 'cpiroomt21588' ?>" class="nav-link">
                  <i class="far fas fa-pen nav-icon"></i>
                  <p>Prof. Keisy Camargo</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="av-room5.php?rname=<?php echo 'cpiroomt22687' ?>" class="nav-link">
                  <i class="far fas fa-pen nav-icon"></i>
                  <p>Prof. Wendy Arrieta</p>
                </a>
              </li>

            </ul>

          </li><!-- / Aula Virtual Preescolar estudiantes -->
        <?php endif; ?>

        */ ?>

  <?php if ($_SESSION['nivel'] == 999 || $_SESSION['logid'] == 999) : ?>
    <!-- Modulo Simulacros Coordinador -->
    <li class="nav-item has-treeview">

      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-book"></i>
        <p>
          Simulacro ICFES
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>

      <ul class="nav nav-treeview">

        <?php

        foreach (GRADOS2 as $gra_cod => $gra_des) {

          $grado_num = $gra_cod;
          $grado_des = $gra_des[0];

          $datos = ['d1' => $grado_num, 'd2' => $grado_des];
          $datos = serialize($datos);
          $datos = urlencode($datos);

        ?>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fas fa-chalkboard-teacher nav-icon"></i>
              <p><?php echo $grado_des ?></p>
            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href=<?php echo MODULOS . "preicfes-param.php?data=" . $datos ?> class="nav-link">
                  <i class="far fas fa-plus nav-icon"></i>
                  <p>Cargar Prueba</p>
                </a>
              </li>

              <li class="nav-item">
                <a href=<?php echo MODULOS . "preicfes-lista.php?data=" . $datos ?> class="nav-link">
                  <i class="far fas fa-th-list nav-icon"></i>
                  <p>Pruebas Cargadas</p>
                </a>
              </li>
            </ul>
          </li>

        <?php

        }

        ?>

      </ul>




    </li><!-- / Modulo Simulacros Coordinador -->
  <?php endif; ?>

  <?php /*

        <?php if ($_SESSION['nivel'] == 3 || $_SESSION['id'] == 44) : ?>
          <!-- Modulo Simulacros Docentes -->
          <li class="nav-item has-treeview">

            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Simulacro ICFES
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">

              <?php if ($_SESSION['users_1ro'] == 'SI') : ?>
                <li class="nav-item">
                  <a href="preifces-lista3.php?grado=1" class="nav-link">
                    <i class="far fas fa-chalkboard-teacher nav-icon"></i>
                    <p>Primero</p>
                  </a>
                </li>
              <?php endif; ?>

              <?php if ($_SESSION['users_2do'] == 'SI') : ?>
                <li class="nav-item">
                  <a href="preifces-lista3.php?grado=2" class="nav-link">
                    <i class="far fas fa-chalkboard-teacher nav-icon"></i>
                    <p>Segundo</p>
                  </a>
                </li>
              <?php endif; ?>

              <?php if ($_SESSION['users_3ro'] == 'SI') : ?>
                <li class="nav-item">
                  <a href="preifces-lista3.php?grado=3" class="nav-link">
                    <i class="far fas fa-chalkboard-teacher nav-icon"></i>
                    <p>Tercero</p>
                  </a>
                </li>
              <?php endif; ?>

              <?php if ($_SESSION['users_4to'] == 'SI') : ?>
                <li class="nav-item">
                  <a href="preifces-lista3.php?grado=4" class="nav-link">
                    <i class="far fas fa-chalkboard-teacher nav-icon"></i>
                    <p>Cuarto</p>
                  </a>
                </li>
              <?php endif; ?>

              <?php if ($_SESSION['users_5to'] == 'SI') : ?>
                <li class="nav-item">
                  <a href="preifces-lista3.php?grado=5" class="nav-link">
                    <i class="far fas fa-chalkboard-teacher nav-icon"></i>
                    <p>Quinto</p>
                  </a>
                </li>
              <?php endif; ?>

              <?php if ($_SESSION['users_6to'] == 'SI') : ?>
                <li class="nav-item">
                  <a href="preifces-lista3.php?grado=6" class="nav-link">
                    <i class="far fas fa-chalkboard-teacher nav-icon"></i>
                    <p>Sexto</p>
                  </a>
                </li>
              <?php endif; ?>

              <?php if ($_SESSION['users_7mo'] == 'SI') : ?>
                <li class="nav-item">
                  <a href="preifces-lista3.php?grado=7" class="nav-link">
                    <i class="far fas fa-chalkboard-teacher nav-icon"></i>
                    <p>Séptimo</p>
                  </a>
                </li>
              <?php endif; ?>

              <?php if ($_SESSION['users_8vo'] == 'SI') : ?>
                <li class="nav-item">
                  <a href="preifces-lista3.php?grado=8" class="nav-link">
                    <i class="far fas fa-chalkboard-teacher nav-icon"></i>
                    <p>Octavo</p>
                  </a>
                </li>
              <?php endif; ?>

              <?php if ($_SESSION['users_9no'] == 'SI') : ?>
                <li class="nav-item">
                  <a href="preifces-lista3.php?grado=9" class="nav-link">
                    <i class="far fas fa-chalkboard-teacher nav-icon"></i>
                    <p>Noveno</p>
                  </a>
                </li>
              <?php endif; ?>

              <?php if ($_SESSION['users_10mo'] == 'SI') : ?>
                <li class="nav-item">
                  <a href="preifces-lista3.php?grado=10" class="nav-link">
                    <i class="far fas fa-chalkboard-teacher nav-icon"></i>
                    <p>Décimo</p>
                  </a>
                </li>
              <?php endif; ?>

              <?php if ($_SESSION['users_11mo'] == 'SI') : ?>
                <li class="nav-item">
                  <a href="preifces-lista3.php?grado=11" class="nav-link">
                    <i class="far fas fa-chalkboard-teacher nav-icon"></i>
                    <p>Undécimo</p>
                  </a>
                </li>
              <?php endif; ?>


            </ul>
          </li><!-- / Modulo Simulacros Docentess -->
        <?php endif; ?>

        */ ?>

  <?php if ($_SESSION['nivel'] == 8 && $_SESSION['datos']['gra_esc'] !== 97 && $_SESSION['datos']['gra_esc'] !== 98 && $_SESSION['datos']['gra_esc'] !== 99) : ?>
    <!-- Modulo Simulacros Estudiantes -->
    <li class="nav-item has-treeview">

      <a href=<?php echo MODULOS . "preicfes-lista2.php" ?> class="nav-link">
        <i class="nav-icon fas fa-users-cog"></i>
        <p>
          Simulacro ICFES
        </p>
      </a>
    </li><!-- / Modulo Simulacros Estudiantes -->
  <?php endif; ?>

  <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 5) : ?>
    <!-- Modulo de boletines -->
    <li class="nav-item has-treeview">

      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users-cog"></i>
        <p>
          Boletines
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">

        <li class="nav-item">
          <a href="pages/charts/flot.html" class="nav-link">
            <i class="far fas fa-users nav-icon"></i>
            <p>Periodo 1°</p>
          </a>

          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf" data-gra="12" data-sec="U" data-per="1" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Prejardín</p>
              </a>
            </li>


            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf" data-gra="13" data-sec="U" data-per="1" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Jardín</p>
              </a>
            </li>


            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf" data-gra="14" data-sec="A" data-per="1" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Transición (A)</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf" data-gra="14" data-sec="B" data-per="1" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Transición (B)</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf" data-gra="1" data-sec="U" data-per="1" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Primero</p>
              </a>
            </li>


            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf" data-gra="2" data-sec="U" data-per="1" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Segundo</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf" data-gra="3" data-sec="U" data-per="1" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Tercero</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf" data-gra="4" data-sec="U" data-per="1" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Cuarto</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf" data-gra="5" data-sec="U" data-per="1" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Quinto</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf" data-gra="6" data-sec="U" data-per="1" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Sexto</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf" data-gra="7" data-sec="U" data-per="1" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Séptimo</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf" data-gra="8" data-sec="A" data-per="1" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Octavo (A)</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf" data-gra="8" data-sec="B" data-per="1" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Octavo (B)</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf" data-gra="9" data-sec="U" data-per="1" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Noveno</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf" data-gra="10" data-sec="A" data-per="1" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Décimo (A)</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf" data-gra="10" data-sec="B" data-per="1" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Décimo (B)</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf" data-gra="11" data-sec="U" data-per="1" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Undécimo</p>
              </a>
            </li>

          </ul>
        </li>

        <?php /*
        <li class="nav-item">
          <a href="pages/charts/flot.html" class="nav-link">
            <i class="far fas fa-users nav-icon"></i>
            <p>I. Final</p>
          </a>

          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf5" data-gra="12" data-per="4" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Prejardín</p>
              </a>
            </li>


            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf5" data-gra="13" data-per="4" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Jardín</p>
              </a>
            </li>


            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf5" data-gra="14" data-per="4" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Transición</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf5" data-gra="1" data-per="4" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Primero</p>
              </a>
            </li>


            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf5" data-gra="2" data-per="4" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Segundo</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf5" data-gra="3" data-per="4" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Tercero</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf5" data-gra="4" data-per="4" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Cuarto</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf5" data-gra="5" data-per="4" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Quinto</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf5" data-gra="6" data-per="4" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Sexto</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf5" data-gra="7" data-per="4" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Séptimo</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf5" data-gra="8" data-per="3" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Octavo</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf5" data-gra="9" data-per="3" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Noveno</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf5" data-gra="10" data-per="4" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Décimo</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link btn-bol-pdf5" data-gra="11" data-per="4" data-uid="<?php echo $_SESSION['logid'] ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Undécimo</p>
              </a>
            </li>

          </ul>
        </li>
        */ ?>

      </ul>

    </li><!-- / Modulo de boletines -->
  <?php endif; ?>

  <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 5) : ?>
    <!-- Modulo de usuarios -->
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user-friends"></i>
        <p>
          Usuarios
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href=<?php echo MODULOS . "usuario-nuevo.php" ?> class="nav-link">
            <i class="far fas fa-user-plus nav-icon"></i>
            <p>Registrar Usuario</p>
          </a>
        </li>
        <li class="nav-item">
          <a href=<?php echo MODULOS . "usuario-lista.php" ?> class="nav-link">
            <i class="far fas fa-user-check nav-icon"></i>
            <p>Usuarios registrados</p>
          </a>
        </li>
      </ul>
    </li><!-- / Modulo de usuarios -->
  <?php endif; ?>

  <?php /*

        <?php if ($_SESSION['nivel'] == 4) : ?>
          <!-- Modulo de gestión de datos personales -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Mis Datos
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <!--
            <li class="nav-item">
              <a href="usuario-actualizar2.php?id=<?php echo $_SESSION['id']; ?>" class="nav-link">
                <i class="far fas fa-folder-open nav-icon"></i>
                <p>Datos Institucionales</p>
              </a>
            </li>
              -->

              <li class="nav-item">

                <a href="#" class="dropdown-item logins_form nav-link" id_log="<?php echo $_SESSION['id']; ?>" onclick="desplegar(<?php echo $_SESSION['id']; ?>);">
                  <i class="far fas fa-lock nav-icon"></i>
                  <p>Datos de acceso</p>
                </a>

              </li>
            </ul>
          </li><!-- / Modulo de gestión de datos personales -->
        <?php endif; ?>

        
        <?php if ($_SESSION['nivel'] == 'NEO') : ?>
          <!-- Salón de Conferencia -->
          <li class="nav-item has-treeview">
            <a href="av-room6.php" class="nav-link">
              <i class="nav-icon fas fa-bullhorn"></i>
              <p>
                Salón de Eventos
              </p>
            </a>
          </li><!-- / Salón de Conferencia -->
        <?php endif; ?>

        <?php if ($_SESSION['nivel'] == 'NEO') : ?>
          <!-- Salón de Conferencia -->
          <li class="nav-item has-treeview">
            <a href="av-room7.php" class="nav-link">
              <i class="nav-icon fas fa-bullhorn"></i>
              <p>
                Salón de Eventos
              </p>
            </a>
          </li><!-- / Salón de Conferencia -->
        <?php endif; ?>

        <?php if ($_SESSION['nivel'] == 4) : ?>
          <!-- Salón de Psicología -->
          <li class="nav-item has-treeview">
            <a href="av-room8.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Aula Psicología
              </p>
            </a>
          </li><!-- / Salón de Psicología -->
        <?php endif; ?>

        <?php if ($_SESSION['nivel'] !== 4) : ?>
          <!-- Salón de Psicología -->
          <li class="nav-item has-treeview">
            <a href="av-room9.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Aula Psicología
              </p>
            </a>
          </li><!-- / Salón de Psicología -->
        <?php endif; */ ?>

  <?php if ($_SESSION['nivel'] == 1) : ?>
    <!-- Modulo Electoral -->
    <li class="nav-item has-treeview">

      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-hand-pointer"></i>
        <p>
          Elecciones Personero<span class="right badge badge-info" style="margin-right:5%">2023</span>
        </p>
      </a>

      <ul class="nav nav-treeview">

        <li class="nav-item">
          <a href=<?php echo MODULOS . "elecciones-resultados.php" ?> class="nav-link">
            <i class="far fas fa-user-plus nav-icon"></i>
            <p>Resultados</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="pages/charts/flot.html" class="nav-link">
            <i class="far fas fa-users nav-icon"></i>
            <p>Electores
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href=<?php echo MODULOS . "elecciones-lista.php?grado=1" ?> class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Primero</p>
              </a>
            </li>

            <li class="nav-item">
              <a href=<?php echo MODULOS . "elecciones-lista.php?grado=2" ?> class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Segundo</p>
              </a>
            </li>

            <li class="nav-item">
              <a href=<?php echo MODULOS . "elecciones-lista.php?grado=3" ?> class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Tercero</p>
              </a>
            </li>

            <li class="nav-item">
              <a href=<?php echo MODULOS . "elecciones-lista.php?grado=4" ?> class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Cuarto</p>
              </a>
            </li>

            <li class="nav-item">
              <a href=<?php echo MODULOS . "elecciones-lista.php?grado=5" ?> class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Quinto</p>
              </a>
            </li>

            <li class="nav-item">
              <a href=<?php echo MODULOS . "elecciones-lista.php?grado=6" ?> class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Sexto</p>
              </a>
            </li>

            <li class="nav-item">
              <a href=<?php echo MODULOS . "elecciones-lista.php?grado=7" ?> class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Séptimo</p>
              </a>
            </li>

            <li class="nav-item">
              <a href=<?php echo MODULOS . "elecciones-lista.php?grado=8" ?> class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Octavo</p>
              </a>
            </li>

            <li class="nav-item">
              <a href=<?php echo MODULOS . "elecciones-lista.php?grado=9" ?> class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Noveno</p>
              </a>
            </li>

            <li class="nav-item">
              <a href=<?php echo MODULOS . "elecciones-lista.php?grado=10" ?> class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Décimo</p>
              </a>
            </li>

            <li class="nav-item">
              <a href=<?php echo MODULOS . "elecciones-lista.php?grado=11" ?> class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Undécimo</p>
              </a>
            </li>

          </ul>
        </li>

        <li class="nav-item">
          <a href="pages/charts/flot.html" class="nav-link">
            <i class="far fas fa-users nav-icon"></i>
            <p>Mesas
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href=<?php echo MODULOS . "elecciones-votacion.php?m=1" ?> class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>MESA 1</p>
              </a>
            </li>

            <li class="nav-item">
              <a href=<?php echo MODULOS . "elecciones-votacion.php?m=2" ?> class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>MESA 2</p>
              </a>
            </li>

            <li class="nav-item">
              <a href=<?php echo MODULOS . "elecciones-votacion.php?m=3" ?> class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>MESA 3</p>
              </a>
            </li>

            <li class="nav-item">
              <a href=<?php echo MODULOS . "elecciones-votacion.php?m=4" ?> class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>MESA 4</p>
              </a>
            </li>

            <li class="nav-item">
              <a href=<?php echo MODULOS . "elecciones-votacion.php?m=5" ?> class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>MESA 5</p>
              </a>
            </li>

          </ul>
        </li>


      </ul>
    </li><!-- / Modulo Electoral -->
  <?php endif; ?>

  <?php /*
        <?php if ($_SESSION['nivel'] !== 4) : ?>
          <!-- Modulo de gestión de datos personales -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Mis Datos
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="usuario-actualizar2.php?id=<?php echo $_SESSION['id']; ?>" class="nav-link">
                  <i class="far fas fa-folder-open nav-icon"></i>
                  <p>Datos Institucionales</p>
                </a>
              </li>
              <li class="nav-item">

                <a href="#" class="dropdown-item logins_form nav-link" id_log="<?php echo $_SESSION['id']; ?>" onclick="desplegar(<?php echo $_SESSION['id']; ?>);">
                  <i class="far fas fa-lock nav-icon"></i>
                  <p>Datos de acceso</p>
                </a>

              </li>
            </ul>
          </li><!-- / Modulo de gestión de datos personales -->
        <?php endif; ?>
        */ ?>

  <!-- Cerrar Sesión -->
  <li class="nav-item has-treeview">
    <a href=<?php echo MODULOS . "login.php?cerrar_sesion=true" ?> class="nav-link">
      <i class="nav-icon fas fa-sign-out-alt"></i>
      <p>
        Cerrar Sesión
      </p>
    </a>
  </li><!-- / Cerrar Sesión -->

  </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>