<?php

session_start();
$usuarios = ctrUsuarios::ctrMostrarUsuarios();
$roles = ctrRoles::ctrMostrarRoles2();
$empleados = ctrEmpleados::ctrMostrarEmpleados();
$cargos = ctrCargos::ctrMostrarCargos2();
$asistencias = ctrAsistencias::ctrMostrarAsistencias();

if (isset($_SESSION['idBackend'])) {
  $admin = ctrUsuarios::ctrMostrarUsuarios1("id", $_SESSION['idBackend']);
  $menu = $_SESSION['rol'];
}



?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Control de Asistencias</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!--sweet alert-->
  <script src="vistas/js/sweetalert2.min.js"></script>

  <!-- Fuentes personalizadas -->
  <link
    href="vistas/recursos/vendor/fontawesome-free/css/all.min.css"
    rel="stylesheet"
    type="text/css" />
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet" />

  <!-- Custom styles for this template-->
  <link href="vistas/recursos/dist/css/sb-admin-2.min.css" rel="stylesheet" />
  <style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    input[type="number"] {
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      /* Para navegadores más modernos */
    }

    .fondo-imagen {
      background-image: url('vistas/imagenes/fondo.jpeg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }
  </style>
</head>

<!-- Paginas Publicas -->
<?php
if (!isset($_SESSION['validarSesion'])):
  if (!isset($_GET['pagina'])) {
    include "paginas/start.php";
  }
  if (isset($_GET['pagina'])) {
    if (
      $_GET['pagina'] == "login" ||
      $_GET['pagina'] == "reset-password"
    ) {
      include "paginas/" . $_GET['pagina'] . ".php";
    } else {
      include "paginas/401.php";
    }
  }

  

?>

<?php else: ?>

  <body id="page-top">

    <!-- Site wrapper -->
    <div id="wrapper">

      <!-- Sidebar -->
      <?php include "modulos/menu.php" ?>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
          <!-- Topbar -->
          <?php include "modulos/header.php" ?>
          <!-- End of Topbar -->

          <!-- Begin Page Content -->
          <div class="container-fluid">
            <!-- Page Heading -->
<?php
if (isset($_GET['pagina'])) {
  $permitidas = [
    "home", "asistencias", "usuarios", "empleados",
    "cargos", "respaldo", "perfil", "roles", "salir", "start2"
  ];

  if (in_array($_GET['pagina'], $permitidas)) {
    include "paginas/" . $_GET['pagina'] . ".php";
  } else {
    include "paginas/404.php"; // o puedes redirigir a home
  }
} else {
  include "paginas/home.php";
}

            ?>
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php include "modulos/footer.php" ?>
        <!-- End of Footer -->

      </div>
      <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div
      class="modal fade"
      id="logoutModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">¿Seguro quieres salir?</h5>
            <button
              class="close"
              type="button"
              data-dismiss="modal"
              aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            Seleccione “Salir” a continuación si está listo para finalizar su sesión actual.
          </div>
          <div class="modal-footer">
            <button
              class="btn btn-secondary"
              type="button"
              data-dismiss="modal">
              Cancelar
            </button>
            <a class="btn btn-primary" href="salir">Salir</a>
          </div>
        </div>
      </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="vistas/recursos/vendor/jquery/jquery.min.js"></script>
    <script src="vistas/recursos/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vistas/recursos/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="vistas/recursos/dist/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vistas/recursos/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vistas/recursos/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="vistas/recursos/dist/js/demo/datatables-demo.js"></script>

    <script src="vistas/js/usuarios.js"></script>
    <script src="vistas/js/roles.js"></script>
    <script src="vistas/js/empleados.js"></script>
    <script src="vistas/js/cargos.js"></script>
    <script src="vistas/js/asistencias.js"></script>


  </body>
<?php endif ?>

</html>