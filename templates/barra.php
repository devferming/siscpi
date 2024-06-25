<body class="sidebar-mini control-sidebar-slide-closed layout-fixed layout-navbar-fixed sidebar-closed text-sm" style="height: auto;" cz-shortcut-listen="true">

  <div class="wrapper">



    <!-- Navbar -->

    <nav class="main-header navbar navbar-expand navbar-light bg-navy">

      <!-- Left navbar links -->

      <ul class="navbar-nav">

        <li class="nav-item">

          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color:white;"></i></a>

        </li>

        <li class="nav-item d-none d-sm-inline-block">

          <a href="index.php" class="nav-link" style="color:white;">Inicio</a>

        </li>

        <li class="nav-item d-none d-sm-inline-block">

          <a href="usuario-actualizar2.php?id=<?php echo $_SESSION['logid']; ?>" class="nav-link" style="color:white;">Mis datos</a>

        </li>

        <li class="nav-item d-none d-sm-inline-block">

          <a href="modulos/login.php?cerrar_sesion=true" class="nav-link" style="color:white;">Cerrar Sesión</a>

        </li>

      </ul>



      <!-- Right navbar links -->

      <ul class="navbar-nav ml-auto">

        <li class="nav-item">

          <a class="nav-link" href="login.php?cerrar_sesion=true" role="button" style="color:white;">

            <i class="fas fa-sign-out-alt"></i>

          </a>

        </li>

      </ul>

    </nav>

    <!-- /.navbar -->