<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once  SESIONES;

if ($_SESSION['nivel'] == 6) :
    require_once FUNCIONES;
    // Templates
    require_once HEADER;
    require_once BARRA;
    require_once NAVEGACION;

    $dgrupo = $_SESSION['datos']['pro_dgr'];
    $dgrupo_sec = $_SESSION['datos']['pro_dgs'];
?>

    <?php

    if (array_key_exists($dgrupo, DGRUPOS)) {
        list($minima, $minima_total, $peligro) = DGRUPOS[$dgrupo];
    } else {
        $minima = 0;
        $minima_total = 0;
        $peligro = 0;
    }

    $gcod = GRADOS_COD[$dgrupo];

    if (isset(GRADOS[$gcod])) {
        [$gra, $sec, $log] = GRADOS[$gcod];
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
                            <i class="fa fa-users-cog"></i>
                            REPORTE GENERAL
                        </h1>
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
                        <h3 class="card-title"> Grado: <strong><?php echo $dgrupo . ' (' . $dgrupo_sec . ')'; ?></strong></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="mat-lista" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Rendimiento</th>
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

                                $alumnos = array();

                                while ($rowx2  = $result->fetch_assoc()) {
                                    $dat_alumx2 = json_decode($rowx2['datos'], true); //Obtiene todos los datos del alumno
                                    $ide_alumx2 = $rowx2['id']; //Obtiene el ID del alumno

                                    // Añadir el nombre completo del alumno al array
                                    $alumnos[] = array(
                                        'nombre' => $dat_alumx2['per_ape'] . " " . $dat_alumx2['per_nom'],
                                        'datos' => $dat_alumx2,
                                        'id' => $ide_alumx2
                                    );
                                }

                                // Función de comparación para ordenar por nombre
                                function comparar_nombres($a, $b)
                                {
                                    return strcmp($a['nombre'], $b['nombre']);
                                }

                                // Ordenar el array de alumnos por nombre
                                usort($alumnos, 'comparar_nombres');

                                foreach ($alumnos as $alumno) {
                                    $datos_alum = $alumno['datos'];
                                    $ida = $alumno['id'];

                                    if ($datos_alum['gra_esc'] == $dgrupo && $datos_alum['gra_sec'] === $dgrupo_sec && $datos_alum['estatus'] === 'MATRICULADO') { ?>

                                        <tr>
                                            <td>
                                                <span style="padding: 10px; font-weight: 600;"><?php echo $datos_alum['per_ape'] . ' ' . $datos_alum['per_nom'] ?></span><br>
                                                <?php

                                                $periodos = array("p-1", "p-2", "p-3", "p-4");
                                                $materias = array("SOCIALES", "ESPAÑOL", "MATEMÁTICAS", "NATURALES", "INGLÉS", "INFORMÁTICA", "ÉTICA Y RELIGIÓN", "ARTÍSTICA", "MÚSICA", "DEPORTE");

                                                try {
                                                    $stmt2 = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
                                                    $stmt2->bind_param("i", $ida);
                                                    $stmt2->execute();
                                                    $resultado3 = $stmt2->get_result();
                                                } catch (\Exception $e) {
                                                    $error = $e->getMessage();
                                                    echo $error;
                                                }

                                                while ($datos_notas = $resultado3->fetch_assoc()) {
                                                    $notas = json_decode($datos_notas['datos'], true);

                                                    $notas_periodos = array();

                                                    foreach ($periodos as $periodo) {
                                                        $notas_materia_periodo = array();

                                                        foreach ($materias as $materia) {

                                                            if (isset($notas[$periodo]['m-' . $materia]['nov'])) {
                                                                $ncn = isset($notas[$periodo]['m-' . $materia]['ncn']) ? $notas[$periodo]['m-' . $materia]['ncn'] : '';
                                                                $nnv = $notas[$periodo]['m-' . $materia]['nov'];

                                                                $notas_materia_periodo[$materia]['ncn'] = $ncn;
                                                                $notas_materia_periodo[$materia]['nov'] = $nnv;
                                                            } else {
                                                                $ncn = isset($notas[$periodo]['m-' . $materia]['ncn']) ? $notas[$periodo]['m-' . $materia]['ncn'] : 0;
                                                                $notas_materia_periodo[$materia]['ncn'] = $ncn;
                                                            }
                                                        }

                                                        $notas_periodos[$periodo] = $notas_materia_periodo;
                                                    }
                                                ?>


                                                    <div class="row" style="justify-content: center; margin-top: 6px; gap:10px">

                                                        <?php
                                                        foreach ($materias as $materia) {

                                                            if (array_key_exists($materia, MATERIAS)) {
                                                                list($mat_apodo, $mat_color) = MATERIAS[$materia];
                                                            } else {
                                                                $mat_apodo = 'N/A';
                                                                $mat_color = 'N/N';
                                                            }

                                                            echo '<div class="card card-secondary">';
                                                            echo '<div class="card-header" style="padding: 2px; background-color: ' . $mat_color . '">';
                                                            echo '<p class="card-title" style="font-size: 0.8rem; width: 100%; text-align:center">' . $mat_apodo . '</p>';
                                                            echo '</div>';
                                                            echo '<p style="padding: 5px">';

                                                            foreach ($notas_periodos as $periodo => $notas_materia_periodo) {
                                                                $periodo_actual = substr($periodo, 2);
                                                                //$notas_materia = $notas_periodos;

                                                                $ncn = $notas_materia_periodo[$materia]['ncn'];
                                                                
                                                                if (isset($notas_materia_periodo[$materia]['nov'])) {
                                                                    if ($notas_materia_periodo[$materia]['nov'] === 'REC') {
                                                                        echo '<span>P' . $periodo_actual . ': ' . $ncn . '</span><span class="badge" style="color:#28A745; font-weight: bold;">REC</span>';
                                                                        //echo '<span class="badge" style="color:black; font-weight: bold;">s/r</span>';
                                                                    } elseif ($notas_materia_periodo[$materia]['nov'] === 'NRE') {
                                                                        echo '<span>P' . $periodo_actual . ': ' . $ncn . '</span><span class="badge" style="color:red; font-weight: bold;">NRE</span>';
                                                                    }
                                                                } else {
                                                                    if ($ncn < $minima) {
                                                                        echo '<span style="color:red">P' . $periodo_actual . ': ' . $ncn . '</span><span class="badge" style="color:red; font-weight: bold;">S/R</span>';
                                                                    } else {
                                                                        echo '<span style="color:#28A745;">P' . $periodo_actual . ': ' . $ncn . '</span>';
                                                                    }
                                                                }
                                                                echo '<br>';
                                                            }

                                                            $nota_final = 0;
                                                            if (isset($notas_periodos['p-1'][$materia]['non'])) {
                                                                $nota_final += $notas_periodos['p-1'][$materia]['non'];
                                                            } else {
                                                                $nota_final += $notas_periodos['p-1'][$materia]['ncn'];
                                                            }

                                                            if (isset($notas_periodos['p-2'][$materia]['non'])) {
                                                                $nota_final += $notas_periodos['p-2'][$materia]['non'];
                                                            } else {
                                                                $nota_final += $notas_periodos['p-2'][$materia]['ncn'];
                                                            }

                                                            if (isset($notas_periodos['p-3'][$materia]['non'])) {
                                                                $nota_final += $notas_periodos['p-3'][$materia]['non'];
                                                            } else {
                                                                $nota_final += $notas_periodos['p-3'][$materia]['ncn'];
                                                            }

                                                            if (isset($notas_periodos['p-4'][$materia]['non'])) {
                                                                $nota_final += $notas_periodos['p-4'][$materia]['non'];
                                                            } else {
                                                                $nota_final += $notas_periodos['p-4'][$materia]['ncn'];
                                                            }

                                                            $nota_final = round(($nota_final / 4), 1);
                                                            $buscar_nota = strval($nota_final);
                                                            $ren = RENDIMIENTOS[$sec][$buscar_nota][0];
                                                            $ban = RENDIMIENTOS[$sec][$buscar_nota][1];

                                                            echo '<span class="badge badge-pill badge-' . $ban . '" id="defnov' . $ida . '">' . $nota_final . ' ' . $ren . '</span>';
                                                            echo '</p>';
                                                            echo '</div>';
                                                        }

                                                        $conv_final = 0;

                                                        echo '<div class="card card-secondary">';
                                                        echo '<div class="card-header" style="padding: 2px; background-color: black">';
                                                        echo '<p class="card-title" style="font-size: 0.8rem;">:::  CNV  :::</p>';
                                                        echo '</div>';
                                                        echo '<p style="padding: 5px">';

                                                        foreach ($notas_periodos as $periodo => $notas_materia_periodo) {
                                                            $periodo_actual = substr($periodo, 2);
                                                            // echo "neoa4 ".$notas[$periodo]['ncv'];
                                                            $ncv = !empty($notas[$periodo]['ncv']) ? $notas[$periodo]['ncv'] : 0;
                                                            $conv_final += $ncv;
                                                            if ($ncv <= $minima) {
                                                                echo '<span style="color:red">P' . $periodo_actual . ': ' . $ncv . '</span>';
                                                            } else {
                                                                echo '<span>P' . $periodo_actual . ': ' . $ncv . '</span>';
                                                            }
                                                            echo '<br>';
                                                        }

                                                        $cnv_def =  round(($conv_final / 4), 1);
                                                        $buscar_notacnv = strval($cnv_def);
                                                        $rencnv = RENDIMIENTOS[$sec][$buscar_notacnv][0];
                                                        $bancnv = RENDIMIENTOS[$sec][$buscar_notacnv][1];

                                                        echo '<span class="badge badge-pill badge-' . $bancnv . '">' . $cnv_def . ' ' . $rencnv . '</span>';

                                                        echo '</p>';
                                                        echo '</div>';
                                                        ?>
                                                    </div>
                                                <?php
                                                }
                                                ?>

                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Rendimiento</th>
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

<?php
    // Footer
    require_once FOOTER;
endif;
?>