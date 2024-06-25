<?php
  session_start();
  $cerrar_sesion = $_GET['cerrar_sesion'];
  if($cerrar_sesion){
    session_destroy();
  }
  $nivel = 2;
  require_once '../funciones/configuracion.php';
  require_once HEADER;  
  /*'microphone', 'camera', 'fullscreen', 'recording','videoquality', 'chat', 'hangup', 'raisehand'*/
?>
<body class="hold-transition login-page" style="background: #FFFFFF">
<!--::::::::::::::::::::::::::::::::::::::-->
        <div class="login-box">
          <div class="login-logo">
            <!--a href="#"><strong>APRENDUP</strong><b></b></a -->
            <a>
            <img src=<?php echo DIST."/img/cpi_logo.png"?> alt="APRENDUP Logo" style="width: 150px; height: auto;">
            <h6 style="font-size: 1.2rem;color: #45BDFF;font-weight: bold;">SISTEMA CPI</h6>
            </a>
          </div>
          <!-- /.login-logo -->
          <div class="card" style="box-shadow: 0 0 3px rgb(0 0 0 / 50%), 0 3px 3px rgb(0 0 0 / 50%)!important;">
            <div class="card-body login-card-body" style="background:#45BDFF">
              <form name="user_login" id="user_login" method="post" action="../modelos/login-modelo.php">
                <div class="input-group mb-3">
                  <input type="text" class="form-control minusculas" name="nickname" placeholder="Usuario">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="password" class="form-control" name="password" placeholder="Contraseña">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <input type="hidden" name="login-user" value="1">
                    <button type="submit" class="btn btn-success btn-block" style="color: #ffffff; cursor: pointer; border-color:#685AF1; background:#001F3F">Igresar</button>
                  </div>
                  <!-- /.col -->
                </div>
              </form>
            </div>
            <!-- /.login-card-body -->
          </div>
        </div>
        <!-- /.login-box -->
<!--::::::::::::::::::::::::::::::::::::::-->
<?php
  require_once FOOTER;
?>
<script src="../dist/js/custom/login-control.js"></script>
