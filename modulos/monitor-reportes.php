<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once  SESIONES;

if ($_SESSION['nivel'] == 3 || $_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 5) :
    require_once FUNCIONES;
    // Templates
    require_once HEADER;
    require_once BARRA;
    require_once NAVEGACION;

    $dat = $_GET['data'];
    $dat = unserialize($dat);
    $dgrupo = $dat['gra'];

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

      $notas_alicia = array();

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
                            MONITOR DE GRUPO
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
                        <h3 class="card-title">Dirección del Grado: <strong><span><?php echo $dgrupo; ?></span></strong></h3>
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

                                    try {
                                        $stmt = $conn->prepare("SELECT * FROM siscpi_alumnos");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                    } catch (\Exception $e) {
                                        $error = $e->getMessage();
                                        echo $error;
                                    }
                                } catch (\Exception $e) {
                                    $error = $e->getMessage();
                                    echo $error;
                                }
                                ?>
                                <?php
                                while ($datos = $result->fetch_assoc()) {
                                    $datos_alum = json_decode($datos['datos'], true);
                                    $ida = $datos['id'];
                                    
                                    if ($datos_alum['gra_esc'] == $dgrupo) { ?>

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
                                                            $ncn = isset($notas[$periodo]['m-' . $materia]['ncn']) ? $notas[$periodo]['m-' . $materia]['ncn'] : 0;
                                                            $nnv = $notas[$periodo]['m-' . $materia]['nov'];
                                                            $non = NOVEDADES[$sec][$nnv];

                                                            $notas_materia_periodo[$materia]['ncn'] = $ncn;
                                                            $notas_materia_periodo[$materia]['nov'] = $nnv;
                                                            $notas_materia_periodo[$materia]['non'] = $non;

                                                        } else {
                                                            $ncn = isset($notas[$periodo]['m-' . $materia]['ncn']) ? $notas[$periodo]['m-' . $materia]['ncn'] : 0;
                                                            $notas_materia_periodo[$materia]['ncn'] = $ncn;
                                                        }
                                                        
                                                    }

                                                    $notas_periodos[$periodo] = $notas_materia_periodo;
                                                }
                                                ?>


                                                <div class="row ">

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
                                                        echo '<p class="card-title" style="font-size: 0.8rem;">:::' . $mat_apodo . ':::</p>';
                                                        echo '</div>';
                                                        echo '<p style="padding: 5px">';

                                                            foreach ($notas_periodos as $periodo => $notas_materia_periodo) {
                                                                $periodo_actual = substr($periodo, 2);
                                                                //$notas_materia = $notas_periodos;

                                                                $ncn = $notas_materia_periodo[$materia]['ncn'];

                                                                if ($ncn <= $minima) {
                                                                    echo '<span style="color:red">P' . $periodo_actual . ': ' . $ncn . '</span>';
                                                                    if (isset($notas_materia_periodo[$materia]['nov'])) {
                                                                        $resultado_recuperacion = $notas_materia_periodo[$materia]['nov'];
                                                                        $nota_recuperacion = $notas_materia_periodo[$materia]['non'];
                                                                        if ($resultado_recuperacion === 'BÁSICO') {
                                                                            echo '<span class="badge" id="nov'.$ida.$periodo_actual.'" style="color:#28A745; font-weight: bold;">REC ('.$nota_recuperacion.')</span>';
                                                                        } elseif ($resultado_recuperacion === 'BAJO') {
                                                                            echo '<span class="badge" id="nov'.$ida.$periodo_actual.'" style="color:red; font-weight: bold;">PER ('.$nota_recuperacion.')</span>';
                                                                        }
                                                                    } else {
                                                                        echo '<span class="badge" style="color:black; font-weight: bold;">s/r</span>';
                                                                    }
                                                                } else {
                                                                    echo '<span>P' . $periodo_actual . ': ' . $ncn . '</span>';
                                                                }
                                                                echo '<br>';
                                                            }

                                                            
                                                            $nota_final = 0;
                                                            if (isset($notas_periodos['p-1'][$materia]['non'])) {
                                                                $nota_final += $notas_periodos['p-1'][$materia]['non'];
                                                            } else {
                                                                $nota_final += $notas_periodos['p-1'][$materia]['ncn'];
                                                                $noum = $datos_alum['per_ape'].' '.$datos_alum['per_nom'];
                                                                //$notas_alicia[$noum] = $notas_alicia[$noum] + $nota_final;
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
                                            
                                                        echo '<span class="badge badge-pill badge-'.$ban.'" id="defnov'.$ida.'">'.$nota_final .' '.$ren.'</span>';
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

                                                    echo '<span class="badge badge-pill badge-'.$bancnv.'">'.$cnv_def .' '.$rencnv.'</span>';

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

                                /* echo '<pre>';
                                    print_r($notas_alicia);
                                echo '</pre>'; */
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

    <div class="modal fade" id="modal-convi">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><small><strong><i class="fas fa-user"></i><?php echo ' ' ?><span id="modal-convi-alumno">Fermin</span></strong></small> <small>- Calificación por Conviviencia<span id="modal-numero-logro"></span></small></h5>
                    <h6></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-sm-6">
                            <span class="badge" style="background-color: #dc3545; color:white">SOC </span><span id="conv-soc"></span><br>
                            <span class="badge" style="background-color: #6c757d; color:white">ESP </span><span id="conv-esp"></span><br>
                            <span class="badge" style="background-color: #17a2b8; color:white">MAT </span><span id="conv-mat"></span><br>
                            <span class="badge" style="background-color: #007bff; color:white">NAT </span><span id="conv-nat"></span><br>
                            <span class="badge" style="background-color: #ffc107; color:black">ING </span><span id="conv-ing"></span><br>
                            <span class="badge" style="background-color: #001f3f; color:white">INF </span><span id="conv-inf"></span><br>
                            <span class="badge" style="background-color: #f012be; color:white">ART </span><span id="conv-art"></span><br>
                            <span class="badge" style="background-color: #6f42c1; color:white">ETC </span><span id="conv-etc"></span><br>
                            <span class="badge" style="background-color: #28a745; color:white">MUS </span><span id="conv-mus"></span><br>
                            <span class="badge" style="background-color: #b8ac17; color:white">DEP </span><span id="conv-dep"></span><br>

                        </div> <!-- col -->

                    </div>
                    <!-- /.row -->

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <script>
        function notaConvivencia(soc, esp, mat, nat, ing, inf, art, etc, mus, dep, alu) {

            $('#modal-convi-alumno').text(alu);

            $('#conv-soc').text(' - ' + soc);
            $('#conv-esp').text(' - ' + esp);
            $('#conv-mat').text(' - ' + mat);
            $('#conv-nat').text(' - ' + nat);
            $('#conv-ing').text(' - ' + ing);
            $('#conv-inf').text(' - ' + inf);
            $('#conv-art').text(' - ' + art);
            $('#conv-etc').text(' - ' + etc);
            $('#conv-mus').text(' - ' + mus);
            $('#conv-dep').text(' - ' + dep);

            $('#modal-convi').modal();

        }
    </script>

<?php
    // Footer
    require_once FOOTER;
endif;
?>