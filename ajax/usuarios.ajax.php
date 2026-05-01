<?php
require_once "../controlador/usuario.controlador.php";
require_once "../modelo/usuario.modelo.php";

class AjaxUsuarios
{

    public $idUsuario;

    public function ajaxEditarUsuarios()
    {

        $item = "id";
        $valor = $this->idUsuario;

        $respuesta = ctrUsuarios::ctrMostrarUsuarios1($item, $valor);

        echo json_encode($respuesta);
    }

    public $idEliminar;
    public $rutaFoto;

    public function ajasxEliminarUsuarios()
    {
        $respuesta = ctrUsuarios::ctrEliminarUsuarios($this->idEliminar, $this->rutaFoto);
        echo json_encode($respuesta);

    }
}

//Editar usuario

if (isset($_POST["idUsuario"])) {

    $editar = new AjaxUsuarios();
    $editar->idUsuario = $_POST["idUsuario"];
    $editar->ajaxEditarUsuarios();
}

//Editar eliminar

if (isset($_POST["idUsuarioE"])) {

    $eliminar = new AjaxUsuarios();
    $eliminar->idEliminar = $_POST["idUsuarioE"];
    $eliminar->rutaFoto = $_POST["rutaFoto"];
    $eliminar->ajasxEliminarUsuarios();
}
