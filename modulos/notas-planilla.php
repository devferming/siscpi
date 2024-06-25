<?php $nivel = 2;

require_once '../funciones/configuracion.php';
require_once  SESIONES;

if ($_SESSION['nivel'] == 6) :

  require_once FUNCIONES;

  // Templates
  require_once HEADER;
  require_once BARRA;
  require_once NAVEGACION;

  $dat = $_GET['data'];
  $dat = unserialize($dat);
  $hoy = date("Y-m-d H:i:s");

  $da1 = $dat['d1']; //grado
  $da2 = $dat['d2']; // periodo
  $da3 = $dat['d3']; // materia
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

  $stmt = $conn->prepare("SELECT * FROM siscpi_materias WHERE mat_des_materia=?");
  $stmt->bind_param("s", $mat);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  $log = $row[$log . $da2]; // Cantidad de logros para la materia

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
              Planilla de notas
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
              Grado: <strong><span><?php echo $gra; ?></span></strong> &nbsp;
              Periodo: <strong><span><?php echo $per; ?></span></strong> &nbsp;
              Materia: <strong><span><?php echo $mat; ?></span></strong>
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            <?php /*
            <table id="tablaplanilla" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>N°</th>
                  <th>APELLIDOS Y NOMBRES</th>
                  <th>DESEMPEÑO</th>

                  <?php

                  for ($i=0; $i < $log ; $i++) { ?>

                    <th>A1</th>
                    <th>A2</th>
                    <th>A3</th>
                    <th>70%</th>
                    <th>AC</th>
                    <th>20%</th>
                    <th>EP</th>
                    <th>10%</th>
                    <th>P1</th>

                    <?php
                  } ?>


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

                while ($row  = $result->fetch_assoc()) {
                  $dat_alum = json_decode($row['datos'], true); //Obtiene todos los datos del alumno
                  $ide_alum = $row['id']; //Obtiene el ID del alumno
                  $acumulada = 0;

                  if ($dat_alum['gra_esc'] == $gra) { ?>


                    <tr>

                      <td>
                        <i class="fas fa-user"></i><?php echo ' ' . $nom_alum = $dat_alum['per_ape'] . " " . $dat_alum['per_nom']; ?><br>
                        <?php

                        $in = 1;
                        $fn = $log;

                        for ($i = $in; $i <= $fn; $i++) {

                          $stmt = $conn->prepare("SELECT * FROM siscpi_notas WHERE id_alumno=?");
                          $stmt->bind_param("i", $ide_alum);
                          $stmt->execute();
                          $notas_resultado = $stmt->get_result();

                          if ($notas_resultado->num_rows > 0) {
                            $notas_detalle = $notas_resultado->fetch_assoc();
                            $notas = json_decode($notas_detalle['datos'], true);

                            $nota_ev1 = 0;
                            $nota_ev2 = 0;
                            $nota_ev3 = 0;
                            $nota_ev4 = 0;
                            $nota_ev5 = 0;

                            for ($j = 1; $j <= 5; $j++) {
                              $nota_key = 'ev' . $j;
                              $nota = isset($notas['p-' . $da2]['m-' . $mat]['l-' . $in][$nota_key]) ? $notas['p-' . $da2]['m-' . $mat]['l-' . $in][$nota_key] : null;

                              switch ($nota) {
                                case '':
                                case null:
                                  ${"nota_ev" . $j} = 0;
                                  break;
                                default:
                                  ${"nota_ev" . $j} = $nota;
                                  break;
                              }
                            }
                          } else {
                            $nota_ev1 = 0;
                            $nota_ev2 = 0;
                            $nota_ev3 = 0;
                            $nota_ev4 = 0;
                            $nota_ev5 = 0;
                          }



                          $def70 = (($nota_ev1 + $nota_ev2 + $nota_ev3) / 3) * 0.7;
                          $def20 = $nota_ev4 * 0.2;
                          $def10 = $nota_ev5 * 0.1;

                          $def70 = number_format($def70, 1, '.', '');
                          $def20 = number_format($def20, 1, '.', '');
                          $def10 = number_format($def10, 1, '.', '');

                          $def2 = number_format($def70 + $def20 + $def10, 1, '.', '');
                        ?>

                          <span class="badge badge-pill badge-primary" id="e1-a<?php echo $ide_alum . '-l' . $in ?>"><?php echo $nota_ev1 ?></span>
                          <span class="badge badge-pill badge-primary" id="e2-a<?php echo $ide_alum . '-l' . $in ?>"><?php echo $nota_ev2 ?></span>
                          <span class="badge badge-pill badge-primary" id="e3-a<?php echo $ide_alum . '-l' . $in ?>"><?php echo $nota_ev3 ?></span>
                          <span class="badge badge-pill badge-warning" style="background-color:blueviolet;color:white" id="e4-a<?php echo $ide_alum . '-l' . $in ?>"><?php echo $nota_ev4 ?></span>
                          <span class="badge badge-pill badge-dark" style="background-color:#e83e8c;color:white" id="e5-a<?php echo $ide_alum . '-l' . $in ?>"><?php echo $nota_ev5 ?></span>

                          <a style="color:#212529; cursor:pointer;">
                            <i class="fas fa-edit zoom" onClick="modalNota(
                                    '<?php echo $in ?>',
                                    '<?php echo $ide_alum ?>',
                                    '<?php echo $nom_alum ?>'
                                    )">
                            </i>
                          </a>

                          <span>Def: <span id="dl-a<?php echo $ide_alum . '-l' . $in ?>"><?php echo $def2 ?></span></span>
                          <br>

                        <?php
                          $in += 1;
                          $acumulada += $def2;
                        }

                        $final = number_format((float)$acumulada / $log, 1, '.', '');
                        isset(RENDIMIENTOS[$sec]) ? [$rendimiento, $bandera, $cualitativo] = RENDIMIENTOS[$sec][$final] : 0;

                        ?>

                        <hr>
                        <span>Rendimiento: <strong id="final-a<?php echo $ide_alum ?>"><?php echo $final ?></strong> <span class="badge badge-pill badge-<?php echo $bandera ?>" id="bandera-a<?php echo $ide_alum ?>"><?php echo $rendimiento ?> </span></span>
                      </td>

                    </tr>



                <?php
                  }
                }

                ?>
              </tbody>
              <tfoot>
                <tr>
                <th>N°</th>
                  <th>APELLIDOS Y NOMBRES</th>
                  <th>DESEMPEÑO</th>

                  <?php

                  for ($i=0; $i < $log ; $i++) { ?>

                    <th>A1</th>
                    <th>A2</th>
                    <th>A3</th>
                    <th>70%</th>
                    <th>AC</th>
                    <th>20%</th>
                    <th>EP</th>
                    <th>10%</th>
                    <th>P1</th>

                    <?php
                  } ?>
                </tr>
              </tfoot>
            </table>
            */ ?>

            <button onclick="planilla('siSeñor')">Crear Excel</button>

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

<script>

   async function planilla(data) {

    datos = [
      {
    "id": {
      "bioguide": "W000178",
      "govtrack": 411351,
      "icpsr_prez": 99869
    },
    "name": {
      "first": "Fermin",
      "last": "Gutiérrez"
    },
    "bio": {
      "birthday": "20-10-1987",
      "gender": "M"
    },
    "terms": [
      {
        "type": "prez",
        "start": "1789-04-30",
        "end": "1793-03-04",
        "party": "no party",
        "how": "election"
      },
      {
        "type": "prez",
        "start": "1793-03-04",
        "end": "1797-03-04",
        "party": "no party",
        "how": "election"
      }
    ]
  }
    ]

    //const url = "https://sheetjs.com/data/executive.json";
    //const raw_data = await (await fetch(url)).json();
    const raw_data = datos;

    //filter for the Presidents 
    const prez = raw_data.filter(row => row.terms.some(term => term.type === "prez"));

    //sort by first presidential term 
    prez.forEach(row => row.start = row.terms.find(term => term.type === "prez").start);
    prez.sort((l,r) => l.start.localeCompare(r.start));

    //flatten objects
    const rows = prez.map(row => ({
      name: row.name.first + " " + row.name.last,
      birthday: row.bio.birthday
    }));

    //generate worksheet and workbook 
    const worksheet = XLSX.utils.json_to_sheet(rows);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Dates");

    //fix headers
    XLSX.utils.sheet_add_aoa(worksheet, [["Name", "Birthday"]], { origin: "A1" });

    //calculate column width 
    const max_width = rows.reduce((w, r) => Math.max(w, r.name.length), 10);
    worksheet["!cols"] = [ { wch: max_width } ];

    //create an XLSX file and try to save to Presidents.xlsx 
    XLSX.writeFile(workbook, "Presidents.xlsx", { compression: true });

  }

</script>