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

    $dat = $_GET['data'];
    $dat = unserialize($dat);
    $hoy = date("Y-m-d H:i:s");

    $da1 = $dat['d1']; //grado
    $da2 = $dat['d2']; // periodo
    $da3 = $dat['d3']; // materia
    $da4 = $dat['d4']; // mateseccion

    $use = $_SESSION['logid']; // ID de usuario

    if (!filter_var($da1, FILTER_VALIDATE_INT) || !filter_var($da2, FILTER_VALIDATE_INT)) {
        die("ERROR!");
    }

    $mat = array_key_exists($da3, MATERIAS) ? $da3 : '';
    $per = isset(PERIODOS[$da2]) ? PERIODOS[$da2] : '';
    $gra = $sec = $lno = ''; //Grado, Sector, y llave para el select de logros

    if (isset(GRADOS[$da1])) {
        [$gra, $sec, $log] = GRADOS[$da1];
    }

    if (array_key_exists($gra, DGRUPOS)) {
        list($min, $minima_total, $peligro) = DGRUPOS[$gra];
    } else {
        $min = 0;
        $minima_total = 0;
        $peligro = 0;
    }

    $minima = number_format(($min + 0.1), 1, '.', '');



    $stmt = $conn->prepare("SELECT * FROM siscpi_materias WHERE mat_des_materia=?");
    $stmt->bind_param("s", $mat);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $ml_actuales = json_decode($row['mat_malla'], true);
    //$ap_actuales = json_decode($row['mat_aprendizajes'], true);
    $log_actuales = json_decode($row['mat_logros'], true);

?>

    <script>
        const logId = <?php echo json_encode($_SESSION['logid']); ?>;
        const modelo = '../modelos/notas-modelo.php'
    </script>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            <i class="fa fa-users-cog"></i>
                            Registro de Novedades
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
                        <h3 class="card-title">
                            Novedades del Grado:
                            <strong><span><?php echo $gra . ' (' . $da4 . ')';; ?></span></strong>
                            Materia: <strong><?php echo $mat ?></strong>
                            Periodo: <strong><?php echo $per ?></strong>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="mat-lista" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre y Apellido</th>
                                    <th>Rendimiento</th>
                                    <th>Indicadores</th>
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


                                ?>
                                <?php
                                foreach ($alumnos as $alumno) {
                                    $datos_alum = $alumno['datos'];
                                    $ida = $alumno['id'];
                                    $nombre_alum = $datos_alum['per_ape'] . ' ' . $datos_alum['per_nom'];
                                    if ($datos_alum['gra_esc'] === $gra && $datos_alum['gra_sec'] === $da4 && $datos_alum['estatus'] === 'MATRICULADO') { ?>

                                        <tr>
                                            <td>
                                                <?php echo $nombre_alum ?>
                                            </td>

                                            <td class="col-sm-3">
                                                <?php

                                                $periodos = array("p-1", "p-2", "p-3", "p-4");
                                                $materias = array("$mat");

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

                                                    $notas_logros = array();
                                                    $notas_logros_defi['defi'] = 0;

                                                    for ($lo = 1; $lo <= $log_actuales['p-' . $da2]['g-' . $da1]; $lo++) {

                                                        if (isset($notas['p-' . $da2]) 
                                                            && isset($notas['p-' . $da2]['m-' . $mat])
                                                            && isset($notas['p-' . $da2]['m-' . $mat]['ncn']))
                                                        {
                                                            $ncn = $notas['p-' . $da2]['m-' . $mat]['ncn'];
                                                        } else {
                                                            $ncn = 0;
                                                        }

                                                        if (isset($notas['p-' . $da2])
                                                            && isset($notas['p-' . $da2]['m-' . $mat])
                                                            && isset($notas['p-' . $da2]['m-' . $mat]['l-' . $lo])
                                                            && isset($notas['p-' . $da2]['m-' . $mat]['l-' . $lo]['nov']))
                                                        {
                                                            $crr_novedad = $notas['p-' . $da2]['m-' . $mat]['l-' . $lo]['nov'];
                                                            $def_novedad = $crr_novedad === 'RECUPERADO' ? NOVEDADES[$sec]['BÁSICO'] : 0;
                                                        } else {
                                                            $def_novedad = 'S/R';
                                                        }

                                                        $nota_logro_70 = 0;
                                                        $nota_logro_20 = 0;
                                                        $nota_logro_10 = 0;

                                                        for ($ev = 1; $ev <= 5; $ev++) {

                                                            if (isset($notas['p-' . $da2])
                                                                && isset($notas['p-' . $da2]['m-' . $mat])
                                                                && isset($notas['p-' . $da2]['m-' . $mat]['l-' . $lo])
                                                                && isset($notas['p-' . $da2]['m-' . $mat]['l-' . $lo]['ev' . $ev]))
                                                            {
                                                                $nota_ev = $notas['p-' . $da2]['m-' . $mat]['l-' . $lo]['ev' . $ev];
                                                            } else {
                                                                $nota_ev = 0;
                                                            }

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

                                                        if (isset($ml_actuales["p-" . $da2]["g-" . $da1]["a-" . $lo]["key"])) {
                                                            $claves = explode('&', $ml_actuales["p-" . $da2]["g-" . $da1]["a-" . $lo]["key"]);
                                                            $claves2 = explode('-', $claves[0]);

                                                            $area_tittle = array_search($claves2[1], SUBDIV);
                                                            $area_tittle_pass = 1;
                                                        } else {
                                                            $area_tittle = '';
                                                            $area_tittle_pass = 0;
                                                        };


                                                        $notas_logros['AP-' . $lo]['name'] = $area_tittle;
                                                        $notas_logros['AP-' . $lo]['nota'] = $def;


                                                        if (isset($notas['p-' . $da2]) 
                                                            && isset($notas['p-' . $da2]['m-' . $mat])
                                                            && isset($notas['p-' . $da2]['m-' . $mat]['l-' . $lo])
                                                            && isset($notas['p-' . $da2]['m-' . $mat]['l-' . $lo]['nov']))
                                                        {
                                                            if ($def_novedad === 0 or $def_novedad === 'S/R') {
                                                                $notas_logros_defi['defi'] = $notas_logros_defi['defi'] + $def;
                                                                $notas_logros['AP-' . $lo]['nove'] = $def;
                                                            } else {
                                                                $notas_logros_defi['defi'] = $notas_logros_defi['defi'] + $def_novedad;
                                                                $notas_logros['AP-' . $lo]['nove'] = $def_novedad;
                                                            }
                                                        } else {
                                                            $notas_logros_defi['defi'] = $notas_logros_defi['defi'] + $def;
                                                            $notas_logros['AP-' . $lo]['nove'] = $def_novedad;
                                                        }
                                                    }

                                                    $final_count = 0;
                                                    foreach ($notas_logros as $key => $value) { ?>

                                                        <fieldset class="fiel-custom">
                                                            <legend class=""><small class=""><?php echo $key . ': ' . $value['name'] ?></small></legend>
                                                            <p>
                                                                <?php

                                                                if ($value['nota'] < $minima) {
                                                                    if ($value['nove'] < $minima or  $value['nove'] === 'S/R') {
                                                                        $nove_style = "color:red; font-weight: 700;";
                                                                    } else {
                                                                        $nove_style = "color:#28A745; font-weight: 700;";
                                                                    }
                                                                ?>

                                                                    <span>Def:</span><span style="color:red; font-weight: 700;"> <?php echo $value['nota'] ?> </span>
                                                                    <span>Nov:</span><span id="<?php echo 'nov-def' . $key . $ida ?>" style="<?php echo $nove_style ?>"> <?php echo $value['nove'] ?> </span>
                                                                    <a style="color:#212529; cursor:pointer;">
                                                                        <i class="fas fa-edit zoom" onclick="modalConvi(
                                                                            '<?php echo $nombre_alum ?>',
                                                                            '<?php echo $da2 ?>',
                                                                            '<?php echo $ida ?>',
                                                                            '<?php echo $mat ?>',
                                                                            '<?php echo $sec ?>',
                                                                            '<?php echo $minima ?>',
                                                                            '<?php echo $key ?>',
                                                                            '<?php echo $value['name'] ?>',
                                                                            '<?php echo $log_actuales['p-' . $da2]['g-' . $da1] ?>',
                                                                            '<?php echo $value['nota'] ?>'
                                                                            )">
                                                                        </i>
                                                                    </a>

                                                                <?php
                                                                } else {
                                                                    echo '<span style="color:#28A745; font-weight: 700;">' . $value['nota'] . '</span>';
                                                                }
                                                                ?>

                                                            </p>
                                                        </fieldset>
                                                        <br>
                                                    <?php
                                                    }

                                                    $nota_log_cnt = number_format($notas_logros_defi['defi'] / $log_actuales['p-' . $da2]['g-' . $da1], 1, '.', '');

                                                    [$rend, $band] = RENDIMIENTOS[$sec][strval($nota_log_cnt)];

                                                    ?>
                                                    <span>Rendimiento: <strong id="<?php echo 'nov-ren-' . $ida ?>"><?php echo $nota_log_cnt ?></strong> <span class="badge badge-pill badge-<?php echo $band ?>" id="<?php echo 'nov-ban-' . $ida ?>"><?php echo $rend ?></span></span>

                                                    <div class="row ">
                                                        <?php
                                                        echo '</p>';
                                                        echo '</div>';
                                                        ?>
                                                    </div>
                                                <?php
                                                }
                                                ?>

                                            </td>

                                            <td class="col-sm-7">

                                                <?php

                                                $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
                                                $stmt->bind_param("ss", $mat, $gra);
                                                $stmt->execute();
                                                $result3 = $stmt->get_result();
                                                $row2 = $result3->fetch_assoc();
                                                $notasclv_datos = json_decode($row2['datos'], true);


                                                $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
                                                $stmt->bind_param("i", $ida);
                                                $stmt->execute();
                                                $result2 = $stmt->get_result();

                                                if ($result2->num_rows > 0) {
                                                    $row = $result2->fetch_assoc();
                                                    $notas_cnv = json_decode($row['datos'], true);

                                                    /* Datos a usar en caso de que no haya nigún indicador asignado */
                                                    $new_notas = [];
                                                    $new_notas = $notas_cnv;
                                                    $nota_final_string = strval($nota_log_cnt);
                                                    $notas_clt = $notasclv_datos[$per];
                                                    if (isset(RENDIMIENTOS[$sec][$nota_final_string])) {
                                                        [$rendimiento, $flag, $cualitativo] = RENDIMIENTOS[$sec][$nota_final_string];
                                                    }
                                                    /********************************************************** */

                                                    if (isset($notas_cnv['p-' . $da2]['m-' . $mat]['ftz'])) {
                                                        $ftz_mat_id = $notas_cnv['p-' . $da2]['m-' . $mat]['ftz'];
                                                        $ftz_array = explode('+', $ftz_mat_id);
                                                        $ftz_per = $ftz_array[0];
                                                        $ftz_ren = $ftz_array[1];
                                                        $ftz_niv = $ftz_array[2];
                                                        $ftz_des = $ftz_array[3];
                                                        $nota_ftz_desc = $notasclv_datos[$ftz_per][$ftz_ren][$ftz_niv][$ftz_des];
                                                    } else {
                                                        $fort = $notas_clt[$rendimiento]['n' . $cualitativo]['ftz'];
                                                        $new_notas['p-' . $da2]['m-' . $mat]['ftz'] = $per . '+' . $rendimiento . '+n' . $cualitativo . '+ftz';
                                                        $notas_nuevas_ftz = json_encode($new_notas);
                                                        try {
                                                            $stmt = $conn->prepare("UPDATE siscpi_notas SET datos=?, editado=? WHERE id_alumno=?");
                                                            $stmt->bind_param('ssi', $notas_nuevas_ftz, $hoy, $ida);
                                                            $stmt->execute();

                                                            if ($stmt->affected_rows) {
                                                                $nota_ftz_desc = $fort;
                                                            } else {
                                                                $nota_ftz_desc = '***';
                                                            }
                                                        } catch (Exception $e) {
                                                            echo "FALLO N2:" . $e->getMessage();
                                                        }
                                                    }

                                                    if (isset($notas_cnv['p-' . $da2]['m-' . $mat]['deb'])) {
                                                        $deb_mat_id = $notas_cnv['p-' . $da2]['m-' . $mat]['deb'];
                                                        $deb_array = explode('+', $deb_mat_id);
                                                        $deb_per = $deb_array[0];
                                                        $deb_ren = $deb_array[1];
                                                        $deb_niv = $deb_array[2];
                                                        $deb_des = $deb_array[3];
                                                        $nota_deb_desc = $notasclv_datos[$deb_per][$deb_ren][$deb_niv][$deb_des];
                                                    } else {
                                                        $debi = $notas_clt[$rendimiento]['n' . $cualitativo]['deb'];
                                                        $new_notas['p-' . $da2]['m-' . $mat]['deb'] = $per . '+' . $rendimiento . '+n' . $cualitativo . '+deb';
                                                        $notas_nuevas_deb = json_encode($new_notas);

                                                        try {
                                                            $stmt = $conn->prepare("UPDATE siscpi_notas SET datos=?, editado=? WHERE id_alumno=?");
                                                            $stmt->bind_param('ssi', $notas_nuevas_deb, $hoy, $ida);
                                                            $stmt->execute();

                                                            if ($stmt->affected_rows) {
                                                                $nota_deb_desc = $debi;
                                                            } else {
                                                                $nota_deb_desc = '***';
                                                            }
                                                        } catch (Exception $e) {
                                                            echo "FALLO N2:" . $e->getMessage();
                                                        }
                                                    }

                                                    if (isset($notas_cnv['p-' . $da2]['m-' . $mat]['rec'])) {
                                                        $rec_mat_id = $notas_cnv['p-' . $da2]['m-' . $mat]['rec'];
                                                        $rec_array = explode('+', $rec_mat_id);
                                                        $rec_per = $rec_array[0];
                                                        $rec_ren = $rec_array[1];
                                                        $rec_niv = $rec_array[2];
                                                        $rec_des = $rec_array[3];
                                                        $nota_rec_desc = $notasclv_datos[$rec_per][$rec_ren][$rec_niv][$rec_des];
                                                    } else {
                                                        $reco = $notas_clt[$rendimiento]['n' . $cualitativo]['rec'];
                                                        $new_notas['p-' . $da2]['m-' . $mat]['rec'] = $per . '+' . $rendimiento . '+n' . $cualitativo . '+rec';
                                                        $notas_nuevas_rec = json_encode($new_notas);
                                                        try {
                                                            $stmt = $conn->prepare("UPDATE siscpi_notas SET datos=?, editado=? WHERE id_alumno=?");
                                                            $stmt->bind_param('ssi', $notas_nuevas_rec, $hoy, $ida);
                                                            $stmt->execute();

                                                            if ($stmt->affected_rows) {
                                                                $nota_rec_desc = $reco;
                                                            } else {
                                                                $nota_rec_desc = '***';
                                                            }
                                                        } catch (Exception $e) {
                                                            echo "FALLO N2:" . $e->getMessage();
                                                        }
                                                    }
                                                } else {
                                                    $nota_ftz_desc = '0';
                                                    $nota_deb_desc = '0';
                                                    $nota_rec_desc = '0';
                                                }

                                                ?>

                                                <strong style="cursor:pointer"><span style="color: blue" onclick="desModal('<?php echo $ida ?>', 'ftz','<?php echo $per ?>')">Fortalezas: </span></strong>
                                                <span id="des-forta-<?php echo $ida ?>"><?php echo $nota_ftz_desc ?></span>
                                                <br>

                                                <strong style="cursor:pointer"><span style="color: red" onclick="desModal('<?php echo $ida ?>', 'deb','<?php echo $per ?>')">Debilidades: </span></strong>
                                                <span id="des-debil-<?php echo $ida ?>"><?php echo $nota_deb_desc ?></span>
                                                <br>

                                                <strong style="cursor:pointer"><span style="color: #1f8435" onclick="desModal('<?php echo $ida ?>', 'rec','<?php echo $per ?>')">Recomendaciones: </span></strong>
                                                <span id="des-recom-<?php echo $ida ?>"><?php echo $nota_rec_desc ?></span>

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
                                    <th>Indicadores</th>
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
                    <h5 class="modal-title"><small><strong><i class="fas fa-user"></i><?php echo ' ' ?><span id="modal-convi-alumno">Fermin</span></strong></small> <small id="modal-convi-alumno-periodo">- Resultado Recuperación<span id="modal-numero-logro"></span></small></h5>
                    <h6></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label><span class="badge badge-pill">RESULTADO</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text badge-warning"><i class="fas fa-edit"></i></span>
                                    </div>
                                    <select class="form-control bloquear" name="cal-convi" id="cal-convi">
                                        <option value="" selected></option>
                                        <option value="RECUPERADO">RECUPERADO</option>
                                        <option value="NO RECUPERADO">NO RECUPERADO</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Este campo es obligatorio.
                                    </div>
                                </div>
                            </div>
                        </div> <!-- col -->

                        <input type="hidden" id="idalum-convi" value="">
                        <input type="hidden" id="perlum-convi" value="">
                        <input type="hidden" id="matlum-convi" value="">
                        <input type="hidden" id="seclum-convi" value="">
                        <input type="hidden" id="minlum-convi" value="">
                        <input type="hidden" id="lognum-convi" value="">
                        <input type="hidden" id="logact-convi" value="">
                        <input type="hidden" id="logfno-convi" value="">
                    </div>
                    <!-- /.row -->


                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-success" onClick="regConvi()">Confirmar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-forta">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><small><strong><i class="fas fa-user"></i><span>Banco de fortalezas (<?php echo $mat ?>)</span></strong></small></h5>
                    <h6></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <?php /*
            <div class="row">

                <?php

                $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
                $stmt->bind_param("ss", $mat, $gra);
                $stmt->execute();
                $result_ftz = $stmt->get_result();
                $des_ftz = $result_ftz->fetch_assoc();
                $banco2 = json_decode($des_ftz['datos'], true);
                $banco = $banco2[$per];

                $orden = array('SUPERIOR', 'ALTO', 'BÁSICO', 'BAJO');

                foreach ($orden as $nivel) {
                if (isset($banco[$nivel])) {
                    foreach ($banco[$nivel] as $key2 => $value2) {
                    if (isset($value2['ftz'])) {
                        $id = $per . '+' . $nivel . '+' . $key2 . '+ftz';
                        $concatenatedKeys = $key2 . ' (' . $nivel . ')';
                        $content = $value2['ftz'];
                        echo '<div class="col-sm-12">';
                        echo '<div class="form-group">';
                        echo '<p style="cursor:pointer; background-color: #87cefa4a" onclick="cambiaForta(\'' . $id . '\', \'' . $content . '\')">';
                        echo '<strong>' . $concatenatedKeys . '</strong>';
                        echo '<br>';
                        echo $content;
                        echo '<hr>';
                        echo '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                    }
                }
                }

                ?>

                <input type="hidden" id="idalum-forta" value="">



            </div>}
            */ ?>

                    <div class="row" id="modal-container">
                        <!-- Aquí se generará dinámicamente el contenido del modal -->
                    </div>

                    <input type="hidden" id="idalum-forta" value="">

                </div>
                <!-- /.modal-body -->

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-debil">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><small><strong><i class="fas fa-user"></i><span>Banco de debilidades (<?php echo $mat ?>)</span></strong></small></h5>
                    <h6></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="row">

                        <?php

                        $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
                        $stmt->bind_param("ss", $mat, $periodo);
                        $stmt->execute();
                        $banco_desc2 = $stmt->get_result();

                        while ($banco = $banco_desc2->fetch_assoc()) {

                            if ($banco['datos'] !== 'N/A') { ?>

                                <div class="col-sm-12">
                                    <div class="form-group">

                                        <p style="cursor:pointer; background-color: #87cefa4a" onclick="cambiaDebil('<?php echo 'id de la nota cualitaiva' ?>')">
                                            <strong><?php echo 'rendiminiento en texto' . ' (' . 'nivel del rendimineto' . ')' ?>: </strong>
                                            <?php echo 'debilidades' ?>
                                            <hr>
                                        </p>
                                    </div>
                                </div> <!-- col -->


                        <?php
                            }
                        }


                        ?>

                        <input type="hidden" id="idalum-debil" value="">

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

    <div class="modal fade" id="modal-recom">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><small><strong><i class="fas fa-user"></i><span>Banco de recomendaciones (<?php echo $mat ?>)</span></strong></small></h5>
                    <h6></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="row">

                        <?php

                        $stmt = $conn->prepare("SELECT * FROM siscpi_cualitativas WHERE materia=? AND grado=?");
                        $stmt->bind_param("ss", $mat, $periodo);
                        $stmt->execute();
                        $banco_desc2 = $stmt->get_result();

                        while ($banco = $banco_desc2->fetch_assoc()) {

                            if ($banco['datos'] !== 'N/A') { ?>

                                <div class="col-sm-12">
                                    <div class="form-group">

                                        <p style="cursor:pointer; background-color: #87cefa4a" onclick="cambiaRecom('<?php echo 'ide de la nota cualitativa' ?>')">
                                            <strong><?php echo 'rendimineto en texto' . ' (' . 'nivel del rendimiento' . ')' ?>: </strong>
                                            <?php echo 'recomendaciones' ?>
                                            <hr>
                                        </p>
                                    </div>
                                </div> <!-- col -->


                        <?php
                            }
                        }


                        ?>

                        <input type="hidden" id="idalum-recom" value="">

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



<?php
    // Footer
    require_once FOOTER;
endif;
?>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
    });

    function modalConvi(alu, per, ida, mat, sec, min, key, asg, lac, fno) {

        const logNum = key.split('-')[1];

        $('#modal-convi-alumno').text(alu);
        $('#modal-convi-alumno-periodo').text(`Novedad: ${asg} / Periodo: ${per}`);
        $('#idalum-convi').val(ida);
        $('#perlum-convi').val(per);
        $('#matlum-convi').val(mat);
        $('#seclum-convi').val(sec);
        $('#minlum-convi').val(min);
        $('#lognum-convi').val(logNum);
        $('#logact-convi').val(lac);
        $('#logfno-convi').val(fno);
        $('#modal-convi').modal();

    }

    async function regConvi() {
        $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:flex;');
        let min = $('#minlum-convi').val()
        const data = {
            cmd: "regnov",
            user_id: logId,
            ida: $('#idalum-convi').val(),
            not: $('#cal-convi').val(),
            per: $('#perlum-convi').val(),
            mat: $('#matlum-convi').val(),
            sec: $('#seclum-convi').val(),
            lon: $('#lognum-convi').val(),
            lac: $('#logact-convi').val(),
            fno: $('#logfno-convi').val()
        };

        const response = await fetch(modelo, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data),
        });

        const responseData = await response.json()

        if (responseData.respuesta === 'exito') {
            Toast.fire({
                icon: 'success',
                title: responseData.comentario
            });

            if (responseData.not === 'RECUPERADO') {
                $('#nov-defAP-' + responseData.lon + responseData.ida).text(' ' + responseData.nre);
                $('#nov-defAP-' + responseData.lon + responseData.ida).attr('style', 'color:#28A745; font-weight: bold;');
            } else {
                $('#nov-defAP-' + responseData.lon + responseData.ida).text(' ' + responseData.nre);
                $('#nov-defAP-' + responseData.lon + responseData.ida).attr('style', 'color:red; font-weight: bold;');
            }

            $('#nov-ren-' + responseData.ida).text('' + responseData.def);
            $('#nov-ban-' + responseData.ida).attr('class', 'badge badge-pill badge-' + responseData.ban + '').text(responseData.ren);;

            $('#modal-convi').modal('hide');
            $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:none;');

        } else {
            Toast.fire({
                icon: 'error',
                title: responseData.comentario
            });
            $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:none;');
        }
    }

    function desModal(ida, tipo, per) {
        var modalContainer = document.getElementById('modal-container');
        modalContainer.innerHTML = '';

        (async () => {

            const data = {
                cmd: "sqlftz",
                user_id: logId,
                mat: "<?php echo $mat ?>",
                gra: '<?php echo $gra ?>'
            };

            try {
                const response = await fetch(modelo, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data),
                });

                const responseData = await response.json();

                if (responseData.respuesta == 'exito') {

                    let banco2 = JSON.parse(responseData.data);
                    let tipoDatos = banco2[per];
                    const subKeyMapping = {
                        'n1': 1,
                        'n2': 2,
                        'n3': 3
                    };

                    const tiposOrdenados = ['SUPERIOR', 'ALTO', 'BÁSICO', 'BAJO'];

                    tiposOrdenados.forEach(function(tipoOrdenado) {
                        if (tipoDatos[tipoOrdenado]) {
                            Object.entries(tipoDatos[tipoOrdenado]).forEach(function([nivel, ftzObjec]) {

                                Object.entries(ftzObjec).forEach(function([ftzTipo, ftzDesc]) {
                                    let subkey2 = subKeyMapping[nivel];
                                    let tipo2 = Object.keys(ftzObjec).find(key => key === tipo);

                                    if (tipo2 === ftzTipo) {
                                        let id = per + '+' + tipoOrdenado + '+' + nivel + '+' + tipo;
                                        let concatenatedKeys = tipoOrdenado + ' (' + subkey2 + ')';

                                        let div = document.createElement('div');
                                        div.className = 'col-sm-12';

                                        let formGroup = document.createElement('div');
                                        formGroup.className = 'form-group';

                                        let p = document.createElement('p');
                                        p.style.cursor = 'pointer';
                                        p.style.backgroundColor = '#87cefa4a';
                                        p.onclick = function() {
                                            cambiaForta(id, tipo, ftzObjec[ftzTipo]);
                                        };

                                        let strong = document.createElement('strong');
                                        strong.textContent = concatenatedKeys;

                                        let br = document.createElement('br');

                                        let contentText = document.createTextNode(ftzObjec[ftzTipo]);

                                        let hr = document.createElement('hr');

                                        p.appendChild(strong);
                                        p.appendChild(br);
                                        p.appendChild(contentText);
                                        p.appendChild(hr);

                                        formGroup.appendChild(p);

                                        div.appendChild(formGroup);

                                        modalContainer.appendChild(div);
                                    }
                                });
                            });
                        }
                    });







                } else {
                    Toast.fire({
                        icon: 'error',
                        title: resultado.comentario
                    })
                }


            } catch (error) {
                console.error(error);
            }

            $('#idalum-forta').val(ida);
            $('#modal-forta').modal();


        })();

    }


    function cambiaForta(desc, tipo, content) {

        $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:flex;');

        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 8000,
        });

        (async () => {

            let ide_a = $('#idalum-forta').val();

            const data = {
                cmd: "ftzatc",
                cmd2: tipo,
                ida: ide_a,
                mat: "<?php echo $mat ?>",
                gra: "<?php echo $gra ?>",
                per: "<?php echo $da2 ?>",
                des: desc,
                user_id: logId,
            };

            try {
                const response = await fetch(modelo, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data),
                });

                const responseData = await response.json();
                if (responseData.respuesta == 'exito') {

                    Toast.fire({
                        icon: 'success',
                        title: responseData.comentario
                    })

                    let ftz2;
                    let nombreModal;

                    if (tipo === 'ftz') {
                        ftz2 = 'des-forta-'
                        nombreModal = 'Fortalezas'
                    } else if (tipo === 'deb') {
                        ftz2 = 'des-debil-'
                        nombreModal = 'Debilidades'
                    } else if (tipo === 'rec') {
                        ftz2 = 'des-recom-'
                        nombreModal = 'Recomendaciones'
                    }

                    console.log(tipo);
                    console.log('#' + ftz2 + '-' + ide_a);

                    $('#' + ftz2 + ide_a).text(content);
                    $('#modal-forta').modal('hide');

                } else {
                    Toast.fire({
                        icon: 'error',
                        title: responseData.comentario
                    })
                }

            } catch (error) {
                console.error(error);
            }

            $('#cortina-de-espera').attr('style', 'overflow-y: auto; display:none;');

        })();

    }
</script>