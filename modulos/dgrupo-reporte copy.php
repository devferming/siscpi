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

?>

    <?php

    if (array_key_exists($dgrupo, DGRUPOS)) {
        list($minima, $minima_total, $peligro) = DGRUPOS[$dgrupo];
    } else {
        $minima = 0;
        $minima_total = 0;
        $peligro = 0;
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
                                    <th>Nombre y Apellido</th>
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
                                            <?php echo $datos_alum['per_ape'] . ' ' . $datos_alum['per_nom'] ?>
                                        </td>

                                        <td>
                                            <?php

                                            $periodos = array("p-1", "p-2", "p-3", "p-4");
                                            $materias = array("SOCIALES", "ESPAÑOL", "MATEMÁTICAS", "NATURALES", "INGLÉS", "INFORMÁTICA", "ÉTICA Y RELIGIÓN", "ARTÍSTICA", "MÚSICA", "DEPORTE", "LECTORES");

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
                                                        $ncn = isset($notas[$periodo]['m-' . $materia]['ncn']) ? $notas[$periodo]['m-' . $materia]['ncn'] : 0;
                                                        $notas_materia_periodo[$materia]['ncn'] = $ncn;
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
                                                                echo '<strong style="color:red">P' . $periodo_actual . ': ' . $ncn . '</strong>';
                                                            } else {
                                                                echo '<strong>P' . $periodo_actual . ': ' . $ncn . '</strong>';
                                                            }
                                                            echo '<br>';
                                                        }

                                                        $soc_necesita = $minima_total - ($notas_periodos['p-1'][$materia]['ncn'] + $notas_periodos['p-2'][$materia]['ncn'] + $notas_periodos['p-3'][$materia]['ncn'] + $notas_periodos['p-4'][$materia]['ncn']);

                                                        if ($soc_necesita > 0) {
                                                            echo '<strong style="color:red">NR: ' . $soc_necesita . '</strong>';
                                                        } else {
                                                            echo '<strong style="color:#28A745">NR: ' . $soc_necesita . '</strong>';
                                                        }

                                                        echo '</p>';
                                                        echo '</div>';
                                                    }
                                                    ?>



                                                    <?php
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
                                                            echo '<strong style="color:red">P' . $periodo_actual . ': ' . $ncv . '</strong>';
                                                        } else {
                                                            echo '<strong>P' . $periodo_actual . ': ' . $ncv . '</strong>';
                                                        }
                                                        echo '<br>';
                                                    }

                                                    $conv_necesita = $minima_total - $conv_final;

                                                    if ($conv_necesita > 0) {
                                                        echo '<strong style="color:red">NR: ' . $conv_necesita . '</strong>';
                                                    } else {
                                                        echo '<strong style="color:#28A745">NR: ' . $conv_necesita . '</strong>';
                                                    }

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
                                    <th>Nombre y Apellido</th>
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