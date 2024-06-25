<?php $nivel = 2; ?>
<footer class="main-footer text-sm">
  <strong>Copyright &copy; 2024 Centro Pedagógico La Inmaculada ·</strong> Desarrollado por: <a href="https://www.facebook.com/gfermin1987"><strong>Fermín Gutiérrez</strong></a>
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 5.0.0
  </div>
</footer>

<?php /*
<div class="modal fade" id="modal-login-lista">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Datos de acceso</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form role="form" name="logins_actualizar" id="logins_actualizar" method="post" action="usuario-modelo.php" class="needs-validation" novalidate autocomplete="on">

          <div class="row">
            
            <div class="col-sm-6">
              <div class="form-group">
                <label>Nombre</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                  </div>
                  <input type="text" class="form-control letter bloquear" name="user_nombre_l" id="user_nombre_l" readonly required>
                </div>
              </div>
            </div> <!-- col -->

            <div class="col-sm-6">
              <div class="form-group">
                <label>Nickname</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                  </div>
                  <input type="text" class="form-control nickname minusculas bloquear" name="user_nick_l" id="user_nick_l" required>
                </div>
              </div>
            </div> <!-- col -->

            <div class="col-sm-6">
              <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                  </div>
                  <input type="password" class="form-control password bloquear" name="user_password_l" id="password" required>
                  <div id="resultado-password-contenedor2" style ="display:none">
                  <span id="resultado-password2">Este campo es obligatorio.</span> 
                  </div>
                </div>
              </div>
            </div> <!-- col -->

            <div class="col-sm-6">
              <div class="form-group">
                <label>Confirmar Password</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-keyboard"></i></span>
                  </div>
                  <input type="password" class="form-control password bloquear" name="user_password2" id="repetir-password" required>
                  <div id="resultado-password-contenedor" style ="display:none">
                  <span id="resultado-password">Este campo es obligatorio.</span> 
                  </div>
                </div>
              </div>
            </div> <!-- col -->

          </div>
          <!-- /.row -->


          </div>
          <div class="modal-footer justify-content-between">
            <input type="hidden" name="id_login_l" id="id_login_l" value="">
            <input type="hidden" name="user" value="login_act">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-success" id="reg-user">Actualizar</button>
          </div>

      </form>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
*/ ?>

<div class="swal2-container swal2-center swal2-backdrop-show cortina" style="overflow-y: auto; display:none;" id="cortina-de-espera">
<div class="preloader"></div>
</div>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script src=<?php echo DIST."js/vendor/modernizr-3.11.2.min.js"?>></script>
<script src=<?php echo DIST."js/plugins.js"?>></script>
<script src=<?php echo PLUGIN."jquery/jquery.min.js"?>></script>
<script src=<?php echo PLUGIN."jquery-ui/jquery-ui.min.js"?>></script>
<script>$.widget.bridge('uibutton', $.ui.button)</script>
<script src=<?php echo PLUGIN."bootstrap/js/bootstrap.bundle.min.js"?>></script>
<script src=<?php echo PLUGIN."moment/moment.min.js"?>></script>
<script src=<?php echo PLUGIN."inputmask/min/jquery.inputmask.bundle.min.js"?>></script>
<script src=<?php echo PLUGIN."daterangepicker/daterangepicker.js"?>></script>
<script src=<?php echo PLUGIN."summernote/summernote-bs4.min.js"?>></script>
<script src=<?php echo PLUGIN."overlayScrollbars/js/jquery.overlayScrollbars.min.js"?>></script>
<script src=<?php echo DIST."js/adminlte.js"?>></script>
<script src=<?php echo DIST."js/demo.js"?>></script>
<script src=<?php echo PLUGIN."bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"?>></script>
<script src=<?php echo PLUGIN."select2/js/select2.full.min.js"?>></script>
<script src=<?php echo PLUGIN."bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"?>></script>
<script src=<?php echo PLUGIN."bootstrap-switch/js/bootstrap-switch.min.js"?>></script>
<script src=<?php echo PLUGIN."sweetalert2/sweetalert2.all.min.js"?>></script>

<script src=<?php echo PLUGIN."datatables/jquery.dataTables.min.js"?>></script>
<script src=<?php echo PLUGIN."datatables/dataTables.bootstrap4.min.js"?>></script>
<script src=<?php echo PLUGIN."datatables/dataTables.responsive.min.js"?>></script>

<script src=<?php echo PLUGIN."datatables/responsive.bootstrap4.min.js"?>></script>
<script src=<?php echo PLUGIN."datatables/dataTables.buttons.min.js"?>></script>
<script src=<?php echo PLUGIN."datatables/buttons.bootstrap4.min.js"?>></script>
<script src=<?php echo PLUGIN."jszip/jszip.min.js"?>></script>
<script src=<?php echo PLUGIN."pdfmake/pdfmake.min.js"?>></script>
<script src=<?php echo PLUGIN."pdfmake/vfs_fonts.js"?>></script>
<script src=<?php echo PLUGIN."datatables/buttons.html5.min.js"?>></script>
<script src=<?php echo PLUGIN."datatables/buttons.print.min.js"?>></script>
<script src=<?php echo PLUGIN."datatables/buttons.colVis.min.js"?>></script>
<script src=<?php echo PLUGIN."bs-custom-file-input/bs-custom-file-input.min.js"?>></script>
<script src=<?php echo PLUGIN."sheetjs/xlsx.full.min.js"?>></script>

<!-- Custom's -->
<script src=<?php echo DIST."js/custom/apps-control.js"?>></script>
<script src=<?php echo DIST."js/custom/planillas.js"?>></script>
<script src=<?php echo DIST."js/custom/boletines.js"?>></script>
<script src=<?php echo DIST."js/custom/boletines5.js"?>></script>

<?php 
    $current_file = basename($_SERVER['PHP_SELF']);
    if (
        $current_file === 'matricula-nueva.php' ||
        $current_file === 'matricula-lotes.php' ||
        $current_file === 'usuario-nuevo.php' ||
        $current_file === 'notas-fortalezados.php' ||
        $current_file === 'monitor-fortalezados.php' ||
        $current_file === 'admin-aprendizajes.php'  ||
        $current_file === 'admin-mayacurricular.php'
      ) {
        echo '<script src='.DIST."js/custom/validador.js".'></script>';
    }

    if ($current_file === 'matricula-lista.php') {
      echo '<script src='.DIST."js/custom/mat-pdf.js".'></script>';
      echo '<script src='.DIST."js/custom/mat-pdf5.js".'></script>';
      echo '<script src='.DIST."js/custom/constanciaMatricula.js".'></script>';
    }

    if (
      $current_file === 'preicfes-param.php' ||
      $current_file === 'preicfes-prueba.php'
      ) {
      echo '<script src='.DIST."js/custom/preicfes.js".'></script>';
    }
    
?>



</body>
</html>

