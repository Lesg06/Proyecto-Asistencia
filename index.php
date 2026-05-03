<?php

include "controlador/plantillaControlador.php";
include "controlador/usuario.controlador.php";
include "controlador/empleados.controlador.php";
include "controlador/roles.controlador.php";
include "controlador/cargos.controlador.php";
include "controlador/asistencia.controlador.php";
include "controlador/estadistica.controlador.php";



include "modelo/usuario.modelo.php";
include "modelo/empleados.modelo.php";
include "modelo/roles.modelo.php";
include "modelo/cargos.modelo.php";
include "modelo/asistencia.modelo.php";
include "modelo/estadistica.modelo.php";


//pagina inicial
include "modelo/conexion.php";
include "controlador/controlador-registrar-asistencia.php";


$plantilla = new ControladorPlantilla();
$plantilla->ctrPlantilla();
