<?php
require_once "../controlador/asistencia.controlador.php";
require_once "../modelo/asistencia.modelo.php";

class AjaxAsistencias
{
    public $idAsistenciaE;

    public function ajaxEliminarAsistencias()
    {
        $id = $this->idAsistenciaE;

        $respuesta = ctrAsistencias::ctrEliminarAsistencias($id);

        echo json_encode($respuesta);
    }
}

//Eliminar Cargo

if (isset($_POST["idAsistenciaE"])) {

    $eliminar = new AjaxAsistencias();
    $eliminar->idAsistenciaE = $_POST["idAsistenciaE"];
    $eliminar->ajaxEliminarAsistencias();
}
