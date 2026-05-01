<ul
  class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
  id="accordionSidebar">
  <!-- Sidebar - Brand -->
  <a
    class="sidebar-brand d-flex align-items-center justify-content-center"
    href="/">
    <div class="sidebar-brand-icon">
      <img src="vistas/imagenes/cs.png" alt="logo" width="160" height="60">
    </div>
    <div class="sidebar-brand-text mx-3"></div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0" />

  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="home">
      <i class="fas fa-home"></i>
      <span>Inicio</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider" />

    <!-- Heading -->
    <div class="sidebar-heading">Administrador</div>

    <!-- Nav Item - Asistencias -->
    <li class="nav-item">
      <a class="nav-link" href="asistencias">
        <i class="fas fa-table"></i>
        <span>Asistencias</span></a>
    </li>

    <li class="nav-item">
  <a class="nav-link" href="start2">
    <i class="fas fa-table"></i>
    <span>Registrar asistencia</span>
  </a>
</li>


    <!-- Nav Item - Usuarios -->
    <li class="nav-item">
      <a class="nav-link" href="usuarios">
        <i class="fas fa-users"></i>
        <span>Usuarios</span></a>
    </li>

    <!-- Nav Item - Empleados -->
    <li class="nav-item">
      <a class="nav-link" href="empleados">
        <i class="fas fa-users"></i>
        <span>Empleados</span></a>
    </li>

    <!-- Nav Item - Cargos -->
    <li class="nav-item">
      <a class="nav-link" href="cargos">
        <i class="fas fa-id-badge"></i>
        <span>Cargos</span></a>
    </li>

  <!-- Nav Item - Respaldo -->
<?php if ($_SESSION['rol'] != 2): ?>
<li class="nav-item">
  <a class="nav-link" href="respaldo">
    <i class="fas fa-database"></i>
    <span>Respaldo</span></a>
</li>
<?php endif; ?>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block" />

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>