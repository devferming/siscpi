<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once  SESIONES;

if ($_SESSION['nivel'] == 6) :
    require_once FUNCIONES;
    // Templates
    require_once HEADER;
    require_once BARRA;
    require_once NAVEGACION;

    date_default_timezone_set('America/Bogota');
    $hoy = date("Y-m-d H:i:s");

    $dgrupo = $_SESSION['datos']['pro_dgr'];
    $dgrupo_sec = $_SESSION['datos']['pro_dgs'];

    $dat = $_GET['data'];
    $dat = unserialize($dat);
    $hoy = date("Y-m-d H:i:s");

    $da2 = $dat['d1']; // periodo

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
                            REPORTE PERIODO <?php echo $da2 ?>
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
                                                ?>


                                                    <div class="row" style="justify-content: center; margin-top: 6px; gap:10px; padding:0 1em;">

                                                        <?php

                                                        foreach ($materias as $materia) {

                                                            $stmt = $conn->prepare("SELECT * FROM siscpi_materias WHERE mat_des_materia=?");
                                                            $stmt->bind_param("s", $materia);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();
                                                            $row = $result->fetch_assoc();

                                                            $log_actuales = json_decode($row['mat_logros'], true);
                                                            $ml_actuales = json_decode($row['mat_malla'], true);

                                                            $notas_logros = array();
                                                            $notas_logros_defi['defi'] = 0;

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

                                                            for ($lo = 1; $lo <= $log_actuales['p-' . $da2]['g-' . $gcod]; $lo++) {

                                                                $nota_logro_70 = 0;
                                                                $nota_logro_20 = 0;
                                                                $nota_logro_10 = 0;

                                                                for ($ev = 1; $ev <= 5; $ev++) {

                                                                    $nota_ev = isset($notas['p-' . $da2]['m-' . $materia]['l-' . $lo]['ev' . $ev]) ? $notas['p-' . $da2]['m-' . $materia]['l-' . $lo]['ev' . $ev] : 0;

                                                                    if ($ev === 1 or $ev === 2 or $ev === 3) {
                                                                        if ($nota_ev > 0) {
                                                                            $nota_logro_70 += number_format($nota_ev, 1);
                                                                        }
                                                                    }

                                                                    if ($ev === 4) {
                                                                        if ($nota_ev > 0) {
                                                                            $nota_logro_20 += number_format($nota_ev, 1);
                                                                        }
                                                                    }

                                                                    if ($ev === 5) {
                                                                        if ($nota_ev > 0) {
                                                                            $nota_logro_10 += number_format($nota_ev, 1);
                                                                        }
                                                                    }
                                                                }

                                                                $def70 = ($nota_logro_70 / 3) * 0.7;
                                                                $def20 = $nota_logro_20 * 0.2;
                                                                $def10 = $nota_logro_10 * 0.1;
                                                                $def = number_format($def70 + $def20 + $def10, 1, '.', '');

                                                                if (isset($ml_actuales["p-" . $da2]["g-" . $gcod]["a-" . $lo]["key"])) {
                                                                    $claves = explode('&', $ml_actuales["p-" . $da2]["g-" . $gcod]["a-" . $lo]["key"]);
                                                                    $claves2 = explode('-', $claves[0]);

                                                                    $area_tittle = array_search($claves2[1], SUBDIV);
                                                                    $area_tittle_pass = 1;
                                                                } else {
                                                                    $area_tittle = 'S/R';
                                                                    $area_tittle_pass = 0;
                                                                };

                                                                /* $notas_logros['AP-' . $lo]['name'] = $area_tittle;
                                                                $notas_logros['AP-' . $lo]['nota'] = $def; */

                                                                $font_size_report = '0.7rem';
                                                                if (isset($notas['p-' . $da2]['m-' . $materia]['l-' . $lo]['nov'])) {

                                                                    $crr_nov = $notas['p-' . $da2]['m-' . $materia]['l-' . $lo]['nov'];
                                                                    $def_novedad = $crr_nov === 'RECUPERADO' ? NOVEDADES[$sec]['BÁSICO'] : 0;

                                                                    if ($crr_nov === 'RECUPERADO') {
                                                                        echo '<span style="font-size:' . $font_size_report . '">AP' . $lo . ' (' . $area_tittle . '): ' . $def . '</span><span class="badge" style="color:#28A745; font-weight: bold; font-size:' . $font_size_report . '">REC</span>';
                                                                        echo '<br>';
                                                                    } elseif ($crr_nov === 'NO RECUPERADO') {
                                                                        echo '<span style="font-size:' . $font_size_report . '">AP' . $lo . ' (' . $area_tittle . '): ' . $def . '</span><span class="badge" style="color:red; font-weight: bold; font-size:' . $font_size_report . '">NREC</span>';
                                                                        echo '<br>';
                                                                    } else {
                                                                        echo '<span style="font-size:' . $font_size_report . '">AP' . $lo . ' (' . $area_tittle . '): ' . $def . '</span><span class="badge" style="color:red; font-weight: bold; font-size:' . $font_size_report . '">S/R</span>';
                                                                        echo '<br>';
                                                                    }
                                                                } else {

                                                                    if ($def <= $minima) {
                                                                        echo '<span style="color:red; font-size:' . $font_size_report . '">AP' . $lo . ' (' . $area_tittle . '): ' . $def . '</span><span class="badge" style="color:red; font-weight: bold; font-size:' . $font_size_report . '">S/R</span>';
                                                                    } else {
                                                                        echo '<span style="color:#28A745; font-size:' . $font_size_report . '">AP' . $lo . ' (' . $area_tittle . '): ' . $def . '</span>';
                                                                    }
                                                                    echo '<br>';
                                                                }
                                                            }

                                                            echo '<br>';

                                                            $nota_final = 0;

                                                            if (isset($notas['p-' . $da2]['m-' . $materia])) {
                                                                if (isset($notas['p-' . $da2]['m-' . $materia]['non'])) {
                                                                    $nota_final += $notas['p-' . $da2]['m-' . $materia]['non'];
                                                                } else {
                                                                    $nota_final += $notas['p-' . $da2]['m-' . $materia]['ncn'];
                                                                }
                                                            }



                                                            $nota_final = round($nota_final, 1);
                                                            $buscar_nota = strval($nota_final);
                                                            $ren = RENDIMIENTOS[$sec][$buscar_nota][0];
                                                            $ban = RENDIMIENTOS[$sec][$buscar_nota][1];

                                                            echo '<div class="text-center">';
                                                            echo '<span class="badge badge-pill badge-' . $ban . '" id="defnov' . $ida . '">' . $nota_final . ' ' . $ren . '</span>';
                                                            echo '</div>';
                                                            echo '</p>';
                                                            echo '</div>';
                                                        }

                                                        $conv_final = 0;

                                                        echo '<div class="card card-secondary">';
                                                        echo '<div class="card-header" style="padding: 2px; background-color: black">';
                                                        echo '<p class="card-title" style="font-size: 0.8rem;">:::  CNV  :::</p>';
                                                        echo '</div>';
                                                        echo '<p style="padding: 5px">';

                                                        $ncv = !empty($notas['p-' . $da2]['ncv']) ? $notas['p-' . $da2]['ncv'] : 0;
                                                        $conv_final += $ncv;

                                                        $cnv_def =  round($conv_final, 1);
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