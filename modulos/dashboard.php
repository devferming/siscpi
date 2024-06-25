<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">INICIO</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <?php if ($_SESSION['nivel'] !== 8) : ?>
            <div class="container-fluid">


                <div class="row">
                    <div class="col-lg-3 col-6">

                        <?php

                        try {
                            $stmt = $conn->prepare("SELECT * FROM siscpi_alumnos");
                            $stmt->execute();
                            $result = $stmt->get_result();
                        } catch (\Exception $e) {
                            $error = $e->getMessage();
                            echo $error;
                        }

                        $mat_par = 0;
                        $mat_pja = 0;
                        $mat_jar = 0;
                        $mat_tra = 0;
                        $mat_1ro = 0;
                        $mat_2do = 0;
                        $mat_3ro = 0;
                        $mat_4to = 0;
                        $mat_5to = 0;
                        $mat_6to = 0;
                        $mat_7to = 0;
                        $mat_8to = 0;
                        $mat_9to = 0;
                        $mat_10o = 0;
                        $mat_11o = 0;
                        $mat_total = 0;
                        $mat_hem = 0;
                        $mat_hom = 0;

                        while ($datos_alum = $result->fetch_assoc()) {
                            $datos = json_decode($datos_alum['datos'], true);
                            $grado = $datos['gra_esc'];
                            $genero = $datos['alu_gen'];
                            if ($grado == 'PRE JARDÍN') {
                                $mat_pja += 1;
                                $mat_total += 1;
                            }
                            if ($grado == 'JARDÍN') {
                                $mat_jar += 1;
                                $mat_total += 1;
                            }
                            if ($grado == 'TRANSICIÓN') {
                                $mat_tra += 1;
                                $mat_total += 1;
                            }
                            if ($grado == 'PRIMERO') {
                                $mat_1ro += 1;
                                $mat_total += 1;
                            }
                            if ($grado == 'SEGUNDO') {
                                $mat_2do += 1;
                                $mat_total += 1;
                            }
                            if ($grado == 'TERCERO') {
                                $mat_3ro += 1;
                                $mat_total += 1;
                            }
                            if ($grado == 'CUARTO') {
                                $mat_4to += 1;
                                $mat_total += 1;
                            }
                            if ($grado == 'QUINTO') {
                                $mat_5to += 1;
                                $mat_total += 1;
                            }
                            if ($grado == 'SEXTO') {
                                $mat_6to += 1;
                                $mat_total += 1;
                            }
                            if ($grado == 'SÉPTIMO') {
                                $mat_7to += 1;
                                $mat_total += 1;
                            }
                            if ($grado == 'OCTAVO') {
                                $mat_8to += 1;
                                $mat_total += 1;
                            }
                            if ($grado == 'NOVENO') {
                                $mat_9to += 1;
                                $mat_total += 1;
                            }
                            if ($grado == 'DÉCIMO') {
                                $mat_10o += 1;
                                $mat_total += 1;
                            }
                            if ($grado == 'UNDÉCIMO') {
                                $mat_11o += 1;
                                $mat_total += 1;
                            }
                            if ($genero == 'MASCULINO') {
                                $mat_hom += 1;
                            }
                            if ($genero == 'FEMENINO') {
                                $mat_hem += 1;
                            }
                        };

                        $conn->close()


                        ?>

                        <div class="info-box">
                            <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Matrícula Total</span>
                                <span class="info-box-number">
                                    <?php echo $mat_total; ?>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>

                    </div>

                    <div class="col-lg-3 col-6">

                        <div class="info-box">
                            <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-shield"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Alumnos Becados</span>
                                <span class="info-box-number">
                                    <?php echo '0'; ?>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>

                    </div>


                    <div class="col-lg-3 col-6">

                        <div class="info-box">
                            <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-check"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Alumnos Privados</span>
                                <span class="info-box-number">
                                    <?php echo $mat_total; ?>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>

                    </div>

                    <div class="col-lg-3 col-6">

                        <div class="info-box">
                            <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-user-tie"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Docentes</span>
                                <span class="info-box-number">
                                    <?php echo '11'; ?>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-3 col-3">
                        <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i><?php echo $mat_tra; ?></span>
                            <h5 class="description-header">TRANSICIÓN</h5>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-3">
                        <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i><?php echo $mat_1ro; ?></span>
                            <h5 class="description-header">PRIMERO</h5>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-3">
                        <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i><?php echo $mat_2do; ?></span>
                            <h5 class="description-header">SEGUNDO</h5>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-3">
                        <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i><?php echo $mat_3ro; ?></span>
                            <h5 class="description-header">TERCERO</h5>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-3">
                        <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i><?php echo $mat_4to; ?></span>
                            <h5 class="description-header">CUARTO</h5>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-3">
                        <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i><?php echo $mat_5to; ?></span>
                            <h5 class="description-header">QUINTO</h5>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-3">
                        <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i><?php echo $mat_6to; ?></span>
                            <h5 class="description-header">SEXTO</h5>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-3">
                        <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i><?php echo $mat_7to; ?></span>
                            <h5 class="description-header">SÉPTIMO</h5>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-3">
                        <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i><?php echo $mat_8to; ?></span>
                            <h5 class="description-header">OCTAVO</h5>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-3">
                        <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i><?php echo $mat_9to; ?></span>
                            <h5 class="description-header">NOVENO</h5>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-3">
                        <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i><?php echo $mat_10o; ?></span>
                            <h5 class="description-header">DÉCIMO</h5>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->

                    <div class="col-sm-3 col-3">
                        <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i><?php echo $mat_11o; ?></span>
                            <h5 class="description-header">UNDÉCIMO</h5>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->

                    <div class="col-sm-3 col-3">
                        <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i><?php echo $mat_hem; ?></span>
                            <h5 class="description-header">HEMBRAS</h5>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-3">
                        <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i><?php echo $mat_hom; ?></span>
                            <h5 class="description-header">VARONES</h5>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->


            </div><!-- /.container-fluid -->
        <?php endif; ?>
        <?php if ($_SESSION['nivel'] == 'NEO') :

            $dgrupo = $_SESSION['alum_grado'];
            $alum_user_id = $_SESSION['id'];
            $per = 'TERCERO';

        ?>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Estan son tus guias entregadas y revisadas hasta ahora, del Periodo: <strong><span><?php echo $per; ?></span></strong></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="alum-reporte" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Inglés</th>
                                    <th>Naturales</th>
                                    <th>Lenguaje</th>
                                    <th>Matemáticas</th>
                                    <th>Sociales</th>
                                    <th>Informática</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                try {
                                    $stmt2 = $conn->prepare("SELECT * FROM alumnos WHERE alum_id_logins=?");
                                    $stmt2->bind_param("i", $alum_user_id);
                                    $stmt2->execute();
                                    $resultado2 = $stmt2->get_result();
                                    $datos_alum = $resultado2->fetch_assoc();
                                } catch (\Exception $e) {
                                    $error = $e->getMessage();
                                    echo $error;
                                }
                                $id_alum = $datos_alum['alum_id'];
                                $materia1 = 'INGLÉS';
                                $materia2 = 'CIENCIAS NATURALES';
                                $materia3 = 'LENGUAJE';
                                $materia4 = 'MATEMÁTICAS';
                                $materia5 = 'CIENCIAS SOCIALES';
                                $materia6 = 'INFORMÁTICA';
                                ?>

                                <tr>
                                    <td>
                                        <p>
                                            <?php
                                            try {

                                                $stmt = $conn->prepare("SELECT * FROM notas_parciales_p2 WHERE notas_p_p2_id_alumno=? AND notas_p_p2_materia=? AND notas_p_p2_periodo=?");
                                                $stmt->bind_param("iss", $id_alum, $materia1, $per);
                                                $stmt->execute();
                                                $notas_ingles2 = $stmt->get_result();
                                                $notas_ingles = $notas_ingles2->fetch_assoc();
                                            } catch (\Exception $e) {
                                                $error = $e->getMessage();
                                                echo $error;
                                            }
                                            ?>
                                            <?php

                                            $taller1 = $notas_ingles['notas_p_p2_t1'];
                                            $taller2 = $notas_ingles['notas_p_p2_t2'];
                                            $taller3 = $notas_ingles['notas_p_p2_t3'];
                                            $proyecto = $notas_ingles['notas_p_p2_p'];
                                            $examen = $notas_ingles['notas_p_p2_e'];

                                            if ($taller1 > 0) { ?>
                                                T1 = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                T1 = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            } ?>
                                            <br>
                                            <?php
                                            if ($taller2 > 0) { ?>
                                                T2 = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                T2 = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php

                                            if ($taller3 > 0) { ?>
                                                T3 = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                T3 = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php

                                            if ($proyecto > 0) { ?>
                                                P = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                P = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php

                                            if ($examen > 0) { ?>
                                                E = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                E = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>



                                        </p>

                                    </td>
                                    <td>
                                        <p>
                                            <?php
                                            try {

                                                $stmt = $conn->prepare("SELECT * FROM notas_parciales_p2 WHERE notas_p_p2_id_alumno=? AND notas_p_p2_materia=? AND notas_p_p2_periodo=?");
                                                $stmt->bind_param("iss", $id_alum, $materia2, $per);
                                                $stmt->execute();
                                                $notas_ingles2 = $stmt->get_result();
                                                $notas_ingles = $notas_ingles2->fetch_assoc();
                                            } catch (\Exception $e) {
                                                $error = $e->getMessage();
                                                echo $error;
                                            }
                                            ?>
                                            <?php

                                            $taller1 = $notas_ingles['notas_p_p2_t1'];
                                            $taller2 = $notas_ingles['notas_p_p2_t2'];
                                            $taller3 = $notas_ingles['notas_p_p2_t3'];
                                            $proyecto = $notas_ingles['notas_p_p2_p'];
                                            $examen = $notas_ingles['notas_p_p2_e'];

                                            if ($taller1 > 0) { ?>
                                                T1 = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                T1 = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            } ?>
                                            <br>
                                            <?php
                                            if ($taller2 > 0) { ?>
                                                T2 = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                T2 = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php

                                            if ($taller3 > 0) { ?>
                                                T3 = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                T3 = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php

                                            if ($proyecto > 0) { ?>
                                                P = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                P = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php

                                            if ($examen > 0) { ?>
                                                E = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                E = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>



                                        </p>

                                    </td>
                                    <td>
                                        <p>
                                            <?php
                                            try {

                                                $stmt = $conn->prepare("SELECT * FROM notas_parciales_p2 WHERE notas_p_p2_id_alumno=? AND notas_p_p2_materia=? AND notas_p_p2_periodo=?");
                                                $stmt->bind_param("iss", $id_alum, $materia3, $per);
                                                $stmt->execute();
                                                $notas_ingles2 = $stmt->get_result();
                                                $notas_ingles = $notas_ingles2->fetch_assoc();
                                            } catch (\Exception $e) {
                                                $error = $e->getMessage();
                                                echo $error;
                                            }
                                            ?>
                                            <?php

                                            $taller1 = $notas_ingles['notas_p_p2_t1'];
                                            $taller2 = $notas_ingles['notas_p_p2_t2'];
                                            $taller3 = $notas_ingles['notas_p_p2_t3'];
                                            $proyecto = $notas_ingles['notas_p_p2_p'];
                                            $examen = $notas_ingles['notas_p_p2_e'];

                                            if ($taller1 > 0) { ?>
                                                T1 = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                T1 = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            } ?>
                                            <br>
                                            <?php
                                            if ($taller2 > 0) { ?>
                                                T2 = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                T2 = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php

                                            if ($taller3 > 0) { ?>
                                                T3 = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                T3 = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php

                                            if ($proyecto > 0) { ?>
                                                P = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                P = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php

                                            if ($examen > 0) { ?>
                                                E = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                E = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>



                                        </p>

                                    </td>
                                    <td>
                                        <p>
                                            <?php
                                            try {

                                                $stmt = $conn->prepare("SELECT * FROM notas_parciales_p2 WHERE notas_p_p2_id_alumno=? AND notas_p_p2_materia=? AND notas_p_p2_periodo=?");
                                                $stmt->bind_param("iss", $id_alum, $materia4, $per);
                                                $stmt->execute();
                                                $notas_ingles2 = $stmt->get_result();
                                                $notas_ingles = $notas_ingles2->fetch_assoc();
                                            } catch (\Exception $e) {
                                                $error = $e->getMessage();
                                                echo $error;
                                            }
                                            ?>
                                            <?php

                                            $taller1 = $notas_ingles['notas_p_p2_t1'];
                                            $taller2 = $notas_ingles['notas_p_p2_t2'];
                                            $taller3 = $notas_ingles['notas_p_p2_t3'];
                                            $proyecto = $notas_ingles['notas_p_p2_p'];
                                            $examen = $notas_ingles['notas_p_p2_e'];

                                            if ($taller1 > 0) { ?>
                                                T1 = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                T1 = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            } ?>
                                            <br>
                                            <?php
                                            if ($taller2 > 0) { ?>
                                                T2 = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                T2 = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php

                                            if ($taller3 > 0) { ?>
                                                T3 = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                T3 = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php

                                            if ($proyecto > 0) { ?>
                                                P = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                P = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php

                                            if ($examen > 0) { ?>
                                                E = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                E = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>



                                        </p>

                                    </td>
                                    <td>

                                        <p>
                                            <?php
                                            try {

                                                $stmt = $conn->prepare("SELECT * FROM notas_parciales_p2 WHERE notas_p_p2_id_alumno=? AND notas_p_p2_materia=? AND notas_p_p2_periodo=?");
                                                $stmt->bind_param("iss", $id_alum, $materia5, $per);
                                                $stmt->execute();
                                                $notas_ingles2 = $stmt->get_result();
                                                $notas_ingles = $notas_ingles2->fetch_assoc();
                                            } catch (\Exception $e) {
                                                $error = $e->getMessage();
                                                echo $error;
                                            }
                                            ?>
                                            <?php

                                            $taller1 = $notas_ingles['notas_p_p2_t1'];
                                            $taller2 = $notas_ingles['notas_p_p2_t2'];
                                            $taller3 = $notas_ingles['notas_p_p2_t3'];
                                            $proyecto = $notas_ingles['notas_p_p2_p'];
                                            $examen = $notas_ingles['notas_p_p2_e'];

                                            if ($taller1 > 0) { ?>
                                                T1 = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                T1 = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            } ?>
                                            <br>
                                            <?php
                                            if ($taller2 > 0) { ?>
                                                T2 = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                T2 = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php

                                            if ($taller3 > 0) { ?>
                                                T3 = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                T3 = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php

                                            if ($proyecto > 0) { ?>
                                                P = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                P = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php

                                            if ($examen > 0) { ?>
                                                E = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                E = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>



                                        </p>

                                    </td>
                                    <td>
                                        <p>
                                            <?php
                                            try {

                                                $stmt = $conn->prepare("SELECT * FROM notas_parciales_p2 WHERE notas_p_p2_id_alumno=? AND notas_p_p2_materia=? AND notas_p_p2_periodo=?");
                                                $stmt->bind_param("iss", $id_alum, $materia6, $per);
                                                $stmt->execute();
                                                $notas_ingles2 = $stmt->get_result();
                                                $notas_ingles = $notas_ingles2->fetch_assoc();
                                            } catch (\Exception $e) {
                                                $error = $e->getMessage();
                                                echo $error;
                                            }
                                            ?>
                                            <?php

                                            $taller1 = $notas_ingles['notas_p_p2_t1'];
                                            $taller2 = $notas_ingles['notas_p_p2_t2'];
                                            $taller3 = $notas_ingles['notas_p_p2_t3'];
                                            $proyecto = $notas_ingles['notas_p_p2_p'];
                                            $examen = $notas_ingles['notas_p_p2_e'];

                                            if ($taller1 > 0) { ?>
                                                T1 = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                T1 = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            } ?>
                                            <br>
                                            <?php
                                            if ($taller2 > 0) { ?>
                                                T2 = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                T2 = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php

                                            if ($taller3 > 0) { ?>
                                                T3 = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                T3 = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php

                                            if ($proyecto > 0) { ?>
                                                P = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                P = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>
                                            <br>
                                            <?php

                                            if ($examen > 0) { ?>
                                                E = <i class="fas fa-check" style=color:green;></i>
                                            <?php
                                            } else { ?>
                                                E = <i class="fas fa-times" style=color:red;></i>
                                            <?php
                                            }
                                            ?>



                                        </p>

                                    </td>
                                </tr>
                                <?php
                                $conn->close();
                                ?>


                            </tbody>
                        </table>
                        <br>
                        <span>Recuerda que la <i class="fas fa-times" style="color:red;"></i> signfica que no has entregado la guia o que el profesor no la ha revisado y el <i class="fas fa-check" style="color:green;"></i> quiere decir que ya entregaste y que el profesor ya la revisó. <strong> Si ya entregaste tus guias y no te aparecen como revisadas, comunicate con el profesor y solicita que actualice tus entregas.</strong>

                        </span>

                    </div>
                    <!-- /.card-body -->
                </div>
            </div><!-- /.container-fluid -->

        <?php endif; ?>
    </section>

</div>